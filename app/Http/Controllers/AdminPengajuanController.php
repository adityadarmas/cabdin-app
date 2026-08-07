<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use App\Models\JenisPengajuan;
use Illuminate\Http\Request;

class AdminPengajuanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengajuan::with(['operator', 'jenisPengajuan'])->latest();
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('jenis_pengajuan_id')) $query->where('jenis_pengajuan_id', $request->integer('jenis_pengajuan_id'));
        $pengajuans = $query->paginate(15)->withQueryString();
        $jenisPengajuans = JenisPengajuan::orderBy('urutan')->get();
        return view('dashboard.pengajuan.index', compact('pengajuans', 'jenisPengajuans'));
    }

    public function update(Request $request, Pengajuan $pengajuan)
    {
        $data = $request->validate([
            'status' => 'required|in:menunggu,diproses,disetujui,ditolak',
            'keterangan_admin' => 'nullable|string|max:2000',
        ]);
        $pengajuan->update($data);
        return back()->with('success', 'Status pengajuan berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        $query = Pengajuan::with(['operator', 'jenisPengajuan'])->latest();
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('jenis_pengajuan_id')) $query->where('jenis_pengajuan_id', $request->integer('jenis_pengajuan_id'));

        $filename = 'pengajuan-operator-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($query) {
            $output = fopen('php://output', 'w');
            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['No', 'Jenis Pengajuan', 'Operator', 'Sekolah', 'Keterangan', 'Status', 'Keterangan Admin', 'Tanggal Pengajuan', 'Lampiran']);
            $number = 1;

            foreach ($query->cursor() as $item) {
                fputcsv($output, [
                    $number++,
                    $item->jenisPengajuan?->nama ?? $item->judul,
                    $item->operator?->name,
                    $item->operator?->nama_sekolah,
                    $item->isi,
                    ucfirst($item->status),
                    $item->keterangan_admin,
                    $item->submitted_at?->format('Y-m-d H:i'),
                    $item->lampiran ? asset('storage/'.$item->lampiran) : null,
                ]);
            }

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}

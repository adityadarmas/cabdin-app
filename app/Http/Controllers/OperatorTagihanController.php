<?php

namespace App\Http\Controllers;

use App\Models\JenisPengajuan;
use App\Models\TagihanKonfirmasi;

class OperatorTagihanController extends Controller
{
    public function index()
    {
        $tagihans = $this->tagihansUntukOperator();

        return view('operator.tagihan.index', compact('tagihans'));
    }

    public function confirm(JenisPengajuan $jenisPengajuan)
    {
        abort_unless($jenisPengajuan->is_active && $jenisPengajuan->is_tagihan_dashboard, 404);

        TagihanKonfirmasi::updateOrCreate(
            ['jenis_pengajuan_id' => $jenisPengajuan->id, 'user_id' => auth()->id()],
            ['dibaca_at' => now()]
        );

        return back()->with('success', 'Tagihan telah ditandai sudah dibaca.');
    }

    private function tagihansUntukOperator()
    {
        return JenisPengajuan::where('is_active', true)
            ->where('is_tagihan_dashboard', true)
            ->where('deadline_at', '>=', now())
            ->with(['tagihanKonfirmasis' => fn ($query) => $query->where('user_id', auth()->id())])
            ->withCount(['pengajuans as pengumpulan_operator_count' => fn ($query) => $query->where('user_id', auth()->id())])
            ->orderBy('deadline_at')
            ->get()
            ->each(function (JenisPengajuan $tagihan) {
                $tagihan->sudah_dikumpulkan = $tagihan->pengumpulan_operator_count > 0;
                $tagihan->sudah_dibaca = $tagihan->tagihanKonfirmasis->isNotEmpty();
            });
    }
}

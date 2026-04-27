<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\Produk;
use App\Models\Berita;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Tampilkan status surat untuk tamu (tanpa login)
     */
    public function show($token)
    {
        $surat = SuratMasuk::where('tracking_token', $token)->first();

        if (!$surat) {
            abort(404, 'Link tracking tidak valid');
        }

        if (!$surat->isTokenValid()) {
            return view('tracking.expired');
        }

        // Load relasi yang diperlukan
        $surat->load(['tamu', 'penerima']);

        // Ambil produk dan berita untuk carousel
        $produk = Produk::where('is_active', '1')
            ->latest()
            ->take(6)
            ->get();

        $berita = Berita::where('is_active', '1')
            ->latest()
            ->take(6)
            ->get();

        return view('tracking.show', compact('surat', 'produk', 'berita'));
    }

    /**
     * Refresh token
     */
    public function refresh($token)
    {
        $surat = SuratMasuk::where('tracking_token', $token)->first();

        if (!$surat) {
            abort(404);
        }

        $newToken = $surat->generateTrackingToken();

        return redirect()->route('tracking.show', $newToken)
            ->with('success', 'Link tracking berhasil diperbarui');
    }
}
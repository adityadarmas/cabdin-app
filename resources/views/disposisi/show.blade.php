@extends('layouts.app')

@section('title', 'Detail & Disposisi Surat')

@section('content')
<h3>Detail Surat Masuk</h3>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr>
        <th width="30%">Nomor Surat</th>
        <td>{{ $suratMasuk->nomor_surat }}</td>
    </tr>
    <tr>
        <th>Perihal</th>
        <td>{{ $suratMasuk->perihal }}</td>
    </tr>
    <tr>
        <th>Asal Surat</th>
        <td>{{ $suratMasuk->asal }}</td>
    </tr>
    <tr>
        <th>Tanggal Diterima</th>
        <td>{{ $suratMasuk->tgl_diterima }}</td>
    </tr>
    <tr>
        <th>Sifat</th>
        <td>{{ $suratMasuk->sifat ?? '-' }}</td>
    </tr>
    <tr>
        <th>Jenis</th>
        <td>{{ $suratMasuk->jenis ?? '-' }}</td>
    </tr>
    <tr>
        <th>File Surat</th>
        <td>
            @if($suratMasuk->filepath)
                <a href="{{ asset('storage/'.$suratMasuk->filepath) }}" target="_blank">
                    Lihat File
                </a>
            @else
                -
            @endif
        </td>
    </tr>
</table>

<hr>

<h4>Disposisi Pimpinan</h4>

@can('update', $suratMasuk)
<form method="POST" action="{{ route('surat.update', $suratMasuk->id) }}">
    @csrf
    @method('PUT')

    <div style="margin-bottom:10px;">
        <label>Tanggal Kegiatan</label><br>
        <input type="date"
               name="tgl_kegiatan"
               value="{{ old('tgl_kegiatan', $suratMasuk->tgl_kegiatan) }}">
    </div>

    <div style="margin-bottom:10px;">
        <label>Disposisi ke Staff</label><br>
        <select name="user_id">
            <option value="">-- Pilih Staff --</option>
            @foreach($staff as $user)
                <option value="{{ $user->id }}"
                    {{ $suratMasuk->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom:10px;">
        <label>Catatan Disposisi</label><br>
        <textarea name="disposisi" rows="4" cols="50">{{ old('disposisi', $suratMasuk->disposisi) }}</textarea>
    </div>

    <button type="submit">
        Simpan Disposisi
    </button>
</form>
@else
<p><i>Anda tidak memiliki hak untuk melakukan disposisi.</i></p>
@endcan

@endsection

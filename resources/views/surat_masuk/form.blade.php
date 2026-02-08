<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    <div>
        <label>Nomor Surat</label>
        <input type="text" name="nomor_surat" value="{{ old('nomor_surat', $suratMasuk->nomor_surat ?? '') }}">
    </div>

    <div>
        <label>Perihal</label>
        <input type="text" name="perihal" value="{{ old('perihal', $suratMasuk->perihal ?? '') }}">
    </div>

    <div>
        <label>Asal</label>
        <input type="text" name="asal" value="{{ old('asal', $suratMasuk->asal ?? '') }}">
    </div>

    

    {{-- SIFAT --}}
    <div>
        <label>Sifat</label>
        <select name="sifat">
            <option value="">-- Pilih Sifat --</option>
            <option value="segera"
                @selected(old('sifat', $suratMasuk->sifat ?? '') == 'segera')>
                Segera
            </option>
            <option value="penting"
                @selected(old('sifat', $suratMasuk->sifat ?? '') == 'penting')>
                Penting
            </option>
            <option value="biasa"
                @selected(old('sifat', $suratMasuk->sifat ?? '') == 'biasa')>
                Biasa
            </option>
        </select>
    </div>

     {{-- JENIS --}}
    <div>
        <label>Jenis</label>
        <select name="jenis">
            <option value="">-- Pilih Jenis --</option>
            <option value="mutasi"
                @selected(old('jenis', $suratMasuk->jenis ?? '') == 'mutasi')>
                mutasi
            </option>
            <option value="izin_penelitian"
                @selected(old('jenis', $suratMasuk->jenis ?? '') == 'izin_penelitian')>
                izin_penelitian
            </option>
            <option value="pemberitahuan"
                @selected(old('jenis', $suratMasuk->jenis ?? '') == 'pemberitahuan')>
                pemberitahuan
            </option>
        </select>
    </div>

<div class="form-group">
    <label for="tamu_id">Pilih Tamu</label>
    <select name="tamu_id" id="tamu_id" class="form-control">
        <option value="">-- Pilih Tamu --</option>
        @foreach ($tamu as $t)
            <option value="{{ $t->id }}"
                {{ old('tamu_id') == $t->id ? 'selected' : '' }}>
                {{ $t->nama ?? 'Tamu tanpa nama' }}
            </option>
        @endforeach
    </select>
    @error('tamu_id')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

    
    <div>
        <label>Tanggal Diterima</label>
        <input type="date" name="tgl_diterima" value="{{ old('tgl_diterima', $suratMasuk->tgl_diterima ?? '') }}">
    </div>

    {{-- <div>
        <label>Tamu</label>
        <select name="tamu_id">
            <option value="">-- Pilih --</option>
            @foreach($tamu as $tamu)
                <option value="{{ $tamu->id }}"
                    @selected(old('tamu_id', $suratMasuk->tamu_id ?? '') == $tamu->id)>
                    {{ $tamu->nama }}
                </option>
            @endforeach
        </select>
    </div> --}}

    <div>
    <label>File</label>

    @if (!empty($suratMasuk->filepath))
        <div style="margin-bottom: 8px;">
            <a href="{{ asset('storage/'.$suratMasuk->filepath) }}" target="_blank">
                📄 Lihat File Saat Ini
            </a>
        </div>
    @endif

    <input type="file" name="filepath">
    <small class="text-muted">
        (Kosongkan jika tidak ingin mengganti file)
    </small>
</div>

    <button type="submit">{{ $button }}</button>
</form>




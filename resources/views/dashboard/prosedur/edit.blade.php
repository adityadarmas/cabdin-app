@extends('layouts.app')

@section('content')
    @include('dashboard.prosedur.form', [
        'pageTitle' => 'Edit Prosedur',
        'pageDescription' => 'Perbarui panduan, gambar, dan informasi prosedur.',
        'action' => route('prosedur.update', $prosedur),
        'method' => 'PUT',
        'submitLabel' => 'Simpan Perubahan',
        'prosedur' => $prosedur,
    ])
@endsection

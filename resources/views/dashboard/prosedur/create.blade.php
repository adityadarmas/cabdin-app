@extends('layouts.app')

@section('content')
    @include('dashboard.prosedur.form', [
        'pageTitle' => 'Tambah Prosedur',
        'pageDescription' => 'Buat panduan layanan yang jelas dan mudah diikuti.',
        'action' => route('prosedur.store'),
        'method' => 'POST',
        'submitLabel' => 'Simpan Prosedur',
        'prosedur' => null,
    ])
@endsection

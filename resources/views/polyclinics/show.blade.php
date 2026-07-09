@extends('layouts.app')
@section('title', 'Detail Poli')
@section('content')
<div class="card">
    <div class="card-header">Detail Poli</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th style="width:200px">Kode</th><td>{{ $item->code }}</td></tr>
            <tr><th>Nama</th><td>{{ $item->name }}</td></tr>
            <tr><th>Lokasi</th><td>{{ $item->location }}</td></tr>
            <tr><th>Deskripsi</th><td>{{ $item->description }}</td></tr>
            <tr><th>Status</th><td>{{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td></tr>
        </table>
        <a href="{{ route('polyclinics.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

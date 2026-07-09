@extends('layouts.app')
@section('title', 'Detail Radiologi')
@section('content')
<div class="card">
    <div class="card-header">Detail Radiologi</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th style="width:200px">Kode</th><td>{{ $item->code }}</td></tr>
            <tr><th>Nama</th><td>{{ $item->name }}</td></tr>
            <tr><th>Kategori</th><td>{{ $item->category }}</td></tr>
            <tr><th>Harga</th><td>{{ number_format($item->price) }}</td></tr>
            <tr><th>Deskripsi</th><td>{{ $item->description }}</td></tr>
            <tr><th>Persiapan</th><td>{{ $item->preparation }}</td></tr>
            <tr><th>Status</th><td>{{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td></tr>
        </table>
        <a href="{{ route('radiology-tests.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

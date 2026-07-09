@extends('layouts.app')
@section('title', 'Detail Obat')
@section('content')
<div class="card">
    <div class="card-header">Detail Obat</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th style="width:200px">Kode</th><td>{{ $item->code }}</td></tr>
            <tr><th>Nama</th><td>{{ $item->name }}</td></tr>
            <tr><th>Nama Generik</th><td>{{ $item->generic_name }}</td></tr>
            <tr><th>Kategori</th><td>{{ $item->category->name ?? '-' }}</td></tr>
            <tr><th>Satuan</th><td>{{ $item->unit }}</td></tr>
            <tr><th>Harga</th><td>{{ number_format($item->price) }}</td></tr>
            <tr><th>Stok</th><td>{{ $item->stock }}</td></tr>
            <tr><th>Min. Stok</th><td>{{ $item->min_stock }}</td></tr>
            <tr><th>Tanggal Kedaluwarsa</th><td>{{ $item->expired_date }}</td></tr>
            <tr><th>Produsen</th><td>{{ $item->manufacturer }}</td></tr>
            <tr><th>Deskripsi</th><td>{{ $item->description }}</td></tr>
            <tr><th>Status</th><td>{{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td></tr>
        </table>
        <a href="{{ route('medicines.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Detail Kategori Obat')
@section('content')
<div class="card">
    <div class="card-header">Detail Kategori Obat</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th style="width:200px">Nama</th><td>{{ $item->name }}</td></tr>
            <tr><th>Deskripsi</th><td>{{ $item->description }}</td></tr>
            <tr><th>Status</th><td>{{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td></tr>
        </table>
        <a href="{{ route('medicine-categories.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

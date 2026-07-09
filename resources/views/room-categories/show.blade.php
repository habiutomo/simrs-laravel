@extends('layouts.app')
@section('title', 'Detail Kelas Kamar')
@section('content')
<div class="card">
    <div class="card-header">Detail Kelas Kamar</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th style="width:200px">Nama Kelas</th><td>{{ $item->name }}</td></tr>
            <tr><th>Tarif/Hari</th><td>{{ number_format($item->rate_per_day) }}</td></tr>
            <tr><th>Deskripsi</th><td>{{ $item->description }}</td></tr>
            <tr><th>Status</th><td>{{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td></tr>
        </table>
        <a href="{{ route('room-categories.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

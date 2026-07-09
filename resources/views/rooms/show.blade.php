@extends('layouts.app')
@section('title', 'Detail Kamar')
@section('content')
<div class="card">
    <div class="card-header">Detail Kamar</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th style="width:200px">No. Kamar</th><td>{{ $item->room_number }}</td></tr>
            <tr><th>Nama Kamar</th><td>{{ $item->name }}</td></tr>
            <tr><th>Kelas</th><td>{{ $item->category->name ?? '-' }}</td></tr>
            <tr><th>Status</th><td>{{ $item->status }}</td></tr>
            <tr><th>Catatan</th><td>{{ $item->notes }}</td></tr>
            <tr><th>Status Aktif</th><td>{{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td></tr>
        </table>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

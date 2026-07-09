@extends('layouts.app')
@section('title', 'Detail Supplier')
@section('content')
<div class="card">
    <div class="card-header">Detail Supplier</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th style="width:200px">Nama</th><td>{{ $item->name }}</td></tr>
            <tr><th>No. Telepon</th><td>{{ $item->phone }}</td></tr>
            <tr><th>Email</th><td>{{ $item->email }}</td></tr>
            <tr><th>Alamat</th><td>{{ $item->address }}</td></tr>
            <tr><th>PIC</th><td>{{ $item->pic_name }}</td></tr>
            <tr><th>No. Telepon PIC</th><td>{{ $item->pic_phone }}</td></tr>
            <tr><th>Catatan</th><td>{{ $item->notes }}</td></tr>
            <tr><th>Status</th><td>{{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td></tr>
        </table>
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

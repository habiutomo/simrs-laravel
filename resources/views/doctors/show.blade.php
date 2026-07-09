@extends('layouts.app')
@section('title', 'Detail Dokter')
@section('content')
<div class="card">
    <div class="card-header">Detail Dokter</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th style="width:200px">Kode</th><td>{{ $item->code }}</td></tr>
            <tr><th>Nama</th><td>{{ $item->name }}</td></tr>
            <tr><th>Spesialisasi</th><td>{{ $item->specialization }}</td></tr>
            <tr><th>No. Telepon</th><td>{{ $item->phone }}</td></tr>
            <tr><th>Email</th><td>{{ $item->email }}</td></tr>
            <tr><th>SIP</th><td>{{ $item->sip }}</td></tr>
            <tr><th>Alamat</th><td>{{ $item->address }}</td></tr>
            <tr><th>Biaya Konsultasi</th><td>{{ number_format($item->consultation_fee) }}</td></tr>
            <tr><th>Status</th><td>{{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td></tr>
        </table>
        <a href="{{ route('doctors.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

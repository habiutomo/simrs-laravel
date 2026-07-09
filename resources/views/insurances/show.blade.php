@extends('layouts.app')
@section('title', 'Detail Asuransi')
@section('content')
<div class="card">
    <div class="card-header">Detail Asuransi</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th style="width:200px">Nama</th><td>{{ $item->name }}</td></tr>
            <tr><th>Tipe</th><td>{{ $item->type }}</td></tr>
            <tr><th>Coverage</th><td>{{ $item->coverage_percentage }}%</td></tr>
            <tr><th>Catatan</th><td>{{ $item->notes }}</td></tr>
            <tr><th>Status</th><td>{{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td></tr>
        </table>
        <a href="{{ route('insurances.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

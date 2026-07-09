@extends('layouts.app')
@section('title', 'Detail Jadwal')
@section('content')
<div class="card">
    <div class="card-header">Detail Jadwal</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th style="width:200px">Dokter</th><td>{{ $item->doctor->name ?? '-' }}</td></tr>
            <tr><th>Poli</th><td>{{ $item->polyclinic->name ?? '-' }}</td></tr>
            <tr><th>Hari</th><td>{{ $item->day_of_week }}</td></tr>
            <tr><th>Jam Mulai</th><td>{{ $item->start_time }}</td></tr>
            <tr><th>Jam Selesai</th><td>{{ $item->end_time }}</td></tr>
            <tr><th>Max Pasien</th><td>{{ $item->max_patients }}</td></tr>
            <tr><th>Status</th><td>{{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td></tr>
        </table>
        <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

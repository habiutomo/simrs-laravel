@extends('layouts.app')
@section('title', 'Detail Pasien')
@section('content')
<div class="card">
    <div class="card-header">Detail Pasien</div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr><th style="width:200px">No. RM</th><td>{{ $item->no_rm }}</td></tr>
            <tr><th>NIK</th><td>{{ $item->nik }}</td></tr>
            <tr><th>Nama</th><td>{{ $item->name }}</td></tr>
            <tr><th>Tempat Lahir</th><td>{{ $item->birth_place }}</td></tr>
            <tr><th>Tanggal Lahir</th><td>{{ $item->birth_date }}</td></tr>
            <tr><th>Gender</th><td>{{ $item->gender }}</td></tr>
            <tr><th>Gol. Darah</th><td>{{ $item->blood_type }}</td></tr>
            <tr><th>Agama</th><td>{{ $item->religion }}</td></tr>
            <tr><th>Pekerjaan</th><td>{{ $item->occupation }}</td></tr>
            <tr><th>Status Pernikahan</th><td>{{ $item->marital_status }}</td></tr>
            <tr><th>Nama Ibu</th><td>{{ $item->mother_name }}</td></tr>
            <tr><th>No. Telepon</th><td>{{ $item->phone }}</td></tr>
            <tr><th>Alamat</th><td>{{ $item->address }}</td></tr>
            <tr><th>Alergi</th><td>{{ $item->allergies }}</td></tr>
        </table>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Laporan Harian')
@section('content')
<div class="card">
    <div class="card-header">Laporan Harian</div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto"><input type="date" name="date" class="form-control form-control-sm" value="{{ request('date', date('Y-m-d')) }}"></div>
            <div class="col-auto"><button class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Tampilkan</button></div>
        </form>
        <hr>
        <div class="row g-3 mb-4">
            <div class="col-md-3"><div class="border rounded p-3 text-center"><strong class="d-block text-primary">{{ $totalRegistrations ?? 0 }}</strong><small class="text-muted">Pendaftaran</small></div></div>
            <div class="col-md-3"><div class="border rounded p-3 text-center"><strong class="d-block text-success">{{ $totalVisits ?? 0 }}</strong><small class="text-muted">Kunjungan RJ</small></div></div>
            <div class="col-md-3"><div class="border rounded p-3 text-center"><strong class="d-block text-warning">{{ $totalInpatient ?? 0 }}</strong><small class="text-muted">Rawat Inap</small></div></div>
            <div class="col-md-3"><div class="border rounded p-3 text-center"><strong class="d-block text-danger">{{ $totalIgd ?? 0 }}</strong><small class="text-muted">Kunjungan IGD</small></div></div>
        </div>
        <p class="text-muted text-center py-3">Pilih tanggal untuk menampilkan laporan</p>
    </div>
</div>
@endsection

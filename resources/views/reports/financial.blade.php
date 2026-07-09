@extends('layouts.app')
@section('title', 'Laporan Keuangan')
@section('content')
<div class="card">
    <div class="card-header">Laporan Keuangan</div>
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto"><input type="date" name="start_date" class="form-control form-control-sm" value="{{ request('start_date', date('Y-m-01')) }}"></div>
            <div class="col-auto"><input type="date" name="end_date" class="form-control form-control-sm" value="{{ request('end_date', date('Y-m-d')) }}"></div>
            <div class="col-auto"><button class="btn btn-sm btn-primary"><i class="fas fa-search"></i> Tampilkan</button></div>
        </form>
        <hr>
        <div class="row g-3 mb-4">
            <div class="col-md-4"><div class="border rounded p-3 text-center"><strong class="d-block text-success">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</strong><small class="text-muted">Total Pendapatan</small></div></div>
            <div class="col-md-4"><div class="border rounded p-3 text-center"><strong class="d-block text-primary">{{ $totalBills ?? 0 }}</strong><small class="text-muted">Total Tagihan</small></div></div>
            <div class="col-md-4"><div class="border rounded p-3 text-center"><strong class="d-block text-info">{{ $totalPayments ?? 0 }}</strong><small class="text-muted">Total Pembayaran</small></div></div>
        </div>
        <p class="text-muted text-center py-3">Pilih rentang tanggal untuk menampilkan laporan</p>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Detail Pembayaran')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Detail Pembayaran</h5>
    <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Informasi Pembayaran</h6></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><td>No Bayar</td><td>{{ $item->payment_number }}</td></tr>
                    <tr><td>Tagihan</td><td>{{ $item->patientBill->bill_number ?? '-' }}</td></tr>
                    <tr><td>Pasien</td><td>{{ $item->patient->name ?? '-' }}</td></tr>
                    <tr><td>Jumlah</td><td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td></tr>
                    <tr><td>Metode</td><td><span class="badge bg-info">{{ ucfirst($item->method) }}</span></td></tr>
                    <tr><td>Status</td><td><span class="badge bg-{{ $item->status=='confirmed' ? 'success' : 'warning' }}">{{ ucfirst($item->status) }}</span></td></tr>
                    <tr><td>Tanggal Bayar</td><td>{{ $item->payment_date ? $item->payment_date->format('d/m/Y H:i') : '-' }}</td></tr>
                    <tr><td>Diterima Oleh</td><td>{{ $item->received_by ?? '-' }}</td></tr>
                    <tr><td>Catatan</td><td>{{ $item->notes ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Informasi Pasien</h6></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><td>No RM</td><td>{{ $item->patient->no_rm ?? '-' }}</td></tr>
                    <tr><td>Nama</td><td>{{ $item->patient->name ?? '-' }}</td></tr>
                    <tr><td>Jenis Kelamin</td><td>{{ $item->patient->gender ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="d-flex gap-2">
    <a href="{{ route('payments.edit', $item->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
    <form method="POST" action="{{ route('payments.destroy', $item->id) }}" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button></form>
</div>
@endsection

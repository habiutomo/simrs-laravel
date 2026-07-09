@extends('layouts.app')
@section('title', 'Detail Tagihan')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Detail Tagihan</h5>
    <a href="{{ route('patient-bills.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Informasi Tagihan</h6></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><td>No Tagihan</td><td>{{ $item->bill_number }}</td></tr>
                    <tr><td>Pasien</td><td>{{ $item->patient->name ?? '-' }}</td></tr>
                    <tr><td>Registrasi</td><td>{{ $item->registration->registration_number ?? '-' }}</td></tr>
                    <tr><td>Asuransi</td><td>{{ $item->insurance->name ?? '-' }}</td></tr>
                    <tr><td>Total</td><td>Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td></tr>
                    <tr><td>Diskon</td><td>Rp {{ number_format($item->discount ?? 0, 0, ',', '.') }}</td></tr>
                    <tr><td>Status</td><td><span class="badge bg-{{ $item->status=='paid' ? 'success' : ($item->status=='cancelled' ? 'secondary' : ($item->status=='partial' ? 'warning' : 'primary')) }}">{{ ucfirst($item->status) }}</span></td></tr>
                    <tr><td>Catatan</td><td>{{ $item->notes ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Pembayaran</h6></div>
            <div class="card-body">
                @if($item->payments->count() > 0)
                <table class="table table-sm">
                    <thead><tr><th>No Bayar</th><th>Jumlah</th><th>Metode</th><th>Status</th></tr></thead>
                    <tbody>
                    @foreach($item->payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_number }}</td>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($payment->method) }}</td>
                        <td><span class="badge bg-{{ $payment->status=='confirmed' ? 'success' : 'warning' }}">{{ ucfirst($payment->status) }}</span></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-muted mb-0">Belum ada pembayaran</p>
                @endif
            </div>
        </div>
    </div>
</div>
@if($item->billItems->count() > 0)
<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Item Tagihan</h6></div>
    <div class="card-body">
        <table class="table table-sm">
            <thead><tr><th>Deskripsi</th><th>Jumlah</th><th>Harga</th><th>Subtotal</th></tr></thead>
            <tbody>
            @foreach($item->billItems as $billItem)
            <tr>
                <td>{{ $billItem->description }}</td>
                <td>{{ $billItem->quantity }}</td>
                <td>Rp {{ number_format($billItem->price, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($billItem->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
<div class="d-flex gap-2">
    <a href="{{ route('patient-bills.edit', $item->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
    <form method="POST" action="{{ route('patient-bills.destroy', $item->id) }}" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button></form>
</div>
@endsection

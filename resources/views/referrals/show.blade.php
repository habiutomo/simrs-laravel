@extends('layouts.app')
@section('title', 'Detail Rujukan')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Detail Rujukan</h5>
    <a href="{{ route('referrals.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Informasi Rujukan</h6></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><td>No Rujukan</td><td>{{ $item->referral_number }}</td></tr>
                    <tr><td>Pasien</td><td>{{ $item->patient->name ?? '-' }}</td></tr>
                    <tr><td>Dokter Pengirim</td><td>{{ $item->fromDoctor->name ?? '-' }}</td></tr>
                    <tr><td>Institusi Tujuan</td><td>{{ $item->to_institution ?? '-' }}</td></tr>
                    <tr><td>Dokter Tujuan</td><td>{{ $item->to_doctor ?? '-' }}</td></tr>
                    <tr><td>Tanggal Rujukan</td><td>{{ $item->referral_date ? $item->referral_date->format('d/m/Y') : '-' }}</td></tr>
                    <tr><td>Status</td><td><span class="badge bg-{{ $item->status=='accepted' ? 'success' : ($item->status=='cancelled' || $item->status=='rejected' ? 'secondary' : 'primary') }}">{{ ucfirst($item->status) }}</span></td></tr>
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
<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Detail Medis</h6></div>
    <div class="card-body">
        <table class="table table-sm">
            <tr><td>Diagnosis</td><td>{{ $item->diagnosis ?? '-' }}</td></tr>
            <tr><td>Alasan Rujukan</td><td>{{ $item->reason ?? '-' }}</td></tr>
            <tr><td>Catatan</td><td>{{ $item->notes ?? '-' }}</td></tr>
        </table>
    </div>
</div>
<div class="d-flex gap-2">
    <a href="{{ route('referrals.edit', $item->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
    <form method="POST" action="{{ route('referrals.destroy', $item->id) }}" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button></form>
</div>
@endsection

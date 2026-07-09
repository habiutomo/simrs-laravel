@extends('layouts.app')
@section('title', 'Detail Kunjungan Rawat Jalan')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Detail Kunjungan Rawat Jalan</h5>
    <a href="{{ route('outpatient-visits.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Informasi Pasien</h6></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><td>No RM</td><td>{{ $item->patient->no_rm ?? '-' }}</td></tr>
                    <tr><td>Nama</td><td>{{ $item->patient->name ?? '-' }}</td></tr>
                    <tr><td>Jenis Kelamin</td><td>{{ $item->patient->gender ?? '-' }}</td></tr>
                    <tr><td>Tanggal Lahir</td><td>{{ $item->patient->birth_date ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Informasi Kunjungan</h6></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><td>No Antrian</td><td>{{ $item->queue_number }}</td></tr>
                    <tr><td>Registrasi</td><td>{{ $item->registration->registration_number ?? '-' }}</td></tr>
                    <tr><td>Dokter</td><td>{{ $item->doctor->name ?? '-' }}</td></tr>
                    <tr><td>Poliklinik</td><td>{{ $item->polyclinic->name ?? '-' }}</td></tr>
                    <tr><td>Status</td><td><span class="badge bg-{{ $item->status=='completed' ? 'success' : ($item->status=='cancelled' ? 'secondary' : 'primary') }}">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span></td></tr>
                    <tr><td>Check In</td><td>{{ $item->check_in_at ? $item->check_in_at->format('d/m/Y H:i') : '-' }}</td></tr>
                    <tr><td>Check Out</td><td>{{ $item->check_out_at ? $item->check_out_at->format('d/m/Y H:i') : '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Pemeriksaan</h6></div>
    <div class="card-body">
        <table class="table table-sm">
            <tr><td>Anamnesis</td><td>{{ $item->anamnesis ?? '-' }}</td></tr>
            <tr><td>Diagnosis</td><td>{{ $item->diagnosis ?? '-' }}</td></tr>
            <tr><td>Terapi</td><td>{{ $item->therapy ?? '-' }}</td></tr>
            <tr><td>Catatan</td><td>{{ $item->notes ?? '-' }}</td></tr>
        </table>
    </div>
</div>
<div class="d-flex gap-2">
    <a href="{{ route('outpatient-visits.edit', $item->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
    <form method="POST" action="{{ route('outpatient-visits.destroy', $item->id) }}" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button></form>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Detail Pendaftaran')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Detail Pendaftaran</h5>
    <a href="{{ route('registrations.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                    <tr><td>Alamat</td><td>{{ $item->patient->address ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Informasi Pendaftaran</h6></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><td>No Registrasi</td><td>{{ $item->registration_number }}</td></tr>
                    <tr><td>Waktu</td><td>{{ $item->registration_time->format('d/m/Y H:i') }}</td></tr>
                    <tr><td>Tipe</td><td><span class="badge bg-{{ $item->type=='igd' ? 'danger' : ($item->type=='rawat_inap' ? 'warning' : 'info') }}">{{ str_replace('_', ' ', ucfirst($item->type)) }}</span></td></tr>
                    <tr><td>Status</td><td><span class="badge bg-{{ $item->status=='completed' ? 'success' : ($item->status=='cancelled' ? 'secondary' : 'primary') }}">{{ ucfirst($item->status) }}</span></td></tr>
                    <tr><td>Poliklinik</td><td>{{ $item->polyclinic->name ?? '-' }}</td></tr>
                    <tr><td>Dokter</td><td>{{ $item->doctor->name ?? '-' }}</td></tr>
                    <tr><td>Asuransi</td><td>{{ $item->insurance->name ?? '-' }}</td></tr>
                    <tr><td>Rujukan</td><td>{{ $item->referral_from ?? '-' }}</td></tr>
                    <tr><td>Keluhan</td><td>{{ $item->complaint ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
@if($item->outpatientVisit)
<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Kunjungan Rawat Jalan</h6></div>
    <div class="card-body">
        <a href="{{ route('outpatient-visits.show', $item->outpatientVisit->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i> Lihat Kunjungan</a>
    </div>
</div>
@endif
@if($item->inpatientAdmission)
<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Rawat Inap</h6></div>
    <div class="card-body">
        <a href="{{ route('inpatient-admissions.show', $item->inpatientAdmission->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i> Lihat Rawat Inap</a>
    </div>
</div>
@endif
@if($item->emergencyVisit)
<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Kunjungan IGD</h6></div>
    <div class="card-body">
        <a href="{{ route('emergency-visits.show', $item->emergencyVisit->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i> Lihat IGD</a>
    </div>
</div>
@endif
@if($item->patientBill)
<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Tagihan</h6></div>
    <div class="card-body">
        <a href="{{ route('patient-bills.show', $item->patientBill->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i> Lihat Tagihan</a>
    </div>
</div>
@endif
<div class="d-flex gap-2">
    <a href="{{ route('registrations.edit', $item->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
    <form method="POST" action="{{ route('registrations.destroy', $item->id) }}" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button></form>
</div>
@endsection

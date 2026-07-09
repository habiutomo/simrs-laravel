@extends('layouts.app')
@section('title', 'Detail Permintaan Radiologi')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Detail Permintaan Radiologi</h5>
    <a href="{{ route('radiology-requests.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Informasi Permintaan</h6></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><td>No Rad</td><td>{{ $item->request_number }}</td></tr>
                    <tr><td>Pasien</td><td>{{ $item->patient->name ?? '-' }}</td></tr>
                    <tr><td>Dokter</td><td>{{ $item->doctor->name ?? '-' }}</td></tr>
                    <tr><td>Pemeriksaan</td><td>{{ $item->radiologyTest->name ?? '-' }}</td></tr>
                    <tr><td>Prioritas</td><td><span class="badge bg-{{ $item->priority=='stat' ? 'danger' : ($item->priority=='urgent' ? 'warning' : 'info') }}">{{ ucfirst($item->priority) }}</span></td></tr>
                    <tr><td>Status</td><td><span class="badge bg-{{ $item->status=='completed' ? 'success' : ($item->status=='cancelled' ? 'secondary' : ($item->status=='in_progress' ? 'info' : 'primary')) }}">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span></td></tr>
                    <tr><td>Tanggal</td><td>{{ $item->requested_at ? $item->requested_at->format('d/m/Y H:i') : $item->created_at->format('d/m/Y H:i') }}</td></tr>
                    <tr><td>Informasi Klinis</td><td>{{ $item->clinical_info ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Hasil Radiologi</h6></div>
            <div class="card-body">
                @if($item->radiologyResult)
                <table class="table table-sm">
                    <tr><td>Hasil</td><td>{{ $item->radiologyResult->result ?? '-' }}</td></tr>
                    <tr><td>Kesan</td><td>{{ $item->radiologyResult->impression ?? '-' }}</td></tr>
                    <tr><td>Kesimpulan</td><td>{{ $item->radiologyResult->conclusion ?? '-' }}</td></tr>
                    <tr><td>Diperiksa Oleh</td><td>{{ $item->radiologyResult->radiologist ?? '-' }}</td></tr>
                    <tr><td>Tanggal Hasil</td><td>{{ $item->radiologyResult->examined_at ? $item->radiologyResult->examined_at->format('d/m/Y H:i') : '-' }}</td></tr>
                </table>
                @else
                <p class="text-muted mb-0">Belum ada hasil radiologi</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="d-flex gap-2">
    <a href="{{ route('radiology-requests.edit', $item->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
    <form method="POST" action="{{ route('radiology-requests.destroy', $item->id) }}" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button></form>
</div>
@endsection

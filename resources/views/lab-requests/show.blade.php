@extends('layouts.app')
@section('title', 'Detail Permintaan Lab')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Detail Permintaan Laboratorium</h5>
    <a href="{{ route('lab-requests.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Informasi Permintaan</h6></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><td>No Lab</td><td>{{ $item->request_number }}</td></tr>
                    <tr><td>Pasien</td><td>{{ $item->patient->name ?? '-' }}</td></tr>
                    <tr><td>Dokter</td><td>{{ $item->doctor->name ?? '-' }}</td></tr>
                    <tr><td>Pemeriksaan</td><td>{{ $item->labTest->name ?? '-' }}</td></tr>
                    <tr><td>Prioritas</td><td><span class="badge bg-{{ $item->priority=='stat' ? 'danger' : ($item->priority=='urgent' ? 'warning' : 'info') }}">{{ ucfirst($item->priority) }}</span></td></tr>
                    <tr><td>Status</td><td><span class="badge bg-{{ $item->status=='completed' ? 'success' : ($item->status=='cancelled' ? 'secondary' : ($item->status=='in_progress' ? 'info' : 'primary')) }}">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span></td></tr>
                    <tr><td>Tanggal</td><td>{{ $item->requested_at ? $item->requested_at->format('d/m/Y H:i') : $item->created_at->format('d/m/Y H:i') }}</td></tr>
                    <tr><td>Catatan</td><td>{{ $item->notes ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Hasil Laboratorium</h6></div>
            <div class="card-body">
                @if($item->labResult)
                <table class="table table-sm">
                    <tr><td>Hasil</td><td>{{ $item->labResult->result ?? '-' }}</td></tr>
                    <tr><td>Nilai Normal</td><td>{{ $item->labResult->normal_range ?? '-' }}</td></tr>
                    <tr><td>Keterangan</td><td>{{ $item->labResult->notes ?? '-' }}</td></tr>
                    <tr><td>Diperiksa Oleh</td><td>{{ $item->labResult->examiner ?? '-' }}</td></tr>
                    <tr><td>Tanggal Hasil</td><td>{{ $item->labResult->examined_at ? $item->labResult->examined_at->format('d/m/Y H:i') : '-' }}</td></tr>
                </table>
                @else
                <p class="text-muted mb-0">Belum ada hasil laboratorium</p>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="d-flex gap-2">
    <a href="{{ route('lab-requests.edit', $item->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
    <form method="POST" action="{{ route('lab-requests.destroy', $item->id) }}" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button></form>
</div>
@endsection

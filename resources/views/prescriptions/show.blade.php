@extends('layouts.app')
@section('title', 'Detail Resep')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Detail Resep</h5>
    <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Informasi Resep</h6></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><td>No Resep</td><td>{{ $item->prescription_number }}</td></tr>
                    <tr><td>Pasien</td><td>{{ $item->patient->name ?? '-' }}</td></tr>
                    <tr><td>Dokter</td><td>{{ $item->doctor->name ?? '-' }}</td></tr>
                    <tr><td>Tanggal</td><td>{{ $item->prescribed_at ? $item->prescribed_at->format('d/m/Y H:i') : '-' }}</td></tr>
                    <tr><td>Status</td><td><span class="badge bg-{{ $item->status=='dispensed' ? 'success' : ($item->status=='cancelled' ? 'secondary' : 'primary') }}">{{ ucfirst($item->status) }}</span></td></tr>
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
<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Item Resep</h6></div>
    <div class="card-body">
        <table class="table table-sm">
            <thead><tr><th>Obat</th><th>Dosis</th><th>Frekuensi</th><th>Instruksi</th><th>Jumlah</th><th>Hari</th></tr></thead>
            <tbody>
            @forelse($item->items as $prescriptionItem)
            <tr>
                <td>{{ $prescriptionItem->medicine->name ?? '-' }}</td>
                <td>{{ $prescriptionItem->dosage ?? '-' }}</td>
                <td>{{ $prescriptionItem->frequency ?? '-' }}</td>
                <td>{{ $prescriptionItem->instruction ?? '-' }}</td>
                <td>{{ $prescriptionItem->quantity }}</td>
                <td>{{ $prescriptionItem->days }}</td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted">Tidak ada item resep</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex gap-2">
    <a href="{{ route('prescriptions.edit', $item->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
    <form method="POST" action="{{ route('prescriptions.destroy', $item->id) }}" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-danger"><i class="fas fa-trash"></i> Hapus</button></form>
</div>
@endsection

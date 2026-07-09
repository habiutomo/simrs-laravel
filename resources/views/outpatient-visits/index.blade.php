@extends('layouts.app')
@section('title', 'Kunjungan Rawat Jalan')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Kunjungan Rawat Jalan</h5>
    <a href="{{ route('outpatient-visits.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
</div>
<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari pasien..." value="{{ request('search') }}"></div>
            <div class="col-auto"><select name="status" class="form-select form-select-sm"><option value="">Semua Status</option><option value="waiting" {{ request('status')=='waiting' ? 'selected' : '' }}>Menunggu</option><option value="called" {{ request('status')=='called' ? 'selected' : '' }}>Dipanggil</option><option value="in_examination" {{ request('status')=='in_examination' ? 'selected' : '' }}>Diperiksa</option><option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Selesai</option><option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Batal</option></select></div>
            <div class="col-auto"><button class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>No Antrian</th><th>Tanggal</th><th>Pasien</th><th>Dokter</th><th>Poli</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->queue_number }}</td>
                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $item->patient->name ?? '-' }}</td>
                    <td>{{ $item->doctor->name ?? '-' }}</td>
                    <td>{{ $item->polyclinic->name ?? '-' }}</td>
                    <td><span class="badge bg-{{ $item->status=='completed' ? 'success' : ($item->status=='cancelled' ? 'secondary' : ($item->status=='in_examination' ? 'info' : ($item->status=='called' ? 'warning' : 'primary'))) }}">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span></td>
                    <td>
                        <a href="{{ route('outpatient-visits.show', $item->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('outpatient-visits.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('outpatient-visits.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data kunjungan</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection

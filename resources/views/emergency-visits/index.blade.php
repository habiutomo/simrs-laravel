@extends('layouts.app')
@section('title', 'Kunjungan IGD')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Kunjungan IGD</h5>
    <a href="{{ route('emergency-visits.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
</div>
<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari pasien..." value="{{ request('search') }}"></div>
            <div class="col-auto"><select name="triage" class="form-select form-select-sm"><option value="">Semua Triage</option><option value="resuscitation" {{ request('triage')=='resuscitation' ? 'selected' : '' }}>Resusitasi</option><option value="emergent" {{ request('triage')=='emergent' ? 'selected' : '' }}>Emergen</option><option value="urgent" {{ request('triage')=='urgent' ? 'selected' : '' }}>Urgent</option><option value="semi_urgent" {{ request('triage')=='semi_urgent' ? 'selected' : '' }}>Semi Urgent</option><option value="non_urgent" {{ request('triage')=='non_urgent' ? 'selected' : '' }}>Non Urgent</option></select></div>
            <div class="col-auto"><select name="status" class="form-select form-select-sm"><option value="">Semua Status</option><option value="waiting" {{ request('status')=='waiting' ? 'selected' : '' }}>Menunggu</option><option value="in_treatment" {{ request('status')=='in_treatment' ? 'selected' : '' }}>Ditangani</option><option value="discharged" {{ request('status')=='discharged' ? 'selected' : '' }}>Pulang</option><option value="referred" {{ request('status')=='referred' ? 'selected' : '' }}>Dirujuk</option><option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Batal</option></select></div>
            <div class="col-auto"><button class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>No IGD</th><th>Pasien</th><th>Triage</th><th>Status</th><th>Waktu Masuk</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->visit_number }}</td>
                    <td>{{ $item->patient->name ?? '-' }}</td>
                    <td><span class="badge bg-{{ $item->triage=='resuscitation' ? 'danger' : ($item->triage=='emergent' ? 'warning' : ($item->triage=='urgent' ? 'info' : 'secondary')) }}">{{ ucfirst(str_replace('_', ' ', $item->triage)) }}</span></td>
                    <td><span class="badge bg-{{ $item->status=='discharged' ? 'success' : ($item->status=='cancelled' ? 'secondary' : ($item->status=='in_treatment' ? 'info' : 'primary')) }}">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span></td>
                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('emergency-visits.show', $item->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('emergency-visits.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('emergency-visits.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data IGD</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection

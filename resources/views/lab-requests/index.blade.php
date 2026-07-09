@extends('layouts.app')
@section('title', 'Permintaan Laboratorium')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Permintaan Laboratorium</h5>
    <a href="{{ route('lab-requests.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
</div>
<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari pasien..." value="{{ request('search') }}"></div>
            <div class="col-auto"><select name="priority" class="form-select form-select-sm"><option value="">Semua Prioritas</option><option value="routine" {{ request('priority')=='routine' ? 'selected' : '' }}>Rutin</option><option value="urgent" {{ request('priority')=='urgent' ? 'selected' : '' }}>Urgent</option><option value="stat" {{ request('priority')=='stat' ? 'selected' : '' }}>STAT</option></select></div>
            <div class="col-auto"><select name="status" class="form-select form-select-sm"><option value="">Semua Status</option><option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option><option value="in_progress" {{ request('status')=='in_progress' ? 'selected' : '' }}>Diproses</option><option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Selesai</option><option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Batal</option></select></div>
            <div class="col-auto"><button class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>No Lab</th><th>Pasien</th><th>Pemeriksaan</th><th>Prioritas</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->request_number }}</td>
                    <td>{{ $item->patient->name ?? '-' }}</td>
                    <td>{{ $item->labTest->name ?? '-' }}</td>
                    <td><span class="badge bg-{{ $item->priority=='stat' ? 'danger' : ($item->priority=='urgent' ? 'warning' : 'info') }}">{{ ucfirst($item->priority) }}</span></td>
                    <td><span class="badge bg-{{ $item->status=='completed' ? 'success' : ($item->status=='cancelled' ? 'secondary' : ($item->status=='in_progress' ? 'info' : 'primary')) }}">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span></td>
                    <td>
                        <a href="{{ route('lab-requests.show', $item->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('lab-requests.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('lab-requests.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data permintaan lab</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection

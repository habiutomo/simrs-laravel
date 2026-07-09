@extends('layouts.app')
@section('title', 'Tagihan Pasien')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Tagihan Pasien</h5>
    <a href="{{ route('patient-bills.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
</div>
<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari pasien..." value="{{ request('search') }}"></div>
            <div class="col-auto"><select name="status" class="form-select form-select-sm"><option value="">Semua Status</option><option value="unpaid" {{ request('status')=='unpaid' ? 'selected' : '' }}>Belum Bayar</option><option value="partial" {{ request('status')=='partial' ? 'selected' : '' }}>Sebagian</option><option value="paid" {{ request('status')=='paid' ? 'selected' : '' }}>Lunas</option><option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Batal</option></select></div>
            <div class="col-auto"><button class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>No Tagihan</th><th>Pasien</th><th>Total</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->bill_number }}</td>
                    <td>{{ $item->patient->name ?? '-' }}</td>
                    <td>Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                    <td><span class="badge bg-{{ $item->status=='paid' ? 'success' : ($item->status=='cancelled' ? 'secondary' : ($item->status=='partial' ? 'warning' : 'primary')) }}">{{ ucfirst($item->status) }}</span></td>
                    <td>
                        <a href="{{ route('patient-bills.show', $item->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('patient-bills.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('patient-bills.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada data tagihan</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection

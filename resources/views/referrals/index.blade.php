@extends('layouts.app')
@section('title', 'Rujukan')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Rujukan Pasien</h5>
    <a href="{{ route('referrals.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
</div>
<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari pasien..." value="{{ request('search') }}"></div>
            <div class="col-auto"><select name="status" class="form-select form-select-sm"><option value="">Semua Status</option><option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option><option value="accepted" {{ request('status')=='accepted' ? 'selected' : '' }}>Diterima</option><option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Ditolak</option><option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Batal</option></select></div>
            <div class="col-auto"><button class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>No Rujukan</th><th>Pasien</th><th>Dokter</th><th>Tujuan</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->referral_number }}</td>
                    <td>{{ $item->patient->name ?? '-' }}</td>
                    <td>{{ $item->fromDoctor->name ?? '-' }}</td>
                    <td>{{ $item->to_institution ?? '-' }}</td>
                    <td><span class="badge bg-{{ $item->status=='accepted' ? 'success' : ($item->status=='cancelled' || $item->status=='rejected' ? 'secondary' : 'primary') }}">{{ ucfirst($item->status) }}</span></td>
                    <td>
                        <a href="{{ route('referrals.show', $item->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('referrals.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('referrals.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data rujukan</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection

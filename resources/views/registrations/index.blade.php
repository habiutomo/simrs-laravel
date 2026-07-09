@extends('layouts.app')
@section('title', 'Pendaftaran')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Pendaftaran Pasien</h5>
    <a href="{{ route('registrations.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Daftar Baru</a>
</div>
<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari no registrasi/pasien..." value="{{ request('search') }}"></div>
            <div class="col-auto"><select name="type" class="form-select form-select-sm"><option value="">Semua Tipe</option><option value="rawat_jalan" {{ request('type')=='rawat_jalan' ? 'selected' : '' }}>Rawat Jalan</option><option value="igd" {{ request('type')=='igd' ? 'selected' : '' }}>IGD</option><option value="rawat_inap" {{ request('type')=='rawat_inap' ? 'selected' : '' }}>Rawat Inap</option></select></div>
            <div class="col-auto"><select name="status" class="form-select form-select-sm"><option value="">Semua Status</option><option value="waiting" {{ request('status')=='waiting' ? 'selected' : '' }}>Menunggu</option><option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Selesai</option><option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Batal</option></select></div>
            <div class="col-auto"><button class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>No Registrasi</th><th>Tanggal</th><th>Pasien</th><th>Tipe</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->registration_number }}</td>
                    <td>{{ $item->registration_time->format('d/m/Y H:i') }}</td>
                    <td>{{ $item->patient->name ?? '-' }}</td>
                    <td><span class="badge bg-{{ $item->type=='igd' ? 'danger' : ($item->type=='rawat_inap' ? 'warning' : 'info') }}">{{ str_replace('_', ' ', ucfirst($item->type)) }}</span></td>
                    <td><span class="badge bg-{{ $item->status=='completed' ? 'success' : ($item->status=='cancelled' ? 'secondary' : 'primary') }}">{{ ucfirst($item->status) }}</span></td>
                    <td>
                        <a href="{{ route('registrations.show', $item->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('registrations.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('registrations.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada data pendaftaran</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Pembayaran')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Pembayaran</h5>
    <a href="{{ route('payments.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
</div>
<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari pasien..." value="{{ request('search') }}"></div>
            <div class="col-auto"><select name="method" class="form-select form-select-sm"><option value="">Semua Metode</option><option value="cash" {{ request('method')=='cash' ? 'selected' : '' }}>Tunai</option><option value="transfer" {{ request('method')=='transfer' ? 'selected' : '' }}>Transfer</option><option value="debit" {{ request('method')=='debit' ? 'selected' : '' }}>Debit</option><option value="credit" {{ request('method')=='credit' ? 'selected' : '' }}>Kredit</option><option value="insurance" {{ request('method')=='insurance' ? 'selected' : '' }}>Asuransi</option><option value="other" {{ request('method')=='other' ? 'selected' : '' }}>Lainnya</option></select></div>
            <div class="col-auto"><select name="status" class="form-select form-select-sm"><option value="">Semua Status</option><option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option><option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>Dikonfirmasi</option></select></div>
            <div class="col-auto"><button class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead><tr><th>No Bayar</th><th>Tagihan</th><th>Pasien</th><th>Jumlah</th><th>Metode</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->payment_number }}</td>
                    <td>{{ $item->patientBill->bill_number ?? '-' }}</td>
                    <td>{{ $item->patient->name ?? '-' }}</td>
                    <td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($item->method) }}</span></td>
                    <td><span class="badge bg-{{ $item->status=='confirmed' ? 'success' : 'warning' }}">{{ ucfirst($item->status) }}</span></td>
                    <td>
                        <a href="{{ route('payments.show', $item->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('payments.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('payments.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Hapus data?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Tidak ada data pembayaran</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection

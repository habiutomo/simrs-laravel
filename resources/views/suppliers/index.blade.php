@extends('layouts.app')
@section('title', 'Supplier')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Supplier</h5>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
</div>
<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-auto"><input type="text" name="search" class="form-control form-control-sm" placeholder="Cari..." value="{{ request('search') }}"></div>
            <div class="col-auto"><button class="btn btn-sm btn-primary"><i class="fas fa-search"></i></button></div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>No Telp</th>
                        <th>PIC</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->phone }}</td>
                        <td>{{ $item->pic_name }}</td>
                        <td>{{ $item->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                        <td>
                            <a href="{{ route('suppliers.show', $item->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('suppliers.edit', $item->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('suppliers.destroy', $item->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada data</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        {{ $items->links() }}
    </div>
</div>
@endsection

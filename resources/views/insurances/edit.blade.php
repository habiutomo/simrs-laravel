@extends('layouts.app')
@section('title', 'Edit Asuransi')
@section('content')
<div class="card">
    <div class="card-header">Edit Asuransi</div>
    <div class="card-body">
        <form method="POST" action="{{ route('insurances.update', $item->id) }}">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $item->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tipe</label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Asuransi" {{ old('type', $item->type)=='Asuransi' ? 'selected' : '' }}>Asuransi</option>
                        <option value="Perusahaan" {{ old('type', $item->type)=='Perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                        <option value="JKN" {{ old('type', $item->type)=='JKN' ? 'selected' : '' }}>JKN</option>
                        <option value="Lainnya" {{ old('type', $item->type)=='Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Coverage (%)</label>
                    <input type="number" name="coverage_percentage" class="form-control @error('coverage_percentage') is-invalid @enderror" value="{{ old('coverage_percentage', $item->coverage_percentage) }}">
                    @error('coverage_percentage') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="2">{{ old('notes', $item->notes) }}</textarea>
                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label">Aktif</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('insurances.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

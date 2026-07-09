@extends('layouts.app')
@section('title', 'Tambah Lab Test')
@section('content')
<div class="card">
    <div class="card-header">Tambah Lab Test</div>
    <div class="card-body">
        <form method="POST" action="{{ route('lab-tests.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode</label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}">
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-select @error('category') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Hematologi" {{ old('category')=='Hematologi' ? 'selected' : '' }}>Hematologi</option>
                        <option value="Kimia Klinik" {{ old('category')=='Kimia Klinik' ? 'selected' : '' }}>Kimia Klinik</option>
                        <option value="Mikrobiologi" {{ old('category')=='Mikrobiologi' ? 'selected' : '' }}>Mikrobiologi</option>
                        <option value="Imunologi" {{ old('category')=='Imunologi' ? 'selected' : '' }}>Imunologi</option>
                        <option value="Urinalisis" {{ old('category')=='Urinalisis' ? 'selected' : '' }}>Urinalisis</option>
                        <option value="Lainnya" {{ old('category')=='Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Sampel</label>
                    <select name="sample_type" class="form-select @error('sample_type') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Darah" {{ old('sample_type')=='Darah' ? 'selected' : '' }}>Darah</option>
                        <option value="Urine" {{ old('sample_type')=='Urine' ? 'selected' : '' }}>Urine</option>
                        <option value="Feses" {{ old('sample_type')=='Feses' ? 'selected' : '' }}>Feses</option>
                        <option value="Swab" {{ old('sample_type')=='Swab' ? 'selected' : '' }}>Swab</option>
                        <option value="Lainnya" {{ old('sample_type')=='Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('sample_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror" value="{{ old('unit') }}">
                    @error('unit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Nilai Normal</label>
                    <input type="text" name="normal_values" class="form-control @error('normal_values') is-invalid @enderror" value="{{ old('normal_values') }}">
                    @error('normal_values') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="2">{{ old('description') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active') ? 'checked' : '' }}>
                        <label class="form-check-label">Aktif</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('lab-tests.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

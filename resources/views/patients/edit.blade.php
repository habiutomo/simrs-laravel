@extends('layouts.app')
@section('title', 'Edit Pasien')
@section('content')
<div class="card">
    <div class="card-header">Edit Pasien</div>
    <div class="card-body">
        <form method="POST" action="{{ route('patients.update', $item->id) }}">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. RM</label>
                    <input type="text" name="no_rm" class="form-control @error('no_rm') is-invalid @enderror" value="{{ old('no_rm', $item->no_rm) }}" readonly>
                    @error('no_rm') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $item->nik) }}">
                    @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $item->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="birth_place" class="form-control @error('birth_place') is-invalid @enderror" value="{{ old('birth_place', $item->birth_place) }}">
                    @error('birth_place') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date', $item->birth_date) }}">
                    @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('gender', $item->gender)=='L' ? 'selected' : '' }}>L</option>
                        <option value="P" {{ old('gender', $item->gender)=='P' ? 'selected' : '' }}>P</option>
                    </select>
                    @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Gol. Darah</label>
                    <select name="blood_type" class="form-select @error('blood_type') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="A" {{ old('blood_type', $item->blood_type)=='A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('blood_type', $item->blood_type)=='B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('blood_type', $item->blood_type)=='AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('blood_type', $item->blood_type)=='O' ? 'selected' : '' }}>O</option>
                    </select>
                    @error('blood_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Agama</label>
                    <input type="text" name="religion" class="form-control @error('religion') is-invalid @enderror" value="{{ old('religion', $item->religion) }}">
                    @error('religion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pekerjaan</label>
                    <input type="text" name="occupation" class="form-control @error('occupation') is-invalid @enderror" value="{{ old('occupation', $item->occupation) }}">
                    @error('occupation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status Pernikahan</label>
                    <select name="marital_status" class="form-select @error('marital_status') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Belum Menikah" {{ old('marital_status', $item->marital_status)=='Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="Menikah" {{ old('marital_status', $item->marital_status)=='Menikah' ? 'selected' : '' }}>Menikah</option>
                        <option value="Cerai" {{ old('marital_status', $item->marital_status)=='Cerai' ? 'selected' : '' }}>Cerai</option>
                    </select>
                    @error('marital_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Ibu</label>
                    <input type="text" name="mother_name" class="form-control @error('mother_name') is-invalid @enderror" value="{{ old('mother_name', $item->mother_name) }}">
                    @error('mother_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $item->phone) }}">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="2">{{ old('address', $item->address) }}</textarea>
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Alergi</label>
                    <textarea name="allergies" class="form-control @error('allergies') is-invalid @enderror" rows="2">{{ old('allergies', $item->allergies) }}</textarea>
                    @error('allergies') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('patients.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Edit Tagihan')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Edit Tagihan</h5>
    <a href="{{ route('patient-bills.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card">
    <div class="card-body">
        @php
            $patients = \App\Models\Patient::all();
            $registrations = \App\Models\Registration::all();
            $insurances = \App\Models\Insurance::all();
        @endphp
        <form method="POST" action="{{ route('patient-bills.update', $item->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pasien</label>
                    <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pasien --</option>
                        @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id', $item->patient_id)==$patient->id ? 'selected' : '' }}>{{ $patient->no_rm }} - {{ $patient->name }}</option>
                        @endforeach
                    </select>
                    @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Registrasi</label>
                    <select name="registration_id" class="form-select @error('registration_id') is-invalid @enderror">
                        <option value="">-- Pilih Registrasi --</option>
                        @foreach($registrations as $reg)
                        <option value="{{ $reg->id }}" {{ old('registration_id', $item->registration_id)==$reg->id ? 'selected' : '' }}>{{ $reg->registration_number }} - {{ $reg->patient->name ?? '' }}</option>
                        @endforeach
                    </select>
                    @error('registration_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Asuransi</label>
                    <select name="insurance_id" class="form-select @error('insurance_id') is-invalid @enderror">
                        <option value="">-- Tidak Ada --</option>
                        @foreach($insurances as $ins)
                        <option value="{{ $ins->id }}" {{ old('insurance_id', $item->insurance_id)==$ins->id ? 'selected' : '' }}>{{ $ins->name }}</option>
                        @endforeach
                    </select>
                    @error('insurance_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Diskon</label>
                    <input type="number" name="discount" class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount', $item->discount) }}" min="0">
                    @error('discount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="2">{{ old('notes', $item->notes) }}</textarea>
                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Edit Pendaftaran')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Edit Pendaftaran</h5>
    <a href="{{ route('registrations.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card">
    <div class="card-body">
        @php
            $patients = \App\Models\Patient::all();
            $polyclinics = \App\Models\Polyclinic::all();
            $doctors = \App\Models\Doctor::all();
            $insurances = \App\Models\Insurance::all();
        @endphp
        <form method="POST" action="{{ route('registrations.update', $item->id) }}">
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
                    <label class="form-label">Poliklinik</label>
                    <select name="polyclinic_id" class="form-select @error('polyclinic_id') is-invalid @enderror">
                        <option value="">-- Pilih Poliklinik --</option>
                        @foreach($polyclinics as $poly)
                        <option value="{{ $poly->id }}" {{ old('polyclinic_id', $item->polyclinic_id)==$poly->id ? 'selected' : '' }}>{{ $poly->name }}</option>
                        @endforeach
                    </select>
                    @error('polyclinic_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dokter</label>
                    <select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror">
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id', $item->doctor_id)==$doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                    @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                    <label class="form-label">Tipe Pendaftaran</label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="">-- Pilih Tipe --</option>
                        <option value="rawat_jalan" {{ old('type', $item->type)=='rawat_jalan' ? 'selected' : '' }}>Rawat Jalan</option>
                        <option value="igd" {{ old('type', $item->type)=='igd' ? 'selected' : '' }}>IGD</option>
                        <option value="rawat_inap" {{ old('type', $item->type)=='rawat_inap' ? 'selected' : '' }}>Rawat Inap</option>
                    </select>
                    @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Waktu Pendaftaran</label>
                    <input type="datetime-local" name="registration_time" class="form-control @error('registration_time') is-invalid @enderror" value="{{ old('registration_time', $item->registration_time ? $item->registration_time->format('Y-m-d\TH:i') : '') }}" required>
                    @error('registration_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Rujukan Dari</label>
                    <input type="text" name="referral_from" class="form-control @error('referral_from') is-invalid @enderror" value="{{ old('referral_from', $item->referral_from) }}">
                    @error('referral_from')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Keluhan</label>
                    <textarea name="complaint" class="form-control @error('complaint') is-invalid @enderror" rows="3">{{ old('complaint', $item->complaint) }}</textarea>
                    @error('complaint')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
        </form>
    </div>
</div>
@endsection

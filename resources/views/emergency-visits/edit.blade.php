@extends('layouts.app')
@section('title', 'Edit Kunjungan IGD')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Edit Kunjungan IGD</h5>
    <a href="{{ route('emergency-visits.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card">
    <div class="card-body">
        @php
            $patients = \App\Models\Patient::all();
            $doctors = \App\Models\Doctor::all();
            $registrations = \App\Models\Registration::where('type', 'igd')->get();
        @endphp
        <form method="POST" action="{{ route('emergency-visits.update', $item->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
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
                    <label class="form-label">Triage</label>
                    <select name="triage" class="form-select @error('triage') is-invalid @enderror" required>
                        <option value="">-- Pilih Triage --</option>
                        <option value="resuscitation" {{ old('triage', $item->triage)=='resuscitation' ? 'selected' : '' }}>Resusitasi</option>
                        <option value="emergent" {{ old('triage', $item->triage)=='emergent' ? 'selected' : '' }}>Emergen</option>
                        <option value="urgent" {{ old('triage', $item->triage)=='urgent' ? 'selected' : '' }}>Urgent</option>
                        <option value="semi_urgent" {{ old('triage', $item->triage)=='semi_urgent' ? 'selected' : '' }}>Semi Urgent</option>
                        <option value="non_urgent" {{ old('triage', $item->triage)=='non_urgent' ? 'selected' : '' }}>Non Urgent</option>
                    </select>
                    @error('triage')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Keluhan</label>
                    <textarea name="complaint" class="form-control @error('complaint') is-invalid @enderror" rows="2">{{ old('complaint', $item->complaint) }}</textarea>
                    @error('complaint')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Diagnosis</label>
                    <textarea name="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="2">{{ old('diagnosis', $item->diagnosis) }}</textarea>
                    @error('diagnosis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Penanganan</label>
                    <textarea name="treatment" class="form-control @error('treatment') is-invalid @enderror" rows="2">{{ old('treatment', $item->treatment) }}</textarea>
                    @error('treatment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Disposisi</label>
                    <select name="disposition" class="form-select @error('disposition') is-invalid @enderror">
                        <option value="">-- Pilih Disposisi --</option>
                        <option value="home" {{ old('disposition', $item->disposition)=='home' ? 'selected' : '' }}>Pulang</option>
                        <option value="inpatient" {{ old('disposition', $item->disposition)=='inpatient' ? 'selected' : '' }}>Rawat Inap</option>
                        <option value="referred" {{ old('disposition', $item->disposition)=='referred' ? 'selected' : '' }}>Dirujuk</option>
                        <option value="observation" {{ old('disposition', $item->disposition)=='observation' ? 'selected' : '' }}>Observasi</option>
                        <option value="deceased" {{ old('disposition', $item->disposition)=='deceased' ? 'selected' : '' }}>Meninggal</option>
                    </select>
                    @error('disposition')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
        </form>
    </div>
</div>
@endsection

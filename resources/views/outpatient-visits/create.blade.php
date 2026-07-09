@extends('layouts.app')
@section('title', 'Tambah Kunjungan Rawat Jalan')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Tambah Kunjungan Rawat Jalan</h5>
    <a href="{{ route('outpatient-visits.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card">
    <div class="card-body">
        @php
            $patients = \App\Models\Patient::all();
            $doctors = \App\Models\Doctor::all();
            $polyclinics = \App\Models\Polyclinic::all();
            $registrations = \App\Models\Registration::where('type', 'rawat_jalan')->where('status', 'waiting')->get();
        @endphp
        <form method="POST" action="{{ route('outpatient-visits.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Registrasi</label>
                    <select name="registration_id" class="form-select @error('registration_id') is-invalid @enderror">
                        <option value="">-- Pilih Registrasi --</option>
                        @foreach($registrations as $reg)
                        <option value="{{ $reg->id }}" {{ old('registration_id')==$reg->id ? 'selected' : '' }}>{{ $reg->registration_number }} - {{ $reg->patient->name ?? '' }}</option>
                        @endforeach
                    </select>
                    @error('registration_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pasien</label>
                    <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pasien --</option>
                        @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id')==$patient->id ? 'selected' : '' }}>{{ $patient->no_rm }} - {{ $patient->name }}</option>
                        @endforeach
                    </select>
                    @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dokter</label>
                    <select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id')==$doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                    @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Poliklinik</label>
                    <select name="polyclinic_id" class="form-select @error('polyclinic_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Poliklinik --</option>
                        @foreach($polyclinics as $poly)
                        <option value="{{ $poly->id }}" {{ old('polyclinic_id')==$poly->id ? 'selected' : '' }}>{{ $poly->name }}</option>
                        @endforeach
                    </select>
                    @error('polyclinic_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="waiting" {{ old('status')=='waiting' ? 'selected' : '' }}>Menunggu</option>
                        <option value="called" {{ old('status')=='called' ? 'selected' : '' }}>Dipanggil</option>
                        <option value="in_examination" {{ old('status')=='in_examination' ? 'selected' : '' }}>Diperiksa</option>
                        <option value="completed" {{ old('status')=='completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ old('status')=='cancelled' ? 'selected' : '' }}>Batal</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No Antrian</label>
                    <input type="text" name="queue_number" class="form-control @error('queue_number') is-invalid @enderror" value="{{ old('queue_number') }}" readonly>
                    @error('queue_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Anamnesis</label>
                    <textarea name="anamnesis" class="form-control @error('anamnesis') is-invalid @enderror" rows="2">{{ old('anamnesis') }}</textarea>
                    @error('anamnesis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Diagnosis</label>
                    <textarea name="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="2">{{ old('diagnosis') }}</textarea>
                    @error('diagnosis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Terapi</label>
                    <textarea name="therapy" class="form-control @error('therapy') is-invalid @enderror" rows="2">{{ old('therapy') }}</textarea>
                    @error('therapy')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="2">{{ old('notes') }}</textarea>
                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
        </form>
    </div>
</div>
@endsection

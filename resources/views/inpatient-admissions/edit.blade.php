@extends('layouts.app')
@section('title', 'Edit Rawat Inap')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Edit Rawat Inap</h5>
    <a href="{{ route('inpatient-admissions.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card">
    <div class="card-body">
        @php
            $patients = \App\Models\Patient::all();
            $rooms = \App\Models\Room::all();
            $doctors = \App\Models\Doctor::all();
            $registrations = \App\Models\Registration::where('type', 'rawat_inap')->get();
        @endphp
        <form method="POST" action="{{ route('inpatient-admissions.update', $item->id) }}">
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
                    <label class="form-label">Kamar</label>
                    <select name="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Kamar --</option>
                        @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id', $item->room_id)==$room->id ? 'selected' : '' }}>{{ $room->name }} ({{ $room->room_number }})</option>
                        @endforeach
                    </select>
                    @error('room_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dokter</label>
                    <select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id', $item->doctor_id)==$doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                    @error('doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Masuk</label>
                    <input type="date" name="admission_date" class="form-control @error('admission_date') is-invalid @enderror" value="{{ old('admission_date', $item->admission_date ? $item->admission_date->format('Y-m-d') : '') }}" required>
                    @error('admission_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam Masuk</label>
                    <input type="time" name="admission_time" class="form-control @error('admission_time') is-invalid @enderror" value="{{ old('admission_time', $item->admission_time ? $item->admission_time->format('H:i') : '') }}">
                    @error('admission_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', $item->status)=='active' ? 'selected' : '' }}>Aktif</option>
                        <option value="discharged" {{ old('status', $item->status)=='discharged' ? 'selected' : '' }}>Pulang</option>
                        <option value="transferred" {{ old('status', $item->status)=='transferred' ? 'selected' : '' }}>Dipindah</option>
                        <option value="cancelled" {{ old('status', $item->status)=='cancelled' ? 'selected' : '' }}>Batal</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Diagnosis Awal</label>
                    <textarea name="primary_diagnosis" class="form-control @error('primary_diagnosis') is-invalid @enderror" rows="2">{{ old('primary_diagnosis', $item->primary_diagnosis) }}</textarea>
                    @error('primary_diagnosis')<div class="invalid-feedback">{{ $message }}</div>@enderror
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

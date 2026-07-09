@extends('layouts.app')
@section('title', 'Edit Permintaan Lab')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Edit Permintaan Laboratorium</h5>
    <a href="{{ route('lab-requests.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card">
    <div class="card-body">
        @php
            $patients = \App\Models\Patient::all();
            $doctors = \App\Models\Doctor::all();
            $labTests = \App\Models\LabTest::all();
        @endphp
        <form method="POST" action="{{ route('lab-requests.update', $item->id) }}">
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
                    <label class="form-label">Pemeriksaan</label>
                    <select name="lab_test_id" class="form-select @error('lab_test_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pemeriksaan --</option>
                        @foreach($labTests as $test)
                        <option value="{{ $test->id }}" {{ old('lab_test_id', $item->lab_test_id)==$test->id ? 'selected' : '' }}>{{ $test->name }}</option>
                        @endforeach
                    </select>
                    @error('lab_test_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Prioritas</label>
                    <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                        <option value="routine" {{ old('priority', $item->priority)=='routine' ? 'selected' : '' }}>Rutin</option>
                        <option value="urgent" {{ old('priority', $item->priority)=='urgent' ? 'selected' : '' }}>Urgent</option>
                        <option value="stat" {{ old('priority', $item->priority)=='stat' ? 'selected' : '' }}>STAT</option>
                    </select>
                    @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Permintaan</label>
                    <input type="datetime-local" name="requested_at" class="form-control @error('requested_at') is-invalid @enderror" value="{{ old('requested_at', $item->requested_at ? $item->requested_at->format('Y-m-d\TH:i') : '') }}" required>
                    @error('requested_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $item->notes) }}</textarea>
                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
        </form>
    </div>
</div>
@endsection

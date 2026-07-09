@extends('layouts.app')
@section('title', 'Edit Rujukan')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Edit Rujukan</h5>
    <a href="{{ route('referrals.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card">
    <div class="card-body">
        @php
            $patients = \App\Models\Patient::all();
            $doctors = \App\Models\Doctor::all();
        @endphp
        <form method="POST" action="{{ route('referrals.update', $item->id) }}">
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
                    <label class="form-label">Dokter Pengirim</label>
                    <select name="from_doctor_id" class="form-select @error('from_doctor_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('from_doctor_id', $item->from_doctor_id)==$doctor->id ? 'selected' : '' }}>{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                    @error('from_doctor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Institusi Tujuan</label>
                    <input type="text" name="to_institution" class="form-control @error('to_institution') is-invalid @enderror" value="{{ old('to_institution', $item->to_institution) }}" required>
                    @error('to_institution')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dokter Tujuan</label>
                    <input type="text" name="to_doctor" class="form-control @error('to_doctor') is-invalid @enderror" value="{{ old('to_doctor', $item->to_doctor) }}">
                    @error('to_doctor')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Rujukan</label>
                    <input type="date" name="referral_date" class="form-control @error('referral_date') is-invalid @enderror" value="{{ old('referral_date', $item->referral_date ? $item->referral_date->format('Y-m-d') : '') }}" required>
                    @error('referral_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="pending" {{ old('status', $item->status)=='pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ old('status', $item->status)=='accepted' ? 'selected' : '' }}>Diterima</option>
                        <option value="rejected" {{ old('status', $item->status)=='rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="cancelled" {{ old('status', $item->status)=='cancelled' ? 'selected' : '' }}>Batal</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Diagnosis</label>
                    <textarea name="diagnosis" class="form-control @error('diagnosis') is-invalid @enderror" rows="2">{{ old('diagnosis', $item->diagnosis) }}</textarea>
                    @error('diagnosis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Alasan Rujukan</label>
                    <textarea name="reason" class="form-control @error('reason') is-invalid @enderror" rows="2">{{ old('reason', $item->reason) }}</textarea>
                    @error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
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

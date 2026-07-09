@extends('layouts.app')
@section('title', 'Edit Jadwal')
@section('content')
@php $doctors = \App\Models\Doctor::all(); $polyclinics = \App\Models\Polyclinic::all(); @endphp
<div class="card">
    <div class="card-header">Edit Jadwal</div>
    <div class="card-body">
        <form method="POST" action="{{ route('schedules.update', $item->id) }}">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dokter</label>
                    <select name="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}" {{ old('doctor_id', $item->doctor_id)==$doc->id ? 'selected' : '' }}>{{ $doc->name }}</option>
                        @endforeach
                    </select>
                    @error('doctor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Poli</label>
                    <select name="polyclinic_id" class="form-select @error('polyclinic_id') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach($polyclinics as $poli)
                            <option value="{{ $poli->id }}" {{ old('polyclinic_id', $item->polyclinic_id)==$poli->id ? 'selected' : '' }}>{{ $poli->name }}</option>
                        @endforeach
                    </select>
                    @error('polyclinic_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Hari</label>
                    <select name="day_of_week" class="form-select @error('day_of_week') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="Senin" {{ old('day_of_week', $item->day_of_week)=='Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ old('day_of_week', $item->day_of_week)=='Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ old('day_of_week', $item->day_of_week)=='Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ old('day_of_week', $item->day_of_week)=='Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ old('day_of_week', $item->day_of_week)=='Jumat' ? 'selected' : '' }}>Jumat</option>
                        <option value="Sabtu" {{ old('day_of_week', $item->day_of_week)=='Sabtu' ? 'selected' : '' }}>Sabtu</option>
                        <option value="Minggu" {{ old('day_of_week', $item->day_of_week)=='Minggu' ? 'selected' : '' }}>Minggu</option>
                    </select>
                    @error('day_of_week') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Jam Mulai</label>
                    <input type="time" name="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', $item->start_time) }}">
                    @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Jam Selesai</label>
                    <input type="time" name="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', $item->end_time) }}">
                    @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Max Pasien</label>
                    <input type="number" name="max_patients" class="form-control @error('max_patients') is-invalid @enderror" value="{{ old('max_patients', $item->max_patients) }}">
                    @error('max_patients') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label">Aktif</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

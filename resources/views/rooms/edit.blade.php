@extends('layouts.app')
@section('title', 'Edit Kamar')
@section('content')
@php $categories = \App\Models\RoomCategory::all(); @endphp
<div class="card">
    <div class="card-header">Edit Kamar</div>
    <div class="card-body">
        <form method="POST" action="{{ route('rooms.update', $item->id) }}">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kelas Kamar</label>
                    <select name="room_category_id" class="form-select @error('room_category_id') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('room_category_id', $item->room_category_id)==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('room_category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. Kamar</label>
                    <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror" value="{{ old('room_number', $item->room_number) }}">
                    @error('room_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Kamar</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $item->name) }}">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="available" {{ old('status', $item->status)=='available' ? 'selected' : '' }}>Available</option>
                        <option value="occupied" {{ old('status', $item->status)=='occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="maintenance" {{ old('status', $item->status)=='maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="reserved" {{ old('status', $item->status)=='reserved' ? 'selected' : '' }}>Reserved</option>
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="2">{{ old('notes', $item->notes) }}</textarea>
                    @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" class="form-check-input" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label">Aktif</label>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

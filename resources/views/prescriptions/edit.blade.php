@extends('layouts.app')
@section('title', 'Edit Resep')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Edit Resep</h5>
    <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card">
    <div class="card-body">
        @php
            $patients = \App\Models\Patient::all();
            $doctors = \App\Models\Doctor::all();
            $medicines = \App\Models\Medicine::all();
        @endphp
        <form method="POST" action="{{ route('prescriptions.update', $item->id) }}">
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
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" {{ old('status', $item->status)=='active' ? 'selected' : '' }}>Aktif</option>
                        <option value="dispensed" {{ old('status', $item->status)=='dispensed' ? 'selected' : '' }}>Diberikan</option>
                        <option value="cancelled" {{ old('status', $item->status)=='cancelled' ? 'selected' : '' }}>Batal</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Resep</label>
                    <input type="datetime-local" name="prescribed_at" class="form-control @error('prescribed_at') is-invalid @enderror" value="{{ old('prescribed_at', $item->prescribed_at ? $item->prescribed_at->format('Y-m-d\TH:i') : '') }}" required>
                    @error('prescribed_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="2">{{ old('notes', $item->notes) }}</textarea>
                    @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Item Resep</h6>
                    <button type="button" class="btn btn-sm btn-success" id="addItem"><i class="fas fa-plus"></i> Tambah Item</button>
                </div>
                <div class="card-body">
                    <table class="table table-sm" id="itemsTable">
                        <thead><tr><th>Obat</th><th>Dosis</th><th>Frekuensi</th><th>Instruksi</th><th>Jumlah</th><th>Hari</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @forelse($item->items as $idx => $prescriptionItem)
                            <tr class="item-row">
                                <td><select name="items[{{ $idx }}][medicine_id]" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach($medicines as $medicine)
                                    <option value="{{ $medicine->id }}" {{ $prescriptionItem->medicine_id==$medicine->id ? 'selected' : '' }}>{{ $medicine->name }}</option>
                                    @endforeach
                                </select></td>
                                <td><input type="text" name="items[{{ $idx }}][dosage]" class="form-control form-control-sm" value="{{ $prescriptionItem->dosage }}"></td>
                                <td><input type="text" name="items[{{ $idx }}][frequency]" class="form-control form-control-sm" value="{{ $prescriptionItem->frequency }}"></td>
                                <td><input type="text" name="items[{{ $idx }}][instruction]" class="form-control form-control-sm" value="{{ $prescriptionItem->instruction }}"></td>
                                <td><input type="number" name="items[{{ $idx }}][quantity]" class="form-control form-control-sm" min="1" value="{{ $prescriptionItem->quantity }}"></td>
                                <td><input type="number" name="items[{{ $idx }}][days]" class="form-control form-control-sm" min="1" value="{{ $prescriptionItem->days }}"></td>
                                <td><button type="button" class="btn btn-sm btn-danger removeItem"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @empty
                            <tr class="item-row">
                                <td><select name="items[0][medicine_id]" class="form-select form-select-sm" required>
                                    <option value="">-- Pilih --</option>
                                    @foreach($medicines as $medicine)
                                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                    @endforeach
                                </select></td>
                                <td><input type="text" name="items[0][dosage]" class="form-control form-control-sm"></td>
                                <td><input type="text" name="items[0][frequency]" class="form-control form-control-sm"></td>
                                <td><input type="text" name="items[0][instruction]" class="form-control form-control-sm"></td>
                                <td><input type="number" name="items[0][quantity]" class="form-control form-control-sm" min="1" value="1"></td>
                                <td><input type="number" name="items[0][days]" class="form-control form-control-sm" min="1" value="1"></td>
                                <td><button type="button" class="btn btn-sm btn-danger removeItem"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
let itemIndex = {{ $item->items->count() ?: 1 }};
document.getElementById('addItem').addEventListener('click', function() {
    const tbody = document.querySelector('#itemsTable tbody');
    const row = document.createElement('tr');
    row.className = 'item-row';
    row.innerHTML = `
        <td><select name="items[${itemIndex}][medicine_id]" class="form-select form-select-sm" required>
            <option value="">-- Pilih --</option>
            @foreach($medicines as $medicine)
            <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
            @endforeach
        </select></td>
        <td><input type="text" name="items[${itemIndex}][dosage]" class="form-control form-control-sm"></td>
        <td><input type="text" name="items[${itemIndex}][frequency]" class="form-control form-control-sm"></td>
        <td><input type="text" name="items[${itemIndex}][instruction]" class="form-control form-control-sm"></td>
        <td><input type="number" name="items[${itemIndex}][quantity]" class="form-control form-control-sm" min="1" value="1"></td>
        <td><input type="number" name="items[${itemIndex}][days]" class="form-control form-control-sm" min="1" value="1"></td>
        <td><button type="button" class="btn btn-sm btn-danger removeItem"><i class="fas fa-trash"></i></button></td>
    `;
    tbody.appendChild(row);
    itemIndex++;
});
document.addEventListener('click', function(e) {
    if (e.target.closest('.removeItem')) {
        e.target.closest('.item-row').remove();
    }
});
</script>
@endpush

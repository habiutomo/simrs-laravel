@extends('layouts.app')
@section('title', 'Tambah Pembayaran')
@section('content')
<div class="page-header">
    <h5 class="mb-0">Tambah Pembayaran</h5>
    <a href="{{ route('payments.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card">
    <div class="card-body">
        @php
            $unpaidBills = \App\Models\PatientBill::whereIn('status', ['unpaid', 'partial'])->get();
        @endphp
        <form method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tagihan</label>
                    <select name="patient_bill_id" class="form-select @error('patient_bill_id') is-invalid @enderror" id="patientBillSelect" required>
                        <option value="">-- Pilih Tagihan --</option>
                        @foreach($unpaidBills as $bill)
                        <option value="{{ $bill->id }}" data-patient="{{ $bill->patient_id }}" {{ old('patient_bill_id')==$bill->id ? 'selected' : '' }}>{{ $bill->bill_number }} - {{ $bill->patient->name ?? '' }} (Rp {{ number_format($bill->total_amount, 0, ',', '.') }})</option>
                        @endforeach
                    </select>
                    @error('patient_bill_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pasien</label>
                    <select name="patient_id" class="form-select @error('patient_id') is-invalid @enderror" id="patientIdSelect" required>
                        <option value="">-- Pilih Pasien --</option>
                        @foreach(\App\Models\Patient::all() as $patient)
                        <option value="{{ $patient->id }}" {{ old('patient_id')==$patient->id ? 'selected' : '' }}>{{ $patient->no_rm }} - {{ $patient->name }}</option>
                        @endforeach
                    </select>
                    @error('patient_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" min="0" required>
                    @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Metode</label>
                    <select name="method" class="form-select @error('method') is-invalid @enderror" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="cash" {{ old('method')=='cash' ? 'selected' : '' }}>Tunai</option>
                        <option value="transfer" {{ old('method')=='transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="debit" {{ old('method')=='debit' ? 'selected' : '' }}>Debit</option>
                        <option value="credit" {{ old('method')=='credit' ? 'selected' : '' }}>Kredit</option>
                        <option value="insurance" {{ old('method')=='insurance' ? 'selected' : '' }}>Asuransi</option>
                        <option value="other" {{ old('method')=='other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('method')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="pending" {{ old('status')=='pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status')=='confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Bayar</label>
                    <input type="datetime-local" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror" value="{{ old('payment_date') }}" required>
                    @error('payment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Diterima Oleh</label>
                    <input type="text" name="received_by" class="form-control @error('received_by') is-invalid @enderror" value="{{ old('received_by', auth()->user()->name ?? '') }}">
                    @error('received_by')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
@push('scripts')
<script>
document.getElementById('patientBillSelect').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    if (selected && selected.dataset.patient) {
        document.getElementById('patientIdSelect').value = selected.dataset.patient;
    }
});
</script>
@endpush

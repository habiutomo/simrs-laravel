@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #0d6efd, #0a58ca); position: relative;">
            <i class="fas fa-users"></i>
            <div class="number">{{ $totalPatients }}</div>
            <div class="label">Total Pasien</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #198754, #157347); position: relative;">
            <i class="fas fa-clipboard-list"></i>
            <div class="number">{{ $todayRegistrations }}</div>
            <div class="label">Pendaftaran Hari Ini</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #fd7e14, #e96b0a); position: relative;">
            <i class="fas fa-procedures"></i>
            <div class="number">{{ $activeInpatients }}</div>
            <div class="label">Rawat Inap Aktif</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #dc3545, #b02a37); position: relative;">
            <i class="fas fa-file-invoice"></i>
            <div class="number">{{ $pendingBills }}</div>
            <div class="label">Tagihan Belum Dibayar</div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Kunjungan 7 Hari Terakhir</div>
            <div class="card-body">
                @if($weeklyVisits->count() > 0)
                <div style="height: 250px; position: relative;">
                    <canvas id="visitChart"></canvas>
                </div>
                @else
                    <p class="text-muted text-center py-5">Belum ada data kunjungan</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Aksi Cepat</div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('registrations.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Pendaftaran Baru</a>
                    <a href="{{ route('outpatient-visits.index') }}" class="btn btn-success"><i class="fas fa-walking"></i> Rawat Jalan</a>
                    <a href="{{ route('emergency-visits.create') }}" class="btn btn-danger"><i class="fas fa-ambulance"></i> IGD</a>
                    <a href="{{ route('patient-bills.index') }}" class="btn btn-warning"><i class="fas fa-file-invoice"></i> Tagihan</a>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Informasi</div>
            <div class="card-body">
                <p class="small mb-1"><i class="fas fa-check-circle text-success me-2"></i>Kunjungan Hari Ini: <strong>{{ $todayVisits }}</strong></p>
                <p class="small mb-0"><i class="fas fa-check-circle text-info me-2"></i>Pasien Dirawat: <strong>{{ $activeInpatients }}</strong></p>
            </div>
        </div>
    </div>
</div>

@if($weeklyVisits->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('visitChart'), {
        type: 'line',
        data: {
            labels: [@foreach($weeklyVisits as $v) '{{ $v->date->format("d/m") }}', @endforeach],
            datasets: [{
                label: 'Kunjungan',
                data: [@foreach($weeklyVisits as $v) {{ $v->total }}, @endforeach],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,.1)',
                fill: true,
                tension: .3
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });
</script>
@endif
@endsection
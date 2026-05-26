<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row g-3 mb-4">
    <div class="col-md-8">
        <div class="card card-custom p-4 h-100">
            <h4 class="fw-bold mb-2">Dashboard MineFleet Booking</h4>
            <p class="text-muted mb-0">
                Login berhasil. Selamat datang di sistem pemesanan dan approval kendaraan operasional perusahaan.
            </p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-custom p-4 h-100">
            <h6 class="fw-bold mb-3">Informasi User</h6>

            <p class="mb-1">
                <strong>Nama:</strong> <?= esc(session()->get('name')) ?>
            </p>

            <p class="mb-1">
                <strong>Role:</strong> <?= esc(session()->get('role')) ?>
            </p>

            <p class="mb-3">
                <strong>Approval Level:</strong> <?= esc(session()->get('approval_level') ?? '-') ?>
            </p>

            <a href="/logout" class="btn btn-outline-danger btn-sm">
                Logout
            </a>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-custom p-4">
            <p class="text-muted mb-1">Total Kendaraan</p>
            <h2 class="fw-bold mb-0">
                <?= esc($summary['totalVehicles']) ?>
            </h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-custom p-4">
            <p class="text-muted mb-1">Total Driver</p>
            <h2 class="fw-bold mb-0">
                <?= esc($summary['totalDrivers']) ?>
            </h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-custom p-4">
            <p class="text-muted mb-1">Approved</p>
            <h2 class="fw-bold mb-0 text-success">
                <?= esc($summary['approvedBookings']) ?>
            </h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-custom p-4">
            <p class="text-muted mb-1">Rejected</p>
            <h2 class="fw-bold mb-0 text-danger">
                <?= esc($summary['rejectedBookings']) ?>
            </h2>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card card-custom p-4">
            <h5 class="fw-bold mb-3">
                Grafik Pemakaian Kendaraan per Bulan
            </h5>

            <?php if (! empty($monthlyUsage)) : ?>
                <canvas id="monthlyUsageChart" height="130"></canvas>
            <?php else : ?>
                <div class="text-center text-muted py-5">
                    Belum ada data pemakaian kendaraan.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card card-custom p-4">
            <h5 class="fw-bold mb-3">
                Kendaraan Paling Sering Digunakan
            </h5>

            <?php if (! empty($topVehicles)) : ?>
                <canvas id="topVehicleChart" height="180"></canvas>
            <?php else : ?>
                <div class="text-center text-muted py-5">
                    Belum ada kendaraan yang digunakan.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
const monthlyUsage = <?= json_encode($monthlyUsage ?? []) ?>;
const topVehicles = <?= json_encode($topVehicles ?? []) ?>;

if (monthlyUsage.length > 0) {
    new Chart(document.getElementById('monthlyUsageChart'), {
        type: 'line',
        data: {
            labels: monthlyUsage.map(item => item.month),
            datasets: [{
                label: 'Jumlah Pemakaian',
                data: monthlyUsage.map(item => item.total),
                tension: 0.35
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}

if (topVehicles.length > 0) {
    new Chart(document.getElementById('topVehicleChart'), {
        type: 'bar',
        data: {
            labels: topVehicles.map(item => item.vehicle_name + ' - ' + item.plate_number),
            datasets: [{
                label: 'Total Booking',
                data: topVehicles.map(item => item.total)
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}
</script>

<?= $this->endSection() ?>
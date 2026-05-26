<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h4 class="fw-bold mb-1">Laporan Pemesanan Kendaraan</h4>
    <p class="text-muted mb-0">
        Laporan periodik pemesanan kendaraan yang dapat diexport ke Excel.
    </p>
</div>

<div class="card card-custom p-4 mb-4">
    <form method="get" action="/reports" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label">Tanggal Awal</label>
            <input type="date" name="start" class="form-control" value="<?= esc($start) ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Tanggal Akhir</label>
            <input type="date" name="end" class="form-control" value="<?= esc($end) ?>">
        </div>

        <div class="col-md-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="waiting_level_1" <?= $status === 'waiting_level_1' ? 'selected' : '' ?>>Waiting Level 1</option>
                <option value="waiting_level_2" <?= $status === 'waiting_level_2' ? 'selected' : '' ?>>Waiting Level 2</option>
                <option value="approved" <?= $status === 'approved' ? 'selected' : '' ?>>Approved</option>
                <option value="rejected" <?= $status === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                <option value="completed" <?= $status === 'completed' ? 'selected' : '' ?>>Completed</option>
            </select>
        </div>

        <div class="col-md-3 d-flex gap-2">
            <button class="btn btn-primary-custom text-white">
                Filter
            </button>

            <a 
                href="/reports/export?start=<?= esc($start) ?>&end=<?= esc($end) ?>&status=<?= esc($status) ?>" 
                class="btn btn-success"
            >
                Export Excel
            </a>
        </div>
    </form>
</div>

<div class="card card-custom p-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pemesan</th>
                    <th>Kendaraan</th>
                    <th>Driver</th>
                    <th>Tujuan</th>
                    <th>Waktu</th>
                    <th>BBM</th>
                    <th>Biaya BBM</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($bookings as $booking) : ?>
                    <tr>
                        <td class="fw-semibold"><?= esc($booking['booking_code']) ?></td>

                        <td>
                            <?= esc($booking['requester_name']) ?><br>
                            <small class="text-muted"><?= esc($booking['department']) ?></small>
                        </td>

                        <td>
                            <?= esc($booking['vehicle_name']) ?><br>
                            <small class="text-muted"><?= esc($booking['plate_number']) ?></small>
                        </td>

                        <td><?= esc($booking['driver_name']) ?></td>

                        <td>
                            <?= esc($booking['destination']) ?><br>
                            <small class="text-muted"><?= esc($booking['purpose']) ?></small>
                        </td>

                            <td>
                                <?= esc($booking['start_at']) ?><br><small class="text-muted">s/d <?= esc($booking['end_at']) ?></small>
                            </td>

                            <td>
                                <?= esc($booking['total_fuel_liter'] ?? 0) ?> L
                            </td>

                            <td>
                                Rp <?= number_format($booking['total_fuel_cost'] ?? 0, 0, ',', '.') ?>
                            </td>

                            <td>
                                <span class="badge bg-secondary"><?= esc($booking['status']) ?>
                                </span>
                            </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($bookings)) : ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            Tidak ada data laporan pada periode ini.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
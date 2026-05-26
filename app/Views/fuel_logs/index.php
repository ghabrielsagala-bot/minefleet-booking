<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Konsumsi BBM</h4>
        <p class="text-muted mb-0">Monitoring konsumsi bahan bakar kendaraan operasional.</p>
    </div>

    <?php if (session()->get('role') === 'admin') : ?>
        <a href="/fuel-logs/create" class="btn btn-primary-custom text-white">
            + Tambah BBM
        </a>
    <?php endif; ?>
</div>

<div class="card card-custom p-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kendaraan</th>
                    <th>Kode Booking</th>
                    <th>Liter</th>
                    <th>Biaya</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($fuelLogs as $item) : ?>
                    <tr>
                        <td><?= esc($item['log_date']) ?></td>
                        <td>
                            <?= esc($item['vehicle_name']) ?><br>
                            <small class="text-muted"><?= esc($item['plate_number']) ?></small>
                        </td>
                        <td><?= esc($item['booking_code'] ?? '-') ?></td>
                        <td><?= esc($item['fuel_liter']) ?> L</td>
                        <td>Rp <?= number_format($item['cost'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($fuelLogs)) : ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Belum ada data konsumsi BBM.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
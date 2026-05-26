<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h4 class="fw-bold mb-1">Riwayat Pemakaian Kendaraan</h4>
    <p class="text-muted mb-0">
        Data pemakaian kendaraan yang sudah disetujui oleh atasan.
    </p>
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
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($histories as $item) : ?>
                    <tr>
                        <td class="fw-semibold"><?= esc($item['booking_code']) ?></td>

                        <td>
                            <?= esc($item['requester_name']) ?><br>
                            <small class="text-muted"><?= esc($item['department']) ?></small>
                        </td>

                        <td>
                            <?= esc($item['vehicle_name']) ?><br>
                            <small class="text-muted"><?= esc($item['plate_number']) ?></small>
                        </td>

                        <td><?= esc($item['driver_name']) ?></td>

                        <td>
                            <?= esc($item['destination']) ?><br>
                            <small class="text-muted"><?= esc($item['purpose']) ?></small>
                        </td>

                        <td>
                            <?= esc($item['start_at']) ?><br>
                            <small class="text-muted">s/d <?= esc($item['end_at']) ?></small>
                        </td>

                        <td>
                            <span class="badge bg-success">
                                <?= esc($item['status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($histories)) : ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada riwayat pemakaian kendaraan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
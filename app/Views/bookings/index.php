<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Daftar Pemesanan Kendaraan</h4>
        <p class="text-muted mb-0">Monitoring seluruh pemesanan kendaraan operasional.</p>
    </div>

    <?php if (session()->get('role') === 'admin') : ?>
        <a href="/bookings/create" class="btn btn-primary-custom text-white">
            + Buat Pemesanan
        </a>
    <?php endif; ?>
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
                <?php foreach ($bookings as $booking) : ?>
                    <tr>
                        <td class="fw-semibold">
                            <?= esc($booking['booking_code']) ?>
                        </td>

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
                            <?= esc($booking['start_at']) ?><br>
                            <small class="text-muted">s/d <?= esc($booking['end_at']) ?></small>
                        </td>

                        <td>
                            <?php
                                $status = $booking['status'];
                                $badge = 'bg-secondary';

                                if (str_contains($status, 'waiting')) {
                                    $badge = 'badge-waiting';
                                } elseif ($status === 'approved') {
                                    $badge = 'badge-approved';
                                } elseif ($status === 'rejected') {
                                    $badge = 'badge-rejected';
                                }
                            ?>

                            <span class="badge <?= $badge ?>">
                                <?= esc($status) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($bookings)) : ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            Belum ada data pemesanan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h4 class="fw-bold mb-1">Daftar Approval</h4>
    <p class="text-muted mb-0">
        Persetujuan pemesanan kendaraan sesuai level approver.
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
                    <th>Level</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($approvals as $item) : ?>
                    <tr>
                        <td class="fw-semibold">
                            <?= esc($item['booking_code']) ?>
                        </td>

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
                            <span class="badge badge-waiting">
                                Level <?= esc($item['level']) ?>
                            </span>
                        </td>

                        <td>
                            <form method="post" action="/approvals/approve/<?= esc($item['approval_id']) ?>" class="d-inline">
                                <?= csrf_field() ?>
                                <button class="btn btn-success btn-sm">
                                    Approve
                                </button>
                            </form>

                            <form method="post" action="/approvals/reject/<?= esc($item['approval_id']) ?>" class="d-inline" onsubmit="return confirm('Yakin ingin menolak pemesanan ini?')">
                                <?= csrf_field() ?>
                                <button class="btn btn-danger btn-sm">
                                    Reject
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($approvals)) : ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Tidak ada data approval.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

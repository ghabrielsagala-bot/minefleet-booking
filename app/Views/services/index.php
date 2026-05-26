<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Jadwal Service Kendaraan</h4>
        <p class="text-muted mb-0">Monitoring service terakhir dan jadwal service berikutnya.</p>
    </div>

    <?php if (session()->get('role') === 'admin') : ?>
        <a href="/services/create" class="btn btn-primary-custom text-white">
            + Tambah Service
        </a>
    <?php endif; ?>
</div>

<div class="card card-custom p-4">
    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Kendaraan</th>
                    <th>Tanggal Service</th>
                    <th>Service Berikutnya</th>
                    <th>Deskripsi</th>
                    <th>Biaya</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($services as $item) : ?>
                    <tr>
                        <td>
                            <?= esc($item['vehicle_name']) ?><br>
                            <small class="text-muted"><?= esc($item['plate_number']) ?></small>
                        </td>
                        <td><?= esc($item['service_date']) ?></td>
                        <td><?= esc($item['next_service_date'] ?? '-') ?></td>
                        <td><?= esc($item['description']) ?></td>
                        <td>Rp <?= number_format($item['cost'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>

                <?php if (empty($services)) : ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Belum ada data service kendaraan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
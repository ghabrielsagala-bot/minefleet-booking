<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h4 class="fw-bold mb-1">Tambah Konsumsi BBM</h4>
    <p class="text-muted mb-0">Input data bahan bakar kendaraan.</p>
</div>

<div class="card card-custom p-4">
    <form method="post" action="/fuel-logs/create">
        <?= csrf_field() ?>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Kendaraan</label>
                <select name="vehicle_id" class="form-select" required>
                    <option value="">Pilih Kendaraan</option>
                    <?php foreach ($vehicles as $vehicle) : ?>
                        <option value="<?= esc($vehicle['id']) ?>">
                            <?= esc($vehicle['vehicle_name']) ?> - <?= esc($vehicle['plate_number']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Booking Terkait</label>
                <select name="booking_id" class="form-select">
                    <option value="">Tidak terkait booking</option>
                    <?php foreach ($bookings as $booking) : ?>
                        <option value="<?= esc($booking['id']) ?>">
                            <?= esc($booking['booking_code']) ?> - <?= esc($booking['requester_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Tanggal</label>
                <input type="date" name="log_date" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Jumlah Liter</label>
                <input type="number" step="0.01" name="fuel_liter" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Biaya</label>
                <input type="number" name="cost" class="form-control" required>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary-custom text-white px-4">
                Simpan
            </button>

            <a href="/fuel-logs" class="btn btn-outline-secondary">
                Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
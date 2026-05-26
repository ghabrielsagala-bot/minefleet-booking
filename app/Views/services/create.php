<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h4 class="fw-bold mb-1">Tambah Jadwal Service</h4>
    <p class="text-muted mb-0">Input riwayat service dan jadwal service berikutnya.</p>
</div>

<div class="card card-custom p-4">
    <form method="post" action="/services/create">
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

            <div class="col-md-3">
                <label class="form-label">Tanggal Service</label>
                <input type="date" name="service_date" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Service Berikutnya</label>
                <input type="date" name="next_service_date" class="form-control">
            </div>

            <div class="col-md-8">
                <label class="form-label">Deskripsi Service</label>
                <input type="text" name="description" class="form-control" placeholder="Contoh: ganti oli, cek rem, servis berkala" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Biaya</label>
                <input type="number" name="cost" class="form-control" value="0">
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary-custom text-white px-4">
                Simpan
            </button>

            <a href="/services" class="btn btn-outline-secondary">
                Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
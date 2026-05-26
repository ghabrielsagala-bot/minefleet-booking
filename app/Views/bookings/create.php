<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h4 class="fw-bold mb-1">Buat Pemesanan Kendaraan</h4>
    <p class="text-muted mb-0">
        Admin menentukan kendaraan, driver, dan approver berjenjang.
    </p>
</div>

<div class="card card-custom p-4">
    <form method="post" action="/bookings/create">
        <?= csrf_field() ?>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nama Pemesan</label>
                <input type="text" name="requester_name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Departemen</label>
                <input type="text" name="department" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tujuan</label>
                <input type="text" name="destination" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Keperluan</label>
                <input type="text" name="purpose" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tanggal Mulai</label>
                <input type="datetime-local" name="start_at" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Tanggal Selesai</label>
                <input type="datetime-local" name="end_at" class="form-control" required>
            </div>

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
                <label class="form-label">Driver</label>
                <select name="driver_id" class="form-select" required>
                    <option value="">Pilih Driver</option>
                    <?php foreach ($drivers as $driver) : ?>
                        <option value="<?= esc($driver['id']) ?>">
                            <?= esc($driver['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Approver Level 1</label>
                <select name="approver_level_1" class="form-select" required>
                    <option value="">Pilih Approver Level 1</option>
                    <?php foreach ($approverLevel1 as $approver) : ?>
                        <option value="<?= esc($approver['id']) ?>">
                            <?= esc($approver['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Approver Level 2</label>
                <select name="approver_level_2" class="form-select" required>
                    <option value="">Pilih Approver Level 2</option>
                    <?php foreach ($approverLevel2 as $approver) : ?>
                        <option value="<?= esc($approver['id']) ?>">
                            <?= esc($approver['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary-custom text-white px-4">
                Simpan Pemesanan
            </button>

            <a href="/bookings" class="btn btn-outline-secondary">
                Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
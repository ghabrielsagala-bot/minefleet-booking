<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'MineFleet Booking' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >

    <style>
        :root {
            --primary: #0f766e;
            --dark: #111827;
            --accent: #f59e0b;
            --bg: #f8fafc;
            --text: #374151;
        }

        body {
            background: var(--bg);
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text);
        }

        .sidebar {
            min-height: 100vh;
            background: var(--dark);
            position: sticky;
            top: 0;
        }

        .sidebar-brand {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: var(--primary);
            color: #fff;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar a {
            display: block;
            color: #d1d5db;
            text-decoration: none;
            padding: 12px 14px;
            border-radius: 12px;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .sidebar a:hover {
            background: #1f2937;
            color: #fff;
        }

        .sidebar a.active {
            background: var(--primary);
            color: #fff;
        }

        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.08);
        }

        .btn-primary-custom {
            background: var(--primary);
            border: none;
            border-radius: 12px;
        }

        .btn-primary-custom:hover {
            background: #115e59;
        }

        .badge-waiting {
            background: #f59e0b;
        }

        .badge-approved {
            background: #16a34a;
        }

        .badge-rejected {
            background: #dc2626;
        }

        .topbar {
            background: #fff;
            border-radius: 18px;
            padding: 18px 22px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.06);
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <aside class="col-md-3 col-lg-2 sidebar p-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="sidebar-brand">MF</div>
                <div>
                    <h5 class="text-white mb-0">MineFleet</h5>
                    <small class="text-secondary">Booking System</small>
                </div>
            </div>

            <a href="/dashboard">Dashboard</a>
            <a href="/bookings">Pemesanan</a>
            <a href="/approvals">Approval</a>
            <a href="/fuel-logs">Konsumsi BBM</a>
            <a href="/services">Jadwal Service</a>
            <a href="/usage-history">Riwayat Pemakaian</a>
            <a href="/reports">Laporan</a>

            <hr class="border-secondary">

            <a href="/logout" class="text-danger">Logout</a>
        </aside>

        <main class="col-md-9 col-lg-10 p-4">
            <div class="topbar mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1"><?= $title ?? 'MineFleet Booking' ?></h4>
                    <small class="text-muted">
                        Login sebagai <?= session()->get('name') ?> - <?= session()->get('role') ?>
                    </small>
                </div>

                <span class="badge bg-dark px-3 py-2">
                    <?= date('d M Y') ?>
                </span>
            </div>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?= $this->renderSection('scripts') ?>

</body>
</html>
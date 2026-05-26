<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - MineFleet Booking</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #111827, #0f766e);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border-radius: 24px;
            padding: 34px;
            box-shadow: 0 24px 60px rgba(0,0,0,0.25);
        }

        .brand-badge {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            background: #0f766e;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 800;
            font-size: 22px;
            margin-bottom: 24px;
        }

        .login-title {
            font-weight: 800;
            color: #111827;
            margin-bottom: 6px;
        }

        .login-subtitle {
            color: #6b7280;
            margin-bottom: 28px;
        }

        .form-label {
            font-weight: 600;
            color: #111827;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 14px;
            padding: 13px 16px;
            border: 1px solid #d1d5db;
        }

        .form-control:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 0.2rem rgba(15, 118, 110, 0.15);
        }

        .btn-primary-custom {
            background: #0f766e;
            border: none;
            border-radius: 14px;
            padding: 13px;
            font-weight: 600;
        }

        .btn-primary-custom:hover {
            background: #115e59;
        }

        .alert {
            border-radius: 14px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand-badge">MF</div>

    <h2 class="login-title">MineFleet Booking</h2>
    <p class="login-subtitle">
        Vehicle reservation and approval system
    </p>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form method="post" action="/login">
        <?= csrf_field() ?>

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input 
                type="text" 
                name="username" 
                class="form-control" 
                placeholder="Masukkan username"
                required
            >
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>
            <input 
                type="password" 
                name="password" 
                class="form-control" 
                placeholder="Masukkan password"
                required
            >
        </div>

        <button class="btn btn-primary-custom text-white w-100">
            Login
        </button>
    </form>
</div>

</body>
</html>
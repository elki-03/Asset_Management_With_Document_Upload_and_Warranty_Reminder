<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VS24 Asset</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>
    <body class="container mt-4">
        <nav class="navbar mb-4">
            <div class="container-fluid">
                <!-- Logo links -->
                <a class="navbar-brand" href="<?= base_url('/dashboard') ?>">
                    <img src="<?= base_url('/images/logo/logo.jpg') ?>" alt="logo" height="50">
                </a>

                <!-- Buttons rechts -->
                <div class="d-flex align-items-center gap-2 ms-auto">
                    <a href="<?= base_url('/dashboard') ?>">
                        <img src="<?= base_url('/images/dashboard_button.png') ?>" alt="Dashboard" height="40">
                    </a>
                    <form method="post" action="<?= base_url('logout') ?>">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-outline-secondary">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
        
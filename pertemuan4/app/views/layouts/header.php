
<?php $flash = take_flash(); ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?= isset($title) ? e($title) . ' - ' : '' ?><?= APP_NAME ?>
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <main class="container py-4">

        <?php if ($flash): ?>
            <div class="alert alert-<?= e($flash['type']) ?>">
                <?= e($flash['message']) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['user'])): ?>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <span class="text-muted">
                    Selamat datang, <?= e($_SESSION['user']['full_name']) ?>
                </span>

                <a href="<?= BASE_URL ?>/auth/logout"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Yakin ingin keluar?')">
                    Logout
                </a>
            </div>
        <?php endif; ?>

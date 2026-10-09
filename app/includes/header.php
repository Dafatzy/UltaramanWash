<?php require_once __DIR__.'/auth.php'; require_login(); ?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title ?? 'CarWashPro') ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
<div class="container-fluid">
<a class="navbar-brand fw-bold" href="/dashboard.php">🚗 UltramanWash</a>
<div class="text-white small"><?= e($_SESSION['user']['name']) ?> · <?= e($_SESSION['user']['role']) ?> · <a class="text-white" href="/logout.php">Logout</a></div>
</div>
</nav>
<div class="container-fluid">
<div class="row">
<aside class="col-md-2 sidebar p-3">
<a href="/dashboard.php">Dashboard</a>
<?php if ($_SESSION['user']['role']==='admin'): ?>
<a href="/admin/services.php">Layanan</a>
<a href="/admin/customers.php">Pelanggan</a>
<a href="/admin/users.php">Petugas</a>
<a href="/admin/transactions.php">Transaksi</a>
<a href="/admin/reports.php">Laporan</a>
<?php elseif ($_SESSION['user']['role']==='cashier'): ?>
<a href="/cashier/customers.php">Pelanggan</a>
<a href="/cashier/vehicles.php">Kendaraan</a>
<a href="/cashier/transaction_add.php">Transaksi Baru</a>
<a href="/cashier/payment.php">Pembayaran</a>
<a href="/cashier/history.php">Riwayat</a>
<?php elseif ($_SESSION['user']['role']==='washer'): ?>
<a href="/washer/queue.php">Antrian</a>
<a href="/washer/washing.php">Sedang Dicuci</a>
<a href="/washer/completed.php">Selesai</a>
<?php endif; ?>
</aside>
<main class="col-md-10 p-4">

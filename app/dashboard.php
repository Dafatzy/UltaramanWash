<?php
require_once __DIR__.'/config/database.php'; require_once __DIR__.'/includes/auth.php'; require_login();
$title='Dashboard';
$customers=(int)$pdo->query("SELECT COUNT(*) FROM customers")->fetchColumn();
$vehicles=(int)$pdo->query("SELECT COUNT(*) FROM vehicles")->fetchColumn();
$transactions=(int)$pdo->query("SELECT COUNT(*) FROM transactions")->fetchColumn();
$queue=(int)$pdo->query("SELECT COUNT(*) FROM transactions WHERE status IN ('waiting','washing','finishing')")->fetchColumn();
$income=(float)$pdo->query("SELECT COALESCE(SUM(total),0) FROM transactions WHERE payment_status='paid'")->fetchColumn();
require __DIR__.'/includes/header.php';
?>
<h2 class="fw-bold mb-4">Dashboard</h2>
<div class="row g-3 mb-4">
<?php foreach([['Pelanggan',$customers,'👥'],['Kendaraan',$vehicles,'🚘'],['Transaksi',$transactions,'🧾'],['Antrian',$queue,'🧽'],['Pendapatan','Rp '.number_format($income,0,',','.'),'💰']] as $s): ?>
<div class="col-md"><div class="card card-stat shadow-sm"><div class="card-body"><div class="text-muted"><?=$s[2]?> <?=$s[0]?></div><h3 class="fw-bold"><?=$s[1]?></h3></div></div></div>
<?php endforeach; ?>
</div>
<div class="card shadow-sm border-0"><div class="card-body"><h5>UltramanWash</h5><p class="mb-0">Pelanggan → Kendaraan → Transaksi → Antrian → Pencucian → Pembayaran → Riwayat</p></div></div>
<?php require __DIR__.'/includes/footer.php'; ?>

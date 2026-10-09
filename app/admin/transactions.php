<?php
require_once __DIR__.'/../config/database.php'; require_once __DIR__.'/../includes/auth.php'; require_role('admin');$title='Transaksi';
$rows=$pdo->query("SELECT t.*,c.name customer,v.plate_number FROM transactions t JOIN customers c ON c.id=t.customer_id JOIN vehicles v ON v.id=t.vehicle_id ORDER BY t.id DESC")->fetchAll();require __DIR__.'/../includes/header.php';?>
<h2>Semua Transaksi</h2><div class="card shadow-sm"><div class="card-body"><table class="table"><tr><th>Invoice</th><th>Pelanggan</th><th>Plat</th><th>Total</th><th>Status</th><th>Pembayaran</th></tr><?php foreach($rows as $r):?><tr><td><?=e($r['invoice_number'])?></td><td><?=e($r['customer'])?></td><td><?=e($r['plate_number'])?></td><td>Rp <?=number_format($r['total'],0,',','.')?></td><td><?=e($r['status'])?></td><td><?=e($r['payment_status'])?></td></tr><?php endforeach;?></table></div></div>
<?php require __DIR__.'/../includes/footer.php';?>

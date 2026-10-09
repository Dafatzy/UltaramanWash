<?php
require_once __DIR__.'/../config/database.php';require_once __DIR__.'/../includes/auth.php';require_role('cashier');
$title='Transaksi Baru';
$customers=$pdo->query("SELECT * FROM customers ORDER BY name")->fetchAll();
$vehicles=$pdo->query("SELECT v.*,c.name customer FROM vehicles v JOIN customers c ON c.id=v.customer_id ORDER BY c.name")->fetchAll();
$services=$pdo->query("SELECT * FROM services ORDER BY vehicle_type,name")->fetchAll();
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
 $cid=(int)$_POST['customer_id'];$vid=(int)$_POST['vehicle_id'];$sid=(int)$_POST['service_id'];
 $s=$pdo->prepare("SELECT * FROM services WHERE id=?");$s->execute([$sid]);$svc=$s->fetch();
 if(!$svc){$error='Layanan tidak ditemukan.';}else{
  $invoice='INV-'.date('YmdHis').'-'.random_int(10,99);
  $pdo->beginTransaction();
  try{$pdo->prepare("INSERT INTO transactions(invoice_number,customer_id,vehicle_id,total)VALUES(?,?,?,?)")->execute([$invoice,$cid,$vid,$svc['price']]);$tid=$pdo->lastInsertId();$pdo->prepare("INSERT INTO transaction_details(transaction_id,service_id,price)VALUES(?,?,?)")->execute([$tid,$sid,$svc['price']]);$pdo->commit();header('Location:/cashier/payment.php?invoice='.urlencode($invoice));exit;}catch(Exception $e){$pdo->rollBack();$error=$e->getMessage();}
 }}
require __DIR__.'/../includes/header.php';?><h2>Transaksi Baru</h2><?php if($error):?><div class="alert alert-danger"><?=e($error)?></div><?php endif;?><div class="card"><div class="card-body"><form method="post" class="row g-3">
<div class="col-md-4"><label>Pelanggan</label><select name="customer_id" class="form-select" required><?php foreach($customers as $c):?><option value="<?=$c['id']?>"><?=e($c['name'])?></option><?php endforeach;?></select></div>
<div class="col-md-4"><label>Kendaraan</label><select name="vehicle_id" class="form-select" required><?php foreach($vehicles as $v):?><option value="<?=$v['id']?>"><?=e($v['customer'])?> - <?=e($v['plate_number'])?> (<?=$v['vehicle_type']?>)</option><?php endforeach;?></select></div>
<div class="col-md-4"><label>Layanan</label><select name="service_id" class="form-select" required><?php foreach($services as $s):?><option value="<?=$s['id']?>"><?=e($s['name'])?> - <?=$s['vehicle_type']?> - Rp <?=number_format($s['price'],0,',','.')?></option><?php endforeach;?></select></div>
<div><button class="btn btn-success">Buat Transaksi</button></div></form></div></div><?php require __DIR__.'/../includes/footer.php';?>

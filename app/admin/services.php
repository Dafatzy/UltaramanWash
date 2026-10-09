<?php
require_once __DIR__.'/../config/database.php'; require_once __DIR__.'/../includes/auth.php'; require_role('admin');
$title='Kelola Layanan';
if(isset($_GET['delete'])){$pdo->prepare("DELETE FROM services WHERE id=?")->execute([(int)$_GET['delete']]);header('Location:/admin/services.php');exit;}
if($_SERVER['REQUEST_METHOD']==='POST'){
 $id=(int)($_POST['id']??0); $data=[trim($_POST['name']),$_POST['vehicle_type'],(float)$_POST['price'],(int)$_POST['duration'],trim($_POST['description'])];
 if($id){$pdo->prepare("UPDATE services SET name=?,vehicle_type=?,price=?,duration=?,description=? WHERE id=?")->execute([...$data,$id]);}
 else{$pdo->prepare("INSERT INTO services(name,vehicle_type,price,duration,description) VALUES(?,?,?,?,?)")->execute($data);}
 header('Location:/admin/services.php');exit;
}
$edit=null;if(isset($_GET['edit'])){$s=$pdo->prepare("SELECT * FROM services WHERE id=?");$s->execute([(int)$_GET['edit']]);$edit=$s->fetch();}
$rows=$pdo->query("SELECT * FROM services ORDER BY id DESC")->fetchAll(); require __DIR__.'/../includes/header.php';
?>
<div class="d-flex justify-content-between"><h2>Layanan</h2><a class="btn btn-dark" href="?new=1">+ Tambah Layanan</a></div>
<?php if(isset($_GET['new'])||$edit): ?><div class="card my-3"><div class="card-body"><form method="post" class="row g-2">
<input type="hidden" name="id" value="<?=e($edit['id']??0)?>"><div class="col-md-4"><label>Nama</label><input class="form-control" name="name" value="<?=e($edit['name']??'')?>" required></div>
<div class="col-md-2"><label>Kendaraan</label><select class="form-select" name="vehicle_type"><option>Mobil</option><option <?=($edit['vehicle_type']??'')==='Motor'?'selected':''?>>Motor</option></select></div>
<div class="col-md-2"><label>Harga</label><input type="number" class="form-control" name="price" value="<?=e($edit['price']??'')?>" required></div>
<div class="col-md-2"><label>Durasi (menit)</label><input type="number" class="form-control" name="duration" value="<?=e($edit['duration']??30)?>" required></div>
<div class="col-md-12"><label>Deskripsi</label><textarea class="form-control" name="description"><?=e($edit['description']??'')?></textarea></div>
<div><button class="btn btn-success">Simpan</button> <a class="btn btn-secondary" href="services.php">Batal</a></div></form></div></div><?php endif; ?>
<div class="card shadow-sm"><div class="card-body"><div class="table-responsive"><table class="table"><thead><tr><th>ID</th><th>Nama</th><th>Kendaraan</th><th>Harga</th><th>Durasi</th><th>Aksi</th></tr></thead><tbody>
<?php foreach($rows as $r): ?><tr><td><?=$r['id']?></td><td><?=e($r['name'])?></td><td><?=$r['vehicle_type']?></td><td>Rp <?=number_format($r['price'],0,',','.')?></td><td><?=$r['duration']?> mnt</td><td><a class="btn btn-sm btn-warning" href="?edit=<?=$r['id']?>">Edit</a> <a class="btn btn-sm btn-danger" onclick="return confirm('Hapus layanan?')" href="?delete=<?=$r['id']?>">Hapus</a></td></tr><?php endforeach; ?>
</tbody></table></div></div></div>
<?php require __DIR__.'/../includes/footer.php'; ?>

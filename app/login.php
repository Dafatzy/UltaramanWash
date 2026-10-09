<?php
require_once __DIR__.'/config/database.php';
require_once __DIR__.'/includes/auth.php';
if (!empty($_SESSION['user'])) { header('Location:/dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $stmt=$pdo->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
    $stmt->execute([trim($_POST['username'] ?? '')]);
    $u=$stmt->fetch();
    if ($u && hash_equals($u['password'], $_POST['password'] ?? '')) {
        $_SESSION['user']=['id'=>$u['id'],'name'=>$u['name'],'username'=>$u['username'],'role'=>$u['role']];
        header('Location:/dashboard.php'); exit;
    }
    $error='Username atau password salah.';
}
?>
<!doctype html><html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login - UltramanWash</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="/assets/css/style.css" rel="stylesheet"></head>
<body class="login-bg d-flex align-items-center"><div class="container"><div class="row justify-content-center"><div class="col-md-5">
<div class="card shadow-lg border-0"><div class="card-body p-4">
<h2 class="fw-bold text-center">🚗 UltramanWash</h2><p class="text-center text-muted">Sistem Manajemen Cuci Kendaraan</p>
<?php if($error): ?><div class="alert alert-danger"><?=e($error)?></div><?php endif; ?>
<form method="post"><label class="form-label">Username</label><input name="username" class="form-control mb-3" required>
<label class="form-label">Password</label><input name="password" type="password" class="form-control mb-3" required>
<button class="btn btn-dark w-100">Login</button></form>
</div></div></div></div></div></body></html>

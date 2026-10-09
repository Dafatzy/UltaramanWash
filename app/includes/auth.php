<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function require_login() {
    if (empty($_SESSION['user'])) {
        header('Location: /login.php');
        exit;
    }
}

function require_role($roles) {
    require_login();
    $roles = (array)$roles;
    if (!in_array($_SESSION['user']['role'], $roles, true)) {
        http_response_code(403);
        exit('403 - Anda tidak memiliki akses ke halaman ini.');
    }
}

function e($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

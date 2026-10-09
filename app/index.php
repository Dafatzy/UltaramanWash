<?php
session_start();
if (!empty($_SESSION['user'])) { header('Location: /dashboard.php'); exit; }
header('Location: /login.php'); exit;

<?
session_start();
$admin_login = $_SESSION['admin_login'];
if ($admin_login !== true) {
  header('Location:/admin/page/login.php');
} else {
  header('Location:/admin/page/report/report.php');
}

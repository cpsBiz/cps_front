<?
session_start();
$admin_login = $_SESSION['admin_login'];
if ($admin_login !== true) {
  header('Location:/page/login.php');
} else {
  header('Location:/page/report/report.php');
}

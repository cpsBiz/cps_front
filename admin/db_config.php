<?
session_start();
$admin_login = $_SESSION['admin_login'];
if (!$admin_login) {
  header('Location:/500.php');
  exit;
}

// 데이터베이스 연결 정보
$host = '192.168.3.15:3306';
$username = 'CPS';
$password = 'Emfla2017!@#';
$database = 'CPS';

// MySQL 데이터베이스 연결
$con = mysqli_connect($host, $username, $password, $database);

// 연결 확인
if (!$con) {
  die('MySQL 연결 실패: ' . mysqli_connect_error());
  header('Location:/500.php');
}
mysqli_set_charset($con, 'utf8');

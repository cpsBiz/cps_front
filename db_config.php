<?
$host = '192.168.150.61:3306';
$username = 'dhhan';
$password = 'dhhan@enliple.com';
$database = 'CPS';

$con = mysqli_connect($host, $username, $password, $database);

if (!$con) {
  die('MySQL 연결 실패: ' . mysqli_connect_error());
}

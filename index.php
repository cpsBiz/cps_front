<?
$userId = $_REQUEST['userId'];
$adId = $_REQUEST['adId'];
$affliateId = $_REQUEST['affliateId'];
$site = $_REQUEST['site'];
$zoneId = $_REQUEST['zoneId'];

if ($userId && $adId && $affliateId && $site && $zoneId) {
  session_start();
  $_SESSION['check_userId'] = $userId;
  $_SESSION['check_adId'] = $adId;
  $_SESSION['check_affliateId'] = $affliateId;
  $_SESSION['check_site'] = $site;
  $_SESSION['check_zoneId'] = $zoneId;

  header('location:/view/index.php');
} else {
?>
  <script>
    alert('필수 값이 없습니다. 종료 후 다시 시도해 주세요.')
  </script>
<?
  exit;
}
?>
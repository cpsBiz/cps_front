<? include_once $_SERVER['DOCUMENT_ROOT'] . '/isTest.php'; ?>
<?
if ($isTest) {
  $checkUserId = 'test';
  $checkAdId = 'test';
  $checkAffliateId = 'donsee';
  $checkSite = 'test';
  $checkZoneId =  'test';

  $apiUrl = 'http://192.168.101.156';
} else {
  $userId = $_REQUEST['userId'];
  $adId = $_REQUEST['adId'];
  $affliateId = $_REQUEST['affliateId'];
  $site = $_REQUEST['site'];
  $zoneId = $_REQUEST['zoneId'];

  session_start();
  if ($userId && $adId && $affliateId && $site && $zoneId) {
    $_SESSION['check_userId'] = $userId;
    $_SESSION['check_adId'] = $adId;
    $_SESSION['check_affliateId'] = $affliateId;
    $_SESSION['check_site'] = $site;
    $_SESSION['check_zoneId'] = $zoneId;
  }

  $checkUserId = $_SESSION['check_userId'];
  $checkAdId = $_SESSION['check_adId'];
  $checkAffliateId = $_SESSION['check_affliateId'];
  $checkSite = $_SESSION['check_site'];
  $checkZoneId =  $_SESSION['check_zoneId'];

  $adminApiUrl = 'https://admin.shoplus.io';
  $appApiUrl = 'https://app.shoplus.io';

  if (!$checkUserId || !$checkAdId || !$checkAffliateId || !$checkSite || !$checkZoneId) {
?>
    <script>
      alert('필수 값이 없습니다. 다시 시도해 주세요.');
      HybridApp.close();
    </script>
<?
    exit;
  }
}
?>
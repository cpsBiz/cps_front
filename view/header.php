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
  session_start();
  $checkUserId = $_SESSION['check_userId'];
  $checkAdId = $_SESSION['check_adId'];
  $checkAffliateId = $_SESSION['check_affliateId'];
  $checkSite = $_SESSION['check_site'];
  $checkZoneId =  $_SESSION['check_zoneId'];

  $adminApiUrl = 'https://admin.shoplus.io';
  $appApiUrl = 'https://app.shoplus.io';
}

$origin = $_SERVER['HTTP_ORIGIN'];
$allowed_origins = ['https://app.shoplus.io', 'https://admin.shoplus.io'];

if (in_array($origin, $allowed_origins)) {
  header("Access-Control-Allow-Origin: " . $origin);
}
?>
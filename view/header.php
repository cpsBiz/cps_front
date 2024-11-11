<? include_once $_SERVER['DOCUMENT_ROOT'] . '/isTest.php'; ?>
<?
if ($isTest) {
  $checkUserId = 'test';
  $checkAdId = 'test';
  $checkAffliateId = 'donsee';
  $checkSite = 'test';
  $checkZoneId =  'test';

  $appApiUrl = 'http://192.168.101.156';
} else {
  session_start();

  $checkUserId = $_SESSION['check_userId'];
  $checkAdId = $_SESSION['check_adId'];
  $checkAffliateId = $_SESSION['check_affliateId'];
  $checkSite = $_SESSION['check_site'];
  $checkZoneId =  $_SESSION['check_zoneId'];

  $appApiUrl = 'https://app.shoplus.io';
}

$cacheVersion = 1.0;
?>
<link rel="icon" type="image/x-icon" href="https://app.shoplus.io/images/favicon.ico">
<script type="text/javascript" src="https://app.shoplus.io/js/lib/jquery-2.2.2.min.js?version=<?= $cacheVersion; ?>"></script>
<script type="text/javascript" src="https://app.shoplus.io/js/lib/jquery.easing.1.3.js?version=<?= $cacheVersion; ?>"></script>
<script type="text/javascript" src="https://app.shoplus.io/js/lib/jquery-ui.min.js?version=<?= $cacheVersion; ?>"></script>
<style>
  .loadingBg {
    position: fixed;
    display: none;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgba(0, 0, 0, 0);
    z-index: 99999;
    width: 100%;
    height: 100%;
  }
</style>
<div id="loading-spinner" class="loadingBg"></div>
<script>
  $(document).ajaxStart(function() {
    $('#loading-spinner').show();
  });

  // 모든 AJAX 요청이 끝나면 로딩 스피너 숨김
  $(document).ajaxStop(function() {
    $('#loading-spinner').hide();
  });
</script>
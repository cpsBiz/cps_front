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

?>
<link rel="icon" type="image/x-icon" src="../images/favicon.ico">
<script type="text/javascript" src="../js/lib/jquery-2.2.2.min.js"></script>
<script type="text/javascript" src="../js/lib/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../js/lib/jquery-ui.min.js"></script>
<!-- <style>
  .loadingBg {
    position: fixed;
    display: block;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.7);
    z-index: 99999;
  }

  .loadingBg p:before {
    content: '';
    position: relative;
    display: inline-block;
    background-position: 0px 0px;
    font-size: 0;
    font-style: normal;
    vertical-align: middle;
    background: url(https://app.shoplus.io/images/loading/ico_loadingCircle.gif) no-repeat center;
    content: '';
    display: block;
    width: 100px;
    height: 80px;
    margin: 0 auto 40px;
    background-size: 100px 80px;
    -webkit-animation: rotationLoading 1.2s infinite steps(9);
    animation: rotationLoading 1.2s infinite steps(9);
  }

  .loadingBg p {
    position: absolute;
    top: calc(50% - 70px);
    width: 100%;
    text-align: center;
    font-size: 18px;
    line-height: 1.5;
    color: #ffffff;
    z-index: 9999;
  }

  .loadingBg p b {
    display: block;
    margin-bottom: 10px;
    font-size: 18px;
  }
</style>
<div id="loading-spinner" class="loadingBg" style="display: none;">
  <p><b>Loading</b>잠시만 기다려 주세요.</p>
</div>
<script>
  $(document).ajaxStart(function() {
    $('#loading-spinner').show();
  });

  // 모든 AJAX 요청이 끝나면 로딩 스피너 숨김
  $(document).ajaxStop(function() {
    $('#loading-spinner').hide();
  });
</script> -->
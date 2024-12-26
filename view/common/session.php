<script>
  const storageItems = ['mainPageScroll', 'cartMainPageScroll', 'cartSalePageScroll'];
  storageItems.forEach(item => localStorage.removeItem(item));
</script>
<?
if (!$isTest) {
  $userId = $_REQUEST['userId'];
  $adId = $_REQUEST['adId'];
  $affliateId = $_REQUEST['affliateId'];
  $site = $_REQUEST['site'];
  $zoneId = $_REQUEST['zoneId'];
  $fcmToken = $_REQUEST['fcmToken'];
  $type = $_REQUEST['type'];
  $productCode = $_REQUEST['productCode'];
  $optionCode = $_REQUEST['optionCode'];
  $merchantId = $_REQUEST['merchantId'];

  if ($userId && $adId && $affliateId && $site && $zoneId) {
    session_start();
    $_SESSION['check_userId'] = $userId;
    $_SESSION['check_adId'] = $adId;
    $_SESSION['check_affliateId'] = $affliateId;
    $_SESSION['check_site'] = $site;
    $_SESSION['check_zoneId'] = $zoneId;
    $_SESSION['check_fcmToken'] = $fcmToken;

    if ($type === 'push' && $productCode && $optionCode && $merchantId) {
      header('Location:https://app.shoplus.io/cart/detail.php?productCode=' . $productCode . '&optionCode=' . $optionCode . '&merchantId=' . $merchantId);
      exit;
    }
?>
    <? include_once $_SERVER['DOCUMENT_ROOT'] . '/common/token.php'; ?>
    <script>
      $(function() {
        <? if ($fcmToken) { ?>
          setToken();
        <? } else { ?>
          successToken('N');
        <? } ?>
      })
    </script>
  <?
  } else {
  ?>
    <script>
      alert('필수 값이 없습니다. 다시 시도해 주세요.');
      HybridApp.close();
    </script>
  <?
    exit;
  }
} else {
  $userId = 'test';
  $adId = 'test';
  $affliateId = 'donsee';
  $fcmToken = 'test';
  ?>
  <? include_once $_SERVER['DOCUMENT_ROOT'] . '/common/token.php'; ?>
  <script>
    $(function() {
      setToken();
    })
  </script>
<?
}
?>
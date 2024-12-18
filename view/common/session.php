<script>
  localStorage.removeItem('mainPageScroll');
  localStorage.removeItem('cartMainPageScroll');
  localStorage.removeItem('cartSalePageScroll');
</script>
<?
if (!$isTest) {
  $userId = $_REQUEST['userId'];
  $adId = $_REQUEST['adId'];
  $affliateId = $_REQUEST['affliateId'];
  $site = $_REQUEST['site'];
  $zoneId = $_REQUEST['zoneId'];
  $fcmToken = $_REQUEST['fcmToken'];

  if ($userId && $adId && $affliateId && $site && $zoneId && $fcmToken) {
    session_start();
    $_SESSION['check_userId'] = $userId;
    $_SESSION['check_adId'] = $adId;
    $_SESSION['check_affliateId'] = $affliateId;
    $_SESSION['check_site'] = $site;
    $_SESSION['check_zoneId'] = $zoneId;
    $_SESSION['check_fcmToken'] = $fcmToken;
?>
    <script src="https://cdn.shoplus.io/js/common.js"></script>
    <script>
      function setToken() {
        try {
          const requestData = {
            userId: '<?= $userId; ?>',
            affliateId: '<?= $affliateId; ?>',
            adId: '<?= $adId; ?>',
            token: '<?= $fcmToken; ?>',
            os: getOs(),
            userName: '',
            userEmail: '',
            userPhone: ''
          }

          $.ajax({
            async: false,
            type: 'POST',
            url: 'https://app.shoplus.io/api/common/cpsUser',
            contentType: 'application/json',
            data: JSON.stringify(requestData),
            success: function(result) {
              if (result.resultCode === '0000') {
                successToken(result.data.firstLogin);
              } else {
                console.log(`${result.resultCode}/${result.resultMessage}`);
              }
            },
            error: function(request, status, error) {
              console.error(`Error: ${error}`);
            }
          });
        } catch (error) {
          alert(error);
        }
      }

      function successToken(firstLogin) {
        const host = window.location.hostname;
        if (host.includes('/cart/index.php') && firstLogin === 'Y') {
          checkCartAgree();
        }
      }
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
}
?>
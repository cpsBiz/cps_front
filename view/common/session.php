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
    }
?>
    <script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery-2.2.2.min.js"></script>
    <script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery-ui.min.js"></script>
    <script src="https://cdn.shoplus.io/js/common.js"></script>
    <script>
      $(function() {
        <? if ($fcmToken) { ?>
          setToken();
        <? } else { ?>
          successToken('N');
        <? } ?>
      })


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
        } else {
          location.replace('https://app.shoplus.io/main.php');
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
} else {
  $userId = 'test';
  $adId = 'test';
  $affliateId = 'donsee';
  $fcmToken = 'test';
  ?>
  <script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery-2.2.2.min.js"></script>
  <script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery-ui.min.js"></script>
  <script src="https://cdn.shoplus.io/js/common.js"></script>
  <script>
    $(function() {
      setToken();
    })

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
          url: 'https://testapp.shoplus.io/api/common/cpsUser',
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
      } else {
        location.replace('https://testapp.shoplus.io/main.php');
      }
    }
  </script>
<?
}
?>
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
  $linkCase = $_REQUEST['linkCase'];
  $appYn = $_REQUEST['appYn'] ?? 'N';
  $object = $_REQUEST['object'];

  if ($userId && $adId && $affliateId && $site && $zoneId) {
    if ($affliateId === 'donsee') $affliateId = 'ENLIPLE';

    session_start();
    $_SESSION['check_userId'] = $userId;
    $_SESSION['check_adId'] = $adId;
    $_SESSION['check_affliateId'] = $affliateId;
    $_SESSION['check_site'] = $site;
    $_SESSION['check_zoneId'] = $zoneId;
    $_SESSION['check_fcmToken'] = $fcmToken;
    $_SESSION['check_appYn'] = $appYn;

    if ($type === 'push' && $productCode && $optionCode && $merchantId) {
      header('Location:https://app.shoplus.io/cart/detail.php?productCode=' . $productCode . '&optionCode=' . $optionCode . '&merchantId=' . $merchantId);
      exit;
    } elseif ($type === 'share' && $productCode && $optionCode && $merchantId && $linkCase) {
      header('Location:https://app.shoplus.io/cart/detail.php?productCode=' . $productCode . '&optionCode=' . $optionCode . '&merchantId=' . $merchantId . '&type=share&linkCase=' . $linkCase);
      exit;
    } elseif ($type === 'autoReward' && $object) {
?>
      <script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery-2.2.2.min.js"></script>
      <script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery.easing.1.3.js"></script>
      <script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery-ui.min.js"></script>
      <script src="https://app.shoplus.io/js/common.js"></script>
      <script>
        const object = decodeFromBase64(`<?= $object ?>`);
        $(function() {
          checkParam(object);
        })

        function checkParam(object) {
          let item = object;

          if (!item.apiUrl || !item.clickUrl || !item.campaignNum || !item.agencyId || !item.merchantId ||
            !item.userCommissionShare || !item.affliateCommissionShare || !item.commissionMobile) {
            alert('필수 값이 없습니다. 다시 시도해 주세요.');
            HybridApp.close();
            return;
          }

          const per = (
            (item.commissionMobile *
              ((item.affliateCommissionShare * item.userCommissionShare) / 100)) /
            100
          ).toFixed(2);

          item.per = per;

          delete item.commissionMobile;
          delete item.affliateCommissionShare;
          delete item.userCommissionShare;

          const itemStr = base64Encode(JSON.stringify(item));

          location.href = `https://app.shoplus.io/reward/campaign.php?object=${itemStr}&type=autoReward`;
        }
      </script>
    <?

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
  $affliateId = 'ENLIPLE';
  $site = 'donsee';
  $fcmToken = 'donsee';
  $appYn = 'N';

  $type = $_REQUEST['type'];
  $productCode = $_REQUEST['productCode'];
  $optionCode = $_REQUEST['optionCode'];
  $merchantId = $_REQUEST['merchantId'];
  $linkCase = $_REQUEST['linkCase'];
  $object = $_REQUEST['object'];

  if ($type === 'push' && $productCode && $optionCode && $merchantId) {
    header('Location:https://testapp.shoplus.io/cart/detail.php?productCode=' . $productCode . '&optionCode=' . $optionCode . '&merchantId=' . $merchantId);
    exit;
  } elseif ($type === 'share' && $productCode && $optionCode && $merchantId && $linkCase) {
    header('Location:https://testapp.shoplus.io/cart/detail.php?productCode=' . $productCode . '&optionCode=' . $optionCode . '&merchantId=' . $merchantId . '&type=share&linkCase=' . $linkCase);
    exit;
  } elseif ($type === 'autoReward' && $object) {
  ?>
    <script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery-2.2.2.min.js"></script>
    <script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery-ui.min.js"></script>
    <script src="https://testapp.shoplus.io/js/common.js"></script>
    <script>
      const object = decodeFromBase64(`<?= $object ?>`);
      $(function() {
        checkParam(object);
      })

      function checkParam(object) {
        let item = object;

        if (!item.apiUrl || !item.clickUrl || !item.campaignNum || !item.agencyId || !item.merchantId ||
          !item.userCommissionShare || !item.affliateCommissionShare || !item.commissionMobile) {
          alert('필수 값이 없습니다. 다시 시도해 주세요.');
          HybridApp.close();
          return;
        }

        const per = (
          (item.commissionMobile *
            ((item.affliateCommissionShare * item.userCommissionShare) / 100)) /
          100
        ).toFixed(2);

        item.per = per;

        delete item.commissionMobile;
        delete item.affliateCommissionShare;
        delete item.userCommissionShare;

        const itemStr = base64Encode(JSON.stringify(item));

        location.href = `https://testapp.shoplus.io/reward/campaign.php?object=${itemStr}&type=autoReward`;
      }
    </script>
  <?
    exit;
  }
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
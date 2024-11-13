<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<?
$productCode = $_REQUEST[''];
$optionCode = $_REQUEST[''];
$productPrice = $_REQUEST[''];
$merchantId = $_REQUEST[''];
?>
<script>
  <?
  if (!$productCode || !$optionCode || !$productPrice || !$checkUserId || !$checkAffliateId || !$checkAdId) {
  ?>
    alert('상품 추가를 실패했습니다. 다시 시도해 주세요.');
    location.replace('/main.php');
  <?
  } else {
  ?>

    function addCart() {
      try {
        const requestData = {
          userId: '<?= $checkUserId; ?>',
          affliateId: '<?= $checkAffliateId; ?>',
          merchantId: '<?= $merchantId; ?>',
          apiType: 'I',
          productList: [{
            productCode: '<?= $productCode; ?>',
            optionCode: '<?= $optionCode; ?>',
            favorites: '',
            cartPrice: <?= $productPrice; ?>,
            wantPrice: 0,
            alarm: '',
            returnalarm: '',
            adId: '<?= $checkAdId; ?>'
          }]
        }

        $.ajax({
          type: 'POST',
          url: '<?= $appApiUrl; ?>/api/cart/cartProduct',
          contentType: 'application/json',
          data: JSON.stringify(requestData),
          success: function(result) {
            if (result.resultCode !== '0000') alert('상품 추가를 실패했습니다. 다시 시도해 주세요.');
            location.replace('/main.php');
          },
          error: function(request, status, error) {
            console.error(`Error: ${error}`);
          }
        });
      } catch (error) {
        alert(error);
      }
    }
  <?
  }
  ?>
</script>
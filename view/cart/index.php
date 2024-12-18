<? include_once $_SERVER['DOCUMENT_ROOT'] . '/isTest.php'; ?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . '/common/session.php'; ?>
<script>
  function checkCartAgree() {

  }
</script>
<?
if ($isTest) header('Location:https://testapp.shoplus.io/cart/main.php');
else header('Location:https://app.shoplus.io/cart/main.php');
?>
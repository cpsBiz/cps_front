<? include_once $_SERVER['DOCUMENT_ROOT'] . '/isTest.php'; ?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . '/common/session.php'; ?>
<?
if ($isTest) header('Location:https://testapp.shoplus.io/main.php');
else header('Location:https://app.shoplus.io/main.php');
?>
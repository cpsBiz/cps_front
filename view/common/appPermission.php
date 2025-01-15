<?
$appYn = $_REQUEST['appYn'];
if ($appYn !== '' && $appYn !== null) {
  $_SESSION['check_appYn'] = $appYn;
}

$prevPage = $_SERVER['HTTP_REFERER'];
header('location:' . $prevPage);

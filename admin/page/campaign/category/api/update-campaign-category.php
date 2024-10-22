<? include_once $_SERVER['DOCUMENT_ROOT'] . "/db_config.php"; ?>
<?
$C = $_POST[''];
if (!$campaignNum) {
  $json_data['resultCode'] = 'fail';
  $json_data['resultMessage'] = '변경사항저장실패';
  echo json_encode($json_data);
  exit;
}

$sql = "

        ";
$stmt = mysqli_stmt_init($con);
if (mysqli_stmt_prepare($stmt, $sql)) {
  mysqli_stmt_bind_param($stmt, 'i', $C);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  $i = 0;
  $json_data['datas'] = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $json_data['datas'][$i][''] = $row[''];
    $json_data['datas'][$i][''] = $row[''];
    $i++;
  }

  if ($i == 0) {
    $json_data['resultCode'] = 'fail';
    $json_data['resultMessage'] = '변경사항저장실패';
  } else {
    $json_data['resultCode'] = 'success';
    $json_data['resultMessage'] = '변경사항저장성공';
  }

  echo json_encode($json_data);
  mysqli_stmt_close($stmt);
  exit;
}
?>
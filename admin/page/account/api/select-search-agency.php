<? include_once $_SERVER['DOCUMENT_ROOT'] . "/db_config.php"; ?>
<?
$agency = $_GET['agency'];
if (!$agency) {
  $json_data['resultCode'] = 'fail';
  $json_data['resultMessage'] = '대행사명을 입력해 주세요.';
  echo json_encode($json_data);
  exit;
}

$sql = "
        SELECT
          MEMBER_ID
        FROM CPS_MEMBER
        WHERE
          MEMBER_NAME = ?
        ";
$stmt = mysqli_stmt_init($con);
if (mysqli_stmt_prepare($stmt, $sql)) {
  mysqli_stmt_bind_param($stmt, 's', $agency);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  while ($row = mysqli_fetch_assoc($result)) {
    $agencyId = $row['MEMBER_ID'];
  }

  if (!$agencyId) {
    $json_data['resultCode'] = 'fail';
    $json_data['resultMessage'] = '존재하지 않는 대행사입니다.';
  } else {
    $json_data['resultCode'] = 'success';
    $json_data['resultMessage'] = '등록 가능한 대행사입니다.';
    $json_data['agencyId'] = $agencyId;
  }

  echo json_encode($json_data);
  mysqli_stmt_close($stmt);
  exit;
}
?>
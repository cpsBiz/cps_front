<? include_once $_SERVER['DOCUMENT_ROOT'] . "/db_config.php"; ?>
<?
$id = $_GET['id'];
if (!$id) {
  $json_data['resultCode'] = 'fail';
  $json_data['resultMessage'] = '아이디를 입력해 주세요.';
  echo json_encode($json_data);
  exit;
}

$sql = "
        SELECT
          COUNT(*) AS CNT
        FROM CPS_MEMBER
        WHERE
          MEMBER_ID = ?
        ";
$stmt = mysqli_stmt_init($con);
if (mysqli_stmt_prepare($stmt, $sql)) {
  mysqli_stmt_bind_param($stmt, 's', $id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $cnt);
  mysqli_stmt_fetch($stmt);

  if ($cnt == 0) {
    $json_data['resultCode'] = 'success';
    $json_data['resultMessage'] = '사용 가능한 아이디입니다.';
  } else {
    $json_data['resultCode'] = 'fail';
    $json_data['resultMessage'] = '이미 존재하는 아이디입니다.';
  }

  echo json_encode($json_data);
  mysqli_stmt_close($stmt);
  exit;
}
?>
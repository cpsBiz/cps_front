<? include_once $_SERVER['DOCUMENT_ROOT'] . "/db_config.php"; ?>
<?
$campaignNum = $_GET['campaignNum'];
if (!$campaignNum) {
  $json_data['resultCode'] = 'fail';
  $json_data['resultMessage'] = '조회실패';
  echo json_encode($json_data);
  exit;
}

$sql = "
        SELECT 
          A.CATEGORY, A.CATEGORY_NAME, A.CATEGORY_RANK, 
          (SELECT COUNT(*) FROM CPS_CAMPAIGN_RANK B WHERE B.CAMPAIGN_NUM = ? AND CATEGORY = A.CATEGORY) AS CNT 
        FROM CPS_CATEGORY A
        HAVING CNT = 0
        ORDER BY CAST(A.CATEGORY_RANK AS UNSIGNED) ASC
        ";
$stmt = mysqli_stmt_init($con);
if (mysqli_stmt_prepare($stmt, $sql)) {
  mysqli_stmt_bind_param($stmt, 'i', $campaignNum);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  $i = 0;
  $json_data['datas'] = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $json_data['datas'][$i]['category'] = $row['CATEGORY'];
    $json_data['datas'][$i]['categoryName'] = $row['CATEGORY_NAME'];
    $i++;
  }

  if ($i == 0) {
    $json_data['resultCode'] = 'fail';
    $json_data['resultMessage'] = '조회실패';
  } else {
    $json_data['resultCode'] = 'success';
    $json_data['resultMessage'] = '조회성공';
  }

  echo json_encode($json_data);
  mysqli_stmt_close($stmt);
  exit;
}
?>
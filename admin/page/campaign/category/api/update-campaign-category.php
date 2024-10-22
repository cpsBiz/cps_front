<? include_once $_SERVER['DOCUMENT_ROOT'] . "/db_config.php"; ?>
<?
$inputData = file_get_contents("php://input");

$data = json_decode($inputData, true);

if (isset($data['apiType']) && isset($data['campaignCategoryList'])) {
  $apiType = $data['apiType'];
  $campaignCategoryList = $data['campaignCategoryList'];

  $i = 0;
  foreach ($campaignCategoryList as $campaign) {
    $category = $campaign['category'];
    $nowCategory = $campaign['nowCategory'];
    $affliateId = $campaign['affliateId'];
    $campaignNum = $campaign['campaignNum'];

    $sql = "
            SELECT 
              COUNT(*) AS CNT
            FROM CPS_CAMPAIGN_RANK
            WHERE 
              CATEGORY = ? AND CAMPAIGN_NUM = ? AND AFFLIATE_ID = ?
        ";
    $stmt = mysqli_stmt_init($con);
    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, 'sis', $category, $campaignNum, $affliateId);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $cnt);
      mysqli_stmt_fetch($stmt);
      mysqli_stmt_close($stmt);

      // CNT 값을 사용
      if ($cnt > 0) {
        $i++;
      } else {
        $sql2 = "
                UPDATE CPS_CAMPAIGN_RANK
                SET 
                  CATEGORY = ?
                WHERE 
                  CATEGORY = ? AND CAMPAIGN_NUM = ? AND AFFLIATE_ID = ?
                ";
        $stmt2 = mysqli_stmt_init($con);
        if (mysqli_stmt_prepare($stmt2, $sql2)) {
          mysqli_stmt_bind_param($stmt2, 'ssis', $category, $nowCategory, $campaignNum, $affliateId);
          mysqli_stmt_execute($stmt2);
          mysqli_stmt_close($stmt2);
        }
      }
    }
  }

  $total = count($campaignCategoryList);
  $failCnt = $i;
  $successCnt = $total - $failCnt;

  $json_data['total'] = $total;
  $json_data['failCnt'] = $failCnt;
  $json_data['successCnt'] = $successCnt;

  $json_data['resultCode'] = 'success';
  $json_data['resultMessage'] = '변경사항저장성공';
} else {
  $json_data['resultCode'] = 'fail';
  $json_data['resultMessage'] = '변경사항저장실패';
}

echo json_encode($json_data);
exit;
?>

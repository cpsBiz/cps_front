<? include_once $_SERVER['DOCUMENT_ROOT'] . "/db_config.php"; ?>
<?
// JSON 데이터를 받아서 처리하는 부분
$inputData = file_get_contents("php://input");

// JSON 데이터를 PHP 배열로 변환
$data = json_decode($inputData, true);

// 데이터가 있는지 확인
if (isset($data['apiType']) && isset($data['campaignList'])) {
  $apiType = $data['apiType'];
  $campaignList = $data['campaignList'];

  // 각 캠페인 정보에 접근해서 처리
  $i = 0;
  foreach ($campaignList as $campaign) {
    $category = $campaign['category'];
    $affliateId = $campaign['affliateId'];
    $campaignNum = $campaign['campaignNum'];
    $campaignRank = $campaign['campaignRank'];

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
      $result = mysqli_stmt_get_result($stmt);
      if (mysqli_num_rows($result) > 0) $i++;
      else {
        $sql = "
                UPDATE SET
                (
                  CAMPAIGN_RANK
                )
                VALUES
                (
                  ?
                )
                WHERE
                  CATEGORY = ? AND CAMPAIGN_NUM = ? AND AFFLIATE_ID = ?
                ";
        $stmt = mysqli_stmt_init($con);
        if (mysqli_stmt_prepare($stmt, $sql)) {
          mysqli_stmt_bind_param($stmt, 'isis', $campaignRank, $category, $campaignNum, $affliateId);
          mysqli_stmt_execute($stmt);
        }
      }
    }
  }

  $total = count($campaignList);
  $failCnt = $i;
  $successCnt = $total - $failCnt;

  $json_data['totla'] = $total;
  $json_data['failCnt'] = $failCnt;
  $json_data['successCnt'] = $successCnt;

  $json_data['resultCode'] = 'success';
  $json_data['resultMessage'] = '변경사항저장성공';
  mysqli_stmt_close($stmt);
} else {
  $json_data['resultCode'] = 'fail';
  $json_data['resultMessage'] = '변경사항저장실패';
}

echo json_encode($json_data);
exit;
?>
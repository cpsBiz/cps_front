<? include_once $_SERVER['DOCUMENT_ROOT'] . "/db_config.php"; ?>
<?
$inputData = file_get_contents("php://input");

$data = json_decode($inputData, true);

if (isset($data['apiType']) && isset($data['campaignList'])) {
  $apiType = $data['apiType'];
  $campaignList = $data['campaignList'];

  foreach ($campaignList as $campaign) {
    $category = $campaign['category'];
    $affliateId = $campaign['affliateId'];
    $campaignNum = $campaign['campaignNum'];
    $campaignRank = $campaign['campaignRank'];

    $sql = "
            UPDATE CPS_CAMPAIGN_RANK 
            SET
              CAMPAIGN_RANK = ?
            WHERE
              CATEGORY = ? AND CAMPAIGN_NUM = ? AND AFFLIATE_ID = ? AND CAMPAIGN_RANK != ?
            ";
    $stmt = mysqli_stmt_init($con);
    if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, 'isisi', $campaignRank, $category, $campaignNum, $affliateId, $campaignRank);
      mysqli_stmt_execute($stmt);
    }
  }

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
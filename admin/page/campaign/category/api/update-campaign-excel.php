<? include_once $_SERVER['DOCUMENT_ROOT'] . "/db_config.php"; ?>
<?
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$response = ['resultCode' => false, 'resultMessage' => ''];

if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
  try {
    $inputFileType = IOFactory::identify($_FILES['excelFile']['tmp_name']);
    $reader = IOFactory::createReader($inputFileType);
    $spreadsheet = $reader->load($_FILES['excelFile']['tmp_name']);

    $worksheet = $spreadsheet->getActiveSheet();
    foreach ($worksheet->getRowIterator(6) as $row) {
      //캠페인번호
      $a = $worksheet->getCell('A' . $row->getRowIndex())->getValue();
      //카테고리코드
      $b = $worksheet->getCell('B' . $row->getRowIndex())->getValue();
      //매체아이디
      $c = $worksheet->getCell('C' . $row->getRowIndex())->getValue();
      //순위
      $d = $worksheet->getCell('D' . $row->getRowIndex())->getValue();

      // A 열 값이 비어 있으면 더 이상 데이터가 없다고 가정하고 중단
      if (empty($a) || empty($b) || empty($c) || empty($d)) {
        break;
      }

      $sql = "
              INSERT INTO CPS_CAMPAIGN_RANK
              (CAMPAIGN_NUM, CATEGORY, AFFLIATE_ID, CAMPAIGN_RANK)
              VALUES
              (?, ?, ?, ?)
              ON DUPLICATE KEY UPDATE
              CATEGORY = ?,
              CAMPAIGN_RANK = ?
              ";
      $stmt = mysqli_stmt_init($con);
      if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'issisi', $a, $b, $c, $d, $b, $d);
        mysqli_stmt_execute($stmt);
      }
    }

    $response['resultCode'] = true;
  } catch (Exception $e) {
    $response['resultMessage'] = '데이터 처리중 문제가 발생했습니다. 다시 시도해 주세요.';
  }
} else {
  $response['resultMessage'] = '파일을 재 첨부하여 다시 시도해 주세요.';
}

echo json_encode($response);
?>
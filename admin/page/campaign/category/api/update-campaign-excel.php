<? include_once $_SERVER['DOCUMENT_ROOT'] . "/db_config.php"; ?>
<?
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$response = ['resultCode' => false, 'resultMessage' => ''];

if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
  try {
    // 파일 형식 검사
    $allowedMimeTypes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if (!in_array($_FILES['excelFile']['type'], $allowedMimeTypes)) {
      $response['resultMessage'] = '엑셀 파일만 업로드 가능합니다.';
      echo json_encode($response);
      exit;
    }

    $inputFileType = IOFactory::identify($_FILES['excelFile']['tmp_name']);
    $reader = IOFactory::createReader($inputFileType);
    $spreadsheet = $reader->load($_FILES['excelFile']['tmp_name']);

    $worksheet = $spreadsheet->getActiveSheet();
    foreach ($worksheet->getRowIterator(6) as $row) {
      // 캠페인번호
      $a = $worksheet->getCell('A' . $row->getRowIndex())->getValue();
      // 카테고리코드
      $b = $worksheet->getCell('B' . $row->getRowIndex())->getValue();
      // 매체아이디
      $c = $worksheet->getCell('C' . $row->getRowIndex())->getValue();
      // 순위
      $d = $worksheet->getCell('D' . $row->getRowIndex())->getValue();

      // A, B, C, D 값이 비어 있으면 중단
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
        // 매개변수 타입을 ssisi로 수정
        mysqli_stmt_bind_param($stmt, 'issisi', $a, $b, $c, $d, $b, $d);
        if (!mysqli_stmt_execute($stmt)) {
          throw new Exception('MySQL execute error: ' . mysqli_stmt_error($stmt));
        }
      } else {
        throw new Exception('MySQL prepare error: ' . mysqli_error($con));
      }
    }

    $response['resultCode'] = true;
  } catch (Exception $e) {
    $response['resultMessage'] = '데이터 처리중 문제가 발생했습니다. 오류: ' . $e->getMessage();
  }
} else {
  $response['resultMessage'] = '파일을 재 첨부하여 다시 시도해 주세요.';
}

echo json_encode($response);
?>
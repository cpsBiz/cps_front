<?

use PhpOffice\PhpSpreadsheet\IOFactory;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// 파일 업로드 처리
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
  $file = $_FILES['excel_file']['tmp_name'];

  // 엑셀 파일 읽기
  $spreadsheet = IOFactory::load($file);
  $sheet = $spreadsheet->getActiveSheet();
  $data = $sheet->toArray();

  // 데이터베이스 수정
  foreach ($data as $row) {
    // 예를 들어, 첫 번째 열에 ID, 두 번째 열에 수정할 값이 있다고 가정
    $id = $row[0];
    $value = $row[1];

    // 데이터베이스 연결 및 수정 쿼리 실행
    $stmt = $pdo->prepare("UPDATE your_table SET your_column = ? WHERE id = ?");
    $stmt->execute([$value, $id]);
  }
}

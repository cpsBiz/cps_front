<?
session_start();
$admin_login = $_SESSION['admin_login'];
if (!$admin_login) {
  echo json_encode(['error' => '잘못된 요청입니다.']);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $files = json_decode(file_get_contents('php://input'), true);
  $filePath = '/var/www/html/uploads/inquiryFiles/';

  // 파일 존재 여부 확인
  $validFiles = [];
  foreach ($files as $fileName) {
    $fullPath = $filePath . $fileName;
    if (file_exists($fullPath) && is_file($fullPath)) {
      $validFiles[] = $fileName;
    }
  }

  if (empty($validFiles)) {
    echo json_encode(['error' => '압축할 파일이 없습니다.']);
    exit;
  }

  $zip = new ZipArchive();
  $zipName = '/var/www/html/tmp/' . date('ymdhis') . '-' . uniqid() . '.zip'; // .zip 확장자 추가

  if ($zip->open($zipName, ZipArchive::CREATE) !== TRUE) {
    echo json_encode(['error' => 'ZIP 파일을 생성할 수 없습니다.']);
    exit;
  }

  // 유효한 파일만 압축
  foreach ($validFiles as $fileName) {
    $fullPath = $filePath . $fileName;
    if (!$zip->addFile($fullPath, $fileName)) {
      $zip->close();
      unlink($zipName);
      echo json_encode(['error' => '파일 압축 중 오류가 발생했습니다.']);
      exit;
    }
  }

  $zip->close();

  if (file_exists($zipName) && filesize($zipName) > 0) {
    $downZipName = "download.zip";
    header("Content-type: application/zip");
    header("Content-Length: " . filesize($zipName));
    header("Content-Disposition: attachment; filename=$downZipName");

    ob_clean();
    flush();
    readfile($zipName);
    unlink($zipName);
  } else {
    echo json_encode(['error' => 'ZIP 파일이 정상적으로 생성되지 않았습니다.']);
  }
} else {
  echo json_encode(['error' => '잘못된 요청입니다.']);
}

<?php
// JSON으로 받은 파일 배열 처리
$data = file_get_contents("php://input");
$fileArray = json_decode($data, true);

$zip = new ZipArchive();
$zipFile = "downloads.zip";

try {
  // zip 파일 생성
  if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    foreach ($fileArray as $file) {
      $filePath = "/var/www/html/uploads/inquiryFiles/" . $file;
      if (file_exists($filePath)) {
        error_log('Adding file: ' . $filePath);
        $zip->addFile($filePath, basename($filePath));
      } else {
        error_log('File not found: ' . $filePath);
        throw new Exception('File not found: ' . $filePath);
      }
    }
    $zip->close();

    // 파일 다운로드 처리
    if (file_exists($zipFile)) {
      header('Content-Type: application/zip');
      header('Content-Disposition: attachment; filename="files.zip"');
      header('Content-Length: ' . filesize($zipFile));

      readfile($zipFile);

      // 임시 zip 파일 삭제
      unlink($zipFile);
    } else {
      throw new Exception('다운로드 파일 생성에 실패했습니다.');
    }
  } else {
    error_log('Zip file create failed');
    throw new Exception('ZIP 파일 생성에 실패했습니다.');
  }
} catch (Exception $e) {
  // 에러 메시지 처리 및 로깅
  error_log($e->getMessage());
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}

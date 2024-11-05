<?php
// 요청이 POST인지 확인
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // JSON 데이터를 받아서 배열로 변환
  $files = json_decode(file_get_contents('php://input'), true);

  // 압축할 파일의 경로 (수정 필요)
  $filePath = '/var/www/html/admin/campaign/files/'; // 파일들이 저장된 경로

  $zip = new ZipArchive();

  // zip 아카이브 생성하기 위한 고유값
  $zipName = '/var/www/html/tmp/' . date('ymdhis') . '-' . uniqid() . "zip";

  // zip 아카이브 생성 여부 확인
  if (!$zip->open($zipName, ZipArchive::CREATE)) {
    exit("error");
  }

  // addFile ( 파일이 존재하는 경로, 저장될 이름 )
  foreach ($files as $fileName) {
    $zip->addFile($filePath . $fileName, $fileName);
  }

  // 아카이브 닫아주기
  $zip->close();

  // 다운로드 될 zip 파일명
  $downZipName = "download.zip";

  // 생성한 zip 파일을 다운로드하기
  header("Content-type: application/zip");
  header("Content-Disposition: attachment; filename=$downZipName");
  readfile($zipName);
  unlink($zipName);
} else {
  echo json_encode(['error' => '잘못된 요청입니다.']);
}

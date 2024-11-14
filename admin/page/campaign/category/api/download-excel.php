<?
session_start();
$admin_login = $_SESSION['admin_login'];
if (!$admin_login) exit;

// 압축할 파일의 경로 (수정 필요)
$filePath = '/var/www/html/admin/page/campaign/files/'; // 파일들이 저장된 경로

$zip = new ZipArchive();

// zip 아카이브 생성하기 위한 고유값
$zipName = '/var/www/html/tmp/' . date('ymdhis') . '-' . uniqid() . "zip";

// zip 아카이브 생성 여부 확인
if (!$zip->open($zipName, ZipArchive::CREATE)) {
  exit("error");
}

// addFile ( 파일이 존재하는 경로, 저장될 이름 )
$zip->addFile($filePath . 'campaign_excel.xlsx', 'campaign_excel.xlsx');

// 아카이브 닫아주기
$zip->close();

// 다운로드 될 zip 파일명
$downZipName = "download.zip";

// 생성한 zip 파일을 다운로드하기
header("Content-type: application/zip");
header("Content-Disposition: attachment; filename=$downZipName");
readfile($zipName);
unlink($zipName);

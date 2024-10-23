<?
$affliateId = $_POST['affliateId'];
$userId = $_POST['userId'];
if (!$affliateId || !$userId) {
  echo json_encode(['resultCode' => 'fail', 'resultMessage' => '잘못된 접근입니다.']);
  exit;
}

if (isset($_FILES['files'])) {
  $uploadDir = '/var/www/html/uploads/inquiryFiles/';  // 파일이 저장될 디렉토리
  $uploadedFiles = [];  // 저장된 파일명을 담을 배열

  $totalFiles = count($_FILES['files']['name']);  // 전송된 파일의 개수

  // 허용되는 MIME 타입 배열
  $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];

  for ($i = 0; $i < $totalFiles; $i++) {
    $fileTmpName = $_FILES['files']['tmp_name'][$i];
    $fileMimeType = mime_content_type($fileTmpName); // 파일의 MIME 타입 가져오기

    // 파일 MIME 타입 검증
    if (!in_array($fileMimeType, $allowedMimeTypes)) {
      continue; // 유효하지 않은 파일은 업로드를 건너뜀
    }

    // 파일명 생성
    $fileBasename = basename($_FILES['files']['name'][$i]);
    $fileExtension = pathinfo($fileBasename, PATHINFO_EXTENSION); // 파일 확장자 추출
    $fileName = date('ymd') . '-' . pathinfo($fileBasename, PATHINFO_FILENAME) . '-' . $affliateId . '-' . $userId . '-' . uniqid() . '.' . $fileExtension; // 파일명 구성
    $uploadFile = $uploadDir . $fileName;

    // 각 파일을 업로드 디렉토리로 이동
    if (move_uploaded_file($fileTmpName, $uploadFile)) {
      $uploadedFiles[] = [
        'fileName' => $fileName // 파일명을 배열에 추가
      ];
    }
  }

  echo json_encode(['resultCode' => 'success', 'datas' => $uploadedFiles]);
} else {
  echo json_encode(['resultCode' => 'fail', 'resultMessage' => '첨부된 파일이 없습니다.']);
}

exit;

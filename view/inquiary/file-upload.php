<?
if ($_FILES['upload_file']['size'] > 0) { // 업로드 파일 사이즈를 체크하여, 업로드 파일여부를 확인

  $upfile_path  = "업로드 할 파일 경로 설정";
  // 파일명에 한글이 존재하는 경우 서버에서 파일명이 깨질 수 있기 때문에 서버가 인식할 수 있는 파일명으로 변환해줘야 한다.
  $file_name  = "파일이름설정." . pathinfo($_FILES['upload_file']['name'], PATHINFO_EXTENSION); // "파일이름설정."+파일 확장자
  $file_upload  = copy($_FILES['upload_file']['tmp_name'], $upfile_path . "/" . $file_name);

  if ($file_upload == false)  echo "failed";
}

echo "failed";

<?php
$inputData = file_get_contents("php://input");

$data = json_decode($inputData, true);

$to = $data['to'] ? $data['to'] : 'choco5958@naver.com';
$from = $data['from'] ? $data['from'] : 'choco5958@gmail.com';
$title = '문의 답변';
$content = $data['content'] ? $data['content'] : '테스트';

// 추가 헤더 설정
$headers = "From: $from\r\n";
$headers .= "Reply-To: $from\r\n"; // 답장 주소 설정

if (!filter_var($to, FILTER_VALIDATE_EMAIL) || !filter_var($from, FILTER_VALIDATE_EMAIL)) {
  $json_data['resultCode'] = 'fail';
  $json_data['resultMessage'] = '유효하지 않은 이메일 주소입니다.';
  echo json_encode($json_data);
  exit;
}


if (!$mail->send()) {
  $json_data['resultCode'] = 'fail';
  $json_data['resultMessage'] = '메일 전송 실패';
} else {
  $json_data['resultCode'] = 'success';
  $json_data['resultMessage'] = '메일 전송 성공';
}

echo json_encode($json_data);
exit;

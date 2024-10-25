<?
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Composer의 autoloader 로드
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


// PHPMailer 객체 생성
$mail = new PHPMailer(true);

try {
  // 서버 설정
  $mail->isSMTP();                                         // SMTP 사용
  $mail->Host       = 'smtp.gmail.com';                  // SMTP 서버 (예: smtp.gmail.com)
  $mail->SMTPAuth   = true;                                // SMTP 인증 사용
  $mail->Username   = 'choco5958@gmail.com';            // SMTP 사용자 이메일
  $mail->Password   = 'mvbilmqlnlzxxzmz';                     // SMTP 비밀번호
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // TLS 암호화 사용
  $mail->Port       = 587;
  $mail->CharSet = 'UTF-8';

  // 발신자 정보
  $mail->setFrom($from, '[고객센터]');

  // 수신자 정보
  $mail->addAddress($to, '[유저이름]');  // 수신자 이메일

  // 이메일 콘텐츠 설정
  $mail->isHTML(true);                                    // HTML 포맷 사용
  $mail->Subject = $title;
  $mail->Body    = $content;
  $mail->AltBody = $content;

  // 이메일 전송
  if (!$mail->send()) {
    $json_data['resultCode'] = 'fail';
    $json_data['resultMessage'] = '메일 전송 실패';
  } else {
    $json_data['resultCode'] = 'success';
    $json_data['resultMessage'] = '메일 전송 성공';
  }
} catch (Exception $e) {
  $json_data['resultCode'] = 'fail';
  $json_data['resultMessage'] = '메일 전송 실패';
}

echo json_encode($json_data);
exit;

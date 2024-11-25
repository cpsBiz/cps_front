<? include_once $_SERVER['DOCUMENT_ROOT'] . "/isTest.php"; ?>
<?
$inputData = json_decode(file_get_contents("php://input"), true);

// ID와 PW를 JSON에서 추출
$id = $inputData['id'] ?? null;
$pw = $inputData['pw'] ?? null;

if (!$id || !$pw) {
  $json_data['resultCode'] = '9999';
  $json_data['resultMessage'] = '아이디 또는 비밀번호를 입력해 주세요.';
  echo json_encode($json_data);
  exit;
}

function callApi($url, $data)
{
  $ch = curl_init($url);  // cURL 초기화
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_POST, true);  // POST 요청 설정
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',  // JSON 형식 요청 헤더 설정
  ]);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));  // 요청 데이터 설정

  $response = curl_exec($ch);  // 요청 실행
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  // HTTP 상태 코드 확인
  curl_close($ch);

  if ($httpCode == 200) {
    return json_decode($response, true);  // 성공 시 JSON 응답 반환
  } else {
    return ['resultCode' => '9999', 'resultMessage' => '요청이 실패했습니다. 다시 시도해 주세요.'];
  }
}

$url = $adminApiUrl . "/api/admin/memberLogin";
$data = [
  "memberId" => $id,
  "memberPw" => $pw
];

$response = callApi($url, $data);

if ($response['resultCode'] === '0000') {
  session_start();

  $_SESSION['admin_login'] = true;
  $_SESSION['admin_login_id'] = $response['data']['memberId'];
  $_SESSION['admin_login_name'] = $response['data']['memberName'];
  $_SESSION['admin_login_type'] = $response['data']['type'];
}

echo json_encode($response);
exit;
?>
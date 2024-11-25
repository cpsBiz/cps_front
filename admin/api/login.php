<? include_once $_SERVER['DOCUMENT_ROOT'] . "/isTest.php"; ?>
<?
$inputData = json_decode(file_get_contents("php://input"), true);

$id = $inputData['id'] ?? null;
$pw = $inputData['pw'] ?? null;

if (!$id || !$pw) {
  echo json_encode([
    'resultCode' => '9999',
    'resultMessage' => '아이디 또는 비밀번호를 입력해 주세요.'
  ]);
  exit;
}

function callApi($url, $data)
{
  $options = [
    'http' => [
      'header' => [
        'Content-Type: application/json',
        'Accept: application/json'
      ],
      'method' => 'POST',
      'content' => json_encode($data),
      'ignore_errors' => true
    ],
    'ssl' => [
      'verify_peer' => false,
      'verify_peer_name' => false
    ]
  ];

  $context = stream_context_create($options);
  $response = file_get_contents($url, false, $context);

  if ($response === false) {
    return [
      'resultCode' => '9999',
      'resultMessage' => '서버 연결에 실패했습니다.'
    ];
  }

  $result = json_decode($response, true);
  if (json_last_error() !== JSON_ERROR_NONE) {
    return [
      'resultCode' => '9999',
      'resultMessage' => '응답 처리에 실패했습니다.'
    ];
  }

  return $result;
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

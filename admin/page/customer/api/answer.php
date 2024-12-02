<?
include_once $_SERVER['DOCUMENT_ROOT'] . "/db_config.php";
include_once "./answerClasses.php";

try {
  // JSON 데이터 파싱
  $jsonData = file_get_contents("php://input");
  $requestData = json_decode($jsonData, true);

  if (json_last_error() !== JSON_ERROR_NONE) {
    ApiResponse::error('9999', 'Invalid JSON format');
  }

  // MemberSignIn 클래스 초기화 및 처리
  $answer = new answer($con);
  $result = $answer->process($requestData);

  // 결과 반환
  if ($result['resultCode'] === '0000') {
    ApiResponse::success($result['data'] ?? null);
  } else {
    ApiResponse::error($result['resultCode'], $result['resultMessage']);
  }
} catch (Exception $e) {
  ApiResponse::error('9997', $e->getMessage());
}

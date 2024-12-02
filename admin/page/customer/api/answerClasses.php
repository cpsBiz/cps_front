<?php
class Answer
{
  private $db;

  public function __construct($connection)
  {
    $this->db = new DatabaseHandler($connection);
  }

  public function process($requestData)
  {
    try {
      return $this->handleInsert($requestData);
    } catch (Exception $e) {
      return $this->errorResponse('9997', $e->getMessage());
    }
  }

  private function handleInsert($requestData)
  {
    // 필수 파라미터 체크
    $requiredParams = ['inquiryNum', 'note'];
    foreach ($requiredParams as $param) {
      if (!isset($requestData[$param])) {
        return $this->errorResponse('9998', "Missing required parameter: {$param}");
      }
    }

    try {
      // 답변 등록
      $sql = "INSERT INTO CPS_ANSWER (INQUIRY_NUM, NOTE, MOD_DATE) VALUES (?, ?, NOW())";
      $result = $this->db->executeQuery($sql, 'is', [$requestData['inquiryNum'], $requestData['note']]);

      if (!$result) {
        return $this->errorResponse('4002', 'Answer registration failed');
      }

      // 문의 상태 업데이트
      $updateSql = "UPDATE CPS_INQUIRY SET ANSWER_YN = 'Y' WHERE INQUIRY_NUM = ?";
      $updateResult = $this->db->executeQuery($updateSql, 'i', [$requestData['inquiryNum']]);

      if (!$updateResult) {
        return $this->errorResponse('4003', 'Status update failed');
      }

      return $this->successResponse();
    } catch (Exception $e) {
      throw $e;
    }
  }

  private function successResponse($data = null)
  {
    $response = ['resultCode' => '0000', 'resultMessage' => 'Success'];
    if ($data) {
      $response['data'] = $data;
    }
    return $response;
  }

  private function errorResponse($code, $message)
  {
    return ['resultCode' => $code, 'resultMessage' => $message];
  }
}

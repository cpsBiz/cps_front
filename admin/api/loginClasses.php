<? class login
{
  private $db;

  public function __construct($connection)
  {
    $this->db = new DatabaseHandler($connection);
  }

  public function process($requestData)
  {
    try {
      // 필수 파라미터 체크
      if (!isset($requestData['id']) || !isset($requestData['pw'])) {
        return $this->errorResponse('9998', '필수 파라미터가 누락되었습니다.');
      }

      // 회원 검증 및 데이터 조회
      $memberData = $this->getMemberValid($requestData);

      if (!$memberData) {
        return $this->errorResponse('4001', '아이디 또는 비밀번호가 일치하지 않습니다.');
      }

      return $this->successResponse($memberData);
    } catch (Exception $e) {
      return $this->errorResponse('9997', '로그인 처리 중 오류가 발생했습니다.');
    }
  }

  private function getMemberValid($requestData)
  {
    try {
      // 회원 정보 조회
      $sql = "SELECT 
                        MEMBER_ID,
                        MEMBER_NAME,
                        TYPE
                    FROM CPS_MEMBER 
                    WHERE MEMBER_ID = ? 
                    AND MEMBER_PW = ?";

      $result = $this->db->executeQuery(
        $sql,
        'ss',
        [
          $requestData['id'],
          AESCipher::encrypt($requestData['pw'])
        ]
      );

      return mysqli_fetch_assoc($result);
    } catch (Exception $e) {
      throw new Exception('회원 정보 조회 중 오류가 발생했습니다.');
    }
  }

  private function successResponse($data = null)
  {
    $response = [
      'resultCode' => '0000',
      'resultMessage' => 'Success'
    ];

    if ($data) {
      $response['data'] = [
        'memberId' => $data['MEMBER_ID'],
        'memberName' => $data['MEMBER_NAME'],
        'type' => $data['TYPE']
      ];
    }

    return $response;
  }

  private function errorResponse($code, $message)
  {
    return [
      'resultCode' => $code,
      'resultMessage' => $message,
      'data' => null
    ];
  }
}

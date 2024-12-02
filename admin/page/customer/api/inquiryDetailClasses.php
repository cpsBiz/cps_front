<?
class inquiryDetail
{
  private $db;

  public function __construct($connection)
  {
    $this->db = new DatabaseHandler($connection);
  }

  public function process($requestData)
  {
    try {
      return $this->handleSelect($requestData);
    } catch (Exception $e) {
      return $this->errorResponse('9997', $e->getMessage());
    }
  }

  private function handleSelect($requestData)
  {
    $inquiry = $this->getInquiry($requestData);
    $answer = $this->getAnswer($requestData);
    $fileList = $this->getFileList($requestData);

    $responseData = [
      'cpsInquiry' => $inquiry ? [
        'inquiryNum' => (int)$inquiry['INQUIRY_NUM'],
        'note' => $inquiry['NOTE'],
        'userId' => $inquiry['USER_ID'],
        'inquiryType' => $inquiry['INQUIRY_TYPE'],
        'merchantId' => $inquiry['MERCHANT_ID'] ?? '',
        'purpose' => $inquiry['PURPOSE'],
        'regDay' => (int)$inquiry['REG_DAY'],
        'userName' => $inquiry['USER_NAME'],
        'orderNo' => $inquiry['ORDER_NO'] ?? '',
        'productCode' => $inquiry['PRODUCT_CODE'] ?? '',
        'currency' => $inquiry['CURRENCY'] ?? '',
        'payment' => $inquiry['PAYMENT'] ?? '',
        'productPrice' => (int)$inquiry['PRODUCT_PRICE'],
        'productCnt' => (int)$inquiry['PRODUCT_CNT'],
        'email' => $inquiry['EMAIL'],
        'information' => $inquiry['INFORMATION'],
        'answerYn' => $inquiry['ANSWER_YN'],
        'regDate' => $inquiry['REG_DATE']
      ] : null,
      'cpsAnswer' => $answer ? [
        'inquiryNum' => (int)$answer['INQUIRY_NUM'],
        'note' => $answer['NOTE']
      ] : null,
      'fileList' => $fileList ?: null
    ];

    return $this->successResponse($responseData);
  }

  private function getInquiry($requestData)
  {
    $sql = "SELECT * FROM CPS_INQUIRY WHERE INQUIRY_NUM = ?";
    $result = $this->db->executeQuery($sql, 's', [$requestData['inquiryNum']]);
    return mysqli_fetch_assoc($result);
  }

  private function getAnswer($requestData)
  {
    $sql = "SELECT * FROM CPS_ANSWER WHERE INQUIRY_NUM = ?";
    $result = $this->db->executeQuery($sql, 's', [$requestData['inquiryNum']]);
    return mysqli_fetch_assoc($result);
  }

  private function getFileList($requestData)
  {
    $sql = "SELECT FILE_NAME FROM CPS_INQUIRY_FILE WHERE INQUIRY_NUM = ?";
    $result = $this->db->executeQuery($sql, 's', [$requestData['inquiryNum']]);
    $files = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $files[] = $row['FILE_NAME'];
    }
    return !empty($files) ? ['fileName' => $files] : null;
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

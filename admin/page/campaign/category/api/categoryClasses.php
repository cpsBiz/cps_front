<?
error_reporting(E_ALL);
ini_set("display_errors", 1);
class category
{
  private $db;

  public function __construct($connection)
  {
    $this->db = new DatabaseHandler($connection);
  }

  public function process($requestData)
  {
    try {
      return $this->handleCategory($requestData);
    } catch (Exception $e) {
      return $this->errorResponse('9997', $e->getMessage());
    }
  }

  private function handleCategory($requestData)
  {
    if (!isset($requestData['apiType']) || !isset($requestData['categoryList']) || !is_array($requestData['categoryList'])) {
      return $this->errorResponse('9998', 'Missing required parameters or invalid format');
    }

    try {
      $responseData = [];
      $apiType = strtoupper($requestData['apiType']);  // 대소문자 구분 없이 처리

      if ($apiType === 'D') {
        foreach ($requestData['categoryList'] as $category) {
          if (!isset($category['category'])) {
            continue;  // 유효하지 않은 데이터는 건너뛰기
          }
          $sql = "DELETE FROM CPS_CATEGORY WHERE CATEGORY = ?";
          $this->db->executeQuery($sql, 's', [$category['category']]);
          $responseData[] = $category;
        }
      } else if ($apiType === 'I' || $apiType === 'U') {
        foreach ($requestData['categoryList'] as $category) {
          if (!isset($category['categoryName'])) {
            continue;
          }

          // 입력값 검증 추가
          $categoryName = trim($category['categoryName']);
          if (empty($categoryName)) {
            continue;
          }

          $checkSql = "SELECT * FROM CPS_CATEGORY WHERE CATEGORY_NAME = ?";
          $result = $this->db->executeQuery($checkSql, 's', [$categoryName]);
          $existingCategory = mysqli_fetch_assoc($result);

          // 로직 개선
          if ($apiType === 'U') {
            if (!isset($category['category'])) {
              continue;
            }
            if ($existingCategory && $existingCategory['CATEGORY'] !== $category['category']) {
              return $this->errorResponse('4001', '이미 존재하는 카테고리명입니다.');
            }
            $categoryCode = $category['category'];
          } else {
            if ($existingCategory) {
              return $this->errorResponse('4001', '이미 존재하는 카테고리명입니다.');
            }
            $categoryCode = $this->getMaxCategory();
          }

          $categoryRank = isset($category['categoryRank']) && is_numeric($category['categoryRank'])
            ? max(1, intval($category['categoryRank']))
            : 999;

          $sql = ($apiType === 'I')
            ? "INSERT INTO CPS_CATEGORY (CATEGORY, CATEGORY_NAME, CATEGORY_RANK) VALUES (?, ?, ?)"
            : "UPDATE CPS_CATEGORY SET CATEGORY_NAME = ?, CATEGORY_RANK = ? WHERE CATEGORY = ?";

          $params = ($apiType === 'I')
            ? [$category['category'], $categoryName, $categoryRank]
            : [$categoryName, $categoryRank, $category['category']];

          $types = ($apiType === 'I') ? 'ssi' : 'sis';

          $this->db->executeQuery($sql, $types, $params);

          $responseData[] = [
            'category' => $categoryCode,
            'categoryName' => $categoryName,
            'categoryRank' => $categoryRank
          ];
        }
      } else {
        return $this->errorResponse('9999', '잘못된 API 타입입니다.');
      }

      return $this->successResponse($responseData);
    } catch (Exception $e) {
      return $this->errorResponse('4002', '카테고리 처리 중 오류가 발생했습니다: ' . $e->getMessage());
    }
  }

  private function getMaxCategory()
  {
    $sql = "SELECT COALESCE(MAX(CATEGORY), 0) as max_category FROM CPS_CATEGORY";
    $result = $this->db->executeQuery($sql);
    $row = mysqli_fetch_assoc($result);
    return intval($row['max_category']) + 1;
  }

  private function successResponse($data = null)
  {
    $response = ['resultCode' => '0000', 'resultMessage' => 'Success'];
    if ($data) {
      $response['datas'] = $data;
    }
    return $response;
  }

  private function errorResponse($code, $message)
  {
    return [
      'resultCode' => $code,
      'resultMessage' => $message,
      'datas' => null
    ];
  }
}

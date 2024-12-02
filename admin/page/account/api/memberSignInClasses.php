<?
error_reporting(E_ALL);
ini_set("display_errors", 1);
class MemberSignIn
{
  private $db;

  public function __construct($connection)
  {
    $this->db = new DatabaseHandler($connection);
  }

  public function process($requestData)
  {
    try {
      // 회원 조회
      $memberCheck = $this->getMemberById($requestData['memberId']);

      // API 타입에 따른 처리
      switch ($requestData['apiType']) {
        case 'I':
          return $this->handleInsert($requestData, $memberCheck);
        case 'D':
          return $this->handleDelete($requestData, $memberCheck);
        case 'U':
          return $this->handleUpdate($requestData, $memberCheck);
        default:
          return $this->errorResponse('9998', 'Invalid API Type');
      }
    } catch (Exception $e) {
      return $this->errorResponse('9997', $e->getMessage());
    }
  }

  private function handleInsert($requestData, $memberCheck)
  {
    if ($memberCheck) {
      return $this->errorResponse('4001', 'Member already exists');
    }

    if ($requestData['type'] === 'MASTER') {
      $requiredParams = [
        'memberId',
        'memberPw',
        'dept',
        'team',
        'managerName',
        'managerEmail',
        'companyPhone',
        'companyPhoneSub',
        'type'
      ];
      $sql = "INSERT INTO CPS_MEMBER (
                MEMBER_ID, MEMBER_PW, DEPT, TEAM,
                MANAGER_NAME, MANAGER_EMAIL, COMPANY_PHONE, COMPANY_PHONE_SUB,
                TYPE
              ) VALUES (
                ?, ?, ?, ?, 
                ?, ?, ?, ?, 
                ?
              )";
      $types = 'sssssssss';
      $params = [
        $requestData['memberId'],
        AESCipher::encrypt($requestData['memberPw']),
        $requestData['dept'],
        $requestData['team'],
        $requestData['managerName'],
        $requestData['managerEmail'],
        $requestData['companyPhone'],
        $requestData['companyPhoneSub'],
        $requestData['type']
      ];
    } else {
      $requiredParams = [
        'memberId',
        'memberPw',
        'type',
        'businessType',
        'license',
      ];

      if ($requestData['businessType'] === 'O') {
        $requiredParams = array_merge($requiredParams, [
          'ceoName',
          'managerEmail',
          'companyPhone',
          'birthYear',
          'sex'
        ]);

        $sql = "INSERT INTO CPS_MEMBER 
                (
                  MEMBER_ID, MEMBER_PW, TYPE, BUSINESS_TYPE, AGENCY_ID,
                  LICENSE, ACCOUNT_NAME, BANK, 
                  CEO_NAME, MANAGER_EMAIL, COMPANY_PHONE, BRITH_YEAR, SEX
                ) 
                VALUES 
                (
                  ?, ?, ?, ?, ?, 
                  ?, ?, ?, 
                  ?, ?, ?, ?, ?
                )";

        $types = 'sssssssssssss';
        $params = [
          $requestData['memberId'],
          AESCipher::encrypt($requestData['memberPw']),
          $requestData['type'],
          $requestData['businessType'],
          $requestData['agencyId'],
          $requestData['license'],
          $requestData['accountName'],
          $requestData['bank'],
          $requestData['ceoName'],
          $requestData['managerEmail'],
          $requestData['companyPhone'],
          $requestData['birthYear'],
          $requestData['sex']
        ];
      } elseif ($requestData['businessType'] === 'B') {
        $requiredParams = array_merge($requiredParams, [
          'memberName',
          'ceoName',
          'businessNumber',
          'companyAddress',
          'businessCategory',
          'businessSector',
          'managerName',
          'managerEmail',
          'managerPhone',
          'companyPhone'
        ]);

        $sql = "INSERT INTO CPS_MEMBER 
                (
                  MEMBER_ID, MEMBER_PW, TYPE, BUSINESS_TYPE, AGENCY_ID,
                  LICENSE, ACCOUNT_NAME, BANK, 
                  MEMBER_NAME, CEO_NAME,
                  BUSINESS_NUMBER, COMPANY_ADDRESS, BUSINESS_CATEGORY,
                  BUSINESS_SECTOR, MANAGER_NAME, MANAGER_EMAIL,
                  MANAGER_PHONE, COMPANY_PHONE
                ) 
                VALUES 
                (
                  ?, ?, ?, ?, ?,
                  ?, ?, ?, 
                  ?, ?, 
                  ?, ?, ?, 
                  ?, ?, ?,
                  ?, ?
                )";

        $types = 'ssssssssssssssssss';
        $params = [
          $requestData['memberId'],
          AESCipher::encrypt($requestData['memberPw']),
          $requestData['type'],
          $requestData['businessType'],
          $requestData['agencyId'],
          $requestData['license'],
          $requestData['accountName'],
          $requestData['bank'],
          $requestData['memberName'],
          $requestData['ceoName'],
          $requestData['businessNumber'],
          $requestData['companyAddress'],
          $requestData['businessCategory'],
          $requestData['businessSector'],
          $requestData['managerName'],
          $requestData['managerEmail'],
          $requestData['managerPhone'],
          $requestData['companyPhone']
        ];
      }
    }

    foreach ($requiredParams as $param) {
      if (!isset($requestData[$param])) {
        return $this->errorResponse('9998', "Missing required parameter: {$param}");
      }
    }

    $result = $this->db->executeQuery($sql, $types, $params);

    if ($result) {
      $this->handleMemberSites($requestData);
      return $this->successResponse($this->getMemberWithSites($requestData['memberId']));
    }

    return $this->errorResponse('4002', 'Insert Failed');
  }

  private function handleDelete($requestData, $memberCheck)
  {
    if (!$memberCheck) {
      return $this->errorResponse('4003', 'Member Not Found');
    }

    // 회원 정보 삭제
    $sql = "DELETE FROM CPS_MEMBER 
            WHERE 
              MEMBER_ID = ? AND MEMBER_PW = ?";
    $params = [$requestData['memberId'], AESCipher::encrypt($requestData['memberPw'])];
    $types = 'ss';

    $result = $this->db->executeQuery($sql, $types, $params);

    // 회원 사이트 정보 삭제
    $this->deleteMemberSites($requestData['memberId']);

    if ($result) {
      return $this->successResponse();
    }

    return $this->errorResponse('4004', 'Delete Failed');
  }

  private function handleUpdate($requestData, $memberCheck)
  {
    if (!$memberCheck) {
      return $this->errorResponse('4005', 'Member Not Found');
    }

    if ($requestData['type'] === 'MASTER') {
      $requiredParams = [
        'memberId',
        'memberPw',
        'dept',
        'team',
        'managerName',
        'managerEmail',
        'companyPhone',
        'companyPhoneSub',
        'type'
      ];
      $sql = "UPDATE CPS_MEMBER SET
                MEMBER_PW = ?, DEPT = ?, TEAM = ?,
                MANAGER_NAME = ?, MANAGER_EMAIL = ?, COMPANY_PHONE = ?, COMPANY_PHONE_SUB = ?
              WHERE 
                MEMBER_ID = ? AND TYPE = ?";
      $types = 'sssssssss';
      $params = [
        AESCipher::encrypt($requestData['memberPw']),
        $requestData['dept'],
        $requestData['team'],
        $requestData['managerName'],
        $requestData['managerEmail'],
        $requestData['companyPhone'],
        $requestData['companyPhoneSub'],
        $requestData['memberId'],
        $requestData['type']
      ];
    } else {
      $requiredParams = [
        'memberId',
        'memberPw',
        'type',
        'businessType',
        'license',
      ];

      if ($requestData['businessType'] === 'O') {
        $requiredParams = array_merge($requiredParams, [
          'ceoName',
          'managerEmail',
          'companyPhone',
          'birthYear',
          'sex'
        ]);

        $sql = "UPDATE CPS_MEMBER SET
                  MEMBER_PW = ?, BUSINESS_TYPE = ?, AGENCY_ID = ?,
                  LICENSE = ?, ACCOUNT_NAME = ?, BANK = ?, 
                  CEO_NAME = ?, MANAGER_EMAIL = ?, COMPANY_PHONE = ?, BRITH_YEAR = ?, SEX = ?,
                  TYPE = ?
                WHERE
                  MEMBER_ID = ?";

        $types = 'sssssssssssss';
        $params = [
          AESCipher::encrypt($requestData['memberPw']),
          $requestData['businessType'],
          $requestData['agencyId'] ?? '',
          $requestData['license'],
          $requestData['accountName'] ?? '',
          $requestData['bank'] ?? '',
          $requestData['ceoName'],
          $requestData['managerEmail'],
          $requestData['companyPhone'],
          $requestData['birthYear'],
          $requestData['sex'],
          $requestData['type'],
          $requestData['memberId']
        ];
      } elseif ($requestData['businessType'] === 'B') {
        $requiredParams = array_merge($requiredParams, [
          'memberName',
          'ceoName',
          'businessNumber',
          'companyAddress',
          'businessCategory',
          'businessSector',
          'managerName',
          'managerEmail',
          'managerPhone',
          'companyPhone'
        ]);

        $sql = "UPDATE CPS_MEMBER SET
                  MEMBER_PW = ?, BUSINESS_TYPE = ?, AGENCY_ID = ?,
                  LICENSE = ?, ACCOUNT_NAME = ?, BANK = ?, 
                  MEMBER_NAME = ?, CEO_NAME = ?,
                  BUSINESS_NUMBER = ?, COMPANY_ADDRESS = ?, BUSINESS_CATEGORY = ?,
                  BUSINESS_SECTOR = ?, MANAGER_NAME = ?, MANAGER_EMAIL = ?,
                  MANAGER_PHONE = ?, COMPANY_PHONE = ?, TYPE = ?
                WHERE
                  MEMBER_ID = ?";

        $types = 'ssssssssssssssssss';
        $params = [
          AESCipher::encrypt($requestData['memberPw']),
          $requestData['businessType'],
          $requestData['agencyId'] ?? '',
          $requestData['license'],
          $requestData['accountName'] ?? '',
          $requestData['bank'] ?? '',
          $requestData['memberName'],
          $requestData['ceoName'],
          $requestData['businessNumber'],
          $requestData['companyAddress'],
          $requestData['businessCategory'],
          $requestData['businessSector'],
          $requestData['managerName'],
          $requestData['managerEmail'],
          $requestData['managerPhone'],
          $requestData['companyPhone'],
          $requestData['type'],
          $requestData['memberId']
        ];
      }
    }

    foreach ($requiredParams as $param) {
      if (!isset($requestData[$param])) {
        return $this->errorResponse('9998', "Missing required parameter: {$param}");
      }
    }

    $result = $this->db->executeQuery($sql, $types, $params);

    if ($result) {
      $this->handleMemberSites($requestData);
      return $this->successResponse($this->getMemberWithSites($requestData['memberId']));
    }

    return $this->errorResponse('4006', 'Update Failed');
  }

  private function handleMemberSites($requestData)
  {
    if ($requestData['type'] === 'AFFLIATE' && !empty($requestData['memberSiteList'])) {
      $this->deleteMemberSites($requestData['memberId']);

      foreach ($requestData['memberSiteList'] as $site) {
        $sql = "INSERT INTO CPS_MEMBER_SITE 
                (
                  MEMBER_ID, SITE, SITE_NAME, CATEGORY
                ) 
                VALUES 
                (
                  ?, ?, ?, ?
                )";

        $params = [
          $requestData['memberId'],
          $site['site'],
          $site['siteName'],
          $site['category']
        ];
        $types = 'ssss';

        $this->db->executeQuery($sql, $types, $params);
      }
    } else if ($requestData['apiType'] === 'U' && $requestData['type'] !== 'AFFLIATE') {
      $this->deleteMemberSites($requestData['memberId']);
    }
  }

  private function getMemberWithSites($memberId)
  {
    $member = $this->getMemberById($memberId);
    if ($member) {
      $member['siteList'] = $this->getMemberSites($memberId);
    }
    return $member;
  }

  private function getMemberSites($memberId)
  {
    $sql = "SELECT * FROM CPS_MEMBER_SITE WHERE MEMBER_ID = ?";
    $result = $this->db->executeQuery($sql, 's', [$memberId]);
    $sites = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $sites[] = $row;
    }
    return $sites;
  }

  private function deleteMemberSites($memberId)
  {
    $sql = "DELETE FROM CPS_MEMBER_SITE WHERE MEMBER_ID = ?";
    return $this->db->executeQuery($sql, 's', [$memberId]);
  }

  private function getMemberById($memberId)
  {
    $sql = "SELECT * FROM CPS_MEMBER WHERE MEMBER_ID = ?";
    $result = $this->db->executeQuery($sql, 's', [$memberId]);
    return mysqli_fetch_assoc($result);
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

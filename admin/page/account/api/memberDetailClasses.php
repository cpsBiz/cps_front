<?php
class MemberDetail
{
  private $db;

  public function __construct($connection)
  {
    $this->db = new DatabaseHandler($connection);
  }

  public function process($requestData)
  {
    try {
      $memberCheck = $this->getMemberById($requestData['memberId']);
      return $this->handleSelect($requestData, $memberCheck);
    } catch (Exception $e) {
      return $this->errorResponse('9997', $e->getMessage());
    }
  }

  private function handleSelect($requestData, $memberCheck)
  {
    if (!$memberCheck) {
      return $this->errorResponse('4003', 'Member Not Found');
    }

    return $this->successResponse($this->getMemberWithSites($requestData['memberId']));
  }

  private function getMemberWithSites($memberId)
  {
    $member = $this->getMemberById($memberId);
    if ($member) {
      // DB 컬럼명을 원하는 키값으로 변환
      $formattedMember = [
        'memberId' => $member['MEMBER_ID'],
        'memberPw' => AESCipher::decrypt($member['MEMBER_PW']),
        'memberName' => $member['MEMBER_NAME'],
        'type' => $member['TYPE'],
        'businessType' => $member['BUSINESS_TYPE'],
        'agencyId' => $member['AGENCY_ID'],
        'bank' => $member['BANK'],
        'accountName' => $member['ACCOUNT_NAME'],
        'ceoName' => $member['CEO_NAME'],
        'businessNumber' => $member['BUSINESS_NUMBER'],
        'companyAddress' => $member['COMPANY_ADDRESS'],
        'businessCategory' => $member['BUSINESS_CATEGORY'],
        'businessSector' => $member['BUSINESS_SECTOR'],
        'dept' => $member['DEPT'],
        'team' => $member['TEAM'],
        'managerName' => $member['MANAGER_NAME'],
        'managerEmail' => $member['MANAGER_EMAIL'],
        'managerPhone' => $member['MANAGER_PHONE'],
        'companyPhone' => $member['COMPANY_PHONE'],
        'companyPhoneSub' => $member['COMPANY_PHONE_SUB'],
        'birthYear' => $member['BRITH_YEAR'],
        'sex' => $member['SEX'],
        'license' => $member['LICENSE'],
        'siteList' => null
      ];

      $sites = $this->getMemberSites($memberId);
      if (!empty($sites)) {
        $formattedMember['siteList'] = array_map(function ($site) {
          return [
            'site' => $site['SITE'],
            'siteName' => $site['SITE_NAME'],
            'category' => $site['CATEGORY']
          ];
        }, $sites);
      }

      return $formattedMember;
    }
    return null;
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

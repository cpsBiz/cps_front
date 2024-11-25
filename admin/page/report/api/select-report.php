<?
error_reporting(E_ALL);
ini_set("display_erros", 1);

// JSON 요청 데이터 받기
$inputData = json_decode(file_get_contents("php://input"), true);

// 요청 파라미터 추출
$dayType = $inputData['dayType'] ?? null;
$regStart = $inputData['regStart'] ?? null;
$regEnd = $inputData['regEnd'] ?? null;
$searchType = $inputData['searchType'] ?? null;
$os = $inputData['os'] ?? null;
$cancelYn = $inputData['cancelYn'] ?? null;
$keywordType = $inputData['keywordType'] ?? null;
$keyword = $inputData['keyword'] ?? null;
$type = $inputData['type'] ?? null;
$searchId = $inputData['searchId'] ?? null;
$page = $inputData['page'] ?? 0;
$size = $inputData['size'] ?? 40;
$orderBy = $inputData['orderBy'] ?? 'DESC';
$orderByName = $inputData['orderByName'] ?? null;

// 요청 객체 구성
$request = [
  'dayType' => $dayType,
  'regStart' => $regStart,
  'regEnd' => $regEnd,
  'searchType' => $searchType,
  'os' => $os,
  'cancelYn' => $cancelYn,
  'keywordType' => $keywordType,
  'keyword' => $keyword,
  'type' => $type,
  'searchId' => $searchId,
  'page' => (int)$page,
  'size' => (int)$size,
  'orderBy' => $orderBy,
  'orderByName' => $orderByName
];


function getSummarySearch($request)
{
  include_once $_SERVER['DOCUMENT_ROOT'] . "/isTest.php";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/db_config.php";

  $where = [];
  $params = [];
  $types = '';

  // 날짜 조건
  if ($request['dayType'] == 'MONTH') {
    $where[] = "A.REG_YM BETWEEN ? AND ?";
    $params[] = intval(substr($request['regStart'], 0, 6));
    $params[] = intval(substr($request['regEnd'], 0, 6));
    $types .= 'ii';
  } else if ($request['dayType'] == 'DAY') {
    $where[] = "A.REG_DAY BETWEEN ? AND ?";
    $params[] = intval($request['regStart']);
    $params[] = intval($request['regEnd']);
    $types .= 'ii';
  } else if ($request['dayType'] == 'EQMONTH') {
    $where[] = "A.REG_YM = ?";
    $params[] = intval(substr($request['keyword'], 0, 6));
    $types .= 'i';
  } else {
    $where[] = "A.REG_DAY = ?";
    $params[] = intval($request['keyword']);
    $types .= 'i';
  }

  // OS 조건
  if ($request['os'] == 'PC') {
    $where[] = "A.OS = 'PC'";
  } else if ($request['os'] == 'MOBILE') {
    $where[] = "A.OS IN ('IOS', 'AOS')";
  }

  // 검색어 조건
  if (!empty($request['keyword'])) {
    if ($request['keywordType'] == 'MERCHANT' || $request['keywordType'] == 'ALL') {
      $where[] = "(A.MEMBER_NAME LIKE ? OR A.MERCHANT_ID LIKE ?)";
      $params[] = "%{$request['keyword']}%";
      $params[] = "%{$request['keyword']}%";
      $types .= 'ss';
    }
    if ($request['keywordType'] == 'SITE' || $request['keywordType'] == 'ALL') {
      $where[] = "A.SITE LIKE ?";
      $params[] = "%{$request['keyword']}%";
      $types .= 's';
    }
    if ($request['keywordType'] == 'CAMPAIGN' || $request['keywordType'] == 'ALL') {
      $where[] = "(A.CAMPAIGN_NAME LIKE ? OR A.CAMPAIGN_ID LIKE ?)";
      $params[] = "%{$request['keyword']}%";
      $params[] = "%{$request['keyword']}%";
      $types .= 'ss';
    }
    if ($request['keywordType'] == 'AFFLIATE' || $request['keywordType'] == 'ALL') {
      $where[] = "A.AFFLIATE_ID LIKE ?";
      $params[] = "%{$request['keyword']}%";
      $types .= 's';
    }

    if ($request['keywordType'] == 'EQMERCHANT') {
      $where[] = "A.MERCHANT_ID = ?";
      $params[] = $request['keyword'];
      $types .= 's';
    } else if ($request['keywordType'] == 'EQSITE') {
      $where[] = "A.SITE = ?";
      $params[] = $request['keyword'];
      $types .= 's';
    } else if ($request['keywordType'] == 'EQCAMPAIGN') {
      $where[] = "A.CAMPAIGN_NUM = ?";
      $params[] = $request['keyword'];
      $types .= 's';
    } else if ($request['keywordType'] == 'EQAFFLIATE') {
      $where[] = "A.AFFLIATE_ID = ?";
      $params[] = $request['keyword'];
      $types .= 's';
    }
  }

  // 타입별 검색
  if ($request['type'] == 'MERCHANT') {
    $where[] = "A.MERCHANT_ID = ?";
    $params[] = $request['searchId'];
    $types .= 's';
  } else if ($request['type'] == 'AFFLIATE') {
    $where[] = "A.AFFLIATE_ID = ?";
    $params[] = $request['searchId'];
    $types .= 's';
  } else if ($request['type'] == 'AGENCY') {
    $where[] = "A.AGENCY_ID = ?";
    $params[] = $request['searchId'];
    $types .= 's';
  }

  $sql = "
          SELECT 
              A.*,
              COUNT(*) as CNT,
              SUM(CLICK_CNT) as CLICK_CNT,
              SUM(REWARD_CNT) as REWARD_CNT,
              CASE 
                  WHEN SUM(CLICK_CNT) = 0 THEN 0
                  ELSE ROUND(
                      (CASE 
                          WHEN '{$request['cancelYn']}' = 'N' THEN SUM(CONFIRM_REWARD_CNT)
                          WHEN '{$request['cancelYn']}' = 'Y' THEN SUM(CANCEL_REWARD_CNT)
                          ELSE SUM(REWARD_CNT)
                      END / SUM(CLICK_CNT) * 100
                      ), 2
                  )
              END as REWARD_RATE,
              SUM(PRODUCT_PRICE) as PRODUCT_PRICE,
              SUM(COMMISSION) as COMMISSION,
              SUM(COMMISSION_PROFIT) as COMMISSION_PROFIT,
              SUM(AFFLIATE_COMMISSION) as AFFLIATE_COMMISSION,
              SUM(USER_COMMISSION) as USER_COMMISSION
          FROM (
              SELECT 
                REG_YM,
                REG_DAY,
                CAMPAIGN_NUM,
                AFFLIATE_ID,
                MERCHANT_ID,
                AGENCY_ID,
                ZONE_ID,
                SITE,
                OS,
                MEMBER_NAME,
                CAMPAIGN_NAME,
                AFFLIATE_NAME,
                AGENCY_NAME,
                CLICK_CNT,
                REWARD_CNT,
                CONFIRM_REWARD_CNT,
                CANCEL_REWARD_CNT,
                PRODUCT_PRICE,
                CONFIRM_PRODUCT_PRICE,
                CANCEL_PRODUCT_PRICE,
                COMMISSION,
                COMFIRM_COMMISSION,
                CANCEL_COMMISSION,
                COMMISSION_PROFIT,
                COMFIRM_COMMISSION_PROFIT,
                CANCEL_COMMISSION_PROFIT,
                AFFLIATE_COMMISSION,
                COMFIRM_AFFLIATE_COMMISSION,
                CANCEL_AFFLIATE_COMMISSION,
                USER_COMMISSION,
                COMFIRM_USER_COMMISSION,
                CANCEL_USER_COMMISSION
              FROM 
                  SUMMARY_DAY
          ) A
          ";

  $sql .= (!empty($where) ? "WHERE " . implode(" AND ", $where) : "");

  // 그룹핑 설정
  if ($request['searchType']) {
    $groupBy = "";
    if ($request['searchType'] == 'DAY') {
      $groupBy = "GROUP BY A.REG_DAY";
    } else if ($request['searchType'] == 'MONTH') {
      $groupBy = "GROUP BY A.REG_YM";
    } else if ($request['searchType'] == 'MERCHANT') {
      $groupBy = "GROUP BY A.MERCHANT_ID";
    } else if ($request['searchType'] == 'CAMPAIGN') {
      $groupBy = "GROUP BY A.CAMPAIGN_NUM";
    } else if ($request['searchType'] == 'AFFLIATE') {
      $groupBy = "GROUP BY A.AFFLIATE_ID";
    } else if ($request['searchType'] == 'SITE') {
      $groupBy = "GROUP BY A.SITE";
    }
    $sql .= " " . $groupBy;
  }

  // 정렬 조건
  if ($request['orderByName']) {
    $columnMap = [
      'regDay' => 'REG_DAY',
      'regYm' => 'REG_YM',
      'memberName' => 'MEMBER_NAME',
      'campaignName' => 'CAMPAIGN_NAME',
      'affliateName' => 'AFFLIATE_NAME',
      'site' => 'SITE',
      'agencyName' => 'AGENCY_NAME',
      'cnt' => 'CNT',
      'clickCnt' => 'CLICK_CNT',
      'rewardCnt' => 'REWARD_CNT',
      'productPrice' => 'PRODUCT_PRICE',
      'commissionProfit' => 'COMMISSION_PROFIT'
    ];

    if (array_key_exists($request['orderByName'], $columnMap)) {
      $sql .= " ORDER BY A.{$columnMap[$request['orderByName']]} {$request['orderBy']}";
    } else if ($request['orderByName'] == 'rewardRate') {
      $sql .= " ORDER BY REWARD_RATE {$request['orderBy']}";
    } else {
      $sql .= " ORDER BY SUM({$request['orderByName']}) {$request['orderBy']}";
    }
  }

  // 페이징
  $sql .= " LIMIT ?, ?";
  $params[] = ($request['page'] * ($request['size'] ?: 40));
  $params[] = ($request['size'] ?: 40);
  $types .= 'ii';

  $stmt = mysqli_stmt_init($con);
  if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // 취소 여부에 따른 데이터 처리
    foreach ($data as &$row) {
      if ($request['cancelYn'] == 'Y') {
        $row['REWARD_CNT'] = $row['CANCEL_REWARD_CNT'];
        $row['PRODUCT_PRICE'] = $row['CANCEL_PRODUCT_PRICE'];
        $row['COMMISSION'] = $row['CANCEL_COMMISSION'];
        $row['COMMISSION_PROFIT'] = $row['CANCEL_COMMISSION_PROFIT'];
        $row['AFFLIATE_COMMISSION'] = $row['CANCEL_AFFLIATE_COMMISSION'];
        $row['USER_COMMISSION'] = $row['CANCEL_USER_COMMISSION'];
      } else if ($request['cancelYn'] == 'N') {
        $row['REWARD_CNT'] = $row['COMFIRM_REWARD_CNT'];
        $row['PRODUCT_PRICE'] = $row['COMFIRM_PRODUCT_PRICE'];
        $row['COMMISSION'] = $row['COMFIRM_COMMISSION'];
        $row['COMMISSION_PROFIT'] = $row['COMFIRM_COMMISSION_PROFIT'];
        $row['AFFLIATE_COMMISSION'] = $row['COMFIRM_AFFLIATE_COMMISSION'];
        $row['USER_COMMISSION'] = $row['COMFIRM_USER_COMMISSION'];
      }
      if ($request['searchType'] == 'DAY') {
        $row['keyWord'] = $row['REG_DAY'];
        $row['keyWordName'] = $row['REG_DAY'];
      } else if ($request['searchType'] == 'MONTH') {
        $row['keyWord'] = $row['REG_YM'];
        $row['keyWordName'] = $row['REG_YM'];
      } else if ($request['searchType'] == 'MERCHANT') {
        $row['keyWord'] = $row['MERCHANT_ID'];
        $row['keyWordName'] = $row['MEMBER_NAME'];
      } else if ($request['searchType'] == 'CAMPAIGN') {
        $row['keyWord'] = $row['CAMPAIGN_NUM'];
        $row['keyWordName'] = $row['CAMPAIGN_NAME'];
      } else if ($request['searchType'] == 'AFFLIATE') {
        $row['keyWord'] = $row['AFFLIATE_ID'];
        $row['keyWordName'] = $row['AFFLIATE_NAME'];
      } else if ($request['searchType'] == 'SITE') {
        $row['keyWord'] = $row['SITE'];
        $row['keyWordName'] = $row['SITE'];
      }
    }
  }
  return $data;
}

// 데이터 조회 함수 호출
try {
  // 데이터 조회 함수 호출
  $result = getSummarySearch($request);

  if (empty($result)) {
    $response = [
      'resultCode' => '9001',
      'resultMessage' => '조회된 데이터가 없습니다.',
      'datas' => [],
      'totalCount' => 0
    ];
  } else {
    // 합계 계산
    $totalCount = count($result);
    $cnt = 0;
    $clickCnt = 0;
    $rewardCnt = 0;
    $productPrice = 0;
    $commission = 0;
    $commissionProfit = 0;
    $affliateCommission = 0;
    $userCommission = 0;

    foreach ($result as $row) {
      $cnt += $row['CNT'];
      $clickCnt += $row['CLICK_CNT'];
      $rewardCnt += $row['REWARD_CNT'];
      $productPrice += $row['PRODUCT_PRICE'];
      $commission += $row['COMMISSION'];
      $commissionProfit += $row['COMMISSION_PROFIT'];
      $affliateCommission += $row['AFFLIATE_COMMISSION'];
      $userCommission += $row['USER_COMMISSION'];
    }

    $response = [
      'resultCode' => '0000',
      'resultMessage' => '성공',
      'totalCount' => $totalCount,
      'cnt' => $cnt,
      'clickCnt' => $clickCnt,
      'rewardCnt' => $rewardCnt,
      'productPrice' => $productPrice,
      'commission' => $commission,
      'commissionProfit' => $commissionProfit,
      'affliateCommission' => $affliateCommission,
      'userCommission' => $userCommission,
      'data' => $result
    ];
  }
} catch (Exception $e) {

  $response = [
    'resultCode' => '9999',
    'resultMessage' => '조회 중 오류가 발생했습니다.',
    'datas' => [],
    'totalCount' => 0
  ];
  error_log("Summary Search Error - Request: " . json_encode($request) . ", Error: " . $e->getMessage());
}


// JSON 응답 반환
header('Content-Type: application/json');
echo json_encode($response);
exit;

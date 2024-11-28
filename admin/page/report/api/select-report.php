<?
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
$page = $inputData['page'] ?? 1;
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
      $where[] = "(A.CAMPAIGN_NAME LIKE ? OR A.CAMPAIGN_NUM LIKE ?)";
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

  // 그룹핑 설정
  if ($request['searchType']) {
    $groupBy = "";
    if ($request['searchType'] == 'DAY') {
      $groupBy = "A.REG_DAY";
      $sqlKeyword = "A.REG_DAY";
      $sqlKeywordName = "A.REG_DAY";
    } else if ($request['searchType'] == 'MONTH') {
      $groupBy = "A.REG_YM";
      $sqlKeyword = "A.REG_YM";
      $sqlKeywordName = "A.REG_YM";
    } else if ($request['searchType'] == 'MERCHANT') {
      $groupBy = "A.MERCHANT_ID";
      $sqlKeyword = "A.MERCHANT_ID";
      $sqlKeywordName = "A.MERCHANT_NAME";
    } else if ($request['searchType'] == 'CAMPAIGN') {
      $groupBy = "A.CAMPAIGN_NUM";
      $sqlKeyword = "A.CAMPAIGN_NUM";
      $sqlKeywordName = "A.CAMPAIGN_NAME";
    } else if ($request['searchType'] == 'AFFLIATE') {
      $groupBy = "A.AFFLIATE_ID";
      $sqlKeyword = "A.AFFLIATE_ID";
      $sqlKeywordName = "A.AFFLIATE_NAME";
    } else if ($request['searchType'] == 'SITE') {
      $groupBy = "A.SITE";
      $sqlKeyword = "A.SITE";
      $sqlKeywordName = "A.SITE";
    } else if ($request['searchType'] == 'MEMBERAGC') {
      $groupBy = "A.AGENCY_ID";
      $sqlKeyword = "A.AGENCY_ID";
      $sqlKeywordName = "A.AGENCY_NAME";
    } else if ($request['searchType'] == 'MEMBERAFF') {
      $groupBy = "A.AGENCY_ID";
      $sqlKeyword = "A.AGENCY_ID";
      $sqlKeywordName = "A.AGENCY_NAME";
    }
  }

  // 정렬 조건
  if ($request['orderByName']) {
    $orderBy = "";

    $columnMap = [
      'regDay' => 'REG_DAY',
      'regYm' => 'REG_YM',
      'memberName' => 'MEMBER_NAME',
      'campaignName' => 'CAMPAIGN_NAME',
      'affliateName' => 'AFFLIATE_NAME',
      'site' => 'SITE',
      'agencyName' => 'AGENCY_NAME',
      'cnt' => 'CNT',
      'rewardRate' => 'REWARD_RATE',
      'clickCnt' => 'CLICK_CNT',
      'rewardCnt' => 'REWARD_CNT',
      'productPrice' => 'PRODUCT_PRICE',
      'commission' => 'COMMISSION',
      'commissionProfit' => 'COMMISSION_PROFIT'
    ];

    if (array_key_exists($request['orderByName'], $columnMap)) {
      $orderBy = "A.{$columnMap[$request['orderByName']]} {$request['orderBy']}";
    } else {
      $orderBy = "SUM({$request['orderByName']}) {$request['orderBy']}";
    }
  }

  $sql = "
          SELECT A.*
          FROM(
            SELECT 
              {$sqlKeyword} AS KEYWORD, {$sqlKeywordName} AS KEYWORD_NAME,
              A.CNT, A.CLICK_CNT, 
              A.REWARD_CNT, A.PRODUCT_PRICE, A.COMMISSION, A.COMMISSION_PROFIT, A.AFFLIATE_COMMISSION, A.USER_COMMISSION, A.REWARD_RATE,
              A.TOTAL_CNT,
              SUM(A.CNT) OVER() AS TOTAL_VIEW_CNT,
              SUM(A.CLICK_CNT) OVER() AS TOTAL_CLICK_CNT,
              SUM(A.REWARD_CNT) OVER() AS TOTAL_REWARD_CNT,
              SUM(A.PRODUCT_PRICE) OVER() AS TOTAL_PRODUCT_PRICE,
              SUM(A.COMMISSION) OVER() AS TOTAL_COMMISSION,
              SUM(A.COMMISSION_PROFIT) OVER() AS TOTAL_COMMISSION_PROFIT,
              SUM(A.AFFLIATE_COMMISSION) OVER() AS TOTAL_AFFLIATE_COMMISSION,
              SUM(A.USER_COMMISSION) OVER() AS TOTAL_USER_COMMISSION,
              ROUND((SUM(A.REWARD_CNT) OVER() / SUM(A.CLICK_CNT) OVER() * 100), 2) AS TOTAL_REWARD_RATE
            FROM(
              SELECT
                A.REG_DAY, A.REG_YM, A.CAMPAIGN_NUM,
                A.AFFLIATE_ID, A.MERCHANT_ID, A.AGENCY_ID, A.ZONE_ID,
                A.SITE, A.OS, 
                A.MEMBER_NAME, A.CAMPAIGN_NAME, A.AFFLIATE_NAME, A.AGENCY_NAME,
                COUNT(*) OVER() AS TOTAL_CNT,
                SUM(A.CNT) AS CNT,
                SUM(A.CLICK_CNT) AS CLICK_CNT, 
                CASE 
                  WHEN '{$request['cancelYn']}' = 'N' THEN SUM(A.CONFIRM_REWARD_CNT)
                  WHEN '{$request['cancelYn']}' = 'Y' THEN SUM(A.CANCEL_REWARD_CNT)
                  ELSE SUM(A.REWARD_CNT)
                END AS REWARD_CNT,
                CASE 
                  WHEN '{$request['cancelYn']}' = 'N' THEN SUM(A.CONFIRM_PRODUCT_PRICE)
                  WHEN '{$request['cancelYn']}' = 'Y' THEN SUM(A.CANCEL_PRODUCT_PRICE)
                  ELSE SUM(A.PRODUCT_PRICE)
                END AS PRODUCT_PRICE,
                CASE 
                  WHEN '{$request['cancelYn']}' = 'N' THEN SUM(A.COMFIRM_COMMISSION)
                  WHEN '{$request['cancelYn']}' = 'Y' THEN SUM(A.CANCEL_COMMISSION)
                  ELSE SUM(A.COMMISSION)
                END AS COMMISSION,
                CASE 
                  WHEN '{$request['cancelYn']}' = 'N' THEN SUM(A.COMFIRM_COMMISSION_PROFIT)
                  WHEN '{$request['cancelYn']}' = 'Y' THEN SUM(A.CANCEL_COMMISSION_PROFIT)
                  ELSE SUM(A.COMMISSION_PROFIT)
                END AS COMMISSION_PROFIT,
                CASE 
                  WHEN '{$request['cancelYn']}' = 'N' THEN SUM(A.COMFIRM_AFFLIATE_COMMISSION)
                  WHEN '{$request['cancelYn']}' = 'Y' THEN SUM(A.CANCEL_AFFLIATE_COMMISSION)
                  ELSE SUM(A.AFFLIATE_COMMISSION)
                END AS AFFLIATE_COMMISSION,
                CASE 
                  WHEN '{$request['cancelYn']}' = 'N' THEN SUM(A.COMFIRM_USER_COMMISSION)
                  WHEN '{$request['cancelYn']}' = 'Y' THEN SUM(A.CANCEL_USER_COMMISSION)
                  ELSE SUM(A.USER_COMMISSION)
                END AS USER_COMMISSION,
                CASE 
                  WHEN SUM(CLICK_CNT) = 0 THEN 0
                  ELSE ROUND(
                      (CASE 
                          WHEN '{$request['cancelYn']}' = 'N' THEN SUM(A.CONFIRM_REWARD_CNT)
                          WHEN '{$request['cancelYn']}' = 'Y' THEN SUM(A.CANCEL_REWARD_CNT)
                          ELSE SUM(A.REWARD_CNT)
                      END / SUM(A.CLICK_CNT) * 100
                      ), 2
                  )
                END as REWARD_RATE
              FROM SUMMARY_DAY A
              " . (!empty($where) ? "WHERE " . implode(" AND ", $where) : "") . "
              " . (!empty($groupBy) ? "GROUP BY " . $groupBy : "") . "
            )A
            " . (!empty($orderBy) ? "ORDER BY " . $orderBy : "") . "
          )A
          LIMIT ?, ?
          ";

  $page = (int)(isset($request['page']) ? $request['page'] : 1);
  $per = $request['size'];
  $page_int = ($page - 1) * $per;

  $params[] = $page_int;
  $params[] = $per;
  $types .= 'ii';

  $stmt = mysqli_stmt_init($con);
  if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    $totalCount = $result[0]['TOTAL_CNT'];
    $cnt = $result[0]['TOTAL_VIEW_CNT'];
    $clickCnt = $result[0]['TOTAL_CLICK_CNT'];
    $rewardCnt = $result[0]['TOTAL_REWARD_CNT'];
    $productPrice = $result[0]['TOTAL_PRODUCT_PRICE'];
    $commission = $result[0]['TOTAL_COMMISSION'];
    $commissionProfit = $result[0]['TOTAL_COMMISSION_PROFIT'];
    $affliateCommission = $result[0]['TOTAL_AFFLIATE_COMMISSION'];
    $userCommission = $result[0]['TOTAL_USER_COMMISSION'];
    $rewardRate = $result[0]['TOTAL_REWARD_RATE'] ?? 0;

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
      'rewardRate' => $rewardRate,
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

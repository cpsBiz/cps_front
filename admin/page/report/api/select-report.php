<? include_once $_SERVER['DOCUMENT_ROOT'] . "/db_config.php"; ?>
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
  global $con;

  $where = [];
  $params = [];
  $types = '';

  // 날짜 조건
  if ($request['dayType'] == 'MONTH') {
    $where[] = "reg_ym BETWEEN ? AND ?";
    $params[] = $request['regStart'];
    $params[] = $request['regEnd'];
    $types .= 'ss';
  } else if ($request['dayType'] == 'DAY') {
    $where[] = "reg_day BETWEEN ? AND ?";
    $params[] = $request['regStart'];
    $params[] = $request['regEnd'];
    $types .= 'ss';
  } else if ($request['dayType'] == 'EQMONTH') {
    $where[] = "reg_ym = ?";
    $params[] = $request['keyword'];
    $types .= 's';
  } else {
    $where[] = "reg_day = ?";
    $params[] = $request['keyword'];
    $types .= 's';
  }

  // OS 조건
  if ($request['os'] == 'PC') {
    $where[] = "A.os = 'PC'";
  } else if ($request['os'] == 'MOBILE') {
    $where[] = "A.os IN ('IOS', 'AOS')";
  }

  // 검색어 조건
  if (!empty($request['keyword'])) {
    if ($request['keywordType'] == 'MERCHANT' || $request['keywordType'] == 'ALL') {
      $where[] = "(A.member_name LIKE ? OR A.merchant_id LIKE ?)";
      $params[] = "%{$request['keyword']}%";
      $params[] = "%{$request['keyword']}%";
      $types .= 'ss';
    }
    if ($request['keywordType'] == 'SITE' || $request['keywordType'] == 'ALL') {
      $where[] = "A.site LIKE ?";
      $params[] = "%{$request['keyword']}%";
      $types .= 's';
    }
    if ($request['keywordType'] == 'CAMPAIGN' || $request['keywordType'] == 'ALL') {
      $where[] = "(A.campaign_name LIKE ? OR A.campaign_id LIKE ?)";
      $params[] = "%{$request['keyword']}%";
      $params[] = "%{$request['keyword']}%";
      $types .= 'ss';
    }
    if ($request['keywordType'] == 'AFFLIATE' || $request['keywordType'] == 'ALL') {
      $where[] = "A.affliate_id LIKE ?";
      $params[] = "%{$request['keyword']}%";
      $types .= 's';
    }

    if ($request['keywordType'] == 'EQMERCHANT') {
      $where[] = "A.merchant_id = ?";
      $params[] = $request['keyword'];
      $types .= 's';
    } else if ($request['keywordType'] == 'EQSITE') {
      $where[] = "A.site = ?";
      $params[] = $request['keyword'];
      $types .= 's';
    } else if ($request['keywordType'] == 'EQCAMPAIGN') {
      $where[] = "A.campaign_num = ?";
      $params[] = $request['keyword'];
      $types .= 's';
    } else if ($request['keywordType'] == 'EQAFFLIATE') {
      $where[] = "A.affliate_id = ?";
      $params[] = $request['keyword'];
      $types .= 's';
    }
  }

  // 타입별 검색
  if ($request['type'] == 'MERCHANT') {
    $where[] = "A.merchant_id = ?";
    $params[] = $request['searchId'];
    $types .= 's';
  } else if ($request['type'] == 'AFFLIATE') {
    $where[] = "A.affliate_id = ?";
    $params[] = $request['searchId'];
    $types .= 's';
  } else if ($request['type'] == 'AGENCY') {
    $where[] = "A.agency_id = ?";
    $params[] = $request['searchId'];
    $types .= 's';
  }

  $sql = "
          SELECT 
              A.*,
              COUNT(*) as CNT,
              SUM(CLICK_CNT) as CLICK_CNT,
              SUM(REWARD_CNT) as REWARD_CNT,
              SUM(PRODUCT_PRICE) as PRODUCT_PRICE,
              SUM(COMMISSION) as COMMISSION,
              SUM(COMMISSION_PROFIT) as COMMISSION_PROFIT,
              SUM(AFFLIATE_COMMISSION) as AFFLIATE_COMMISSION,
              SUM(USER_COMMISSION) as USER_COMMISSION
          FROM (
              SELECT 
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
                PRODUCT_PRICE,
                COMMISSION,
                COMMISSION_PROFIT,
                AFFLIATE_COMMISSION,
                USER_COMMISSION,
                CANCEL_REWARD_CNT,
                CANCEL_PRODUCT_PRICE,
                CANCEL_COMMISSION,
                CANCEL_COMMISSION_PROFIT,
                CANCEL_AFFLIATE_COMMISSION,
                CANCEL_USER_COMMISSION,
                COMFIRM_COMMISSION,
                COMFIRM_COMMISSION_PROFIT,
                COMFIRM_AFFLIATE_COMMISSION,
                COMFIRM_USER_COMMISSION
              FROM 
                  SUMMARY_DAY
              WHERE 
                  1=1
          ) A
          " . (!empty($where) ? "WHERE " . implode(" AND ", $where) : "");

  // 그룹핑 설정
  if ($request['searchType']) {
    $groupBy = "";
    if ($request['searchType'] == 'DAY') {
      $groupBy = "GROUP BY A.reg_day";
    } else if ($request['searchType'] == 'MONTH') {
      $groupBy = "GROUP BY A.reg_ym";
    } else if ($request['searchType'] == 'MERCHANT') {
      $groupBy = "GROUP BY A.merchant_id";
    } else if ($request['searchType'] == 'CAMPAIGN') {
      $groupBy = "GROUP BY A.campaign_num";
    } else if ($request['searchType'] == 'AFFLIATE') {
      $groupBy = "GROUP BY A.affliate_id";
    } else if ($request['searchType'] == 'SITE') {
      $groupBy = "GROUP BY A.site";
    }
    $sql .= " " . $groupBy;
  }

  // 정렬 조건
  if ($request['orderByName']) {
    if (in_array($request['orderByName'], ['reg_day', 'reg_ym', 'member_name', 'campaign_name', 'affliate_name', 'site', 'agency_name'])) {
      $sql .= " ORDER BY A.{$request['orderByName']} {$request['orderBy']}";
    } else if ($request['orderByName'] == 'reward_rate') {
      $sql .= " ORDER BY (SUM(reward_cnt) / SUM(click_cnt)) {$request['orderBy']}";
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
        $row['reward_cnt'] = $row['cancel_reward_cnt'];
        $row['product_price'] = $row['cancel_product_price'];
        $row['commission'] = $row['cancel_commission'];
        $row['commission_profit'] = $row['cancel_commission_profit'];
        $row['affliate_commission'] = $row['cancel_affliate_commission'];
        $row['user_commission'] = $row['cancel_user_commission'];
      } else if ($request['cancelYn'] == 'N') {
        $row['reward_cnt'] = $row['confirm_reward_cnt'];
        $row['product_price'] = $row['confirm_product_price'];
        $row['commission'] = $row['confirm_commission'];
        $row['commission_profit'] = $row['confirm_commission_profit'];
        $row['affliate_commission'] = $row['confirm_affliate_commission'];
        $row['user_commission'] = $row['confirm_user_commission'];
      }
    }

    mysqli_stmt_close($stmt);
  }

  mysqli_close($con);
  return $data;
}

// 데이터 조회 함수 호출
$result = getSummarySearch($request);

// JSON 응답 반환
header('Content-Type: application/json');
echo json_encode([
  'resultCode' => '0000',
  'data' => $result
]);
exit;
?>
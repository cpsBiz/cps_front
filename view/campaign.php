<?
$url = $_SERVER['REQUEST_URI'];
// URL에서 쿼리스트링 추출
$parsedUrl = parse_url($url);
$query = $parsedUrl['query'];

// 쿼리스트링을 배열로 변환
parse_str($query, $params);

// 'apiUrl' 이전의 파라미터만 추출
$clickUrl = '';
foreach ($params as $key => $value) {
  if ($key == 'apiUrl') {
    break; // 'apiUrl' 이후는 무시
  }
  $filteredParams[$key] = $value;
  if ($key === 'clickUrl') {
    $clickUrl .= $value;
  } else {
    $clickUrl .= $key . '=' . $value;
  }
}
$apiUrl = $_REQUEST['apiUrl'];
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>쇼핑적립 상세정보</title>
  <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
  <!-- style -->
  <link rel="stylesheet" href="./css/style.css">
  <script type="text/javascript" src="../admin/js/lib/jquery-2.2.2.min.js"></script>
  <script type="text/javascript" src="../admin/js/lib/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="../admin/js/lib/jquery-ui.min.js"></script>
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>쇼핑적립 상세정보</h1>
      <div class="btn-list">
        <a href="./index.php" class="ico-arrow type1 left">이전</a>
      </div>
    </header>
    <!-- main -->
    <!-- hana 클래스 추가 시 시그니처 컬러 변경 -->
    <div class="sub sub-2-1">
      <div class="cont cont1">
        <div class="box box1">
          <div class="title">
            <p>알리익스프레스 쇼핑하고</p>
            <p class="blue">최대<span>2.45%</span></p>
            <p>적립 받으세요!</p>
          </div>
          <div class="logo" style="background-image: url(./images/test/쿠팡.png);"></div>
        </div>
        <div class="box box2">
          <div class="gray-box">
            <p><span>적립시점</span>구매 완료 후 1시간 이내</p>
            <p><span>적립확정</span>구매 확정 후 2개월 뒤 월 말</p>
          </div>
        </div>
        <div class="box box3">
          <a href="./qna.php">적립에 문제가 있다면 1:1 문의하기<span class="ico-arrow type1 right"></span></a>
        </div>
        <div class="box box4">
          <p class="sub-title">적립 대상</p>
          <div class="gray-box">
            <p>해드폰 악세사리/인테리어 <span class="percent">6.3%</span></p>
            <p>PC 주변기기/태블릿 <span class="percent">2.1%</span></p>
            <p>그 외 기타상품 <span class="percent">4.9%</span></p>
          </div>
          <p class="sub-title">제외 대상</p>
          <div class="gray-box">
            <p>기프트카드 구매건</p>
            <p>특정 셀러에서 구매한 상품</p>
            <p>주문건 환불, 교환, 취소 시</p>
          </div>
        </div>
        <div class="box box5">
          <p>유의사항</p>
          <ul>
            <li>유의사항 1번입니다유의사항 1번입니다.유의사항 1번입니다.</li>
            <li>유의사항 1번입니다유의사항 2번입니다.유의사항 2번입니다.</li>
            <li>유의사항 1번입니다유의사항 3번입니다.유의사항 3번입니다.</li>
            <li>유의사항 1번입니다유의사항 4번입니다.유의사항 4번입니다.</li>
          </ul>
        </div>
        <input type="hidden" id="apiUrl" value="<?= $apiUrl; ?>">
        <input type="hidden" id="clickUrl" value="<?= $clickUrl; ?>">
        <a id="buttonUrl" class="submit-btn on" href="">쇼핑하고 적립받기</a>
      </div>
    </div>
  </div>
  <script src="./js/common.js"></script>
  <script src="./js/page.js"></script>
</body>

</html>
<script>
  $(function() {
    checkParam();
  })

  function checkParam() {
    const apiUrl = '<?= $apiUrl; ?>';
    const clickUrl = '<?= $clickUrl; ?>';

    const checkApiUrl = document.getElementById('apiUrl').value;
    const checkClickUrl = document.getElementById('clickUrl').value;
    if (apiUrl === checkApiUrl && clickUrl === checkClickUrl) {
      getClickRewardUrl(apiUrl, clickUrl);
    } else {
      alert('잘못된 접근입니다.')
      history.back();
    }
  }

  function getClickRewardUrl(apiUrl, clickUrl) {
    try {
      const campaignNum = 0;
      const affliateId = 'string';
      const zoneId = 'string';
      const agencyId = 'string';
      const merchantId = 'string';
      const type = '';
      const site = '';
      const os = 'aos';
      const userId = 'string';
      const adId = '';

      // AJAX 요청 데이터 설정
      const requestData = {
        campaignNum,
        affliateId,
        zoneId,
        agencyId,
        merchantId,
        type,
        site,
        clickUrl,
        os,
        userId,
        adId,
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: apiUrl,
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const buttonUrl = result.data.clickUrl;
          if (!buttonUrl) {
            alert('잘못된 접근입니다.');
            history.back();
            return;
          }
          $('#buttonUrl').attr('href', buttonUrl);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error.message);
    }
  }
</script>
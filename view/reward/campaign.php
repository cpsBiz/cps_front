<?

$object = $_REQUEST['object'] ?? null; // null로 기본값 설정
if (!$object) {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  exit;
}


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
$campaignNum = $_REQUEST['campaignNum'];
$merchantId = $_REQUEST['merchantId'];
$agencyId = $_REQUEST['agencyId'];
$affliateId = $_REQUEST['affliateId'];
$site = $_REQUEST['site'];
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>쇼핑적립 상세정보</title>
  <link rel="icon" type="image/x-icon" href="/view/images/favicon.ico">
  <!-- style -->
  <link rel="stylesheet" href="/view/css/style.css">
  <script type="text/javascript" src="/admin/js/lib/jquery-2.2.2.min.js"></script>
  <script type="text/javascript" src="/admin/js/lib/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="/admin/js/lib/jquery-ui.min.js"></script>
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>쇼핑적립 상세정보</h1>
      <div class="btn-list">
        <a href="/view/index.php" class="ico-arrow type1 left">이전</a>
      </div>
    </header>
    <!-- main -->
    <!-- hana 클래스 추가 시 시그니처 컬러 변경 -->
    <div class="sub sub-2-1">
      <div class="cont cont1">
        <div class="box box1">
          <div class="title">
            <p id="campaignName"></p>
            <p id="rewardPerArea" class="blue">최대<span id="campaignRewardPer"></span></p>
            <p>적립 받으세요!</p>
          </div>
          <div id="campaignLogo" class="logo"></div>
        </div>
        <div class="box box2">
          <div id="campaignRewardDate" class="gray-box"></div>
        </div>
        <div class="box box3">
          <a href="/view/inquiry/index.php">적립에 문제가 있다면 1:1 문의하기<span class="ico-arrow type1 right"></span></a>
        </div>
        <div class="box box4">
          <div id="accessProductArea">
            <p class="sub-title">적립 대상</p>
            <div id="campaignAccessProduct" class="gray-box"></div>
          </div>
          <div id="denyProductArea">
            <p class="sub-title">제외 대상</p>
            <div id="campaignDenyProduct" class="gray-box"></div>
          </div>
        </div>
        <div id="noticeArea" class="box box5">
          <p>유의사항</p>
          <ul id="campaignNotice"></ul>
        </div>
        <input type="hidden" id="apiUrl" value="<?= $apiUrl; ?>">
        <input type="hidden" id="clickUrl" value="<?= $clickUrl; ?>">
        <input type="hidden" id="campaignNum" value="<?= $campaignNum; ?>">
        <a id="buttonUrl" class="submit-btn on" href="">쇼핑하고 적립받기</a>
      </div>
    </div>
  </div>
</body>
<script src="/view/js/common.js"></script>
<script src="/view/js/page.js"></script>

</html>
<script>
  const object = decodeFromBase64(`<?= $object ?>`);

  $(function() {
    checkParam(object);
  })

  function checkParam(object) {
    if (!object) {
      alert('잘못된 접근입니다.');
      history.back();
      return;
    }
    const apiUrl = object.apiUrl;
    const clickUrl = object.clickUrl;
    const campaignNum = object.campaignNum;

    if (apiUrl && clickUrl && campaignNum) {
      getClickRewardUrl(apiUrl, clickUrl, campaignNum);
    } else {
      alert('잘못된 접근입니다.')
      history.back();
    }
  }

  function getClickRewardUrl(apiUrl, clickUrl, campaignNum) {
    try {
      const affliateId = object.affliateId;
      const zoneId = 'zonedhhan';
      const agencyId = object.agencyId;
      const merchantId = object.merchantId;
      const type = '';
      const site = object.site;
      const os = 'aos';
      const userId = 'dhhan';
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

          getCampaignData(campaignNum);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error.message);
    }
  }

  function getCampaignData(campaignNum) {
    try {
      // AJAX 요청 데이터 설정
      const requestData = {
        campaignNum,
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: 'http://192.168.101.156/api/admin/campaignList',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const data = result.datas[0];
          if (!data) {
            alert('존재하지않는 캠페인입니다.')
            history.back();
            return;
          }
          renderCampaignData(data);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error.message);
    }
  }

  function renderCampaignData(data) {
    // 이름
    const name = data.memberName + ' 쇼핑하고';
    $('#campaignName').append(name);

    // 로고
    const logo = data.logo;
    if (logo) $('#campaignLogo').css('background-image', `url(${logo})`);

    // 지급시점
    const commissionPaymentStandard = `<p><span>지급시점</span>${data.commissionPaymentStandard}</p>`;
    $('#campaignRewardDate').append(commissionPaymentStandard);

    // 적립 퍼센트
    const rewardPer = '<?= $_REQUEST['per']; ?>';
    if (!rewardPer) {
      $('#rewardPerArea').css('display', 'none');
    } else {
      $('#campaignRewardPer').append(rewardPer + '%');
    }

    // 적립대상 -> 아직은 데이터가 없음
    // const accessProduct = [{
    //   category: '헤드폰 악세사리/인테리어',
    //   per: '6.3%'
    // }, {
    //   category: 'PC 주변기기/태블릿',
    //   per: '2.1%'
    // }, {
    //   category: '그 외 기타상품',
    //   per: '4.9%'
    // }];
    const accessProduct = [];
    if (accessProduct.length === 0) {
      $('#accessProductArea').css('display', 'none');
    } else {
      let accessProductList = '';
      accessProduct.forEach(item => {
        accessProductList += `<p>${item.category} <span class="percent">${item.per}</span></p>`;
      });
      $('#campaignAccessProduct').append(accessProductList);
    }

    // 제외대상
    const denyProduct = data.denyProduct && data.denyProduct.includes('\r\n') ? data.denyProduct.split('\r\n') : [data.denyProduct];
    if (!denyProduct || denyProduct.length === 0 || !denyProduct[0]) {
      $('#denyProductArea').css('display', 'none');
    } else {
      let denyProductList = '';
      denyProduct.forEach(item => {
        denyProductList += `<p>${item}</p>`;
      });
      $('#campaignDenyProduct').append(denyProductList);
    }

    // 유의사항
    const notice = data.notice && data.notice.includes('\r\n') ? data.notice.split('\r\n') : [data.notice];
    if (!notice || notice.length === 0 || !notice[0]) {
      $('#noticeArea').css('display', 'none');
    } else {
      let noticeList = '';
      notice.forEach(item => {
        noticeList += `<li>${item}</li>`;
      });
      $('#campaignNotice').append(noticeList);
    }
  }
</script>
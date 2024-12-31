<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<?
$object = $_REQUEST['object'] ?? null; // null로 기본값 설정
if (!$object) {
  header('Location: /main.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>쇼핑적립 상세정보</title>
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>쇼핑적립 상세정보</h1>
      <div class="btn-list">
        <a href="javascript:moveBack();" class="ico-arrow type1 left">이전</a>
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
          <a href="javascript:goInquiry()">적립에 문제가 있다면 1:1 문의하기<span class="ico-arrow type1 right"></span></a>
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
        <input type="hidden" id="campaignNum" value="">
        <div class="fixed-bottom">
          <a id="buttonUrl" class="submit-btn on" href="">쇼핑하고 적립받기</a>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="<?= $appApiUrl; ?>/js/common.js?version=<?= $cacheVersion; ?>"></script>
<script src="<?= $appApiUrl; ?>/js/page.js?version=<?= $cacheVersion; ?>"></script>

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
    document.getElementById('campaignNum').value = campaignNum;

    if (apiUrl && clickUrl && campaignNum) {
      getCampaignData(campaignNum);
      $('#buttonUrl').attr('href', `javascript:getClickRewardUrl('${apiUrl}', '${clickUrl}', ${campaignNum})`);
    } else {
      alert('잘못된 접근입니다.')
      history.back();
    }
  }

  function getClickRewardUrl(apiUrl, clickUrl, campaignNum) {
    try {
      $('#buttonUrl').attr('href', 'javascript:void(0)');

      const affliateId = '<?= $checkAffliateId; ?>';
      const zoneId = '<?= $checkZoneId; ?>';
      const agencyId = object.agencyId;
      const merchantId = object.merchantId;
      const site = '<?= $checkSite; ?>';
      const os = getOs();
      const userId = '<?= $checkUserId; ?>';
      const adId = '<?= $checkAdId; ?>';

      // AJAX 요청 데이터 설정
      const requestData = {
        campaignNum,
        affliateId,
        zoneId,
        agencyId,
        merchantId,
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

          location.href = buttonUrl;
          $('#buttonUrl').attr('href', `javascript:getClickRewardUrl('${apiUrl}', '${clickUrl}', ${campaignNum})`);
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
        url: '<?= $appApiUrl; ?>/api/view/campaignList',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const data = result.data;
          if (!data) {
            alert('존재하지않는 캠페인입니다.')
            window.close();
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
    let logo = data.logo;
    if (logo && logo.includes('http://')) {
      logo = logo.replace('http://', 'https://');
    }
    if (logo) $('#campaignLogo').css('background-image', `url(${logo})`);

    // 적립예정
    const whenTrans = `<p><span>적립예정</span>${data.whenTrans}</p>`;
    $('#campaignRewardDate').append(whenTrans);

    // 적립확정
    const commissionPaymentStandard = `<p><span>적립확정</span>${data.commissionPaymentStandard}</p>`;
    $('#campaignRewardDate').append(commissionPaymentStandard);

    // 적립 퍼센트
    const rewardPer = object.per;
    if (!rewardPer) {
      $('#rewardPerArea').css('display', 'none');
    } else {
      if (data.memberName === '쿠팡') {
        $('#rewardPerArea').empty();
        $('#rewardPerArea').append('1만원당 막대사탕 1개');
      } else {
        $('#campaignRewardPer').append(rewardPer + '%');
      }
    }

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

    // history.replaceState(null, null, '/reward/campaign.php');
  }

  function goInquiry() {
    const campaignNum = document.getElementById('campaignNum').value;
    if (!campaignNum) return alert('잘못된 접근입니다.');
    location.href = `/inquiry/index.php?campaign=${campaignNum}`;
  }

  function moveBack() {
    history.back();
    return
    try {
      // window.open으로 열린 창인 경우를 위한 처리
      if (window.opener) {
        window.open('', '_self').close();
        return;
      }

      // 이전 페이지가 있는 경우 뒤로가기
      if (window.history.length > 1) {
        window.history.back();
      } else {
        // 대체 URL로 리다이렉트
        window.location.href = '/'; // 메인 페이지 등으로 이동
      }
    } catch (e) {
      console.error('Navigation failed:', e);
    }
  }
</script>
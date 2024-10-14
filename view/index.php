<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>쇼핑적립</title>
  <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
  <script type="text/javascript" src="../admin/js/lib/jquery-2.2.2.min.js"></script>
  <script type="text/javascript" src="../admin/js/lib/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="../admin/js/lib/jquery-ui.min.js"></script>
  <!-- style -->
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./index.css">
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>쇼핑적립</h1>
      <div class="btn-list">
        <a href="./" class="ico-arrow type1 left">이전</a>
        <a href="./" class="ico-home">홈</a>
      </div>
    </header>
    <!-- main -->
    <!-- hana class 추가 시 시그니처 컬러 변경 -->
    <div class="main">
      <div id="event-popup1" class="event-popup on">
        <div class="event-cont">
          <div class="logo" style="background-image: url(./images/test/지마켓.png);"></div>
          <p>지마켓 수수료 2% 상향 이벤트<span>기간 : 10/1 ~ 10/30</span></p>
        </div>
        <a href="javascript:void(0)"></a>
        <button class="close" onclick="eventPopupClose('#event-popup1')"></button>
      </div>
      <div class="point-info-wrap">
        <div class="point-info">
          <div class="text-box">
            <p class="title">총 적립 포인트</p>
            <p class="point"><span class="ico-point"></span>1,230<span class="ico-arrow type2 right"></span></p>
          </div>
          <a href="./sub-5.html"></a>
        </div>
      </div>
      <div class="tab-box-wrap">
        <div class="tab-box">
          <div class="tab tab1 on"><a href="javascript:void(0)">인기순</a></div>
          <div class="tab tab2"><a href="javascript:void(0)">종합몰</a></div>
          <div class="tab tab3"><a href="javascript:void(0)">패션</a></div>
          <div class="tab tab4"><a href="javascript:void(0)">뷰티</a></div>
          <div class="tab tab5"><a href="javascript:void(0)">즐겨찾기</a></div>
        </div>
      </div>
      <div class="list-wrap type1">
        <div class="list list1 type1">
          <p class="title">쿠팡 검색 쇼핑하고 선물 받기</p>
          <div class="info-wrap">
            <a class="candy type1" href="javascript:void(0)">20개</a>
            <div class="coupang-search-wrap">
              <span class="logo">쿠팡</span>
              <input type="text" placeholder="쿠팡에서 검색">
              <a href="javascript:void(0)">검색</a>
            </div>
          </div>
          <div class="link-wrap">
            <div class="link-box"><a href="./sub-2-2.html">당첨내역</a></div>
            <div class="link-box"><a href="./sub-2-3.html">행운의룰렛 GO</a></div>
            <div class="link-box"><a href="./sub-2-4.html">이벤트 안내</a></div>
          </div>
          <button class="ico-heart" type="button"></button>
        </div>
        <div class="campaign-list" id="campaign-list"></div>
      </div>
    </div>
    <div class="bottom-menu-wrap">
      <a class="menu" href="javascript:void(0)"><span class="ico-cart">카트</span></a>
      <a class="menu on" href="./index.html"><span class="ico-save">적립</span></a>
      <a class="menu" href="javascript:void(0)"><span class="ico-trend">트렌드</span></a>
      <a class="menu" href="javascript:void(0)"><span class="ico-delivery">배송</span></a>
      <a class="menu" href="./sub-5.html"><span class="ico-breakDown">내역</span></a>
    </div>
  </div>
  <script src="./js/common.js"></script>
</body>

</html>
<script>
  $(function() {
    getCampaignView();
  })

  function getCampaignView() {
    try {
      const affliateId = '';
      const zoneId = '';
      const site = '';
      const userId = '';
      const adId = '';
      const os = 'AOS';
      const category = '';

      // AJAX 요청 데이터 설정
      const requestData = {
        affliateId,
        zoneId,
        site,
        userId,
        adId,
        os,
        category
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: 'http://192.168.101.156/api/view/campaignView',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          handelCampaingView(result);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error.message);
    }
  }

  function handelCampaingView(result) {
    const data = result.datas;
    console.log(data);
    let list = '';
    data.forEach(item => {
      list += `
              <div class="list">
                <p class="title"><span class="logo" style="background-image: url(${item.logo});"></span>${item.campaignName}</p>
                <p class="percent"><span class="ico-point"></span>3.36%</p>
                <a href="./campaign.php?url=${item.clickUrl}">바로가기</a>
                <button class="ico-heart" type="button">즐겨찾기</button>
              </div>
            `;
    });

    $('#campaign-list').empty();
    $('#campaign-list').append(list);
  }
</script>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>행운의 룰렛</title>
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
      <h1>행운의 룰렛</h1>
      <div class="btn-list">
        <a href="./index.php" class="ico-arrow type1 left">이전</a>
      </div>
    </header>
    <!-- main -->
    <!-- hana 클래스 추가 시 시그니처 컬러 변경 -->
    <div class="sub sub-2-3">
      <div class="title-box">
        <p class="title">갖고 싶은 상품의 브랜드를 선택해주세요.</p>
        <p class="text">브랜드마다 최소 교환 가능한<br>막대사탕 개수를 보고 입장해주세요.</p>
      </div>
      <div class="candy-link-wrap">
        <p class="title">내 막대사탕</p>
        <p class="candy-count"></p>
        <a href="./history-stick.php"></a>
      </div>
      <div class="list-wrap type4"></div>
    </div>

    <!-- popup-wrap -->
    <div id="popup-wrap">
      <!-- popup1 -->
      <div class="roulette-popup popup1">
        <div class="logo-box">
          <div class="logo" style="background-image: url(./images/test/11번가.png);"></div>
          <p class="text">
            스타벅스
            <span>
              20개 이상부터 참여 가능<br>
              룰렛돌리기 참여시 20개 차감
            </span>
          </p>
        </div>
        <p class="candy-info">내가 가진<span></span></p>
        <div class="roulette-wrap">
          <div class="roulette-box">
            <div class="roulette bg-roulette"></div>
            <div class="roulette item-roulette"></div>
            <div class="roulette fix-roulette"></div>
          </div>
        </div>
        <div class="box">
          <div id="rouletteBtn" class="btn-box"></div>
        </div>
        <button class="ico-close type1" type="button" onclick="popupClose('#popup-wrap', '.popup1')">닫기</button>
      </div>

      <!-- popup2 -->
      <div class="popup type2 popup2">
        <div class="box">
          <p>🎉당첨을 축하드립니다!</p>
          <div class="goods-box"></div>
          <div class="btn-box">
            <a href="javascript:void(0)" class="popup-btn" onclick="popupClose('#popup-wrap', '.popup2')">당첨내역 보러가기</a>
          </div>
        </div>
        <button class="ico-close type1" type="button" onclick="popupClose('#popup-wrap', '.popup2')">닫기</button>
      </div>
    </div>
  </div>
  <script src="./js/common.js"></script>
  <script src="./js/page.js"></script>
</body>

</html>
<script>
  $(function() {
    getMemberStick();
    getBrandList();
  });

  // 쿠팡 막대사탕 조회
  function getMemberStick() {
    try {
      const userId = 'dhhan';
      const affliateId = 'moneyweather';

      // AJAX 요청 데이터 설정
      const requestData = {
        userId,
        affliateId
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: 'http://192.168.101.156/api/giftCoupang/coupangStick',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const memberStick = parseInt(result.data.cnt).toLocaleString();
          const appendStick = `${memberStick}개`;
          $('.candy-count, .candy-info span').append(appendStick);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error.message);
    }
  }

  // 룰렛 브랜드 리스트 조회
  function getBrandList() {
    console.log('룰렛 브랜드 리스트 조회');
    return renderBrandList();
    try {
      const requestData = {
        brandId: "string",
        affliateId: "moneyweather",
        merchantId: "coupang",
        apiType: "string",
        brandType: "string",
        brandName: "string",
        brandLogo: "string",
        minCnt: 6,
        brandYn: "string"
      }

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: 'http://192.168.101.156/api/',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          renderBrandList(result);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  // 룰렛 브랜드 리스트 렌더링
  function renderBrandList(data = [1, 2, 3, 4, 5]) {
    console.log('룰렛 브랜드 리스트 렌더링');
    let list = '';

    data.forEach(item => {
      list += `
              <div class="list list1">
                <div class="logo" style="background-image: url(./images/test/홈플러스.png)">스타벅스</div>
                <p class="title">스타벅스<span class="candy-info">20개</span></p>
                <a href="javascript:void(0)" onclick="getGifticonList()"></a>
              </div>
              `;
    })
    $('.list-wrap.type4').empty();
    $('.list-wrap.type4').append(list);
  }

  // 룰렛 기프티콘 리스트 조회
  function getGifticonList() {
    console.log('룰렛 기프티콘 리스트 조회');
    return renderGifticonList();

    try {
      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: 'http://192.168.101.156/api/',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          renderGifticonList(result);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error)
    }
  }

  // 룰렛 기프티콘 리스트 렌더링
  function renderGifticonList(data = [1, 2, 3, 4, 5, 6]) {
    let list = '';
    let i = 1;
    data.forEach(item => {
      list += `
              <div class="item item${i}" style="width: 62px; height: 80px; background-image: url(./images/test/roulette_text.png);"></div>
              `;
      i++;
    });

    $('.roulette.item-roulette').empty();
    $('.roulette.item-roulette').append(list);

    const stickCnt = 20;
    //document.querySelector('.candy-info > span').textContent.replace('개', '');
    const button = `
                  <button class="popup-btn ${stickCnt >= 20 ? '' : 'gray'}" type="button" onclick="getRoulette()" ${stickCnt < 20 ? 'disabled' : ''}>
                  ${stickCnt >= 20 ? '룰렛 돌리기' : '막대사탕 20개부터 참여가능'}
                  </button>
                  `;
    $('#rouletteBtn').empty();
    $('#rouletteBtn').append(button);

    popupOn('#popup-wrap', '.popup1');
  }

  // 룰렛 돌리기
  function getRoulette() {
    try {
      console.log('룰렛 돌리기');

      // AJAX 요청 데이터 설정
      const requestData = {
        userId: "userId11",
        merchantId: "coupang",
        affliateId: "moneyweather",
        brandId: "BR00002",
        cnt: 20
      }

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: 'http://192.168.101.156/api/giftCoupang/coupangGift',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          console.log(result);
          renderRouletteWin();
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  // 룰렛 당첨 내역 렌더링
  function renderRouletteWin() {
    console.log('룰렛 당첨 팝업 렌더링');
    const list = `
                  <div class="img-box" style="background-image: url(./images/test/스타벅스상품.png);"></div>
                  <div class="text-box">
                    <div class="title-box">
                      <div class="logo-box">
                        <div class="logo" style="background-image: url(./images/test/스타벅스로고.png);"></div>
                        <p class="logo-title">스타벅스</p>
                      </div>
                      <p class="title">아이스 카페 아메리카노 T</p>
                    </div>
                    <div class="info-box">
                      <p class="date">지급예정 (2024.10.15)</p>
                    </div>
                  </div>
                  `;
    $('.goods-box').empty();
    $('.goods-box').append(list);
    getMemberStick();
    popupClose('#popup-wrap', '.popup1');
    popupOn('#popup-wrap', '.popup2');
  }
</script>
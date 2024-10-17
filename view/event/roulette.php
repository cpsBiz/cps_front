<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>행운의 룰렛</title>
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
      <h1>행운의 룰렛</h1>
      <div class="btn-list">
        <a href="/view/index.php" class="ico-arrow type1 left">이전</a>
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
        <a href="/view/history/stick.php"></a>
      </div>
      <div class="list-wrap type4"></div>
    </div>

    <!-- popup-wrap -->
    <div id="popup-wrap">
      <!-- popup1 -->
      <div class="roulette-popup popup1">
        <div class="logo-box">
          <div class="logo" style="background-image: url(/view/images/test/11번가.png);"></div>
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
            <a href="/view/history/gifticon.php" class="popup-btn" onclick="popupClose('#popup-wrap', '.popup2')">당첨내역 보러가기</a>
          </div>
        </div>
        <button class="ico-close type1" type="button" onclick="popupClose('#popup-wrap', '.popup2')">닫기</button>
      </div>
    </div>
  </div>
  <script src="/view/js/common.js"></script>
  <script src="/view/js/page.js"></script>
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
          $('.candy-count, .candy-info span').empty();
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
    let list = '';

    data.forEach(item => {
      list += `
              <div class="list list1">
                <div class="logo" style="background-image: url(/view/images/test/홈플러스.png)">스타벅스</div>
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

  const giftListData = [{
    affliateId: 'coupang',
    brandId: 'BR00002',
    brandName: 'GS25',
    productId: 'G00000182491',
    productName: '콘칩'
  }, {
    affliateId: 'coupang',
    brandId: 'BR00002',
    brandName: 'GS25',
    productId: 'G00000182518',
    productName: '초콜릿'
  }, {
    affliateId: 'coupang',
    brandId: 'BR00002',
    brandName: 'GS25',
    productId: 'G00000182520',
    productName: '메로나'
  }, {
    affliateId: 'coupang',
    brandId: 'BR00002',
    brandName: 'GS25',
    productId: 'G00000190659',
    productName: '커피'
  }, {
    affliateId: 'coupang',
    brandId: 'BR00002',
    brandName: 'GS25',
    productId: 'G00000190665',
    productName: '사탕'
  }, {
    affliateId: 'coupang',
    brandId: 'BR00002',
    brandName: 'GS25',
    productId: 'G00000190687',
    productName: '젤리'
  }];

  // 룰렛 기프티콘 리스트 렌더링
  function renderGifticonList(data) {
    let list = '';
    let i = 1;
    giftListData.forEach(item => {
      list += `
              <div class="item item${i}" style="width: 62px; height: 80px; background-image: url();">${item.productName}</div>
              `;
      i++;
    });

    //룰렛 초기화 후 렌더링
    document.querySelector('.roulette.item-roulette').style = '';
    document.querySelector('.roulette.bg-roulette').style = '';
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


  // 서버에서 당첨된 아이템을 받아오는 함수
  function getRoulette() {
    try {
      // AJAX 요청 데이터 설정
      const requestData = {
        userId: "userId11",
        merchantId: "coupang",
        affliateId: "moneyweather",
        brandId: "BR00002",
        cnt: 20
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: 'http://192.168.101.156/api/giftCoupang/coupangGift',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const data = result.data;
          // 룰렛 돌리기
          spin(data);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  // 룰렛 회전 함수 (당첨 아이템에 따라 멈추도록)
  function spin(data) {
    const winningItem = data.productId;
    const totalItems = 6; // 아이템 개수
    const degreePerItem = 360 / totalItems; // 각 아이템이 차지하는 각도
    const roulette = document.querySelector('.roulette-wrap .item-roulette');
    const rouletteBg = document.querySelector('.roulette-wrap .bg-roulette');

    // 당첨 아이템이 무엇인지 매핑
    const itemIndex = giftListData.findIndex(item => item.productId === winningItem);

    // 당첨된 아이템이 맨 위로 오도록 각도를 계산
    const winningDegree = itemIndex * degreePerItem; // 당첨된 아이템에 해당하는 각도
    const totalRotation = 360 * 6 - winningDegree; // 여러 바퀴 돌고 당첨 아이템에서 멈춤

    // 룰렛 회전
    roulette.style.transitionDuration = '3.7s'; // 회전 시간 설정
    roulette.style.transform = `translate(-50%, -50%) rotate(${totalRotation}deg)`; // 룰렛 회전
    // 룰렛 배경 회전
    rouletteBg.style.transitionDuration = '3.7s'; // 회전 시간 설정
    rouletteBg.style.transform = `translate(-50%, -50%) rotate(${totalRotation}deg)`; // 룰렛 회전


    // transitionend 이벤트 리스너 추가 - 룰렛이 멈추면 실행
    roulette.addEventListener('transitionend', function handleTransitionEnd() {
      setTimeout(() => {
        // 룰렛 멈춤 이후 렌더링 함수 실행
        renderRouletteWin(itemIndex);
        // 이벤트 리스너 제거 (한 번만 실행되도록)
        roulette.removeEventListener('transitionend', handleTransitionEnd);
      }, 500);
    });
  }

  // 룰렛 당첨 내역 렌더링
  function renderRouletteWin(itemIndex) {
    const item = giftListData[itemIndex];

    const list = `
                  <div class="img-box" style="background-image: url(/view/images/test/스타벅스상품.png);"></div>
                  <div class="text-box">
                    <div class="title-box">
                      <div class="logo-box">
                        <div class="logo" style="background-image: url(/view/images/test/스타벅스로고.png);"></div>
                        <p class="logo-title">${item.brandName}</p>
                      </div>
                      <p class="title">${item.productName}</p>
                    </div>
                    <div class="info-box">
                      <p class="date">지급예정 (2024.10.15)</p>
                    </div>
                  </div>
                `;

    // 화면에 당첨 상품 표시
    $('.goods-box').empty();
    $('.goods-box').append(list);

    // 추가적인 UI 조작
    getMemberStick();
    popupClose('#popup-wrap', '.popup1');
    popupOn('#popup-wrap', '.popup2');
  }
</script>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>행운의 룰렛</title>
  <!-- style -->

</head>
<style>
  .itemBrand {
    font-size: 9px;
    text-align: center;
  }

  .itemProduct {
    font-size: 11px;
    font-weight: bold;
    text-align: center;
  }

  .itemImage {
    width: 40px;
    height: 40px;
  }
</style>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>행운의 룰렛</h1>
      <div class="btn-list">
        <a href="javascript:history.back()" class="ico-arrow type1 left">이전</a>
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
        <a href="/history/stick.php"></a>
      </div>
      <div class="list-wrap type4"></div>
    </div>

    <!-- popup-wrap -->
    <div id="popup-wrap">
      <!-- popup1 -->
      <div class="roulette-popup popup1">
        <div class="logo-box">
          <div id="roulette-popup-logo" class="logo"></div>
          <p id="roulette-popup-text" class="text"></p>
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
            <a href="/history/gifticon.php" class="popup-btn" onclick="popupClose('#popup-wrap', '.popup2')">당첨내역 보러가기</a>
          </div>
        </div>
        <button class="ico-close type1" type="button" onclick="popupClose('#popup-wrap', '.popup2')">닫기</button>
      </div>
    </div>
  </div>
</body>
<script src="<?= $appApiUrl; ?>/js/common.js?version=<?= $cacheVersion; ?>"></script>
<script src="<?= $appApiUrl; ?>/js/page.js?version=<?= $cacheVersion; ?>"></script>

</html>
<script>
  $(function() {
    getMemberStick();
    getBrandList();
  });

  // 쿠팡 막대사탕 조회
  function getMemberStick() {
    try {
      const userId = '<?= $checkUserId; ?>';
      const merchantId = 'coupang';
      const affliateId = '<?= $checkAffliateId; ?>';
      const site = '<?= $checkSite; ?>';

      // AJAX 요청 데이터 설정
      const requestData = {
        userId,
        merchantId,
        affliateId,
        site
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/view/coupangStick',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const memberStick = parseInt(result.data.cnt - result.data.stockCnt);
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
    try {
      const requestData = {
        affliateId: "<?= $checkAffliateId; ?>",
        site: "<?= $checkSite; ?>",
        brandType: "BRAND",
        merchantId: "coupang"
      }

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/view/giftBrandList',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const data = result.datas;
          renderBrandList(data);
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
  function renderBrandList(data) {
    let list = '';
    data.forEach(item => {
      const itemStr = encodeURIComponent(JSON.stringify(item));
      list += `
              <div class="list list1">
                <div class="logo" style="background-image: url(${item.brandLogo})">${item.brandName}</div>
                <p class="title">${item.brandName}<span class="candy-info">${item.minCnt}개</span></p>
                <a href="javascript:void(0)" onclick="getGifticonList('${item.brandId}', '${itemStr}')"></a>
              </div>
              `;
    })
    $('.list-wrap.type4').empty();
    $('.list-wrap.type4').append(list);
  }

  let giftListData = [];
  let selectedBrandLogo = '';
  // 룰렛 기프티콘 리스트 조회
  function getGifticonList(brandId, brandData) {

    const requestData = {
      brandId,
      affliateId: "<?= $checkAffliateId; ?>",
      site: "<?= $checkSite; ?>",
      merchantId: "coupang"
    }

    try {
      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/view/giftProductList',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const data = result.datas;
          giftListData = data;
          renderGifticonList(giftListData, brandData);
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
  function renderGifticonList(data, brandData) {
    // 브랜드 데이터
    const brandDataObject = JSON.parse(decodeURIComponent(brandData));

    // 룰렛 팝업 로고 초기화 후 렌더링
    selectedBrandLogo = brandDataObject.brandLogo;
    $('#roulette-popup-logo').removeAttr('style');
    $('#roulette-popup-logo').css('background-image', `url(${selectedBrandLogo})`);

    // 룰렛 팝업 텍스트 초기화 후 렌더링
    const minCnt = brandDataObject.minCnt;
    const roulettePopUpText = `
                                ${brandDataObject.brandName}
                                <span>
                                  ${minCnt}개 이상부터 참여 가능<br>
                                  룰렛돌리기 참여시 ${minCnt}개 차감
                                </span>
                              `;
    $('#roulette-popup-text').empty();
    $('#roulette-popup-text').append(roulettePopUpText);

    // 룰렛 기프티콘 리스트 초기화 후 렌더링
    let list = '';
    let i = 1;
    data.forEach(item => {
      list += `
              <div class="item item${i}" style="width: 62px; height: 80px;">
                <p class="itemBrand">${item.brandName}</p>
                <p class="itemProduct">${item.productName}</p>
                <img class="itemImage" src="${item.productImageS}"/>
              </div>
              `;
      i++;
    });

    document.querySelector('.roulette.item-roulette').style = '';
    document.querySelector('.roulette.bg-roulette').style = '';
    $('.roulette.item-roulette').empty();
    $('.roulette.item-roulette').append(list);

    // 룰렛 버튼 초기화 후 렌더링
    const stickCnt = document.querySelector('.candy-info > span').textContent.replace('개', '');
    const button = `
                  <button class="popup-btn ${stickCnt >= minCnt ? '' : 'gray'}" type="button" onclick="getRoulette('${brandDataObject.brandId}', ${minCnt}, ${stickCnt})" ${stickCnt < minCnt ? 'disabled' : ''}>
                  ${stickCnt >= minCnt ? '룰렛 돌리기' : `막대사탕 ${minCnt}개부터 참여가능`}
                  </button>
                  `;
    $('#rouletteBtn').empty();
    $('#rouletteBtn').append(button);

    popupOn('#popup-wrap', '.popup1');
  }


  // 서버에서 당첨된 아이템을 받아오는 함수
  let checkSpin = false;

  function getRoulette(brandId, minCnt, stickCnt) {
    try {
      if (checkSpin) return;
      if (minCnt > stickCnt) return alert('최소 개수가 부족합니다.');

      checkSpin = true;
      // AJAX 요청 데이터 설정
      const requestData = {
        userId: "<?= $checkUserId; ?>",
        merchantId: "coupang",
        affliateId: "<?= $checkAffliateId; ?>",
        site: "<?= $checkSite; ?>",
        brandId,
        cnt: minCnt
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/giftCoupang/coupangGift',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') {
            alert(result.resultMessage);
            checkSpin = false;
            return
          }

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
                  <div class="img-box" style="background-image: url(${item.productImageS});"></div>
                  <div class="text-box">
                    <div class="title-box">
                      <div class="logo-box">
                        <div class="logo" style="background-image: url(${selectedBrandLogo});"></div>
                        <p class="logo-title">${item.brandName}</p>
                      </div>
                      <p class="title">${item.productName}</p>
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
    checkSpin = false;
  }
</script>
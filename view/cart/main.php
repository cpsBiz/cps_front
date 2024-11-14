<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>스마트 카트</title>
  <!-- style -->
  <link rel="stylesheet" href="../css/style.css?version=<?= $cacheVersion; ?>">
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>스마트 카트</h1>
      <div class="btn-list">
        <a href="javascript:history.back()" class="ico-arrow type1 left">이전</a>
        <div>
          <a href="./alarm.html" class="ico-head-alarm">알림</a>
          <a href="./setting.html" class="ico-setting">설정</a>
        </div>
      </div>
    </header>
    <!-- sub-1 -->
    <!-- hana class 추가 시 시그니처 컬러 변경 -->
    <div class="sub sub-1" onclick="toolTipsOff(event, '.tool-tip-line1')">
      <div id="event-popup1" class="event-popup type1 on">
        <div class="event-cont">
          <div class="logo"></div>
          <div class="text-box">
            <p class="text text1">쇼핑몰 방문 후 <span>카트 공유 등록</span>시마다 1포인트씩 하루 최대 3회 적립해 드려요.</p>
            <p class="text text2">이용가이드</p>
          </div>
        </div>
        <a href="javascript:void(0)"></a>
        <button class="close" onclick="eventPopupClose('#event-popup1')"></button>
      </div>
      <div class="point-info-wrap">
        <div class="mix-info">
          <div class="text-box">
            <div class="box box1">
              <p class="title">총 적립현황</p>
              <div id="tool-tip-box1" class="tool-tip-box type2 tool-tip-line1">
                <button class="ico-question" type="button" onclick="toolTipOnOff('#tool-tip-box1', '.tool-tip-line1')">툴팁</button>
                <div class="tool-tip">
                  카트와 적립 메뉴를 통해 제공되는<br>
                  쇼핑몰을 누른 후 이동하여 상품 구매 후<br>
                  구매 확정이 되면 각각 쇼핑몰마다 정해준<br>
                  비율로 포인트가 적립 됩니다.<br>
                  (쿠팡은 포인트가 아닌 막대사탕으로 지급됩니다.)
                </div>
              </div>
            </div>
            <div class="box box2">
              <p id="userCommission" class="point"></p>
              <a href="../history/point.php"></a>
            </div>
          </div>
          <div class="text-box">
            <div class="box box1">
              <p class="title">내 막대사탕</p>
              <div id="tool-tip-box2" class="tool-tip-box type2 tool-tip-line1">
                <button class="ico-question" type="button" onclick="toolTipOnOff('#tool-tip-box2', '.tool-tip-line1')">툴팁</button>
                <div class="tool-tip">
                  쿠팡에서 상품 구매시<br>
                  1만원당 1개의 막대사탕이 적립되며,<br>
                  적립후 30일이 지나면 표시 됩니다.
                </div>
              </div>
            </div>
            <div class="box box2">
              <p id="memberStick" class="point"></p>
              <a href="../history/stick.php"></a>
            </div>
          </div>
        </div>
      </div>
      <!-- 카트 리스트 -->
      <div class="cont cont1">
        <div class="tab-box-wrap type2">
          <div id="folder-list" class="tab-box"></div>
          <button id="select-btn2" class="folder" type="button" onclick="selectInputOn('#select-wrap', '#select-list2')">폴더</button>
        </div>
        <div class="cart-link-list">
          <div class="top">
            <p><span>지금</span> 구매하세요!</p>
            <div id="top-down-btn1" class="select-btn type4" onclick="topDowmBoxOnOff('#top-down-btn1', '.cart-link-list > .bottom')">
              <p class="value"></p>
              <div class="ico-arrow type2 bottom"></div>
            </div>
          </div>
          <div class="bottom">
            <div class="item">
              <div class="text">
                <span></span>
                <p>드디어<br>할인 시작!</p>
              </div>
              <div class="img-box"></div>
              <a href="./sub-1-1.html"></a>
            </div>
          </div>
        </div>
        <div class="stiky-wrap">
          <div class="cart-set-list">
            <div id="select-btn1" class="select-btn type3" onclick="selectListOn('#select-btn1', '#select-wrap', '#select-list1', getCartList)">
              <p class="value">최신순</p>
              <div class="ico-arrow type2 bottom"></div>
            </div>
            <div class="set-list">
              <button type="button" id="select-text1" class="select-text" onclick="cartListOrganizeOn('#select-text1', '.cart-list-wrap', '#bottom-cart-menu1', '#cart-alarm1', '#bottom-popup1', '#cart-heart1')">선택</button>
              <button type="button" class="ico-array one" onclick="cartListType('.cart-set-list .ico-array', '.cart-list-wrap')">정렬</button>
              <button type="button" id="main-heart" class="ico-heart" onclick="onOff('.cart-set-list .ico-heart'), favoritesList('#main-heart', '#cart-list-wrap1'), getFavotiesList()">즐겨찾기</button>
            </div>
          </div>
        </div>

        <!-- 리스트 있을 경우 -->
        <div id="cart-list-wrap1" class="cart-list-wrap type1 one"></div>

        <!-- 전체보기에서 등록된 상품 없을 경우 -->
        <div id="all-cart-list-none" class="list-none-box" style="display: none;">
          <p><span class="ico-nonecart"></span>등록된 상품이 없습니다.</p>
        </div>

        <!-- 폴더에 등록된 상품 없을 경우 -->
        <div id="folder-cart-list-none" class="list-none-box folder" style="display: none;">
          <div class="center">
            <p id="folderItemNone"><span class="ico-nonefolder"></span>[전자기기]<br>폴더가 비어있어요.</p>
            <a href="javascript:void(0)">사용법 보러가기</a>
          </div>
        </div>

      </div>
      <!-- 카트 상품추가 버튼 -->
      <button class="ico-cart-add" type="button" onclick="selectBasicOn('#select-wrap', '#select-list3')">카트 상품추가</button>
      <!-- 토스트 팝업 -->
      <p id="tost1" class="tost-popup">폴더가 추가 되었습니다.</p>
      <p id="tost2" class="tost-popup type2">알림 켜기가 설정 되었습니다.</p>
      <p id="tost3" class="tost-popup type2">알림 끄기가 설정 되었습니다.</p>
      <p id="tost4" class="tost-popup type2">즐겨찾기가 설정 되었습니다.</p>
      <p id="tost5" class="tost-popup type2">즐겨찾기가 해제 되었습니다.</p>
      <p id="tost6" class="tost-popup type2">상품이 삭제 되었습니다.</p>
    </div>
    <!-- 셀렉트 박스 -->
    <div id="select-wrap">
      <!-- 정렬 방식 셀렉트 -->
      <div id="select-list1" class="select-list">
        <div class="select-head">
          <p>정렬 방법을 선택해주세요</p>
          <button class="ico-close type1" type="button" onclick="selectListClose('#select-btn1', '#select-wrap', '#select-list1')">닫기</button>
        </div>
        <ul class="select-cont">
          <li class="list list1 on">
            <p class="value">최신순</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list2">
            <p class="value">할인율순</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list3">
            <p class="value">오래된순</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list4">
            <p class="value">이름순</p>
            <div class="ico-check on"></div>
          </li>
        </ul>
      </div>
      <div id="select-list2" class="select-list type2">
        <div class="select-head">
          <p>폴더 추가</p>
          <button class="ico-close type1" type="button" onclick="selectInputClose('#select-wrap', '#select-list2')">닫기</button>
        </div>
        <ul class="select-cont">
          <input type="text" placeholder="폴더명을 입력해주세요" oninput="inputValueCheck('#select-list2 .select-cont input', '#select-list2 .select-cont .folder-btn')">
          <button
            class="folder-btn"
            type="button"
            onclick="addFolderList(
              '#select-list2 .select-cont input', 
              '.tab-box', 
              '#select-wrap', 
              '#select-list2', 
              '#select-list2 .select-cont .folder-btn',
              '#tost1'
              )">
            확인
          </button>
        </ul>
      </div>
      <div id="select-list3" class="select-list type3">
        <div class="select-head">
          <p>리스트에 <span>상품</span>을 추가해보세요</p>
          <button class="ico-close type1" type="button" onclick="selectBasicClose('#select-wrap', '#select-list3')">닫기</button>
        </div>
        <ul class="select-cont">
          <div class="link">
            <div class="text-box">
              <p class="title">쿠팡에서 상품추가 GO!</p>
              <p class="text">구매금액 1만원 마다 막대사탕을 적립해드려요. 막대사탕으로 100% 당첨 행운의 룰렛 GO GO!!</p>
            </div>
            <a href="https://www.coupang.com/"></a>
          </div>
          <div class="link">
            <div class="text-box">
              <p class="title">다른쇼핑몰에서 상품추가 GO!</p>
              <p class="text">구매금액의 일정 요율을 포인트로 적립해드려요. [적립]메뉴에서 확인하실 수 있어요 :)</p>
            </div>
            <a href="javascript:void(0)" onclick="popupChange('#select-list3', '#select-list4')"></a>
          </div>
          <div class="link">
            <div class="text-box">
              <p class="title">링크로 상품추가 GO!</p>
              <p class="text">쇼핑몰 공유에서 URL 복사 후 붙여넣어주세요.</p>
            </div>
            <a href="javascript:void(0)" onclick="popupChange('#select-list3', '#select-list5')"></a>
          </div>
          <button class="btn" type="button">사용방법 보러가기</button>
        </ul>
      </div>
      <div id="select-list4" class="select-list type3">
        <div class="select-head">
          <p>다른 쇼핑몰에서 상품추가</p>
          <button class="ico-close type1" type="button" onclick="selectBasicClose('#select-wrap', '#select-list4')">닫기</button>
        </div>
        <ul class="select-cont">
          <div class="text-box type1">
            <span class="ico-preparing"></span>
            <p>조금만 기다려주세요.<br>준비중입니다.</p>
          </div>
        </ul>
      </div>
      <div id="select-list5" class="select-list type2">
        <div class="select-head">
          <p>링크로 상품추가</p>
          <button class="ico-close type1" type="button" onclick="selectInputClose('#select-wrap', '#select-list5')">닫기</button>
        </div>
        <ul class="select-cont">
          <input type="text" placeholder="상품공유 클릭 후 복사한 링크를 붙여넣어주세요" oninput="inputValueCheck('#select-list5 .select-cont input', '#select-list5 .select-cont .folder-btn')">
          <button class="folder-btn" type="button">확인</button>
        </ul>
      </div>
    </div>
    <div id="bottom-cart-menu1" class="bottom-cart-menu-wrap type1">
      <button type="button" onclick="bottomCartCancel('#bottom-cart-menu1', '#cart-list-wrap1', '#select-text1', '#cart-alarm1', '#cart-heart1')"><span class="ico-b-cart-cancel"></span>취소</button>
      <button id="cart-alarm1" type="button" onclick="bottomCartAlarm('#cart-alarm1', '#cart-list-wrap1', '#select-text1', '#tost2', '#tost3')"><span class="ico-b-cart-alarm on"></span>알림 켜기</button>
      <button id="cart-heart1" type="button" onclick="bottomCartFavorites('#cart-heart1', '#cart-list-wrap1', '#select-text1', '#tost4', '#tost5')"><span class="ico-b-cart-heart on"></span>즐겨찾기 설정</button>
      <button type="button" onclick="bottomPopupOn('#bottom-popup1', '#cart-list-wrap1')"><span class="ico-b-cart-remove"></span>삭제</button>
    </div>
    <div id="bottom-popup1" class="bottom-popup type1">
      <div class="head">
        <p></p>
        <button class="ico-close type1" type="button" onclick="onOff('#bottom-popup1')">닫기</button>
      </div>
      <div class="btn-box">
        <button type="button" class="gray" onclick="onOff('#bottom-popup1')">취소</button>
        <button type="button" class="blue" onclick="bottomCartRemove('#cart-list-wrap1', '#bottom-popup1', '#bottom-cart-menu1', '#select-text1', '#tost6')">확인</button>
      </div>
    </div>
    <? include_once $_SERVER['DOCUMENT_ROOT'] . "/footer.php"; ?>
  </div>
</body>
<script src="../js/common.js?version=<?= $cacheVersion; ?>"></script>

</html>
<script>
  $(function() {
    getMemberCommission();
    getMemberStick();
    getFolderList();
    getNowBuyingList();
    getCartList();
  });

  const scrollManager = {
    save: function(key) {
      localStorage.setItem(key, window.scrollY);
    },
    restore: function(key) {
      const position = localStorage.getItem(key);
      if (position) {
        window.scrollTo(0, parseInt(position));
      }
    },
  };

  // 사용 예시
  window.addEventListener('scroll', () => {
    scrollManager.save('cartMainPageScroll');
  });

  function getMemberCommission() {
    try {
      const userId = '<?= $checkUserId; ?>'
      const affliateId = '<?= $checkAffliateId; ?>'

      // AJAX 요청 데이터 설정
      const requestData = {
        userId,
        affliateId
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/view/memberCommission',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const userCommission = parseInt(result.data.userCommission).toLocaleString();
          const appendCommission =
            `<span class="ico-point"></span>${userCommission}<span class="ico-arrow type2 right"></span>`;
          $('#userCommission').append(appendCommission);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error.message);
    }
  }

  function getMemberStick() {
    try {
      const userId = '<?= $checkUserId; ?>'
      const merchantId = 'coupang';
      const affliateId = '<?= $checkAffliateId; ?>'

      // AJAX 요청 데이터 설정
      const requestData = {
        userId,
        merchantId,
        affliateId
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/view/coupangStick',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const memberStick = parseInt(result.data.cnt - result.data.stockCnt).toLocaleString();
          const appendStick = `<span class="ico-candy"></span>${memberStick}개<span class="ico-arrow type2 right"></span>`;
          $('#memberStick').append(appendStick);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error.message);
    }
  }

  // 정렬순, 폴더선택 변수
  let checkOrderBy = 'modDateDesc';
  let checkFolder = 0;
  let checkFavorite = '';

  // 폴더 리스트 조회 및 렌더링
  function getFolderList() {
    try {
      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId ?>'
      };

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/folderSearch',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000' && result.resultCode !== '3001') return alert(result.resultMessage);
          renderFolderList(result.datas);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  function renderFolderList(data) {
    let list = `<div id="folderNum0" class="tab tab1 ${checkFolder === 0 ? 'on' : ''}"><a href="javascript:getFolderCartList(0)">전체보기</a></div>`;
    data.forEach((item, index) => {
      list += `
              <div id="folderNum${item.folderNum}" class="tab tab${index + 2} ${checkFolder === item.folderNum ? 'on' : ''}">
                <a href="javascript:getFolderCartList(${item.folderNum}, '${item.folderName}')">${item.folderName}</a>
              </div>
              `;
    });
    $('#folder-list').empty();
    $('#folder-list').append(list);
    addFolderEvent();
  }

  function getFolderCartList(num, name) {
    checkFolder = num;
    if (name) {
      const noneTitle = `
                      <span class="ico-nonefolder"></span>[${name}]<br>폴더가 비어있어요.
                      `;
      $('#folderItemNone').empty()
      $('#folderItemNone').append(noneTitle);
    }
    getCartList();
  }

  function addFolderEvent() {
    const folders = document.querySelectorAll('#folder-list.tab-box .tab');
    folders.forEach(elm => {
      elm.addEventListener('click', () => {
        folders.forEach(tab => tab.classList.remove('on'));
        elm.classList.add('on');
      });
    });
  }

  function addFolderList(input, tabListWrap, selectWrap, selectList, btn, tost) {
    const $input = document.querySelector(input);
    const $tabListWrap = document.querySelector(tabListWrap);
    const $tost = document.querySelector(tost);
    if ($input.value.length <= 0) return;

    try {
      const requestData = {
        folderNum: 0,
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        folderName: $input.value,
        apiType: 'I'
      }

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/folder',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') return alert(result.resultMessage);

          $input.value = '';
          document.body.classList.remove('scrollNone');
          document.querySelector(selectWrap).classList.remove('on');
          document.querySelector(selectList).classList.remove('on');
          document.querySelector(btn).classList.remove('on');

          if ($tost && !$tost.classList.contains('on')) {
            $tost.classList.add('on');
            setTimeout(() => $tost.classList.remove('on'), 1000);
          }

          getFolderList();
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }


  }

  // 지금 구매하세요 영역 조회 및 렌더링
  function getNowBuyingList() {
    try {
      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        adId: ''
      };

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cartSaleSearch',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.datas === null) {
            $('.cart-link-list').hide();
            return;
          }
          renderNowBuyingList(result.datas);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  function renderNowBuyingList(data) {
    let list = '';
    data.forEach((item, index) => {
      list += `
              <div class="img img${index + 1}" style="background-image: url(${item.productImage});"></div>
              `;
    });
    list += `<p class="count">${data.length}</p>`;
    document.querySelector('#top-down-btn1 .value').innerHTML = data.length + '개'
    $('.cart-link-list .img-box').empty();
    $('.cart-link-list .img-box').append(list);
  }

  // 카트 아이템 조회
  function getCartList() {
    try {
      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        adId: '',
        productCode: '',
        optionCode: '',
        orderbyName: checkOrderBy,
        favorites: checkFavorite,
        folderNum: checkFolder
      };

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cartSearch',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.datas === null) {
            $('#cart-list-wrap1').hide();
            if (checkFolder === 0) {
              $('#all-cart-list-none').show();
            } else {
              $('#folder-cart-list-none').show();
            }
            return;
          }

          if (result.resultCode !== '0000') return alert(result.resultMessage);

          renderCartList(result.datas);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  // 카트 아이템 렌더링
  function renderCartList(data) {
    let list = '';
    data.forEach((item, index) => {
      const productPrice = parseInt(item.productPrice);
      const cartPrice = parseInt(item.cartPrice);
      const priceChange = calculatePriceChange(cartPrice, productPrice);
      const badge = item.badge ? `<div class="lowest-price">${item.badge}</div>` : '';
      const saleStatus = item.saleStatus === '310' ? '<span class="sale">품절</span>' : '';
      list += `
                <div 
                    id="list${index}" 
                    class="list" 
                    data-merchantId="${item.merchantId}" 
                    data-productCode="${item.productCode}"
                    data-optionCode="${item.optionCode}"
                    data-favorites="${item.favorites}"
                    data-cartPrice="${item.cartPrice}"
                    data-wantPrice="${item.wantPrice}"
                    data-alarm="${item.alarm}"
                    data-returnalarm="${item.returnAlarm}"
                  >
                  <div class="img-box" style="background-image: url(${item.productImage});">
                    ${badge}
                    ${saleStatus}
                    <button class="ico-heart ${item.favorites === 'Y' ? 'on' : ''}" type="button"></button>
                    <button class="ico-alarm ${item.alarm === 'Y' ? 'on' : ''}" type="button"></button>
                  </div>
                  <div class="text-box">
                    <div class="logo-box">
                      <div class="logo" style="background-image: url(<?= $appApiUrl; ?>/cart/images/merchant/${item.merchantId}.png)"></div>
                      <p class="logo-title">${item.memberName}</p>
                    </div>
                    <p class="title">${item.productName}</p>
                    <div class="price-box">
                      <p class="price">${productPrice.toLocaleString()}</p>
                      <div class="up-down ${priceChange.type}">${priceChange.rate}</div>
                    </div>
                  </div>
                  <a href="${item.productUrl}"></a>
                  <div
                    class="check-box"
                    onclick="
                      onOff('#list${index} .check-box .img-bg', '#bottom-popup1'), 
                      cartListOrganizeCheck('#select-text1', '.cart-list-wrap'),
                      bottomCartAlarmChangeCheck('#cart-alarm1', '#cart-list-wrap1'),
                      bottomCartHeartChangeCheck('#cart-heart1', '#cart-list-wrap1')
                    ">
                    <div class="img-bg">
                      <span class="check"></span>
                    </div>
                  </div>
                </div>
              `;
    });
    $('#all-cart-list-none').hide();
    $('#folder-cart-list-none').hide();
    $('#cart-list-wrap1').empty();
    $('#cart-list-wrap1').append(list);
    $('#cart-list-wrap1').show();
    cartListEvent();
    scrollManager.restore('cartMainPageScroll');
  }

  // 카트 아이템 삭제
  function bottomCartRemove(cartWrap, popup, bottomCartMenu, textBtn, tost) {
    const $cartListBefore = document.querySelectorAll(`${cartWrap} .list`);
    const $popup = document.querySelector(popup);
    const $bottomCartMenu = document.querySelector(bottomCartMenu);
    const $textBtn = document.querySelector(textBtn);
    const $tost = document.querySelector(tost);

    let removeList = [];
    $cartListBefore.forEach((elm) => {
      const $cartImgBg = elm.querySelector('.img-bg');
      if ($cartImgBg.classList.contains('on')) {
        const obj = {
          merchantId: elm.getAttribute('data-merchantId'),
          productCode: elm.getAttribute('data-productCode'),
          optionCode: elm.getAttribute('data-optionCode'),
          favorites: elm.getAttribute('data-favorites'),
          cartPrice: elm.getAttribute('data-cartPrice'),
          wantPrice: elm.getAttribute('data-wantPrice'),
          alarm: elm.getAttribute('data-alarm'),
          returnalarm: elm.getAttribute('data-returnalarm'),
        };
        removeList.push(obj);
      }
    });

    try {
      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        adId: '',
        apiType: 'D',
        productList: removeList
      };

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cartProduct',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') {
            alert(result.resultMessage);
            location.reload();
            return
          }
          getCartList();
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        },
      });
    } catch (error) {
      alert(error);
    }

    $popup.classList.remove('on');

    if ($tost && !$tost.classList.contains('on')) {
      $tost.classList.add('on');
      setTimeout(() => $tost.classList.remove('on'), 1000);
    }

    const $cartListAfter = document.querySelectorAll(`${cartWrap} .list`);
    if ($cartListAfter.length === 0) {
      $bottomCartMenu.classList.remove('on');
      if ($textBtn.classList.contains('selected'))
        $textBtn.classList.remove('selected');
      $textBtn.classList.remove('on');
      $textBtn.innerText = '선택';
    }

    bottomCartCancel(
      '#bottom-cart-menu1',
      '#cart-list-wrap1',
      '#select-text1',
      '#cart-alarm1',
      '#cart-heart1',
    );
  }

  // 카트 아이템 즐겨찾기 추가, 삭제
  function bottomCartFavorites(heartBtn, cartWrap, textBtn, tost1, tost2) {
    const $heartBtn = document.querySelector(heartBtn);
    const $heartBtnIco = document.querySelector(`${heartBtn} .ico-b-cart-heart`);
    const $cartLists = document.querySelectorAll(`${cartWrap} .list`);
    const $textBtn = document.querySelector(textBtn);
    const $tost1 = document.querySelector(tost1);
    const $tost2 = document.querySelector(tost2);
    let count = 0;
    let favoritesList = [];
    $cartLists.forEach((elm) => {
      const $cartImgBg = elm.querySelector('.img-bg');
      const $cartIcoFavorites = elm.querySelector('.ico-heart');

      if ($cartImgBg.classList.contains('on')) count += 1;

      if ($cartImgBg.classList.contains('on')) {
        const obj = {
          merchantId: elm.getAttribute('data-merchantId'),
          productCode: elm.getAttribute('data-productCode'),
          optionCode: elm.getAttribute('data-optionCode'),
          favorites: !$cartIcoFavorites.classList.contains('on') ? 'Y' : 'N',
          cartPrice: elm.getAttribute('data-cartPrice'),
          wantPrice: elm.getAttribute('data-wantPrice'),
          alarm: elm.getAttribute('data-alarm'),
          returnalarm: elm.getAttribute('data-returnalarm'),
        };
        favoritesList.push(obj);
      }
    });

    try {
      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        adId: '',
        apiType: 'U',
        productList: favoritesList
      };

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cartProduct',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') {
            alert(result.resultMessage);
            location.reload();
            return
          }

          if (count > 0) {
            if ($heartBtnIco.classList.contains('on')) {
              if ($tost1 && !$tost1.classList.contains('on')) {
                if ($tost2.classList.contains('on')) $tost2.classList.remove('on');
                $tost1.classList.add('on');
                setTimeout(() => $tost1.classList.remove('on'), 1000);
              }
            } else if (!$heartBtnIco.classList.contains('on')) {
              if ($tost2 && !$tost2.classList.contains('on')) {
                if ($tost1.classList.contains('on')) $tost1.classList.remove('on');
                $tost2.classList.add('on');
                setTimeout(() => $tost2.classList.remove('on'), 1000);
              }
            }
          }

          getCartList();
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        },
      });
    } catch (error) {
      alert(error);
    }

    if ($textBtn.classList.contains('selected'))
      $textBtn.classList.remove('selected');
    $textBtn.innerText = '전체선택';
    if (!$heartBtnIco.classList.contains('on')) {
      $heartBtn.innerHTML =
        '<span class="ico-b-cart-heart on"></span>즐겨찾기 설정';
      $heartBtnIco.classList.add('on');
    }

    bottomCartCancel(
      '#bottom-cart-menu1',
      '#cart-list-wrap1',
      '#select-text1',
      '#cart-alarm1',
      '#cart-heart1',
    );
  }

  // 카트 아이템 알림 추가, 삭제
  function bottomCartAlarm(alarmBtn, cartWrap, textBtn, tost1, tost2) {
    const $alarmBtn = document.querySelector(alarmBtn);
    const $alarmBtnIco = document.querySelector(`${alarmBtn} .ico-b-cart-alarm`);
    const $cartLists = document.querySelectorAll(`${cartWrap} .list`);
    const $textBtn = document.querySelector(textBtn);
    const $tost1 = document.querySelector(tost1);
    const $tost2 = document.querySelector(tost2);
    let count = 0;
    let alarmList = [];
    $cartLists.forEach((elm) => {
      const $cartImgBg = elm.querySelector('.img-bg');
      const $cartIcoAlarm = elm.querySelector('.ico-alarm');

      if ($cartImgBg.classList.contains('on')) count += 1;

      if ($cartImgBg.classList.contains('on')) {
        const obj = {
          merchantId: elm.getAttribute('data-merchantId'),
          productCode: elm.getAttribute('data-productCode'),
          optionCode: elm.getAttribute('data-optionCode'),
          favorites: elm.getAttribute('data-favorites'),
          cartPrice: elm.getAttribute('data-cartPrice'),
          wantPrice: elm.getAttribute('data-wantPrice'),
          alarm: !$cartIcoAlarm.classList.contains('on') ? 'Y' : 'N',
          returnalarm: elm.getAttribute('data-returnalarm'),
        };
        alarmList.push(obj);
      }
    });

    try {
      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        adId: '',
        apiType: 'U',
        productList: alarmList
      };

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cartProduct',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') {
            alert(result.resultMessage);
            location.reload();
            return
          }

          if (count > 0) {
            if ($alarmBtnIco.classList.contains('on')) {
              if ($tost1 && !$tost1.classList.contains('on')) {
                if ($tost2.classList.contains('on')) $tost2.classList.remove('on');
                $tost1.classList.add('on');
                setTimeout(() => $tost1.classList.remove('on'), 1000);
              }
            } else if (!$alarmBtnIco.classList.contains('on')) {
              if ($tost2 && !$tost2.classList.contains('on')) {
                if ($tost1.classList.contains('on')) $tost1.classList.remove('on');
                $tost2.classList.add('on');
                setTimeout(() => $tost2.classList.remove('on'), 1000);
              }
            }
          }

          getCartList();
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        },
      });
    } catch (error) {
      alert(error);
    }

    if ($textBtn.classList.contains('selected'))
      $textBtn.classList.remove('selected');
    $textBtn.innerText = '전체선택';
    if (!$alarmBtnIco.classList.contains('on')) {
      $alarmBtn.innerHTML = '<span class="ico-b-cart-alarm on"></span>알림 켜기';
      $alarmBtnIco.classList.add('on');
    }

    bottomCartCancel(
      '#bottom-cart-menu1',
      '#cart-list-wrap1',
      '#select-text1',
      '#cart-alarm1',
      '#cart-heart1',
    );
  }

  // 즐겨찾기 단일 설정
  function updateCartFavorites(elm) {

    try {
      let favoritesList = [];
      const obj = {
        merchantId: elm.getAttribute('data-merchantId'),
        productCode: elm.getAttribute('data-productCode'),
        optionCode: elm.getAttribute('data-optionCode'),
        favorites: elm.getAttribute('data-favorites') === 'Y' ? 'N' : 'Y',
        cartPrice: elm.getAttribute('data-cartPrice'),
        wantPrice: elm.getAttribute('data-wantPrice'),
        alarm: elm.getAttribute('data-alarm'),
        returnalarm: elm.getAttribute('data-returnalarm'),
      };
      favoritesList.push(obj);

      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        adId: '',
        apiType: 'U',
        productList: favoritesList
      };

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cartProduct',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') {
            alert(result.resultMessage);
            location.reload();
            return
          }
          getCartList();
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        },
      });
    } catch (error) {
      alert(error);
    }
  }

  // 알림 단일 설정
  function updateCartAlarm(elm) {
    try {
      let alarmList = [];
      const obj = {
        merchantId: elm.getAttribute('data-merchantId'),
        productCode: elm.getAttribute('data-productCode'),
        optionCode: elm.getAttribute('data-optionCode'),
        favorites: elm.getAttribute('data-favorites'),
        cartPrice: elm.getAttribute('data-cartPrice'),
        wantPrice: elm.getAttribute('data-wantPrice'),
        alarm: elm.getAttribute('data-alarm') === 'Y' ? 'N' : 'Y',
        returnalarm: elm.getAttribute('data-returnalarm'),
      };
      alarmList.push(obj);

      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        adId: '',
        apiType: 'U',
        productList: alarmList
      };

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cartProduct',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') {
            alert(result.resultMessage);
            location.reload();
            return
          }
          getCartList();
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        },
      });
    } catch (error) {
      alert(error);
    }
  }

  // 폴더 추가
  function addForder() {
    try {
      const requstData = {};
    } catch (error) {
      alert(error);
    }
  }

  function calculatePriceChange(cartPrice, productPrice) {
    if (cartPrice === productPrice || cartPrice === 0 || productPrice === 0) {
      return {
        type: '',
        rate: ''
      };
    }

    const isIncrease = cartPrice < productPrice;
    const basePrice = isIncrease ? cartPrice : productPrice;
    const comparePrice = isIncrease ? productPrice : cartPrice;

    const rate = Math.round(((comparePrice - basePrice) / basePrice) * 100);

    return {
      type: isIncrease ? 'up' : 'down',
      rate: `${rate}%`
    };
  }

  function getFavotiesList() {
    checkFavorite === '' ? checkFavorite = 'Y' : checkFavorite = '';
    getCartList();
  }
</script>
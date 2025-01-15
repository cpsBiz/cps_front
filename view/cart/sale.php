<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="format-detection" content="telephone=no" />
  <title>지금 구매하세요!</title>
  <!-- style -->

</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>지금 구매하세요!</h1>
      <div class="btn-list">
        <a href="javascript:history.back()" class="ico-arrow type1 left">이전</a>
      </div>
    </header>
    <!-- sub-1-1 -->
    <!-- hana class 추가 시 시그니처 컬러 변경 -->
    <div class="sub sub-1-1">
      <!-- 카트 리스트 -->
      <div class="cont cont1">
        <div class="stiky-wrap">
          <div class="cart-set-list">
            <div id="select-btn1" class="select-btn type3" onclick="selectListOn('#select-btn1', '#select-wrap', '#select-list1', getSaleList, 'sale')">
              <p class="value">최신순</p>
              <div class="ico-arrow type2 bottom"></div>
            </div>
            <div class="set-list">
              <button type="button" id="select-text1" class="select-text" onclick="cartListOrganizeOn('#select-text1', '.cart-list-wrap', '#bottom-cart-menu1', '#cart-alarm1', '#bottom-popup1', '#cart-heart1')">선택</button>
              <button type="button" class="ico-array one" onclick="cartListType('.cart-set-list .ico-array', '.cart-list-wrap', 'cartSale')">정렬</button>
            </div>
          </div>
        </div>
        <!-- 리스트 있을 경우 -->
        <div id="cart-list-wrap1" class="cart-list-wrap type1 one"></div>
        <!-- 리스트 없을 경우 -->
        <div id="all-cart-list-none" class="list-none-box" style="display: none;">
          <p><span class="ico-nonecart"></span>할인 중인 상품이 없습니다. 상풍을 등록해 보세요.</p>
        </div>
      </div>
      <!-- 토스트 팝업 -->
      <p id="tost1" class="tost-popup type3">상품이 삭제 되었습니다.</p>
    </div>
    <!-- 셀렉트 박스 -->
    <div id="select-wrap">
      <!-- 정렬 방식 셀렉트 -->
      <div id="select-list1" class="select-list">
        <div class="select-head">
          <p>정렬 방법을 선택해주세요</p>
          <button
            class="ico-close type1"
            type="button"
            onclick="selectListClose('#select-btn1', '#select-wrap', '#select-list1')">
            닫기
          </button>
        </div>
        <ul class="select-cont">
          <li id="orderByRegDateDesc" class="list list1 on">
            <p class="value">최신순</p>
            <div class="ico-check on"></div>
          </li>
          <li id="orderByDiscount" class="list list2">
            <p class="value">할인율순</p>
            <div class="ico-check on"></div>
          </li>
          <li id="orderByRegDateAsc" class="list list3">
            <p class="value">오래된순</p>
            <div class="ico-check on"></div>
          </li>
          <li id="orderByProductName" class="list list4">
            <p class="value">이름순</p>
            <div class="ico-check on"></div>
          </li>
        </ul>
      </div>
    </div>
    <div id="bottom-cart-menu1" class="bottom-popup type1">
      <div class="head">
        <p>상품을 선택해주세요</p>
        <button
          class="ico-close type1"
          type="button"
          onclick="bottomCartCancel('#bottom-cart-menu1', '#cart-list-wrap1', '#select-text1'), onOff('.sub-1-1')">
          닫기
        </button>
      </div>
      <div class="btn-box">
        <button
          type="button"
          class="gray"
          onclick="bottomCartCancel('#bottom-cart-menu1', '#cart-list-wrap1', '#select-text1'), onOff('.sub-1-1')">
          취소
        </button>
        <button
          type="button"
          class="blue"
          onclick="bottomPopupOn('#bottom-popup1', '#cart-list-wrap1')">
          삭제
        </button>
      </div>
    </div>
    <div id="bottom-popup1" class="bottom-popup type1">
      <div class="head">
        <p></p>
        <button
          class="ico-close type1"
          type="button"
          onclick="onOff('#bottom-popup1')">
          닫기
        </button>
      </div>
      <div class="btn-box">
        <button type="button" class="gray" onclick="onOff('#bottom-popup1')">
          취소
        </button>
        <button
          type="button"
          class="blue"
          onclick="bottomCartRemove('#cart-list-wrap1', '#bottom-popup1', '#bottom-cart-menu1', '#select-text1', '#tost1')">
          확인
        </button>
      </div>
    </div>
  </div>
  <script src="<?= $appApiUrl; ?>/js/common.js?version=<?= $cacheVersion; ?>"></script>
</body>

</html>
<script>
  $(function() {
    if (!localStorage.getItem('checkCartSaleOrderBy')) {
      localStorage.setItem('checkCartSaleOrderBy', 'regDateDesc');
    } else {
      const orderBy = localStorage.getItem('checkCartSaleOrderBy');
      if (orderBy) {
        let id = '';
        switch (orderBy) {
          case 'regDateDesc':
            id = 'orderByRegDateDesc';
            break;
          case 'discount':
            id = 'orderByDiscount';
            break;
          case 'regDateAsc':
            id = 'orderByRegDateAsc';
            break;
          case 'productName':
            id = 'orderByProductName';
            break;
        }

        const elm = document.querySelectorAll('#select-list1 .list');
        elm.forEach((item) => item.classList.remove('on'));
        document.getElementById(id).classList.add('on');
        document.querySelector('#select-btn1 p.value').innerText = document.querySelector(`#${id} p.value`).innerText;
      }
    }

    if (localStorage.getItem('checkCartSaleListType')) {
      const $btn = document.querySelector('.cart-set-list .ico-array');
      const $cartList = document.querySelector('.cart-list-wrap');
      $btn.classList.remove('one', 'two', 'three');
      $cartList.classList.remove('one', 'two', 'three');
      $btn.classList.add(localStorage.getItem('checkCartSaleListType'));
      $cartList.classList.add(localStorage.getItem('checkCartSaleListType'));
    }

    getSaleList();
  })

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

  window.addEventListener('scroll', () => {
    scrollManager.save('cartSalePageScroll');
  });

  // 세일 아이템 조회
  function getSaleList() {
    try {
      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        site: '<?= $checkSite; ?>',
        // orderbyName: localStorage.getItem('checkCartSaleOrderBy'),
      };

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cartSaleSearch',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.datas === null) {
            $('#cart-list-wrap1').hide();
            $('#all-cart-list-none').show();
            return;
          }

          if (result.resultCode !== '0000') return alert(result.resultMessage);

          renderSaleList(result.datas);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  function renderSaleList(data) {
    let list = '';
    data.forEach((item, index) => {
      const productPrice = parseInt(item.rocketStatus === 'Y' && item.rocketProductPrice > 0 ? item.rocketProductPrice : item.productPrice);
      const cartPrice = parseInt(item.cartPrice);
      const priceChange = calculatePriceChange(cartPrice, item.rocketStatus === 'Y' && item.rocketProductPrice > 0 ? item.rocketProductPrice : item.productPrice);
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
                    data-rocketCartPrice="${item.rocketCartPrice}"
                    data-regDay="${item.regDay}"
                    data-regYm="${item.regYm}"
                    data-regHour="${item.regHour}"
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
                  <a href="javascript:location.href='/cart/detail.php?productCode=${item.productCode}&optionCode=${item.optionCode}&merchantId=${item.merchantId}'"></a>
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
    $('#cart-list-wrap1').empty();
    $('#cart-list-wrap1').append(list);
    $('#cart-list-wrap1').show();
    cartListEvent();
    scrollManager.restore('cartSalePageScroll');
  }

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
          rocketCartPrice: elm.getAttribute('data-rocketCartPrice'),
          regDay: elm.getAttribute('data-regDay'),
          regYm: elm.getAttribute('data-regYm'),
          regHour: elm.getAttribute('data-regHour'),
        };
        removeList.push(obj);
      }
    });

    try {
      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        site: '<?= $checkSite; ?>',
        adId: '<?= $checkAdId; ?>',
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
          getSaleList();
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
        rocketCartPrice: elm.getAttribute('data-rocketCartPrice'),
        regDay: elm.getAttribute('data-regDay'),
        regYm: elm.getAttribute('data-regYm'),
        regHour: elm.getAttribute('data-regHour'),
      };
      favoritesList.push(obj);

      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        site: '<?= $checkSite; ?>',
        adId: '<?= $checkAdId; ?>',
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
          getSaleList();
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
        rocketCartPrice: elm.getAttribute('data-rocketCartPrice'),
        regDay: elm.getAttribute('data-regDay'),
        regYm: elm.getAttribute('data-regYm'),
        regHour: elm.getAttribute('data-regHour'),
      };
      alarmList.push(obj);

      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        site: '<?= $checkSite; ?>',
        adId: '<?= $checkAdId; ?>',
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
          getSaleList();
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        },
      });
    } catch (error) {
      alert(error);
    }
  }
</script>
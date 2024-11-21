// 모든 탭을 선택
const tabs = document.querySelectorAll('.tab');

// 각 탭에 클릭 이벤트 리스너 추가
tabs.forEach((tab) => {
  tab.addEventListener('click', () => {
    // 모든 탭에서 on 클래스 제거
    tabs.forEach((t) => t.classList.remove('on'));

    // 클릭된 탭에 on 클래스 추가
    tab.classList.add('on');
  });
});

// list type3
const $type3Lists = document.querySelectorAll('.list-wrap.type3 .list');
const $type3ListsTop = document.querySelectorAll(
  '.list-wrap.type3 .list > .top',
);
const $type3ListsBottom = document.querySelectorAll(
  '.list-wrap.type3 .list > .bottom',
);
const $type3ListsBottomContent = document.querySelectorAll(
  '.list-wrap.type3 .list > .bottom > div',
);

// file
const $inputFile1 = document.querySelector('#file-1');

function historyPointEvent() {
  // list type2
  const $type2Lists = document.querySelectorAll('.list-wrap.type2 .list');
  const $type2ListsToolTipBox = document.querySelectorAll(
    '.list-wrap.type2 .list .tool-tip-box',
  );
  // list type2
  if ($type2Lists) {
    $type2Lists.forEach((elm) => {
      elm.addEventListener('click', (e) => {
        if (e.target.className === 'tool-tip') return;
        if (e.target.tagName.toLowerCase() !== 'button') {
          $type2ListsToolTipBox.forEach((elm) => elm.classList.remove('on'));
        }
      });
    });

    $type2ListsToolTipBox.forEach((elm) => {
      elm.addEventListener('click', (e) => {
        if (e.target.className === 'tool-tip') return;
        if (!elm.classList.contains('on')) {
          $type2ListsToolTipBox.forEach((elm) => elm.classList.remove('on'));
          elm.classList.add('on');
        } else if (elm.classList.contains('on')) {
          $type2ListsToolTipBox.forEach((elm) => elm.classList.remove('on'));
        }
      });
    });
  }
}

// list type3
if ($type3Lists) {
  $type3ListsTop.forEach((elm) => {
    elm.addEventListener('click', () => {
      const $list = elm.closest('.list');
      const $bottom = elm.closest('.list').querySelector('.bottom');
      const bottomContentHeight = elm
        .closest('.list')
        .querySelector('.bottom > div').clientHeight;

      if (!$list.classList.contains('on')) {
        $type3ListsBottom.forEach((elm) => (elm.style.height = '0px'));
        $type3Lists.forEach((elm) => elm.classList.remove('on'));
        $bottom.style.height = `${bottomContentHeight}px`;
        $list.classList.add('on');
      } else if ($list.classList.contains('on')) {
        $type3ListsBottom.forEach((elm) => (elm.style.height = '0px'));
        $type3Lists.forEach((elm) => elm.classList.remove('on'));
        $list.classList.remove('on');
      }
    });
  });
}

// cart list type1
function cartListEvent() {
  // cart list type1
  const $type1CartLists = document.querySelectorAll(
    '.cart-list-wrap.type1 .list',
  );
  const $type1CartListsIcoHeart = document.querySelectorAll(
    '.cart-list-wrap.type1 .ico-heart',
  );
  const $type1CartListsIcoalarm = document.querySelectorAll(
    '.cart-list-wrap.type1 .ico-alarm',
  );

  if ($type1CartLists) {
    $type1CartListsIcoHeart.forEach((elm, index) => {
      elm.addEventListener('click', () => {
        updateCartFavorites($type1CartLists[index]);
      });
    });

    $type1CartListsIcoalarm.forEach((elm, index) => {
      elm.addEventListener('click', () => {
        updateCartAlarm($type1CartLists[index]);
      });
    });

    const links = document.querySelectorAll('.list > a');
    const eventOptions = {
      passive: false,
    };

    links.forEach((link) => {
      let pressTimer;
      let isLongPress = false;

      link.addEventListener(
        'touchstart',
        (e) => {
          isLongPress = false;
          pressTimer = setTimeout(() => {
            isLongPress = true;
            cartListOrganizeOn(
              '#select-text1',
              '.cart-list-wrap',
              '#bottom-cart-menu1',
              '#cart-alarm1',
              '#bottom-popup1',
              '#cart-heart1',
            );
          }, 1500);
        },
        eventOptions,
      );

      link.addEventListener(
        'touchend',
        (e) => {
          clearTimeout(pressTimer);
          if (isLongPress) {
            e.preventDefault();
          }
        },
        eventOptions,
      );

      link.addEventListener('mousedown', (e) => {
        isLongPress = false;
        pressTimer = setTimeout(() => {
          isLongPress = true;
          cartListOrganizeOn(
            '#select-text1',
            '.cart-list-wrap',
            '#bottom-cart-menu1',
            '#cart-alarm1',
            '#bottom-popup1',
            '#cart-heart1',
          );
        }, 1500);
      });

      link.addEventListener('mouseup', () => {
        clearTimeout(pressTimer);
      });

      link.addEventListener('mouseleave', () => {
        clearTimeout(pressTimer);
        isLongPress = false;
      });

      link.addEventListener('click', (e) => {
        if (isLongPress) {
          e.preventDefault();
        }
      });
    });
  }
}

// resize event
window.addEventListener('resize', () => {
  // list type3
  if ($type3Lists) {
    $type3Lists.forEach((elm) => {
      if (elm.classList.contains('on')) {
        elm.children[elm.children.length - 1].style.height = `${
          elm.children[elm.children.length - 1].children[0].clientHeight
        }px`;
      }
    });
  }
});

// cart
function cartListType(btn, cartList, page) {
  const $btn = document.querySelector(btn);
  const $cartList = document.querySelector(cartList);

  let pageType = '';
  if (page === 'main') pageType = 'checkListType';
  else if (page === 'cartSale') pageType = 'checkCartSaleListType';

  if (!pageType) return;

  if (!localStorage.getItem(pageType)) {
    localStorage.setItem(pageType, 'two');
  } else {
    const type = localStorage.getItem(pageType);
    switch (type) {
      case 'one':
        localStorage.setItem(pageType, 'two');
        break;
      case 'two':
        localStorage.setItem(pageType, 'three');
        break;
      case 'three':
        localStorage.setItem(pageType, 'one');
        break;
    }
  }

  const type = localStorage.getItem(pageType);

  if (type === 'one') {
    $btn.classList.remove('two', 'three');
    $cartList.classList.remove('two', 'three');
    $btn.classList.add('one');
    $cartList.classList.add('one');
  } else if (type === 'two') {
    $btn.classList.remove('one', 'three');
    $cartList.classList.remove('one', 'three');
    $btn.classList.add('two');
    $cartList.classList.add('two');
  } else if (type === 'three') {
    $btn.classList.remove('one', 'two');
    $cartList.classList.remove('one', 'two');
    $btn.classList.add('three');
    $cartList.classList.add('three');
  }
}

function topDowmBoxOnOff(topDownBtn, topDownBox) {
  const $btn = document.querySelector(topDownBtn);
  const $box = document.querySelector(topDownBox);

  if (!$btn.classList.contains('on')) {
    $btn.classList.add('on');
    $box.classList.add('on');
  } else if ($btn.classList.contains('on')) {
    $btn.classList.remove('on');
    $box.classList.remove('on');
  }
}

// cart input value check
function inputValueCheck(input, btn) {
  const $input = document.querySelector(input);
  const $btn = document.querySelector(btn);

  if ($input.value.length > 0) {
    $btn.classList.add('on');
  } else {
    $btn.classList.remove('on');
  }
}

// component
// popup
function popupOn(popupWrap, popup) {
  document.body.classList.add('scrollNone');
  document.querySelector(popupWrap).classList.add('on');
  document.querySelector(popup).classList.add('on');
}

function popupClose(popupWrap, popup) {
  document.body.classList.remove('scrollNone');
  document.querySelector(popupWrap).classList.remove('on');
  document.querySelector(popup).classList.remove('on');
}

// popup change
function popupChange(nowPop, nextPop) {
  document.querySelector(nowPop).classList.remove('on');
  document.querySelector(nextPop).classList.add('on');
}

// event popup
function eventPopupClose(popup) {
  document.querySelector(popup).classList.remove('on');
}

// select box
function selectListOn(selectBtn, selectWrap, selectList, callback, type) {
  const $selectBtnValue = document.querySelector(`${selectBtn} .value`);
  const $selectLists = document.querySelectorAll(`${selectList} .list`);
  const $selectListContainer = document.querySelector(selectList);
  document.body.classList.add('scrollNone');
  document.querySelector(selectBtn).classList.add('on');
  document.querySelector(selectWrap).classList.add('on');
  document.querySelector(selectList).classList.add('on');

  $selectListContainer.onclick = (e) => {
    const listItem = e.target.closest('.list');
    if (listItem) {
      selectListsCheck(
        $selectLists,
        listItem,
        $selectBtnValue,
        selectBtn,
        selectWrap,
        selectList,
        callback,
        type,
      );
    }
  };
}

function selectListsCheck(
  $selectLists,
  $selectList,
  $selectBtnValue,
  selectBtn,
  selectWrap,
  selectList,
  callback,
  type,
) {
  $selectLists.forEach((elm) => elm.classList.remove('on'));
  $selectList.classList.add('on');
  $selectList.querySelector('div').classList.add('on');
  const selectValue = $selectList.querySelector('.value').innerText;
  $selectBtnValue.innerText = selectValue;
  if (!$selectBtnValue.classList.contains('on'))
    $selectBtnValue.classList.add('on');

  selectListClose(selectBtn, selectWrap, selectList);
  if (callback && typeof callback === 'function') {
    let checkOrderBy = '';
    switch (selectValue) {
      case '최신순':
        checkOrderBy = 'modDateDesc';
        break;
      case '할인율순':
        checkOrderBy = 'discount';
        break;
      case '오래된순':
        checkOrderBy = 'modDateAsc';
        break;
      case '이름순':
        checkOrderBy = 'productName';
        break;
    }
    if (type === 'main') {
      localStorage.setItem('checkOrderBy', checkOrderBy);
      getCartList();
    } else if (type === 'sale') {
      localStorage.setItem('checkCartSaleOrderBy', checkOrderBy);
      getSaleList();
    }
  }
}

function selectListClose(selectBtn, selectWrap, selectList) {
  const $selectLists = document.querySelectorAll(`${selectList} .list`);
  document.body.classList.remove('scrollNone');
  document.querySelector(selectBtn).classList.remove('on');
  document.querySelector(selectWrap).classList.remove('on');
  document.querySelector(selectList).classList.remove('on');

  $selectLists.forEach((elm) =>
    elm.removeEventListener('click', () =>
      selectListsCheck(elm, $selectBtnValue),
    ),
  );
}

// select input box
function selectInputOn(selectWrap, selectList) {
  document.body.classList.add('scrollNone');
  document.querySelector(selectWrap).classList.add('on');
  document.querySelector(selectList).classList.add('on');
}

function selectInputClose(selectWrap, selectList) {
  const $selectInput = document.querySelector(
    `${selectList} .select-cont > input`,
  );
  const $selectBtn = document.querySelector(
    `${selectList} .select-cont .folder-btn`,
  );
  document.body.classList.remove('scrollNone');
  document.querySelector(selectWrap).classList.remove('on');
  document.querySelector(selectList).classList.remove('on');
  if ($selectInput) $selectInput.value = '';
  if ($selectBtn && $selectBtn.classList.contains('on'))
    $selectBtn.classList.remove('on');
}

// select basic box
function selectBasicOn(selectWrap, selectList) {
  document.body.classList.add('scrollNone');
  document.querySelector(selectWrap).classList.add('on');
  document.querySelector(selectList).classList.add('on');
}

function selectBasicClose(selectWrap, selectList) {
  document.body.classList.remove('scrollNone');
  document.querySelector(selectWrap).classList.remove('on');
  document.querySelector(selectList).classList.remove('on');
}

// form box
function formBoxOn(
  askElms,
  askTarget,
  askText,
  askValue,
  formBoxElms,
  formBoxTarget,
) {
  const $formBoxElms = document.querySelectorAll(formBoxElms);
  const $formBoxTarget = document.querySelector(formBoxTarget);
  const formObj = {
    askElms,
    askTarget,
    askText,
    askValue,
    formBoxElms,
    formBoxTarget,
  };

  $formBoxElms.forEach((elm) => elm.classList.remove('on'));
  $formBoxTarget.classList.add('on');
  sessionStorage.setItem('form-box-number', JSON.stringify(formObj));
}

function getDevice() {
  //모바일기기 배열
  const Mobile =
    /iPhone|iPad|Android|BlackBerry|Windows Phone|Windows CE|LG|MOT|SAMSUNG|SonyEricsson|Nokia/i.test(
      navigator.userAgent,
    )
      ? true
      : false;

  return Mobile;
}

function getOs() {
  const userAgent = window.navigator.userAgent;

  if (/iPhone|iPad|iPod/i.test(userAgent)) {
    return 'IOS';
  } else if (/Android/i.test(userAgent)) {
    return 'AOS';
  } else {
    return 'PC';
  }
}

function getCommissionPer(item) {
  // 적립률 - OS별로 PC,MOBILE 나눠서 계산필요
  const commission = getDevice() ? item.commissionMobile : item.commissionPc;
  const commissionPer = (
    (commission *
      ((item.affliateCommissionShare * item.userCommissionShare) / 100)) /
    100
  ).toFixed(2);

  return commissionPer;
}

// 날짜를 변환하고, 요일을 판단하는 함수
function formatDate(date) {
  // 숫자를 문자열로 변환하고 앞에 0을 채움
  const dateStr = date.toString().padStart(8, '0');
  const len = dateStr.length;

  // 빠른 분기 처리
  if (len !== 6 && len !== 8) {
    return ''; // 에러 로깅 대신 빈 문자열 반환
  }

  // 문자열 직접 연결 사용 (템플릿 리터럴보다 빠름)
  const year = dateStr.slice(0, 4);

  if (len === 6) {
    return year + '.' + dateStr.slice(4, 6);
  }

  return year + '.' + dateStr.slice(4, 6) + '.' + dateStr.slice(6, 8);
}

function base64Encode(str) {
  return btoa(unescape(encodeURIComponent(str)));
}

function decodeFromBase64(base64String) {
  const jsonString = decodeURIComponent(escape(atob(base64String))); // Base64를 디코딩 후 JSON 문자열로 변환
  const jsonObject = JSON.parse(jsonString); // JSON 문자열을 객체로 변환
  return jsonObject;
}

// on off
function onOff(elm, flagElm) {
  const $elm = document.querySelector(elm);
  const $flagElm = document.querySelector(flagElm);

  if ($flagElm && $flagElm.classList.contains('on')) return;

  if (!$elm.classList.contains('on')) {
    $elm.classList.add('on');
  } else if ($elm.classList.contains('on')) {
    $elm.classList.remove('on');
  }
}

function toolTipOnOff(toolTip, toolTips) {
  const $toolTips = document.querySelectorAll(toolTips);
  const $toolTip = document.querySelector(toolTip);

  $toolTips.forEach((elm) => {
    if (elm !== $toolTip) elm.classList.remove('on');
  });

  if (!$toolTip.classList.contains('on')) {
    $toolTip.classList.add('on');
  } else if ($toolTip.classList.contains('on')) {
    $toolTip.classList.remove('on');
  }
}

function toolTipsOff(e, toolTips) {
  const $toolTips = document.querySelectorAll(toolTips);
  let flag = true;

  $toolTips.forEach((elm) => {
    if (e.target.closest(toolTips) === elm) flag = false;
  });

  if (flag) {
    $toolTips.forEach((elm) => {
      elm.classList.remove('on');
    });
  }
}

// favorites list
function favoritesList(heart, cartWrap) {
  const $heart = document.querySelector(heart);
  const $cartLists = document.querySelectorAll(`${cartWrap} .list .ico-heart`);

  if ($heart.classList.contains('on')) {
    $cartLists.forEach((elm) => {
      if (!elm.classList.contains('on')) {
        elm.closest('.list').classList.add('none');
      }
    });
  } else if (!$heart.classList.contains('on')) {
    $cartLists.forEach((elm) => {
      if (!elm.classList.contains('on')) {
        elm.closest('.list').classList.remove('none');
      }
    });
  }
}

function bottomCartCancel(
  bottomCartMenu,
  cartWrap,
  selectBtn,
  alarmBtn,
  heartBtn,
) {
  const $bottomCartMenu = document.querySelector(bottomCartMenu);
  const $cartCheckBoxs = document.querySelectorAll(`${cartWrap} .check-box`);
  const $selectBtn = document.querySelector(selectBtn);
  const $alarmBtn = document.querySelector(alarmBtn);
  const $alarmBtnIco = document.querySelector(`${alarmBtn} .ico-b-cart-alarm`);
  const $heartBtn = document.querySelector(heartBtn);
  const $heartBtnIco = document.querySelector(`${heartBtn} .ico-b-cart-heart`);

  $bottomCartMenu.classList.remove('on');
  $cartCheckBoxs.forEach((elm) => {
    elm.classList.remove('on');
    if (elm.querySelector('.img-bg').classList.contains('on')) {
      elm.querySelector('.img-bg').classList.remove('on');
    }
  });

  if ($selectBtn.classList.contains('selected'))
    $selectBtn.classList.remove('selected');
  $selectBtn.classList.remove('on');
  $selectBtn.innerText = '선택';

  if ($alarmBtnIco && !$alarmBtnIco.classList.contains('on')) {
    $alarmBtn.innerHTML = '<span class="ico-b-cart-alarm on"></span>알림 켜기';
    $alarmBtnIco.classList.add('on');
  }

  if ($heartBtnIco && !$heartBtnIco.classList.contains('on')) {
    $heartBtn.innerHTML =
      '<span class="ico-b-cart-heart on"></span>즐겨찾기 설정';
    $heartBtnIco.classList.add('on');
  }

  const $folderList = document.querySelector('#folder-list');
  const $folders = $folderList.querySelectorAll('.tab .folderChangeWrap');
  if ($folders.length > 0) {
    $folders.forEach((elm) => {
      elm.classList.remove('on');
    });
  }
}

function bottomCartAlarmChangeCheck(alarmBtn, cartWrap) {
  const $alarmBtn = document.querySelector(`${alarmBtn}`);
  const $alarmBtnIco = document.querySelector(`${alarmBtn} .ico-b-cart-alarm`);
  const $cartLists = document.querySelectorAll(`${cartWrap} .list`);
  let count = 0;

  $cartLists.forEach((elm) => {
    const $cartImgBg = elm.querySelector('.img-bg');
    const $alarmIco = elm.querySelector('.ico-alarm');
    if (
      $cartImgBg.classList.contains('on') &&
      $alarmIco.classList.contains('on')
    )
      count += 1;
  });

  if (count === 0) {
    if ($alarmBtnIco && !$alarmBtnIco.classList.contains('on')) {
      $alarmBtn.innerHTML =
        '<span class="ico-b-cart-alarm on"></span>알림 켜기';
      $alarmBtnIco.classList.add('on');
    }
  } else if (count > 0) {
    if ($alarmBtnIco && $alarmBtnIco.classList.contains('on')) {
      $alarmBtn.innerHTML = '<span class="ico-b-cart-alarm"></span>알림 끄기';
      $alarmBtnIco.classList.remove('on');
    }
  }
}

function bottomCartHeartChangeCheck(heartBtn, cartWrap) {
  const $heartBtn = document.querySelector(`${heartBtn}`);
  const $heartBtnIco = document.querySelector(`${heartBtn} .ico-b-cart-heart`);
  const $cartLists = document.querySelectorAll(`${cartWrap} .list`);
  let count = 0;

  $cartLists.forEach((elm) => {
    const $cartImgBg = elm.querySelector('.img-bg');
    const $heartIco = elm.querySelector('.ico-heart');
    if (
      $cartImgBg.classList.contains('on') &&
      $heartIco.classList.contains('on')
    )
      count += 1;
  });

  if (count === 0) {
    if ($heartBtnIco && !$heartBtnIco.classList.contains('on')) {
      $heartBtn.innerHTML =
        '<span class="ico-b-cart-heart on"></span>즐겨찾기 설정';
      $heartBtnIco.classList.add('on');
    }
  } else if (count > 0) {
    if ($heartBtnIco && $heartBtnIco.classList.contains('on')) {
      $heartBtn.innerHTML =
        '<span class="ico-b-cart-heart"></span>즐겨찾기 해제';
      $heartBtnIco.classList.remove('on');
    }
  }
}

function bottomPopupOn(popup, cartWrap) {
  const $popup = document.querySelector(popup);
  const $popupCountText = document.querySelector(`${popup} .head > p`);
  const $cartList = document.querySelectorAll(`${cartWrap} .list`);
  let count = 0;

  $cartList.forEach((elm) => {
    const $cartImgBg = elm.querySelector('.img-bg');

    if ($cartImgBg.classList.contains('on')) count += 1;
  });

  if (count === 0) return;
  $popupCountText.innerText = `${count}개 상품을 삭제할까요?`;
  $popup.classList.add('on');
}

// cartList organize
function cartListOrganizeOn(
  btn,
  cartWrap,
  bottomCartMenu,
  alarmBtn,
  flagElm,
  heartBtn,
) {
  const $btn = document.querySelector(btn);
  const $cartLists = document.querySelectorAll(`${cartWrap} .list`);
  const $cartCheckBox = document.querySelectorAll(`${cartWrap} .check-box`);
  const $bottomCartMenu = document.querySelector(bottomCartMenu);
  const $alarmBtn = document.querySelector(alarmBtn);
  const $alarmBtnIco = document.querySelector(`${alarmBtn} .ico-b-cart-alarm`);
  const $flagElm = document.querySelector(flagElm);
  const $heartBtn = document.querySelector(heartBtn);
  const $heartBtnIco = document.querySelector(`${heartBtn} .ico-b-cart-heart`);
  let count = 0;
  let heartCount = 0;
  if ($flagElm && $flagElm.classList.contains('on')) return;
  if ($cartLists.length === 0) return;

  if (!$btn.classList.contains('on')) {
    $btn.classList.add('on');
    $btn.innerText = '전체선택';
    $cartCheckBox.forEach((elm) => {
      elm.classList.add('on');
    });
    $bottomCartMenu.classList.add('on');
  } else if (
    $btn.classList.contains('on') &&
    !$btn.classList.contains('selected')
  ) {
    $btn.classList.add('selected');
    $btn.innerText = '전체해제';
    $cartCheckBox.forEach((elm) => {
      elm.querySelector('.img-bg').classList.add('on');
    });

    $cartLists.forEach((elm) => {
      const $cartImgBg = elm.querySelector('.img-bg');
      const $alarmIco = elm.querySelector('.ico-alarm');
      const $heartIco = elm.querySelector('.ico-heart');
      if (
        $cartImgBg.classList.contains('on') &&
        $alarmIco.classList.contains('on')
      ) {
        count += 1;
      }
      if (
        $cartImgBg.classList.contains('on') &&
        $heartIco.classList.contains('on')
      ) {
        heartCount += 1;
      }
    });

    if (count === 0) {
      if ($alarmBtnIco && !$alarmBtnIco.classList.contains('on')) {
        $alarmBtn.innerHTML =
          '<span class="ico-b-cart-alarm on"></span>알림 켜기';
        $alarmBtnIco.classList.add('on');
      }
    } else if (count > 0) {
      if ($alarmBtnIco && $alarmBtnIco.classList.contains('on')) {
        $alarmBtn.innerHTML = '<span class="ico-b-cart-alarm"></span>알림 끄기';
        $alarmBtnIco.classList.remove('on');
      }
    }

    if (heartCount === 0) {
      if ($heartBtnIco && !$heartBtnIco.classList.contains('on')) {
        $heartBtn.innerHTML =
          '<span class="ico-b-cart-heart on"></span>즐겨찾기 설정';
        $heartBtnIco.classList.add('on');
      }
    } else if (heartCount > 0) {
      if ($heartBtnIco && $heartBtnIco.classList.contains('on')) {
        $heartBtn.innerHTML =
          '<span class="ico-b-cart-heart"></span>즐겨찾기 해제';
        $heartBtnIco.classList.remove('on');
      }
    }
  } else if (
    $btn.classList.contains('on') &&
    $btn.classList.contains('selected')
  ) {
    $btn.classList.remove('selected');
    $btn.innerText = '전체선택';
    $cartCheckBox.forEach((elm) => {
      elm.querySelector('.img-bg').classList.remove('on');
    });

    if ($alarmBtnIco && !$alarmBtnIco.classList.contains('on')) {
      $alarmBtn.innerHTML =
        '<span class="ico-b-cart-alarm on"></span>알림 켜기';
      $alarmBtnIco.classList.add('on');
    }

    if ($heartBtnIco && !$heartBtnIco.classList.contains('on')) {
      $heartBtn.innerHTML =
        '<span class="ico-b-cart-heart on"></span>즐겨찾기 설정';
      $heartBtnIco.classList.add('on');
    }
  }

  const $folderList = document.querySelector('#folder-list');
  const $folders = $folderList.querySelectorAll('.tab .folderChangeWrap');

  if ($folders.length > 0) {
    $folders.forEach((elm) => {
      elm.classList.add('on');
    });
  }
}

function cartListOrganizeCheck(btn, cartWrap, flagElm) {
  const $btn = document.querySelector(btn);
  const $cartCheckBox = document.querySelectorAll(`${cartWrap} .check-box`);
  let count = 0;

  $cartCheckBox.forEach((elm) => {
    if (elm.querySelector('.img-bg').classList.contains('on')) {
      count += 1;
    }

    if (count >= 0 && count < $cartCheckBox.length) {
      $btn.classList.remove('selected');
      $btn.innerText = '전체선택';
    } else if (count === $cartCheckBox.length) {
      $btn.classList.add('selected');
      $btn.innerText = '전체해제';
    }
  });
}

function calculatePriceChange(cartPrice, productPrice) {
  if (cartPrice === productPrice || cartPrice === 0 || productPrice === 0) {
    return {
      type: '',
      rate: '',
    };
  }

  const isIncrease = cartPrice < productPrice;
  const basePrice = isIncrease ? cartPrice : productPrice;
  const comparePrice = isIncrease ? productPrice : cartPrice;

  const rate = Math.round(((comparePrice - basePrice) / basePrice) * 100);

  return {
    type: isIncrease ? 'up' : 'down',
    rate: `${rate}%`,
  };
}

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

// list type1
const $type1Lists = document.querySelectorAll('.list-wrap.type1 .list');
const $type1ListsIcoHeart = document.querySelectorAll(
  '.list-wrap.type1 .ico-heart',
);

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

// list type1
if ($type1Lists) {
  $type1ListsIcoHeart.forEach((elm) => {
    elm.addEventListener('click', () => {
      if (!elm.classList.contains('on')) {
        elm.classList.add('on');
      } else if (elm.classList.contains('on')) {
        elm.classList.remove('on');
      }
    });
  });
}

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
if ($type1CartLists) {
  $type1CartListsIcoHeart.forEach((elm) => {
    elm.addEventListener('click', () => {
      if (!elm.classList.contains('on')) {
        elm.classList.add('on');
      } else if (elm.classList.contains('on')) {
        elm.classList.remove('on');
      }
    });
  });

  $type1CartListsIcoalarm.forEach((elm) => {
    elm.addEventListener('click', () => {
      if (!elm.classList.contains('on')) {
        elm.classList.add('on');
      } else if (elm.classList.contains('on')) {
        elm.classList.remove('on');
      }
    });
  });
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
function cartListType(btn, cartList) {
  const $btn = document.querySelector(btn);
  const $cartList = document.querySelector(cartList);

  if ($btn.classList.contains('one')) {
    $btn.classList.remove('one');
    $cartList.classList.remove('one');
    $btn.classList.add('two');
    $cartList.classList.add('two');
  } else if ($btn.classList.contains('two')) {
    $btn.classList.remove('two');
    $cartList.classList.remove('two');
    $btn.classList.add('three');
    $cartList.classList.add('three');
  } else if ($btn.classList.contains('three')) {
    $btn.classList.remove('three');
    $cartList.classList.remove('three');
    $btn.classList.add('one');
    $cartList.classList.add('one');
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

function addFolderList(input, tabListWrap, selectWrap, selectList, btn, tost) {
  const $input = document.querySelector(input);
  const $tabListWrap = document.querySelector(tabListWrap);
  const $tost = document.querySelector(tost);
  if ($input.value.length <= 0) return;

  const $tab = document.createElement('div');
  $tab.setAttribute('class', `tab tab${$tabListWrap.children.length + 1}`);
  $tab.innerHTML = `<a href="javascript:void(0)">${$input.value}</a>`;
  $tabListWrap.appendChild($tab);
  $input.value = '';
  document.body.classList.remove('scrollNone');
  document.querySelector(selectWrap).classList.remove('on');
  document.querySelector(selectList).classList.remove('on');
  document.querySelector(btn).classList.remove('on');

  if ($tost && !$tost.classList.contains('on')) {
    $tost.classList.add('on');
    setTimeout(() => $tost.classList.remove('on'), 1000);
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
function selectListOn(selectBtn, selectWrap, selectList) {
  const $selectBtnValue = document.querySelector(`${selectBtn} .value`);
  const $selectLists = document.querySelectorAll(`${selectList} .list`);
  document.body.classList.add('scrollNone');
  document.querySelector(selectBtn).classList.add('on');
  document.querySelector(selectWrap).classList.add('on');
  document.querySelector(selectList).classList.add('on');

  $selectLists.forEach((elm) =>
    elm.addEventListener('click', () =>
      selectListsCheck($selectLists, elm, $selectBtnValue),
    ),
  );
}

function selectListsCheck($selectLists, $selectList, $selectBtnValue) {
  $selectLists.forEach((elm) => elm.classList.remove('on'));
  $selectList.classList.add('on');
  $selectList.querySelector('div').classList.add('on');
  $selectBtnValue.innerText = `${
    $selectList.querySelector('.value').innerText
  }`;
  if (!$selectBtnValue.classList.contains('on'))
    $selectBtnValue.classList.add('on');
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
  if ($selectBtn.classList.contains('on')) $selectBtn.classList.remove('on');
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
}

function bottomCartAlarm(alarmBtn, cartWrap, textBtn, tost1, tost2) {
  const $alarmBtn = document.querySelector(alarmBtn);
  const $alarmBtnIco = document.querySelector(`${alarmBtn} .ico-b-cart-alarm`);
  const $cartLists = document.querySelectorAll(`${cartWrap} .list`);
  const $textBtn = document.querySelector(textBtn);
  const $tost1 = document.querySelector(tost1);
  const $tost2 = document.querySelector(tost2);
  let count = 0;

  $cartLists.forEach((elm) => {
    const $cartImgBg = elm.querySelector('.img-bg');
    const $cartIcoAlarm = elm.querySelector('.ico-alarm');

    if ($cartImgBg.classList.contains('on')) count += 1;

    if ($alarmBtnIco.classList.contains('on')) {
      if ($cartImgBg.classList.contains('on')) {
        $cartImgBg.classList.remove('on');
        if (!$cartIcoAlarm.classList.contains('on'))
          $cartIcoAlarm.classList.add('on');
      }
    } else if (!$alarmBtnIco.classList.contains('on')) {
      if ($cartImgBg.classList.contains('on')) {
        $cartImgBg.classList.remove('on');
        if ($cartIcoAlarm.classList.contains('on'))
          $cartIcoAlarm.classList.remove('on');
      }
    }
  });

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

function bottomCartFavorites(heartBtn, cartWrap, textBtn, tost1, tost2) {
  const $heartBtn = document.querySelector(heartBtn);
  const $heartBtnIco = document.querySelector(`${heartBtn} .ico-b-cart-heart`);
  const $cartLists = document.querySelectorAll(`${cartWrap} .list`);
  const $textBtn = document.querySelector(textBtn);
  const $tost1 = document.querySelector(tost1);
  const $tost2 = document.querySelector(tost2);
  let count = 0;

  $cartLists.forEach((elm) => {
    const $cartImgBg = elm.querySelector('.img-bg');
    const $cartIcoFavorites = elm.querySelector('.ico-heart');

    if ($cartImgBg.classList.contains('on')) count += 1;

    if ($heartBtnIco.classList.contains('on')) {
      if ($cartImgBg.classList.contains('on')) {
        $cartImgBg.classList.remove('on');
        if (!$cartIcoFavorites.classList.contains('on'))
          $cartIcoFavorites.classList.add('on');
      }
    } else if (!$heartBtnIco.classList.contains('on')) {
      if ($cartImgBg.classList.contains('on')) {
        $cartImgBg.classList.remove('on');
        if ($cartIcoFavorites.classList.contains('on'))
          $cartIcoFavorites.classList.remove('on');
      }
    }
  });

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

function bottomCartRemove(cartWrap, popup, bottomCartMenu, textBtn, tost) {
  const $cartListBefore = document.querySelectorAll(`${cartWrap} .list`);
  const $popup = document.querySelector(popup);
  const $bottomCartMenu = document.querySelector(bottomCartMenu);
  const $textBtn = document.querySelector(textBtn);
  const $tost = document.querySelector(tost);

  $cartListBefore.forEach((elm) => {
    const $cartImgBg = elm.querySelector('.img-bg');

    if ($cartImgBg.classList.contains('on')) {
      elm.remove();
    }
  });

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

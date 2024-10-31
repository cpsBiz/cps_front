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
  const commission = getDevice()
    ? parseInt(item.commissionMobile)
    : parseInt(item.commissionPc);
  const commissionPer = (
    (commission *
      ((parseInt(item.affliateCommissionShare) *
        parseInt(item.userCommissionShare)) /
        100)) /
    100
  ).toFixed(2);

  return commissionPer;
}

// 날짜를 변환하고, 요일을 판단하는 함수
function formatDate(date) {
  let year, month, day;
  let formattedDate = '';
  let dateStr = String(date);

  // 날짜 문자열 길이에 따라 연도, 월, 일을 파싱
  if (dateStr.length === 6) {
    // "YYYYMM" 형식
    year = dateStr.substring(0, 4); // 연도
    month = dateStr.substring(4, 6); // 월
    formattedDate = `${year}.${month}`;
  } else if (dateStr.length === 8) {
    // "YYYYMMDD" 형식
    year = dateStr.substring(0, 4); // 연도
    month = dateStr.substring(4, 6); // 월
    day = dateStr.substring(6, 8); // 일
    formattedDate = `${year}.${month}.${day}`;
  } else {
    console.error('지원하지 않는 날짜 형식입니다.');
    return;
  }

  return formattedDate;
}

function base64Encode(str) {
  return btoa(unescape(encodeURIComponent(str)));
}

function decodeFromBase64(base64String) {
  const jsonString = decodeURIComponent(escape(atob(base64String))); // Base64를 디코딩 후 JSON 문자열로 변환
  const jsonObject = JSON.parse(jsonString); // JSON 문자열을 객체로 변환
  return jsonObject;
}

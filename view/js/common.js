// list type1
const $type1Lists = document.querySelectorAll('.list-wrap.type1 .list')
const $type1ListsIcoHeart = document.querySelectorAll('.list-wrap.type1 .ico-heart')
// list type2
const $type2Lists = document.querySelectorAll('.list-wrap.type2 .list');
const $type2ListsToolTipBox = document.querySelectorAll('.list-wrap.type2 .list .tool-tip-box');
// list type3
const $type3Lists = document.querySelectorAll('.list-wrap.type3 .list');
const $type3ListsTop = document.querySelectorAll('.list-wrap.type3 .list > .top');
const $type3ListsBottom = document.querySelectorAll('.list-wrap.type3 .list > .bottom');
const $type3ListsBottomContent = document.querySelectorAll('.list-wrap.type3 .list > .bottom > div');
// file
const $inputFile1 = document.querySelector('#file-1');

// list type1
if($type1Lists) {
  $type1ListsIcoHeart.forEach(elm => {
    elm.addEventListener('click', () => {
      if(!elm.classList.contains('on')) {
        elm.classList.add('on');
      } else if(elm.classList.contains('on')) {
        elm.classList.remove('on');
      }
    });
  });
}

// list type2
if($type2Lists) {
  $type2Lists.forEach(elm => {
    elm.addEventListener('click', (e) => {
      if(e.target.className === 'tool-tip') return;
      if(e.target.tagName.toLowerCase() !== 'button') {
        $type2ListsToolTipBox.forEach(elm => elm.classList.remove('on'));
      }
    });
  });

  $type2ListsToolTipBox.forEach(elm => {
    elm.addEventListener('click', (e) => {
      if(e.target.className === 'tool-tip') return;
      if(!elm.classList.contains('on')) {
        $type2ListsToolTipBox.forEach(elm => elm.classList.remove('on'));
        elm.classList.add('on');
      } else if(elm.classList.contains('on')) {
        $type2ListsToolTipBox.forEach(elm => elm.classList.remove('on'));
      }
    });
  });
}

// list type3
if($type3Lists) {
  $type3ListsTop.forEach(elm => {
    elm.addEventListener('click', () => {
      const $list = elm.closest('.list');
      const $bottom = elm.closest('.list').querySelector('.bottom');
      const bottomContentHeight = elm.closest('.list').querySelector('.bottom > div').clientHeight;

      if(!$list.classList.contains('on')) {
        $type3ListsBottom.forEach(elm => elm.style.height = '0px');
        $type3Lists.forEach(elm => elm.classList.remove('on'));
        $bottom.style.height = `${bottomContentHeight}px`;
        $list.classList.add('on');

      } else if($list.classList.contains('on')) {
        $type3ListsBottom.forEach(elm => elm.style.height = '0px');
        $type3Lists.forEach(elm => elm.classList.remove('on'));
        $list.classList.remove('on');
      }
    });
  });
}

// resize event
window.addEventListener('resize', () => {
  // list type3
  if($type3Lists) {
    $type3Lists.forEach(elm => {
      if(elm.classList.contains('on')) {
        elm.children[elm.children.length - 1].style.height = `${elm.children[elm.children.length - 1].children[0].clientHeight}px`;
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

  $selectLists.forEach((elm) => elm.addEventListener('click', () => selectListsCheck($selectLists, elm, $selectBtnValue)));
}

function selectListsCheck($selectLists, $selectList, $selectBtnValue) {
  $selectLists.forEach(elm => elm.classList.remove('on'));
  $selectList.classList.add('on');
  $selectBtnValue.innerText = `${$selectList.querySelector('.value').innerText}`;
  if(!$selectBtnValue.classList.contains('on')) $selectBtnValue.classList.add('on');
}

function selectListClose(selectBtn, selectWrap, selectList) {
  const $selectLists = document.querySelectorAll(`${selectList} .list`);
  document.body.classList.remove('scrollNone');
  document.querySelector(selectBtn).classList.remove('on');
  document.querySelector(selectWrap).classList.remove('on');
  document.querySelector(selectList).classList.remove('on');

  $selectLists.forEach((elm) => elm.removeEventListener('click', () => selectListsCheck(elm, $selectBtnValue)));
}

// form box
function formBoxOn(askElms, askTarget, askText, askValue, formBoxElms, formBoxTarget) {
  const $formBoxElms = document.querySelectorAll(formBoxElms);
  const $formBoxTarget = document.querySelector(formBoxTarget);
  const formObj = {
    askElms,
    askTarget,
    askText,
    askValue,
    formBoxElms,
    formBoxTarget
  }
  
  $formBoxElms.forEach(elm => elm.classList.remove('on'));
  $formBoxTarget.classList.add('on');
  sessionStorage.setItem('form-box-number', JSON.stringify(formObj));
}
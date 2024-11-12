<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>스마트 카트</title>
  <!-- style -->
  <link rel="stylesheet" href="/css/style.css?version=<?= $cacheVersion; ?>">
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>스마트 카트</h1>
      <div class="btn-list">
        <a href="./" class="ico-arrow type1 left">이전</a>
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
              <a href="/history/point.php"></a>
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
              <a href="/history/stick.php"></a>
            </div>
          </div>
        </div>
      </div>
      <!-- 카트 리스트 -->
      <div class="cont cont1">
        <div class="tab-box-wrap type2">
          <div class="tab-box">
            <div class="tab tab1 on"><a href="javascript:void(0)">전체보기</a></div>
            <div class="tab tab2"><a href="javascript:void(0)">전자기기</a></div>
            <div class="tab tab3"><a href="javascript:void(0)">과자</a></div>
          </div>
          <button id="select-btn2" class="folder" type="button" onclick="selectInputOn('#select-wrap', '#select-list2')">폴더</button>
        </div>
        <div class="cart-link-list">
          <div class="top">
            <p><span>지금</span> 구매하세요!</p>
            <div id="top-down-btn1" class="select-btn type4" onclick="topDowmBoxOnOff('#top-down-btn1', '.cart-link-list > .bottom')">
              <p class="value">2개</p>
              <div class="ico-arrow type2 bottom"></div>
            </div>
          </div>
          <div class="bottom">
            <div class="item">
              <div class="text">
                <span></span>
                <p>드디어<br>할인 시작!</p>
              </div>
              <div class="img-box">
                <div class="img img1" style="background-image: url(/images/test/상품1.png);"></div>
                <div class="img img2" style="background-image: url(/images/test/상품1.png);"></div>
                <p class="count">2</p>
              </div>
              <a href="./sub-1-1.html"></a>
            </div>
          </div>
        </div>
        <div class="stiky-wrap">
          <div class="cart-set-list">
            <div id="select-btn1" class="select-btn type3" onclick="selectListOn('#select-btn1', '#select-wrap', '#select-list1')">
              <p class="value">최신순</p>
              <div class="ico-arrow type2 bottom"></div>
            </div>
            <div class="set-list">
              <button type="button" id="select-text1" class="select-text" onclick="cartListOrganizeOn('#select-text1', '.cart-list-wrap', '#bottom-cart-menu1', '#cart-alarm1', '#bottom-popup1')">선택</button>
              <button type="button" class="ico-array one" onclick="cartListType('.cart-set-list .ico-array', '.cart-list-wrap')">정렬</button>
              <button type="button" id="main-heart" class="ico-heart" onclick="onOff('.cart-set-list .ico-heart'), favoritesList('#main-heart', '#cart-list-wrap1')">즐겨찾기</button>
            </div>
          </div>
        </div>
        <!-- 리스트 있을 경우 -->
        <div id="cart-list-wrap1" class="cart-list-wrap type1 one">
          <div id="list1" class="list">
            <div class="img-box" style="background-image: url(/images/test/상품1.png);">
              <div class="lowest-price">최저가</div>
              <button class="ico-heart" type="button"></button>
              <button class="ico-alarm" type="button"></button>
            </div>
            <div class="text-box">
              <div class="logo-box">
                <div class="logo coupang"></div>
                <p class="logo-title">쿠팡</p>
              </div>
              <p class="title">더리얼 비타민D 5000IU, 180정, 더리얼 비타민D 5000IU 더리얼 비타민D 5000IU, 180정, 더리얼 비타민D 5000IU</p>
              <div class="price-box">
                <p class="price">26,550</p>
                <div class="up-down up">24%</div>
              </div>
            </div>
            <a href="./sub-1-2.html"></a>
            <div
              class="check-box"
              onclick="
                onOff('#list1 .check-box .img-bg', '#bottom-popup1'), 
                cartListOrganizeCheck('#select-text1', '.cart-list-wrap'),
                bottomCartAlarmChangeCheck('#cart-alarm1', '#cart-list-wrap1')
              ">
              <div class="img-bg">
                <span class="check"></span>
              </div>
            </div>
          </div>
          <div id="list2" class="list">
            <div class="img-box" style="background-image: url(/images/test/상품2.png);">
              <div class="lowest-price">최저가</div>
              <button class="ico-heart" type="button"></button>
              <button class="ico-alarm" type="button"></button>
            </div>
            <div class="text-box">
              <div class="logo-box">
                <div class="logo coupang"></div>
                <p class="logo-title">쿠팡</p>
              </div>
              <p class="title">더리얼 비타민D 5000IU, 180정, 더리얼 비타민D 5000IU 더리얼 비타민D 5000IU, 180정, 더리얼 비타민D 5000IU</p>
              <div class="price-box">
                <p class="price">26,550</p>
                <div class="up-down down">24%</div>
              </div>
            </div>
            <a href="./sub-1-2.html"></a>
            <div
              class="check-box"
              onclick="
                onOff('#list2 .check-box .img-bg', '#bottom-popup1'), 
                cartListOrganizeCheck('#select-text1', '.cart-list-wrap'),
                bottomCartAlarmChangeCheck('#cart-alarm1', '#cart-list-wrap1')
              ">
              <div class="img-bg">
                <span class="check"></span>
              </div>
            </div>
          </div>
          <div id="list3" class="list">
            <div class="img-box" style="background-image: url(/images/test/상품1.png);">
              <div class="lowest-price">최저가</div>
              <button class="ico-heart" type="button"></button>
              <button class="ico-alarm" type="button"></button>
            </div>
            <div class="text-box">
              <div class="logo-box">
                <div class="logo coupang"></div>
                <p class="logo-title">쿠팡</p>
              </div>
              <p class="title">더리얼 비타민D 5000IU, 180정, 더리얼 비타민D 5000IU 더리얼 비타민D 5000IU, 180정, 더리얼 비타민D 5000IU</p>
              <div class="price-box">
                <p class="price">26,550</p>
                <div class="up-down up">24%</div>
              </div>
            </div>
            <a href="./sub-1-2.html"></a>
            <div
              class="check-box"
              onclick="
                onOff('#list3 .check-box .img-bg', '#bottom-popup1'), 
                cartListOrganizeCheck('#select-text1', '.cart-list-wrap'),
                bottomCartAlarmChangeCheck('#cart-alarm1', '#cart-list-wrap1')
              ">
              <div class="img-bg">
                <span class="check"></span>
              </div>
            </div>
          </div>
          <div id="list4" class="list">
            <div class="img-box" style="background-image: url(/images/test/상품2.png);">
              <div class="lowest-price">최저가</div>
              <button class="ico-heart" type="button"></button>
              <button class="ico-alarm" type="button"></button>
            </div>
            <div class="text-box">
              <div class="logo-box">
                <div class="logo coupang"></div>
                <p class="logo-title">쿠팡</p>
              </div>
              <p class="title">더리얼 비타민D 5000IU, 180정, 더리얼 비타민D 5000IU 더리얼 비타민D 5000IU, 180정, 더리얼 비타민D 5000IU</p>
              <div class="price-box">
                <p class="price">26,550</p>
                <div class="up-down down">24%</div>
              </div>
            </div>
            <a href="./sub-1-2.html"></a>
            <div
              class="check-box"
              onclick="
                onOff('#list4 .check-box .img-bg', '#bottom-popup1'), 
                cartListOrganizeCheck('#select-text1', '.cart-list-wrap'),
                bottomCartAlarmChangeCheck('#cart-alarm1', '#cart-list-wrap1')
              ">
              <div class="img-bg">
                <span class="check"></span>
              </div>
            </div>
          </div>
          <div id="list5" class="list">
            <div class="img-box" style="background-image: url(/images/test/상품1.png);">
              <div class="lowest-price">최저가</div>
              <button class="ico-heart" type="button"></button>
              <button class="ico-alarm" type="button"></button>
            </div>
            <div class="text-box">
              <div class="logo-box">
                <div class="logo coupang"></div>
                <p class="logo-title">쿠팡</p>
              </div>
              <p class="title">더리얼 비타민D 5000IU, 180정, 더리얼 비타민D 5000IU 더리얼 비타민D 5000IU, 180정, 더리얼 비타민D 5000IU</p>
              <div class="price-box">
                <p class="price">26,550</p>
                <div class="up-down up">24%</div>
              </div>
            </div>
            <a href="./sub-1-2.html"></a>
            <div
              class="check-box"
              onclick="
                onOff('#list5 .check-box .img-bg', '#bottom-popup1'), 
                cartListOrganizeCheck('#select-text1', '.cart-list-wrap'),
                bottomCartAlarmChangeCheck('#cart-alarm1', '#cart-list-wrap1')
              ">
              <div class="img-bg">
                <span class="check"></span>
              </div>
            </div>
          </div>
          <div id="list6" class="list">
            <div class="img-box" style="background-image: url(/images/test/상품2.png);">
              <div class="lowest-price">최저가</div>
              <button class="ico-heart" type="button"></button>
              <button class="ico-alarm" type="button"></button>
            </div>
            <div class="text-box">
              <div class="logo-box">
                <div class="logo coupang"></div>
                <p class="logo-title">쿠팡</p>
              </div>
              <p class="title">더리얼 비타민D 5000IU, 180정, 더리얼 비타민D 5000IU 더리얼 비타민D 5000IU, 180정, 더리얼 비타민D 5000IU</p>
              <div class="price-box">
                <p class="price">26,550</p>
                <div class="up-down down">24%</div>
              </div>
            </div>
            <a href="./sub-1-2.html"></a>
            <div
              class="check-box"
              onclick="
                onOff('#list6 .check-box .img-bg', '#bottom-popup1'), 
                cartListOrganizeCheck('#select-text1', '.cart-list-wrap'),
                bottomCartAlarmChangeCheck('#cart-alarm1', '#cart-list-wrap1')
              ">
              <div class="img-bg">
                <span class="check"></span>
              </div>
            </div>
          </div>
        </div>
        <!-- 등록된 상품 없을 경우 -->
        <div class="list-none-box">
          <p><span class="ico-nonecart"></span>등록된 상품이 없습니다.</p>
        </div>
        <!-- 등록된 폴더 없을 경우 -->
        <div class="list-none-box folder">
          <div class="center">
            <p><span class="ico-nonefolder"></span>[전자기기]<br>폴더가 비어있어요.</p>
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
      <p id="tost4" class="tost-popup type2">즐겨찾기가 추가 되었습니다.</p>
      <p id="tost5" class="tost-popup type2">상품이 삭제 되었습니다.</p>
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
            <p class="value">즐겨찾기순</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list5">
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
      <button type="button" onclick="bottomCartCancel('#bottom-cart-menu1', '#cart-list-wrap1', '#select-text1', '#cart-alarm1')"><span class="ico-b-cart-cancel"></span>취소</button>
      <button id="cart-alarm1" type="button" onclick="bottomCartAlarm('#cart-alarm1', '#cart-list-wrap1', '#select-text1', '#tost2', '#tost3')"><span class="ico-b-cart-alarm on"></span>알림 켜기</button>
      <button type="button" onclick="bottomCartFavorites('#cart-list-wrap1', '#select-text1', '#tost4')"><span class="ico-b-cart-heart"></span>즐겨찾기 설정</button>
      <button type="button" onclick="bottomPopupOn('#bottom-popup1', '#cart-list-wrap1')"><span class="ico-b-cart-remove"></span>삭제</button>
    </div>
    <div id="bottom-popup1" class="bottom-popup type1">
      <div class="head">
        <p></p>
        <button class="ico-close type1" type="button" onclick="onOff('#bottom-popup1')">닫기</button>
      </div>
      <div class="btn-box">
        <button type="button" class="gray" onclick="onOff('#bottom-popup1')">취소</button>
        <button type="button" class="blue" onclick="bottomCartRemove('#cart-list-wrap1', '#bottom-popup1', '#bottom-cart-menu1', '#select-text1', '#tost5')">확인</button>
      </div>
    </div>
    <? include_once $_SERVER['DOCUMENT_ROOT'] . "/footer.php"; ?>
  </div>
</body>
<script src="/js/common.js?version=<?= $cacheVersion; ?>"></script>

</html>
<script>
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
</script>
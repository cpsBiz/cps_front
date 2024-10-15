<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>내역</title>
  <link rel="icon" type="image/x-icon" href="./images/favicon.ico">
  <!-- style -->
  <link rel="stylesheet" href="./css/style.css">
  <script src="./js/history.js"></script>
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>내역</h1>
      <div class="btn-list">
        <a href="./index.php" class="ico-arrow type1 left">이전</a>
      </div>
    </header>
    <!-- main -->
    <!-- hana 클래스 추가 시 시그니처 컬러 변경 -->
    <div class="sub sub-5">
      <div class="history-link-wrap">
        <!-- link에 on 추가 하면 효과 적용 -->
        <div class="link point">
          <div class="icon"></div>
          <p>포인트</p>
          <a href="javascript:moveHistory('point')"></a>
        </div>
        <div class="link candy">
          <div class="icon"></div>
          <p>막대사탕</p>
          <a href="javascript:moveHistory('stick')"></a>
        </div>
        <div class="link gift on">
          <div class="icon"></div>
          <p>기프티콘</p>
          <a href="javascript:moveHistory('gifticon')"></a>
        </div>
      </div>
      <div class="line line1">
        <a href="./notice-gifticon.php">[필독] 꼭 읽어보세요! (기프티콘)<span class="ico-arrow type1 right"></span></a>
      </div>
      <!-- 기프티콘 당첨내역 -->
      <div class="cont cont3">
        <div class="line line2">
          <p>기프티콘 당첨내역</p>
          <div id="select-btn3" class="select-btn type2" onclick="selectListOn('#select-btn3', '#select-wrap', '#select-list3')">
            <p class="value">2024년 9월</p>
            <div class="ico-arrow type2 bottom"></div>
          </div>
        </div>
        <div class="tab-box-wrap">
          <div class="tab-box">
            <div class="tab tab1 on"><a href="javascript:void(0)">사용가능</a></div>
            <div class="tab tab2"><a href="javascript:void(0)">지급예정</a></div>
            <div class="tab tab2"><a href="javascript:void(0)">사용완료/만료</a></div>
          </div>
        </div>
        <!-- 리스트 있을 경우 -->
        <!-- 기프티콘 사용가능 -->
        <div class="list-wrap type6 type6-1">
          <div class="list list1">
            <div class="img-box" style="background-image: url(./images/test/스타벅스\ 상품.png);"></div>
            <div class="text-box">
              <div class="title-box">
                <div class="logo-box">
                  <div class="logo" style="background-image: url(./images/test/스타벅스로고.png);"></div>
                  <p class="logo-title">스타벅스</p>
                </div>
                <p class="title">아이스 카페 아메리카노 T</p>
              </div>
              <div class="info-box">
                <p class="date date1">당첨일자 (2024.08.15)</p>
                <p class="date date2">유효기간 (2024.10.15)</p>
              </div>
            </div>
            <a href="./gifticon-detail.php"></a>
          </div>
        </div>
        <!-- 기프티콘 지급예정 -->
        <div class="list-wrap type6 type6-2">
          <div class="list list1">
            <div class="img-box" style="background-image: url(./images/test/스타벅스\ 상품.png);"></div>
            <div class="text-box">
              <div class="title-box">
                <div class="logo-box">
                  <div class="logo" style="background-image: url(./images/test/스타벅스로고.png);"></div>
                  <p class="logo-title">스타벅스</p>
                </div>
                <p class="title">아이스 카페 아메리카노 T</p>
              </div>
              <div class="info-box">
                <p class="date date1">당첨일자 (2024.08.15)</p>
                <p class="date date2">유효기간 (2024.10.15)</p>
              </div>
            </div>
            <a href="./gifticon-detail.php"></a>
          </div>
        </div>
        <!-- 기프티콘 사용만료 -->
        <div class="list-wrap type6 type6-3">
          <div class="list list1">
            <div class="img-box" style="background-image: url(./images/test/스타벅스\ 상품.png);"></div>
            <div class="text-box">
              <div class="title-box">
                <div class="logo-box">
                  <div class="logo" style="background-image: url(./images/test/스타벅스로고.png);"></div>
                  <p class="logo-title">스타벅스</p>
                </div>
                <p class="title">아이스 카페 아메리카노 T</p>
              </div>
              <div class="info-box">
                <p class="date date1">당첨일자 (2024.08.15)</p>
                <p class="date date2">유효기간 (2024.10.15)</p>
              </div>
            </div>
            <a href="./gifticon-detail.php"></a>
          </div>
        </div>
        <!-- 리스트 없을 경우 -->
        <div class="list-none-box">
          <p><span class="ico-exclamation"></span>적립내역이 없습니다.</p>
        </div>
      </div>
    </div>
    <!-- 셀렉트 박스 -->
    <div id="select-wrap">
      <!-- 기프티콘 상세내역 셀렉트 -->
      <div id="select-list3" class="select-list">
        <div class="select-head">
          <p>조회 월 선택</p>
          <button class="ico-close type1" type="button" onclick="selectListClose('#select-btn3', '#select-wrap', '#select-list3')">닫기</button>
        </div>
        <ul class="select-cont">
          <li class="list list1 on">
            <p class="value">2024년 9월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list2">
            <p class="value">2024년 8월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list3">
            <p class="value">2024년 7월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list4">
            <p class="value">2024년 6월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list5">
            <p class="value">2024년 5월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list6">
            <p class="value">2024년 4월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list7">
            <p class="value">2024년 3월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list8">
            <p class="value">2024년 2월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list9">
            <p class="value">2024년 1월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list10">
            <p class="value">2023년 12월</p>
            <div class="ico-check on"></div>
          </li>
        </ul>
      </div>
    </div>
    <div class="bottom-menu-wrap">
      <a class="menu" href="javascript:void(0)"><span class="ico-cart">카트</span></a>
      <a class="menu" href="./index.php"><span class="ico-save">적립</span></a>
      <a class="menu" href="javascript:void(0)"><span class="ico-trend">트렌드</span></a>
      <a class="menu" href="javascript:void(0)"><span class="ico-delivery">배송</span></a>
      <a class="menu on" href="./history-point.php"><span class="ico-breakDown">내역</span></a>
    </div>
  </div>
  <script src="./js/common.js"></script>
  <script src="./js/page.js"></script>
</body>

</html>
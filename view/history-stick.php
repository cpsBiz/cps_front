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
  <script type="text/javascript" src="../admin/js/lib/jquery-2.2.2.min.js"></script>
  <script type="text/javascript" src="../admin/js/lib/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="../admin/js/lib/jquery-ui.min.js"></script>
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
        <div class="link candy on">
          <div class="icon"></div>
          <p>막대사탕</p>
          <a href="javascript:moveHistory('stick')"></a>
        </div>
        <div class="link gift">
          <div class="icon"></div>
          <p>기프티콘</p>
          <a href="javascript:moveHistory('gifticon')"></a>
        </div>
      </div>
      <!-- 쇼핑내역 막대사탕 -->
      <div class="candy-info-wrap">
        <div class="candy-info">
          <div class="text-box">
            <p class="text">내 막대사탕</p>
            <p id="userStick" class="candy"></p>
          </div>
        </div>
      </div>
      <div class="line line1">
        <a href="./notice-stick.php">[필독] 꼭 읽어보세요! (막대사탕)<span class="ico-arrow type1 right"></span></a>
      </div>
      <!-- 막대사탕 상세내역 -->
      <div class="cont cont2">
        <div class="line line2">
          <p>막대사탕 상세내역</p>
          <div id="select-btn2" class="select-btn type2" onclick="selectListOn('#select-btn2', '#select-wrap', '#select-list2')">
            <p class="value">2024년 9월</p>
            <div class="ico-arrow type2 bottom"></div>
          </div>
        </div>
        <div class="tab-box-wrap">
          <div class="tab-box">
            <div class="tab tab1 on"><a href="javascript:void(0)">적립</a></div>
            <div class="tab tab2"><a href="javascript:void(0)">사용/취소</a></div>
          </div>
        </div>
        <!-- 리스트 있을 경우 -->
        <!-- 막대사탕 적립 -->
        <div class="list-wrap type5 type5-1">
          <div class="list list1">
            <div class="text-box text-box1">
              <div class="text text1">
                <p>곡물그대로21 크리스피롤 1.5kg 오리지널곡물그대로21 크리스피롤 1.5kg 오리지널</p>
                <span>외 1건</span>
              </div>
              <p class="text text2">21,230원</p>
            </div>
            <div class="text-box text-box2">
              <p class="date">24.09.03</p>
              <p class="state">2개</p>
            </div>
          </div>
          <div class="list list1">
            <div class="text-box text-box1">
              <div class="text text1">
                <p>곡물그대로21 크리스피롤 1.5kg 오리지널곡물그대로21 크리스피롤 1.5kg 오리지널</p>
              </div>
              <p class="text text2">21,230원</p>
            </div>
            <div class="text-box text-box2">
              <p class="date">24.09.03</p>
              <p class="state">2개</p>
            </div>
          </div>
        </div>
        <!-- 막대사탕 사용/취소 -->
        <div class="list-wrap type5 type5-2">
          <div class="list list1">
            <div class="text-box text-box1">
              <div class="text text1">
                <p>곡물그대로21 크리스피롤 1.5kg 오리지널곡물그대로21 크리스피롤 1.5kg 오리지널</p>
                <span>외 1건</span>
              </div>
              <p class="text text2">21,230원</p>
            </div>
            <div class="text-box text-box2">
              <p class="date">24.09.03</p>
              <div class="state-box">
                <p class="state">2개</p>
                <p class="state-info red">취소</p>
              </div>
            </div>
          </div>
          <div class="list list1">
            <div class="text-box text-box1">
              <div class="text text1">
                <p>곡물그대로21 크리스피롤 1.5kg 오리지널곡물그대로21 크리스피롤 1.5kg 오리지널</p>
                <span>외 1건</span>
              </div>
              <p class="text text2">21,230원</p>
            </div>
            <div class="text-box text-box2">
              <p class="date">24.09.03</p>
              <div class="state-box">
                <p class="state">2개</p>
                <p class="state-info blue">사용</p>
              </div>
            </div>
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
      <!-- 막대사탕 상세내역 셀렉트 -->
      <div id="select-list2" class="select-list">
        <div class="select-head">
          <p>조회 월 선택</p>
          <button class="ico-close type1" type="button" onclick="selectListClose('#select-btn2', '#select-wrap', '#select-list2')">닫기</button>
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

<script>
  $(function() {
    getStick();
  });

  // 쿠팡 막대사탕 조회
  function getStick() {
    try {
      const userId = '';
      const affliateId = '';

      // AJAX 요청 데이터 설정
      const requestData = {
        userId,
        affliateId
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: 'http://192.168.101.156/api/view/memberStick',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const userStick = parseInt(result.data.cnt).toLocaleString();
          const appendUserStick = `${userStick}개`;
          $('#userStick').append(appendUserStick);
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
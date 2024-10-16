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
        <div class="link point on">
          <div class="icon"></div>
          <p>포인트</p>
          <a href="javascript:moveHistory('point')"></a>
        </div>
        <div class="link candy">
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
      <!-- 쇼핑내역 포인트 -->
      <div class="point-info-wrap">
        <div class="point-info">
          <div class="text-box">
            <div>
              <p class="title">총 적립 포인트</p>
              <div class="tool-tip-box">
                <button class="ico-question" type="button">툴팁</button>
                <div class="tool-tip">쇼핑적립을 통해 적립이<br>완료된 총 포인트</div>
              </div>
            </div>
            <p id="userCommission" class="point"></p>
          </div>
          <div class="text-box">
            <div>
              <p class="title">적립 예정 포인트</p>
              <div class="tool-tip-box">
                <button class="ico-question" type="button">툴팁</button>
                <div class="tool-tip">
                  <p>쇼핑적립을 통해 적립 예정인 총 포인트</p>
                  <ul>
                    <li>* 쇼핑몰에 따라 최대 90일 소요</li>
                    <li>* 해외 쇼핑몰 최대 6개월</li>
                    <li>* 여행 최대 1년</li>
                  </ul>
                </div>
              </div>
            </div>
            <p id="expectedUserCommission" class="point"></p>
          </div>
        </div>
      </div>
      <div class="line line1">
        <a href="./notice-point.php">[필독] 꼭 읽어보세요! (포인트)<span class="ico-arrow type1 right"></span></a>
      </div>
      <!-- 포인트 상세내역 -->
      <div class="cont cont1">
        <div class="line line2">
          <p>포인트 상세내역</p>
          <div id="select-btn1" class="select-btn type2" onclick="selectListOn('#select-btn1', '#select-wrap', '#select-list1')">
            <p class="value">2024년 9월</p>
            <div class="ico-arrow type2 bottom"></div>
          </div>
        </div>
        <div class="tab-box-wrap">
          <div class="tab-box">
            <div class="tab tab1 on"><a href="javascript:void(0)">전체</a></div>
            <div class="tab tab2"><a href="javascript:void(0)">예정</a></div>
            <div class="tab tab3"><a href="javascript:void(0)">확정</a></div>
            <div class="tab tab4"><a href="javascript:void(0)">취소</a></div>
          </div>
        </div>
        <!-- 리스트 있을 경우 -->
        <div class="list-wrap type2">
          <div class="list list1 red">
            <p class="title">쿠팡</p>
            <div class="text-box">
              <p class="text text1">곡물그대로21 크리스피롤 1.5kg 오리지널곡물그대로21 크리스피롤 1.5kg 오리지널</p>
              <p class="text text2">21,230원</p>
            </div>
            <div class="point-box">
              <div class="text text1">
                <p>적립예정</p>
                <div class="tool-tip-box">
                  <button class="ico-question" type="button"></button>
                  <div class="tool-tip">적립예정일: 구매 완료 3개월 이내</div>
                </div>
              </div>
              <p class="text text2">+1,230</p>
            </div>
            <div class="info-box">
              <p class="date">24.09.03</p>
              <p class="state">쇼핑적립</p>
            </div>
          </div>
          <div class="list list2 blue">
            <p class="title">쿠팡</p>
            <div class="text-box">
              <p class="text text1">곡물그대로21 크리스피롤 1.5kg 오리지널곡물그대로21 크리스피롤 1.5kg 오리지널</p>
              <p class="text text2">21,230원</p>
            </div>
            <div class="point-box">
              <div class="text text1">
                <p>적립확정</p>
                <div class="tool-tip-box">
                  <button class="ico-question" type="button"></button>
                  <div class="tool-tip">적립예정일: 구매 완료 3개월 이내</div>
                </div>
              </div>
              <p class="text text2">+1,230</p>
            </div>
            <div class="info-box">
              <p class="date">24.09.03</p>
              <p class="state">카트공유</p>
            </div>
          </div>
          <div class="list list3 green">
            <p class="title">쿠팡</p>
            <div class="text-box">
              <p class="text text1">곡물그대로21 크리스피롤 1.5kg 오리지널곡물그대로21 크리스피롤 1.5kg 오리지널</p>
              <p class="text text2">21,230원</p>
            </div>
            <div class="point-box">
              <div class="text text1">
                <p>적립취소</p>
              </div>
              <p class="text text2">+1,230</p>
            </div>
            <div class="info-box">
              <p class="date">24.09.03</p>
              <p class="state">배송조회</p>
            </div>
          </div>
          <div class="list list4 green">
            <p class="title">쿠팡</p>
            <div class="text-box">
              <p class="text text1">곡물그대로21 크리스피롤 1.5kg 오리지널곡물그대로21 크리스피롤 1.5kg 오리지널</p>
              <p class="text text2">21,230원</p>
            </div>
            <div class="point-box">
              <div class="text text1">
                <p>적립취소</p>
              </div>
              <p class="text text2">+1,230</p>
            </div>
            <div class="info-box">
              <p class="date">24.09.03</p>
              <p class="state">배송조회</p>
            </div>
          </div>
          <div class="list list5 red">
            <p class="title">쿠팡</p>
            <div class="text-box">
              <p class="text text1">곡물그대로21 크리스피롤 1.5kg 오리지널곡물그대로21 크리스피롤 1.5kg 오리지널</p>
              <p class="text text2">21,230원</p>
            </div>
            <div class="point-box">
              <div class="text text1">
                <p>적립예정</p>
                <div class="tool-tip-box">
                  <button class="ico-question" type="button"></button>
                  <div class="tool-tip">적립예정일: 구매 완료 3개월 이내</div>
                </div>
              </div>
              <p class="text text2">+1,230</p>
            </div>
            <div class="info-box">
              <p class="date">24.09.03</p>
              <p class="state">쇼핑적립</p>
            </div>
          </div>
          <div class="list list6 blue">
            <p class="title">쿠팡</p>
            <div class="text-box">
              <p class="text text1">곡물그대로21 크리스피롤 1.5kg 오리지널곡물그대로21 크리스피롤 1.5kg 오리지널</p>
              <p class="text text2">21,230원</p>
            </div>
            <div class="point-box">
              <div class="text text1">
                <p>적립확정</p>
                <div class="tool-tip-box">
                  <button class="ico-question" type="button"></button>
                  <div class="tool-tip">적립예정일: 구매 완료 3개월 이내</div>
                </div>
              </div>
              <p class="text text2">+1,230</p>
            </div>
            <div class="info-box">
              <p class="date">24.09.03</p>
              <p class="state">카트공유</p>
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
      <!-- 포인트 상세내역 셀렉트 -->
      <div id="select-list1" class="select-list">
        <div class="select-head">
          <p>조회 월 선택</p>
          <button class="ico-close type1" type="button" onclick="selectListClose('#select-btn1', '#select-wrap', '#select-list1')">닫기</button>
        </div>
        <ul class="select-cont">
          <li class="list list1 on" onclick="getCommissionList()">
            <p class="value">2024년 9월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list2" onclick="getCommissionList()">
            <p class="value">2024년 8월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list3" onclick="getCommissionList()">
            <p class="value">2024년 7월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list4" onclick="getCommissionList()">
            <p class="value">2024년 6월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list5" onclick="getCommissionList()">
            <p class="value">2024년 5월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list6" onclick="getCommissionList()">
            <p class="value">2024년 4월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list7" onclick="getCommissionList()">
            <p class="value">2024년 3월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list8" onclick="getCommissionList()">
            <p class="value">2024년 2월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list9" onclick="getCommissionList()">
            <p class="value">2024년 1월</p>
            <div class="ico-check on"></div>
          </li>
          <li class="list list10" onclick="getCommissionList()">
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
    getCommission();
    getCommissionList();
  });

  // 회원 적립금 조회
  function getCommission() {
    try {
      const userId = 'dhhan';
      const affliateId = 'moneyweather';

      // AJAX 요청 데이터 설정
      const requestData = {
        userId,
        affliateId
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: 'http://192.168.101.156/api/view/memberCommission',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const userCommission = parseInt(result.data.userCommission).toLocaleString();
          const expectedUserCommission = parseInt(result.data.expectedUserCommission).toLocaleString();
          const appendUserCommission = `<span class="ico-point"></span>${userCommission}`;
          const appendExpectedUserCommission = `<span class="ico-point"></span>${expectedUserCommission}`;
          $('#userCommission').append(appendUserCommission);
          $('#expectedUserCommission').append(appendExpectedUserCommission);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error.message);
    }
  }

  // 회원 적립금 리스트 조회
  function getCommissionList() {
    try {
      const userId = "dhhan";
      const affliateId = "moneyweather";
      const regYm = convertToYYYYMM(document.querySelector('#select-list1 .list.on').children[0].innerHTML);
      const status = 0;

      // AJAX 요청 데이터 설정
      const requestData = {
        userId,
        affliateId,
        regYm,
        status
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: 'http://192.168.101.156/api/view/memberCommissionList',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          selectListClose('#select-btn1', '#select-wrap', '#select-list1');
          renderCommissionList(result);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error.message);
    }
  }

  // 회원 적립금 리스트 렌더링
  function renderCommissionList(data) {
    console.log(data);
  }
</script>
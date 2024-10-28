<?
// 현재 날짜를 기준으로 최근 1년의 월을 가져오는 함수
function getLastYearMonths()
{
  $months = [];
  // 현재 날짜로부터 12개월 전까지 반복
  for ($i = 0; $i < 12; $i++) {
    $month = date('Y년 n월', strtotime("-$i month")); // "-$i month"를 통해 과거 월을 계산
    $months[] = $month;
  }
  return $months;
}

// 월 리스트 가져오기
$months = getLastYearMonths();
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>내역</title>
  <link rel="icon" type="image/x-icon" href="/view/images/favicon.ico">
  <!-- style -->
  <link rel="stylesheet" href="/view/css/style.css">
  <script type="text/javascript" src="/admin/js/lib/jquery-2.2.2.min.js"></script>
  <script type="text/javascript" src="/admin/js/lib/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="/admin/js/lib/jquery-ui.min.js"></script>

</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>내역</h1>
      <div class="btn-list">
        <a href="/view/index.php" class="ico-arrow type1 left">이전</a>
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
        <a href="/view/notice/point.php">[필독] 꼭 읽어보세요! (포인트)<span class="ico-arrow type1 right"></span></a>
      </div>
      <!-- 포인트 상세내역 -->
      <div class="cont cont1">
        <div class="line line2">
          <p>포인트 상세내역</p>
          <div id="select-btn1" class="select-btn type2" onclick="selectListOn('#select-btn1', '#select-wrap', '#select-list1')">
            <p class="value"><?= $months[0]; ?></p>
            <div class="ico-arrow type2 bottom"></div>
          </div>
        </div>
        <div class="tab-box-wrap">
          <div class="tab-box">
            <div class="tab tab1 on"><a href="javascript:checkFilter(0)">전체</a></div>
            <div class="tab tab2"><a href="javascript:checkFilter(100)">예정</a></div>
            <div class="tab tab3"><a href="javascript:checkFilter(210)">확정</a></div>
            <div class="tab tab4"><a href="javascript:checkFilter(310)">취소</a></div>
          </div>
        </div>
        <!-- 리스트 있을 경우 -->
        <div class="list-wrap type2"></div>
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
          <?
          foreach ($months as $index => $month) {
            // 클래스와 onclick 핸들러 설정
            $listClass = "list list" . ($index + 1);
            $isActive = ($index === 0) ? 'on' : ''; // 첫 번째 항목만 활성화
          ?>
            <li class="<?= $listClass . ' ' . $isActive; ?>" onclick="checkFilter('','<?= $month; ?>')">
              <p class="value"><?= $month; ?></p>
              <div class="ico-check <?= $isActive; ?>"></div>
            </li>
          <?
          }
          ?>
        </ul>
      </div>
    </div>
    <div class="bottom-menu-wrap">
      <a class="menu" href="javascript:void(0)"><span class="ico-cart">카트</span></a>
      <a class="menu" href="/view/index.php"><span class="ico-save">적립</span></a>
      <a class="menu" href="javascript:void(0)"><span class="ico-trend">트렌드</span></a>
      <a class="menu" href="javascript:void(0)"><span class="ico-delivery">배송</span></a>
      <a class="menu on" href="/view/history/point.php"><span class="ico-breakDown">내역</span></a>
    </div>
  </div>
</body>
<script src="/view/js/common.js"></script>
<script src="/view/js/page.js"></script>
<script src="/view/js/history.js"></script>

</html>
<script>
  $(function() {
    getCommission();
    getCommissionList(0, "<?= $months[0]; ?>");
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
        url: 'https://app.shoplus.io/api/view/memberCommission',
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

  let checkStatus = 0;
  let checkDate = '<?= $months[0] ?>';

  function checkFilter(status, date) {
    if (status !== '') checkStatus = status;
    if (date) checkDate = date;

    getCommissionList(checkStatus, checkDate);
  }

  // 회원 적립금 리스트 조회
  function getCommissionList(status, date) {
    try {
      const userId = "dhhan";
      const affliateId = "moneyweather";
      const regYm = convertDate(date);

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
        url: 'https://app.shoplus.io/api/view/memberCommissionList',
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
    $('.list-none-box').css('display', 'none');
    $('.list-wrap.type2').empty();

    const datas = data.datas;
    if (!datas || datas.length === 0) {
      $('.list-none-box').css('display', 'block');
      return;
    }

    let list = '';
    datas.forEach(item => {
      let status = {
        text: '',
        color: ''
      }
      switch (item.status) {
        case 100:
          status.text = '적립예정';
          status.color = 'red';
          break;
        case 210:
          status.text = '적립확정';
          status.color = 'blue';
          break;
        case 310:
          status.text = '적립취소';
          status.color = 'green';
          break;
      }

      list += `
              <div class="list ${status.color}">
                <p class="title">${item.campaignName}</p>
                <div class="text-box">
                  <p class="text text1">${item.productName}</p>
                  <p class="text text2">${item.productPrice.toLocaleString()}원</p>
                </div>
                <div class="point-box">
                  <div class="text text1">
                    <p>${status.text}</p>
                    ${item.status === 100 ? `
                    <div class="tool-tip-box">
                      <button class="ico-question" type="button"></button>
                      <div class="tool-tip">적립예정일: ${item.commissionPaymentStandard}</div>
                    </div>
                    ` : ''}  
                  </div>
                  <p class="text text2">+${item.userCommission.toLocaleString()}</p>
                </div>
                <div class="info-box">
                  <p class="date">${formatDate(item.regDay)}</p>
                  <!--<p class="state">쇼핑적립</p>-->
                </div>
              </div>
              `;
    });
    $('.list-wrap.type2').append(list);

    historyPointEvent();
  }
</script>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
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
  <!-- style -->

</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>내역</h1>
      <div class="btn-list">
        <a href="javascript:history.back()" class="ico-arrow type1 left">이전</a>
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
        <a href="/notice/stick.php">[필독] 꼭 읽어보세요! (막대사탕)<span class="ico-arrow type1 right"></span></a>
      </div>
      <!-- 막대사탕 상세내역 -->
      <div class="cont cont2">
        <div class="line line2">
          <p>막대사탕 상세내역</p>
          <div id="select-btn2" class="select-btn type2" onclick="selectListOn('#select-btn2', '#select-wrap', '#select-list2')">
            <p class="value"><?= $months[0]; ?></p>
            <div class="ico-arrow type2 bottom"></div>
          </div>
        </div>
        <div class="tab-box-wrap">
          <div class="tab-box">
            <div class="tab tab1 on"><a href="javascript:checkFilter(200)">확정</a></div>
            <div class="tab tab2"><a href="javascript:checkFilter(100)">예정</a></div>
            <div class="tab tab3"><a href="javascript:checkFilter(0)">사용/취소</a></div>
          </div>
        </div>
        <!-- 리스트 있을 경우 -->
        <div class="list-wrap type5 type5-1">
          <!-- 막대사탕 적립 type5에 type5-1추가필요 -->
          <!-- 막대사탕 사용/취소 type5에 type5-2추가필요 -->
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
    <? include_once $_SERVER['DOCUMENT_ROOT'] . "/footer.php"; ?>
  </div>
</body>
<script src="<?= $appApiUrl; ?>/js/common.js?version=<?= $cacheVersion; ?>"></script>
<script src="<?= $appApiUrl; ?>/js/page.js?version=<?= $cacheVersion; ?>"></script>
<script src="../js/history.js?version=<?= $cacheVersion; ?>"></script>

</html>

<script>
  $(function() {
    getStick();
    getStickList(200, "<?= $months[0]; ?>");
  });

  // 쿠팡 막대사탕 조회
  function getStick() {
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
          const userStick = parseInt(result.data.cnt - result.data.stockCnt).toLocaleString();
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

  let checkStatus = 200;
  let checkDate = '<?= $months[0] ?>';

  function checkFilter(status, date) {
    if (status !== '') checkStatus = status;
    if (date) checkDate = date;

    getStickList(checkStatus, checkDate);
  }

  // 막대사탕 리스트 조회
  function getStickList(status, date) {
    try {
      const userId = "<?= $checkUserId; ?>";
      const merchantId = "coupang";
      const affliateId = "<?= $checkAffliateId; ?>";
      const regYm = convertDate(date);

      // AJAX 요청 데이터 설정
      const requestData = {
        userId,
        merchantId,
        affliateId,
        regYm,
        status
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/view/coupangStickList',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          selectListClose('#select-btn2', '#select-wrap', '#select-list2');
          renderStickList(result);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error.message);
    }
  }

  // 막대사탕 리스트 렌더링
  function renderStickList(data) {
    $('.list-none-box').css('display', 'none');
    $('.list-wrap.type5').empty();

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
        case 210:
          status.text = '사용';
          status.color = 'blue';
          break;
        case 310:
          status.text = '취소';
          status.color = 'red';
          break;
      }

      let stickCnt = 0;
      if (item.status === 210) {
        const checkCnt = item.cnt - item.stockCnt;
        stickCnt = checkCnt === 0 ? item.cnt : checkCnt;
      } else {
        stickCnt = item.cnt;
      }
      stickCnt = stickCnt.toLocaleString();

      list += `
              <div class="list">
                <div class="text-box text-box1">
                  <div class="text text1">
                    <p>${item.productName}</p>
                    ${item.rewardCnt > 1 ? 
                    `<span>외 ${item.rewardCnt - 1}건</span>` : ''
                    }
                  </div>
                  <p class="text text2">${item.totalPrice.toLocaleString()}원</p>
                </div>
                <div class="text-box text-box2">
                  <p class="date">${formatDate(item.regDay)}</p>
                  ${(item.status === 210 || item.status === 310) ? `
                  <div class="state-box">
                    <p class="state">${stickCnt}개</p>
                    <p class="state-info ${status.color}">${status.text}</p>
                  </div>`:
                  `<p class="state">${stickCnt}개</p>`
                  }
                </div>
              </div>
              `;
    });
    document.querySelector('.list-wrap.type5').classList.remove('type5-1', 'type5-2');
    document.querySelector('.list-wrap.type5').classList.add(checkStatus === 200 ? 'type5-1' : 'type5-2');
    $('.list-wrap.type5').append(list);
  }
</script>
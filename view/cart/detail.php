<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<?
$object = $_REQUEST['object'] ?? null; // null로 기본값 설정
if (!$object) {
  header('Location: /main.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="format-detection" content="telephone=no" />
  <title>상품 가격정보</title>
  <!-- style -->
  <link rel="stylesheet" href="style.css" />
  <!-- <link rel="stylesheet" href="../css/style.css?version=<?= $cacheVersion; ?>"> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/1.4.0/chartjs-plugin-annotation.min.js"></script>
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>상품 가격정보</h1>
      <div class="btn-list">
        <a href="javascript:history.back();" class="ico-arrow type1 left">이전</a>
        <div>
          <a
            href="javascript:void(0)"
            id="select-btn1"
            class="ico-remove"
            onclick="selectInputOn('#select-wrap', '#select-list1')">삭제</a>
          <a
            href="javascript:void(0)"
            id="ico-heart1"
            class="ico-heart type2"
            onclick="onOff('#ico-heart1')">즐겨찾기</a>
        </div>
      </div>
    </header>
    <!-- sub-1-2 -->
    <!-- hana class 추가 시 시그니처 컬러 변경 -->
    <div class="sub sub-1-2">
      <div class="cart-goods-price-info"></div>
      <div class="graph-wrap">
        <div class="title-box">
          <p class="title">가격 변동 그래프</p>
          <button
            type="button"
            class="ico-question"
            onclick="popupOn('#popup-wrap', '#popup1')">
            질문
          </button>
        </div>
        <div class="graph-set" style="display: none;">
          <p>
            해당 상품은 처음 추가된 상품이라<br />
            가격 그래프가 보이지 않습니다.<br />
            내일부터 가격 그래프를 볼 수 있습니다.
          </p>
        </div>
        <canvas
          id="price-chart"
          class="graph-main"
          style="
              display: flex;
              justify-content: center;
              align-items: center;
              text-align: center;
            ">
        </canvas>
        <div class="price-info">
          <p class="price up">최고가<span>2,052,000원</span></p>
          <p class="price flat">등록가<span>1,957,337원</span></p>
          <p class="price down">최저가<span>1,925,200원</span></p>
        </div>
      </div>
      <div class="alarm-set">
        <p class="title">추가 알림 설정</p>
        <div class="link-box">
          <p class="title">가격 알림 설정</p>
          <p class="price">설정 안됨</p>
          <a
            id="select-btn2"
            href="javascript:void(0)"
            onclick="selectInputOn('#select-wrap', '#select-list2')"></a>
        </div>
        <div class="gray-box">
          <ul>
            <li>
              가격 알림 설정 금액보다 구매 금액이 낮아지면 알림을 보내
              드립니다. 최초 금액은 등록금액이 기준이 됩니다.
            </li>
            <li>
              가격 알림 설정은 변경하실 수 있으며, 변경시 변경된 금액보다
              낮아질때 알림을 보내 드립니다.
            </li>
            <li>실제 구매 금액은 해당 쇼핑몰에 꼭 확인 후 구매하세요.</li>
          </ul>
        </div>
        <a id="buttonUrl" href="javascript:getClickRewardUrl()" class="c-btn blue">구매하러 가기</a>
      </div>
      <!-- 토스트 팝업 -->
      <p id="tost1" class="tost-popup">즐겨찾기 설정 완료</p>
      <p id="tost2" class="tost-popup">즐겨찾기 설정 해제</p>
    </div>
    <!-- select-wrap -->
    <div id="select-wrap">
      <!-- 정렬 방식 셀렉트 -->
      <div id="select-list1" class="select-list type4">
        <div class="select-head">
          <p>상품을 삭제할까요?</p>
          <button
            class="ico-close type1"
            type="button"
            onclick="selectListClose('#select-btn1', '#select-wrap', '#select-list1')">
            닫기
          </button>
        </div>
        <div class="select-cont">
          <p class="text">
            상품을 삭제하면 더 이상<br />가격 할인 정보 알림을 받을 수
            없습니다.
          </p>
          <div class="btn-box">
            <button
              class="btn gray"
              type="button"
              onclick="selectListClose('#select-btn1', '#select-wrap', '#select-list1')">
              취소
            </button>
            <button class="btn" type="button">삭제</button>
          </div>
        </div>
      </div>
      <div id="select-list2" class="select-list type4">
        <div class="select-head">
          <p>사고 싶은 가격 입력</p>
          <button
            class="ico-close type1"
            type="button"
            onclick="selectListClose('#select-btn2', '#select-wrap', '#select-list2')">
            닫기
          </button>
        </div>
        <div class="select-cont">
          <input type="text" placeholder="현재 가격 : 설정 안됨" />
          <p class="text">
            등록가대비 일정 요율(%) 로 알림을 받기 원하시면 [설정] →
            [알림감도] 에서 설정하세요.
          </p>
          <div class="btn-box">
            <button
              class="btn gray"
              type="button"
              onclick="selectListClose('#select-btn2', '#select-wrap', '#select-list2')">
              취소
            </button>
            <button class="btn" type="button" onclick="updateWantPrice()">입력</button>
          </div>
        </div>
      </div>
    </div>
    <!-- popup-wrap -->
    <div id="popup-wrap">
      <!-- popup1 -->
      <div id="popup1" class="popup type3">
        <div class="box">
          <p class="title">그래프 색깔의 의미는?</p>
          <p class="info-text">
            <span class="blue">하늘색</span>: 최고가,
            <span class="red">빨간색</span>: 최저가
          </p>
          <p class="text">
            하루에도 가격이 여러번 변하기 때문에 하루의 최고가 최저가를 모두
            알려드리고 있습니다.
          </p>
          <div class="btn-box">
            <button
              class="popup-btn"
              type="button"
              onclick="popupClose('#popup-wrap', '#popup1')">
              확인
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../js/common.js?version=<?= $cacheVersion; ?>"></script>
</body>

</html>
<script>
  const object = decodeFromBase64(`<?= $object ?>`);

  $(function() {
    getItemData(object);
  })

  function getItemData(object) {
    try {
      if (!object) {
        alert('잘못된 접근입니다.');
        history.back();
        return;
      }

      const productCode = object.productCode;
      const optionCode = object.optionCode;
      const merchantId = object.merchantId;

      if (!productCode || !optionCode) {
        alert('잘못된 접근입니다.')
        history.back();
        return;
      }

      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        merchantId,
        productCode,
        optionCode,
      }

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cartSearchDetail',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') {
            alert(result.resultMessage);
            location.back();
            return;
          }
          renderItem(result.data);
          renderChart(result.data);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        },
      });

    } catch (error) {
      alert(error);
    }
  }

  function renderItem(data) {
    const productPrice = parseInt(data.productPrice);
    const cartPrice = parseInt(data.cartPrice);
    const priceChange = calculatePriceChange(cartPrice, productPrice);

    const badge = data.badge ? `<p class="lowest-price">${data.badge}}</p>` : '';
    const currentDate = new Date();
    const goodsInfo = `
                <div class="top">
                  <div class="img" style="background-image: url(${data.productImage})"></div>
                  <div class="text-box">
                    <p class="title">${data.memberName}</p>
                    <p class="text">${data.productName}</p>
                  </div>
                </div>
                <div class="bottom">
                  <div class="price-box">
                    <div class="price">
                      <p class="main-price">${productPrice.toLocaleString()}<span>원</span></p>
                      <p class="sub-price">${cartPrice.toLocaleString()}</p>
                      <p class="date">(${currentDate.getMonth() + 1}/${currentDate.getDate()})</p>
                    </div>
                    <div class="percent-box">
                      <p class="percent ${priceChange.type}">${priceChange.rate}</p>
                    </div>
                  </div>
                  ${badge}
                </div>
                `;

    $('.cart-goods-price-info').empty();
    $('.cart-goods-price-info').append(goodsInfo);

    if (data.wantPrice !== 0) {
      document.querySelector('.alarm-set .link-box .price').innerHTML = `${data.wantPrice.toLocaleString()}원`;
      document.querySelector('#select-list2 .select-cont input').value = data.wantPrice;
    }
  }

  function renderChart(result) {
    const data = result.productGraphList;
    if (!data || data.length === 0) {
      $('.graph-set').show();
      $('#price-chart').hide();
      renderPriceInfo(result.cartPrice, 'all');
      return;
    }

    const findExtremePrice = (data, type) => {
      // 날짜를 내림차순으로 정렬 (최신 날짜 우선)
      const sortedData = [...data].sort((a, b) => b.regDay - a.regDay);

      if (type === 'max') {
        // 최고가 찾기
        const maxPrice = Math.max(...data.map(item => item.maxPrice));
        // 최고가와 동일한 가격 중 가장 최근 데이터 찾기
        return sortedData.find(item => item.maxPrice === maxPrice).maxPrice;
      } else {
        // 최저가 찾기
        const minPrice = Math.min(...data.map(item => item.minPrice));
        // 최저가와 동일한 가격 중 가장 최근 데이터 찾기
        return sortedData.find(item => item.minPrice === minPrice).minPrice;
      }
    };

    // 데이터에서 최고가와 최저가 추출
    const historicalHigh = findExtremePrice(data, 'max');
    const historicalLow = findExtremePrice(data, 'min');
    renderPriceInfo(historicalHigh, 'max');
    renderPriceInfo(historicalLow, 'min');
    renderPriceInfo(result.cartPrice, 'now');

    // 날짜 포맷 변환 (YYYYMMDD -> MM/DD)
    const formatDate = (dateNum) => {
      const dateStr = dateNum.toString();
      const month = dateStr.substring(4, 6);
      const day = dateStr.substring(6, 8);
      return `${month}/${day}`;
    };

    const ctx = document.getElementById('price-chart').getContext('2d');
    const chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: data.map(item => formatDate(item.regDay)),
        datasets: [{
            label: '최고가',
            data: data.map(item => item.maxPrice),
            borderColor: 'rgb(54, 162, 235)',
            backgroundColor: 'rgba(255, 99, 132, 0.1)',
            pointHoverBackgroundColor: '#000',
            tension: 0.1,
            pointRadius: 3,
          },
          {
            label: '최저가',
            data: data.map(item => item.minPrice),
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(54, 162, 235, 0.1)',
            pointHoverBackgroundColor: '#000',
            tension: 0.1,
            pointRadius: 3,
          },
        ],
      },
      options: {
        responsive: true,
        interaction: {
          mode: 'index',
          intersect: false,
        },
        layout: {
          padding: {
            top: 20,
          }
        },
        plugins: {
          legend: false,
          tooltip: {
            titleAlign: 'center',
            displayColors: false,
            callbacks: {
              label: function(context) {
                return `${context.dataset.label}: ${context.parsed.y.toLocaleString()}원`;
              },
            },
          },
          annotation: {
            annotations: {
              highLine: {
                type: 'line',
                yMin: historicalHigh,
                yMax: historicalHigh,
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1,
                borderDash: [5, 5],
                tension: 0,
                label: {
                  content: `역대최고가 ${historicalHigh.toLocaleString()}원`,
                  enabled: true,
                  position: 'end',
                  yAdjust: -20,
                  backgroundColor: 'transparent',
                  color: 'rgb(54, 162, 235)',
                  font: {
                    size: 10
                  },
                },
              },
              lowLine: {
                type: 'line',
                yMin: historicalLow,
                yMax: historicalLow,
                borderColor: 'rgb(255, 99, 132)',
                borderWidth: 1,
                borderDash: [5, 5],
                tension: 0,
                label: {
                  content: `역대최저가 ${historicalLow.toLocaleString()}원`,
                  enabled: true,
                  position: 'end',
                  yAdjust: 20,
                  backgroundColor: 'transparent',
                  color: 'rgb(255, 99, 132',
                  font: {
                    size: 10
                  },
                },
              },
            },
          },
        },
        scales: {
          x: {
            grid: {
              display: false
            },
            ticks: {
              padding: 10,
              callback: function(val, index) {
                if (val.length > 6) {
                  return index % 10 === 0 ? this.getLabelForValue(val) : '';
                } else {
                  return this.getLabelForValue(val);
                }
              },
            },
          },
          y: {
            display: false,
          },
        },
      },
    });
  }

  function renderPriceInfo(price, type = 'all') {
    const priceTypes = {
      max: '.up',
      min: '.down',
      now: '.flat',
      all: ['.up', '.down', '.flat']
    };

    const formatPrice = (price) => `${price.toLocaleString()}원`;

    try {
      if (type === 'all') {
        priceTypes.all.forEach(selector => {
          document.querySelector(`.price-info ${selector} span`).innerHTML = formatPrice(price);
        });
      } else {
        const selector = priceTypes[type];
        if (!selector) throw new Error('Invalid price type');
        document.querySelector(`.price-info ${selector} span`).innerHTML = formatPrice(price);
      }
    } catch (error) {
      console.error('Price rendering failed:', error);
    }
  }

  function updateWantPrice() {
    try {
      let wantPrice = parseInt(document.querySelector('#select-list2 .select-cont input').value);

      let itemList = [];
      const obj = {
        merchantId: object.merchantId,
        productCode: object.productCode,
        optionCode: object.optionCode,
        favorites: object.favorites,
        cartPrice: object.cartPrice,
        wantPrice: !wantPrice ? 0 : wantPrice,
        alarm: object.alarm,
        returnalarm: object.returnalarm
      };
      itemList.push(obj);

      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        adId: '',
        apiType: 'U',
        productList: itemList
      };

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cartProduct',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') {
            alert(result.resultMessage);
            location.reload();
            return
          }
          if (!wantPrice || wantPrice === 0) {
            document.querySelector('.alarm-set .link-box .price').innerHTML = '설정 안됨'
            document.querySelector('#select-list2 .select-cont input').value = '';
          } else {
            document.querySelector('.alarm-set .link-box .price').innerHTML = wantPrice.toLocaleString() + '원';
            document.querySelector('#select-list2 .select-cont input').value = wantPrice;
          }
          selectListClose('#select-btn2', '#select-wrap', '#select-list2');
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        },
      });
    } catch (error) {
      alert(error);
    }
  }

  function getClickRewardUrl() {
    try {
      $('#buttonUrl').attr('href', 'javascript:void(0)');

      // AJAX 요청 데이터 설정
      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        merchantId: object.merchantId,
        clickUrl: object.clickUrl,
        zoneId: '<?= $checkZoneId; ?>',
        site: '<?= $checkSite; ?>',
        os: getOs(),
        adId: '<?= $checkAdId; ?>'
      };

      let apiUrl = '';
      switch (object.merchantId) {
        case 'coupang':
          apiUrl = '<?= $appApiUrl; ?>/api/clickCoupang/cartProductClick';
          break;
      }

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: apiUrl,
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const buttonUrl = result.data.clickUrl;
          if (!buttonUrl) {
            alert('잘못된 접근입니다.');
            history.back();
            return;
          }

          location.href = buttonUrl;
          $('#buttonUrl').attr('href', `javascript:getClickRewardUrl()`);
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
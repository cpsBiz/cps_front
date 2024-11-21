<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="format-detection" content="telephone=no" />
  <title>알림</title>
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>알림</h1>
      <div class="btn-list">
        <a href="javascript:history.back()" class="ico-arrow type1 left">이전</a>
      </div>
    </header>
    <!-- alarm -->
    <!-- hana class 추가 시 시그니처 컬러 변경 -->
    <div class="page-alarm">
      <div class="alarm-list-wrap type1"></div>
    </div>
  </div>
  <script src="../js/common.js?version=<?= $cacheVersion; ?>"></script>
</body>

</html>
<script>
  $(function() {
    getAlarmList();
  })

  const exData = [{
    id: 1,
    type: '가격하락 안내',
    productName: '더리얼 비타민D 5000IU',
    cartPrice: 18000,
    productPrice: 13500,
    regDate: '2024-11-20 18:00:00',
    merchantId: '11st'
  }, {
    id: 2,
    type: '가격하락 안내',
    productName: '더리얼 비타민D 5000IU',
    cartPrice: 18000,
    productPrice: 13500,
    regDate: '2024-11-20 18:00:00',
    merchantId: '11st'
  }, {
    id: 3,
    type: '가격하락 안내',
    productName: '더리얼 비타민D 5000IU',
    cartPrice: 18000,
    productPrice: 13500,
    regDate: '2024-11-20 18:00:00',
    merchantId: '11st'
  }, ]

  function getAlarmList() {
    try {
      const requestData = {

      };
      renderAlarmList();

    } catch (error) {
      alert(error);
    }
  }

  function renderAlarmList(data) {
    let list = '';

    exData.forEach(item => {
      const cartPrice = item.cartPrice;
      const productPrice = item.productPrice;
      const price = calculatePriceChange(cartPrice, productPrice);

      list += `
              <div class="list blue" onclick="location.href='alarmDetail.php?id=${item.id}'">
                <div class="alarm-head">
                  <p class="title">[${item.type}]</p>
                  <p class="date">${item.regDate}</p>
                </div>
                <div class="alarm-cont">
                  <div
                    class="img"
                    style="background-image: url(images/merchant/${item.merchantId}.png)"></div>
                  <div class="text-box">
                    <p class="title type1">${item.productName}</p>
                    <p class="text"><span>등록</span>${cartPrice.toLocaleString()}원</p>
                    <p class="price">
                      <span>현재</span>${productPrice.toLocaleString()}원<span class="up-down ${price.type}">${price.rate}</span>
                    </p>
                  </div>
                </div>
              </div>
              `;
    });

    $('.alarm-list-wrap').empty();
    $('.alarm-list-wrap').append(list);
  }
</script>
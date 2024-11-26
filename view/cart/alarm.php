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
      <div class="alarm-list-wrap type1">
        <div id="alarm-list-none" style="display: none;">받은 알림이 아직 없습니다.</div>
      </div>
    </div>
  </div>
  <script src="../js/common.js?version=<?= $cacheVersion; ?>"></script>
</body>

</html>
<script>
  $(function() {
    getAlarmList();
  })

  function getAlarmList() {
    try {
      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        merchantId: 'coupang'
      };

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/pushList',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.datas && result.resultCode === '0000') {
            renderAlarmList(result.datas)
          } else {
            $('#alarm-list-none').show();
          }
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        },
      });
    } catch (error) {
      alert(error);
    }
  }

  function renderAlarmList(data) {
    let list = '';

    data.forEach(item => {
      const cartPrice = item.cartPrice;
      const productPrice = item.productPrice;
      const price = calculatePriceChange(cartPrice, productPrice);

      const formatDate = (dateStr) => {
        return dateStr.replace(/-/g, '.').slice(0, -3);
      }
      list += `
              <div class="list blue" onclick="">
                <div class="alarm-head">
                  <p class="date">${formatDate(item.regDate)}</p>
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
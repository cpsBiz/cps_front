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
      <div class="cart-goods-price-info">
        <div class="top">
          <div
            class="img"
            style="background-image: url(../images/test/상품1.png)"></div>
          <div class="text-box">
            <p class="title">마크모크(MacMoc)</p>
            <p class="text">
              Kanga 5Color 하트 러블리 천연 가죽 모카신 로퍼 3cm
            </p>
          </div>
        </div>
        <div class="bottom">
          <div class="price-box">
            <div class="price">
              <p class="main-price">88,000<span>원</span></p>
              <p class="sub-price">88,000</p>
              <p class="date">(10/30)</p>
            </div>
            <div class="percent-box">
              <p class="percent up">7%</p>
              <p class="percent down">7%</p>
            </div>
          </div>
          <p class="lowest-price">최저가</p>
        </div>
      </div>
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
        <div class="graph-set">
          <p>
            해당 상품은 처음 추가된 상품이라<br />
            가격 그래프가 보이지 않습니다.<br />
            내일부터 가격 그래프를 볼 수 있습니다.
          </p>
        </div>
        <div
          class="graph-main"
          style="
              display: flex;
              justify-content: center;
              align-items: center;
              text-align: center;
            ">
          <p>여기에 그래프 라이브러리 넣어주세요</p>
        </div>
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
        <a href="javascript:void(0)" class="c-btn blue">구매하러 가기</a>
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
            <button class="btn" type="button">입력</button>
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

      if (!productCode || !optionCode) {
        alert('잘못된 접근입니다.')
        history.back();
        return;
      }

      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        productCode,
        optionCode,
        orderbyName: '',
        favorites: '',
        folderNum: 0
      }

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cartSearch',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') {
            alert(result.resultMessage);
            location.back();
            return;
          }
          renderItem(result.datas[0])

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
                      <p class="sub-price">88,000</p>
                      <p class="date">(10/30)</p>
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

  }
</script>
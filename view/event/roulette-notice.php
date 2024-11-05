<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>쿠팡 이벤트 안내</title>
  <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
  <!-- style -->
  <link rel="stylesheet" href="/css/style.css">
  <!-- swiper -->
  <link rel="stylesheet" href="/css/swiper-min.css">
  <script src="/js/swiper.js"></script>
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>쿠팡 이벤트 안내</h1>
      <div class="btn-list">
        <a href="javscript:history.back()" class="ico-arrow type1 left">이전</a>
      </div>
    </header>
    <!-- main -->
    <!-- hana 클래스 추가 시 시그니처 컬러 변경 -->
    <div class="sub sub-2-4">
      <div class="img-box">
        <img src="/images/coupang-event.png" alt="쿠팡 쇼핑하면 행운의룰렛이 무료!, 쿠팡 구매금액 1만원당 막대사탕 1개, 최소 7개부터 100%당첨 행운의 룰렛 GO! GO!">
      </div>
      <div class="swiper coupang-swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="item item1">
              <p class="step">STEP 1</p>
              <p class="text">
                <span>적립 메뉴</span>를 클릭<br>
                제공되는 <span>쿠팡 쇼핑 GO!</span>에서<br>
                쿠팡으로 이동해주세요.
              </p>
              <div class="img-box">
                <div class="img"></div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="item item2">
              <p class="step">STEP 2</p>
              <p class="text">
                쿠팡에서 <span>1만원 이상</span> 구매시<br>
                1만원당 1개의 막대사탕을<br>
                적립해드려요!
              </p>
              <div class="img-box">
                <div class="img"></div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="item item3">
              <p class="step">STEP 3</p>
              <p class="text text1">
                적립된 막대사탕을 사용해<br>
                적립메뉴의 행운의 룰렛 GO! GO!
              </p>
              <p class="text text2"><span>100% 당첨</span>의 기회를 드립니다.</p>
              <div class="img-box">
                <div class="img"></div>
                <p class="text">*기프티콘은 당첨 후 30일 이내에 지급됩니다.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </div>
  <script>
    let swiper = new Swiper(".coupang-swiper", {
      slidesPerView: 1,
      loop: true,
      speed: 700,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
    });
  </script>
  <script src="/js/common.js"></script>
  <script src="/js/page.js"></script>
</body>

</html>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>카트 메뉴 사용법</title>
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>카트 메뉴 사용법</h1>
      <div class="btn-list">
        <a id="prev-link1" href="javascript:history.back()" class="ico-arrow type1 left">이전</a>
      </div>
    </header>
    <!-- cart use guide  -->
    <div class="page-cart-use-guide">
      <div class="img-box">
        <p class="title">카트 서비스 이용 <span>가이드</span></p>
        <div class="img"></div>
      </div>
      <div class="tab-box-wrap">
        <div class="tab-box">
          <div id="tab1" class="tab on"><button type="button" onclick="tabMenuOnOff('#tab1', '#cont-box1', '.tab', '.cont-box')">상품 추가</button></div>
          <div id="tab2" class="tab"><button type="button" onclick="tabMenuOnOff('#tab2', '#cont-box2', '.tab', '.cont-box')">폴더 추가</button></div>
          <div id="tab3" class="tab"><button type="button" onclick="tabMenuOnOff('#tab3', '#cont-box3', '.tab', '.cont-box')">알림 설정</button></div>
          <div id="tab4" class="tab"><button type="button" onclick="tabMenuOnOff('#tab4', '#cont-box4', '.tab', '.cont-box')">기타</button></div>
        </div>
      </div>
      <div id="cont-box1" class="cont-box on">
        <p class="text">원하는 상품을 카트에 추가해보세요.<br>추가한 상품의 가격이 내려가면 알림을 보내줘요!</p>
        <div class="item">
          <p class="num">01</p>
          <p class="title">페이지 우측 하단 <i class="ico ico1-1"></i>버튼을 눌러주세요</p>
          <div class="img img1-1"></div>
        </div>
        <div class="item">
          <p class="num">02</p>
          <p class="title">각 쇼핑몰별<br>‘상품추가 GO!’ 버튼을 눌러주세요</p>
          <div class="img img1-2"></div>
          <p class="text">아직은 쿠팡에 있는 상품만 가능해요<br>하루빨리 다른 쇼핑몰도 준비해드릴게요!</p>
        </div>
        <div class="item">
          <p class="num">03</p>
          <p class="title">접속한 쇼핑몰 페이지에서 추가하고 싶은<br>상품의 ‘공유하기’ <i class="ico ico1-2"></i>버튼을 눌러주세요</p>
          <div class="img img1-3"></div>
          <p class="text">웹페이지에는 ‘공유하기’ 버튼이 없을 수 있으니<br>쇼핑몰 APP을 설치해서 이용해주세요.</p>
        </div>
        <div class="item">
          <p class="num">04</p>
          <p class="title">공유하기 화면에서 '더보기' 클릭 후 쇼핑적립<br>이 있던 APP으로 공유해주시면 추가 완료!</p>
          <div class="img img1-4"></div>
          <p class="text">예를 들어 A라는 앱을 통해서 쇼핑적립 카트 페이지로<br>들어왔다면 A앱으로 공유해주시면 돼요!</p>
        </div>
        <div class="item">
          <p class="num">04-1</p>
          <p class="title">공유할 APP이 보이지 않는다면 오른쪽으로<br>스와이프 한 뒤 ‘더 보기’ 버튼을 눌러주시면<br>원하시는 APP을 찾을 수 있어요</p>
          <div class="img img1-5"></div>
        </div>
        <div class="item">
          <p class="num">05</p>
          <p class="title">상품을 추가하면<br>시간당 2번 포인트를 받을 수 있어요</p>
          <div class="img img1-6"></div>
          <p class="text">쇼핑적립 페이지를 거치지 않는다면<br>상품페이지를 다시 한번 방문해 줘야해요</p>
        </div>
        <div class="item">
          <p class="num">06</p>
          <p class="title">해당 카트 페이지를 통해 상품을 구매하면<br>구매 금액의 일부를 포인트로 받을 수 있어요</p>
          <div class="img img1-7"></div>
          <p class="text">쿠팡은 1만원당 막대사탕 1개를 적립 받을 수 있고<br>적립 받은 막대사탕은 기프티콘으로 교환 가능해요</p>
        </div>
      </div>
      <div id="cont-box2" class="cont-box">
        <p class="text">추가한 상품들을 폴더링을 통해<br>손쉽게 관리할 수 있어요!</p>
        <div class="item">
          <p class="num">01</p>
          <p class="title">폴더아이콘 <i class="ico ico2-1"></i>버튼을 눌러 추가하세요</p>
          <div class="img img2-1"></div>
        </div>
        <div class="item">
          <p class="num">02</p>
          <p class="title">폴더의 이름을 설정하세요</p>
          <div class="img img2-2"></div>
        </div>
        <div class="item">
          <p class="num">03</p>
          <p class="title">‘선택’ 을 누르시거나<br>상품을 길게 꾹 눌러주세요</p>
          <div class="img img2-3"></div>
        </div>
        <div class="item">
          <p class="num">04</p>
          <p class="title">상품을 선택한 상태에서 폴더를 눌러주면<br>상품을 옮길 수 있어요.</p>
          <div class="img img2-4"></div>
        </div>
      </div>
      <div id="cont-box3" class="cont-box">
        <p class="text">가격 할인, 재입고, 카드 할인 등<br>각종 상황 발생 시 알림으로 알려드려요!</p>
        <div class="item">
          <p class="num">01</p>
          <p class="title">‘설정’ 탭에서 알림 설정 및 해지를 진행할 수<br>있어요. 특히 추가한 상품의 가격이 인하되었<br>을때 알려주기 때문에 유용해요</p>
          <div class="img img3-1"></div>
        </div>
        <div class="item">
          <p class="num">02</p>
          <p class="title">‘알림 감도 설정’으로 내가 추가한 상품의<br>가격이 할인될 경우 알려줘요</p>
          <div class="img img3-2"></div>
          <p class="text">상품을 카트에 추가한 시점의 가격(등록가)을 기준으<br>로 감도 설정에서 설정한 할인율만큼 할인되면 알려줘요.</p>
        </div>
        <div class="item">
          <p class="num">03</p>
          <p class="title">등록한 상품 상세페이지에 있는<br>‘가격 알림 설정’을 통해 원하는 가격을<br>직접 설정할 수 있어요</p>
          <div class="img img3-3"></div>
          <p class="text">가격 알림 설정을 한 상품은 알림 감도 설정과 상관없이 무조건<br>설정한 가격 이하로 내려가야만 알림을 드릴거에요.</p>
        </div>
        <div class="item">
          <p class="num">04</p>
          <p class="title">보유한 카드를 설정하면 해당 카드 할인 혜택<br>이있을때 알려줘요</p>
          <div class="img img3-4"></div>
        </div>
        <div class="item">
          <p class="num">05</p>
          <p class="title">재입고, 반품 상품, 로켓배송 알림 등<br>다양한 알림을 받아볼 수 있어요.</p>
          <div class="img img3-5"></div>
        </div>
      </div>
      <div id="cont-box4" class="cont-box">
        <p class="text">카트 서비스 이용 시<br>도움 될만한 정보를 안내드려요!</p>
        <div class="item">
          <p class="num">01</p>
          <p class="title">추가된 상품은 보시기 편한 배열을<br>선택할 수 있어요</p>
          <div class="img img4-1"></div>
        </div>
        <div class="item">
          <p class="num">02</p>
          <p class="title">쿠팡 와우 회원이면<br>와우 회원가에 맞춰서 가격을 알려줘요</p>
          <div class="img img4-2"></div>
          <p class="text">설정에서 쿠팡 와우 회원이라고 설정해주세요.</p>
        </div>
        <div class="item">
          <p class="num">03</p>
          <p class="title">상품 상태는 새 상품과 동일하나<br>단순 변심, 박스 훼손 등으로 반품된 상품은<br>더욱 저렴하게 구매할 수 있어요</p>
          <div class="img img4-3"></div>
          <p class="text">‘설정’에서 ‘반품 상품 알림’을 체크하면<br>반품 상품이 들어왔을 때 알려줘요.</p>
        </div>
        <div class="item">
          <p class="num">04</p>
          <p class="title"> 상품 상세페이지에서 그래프를 누르면<br>날짜별 가격 변동 상태를 확인할 수 있어요</p>
          <div class="img img4-4"></div>
          <p class="text">단, 추가하기 전 시점의 그래프는 확인할 수 없어요.</p>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= $appApiUrl; ?>/js/common.js?version=<?= $cacheVersion; ?>"></script>
  <script src="<?= $appApiUrl; ?>/js/page.js?version=<?= $cacheVersion; ?>"></script>
</body>

</html>
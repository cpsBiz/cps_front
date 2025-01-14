<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>포인트 적립 안내</title>
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>포인트 적립 안내</h1>
      <div class="btn-list">
        <a href="javascript:history.back()" class="ico-arrow type1 left">이전</a>
      </div>
    </header>
    <!-- sub-1 -->
    <!-- hana class 추가 시 시그니처 컬러 변경 -->
    <div class="sub sub-1-3">
      <p class="text type1 ico1">상품을 <span>카트</span>에 추가하고<br><span>포인트</span>를 적립하세요</p>
      <div class="text-box text-box1">
        <p class="num">1</p>
        <p class="text type1 ico2">매 정시 마다<br>시간당 <span>2회</span> 참여</p>
        <p class="num">2</p>
        <p class="text type1 ico3">포인트<br>100% 당첨</p>
        <p class="num">3</p>
        <p class="text type1 ico4">하루 최대 <span>48회</span><br>당첨 기회</p>
      </div>
      <div class="text-box text-box2">
        <p class="text type2 ico1">원하는 상품을 <span>카트</span>에 담고<br>포인트를 받아가세요</p>
        <p class="text type2 ico2">담은 상품을 구매하면<br>구매금액 1만원당 <span>막대사탕</span><br>1개를 증정해드려요!</p>
      </div>
      <a class="btn btn1" href="javascript:void(0)">상품 추가 방법 보기<i></i></a>
      <button class="btn btn2" type="button" onclick="moveMain()">상품 추가하기<i></i></button>
      <div class="text-box">
        <p class="text type3">유의사항</p>
        <div class="gray-box">
          <ul>
            <li>카트에 등록한 상품 개수당 포인트가 적립되며 시간당 2회까지 가능합니다.</li>
            <li>매 정시 기준으로 포인트 적립 기회가 제공되며, 2회를 모두 참여한 경우 다음 정시가 되면 재참여가 가능합니다.</li>
            <li>이미 카트에 등록한 상품은 삭제 후 재등록하여도 포인트 적립이 불가능합니다. 단 시간당 적립 기회를 모두 참여한 이후 등록한 상품에 대해서는 다음 정시에 삭제 후 재등록 시 포인트가 적립됩니다.</li>
            <li>카트에 등록한 상품은 구매금액 1만원당 막대사탕 1개가 제공되며 막대 사탕은 '적립 > 쿠팡 구매금액 1만원 당 막대사탕 1개 > 행운의룰렛 GO' 에서 기프티콘으로 교환 가능합니다.</li>
            <li>위 이벤트의 일정 및 세부내용은 사전 고지 없이 변경 또는 종료 될 수 있습니다.</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= $appApiUrl; ?>/js/common.js?version=<?= $cacheVersion; ?>"></script>
  <script src="<?= $appApiUrl; ?>/js/page.js?version=<?= $cacheVersion; ?>"></script>
  <script>
    function moveMain() {
      location.href = '<?= $appApiUrl; ?>/cart/main.php';
    }
  </script>
</body>

</html>
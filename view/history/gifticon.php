<? include_once $_SERVER['DOCUMENT_ROOT'] . "/view/header.php"; ?>
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
				<div class="link point">
					<div class="icon"></div>
					<p>포인트</p>
					<a href="javascript:moveHistory('point')"></a>
				</div>
				<div class="link candy">
					<div class="icon"></div>
					<p>막대사탕</p>
					<a href="javascript:moveHistory('stick')"></a>
				</div>
				<div class="link gift on">
					<div class="icon"></div>
					<p>기프티콘</p>
					<a href="javascript:moveHistory('gifticon')"></a>
				</div>
			</div>
			<div class="line line1">
				<a href="/view/notice/gifticon.php">[필독] 꼭 읽어보세요! (기프티콘)<span class="ico-arrow type1 right"></span></a>
			</div>
			<!-- 기프티콘 당첨내역 -->
			<div class="cont cont3">
				<div class="line line2">
					<p>기프티콘 당첨내역</p>
					<div id="select-btn3" class="select-btn type2"
						onclick="selectListOn('#select-btn3', '#select-wrap', '#select-list3')">
						<p class="value"><?= $months[0]; ?></p>
						<div class="ico-arrow type2 bottom"></div>
					</div>
				</div>
				<div class="tab-box-wrap">
					<div class="tab-box">
						<div class="tab tab1 on"><a href="javascript:checkFilter('N')">사용가능</a></div>
						<div class="tab tab2"><a href="javascript:checkFilter('Y')">사용완료/만료</a></div>
					</div>
				</div>
				<!-- 리스트 있을 경우 -->
				<div class="list-wrap type6 type6-1"></div>
				<!-- 리스트 없을 경우 -->
				<div class="list-none-box">
					<p><span class="ico-exclamation"></span>당첨내역이 없습니다.</p>
				</div>
			</div>
		</div>
		<!-- 셀렉트 박스 -->
		<div id="select-wrap">
			<!-- 기프티콘 상세내역 셀렉트 -->
			<div id="select-list3" class="select-list">
				<div class="select-head">
					<p>조회 월 선택</p>
					<button class="ico-close type1" type="button"
						onclick="selectListClose('#select-btn3', '#select-wrap', '#select-list3')">닫기</button>
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
		getGifticonList('N', "<?= $months[0]; ?>");
	});

	let checkStatus = 'N';
	let checkDate = '<?= $months[0] ?>';

	function checkFilter(status, date) {
		if (status !== '') checkStatus = status;
		if (date) checkDate = date;

		getGifticonList(checkStatus, checkDate);
	}

	// 기프티콘 리스트 조회
	function getGifticonList(status, date) {
		try {
			const userId = "<?= $_SESSION['check_userId']; ?>";
			const merchantId = "coupang";
			const affliateId = "<?= $_SESSION["check_affliateId"]; ?>";
			const awardYm = convertDate(date);
			// 사용가능 n, 완료/만료 y -> 응답에서 만료 v
			const giftYn = status;


			// AJAX 요청 데이터 설정
			const requestData = {
				userId,
				affliateId,
				merchantId,
				giftYn,
				awardYm
			};

			// AJAX 요청 수행
			$.ajax({
				type: 'POST',
				url: 'https://app.shoplus.io/api/view/gifticonList',
				contentType: 'application/json',
				data: JSON.stringify(requestData),
				success: function(result) {


					selectListClose('#select-btn3', '#select-wrap', '#select-list3');
					renderGifticonList(result);
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
	function renderGifticonList(data) {
		$('.list-none-box').css('display', 'none');
		$('.list-wrap.type6').empty();

		const datas = data.datas;
		if (!datas || datas.length === 0) {
			$('.list-none-box').css('display', 'block');
			return;
		}

		let list = '';
		datas.forEach(item => {
			const itemStr = base64Encode(JSON.stringify(item));


			list += `
								<div class="list list1">
										<div class="img-box" style="background-image: url(${item.productImageS});"></div>
										<div class="text-box">
												<div class="title-box">
														<div class="logo-box">
																<div class="logo" style="background-image: url(${item.brandIcon});">
																</div>
																<p class="logo-title">${item.brandName}</p>
														</div>
														<p class="title">${item.productName}</p>
												</div>
												<div class="info-box">
														<p class="date date1">당첨일자 (${formatDate(item.awardDay)})</p>
														<p class="date date2">유효기간 (${formatDate(item.validDay)})</p>
												</div>
										</div>
										<a href="javascript:postToUrl('${itemStr}')"></a>
								</div>
							`;

		});
		document.querySelector('.list-wrap.type6').classList.remove('type6-1', 'type6-3');
		document.querySelector('.list-wrap.type6').classList.add(checkStatus === 'N' ? 'type6-1' : 'type6-3');
		$('.list-wrap.type6').append(list);
	}

	function postToUrl(item) {
		// 동적으로 form 생성
		const form = document.createElement('form');
		form.action = '/view/history/gifticon-detail.php'; // 제출할 URL
		form.method = 'POST'; // POST 방식

		// hidden input 생성 및 데이터 설정
		const input = document.createElement('input');
		input.type = 'hidden';
		input.name = 'object';
		input.value = item;

		// form에 input 추가
		form.appendChild(input);

		// form을 body에 추가
		document.body.appendChild(form);

		// form 제출
		form.submit();
	}
</script>
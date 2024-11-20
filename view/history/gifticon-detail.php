<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<?
$object = $_REQUEST['object'] ?? null; // null로 기본값 설정
if (!$object) {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	exit;
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<title>기프티콘 상세정보</title>
	<!-- style -->

	<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js?version=<?= $cacheVersion; ?>"></script>
	<style>
		.gifticon-notice-list li {
			list-style: none;
			padding-left: 0 !important;
		}

		.gifticon-notice-list li::before {
			content: none !important;
		}
	</style>
</head>

<body>
	<div class="wrap">
		<!-- header -->
		<header>
			<h1>기프티콘 상세정보</h1>
			<div class="btn-list">
				<a href="javascript:history.back()" class="ico-arrow type1 left">이전</a>
			</div>
		</header>
		<!-- main -->
		<!-- hana 클래스 추가 시 시그니처 컬러 변경 -->
		<div class="sub sub-5-3-2">
			<div class="box box1">
				<div class="giftcon-info-wrap" style="margin-bottom: 20px;">
					<div class="goods-info-box">
						<div class="goods-img"></div>
						<div class="logo-box">
							<div class="logo"></div>
							<p class="logo-title"></p>
						</div>
						<p class="title"></p>
					</div>
					<div class="date-info-box">
						<div class="date-box date-box1">
							<p class="text">당첨일자</p>
							<p class="date"></p>
						</div>
						<div class="date-box date-box2">
							<p class="text">유효기간</p>
							<p class="date"></p>
						</div>
						<p class="text">*교환이나 환불, 유효기간은 연장이 불가합니다.</p>
					</div>
					<div class="barcode-box">
						<canvas id="barcode" class="barcode"></canvas>
					</div>
					<p class="title">유의사항</p>
					<div class="gray-box">
						<ul id="notice" class="gifticon-notice-list"></ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="../js/common.js?version=<?= $cacheVersion; ?>"></script>
<script src="../js/page.js?version=<?= $cacheVersion; ?>"></script>

</html>
<script>
	const object = decodeFromBase64(`<?= $object ?>`);
	$(function() {
		renderGifticonDetail(object);
	});


	function renderGifticonDetail(object) {
		try {
			if (!object) {
				alert('존재하지않는 기프티콘입니다.');
				history.back();
				return
			}

			// 넘겨받은 기프티콘 데이터
			const item = object;
			// 기프티콘 상태
			$('.giftcon-info-wrap').addClass(item.giftYn === 'N' ? '' : 'type3');

			// 기프티콘 브랜드, 상품 정보
			$('.goods-info-box .goods-img').css('background-image', `url(${item.productImageS})`);
			$('.goods-info-box .logo-box .logo').css('background-image', `url(${item.brandIcon})`);
			$('.goods-info-box .logo-box .logo-title').text(`${item.brandName}`);
			$('.goods-info-box .title').text(`${item.productName}`);

			// 기프티콘 당첨일자, 유효기간
			$('.date-box1 .date').append(formatDate(item.awardDay));
			$('.date-box2 .date').append(formatDate(item.validDay));

			// 기프티콘 바코드
			JsBarcode("#barcode", `${item.pinNo}`, {
				format: "CODE128", // 바코드 형식
				lineColor: "#000", // 바코드 색상
				width: 2, // 막대 너비
				height: 111, // 바코드 높이
				displayValue: true // 바코드 값 표시 여부
			});

			if (item.giftYn === 'Y' || item.giftYn === 'V') {
				const status = `<p class="state ${item.giftYn === 'Y' ? 'blue' : 'red'}">${item.giftYn === 'Y' ? '사용완료' : '사용만료'}</p>`;
				$('.barcode-box').append(status);
			}

			// 유의사항
			const notice = item.content && item.content.includes('\n') ? item.content.split('\n') : [item.content];
			if (!notice || notice.length === 0 || !notice[0]) {
				$('#notice').css('display', 'none');
			} else {
				let noticeList = '';
				notice.forEach(item => {
					noticeList += `<li>${item}</li>`;
				});
				$('#notice').append(noticeList);
			}
		} catch (error) {
			alert(error);
			history.back();
		}
	}

	function escapeJsonString(jsonString) {
		// 줄 바꿈 및 기타 제어 문자를 이스케이프 처리
		return jsonString.replace(/[\r\n]+/g, '\\n'); // 줄 바꿈을 \\n으로 대체
	}
</script>
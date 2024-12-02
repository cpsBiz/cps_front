<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<?
$tab = $_REQUEST['tab'];

$page = (int)(isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
$per = 50;
$total_page = 0;
$total = 0;
?>
<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=Edge, chrome=1" />
	<meta name="description" content="MOBON" />
	<meta name="keywords" content="MOBON" />
	<meta name="author" content="인라이플" />
	<title>통합카트</title>
	<link type="image/ico" rel="shortcut icon" href="/image/favicon/app.png">
	<script type="text/javascript" src="/js/lib/jquery-2.2.2.min.js"></script>
	<script type="text/javascript" src="/js/lib/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="/js/lib/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/js/lib/moment.min.js"></script>
	<script type="text/javascript" src="/js/lib/daterangepicker_popup.js"></script>
	<script type="text/javascript" src="/js/ui.js"></script>
	<link type="text/css" rel="stylesheet" href="/css/lib/daterangepicker_popup.css" />
	<link type="text/css" rel="stylesheet" href="/css/common.css">
</head>

<body>
	<!-- 캠페인관리 > 캠페인 카테고리 -->
	<!-- ic_campaignCategory 클래스는 해당 페이지를 구분하는 id 값으로 사용하는 클래스입니다. 
             다른 페이지에는 사용을 지양해주시기 바랍니다.(추후 유지보수때 css 수정 어려움) -->
	<div class="wrap ic_campaignCategory">
		<? include_once $_SERVER['DOCUMENT_ROOT'] . '/page/header.php'; ?>
		<? include_once $_SERVER['DOCUMENT_ROOT'] . '/page/nav.php'; ?>
		<section class="container">
			<div class="title">
				<p>캠페인 카테고리</p>
				<div class="location">
					<span>캠페인 관리</span><span>캠페인 카테고리</span>
				</div>
			</div>
			<div class="content">
				<section class="sec_list">
					<div class="tab">
						<ul>
							<!-- on 클래스로 탭 제어 -->
							<li class="<? if ($tab == '' || $tab == 'category') echo 'on' ?>"
								onclick="location.href='/page/campaign/category.php?tab=category'">카테고리 목록 관리</li>
							<li class="<? if ($tab == 'campaign') echo 'on' ?>" onclick="location.href='/page/campaign/category.php?tab=campaign'">카테고리 캠페인 관리</li>
						</ul>
					</div>
					<div class="tabView">
						<!-- tab 1 > 카테고리 목록 관리 -->
						<!--  show 클래스로 탭 제어 -->
						<? if ($tab == '' || $tab == 'category') {
							include_once $_SERVER['DOCUMENT_ROOT'] . "/page/campaign/category/tab-category.php";
						} ?>
						<!-- tab 2 > 카테고리 캠페인 관리  -->
						<? if ($tab == 'campaign') {
							$paramCategory = !$_REQUEST['category'] ? 'C0001' : $_REQUEST['category'];
							$paramAffliate = !$_REQUEST['affliate'] ? 'donsee' : $_REQUEST['affliate'];
							include_once $_SERVER['DOCUMENT_ROOT'] . "/page/campaign/category/tab-campaign.php";
						} ?>
					</div>
				</section>
			</div>
			<!--// content end -->
		</section>
		<!--// container end -->
	</div>
	<div class="wrap modalView">
		<div class="modal"></div>
	</div>
</body>

</html>
<script>
	function pageLink(pageNumber) {
		// 페이지 번호에 따라 요청을 보내는 방법 구현
		// 예를 들어, 페이지를 새로 고치거나 AJAX 요청을 통해 페이지를 로드할 수 있습니다.
		window.location.href = "?tab=<?= $tab; ?>&page=" + pageNumber; // 필요한 파라미터 추가
	}
</script>
<?
if ($tab == '' || $tab == 'category') {
	include_once $_SERVER['DOCUMENT_ROOT'] . "/page/campaign/category/category-add.php";
	include_once $_SERVER['DOCUMENT_ROOT'] . "/page/campaign/category/category-modify.php";
	include_once $_SERVER['DOCUMENT_ROOT'] . "/page/campaign/category/category-delete.php";
}

if ($tab == 'campaign') {
	include_once $_SERVER['DOCUMENT_ROOT'] . "/page/campaign/category/category-campaign-modify.php";
	include_once $_SERVER['DOCUMENT_ROOT'] . "/page/campaign/category/category-campaign-excel.php";
}
?>
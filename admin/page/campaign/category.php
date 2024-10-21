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
	<link type="image/ico" rel="shortcut icon" href="/admin/image/favicon/favicon.ico">
	<script type="text/javascript" src="/admin/js/lib/jquery-2.2.2.min.js"></script>
	<script type="text/javascript" src="/admin/js/lib/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="/admin/js/lib/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/admin/js/lib/moment.min.js"></script>
	<script type="text/javascript" src="/admin/js/lib/daterangepicker_popup.js"></script>
	<script type="text/javascript" src="/admin/js/ui.js"></script>
	<link type="text/css" rel="stylesheet" href="/admin/css/lib/daterangepicker_popup.css" />
	<link type="text/css" rel="stylesheet" href="/admin/css/common.css">
</head>

<body>
	<!-- 캠페인관리 > 캠페인 카테고리 -->
	<!-- ic_campaignCategory 클래스는 해당 페이지를 구분하는 id 값으로 사용하는 클래스입니다. 
             다른 페이지에는 사용을 지양해주시기 바랍니다.(추후 유지보수때 css 수정 어려움) -->
	<div class="wrap ic_campaignCategory">
		<? include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/page/header.php'; ?>
		<? include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/page/nav.php'; ?>
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
								onclick="location.href='/admin/page/campaign/category.php?tab=category'">카테고리 목록 관리</li>
							<li class="<? if ($tab == 'campaign') echo 'on' ?>" onclick="location.href='/admin/page/campaign/category.php?tab=campaign'">카테고리 캠페인 관리</li>
							<li class="<? if ($tab == 'pop') echo 'on' ?>" onclick="location.href='/admin/page/campaign/category.php?tab=pop'">인기 캠페인 관리</li>
						</ul>
					</div>
					<div class="tabView">
						<!-- tab 1 > 카테고리 목록 관리 -->
						<!--  show 클래스로 탭 제어 -->
						<? if ($tab == '' || $tab == 'category') { ?>
							<div class="tabViewList show">
								<div class="tableHeader">
									<div class="tableTitle">
										<p>카테고리 목록 관리</p>
									</div>
									<div class="buttonBox">
										<button type="button" class="register" onclick="addCategory();">추가등록</button>
										<button type="button" class="rankSave" onclick="modifyCategoryRank();">순위 변경사항 저장</button>
									</div>
								</div>
								<!--// 내용이 없을 때 tableWrap & tableAreaDataNone 함께 사용 -->
								<!-- <div class="tableArea tableAreaDataNone"> -->
								<div id="categoryList" class="tableArea">
									<!-- table 스크롤 생기게 하고 싶을 때 tableBox 에 높이값(max-height) 추가-->
									<div class="tableBox">
										<table>
											<thead>
												<tr>
													<th>순위</th>
													<th>카테고리</th>
													<th>캠페인수</th>
													<th>관리</th>
													<th>순위변경<span class="iBox">
															<span class="iMarkHover">말풍선입니다.</span></span></th>
												</tr>
											</thead>
											<tbody>
												<?
												$sql = "
																SELECT SQL_CALC_FOUND_ROWS
																	A.CATEGORY,
																	A.CATEGORY_NAME,
																	A.CATEGORY_RANK,
																	COUNT(B.CAMPAIGN_NUM) AS CAMPAIGN_CNT
																FROM CPS_CATEGORY A
																LEFT JOIN CPS_CAMPAIGN B ON B.CATEGORY = A.CATEGORY 
																GROUP BY A.CATEGORY
																ORDER BY CAST(CATEGORY_RANK AS UNSIGNED) ASC
																LIMIT ?, ?
																";

												$page_int = ($page - 1) * $per;

												$stmt = mysqli_stmt_init($con);
												if (mysqli_stmt_prepare($stmt, $sql)) {
													mysqli_stmt_bind_param($stmt, 'ii', $page_int, $per);
													mysqli_stmt_execute($stmt);
													$result = mysqli_stmt_get_result($stmt);

													//페이징
													$query = "SELECT FOUND_ROWS()";
													$stmt = mysqli_prepare($con, $query);
													mysqli_stmt_execute($stmt);
													mysqli_stmt_bind_result($stmt, $num);
													while (mysqli_stmt_fetch($stmt)) {
														$total = $num;
													}

													if ($total % $per == 0) {
														$total_page = (int)($total / $per);
													} else {
														$total_page = (int)($total / $per) + 1;
													}


													// 결과를 처리
													$i = $page_int + 1;
													while ($row = mysqli_fetch_assoc($result)) {
														$categoryRank = $row['CATEGORY_RANK'];
														$categoryName = $row['CATEGORY_NAME'];
														$campaignCnt = $row['CAMPAIGN_CNT'];
														$category = $row['CATEGORY'];
												?>
														<tr id="categoryList<?= $i; ?>">
															<td><?= $i; ?></td>
															<td><?= $categoryName; ?></td>
															<td><?= $campaignCnt; ?></td>
															<td>
																<div class="buttonBox">
																	<button type="button" class="modify" title="수정" onclick="modifyCategory('<?= $category; ?>', '<?= $categoryName; ?>', <?= $categoryRank; ?>)">수정</button>
																	<button type="button" class="delete" title="삭제" onclick="deleteCategory('<?= $category; ?>')">삭제</button>
																</div>
															</td>
															<td>
																<div class="buttonBox"><button type="button" class="listChange">순위변경</button></div>
															</td>
														</tr>
												<?
														$i++;
													}

													mysqli_stmt_close($stmt);
												}
												?>
											</tbody>
										</table>
									</div>
									<? if ($total == 0) { ?>
										<div class="categoryList tableDataNone">
											<div>
												<p>내용이 없습니다. </p>
											</div>
										</div>
										<script>
											$('#categoryList .tableBox').hide();
											$('.categoryList.tableDataNone').show();
										</script>
									<? } else { ?>
										<div class="paging">
											<ul>
												<!-- 이전 페이지 -->
												<? if ($page > 1) { ?>
													<li class="prev"><a href="javascript:pageLink(<?= $page - 1; ?>);"></a></li>
												<? } else { ?>
													<li class="prev disabled"><a></a></li>
												<? } ?>

												<!-- 페이지리스트 -->
												<? for ($i = 1; $i <= $total_page; $i++) { ?>
													<? if ($i == $page) { ?>
														<li class="on"><a href="javascript:pageLink(<?= $i; ?>);"><?= $i; ?></a></li>
													<? } else { ?>
														<li><a href="javascript:pageLink(<?= $i; ?>);"><?= $i; ?></a></li>
												<? }
												} ?>

												<!-- 다음페이지 -->
												<? if ($page < $total_page) { ?>
													<li class="next"><a href="javascript:pageLink(<?= $page + 1; ?>);"></a></li>
												<? } else { ?>
													<li class="next disabled"><a></a></li>
												<? } ?>
											</ul>
										</div>
									<? } ?>
								</div>
							</div>
						<? } ?>
						<!-- tab 2 > 카테고리 캠페인 관리  -->
						<? if ($tab == 'campaign') {

							$paramCategory = $_REQUEST['category'];
						?>
							<div class="tabViewList show">
								<div class="tableHeader">
									<div class="tableTitle">
										<p>카테고리 캠페인 관리</p>
									</div>
									<div class="selectBox">
										<select id="selectCategory" class="category" onchange="selectCategory()">
											<?
											$sql = "
															SELECT 
																CATEGORY, CATEGORY_NAME 
															FROM CPS_CATEGORY 
															ORDER BY CATEGORY_RANK ASC
															";
											$stmt = mysqli_stmt_init($con);
											if (mysqli_stmt_prepare($stmt, $sql)) {
												mysqli_stmt_execute($stmt);
												$result = mysqli_stmt_get_result($stmt);
												while ($row = mysqli_fetch_assoc($result)) {
											?>
													<option value="<?= $row['CATEGORY']; ?>" <? if ($paramCategory == $row['CATEGORY']) echo 'selected'; ?>><?= $row['CATEGORY_NAME']; ?></option>
											<? }
											} ?>
										</select>
										<select name="" id="">
											<option value="">50개씩 보기</option>
										</select>
									</div>
									<div class="buttonBox">
										<button type="button" class="change">선택변경</button>
										<button type="button" class="excelUpload">엑셀 업로드</button>
										<button type="button" class="save">변경사항 저장</button>
									</div>
								</div>
								<!--// 내용이 없을 때 tableWrap & tableAreaDataNone 함께 사용 -->
								<!-- <div class="tableArea tableAreaDataNone"> -->
								<div id="campaignList" class="tableArea">
									<!-- table 스크롤 생기게 하고 싶을 때 tableBox 에 높이값(max-height) 추가-->
									<div class="tableBox">
										<table>
											<thead>
												<tr>
													<th>순서</th>
													<th>캠페인명</th>
													<th>카테고리 변경</th>
													<th>
														<div class="checkBox">
															<input type="checkbox" name="chk2" id="chk2_all">
															<label for="chk2_all">선택</label>
														</div>
													</th>
													<th>순위변경<span class="iBox">
															<span class="iMarkHover">말풍선입니다.</span></span>
													</th>
												</tr>
											</thead>
											<tbody>
												<?
												$sql = "
																SELECT 
																	C.CATEGORY_NAME,
																	A.CATEGORY,
																	A.CAMPAIGN_RANK,
																	B.CAMPAIGN_NAME
																FROM CPS_CAMPAIGN_RANK A
																JOIN CPS_CAMPAIGN B ON A.CAMPAIGN_NUM = B.CAMPAIGN_NUM
																JOIN CPS_CATEGORY C ON C.CATEGORY = A.CATEGORY 
																WHERE 
																	A.CATEGORY = ?
																GROUP BY A.CAMPAIGN_NUM
																ORDER BY CAMPAIGN_RANK ASC
																LIMIT ?, ?
																";

												$page_int = ($page - 1) * $per;

												$stmt = mysqli_stmt_init($con);
												if (mysqli_stmt_prepare($stmt, $sql)) {
													mysqli_stmt_bind_param($stmt, 'sii', $paramCategory, $page_int, $per);
													mysqli_stmt_execute($stmt);
													$result = mysqli_stmt_get_result($stmt);

													//페이징
													$query = "SELECT FOUND_ROWS()";
													$stmt = mysqli_prepare($con, $query);
													mysqli_stmt_execute($stmt);
													mysqli_stmt_bind_result($stmt, $num);
													while (mysqli_stmt_fetch($stmt)) {
														$total = $num;
													}

													if ($total % $per == 0) {
														$total_page = (int)($total / $per);
													} else {
														$total_page = (int)($total / $per) + 1;
													}


													// 결과를 처리
													$i = $page_int + 1;
													while ($row = mysqli_fetch_assoc($result)) {
														$campaignName = $row['CAMPAIGN_NAME'];

												?>
														<tr id="campaignList<?= $i; ?>">
															<td><?= $i; ?></td>
															<td><?= $campaignName; ?></td>
															<td>
																<div class="buttonBox">
																	<button type="button" class="categoryChange">카테고리 변경</button>
																</div>
															</td>
															<td>
																<div class="checkBox">
																	<input type="checkbox" name="chk2" id="chk2_1">
																	<label for="chk2_1"></label>
																</div>
															</td>
															<td>
																<div class="buttonBox"><button type="button"
																		class="listChange">순위변경</button></div>
															</td>
														</tr>

														<!-- <tr id="categoryList<?= $category; ?>">
															<td><?= $categoryRank; ?></td>
															<td><?= $categoryName; ?></td>
															<td><?= $campaignCnt; ?></td>
															<td>
																<div class="buttonBox">
																	<button type="button" class="modify" title="수정" onclick="modifyCategory('<?= $category; ?>', '<?= $categoryName; ?>', <?= $categoryRank; ?>)">수정</button>
																	<button type="button" class="delete" title="삭제" onclick="deleteCategory('<?= $category; ?>')">삭제</button>
																</div>
															</td>
															<td>
																<div class="buttonBox"><button type="button" class="listChange">순위변경</button></div>
															</td>
														</tr> -->
												<?
													}

													mysqli_stmt_close($stmt);
												}
												?>
											</tbody>
										</table>
									</div>
									<? if ($total == 0) { ?>
										<div class="campaignList tableDataNone">
											<div>
												<p>내용이 없습니다. </p>
											</div>
										</div>
										<script>
											$('#campaignList .tableBox').hide();
											$('.campaignList.tableDataNone').show();
										</script>
									<? } else { ?>
										<div class="paging">
											<ul>
												<!-- 이전 페이지 -->
												<? if ($page > 1) { ?>
													<li class="prev"><a href="javascript:pageLink(<?= $page - 1; ?>);"></a></li>
												<? } else { ?>
													<li class="prev disabled"><a></a></li>
												<? } ?>

												<!-- 페이지리스트 -->
												<? for ($i = 1; $i <= $total_page; $i++) { ?>
													<? if ($i == $page) { ?>
														<li class="on"><a href="javascript:pageLink(<?= $i; ?>);"><?= $i; ?></a></li>
													<? } else { ?>
														<li><a href="javascript:pageLink(<?= $i; ?>);"><?= $i; ?></a></li>
												<? }
												} ?>

												<!-- 다음페이지 -->
												<? if ($page < $total_page) { ?>
													<li class="next"><a href="javascript:pageLink(<?= $page + 1; ?>);"></a></li>
												<? } else { ?>
													<li class="next disabled"><a></a></li>
												<? } ?>
											</ul>
										</div>
									<? } ?>
								</div>
							</div>
							<script>
								function selectCategory() {
									const category = document.getElementById('selectCategory').value;

									const currentUrl = window.location.href;

									const url = new URL(currentUrl);

									url.searchParams.set('category', category);

									window.location.href = url.toString();
								}
							</script>
						<? } ?>
						<? if ($tab == 'pop') { ?>
							<!-- tab 3 > 인기 캠페인 관리  -->
							<div class="tabViewList show">
								<div class="tableHeader">
									<div class="tableTitle">
										<p>인기 캠페인 관리</p>
									</div>
									<div class="selectBox">
										<select name="" id="">
											<option value="">10개씩 보기</option>
										</select>
									</div>
									<div class="buttonBox">
										<button type="button" class="change">선택변경</button>
										<button type="button" class="excelUpload">엑셀 업로드</button>
										<button type="button" class="save">변경사항 저장</button>
									</div>
								</div>
								<!--// 내용이 없을 때 tableWrap & tableAreaDataNone 함께 사용 -->
								<!-- <div class="tableArea tableAreaDataNone"> -->
								<div class="tableArea">
									<!-- table 스크롤 생기게 하고 싶을 때 tableBox 에 높이값(max-height) 추가-->
									<div class="tableBox">
										<table>
											<thead>
												<tr>
													<th>순서</th>
													<th>캠페인명</th>
													<th>삭제</th>
													<th>
														<div class="checkBox">
															<input type="checkbox" name="chk3" id="chk3_all">
															<label for="chk3_all">선택</label>
														</div>
													</th>
													<th>순위변경<span class="iBox">
															<span class="iMarkHover">말풍선입니다.</span></span>
													</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td>쿠팡</td>
													<td>
														<div class="buttonBox">
															<button type="button" class="delete">삭제</button>
														</div>
													</td>
													<td>
														<div class="checkBox">
															<input type="checkbox" name="chk3" id="chk3_1">
															<label for="chk3_1"></label>
														</div>
													</td>
													<td>
														<div class="buttonBox"><button type="button"
																class="listChange">순위변경</button></div>
													</td>
												</tr>
												<tr>
													<td>2</td>
													<td>G마켓</td>
													<td>
														<div class="buttonBox">
															<button type="button" class="delete">삭제</button>
														</div>
													</td>
													<td>
														<div class="checkBox">
															<input type="checkbox" name="chk3" id="chk3_2">
															<label for="chk3_2"></label>
														</div>
													</td>
													<td>
														<div class="buttonBox"><button type="button"
																class="listChange">순위변경</button></div>
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="tableDataNone">
										<div>
											<p>내용이 없습니다. </p>
										</div>
									</div>
									<div class="paging">
										<ul>
											<!-- <li class="prev-list"><a href="javascript:pageLink(0);"></a></li> -->
											<li class="prev"><a href="javascript:pageLink(0);"></a></li>
											<li class="on"><a href="javascript:pageLink(1);">1</a></li>
											<li><a href="javascript:pageLink(2);">2</a></li>
											<li><a href="javascript:pageLink(3);">3</a></li>
											<li><a href="javascript:pageLink(4);">4</a></li>
											<li><a href="javascript:pageLink(5);">5</a></li>
											<li><a href="javascript:pageLink(6);">6</a></li>
											<li><a href="javascript:pageLink(7);">7</a></li>
											<li><a href="javascript:pageLink(8);">8</a></li>
											<li><a href="javascript:pageLink(9);">9</a></li>
											<li><a href="javascript:pageLink(10);">10</a></li>
											<li class="next"><a href="javascript:pageLink(10+1);"></a></li>
											<!-- <li class="next-list"><a href="javascript:pageLink(10+1);"></a></li> -->
										</ul>
									</div>
								</div>
							</div>
						<? } ?>
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
	include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/page/campaign/category-add.php";
	include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/page/campaign/category-modify.php";
	include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/page/campaign/category-delete.php";
}

if ($tab == 'campaign') {
}
?>
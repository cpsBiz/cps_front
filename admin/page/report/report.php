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
	<script type="text/javascript" src="./report.js"></script>
	<link type="text/css" rel="stylesheet" href="/css/lib/daterangepicker_popup.css" />
	<link type="text/css" rel="stylesheet" href="/css/common.css">
</head>

<body>
	<div class="wrap ic_reportPerformance">
		<? include_once $_SERVER['DOCUMENT_ROOT'] . '/page/header.php'; ?>
		<? include_once $_SERVER['DOCUMENT_ROOT'] . '/page/nav.php'; ?>
		<section class="container">
			<div class="title">
				<p>실적리포트</p>
				<div class="location">
					<span>리포트</span><span>실적리포트</span>
				</div>
			</div>
			<div class="content">
				<section class="sec_list">
					<div class="optionBox">
						<div>
							<div class="radioBox">
								<p>일반</p>
								<input type="radio" name="dayType" id="dayType1" checked>
								<label for="dayType1">요약</label>
								<!-- <input type="radio" name="dayType" id="dayType2">
                                <label for="dayType2">상세</label> -->
							</div>
							<div class="radioBox">
								<p>상세보기</p>
								<input type="radio" name="searchType" id="searchType1" value="DAY" checked>
								<label for="searchType1">일별</label>
								<input type="radio" name="searchType" id="searchType2" value="MONTH">
								<label for="searchType2">월별</label>
								<input type="radio" name="searchType" id="searchType3" value="MERCHANT">
								<label for="searchType3">광고주</label>
								<input type="radio" name="searchType" id="searchType4" value="CAMPAIGN">
								<label for="searchType4">캠페인</label>
								<input type="radio" name="searchType" id="searchType5" value="AFFLIATE">
								<label for="searchType5">매체</label>
								<input type="radio" name="searchType" id="searchType6" value="SITE">
								<label for="searchType6">사이트</label>
								<input type="radio" name="searchType" id="searchType7" value="MEMBERAGC">
								<label for="searchType7">광고주대행사</label>
								<input type="radio" name="searchType" id="searchType8" value="MEMBERAFF">
								<label for="searchType8">매체대행사</label>
							</div>
						</div>
						<div>
							<div class="radioBox">
								<p>영역</p>
								<input type="radio" name="os" id="os1" value="" checked>
								<label for="os1">전체</label>
								<input type="radio" name="os" id="os2" value="PC">
								<label for="os2">PC</label>
								<input type="radio" name="os" id="os3" value="MOBILE">
								<label for="os3">모바일</label>
							</div>
							<div class="radioBox">
								<p>상태</p>
								<input type="radio" name="cancelYn" id="cancelYn1" value="" checked>
								<label for="cancelYn1">전체</label>
								<input type="radio" name="cancelYn" id="cancelYn2" value="N">
								<label for="cancelYn2">취소반영분</label>
								<input type="radio" name="cancelYn" id="cancelYn3" value="Y">
								<label for="cancelYn3">취소분</label>
							</div>
						</div>
						<div>
							<div class="calendarBox">
								<div class="calendar">
									<input type="text" id="dateInput" name="dateInput" value="">
								</div>
							</div>
							<div class="radioBox">
								<p>선택</p>
								<input type="radio" name="keywordType" id="keywordType1" value="" checked>
								<label for="keywordType1">전체</label>
								<input type="radio" name="keywordType" id="keywordType2" value="MERCHANT">
								<label for="keywordType2">광고주</label>
								<input type="radio" name="keywordType" id="keywordType3" value="CAMPAIGN">
								<label for="keywordType3">캠페인</label>
								<input type="radio" name="keywordType" id="keywordType4" value="AFFLIATE">
								<label for="keywordType4">매체</label>
								<input type="radio" name="keywordType" id="keywordType5" value="SITE">
								<label for="keywordType5">사이트</label>
							</div>
							<div class="searchBox">
								<input id="keyword" type="text" placeholder="ID/명/법인명">
								<button type="button" class="search" onclick="getReport()">검색</button>
							</div>
						</div>
					</div>
					<div class="tableHeader">
						<div class="tableTitle">
							<p>요약 리포트<span>일별</span></p>
						</div>
						<div class="selectBox">
							<select id="size">
								<option value="10">10개씩 보기</option>
								<option value="20">20개씩 보기</option>
								<option value="40" selected>40개씩 보기</option>
								<option value="60">60개씩 보기</option>
								<option value="100">100개씩 보기</option>
							</select>
						</div>
					</div>
					<div class="tableArea">
						<!-- 상세리포트 테이블과 요약리포트 테이블은 tableBox에 selectDay, selectDetail 클래스로 구분함  >> 퍼블확인을 위해 tableBox 두개 추가한 부분이므로 개발할때는 한개만 사용하고 클래스로 구분하면 됩니다. -->
						<!-- 요약리포트 selectDay -->
						<div class="tableBox selectDay">
							<table>
								<thead id="reportHead">
									<tr>
										<th id="searchTypeTitle" class="sortDown">날짜</th>
										<th class="sort">노출수</th>
										<th class="sort">클릭수</th>
										<th class="sort">건수</th>
										<th class="sort">전환율</th>
										<th class="sort">구매액</th>
										<th class="sort">커미션 매출</th>
										<th class="sort">커미션 이익</th>
										<th>상세보기</th>
									</tr>
								</thead>
								<tbody id="reportData">

								</tbody>
							</table>
						</div>
						<!-- 상세리포트 selectDetail -->
						<!-- <div class="tableBox selectDetail">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="sort">구매날짜</th>
                                        <th class="sortUp">머천트</th>
                                        <th class="sortDown">머천트ID</th>
                                        <th class="sort">주문코드</th>
                                        <th class="sort">상품코드</th>
                                        <th class="sort">상품명</th>
                                        <th class="sort">건수</th>
                                        <th class="sort">가격</th>
                                        <th class="sort">커미션 매출</th>
                                        <th class="sort">커미션 이익</th>
                                        <th class="sort">커미션율</th>
                                        <th class="sort">취소</th>
                                        <th class="sort">취소사유</th>
                                        <th class="sort">카테고리 코드</th>
                                        <th class="sort">매체ID</th>
                                        <th class="sort">배너ID</th>
                                        <th class="sort">UID</th>
                                    </tr>
                                    <tr>
                                        <th colspan="6">합계</th>
                                        <th>123,888,999</th>
                                        <th>456,000</th>
                                        <th>123,888,999원</th>
                                        <th>123,888,999원</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2024.09.19</td>
                                        <td>OOOOOOO</td>
                                        <td>abcdefffere123</td>
                                        <td>202410102223</td>
                                        <td>0202410102223</td>
                                        <td>상품명 길면 줄바꿈</td>
                                        <td>123,456,890</td>
                                        <td>3,456,890</td>
                                        <td>3,456,890</td>
                                        <td>3,456,890원</td>
                                        <td>33%</td>
                                        <td>Y</td>
                                        <td>구매 취소</td>
                                        <td>202410102223</td>
                                        <td>abcdefffere123</td>
                                        <td>abcdefffere123</td>
                                        <td>abcdefffere123</td>
                                    </tr>
                                    <tr>
                                        <td class="sat">2024.09.19</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="sat">2024.09.19</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> -->
						<div class="tableDataNone">
							<div>
								<p>내용이 없습니다. </p>
							</div>
						</div>
						<div class="paging">
							<ul></ul>
						</div>
					</div>
				</section>
			</div>
			<!--// content end -->
		</section>
		<!--// container end -->
	</div>
</body>

</html>
<script>
	$(function() {
		getReport();
	})

	// 현재 페이지 초기화 변수
	let page = 0;

	// 모달 페이지 초기화 변수
	let modalPage = 0;

	// 페이지이동시 정렬 유지 변수 
	let checkOrderByData = {
		orderBy: '',
		orderByName: ''
	};
	let checkOrderByDataModal = {
		orderBy: '',
		orderByName: ''
	};

	function getReport(orderByData = {
		orderBy: 'DESC',
		orderByName: ''
	}, detail = false, detailKeyword = '', btn = '') {
		try {
			// 상세보기 선택에서 월별은 제외한 나머지는 DAY
			let dayType = document.querySelector('input[name="searchType"]:checked').value === 'MONTH' ? 'MONTH' : 'DAY';

			// 월별 YYYYMM, 일별 YYYYMMDD
			const regFull = getRegDates(document.getElementById('dateInput').value, dayType);
			const regStart = regFull[0];
			const regEnd = regFull[1];

			// 상세보기 선택 값
			let searchType = document.querySelector('input[name="searchType"]:checked').value;

			// 영역 선택 값
			const os = document.querySelector('input[name="os"]:checked').value;

			// 상태 선택 값, 취소분만 취소완료
			const cancelYn = document.querySelector('input[name="cancelYn"]:checked').value;

			// 선택 영역 선택 값
			let keywordType = document.querySelector('input[name="keywordType"]:checked').value;

			// ID/명/법인명 입력 값
			let keyword = document.getElementById('keyword').value;

			// 로그인 아이디 타입
			const type = '<?= $_SESSION['admin_login_type']; ?>';

			// 로그인한 아이디
			const searchId = '<?= $_SESSION['admin_login_id']; ?>';

			// 한 페이지에서 몇개의 데이터를 보여줄건지
			const size = parseInt(document.getElementById('size').value);

			// 필수 값 유효성 검사
			if (!searchType || !dayType || !regStart || !regEnd) {
				throw new Error('필수값이 누락되었습니다.');
			}

			// 상세보기일때 데이터 변경
			if (detail && detailKeyword) {
				if (searchType === 'DAY' || searchType === 'MONTH') {
					dayType = 'EQ' + searchType;
				} else {
					keywordType = 'EQ' + searchType;
				}

				if (btn === 'SITE' || btn === 'CAMPAIGN' || btn === 'DETAIL') {
					searchType = btn;
				}

				keyword = detailKeyword;
			}

			// 정렬 값

			const orderBy = orderByData.orderBy;
			checkOrderByData.orderBy = orderBy;
			let orderByName = orderByData.orderByName;
			if (!orderByName && searchType === 'DAY') {
				orderByName = 'regDay';
			} else if (!orderByName && searchType === 'MONTH') {
				orderByName = 'regYm';
			} else if (orderByName) {
				orderByName = orderByData.orderByName;
			} else {
				switch (searchType) {
					case 'MERCHANT':
						orderByName = 'memberName';
						break;
					case 'CAMPAIGN':
						orderByName = 'campaignName';
						break;
					case "AFFLIATE":
						orderByName = "affliateName";
						break;
					case "SITE":
						orderByName = "site";
						break;
					case "MEMBERAGC":
						orderByName = "agencyName";
						break;
					case "MEMBERAFF":
						orderByName = "agencyName";
						break;
				}
			}
			checkOrderByData.orderByName = orderByName;

			// AJAX 요청 데이터 설정
			const requestData = {
				dayType,
				regStart,
				regEnd,
				searchType,
				os,
				cancelYn,
				keywordType,
				keyword,
				type,
				searchId,
				page,
				size,
				orderBy,
				orderByName
			};

			// AJAX 요청 수행
			$.ajax({
				type: 'POST',
				url: 'https://admin.shoplus.io/api/admin/summaryCount',
				contentType: 'application/json',
				data: JSON.stringify(requestData),
				success: function(result) {
					if (detail && detailKeyword) {
						document.getElementById('detailBtnDayType').value = dayType;
						document.getElementById('detailBtnKeywordType').value = keywordType;
						document.getElementById('detailBtnsearchType').value = searchType;
						document.getElementById('detailBtnKeyword').value = keyword;

						modalHandleSuccessResponse(result, size, modalPage, searchType, btn)
						return;
					}
					handleSuccessResponse(result, size, page);
				},
				error: function(request, status, error) {
					console.error(`Error: ${error}`);
				}
			});
		} catch (error) {
			alert(error.message);
		}
	}

	// API 응답 처리 및 데이터 렌더링
	function handleSuccessResponse(data, size, page) {
		// 상세보기 선택 값 업데이트
		const checkedRadio = document.querySelector('input[name="searchType"]:checked');
		const tableTitle = document.querySelector('.tableTitle span');
		tableTitle.textContent = document.querySelector(`label[for="${checkedRadio.id}"]`).innerHTML;

		// 데이터가 없는 경우 UI 처리
		const tableBoxes = document.querySelectorAll('.tableBox');
		const paging = document.querySelector('.paging');
		const tableDataNone = document.querySelector('.tableDataNone');

		if (data.totalCount === 0) {
			hideElements([...tableBoxes, paging]);
			tableDataNone.style.display = 'block';
			return;
		}

		// 데이터가 있는 경우 UI 처리
		showElements([...tableBoxes, paging]);
		tableDataNone.style.display = 'none';

		// 데이터 렌더링 및 페이지네이션 설정
		renderData(data);
		renderPagination(data.totalCount, size, page);
	}

	function renderData(data) {
		// 첫번째 행 키워드 타이틀 설정
		setTitle();

		// 합계 데이터 렌더링
		renderSumRow(data);

		// 데이터 테이블 렌더링
		renderTableRows(data.datas);
	}

	// 첫번째 행 키워드 타이틀 설정 함수
	function setTitle(modal = false, modalReportTitle) {
		let title = '';
		const searchType = getSearchTypeValue();

		if (searchType === 'DAY') {
			title = '일별'
		} else if (searchType === 'MONTH') {
			title = '월별';
		} else {
			const checkedRadio = document.querySelector('input[name="searchType"]:checked');
			title = document.querySelector(`label[for="${checkedRadio.id}"]`).innerHTML;
		}
		document.getElementById(!modal ? 'searchTypeTitle' : 'modal-searchTypeTitle').innerHTML = !modal ? title : modalReportTitle;
	}

	// 합계 데이터 행 렌더링 함수
	function renderSumRow(data, modal = false) {
		const sumRow = document.createElement('tr');
		sumRow.appendChild(createCell('th', '합계'));
		sumRow.appendChild(createCell('th', commaLocale(data.cnt)));
		sumRow.appendChild(createCell('th', commaLocale(data.clickCnt)));
		sumRow.appendChild(createCell('th', commaLocale(data.rewardCnt)));
		let rewardRate;
		if (data.clickCnt === 0 || data.rewardCnt === 0) {
			rewardRate = '0%';
		} else {
			rewardRate = (data.rewardCnt / data.clickCnt * 100).toFixed(2) + '%';
		}
		sumRow.appendChild(createCell('th', rewardRate));
		sumRow.appendChild(createCell('th', commaLocale(data.productPrice) + '원'));
		sumRow.appendChild(createCell('th', commaLocale(data.commission) + '원'));
		sumRow.appendChild(createCell('th', commaLocale(data.commissionProfit) + '원'));

		if (!modal) {
			const sumViewDetail = document.createElement('th');
			sumViewDetail.appendChild(createDetailButtons(getSearchTypeValue(), 'SUM'));
			sumRow.appendChild(sumViewDetail);
		}

		// 기존 합계 데이터 행 제거
		const reportHead = document.getElementById(!modal ? 'reportHead' : 'modal-reportHead');
		if (reportHead.childElementCount > 1) {
			reportHead.removeChild(reportHead.lastElementChild);
		}
		reportHead.appendChild(sumRow);
	}

	// 테이블 행 렌더링 함수
	function renderTableRows(tableData, modal = false, modalSearchType = '') {
		const reportData = document.getElementById(!modal ? 'reportData' : 'modal-reportData');
		const searchType = !modalSearchType ? getSearchTypeValue() : modalSearchType;
		const cancelYn = getCancelYnValue();

		reportData.innerHTML = ''; // 테이블 초기화

		tableData.forEach(item => {
			const row = document.createElement('tr');

			// 데이터 열 생성
			row.appendChild(createKeywordCell(item, searchType));
			row.appendChild(createCell('td', commaLocale(item.cnt)));
			row.appendChild(createCell('td', commaLocale(item.clickCnt)));
			row.appendChild(createCell('td', commaLocale(getRewardCount(item, cancelYn))));

			let rewardRate;
			if (item.clickCnt === 0 || getRewardCount(item, cancelYn) === 0) {
				rewardRate = '0%';
			} else {
				rewardRate = (getRewardCount(item, cancelYn) / item.clickCnt * 100).toFixed(2) + '%';
			}
			row.appendChild(createCell('td', rewardRate));
			row.appendChild(createCell('td', commaLocale(getProductPrice(item, cancelYn)) + '원'));
			row.appendChild(createCell('td', commaLocale(getCommission(item, cancelYn)) + '원'));
			row.appendChild(createCell('td', commaLocale(getCommissionProfit(item, cancelYn)) + '원'));

			// 상세보기 영역
			if (!modal) {
				const viewDetail = document.createElement('td');
				viewDetail.appendChild(createDetailButtons(searchType, item.keyWord));
				row.appendChild(viewDetail);
			}
			reportData.appendChild(row);
		});
	}

	// 페이지네이션 버튼 렌더링
	function renderPagination(totalCount, size, page, modal = false) {
		const currentPage = page === 0 ? 1 : page;

		// 총 페이지 수 계산
		const totalPages = Math.ceil(totalCount / size);

		// Pagination Container 선택
		const paginationContainer = document.querySelector(!modal ? '.paging > ul' : '.modal-paging > ul');

		// 기존 페이지 링크 초기화
		paginationContainer.innerHTML = '';

		// 이전 (`prev`) 버튼 추가
		const prevPage = document.createElement('li');
		prevPage.classList.add('prev');
		if (currentPage === 1) {
			// 첫 페이지일 경우 비활성화
			prevPage.classList.add('disabled');
			prevPage.innerHTML = `<a href="javascript:void(0);"></a>`;
		} else {
			prevPage.innerHTML = `<a href="javascript:pageLink(${Math.max(currentPage - 2, 1)}, ${modal});"></a>`;
		}
		paginationContainer.appendChild(prevPage);

		// 페이지 숫자 버튼 추가
		const startPage = Math.floor((currentPage - 1) / 10) * 10 + 1;
		const endPage = Math.min(startPage + 9, totalPages);

		for (let i = startPage; i <= endPage; i++) {
			const pageItem = document.createElement('li');
			pageItem.innerHTML = `<a href="javascript:pageLink(${i-1}, ${modal});">${i}</a>`;

			// 현재 페이지에 `on` 클래스 추가
			if (i === currentPage) {
				pageItem.classList.add('on');
			}

			paginationContainer.appendChild(pageItem);
		}

		// 다음 (`next`) 버튼 추가
		const nextPage = document.createElement('li');
		nextPage.classList.add('next');
		if (currentPage === totalPages) {
			// 마지막 페이지일 경우 비활성화
			nextPage.classList.add('disabled');
			nextPage.innerHTML = `<a href="javascript:void(0);"></a>`;
		} else {
			nextPage.innerHTML = `<a href="javascript:pageLink(${Math.min(currentPage + 2, totalPages)}, ${modal});"></a>`;
		}
		paginationContainer.appendChild(nextPage);
	}

	// 상세보기 데이터 조회
	function getViewDetailData(keyword, btn) {
		getReport('', true, keyword, btn);
	}


	// 모든 정렬 가능한 <th> 요소들을 선택합니다.
	const sortableHeaders = document.querySelectorAll('th.sort, th.sortUp, th.sortDown');

	sortableHeaders.forEach(header => {
		header.addEventListener('click', () => {
			// 클릭된 요소를 제외하고 모든 요소를 'sort' 상태로 초기화
			sortableHeaders.forEach(otherHeader => {
				if (otherHeader !== header) {
					otherHeader.classList.remove('sortUp', 'sortDown');
					otherHeader.classList.add('sort');
				}
			});

			// 클릭한 요소의 상태 변경
			if (header.classList.contains('sort')) {
				// 'sort' 상태이면 'sortDown'으로 변경
				header.classList.remove('sort');
				header.classList.add('sortDown');
			} else if (header.classList.contains('sortUp')) {
				// 'sortUp' 상태이면 'sort'으로 변경
				header.classList.remove('sortUp');
				header.classList.add('sort');
			} else if (header.classList.contains('sortDown')) {
				// 'sortDown' 상태이면 'sortUp'로 변경
				header.classList.remove('sortDown');
				header.classList.add('sortUp');
			}

			// 클래스가 변경될 때마다 함수를 호출합니다.
			handleSort(header);
		});
	});
</script>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/page/report/reportModal.php"; ?>
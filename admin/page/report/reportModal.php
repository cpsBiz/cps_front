<link type="text/css" rel="stylesheet" href="./reportModal.css">
<div class="modal" id="myModal">
	<div class="modal-background" onclick="closeModal()"></div>
	<div class="modal-content">
		<section class="modal-sec_list">
			<div class="modal-tableHeader">
				<div class="modal-headerTop">
					<div class="modal-tableTitle">
						<p>요약 리포트<span></span></p>
					</div>
					<span class="close-modal" onclick="closeModal()">&times;</span>
				</div>
				<div class="modal-filterArea">
					<div class="modal-optionBox">
						<div>
							<div class="modal-calendarBox">
								<div class="modal-calendar">
									<input type="text" id="modal-dateInput" name=dateInput" value="">
								</div>
							</div>
							<input type="hidden" id="detailBtnDayType" value="">
							<input type="hidden" id="detailBtnKeywordType" value="">
							<input type="hidden" id="detailBtnsearchType" value="">
							<input type="hidden" id="detailBtnKeyword" value="">
							<button class="modal-searchBtn" onclick="getReportModalFilterData()">검색</button>
						</div>
					</div>
					<div class="modal-selectBox">
						<select id="modal-size">
							<option value="10">10개씩 보기</option>
							<option value="20">20개씩 보기</option>
							<option value="40" selected>40개씩 보기</option>
							<option value="60">60개씩 보기</option>
							<option value="100">100개씩 보기</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-tableArea">
				<div class="modal-tableBox modal-selectDay">
					<table>
						<thead id="modal-reportHead">
							<tr>
								<th id="modal-searchTypeTitle" class="modal-sortDown">날짜</th>
								<th class="modal-sort">노출수</th>
								<th class="modal-sort">클릭수</th>
								<th class="modal-sort">건수</th>
								<th class="modal-sort">전환율</th>
								<th class="modal-sort">구매액</th>
								<th class="modal-sort">커미션 매출</th>
								<th class="modal-sort">커미션 이익</th>
							</tr>
						</thead>
						<tbody id="modal-reportData">

						</tbody>
					</table>
				</div>
				<div class="modal-tableDataNone" style="display: none;">
					<div>
						<p>내용이 없습니다. </p>
					</div>
				</div>
				<div class="modal-paging">
					<ul></ul>
				</div>
			</div>
		</section>
	</div>
</div>
<script>
	// 모달 열기
	const modal = document.getElementById("myModal");

	// API 응답 처리 및 데이터 렌더링
	function modalHandleSuccessResponse(data, size, page, modalSearchType, btn, refresh = false) {
		// 데이터가 없는 경우 UI 처리
		const tableBoxes = document.querySelectorAll('.modal-tableBox');
		const paging = document.querySelector('.modal-paging');
		const tableDataNone = document.querySelector('.modal-tableDataNone');

		if (data.totalCount === 0) {
			hideElements([...tableBoxes, paging]);
			tableDataNone.style.display = 'block';
			return;
		}

		// 데이터가 있는 경우 UI 처리
		showElements([...tableBoxes, paging]);
		tableDataNone.style.display = 'none';

		// 데이터 렌더링 및 페이지네이션 설정
		reportModalOpen(data, modalSearchType, btn, refresh);
		renderPagination(data.totalCount, size, page, true);
	}

	function reportModalOpen(data, modalSearchType, btn, refresh = false) {
		// 모달 리포트 제목
		let modalReportTitle = ''
		switch (btn) {
			case 'DAY':
				modalReportTitle = '일별';
				break;
			case 'MONTH':
				modalReportTitle = '월별';
				break;
			case 'SITE':
				modalReportTitle = '사이트';
				break;
			case 'CAMPAIGN':
				modalReportTitle = '캠페인';
				break;
		}
		const checkedRadio = document.querySelector('input[name="searchType"]:checked');
		const titleGroup = document.querySelector(`label[for="${checkedRadio.id}"]`).innerHTML;
		if (!refresh) {
			document.querySelector('.modal-tableTitle > p > span').textContent = titleGroup + ' > ' + modalReportTitle;
		}

		// 모달에 기존 날짜 선택값 복사

		if (!refresh) {
			modalDateCopy();
		}
		// 모달 첫번째 행 키워드 타이틀 설정
		setTitle(true, modalReportTitle);

		// 모달 합계 데이터처리
		renderSumRow(data, true)

		// 모달 데이터 리스트 처리
		renderTableRows(data.datas, true, modalSearchType);

		// 모달 정렬 이벤트 추가
		const sortableHeaders = document.querySelectorAll('th.modal-sort, th.modal-sortUp, th.modal-sortDown');
		sortableHeaders.forEach(header => {
			header.addEventListener('click', () => {
				// 클릭된 요소를 제외하고 모든 요소를 'sort' 상태로 초기화
				sortableHeaders.forEach(otherHeader => {
					if (otherHeader !== header) {
						otherHeader.classList.remove('modal-sortUp', 'modal-sortDown');
						otherHeader.classList.add('modal-sort');
					}
				});

				// 클릭한 요소의 상태 변경
				if (header.classList.contains('modal-sort')) {
					// 'sort' 상태이면 'sortDown'으로 변경
					header.classList.remove('modal-sort');
					header.classList.add('modal-sortDown');
				} else if (header.classList.contains('modal-sortUp')) {
					// 'sortUp' 상태이면 'sort'으로 변경
					header.classList.remove('modal-sortUp');
					header.classList.add('modal-sort');
				} else if (header.classList.contains('modal-sortDown')) {
					// 'sortDown' 상태이면 'sortUp'로 변경
					header.classList.remove('modal-sortDown');
					header.classList.add('modal-sortUp');
				}

				// 클래스가 변경될 때마다 함수를 호출합니다.
				handleSort(header, true);
			});
		});

		modal.style.display = "block";
	}

	// 모달 검색 함수 -> 날짜, 페이지 아이템 사이즈를 제외한 나머지는 기존 필터에서 가져온다.
	function getReportModalFilterData(orderByData = {
		orderBy: 'DESC',
		orderByName: ''
	}) {
		try {
			// 상세보기 선택에서 월별은 제외한 나머지는 DAY
			let dayType = document.getElementById('detailBtnDayType').value;

			// 월별 YYYYMM, 일별 YYYYMMDD
			const regFull = getRegDates(document.getElementById('modal-dateInput').value, dayType);
			const regStart = regFull[0];
			const regEnd = regFull[1];

			// 상세보기 선택 값
			let searchType = document.getElementById('detailBtnsearchType').value;

			// 영역 선택 값
			const os = document.querySelector('input[name="os"]:checked').value;

			// 상태 선택 값, 취소분만 취소완료
			const cancelYn = document.querySelector('input[name="cancelYn"]:checked').value;

			// 선택 영역 선택 값
			let keywordType = document.getElementById('detailBtnKeywordType').value;

			// ID/명/법인명 입력 값
			let keyword = document.getElementById('detailBtnKeyword').value;

			// 로그인 아이디 타입
			const type = '<?= $_SESSION['admin_login_type']; ?>';

			// 로그인한 아이디
			const searchId = '<?= $_SESSION['admin_login_id']; ?>';

			// 한 페이지에서 몇개의 데이터를 보여줄건지
			const size = parseInt(document.getElementById('modal-size').value);

			// 정렬 값
			const orderBy = orderByData.orderBy;
			checkOrderByDataModal.orderBy = orderBy;
			let orderByName = orderByData.orderByName;
			if (!orderByName && (searchType === 'DAY' || dayType === 'EQDAY')) {
				orderByName = 'regDay';
			} else if (!orderByName && (searchType === 'MONTH' || dayType === 'EQMONTH')) {
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
			checkOrderByDataModal.orderByName = orderByName;

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
				modalPage,
				size,
				orderBy,
				orderByName
			};

			// AJAX 요청 수행
			$.ajax({
				type: 'POST',
				url: './api/select-report.php',
				contentType: 'application/json',
				data: JSON.stringify(requestData),
				success: function(result) {
					modalHandleSuccessResponse(result, size, modalPage, searchType, false, true)
				},
				error: function(request, status, error) {
					console.error(`Error: ${error}`);
				}
			});
		} catch (error) {
			alert(error.message);
		}
	}

	function closeModal() {
		reportModalReset();
		modal.style.display = "none";
	}

	// 상세보기 모달 닫을때 데이터 렌더링 초기화
	function reportModalReset() {
		document.getElementById('modal-reportData').innerHTML = '';
		document.querySelector('.modal-paging > ul').innerHTML = '';
		modalPage = 1;
	}

	function modalDateCopy() {
		// 첫 번째 daterangepicker에서 선택된 값 가져오기
		const startDate = $('#dateInput').data('daterangepicker').startDate;
		const endDate = $('#dateInput').data('daterangepicker').endDate;

		// 두 번째 daterangepicker에 값 설정
		$('#modal-dateInput').data('daterangepicker').setStartDate(startDate);
		$('#modal-dateInput').data('daterangepicker').setEndDate(endDate);
	}
</script>
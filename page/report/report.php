<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<?
header('Access-Control-Allow-Origin: *');
header('Access-Control-Max-Age: 86400');
header('Access-Control-Allow-Headers: x-requested-with');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
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
    <link type="image/ico" rel="shortcut icon" href="../../image/favicon/favicon.ico">
    <script type="text/javascript" src="../../js/lib/jquery-2.2.2.min.js"></script>
    <script type="text/javascript" src="../../js/lib/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="../../js/lib/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../../js/lib/moment.min.js"></script>
    <script type="text/javascript" src="../../js/lib/daterangepicker_popup.js"></script>
    <script type="text/javascript" src="../../js/ui.js"></script>
    <link type="text/css" rel="stylesheet" href="../../css/lib/daterangepicker_popup.css" />
    <link type="text/css" rel="stylesheet" href="../../css/common.css">
</head>

<body>
    <!-- 캠페인관리 > 캠페인 카테고리 -->
    <!-- ic_reportPerformance 클래스는 해당 페이지를 구분하는 id 값으로 사용하는 클래스입니다. 
             다른 페이지에는 사용을 지양해주시기 바랍니다.(추후 유지보수때 css 수정 어려움) -->
    <div class="wrap ic_reportPerformance">
        <header class="header">
            <h1><a href="javascript:void(0);">통합카트</a></h1>
            <div class="sideMenu">
                <div class="name"><strong>에비블루</strong>님</div>
                <div class="userMenu">
                    <button type="button" class="userinfo menuMore">고객정보</button>
                    <ul>
                        <li><button type="button">권한정보</button></li>
                        <li><button type="button">회원정보수정</button></li>
                        <li><button type="button">로그아웃</button></li>
                    </ul>
                </div>
            </div>
        </header>
        <nav class="navigation">
            <ul class="lnb">
                <li class="dashboard">
                    <a href="#"><span>대시보드</span></a>
                </li>
                <li class="report on">
                    <a href="#"><span>리포트</span></a>
                </li>
                <li class="campaign">
                    <a href="#"><span>캠페인 관리</span></a>
                    <ul>
                        <li><a href="#">캠페인 생성</a></li>
                        <li><a href="#">캠페인 리스트</a></li>
                        <li class="on"><a href="#">캠페인 카테고리</a></li>
                    </ul>
                </li>
                <li class="menu">
                    <a href="#"><span>메뉴 관리</span></a>
                </li>
                <li class="account">
                    <a href="#"><span>계정 관리</span></a>
                    <ul>
                        <li><a href="#">회원</a></li>
                        <li><a href="#">관리자</a></li>
                    </ul>
                </li>
                <li class="customer">
                    <a href="#"><span>고객 관리</span></a>
                </li>
                <li class="notice">
                    <a href="#"><span>공지사항</span></a>
                </li>
            </ul>
        </nav>
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
                                <input type="radio" name="dayType" id="dayType2">
                                <label for="dayType2">상세</label>
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
                            <!-- <p>상세 리포트</p> -->
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
                    <!--// 내용이 없을 때 tableWrap & tableAreaDataNone 함께 사용 -->
                    <!-- <div class="tableArea tableAreaDataNone"> -->
                    <div class="tableArea">
                        <!-- table 스크롤 생기게 하고 싶을 때 tableBox 에 높이값(max-height) 추가-->
                        <!-- 상세리포트 테이블과 요약리포트 테이블은 tableBox에 selectDay, selectDetail 클래스로 구분함  >> 퍼블확인을 위해 tableBox 두개 추가한 부분이므로 개발할때는 한개만 사용하고 클래스로 구분하면 됩니다. -->
                        <!-- 요약리포트 selectDay -->
                        <div class="tableBox selectDay">
                            <table>
                                <thead id="reportHead">
                                    <tr>
                                        <th id="searchTypeTitle" class="sortDown">날짜</th>
                                        <th class="sortUp">노출수</th>
                                        <th class="sortUp">클릭수</th>
                                        <th class="sortUp">건수</th>
                                        <th class="sortUp">전환율</th>
                                        <th class="sortUp">구매액</th>
                                        <th class="sortUp">커미션 매출</th>
                                        <th class="sortUp">커미션 이익</th>
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

    function getReport(orderBy = '', detail = false, detailKeyword = '', btn = '') {
        console.log(detail, detailKeyword)
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
            const type = 'MASTER';

            // 로그인한 아이디
            // const searchId = '';

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
                    keyword = detailKeyword;
                }

                if (btn === 'SITE' || btn === 'CAMPAIGN' || btn === 'DETAIL') {
                    searchType = btn;
                }
            }



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
                page,
                size,
                orderBy
            };

            // 7. AJAX 요청 수행
            $.ajax({
                type: 'POST',
                url: 'http://192.168.150.61/api/admin/summaryCount',
                contentType: 'application/json',
                data: JSON.stringify(requestData),
                success: function(result) {
                    if (!detail) {
                        handleSuccessResponse(result, searchType, size, page);
                        return;
                    }
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
    function handleSuccessResponse(data, searchType, size, page) {
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

    // 특정 요소 리스트를 숨기는 함수
    function hideElements(elements) {
        elements.forEach(element => {
            element.style.display = 'none';
        });
    }

    // 특정 요소 리스트를 보이는 함수
    function showElements(elements) {
        elements.forEach(element => {
            element.style.display = 'block';
        });
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
    function setTitle() {
        let title = '';
        const searchType = getSearchTypeValue();

        if (searchType === 'DAY' || searchType === 'MONTH') {
            title = '날짜';
        } else {
            const checkedRadio = document.querySelector('input[name="searchType"]:checked');
            title = document.querySelector(`label[for="${checkedRadio.id}"]`).innerHTML;
        }
        document.getElementById('searchTypeTitle').innerHTML = title;
    }

    // 합계 데이터 행 렌더링 함수
    function renderSumRow(data) {
        const sumRow = document.createElement('tr');
        sumRow.appendChild(createCell('th', '합계'));
        sumRow.appendChild(createCell('th', commaLocale(data.cnt)));
        sumRow.appendChild(createCell('th', commaLocale(data.clickCnt)));
        sumRow.appendChild(createCell('th', commaLocale(data.rewardCnt)));
        sumRow.appendChild(createCell('th', '1')); // 전환율 값 예시로 1
        sumRow.appendChild(createCell('th', commaLocale(data.productPrice) + '원'));
        sumRow.appendChild(createCell('th', commaLocale(data.commission) + '원'));
        sumRow.appendChild(createCell('th', commaLocale(data.commissionProfit) + '원'));

        const sumViewDetail = document.createElement('th');
        sumViewDetail.appendChild(createDetailButtons(getSearchTypeValue(), 'SUM'));
        sumRow.appendChild(sumViewDetail);

        // 기존 합계 데이터 행 제거
        const reportHead = document.getElementById('reportHead');
        if (reportHead.childElementCount > 1) {
            reportHead.removeChild(reportHead.lastElementChild);
        }
        reportHead.appendChild(sumRow);
    }

    // 테이블 행 렌더링 함수
    function renderTableRows(tableData) {
        const reportData = document.getElementById('reportData');
        const searchType = getSearchTypeValue();
        const cancelYn = getCancelYnValue();

        reportData.innerHTML = ''; // 테이블 초기화

        tableData.forEach(item => {
            const row = document.createElement('tr');

            // 데이터 열 생성
            row.appendChild(createKeywordCell(item, searchType));
            row.appendChild(createCell('td', commaLocale(item.cnt)));
            row.appendChild(createCell('td', commaLocale(item.clickCnt)));
            row.appendChild(createCell('td', commaLocale(getRewardCount(item, cancelYn))));
            row.appendChild(createCell('td', '1')); // 전환율 값 예시로 1
            row.appendChild(createCell('td', commaLocale(getProductPrice(item, cancelYn)) + '원'));
            row.appendChild(createCell('td', commaLocale(getCommission(item, cancelYn)) + '원'));
            row.appendChild(createCell('td', commaLocale(getCommissionProfit(item, cancelYn)) + '원'));

            // 상세보기 영역
            const viewDetail = document.createElement('td');
            viewDetail.appendChild(createDetailButtons(searchType, item.keyWord));
            row.appendChild(viewDetail);

            reportData.appendChild(row);
        });
    }

    // 검색 타입 값 가져오기 함수
    function getSearchTypeValue() {
        return document.querySelector('input[name="searchType"]:checked').value;
    }

    // 취소 여부 값 가져오기 함수
    function getCancelYnValue() {
        return document.querySelector('input[name="cancelYn"]:checked').value;
    }

    // 테이블 셀 생성 함수
    function createCell(tag, textContent) {
        const cell = document.createElement(tag);
        cell.textContent = textContent;
        return cell;
    }

    // 키워드 셀 생성 함수 (검색 타입에 따라 날짜 처리 포함)
    function createKeywordCell(item, searchType) {
        const keyword = document.createElement('td');
        let keywordText = item.keyWordName;

        if (searchType === 'DAY' || searchType === 'MONTH') {
            const [formattedDate, dayIndex] = formatAndCheckDate(item.keyWordName);
            keywordText = formattedDate;

            if (searchType === 'DAY') {
                if (dayIndex === 0) keyword.classList.add('sat'); // 토요일
                if (dayIndex === 6) keyword.classList.add('sun'); // 일요일
            }
        }

        keyword.textContent = keywordText;
        return keyword;
    }

    // 건수 데이터
    function getRewardCount(item, cancelYn) {
        return cancelYn === 'N' ? item.confirmRewardCnt : cancelYn === 'Y' ? item.cancelRewardCnt : item.rewardCnt;
    }

    // 구매액 데이터
    function getProductPrice(item, cancelYn) {
        return cancelYn === 'N' ? item.confirmProductPrice : cancelYn === 'Y' ? item.cancelProductPrice : item.productPrice;
    }

    // 커미션 매출 데이터
    function getCommission(item, cancelYn) {
        return cancelYn === 'N' ? item.confirmCommission : cancelYn === 'Y' ? item.cancelCommission : item.commission;
    }

    // 커미션 이익 데이터
    function getCommissionProfit(item, cancelYn) {
        return cancelYn === 'N' ? item.confirmCommissionProfit : cancelYn === 'Y' ? item.cancelCommissionProfit : item.commissionProfit;
    }

    // 천단위 컴마
    function commaLocale(val) {
        return parseInt(val).toLocaleString();
    }

    // 버튼을 생성하는 함수
    function createButton(text, className, keyword) {
        const button = document.createElement('button');
        button.textContent = text;
        button.classList.add(className);
        button.onclick = () => getViewDetailData(keyword, className.toUpperCase());
        return button;
    }

    // 상세보기 영역 생성 함수
    function createDetailButtons(searchType, keyword) {

        const btnBox = document.createElement('div');
        btnBox.classList.add('buttonBox');

        if (searchType === 'DAY' || searchType === 'MONTH') {
            btnBox.appendChild(createButton('캠페인', 'campaign', keyword));
            btnBox.appendChild(createButton('사이트', 'site', keyword));
            btnBox.appendChild(createButton('상세', 'detail', keyword));

        } else if (['MERCHANT', 'CAMPAIGN', 'AFFLIATE', 'MEMBERAFF'].includes(searchType)) {
            btnBox.appendChild(createButton('일별', 'day', keyword));
            btnBox.appendChild(createButton('월별', 'month', keyword));
            btnBox.appendChild(createButton('사이트', 'site', keyword));

        } else if (['SITE', 'MEMBERAGC'].includes(searchType)) {
            btnBox.appendChild(createButton('일별', 'day', keyword));
            btnBox.appendChild(createButton('월별', 'month', keyword));
            btnBox.appendChild(createButton('캠페인', 'campaign', keyword));
        }

        return btnBox;
    }

    // 날짜를 변환하고, 요일을 판단하는 함수
    function formatAndCheckDate(dateStr) {
        let year, month, day;
        let formattedDate = '';
        let dayOfWeek = '';

        // 날짜 문자열 길이에 따라 연도, 월, 일을 파싱
        if (dateStr.length === 6) {
            // "YYYYMM" 형식
            year = dateStr.substring(0, 4); // 연도
            month = dateStr.substring(4, 6); // 월
            formattedDate = `${year}.${month}`;

            // 해당 월의 첫날을 기준으로 요일 계산
            dayOfWeek = getDayOfWeek(new Date(year, month - 1, 1));

        } else if (dateStr.length === 8) {
            // "YYYYMMDD" 형식
            year = dateStr.substring(0, 4); // 연도
            month = dateStr.substring(4, 6); // 월
            day = dateStr.substring(6, 8); // 일
            formattedDate = `${year}.${month}.${day}`;

            // 해당 날짜로 요일 계산
            dayOfWeek = getDayOfWeek(new Date(year, month - 1, day));

        } else {
            console.error("지원하지 않는 날짜 형식입니다.");
            return;
        }

        return [
            formattedDate,
            dayOfWeek
        ]
    }

    // 무슨 요일인지 확인하는 함수
    function getDayOfWeek(date) {
        const days = ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"];
        const dayName = days[date.getDay()]; // getDay()는 0 (일요일) ~ 6 (토요일) 사이의 숫자 반환
        return dayName;
    }

    // 일,월별에 맞춰서 날짜를 리턴하는 함수
    function getRegDates(input, dayType) {
        // 입력 문자열에서 날짜 범위를 분리
        const [startDate, endDate] = input.split(" ~ ");

        // 시작 날짜와 끝 날짜에서 년도와 월, 일을 추출
        const [startYear, startMonth, startDay] = startDate.split("-").map(Number);
        const [endYear, endMonth, endDay] = endDate.split("-").map(Number);

        // regStart와 regEnd 초기화
        let regStart, regEnd;

        // 특정 타입이 월별인지 일별인지 확인
        if (dayType === 'MONTH') {
            // 월별
            regStart = `${startYear}${String(startMonth).padStart(2, '0')}`; // YYYYMM 형식
            regEnd = `${startYear}${String(endMonth).padStart(2, '0')}`; // YYYYMM 형식
        } else {
            // 일별
            regStart = `${startYear}${String(startMonth).padStart(2, '0')}${String(startDay).padStart(2, '0')}`; // YYYYMMDD 형식
            regEnd = `${endYear}${String(endMonth).padStart(2, '0')}${String(endDay).padStart(2, '0')}`; // YYYYMMDD 형식
        }

        return [regStart, regEnd];
    }

    // 페이지네이션 버튼 렌더링
    function renderPagination(totalCount, size, page) {
        const currentPage = page === 0 ? 1 : page;

        // 총 페이지 수 계산
        const totalPages = Math.ceil(totalCount / size);

        // Pagination Container 선택
        const paginationContainer = document.querySelector('.paging > ul');

        // 기존 페이지 링크 초기화
        paginationContainer.innerHTML = '';

        // 이전 (`prev`) 버튼 추가
        const prevPage = document.createElement('li');
        prevPage.classList.add('prev');
        prevPage.innerHTML = `<a href="javascript:pageLink(${Math.max(currentPage - 1, 1)});"></a>`;
        paginationContainer.appendChild(prevPage);

        // 페이지 숫자 버튼 추가
        const startPage = Math.floor((currentPage - 1) / 10) * 10 + 1;
        const endPage = Math.min(startPage + 9, totalPages);

        for (let i = startPage; i <= endPage; i++) {
            const pageItem = document.createElement('li');
            pageItem.innerHTML = `<a href="javascript:pageLink(${i});">${i}</a>`;

            // 현재 페이지에 `on` 클래스 추가
            if (i === currentPage) {
                pageItem.classList.add('on');
            }

            paginationContainer.appendChild(pageItem);
        }

        // 다음 (`next`) 버튼 추가
        const nextPage = document.createElement('li');
        nextPage.classList.add('next');
        nextPage.innerHTML = `<a href="javascript:pageLink(${Math.min(currentPage + 1, totalPages)});"></a>`;
        paginationContainer.appendChild(nextPage);
    }

    // 상세보기 데이터 조회
    function getViewDetailData(keyword, btn) {
        getReport('', true, keyword, btn);
    }


    // 모든 정렬 가능한 <th> 요소들을 선택합니다.
    const sortableHeaders = document.querySelectorAll('th.sortUp, th.sortDown');

    // 각 <th> 요소에 클릭 이벤트 리스너를 추가합니다.
    sortableHeaders.forEach(header => {
        header.addEventListener('click', () => {
            if (header.classList.contains('sortUp')) {
                // sortUp 상태이면 sortDown으로 변경
                header.classList.remove('sortUp');
                header.classList.add('sortDown');
            } else if (header.classList.contains('sortDown')) {
                // sortDown 상태이면 sort으로 변경
                header.classList.remove('sortDown');
                header.classList.add('sortUp');
            }

            // 클래스가 변경될 때마다 함수를 호출합니다.
            handleSort(header);
        });
    });

    // 정렬 함수를 정의합니다.
    function handleSort(header) {
        let target, orderBy = '';
        // 클릭한 헤더의 텍스트를 가져옴
        const headerText = header.innerText;
        // 클릭한 헤더의 클래스를 가져옴
        const headerClassList = header.classList.value;

        // 전환율은 프론트에서 계산 전체건수/구매건수 -> 클릭후 구매전환율
        // 취소건 아닌것으로 조회시 confirmRewardCnt
        // 취소건 조회시 cancelRewardCnt

        switch (headerText) {
            case '날짜':
                target = 'regDate'
                break;
            case '노출수':
                target = 'cnt'
                break;
            case '클릭수':
                target = 'clickCnt'
                break;
            case '건수':
                target = 'rewardCnt'
                break;
            case '전환율':
                target = ''
                break;
            case '구매액':
                target = ''
                break;
            case '커미션 매출':
                target = ''
                break;
            case '커미션 이익':
                target = ''
                break;
        }

        // 정렬순서
        if (headerClassList === 'sortUp') {
            orderBy = 'Asc'
        } else if (headerClassList === 'sortDown') {
            orderBy = 'Desc'
        }

        const get = target + orderBy;

        getReport(get)
    }
</script>
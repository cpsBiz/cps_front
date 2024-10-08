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
                                <input type="radio" name="os" id="os2" value="P">
                                <label for="os2">PC</label>
                                <input type="radio" name="os" id="os3" value="M">
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
                            <select name="" id="">
                                <option value="">10개씩 보기</option>
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
                                <thead>
                                    <tr>
                                        <th class="sort">날짜</th>
                                        <th class="sortUp">노출수</th>
                                        <th class="sortDown">클릭수</th>
                                        <th class="sort">건수</th>
                                        <th class="sort">전환율</th>
                                        <th class="sort">구매액</th>
                                        <th class="sort">커미션 매출</th>
                                        <th class="sort">커미션 이익</th>
                                        <th>상세보기</th>
                                    </tr>
                                    <tr>
                                        <th>합계</th>
                                        <th>123,888,999</th>
                                        <th>123,888,999</th>
                                        <th>456,000</th>
                                        <th>59%</th>
                                        <th>123,888,999</th>
                                        <th>123,888,999원</th>
                                        <th>123,888,999원</th>
                                        <th>
                                            <div class="buttonBox">
                                                <button type="button" class="campaign">캠페인</button>
                                                <button type="button" class="site">사이트</button>
                                                <button type="button" class="detail">상세</button>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- 토요일, 일요일은 sat, sun 클래스 추가-->
                                    <tr>
                                        <td>2024.09.19</td>
                                        <td>123,456,890</td>
                                        <td>123,456,890</td>
                                        <td>456,890</td>
                                        <td>57%</td>
                                        <td>123,456,890</td>
                                        <td>123,456,890원</td>
                                        <td>3,456,890원</td>
                                        <td>
                                            <div class="buttonBox">
                                                <button type="button" class="campaign">캠페인</button>
                                                <button type="button" class="site">사이트</button>
                                                <button type="button" class="detail">상세</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sat">2024.09.19</td>
                                        <td>123,456,890</td>
                                        <td>123,456,890</td>
                                        <td>456,890</td>
                                        <td>57%</td>
                                        <td>123,456,890</td>
                                        <td>123,456,890원</td>
                                        <td>3,456,890원</td>
                                        <td>
                                            <div class="buttonBox">
                                                <button type="button" class="campaign">캠페인</button>
                                                <button type="button" class="site">사이트</button>
                                                <button type="button" class="detail">상세</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="sun">2024.09.19</td>
                                        <td>123,456,890</td>
                                        <td>123,456,890</td>
                                        <td>456,890</td>
                                        <td>57%</td>
                                        <td>123,456,890</td>
                                        <td>123,456,890원</td>
                                        <td>3,456,890원</td>
                                        <td>
                                            <div class="buttonBox">
                                                <button type="button" class="campaign">캠페인</button>
                                                <button type="button" class="site">사이트</button>
                                                <button type="button" class="detail">상세</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
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
                        </div>
                        <!-- 상세리포트 selectDetail -->
                        <div class="tableBox selectDetail">
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
                                    <!-- 토요일, 일요일은 sat, sun 클래스 추가-->
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
                </section>
            </div>
            <!--// content end -->
        </section>
        <!--// container end -->
    </div>
</body>

</html>
<script>
    function getReport() {
        // 상세보기 선택에서 월별은 제외한 나머지는 DAY
        const dayType = document.querySelector('input[name="searchType"]:checked').value === 'MONTH' ? 'MONTH' : 'DAY';

        // 월별 YYYYMM, 일별 YYYYMMDD
        const regFull = getRegDates(document.getElementById('dateInput').value, dayType);
        const regStart = regFull[0];
        const regEnd = regFull[1];

        // 상세보기 선택 값
        const searchType = document.querySelector('input[name="searchType"]:checked').value;

        // 영역 선택 값
        const os = document.querySelector('input[name="os"]:checked').value;

        // 상태 선택 값, 취소분만 취소완료
        const cancelYn = document.querySelector('input[name="cancelYn"]:checked').value;

        // 선택 영역 선택 값
        const keywordType = document.querySelector('input[name="keywordType"]:checked').value;

        // ID/명/법인명 입력 값
        const keyword = document.getElementById('keyword').value;

        // 로그인 아이디 타입
        const type = 'MASTER';

        // 로그인한 아이디
        // const searchId = '';

        // totalCount 받은거를 size로 나눴을때의 총 페이지수
        const page = 0;

        // 한 페이지에서 몇개의 데이터를 보여줄건지
        const size = 0;

        // 테이블에서 정렬
        const orderBy = '';

        if (!dayType || !regFull || !regStart || !regEnd || !searchType || !type) {
            return alert('필수값이 누락되었습니다.');
        }

        $.ajax({
            type: 'POST',
            url: 'http://192.168.150.61/api/admin/summaryCount',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                dayType: dayType,
                regStart: regStart,
                regEnd: regEnd,
                searchType: searchType,
                os: os,
                cancelYn: cancelYn,
                keywordType: keywordType,
                keyword: keyword,
                // type: type,
                // searchId: searchId,
                page: page,
                orderBy: orderBy
            }),
            success: function(result) {
                console.log(result);
                const data = result;
                const resultCode = data.resultCode;
                const resultMessage = data.resultMessage;
                const totalCount = data.totalCount;
                const datas = data.datas;

            },
            error: function(request, status, error) {
                console.log(error)
            }
        })
    }

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
</script>
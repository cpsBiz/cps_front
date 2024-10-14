// 날짜를 변환하고, 요일을 판단하는 함수
function formatAndCheckDate(dateStr) {
  let year, month, day;
  let formattedDate = "";
  let dayOfWeek = "";

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

  return [formattedDate, dayOfWeek];
}

// 무슨 요일인지 확인하는 함수
function getDayOfWeek(date) {
  const days = [
    "일요일",
    "월요일",
    "화요일",
    "수요일",
    "목요일",
    "금요일",
    "토요일",
  ];
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
  if (dayType === "MONTH") {
    // 월별
    regStart = `${startYear}${String(startMonth).padStart(2, "0")}`; // YYYYMM 형식
    regEnd = `${startYear}${String(endMonth).padStart(2, "0")}`; // YYYYMM 형식
  } else {
    // 일별
    regStart = `${startYear}${String(startMonth).padStart(2, "0")}${String(
      startDay
    ).padStart(2, "0")}`; // YYYYMMDD 형식
    regEnd = `${endYear}${String(endMonth).padStart(2, "0")}${String(
      endDay
    ).padStart(2, "0")}`; // YYYYMMDD 형식
  }

  return [regStart, regEnd];
}

// 천단위 컴마
function commaLocale(val) {
  return parseInt(val).toLocaleString();
}

// 특정 요소 리스트를 숨기는 함수
function hideElements(elements) {
  elements.forEach((element) => {
    element.style.display = "none";
  });
}

// 특정 요소 리스트를 보이는 함수
function showElements(elements) {
  elements.forEach((element) => {
    element.style.display = "block";
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
  const keyword = document.createElement("td");
  let keywordText = item.keyWordName;

  if (searchType === "DAY" || searchType === "MONTH") {
    const [formattedDate, dayIndex] = formatAndCheckDate(item.keyWordName);
    keywordText = formattedDate;

    if (searchType === "DAY") {
      if (dayIndex === 0) keyword.classList.add("sat"); // 토요일
      if (dayIndex === 6) keyword.classList.add("sun"); // 일요일
    }
  }

  keyword.textContent = keywordText;
  return keyword;
}

// 건수 데이터
function getRewardCount(item, cancelYn) {
  return cancelYn === "N"
    ? item.confirmRewardCnt
    : cancelYn === "Y"
    ? item.cancelRewardCnt
    : item.rewardCnt;
}

// 구매액 데이터
function getProductPrice(item, cancelYn) {
  return cancelYn === "N"
    ? item.confirmProductPrice
    : cancelYn === "Y"
    ? item.cancelProductPrice
    : item.productPrice;
}

// 커미션 매출 데이터
function getCommission(item, cancelYn) {
  return cancelYn === "N"
    ? item.confirmCommission
    : cancelYn === "Y"
    ? item.cancelCommission
    : item.commission;
}

// 커미션 이익 데이터
function getCommissionProfit(item, cancelYn) {
  return cancelYn === "N"
    ? item.confirmCommissionProfit
    : cancelYn === "Y"
    ? item.cancelCommissionProfit
    : item.commissionProfit;
}

// 버튼을 생성하는 함수
function createButton(text, className, keyword) {
  const button = document.createElement("button");
  button.textContent = text;
  button.classList.add(className);
  button.onclick = () => getViewDetailData(keyword, className.toUpperCase());
  return button;
}

// 상세보기 영역 생성 함수
function createDetailButtons(searchType, keyword) {
  const btnBox = document.createElement("div");
  btnBox.classList.add("buttonBox");

  if (searchType === "DAY" || searchType === "MONTH") {
    btnBox.appendChild(createButton("캠페인", "campaign", keyword));
    btnBox.appendChild(createButton("사이트", "site", keyword));
    // btnBox.appendChild(createButton('상세', 'detail', keyword));
  } else if (
    ["MERCHANT", "CAMPAIGN", "AFFLIATE", "MEMBERAFF"].includes(searchType)
  ) {
    btnBox.appendChild(createButton("일별", "day", keyword));
    btnBox.appendChild(createButton("월별", "month", keyword));
    btnBox.appendChild(createButton("사이트", "site", keyword));
  } else if (["SITE", "MEMBERAGC"].includes(searchType)) {
    btnBox.appendChild(createButton("일별", "day", keyword));
    btnBox.appendChild(createButton("월별", "month", keyword));
    btnBox.appendChild(createButton("캠페인", "campaign", keyword));
  }

  return btnBox;
}

// 정렬 함수를 정의합니다.
function handleSort(header, modal = false) {
  let target,
    orderBy = "";
  // 클릭한 헤더의 텍스트를 가져옴
  const headerText = header.innerText;
  // 클릭한 헤더의 클래스를 가져옴
  const headerClassList = header.classList.value;

  // 취소상태
  const cancelYn = getCancelYnValue();

  switch (headerText) {
    case "일별":
      target = "regDay";
      break;
    case "월별":
      target = "regYm";
      break;
    case "광고주":
      target = "memberName";
      break;
    case "캠페인":
      target = "campaignName";
      break;
    case "매체":
      target = "affliateName";
      break;
    case "사이트":
      target = "site";
      break;
    case "광고주대행사":
      target = "memberAgencyName";
      break;
    case "매체대행사":
      target = "affliateAgencyName";
      break;
    case "노출수":
      target = "cnt";
      break;
    case "클릭수":
      target = "clickCnt";
      break;
    case "건수":
      cancelYn === "N"
        ? (target = "confirmRewardCnt")
        : cancelYn === "Y"
        ? (target = "cancelRewardCnt")
        : "rewardCnt";
      break;
    case "전환율":
      target = "";
      break;
    case "구매액":
      cancelYn === "N"
        ? (target = "confirmProductPrice")
        : cancelYn === "Y"
        ? (target = "cancelProductPrice")
        : "productPrice";
      break;
    case "커미션 매출":
      cancelYn === "N"
        ? (target = "confirmCommission")
        : cancelYn === "Y"
        ? (target = "cancelCommission")
        : "commission";
      break;
    case "커미션 이익":
      cancelYn === "N"
        ? (target = "confirmCommissionProfit")
        : cancelYn === "Y"
        ? (target = "cancelCommissionProfit")
        : "commissionProfit";
      break;
  }

  // 정렬순서
  if (headerClassList === "sortUp") {
    orderBy = "ASC";
  } else if (headerClassList === "sortDown") {
    orderBy = "DESC";
  }

  const orderByData = {
    orderBy,
    target,
  };

  return console.log(orderByData);
  if (!modal) {
    getReport(orderByData);
  } else {
    getReportModalFilterData(orderByData);
  }
}

function pageLink(val, modal) {
  if (!modal) {
    page = val;
    getReport();
  } else {
    modalPage = val;
    getReportModalFilterData();
  }
}

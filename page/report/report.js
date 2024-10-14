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
    console.error('지원하지 않는 날짜 형식입니다.');
    return;
  }

  return [formattedDate, dayOfWeek];
}

// 무슨 요일인지 확인하는 함수
function getDayOfWeek(date) {
  const days = [
    '일요일',
    '월요일',
    '화요일',
    '수요일',
    '목요일',
    '금요일',
    '토요일',
  ];
  const dayName = days[date.getDay()]; // getDay()는 0 (일요일) ~ 6 (토요일) 사이의 숫자 반환
  return dayName;
}

// 일,월별에 맞춰서 날짜를 리턴하는 함수
function getRegDates(input, dayType) {
  // 입력 문자열에서 날짜 범위를 분리
  const [startDate, endDate] = input.split(' ~ ');

  // 시작 날짜와 끝 날짜에서 년도와 월, 일을 추출
  const [startYear, startMonth, startDay] = startDate.split('-').map(Number);
  const [endYear, endMonth, endDay] = endDate.split('-').map(Number);

  // regStart와 regEnd 초기화
  let regStart, regEnd;

  // 특정 타입이 월별인지 일별인지 확인
  if (dayType === 'MONTH') {
    // 월별
    regStart = `${startYear}${String(startMonth).padStart(2, '0')}`; // YYYYMM 형식
    regEnd = `${startYear}${String(endMonth).padStart(2, '0')}`; // YYYYMM 형식
  } else {
    // 일별
    regStart = `${startYear}${String(startMonth).padStart(2, '0')}${String(
      startDay,
    ).padStart(2, '0')}`; // YYYYMMDD 형식
    regEnd = `${endYear}${String(endMonth).padStart(2, '0')}${String(
      endDay,
    ).padStart(2, '0')}`; // YYYYMMDD 형식
  }

  return [regStart, regEnd];
}

// 천단위 컴마
function commaLocale(val) {
  return parseInt(val).toLocaleString();
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

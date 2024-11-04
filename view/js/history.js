function moveHistory(param) {
  if (!param) return;
  const url = `/history/${param}.php`;
  location.href = `${url}`;
}

function convertToYYYYMM(dateString) {
  // 연도와 월을 추출
  const year = dateString.match(/\d{4}/)[0];
  const month = dateString.match(/\d{1,2}(?=월)/)[0];

  // 월이 1자리면 앞에 0을 붙여 두 자리로 만들기
  const formattedMonth = month.length === 1 ? `0${month}` : month;

  return `${year}${formattedMonth}`;
}

function convertDate(dateString) {
  // dateString이 정의되었는지 확인
  if (typeof dateString !== 'string') {
    console.error('Input is not a valid string.');
    return null; // 또는 적절한 기본값 반환
  }

  // '년'과 '월'을 기준으로 문자열을 분리
  const parts = dateString.replace(/년|월/g, '').trim().split(' ');

  // 연도와 월을 가져와서 2자리로 맞춤
  const year = parts[0]; // 연도는 그대로 사용
  const month = String(parts[1]).padStart(2, '0'); // 월은 2자리로 맞춤

  // 연도와 월을 합쳐서 반환
  return year + month;
}

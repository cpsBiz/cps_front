function moveHistory(param) {
  if (!param) return;
  const url = `history-${param}.php`;
  location.href = `./${url}`;
}

function convertToYYYYMM(dateString) {
  // 연도와 월을 추출
  const year = dateString.match(/\d{4}/)[0]; 
  const month = dateString.match(/\d{1,2}(?=월)/)[0];

  // 월이 1자리면 앞에 0을 붙여 두 자리로 만들기
  const formattedMonth = month.length === 1 ? `0${month}` : month;

  return `${year}${formattedMonth}`;
}

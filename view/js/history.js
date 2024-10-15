function moveHistory(param) {
  if (!param) return;
  const url = `history-${param}.php`;
  location.href = `./${url}`;
}

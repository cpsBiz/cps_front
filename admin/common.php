<?
function fetchSingleValue($con, $sql)
{
  $stmt = mysqli_stmt_init($con);
  if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result); // 첫 번째 행을 반환
  }
  return null; // 쿼리 준비 실패 시 null 반환
}

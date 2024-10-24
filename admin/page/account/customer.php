<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<?
$page = (int)(isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
$per = 20;
$total_page = 0;
$total = 0;


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
  <link type="image/ico" rel="shortcut icon" href="/admin/image/favicon/favicon.ico">
  <script type="text/javascript" src="/admin/js/lib/jquery-2.2.2.min.js"></script>
  <script type="text/javascript" src="/admin/js/lib/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="/admin/js/lib/jquery-ui.min.js"></script>
  <script type="text/javascript" src="/admin/js/lib/moment.min.js"></script>
  <script type="text/javascript" src="/admin/js/lib/daterangepicker_popup.js"></script>
  <script type="text/javascript" src="/admin/js/ui.js"></script>
  <link type="text/css" rel="stylesheet" href="/admin/css/lib/daterangepicker_popup.css" />
  <link type="text/css" rel="stylesheet" href="/admin/css/common.css">
</head>

<body>
  <!-- 계정관리 > 회원 -->
  <!-- ic_accountCustomer 클래스는 해당 페이지를 구분하는 id 값으로 사용하는 클래스입니다. 
             다른 페이지에는 사용을 지양해주시기 바랍니다.(추후 유지보수때 css 수정 어려움) -->
  <div class="wrap ic_accountCustomer">
    <? include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/page/header.php'; ?>
    <? include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/page/nav.php'; ?>
    <section class="container">
      <div class="title">
        <p>회원</p>
        <div class="location">
          <span>계정 관리</span><span>회원</span>
        </div>
      </div>
      <div class="content">
        <section class="sec_list">
          <div class="tableHeader">
            <div class="searchBox">
              <input type="text" placeholder="ID,회사명">
              <button type="button" class="search">검색</button>
            </div>
            <button type="button" class="register">추가등록</button>
          </div>
          <!--// 내용이 없을 때 tableWrap & tableAreaDataNone 함께 사용 -->
          <!-- <div class="tableArea tableAreaDataNone"> -->
          <div class="tableArea">
            <!-- table 스크롤 생기게 하고 싶을 때 tableBox 에 높이값(max-height) 추가-->
            <div class="tableBox">
              <table>
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>회사명</th>
                    <th>구분</th>
                    <th>담당자</th>
                    <th>대표전화</th>
                    <th>연락처</th>
                    <th>이메일</th>
                    <th>담당자(내부)</th>
                    <th>정보관리</th>
                  </tr>
                </thead>
                <tbody id="accountCustomerList">
                  <?
                  $types = '';
                  $values = array();

                  $sql = "
                          SELECT SQL_CALC_FOUND_ROWS
                            MEMBER_ID,
                            MEMBER_NAME,
                            TYPE,
                            CEO_NAME,
                            COMPANY_PHONE,
                            MANAGER_PHONE,
                            MANAGER_EMAIL,
                            MANAGER_NAME
                          FROM CPS_MEMBER   
                          ";
                  if ($paramKeyword) {
                    $sql .= " 
                            AND (MEMBER_ID = ? OR MEMBER_NAME = ?)
                            ";
                    $types .= 'ss';
                    array_push($values, $paramKeyword, $paramKeyword);
                  }
                  $sql .= "
                          ORDER BY MEMBER_ID ASC
                          LIMIT ?, ?
                          ";
                  $page_int = ($page - 1) * $per;
                  $types .= 'ii';
                  array_push($values, $page_int, $per);

                  $stmt = mysqli_stmt_init($con);
                  if (mysqli_stmt_prepare($stmt, $sql)) {

                    mysqli_stmt_bind_param($stmt, $types, ...$values);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    //페이징
                    $query = "SELECT FOUND_ROWS()";
                    $stmt = mysqli_prepare($con, $query);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $num);
                    while (mysqli_stmt_fetch($stmt)) {
                      $total = $num;
                    }

                    if ($total % $per == 0) {
                      $total_page = (int)($total / $per);
                    } else {
                      $total_page = (int)($total / $per) + 1;
                    }


                    // 결과를 처리
                    while ($row = mysqli_fetch_assoc($result)) {
                      $memberId = $row['MEMBER_ID'];
                      $memberName = $row['MEMBER_NAME'];
                      $memberType = $row['TYPE'];
                      switch ($memberType) {
                        case 'MERCHANT':
                          $memberType = '광고주';
                          break;
                        case 'AGENCY':
                          $memberType = '대행사';
                          break;
                        case 'AFFLIATE':
                          $memberType = '매체';
                          break;
                        case 'MASTER':
                          $memberType = '관리자';
                          break;
                      }
                      $ceoName = $row['CEO_NAME'];
                      $companyPhone = $row['COMPANY_PHONE'];
                      $managerPhone = $row['MANAGER_PHONE'];
                      $managerEmail = $row['MANAGER_EMAIL'];
                      $managerName = $row['MANAGER_NAME'];
                  ?>
                      <tr>
                        <td><?= $memberId; ?></td>
                        <td><?= $memberName ?></td>
                        <td><?= $memberType; ?></td>
                        <td><?= $ceoName; ?></td>
                        <td><?= $companyPhone; ?></td>
                        <td><?= $managerPhone; ?></td>
                        <td><?= $managerEmail; ?></td>
                        <td><?= $managerName; ?></td>
                        <td>
                          <div class="buttonBox">
                            <button type="button" class="login" title="로그인">로그인</button>
                            <button type="button" class="modify" title="수정">수정</button>
                            <button type="button" class="delete" title="삭제">삭제</button>
                          </div>
                        </td>
                      </tr>
                  <?
                    }
                    mysqli_stmt_close($stmt);
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <? if ($total == 0) { ?>
              <div class="accountCustomerList tableDataNone">
                <div>
                  <p style="text-align: center;">내용이 없습니다. </p>
                </div>
              </div>
              <script>
                $('#accountCustomerList .tableBox').hide();
                $('.accountCustomerList .tableDataNone').show();
              </script>
            <? } else { ?>
              <div class="paging">
                <ul>
                  <!-- 이전 페이지 -->
                  <? if ($page > 1) { ?>
                    <li class="prev"><a href="javascript:pageLink(<?= $page - 1; ?>);"></a></li>
                  <? } else { ?>
                    <li class="prev disabled"><a></a></li>
                  <? } ?>

                  <!-- 페이지리스트 -->
                  <? for ($i = 1; $i <= $total_page; $i++) { ?>
                    <? if ($i == $page) { ?>
                      <li class="on"><a href="javascript:pageLink(<?= $i; ?>);"><?= $i; ?></a></li>
                    <? } else { ?>
                      <li><a href="javascript:pageLink(<?= $i; ?>);"><?= $i; ?></a></li>
                  <? }
                  } ?>

                  <!-- 다음페이지 -->
                  <? if ($page < $total_page) { ?>
                    <li class="next"><a href="javascript:pageLink(<?= $page + 1; ?>);"></a></li>
                  <? } else { ?>
                    <li class="next disabled"><a></a></li>
                  <? } ?>
                </ul>
              </div>
              <script>
                function pageLink(pageNumber) {
                  // 페이지 번호에 따라 요청을 보내는 방법 구현
                  // 예를 들어, 페이지를 새로 고치거나 AJAX 요청을 통해 페이지를 로드할 수 있습니다.
                  window.location.href = "?page=" + pageNumber; // 필요한 파라미터 추가
                }
              </script>
            <? } ?>
          </div>
        </section>
      </div>
      <!--// content end -->
    </section>
    <!--// container end -->
  </div>
</body>

</html>
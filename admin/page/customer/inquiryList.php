<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<?
$page = (int)(isset($_REQUEST['page']) ? $_REQUEST['page'] : 1);
$per = 20;
$total_page = 0;
$total = 0;

$paramAnswerYN = $_REQUEST['answerYN'] ? $_REQUEST['answerYN'] : 'N';
$paramCampaign = $_REQUEST['campaign'];
$paramKeyword = $_REQUEST['keyword'];
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
  <!-- 고객관리 > 1:1문의내역 -->
  <!-- ic_inquiryList 클래스는 해당 페이지를 구분하는 id 값으로 사용하는 클래스입니다. 
             다른 페이지에는 사용을 지양해주시기 바랍니다.(추후 유지보수때 css 수정 어려움) -->
  <div class="wrap ic_inquiryList">
    <? include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/page/header.php'; ?>
    <? include_once $_SERVER['DOCUMENT_ROOT'] . '/admin/page/nav.php'; ?>
    <section class="container">
      <div class="title">
        <p>1:1 문의 내역</p>
        <div class="location">
          <span>고객 관리</span><span>1:1 문의 내역</span>
        </div>
      </div>
      <div class="content">
        <section class="sec_alarm">
          <div class="alarmBox">
            <?
            $sql = "
                    SELECT
                        COUNT(*) AS CNT
                    FROM CPS_INQUIRY
                    WHERE
                        ANSWER_YN = 'N'
                    ";
            $stmt = mysqli_stmt_init($con);
            if (mysqli_stmt_prepare($stmt, $sql)) {
              mysqli_stmt_execute($stmt);
              mysqli_stmt_bind_result($stmt, $cnt);
              mysqli_stmt_fetch($stmt);
              mysqli_stmt_close($stmt);
            }
            ?>
            <p>총 <b><?= $cnt; ?>건</b>의 처리되지 않은 회신대기 건이 있습니다.</p>
          </div>
        </section>
        <section class="sec_list">
          <div class="tableHeader">
            <div class="radioBox">
              <p>대응현황</p>
              <input type="radio" name="checkedAnswerYN" id="rd1" value="ALLANSWERYN" <? if ($paramAnswerYN == 'ALLANSWERYN') echo 'checked'; ?>>
              <label for="rd1">전체</label>
              <input type="radio" name="checkedAnswerYN" id="rd2" value="N" <? if ($paramAnswerYN == 'N') echo 'checked'; ?>>
              <label for="rd2">회신대기</label>
              <input type="radio" name="checkedAnswerYN" id="rd3" value="Y" <? if ($paramAnswerYN == 'Y') echo 'checked'; ?>>
              <label for="rd3">회신완료</label>
            </div>
            <div class="selectBox">
              <select id="selectCampaign">
                <option value="ALLCAMPAIGN" <? if ($paramCampaign == 'ALLCAMPAIGN') echo 'selected' ?>>캠페인 전체</option>
                <?
                $sql = "
                        SELECT
                          CAMPAIGN_NUM,
                          CAMPAIGN_NAME
                        FROM CPS_CAMPAIGN
                        ORDER BY CAMPAIGN_NAME ASC
                        ";
                $stmt = mysqli_stmt_init($con);
                if (mysqli_stmt_prepare($stmt, $sql)) {
                  mysqli_stmt_execute($stmt);
                  $result = mysqli_stmt_get_result($stmt);

                  while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <option value="<?= $row['CAMPAIGN_NUM']; ?>" <? if ($paramCampaign == $row['CAMPAIGN_NUM']) echo 'selected'; ?>><?= $row['CAMPAIGN_NAME']; ?></option>
                <?
                  }
                  mysqli_stmt_close($stmt);
                } ?>
              </select>
            </div>
            <div class="searchBox">
              <input id="insertKeyword" type="text" placeholder="이름 or 주문번호">
              <button type="button" class="search" onclick="search()">검색</button>
            </div>
          </div>
          <!--// 내용이 없을 때 tableWrap & tableAreaDataNone 함께 사용 -->
          <!-- <div class="tableArea tableAreaDataNone"> -->
          <div class="tableArea">
            <!-- table 스크롤 생기게 하고 싶을 때 tableBox 에 높이값(max-height) 추가-->
            <div id="customerInquiryList" class="tableBox">
              <table>
                <thead>
                  <tr>
                    <th>접수일시</th>
                    <th>문의유형</th>
                    <th>매체명</th>
                    <th>고객이름</th>
                    <th>주문번호</th>
                    <th>내용</th>
                    <th>대응현황</th>
                  </tr>
                </thead>
                <tbody>
                  <?
                  $types = '';
                  $values = array();
                  $sql = "
                          SELECT SQL_CALC_FOUND_ROWS
                            CAMPAIGN_NUM,
                            REG_DATE,
                            INQUIRY_NUM,
                            INQUIRY_TYPE,
                            AFFLIATE_ID,
                            USER_NAME,
                            ORDER_NO,
                            ANSWER_YN
                          FROM CPS_INQUIRY
                          WHERE
                            1 = 1
                          ";
                  if ($paramAnswerYN && $paramAnswerYN !== 'ALLANSWERYN') {
                    $sql .= "
                            AND ANSWER_YN = ?    
                            ";
                    $types .= 's';
                    array_push($values, $paramAnswerYN);
                  }

                  if ($paramCampaign && $paramCampaign !== 'ALLCAMPAIGN') {
                    $sql .= "
                            AND CAMPAIGN_NUM = ?
                            ";
                    $types .= 'i';
                    array_push($values, $paramCampaign);
                  }

                  if ($paramKeyword) {
                    $sql .= "
                            AND (USER_NAME = ? OR ORDER_NO = ?)
                            ";
                    $types .= 'ss';
                    array_push($values, $paramKeyword, $paramKeyword);
                  }
                  $sql .= "
                          ORDER BY INQUIRY_NUM ASC
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
                      $regDate = $row['REG_DATE'];
                      $inquiryType = $row['INQUIRY_TYPE'];
                      $affliateId = $row['AFFLIATE_ID'];
                      $userName = $row['USER_NAME'];
                      $orderNo = $row['ORDER_NO'];
                      $answerYN = $row['ANSWER_YN'];
                  ?>
                      <!-- 회신완료, 회신대기 complete, wait 클래스 추가-->
                      <tr>
                        <td><?= date('Y.m.d H:i', strtotime($regDate)); ?></td>
                        <td><?= $inquiryType; ?></td>
                        <td><?= $affliateId; ?></td>
                        <td><?= $userName; ?></td>
                        <td><?= $orderNo; ?></td>
                        <td><button type="button" class="detail" onclick="getInquiryDetail(<?= $row['INQUIRY_NUM']; ?>,'<?= $row['INQUIRY_TYPE']; ?>');">상세보기</button></td>
                        <td class="<?= $answerYN === 'Y' ? 'complete' : 'wait';  ?>"><?= $answerYN === 'Y' ? '회신완료' : '회신대기';  ?></td>
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
              <div class="customerInquiryList tableDataNone">
                <div>
                  <p style="text-align: center;">내용이 없습니다. </p>
                </div>
              </div>
              <script>
                $('#customerInquiryList .tableBox').hide();
                $('.customerInquiryList .tableDataNone').show();
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
  <div class="wrap modalView">
    <div class="modal"></div>
  </div>
</body>
<script src="/view/js/common.js"></script>

</html>
<script>
  function search() {
    const answerYN = document.querySelector('input[name="checkedAnswerYN"]:checked').value;
    const campaign = document.getElementById('selectCampaign').value;
    const keyword = document.getElementById('insertKeyword').value;

    const currentUrl = window.location.href;

    const url = new URL(currentUrl);

    if (answerYN) url.searchParams.set('answerYN', answerYN);
    if (campaign) url.searchParams.set('campaign', campaign);
    if (keyword) url.searchParams.set('keyword', keyword);

    window.location.href = url.toString();
  }
</script>
<? if ($total > 0) include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/page/customer/inquiryDetail.php"; ?>
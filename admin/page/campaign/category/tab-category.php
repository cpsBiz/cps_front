<div class="tabViewList show">
  <div class="tableHeader">
    <div class="tableTitle">
      <p>카테고리 목록 관리</p>
    </div>
    <div class="buttonBox">
      <button type="button" class="register" onclick="addCategory();">추가등록</button>
      <button type="button" class="rankSave" onclick="modifyCategoryRank();">순위 변경사항 저장</button>
    </div>
  </div>
  <!--// 내용이 없을 때 tableWrap & tableAreaDataNone 함께 사용 -->
  <!-- <div class="tableArea tableAreaDataNone"> -->
  <div id="categoryList" class="tableArea">
    <!-- table 스크롤 생기게 하고 싶을 때 tableBox 에 높이값(max-height) 추가-->
    <div class="tableBox">
      <table>
        <thead>
          <tr>
            <th>순위</th>
            <th>카테고리</th>
            <th>캠페인수</th>
            <th>관리</th>
            <th>순위변경<span class="iBox">
                <span class="iMarkHover">말풍선입니다.</span></span></th>
          </tr>
        </thead>
        <tbody id="drag-drop">
          <?
          $sql = "
                  SELECT SQL_CALC_FOUND_ROWS
                    A.CATEGORY,
                    A.CATEGORY_NAME,
                    A.CATEGORY_RANK,
                    COUNT(B.CAMPAIGN_NUM) AS CAMPAIGN_CNT
                  FROM CPS_CATEGORY A
                  LEFT JOIN CPS_CAMPAIGN B ON B.CATEGORY = A.CATEGORY 
                  GROUP BY A.CATEGORY
                  ORDER BY CAST(CATEGORY_RANK AS UNSIGNED) ASC
                  LIMIT ?, ?
                  ";

          $page_int = ($page - 1) * $per;

          $stmt = mysqli_stmt_init($con);
          if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ii', $page_int, $per);
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
            $i = $page_int + 1;
            while ($row = mysqli_fetch_assoc($result)) {
              $categoryRank = $row['CATEGORY_RANK'];
              $categoryName = $row['CATEGORY_NAME'];
              $campaignCnt = $row['CAMPAIGN_CNT'];
              $category = $row['CATEGORY'];
          ?>
              <tr id="categoryList<?= $i; ?>" data-category="<?= $category; ?>" data-category-name="<?= $categoryName; ?>">
                <td><?= $i; ?></td>
                <td><?= $categoryName; ?></td>
                <td><?= $campaignCnt; ?></td>
                <td>
                  <div class="buttonBox">
                    <button type="button" class="modify" title="수정" onclick="modifyCategory('<?= $category; ?>', '<?= $categoryName; ?>', <?= $categoryRank; ?>)">수정</button>
                    <button type="button" class="delete" title="삭제" onclick="deleteCategory('<?= $category; ?>', '<?= $categoryName; ?>')">삭제</button>
                  </div>
                </td>
                <td>
                  <div class="buttonBox">
                    <img class="drag-handle" src="/admin/image/component/ico_hamburger.svg" alt="">
                  </div>
                </td>
              </tr>
          <?
              $i++;
            }

            mysqli_stmt_close($stmt);
          }
          ?>
        </tbody>
      </table>
    </div>
    <? if ($total == 0) { ?>
      <div class="categoryList tableDataNone">
        <div>
          <p style="text-align: center;">내용이 없습니다. </p>
        </div>
      </div>
      <script>
        $('#categoryList .tableBox').hide();
        $('.categoryList.tableDataNone').show();
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
      <style>
        .drag-handle {
          cursor: grab;
        }
      </style>
      <script>
        $('#drag-drop').sortable({
          handle: '.drag-handle'
        })

        function modifyCategoryRank() {
          try {
            let categoryList = [];
            const target = document.getElementById('drag-drop');
            for (let i = 0; i < target.childElementCount; i++) {
              const row = target.children[i];
              const category = row.getAttribute('data-category');
              const categoryName = row.getAttribute('data-category-name');

              categoryList.push({
                category: category,
                categoryName: categoryName,
                categoryRank: <?= $page_int; ?> + i + 1
              });
            }

            const requestData = {
              apiType: 'U',
              categoryList
            }

            $.ajax({
              type: 'POST',
              url: 'http://192.168.101.156/api/admin/category',
              contentType: 'application/json',
              data: JSON.stringify(requestData),
              success: function(result) {
                if (result.resultCode !== '0000') return alert(result.resultMessage);
                location.reload();
              },
              error: function(request, status, error) {
                console.error(`Error: ${error}`);
              }
            });
          } catch (error) {
            alert(error);
          }

        }
      </script>
    <? } ?>
  </div>
</div>
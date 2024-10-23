<div class="tabViewList show">
  <div class="tableHeader">
    <div class="tableTitle">
      <p>카테고리 캠페인 관리</p>
    </div>
    <div class="selectBox">
      <select id="selectCategory" class="category" onchange="selectCategory()">
        <?
        $sql = "
                SELECT 
                  CATEGORY, CATEGORY_NAME 
                FROM CPS_CATEGORY 
                ORDER BY CAST(CATEGORY_RANK AS UNSIGNED) ASC
                ";
        $stmt = mysqli_stmt_init($con);
        if (mysqli_stmt_prepare($stmt, $sql)) {
          mysqli_stmt_execute($stmt);
          $selectCategoryList = mysqli_stmt_get_result($stmt);
          $firstCategory = '';
          $i = 0;
          while ($row = mysqli_fetch_assoc($selectCategoryList)) {
            if ($i == 0) $firstCategory = $row['CATEGORY'];
        ?>
            <option value="<?= $row['CATEGORY']; ?>" <? if ($paramCategory == $row['CATEGORY']) echo 'selected'; ?>><?= $row['CATEGORY_NAME']; ?></option>
        <? $i++;
          }
          mysqli_stmt_close($stmt);
        } ?>
      </select>
      <select id="selectAffliate" class="category" onchange="selectAffliate()">
        <?
        $sql = "
                SELECT
                  MEMBER_ID
                FROM CPS_MEMBER
                WHERE
                  TYPE = 'AFFLIATE'
                ";
        $stmt = mysqli_stmt_init($con);
        if (mysqli_stmt_prepare($stmt, $sql)) {
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);

          while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <option value="<?= $row['MEMBER_ID']; ?>" <? if ($paramAffliate == $row['MEMBER_ID']) echo 'selected'; ?>><?= $row['MEMBER_ID']; ?></option>
        <?
          }
          mysqli_stmt_close($stmt);
        } ?>
      </select>
      <select name="" id="">
        <option value="">50개씩 보기</option>
      </select>
    </div>
    <div class="buttonBox">
      <button type="button" class="change" onclick="modifyCheckCampaign()">선택변경</button>
      <button type="button" class="excelUpload" onclick="campaignExcelUpload()">엑셀 업로드</button>
      <button type="button" class="save" onclick="modifyCampaignRank()">변경사항 저장</button>
    </div>
  </div>
  <!--// 내용이 없을 때 tableWrap & tableAreaDataNone 함께 사용 -->
  <!-- <div class="tableArea tableAreaDataNone"> -->
  <div id="campaignList" class="tableArea">
    <!-- table 스크롤 생기게 하고 싶을 때 tableBox 에 높이값(max-height) 추가-->
    <div class="tableBox">
      <table>
        <thead>
          <tr>
            <th>순서</th>
            <th>캠페인명</th>
            <th>카테고리 변경</th>
            <th>
              <div class="checkBox">
                <input type="checkbox" name="chk2" id="chk2_all">
                <label for="chk2_all">선택</label>
              </div>
            </th>
            <th>순위변경<span class="iBox">
                <span class="iMarkHover">말풍선입니다.</span></span>
            </th>
          </tr>
        </thead>
        <tbody id="drag-drop">
          <?
          $types = '';
          $values = array();
          $sql = "
                  SELECT 
                    A.CATEGORY,
                    A.AFFLIATE_ID,
                    B.CAMPAIGN_NUM,
                    B.CAMPAIGN_NAME
                  FROM CPS_CAMPAIGN_RANK A
                  JOIN CPS_CAMPAIGN B ON A.CAMPAIGN_NUM = B.CAMPAIGN_NUM
                  JOIN CPS_CATEGORY C ON C.CATEGORY = A.CATEGORY 
                  WHERE
                    A.CATEGORY = ?
                  ";
          $types .= 's';
          array_push($values, $paramCategory);


          if ($paramAffliate !== 'ALLAFFLIATE') {
            $sql .= "
                    AND A.AFFLIATE_ID = ?
                    ";
            $types .= 's';
            array_push($values, $paramAffliate);
          }

          $sql .= "
                  GROUP BY A.CAMPAIGN_NUM, A.CATEGORY
                  ORDER BY CAMPAIGN_RANK ASC
                  LIMIT ?, ?
                  ";

          $page_int = ($page - 1) * $per;
          $types .= 'ii';
          array_push($values, $page_int, $per);

          $stmt = mysqli_stmt_init($con);
          if (mysqli_stmt_prepare($stmt, $sql)) {
            if (!$paramCategory) $paramCategory = $firstCategory;

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
            $i = $page_int + 1;
            while ($row = mysqli_fetch_assoc($result)) {
              $campaignNum = $row['CAMPAIGN_NUM'];
              $campaignName = $row['CAMPAIGN_NAME'];
              $category = $row['CATEGORY'];
              $affliateId = $row['AFFLIATE_ID'];
          ?>
              <tr id="campaignList<?= $i; ?>" data-category="<?= $category; ?>" data-campaign-num="<?= $campaignNum; ?>" data-affliate-id="<?= $affliateId; ?>">
                <td><?= $i; ?></td>
                <td><?= $campaignName; ?></td>
                <td>
                  <div class="buttonBox">
                    <button type="button" class="categoryChange" onclick="modifySingleCategoryCampaign('<?= $campaignNum ?>', '<?= $campaignName; ?>', '<?= $category; ?>', '<?= $affliateId; ?>')">카테고리 변경</button>
                  </div>
                </td>
                <td>
                  <div class="checkBox">
                    <input type="checkbox" name="chk2" id="chk2_<?= $i; ?>" value="campaignList<?= $i; ?>">
                    <label for="chk2_<?= $i; ?>"></label>
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
      <div class="campaignList tableDataNone">
        <div>
          <p style="text-align: center;">내용이 없습니다. </p>
        </div>
      </div>
      <script>
        $('#campaignList .tableBox').hide();
        $('.campaignList.tableDataNone').show();
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

        function selectCategory() {
          const category = document.getElementById('selectCategory').value;

          const currentUrl = window.location.href;

          const url = new URL(currentUrl);

          url.searchParams.set('category', category);

          window.location.href = url.toString();
        }

        function selectAffliate() {
          const affliate = document.getElementById('selectAffliate').value;

          const currentUrl = window.location.href;

          const url = new URL(currentUrl);

          url.searchParams.set('affliate', affliate);

          window.location.href = url.toString();
        }

        // 캠페인 체크 선택 카테고리 변경
        function modifyCheckCampaign() {
          const checkedBoxes = document.querySelectorAll('input[name="chk2"]:checked');

          let checkedBoxesCnt = checkedBoxes.length;
          if (checkedBoxesCnt === 0) return alert('선택된 캠페인이 없습니다.');
          if (document.getElementById("chk2_all").checked) {
            checkedBoxesCnt -= 1;
          }

          const modal = `
                    <div class="modalWrap md_categoryChange" id="md_categoryChange" style="display:block;">
                        <div class="modalContainer">
                            <div class="modalTitle">
                                <p>카테고리 캠페인 관리 / 선택변경</p>
                                <button class="close modalClose" onclick="location.reload();"></button>
                            </div>
                            <div class="modalContent">
                                <div class="categoryBox">
                                    <p>총 ${checkedBoxesCnt}개의 캠페인을 선택하셨습니다.</p>
                                    <select id="singleCategoryCampaign">
                                    <?
                                    $sql = "
                                            SELECT 
                                              CATEGORY, CATEGORY_NAME 
                                            FROM CPS_CATEGORY 
                                            ORDER BY CAST(CATEGORY_RANK AS UNSIGNED) ASC
                                            ";
                                    $stmt = mysqli_stmt_init($con);
                                    if (mysqli_stmt_prepare($stmt, $sql)) {
                                      mysqli_stmt_execute($stmt);
                                      $result = mysqli_stmt_get_result($stmt);
                                      while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                      <option value="<?= $row['CATEGORY']; ?>" <? if ($paramCategory == $row['CATEGORY']) echo 'selected'; ?>><?= $row['CATEGORY_NAME']; ?></option>
                                    <?
                                      }
                                      mysqli_stmt_close($stmt);
                                    } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modalFooter">
                                <button type="button" class="confirm" onclick="postModifyCheckCampaign()">변경</button>
                                <button type="button" class="cancel" onclick="location.reload();">취소</button>
                            </div>
                        </div>
                        <div class="modalDim" onclick="location.reload();"></div>
                    </div>
                    `;
          $('#md_categoryChange').remove();
          $('.wrap.modalView .modal').append(modal);
        }

        // 캠페인 체크 선택 카테고리 변경 - 데이터 전송
        function postModifyCheckCampaign() {
          try {
            let campaignCategoryList = [];
            const checkedBoxes = document.querySelectorAll('input[name="chk2"]:checked');
            checkedBoxes.forEach(box => {
              if (box.id === "chk2_all") return;

              const row = document.getElementById(box.value);
              const nowCategory = row.getAttribute('data-category');
              const campaignNum = row.getAttribute('data-campaign-num');
              const affliateId = row.getAttribute('data-affliate-id');

              campaignCategoryList.push({
                nowCategory,
                campaignNum,
                affliateId,
                category: document.getElementById('singleCategoryCampaign').value
              });
            });

            const requestData = {
              apiType: 'U',
              campaignCategoryList
            }

            $.ajax({
              type: 'POST',
              url: '/admin/page/campaign/category/api/update-campaign-category.php',
              contentType: 'application/json',
              dataType: "JSON",
              data: JSON.stringify(requestData),
              success: function(result) {
                if (result.resultCode !== 'success') return alert(result.resultMessage);
                successModifyCheckCampaign(result.successCnt);
              },
              error: function(request, status, error) {
                console.error(`Error: ${error}`);
              }
            });
          } catch (error) {
            alert(error);
          }
        }

        // 캠페인 체크 선택 카테고리 변경 - 성공시 
        function successModifyCheckCampaign(successCnt) {

          const categoryNameElement = document.getElementById('singleCategoryCampaign');
          const categoryNameText = categoryNameElement.options[categoryNameElement.selectedIndex].text;

          const modal = `
                  <div class="modalWrap md_categoryRegister" id="md_categoryRegister" style="display:block;">
                      <div class="modalContainer">
                          <div class="modalTitle">
                              <p>카테고리 목록 관리 / 선택변경</p>
                              <button class="close modalClose" onclick="location.reload();"></button>
                          </div>
                          <div class="modalContent">
                              <div class="categoryBox">
                                  <p>${successCnt}개 캠페인</p>
                                  <p>이 ${categoryNameText} 카테고리로 변경 되었습니다.</p>
                              </div>
                          </div>
                          <div class="modalFooter">
                              <button type="button" class="confirm" onclick="location.reload();">확인</button>
                          </div>
                      </div>
                      <div class="modalDim" onclick="location.reload();"></div>
                  </div>
                  `;
          $('.wrap.modalView .modal').empty();
          $('.wrap.modalView .modal').append(modal);
        }

        function modifyCampaignRank() {
          try {
            let campaignList = [];
            const target = document.getElementById('drag-drop');
            for (let i = 0; i < target.childElementCount; i++) {
              const row = target.children[i];
              const category = row.getAttribute('data-category');
              const affliateId = row.getAttribute('data-affliate-id');
              const campaignNum = row.getAttribute('data-campaign-num');

              campaignList.push({
                category,
                affliateId,
                campaignNum,
                campaignRank: <?= $page_int; ?> + i + 1
              });
            }

            const requestData = {
              apiType: 'U',
              campaignList
            }

            $.ajax({
              type: 'POST',
              url: '/admin/page/campaign/category/api/update-campaign-rank.php',
              contentType: 'application/json',
              dataType: "JSON",
              data: JSON.stringify(requestData),
              success: function(result) {
                if (result.resultCode !== 'success') return alert(result.resultMessage);
                successModifyCampaignRank();
              },
              error: function(request, status, error) {
                console.error(`Error: ${error}`);
              }
            });
          } catch (error) {
            alert(error);
          }
        }

        function successModifyCampaignRank() {
          const modal = `
                          <div class="modalWrap md_alert" id="md_alert" style="display:block;">
                            <div class="modalContainer">
                                <div class="modalTitle">
                                    <button class="close modalClose" onclick="location.reload()"></button>
                                </div>
                                <div class="modalContent">
                                    <div>
                                        <p>변경 사항이 저장 되었습니다.</p>
                                    </div>
                                </div>
                                <div class="modalFooter">
                                    <button type="button" class="confirm" onclick="location.reload()">확인</button>
                                </div>
                            </div>
                            <div class="modalDim" onclick="location.reload()"></div>
                        </div>
                        `;
          $('.wrap.modalView .modal').empty();
          $('.wrap.modalView .modal').append(modal);
        }
      </script>
    <? } ?>
  </div>
</div>
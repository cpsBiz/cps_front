<script>
  function modifySingleCategoryCampaign(campaignNum, campaignName, category) {
    const modal = `
                  <div class="modalWrap md_categoryChange" id="md_categoryChange" style="display:block;">
                      <div class="modalContainer">
                          <div class="modalTitle">
                              <p>카테고리 캠페인 관리/변경</p>
                              <button class="close modalClose" onclick="location.reload();"></button>
                          </div>
                          <div class="modalContent">
                              <div class="categoryBox">
                                  <p><span>${campaignName}</span>캠페인을 선택하셨습니다.</p>
                                  <select id="singleCategoryCampaign">
                                  <?
                                  $sql = "
                                          SELECT 
                                            CATEGORY, CATEGORY_NAME 
                                          FROM CPS_CATEGORY 
                                          ORDER BY CATEGORY_RANK ASC
                                          ";
                                  $stmt = mysqli_stmt_init($con);
                                  if (mysqli_stmt_prepare($stmt, $sql)) {
                                    mysqli_stmt_execute($stmt);
                                    $selectCategoryList = mysqli_stmt_get_result($stmt);
                                    while ($row = mysqli_fetch_assoc($selectCategoryList)) {
                                  ?>
                                      <option value="<?= $row['CATEGORY']; ?>" ${category === "<?= $row['CATEGORY']; ?>" ? 'selected' : ''}><?= $row['CATEGORY_NAME']; ?></option>
                                  <? }
                                    mysqli_stmt_close($stmt);
                                  } ?>
                                  </select>
                              </div>
                          </div>
                          <div class="modalFooter">
                              <button type="button" class="confirm" onclick="postModifyCategoryCampaign('${campaignNum}', '${campaignName}')">변경</button>
                              <button type="button" class="cancel" onclick="location.reload();">취소</button>
                          </div>
                      </div>
                      <div class="modalDim" onclick="location.reload();"></div>
                  </div>
                  `;
    $('#md_categoryChange').remove();
    $('.wrap.modalView .modal').append(modal);
  }

  function postModifyCategoryCampaign(campaignNum, campaignName) {
    try {
      const requestData = {
        campaignCategoryList: {
          campaignNum,
          campaignName,
          category: document.getElementById('singleCategoryCampaign').value
        }
      }



      $.ajax({
        type: 'POST',
        url: 'http://192.168.101.156/api/admin/campaignCategory',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') return alert(result.resultMessage);
          successModifyCategoryCampaign(`${campaignName}`);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  function successModifyCategoryCampaign(campaignName, categoryName) {
    const categoryNameElement = document.getElementById('singleCategoryCampaign');
    const categoryNameText = categoryNameElement.options[categoryNameElement.selectedIndex].text;
    const modal = `
                  <div class="modalWrap md_categoryRegister" id="md_categoryRegister" style="display:block;">
                      <div class="modalContainer">
                          <div class="modalTitle">
                              <p>카테고리 목록 관리 / 변경</p>
                              <button class="close modalClose" onclick="location.reload();"></button>
                          </div>
                          <div class="modalContent">
                              <div class="categoryBox">
                                  <p>${campaignName}</p>
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
</script>
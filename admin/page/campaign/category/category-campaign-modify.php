<script>
  // 캠페인 개별 카테고리 변경
  function modifySingleCategoryCampaign(campaignNum, campaignName, category, affliateId) {
    try {
      $.ajax({
        type: 'GET',
        url: '/page/campaign/category/api/select-campaign-category.php',
        contentType: 'application/json',
        dataType: "JSON",
        data: {
          campaignNum
        },
        success: function(result) {
          if (result.resultCode === 'fail') return alert(result.resultMessage);

          const modal = `
                        <div class="modalWrap md_categoryChange" id="md_categoryChange" style="display:block;">
                            <div class="modalContainer">
                                <div class="modalTitle">
                                    <p>카테고리 캠페인 관리 / 변경</p>
                                    <button class="close modalClose" onclick="location.reload();"></button>
                                </div>
                                <div class="modalContent">
                                    <div class="categoryBox">
                                        <p><span>${campaignName}</span>캠페인을 선택하셨습니다.</p>
                                        <select id="singleCategoryCampaign">
                                        ${result.datas.map((item) => `
                                            <option value="${item.category}">${item.categoryName}</option>
                                        `)}
                                        </select>
                                    </div>
                                </div>
                                <div class="modalFooter">
                                    <button type="button" class="confirm" onclick="postModifyCategoryCampaign('${campaignNum}', '${campaignName}', '${affliateId}', '${category}')">변경</button>
                                    <button type="button" class="cancel" onclick="location.reload();">취소</button>
                                </div>
                            </div>
                            <div class="modalDim" onclick="location.reload();"></div>
                        </div>
                        `;
          $('#md_categoryChange').remove();
          $('.wrap.modalView .modal').append(modal);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  // 캠페인 개별 카테고리 변경 - 데이터 전송
  function postModifyCategoryCampaign(campaignNum, campaignName, affliateId, nowCategory) {
    try {
      const requestData = {
        apiType: 'U',
        campaignCategoryList: [{
          campaignNum,
          affliateId,
          nowCategory,
          category: document.getElementById('singleCategoryCampaign').value
        }]
      }

      $.ajax({
        type: 'POST',
        url: '/page/campaign/category/api/update-campaign-category.php',
        contentType: 'application/json',
        dataType: 'JSON',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== 'success') return alert(result.resultMessage);
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

  // 캠페인 개별 카테고리 변경 - 변경 성공시
  function successModifyCategoryCampaign(campaignName) {
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
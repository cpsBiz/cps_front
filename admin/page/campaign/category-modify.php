<script>
  function modifyCategory(category, name, rank) {
    const modal = `
                    <div class="modalWrap md_categoryRegister" id="md_categoryRegister" style="display:block;">
                      <div class="modalContainer">
                        <div class="modalTitle">
                          <p>카테고리 목록 관리 / 수정</p>
                          <button class="close modalClose" onclick="location.reload();"></button>
                        </div>
                        <div class="modalContent">
                          <div class="inputBox">
                            <input id="categoryModifyName" type="text" placeholder="카테고리명을 입력해주세요" value="${name}">
                          </div>
                        </div>
                        <div class="modalFooter">
                          <button type="button" class="confirm" onclick="postModifyCategory('${category}', ${rank});">수정</button>
                          <button type="button" class="cancel" onclick="location.reload();">취소</button>
                        </div>
                      </div>
                      <div class="modalDim" onclick="location.reload();"></div>
                    </div>
                  `;
    $('#md_categoryRegister').remove();
    $('.wrap.modalView .modal').append(modal);
  }

  function postModifyCategory(category, rank) {
    try {
      const categoryList = [{
        category,
        categoryName: document.getElementById('categoryModifyName').value,
        categoryRank: rank
      }]


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
          if (result.resultCode === '0000') {
            return successModifyCategory(`${categoryList[0].categoryName}`);
          } else if (result.resultCode === '3004') {
            return validModifyCategory(`${categoryList[0].category}`, `${categoryList[0].categoryName}`, categoryList[0].categoryRank);
          }
          alert(result.resultMessage);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  function successModifyCategory(name) {
    const modal = `
                  <div class="modalWrap md_categoryRegister" id="md_categoryRegister" style="display:block;">
                      <div class="modalContainer">
                          <div class="modalTitle">
                              <p>카테고리 목록 관리 / 수정</p>
                              <button class="close modalClose" onclick="location.reload();"></button>
                          </div>
                          <div class="modalContent">
                              <div class="categoryBox">
                                  <p>${name}</p>
                                  <p>카테고리로 수정이 완료되었습니다.</p>
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

  function validModifyCategory(category, name, rank) {
    const modal = `
                  <div class="modalWrap md_categoryRegister" id="md_categoryRegister" style="display:block;">
                      <div class="modalContainer">
                          <div class="modalTitle">
                              <p>카테고리 목록 관리 / 수정</p>
                              <button class="close modalClose" onclick="location.reload();"></button>
                          </div>
                          <div class="modalContent">
                              <div class="categoryBox">
                                  <p>${name}</p>
                                  <p>은(는) 이미 등록되어 있습니다.</p>
                              </div>
                          </div>
                          <div class="modalFooter">
                            <button type="button" class="confirm" onclick="modifyCategory('${category}', '${name}', ${rank});">재입력</button>
                            <button type="button" class="cancel" onclick="location.reload();">취소</button>
                        </div>
                      </div>
                      <div class="modalDim" onclick="location.reload();"></div>
                  </div>
                  `;
    $('.wrap.modalView .modal').empty();
    $('.wrap.modalView .modal').append(modal);
  }
</script>
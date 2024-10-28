<script>
  function deleteCategory(category, categoryName) {
    const modal = `
                  <div class="modalWrap md_alert" id="md_alert" style="display:block;">
                        <div class="modalContainer">
                            <div class="modalTitle">
                                <p>카테고리 목록 관리 / 삭제</p>
                                <button class="close modalClose" onclick="location.reload();"></button>
                            </div>
                            <div class="modalContent">
                                <div class="categoryBox">
                                  <p>${categoryName}</p>
                                  <p>카테고리를 삭제 하시겠습니까?</p>
                              </div>
                            </div>
                            <div class="modalFooter">
                                <!-- 버튼 한개 사용 가능 -->
                                <button type="button" class="confirm" onclick="postDeleteCategory('${category}')">확인</button>
                                <button type="button" class="cancel" onclick="location.reload();">취소</button>
                            </div>
                        </div>
                        <div class="modalDim" onclick="location.reload();"></div>
                    </div>
                  `;
    $('#md_alert').remove();
    $('.wrap.modalView .modal').append(modal);
  }

  function postDeleteCategory(category) {
    try {
      const categoryList = [{
        category,
        categoryName: '',
        categoryRank: 0
      }]


      const requestData = {
        apiType: 'D',
        categoryList
      }

      $.ajax({
        type: 'POST',
        url: 'http://admin.shoplus.io/api/admin/category',
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
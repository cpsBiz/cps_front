<?
$sql = "SELECT CATEGORY FROM CPS_CATEGORY ORDER BY CATEGORY DESC LIMIT 1";
$stmt = mysqli_stmt_init($con);
if (mysqli_stmt_prepare($stmt, $sql)) {
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
}

$sql = "SELECT CATEGORY FROM CPS_CATEGORY ORDER BY CATEGORY DESC LIMIT 1";
$result = fetchSingleValue($con, $sql);
$LastCategory = $result ? $result['CATEGORY'] : null;
$prefix = substr($LastCategory, 0, 1);
$number = substr($LastCategory, 1);
$newNumber = intval($number) + 1;
$newCategory = $prefix . str_pad($newNumber, strlen($number), '0', STR_PAD_LEFT);


$sql = "SELECT CATEGORY_RANK FROM CPS_CATEGORY ORDER BY CAST(CATEGORY_RANK AS UNSIGNED) DESC LIMIT 1";
$result = fetchSingleValue($con, $sql);
$LastCategoryRank = $result ? $result['CATEGORY_RANK'] + 1 : null;
?>
<script>
  function addCategory() {
    const modal = `
                    <div class="modalWrap md_categoryRegister" id="md_categoryRegister" style="display:block;">
                      <div class="modalContainer">
                        <div class="modalTitle">
                          <p>카테고리 목록 관리 / 추가 등록</p>
                          <button class="close modalClose" onclick="location.reload();"></button>
                        </div>
                        <div class="modalContent">
                          <div class="inputBox">
                            <input id="categoryAddName" type="text" placeholder="신규 카테고리명을 입력해주세요">
                          </div>
                        </div>
                        <div class="modalFooter">
                          <button type="button" class="confirm" onclick="postAddCategory();">등록</button>
                          <button type="button" class="cancel" onclick="location.reload();">취소</button>
                        </div>
                      </div>
                      <div class="modalDim" onclick="location.reload();"></div>
                    </div>
                  `;
    $('#md_categoryRegister').remove();
    $('.wrap.modalView .modal').append(modal);
  }

  // 저장 i 수정 u 삭제 d
  // 마지막 카테고리키 + 1, 랭크+1
  function postAddCategory() {
    try {
      const categoryList = [{
        category: '<?= $newCategory; ?>',
        categoryName: document.getElementById('categoryAddName').value,
        categoryRank: <?= $LastCategoryRank; ?>
      }]

      if (!categoryList[0].categoryName) {
        return alert('신규 카테고리명을 입력해주세요.');
      }

      const requestData = {
        apiType: 'I',
        categoryList
      }

      $.ajax({
        type: 'POST',
        url: 'http://admin.shoplus.io/api/admin/category',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode === '0000') {
            return successAddCategory(`${categoryList[0].categoryName}`);
          } else if (result.resultCode === '3004') {
            return validAddCategory(`${categoryList[0].categoryName}`);
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

  function successAddCategory(name) {
    const modal = `
                  <div class="modalWrap md_categoryRegister" id="md_categoryRegister" style="display:block;">
                      <div class="modalContainer">
                          <div class="modalTitle">
                              <p>카테고리 목록 관리 / 추가 등록</p>
                              <button class="close modalClose" onclick="location.reload();"></button>
                          </div>
                          <div class="modalContent">
                              <div class="categoryBox">
                                  <p>${name}</p>
                                  <p>카테고리 신규 등록이 완료되었습니다.</p>
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

  function validAddCategory(name) {
    const modal = `
                  <div class="modalWrap md_categoryRegister" id="md_categoryRegister" style="display:block;">
                      <div class="modalContainer">
                          <div class="modalTitle">
                              <p>카테고리 목록 관리 / 추가 등록</p>
                              <button class="close modalClose" onclick="location.reload();"></button>
                          </div>
                          <div class="modalContent">
                              <div class="categoryBox">
                                  <p>${name}</p>
                                  <p>은(는) 이미 등록되어 있습니다.</p>
                              </div>
                          </div>
                          <div class="modalFooter">
                            <button type="button" class="confirm" onclick="addCategory();">재등록</button>
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
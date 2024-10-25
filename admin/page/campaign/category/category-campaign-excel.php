<script>
  // 엑셀 업로드 팝업
  function campaignExcelUpload() {
    const modal = `
                  <div class="modalWrap md_excelUpload" id="md_excelUpload" style="display:block;">
                    <div class="modalContainer">
                      <div class="modalTitle">
                        <p>카테고리 캠페인 관리 / 엑셀업로드</p>
                        <button class="close modalClose" onclick="location.reload();"></button>
                      </div>
                      <div class="modalContent">
                        <span>1. 현재 카테고리 엑셀 양식 <a href="#">[다운로드]</a></span>
                        <span>2. 전체 캠페인 리스트 입니다.</span>
                        <span>3. 다운로드 양식에서 순위 조정 후 아래에 업로드해 주세요.</span>
                        <div class="file-box">
                          <div class="file-info">
                            <input type="file" id="excelFile" accept=".xls, .xlsx" style="display:none;">
                            <label for="excelFile" id="fileLabel">파일을 끌어오세요 +</label>
                          </div>
                          <div class="file-list"></div>
                        </div>
                      </div>
                      <div class="modalFooter">
                        <button type="button" class="confirm" onclick="postCampaignExcelUpload();">등록</button>
                        <button type="button" class="cancel" onclick="location.reload();">취소</button>
                      </div>
                    </div>
                    <div class="modalDim" onclick="location.reload();"></div>
                  </div>
                `;

    $('.wrap.modalView .modal').empty();
    $('.wrap.modalView .modal').append(modal);

    // 파일 첨부 기능 초기화
    initializeFileUpload();
  }

  // 엑셀 데이터 전송
  function postCampaignExcelUpload() {
    try {
      failCampaignExcelUpload();
      // successCampaignExcelUpload();
    } catch (error) {
      alert(error);
    }
  }

  // 엑셀 업로드 성공시
  function successCampaignExcelUpload() {
    const modal = `
                  <div class="modalWrap md_categoryRegister" id="md_excelUpload" style="display:block;">
                      <div class="modalContainer">
                          <div class="modalTitle">
                              <p>카테고리 캠페인 관리 / 엑셀업로드</p>
                              <button class="close modalClose" onclick="location.reload();"></button>
                          </div>
                          <div class="modalContent">
                              <div class="categoryBox">
                                  <p>"@@@.xls"</p>
                                  <p>파일이 정상적으로 업로드 되었습니다.</p>
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

  // 엑셀 업로드 실패시
  function failCampaignExcelUpload() {
    const modal = `
                  <div class="modalWrap md_categoryRegister" id="md_excelUpload" style="display:block;">
                      <div class="modalContainer">
                          <div class="modalTitle">
                              <p>카테고리 캠페인 관리 / 엑셀업로드</p>
                              <button class="close modalClose" onclick="location.reload();"></button>
                          </div>
                          <div class="modalContent">
                              <div class="categoryBox">
                                  <span>파일 업로드에 실패 하였습니다.</span>
                                  <span>사유 : #############</span>
                              </div>
                          </div>
                          <div class="modalFooter">
                            <button type="button" class="confirm" onclick="campaignExcelUpload();">재 업로드</button>
                            <button type="button" class="confirm" onclick="location.reload();">취소</button>
                          </div>
                      </div>
                      <div class="modalDim" onclick="location.reload();"></div>
                  </div>
                  `;
    $('.wrap.modalView .modal').empty();
    $('.wrap.modalView .modal').append(modal);
  }

  function initializeFileUpload() {
    const $excelFile = document.querySelector('#excelFile');
    const $fileList = document.querySelector('.file-list');
    const $fileLabel = document.querySelector('#fileLabel'); // label 요소 참조

    if ($excelFile) {
      let fileData = null; // 단일 파일 저장

      function renderFileName() {
        $fileList.innerHTML = ''; // 파일 리스트 초기화
        if (fileData) {
          $fileList.innerHTML = `
                <div class="list">
                    <p class="name">${fileData.name}</p>
                    <button type="button" class="ico-close type2">X</button>
                </div>
            `;

          // 삭제 버튼 클릭 이벤트
          const $deleteButton = $fileList.querySelector('.ico-close');
          $deleteButton.addEventListener('click', () => {
            fileData = null; // 파일 데이터 초기화
            $excelFile.value = ''; // 파일 input 초기화
            renderFileName(); // 파일 리스트 업데이트
          });
        }
      }

      $excelFile.addEventListener('change', (e) => {
        const file = e.target.files[0]; // 단일 파일 선택

        if (file) {
          const validExtensions = ['.xls', '.xlsx'];
          const fileExtension = file.name
            .substring(file.name.lastIndexOf('.'))
            .toLowerCase();

          if (!validExtensions.includes(fileExtension)) {
            alert(
              `파일 첨부는 XLS 또는 XLSX만 가능합니다. ${file.name}은/는 ${fileExtension} 타입이므로 첨부할 수 없습니다.`
            );
            $excelFile.value = ''; // 유효하지 않은 경우 input 초기화
            return; // 유효하지 않은 경우 함수 종료
          }

          // 새로운 파일 선택 시 기존 파일 정보 초기화
          fileData = {
            name: file.name,
            size: file.size,
            type: file.type,
          };

          renderFileName(); // 파일 이름 및 삭제 버튼 표시
        }
      });

      // 드래그 앤 드롭 이벤트 처리
      $fileLabel.addEventListener('dragover', (e) => {
        e.preventDefault(); // 기본 동작 방지
        e.dataTransfer.dropEffect = 'copy'; // 드래그 효과 설정
        $fileLabel.classList.add('drag-over'); // 드래그 오버 시 스타일 변경
      });

      $fileLabel.addEventListener('dragleave', () => {
        $fileLabel.classList.remove('drag-over'); // 드래그 아웃 시 스타일 복원
      });

      $fileLabel.addEventListener('drop', (e) => {
        e.preventDefault(); // 기본 동작 방지
        $fileLabel.classList.remove('drag-over'); // 드래그 아웃 시 스타일 복원

        const files = e.dataTransfer.files; // 드래그 앤 드롭된 파일들

        if (files.length > 0) {
          const file = files[0]; // 첫 번째 파일만 처리

          const validExtensions = ['.xls', '.xlsx'];
          const fileExtension = file.name
            .substring(file.name.lastIndexOf('.'))
            .toLowerCase();

          if (!validExtensions.includes(fileExtension)) {
            alert(
              `파일 첨부는 XLS 또는 XLSX만 가능합니다. ${file.name}은/는 ${fileExtension} 타입이므로 첨부할 수 없습니다.`
            );
            return; // 유효하지 않은 경우 함수 종료
          }

          // 새로운 파일 선택 시 기존 파일 정보 초기화
          fileData = {
            name: file.name,
            size: file.size,
            type: file.type,
          };

          renderFileName(); // 파일 이름 및 삭제 버튼 표시

          // input 요소에 파일 설정
          const dataTransfer = new DataTransfer();
          dataTransfer.items.add(file);
          $excelFile.files = dataTransfer.files; // input 파일에 설정
        }
      });
    }
  }
</script>
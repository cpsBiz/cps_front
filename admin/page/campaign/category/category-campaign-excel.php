<script>
  // 엑셀 업로드 팝업
  function campaignExcelUpload() {
    const modal = `
                  <div class="modalWrap md_fileUpload" id="md_fileUpload" style="display:block;">
                    <div class="modalContainer">
                      <div class="modalTitle">
                        <p>카테고리 캠페인 관리 / 엑셀업로드</p>
                        <button class="close modalClose" onclick="location.reload();"></button>
                      </div>
                      <div class="modalContent">
                        <div class="guideBox">
                            <p>현재 카테고리 엑셀 양식<span onclick="excelDownload()">다운로드</span></p>
                            <p>전체 캠페인 리스트 입니다.</p>
                            <p>다운로드 양식에서 순위 조정 후 아래에 업로드해 주세요.</p>
                        </div>
                        <div class="fileBox">
                            <button type="button" class="close" id="excelClose">닫기</button>
                            <input type="file" id="excelFile" accept=".xls, .xlsx" style="display:none;" />
                            <label for="excelFile" id="fileLabel">파일을 끌어오세요</label>
                          </div>
                      </div>
                      <div class="modalFooter">
                        <button type="button" class="confirm" onclick="postCampaignExcelUpload();">업로드</button>
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
    const $fileLabel = document.querySelector('#fileLabel'); // label 요소 참조
    const $excelClose = document.getElementById('excelClose');

    if ($excelFile && $fileLabel && $excelClose) {
      let fileData = null; // 단일 파일 저장

      $excelFile.addEventListener('change', (e) => {
        const file = e.target.files[0]; // 단일 파일 선택

        if (file) {
          const validExtensions = ['.xls', '.xlsx'];
          const fileExtension = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();

          if (!validExtensions.includes(fileExtension)) {
            alert(`파일 첨부는 XLS 또는 XLSX만 가능합니다. ${file.name}은/는 ${fileExtension} 타입이므로 첨부할 수 없습니다.`);
            $excelFile.value = ''; // 유효하지 않은 경우 input 초기화
            return; // 유효하지 않은 경우 함수 종료
          }

          $fileLabel.innerHTML = file.name;

          // 새로운 파일 선택 시 기존 파일 정보 초기화
          fileData = {
            name: file.name,
            size: file.size,
            type: file.type,
          };
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
          const fileExtension = file.name.substring(file.name.lastIndexOf('.')).toLowerCase();

          if (!validExtensions.includes(fileExtension)) {
            alert(`파일 첨부는 XLS 또는 XLSX만 가능합니다. ${file.name}은/는 ${fileExtension} 타입이므로 첨부할 수 없습니다.`);
            return; // 유효하지 않은 경우 함수 종료
          }

          // 새로운 파일 선택 시 기존 파일 정보 초기화
          fileData = {
            name: file.name,
            size: file.size,
            type: file.type,
          };

          // input 요소에 파일 설정
          const dataTransfer = new DataTransfer();
          dataTransfer.items.add(file);
          $excelFile.files = dataTransfer.files; // input 파일에 설정

          // 라벨에 파일 이름 표시
          $fileLabel.innerHTML = file.name;
        }
      });

      // 파일 제거 버튼 이벤트
      $excelClose.addEventListener('click', () => {
        fileData = null; // 파일 데이터 초기화
        $excelFile.value = ''; // 파일 input 초기화
        $fileLabel.innerHTML = '파일을 끌어오세요'; // 라벨 초기화
      });
    }
  }


  function excelDownload() {
    try {
      $.ajax({
        url: '/page/campaign/category/api/download-excel.php',
        type: 'GET',
        contentType: 'application/json',
        xhrFields: {
          responseType: 'blob' // 바이너리 데이터를 받기 위한 설정
        },
        success: function(data) {
          const blob = new Blob([data], {
            type: 'application/zip'
          });
          const link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = 'download.zip';
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Error: ' + textStatus + ' - ' + errorThrown);
          alert('파일 다운로드 중 에러가 발생했습니다. 다시 시도해 주세요.');
        }
      });
    } catch (error) {
      alert('예외가 발생했습니다: ' + error.message);
    }
  }
</script>
<link type="text/css" rel="stylesheet" href="./reportModal.css">

<style>
 
</style>
<div class="modal" id="myModal">
  <div class="modal-background" onclick="closeModal()"></div>
  <div class="modal-content">
    <section class="modal-sec_list">
      <div class="modal-tableHeader">
        <div class="modal-headerTop">
          <div class="modal-tableTitle">
              <p>요약 리포트<span>일별</span></p>
          </div>
          <span class="close-modal" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-filterArea">
          <div class="modal-optionBox">
              <div>
                  <div class="modal-calendarBox">
                      <div class="modal-calendar">
                          <input type="text" id="modal-dateInput" name=dateInput" value="">
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-selectBox">
              <select id="modal-size">
                  <option value="10">10개씩 보기</option>
                  <option value="20">20개씩 보기</option>
                  <option value="40" selected>40개씩 보기</option>
                  <option value="60">60개씩 보기</option>
                  <option value="100">100개씩 보기</option>
              </select>
          </div>
        </div>
      </div>
      <div class="modal-tableArea">
        <div class="modal-tableBox modal-selectDay">
            <table>
                <thead id="modal-reportHead">
                    <tr>
                        <th id="modal-searchTypeTitle" class="modal-sortDown">날짜</th>
                        <th class="modal-sort">노출수</th>
                        <th class="modal-sort">클릭수</th>
                        <th class="modal-sort">건수</th>
                        <th class="modal-sort">전환율</th>
                        <th class="modal-sort">구매액</th>
                        <th class="modal-sort">커미션 매출</th>
                        <th class="modal-sort">커미션 이익</th>
                    </tr>
                </thead>
                <tbody id="modal-reportData">

                </tbody>
            </table>
        </div>
        <div class="modal-tableDataNone" style="display: none;">
          <div>
              <p>내용이 없습니다. </p>
          </div>
        </div>
        <div class="modal-paging">
          <ul></ul>
        </div>
      </div>
    </section>
  </div>
</div>
<script>
  // 모달 열기
  const modal = document.getElementById("myModal");

   // API 응답 처리 및 데이터 렌더링
   function modalHandleSuccessResponse(data, size, page, modalSearchType) {
        // 데이터가 없는 경우 UI 처리
        const tableBoxes = document.querySelectorAll('.modal-tableBox');
        const paging = document.querySelector('.modal-paging');
        const tableDataNone = document.querySelector('.modal-tableDataNone');

        if (data.totalCount === 0) {
            hideElements([...tableBoxes, paging]);
            tableDataNone.style.display = 'block';
            return;
        }

        // 데이터가 있는 경우 UI 처리
        showElements([...tableBoxes, paging]);
        tableDataNone.style.display = 'none';

        // 데이터 렌더링 및 페이지네이션 설정
        reportModalOpen(data, modalSearchType);
        renderPagination(data.totalCount, size, page, true);
    }

  function reportModalOpen(data, modalSearchType) {
    // 모달 첫번째 행 키워드 타이틀 설정
    setTitle(true);

    // 모달 합계 데이터처리
    renderSumRow(data, true)

    // 모달 데이터 리스트 처리
    renderTableRows(data.datas, true, modalSearchType);

    modal.style.display = "block";
  }

  function getReportModalFilterData(){
    console.log('모달데이터 요청');
  }

  function closeModal(){
    modal.style.display = "none";
  }

  // 상세보기 모달 닫을때 데이터 렌더링 초기화
  function reportModalReset(){
    document.getElementById('modal-reportData').innerHTML = '';
    document.querySelector('.modal-paging > ul').innerHTML = '';
  }
</script>

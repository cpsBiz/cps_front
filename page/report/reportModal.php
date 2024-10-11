<style>
  .modal {
    display: none;
    position: fixed;
    z-index: 10;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
  }

  .modal-content {
    background-color: white;
    padding: 20px;
    margin: 15%;
  }
</style>
<div id="myModal" class="modal">
  <div class="modal-content" id="modal-content">
    <span id="close-modal" style="cursor:pointer;">&times;</span>
    <div id="modal-body">
          <div class="modal-content">
          <section class="modal-sec_list">
              <div class="modal-optionBox">
                  <div>
                      <div class="modal-calendarBox">
                          <div class="modal-calendar">
                              <input type="text" id="modal-dateInput" name="modal-dateInput" value="">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-tableHeader">
                  <div class="modal-tableTitle">
                      <p>요약 리포트<span>일별</span></p>
                      <!-- <p>상세 리포트</p> -->
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
              <!--// 내용이 없을 때 tableWrap & tableAreaDataNone 함께 사용 -->
              <!-- <div class="tableArea tableAreaDataNone"> -->
              <div class="modal-tableArea">
                  <!-- table 스크롤 생기게 하고 싶을 때 tableBox 에 높이값(max-height) 추가-->
                  <!-- 상세리포트 테이블과 요약리포트 테이블은 tableBox에 selectDay, selectDetail 클래스로 구분함  >> 퍼블확인을 위해 tableBox 두개 추가한 부분이므로 개발할때는 한개만 사용하고 클래스로 구분하면 됩니다. -->
                  <!-- 요약리포트 selectDay -->
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
  </div>
</div>
<script>
  // 모달 열기
  const modal = document.getElementById("myModal");
  const modalBody = document.getElementById("modal-body");
  const closeModal = document.getElementById("close-modal");

   // API 응답 처리 및 데이터 렌더링
   function modalHandleSuccessResponse(data, size, page) {
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
        reportModalOpen(data);
        renderPagination(data.totalCount, size, page, true);
    }

  function reportModalOpen(data) {
    // 모달 첫번째 행 키워드 타이틀 설정
    setTitle(true);

    // 모달 합계 데이터처리
    renderSumRow(data, true)

    // 모달 데이터 리스트 처리
    renderTableRows(data.datas, true);

    modal.style.display = "block";
  }

  function getReportModalFilterData(){

  }

  // 모달 닫기
  closeModal.onclick = function() {
    modal.style.display = "none";
  }

  // 모달 외부를 클릭하면 모달 닫기
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>

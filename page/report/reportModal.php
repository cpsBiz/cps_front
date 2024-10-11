<div id="myModal" class="modal">
  <div class="modal-content" id="modal-content">
    <span id="close-modal" style="cursor:pointer;">&times;</span>
    <div id="modal-body">
          <div class="content">
          <section class="sec_list">
              <div class="optionBox">
                  <div>
                      <div class="calendarBox">
                          <div class="calendar">
                              <input type="text" id="dateInput" name="dateInput" value="">
                          </div>
                      </div>
                  </div>
              </div>
              <div class="tableHeader">
                  <div class="tableTitle">
                      <p>요약 리포트<span>일별</span></p>
                      <!-- <p>상세 리포트</p> -->
                  </div>
                  <div class="selectBox">
                      <select id="size">
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
              <div class="tableArea">
                  <!-- table 스크롤 생기게 하고 싶을 때 tableBox 에 높이값(max-height) 추가-->
                  <!-- 상세리포트 테이블과 요약리포트 테이블은 tableBox에 selectDay, selectDetail 클래스로 구분함  >> 퍼블확인을 위해 tableBox 두개 추가한 부분이므로 개발할때는 한개만 사용하고 클래스로 구분하면 됩니다. -->
                  <!-- 요약리포트 selectDay -->
                  <div class="tableBox selectDay">
                      <table>
                          <thead id="reportHead">
                              <tr>
                                  <th id="searchTypeTitle" class="sortDown">날짜</th>
                                  <th class="sort">노출수</th>
                                  <th class="sort">클릭수</th>
                                  <th class="sort">건수</th>
                                  <th class="sort">전환율</th>
                                  <th class="sort">구매액</th>
                                  <th class="sort">커미션 매출</th>
                                  <th class="sort">커미션 이익</th>
                              </tr>
                          </thead>
                          <tbody id="reportData">

                          </tbody>
                      </table>
                  </div>

                  <div class="tableDataNone">
                      <div>
                          <p>내용이 없습니다. </p>
                      </div>
                  </div>
                  <div class="paging">
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

  function reportModal(data) {
    console.log(data)
    modal.style.display = "block";
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
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
  }
</style>
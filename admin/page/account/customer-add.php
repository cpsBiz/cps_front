<script>
  // 회원 추가 팝업 
  function addCustomer() {
    const modal = `
                  <div class="modalWrap md_customerRegister" id="md_customerRegister" style="display:block;">
                    <div class="modalContainer">
                      <div class="modalTitle">
                        <p>회원 / 추가등록</p>
                        <button class="close modalClose"></button>
                      </div>
                      <div class="modalContent">
                        <section class="sec_list">
                          <div>
                            <p>아이디/비밀번호</p>
                            <div class="idBox">
                              <!-- 아이디 수정의 경우 조회 버튼 삭제 후 사용하면 됩니다.-->
                              <input type="text" placeholder="아이디 (6자리 이상)" />
                              <button type="button" class="search">조회</button>
                            </div>
                            <input type="password" placeholder="비밀번호(영문, 숫자 조합 8자리 이상)" />
                            <input type="password" placeholder="비밀번호 재입력" />
                          </div>
                          <div>
                            <p>회원 유형</p>
                            <select id="selectUserType1" onchange="selectUserType1()">
                              <option value="" selected disabled>회원유형1</option>
                              <option value="MERCHANT">광고주</option>
                              <option value="AFFLIATE">매체</option>
                              <option value="MERCHANTAGC">광고주대행사</option>
                              <option value="AFFLIATEAGC">매체대행사</option>
                            </select>
                            <select id="selectUserType2" onchange="selectUserType2()">
                              <option value="" selected disabled>회원유형2</option>
                              <option value="PERSONAL">개인</option>
                              <option value="BUSINESS">사업자</option>
                            </select>
                          </div>
                          <div>
                            <p>대행사 선택</p>
                            <div class="checkBox">
                              <input type="checkbox" name="" id="" />
                              <label for="">*해당사항 없음</label>
                            </div>
                            <div class="searchBox">
                              <input type="text" placeholder="대행사명" />
                              <button type="button" class="search">조회</button>
                            </div>
                          </div>
                          <div id="personal-user" class="user-info-box userType" style="display:none;">
                            <div>
                              <p>개인 정보</p>
                              <input type="text" placeholder="이름" />
                              <input type="text" placeholder="이메일" />
                              <input type="text" placeholder="연락처 (휴대폰)" />
                              <input type="text" placeholder="출생년도 (숫자 4자리)" />
                              <select name="" id="">
                                <option value="" selected disabled>성별</option>
                                <option value="">남</option>
                                <option value="">여</option>
                              </select>
                            </div>
                            <div>
                              <p>주민등록증 등록</p>
                              <div class="fileBox">
                                <button type="button" class="close">닫기</button>
                                <input type="file" name="" id="" />
                                <label for="">파일을 끌어오세요</label>
                              </div>
                            </div>
                          </div>
                          <div id="business-user" class="user-info-box userType" style="display:none;">
                            <div>
                              <p>사업자 정보</p>
                              <input type="text" placeholder="업체(법인)명" />
                              <input type="text" placeholder="대표자명" />
                              <input type="text" placeholder="사업자등록번호" />
                              <input type="text" placeholder="사업장 소재지 (사업자등록증 기준)" />
                              <input type="text" placeholder="업태" />
                              <input type="text" placeholder="종목" />
                            </div>
                            <div>
                              <p>담당자 정보</p>
                              <input type="text" placeholder="담당자명" />
                              <input type="text" placeholder="담당자 이메일" />
                              <input type="text" placeholder="담당자 연락처 (휴대폰)" />
                              <input type="text" placeholder="대표전화" />
                            </div>
                            <div>
                              <p>사업자등록증 등록</p>
                              <div class="fileBox">
                                <button type="button" class="close">닫기</button>
                                <input type="file" name="" id="" />
                                <label for="">파일을 끌어오세요</label>
                              </div>
                            </div>
                          </div>
                          <div>
                            <p>은행정보</p>
                            <div class="checkBox">
                              <input type="checkbox" name="" id="" />
                              <label for="">*해당사항 없음</label>
                            </div>
                            <input type="text" placeholder="예금주명" />
                            <input type="text" placeholder="은행명" />
                          </div>
                          <div id="affliate-user" class="affliate-info-box" style="display:none;">
                            <div id="site-list" class="site-info-box">
                              <div>
                                <p>사이트등록1</p>
                                <input type="text" placeholder="사이트명" />
                                <input type="text" placeholder="URL" />
                                <select name="" id="">
                                  <option value="" selected disabled>카테고리 선택</option>
                                </select>
                              </div>
                            </div>
                            <button type="button" class="siteAdd">사이트 추가</button>
                          </div>
                        </section>
                      </div>
                      <div class="modalFooter">
                        <button type="button" class="confirm">등록</button>
                        <button type="button" class="cancel">취소</button>
                      </div>
                    </div>
                    <div class="modalDim"></div>
                  </div>
                  `;
    $('.wrap.modalView .modal').empty();
    $('.wrap.modalView .modal').append(modal);
  }

  // 회원 추가 검증 및 데이터 객체 생성 
  function validAddCustomer() {

    postAddCustomer(data);
  }

  // 회원 추가 요청
  function postAddCustomer(data) {
    try {
      const requestData = {};

    } catch (error) {
      alert(error);
    }
  }

  // 회원 추가 성공시
  function successAddCustomer() {

  }

  // 회원 유형1 선택시 영역
  function selectUserType1() {
    const type = document.getElementById('selectUserType1').value;

    $('#affliate-user').hide();

    if (type === 'AFFLIATE') {
      $('#affliate-user').show();
    }
  }

  // 회원 유형2 선택시 영역
  function selectUserType2() {
    const type = document.getElementById('selectUserType2').value;

    $('.userType').hide();

    if (type === 'PERSONAL') {
      $('#personal-user').show();
    } else if (type === 'BUSINESS') {
      $('#business-user').show();
    }
  }
</script>
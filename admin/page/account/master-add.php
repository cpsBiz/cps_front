<script>
  // 관리자 추가 팝업 
  function addMaster() {
    const modal = `
                  <div class="modalWrap md_managerRegister" id="md_managerRegister" style="display:block;">
                    <div class="modalContainer">
                        <div class="modalTitle">
                            <p>회원 / 관리자 추가등록</p>
                            <button class="close modalClose" onclick="location.reload()"></button>
                        </div>
                        <div class="modalContent">
                          <section class="sec_list">
                            <div>
                              <p>아이디 / 비밀번호</p>
                              <div class="idBox">
                                <input id="master-id" type="text" placeholder="아이디 (6자리 이상)" />
                                <button class="search" onclick="searchMasterId()">조회</button>
                              </div>
                              <input id="master-pwd" type="password" placeholder="비밀번호(영문, 숫자 조합 8자리 이상)" />
                              <input id="master-pwd-re" type="password" placeholder="비밀번호 재입력" />
                            </div>
                            <div>
                              <p>관리자 정보</p>
                              <input id="master-dept" type="text" placeholder="부서" />
                              <input id="master-team" type="text" placeholder="팀" />
                              <input id="master-name" type="text" placeholder="이름" />
                              <input id="master-email" type="text" placeholder="이메일" />
                              <input id="master-phone" type="text" placeholder="연락처1" />
                              <input id="master-phone2" type="text" placeholder="연락처2" />
                            </div>
                          </section>
                        </div>
                        <div class="modalFooter">
                            <button type="button" class="save" onclick="validAddMaster()">등록</button>
                            <button type="button" class="cancel" onclick="location.reload()">취소</button>
                        </div>
                    </div>
                    <div class="modalDim" onclick="location.reload()"></div>
                </div>
                `;
    $('.wrap.modalView .modal').empty();
    $('.wrap.modalView .modal').append(modal);
  }

  // 관리자 추가 검증 및 데이터 객체 생성 
  let checkSerachId = false;

  function validAddMaster() {
    const id = document.getElementById('master-id').value;
    if (!id) return alert('아이디를 입력해 주세요.');
    if (id.length < 6) return alert('아이디를 6자리 이상 입력해 주세요.');
    if (!checkSerachId) return alert('아이디를 조회해 주세요.');

    const pwd = document.getElementById('master-pwd').value;
    if (!validatePassword(pwd)) return alert('비밀번호는 영문과 숫자를 포함하여 8자리 이상되어야 합니다.');
    const pwdRe = document.getElementById('master-pwd-re').value;
    if (pwd !== pwdRe) return alert('재입력한 비밀번호가 일치하지 않습니다.');

    const dept = document.getElementById('master-dept').value;
    if (!dept) return alert('부서를 입력해 주세요.');

    const team = document.getElementById('master-team').value;
    if (!team) return alert('팀을 입력해 주세요.');

    const name = document.getElementById('master-name').value;
    if (!name) return alert('이름을 입력해 주세요.');

    const email = document.getElementById('master-email').value;
    if (!email) return alert('이메일을 입력해 주세요.');

    const phone = document.getElementById('master-phone').value;
    if (!phone) return alert('연락처1을 입력해 주세요.');

    const phone2 = document.getElementById('master-phone2').value;
    if (!phone2) return alert('연락처2를 입력해 주세요.');

    const data = {
      apiType: 'I',
      memberId: id,
      memberPw: pwd,
      dept,
      team,
      managerName: name,
      managerEmail: email,
      companyPhone: phone,
      companyPhoneSub: phone2,
      type: 'MASTER'
    }

    postAddMaster(JSON.stringify(data));
  }

  function validatePassword(password) {
    const regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    return regex.test(password);
  }

  function searchMasterId() {
    try {
      const id = document.getElementById('master-id').value;
      if (!id) return alert('아이디를 입력해 주세요.');
      if (id.length < 6) return alert('아이디를 6자리 이상 입력해 주세요.');

      $.ajax({
        type: 'GET',
        url: '/admin/page/account/api/select-search-id.php',
        contentType: 'application/json',
        dataType: 'JSON',
        data: {
          id
        },
        success: function(result) {
          alert(result.resultMessage);
          if (result.resultCode !== 'success') {
            document.getElementById('master-id').value = '';
            $('#master-id').focus();
            checkSerachId = false;
            return;
          }
          checkSerachId = true;
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }

  }

  // 관리자 추가 요청
  function postAddMaster(data) {
    try {
      $.ajax({
        type: 'POST',
        url: 'https://admin.shoplus.io/api/admin/memberSignIn',
        contentType: 'application/json',
        dataType: 'JSON',
        data: requestData,
        success: function(result) {
          if (result.resultCode !== '0000') return alert(result.resultMessage);
          successAddMaster();
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });

    } catch (error) {
      alert(error);
    }
  }

  function successAddMaster() {
    const modal = `
                  <div class="modalWrap md_categoryRegister" id="md_categoryRegister" style="display:block;">
                      <div class="modalContainer">
                          <div class="modalTitle">
                              <p>회원 / 관리자 추가등록</p>
                              <button class="close modalClose" onclick="location.reload();"></button>
                          </div>
                          <div class="modalContent">
                              <div class="categoryBox">
                                  <p>관리자 추가 등록이 완료되었습니다.</p>
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
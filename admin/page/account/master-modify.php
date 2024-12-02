<script>
  // 관리자 수정 팝업
  function modifyMaster(id) {
    if (!id) return alert('잘못된 접근입니다.');
    try {
      const requestData = {
        memberId: id
      }

      $.ajax({
        type: 'POST',
        url: '<?= $adminApiUrl; ?>/page/account/api/memberDetail.php',
        contentType: 'application/json',
        dataType: 'JSON',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') return alert(result.resultMessage);
          renderModifyMaster(JSON.stringify(result.data));
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  function renderModifyMaster(data) {
    const item = JSON.parse(data);

    const modal = `
                  <div class="modalWrap md_managerRegister" id="md_managerRegister" style="display:block;">
                    <div class="modalContainer">
                        <div class="modalTitle">
                            <p>관리자 / 수정</p>
                            <button class="close modalClose" onclick="location.reload()"></button>
                        </div>
                        <div class="modalContent">
                          <section class="sec_list">
                            <div>
                              <p>아이디 / 비밀번호</p>
                              <div class="idBox">
                                <input id="master-id" type="text" placeholder="아이디 (6자리 이상)" value="${item.memberId}" disabled/>
                              </div>
                              <input id="master-pwd" type="password" placeholder="비밀번호 (영문, 숫자 조합 8자리 이상)" value="${item.memberPw}" />
                              <input id="master-pwd-re" type="password" placeholder="비밀번호 재입력" value="${item.memberPw}" />
                            </div>
                            <div>
                              <p>관리자 정보</p>
                              <input id="master-dept" type="text" placeholder="부서" value="${item.dept ? item.dept : ''}" />
                              <input id="master-team" type="text" placeholder="팀" value="${item.team ? item.team : ''}" />
                              <input id="master-name" type="text" placeholder="이름" value="${item.managerName ? item.managerName : ''}" />
                              <input id="master-email" type="text" placeholder="이메일" value="${item.managerEmail ? item.managerEmail : ''}" />
                              <input id="master-phone" type="text" placeholder="연락처1" value="${item.companyPhone ? item.companyPhone : ''}" />
                              <input id="master-phone2" type="text" placeholder="연락처2" value="${item.companyPhoneSub ? item.companyPhoneSub: ''}" />
                            </div>
                          </section>
                        </div>
                        <div class="modalFooter">
                            <button type="button" class="save" onclick="validModifyMaster()">수정</button>
                            <button type="button" class="cancel" onclick="location.reload()">취소</button>
                        </div>
                    </div>
                    <div class="modalDim" onclick="location.reload()"></div>
                </div>
                `;
    $('.wrap.modalView .modal').empty();
    $('.wrap.modalView .modal').append(modal);
  }

  // 관리자 수정 검증 및 데이터 객체 생성 
  function validModifyMaster() {
    const id = document.getElementById('master-id').value;

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
      apiType: 'U',
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

    postModifyMaster(JSON.stringify(data));
  }

  // 관리자 수정 요청
  function postModifyMaster(data) {
    try {
      $.ajax({
        type: 'POST',
        url: '<?= $adminApiUrl; ?>/page/account/api/memberSignIn.php',
        contentType: 'application/json',
        dataType: 'JSON',
        data,
        success: function(result) {
          if (result.resultCode !== '0000') return alert(result.resultMessage);
          successModifyMaster();
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });

    } catch (error) {
      alert(error);
    }
  }

  function successModifyMaster() {
    const modal = `
                  <div class="modalWrap md_categoryRegister" id="md_categoryRegister" style="display:block;">
                      <div class="modalContainer">
                          <div class="modalTitle">
                              <p>관리자 / 수정</p>
                              <button class="close modalClose" onclick="location.reload();"></button>
                          </div>
                          <div class="modalContent">
                              <div class="categoryBox">
                                  <p>관리자 수정이 완료되었습니다.</p>
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
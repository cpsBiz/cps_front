<script>
  // 회원 추가 팝업 
  function addCustomer() {
    const modal = `
                  <div class="modalWrap md_customerRegister" id="md_customerRegister" style="display:block;">
                    <div class="modalContainer">
                      <div class="modalTitle">
                        <p>회원 / 추가등록</p>
                        <button class="close modalClose" onclick="location.reload()"></button>
                      </div>
                      <div class="modalContent">
                        <section class="sec_list">
                          <div>
                            <p>아이디/비밀번호</p>
                            <div class="idBox">
                              <input id="customer-id" type="text" placeholder="아이디 (6자리 이상)" />
                              <button type="button" class="search" onclick="searchCustomerId()">조회</button>
                            </div>
                            <input id="customer-pwd" type="password" placeholder="비밀번호(영문, 숫자 조합 8자리 이상)" />
                            <input id="customer-pwd-re" type="password" placeholder="비밀번호 재입력" />
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
                              <input type="checkbox" id="agencyNone" onchange="checkedAgencyNone()" />
                              <label for="agencyNone">*해당사항 없음</label>
                            </div>
                            <div class="searchBox">
                              <input id="agencyName" type="text" placeholder="대행사명" />
                              <button id="searchAgencyBtn" type="button" class="search">조회</button>
                            </div>
                          </div>
                          <div id="personal-user" class="user-info-box userType" style="display:none;">
                            <div>
                              <p>개인 정보</p>
                              <input id="customer-personal-name" type="text" placeholder="이름" onchange="insertDepositor()"/>
                              <input id="customer-personal-email" type="text" placeholder="이메일" />
                              <input id="customer-personal-phone" type="text" placeholder="연락처 (휴대폰)" />
                              <input id="customer-personal-birth" type="number" maxlength="4" placeholder="출생년도 (숫자 4자리)" />
                              <select id="customer-personal-sex">
                                <option value="" selected disabled>성별</option>
                                <option value="">남</option>
                                <option value="">여</option>
                              </select>
                            </div>
                            <div>
                              <p>주민등록증 등록</p>
                              <div class="fileBox">
                                <button type="button" class="close">닫기</button>
                                <input type="file" name="" id="customer-personal-doc" />
                                <label for="">파일을 끌어오세요</label>
                              </div>
                            </div>
                          </div>
                          <div id="business-user" class="user-info-box userType" style="display:none;">
                            <div>
                              <p>사업자 정보</p>
                              <input id="customer-business-company-name" type="text" placeholder="업체(법인)명" />
                              <input id="customer-business-company-ceo-name" type="text" placeholder="대표자명" onchange="insertDepositor()"/>
                              <input id="customer-business-company-license" type="text" placeholder="사업자등록번호" />
                              <input id="customer-business-company-location" type="text" placeholder="사업장 소재지 (사업자등록증 기준)" />
                              <input id="customer-business-company-type1" type="text" placeholder="업태" />
                              <input id="customer-business-company-type2" type="text" placeholder="종목" />
                            </div>
                            <div>
                              <p>담당자 정보</p>
                              <input id="customer-business-manager-name" type="text" placeholder="담당자명" />
                              <input id="customer-business-manager-email" type="text" placeholder="담당자 이메일" />
                              <input id="customer-business-manager-phone" type="text" placeholder="담당자 연락처 (휴대폰)" />
                              <input id="customer-business-hunting-line" type="text" placeholder="대표전화" />
                            </div>
                            <div>
                              <p>사업자등록증 등록</p>
                              <div class="fileBox">
                                <button type="button" class="close">닫기</button>
                                <input type="file" id="customer-business-doc" />
                                <label for="">파일을 끌어오세요</label>
                              </div>
                            </div>
                          </div>
                          <div>
                            <p>은행정보</p>
                            <div class="checkBox">
                              <input type="checkbox" id="bankNone" onchange="checkedBankNone()"/>
                              <label for="bankNone">*해당사항 없음</label>
                            </div>
                            <input id="depositor" type="text" placeholder="예금주명" disabled/>
                            <input id="bank" type="text" placeholder="은행명" />
                          </div>
                          <div id="affliate-user" class="affliate-info-box" style="display:none;">
                            <div id="site-list" class="site-info-box">
                              <div id="site-card1">
                                <p>사이트등록</p>
                                <input type="text" placeholder="사이트명" />
                                <input type="text" placeholder="URL" />
                                <select name="" id="">
                                  <option value="" selected disabled>카테고리 선택</option>
                                  <?
                                  $sql = "
                                    SELECT
                                      A.CATEGORY,
                                      A.CATEGORY_NAME
                                    FROM CPS_CATEGORY A
                                    LEFT JOIN CPS_CAMPAIGN B ON B.CATEGORY = A.CATEGORY 
                                    GROUP BY A.CATEGORY
                                    ORDER BY CAST(CATEGORY_RANK AS UNSIGNED) ASC
                                    ";

                                  $stmt = mysqli_stmt_init($con);
                                  if (mysqli_stmt_prepare($stmt, $sql)) {
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                  ?>
                                   <option value="<?= $row['CATEGORY']; ?>"><?= $row['CATEGORY_NAME']; ?></option>
                                  <?
                                    }
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <button type="button" class="siteAdd" onclick="addAffliateSite()">사이트 추가</button>
                          </div>
                        </section>
                      </div>
                      <div class="modalFooter">
                        <button type="button" class="confirm" onclick="validAddCustomer()">등록</button>
                        <button type="button" class="cancel" onclick="location.reload()">취소</button>
                      </div>
                    </div>
                    <div class="modalDim" onclick="location.reload()"></div>
                  </div>
                  `;
    $('.wrap.modalView .modal').empty();
    $('.wrap.modalView .modal').append(modal);
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

  // 회원유형2에 맞춰서 예금주명 업데이트
  function insertDepositor() {
    const userType = document.getElementById('selectUserType2').value;
    if (!userType) return;

    const checkedBankNone = document.getElementById('bankNone').checked;
    if (checkedBankNone) return;

    let name = '';
    if (userType === 'PERSONAL') {
      name = document.getElementById('customer-personal-name').value;
    } else if (userType === 'BUSINESS') {
      name = document.getElementById('customer-business-company-ceo-name').value;
    } else {
      return;
    }

    document.getElementById('depositor').value = name;
  }

  // 대행사 선택 해당없음
  function checkedAgencyNone() {
    const checked = document.getElementById('agencyNone').checked;
    if (checked) {
      // 대행사명 초기화 후 입력불가
      document.getElementById('agencyName').value = '';
      document.getElementById('agencyName').disabled = true;
      // 대행사명 조회 버튼 클릭불가
      document.getElementById('searchAgencyBtn').disabled = true;
    } else {
      // 대행사명 입력허용
      document.getElementById('agencyName').disabled = false;
      // 대항사명 조회 버튼 클릭허용
      document.getElementById('searchAgencyBtn').disabled = false;
    }
  }

  // 은행정보 해당없음
  function checkedBankNone() {
    const checked = document.getElementById('bankNone').checked;
    if (checked) {
      // 예금주명, 은행명 초기화
      document.getElementById('depositor').value = '';
      document.getElementById('bank').value = '';
      // 은행명 입력불가
      document.getElementById('bank').disabled = true;
    } else {
      // 은행명 입력허용
      document.getElementById('bank').disabled = false;
    }
  }

  // 매체 사이트 추가
  function addAffliateSite() {
    const cardId = document.getElementById('site-list').childElementCount + 1;
    const card = `
                  <div id="site-card${cardId}">
                    <p>사이트등록<button class="remove-site-btn" onclick="removeAffliateSite(${cardId})">삭제</button></p>
                    <input type="text" placeholder="사이트명" />
                    <input type="text" placeholder="URL" />
                    <select id="site-category">
                      <option value="" selected disabled>카테고리 선택</option>
                      <?
                      $sql = "
                              SELECT
                                A.CATEGORY,
                                A.CATEGORY_NAME
                              FROM CPS_CATEGORY A
                              LEFT JOIN CPS_CAMPAIGN B ON B.CATEGORY = A.CATEGORY 
                              GROUP BY A.CATEGORY
                              ORDER BY CAST(CATEGORY_RANK AS UNSIGNED) ASC
                              ";

                      $stmt = mysqli_stmt_init($con);
                      if (mysqli_stmt_prepare($stmt, $sql)) {
                        mysqli_stmt_execute($stmt);
                        $result = mysqli_stmt_get_result($stmt);

                        while ($row = mysqli_fetch_assoc($result)) {
                      ?>
                        <option value="<?= $row['CATEGORY']; ?>"><?= $row['CATEGORY_NAME']; ?></option>
                      <?
                        }
                      }
                      ?>
                    </select>
                  </div>
                  `;
    $('#site-list').append(card);
  }

  // 매체 사이트 삭제
  function removeAffliateSite(id) {
    $(`#site-card${id}`).remove();
  }

  // 회원 추가 검증 및 데이터 객체 생성 
  let checkSerachCustomerId = false;

  function validAddCustomer() {
    const id = document.getElementById('customer-id').value;
    if (!id) return alert('아이디를 입력해 주세요.');
    if (id.length < 6) return alert('아이디를 6자리 이상 입력해 주세요.');
    if (!checkSerachCustomerId) return alert('아이디를 조회해 주세요.');

    const pwd = document.getElementById('customer-pwd').value;
    if (!validatePassword(pwd)) return alert('비밀번호는 영문과 숫자를 포함하여 8자리 이상되어야 합니다.');
    const pwdRe = document.getElementById('customer-pwd-re').value;
    if (pwd !== pwdRe) return alert('재입력한 비밀번호가 일치하지 않습니다.');

    const type1 = document.getElementById('selectUserType1').value;
    if (!type1) return alert('회원유형1을 선택해 주세요.');

    const type2 = document.getElementById('selectUserType2').value;
    if (!type2) return alert('회원유형2를 선택해 주세요.');

    // 대행사 선택 검증
    const agencyNone = document.getElementById('agencyNone').checked;
    if (!agencyNone) {
      const agency = document.getElementById('agencyName').value;
      if (!agency) return alert('대행사명을 입력해 주세요.');
    }

    if (type2 === 'PERSONAL') { // 개인 검증
      const name = document.getElementById('customer-personal-').value;
      if (!name) return alert('이름을 입력해 주세요.');

      const email = document.getElementById('customer-personal-email').value;
      if (!email) return alert('이메일을 입력해 주세요.');

      const phone = document.getElementById('customer-personal-phone').value;
      if (!phone) return alert('연락처 (휴대폰)을 입력해 주세요.');

      const birth = document.getElementById('customer-personal-birth').value;
      if (!birth || birth.length !== 4) return alert('출생년도 (숫자 4자리)를 입력해 주세요.');

      const sex = document.getElementById('customer-personal-sex').value;
      if (!sex) return alert('성별을 선택해 주세요.');

      // 주민등록증 처리 필요
      const personalDoc = '';
      if (!personalDoc) return alert('주민등록증을 등록해 주세요.');

    } else if (type2 === 'BUSINESS') { // 사업자 검증
      const companyName = document.getElementById('cusotmer-business-company-name').value;
      if (!companyName) return alert('업체(법인)명을 입력해 주세요.');

      const companyCeoName = document.getElementById('cusotmer-business-company-ceo-name').value;
      if (!companyCeoName) return alert('대표자명을 입력해 주세요.');

      const companyLicense = document.getElementById('cusotmer-business-company-license').value;
      if (!companyLicense) return alert('사업자등록번호를 입력해 주세요.');

      const companyLocation = document.getElementById('cusotmer-business-company-location').value;
      if (!companyLocation) return alert('사업장 소재지 (사업자등록증 기준)를 입력해 주세요.');

      const companyType1 = document.getElementById('cusotmer-business-company-type1').value;
      if (!companyType1) return alert('업태를 입력해 주세요.');

      const companyType2 = document.getElementById('cusotmer-business-company-type2').value;
      if (!companyType2) return alert('종목을 입력해 주세요.');

      const managerName = document.getElementById('cusotmer-business-manager-name').value;
      if (!managerName) return alert('담당자명을 입력해 주세요.');

      const managerEmail = document.getElementById('cusotmer-business-manager-email').value;
      if (!managerEmail) return alert('담당자 이메일을 입력해 주세요.');

      const managerPhone = document.getElementById('cusotmer-business-manager-phone').value;
      if (!managerPhone) return alert('담당자 연락처 (휴대폰)를 입력해 주세요.');

      const huntingLine = document.getElementById('cusotmer-business-hunting-line').value;
      if (!huntingLine) return alert('대표전화를 입력해 주세요.');

      // 사업자등록증 처리 필요
      const businessDoc = '';
      if (!businessDoc) return alert('사업자등록증을 등록해 주세요.');
    }

    // 사이트 추가등록 검증
    if (type1 === 'AFFLIATE') {

    }

    // 은행 검증
    const bankNone = document.getElementById('bankNone').checked;
    if (!bankNone) {
      const depositor = document.getElementById('depositor').value;
      if (!depositor) return alert('이름 또는 대표자명을 입력해 주세요.');

      const bank = document.getElementById('bank').value;
      if (!bank) return alert('은행명을 입력해 주세요.')
    }

    return console.log('검증완료');

    const data = {

    };

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

  // 아이디 중복 조회
  function searchCustomerId() {
    try {
      const id = document.getElementById('customer-id').value;
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
            document.getElementById('customer-id').value = '';
            $('#customer-id').focus();
            checkSerachCustomerId = false;
            return;
          }
          checkSerachCustomerId = true;
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  function validatePassword(password) {
    const regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    return regex.test(password);
  }
</script>
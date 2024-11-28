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
                              <option value="O">개인</option>
                              <option value="B">사업자</option>
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
                              <input id="agencyId" type="hidden" value=""/>
                              <button id="searchAgencyBtn" type="button" class="search" onclick="searchAgency()">조회</button>
                            </div>
                          </div>
                          <div id="personal-user" class="user-info-box userType" style="display:none;">
                            <div>
                              <p>개인 정보</p>
                              <input id="customer-personal-name" type="text" placeholder="이름" onchange="insertDepositor()"/>
                              <input id="customer-personal-email" type="text" placeholder="이메일" />
                              <input id="customer-personal-phone" type="text" placeholder="연락처 (휴대폰)" />
                              <input id="customer-personal-birth" type="text" placeholder="출생년도 (숫자 4자리)" pattern="^\d{4}$" />
                              <select id="customer-personal-sex">
                                <option value="" selected disabled>성별</option>
                                <option value="M">남</option>
                                <option value="W">여</option>
                              </select>
                            </div>
                            <div>
                              <p>주민등록증 등록</p>
                              <div class="fileBox">
                                <button type="button" class="close" id="cpd-file-close">닫기</button>
                                <input type="file" id="customer-personal-doc" />
                                <label for="customer-personal-doc" id="cpd-file-label">파일을 끌어오세요</label>
                              </div>
                              <input type="hidden" id="cpd-modify" value="" />
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
                                <button type="button" class="close" id="cbd-file-close">닫기</button>
                                <input type="file" id="customer-business-doc" />
                                <label for="customer-business-doc" id="cbd-file-label">파일을 끌어오세요</label>
                              </div>
                              <input type="hidden" id="cbd-modify" value="" />
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
                                <p>사이트등록1</p>
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

    let fileInput, fileLabel, closeButton, modifyFile;

    if (type === 'O') {
      fileInput = document.getElementById('customer-personal-doc');
      fileLabel = document.getElementById('cpd-file-label');
      closeButton = document.getElementById('cpd-file-close');
      modifyFile = document.getElementById('cpd-modify');
      $('#personal-user').show();
    } else if (type === 'B') {
      fileInput = document.getElementById('customer-business-doc');
      fileLabel = document.getElementById('cbd-file-label');
      closeButton = document.getElementById('cbd-file-close');
      modifyFile = document.getElementById('cbd-modify');
      $('#business-user').show();
    }

    // 드래그 앤 드롭 이벤트 핸들러
    fileLabel.addEventListener('dragover', (event) => {
      event.preventDefault();
      event.stopPropagation();
    });

    fileLabel.addEventListener('drop', (event) => {
      event.preventDefault();
      event.stopPropagation();

      if (event.dataTransfer.files.length) {
        const file = event.dataTransfer.files[0];
        fileInput.files = event.dataTransfer.files; // 파일 입력에 파일 추가
        fileLabel.textContent = file.name; // 라벨 텍스트를 파일명으로 변경
      }
    });

    // 파일 선택 시 라벨 변경
    fileInput.addEventListener('change', () => {
      if (fileInput.files.length) {
        fileLabel.textContent = fileInput.files[0].name; // 라벨 텍스트를 파일명으로 변경
        modifyFile.value = '';
      }
    });

    // 닫기 버튼 클릭 시 초기화
    closeButton.addEventListener('click', () => {
      fileInput.value = ''; // 파일 입력 초기화
      fileLabel.textContent = '파일을 끌어오세요'; // 라벨 초기화
      modifyFile.value = '';
    });
  }

  // 회원유형2에 맞춰서 예금주명 업데이트
  function insertDepositor() {
    const userType = document.getElementById('selectUserType2').value;
    if (!userType) return;

    const checkedBankNone = document.getElementById('bankNone').checked;
    if (checkedBankNone) return;

    let name = '';
    if (userType === 'O') {
      name = document.getElementById('customer-personal-name').value;
    } else if (userType === 'B') {
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
      insertDepositor();
    }
  }

  // 매체 사이트 추가
  function addAffliateSite() {
    const cardId = document.getElementById('site-list').childElementCount + 1;
    const card = `
                  <div id="site-card${cardId}">
                    <p>사이트등록${cardId}<button class="remove-site-btn" onclick="removeAffliateSite(${cardId})">삭제</button></p>
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
  function removeAffliateSite(cardNumber) {
    const card = document.getElementById(`site-card${cardNumber}`);
    if (card) {
      card.remove(); // 카드 삭제
      updateCardIds(); // 카드 ID 업데이트
    }
  }

  function updateCardIds() {
    const cards = document.querySelectorAll('#site-list > div[id^="site-card"]');
    cardCount = 0; // 카드 수 초기화

    cards.forEach((card, index) => {
      cardCount++; // 카드 수 증가
      card.id = `site-card${cardCount}`; // 새로운 ID 설정
      const button = card.querySelector('.remove-site-btn');
      button.setAttribute('onclick', `removeAffliateSite(${cardCount})`); // 버튼의 onclick 업데이트
    });
  }

  // 회원 추가 검증 및 데이터 객체 생성 
  let checkSearchCustomerId = false;
  let checkSearchAgency = false;

  function validAddCustomer() {
    let data = {};

    const id = document.getElementById('customer-id').value;
    if (!id) return alert('아이디를 입력해 주세요.');
    if (id.length < 6) return alert('아이디를 6자리 이상 입력해 주세요.');
    if (!checkSearchCustomerId) return alert('아이디를 조회해 주세요.');
    data.memberId = id;

    const pwd = document.getElementById('customer-pwd').value;
    if (!validatePassword(pwd)) return alert('비밀번호는 영문과 숫자를 포함하여 8자리 이상되어야 합니다.');
    const pwdRe = document.getElementById('customer-pwd-re').value;
    if (pwd !== pwdRe) return alert('재입력한 비밀번호가 일치하지 않습니다.');
    data.memberPw = pwd;

    const type1 = document.getElementById('selectUserType1').value;
    if (!type1) return alert('회원유형1을 선택해 주세요.');
    data.type = type1;

    const type2 = document.getElementById('selectUserType2').value;
    if (!type2) return alert('회원유형2를 선택해 주세요.');
    data.businessType = type2;

    // 대행사 선택 검증
    const agencyNone = document.getElementById('agencyNone').checked;
    if (!agencyNone) {
      const agency = document.getElementById('agencyName').value;
      if (!agency) return alert('대행사명을 입력해 주세요.');
      if (!checkSearchAgency) return alert('대행사를 조회해 주세요.');

      const agencyId = document.getElementById('agencyId').value;
      if (!agencyId) return alert('대행사를 다시 조회해 주세요.');
      data.agencyId = agencyId;
    }

    if (type2 === 'O') { // 개인 검증
      const name = document.getElementById('customer-personal-name').value;
      if (!name) return alert('이름을 입력해 주세요.');
      data.ceoName = name;

      const email = document.getElementById('customer-personal-email').value;
      if (!email) return alert('이메일을 입력해 주세요.');
      data.managerEmail = email;

      const phone = document.getElementById('customer-personal-phone').value;
      if (!phone) return alert('연락처 (휴대폰)을 입력해 주세요.');
      data.companyPhone = phone;

      const birth = document.getElementById('customer-personal-birth').value;
      if (!birth || birth.length !== 4) return alert('출생년도 (숫자 4자리)를 입력해 주세요.');
      data.birthYear = birth;

      const sex = document.getElementById('customer-personal-sex').value;
      if (!sex) return alert('성별을 선택해 주세요.');
      data.sex = sex;

      // 주민등록증 처리 필요
      const personalDoc = document.getElementById('customer-personal-doc').value;
      if (!personalDoc) return alert('주민등록증 파일을 첨부해 주세요.');

    } else if (type2 === 'B') { // 사업자 검증
      const companyName = document.getElementById('customer-business-company-name').value;
      if (!companyName) return alert('업체(법인)명을 입력해 주세요.');
      data.memberName = companyName;

      const companyCeoName = document.getElementById('customer-business-company-ceo-name').value;
      if (!companyCeoName) return alert('대표자명을 입력해 주세요.');
      data.ceoName = companyCeoName;

      const companyLicense = document.getElementById('customer-business-company-license').value;
      if (!companyLicense) return alert('사업자등록번호를 입력해 주세요.');
      data.businessNumber = companyLicense;

      const companyLocation = document.getElementById('customer-business-company-location').value;
      if (!companyLocation) return alert('사업장 소재지 (사업자등록증 기준)를 입력해 주세요.');
      data.companyAddress = companyLocation;

      const companyType1 = document.getElementById('customer-business-company-type1').value;
      if (!companyType1) return alert('업태를 입력해 주세요.');
      data.businessCategory = companyType1;

      const companyType2 = document.getElementById('customer-business-company-type2').value;
      if (!companyType2) return alert('종목을 입력해 주세요.');
      data.businessSector = companyType2;

      const managerName = document.getElementById('customer-business-manager-name').value;
      if (!managerName) return alert('담당자명을 입력해 주세요.');
      data.managerName = managerName;

      const managerEmail = document.getElementById('customer-business-manager-email').value;
      if (!managerEmail) return alert('담당자 이메일을 입력해 주세요.');
      data.managerEmail = managerEmail;

      const managerPhone = document.getElementById('customer-business-manager-phone').value;
      if (!managerPhone) return alert('담당자 연락처 (휴대폰)를 입력해 주세요.');
      data.managerPhone = managerPhone;

      const huntingLine = document.getElementById('customer-business-hunting-line').value;
      if (!huntingLine) return alert('대표전화를 입력해 주세요.');
      data.companyPhone = huntingLine;

      // 사업자등록증 처리 필요
      const businessDoc = document.getElementById('customer-business-doc').value;
      if (!businessDoc) return alert('사업자등록증 파일을 첨부해 주세요.');
    }

    // 은행 검증
    const bankNone = document.getElementById('bankNone').checked;
    if (!bankNone) {
      const depositor = document.getElementById('depositor').value;
      if (!depositor) return alert('이름 또는 대표자명을 입력해 주세요.');
      data.accountName = depositor;

      const bank = document.getElementById('bank').value;
      if (!bank) return alert('은행명을 입력해 주세요.')
      data.bank = bank;
    }

    // 사이트 추가등록 검증
    if (type1 === 'AFFLIATE') {
      let isValid = true;
      let siteList = [];
      const cards = document.querySelectorAll('#site-list > div[id^="site-card"]');
      cards.forEach((card, index) => {
        const siteName = card.querySelector('input[type="text"]').value;
        const url = card.querySelector('input[type="text"]:nth-of-type(2)').value;
        const category = card.querySelector('select').value;

        if (!siteName || !url || !category) isValid = false;
        siteList.push({
          siteName: siteName,
          site: url,
          category: category
        })
      });

      if (!isValid) return alert('사이트 등록의 모든 값을 입력해 주세요.');

      data.memberSiteList = siteList;
    } else {
      data.memberSiteList = [];
    }

    data.apiType = 'I';
    data.status = 'Y';

    uploadDoc().then((result) => {
      data.license = result;
      postAddCustomer(data);
    })
  }

  // 파일 업로드
  function uploadDoc() {
    return new Promise((resolve, reject) => {
      try {
        const type = document.getElementById('selectUserType2').value;
        let fileInput;

        if (type === 'O') {
          fileInput = document.getElementById('customer-personal-doc');
        } else if (type === 'B') {
          fileInput = document.getElementById('customer-business-doc');
        } else {
          return alert('회원유형2을 선택해 주세요.');
        }

        const requestData = new FormData();
        const files = fileInput.files;

        // 파일이 선택되었는지 확인
        if (!files.length) {
          return alert('파일을 선택해 주세요.');
        }

        for (let i = 0; i < files.length; i++) {
          requestData.append('files[]', files[i]);
        }

        requestData.append('userId', document.getElementById('customer-id').value);

        $.ajax({
          type: 'POST',
          url: '/page/account/api/upload-doc.php',
          data: requestData,
          processData: false,
          contentType: false,
          dataType: 'JSON',
          success: function(result) {
            if (result.resultCode !== 'success') reject(result.resultMessage);
            const fileList = result.datas;
            resolve(fileList[0].fileName);
          },
          error: function(request, status, error) {
            console.error(`Error: ${error}`);
          }
        });

      } catch (error) {
        reject(error);
      }
    })
  }


  // 회원 추가 요청
  function postAddCustomer(data) {
    try {
      $.ajax({
        type: 'POST',
        url: '<?= $adminApiUrl; ?>/page/account/api/memberSignIn.php',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(result) {
          if (result.resultCode !== '0000') return alert(result.resultMessage);
          if (data.apiType === 'I') {
            alert('회원 추가 등록이 처리되었습니다.');
          } else if (data.apiType === 'U') {
            alert('회원 수정이 처리되었습니다.');
          }
          location.reload();
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  // 아이디 중복 조회
  function searchCustomerId() {
    try {
      const id = document.getElementById('customer-id').value;
      if (!id) return alert('아이디를 입력해 주세요.');
      if (id.length < 6) return alert('아이디를 6자리 이상 입력해 주세요.');

      $.ajax({
        type: 'GET',
        url: '/page/account/api/select-search-id.php',
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
            checkSearchCustomerId = false;
            return;
          }
          checkSearchCustomerId = true;
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  // 대행사 조회
  function searchAgency() {
    try {
      const agency = document.getElementById('agencyName').value;
      if (!agency) return alert('대행사명을 입력해 주세요.');

      $.ajax({
        type: 'GET',
        url: '/page/account/api/select-search-agency.php',
        contentType: 'application/json',
        dataType: 'JSON',
        data: {
          agency
        },
        success: function(result) {
          alert(result.resultMessage);
          if (result.resultCode !== 'success') {
            document.getElementById('agencyName').value = '';
            document.getElementById('agencyId').value = '';
            $('#agencyName').focus();
            checkSearchAgency = false;
            return;
          }
          document.getElementById('agencyId').value = result.agencyId;
          checkSearchAgency = true;
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
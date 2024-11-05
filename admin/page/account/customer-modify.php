<script>
  // 회원 추가 팝업 
  function modifyCustomer(id) {
    if (!id) return alert('잘못된 접근입니다.');
    try {
      const requestData = {
        memberId: id
      }

      $.ajax({
        type: 'POST',
        url: 'https://admin.shoplus.io/api/admin/memberDetail',
        contentType: 'application/json',
        dataType: 'JSON',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') return alert(result.resultMessage);
          renderModifyCustomer(JSON.stringify(result.data));
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  function renderModifyCustomer(data) {
    const item = JSON.parse(data);

    const siteListHtml = (() => {
      if (item.type === 'AFFLIATE' && item.siteList === null) {
        // AFFLIATE 타입이고 siteList가 null인 경우 기본 사이트 정보를 렌더링
        return `
            <div id="site-card1">
                <p>사이트등록1</p>
                <input type="text" placeholder="사이트명" value="" />
                <input type="text" placeholder="URL" value="" />
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
        `;
      }

      // 기본적으로 siteList가 있을 때 렌더링
      return (item.siteList || []).map((site, index) => `
        <div id="site-card${index + 1}">
            <p>사이트등록${index + 1}</p>
            <input type="text" placeholder="사이트명" value="${site.siteName}" />
            <input type="text" placeholder="URL" value="${site.site}" />
            <select name="" id="">
                <option value="" disabled>카테고리 선택</option>
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
                <option value="<?= $row['CATEGORY']; ?>" ${site.category === "<?= $row['CATEGORY']; ?>" ? 'selected' : ''}><?= $row['CATEGORY_NAME']; ?></option>
                <?
                  }
                }
                ?>
            </select>
        </div>
    `).join('');
    })();

    const modal = `
                  <div class="modalWrap md_customerRegister" id="md_customerRegister" style="display:block;">
                    <div class="modalContainer">
                      <div class="modalTitle">
                        <p>회원 / 수정</p>
                        <button class="close modalClose" onclick="location.reload()"></button>
                      </div>
                      <div class="modalContent">
                        <section class="sec_list">
                          <div>
                            <p>아이디/비밀번호</p>
                            <div class="idBox">
                              <input id="customer-id" type="text" placeholder="아이디 (6자리 이상)" value="${item.memberId}" disabled />
                            </div>
                            <input id="customer-pwd" type="password" placeholder="비밀번호(영문, 숫자 조합 8자리 이상)" value="${item.memberPw}" />
                            <input id="customer-pwd-re" type="password" placeholder="비밀번호 재입력" value="${item.memberPw}" />
                          </div>
                          <div>
                            <p>회원 유형</p>
                            <select id="selectUserType1" onchange="selectUserType1()">
                              <option value="" disabled>회원유형1</option>
                              <option value="MERCHANT" ${item.type === 'MERCHANT' ? 'selected' : ''}>광고주</option>
                              <option value="AFFLIATE" ${item.type === 'AFFLIATE' ? 'selected' : ''}>매체</option>
                              <option value="MERCHANTAGC" ${item.type === 'MERCHANTAGC' ? 'selected' : ''}>광고주대행사</option>
                              <option value="AFFLIATEAGC" ${item.type === 'AFFLIATEAGC' ? 'selected' : ''}>매체대행사</option>
                            </select>
                            <select id="selectUserType2" onchange="selectUserType2()">
                              <option value="" disabled>회원유형2</option>
                              <option value="P" ${item.businessType === 'P' ? 'selected' : ''}>개인</option>
                              <option value="B" ${item.businessType === 'B' ? 'selected' : ''}>사업자</option>
                            </select>
                          </div>
                          <div>
                            <p>대행사 선택</p>
                            <div class="checkBox">
                              <input type="checkbox" id="agencyNone" onchange="checkedAgencyNone()" ${!item.agencyId ? 'checked' : ''}/>
                              <label for="agencyNone">*해당사항 없음</label>
                            </div>
                            <div class="searchBox">
                              <input id="agencyName" type="text" placeholder="대행사명" value="" ${!item.agencyId ? 'disabled' : ''}/>
                              <input id="agencyId" type="hidden" value="${item.agencyId ? item.agencyId : ''}"/>
                              <button id="searchAgencyBtn" type="button" class="search" onclick="searchAgency()">조회</button>
                            </div>
                          </div>
                          <div id="personal-user" class="user-info-box userType" style="${item.businessType !== 'P' ? 'display:none;' : ''}">
                            <div>
                              <p>개인 정보</p>
                              <input id="customer-personal-name" type="text" placeholder="이름" onchange="insertDepositor()" value="${item.ceoName ? item.ceoName : ''}"/>
                              <input id="customer-personal-email" type="text" placeholder="이메일" value="${item.managerEmail ? item.managerEmail : ''}"/>
                              <input id="customer-personal-phone" type="text" placeholder="연락처 (휴대폰)" value="${item.companyPhone ? item.companyPhone : ''}"/>
                              <input id="customer-personal-birth" type="text" placeholder="출생년도 (숫자 4자리)" pattern="^\d{4}$" value="${item.birthYear ? item.birthYear : ''}"/>
                              <select id="customer-personal-sex">
                                <option value="" ${!item.sex ? 'selected' : ''} disabled>성별</option>
                                <option value="M" ${item.sex === 'M' ? 'selected' : ''}>남</option>
                                <option value="W" ${item.sex === 'W' ? 'selected' : ''}>여</option>
                              </select>
                            </div>
                            <div>
                              <p>주민등록증 등록</p>
                              <div class="fileBox">
                                <button type="button" class="close" id="cpd-file-close">닫기</button>
                                <input type="file" id="customer-personal-doc" />
                                <label for="customer-personal-doc" id="cpd-file-label">${item.license ? item.license : '파일을 끌어오세요'}</label>
                              </div>
                              <input type="hidden" id="cpd-modify" value="${item.businessType === 'P' ? item.license : ''}" />
                            </div>
                          </div>
                          <div id="business-user" class="user-info-box userType" style="${item.businessType !== 'B' ? 'display:none;' : ''}">
                            <div>
                              <p>사업자 정보</p>
                              <input id="customer-business-company-name" type="text" placeholder="업체(법인)명" value="${item.memberName ? item.memberName : ''}"/>
                              <input id="customer-business-company-ceo-name" type="text" placeholder="대표자명" onchange="insertDepositor()" value="${item.ceoName ? item.ceoName : ''}" />
                              <input id="customer-business-company-license" type="text" placeholder="사업자등록번호" value="${item.businessNumber ? item.businessNumber : ''}" />
                              <input id="customer-business-company-location" type="text" placeholder="사업장 소재지 (사업자등록증 기준)" value="${item.businessAddress ? item.businessAddress : ''}"/>
                              <input id="customer-business-company-type1" type="text" placeholder="업태" value="${item.businessCategory ? item.businessCategory : ''}"/>
                              <input id="customer-business-company-type2" type="text" placeholder="종목" value="${item.businessSector ? item.businessSector : ''}"/>
                            </div>
                            <div>
                              <p>담당자 정보</p>
                              <input id="customer-business-manager-name" type="text" placeholder="담당자명" value="${item.managerName ? item.managerName : ''}" />
                              <input id="customer-business-manager-email" type="text" placeholder="담당자 이메일" value="${item.managerEmail ? item.managerEmail : ''}" />
                              <input id="customer-business-manager-phone" type="text" placeholder="담당자 연락처 (휴대폰)" value="${item.managerPhone ? item.managerPhone : ''}" />
                              <input id="customer-business-hunting-line" type="text" placeholder="대표전화" value="${item.companyPhone ? item.companyPhone : ''}" />
                            </div>
                            <div>
                              <p>사업자등록증 등록</p>
                              <div class="fileBox">
                                <button type="button" class="close" id="cbd-file-close">닫기</button>
                                <input type="file" id="customer-business-doc" />
                                <label for="customer-business-doc" id="cbd-file-label">${item.license ? item.license : '파일을 끌어오세요'}</label>
                              </div>
                              <input type="hidden" id="cbd-modify" value="${item.businessType === 'B' ? item.license : ''}" />
                            </div>
                          </div>
                          <div>
                            <p>은행정보</p>
                            <div class="checkBox">
                              <input type="checkbox" id="bankNone" onchange="checkedBankNone()" ${!item.accountName ? 'checked' : ''}/>
                              <label for="bankNone">*해당사항 없음</label>
                            </div>
                            <input id="depositor" type="text" placeholder="예금주명" value="${item.accountName ? item.accountName : ''}" disabled/>
                            <input id="bank" type="text" placeholder="은행명" value="${item.accountName ? item.accountName : ''}" ${!item.accountName ? 'disabled' : ''}/>
                          </div>
                          <div id="affliate-user" class="affliate-info-box" style="${data.type === 'AFFLIATE' && data.siteList === null ? '' : 'display:none;'}">
                            <div id="site-list" class="site-info-box">
                              ${siteListHtml}
                            </div>
                            <button type="button" class="siteAdd" onclick="addAffliateSite()">사이트 추가</button>
                          </div>
                        </section>
                      </div>
                      <div class="modalFooter">
                        <button type="button" class="confirm" onclick="validModifyCustomer()">수정</button>
                        <button type="button" class="cancel" onclick="location.reload()">취소</button>
                      </div>
                    </div>
                    <div class="modalDim" onclick="location.reload()"></div>
                  </div>
                  `;
    $('.wrap.modalView .modal').empty();
    $('.wrap.modalView .modal').append(modal);
    selectUserType2();
  }

  // 회원 추가 검증 및 데이터 객체 생성 
  function validModifyCustomer() {
    let data = {};

    const id = document.getElementById('customer-id').value;
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

    let modifyLicense;
    if (data.type === 'P') {
      modifyLicense = document.getElementById('cpd-modify').value;
    } else if (data.type === 'B') {
      modifyLicense = document.getElementById('cbd-modify').value;
    }

    if (type2 === 'P') { // 개인 검증
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
      if (!modifyLicense && !personalDoc) {
        console.log(modifyLicense, personalDoc);
        return alert('주민등록증 파일을 첨부해 주세요.');
      }
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
      if (!modifyLicense && !businessDoc) {
        return alert('사업자등록증 파일을 첨부해 주세요.');
      }
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
      data.apiType = 'U';
    }



    if (!modifyLicense) {
      uploadDoc().then((result) => {
        data.license = result;
        postAddCustomer(data);
      })
    } else {
      data.license = modifyLicense;
      postAddCustomer(data);
    }
  }
</script>
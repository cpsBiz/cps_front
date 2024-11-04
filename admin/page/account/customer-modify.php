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

    const siteListHtml = (data.siteList || []).map((site, index) => `
        <div id="site-card${index + 1}">
            <p>사이트등록${index + 1}</p>
            <input type="text" placeholder="사이트명" value="${site.siteName}" />
            <input type="text" placeholder="URL" value="${site.site}" />
            <select name="" id="">
                <option value="" disabled>카테고리 선택</option>
                <?php
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
                <?php
                  }
                }
                ?>
            </select>
        </div>
    `).join('');

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
                              <input type="checkbox" id="agencyNone" onchange="checkedAgencyNone()" ${item.agencyId ? 'checked' : ''}/>
                              <label for="agencyNone">*해당사항 없음</label>
                            </div>
                            <div class="searchBox">
                              <input id="agencyName" type="text" placeholder="대행사명" value="" />
                              <input id="agencyId" type="hidden" value="${item.agencyId}"/>
                              <button id="searchAgencyBtn" type="button" class="search" onclick="searchAgency()">조회</button>
                            </div>
                          </div>
                          <div id="personal-user" class="user-info-box userType" style="${item.businessType === 'P' ? 'display:none;' : ''}">
                            <div>
                              <p>개인 정보</p>
                              <input id="customer-personal-name" type="text" placeholder="이름" onchange="insertDepositor()" value="${item.ceoName}"/>
                              <input id="customer-personal-email" type="text" placeholder="이메일" value="${item.managerEmail}"/>
                              <input id="customer-personal-phone" type="text" placeholder="연락처 (휴대폰)" value="${item.companyPhone}"/>
                              <input id="customer-personal-birth" type="text" placeholder="출생년도 (숫자 4자리)" pattern="^\d{4}$" value="${item.birthYear}"/>
                              <select id="customer-personal-sex">
                                <option value="" disabled>성별</option>
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
                            </div>
                          </div>
                          <div id="business-user" class="user-info-box userType" style="${item.businessType === 'B' ? 'display:none;' : ''}">
                            <div>
                              <p>사업자 정보</p>
                              <input id="customer-business-company-name" type="text" placeholder="업체(법인)명" value="${item.memberName}"/>
                              <input id="customer-business-company-ceo-name" type="text" placeholder="대표자명" onchange="insertDepositor()" value="${item.ceoName}" />
                              <input id="customer-business-company-license" type="text" placeholder="사업자등록번호" value="${item.businessNumber}" />
                              <input id="customer-business-company-location" type="text" placeholder="사업장 소재지 (사업자등록증 기준)" value="${item.businessAddress}"/>
                              <input id="customer-business-company-type1" type="text" placeholder="업태" value="${item.businessCategory}"/>
                              <input id="customer-business-company-type2" type="text" placeholder="종목" value="${item.businessSector}"/>
                            </div>
                            <div>
                              <p>담당자 정보</p>
                              <input id="customer-business-manager-name" type="text" placeholder="담당자명" value="${item.managerName}" />
                              <input id="customer-business-manager-email" type="text" placeholder="담당자 이메일" value="${item.managerEmail}" />
                              <input id="customer-business-manager-phone" type="text" placeholder="담당자 연락처 (휴대폰)" value="${item.managerPhone}" />
                              <input id="customer-business-hunting-line" type="text" placeholder="대표전화" value="${item.companyPhone}" />
                            </div>
                            <div>
                              <p>사업자등록증 등록</p>
                              <div class="fileBox">
                                <button type="button" class="close" id="cbd-file-close">닫기</button>
                                <input type="file" id="customer-business-doc" />
                                <label for="customer-business-doc" id="cbd-file-label">${item.license ? item.license : '파일을 끌어오세요'}</label>
                              </div>
                            </div>
                          </div>
                          <div>
                            <p>은행정보</p>
                            <div class="checkBox">
                              <input type="checkbox" id="bankNone" onchange="checkedBankNone()" ${!item.accountName ? 'checked' : ''}/>
                              <label for="bankNone">*해당사항 없음</label>
                            </div>
                            <input id="depositor" type="text" placeholder="예금주명" value="${item.accountName}" disabled/>
                            <input id="bank" type="text" placeholder="은행명" value="${item.accountName}"/>
                          </div>
                          <div id="affliate-user" class="affliate-info-box" style="display:none;">
                            <div id="site-list" class="site-info-box">
                               ${siteListHtml}
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
</script>
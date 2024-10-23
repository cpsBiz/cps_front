<script>
  function getInquiryDetail(inquiryNum, type) {
    try {
      const requestData = {
        inquiryNum,
        note: ""
      };

      $.ajax({
        type: 'POST',
        url: 'http://192.168.101.156/api/admin/inquiryDetail',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') return alert(result.resultMessage);
          if (type === '누락문의') {
            renderOmmissionInquiryDetail(result)
          } else if (type === '기타문의') {
            renderEtcInquiryDetail(result)
          }
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  function renderOmmissionInquiryDetail(result) {
    const data = result.data.cpsInquiry;
    const answer = result.data.cspAnswer;

    const modal = `
                  <div class="modalWrap md_inquiryDetail" id="md_inquiryDetail" style="display:block;">
                    <div class="modalContainer">
                        <div class="modalTitle">
                            <p>1:1문의내역<span>상세보기</span></p>
                            <button class="close modalClose" onclick="location.reload()"></button>
                        </div>
                        <div class="modalContent">
                            <section class="sec_listT1">
                                <div class="tableArea">
                                    <div class="tableBox">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>구분</th>
                                                    <th>내용</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>작성일</th>
                                                    <td>${data.regDate}</td>
                                                </tr>
                                                <tr>
                                                    <th>문의 유형</th>
                                                    <td>${data.inquiryType}</td>
                                                </tr>
                                                <tr>
                                                    <th>쇼핑몰명</th>
                                                    <td>${data.merchantId}</td>
                                                </tr>
                                                <tr>
                                                    <th>문의 목적</th>
                                                    <td>${data.purpose}</td>
                                                </tr>
                                                <tr>
                                                    <th>구매일</th>
                                                    <td>${data.regDay}</td>
                                                </tr>
                                                <tr>
                                                    <th>성명</th>
                                                    <td>${data.userName}</td>
                                                </tr>
                                                <tr>
                                                    <th>주문 번호</th>
                                                    <td>${data.orderNo}</td>
                                                </tr>
                                                <tr>
                                                    <th>상품 번호</th>
                                                    <td>${data.productCode}</td>
                                                </tr>
                                                <tr>
                                                    <th>결제 통화</th>
                                                    <td>${data.currency}</td>
                                                </tr>
                                                <tr>
                                                    <th>결제 수단</th>
                                                    <td>${data.payment}</td>
                                                </tr>
                                                <tr>
                                                    <th>상품 금액</th>
                                                    <td>${data.productPrice}</td>
                                                </tr>
                                                <tr>
                                                    <th>상품 수량</th>
                                                    <td>${data.productCnt}</td>
                                                </tr>
                                                <tr>
                                                    <th>비고</th>
                                                    <td>${data.note}</td>
                                                </tr>
                                                <tr>
                                                    <th>이메일 주소</th>
                                                    <td>${data.email}</td>
                                                </tr>
                                                <tr>
                                                    <th>대응 현황</th>
                                                    <td class="wait">${data.answerYn === 'N' ? '회신대기' : '회신완료'}</td>
                                                </tr>
                                                <tr>
                                                    <th>답변</th>
                                                    <td>
                                                        <div class="textareaBox">
                                                            <textarea name="" id="" placeholder="답변을 입력해 주세요">${answer ? answer.note : ''}</textarea>
                                                        </div>
                                                        <div class="sendBox">
                                                            <input type="text">
                                                            <button type="button" class="send">보내기</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="modalFooter">
                            <button type="button" class="save">저장</button>
                            <button type="button" class="cancel" onclick="location.reload()">취소</button>
                        </div>
                    </div>
                    <div class="modalDim" onclick="location.reload()"></div>
                </div>
                `;
    $('.wrap.modalView .modal').empty();
    $('.wrap.modalView .modal').append(modal);
  }

  function renderEtcInquiryDetail(result) {
    const data = result.data.cpsInquiry;
    const answer = result.data.cspAnswer;
    const fileList = result.data.fileList.fileName || [];

    const modal = `
                  <div class="modalWrap md_inquiryDetail" id="md_inquiryDetail" style="display:block;">
                    <div class="modalContainer">
                        <div class="modalTitle">
                            <p>1:1문의내역<span>상세보기</span></p>
                            <button class="close modalClose" onclick="location.reload()"></button>
                        </div>
                        <div class="modalContent">
                            <section class="sec_listT2">
                                <div class="tableArea">
                                    <div class="tableBox">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>구분</th>
                                                    <th>내용</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>작성일</th>
                                                    <td>${data.regDate}</td>
                                                </tr>
                                                <tr>
                                                    <th>문의 유형</th>
                                                    <td>${data.inquiryType}</td>
                                                </tr>
                                                <tr>
                                                    <th>제목</th>
                                                    <td>${data.purpose}</td>
                                                </tr>
                                                <tr>
                                                    <th>내용</th>
                                                    <td>${data.note}</td>
                                                </tr>
                                                <tr>
                                                    <th>성명</th>
                                                    <td>${data.userName}</td>
                                                </tr>
                                                <tr>
                                                    <th>이메일 주소</th>
                                                    <td>${data.email}</td>
                                                </tr>
                                                ${fileList.length > 0 ? 
                                                `<tr>
                                                    <th>첨부파일</th>
                                                    <td>
                                                        <button type="button" class="download" onclick="downloadFileList(${JSON.stringify(fileList)})">다운로드</button>
                                                    </td>
                                                </tr>` 
                                                : ''}
                                                <tr>
                                                    <th>대응 현황</th>
                                                    <td class="complete">${data.answerYn === 'N' ? '회신대기' : '회신완료'}</td>
                                                </tr>
                                                <tr>
                                                    <th>답변</th>
                                                    <td>
                                                        <div class="textareaBox">
                                                            <textarea name="" id="" placeholder="답변을 입력해 주세요">${answer ? answer.note : ''}</textarea>
                                                        </div>
                                                        <div class="sendBox">
                                                            <input type="text">
                                                            <button type="button" class="send">보내기</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="modalFooter">
                            <button type="button" class="save">저장</button>
                            <button type="button" class="cancel" onclick="location.reload()">취소</button>
                        </div>
                    </div>
                    <div class="modalDim" onclick="location.reload()"></div>
                </div>
                `;
    $('.wrap.modalView .modal').empty();
    $('.wrap.modalView .modal').append(modal);
  }

  // 첨부 파일 다운로드
  function downloadFileList() {

  }

  // 답변 이메일로 보내기
  function sendInquiryAnswer() {

  }

  // 답변 저장
  function postInquiryAnswer() {

  }
</script>
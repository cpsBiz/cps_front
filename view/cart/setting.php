<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>설정</title>
  <!-- style -->

</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>설정</h1>
      <div class="btn-list">
        <a href="javascript:history.back()" class="ico-arrow type1 left">이전</a>
      </div>
    </header>
    <!-- setting -->
    <!-- hana class 추가 시 시그니처 컬러 변경 -->
    <div class="page-setting">
      <div class="setting-list-wrap">
        <div class="box">
          <p class="blue-title">적립</p>
          <div class="item type2">
            <div class="text-box">
              <p class="title">사용정보 접근 설정<span class="ico-arrow type3 right"></span></p>
            </div>
            <a href="javascript:void(0)" id="select-btn1"></a>
          </div>
        </div>
        <div class="box">
          <p class="blue-title type2">카트</p>
          <p class="title">회원 정보</p>
          <div class="item type1">
            <div class="text-box">
              <p class="title">쿠팡 와우 멤버</p>
              <p class="text">와우 멤버 기준으로 가격 정보를 제공해요</p>
            </div>
            <div id="toggle-btn1" class="toggle-btn" onclick="onOff('#toggle-btn1'), postSettingData()">
              <div class="circle"></div>
            </div>
          </div>
          <div class="item type2" style="display: none;">
            <div class="text-box">
              <p class="title">카드 할인 알림<span class="ico-arrow type3 right"></span></p>
              <p class="text">보유한 카드를 설정해주시면 해당 카드 할인에 알려줘요</p>
            </div>
            <a href="javascript:void(0)" id="select-btn1" onclick="getCardList(), selectInputOn('#select-wrap', '#select-list1')"></a>
          </div>
        </div>
        <div class="box">
          <p class="title">알림 설정</p>
          <div class="item type1">
            <div class="text-box">
              <p class="title">야간 알림 (24시 ~ 7시)</p>
              <p class="text">새벽에도 푸시 알림메시지가 전송돼요</p>
            </div>
            <div id="toggle-btn2" class="toggle-btn" onclick="onOff('#toggle-btn2'), postSettingData()">
              <div class="circle"></div>
            </div>
          </div>
          <div class="item type2">
            <div class="text-box">
              <p class="title">알림 감도 설정<span class="ico-arrow type3 right"></span></p>
              <p class="text">각 항목 별 푸시 알림을 보내는 기준을 설정하세요</p>
            </div>
            <a href="javascript:void(0)" id="select-btn2" onclick="selectInputOn('#select-wrap', '#select-list2')"></a>
          </div>
          <div class="item type1">
            <div class="text-box">
              <p class="title">로켓배송만 알림</p>
              <p class="text">쿠팡 로켓배송 상품에 한해 가격 할인 알림을 받을 수 있어요</p>
            </div>
            <div id="toggle-btn3" class="toggle-btn" onclick="onOff('#toggle-btn3'), postSettingData()">
              <div class="circle"></div>
            </div>
          </div>
          <div class="item type1" style="display: none;">
            <div class="text-box">
              <p class="title">반품 상품 알림</p>
              <p class="text">새상품과 동일하지만 반품된 상품을 저렴하게 구매할 수 있어요</p>
            </div>
            <div id="toggle-btn4" class="toggle-btn" onclick="onOff('#toggle-btn4'), postSettingData()">
              <div class="circle"></div>
            </div>
          </div>
        </div>
        <div class="box">
          <p class="title">서비스 설정</p>
          <div class="item type2">
            <div class="text-box">
              <p class="title">쿠팡 쇼핑 혜택 동의<span class="ico-arrow type3 right"></span></p>
            </div>
            <a href="javascript:void(0)" id="select-btn4" onclick="selectInputOn('#select-wrap', '#select-list4')"></a>
          </div>
        </div>
        <div class="box">
          <p class="title">고객 센터</p>
          <div class="item type2">
            <div class="text-box">
              <p class="title">카트 메뉴 사용법<span class="ico-arrow type3 right"></span></p>
            </div>
            <a href="<?= $appApiUrl; ?>/cart/guide/cart.php"></a>
          </div>
          <div class="item type2">
            <div class="text-box">
              <p class="title">자주 묻는 질문<span class="ico-arrow type3 right"></span></p>
            </div>
            <a href="javascript:void(0)" id="select-btn6" onclick="selectInputOn('#select-wrap', '#select-list6')"></a>
          </div>
        </div>
      </div>
    </div>
    <!-- select-wrap -->
    <div id="select-wrap">
      <!-- 정렬 방식 셀렉트 -->
      <div id="select-list1" class="select-list type4">
        <div class="select-head">
          <p>할인 받을 카드 선택</p>
          <button class="ico-close type1" type="button" onclick="selectListClose('#select-btn1', '#select-wrap', '#select-list1')">닫기</button>
        </div>
        <div class="select-cont">
          <div class="card-list"></div>
          <div class="btn-box">
            <!-- gray class 제거시 색상 변경 -->
            <button class="btn" type="button" onclick="postCardList()">선택완료</button>
          </div>
        </div>
      </div>
      <div id="select-list2" class="select-list type4">
        <div class="select-head">
          <p>알림 감도 설정</p>
          <button class="ico-close type1" type="button" onclick="selectListClose('#select-btn2', '#select-wrap', '#select-list2')">닫기</button>
        </div>
        <div class="select-cont">
          <div class="alarm-list">
            <p class="title">등록가격 보다 낮아지면 알림</p>
            <p class="text">최초 등록한 가격보다 낮아지면 알림을 드립니다.<br>몇 % 떨어질 때 알림을 받을지 선택해 주세요.</p>
            <div id="priceAlarmPer" class="list-box">
              <div class="input-box">
                <input type="radio" name="alarm-list1" id="alarm-item1" value="1" checked>
                <label for="alarm-item1">1% 이상</label>
              </div>
              <div class="input-box">
                <input type="radio" name="alarm-list1" id="alarm-item2" value="3">
                <label for="alarm-item2">3% 이상</label>
              </div>
              <div class="input-box">
                <input type="radio" name="alarm-list1" id="alarm-item3" value="5">
                <label for="alarm-item3">5% 이상</label>
              </div>
              <div class="input-box">
                <input type="radio" name="alarm-list1" id="alarm-item4" value="7">
                <label for="alarm-item4">7% 이상</label>
              </div>
            </div>
            <p class="title">카드 할인 알림</p>
            <div id="cardAlarmPer" class="list-box">
              <div class="input-box">
                <input type="radio" name="alarm-list2" id="alarm-item5" value="1" checked>
                <label for="alarm-item5">1% 이상</label>
              </div>
              <div class="input-box">
                <input type="radio" name="alarm-list2" id="alarm-item6" value="3">
                <label for="alarm-item6">3% 이상</label>
              </div>
              <div class="input-box">
                <input type="radio" name="alarm-list2" id="alarm-item7" value="5">
                <label for="alarm-item7">5% 이상</label>
              </div>
              <div class="input-box">
                <input type="radio" name="alarm-list2" id="alarm-item8" value="7">
                <label for="alarm-item8">7% 이상</label>
              </div>
            </div>
            <p class="title">미개봉 반품 상품 알림</p>
            <div id="returnAlarmPer" class="list-box">
              <div class="input-box">
                <input type="radio" name="alarm-list3" id="alarm-item9" value="3" checked>
                <label for="alarm-item9">3% 이상</label>
              </div>
              <div class="input-box">
                <input type="radio" name="alarm-list3" id="alarm-item10" value="5">
                <label for="alarm-item10">5% 이상</label>
              </div>
              <div class="input-box">
                <input type="radio" name="alarm-list3" id="alarm-item11" value="7">
                <label for="alarm-item11">7% 이상</label>
              </div>
              <div class="input-box">
                <input type="radio" name="alarm-list3" id="alarm-item12" value="10">
                <label for="alarm-item12">10% 이상</label>
              </div>
            </div>
          </div>
          <div class="btn-box">
            <button class="btn white" type="button" onclick="alarmCheck('basic')">일반상품도 알림</button>
            <button class="btn" type="button" onclick="alarmCheck('rocket')">로켓배송만 알림</button>
          </div>
        </div>
      </div>
      <!-- 로켓배송만 알림 팝업 -->
      <div id="select-list3" class="select-list type4">
        <div class="select-head">
          <p>로켓배송 알림 설정</p>
          <button class="ico-close type1" type="button">닫기</button>
        </div>
        <div class="select-cont">
          <p class="text">로켓배송만 알림 설정시, 로켓배송보다 가격이 낮은 일반 상품은 알림을 받을 수 없습니다</p>
          <div class="btn-box">
            <button class="btn white" type="button">일반상품도 알림</button>
            <button class="btn" type="button">로켓배송만 알림</button>
          </div>
        </div>
      </div>
      <div id="select-list4" class="select-list type5">
        <div class="select-head mb43">
          <p>쿠팡 쇼핑 혜택 동의</p>
          <button class="ico-close type1" type="button" onclick="selectListClose('#select-btn4', '#select-wrap', '#select-list4')">닫기</button>
        </div>
        <div class="select-cont mh43">
          <div class="box type1">
            <p class="title">서비스 이용 동의</p>
            <div class="gray-box">
              <ul>
                <li>본 서비스는 개인을 특정할 수 있는 정보는 받지 않습니다.</li>
                <li>다만 혜택을 드리기 위해 필요한 쿠팡 구매 내역에 대한 제공 동의를 필요로 합니다.</li>
                <li>쿠팡 구매 내역은 개인정보와는 관련 없는 임의의 숫자로 구매한 상품을 분류하여 구매한 상품 정보만 활용하게 됩니다.</li>
                <li>상품 정보 : 주문번호, 상품명, 구매(취소) 일자, 주문상태 (구매, 취소), 구매(취소) 수량, 구매(취소) 금액 등을 활용 합니다.</li>
              </ul>
            </div>
          </div>
          <div class="box type2">
            <div>
              <p class="title">개인정보 수집, 이용 동의</p>
              <div id="toggle-btn5" class="toggle-btn" onclick="selectInputOn('#select-wrap', '#select-list5')">
                <div class="circle"></div>
              </div>
            </div>
            <a href="javascript:void(0)" onclick="onOff('#select-list7')">자세히보기</a>
          </div>
        </div>
        <!-- 서비스 이용 동의 철회 팝업 on class 넣을 때 같이 on class 넣어주세요 -->
        <div class="fake-box"></div>
      </div>
      <!-- 서비스 이용 동의 철회 팝업 -->
      <div id="select-list5" class="select-list type4">
        <div class="select-head">
          <p>서비스 이용 동의 철회</p>
          <button class="ico-close type1" type="button" onclick="selectInputClose('#select-wrap', '#select-list5')">닫기</button>
        </div>
        <div class="select-cont">
          <p class="text">쿠팡 쇼핑 혜택받기 서비스 동의를 철회할 경우 구매 내역이 삭제되고 혜택을 받을 수 없습니다.</p>
          <div class="btn-box">
            <button class="btn gray" type="button" onclick="selectInputClose('#select-wrap', '#select-list5')">취소</button>
            <button class="btn" type="button" onclick="coupangCheck()">이용 동의 철회</button>
          </div>
        </div>
      </div>
      <div id="select-list6" class="select-list type5">
        <div class="select-head mb33">
          <p>자주 묻는 질문</p>
          <button class="ico-close type1" type="button" onclick="selectListClose('#select-btn6', '#select-wrap', '#select-list6')">닫기</button>
        </div>
        <div class="select-cont mh33">
          <div class="list-wrap-box">
            <div class="list-wrap type3">
              <div class="list list1">
                <div class="top">
                  <p>쇼핑할 때 어떻게 포인트를 적립할 수 있나요?</p>
                  <div class="ico-arrow type1"></div>
                </div>
                <div class="bottom">
                  <div>
                    <div>
                      <p>
                        쇼핑몰을 클릭 시 하단 버튼으로 해당 페이지로 이동하여 페이지를 이동하지 않은 상태에서 로그인 후 원하는 상품을 구매하시면 내역이 전달되고 포인트 적립예정으로 표시됩니다.<br>
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="list list2">
                <div class="top">
                  <p>포인트는 언제 적립되나요?</p>
                  <div class="ico-arrow type1"></div>
                </div>
                <div class="bottom">
                  <div>
                    <div>
                      <p>
                        쇼핑몰을 클릭 시 하단 버튼으로 해당 페이지로 이동하여 페이지를 이동하지 않은 상태에서 로그인 후 원하는 상품을 구매하시면 내역이 전달되고 포인트 적립예정으로 표시됩니다.<br>
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="list list3">
                <div class="top">
                  <p>상품에 문제가 있을 경우 어떻게 하나요?</p>
                  <div class="ico-arrow type1"></div>
                </div>
                <div class="bottom">
                  <div>
                    <div>
                      <p>
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="list list4">
                <div class="top">
                  <p>포인트가 적립되지 않는 경우도 있나요?</p>
                  <div class="ico-arrow type1"></div>
                </div>
                <div class="bottom">
                  <div>
                    <div>
                      <p>
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="list list5">
                <div class="top">
                  <p>주문 후 적립 내역에 표시되지 않기도 하나요?</p>
                  <div class="ico-arrow type1"></div>
                </div>
                <div class="bottom">
                  <div>
                    <div>
                      <p>
                        쇼핑몰을 클릭 시 하단 버튼으로 해당 페이지로 이동하여 페이지를 이동하지 않은 상태에서 로그인 후 원하는 상품을 구매하시면 내역이 전달되고 포인트 적립예정으로 표시됩니다.<br>
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="list list6">
                <div class="top">
                  <p>포인트 적립 제외 상품은 어디서 확인 하나요?</p>
                  <div class="ico-arrow type1"></div>
                </div>
                <div class="bottom">
                  <div>
                    <div>
                      <p>
                        쇼핑몰을 클릭 시 하단 버튼으로 해당 페이지로 이동하여 페이지를 이동하지 않은 상태에서 로그인 후 원하는 상품을 구매하시면 내역이 전달되고 포인트 적립예정으로 표시됩니다.<br>
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                        쇼핑몰에서 구매 내역을 확인 하여야 하기 때문에 최대 3개월까지 소요될 수 있는 점 양해바랍니다.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box">
            <p class="title">유의사항</p>
            <div class="gray-box">
              <ul>
                <li>구매 이후, 적립 내역에 반영되기까지 다소 시간이 소요되며, 쇼핑몰마다 걸리는 시간은 다릅니다.</li>
                <li>적립 내역의 날짜는 구매 또는 주문일 기준 입니다.</li>
                <li>일부 쇼핑몰은 적립이 완료될 때까지 예정 내역이 보이지 않을 수 있습니다.</li>
                <li>해외 쇼핑몰 혹은 해외 결제건의 경우 구메~적립 시점의 환율 차이로 인해 적립 금액이 달라질 수 있습니다.</li>
                <li>쇼핑몰 사정과 프로모션에 따라 적립율 및 적립시점은 수시로 변경될 수 있습니다.</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div id="select-list7" class="select-list type5">
        <div class="select-head mb43">
          <p>개인정보 수집, 이용 동의</p>
          <button class="ico-close type1" type="button" onclick="onOff('#select-list7')">닫기</button>
        </div>
        <div class="select-cont mh43">
          <div class="box type3">
            <p class="title">쿠팡 쇼핑 혜택 이용을 위한 개인정보 수집 및 이용 동의서</p>
            <p class="text">“개인정보 보호법” 에 따라 아래와 같이 수집하는 개인정보의 항목, 수집 및 이용 목적, 보유 및 이용 기간을 안내드리고 동의를 받고자 합니다.</p>
          </div>
          <div class="box">
            <p class="title">개인정보</p>
            <div class="table-wrap">
              <table class="type1">
                <thead>
                  <tr>
                    <th class="mw160px">구분(업무명)</th>
                    <th class="mw160px">처리 목적</th>
                    <th class="mw160px">항목</th>
                    <th class="mw160px">보유 및 이용기간</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>(선택) 쿠팡 쇼핑 혜택</td>
                    <td>
                      <p class="dot">쿠팡 쇼핑 혜택 서비스 제공</p>
                      <p class="dot">서비스 이용 내역 제공</p>
                      <p class="dot">서비스 환경의 유지</p>
                      <p class="dot">관리 및 개선</p>
                    </td>
                    <td>필수 : 구매내역 (주문번호, 상품명, 주문상태(구매, 취소), 구매(취소) 일자, 구매(취소) 수량, 구매(취소) 금액, ADID 또는 IDFA</td>
                    <td>회원 탈퇴일로부터 1년</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <p class="text">
              정보주체는 위와 같이 선택목적을 위해 앱 내 설정 페이지에서 개인정보를 처리하는 것에 대한 동의를 거부할 권리가 있습니다. 그러나 동의를 거부할 경우 쿠팡 쇼핑 서비스 이용이 제한될 수 있습니다.
              <br><br>
              이에 본인은 위와 같이 개인정보를 수집 및 이용하는데 동의 합니다.
            </p>
          </div>
          <div class="btn-box fix">
            <button class="btn" type="button" onclick="onOff('#select-list7')">확인</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="<?= $appApiUrl; ?>/js/common.js?version=<?= $cacheVersion; ?>"></script>
  <script src="<?= $appApiUrl; ?>/js/page.js?version=<?= $cacheVersion; ?>"></script>
</body>

</html>
<script>
  $(function() {
    getSettingData();
  });

  // 카드 할인 알림 - 카드 리스트 조회
  function getCardList() {
    try {
      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        site: '<?= $checkSite; ?>'
      }

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cardSearch',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          renderCardList(result.datas);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error)
    }
  }

  // 카드 할인 알림 - 카드 리스트 렌더링
  function renderCardList(data) {
    let list = '';
    data.forEach((item, index) => {
      list += `
              <div id="card-item${index}" class="item ${item.userId ? 'on' : ''}" onclick="onOff('#card-item${index}')" data-code=${item.merchantCode}>
                <span style="background-image: url(./images/card/${item.codeName}.png);"></span>
                <p>${item.codeName}</p>
              </div>
              `;
    });
    $('.card-list').empty();
    $('.card-list').append(list);
  }

  // 카드 할인 알림 - 카드 선택 처리
  function postCardList() {
    try {
      let cardList = [];
      let apiType = 'I';

      const list = document.querySelectorAll('.card-list .item');
      list.forEach(elm => {
        if (elm.classList.contains('on')) {
          cardList.push({
            userId: '<?= $checkUserId; ?>',
            affliateId: '<?= $checkAffliateId; ?>',
            site: '<?= $checkSite; ?>',
            card: elm.getAttribute('data-code')
          })
        }
      })

      if (cardList.length === 0) {
        apiType = 'D';
        list.forEach(elm => {
          cardList.push({
            userId: '<?= $checkUserId; ?>',
            affliateId: '<?= $checkAffliateId; ?>',
            site: '<?= $checkSite; ?>',
            card: elm.getAttribute('data-code')
          })
        })
      }

      const requestData = {
        apiType: apiType,
        cardDataList: cardList
      }

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cardSetting',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          selectInputClose('#select-wrap', '#select-list1')
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  // 설정 데이터
  let settingDataNull = false;

  function getSettingData() {
    try {
      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        site: '<?= $checkSite; ?>'
      }

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cartSettingSearch',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') return alert(result.resultMessage);
          if (!result.data) return settingDataNull = true;
          changeSettingData(result.data);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error)
    }
  }

  function changeSettingData(data) {
    const wowToggle = document.getElementById('toggle-btn1');
    data.rocketStatus === 'Y' ? wowToggle.classList.add('on') : wowToggle.classList.remove('on');

    const nightAlarmToggle = document.getElementById('toggle-btn2');
    data.nightAlarm === 'Y' ? nightAlarmToggle.classList.add('on') : nightAlarmToggle.classList.remove('on');

    const rocketAlarmToggle = document.getElementById('toggle-btn3');
    data.rocketAlarm === 'Y' ? rocketAlarmToggle.classList.add('on') : rocketAlarmToggle.classList.remove('on');

    const returnAlarmToggle = document.getElementById('toggle-btn4');
    data.returnAlarm === 'Y' ? returnAlarmToggle.classList.add('on') : returnAlarmToggle.classList.remove('on');

    // const coupangAgreeToggle = document.getElementById('toggle-btn5');
    // data.coupang === 'Y' ? coupangAgreeToggle.classList.add('on') : coupangAgreeToggle.classList.remove('on');

    // 알림 감도
    const priceAlarmPer = document.getElementById('priceAlarmPer');
    switch (data.priceDiscount) {
      case 1:
        priceAlarmPer.querySelector('#alarm-item1').checked = true;
        break;
      case 3:
        priceAlarmPer.querySelector('#alarm-item2').checked = true;
        break;
      case 5:
        priceAlarmPer.querySelector('#alarm-item3').checked = true;
        break;
      case 7:
        priceAlarmPer.querySelector('#alarm-item4').checked = true;
        break;
    }

    const cardAlarmPer = document.getElementById('cardAlarmPer');
    switch (data.cardDiscount) {
      case 1:
        cardAlarmPer.querySelector('#alarm-item5').checked = true;
        break;
      case 3:
        cardAlarmPer.querySelector('#alarm-item6').checked = true;
        break;
      case 5:
        cardAlarmPer.querySelector('#alarm-item7').checked = true;
        break;
      case 7:
        cardAlarmPer.querySelector('#alarm-item8').checked = true;
        break;
    }

    const returnAlarmPer = document.getElementById('returnAlarmPer');
    switch (data.returnDiscount) {
      case 3:
        returnAlarmPer.querySelector('#alarm-item9').checked = true;
        break;
      case 5:
        returnAlarmPer.querySelector('#alarm-item10').checked = true;
        break;
      case 7:
        returnAlarmPer.querySelector('#alarm-item11').checked = true;
        break;
      case 10:
        returnAlarmPer.querySelector('#alarm-item12').checked = true;
        break;
    }
  }

  function coupangCheck() {
    onOff('#toggle-btn5');
    postSettingData();
    selectInputClose('#select-wrap', '#select-list5');
  }

  function alarmCheck(type) {
    type === 'rocket' ? document.getElementById('toggle-btn3').classList.add('on') : document.getElementById('toggle-btn3').classList.remove('on');
    postSettingData();
    selectListClose('#select-btn2', '#select-wrap', '#select-list2');
  }

  function postSettingData() {
    try {
      const requestData = {
        userId: '<?= $checkUserId; ?>',
        affliateId: '<?= $checkAffliateId; ?>',
        site: '<?= $checkSite; ?>',
        rocketStatus: document.getElementById('toggle-btn1').classList.contains('on') ? 'Y' : 'N',
        nightAlarm: document.getElementById('toggle-btn2').classList.contains('on') ? 'Y' : 'N',
        rocketAlarm: document.getElementById('toggle-btn3').classList.contains('on') ? 'Y' : 'N',
        returnAlarm: document.getElementById('toggle-btn4').classList.contains('on') ? 'Y' : 'N',
        // coupang: document.getElementById('toggle-btn5').classList.contains('on') ? 'Y' : 'N',
        priceDiscount: document.querySelector('input[name="alarm-list1"]:checked').value,
        cardDiscount: document.querySelector('input[name="alarm-list2"]:checked').value,
        returnDiscount: document.querySelector('input[name="alarm-list3"]:checked').value,
        apiType: settingDataNull ? 'I' : 'U'
      };

      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/cart/cartSetting',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') return alert(result.resultMessage);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      })
    } catch (error) {
      alert(error);
    }
  }
</script>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<?
$campaign = $_REQUEST['campaign'];
if (!$campaign) {
?>
  <script>
    alert('잘못된 접근입니다.');
    history.back();
  </script>
<?
}
?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>1:1 문의하기</title>
  <!-- style -->

  <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js?version=<?= $cacheVersion; ?>"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js?version=<?= $cacheVersion; ?>"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css?version=<?= $cacheVersion; ?>" />
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>1:1 문의하기</h1>
      <div class="btn-list">
        <a href="javascript:history.back()" class="ico-arrow type1 left">이전</a>
      </div>
    </header>
    <!-- main -->
    <!-- hana 클래스 추가 시 시그니처 컬러 변경 -->
    <div class="sub sub-4">
      <div class="box box1">
        <p class="title">문의 답변 기한</p>
        <div class="gray-box">
          <ul>
            <li>
              문의 신청 후 대부분 2주 이내 답변이 가능하나,
              쇼핑몰에 따라 60일 이상 소요될 수 있으며,
              여행 관련 쇼핑몰은 이용 완료일로부터
              최대 120일가지 소요될 수 있습니다
            </li>
          </ul>
        </div>
        <p class="title">주요 누락/취소 사유</p>
        <div class="gray-box">
          <ul>
            <li>‘쇼핑적립 상세정보’ 페이지의 “쇼핑하고 적립받기” 를 클릭하지 않고 구매한 경우</li>
            <li>구매일로부터 구매한 쇼핑몰의 적립 시점이 지나지 않은 경우. 쇼핑적립 상세 정보에서 확인 가능 합니다.</li>
            <li>주문건을 취소/환불/교환한 경우</li>
            <li>쇼핑적립을 클릭 후 연속으로 주문한 경우는 한 건만 캐시적립이 됩니다. 주문건 마다 쇼핑적립을 클릭해서 쇼핑몰로 이동 후 주문해 주세요.</li>
          </ul>
        </div>
      </div>
      <div class="form-box-wrap">
        <div class="type-check-input-box">
          <div id="select-btn1" class="select-btn type1" onclick="selectListOn('#select-btn1', '#select-wrap', '#select-list1')">
            <p id="ask-value" class="value on">누락문의</p>
            <div class="ico-arrow type1"></div>
          </div>
        </div>
        <!-- 누락문의 -->
        <div id="form-box1" class="form-box on">
          <div class="input-box">
            <div id="select-btn2" class="select-btn type1" onclick="selectListOn('#select-btn2', '#select-wrap', '#select-list2')">
              <p class="value">구매 쇼핑몰을 선택해주세요(필수)</p>
              <div class="ico-arrow type1"></div>
            </div>
          </div>
          <div class="input-box">
            <div id="select-btn3" class="select-btn type1" onclick="selectListOn('#select-btn3', '#select-wrap', '#select-list3')">
              <p class="value">문의 목적을 선택해주세요(필수)</p>
              <div class="ico-arrow type1"></div>
            </div>
          </div>
          <div class="input-box">
            <input id="datepicker" type="text" placeholder="구매일을 선택해주세요(필수)">
          </div>
          <div class="input-box">
            <input id="name" type="text" placeholder="성함을 입력해주세요(필수)">
          </div>
          <div class="input-box">
            <input id="orderNumber" type="text" placeholder="주문번호를 입력해주세요(필수)">
            <p>구매하신 쇼핑몰의 주문내역에서 확인이 가능합니다.</p>
          </div>
          <div class="input-box">
            <div id="select-btn4" class="select-btn type1" onclick="selectListOn('#select-btn4', '#select-wrap', '#select-list4')">
              <p class="value">결제 통화를 선택해주세요(필수)</p>
              <div class="ico-arrow type1"></div>
            </div>
          </div>
          <div class="input-box">
            <div id="select-btn5" class="select-btn type1" onclick="selectListOn('#select-btn5', '#select-wrap', '#select-list5')">
              <p class="value">결제 수단을 선택해주세요(필수)</p>
              <div class="ico-arrow type1"></div>
            </div>
          </div>
          <div class="input-box">
            <input id="productPrice" type="text" placeholder="상품 금액을 입력해주세요(필수)">
          </div>
          <div class="input-box">
            <input id="productCnt" type="text" placeholder="상품 수량을 입력해주세요(필수)">
          </div>
          <div class="input-box">
            <textarea id="content" rows="10" placeholder="문의하실 내용을 입력해주세요"></textarea>
          </div>
          <div class="input-box">
            <input id="email" type="text" placeholder="이메일 주소를 입력해주세요(필수)">
            <p>기재하시는 메일 주소로 안내 드립니다.</p>
          </div>
          <div class="input-box">
            <input type="checkbox" id="check_1">
            <label for="check_1">
              <i class="ico-check"></i>
              <i class="ico-check on"></i>
              상담 신청을 위한 개인정보 수신동의
            </label>
          </div>
          <div class="gray-box">
            <p>
              (주)인라이플은 1:1 문의 내역에 대해 관리하는 회사 입니다.
              수집한 정보는 문의 이외의 목적으로 사용하지 않으며 관련 법령 및 내부 정책에 따라 3년간 보관 후 파기 합니다.
              개인정보 수집 및 이용에 대한 동의를 거부할 수 있으며, 이 경우 문의 접수가 제한 됩니다.
            </p>
          </div>
          <a class="submit-btn on" href="javascript:void(0)" onclick="checkInquiryData()">문의하기</a>
        </div>
        <!-- 기타문의 -->
        <div id="form-box2" class="form-box">
          <div class="input-box">
            <input id="title" type="text" placeholder="제목을 입력해주세요(필수)">
          </div>
          <div class="input-box">
            <textarea id="content2" rows="10" placeholder="문의하실 내용을 입력해주세요(필수)"></textarea>
            <p>적립누락은 누락문의로 접수해주셔야 처리됩니다.</p>
          </div>
          <div class="input-box">
            <input id="name2" type="text" placeholder="성함을 입력해주세요(필수)">
          </div>
          <div class="input-box">
            <input id="email2" type="text" placeholder="이메일 주소를 입력해주세요(필수)">
          </div>
          <div class="file-box">
            <p class="title">첨부 파일</p>
            <div class="file-info">
              <input type="file" id="file-1" multiple>
              <label for="file-1">파일선택</label>
              <p class="size">0Byte</p>
            </div>
            <div class="file-list"></div>
          </div>
          <div class="gray-box">
            <ul>
              <li>오류 지면의 경우 이미지를 함께 첨부해 주시면 빠른 확인 가능합니다.</li>
              <li>첨부한 파일 의 전체 크기는 10Mbyte 미만이어야 합니다.</li>
              <li>파일 첨부는 JPG / PNG / GIF / PDF 만 가능합니다.</li>
            </ul>
          </div>
          <a class="submit-btn on" href="javascript:void(0)" onclick="checkInquiryData()">문의하기</a>
        </div>
      </div>
    </div>
    <!-- select-wrap -->
    <div id="select-wrap">
      <!-- select-list1 -->
      <div id="select-list1" class="select-list">
        <div class="select-head">
          <p>문의 종류 선택</p>
          <button class="ico-close type1" type="button" onclick="selectListClose('#select-btn1', '#select-wrap', '#select-list1')">닫기</button>
        </div>
        <ul class="select-cont">
          <li id="ask1" class="list list1 select-ask on" onclick="formBoxOn('.select-ask', '#ask1', '누락문의', '#ask-value', '.form-box', '#form-box1')">
            <p class="value">누락문의</p>
            <div class="ico-check on"></div>
          </li>
          <li id="ask2" class="list list2 select-ask" onclick="formBoxOn('.select-ask', '#ask2', '기타문의', '#ask-value', '.form-box', '#form-box2')">
            <p class="value">기타문의</p>
            <div class="ico-check"></div>
          </li>
        </ul>
      </div>
      <!-- select-list2 -->
      <div id="select-list2" class="select-list">
        <div class="select-head">
          <p>구매 쇼핑몰 선택</p>
          <button class="ico-close type1" type="button" onclick="selectListClose('#select-btn2', '#select-wrap', '#select-list2')">닫기</button>
        </div>
        <ul id="shoppingMallList" class="select-cont"></ul>
      </div>
      <!-- select-list3 -->
      <div id="select-list3" class="select-list">
        <div class="select-head">
          <p>문의 목적 선택</p>
          <button class="ico-close type1" type="button" onclick="selectListClose('#select-btn3', '#select-wrap', '#select-list3')">닫기</button>
        </div>
        <ul class="select-cont">
          <li class="list list1 ">
            <p class="value">쇼핑적립 이용내역”의 구매금액과 결제 금액과 차이가 있어요.</p>
            <div class="ico-check"></div>
          </li>
          <li class="list list2">
            <p class="value">구매를 했는데, “적립 상세 내역” 이 보이지 않아요.</p>
            <div class="ico-check"></div>
          </li>
          <li class="list list3">
            <p class="value">구매를 했는데, 실제 결제 금액과 “적립 상세 내역” 구매 금액이 차이가 있어요.</p>
            <div class="ico-check"></div>
          </li>
          <li class="list list4">
            <p class="value">구매를 했는데, 적립 예정 포인트 금액이 0원으로 보여요.</p>
            <div class="ico-check"></div>
          </li>
          <li class="list list5">
            <p class="value">기타</p>
            <div class="ico-check"></div>
          </li>
        </ul>
      </div>
      <!-- select-list4 -->
      <div id="select-list4" class="select-list">
        <div class="select-head">
          <p>결제 통화 선택</p>
          <button class="ico-close type1" type="button" onclick="selectListClose('#select-btn4', '#select-wrap', '#select-list4')">닫기</button>
        </div>
        <ul class="select-cont">
          <li class="list list1">
            <p class="value">원화</p>
            <div class="ico-check"></div>
          </li>
          <li class="list list2">
            <p class="value">US달러</p>
            <div class="ico-check"></div>
          </li>
          <li class="list list3">
            <p class="value">엔화</p>
            <div class="ico-check"></div>
          </li>
          <li class="list list4">
            <p class="value">위안화</p>
            <div class="ico-check"></div>
          </li>
          <li class="list list5">
            <p class="value">유로화</p>
            <div class="ico-check"></div>
          </li>
        </ul>
      </div>
      <!-- select-list5 -->
      <div id="select-list5" class="select-list">
        <div class="select-head">
          <p>결제 수단 선택</p>
          <button class="ico-close type1" type="button" onclick="selectListClose('#select-btn5', '#select-wrap', '#select-list5')">닫기</button>
        </div>
        <ul class="select-cont">
          <li class="list list1">
            <p class="value">신용카드</p>
            <div class="ico-check"></div>
          </li>
          <li class="list list2">
            <p class="value">무통장입금</p>
            <div class="ico-check"></div>
          </li>
          <li class="list list3">
            <p class="value">핸드폰결제</p>
            <div class="ico-check"></div>
          </li>
          <li class="list list4">
            <p class="value">ARS결제</p>
            <div class="ico-check"></div>
          </li>
          <li class="list list5">
            <p class="value">실시간 계좌이체</p>
            <div class="ico-check"></div>
          </li>
          <li class="list list6">
            <p class="value">기타</p>
            <div class="ico-check"></div>
          </li>
        </ul>
      </div>
    </div>

    <!-- popup-wrap -->
    <div id="popup-wrap">
      <!-- popup1 -->
      <div class="popup popup1">
        <div class="box">
          <p>문의사항이<br>접수 되었습니다.</p>
          <div class="btn-box">
            <button class="popup-btn" type="button" onclick="location.reload()">확인</button>
          </div>
        </div>
      </div>

      <!-- popup2 -->
      <div class="popup popup2">
        <div class="box">
          <p>문의사항이<br>접수 되었습니다.</p>
          <div class="btn-box">
            <button class="popup-btn" type="button" onclick="location.reload()">확인</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://app.shoplus.io/js/common.js?version=<?= $cacheVersion; ?>"></script>
<script src="https://app.shoplus.io/js/page.js?version=<?= $cacheVersion; ?>"></script>

</html>
<script>
  $(function() {
    getShoppingMallList();

    $("#datepicker").daterangepicker({
      autoUpdateInput: false,
      singleDatePicker: true,
      autoApply: true,
      opens: 'center',
      drops: 'auto',
      maxDate: moment(),
      locale: {
        format: "YYYY-MM-DD",
        daysOfWeek: ["일", "월", "화", "수", "목", "금", "토"],
        monthNames: [
          "01",
          "02",
          "03",
          "04",
          "05",
          "06",
          "07",
          "08",
          "09",
          "10",
          "11",
          "12",
        ],
      }
    });

    $('#datepicker').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD'));
    });
  })

  // 입력값 검증
  function checkInquiryData() {
    // 문의 종류
    const inquiryType = document.getElementById('select-list1').querySelector('.list.on .value').textContent;

    if (inquiryType === '누락문의') {
      omissioninquiry();
    } else if (inquiryType === '기타문의') {
      etcinquiry();
    } else {
      alert('잘못된 접근입니다.');
    }
  }

  // 누락문의검증
  function omissioninquiry() {
    // 구매 쇼핑몰 
    if (!document.getElementById('select-btn2').querySelector('p.value').classList.contains('on')) {
      return alert('구매 쇼핑몰을 선택해주세요.');
    }

    // 문의 목적
    if (!document.getElementById('select-btn3').querySelector('p.value').classList.contains('on')) {
      return alert('문의 목적을 선택해주세요.');
    }

    // 구매일
    if (!document.getElementById('datepicker').value) {
      return alert('구매일을 선택해주세요.');
    }

    // 성함
    if (!document.getElementById('name').value) {
      return alert('성함을 입력해주세요.');
    }

    // 주문번호
    if (!document.getElementById('orderNumber').value) {
      return alert('주문번호를 입력해주세요.');
    }

    // 결제통화
    if (!document.getElementById('select-btn4').querySelector('p.value').classList.contains('on')) {
      return alert('문의 목적을 선택해주세요.');
    }

    // 결제수단
    if (!document.getElementById('select-btn5').querySelector('p.value').classList.contains('on')) {
      return alert('문의 목적을 선택해주세요.');
    }

    // 상품금액
    if (!document.getElementById('productPrice').value) {
      return alert('상품 금액을 입력해주세요.');
    }

    // 상품수량
    if (!document.getElementById('productCnt').value) {
      return alert('상품 수량을 입력해주세요.');
    }

    // 이메일
    if (!document.getElementById('email').value) {
      return alert('이메일을 입력해주세요.');
    }

    postinquiry('ommission');
  }

  // 기타문의검증
  function etcinquiry() {
    // 제목
    if (!document.getElementById('title').value) {
      return alert('제목을 입력해주세요');
    }

    // 내용
    if (!document.getElementById('content2').value) {
      return alert('문의하실 내용을 입력해주세요.');
    }

    // 성함
    if (!document.getElementById('name2').value) {
      return alert('성함을 입력해주세요.');
    }

    // 이메일
    if (!document.getElementById('email2').value) {
      return alert('이메일을 입력해주세요.');
    }

    if (document.querySelector('.file-list').childElementCount > 0) {
      postFileUpload();
    } else {
      postinquiry('etc');
    }
  }

  function postFileUpload() {
    try {
      const fileInput = document.getElementById('file-1');
      const requestData = new FormData();

      const files = fileInput.files;
      for (let i = 0; i < files.length; i++) {
        requestData.append('files[]', files[i]);
      }

      requestData.append('affliateId', '<?= $checkAffliateId; ?>');
      requestData.append('userId', '<?= $checkUserId; ?>');

      $.ajax({
        type: 'POST',
        url: '/inquiry/file-upload.php',
        data: requestData,
        processData: false,
        contentType: false,
        dataType: 'JSON',
        success: function(result) {
          if (result.resultCode !== 'success') return alert(result.resultMessage);
          const fileList = result.datas;
          postinquiry('etc', fileList);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  function postinquiry(type, fileList) {
    try {

      let requestData = {
        inquiryNum: 0,
        note: '',
        userId: '<?= $checkUserId; ?>',
        inquiryType: '',
        campaignNum: <?= $campaign; ?>,
        affliateId: '<?= $checkAffliateId; ?>',
        merchantId: '',
        purpose: '',
        regDay: 0,
        userName: '',
        orderNo: '',
        productCode: '',
        currency: '',
        payment: '',
        productPrice: 0,
        productCnt: 0,
        email: '',
        information: 'N',
        answerYn: '',
        inqueryFileList: []
      }

      if (type === 'ommission') {
        requestData.inquiryType = '누락문의';
        requestData.merchantId = document.getElementById('shoppingMallList').querySelector('.list.on .value').getAttribute('data-id');
        requestData.purpose = document.getElementById('select-btn3').querySelector('.value.on').textContent;
        requestData.regDay = parseInt(document.getElementById('datepicker').value.replaceAll('-', ''));
        requestData.userName = document.getElementById('name').value;
        requestData.orderNo = document.getElementById('orderNumber').value;
        requestData.currency = document.getElementById('select-list4').querySelector('.list.on .value').textContent;
        requestData.payment = document.getElementById('select-list5').querySelector('.list.on .value').textContent;
        requestData.productPrice = document.getElementById('productPrice').value;
        requestData.productCnt = document.getElementById('productCnt').value;
        requestData.note = document.getElementById('content').value;
        requestData.email = document.getElementById('email').value;
        requestData.information = document.getElementById('check_1').checked ? 'Y' : 'N';
      } else if (type === 'etc') {
        requestData.inquiryType = '기타문의';
        requestData.purpose = document.getElementById('title').value;
        requestData.note = document.getElementById('content2').value;
        requestData.userName = document.getElementById('name2').value;
        requestData.email = document.getElementById('email2').value;
        requestData.inqueryFileList = fileList && fileList.length > 0 ? fileList : []
      } else {
        return alert('잘못된 접근입니다.');
      }

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/view/inquiry',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode !== '0000') return alert(result.resultMessage);
          popupOn('#popup-wrap', '.popup1');
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });

    } catch (error) {
      alert(error);
    }
  }

  function getShoppingMallList() {
    try {
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/view/inquiryMerchantList',
        contentType: 'application/json',
        success: function(result) {
          renderShoppingMallList(result);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  function renderShoppingMallList(result) {
    let list = '';
    const data = result.datas;

    data.forEach((item, index) => {
      list += `
              <li class="list list${index}">
                <p class="value" data-id="${item.merchantId}">${item.merchantName}</p>
                <div class="ico-check"></div>
              </li>
              `;
    });

    $('#shoppingMallList').empty();
    $('#shoppingMallList').append(list);
  }
</script>
<?php
$object = $_REQUEST['object'] ?? null; // null로 기본값 설정
if (!$object) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

// 여기서 object를 JSON으로 인코딩
$objectJson = json_encode($object);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <title>기프티콘 상세정보</title>
    <link rel="icon" type="image/x-icon" href="/view/images/favicon.ico">
    <!-- style -->
    <link rel="stylesheet" href="/view/css/style.css">
    <script type="text/javascript" src="/admin/js/lib/jquery-2.2.2.min.js"></script>
    <script type="text/javascript" src="/admin/js/lib/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="/admin/js/lib/jquery-ui.min.js"></script>
</head>

<body>
    <div class="wrap">
        <!-- header -->
        <header>
            <h1>기프티콘 상세정보</h1>
            <div class="btn-list">
                <a href="/view/history/gifticon.php" class="ico-arrow type1 left">이전</a>
            </div>
        </header>
        <!-- main -->
        <!-- hana 클래스 추가 시 시그니처 컬러 변경 -->
        <div class="sub sub-5-3-2">
            <div class="box box1">
                <!-- 기프티콘 상세 사용가능 -->
                <div class="giftcon-info-wrap" style="margin-bottom: 20px;">
                    <div class="goods-info-box">
                        <div class="goods-img" style="background-image: url(/view/images/test/스타벅스상품.png);"></div>
                        <div class="logo-box">
                            <div class="logo" style="background-image: url(/view/images/test/스타벅스로고.png);"></div>
                            <p class="logo-title">스타벅스</p>
                        </div>
                        <p class="title">아이스 카페 아메리카노 T</p>
                    </div>
                    <div class="date-info-box">
                        <div class="date-box date-box1">
                            <p class="text">당첨일자</p>
                            <p class="date"></p>
                        </div>
                        <div class="date-box date-box2">
                            <p class="text">유효기간</p>
                            <p class="date"></p>
                        </div>
                        <p class="text">*교환이나 환불, 유효기간은 연장이 불가합니다.</p>
                    </div>
                    <div class="barcode-box">
                        <div class="barcode" style="background-image: url(/view/images/test/barcode1.png);"></div>
                    </div>
                    <p class="title">유의사항</p>
                    <div class="gray-box">
                        <p class="title">상품고시정보</p>
                        <ul>
                            <li>발행자 : 주식회사 인라이플</li>
                            <li>교환권 공급자 : (주)OOO마케팅</li>
                        </ul>
                        <p class="title">유효기간</p>
                        <ul>
                            <li>각 상품 상세페이지 내 유효기간 확인</li>
                        </ul>
                        <p class="title">이용조건(유효기간 경과시 보상 기준 포함)</p>
                        <ul>
                            <li>본상품의 매장 별 판매가격이 상이 할 수 있으며, 일부 매장에서는 추가금액 결제 후 교환 가능합니다.</li>
                            <li>물품교환권은 구매일로부터 180일 이내, 금액 교환권은 270일 이내 2회 기간연장 가능합니다.</li>
                            <li>상품에 따라 기간 연장이 불가한 상품이 있으니, 상품 설명을 참고하시기 바랍니다.</li>
                        </ul>
                    </div>
                </div>

                <!-- 기프티콘 상세 사용완료 -->
                <!-- <div class="giftcon-info-wrap type3">
                    <div class="goods-info-box">
                        <div class="goods-img" style="background-image: url(/view/images/test/스타벅스상품.png);"></div>
                        <div class="logo-box">
                            <div class="logo" style="background-image: url(/view/images/test/스타벅스로고.png);"></div>
                            <p class="logo-title">스타벅스</p>
                        </div>
                        <p class="title">아이스 카페 아메리카노 T</p>
                    </div>
                    <div class="date-info-box">
                        <div class="date-box date-box1">
                            <p class="text">당첨일자</p>
                            <p class="date">2024.09.30</p>
                        </div>
                        <div class="date-box date-box2">
                            <p class="text">유효기간</p>
                            <p class="date">2024.10.30</p>
                        </div>
                        <p class="text">*교환이나 환불, 유효기간은 연장이 불가합니다.</p>
                    </div>
                    <div class="barcode-box">
                        <div class="barcode" style="background-image: url(/view/images/test/barcode1.png);"></div>
                        <p class="state blue">사용완료</p>
                    </div>
                    <p class="title">유의사항</p>
                    <div class="gray-box">
                        <p class="title">상품고시정보</p>
                        <ul>
                            <li>발행자 : 주식회사 인라이플</li>
                            <li>교환권 공급자 : (주)OOO마케팅</li>
                        </ul>
                        <p class="title">유효기간</p>
                        <ul>
                            <li>각 상품 상세페이지 내 유효기간 확인</li>
                        </ul>
                        <p class="title">이용조건(유효기간 경과시 보상 기준 포함)</p>
                        <ul>
                            <li>본상품의 매장 별 판매가격이 상이 할 수 있으며, 일부 매장에서는 추가금액 결제 후 교환 가능합니다.</li>
                            <li>물품교환권은 구매일로부터 180일 이내, 금액 교환권은 270일 이내 2회 기간연장 가능합니다.</li>
                            <li>상품에 따라 기간 연장이 불가한 상품이 있으니, 상품 설명을 참고하시기 바랍니다.</li>
                        </ul>
                    </div>
                </div> -->
                <!-- 기프티콘 상세 사용만료 -->
                <!-- <div class="giftcon-info-wrap type3">
                    <div class="goods-info-box">
                        <div class="goods-img" style="background-image: url(/view/images/test/스타벅스상품.png);"></div>
                        <div class="logo-box">
                            <div class="logo" style="background-image: url(/view/images/test/스타벅스로고.png);"></div>
                            <p class="logo-title">스타벅스</p>
                        </div>
                        <p class="title">아이스 카페 아메리카노 T</p>
                    </div>
                    <div class="date-info-box">
                        <div class="date-box date-box1">
                            <p class="text">당첨일자</p>
                            <p class="date">2024.09.30</p>
                        </div>
                        <div class="date-box date-box2">
                            <p class="text">유효기간</p>
                            <p class="date">2024.10.30</p>
                        </div>
                        <p class="text">*교환이나 환불, 유효기간은 연장이 불가합니다.</p>
                    </div>
                    <div class="barcode-box">
                        <div class="barcode" style="background-image: url(/view/images/test/barcode1.png);"></div>
                        <p class="state red">사용만료</p>
                    </div>
                    <p class="title">유의사항</p>
                    <div class="gray-box">
                        <p class="title">상품고시정보</p>
                        <ul>
                            <li>발행자 : 주식회사 인라이플</li>
                            <li>교환권 공급자 : (주)OOO마케팅</li>
                        </ul>
                        <p class="title">유효기간</p>
                        <ul>
                            <li>각 상품 상세페이지 내 유효기간 확인</li>
                        </ul>
                        <p class="title">이용조건(유효기간 경과시 보상 기준 포함)</p>
                        <ul>
                            <li>본상품의 매장 별 판매가격이 상이 할 수 있으며, 일부 매장에서는 추가금액 결제 후 교환 가능합니다.</li>
                            <li>물품교환권은 구매일로부터 180일 이내, 금액 교환권은 270일 이내 2회 기간연장 가능합니다.</li>
                            <li>상품에 따라 기간 연장이 불가한 상품이 있으니, 상품 설명을 참고하시기 바랍니다.</li>
                        </ul>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <script src="/view/js/common.js"></script>
    <script src="/view/js/page.js"></script>
</body>

</html>
<script>
    const object = JSON.parse(<?= $objectJson ?>); // PHP에서 만든 JSON 문자열을 객체로 변환

    $(function() {
        renderGifticonDetail(object); // 함수 호출
    });


    function renderGifticonDetail(object) {
        try {
            if (!object) {
                alert('존재하지않는 기프티콘입니다.');
                history.back();
                return
            }

            const item = object;
            console.log(item);
            $('.giftcon-info-wrap').addClass(item.giftYn === 'N' ? '' : 'type3');

            $('.date-box1 .date').append(formatDate(item.awardDay));
            $('.date-box2 .date').append(formatDate(item.validDay));

        } catch (error) {
            alert(error);
        }
    }
</script>
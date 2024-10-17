<?
// 로그인 유저 아이디
$userId = $_REQUEST['userId'];
// 매체 아이디
$affliateId = $_REQUEST['affliateId'];
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <title>쇼핑적립</title>
    <link rel="icon" type="image/x-icon" href="/view/images/favicon.ico">
    <script type="text/javascript" src="/admin/js/lib/jquery-2.2.2.min.js"></script>
    <script type="text/javascript" src="/admin/js/lib/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="/admin/js/lib/jquery-ui.min.js"></script>
    <!-- style -->
    <link rel="stylesheet" href="/view/css/style.css">
    <link rel="stylesheet" href="/view/css/index.css">
</head>

<body>
    <div class="wrap">
        <!-- header -->
        <header>
            <h1>쇼핑적립</h1>
            <div class="btn-list">
                <a href="javascript:history.back()" class="ico-arrow type1 left">이전</a>
                <a href="/view/index.php" class="ico-home">홈</a>
            </div>
        </header>
        <!-- main -->
        <!-- hana class 추가 시 시그니처 컬러 변경 -->
        <div class="main">
            <div id="event-popup1" class="event-popup on">
                <div class="event-cont">
                    <div class="logo" style="background-image: url(/view/images/test/지마켓.png);"></div>
                    <p>지마켓 수수료 2% 상향 이벤트<span>기간 : 10/1 ~ 10/30</span></p>
                </div>
                <a href="javascript:void(0)"></a>
                <button class="close" onclick="eventPopupClose('#event-popup1')"></button>
            </div>
            <div class="point-info-wrap">
                <div class="point-info">
                    <div class="text-box">
                        <p class="title">총 적립 포인트</p>
                        <p id="userCommission" class="point"></p>
                    </div>
                    <a href="/view/history/point.php"></a>
                </div>
            </div>
            <div class="tab-box-wrap">
                <div class="tab-box">
                    <div class="tab tab1 on"><a href="javascript:getCampaignView('')">인기순</a></div>
                    <div class="tab tab2"><a href="javascript:getCampaignView('')">종합몰</a></div>
                    <div class="tab tab3"><a href="javascript:getCampaignView('')">패션</a></div>
                    <div class="tab tab4"><a href="javascript:getCampaignView('')">뷰티</a></div>
                    <div class="tab tab5"><a href="javascript:getCampaignView('favorites')">즐겨찾기</a></div>
                </div>
            </div>
            <div class="list-wrap type1">
                <div id="coupangArea" class="list list1 type1"></div>
                <div class="campaign-list" id="campaign-list"></div>
            </div>
        </div>
        <div class="bottom-menu-wrap">
            <a class="menu" href="javascript:void(0)"><span class="ico-cart">카트</span></a>
            <a class="menu on" href="/view/index.php"><span class="ico-save">적립</span></a>
            <a class="menu" href="javascript:void(0)"><span class="ico-trend">트렌드</span></a>
            <a class="menu" href="javascript:void(0)"><span class="ico-delivery">배송</span></a>
            <a class="menu" href="/view/history/point.php"><span class="ico-breakDown">내역</span></a>
        </div>
    </div>
    <script src="./js/common.js"></script>
</body>

</html>
<script>
    $(function() {
        // getBanner();
        getMemberCommission();
        getCampaignView();
    })

    // 배너 조회
    // function getBanner() {
    //   return console.log('배너 조회 호출');

    //   try {
    //     // AJAX 요청 데이터 설정
    //     const requestData = {

    //     };

    //     // AJAX 요청 수행
    //     $.ajax({
    //       type: 'POST',
    //       url: 'http://192.168.101.156/api/view/',
    //       contentType: 'application/json',
    //       data: JSON.stringify(requestData),
    //       success: function(result) {
    //         const banner = `
    //                         <div id="event-popup1" class="event-popup on">
    //                           <div class="event-cont">
    //                             <div class="logo" style="background-image: url(./images/test/지마켓.png);"></div>
    //                             <p>지마켓 수수료 2% 상향 이벤트<span>기간 : 10/1 ~ 10/30</span></p>
    //                           </div>
    //                           <a href="javascript:void(0)"></a>
    //                           <button class="close" onclick="eventPopupClose('#event-popup1')"></button>
    //                         </div>
    //                         `;
    //         $('.main').prepend(banner);
    //       },
    //       error: function(request, status, error) {
    //         console.error(`Error: ${error}`);
    //       }
    //     });
    //   } catch (error) {
    //     alert(error.message);
    //   }
    // }

    // 회원 적립금 조회
    function getMemberCommission() {
        try {
            const userId = 'dhhan';
            const affliateId = 'moneyweather';

            // AJAX 요청 데이터 설정
            const requestData = {
                userId,
                affliateId
            };

            // AJAX 요청 수행
            $.ajax({
                type: 'POST',
                url: 'http://192.168.101.156/api/view/memberCommission',
                contentType: 'application/json',
                data: JSON.stringify(requestData),
                success: function(result) {
                    const userCommission = parseInt(result.data.userCommission).toLocaleString();
                    const appendCommission =
                        `<span class="ico-point"></span>${userCommission}<span class="ico-arrow type2 right"></span>`;
                    $('#userCommission').append(appendCommission);
                },
                error: function(request, status, error) {
                    console.error(`Error: ${error}`);
                }
            });
        } catch (error) {
            alert(error.message);
        }
    }

    // 캠페인 영역
    function getCampaignView(category) {
        try {
            // 매체 아이디
            const affliateId = 'moneyweather';
            // 지면 아이디
            const zoneId = 'zonedhhan';
            // 매체가 선택한 사이트
            const site = 'moneyweather';
            // 로그인 유저 아이디
            const userId = 'dhhan';
            // 광고 아이디
            const adId = '';
            // 기기 OS
            const os = 'AOS';

            // AJAX 요청 데이터 설정
            const requestData = {
                affliateId,
                zoneId,
                site,
                userId,
                adId,
                os,
                category: category ? category : ''
            };

            // AJAX 요청 수행
            $.ajax({
                type: 'POST',
                url: 'http://192.168.101.156/api/view/campaignView',
                contentType: 'application/json',
                data: JSON.stringify(requestData),
                success: function(result) {
                    handelCampaingView(result);
                },
                error: function(request, status, error) {
                    console.error(`Error: ${error}`);
                }
            });
        } catch (error) {
            alert(error.message);
        }
    }

    function handelCampaingView(result) {
        const data = result.datas;

        $('#campaign-list').empty();
        if (!data || data.length === 0) {
            removeCoupangArea();
            return;
        }

        let list = '';
        let checkCoupang = false;
        data.forEach(item => {
            if (item.memberName === '쿠팡') {
                checkCoupang = true;
                renderCoupangArea(item);
                return
            }
            let apiUrl = '';
            if (item.adminId === 'linkprice') {
                apiUrl = 'http://192.168.101.156/api/clickLinkPrice/campaignClick';
            } else if (item.adminId === 'dotpitch') {
                apiUrl = 'http://192.168.101.156/api/clickDotPitch/campaignClick';
            }

            // 적립률
            const commissionPer = getCommissionPer(item);

            // 해야함 - 즐겨찾기 유무 데이터 처리 필요
            list += `
              <div class="list">
                <p class="title"><span class="logo" style="background-image: url(${item.logo});"></span>${item.memberName}</p>
                <p class="percent"><span class="ico-point"></span>${commissionPer}%</p>
                <a href="/view/reward/campaign.php?clickUrl=${item.clickUrl}&apiUrl=${apiUrl}&campaignNum=${item.campaignNum}&per=${commissionPer}">바로가기</a>
                <button class="ico-heart ${item.favorites === 'FAVORITE' ? 'on' : ''}" type="button" onclick="patchFavorites(${item.campaignNum}, '${item.favorites}', this)">즐겨찾기</button>
              </div>
            `;
        });
        if (!checkCoupang) removeCoupangArea();
        $('#campaign-list').append(list);
    }

    function renderCoupangArea(item) {
        const apiUrl = 'http://192.168.101.156/api/clickCoupang/campaignClick';
        const commissionPer = getCommissionPer(item);

        const area = `
                  <p class="title">쿠팡 검색 쇼핑하고 선물 받기</p>
                  <div class="info-wrap">
                    <a id="memberStick" class="candy type1" href="/view/history/stick.php"></a>
                    <div class="coupang-search-wrap">
                      <span class="logo">쿠팡</span>
                      <input type="text" placeholder="쿠팡에서 검색" disabled>
                      <a href="/view/reward/campaign.php?clickUrl=${item.clickUrl}&apiUrl=${apiUrl}&campaignNum=${item.campaignNum}&per=${commissionPer}">검색</a>
                    </div>
                  </div>
                  <div class="link-wrap">
                    <div class="link-box"><a href="/view/history/gifticon.php">당첨내역</a></div>
                    <div class="link-box"><a href="/view/event/roulette.php">행운의룰렛 GO</a></div>
                    <div class="link-box"><a href="/view/event/roulette-notice.php">이벤트 안내</a></div>
                  </div>
                  <button class="ico-heart ${item.favorites === 'FAVORITE' ? 'on' : ''}" type="button" onclick="patchFavorites(${item.campaignNum}, '${item.favorites}', this)"></button>
                  `;
        removeCoupangArea();
        $('#coupangArea').append(area);
        getMemberStick();
    }

    function removeCoupangArea() {
        $('#coupangArea').empty();
    }

    // 쿠팡 막대사탕 조회
    function getMemberStick() {
        try {
            const userId = 'dhhan';
            const affliateId = 'moneyweather';

            // AJAX 요청 데이터 설정
            const requestData = {
                userId,
                affliateId
            };

            // AJAX 요청 수행
            $.ajax({
                type: 'POST',
                url: 'http://192.168.101.156/api/giftCoupang/coupangStick',
                contentType: 'application/json',
                data: JSON.stringify(requestData),
                success: function(result) {
                    const memberStick = parseInt(result.data.cnt).toLocaleString();
                    const appendStick = `${memberStick}개`;
                    $('#memberStick').append(appendStick);
                },
                error: function(request, status, error) {
                    console.error(`Error: ${error}`);
                }
            });
        } catch (error) {
            alert(error.message);
        }
    }

    // 캠페인 즐겨찾기 등록, 삭제
    function patchFavorites(campaignNum, favorites, dom) {
        try {
            const userId = 'dhhan';
            const affliatedId = 'affliatedId';
            const apiType = favorites === 'NON_FAVORITE' ? 'i' : 'd';

            // AJAX 요청 데이터 설정
            const requestData = {
                userId,
                affliatedId,
                campaignNum,
                apiType,
            };

            // AJAX 요청 수행
            $.ajax({
                type: 'POST',
                url: 'http://192.168.101.156/api/view/favorites',
                contentType: 'application/json',
                data: JSON.stringify(requestData),
                success: function(result) {
                    if (result.resultCode === '0000') {
                        let domClass = dom.classList;
                        domClass.value.includes('on') ? domClass.remove('on') : domClass.add('on');
                    } else {
                        alert(result.resultMessage);
                    }
                },
                error: function(request, status, error) {
                    console.error(`Error: ${error}`);
                }
            });
        } catch (error) {
            alert(error.message);
        }
    }
</script>
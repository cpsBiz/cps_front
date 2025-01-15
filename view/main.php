<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<!DOCTYPE html>
<html lang="ko">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="format-detection" content="telephone=no">
  <title>쇼핑적립</title>
  <link rel="stylesheet" href="<?= $appApiUrl; ?>/css/index.css?version=<?= $cacheVersion; ?>">
</head>

<body>
  <div class="wrap">
    <!-- header -->
    <header>
      <h1>쇼핑적립</h1>
      <div class="btn-list">
        <a href="javascript:HybridApp.close();" class="ico-arrow type1 left">이전</a>
        <!-- <a href="/index.php" class="ico-home">홈</a> -->
      </div>
    </header>
    <!-- main -->
    <!-- hana class 추가 시 시그니처 컬러 변경 -->
    <div class="main <?= $checkAffliateId; ?>">
      <? if ($checkAppYn == 'N' && $checkZoneId == 'shoplus') { ?>
        <div class="event-banner type1">
          <div class="logo"></div>
          <p>
            포인트 적립을 확실하게<br>챙기는 가장 쉬운 방법!
            <span class="ico-arrow type2 right"></span>
          </p>
          <button id="select-btn1" type="button" onclick="appAgreeBottomPopup()"></button>
        </div>
      <? } ?>
      <div id="banner"></div>
      <div class="point-info-wrap">
        <div class="point-info">
          <div class="text-box">
            <p class="title">총 적립 포인트</p>
            <p id="userCommission" class="point"></p>
          </div>
          <a href="/history/point.php"></a>
        </div>
      </div>
      <div class="tab-box-wrap">
        <div id="category-tab" class="tab-box"></div>
      </div>
      <div class="list-wrap type1">
        <div id="coupangArea" class="list list1 type1" style="display:none;"></div>
        <div id="none-campaign" class="none-campaign" style="display: none;">적립 가능한 캠페인이 없습니다.</div>
        <div class="campaign-list" id="campaign-list"></div>
      </div>
    </div>
    <div id="select-wrap">
      <!-- 정렬 방식 셀렉트 -->
      <div
        id="select-list1"
        class="select-list type7"
        ontouchstart="selectListTouchStart(event.touches[0].pageY)"
        ontouchend="selectListTouchEnd(event.changedTouches[0].pageY, '#select-wrap', '#select-list1')"
        ontouchmove="selectListTouchMove(event.changedTouches[0].pageY, '#select-list1')">
        <div class="select-cont">
          <img class="ico-close type1" style="position: absolute; right:20px; z-index:1;" onclick="selectListClose('#select-btn1', '#select-wrap', '#select-list1');">
          <p class="title">놓치는 포인트가 없도록<br>사용정보 접근을 허용해주세요</p>
          <p class="text">아래 쇼핑몰 APP으로 바로 접속해도<br>쇼핑적립 추가 포인트를 챙겨줄거에요!</p>
          <div class="brand-box">
            <div class="item-box">
              <div class="item">
                <div class="logo" style="background-image: url(./images/test/쿠팡-ico.png);"></div>
                <div class="text-box">
                  <p class="title">쿠팡</p>
                  <p class="text">구매 금액 1만원 당 막대사탕 1개 적립</p>
                </div>
              </div>
              <div class="item">
                <div class="logo" style="background-image: url(./images/test/테무-ico.png);"></div>
                <div class="text-box">
                  <p class="title">테무</p>
                  <p class="text">구매 금액의 17.50% 적립</p>
                </div>
              </div>
              <div class="item">
                <div class="logo" style="background-image: url(./images/test/11번가-ico.png);"></div>
                <div class="text-box">
                  <p class="title">11번가</p>
                  <p class="text">구매 금액의 0.85% 적립</p>
                </div>
              </div>
            </div>
          </div>
          <div class="btn-box">
            <div class="input-box">
              <input type="checkbox" id="check_1" onclick="checkedCheck('#check_1', '#btn-1')">
              <label for="check_1">
                <i class="ico-check"></i>
                <i class="ico-check on"></i>
                개인 정보 처리 및 이용약관에 동의합니다
              </label>
            </div>
            <button id="btn-1" class="btn gray" type="button">동의하러 가기</button>
          </div>
        </div>
      </div>
    </div>
    <? include_once $_SERVER['DOCUMENT_ROOT'] . "/footer.php"; ?>
  </div>

</body>
<script src="<?= $appApiUrl; ?>/js/common.js?version=<?= $cacheVersion; ?>"></script>

</html>
<script>
  $(function() {
    getBanner();
    getCategory();
    getMemberCommission();
  })

  const scrollManager = {
    save: function(key) {
      localStorage.setItem(key, window.scrollY);
    },

    restore: function(key) {
      const position = localStorage.getItem(key);
      if (position) {
        window.scrollTo(0, parseInt(position));
      }
    },
  };

  // 사용 예시
  window.addEventListener('scroll', () => {
    scrollManager.save('mainPageScroll');
  });



  // 배너 조회
  function getBanner() {
    try {
      // AJAX 요청 데이터 설정
      const requestData = {
        affliateId: '<?= $checkAffliateId; ?>',
        site: '<?= $checkSite; ?>'
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/view/bannerView',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (!result.data || result.data == null) return;

          const item = result.data;

          if (localStorage.getItem(`bannerClosed${item.affliateId}${item.bannerNum}`)) return

          if (item.bannerStatus === 'N') return;

          let apiUrl = '';
          if (item.adminId === 'linkprice') {
            apiUrl = '<?= $appApiUrl; ?>/api/clickLinkPrice/campaignClick';
          } else if (item.adminId === 'dotpitch') {
            apiUrl = '<?= $appApiUrl; ?>/api/clickDotPitch/campaignClick';
          }

          // 적립률
          const commissionPer = getCommissionPer(item);

          const params = {
            clickUrl: getDevice() ? item.mobileClickUrl : item.clickUrl,
            apiUrl,
            campaignNum: item.campaignNum,
            per: commissionPer,
            affliateId: '<?= $checkAffliateId; ?>',
            merchantId: item.merchantId,
            agencyId: item.adminId,
            site: '<?= $checkSite; ?>',
            zoneId: '<?= $checkZoneId; ?>',
            userId: '<?= $checkUserId; ?>',
            adId: '<?= $checkAdId; ?>',
          }
          const itemStr = base64Encode(JSON.stringify(params));

          if (item.logo.includes('http://')) {
            item.logo = item.logo.replace('http://', 'https://');
          }

          const banner = `
	                        <div class="event-popup on">
	                          <div class="event-cont">
	                            <div class="logo" style="background-image: url(${item.logo});"></div>
	                            <p>${item.subject}<span>${item.notice}</span><span>기간 : ${formatDate(item.bannerStart)} ~ ${formatDate(item.bannerEnd)}</span></p>
	                          </div>
	                          <a href="javascript:postToUrl('${itemStr}')"></a>
	                          <button class="close" onclick="closeBanner('${item.affliateId}${item.bannerNum}')"></button>
	                        </div>
	                        `;
          $('#banner').empty();
          $('#banner').prepend(banner);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error.message);
    }
  }

  function closeBanner(val) {
    localStorage.setItem(`bannerClosed${val}`, 'true');
    $('#banner').empty();
  }

  // 회원 적립금 조회
  function getMemberCommission() {
    try {
      const userId = '<?= $checkUserId; ?>';
      const affliateId = '<?= $checkAffliateId; ?>';
      const site = '<?= $checkSite; ?>';

      // AJAX 요청 데이터 설정
      const requestData = {
        userId,
        affliateId,
        site
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/view/memberCommission',
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

  function getCategory() {
    try {
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/view/categoryView',
        contentType: 'application/json',
        success: function(result) {
          const data = result.datas;
          let list = '';
          const rewardCategory = localStorage.getItem('rewardCategory');
          data.forEach((item, index) => {
            list += `
											<div id="rewardCategory${item.category}" class="tab tab${index + 1} ${rewardCategory && rewardCategory === item.category ? 'on' : !rewardCategory && index === 0 ? 'on' : ''}">
												<a href="javascript:getCampaignView('${item.category}')">${item.categoryName}</a>
											</div>
										`;
          });
          $('#category-tab').empty();
          $('#category-tab').append(list);

          const tabs = document.querySelectorAll('.tab');
          // 각 탭에 클릭 이벤트 리스너 추가
          tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
              // 모든 탭에서 on 클래스 제거
              tabs.forEach((t) => t.classList.remove('on'));

              // 클릭된 탭에 on 클래스 추가
              tab.classList.add('on');
            });
          });

          getCampaignView(`${rewardCategory ? rewardCategory : data[0].category}`);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error)
    }
  }

  // 캠페인 영역
  function getCampaignView(category) {
    try {
      // 매체 아이디
      const affliateId = '<?= $checkAffliateId; ?>'
      // 지면 아이디
      const zoneId = '<?= $checkZoneId; ?>'
      // 매체가 선택한 사이트
      const site = '<?= $checkSite; ?>'
      // 로그인 유저 아이디
      const userId = '<?= $checkUserId; ?>'
      // 광고 아이디
      const adId = '<?= $checkAdId; ?>'
      // 기기 OS
      const os = getOs();

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
        url: '<?= $appApiUrl; ?>/api/view/campaignView',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (category) localStorage.setItem('rewardCategory', category);

          handleCampaingView(result);
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error.message);
    }
  }

  function handleCampaingView(result) {
    const data = result.datas;

    $('#campaign-list').empty();
    if (!data || data.length === 0) {
      $('#none-campaign').show();
      removeCoupangArea();
      return;
    }
    $('#none-campaign').hide();

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
        apiUrl = '<?= $appApiUrl; ?>/api/clickLinkPrice/campaignClick';
      } else if (item.adminId === 'dotpitch') {
        apiUrl = '<?= $appApiUrl; ?>/api/clickDotPitch/campaignClick';
      }

      // 적립률
      const commissionPer = getCommissionPer(item);

      const params = {
        clickUrl: getDevice() ? item.mobileClickUrl : item.clickUrl,
        apiUrl,
        campaignNum: item.campaignNum,
        per: commissionPer,
        affliateId: '<?= $checkAffliateId; ?>',
        merchantId: item.merchantId,
        agencyId: item.adminId,
        site: '<?= $checkSite; ?>',
        zoneId: '<?= $checkZoneId; ?>',
        userId: '<?= $checkUserId; ?>',
        adId: '<?= $checkAdId; ?>',
      }
      const itemStr = base64Encode(JSON.stringify(params));

      if (item.logo.includes('http://')) {
        item.logo = item.logo.replace('http://', 'https://');
      }

      list += `
              <div class="list">
                <p class="title"><span class="logo" style="background-image: url('${item.logo}');"></span><span class="name">${item.memberName}</span></p>
                <p class="percent"><span class="ico-point"></span>${commissionPer}%</p>
                <a href="javascript:postToUrl('${itemStr}')">바로가기</a>
                <button class="ico-heart ${item.favorites === 'FAVORITE' ? 'on' : ''}" type="button" onclick="patchFavorites(${item.campaignNum}, '${item.favorites}', this)">즐겨찾기</button>
              </div>
            `;
    });
    if (!checkCoupang) removeCoupangArea();
    $('#campaign-list').append(list);

    scrollManager.restore('mainPageScroll');
  }

  function renderCoupangArea(item) {
    const apiUrl = '<?= $appApiUrl; ?>/api/clickCoupang/campaignClick';
    const commissionPer = getCommissionPer(item);

    const params = {
      clickUrl: getDevice() ? item.mobileClickUrl : item.clickUrl,
      apiUrl,
      campaignNum: item.campaignNum,
      per: commissionPer,
      affliateId: item.affliateId,
      site: item.site,
      merchantId: item.merchantId,
      agencyId: item.adminId,
      site: item.site,
    }

    const itemStr = base64Encode(JSON.stringify(params));

    const area = `
                  <p class="title">쿠팡 구매금액 1만원 당 막대사탕 1개</p>
                  <div class="info-wrap" style="justify-content:space-between;">
                    <a id="memberStick" class="candy type1" href="/history/stick.php"></a>
                    <a class="coupang-link" href="javascript:postToUrl('${itemStr}')"><span>쿠팡 쇼핑 GO!</span></a>
                  </div>
                  <div class="link-wrap">
                    <div class="link-box"><a href="/history/gifticon.php">당첨내역</a></div>
                    <div class="link-box"><a href="/event/roulette.php">행운의룰렛 GO</a></div>
                    <div class="link-box"><a href="/event/roulette-notice.php">이벤트 안내</a></div>
                  </div>
                  <button class="ico-heart ${item.favorites === 'FAVORITE' ? 'on' : ''}" type="button" onclick="patchFavorites(${item.campaignNum}, '${item.favorites}', this)"></button>
                  `;
    removeCoupangArea();
    $('#coupangArea').append(area);
    getMemberStick();
  }

  function removeCoupangArea() {
    $('#coupangArea').empty();
    $('#coupangArea').hide();
  }

  // 쿠팡 막대사탕 조회
  function getMemberStick() {
    try {
      const userId = '<?= $checkUserId; ?>';
      const merchantId = 'coupang';
      const affliateId = '<?= $checkAffliateId; ?>';
      const site = '<?= $checkSite; ?>';

      // AJAX 요청 데이터 설정
      const requestData = {
        userId,
        merchantId,
        affliateId,
        site
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/view/coupangStick',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          const memberStick = parseInt(result.data.cnt - result.data.stockCnt).toLocaleString();
          const appendStick = `${memberStick}개`;
          $('#memberStick').append(appendStick);
          $('#coupangArea').show();
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
      const userId = '<?= $checkUserId; ?>';
      const affliateId = '<?= $checkAffliateId; ?>';
      const site = '<?= $checkSite; ?>';
      const apiType = favorites === 'NON_FAVORITE' ? 'I' : 'D';

      // AJAX 요청 데이터 설정
      const requestData = {
        userId,
        affliateId,
        site,
        campaignNum,
        apiType,
      };

      // AJAX 요청 수행
      $.ajax({
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/view/favorites',
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

  function postToUrl(item) {
    location.href = `/reward/campaign.php?object=${item}`;
    // window.open(`/reward/campaign.php?object=${item}`, '_blank');
  }

  function appAgreeBottomPopup() {
    selectListOn('#select-btn1', '#select-wrap', '#select-list1');
  }

  function appAgreeMove() {
    const checked = document.getElementById('check_1').checked;
    if (checked && typeof ShopPlusApp !== 'undefined' && ShopPlusApp) {
      ShopPlusApp.requestUsagePermission('appPermissionCallBack');
    }
  }

  function appPermissionCallBack() {
    console.log('콜백');
  }
</script>
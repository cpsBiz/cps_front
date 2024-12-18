const SpGateway = {
  init: function () {
    const trackingData = this.generateTrackingData();
    this.redirectToMerchantGateway(trackingData);
  },

  generateTrackingData: function () {
    // URL에서 기본 파라미터 추출
    const urlParams = new URLSearchParams(window.location.search);
    const merchantId = urlParams.get('m'); // 광고주 ID
    const affiliateId = urlParams.get('a'); // 제휴사 ID
    const linkId = urlParams.get('l'); // 링크 ID

    // 트래킹 코드 생성
    const trackingCode = this.generateUniqueCode();

    return {
      merchantId,
      affiliateId,
      linkId,
      trackingCode,
    };
  },

  generateUniqueCode: function () {
    // 유니크한 트래킹 코드 생성
    const timestamp = new Date().getTime();
    const random = Math.random().toString(36).substring(2, 15);
    return `${timestamp}_${random}`;
  },

  redirectToMerchantGateway: function (trackingData) {
    // 게이트웨이 URL 생성
    const merchantGatewayUrl = this.getMerchantGatewayUrl(
      trackingData.merchantId,
    );

    // 트래킹 데이터를 포함한 URL 파라미터 생성
    const params = new URLSearchParams({
      a: trackingData.affiliateId,
      m: trackingData.merchantId,
      l: trackingData.linkId,
      trackingCode: trackingData.trackingCode,
      timestamp: new Date().toISOString(),
    });

    // 게이트웨이 페이지로 리다이렉트
    window.location.href = `${merchantGatewayUrl}?${params.toString()}`;
  },

  getMerchantGatewayUrl: function (merchantId) {
    // 광고주별 게이트웨이 URL 매핑
    const gatewayUrls = {
      clickbuy: 'https://gateway.clickbuy.com',
      // 다른 광고주들의 게이트웨이 URL
    };
    return gatewayUrls[merchantId] || '';
  },
};

const SpGateway = {
  init: () => {
    const trackingData = SpGateway.generateTrackingData();
    SpGateway.redirectToMerchantGateway(trackingData);
  },

  generateTrackingData: () => {
    // URL에서 기본 파라미터 추출
    const urlParams = new URLSearchParams(window.location.search);
    const merchantId = urlParams.get('m'); // 광고주 ID
    const affiliateId = urlParams.get('a'); // 제휴사 ID
    const linkId = urlParams.get('l'); // 링크 ID

    // 필수 파라미터 검증
    if (!merchantId || !affiliateId || !linkId) {
      throw new Error('필수 파라미터가 누락되었습니다.');
    }

    // 트래킹 코드 생성
    const trackingCode = SpGateway.generateUniqueCode();

    return {
      merchantId,
      affiliateId,
      linkId,
      trackingCode,
    };
  },

  generateUniqueCode: () => {
    // 유니크한 트래킹 코드 생성
    const timestamp = new Date().getTime();
    const random = Math.random().toString(36).substring(2, 15);
    return `${timestamp}_${random}`;
  },

  redirectToMerchantGateway: (trackingData) => {
    // 게이트웨이 URL 생성
    const merchantGatewayUrl = SpGateway.getMerchantGatewayUrl(
      trackingData.merchantId,
    );

    // 트래킹 데이터를 포함한 URL 파라미터 생성
    const params = new URLSearchParams({
      a: trackingData.affiliateId,
      l: trackingData.linkId,
      t: trackingData.trackingCode,
    });

    // 리다이렉트 수행
    window.location.href = `${merchantGatewayUrl}?${params.toString()}`;
  },

  getMerchantGatewayUrl: (merchantId) => {
    // 게이트웨이 URL 반환 (예시 URL)
    return `https://merchantgateway.example.com/${merchantId}`;
  },
};

const McGateway = {
  init: (config) => {
    McGateway.redirectUrl = config.redirectUrl;
    McGateway.setSpinfoCookie();
  },

  setSpinfoCookie: () => {
    const spinfo = McGateway.getSpinfoFromUrl();
    if (spinfo) {
      document.cookie = `SPINFO=${spinfo}; path=/; max-age=259200`; // 3일간 유효
    }
  },

  getSpinfoFromUrl: () => {
    // URL에서 a, m, l 파라미터 추출
    const urlParams = new URLSearchParams(window.location.search);
    const affiliateId = urlParams.get('a') || '';
    const merchantId = urlParams.get('m') || '';
    const linkId = urlParams.get('l') || '';

    // 필수 파라미터 검증
    if (!affiliateId || !merchantId || !linkId) {
      throw new Error('필수 파라미터가 누락되었습니다.');
    }

    // SPINFO 쿠키 값 생성 (A100000131|9832|A|m|a8uakljfa 형식)
    return `${affiliateId}|${linkId}|A|m|${McGateway.generateTrackingCode()}`;
  },

  generateTrackingCode: () => {
    return Math.random().toString(36).substring(2, 15);
  },

  redirect: () => {
    if (McGateway.redirectUrl) {
      window.location.href = McGateway.redirectUrl;
    }
  },
};

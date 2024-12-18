const McGateway = {
  init: function (config) {
    this.redirectUrl = config.redirectUrl;
    this.setSpinfoCookie();
  },

  setSpinfoCookie: function () {
    const spinfo = this.getSpinfoFromUrl();
    if (spinfo) {
      document.cookie = `SPINFO=${spinfo}; path=/; max-age=259200`; // 3일간 유효
    }
  },

  getSpinfoFromUrl: function () {
    // URL에서 a, m, l 파라미터 추출
    const urlParams = new URLSearchParams(window.location.search);
    const affiliateId = urlParams.get('a') || '';
    const merchantId = urlParams.get('m') || '';
    const linkId = urlParams.get('l') || '';

    // SPINFO 쿠키 값 생성 (A100000131|9832|A|m|a8uakljfa 형식)
    if (affiliateId && merchantId && linkId) {
      return `${affiliateId}|${linkId}|A|m|${this.generateTrackingCode()}`;
    }
    return '';
  },

  generateTrackingCode: function () {
    return Math.random().toString(36).substring(2, 15);
  },

  redirect: function () {
    if (this.redirectUrl) {
      window.location.href = this.redirectUrl;
    }
  },
};

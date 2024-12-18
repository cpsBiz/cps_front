const PaymentTracker = {
  init: function (config) {
    this.apiEndpoint = config.apiEndpoint;
    this.apiKey = config.apiKey;
    this.merchantId = config.merchantId;
    this.remoteAddr = config.remoteAddr;
  },

  trackPurchase: function (purchaseData) {
    const trackingData = {
      order: {
        orderId: purchaseData.orderId,
        final_paid_price: purchaseData.amount,
        currency: purchaseData.currency || 'KRW',
        user_name: purchaseData.buyerName,
      },
      products: purchaseData.products.map((product) => ({
        product_id: product.id,
        product_name: product.name,
        category_code: product.categoryCode,
        category_name: product.categoryName,
        quantity: product.quantity,
        product_final_price: product.finalPrice,
        paid_at: this.getCurrentTime(),
        confirmed_at: '',
        canceled_at: '',
      })),
      merchant: {
        merchant_id: this.merchantId,
        spinfo: this.getSpinfo(),
        user_agent: navigator.userAgent,
        remote_addr: this.remoteAddr,
        device_type: this.getDeviceType(),
      },
    };

    return this.sendTrackingData(trackingData);
  },

  sendTrackingData: function (data) {
    return fetch(this.apiEndpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${this.apiKey}`,
      },
      body: JSON.stringify(data),
    })
      .then((response) => response.json())
      .catch((error) => {
        console.error('트래킹 실패:', error);
        throw error;
      });
  },

  getSpinfo: function () {
    const cookieValue = document.cookie
      .split('; ')
      .find((row) => row.startsWith('SPINFO='));
    return cookieValue ? cookieValue.split('=')[1] : '';
  },

  getCurrentTime: function () {
    return new Date().toISOString();
  },

  getDeviceType: function () {
    if (/Mobile|Android|iPhone/i.test(navigator.userAgent)) {
      return 'mobile';
    }
    return 'pc';
  },
};

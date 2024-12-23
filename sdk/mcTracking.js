const PaymentTracker = {
  init: (config) => {
    PaymentTracker.apiEndpoint = config.apiEndpoint;
    PaymentTracker.apiKey = config.apiKey;
    PaymentTracker.merchantId = config.merchantId;
    PaymentTracker.remoteAddr = config.remoteAddr;
  },

  trackPurchase: (purchaseData) => {
    // 필수 파라미터 검증
    if (
      !purchaseData.orderId ||
      !purchaseData.amount ||
      !purchaseData.buyerName ||
      !purchaseData.products
    ) {
      throw new Error('필수 파라미터가 누락되었습니다.');
    }

    const trackingData = {
      order: {
        orderId: purchaseData.orderId,
        final_paid_price: purchaseData.amount,
        currency: purchaseData.currency || 'KRW',
        user_name: purchaseData.buyerName,
      },
      products: purchaseData.products.map((product) => {
        // 필수 파라미터 검증
        if (
          !product.id ||
          !product.name ||
          !product.categoryCode ||
          !product.categoryName ||
          !product.quantity ||
          !product.finalPrice
        ) {
          throw new Error('제품 정보의 필수 파라미터가 누락되었습니다.');
        }

        return {
          product_id: product.id,
          product_name: product.name,
          category_code: product.categoryCode,
          category_name: product.categoryName,
          quantity: product.quantity,
          product_final_price: product.finalPrice,
          paid_at: PaymentTracker.getCurrentTime(),
          confirmed_at: '',
          canceled_at: '',
        };
      }),
      merchant: {
        merchant_id: PaymentTracker.merchantId,
        spinfo: PaymentTracker.getSpinfo(),
        user_agent: navigator.userAgent,
        remote_addr: PaymentTracker.remoteAddr,
        device_type: PaymentTracker.getDeviceType(),
      },
    };

    return PaymentTracker.sendTrackingData(trackingData);
  },

  sendTrackingData: (data) => {
    return fetch(PaymentTracker.apiEndpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Authorization: `Bearer ${PaymentTracker.apiKey}`,
      },
      body: JSON.stringify(data),
    })
      .then((response) => response.json())
      .catch((error) => {
        console.error('트래킹 실패:', error);
        throw error;
      });
  },

  getSpinfo: () => {
    const cookieValue = document.cookie
      .split('; ')
      .find((row) => row.startsWith('SPINFO='));
    return cookieValue ? cookieValue.split('=')[1] : '';
  },

  getCurrentTime: () => {
    return new Date().toISOString();
  },

  getDeviceType: () => {
    if (/Mobile|Android|iPhone/i.test(navigator.userAgent)) {
      return 'mobile';
    }
    return 'pc';
  },
};

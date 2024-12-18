<script>
  // SDK 초기화
  PaymentTracker.init({
    apiEndpoint: 'https://api.shoplus.io/api/tracking',
    apiKey: 'YOUR_API_KEY',
    remoteAddr: 'USER_IP'
  });

  // 결제 완료 시 호출
  const purchaseData = {
    orderId: 'ORDER_123',
    amount: 50000,
    buyerName: '홍길동',
    products: [{
      id: 'PROD_1',
      name: '상품1',
      categoryCode: 'CATEGORY_1',
      categoryName: ['의류', '남성의류', '티셔츠'],
      quantity: 2,
      finalPrice: 25000
    }]
  };

  PaymentTracker.trackPurchase(purchaseData)
    .then(response => {
      console.log('트래킹 성공');
    })
    .catch(error => {
      console.error('트래킹 실패');
    });
</script>
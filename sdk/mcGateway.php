<!DOCTYPE html>
<html>

<head>
  <script src="https://sdk.shoplus.io/gateway.js"></script>
</head>

<body>
  <script>
    McGateway.init({
      merchantId: 'clickbuy',
      redirectUrl: 'https://www.yourshop.com'
    });
    McGateway.redirect();
  </script>
  <p>잠시만 기다려주세요...</p>
</body>

</html>
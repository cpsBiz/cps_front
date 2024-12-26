<script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery-2.2.2.min.js"></script>
<script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="https://cdn.shoplus.io/js/lib/jquery-ui.min.js"></script>
<script src="<?= $appApiUrl; ?>/js/common.js"></script>
<script>
  function setToken() {
    try {
      const requestData = {
        userId: '<?= $userId; ?>',
        affliateId: '<?= $affliateId; ?>',
        adId: '<?= $adId; ?>',
        token: '<?= $fcmToken; ?>',
        os: getOs(),
        userName: '',
        userEmail: '',
        userPhone: ''
      }

      $.ajax({
        async: false,
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/common/cpsUser',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        success: function(result) {
          if (result.resultCode === '0000') {
            successToken(result.data.firstLogin);
          }
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }

  function successToken(firstLogin) {
    const host = window.location.hostname;
    if (host.includes('/cart/index.php') && firstLogin === 'Y') {
      checkCartAgree();
    } else {
      location.replace('https://testapp.shoplus.io/main.php');
    }
  }
</script>
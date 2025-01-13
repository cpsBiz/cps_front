<script>
  function setToken() {
    try {
      const requestData = {
        userId: '<?= $userId; ?>',
        affliateId: '<?= $affliateId; ?>',
        site: '<?= $site; ?>',
        adId: '<?= $adId; ?>',
        token: '<?= $fcmToken; ?>',
        os: getOs(),
        appYn: '<?= $appYn; ?>',
        userName: '',
        userEmail: '',
        userPhone: ''
      }

      $.ajax({
        async: false,
        type: 'POST',
        url: '<?= $appApiUrl; ?>/api/common/cpsUserToken',
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
      location.replace('<?= $appApiUrl; ?>/main.php');
    }
  }
</script>
<script>
  function postDeleteAccount(id, pw) {
    if (!id) return alert('잘못된 접근입니다.');

    if (confirm('선택하신 계정을 삭제하시겠습니까?')) {
      try {
        const requestData = {
          apiType: 'D',
          memberId: id,
          memberPw: pw,
          memberSiteList: []
        };

        $.ajax({
          type: 'POST',
          url: 'https://admin.shoplus.io/api/admin/memberSignIn',
          contentType: 'application/json',
          dataType: 'JSON',
          data: JSON.stringify(requestData),
          success: function(result) {
            if (result.resultCode !== '0000') return alert(result.resultMessage);
            location.reload();
          },
          error: function(request, status, error) {
            console.error(`Error: ${error}`);
          }
        });
      } catch (error) {
        alert(error)
      }
    }
  }
</script>
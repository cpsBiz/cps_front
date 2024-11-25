<script type="text/javascript" src="/js/lib/jquery-2.2.2.min.js"></script>
<script type="text/javascript" src="/js/lib/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="/js/lib/jquery-ui.min.js"></script>
<input id="id" type="text" placeholder="아이디를 입력해 주세요.">
<input id="pw" type="password" placeholder="비밀번호를 입력해 주세요.">
<button onclick="login()">로그인</button>
<script>
  function login() {
    const id = document.getElementById('id').value.trim();
    const pw = document.getElementById('pw').value.trim();

    if (!id) return alert('아이디를 입력해 주세요.');
    if (!pw) return alert('비밀번호를 입력해 주세요.');

    $.ajax({
      type: 'POST',
      url: '/api/login.php',
      contentType: 'application/json',
      dataType: 'json',
      data: JSON.stringify({
        id,
        pw
      }),
      success: function(result) {
        if (result.resultCode === '0000') {
          location.href = '/page/report/report.php';
        } else {
          alert(result.resultMessage);
        }
      },
      error: function(xhr, status, error) {
        alert('로그인 처리 중 오류가 발생했습니다.');
        console.error(error);
      }
    });
  }
</script>
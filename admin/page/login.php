<script type="text/javascript" src="/admin/js/lib/jquery-2.2.2.min.js"></script>
<script type="text/javascript" src="/admin/js/lib/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="/admin/js/lib/jquery-ui.min.js"></script>
<input id="id" type="text" placeholder="아이디를 입력해 주세요.">
<input id="pw" type="password" placeholder="비밀번호를 입력해 주세요.">
<button onclick="login()">로그인</button>
<script>
  function login() {
    const id = document.getElementById('id').value;
    const pw = document.getElementById('pw').value;

    if (!id) return alert('아이디를 입력해 주세요.');
    if (!pw) return alert('비밀번호를 입력해 주세요.');

    try {
      $.ajax({
        type: 'POST',
        url: '/admin/api/login.php',
        contentType: 'application/json',
        dataType: 'JSON',
        data: JSON.stringify({
          id,
          pw
        }),
        success: function(result) {
          if (result.resultCode !== '0000') return alert(result.resultMessage);
          location.href = '/admin/page/report/report.php';
        },
        error: function(request, status, error) {
          console.error(`Error: ${error}`);
        }
      });
    } catch (error) {
      alert(error);
    }
  }
</script>
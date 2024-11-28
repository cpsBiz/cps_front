<?
session_start();
$admin_login = $_SESSION['admin_login'];
if ($admin_login !== true) {
  header('Location:/page/login.php');
} else {
  include_once $_SERVER['DOCUMENT_ROOT'] . "/db_config.php";
  include_once $_SERVER['DOCUMENT_ROOT'] . "/common.php";
?>
  <header class="header">
    <h1><a href="javascript:void(0);">통합카트</a></h1>
    <div class="sideMenu">
      <div class="name"><strong><?= $_SESSION['admin_login_name']; ?></strong>님</div>
      <div class="userMenu">
        <button type="button" class="userinfo menuMore">고객정보</button>
        <ul>
          <li><button type="button">권한정보</button></li>
          <li><button type="button">회원정보수정</button></li>
          <li><button type="button" onclick="location.href='/page/logout.php'">로그아웃</button></li>
        </ul>
      </div>
    </div>
  </header>
<? } ?>
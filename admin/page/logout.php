<?
session_start();
session_unset();
session_destroy();

header('Location: /admin/page/login.php');
exit();

<? include_once $_SERVER['DOCUMENT_ROOT'] . "/header.php"; ?>
<?
if ($isTest) {
  $host = '192.168.150.80:3306';
  $username = 'CPS';
  $password = 'Emfla2017!@#';
  $database = 'CPS';
} else {
  $host = '192.168.3.15:3306';
  $username = 'CPS';
  $password = 'Emfla2017!@#';
  $database = 'CPS';
}
// MySQL 데이터베이스 연결
$con = mysqli_connect($host, $username, $password, $database);

// 연결 확인
if (!$con) {
  die('MySQL 연결 실패: ' . mysqli_connect_error());
  header('Location:/500.php');
}
mysqli_set_charset($con, 'utf8');
?>
<style>
  .test-con {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin: 0;
    padding: 10px;
  }

  .test-con div {
    border: 1px solid #000;
    border-radius: 8px;
    gap: 10px;
    display: flex;
    flex-direction: column;
    padding: 10px;
  }

  .test-con div img {
    width: 350px;
    height: auto;
  }

  .test-con div a {
    width: 100%;
    word-break: break-all;
  }
</style>
<div class="test-con">
  <?
  $sql = "SELECT * FROM CPS_CART_PRODUCT";
  $stmt = mysqli_stmt_init($con);
  if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    foreach ($result as $row) {
  ?>
      <div>
        <span>제품명: <?= $row['PRODUCT_NAME']; ?> /
          상품코드: <?= $row['PRODUCT_CODE']; ?> /
          옵션코드: <?= $row['OPTION_CODE']; ?> /
          카테고리: <?= $row['CATEGORY']; ?> /
          가격: <?= $row['PRODUCT_PRICE']; ?> <?= $row['PRODUCT_UNIT_PRICE']; ?> /
          로켓가격: <?= $row['ROCKET_PRODUCT_PRICE']; ?> <?= $row['ROCKET_PRODUCT_UNIT_PRICE']; ?> /
          배송비: <?= $row['DELIVERY_PRICE']; ?> /
          로켓유무: <?= $row['ROCKET_STATUS']; ?> /
          배송비유무: <?= $row['FREE_SHOPPING_STATUS']; ?> /
          반품상품유무: <?= $row['RETURN_PRODUCT_STATUS']; ?> /
          리뷰: <?= $row['REVIEW']; ?>
        </span>
        <span>이미지 :<a href="<?= $row['PRODUCT_IMAGE']; ?>"><?= $row['PRODUCT_IMAGE']; ?></a></span>
        <span>URL :<a href="<?= $row['PRODUCT_URL']; ?>"><?= $row['PRODUCT_URL']; ?></a></span>
      </div>
  <?
    }
  }
  ?>
</div>
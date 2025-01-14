<?
if ($_SESSION['check_zoneId'] == 'shoplus') { ?>
  <div class="bottom-menu-wrap">
    <a class="menu" href="<?= $appApiUrl; ?>/cart/main.php"><span class="ico-cart">카트</span></a>
    <a class="menu" href="<?= $appApiUrl; ?>/main.php"><span class="ico-save">적립</span></a>
    <!-- <a class="menu" href="javascript:void(0)"><span class="ico-trend">트렌드</span></a>
  <a class="menu" href="javascript:void(0)"><span class="ico-delivery">배송</span></a> -->
    <a class="menu" href="<?= $appApiUrl; ?>/history/point.php"><span class="ico-breakDown">내역</span></a>
  </div>
<? } ?>
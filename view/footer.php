<?
$footerIdList = [
  10000,
  1049,
  1114,
  1216,
  748,
  994
];
//footerIdList에 $checkUserId가 포함되어 있는지 확인
$checkFooterId = in_array($checkUserId, $footerIdList);
if ($checkFooterId) { ?>
  <div class="bottom-menu-wrap">
    <a class="menu" href="<?= $appApiUrl; ?>/cart/main.php"><span class="ico-cart">카트</span></a>
    <a class="menu" href="<?= $appApiUrl; ?>/main.php"><span class="ico-save">적립</span></a>
    <!-- <a class="menu" href="javascript:void(0)"><span class="ico-trend">트렌드</span></a>
  <a class="menu" href="javascript:void(0)"><span class="ico-delivery">배송</span></a> -->
    <a class="menu" href="<?= $appApiUrl; ?>/history/point.php"><span class="ico-breakDown">내역</span></a>
  </div>
<? } ?>
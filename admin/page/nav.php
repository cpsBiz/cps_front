<?
// 현재 URL을 가져옵니다.
$current_url = $_SERVER['REQUEST_URI'];

// 네비게이션 메뉴 데이터를 배열로 정의합니다.
$menu_items = [
  'dashboard' => [
    'label' => '대시보드',
    'url' => '#'
  ],
  'report' => [
    'label' => '리포트',
    'url' => '/admin/page/report/report.php'
  ],
  'campaign' => [
    'label' => '캠페인 관리',
    'url' => '#',
    'sub' => [
      ['label' => '캠페인 생성', 'url' => '#'],
      ['label' => '캠페인 리스트', 'url' => '#'],
      ['label' => '캠페인 카테고리', 'url' => '/admin/page/campaign/category.php']
    ]
  ],
  'menu' => [
    'label' => '메뉴 관리',
    'url' => '#'
  ],
  'account' => [
    'label' => '계정 관리',
    'url' => '#',
    'sub' => [
      ['label' => '회원', 'url' => '/admin/page/account/customer.php'],
    ]
  ],
  'customer' => [
    'label' => '고객 관리',
    'url' => '#',
    'sub' => [
      ['label' => '1:1문의 내역', 'url' => '/admin/page/customer/inquiryList.php']
    ]
  ],
  'notice' => [
    'label' => '공지사항',
    'url' => '#'
  ],
];

// 함수: 현재 URL이 해당 메뉴 URL에 포함되면 'on' 클래스를 반환합니다.
function get_active_class($menu_url, $current_url)
{
  return (strpos($current_url, $menu_url) !== false) ? 'on' : '';
}

// 함수: 상위 탭에 'on' 클래스를 넣을지 확인합니다.
function is_parent_active($menu, $current_url)
{
  // 상위 메뉴의 URL이 현재 URL과 일치하는지 확인
  if (get_active_class($menu['url'], $current_url) === 'on') {
    return true;
  }

  // 하위 메뉴가 있는 경우, 하위 메뉴 중 하나라도 현재 URL과 일치하는지 확인
  if (isset($menu['sub'])) {
    foreach ($menu['sub'] as $sub_menu) {
      if (get_active_class($sub_menu['url'], $current_url) === 'on') {
        return true;
      }
    }
  }

  return false;
}
?>

<nav class="navigation">
  <ul class="lnb">
    <? foreach ($menu_items as $class => $menu): ?>
      <li class="<?= $class . ' ' . (is_parent_active($menu, $current_url) ? 'on' : ''); ?>">
        <a href="<?= $menu['url']; ?>"><span><?= $menu['label']; ?></span></a>

        <? if (isset($menu['sub'])): ?>
          <ul <?= is_parent_active($menu, $current_url) ? 'style="display:block"' : ''; ?>>
            <? foreach ($menu['sub'] as $sub_menu): ?>
              <li class="<?= get_active_class($sub_menu['url'], $current_url); ?>">
                <a href="<?= $sub_menu['url']; ?>"><?= $sub_menu['label']; ?></a>
              </li>
            <? endforeach; ?>
          </ul>
        <? endif; ?>
      </li>
    <? endforeach; ?>
  </ul>
</nav>
<?php
    $menus = [
      'admin' => [
        ['type' => 'item', 'title' => 'Dashboard', 'icon' => 'fas fa-tachometer-alt', 'link' => 'dashboard.admin.home'],
        ['type' => 'header', 'title' => 'Master Data'],
        // [
        //   'type' => 'dropdown',
        //   'title' => 'Master Data',
        //   'icon' => 'fas fa-table',
        //   'children' => [
        //     // ['type' => 'item', 'title' => 'Angkatan', 'icon' => 'fas fa-th', 'link' => 'dashboard.admin.master.student'],
        //     // ['type' => 'item', 'title' => 'Kelas', 'icon' => 'fas fa-th', 'link' => 'dashboard.admin.master.student'],
        //     // ['type' => 'item', 'title' => 'Prestasi', 'icon' => 'fas fa-user-graduate', 'link' => 'dashboard.admin.master.achievement-category.index'],
        //   ]
        // ],
        ['type' => 'item', 'title' => 'Guru', 'icon' => 'fas fa-chalkboard-teacher', 'link' => 'dashboard.admin.master.teacher.index'],
        ['type' => 'item', 'title' => 'Siswa', 'icon' => 'fas fa-user-graduate', 'link' => 'dashboard.admin.master.student.index'],
        ['type' => 'item', 'title' => 'Angkatan', 'icon' => 'fas fa-users', 'link' => 'dashboard.admin.master.generation.index'],
        ['type' => 'item', 'title' => 'Kelas', 'icon' => 'fas fa-school', 'link' => 'dashboard.admin.master.grade.index'],
        [
          'type' => 'dropdown',
          'title' => 'Pelanggaran',
          'icon' => 'fas fa-table',
          'children' => [
            ['type' => 'item', 'title' => 'Kategori', 'icon' => 'fas fa-user-graduate', 'link' => 'dashboard.admin.master.violation-category.index'],
          ],
        ],
        [
          'type' => 'dropdown',
          'title' => 'Prestasi',
          'icon' => 'fas fa-table',
          'children' => [
            ['type' => 'item', 'title' => 'Kategori', 'icon' => 'fas fa-user-graduate', 'link' => 'dashboard.admin.master.achievement-category.index'],
          ],
        ],

        ['type' => 'header', 'title' => 'Data Utama'],
        ['type' => 'item', 'title' => 'Pelanggaran', 'icon' => 'fas fa-scroll', 'link' => 'dashboard.admin.master.grade.index'],
        ['type' => 'item', 'title' => 'Prestasi', 'icon' => 'fas fa-trophy', 'link' => 'dashboard.admin.master.grade.index'],
        ['type' => 'item', 'title' => 'Presensi', 'icon' => 'fas fa-calendar-alt', 'link' => 'dashboard.admin.master.grade.index'],

        ['type' => 'header', 'title' => 'Lainnya'],
        ['type' => 'item', 'title' => 'Pengaturan', 'icon' => 'fas fa-cog', 'link' => 'dashboard.admin.master.grade.index'],
      ],
      'teacher' => [
        ['type' => 'item', 'title' => 'Dashboard', 'icon' => 'fas fa-th', 'link' => 'dashboard.teacher.home'],
      ],
    ];


    // recursive menu looping
    function loadMenuItem(array $menu)
    {
      $html = '';
      if ($menu['type'] == 'item') {
        $isActiveRoute = request()->routeIs($menu['link']);
        $html .= '<li class="nav-item '.($isActiveRoute ? 'menu-open' : '').'">';
        $html .= '<a href="'.route($menu['link']).'" class="nav-link '.($isActiveRoute ? 'active' : '').'">';
        $html .= '<i class="nav-icon '.@$menu['icon'].'"></i>';
        $html .= '<p>'.$menu['title'].'</p>';
        $html .= '</a>';
        $html .= '</li>';
        return [$html, $isActiveRoute];
      } else if ($menu['type'] == 'dropdown') {
        $html .= '<ul class="nav nav-treeview">';
        $isActiveRoute = false;
        foreach ($menu['children'] as $child) {
          $a = loadMenuItem($child);
          $html .= $a[0];
          $isActiveRoute = $isActiveRoute || $a[1];
        }
        $html .= '</ul>';
        $html .= '</li>';

        $htmlLeft = '<li class="nav-item '.($isActiveRoute ? 'menu-open' : '').'">';
        $htmlLeft .= '<a href="#" class="nav-link '.($isActiveRoute ? 'active' : '').'">';
        $htmlLeft .= '<i class="nav-icon '.@$menu['icon'].'"></i>';
        $htmlLeft .= '<p>';
        $htmlLeft .= $menu['title'];
        $htmlLeft .= '<i class="fas fa-angle-left right"></i>';
        $htmlLeft .= '</p>';
        $htmlLeft .= '</a>';
        return [$htmlLeft . $html, $isActiveRoute];
      } else if ($menu['type'] == 'header') {
        $html .= '<li class="nav-header pl-4 mt-2">'.$menu['title'].'</li>';
        return [$html, false];
      }
    }
    function loadMenuByRole(array $menus, string $guard)
    {
      $menu = $menus[$guard];
      $html = '';
      foreach ($menu as $item) {
        $a = loadMenuItem($item);
        $html .= $a[0];
      }
      return $html;
    }
?>

<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
      {{-- <li class="nav-item menu-open">
          <a href="pages/widgets.html" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                  Dashboard
              </p>
          </a>
      </li>
      <li class="nav-item">
          <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                  Widgets
              </p>
          </a>
      </li>
      <li class="nav-item">
          <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                  Tables
                  <i class="fas fa-angle-left right"></i>
              </p>
          </a>
          <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="pages/tables/simple.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Simple Tables</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="pages/tables/data.html" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>DataTables</p>
                  </a>
              </li>
          </ul>
      </li> --}}
      {!! loadMenuByRole($menus, getGuardNameByCurrentRoute()) !!}
  </ul>
</nav>

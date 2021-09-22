<?php


$menuItems = [
    ['label' => t('My courses'), 'icon' => 'list,fas', 'url' => ['/user/course/list']],
    ['label' => t('Personal cabinet'), 'icon' => 'list,fas', 'url' => ['/user']],
];


?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= to(['/user']) ?>" class="brand-link">
        <img src="/template/adminlte3//img/AdminLTELogo.png" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= user()->tutorSchool->name ?></span>
    </a>

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="<?= user()->tutor->avatar ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block" style="color:#c2c7d0"><?= user()->username ?></a>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?=
            \soft\widget\adminlte3\Menu::widget([
                'items' => $menuItems,
            ])
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
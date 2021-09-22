<?php

/* @var $this \yii\web\View */

$menuItems = [
    ['label' => "Bosh sahifa", 'url' => ['/site/index'], 'icon' => 'home',],
    ['label' => "Hospitals", 'url' => ['/hospital'], 'icon' => 'hospital',],
    ['label' => "Hospital Admin", 'url' => ['/hospital-admin'], 'icon' => 'user',],
//    ['label' => "Mashinalar", 'url' => ['/car'], 'icon' => 'taxi',],
//    ['label' => "Mashinalar modeli", 'url' => ['/car-model'], 'icon' => 'car-side',],
//    ['label' => "Haydovchilar", 'url' => ['/driver'], 'icon' => 'user-tie',],
//    ['label' => "Tariff", 'url' => ['/tariff'], 'icon' => 'funnel-dollar,fas',],
//    ['label' => "Tarjimalar", 'url' => ['/translate-manager/default/index'], 'icon' => 'globe,fas',],
    ['label' => "Gii", 'url' => ['/gii'], 'icon' => 'code,fas', 'visible' => YII_DEBUG],
    ['label' => "Clear cache", 'url' => ['/site/cache-flush'], 'icon' => 'broom,fas', 'visible' => YII_DEBUG],
];

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= to(['site/index']) ?>" class="brand-link">
        <img src="/template/adminlte3//img/AdminLTELogo.png" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Edu system</span>
    </a>
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
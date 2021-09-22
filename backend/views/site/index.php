<?php

/* @var $this soft\web\View */

use frontend\assets\VueAsset;

$this->title = 'Bosh sahifa';

$this->registerJsFile('@web/js/home_page.js', ['depends' => VueAsset::class]);

?>
<div id="app">

    <?= $this->render('_index_order_form') ?>
    <?= $this->render('_index_orders_list') ?>

</div>
</div>
<?php

/* @var $this soft\web\View */
/* @var $content string */

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <div class="col-sm-12 mt-2 mb-2">

                    <?= \yii\bootstrap4\Breadcrumbs::widget([
                        'links' => $this->params['breadcrumbs'] ?? []
                    ]) ?>

                </div>
                <div class="col-sm-12 mt-2 mb-2">

                    <?= \soft\widget\Alert::widget() ?>

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <?= $content ?>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
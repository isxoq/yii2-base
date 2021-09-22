<?php

/* @var $this soft\web\View */
/* @var $content string */

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-1 mt-2">
                <div class="col-sm-12">
                    <?= \yii\bootstrap4\Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'homeLink' => [
                            'label' => Yii::t('yii', 'Home'),
                            'url' => ['default/main']

                        ]
                    ]) ?>
                </div>
                <div class="col-sm-12">
                    <h1><?= isset($this->params['contentTitle']) ? e($this->params['contentTitle']) : $this->title ?></h1>
                </div>

                <div class="col-sm-12">
                    <p class="text-muted"><?= isset($this->params['contentDescription']) ? e($this->params['contentDescription']) : null ?></p>
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
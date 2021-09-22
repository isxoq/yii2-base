<?php

use yii\helpers\Html;

/* @var $this soft\web\View */
/* @var $model backend\modules\usermanager\models\User */

$this->title = Yii::t('site', 'Update');
$this->params['breadcrumbs'][] = ['label' => 'Xodimlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->firstname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


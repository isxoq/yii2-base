<?php


/* @var $this soft\web\View */
/* @var $model backend\modules\usermanager\models\User */

$this->title = "Yangi qo'shish";
$this->params['breadcrumbs'][] = ['label' => 'Xodimlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>



<?= $this->render('_form', [
    'model' => $model,
]) ?>
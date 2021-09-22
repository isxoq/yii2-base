<?php

/* @var $this soft\web\View */
/* @var $model common\models\User */

$this->title = $model->fullname;
$branch = $model->branch;

$this->addBreadCrumb('Filiallar', ['branch/index']);
$this->addBreadCrumb($branch->name, ['branch/view', 'id' => $branch->id]);
$this->addBreadCrumb('Xodimlar', ['user/index', 'branch_id' => $branch->id]);
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= \soft\widget\bs4\DetailView::widget([
        'model' => $model,
        'panel' => $this->isAjax ? false : [],
        'attributes' => [
              'id', 
              'username', 
              'auth_key', 
              'password_hash', 
              'password_reset_token', 
              'email', 
              'status', 
              'created_at', 
              'updated_at', 
              'firstname', 
              'lastname', 
              'type_id', 
              'branch_id', 
        ],
    ]) ?>
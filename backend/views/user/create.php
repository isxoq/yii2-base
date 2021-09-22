<?php


/* @var $this soft\web\View */
/* @var $model common\models\User */
/* @var $branch \common\models\Branch */

$this->title = Yii::t('site', 'Create a new');
$this->addBreadCrumb('Filiallar', ['branch/index']);
$this->addBreadCrumb($branch->name, ['branch/view', 'id' => $branch->id]);
$this->addBreadCrumb('Xodimlar', ['user/index', 'branch_id' => $branch->id]);
$this->params['breadcrumbs'][] = $this->title;
?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
<?php

use common\models\User;

/* @var $this soft\web\View */
/* @var $searchModel backend\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $branch \common\models\Branch */

$this->title = 'Xodimlar';

$this->addBreadCrumb('Filiallar', ['branch/index']);
$this->addBreadCrumb($branch->name, ['branch/view', 'id' => $branch->id]);
$this->params['breadcrumbs'][] = $this->title;

$this->registerAjaxCrudAssets();
?>

<?= $this->render('@backend/views/branch/_branchMenu', ['model' => $branch]) ?>

<?= \soft\grid\GridView::widget([
    'id' => 'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'toolbarTemplate' => '{create}{refresh}',
    'toolbarButtons' => [
        'create' => [
            /** @see soft\widget\button\Button for other configurations */
            'modal' => false,
            'url' => ['user/create', 'branch_id' => $branch->id]
        ]
    ],
    'bulkButtonsTemplate' => '{delete}',
    'bulkButtons' => [
        'delete' => [
            /** @see soft\widget\button\BulkButton for other configurations */
        ],
    ],
    'cols' => [
        'firstname',
        'lastname',
        'username',
        //'status',
        'created_at',
        [
            'attribute' => 'type_id',
            'filter' => User::types(),
            'value' => function ($model) {
                /** @var User $model */
                return $model->typeName;
            }
        ],
        //'type_id',
        //'branch_id',
        'actionColumn',
    ],
]); ?>
    
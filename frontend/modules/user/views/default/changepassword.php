<?php
/** @var TYPE_NAME $model */
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\adminlte3\Card;


$this->params['breadcrumbs'][] = ['label' => t('Personal cabinet'), 'url' => '/user'];
$this->params['breadcrumbs'][] = t('Change password');
$this->title=t('Change password');
?>
<div class="row">
    <div class="col-12 col-md-4">
        <?php Card::begin() ?>

        <?php $form = ActiveForm::begin(['action' => \soft\helpers\Url::to(['default/password'])]); ?>
        <?= $form->field($model, 'current_password')->passwordInput() ?>
        <?= $form->field($model, 'new_password')->passwordInput() ?>
        <?= $form->field($model, 'repeat_new_password')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('site', 'Save'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
        <?php ActiveForm::end(); ?>

        <?php Card::end() ?></div>
</div>

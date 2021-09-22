<?php
/*
 * @author Shukurullo Odilov
 * @link telegram: https://t.me/yii2_dasturchi
 * @date 15.07.2021, 16:12
 */

use common\models\User;
use soft\helpers\Html;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;

/* @var $this soft\web\View */
/* @var $model common\models\User */
/* @var $branch \common\models\Branch */
/* @var $form ActiveForm */


$passwordHint = '';
if (!$model->isNewRecord) {
    $passwordHint = "Parolni o'zgartirish uchun bu yerga yangi parolni yozing. Ushbu maydonni bo'sh qoldirsangiz, parol o'zgarmaydi!";
}

?>
<div class="row">
    <div class="col-md-6">

        <?php $form = ActiveForm::begin(); ?>

        <?= Form::widget([
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'type_id:dropdownList' => [
                    'items' => User::types(),
                ],
                'firstname',
                'lastname',
                'username',
                'password:widget' => [
                    'widgetClass' => \soft\widget\input\VisiblePasswordInput::class,
                    'hint' => $passwordHint
                ],
                'status:radioButtonGroup' => [
                    'items' => User::statuses(),
                ],
            ]
        ]); ?>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

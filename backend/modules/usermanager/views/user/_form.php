<?php

use backend\models\Client;
use backend\modules\usermanager\models\AuthItem;
use backend\modules\usermanager\models\User;
use soft\helpers\Html;
use soft\widget\adminlte3\Card;
use soft\widget\kartik\ActiveForm;
use soft\widget\kartik\Form;


/* @var $this soft\web\View */
/* @var $model backend\modules\usermanager\models\User */
/* @var $form ActiveForm */

$passwordHint = '';
if (!$model->isNewRecord) {
    $passwordHint = "Parolni o'zgartirish uchun bu yerga yangi parolni yozing. Ushbu maydonni bo'sh qoldirsangiz, parol o'zgarmaydi!";
}

$roles = AuthItem::userRoles();


?>
<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <?= Html::submitButton(Yii::t('site', 'Save'), ['visible' => !$this->isAjax]) ?>
            <?= a('Bekor qilish', ['index'], ['class' => 'btn btn-warning']) ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">

        <?= Form::widget([
            'model' => $model,
            'form' => $form,
            'attributes' => [
                'username',
                'firstname',
                'lastname',
                'password:widget' => [
                    'widgetClass' => \soft\widget\input\VisiblePasswordInput::class,
                    'hint' => $passwordHint
                ],
                'status:radioButtonGroup' => [
                    'items' => User::statuses(),
                ],
            ]
        ]); ?>

    </div>
    <div class="col-md-6">

        <?php Card::begin() ?>

        <h3>Foydalanuvchi roli</h3>

        <br>

        <?php foreach ($roles as $role): ?>

            <?= Html::checkbox('RoleName[]', $model->can($role->name), [
                'label' => $role->name,
                'value' => $role->name,
            ]) ?>

            <br>
        <?php endforeach; ?>

        <?php Card::end() ?>
    </div>

</div>


<?php ActiveForm::end(); ?>

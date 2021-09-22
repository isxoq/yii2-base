<?php

use soft\widget\adminlte3\Card;

/** @var \soft\web\View $this */
$this->params['breadcrumbs'][] = t('Personal cabinet');
$this->title = t('Personal cabinet');
$this->headerText = t('Personal data');
$user = user();

?>

<?php Card::begin([
    'type' => Card::TYPE_INFO,
    'options' => [

        'style' => [
            'min-height' => '300px'
        ]
    ]
]) ?>

<p>
    <span class="float-left h4">
        Shaxsiy ma'lumotlar
    </span>
    <span class="float-right">
        <a href="<?= to(['/student/default/update']) ?>" class="btn btn-primary rounded-0">
            <span class="fa fa-edit"></span> <?= Yii::t('site', 'Update') ?>
        </a>
        <a href="<?= to(['/user/default/password']) ?>" class="btn btn-danger rounded-0">
            <span class="fa fa-key"></span> <?= Yii::t('app', 'Change password') ?>
        </a>
    </span>
</p>
<br>
<br>
<?= \soft\widget\bs4\DetailView::widget([
    'model' => $user,
    'panel' => false,
    'options' => ['class' => 'table table-bordered table-striped'],
    'attributes' => [
        'username',
        'lastname',
        'firstname',
    ]
]) ?>
<?php Card::end() ?>

<?php

use common\models\Address;
use kartik\widgets\TypeaheadBasic;
use soft\widget\input\PhoneMaskedInput;

/* @var $this \yii\web\View */

$addresses = Address::find()->select('name')->orderBy('name asc')->column();


?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Yangi buyurtma qo'shish
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <?= PhoneMaskedInput::widget([
                                'name' => 'new-order-phone',
                                'options' => [
                                    'placeholder' => 'Tel. raqami',
                                    'class' => 'form-control',
                                    "ref" => "new_order_phone",
                                    "v-on:keyup.enter" => 'add_order'
                                ]
                            ]) ?>
                        </div>

                    </div>

                    <div class="col-md-5">
                        <div class="form-group">
                            <?= TypeaheadBasic::widget(['name' => 'new-order-address',
                                'data' => $addresses,
                                'options' => ['placeholder' => 'Qayerda turibdi',
                                    'class' => 'form-control',
                                    'ref' => 'new_order_address',
                                    "v-on:keyup.enter" => 'add_order'

                                ]]) ?>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group text-right">
                            <button class="btn btn-success" v-on:click=add_order><i class="fa fa-plus"></i> Qo'shish
                            </button>
                            <button class="btn btn-danger" v-on:click=clear_order_inputs><i class="fa fa-times"></i>
                                Tozalash
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

/* @var $this \yii\web\View */
?>

<div class="row">
    <div class="col-md-2 col-sm-3 col-6" v-for="(order, id) in orders" :key="id">
        <div class="info-box" :class="'bg-'+order.bsPrefix">
            <div class="info-box-content">
                <span class="info-box-text">
                    <b>#{{ order.id }}</b>
                    {{ order.addressName }}
                </span>
                <span class="info-box-number">{{ order.clientPhone }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
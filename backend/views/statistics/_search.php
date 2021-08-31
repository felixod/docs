<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FileUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container">
    <div class="file-user-search">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>

        <?= $form->field($model, 'id_file_user') ?>

        <?= $form->field($model, 'id_file') ?>

        <?= $form->field($model, 'full_name') ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'confirm') ?>

        <?php // echo $form->field($model, 'signature') ?>

        <?php // echo $form->field($model, 'date_confirm') ?>

        <div class="form-group">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Сброс', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
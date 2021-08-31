<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FileUser */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container">
    <div class="file-user-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'id_file')->textInput()->label('Код документа') ?>

        <?= $form->field($model, 'full_name')->textInput(['maxlength' => true])->label('Имя пользователя') ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Почта') ?>

        <?= $form->field($model, 'confirm')->textInput(['maxlength' => true])->label('Статус ознакомления с документом') ?>

        <?= $form->field($model, 'signature')->textInput(['maxlength' => true])->label('Эл. подпись') ?>

        <?= $form->field($model, 'date_confirm')->textInput()->label('Дата последнего изменения статуса') ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'id_file' => $_GET['id_file']]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
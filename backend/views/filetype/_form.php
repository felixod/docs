<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FileType */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container">
    <div class="file-type-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name_type_file')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

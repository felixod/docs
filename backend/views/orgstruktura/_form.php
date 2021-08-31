<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OrgStruktura */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="container">
    <div class="org-struktura-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name_struktura')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
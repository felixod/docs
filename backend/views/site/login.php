<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Авторизация';
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => '/backend/web/img/favicons.png']);
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните следующие поля для входа в систему:</p>

    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>

    <?= $form->field($model, 'password')->passwordInput()->label('Пароль')?>

    <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня') ?>

    <div class="form-group">
        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
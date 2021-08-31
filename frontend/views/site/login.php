<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Авторизация';
?>
<div class="form-signin">
    <div class="text-center mb-4">
        <img class="mb-4" src="/frontend/web/img/password.png" width="128px" height="128px">
        <h1 class="h3 mb-3 font-weight-normal">Авторизация</h1>

    </div>
            <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
            ]); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
                <div class="checkbox">
                    <label>
                        <?= $form->field($model, 'rememberMe')->checkbox(['class'])->label('Запомнить меня') ?>
                    </label>
                </div>
                <div style="color:#999;margin:1em 0">
                    Если Вы забыли свой пароль, Вы можете <?= Html::a('восстановить его', ['site/request-password-reset']) ?>.
                    <br>
                    Вам нужно новое письмо с подтверждением? <?= Html::a('Подтвердить', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
</div>


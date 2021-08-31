<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

//todo поправить эту ссылку, это просто ужас, но я не понимаю пока, как настроить urlManager -_-
//$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);

$verifyLink = 'http://ayii.localhost/frontend/web/index.php?r=site%2Fverify-email&token='.$user->verification_token;
?>
<div class="verify-email">
    <p>Здравствуйте, <?= Html::encode($user->username) ?>,</p>

    <p>Перейдите по ссылке ниже, чтобы подтвердить свой адрес электронной почты:</p>

    <p><?= Html::a(Html::encode($verifyLink), $verifyLink) ?></p>
</div>

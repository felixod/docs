<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Обратная связь';
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Если у вас есть деловые вопросы или другие вопросы, пожалуйста, заполните следующую форму, чтобы связаться с нами. Спасибо.
    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true])->label('Ваше имя') ?>

                <?= $form->field($model, 'email')->label('Электронная почта')?>

                <?= $form->field($model, 'themes')->label('Тема') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6])->label('Расскажите подробнее') ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ])->label('Код подтверждения')?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;


$this->title = 'Рассылка';

//Определяем версию  загрузки версии
Yii::$app->params['bsVersion'] = '4.x';

?>
<div class="container">
    <p></p>
    <h1>Рассылка</h1>
    <p></p>
    <?php $form = ActiveForm::begin(['options' => [
        'id' => 'feedback',
        'enctype' => 'multipart/form-data',
        'class' => 'form-horizontal']]); ?>

    <? //= $form->field($model, 'name')->textInput(['value' => $name]); ?>
    <?= $form->field($model, 'email')->textinput(['placeholder' => 'Иванов Иван Иванович - test@sgups.ru; Сергеев Иван Сергеевич - test2@test.ru; ', 'id' => 'email']); ?>
    <?= $form->field($model, 'body_email')->textarea(['rows' => 5, 'placeholder' => 'Ознакомиться с документом до 00.00.0000','id' => 'body_email']); ?>
    <?= $form->field($model, 'body')->textarea(['rows' => 5, 'placeholder' => 'В документе содержится информация об ....', 'id' => 'body']); ?>
    <?= $form->field($model, 'dropList')->widget(Select2::classname(), [
        'data' => $items,
        'id' => 'dropList',
        'options' => ['placeholder' => 'Выберите документ'],
        'class' => 'form-control',
    ])->label('Документ') ?>
    <div class="text-center">
        <div class="spinner-grow" style="width: 3rem; height: 3rem; display: none" role="status">
            <span class="sr-only">Загрузка...</span>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'type' => 'submit']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<script>
    $(document).ready(function () {
        $(".form-horizontal").on("submit", function (e) {


            var email = $('#email').val();
            var body_email = $('#body_email').val();
            var body = $('#body').val();

            //todo сделать проверка на выбранный селект
            if (email.length != 0 && body_email.length != 0 && body.length != 0) {

                $('.spinner-grow').show();
            } else {

            }
        })
    })
</script>
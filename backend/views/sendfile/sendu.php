<?php

use Symfony\Component\Console\Helper\ProgressBar;
use yii\bootstrap4\Progress;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\DetailView;


$this->title = 'Рассылка';

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


    <?= $form->field($model, 'name')->textInput(['placeholder' => 'Приказ № 0000 от 00.00.0000', 'id' => 'name']); ?>
    <?= $form->field($model, 'email')->textinput(['placeholder' => 'Иванов Иван Иванович - test@sgups.ru; Сергеев Иван Сергеевич - test2@test.ru; ', 'id' => 'email']); ?>
<!--    --><?//= $form->field($model, 'file_list_user')->fileInput(['class' => '', 'id' => 'file_list_user']) ?>
    <?= $form->field($model, 'body_email')->textarea(['rows' => 5, 'placeholder' => 'Ознакомиться с документом до 00.00.0000', 'id' => 'body_email']); ?>
    <?= $form->field($model, 'body')->textarea(['rows' => 5, 'placeholder' => 'В документе содержится информация об ....', 'id' => 'body']); ?>
    <?= $form->field($model, 'dropList')->widget(Select2::classname(), [
        'data' => $items,
        'id' => 'dropList',
        'options' => ['placeholder' => 'Выберите тип документа'],
        'class' => 'form-control',
    ])->label('Документ') ?>
    <?= $form->field($model, 'file')->fileInput(['class' => '', 'id' => 'file']) ?>

    <div class="text-center">
        <div class="spinner-grow" style="width: 3rem; height: 3rem; display: none" role="status">
            <span class="sr-only">Загрузка...</span>
        </div>
    </div>

    <p></p>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'type' => 'submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
//$js = <<<JS
////beforeSubmit
//    $('form').on('beforeSubmit', function(){
//       var data = $(this).serialize();
//        $.ajax({
//            url: './sendu',
//            type: 'POST',
//            data: data,
//            success: function(res){
//                $('.spinner-grow').show();
//                console.log(res);
//            },
//            error: function(){
//                alert('Error!');
//            }
//        });
//        return false;
//    });
//JS;
//
//$this->registerJs($js);
//?>
<!--<script>-->
<!---->
<!---->
<!--    $(document).ready(function () {-->
<!--        $(".form-horizontal").on("submit", function (e) {-->
<!---->
<!--            var name = $('#name').val();-->
<!--            var email = $('#email').val();-->
<!--            var body_email = $('#body_email').val();-->
<!--            var body = $('#body').val();-->
<!--            var file = $('#file').val();-->
<!--            //todo сделать проверка на выбранный селект-->
<!--            if (name.length != 0 && email.length != 0 && body_email.length != 0 && body.length != 0 && file.length != 0) {-->
<!---->
<!--                $('.spinner-grow').show();-->
<!--            } else {-->
<!---->
<!--            }-->
<!---->
<!---->
<!--        })-->
<!--    })-->
<!--</script>-->
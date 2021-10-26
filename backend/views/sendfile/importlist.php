<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Импорт пользователей';
Yii::$app->params['bsVersion'] = '4.x';
?>
    <div class="container">
        <p></p>
        <div class="alert alert-success" style="display: none" id="successinfo" role="alert">
            Добавлен!
        </div>
        <?php $form = ActiveForm::begin(['options' => [
            'id' => 'importForm',
            'enctype' => 'multipart/form-data',
            'class' => 'form-horizontal',
        ]]); ?>
        <?= $form->field($model, 'file_user')->fileInput(['id' => 'file_user']) ?>
        <p></p>
        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'type' => 'submit']) ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

<?php
//$js = <<<JS
//    $('#importForm').on('beforeSubmit', function(){
//        var data = $(this).serialize();
//        $.ajax({
//            url: 'importlist',
//            type: 'POST',
//            data: data,
//            success: function(res){
//                console.log(res)
//                document.getElementById('importForm').reset();
//                $('#successinfo').show();
//                setTimeout(function (){
//                    document.getElementById('successinfo').style.display = 'none';
//                },2000);
//            },
//            error: function(){
//                alert('Возникла ошибка, обратитесь в техническую поддержку!');
//            }
//        });
//        return false;
//    });
//JS;
//$this->registerJs($js);
//
//?>
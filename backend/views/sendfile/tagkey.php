<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Метки для документа';

Yii::$app->params['bsVersion'] = '4.x';

?>
<div class="container">
    <p></p>
    <h1>Метки для документа</h1>
    <p></p>
    <div class="alert alert-success" style="display: none" id="successinfo" role="alert">
        Добавлен!
    </div>
    <?php $form = ActiveForm::begin(['options' => [
        'id' => 'tagkeywords',
        'class' => 'form-horizontal']]); ?>
    <?= $form->field($model, 'tagname')->textInput(['id' => 'tagname']); ?>
    <p></p>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'type' => 'submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<JS
    $('#tagkeywords').on('beforeSubmit', function(){
        var data = $(this).serialize();
        $.ajax({
            url: 'tagkey',
            type: 'POST',
            data: data,
            success: function(res){
                document.getElementById('tagkeywords').reset();
                $('#successinfo').show();
                setTimeout(function (){
                    document.getElementById('successinfo').style.display = 'none';
                },2000);
            },
            error: function(){
                alert('Возникла ошибка, обратитесь в техническую поддержку!');
            }
        });
        return false;
    });
JS;
$this->registerJs($js);

?>

<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;


$this->title = 'Рассылка';

Yii::$app->params['bsVersion'] = '4.x';

?>
<div class="container">
    <p></p>
    <h1><?= Html::encode($this->title) ?></h1>
    <p></p>
    <p>
        <?= Html::submitButton('Добавить тег для документа', ['value' => \yii\helpers\Url::to('tagkey'), 'class' => 'btn btn-success', 'id' => 'modalButton']) ?>
    </p>
    <?php
    Modal::begin([
        'title' => 'Справочник тегов документов',
        'id' => 'modal_tag',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
    ?>
    <?php $form = ActiveForm::begin(['options' => [
        'id' => 'feedback',
        'enctype' => 'multipart/form-data',
        'class' => 'form-horizontal']]); ?>
    <?= $form->field($model, 'name')->textInput(['placeholder' => 'Приказ № 0000 от 00.00.0000', 'id' => 'name']); ?>
    <?= $form->field($model, 'email')->textinput(['placeholder' => 'Иванов Иван Иванович - test@sgups.ru; Сергеев Иван Сергеевич - test2@test.ru; ', 'id' => 'email']); ?>
    <?= $form->field($model, 'tag_list')->widget(Select2::className(), [
        'data' => $tag_name,
        'id' => 'tag_list',
        'class' => 'form-control',
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
        ],
    ]) ?>
    <?= $form->field($model, 'body_email')->textarea(['rows' => 5, 'placeholder' => 'Ознакомиться с документом до 00.00.0000', 'id' => 'body_email']); ?>
    <?= $form->field($model, 'body')->textarea(['rows' => 5, 'placeholder' => 'В документе содержится информация об ....', 'id' => 'body']); ?>
    <?= $form->field($model, 'dropList')->widget(Select2::classname(), [
        'data' => $items,
        'id' => 'dropList',
        'options' =>
            ['placeholder' => 'Выберите тип документа'],
        'class' => 'form-control',
        ])->label('Тип документа')?>
    <?= $form->field($model, 'file')->fileInput(['class' => '', 'id' => 'file']) ?>
    <p></p>
    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'type' => 'submit']) ?>
    </div>
    <div class="text-center">
        <div class="spinner-grow" style="width: 3rem; height: 3rem; display: none" role="status">
            <span class="sr-only">Загрузка...</span>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>


<?php
$js = <<<JS
$(document).ready(function(){
    $("#modal_tag").on('hide.bs.modal', function () {
        location.reload();
    });
});
    $('form').on('beforeSubmit', function(){
        $('.spinner-grow').show();
    });
JS;
$this->registerJs($js);

?>

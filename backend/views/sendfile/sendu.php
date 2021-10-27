<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\widgets\Pjax;

$this->title = 'Рассылка';
Yii::$app->params['bsVersion'] = '4.x';
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    $addon = [
        'prepend' => [
            'content' => '<i class="fas fa-globe"></i>'
        ],
        'append' => [
            'content' => Html::submitButton('Добавить тег для документа', ['value' => \yii\helpers\Url::to('tagkey'), 'class' => 'btn btn-success', 'id' => 'modalButton']),
            'asButton' => true
        ]
    ];
    $addon_import = [
        'prepend' => [
            'content' => '<i class="fas fa-globe"></i>'
        ],
        'append' => [
            'content' => Html::submitButton('Файл импорта', ['value' => \yii\helpers\Url::to('importlist'), 'class' => 'btn btn-success', 'id' => 'modalButtonImport']),
            'asButton' => true
        ]
    ] ?>
    <?php
    Modal::begin([
        'title' => 'Справочник тегов документов',
        'id' => 'modal_tag',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContent'></div>";
    Modal::end();
    ?>
    <?php
    Modal::begin([
        'title' => 'Импорт пользователей',
        'id' => 'import_user',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modalContentImport'></div>";
    Modal::end();
    ?>
    <?php $form = ActiveForm::begin(['options' => [
        'id' => 'feedback',
        'enctype' => 'multipart/form-data',
        'class' => 'form-horizontal',
    ]]); ?>
    <?= $form->field($model, 'name')->textInput(['id' => 'name']); ?>
    <?php Pjax::begin([
        'id' => 'pjaxContentImport',
    ]); ?>
    <?= $form->field($model, 'list_email')->widget(Select2::className(), [
        'data' => $email_list,
        'id' => 'list_email',
        'size' => Select2::MEDIUM,
        'options' => ['placeholder' => 'Иванов Иван Иванович - test@samgups.ru'],
        'class' => 'form-control',
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
            'multiple' => true,
        ],
        'addon' => $addon_import
    ]) ?>
    <?php Pjax::end(); ?>
    <?php Pjax::begin([
        'id' => 'pjaxContent',
    ]); ?>
    <?= $form->field($model, 'tag_list')->widget(Select2::className(), [
        'data' => $tag_name,
        'id' => 'tag_list',
        'class' => 'form-control',
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
        ],
        'addon' => $addon,
    ]) ?>
    <?php Pjax::end(); ?>
    <?= $form->field($model, 'body_email')->textarea(['rows' => 5, 'id' => 'body_email']); ?>
    <?= $form->field($model, 'body')->textarea(['rows' => 5, 'placeholder' => 'В документе содержится информация об ....', 'id' => 'body']); ?>
    <?= $form->field($model, 'dropList')->widget(Select2::classname(), [
        'data' => $items,
        'id' => 'dropList',
        'options' =>
            ['placeholder' => 'Выберите тип документа'],
        'class' => 'form-control',
    ])->label('Тип документа') ?>
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
        $.pjax.reload({container: '#pjaxContent', async:false});
    });
});
$(document).ready(function(){
      $("#import_user").on('hide.bs.modal', function () {
        $.pjax.reload({container: '#pjaxContentImport', async:false});
    });
});
    $('form').on('beforeSubmit', function(){
        $('.spinner-grow').show();
    });
JS;
$this->registerJs($js);

?>

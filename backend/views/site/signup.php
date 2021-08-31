<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model */

use common\models\AuthItem;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Регистрация';
$access_control = AuthItem::findAccessR()->all();

// Выводим все достпуные варианты прав доступа
$items = ArrayHelper::map($access_control, 'name', 'name');
$params = [
    'prompt' => 'Выберите права для данного пользователя'
];

//Выводим все доступные оргнизационные единицы, за которыми можно закрепить пользователя
$org_str = \backend\models\OrgStruktura::find()->all();
$items_2 = ArrayHelper::map($org_str, 'id_struktura', 'name_struktura');
$params_2 = [
    'prompt' => 'Выберите организационную единицу'
];

?>
<div class="container">
    <div class="site-signup">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Пожалуйста, заполните следующие поля для регистрации:</p>

        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>

                <?= $form->field($model, 'fullname')->label('ФИО пользователя') ?>

                <?= $form->field($model, 'email')->label('Электронная почта') ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

                <?= $form->field($model, 'dropList')->dropDownList($items, $params)->label('Права пользователя'); ?>

                <?= $form->field($model, 'dropList_2')->dropDownList($items_2, $params_2)->label('Организационная единица'); ?>

                <div class="form-group">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

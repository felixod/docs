<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FileUser */

$this->title = 'Добавление пользователей';
$this->params['breadcrumbs'][] = ['label' => 'Список пользователей', 'url' => ['index']];

?>
<div class="container">
    <div class="file-user-create">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
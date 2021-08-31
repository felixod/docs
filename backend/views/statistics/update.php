<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FileUser */

$this->title = 'Изменение данных пользователя: ' . $model->id_file_user;
$this->params['breadcrumbs'][] = ['label' => 'Список пользователей', 'url' => ['index', 'id_file' => $model->id_file]];
$this->params['breadcrumbs'][] = ['label' => $model->id_file_user, 'url' => ['view', 'id' => $model->id_file_user]];
$this->params['breadcrumbs'][] = 'Обновление данных';
?>
<div class="container">
    <div class="file-user-update">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FileUser */

$this->title = $model->id_file_user;
$this->params['breadcrumbs'][] = ['label' => 'Список пользователей', 'url' => ['index', 'id_file' => $model->id_file]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container">
    <div class="file-user-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Обновить данные', ['update', 'id' => $model->id_file_user], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id_file_user], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить этот элемент? ',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id_file_user',
                'id_file',
                'full_name',
                'email:email',
                'confirm',
                'signature',
                'date_confirm',
            ],
        ]) ?>

    </div>
</div>
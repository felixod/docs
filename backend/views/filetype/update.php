<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FileType */

$this->title = 'Обновление наименование вида документа: ' . $model->id_type_file;
$this->params['breadcrumbs'][] = ['label' => 'Вид документа', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_type_file, 'url' => ['view', 'id' => $model->id_type_file]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="container">
    <div class="file-type-update">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>

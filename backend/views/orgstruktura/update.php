<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OrgStruktura */

$this->title = 'Обновление организационной единицы: ' . $model->id_struktura;
$this->params['breadcrumbs'][] = ['label' => 'Организационная структура', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_struktura, 'url' => ['view', 'id' => $model->id_struktura]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="container">
    <div class="org-struktura-update">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
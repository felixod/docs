<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\OrgStruktura */

$this->title = 'Создание организационной структуры';
$this->params['breadcrumbs'][] = ['label' => 'Организационная структура', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="org-struktura-create">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
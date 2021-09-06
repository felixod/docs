<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FileType */

$this->title = 'Создание нового вида документа';
$this->params['breadcrumbs'][] = ['label' => 'Вид документа', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="file-type-create">

        <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

    </div>
</div>
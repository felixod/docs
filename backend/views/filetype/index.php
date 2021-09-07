<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FileTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вид документа';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="file-type-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Создать новый вид документа', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pager' => [
                'class' => '\yii\bootstrap4\LinkPager'
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id_type_file',
                'name_type_file',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>

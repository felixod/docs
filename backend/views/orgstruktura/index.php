<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrgStrukturaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Организационная структура';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="org-struktura-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Создание организационной единицы', ['create'], ['class' => 'btn btn-success']) ?>
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

                'id_struktura',
                'name_struktura',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>


    </div>
</div>
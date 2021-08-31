<?php

use yii\bootstrap4\LinkPager;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FileUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Общая статистика';
?>
<div class="container">
    <?php

    foreach ($model as $category) {

        ?>
        <p></p>
        <div class="card-group">
            <!-- Карточка 1 -->
            <div class="card">
                <div class="card-header" id="<?= $category['id_file'] ?>">Тема: <a
                            href="<?= Url::to(['index', 'id_file' => $category['id_file']]) ?>"><?= $category['themes'] ?></a>
                </div>
                <div class="card-body">
                    <p class="card-text">Описание приказа: <br> <?= $category['other_info'] ?></p>
                    <a class="card-link">Общее количество людей для ознакомления: <?= $category['confirm'] ?></a>
                    <a class="card-link">Ознакомленных: <?= $category['ozn'] ?></a>
                </div>
            </div>
        </div>
    <?php }

    ?>
    <p></p>
    <?php
    echo LinkPager::widget([
        'pagination' => $pages,
    ]);
    ?>
</div>

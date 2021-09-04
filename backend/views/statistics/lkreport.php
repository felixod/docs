<?php

use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FileUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Готовые отчеты';

?>
<div class="container">
    <?php if ($success == 'error') {

        Yii::$app->session->hasFlash('error')
        ?>
        <p></p>
    <?php } elseif ($success == "success") { ?>
        <? foreach ($test as $category) { ?>
            <p></p>
            <h1>Cформированные отчеты</h1>
            <div class="card">
                <div class="card-header">
                    Отчет № <?= $category['id_file'] ?>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $category['themes'] ?></h5>
                    <p>Дата и время подписания: <?= $category['date_gener'] ?></p>
                    <p>Подписал: <?= $category['full_name'] ?></p>
                    <p class="card-text"><?= $category['other_info'] ?></p>
                    <a href="<?= Url::to(['/reportPHPWord/' . $category['id_user'] . '/' . $category['id_file'] . '/' . $category['name_report']])?>"
                       class="btn btn-primary"><?= $category['name_report'] ?></a>
                    <!--                    <a href="--><?//= '..web/reportPHPWord/' . $category['id_user'] . '/' . $category['id_file'] . '/' . $category['name_report'] ?><!--"-->
                </div>
            </div>
            <p></p>
            <?php
        }
        ?>
        <?php
        echo LinkPager::widget([
            'pagination' => $pages
        ]);
    ?>
    <?php }?>
</div>

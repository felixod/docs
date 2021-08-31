<?php

use yii\bootstrap4\LinkPager;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FileUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сформированный отчет';
?>
<div class="container">
    <h1>Отчет</h1>
    <div class="card">
        <div class="card-header">
            Отчет № <?= $str_file[0]['id_file'] ?>
        </div>
        <div class="card-body">
            <h5 class="card-title"><?= $str_file[0]['themes'] ?></h5>
            <p><?= $str_file[0]['other_info'] ?></p>
            <p>Дата и время подписания: <?= $str_file[0]['date_gener'] ?></p>
            <p>Подписан: <?= $str_file[0]['full_name'] ?></p>
            <a href="<?= ''.$str_file[1]?>" class="btn btn-primary"><?= $str_file[0]['name_report'] ?></a>
        </div>
    </div>

</div>
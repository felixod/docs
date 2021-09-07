<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FileUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список пользователей';
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <div class="file-user-index">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>
            <?= Html::a('Назад', ['statistics/general'], ['class' => 'btn btn-info']) ?>
            <?= Html::a('Сформировать отчёт', ['statistics/reportword', 'id_file' => $_GET['id_file']], ['class' => 'btn btn-warning']) ?>
        </p>
        <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php if (Yii::$app->user->can('supermoderator')) { ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id_file_user',
                    'id_file',
                    'full_name',
                    'email:email',
                    'confirm',
                    'signature',
                    'date_confirm',
                    [
                        'class' => 'yii\grid\ActionColumn',
                    ],
                ],
            ]);
            ?>
            <?php if (!empty($dataProvider_2)) {
                foreach ($dataProvider_2 as $item) {
                    ?>
                    <div class="accordion" id="accordionExample">
                        <div class="card">
                            <div class="card-header" id="<?= $item[0]['id_file'] ?>">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#<?= str_replace(' ', '', $item[0]['name_struktura']) ?>"
                                            aria-expanded="true" aria-controls="collapseOne">
                                        <?= $item[0]['name_struktura'] ?>
                                    </button>
                                </h5>
                            </div>

                            <div id="<?= str_replace(' ', '', $item[0]['name_struktura']) ?>" class="collapse show"
                                 aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    <h3></h3>
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">ФИО</th>
                                            <th scope="col">Почта</th>
                                            <th scope="col">Ознакомился</th>
                                            <th scope="col">Дата</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php for ($i = 0; $i < count($item); $i++) {
                                            ?>
                                            <tr>
                                                <th scope="row"><?= $item[$i]['id_file_user'] ?></th>
                                                <td><?= $item[$i]['full_name'] ?></td>
                                                <td><?= $item[$i]['email'] ?></td>
                                                <td><? if ($item[$i]['confirm'] == 1) {
                                                        echo 'Да';
                                                    } else {
                                                        echo ' Нет';
                                                    } ?></td>
                                                <td><?= $item[$i]['date_confirm'] ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php }
        } else {
            ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],


                    'id_file_user',
                    'id_file',
                    'full_name',
                    'email:email',
                    'confirm',
                    'signature',
                    'date_confirm',

                ],
            ]);
        } ?>
    </div>
</div>

<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Информационная страница';

?>
<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="list-group" id="list-tab" role="tablist">
                <?php foreach ($gr as $item) { ?>
                <a class="list-group-item list-group-item-action" id="<?= $item[0]['id_type_file']?>" href="?id_bt=<?= $item[0]['name_type_file'] ?>&id_type_file=<?= $item[0]['id_type_file']?>" role="tab" aria-controls="<?= $item[0]['name_type_file'] ?>"><?= $item[0]['name_type_file'] ?></a>
                <?php }?>
            </div>
        </div>

        <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
                <?php foreach ($gr as $item) { ?>
                <?php for ($i = 0; $i < count($item); $i++) { ?>
                    <?php if ($_GET['id_type_file'] == $item[$i]['id_type_file']) { ?>
                        <div class="tab-pane fade show active" id="<?= $_GET['id_bt'] ?>" role="tabpanel"
                             aria-labelledby="list-home-list">
                            <div class="card">
                                <div class="card-header">
                                    <?= $item[$i]['themes'] ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Статус: <?= $item[$i]['status'] ?></h5>
                                    <p class="card-text"><?= $item[$i]['other_info'] ?></p>
                                    <a target="_blank"
                                       href="<?= Yii::$app->urlManagerBackend->createUrl([$item[$i]['path']]) ?>"
                                       class="btn btn-primary">Посмотреть</a>
                                </div>
                                <div class="card-footer text-muted">
                                    <?= $item[$i]['date_file'] ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

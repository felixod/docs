<?php

/* @var $this yii\web\View */


use yii\bootstrap4\LinkPager;

$this->title = 'Информационная страница';

?>
<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="list-group" id="list-tab" role="tablist">
                <?php foreach ($file_type as $item) { ?>
                    <a class="list-group-item list-group-item-action" id="<?= $item['id_type_file'] ?>"
                       href="?id_bt=<?= $item['name_type_file'] ?>&id_type_file=<?= $item['id_type_file'] ?>"
                       role="tab"
                       aria-controls="<?= $item['name_type_file'] ?>"><?= $item['name_type_file'] ?></a>
                <?php } ?>
            </div>
        </div>
        <div class="col-8">
            <div class="tab-content" id="nav-tabContent">
                <?php foreach ($gr as $item) { ?>
                        <?php if ($_GET['id_type_file'] == $item['id_type_file'] && count($item) > 3) { ?>
                            <div class="tab-pane fade show active" id="<?= $_GET['id_bt'] ?>" role="tabpanel"
                                 aria-labelledby="list-home-list">
                                <div class="card">
                                    <div class="card-header">
                                        <?= $item['themes'] ?>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Статус: <?= $item['status'] ?></h5>
                                        <p class="card-text"><?= $item['other_info'] ?></p>
                                        <?php foreach ($tag as $i_tag) {
                                            if ($i_tag['tag_file_id'] == $item['id_file']) {
                                                ?><span class='badge badge-dark'><?= $i_tag['tagname'] ?></span><?php
                                            }
                                        } ?>
                                        <br>
                                        <a target="_blank"
                                           href="<?= Yii::$app->urlManagerBackend->createUrl([$item['path']]) ?>"
                                           class="btn btn-primary">Документ</a>
                                    </div>
                                    <div class="card-footer text-muted">
                                        <?= $item['date_file'] ?>
                                    </div>
                                </div>
                            </div>
                            <br>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
?>
</div>


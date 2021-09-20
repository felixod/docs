<?php

/* @var $this yii\web\View */

use yii\helpers\Url;

$this->title = 'Информационная страница';
?>
<div class="container">
    <?php foreach ($gr as $item) { ?>
        <?php if ($item[0]['name_type_file'] != NULL) { ?>
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="<?= $item[0]['id_type_file'] ?>">
                        <h5 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                    data-target="#<?= $item[0]['name_type_file'] ?>" aria-expanded="true"
                                    aria-controls="collapseOne">
                                <?= $item[0]['name_type_file'] ?>
                            </button>
                        </h5>
                    </div>

                    <div id="<?= $item[0]['name_type_file'] ?>" class="collapse show" aria-labelledby="headingOne"
                         data-parent="#<?= $item[0]['name_type_file'] ?>">
                        <div class="card-body">
                            <h3></h3>
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Номер документа</th>
                                    <th scope="col">Наименование</th>
                                    <th scope="col">Ссылка</th>
                                    <th scope="col">Статус документа</th>
                                    <th scope="col">Дата публикации</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php for ($i = 0; $i < count($item); $i++) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $item[$i]['id_file'] ?></th>
                                        <td><?= $item[$i]['themes'] ?></td>
                                        <td>
                                            <a target="_blank" href="<?= Yii::$app->urlManagerBackend->createUrl([$item[$i]['path']]) ?>">Ссылка</a>
                                        </td>
                                        <td><?= $item[$i]['status'] ?></td>
                                        <td><?= $item[$i]['date_file'] ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>

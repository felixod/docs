<?php

/* @var $this yii\web\View */

$this->title = 'Информационная страница';
?>
<?php foreach ($gr as $item) { ?>
    <div class="container">
        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="<?= $item[0]['id_type_file']?>">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#<?=$item[0]['name_type_file']?>" aria-expanded="true" aria-controls="collapseOne">
                            <?= $item[0]['name_type_file'] ?>
                        </button>
                    </h5>
                </div>

                <div id="<?=$item[0]['name_type_file']?>" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <h3></h3>
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Номер документа</th>
                                <th scope="col">Наименование</th>
                                <th scope="col">Почта</th>
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
                                    <td><?= $item[$i]['email'] ?></td>
                                    <td><?= $item[$i]['status']?></td>
                                    <td><?= $item[$i]['date_file'] ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php } ?>
<div class="accordion" id="accordionExample">
    <div class="card">
        <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Сворачиваемый групповой элемент #1
                </button>
            </h2>
        </div>

        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                Некоторый заполнитель для первой панели аккордеона. Эта панель отображается по умолчанию благодаря классу <code>.show</code>.
            </div>
        </div>
    </div>

<!--<div class="container">-->
<!--<div class="row">-->
<!--    <div class="col-4">-->
<!--        <div class="list-group" id="list-tab" role="tablist">-->
<!--            <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Home</a>-->
<!--            <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Profile</a>-->
<!--            <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Messages</a>-->
<!--            <a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Settings</a>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="col-8">-->
<!--        <div class="tab-content" id="nav-tabContent">-->
<!--            <div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">...</div>-->
<!--            <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">...</div>-->
<!--            <div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">...</div>-->
<!--            <div class="tab-pane fade" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">...</div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!--</div>-->
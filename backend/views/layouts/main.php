<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => '/backend/web/img/favicons.png']);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal"><a href="<?= Yii::$app->homeUrl ?>"><img src="/backend/web/img/logow.png"/></a></h5>
        <?php
        if (Yii::$app->user->isGuest) {
            try {
                echo Nav::widget([
                    'encodeLabels' => false,
                    'items' => [
                        Yii::$app->user->isGuest ? (
                        ['label' => 'Авторизация', 'url' => ['/site/login']]) :
                            [
                                'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                                'url' => ['/site/logout'],
                                'linkOptions' => ['data-method' => 'post']
                            ],
                    ],
                ]);
            } catch (Exception $e) {
            }
        }
        if (Yii::$app->user->can('admin')) {
            try {
                echo Nav::widget([

                    'encodeLabels' => false,
                    'items' => [

                        ['label' => 'Основное', 'items' => [
                            ['label' => 'Регистрация', 'url' => ['/site/signup']],
                            ['label' => 'Новый документ', 'url' => ['/sendfile/sendu']],
                            ['label' => 'Рассылка готового документа', 'url' => ['/sendfile/senduorg']],
                        ]],
                        ['label' => 'Справочники', 'items' => [
                            ['label' => 'Организационная структура', 'url' => ['orgstruktura/index']],
                            ['label' => 'Вид документа', 'url' => ['/filetype/index']],
                        ]],
                        ['label' => 'Стастистика', 'items' => [
                            ['label' => 'Общая статистика', 'url' => ['/statistics/general']],],],
                        Yii::$app->user->isGuest ? (

                        ['label' => 'Авторизация', 'url' => ['/site/login']]) :
                            [
                                'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                                'url' => ['/site/logout'],
                                'linkOptions' => ['data-method' => 'post']
                            ],
                    ],
                ]);
            } catch (Exception $e) {
            }
        } else if (Yii::$app->user->can('editor')) {
            try {
                echo Nav::widget([

                    'encodeLabels' => false,
                    'items' => [

                        ['label' => 'Основное', 'items' => [
                            ['label' => 'Новый документ', 'url' => ['/sendfile/sendu']],
                            ['label' => 'Рассылка готового документа', 'url' => ['/sendfile/senduorg']],
                        ]],
                        ['label' => 'Стастистика', 'items' => [
                            ['label' => 'Общая статистика', 'url' => ['/statistics/general']],],],

                        Yii::$app->user->isGuest ? (

                        ['label' => 'Авторизация', 'url' => ['/site/login']]) :
                            [
                                'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                                'url' => ['/site/logout'],
                                'linkOptions' => ['data-method' => 'post']
                            ],
                    ],
                ]);
            } catch (Exception $e) {
            }
        }
        ?>
    </div>


    <?= Breadcrumbs::widget([
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>

    <div class="container">
        <footer class="pt-4 my-md-5 pt-md-5 border-top">
            <div class="row">
                <div class="col-12 col-md">
                    <img class="mb-2" src="/backend/web/img/logow.png">
                    <small class="d-block mb-3 text-muted">© Команда разработчиков СамГУПС <?= date('Y') ?></small>
                </div>
            </div>
        </footer>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
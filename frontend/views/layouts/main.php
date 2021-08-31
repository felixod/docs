<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => '/frontend/web/img/favicons.png']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" xmlns="http://www.w3.org/1999/html">
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

<div class="wrap">
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">
            <a href="<?= Yii::$app->homeUrl ?>"><img src="/frontend/web/img/logow.png"/></a>
        </h5>
        <nav class="my-2 my-md-0 mr-md-3 nav-item active">
            <? echo Nav::widget([
                'encodeLabels' => false,
                'items' => [
                    ['label' => 'Главная', 'url' => ['/site/index']],
                    ['label' => 'О сайте', 'url' => ['/site/about']],
                    ['label' => 'Свяжитесь с нами', 'url' => ['/site/contact']],
                    Yii::$app->user->isGuest ? (

                    ['label' => 'Авторизация', 'url' => ['/site/login']]):
                        [
                            'label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']
                        ],
                ],
            ]);
            ?>
        </nav>
    </div>
    <main role="main">
<!--        --><?//= Breadcrumbs::widget([
//            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
//        ]) ?>
<!--        --><?//= Alert::widget() ?>
        <?= $content ?>

</div>
</main>
<footer id="footer" class="footer mt-auto py-3 bg-white border-bottom shadow-sm">
    <div class="container" >
        <span class="text-muted">&copy; СамГУПС <?= date('Y') ?></span>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


<?php
return [
    'id' => 'app-common-tests',
    'language' => 'RU-ru',
    'basePath' => dirname(__DIR__),
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
        ],
    ],
];

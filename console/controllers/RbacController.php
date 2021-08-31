<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
/**
 * Инициализатор RBAC выполняется в консоли php yii my-rbac/init
 */
class RbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Создадим роли админа и модератора
        $admin = $auth->createRole('admin');
        $editor = $auth->createRole('editor');

        // запишем их в БД
        $auth->add($admin);
        $auth->add($editor);

        // Создаем разрешения. Например, просмотр админки viewAdminPage и рассылка документов
        $viewAdminPage = $auth->createPermission('viewAdminPage');
        $viewAdminPage->description = 'Просмотр админки';

        $updateNews = $auth->createPermission('sendDoc');
        $updateNews->description = 'Рассылка документов';

        // Запишем эти разрешения в БД
        $auth->add($viewAdminPage);
        $auth->add($updateNews);

        // Теперь добавим наследования. Для роли editor мы добавим разрешение sendDoc,
        // а для админа добавим наследование от роли editor и еще добавим собственное разрешение viewAdminPage

        // Роли «Редактор новостей» присваиваем разрешение «Редактирование новости»
        $auth->addChild($editor,$updateNews);

        // админ наследует роль редактора новостей. Он же админ, должен уметь всё! :D
        $auth->addChild($admin, $editor);

        // Еще админ имеет собственное разрешение - «Просмотр админки»
        $auth->addChild($admin, $viewAdminPage);

        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1);

        // Назначаем роль editor пользователю с ID 2
        $auth->assign($editor, 2);
    }
}
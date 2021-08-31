<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class FileUser extends ActiveRecord
{
    public static function tableName() {
        return 'file_user';
    }
}
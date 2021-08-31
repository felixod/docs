<?php


namespace common\models;


use yii\db\ActiveRecord;

class AuthItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'auth_item';
    }

    public static function findAccessR()
    {
        return static::find();
    }
}
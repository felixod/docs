<?php


namespace frontend\models;


use yii\db\ActiveRecord;

class FileStatus extends ActiveRecord
{
    public static function tableName() {
        return 'file_status';
    }
}
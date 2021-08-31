<?php


namespace frontend\models;


use yii\base\Model;

class ConfirmForm extends Model
{
    public $readdoc;

    public function rules()
    {
        return [
            [['readdoc'], 'required'],
        ];
    }
}
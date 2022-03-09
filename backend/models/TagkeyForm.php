<?php

namespace backend\models;

use yii\base\Model;

class TagkeyForm extends Model
{
    public $tagname;

    public function attributeLabels()
    {
        return [
            'tagname' => 'Введите наименование',
        ];
    }

    public function rules()
    {
        return [
            // удалить пробелы для всех трех полей формы
            [['tagname',], 'trim'],
            // поле tagname обязательно для заполнения
            ['tagname', 'required', 'message' => 'Поле «Наименование тега» обязательно для заполнения'],

        ];
    }

}
<?php


namespace frontend\models;


use yii\base\Model;

class SendFileForm extends Model
{
    public $name;
    public $email;
    public $body;
    public $file;

    public function attributeLabels() {
        return [
            'name' => 'Ваша тема',
            'email' => 'Ваш e-mail',
            'body' => 'Информация',
            'file' => 'Ваш файл',
        ];
    }

    public function rules() {
        return [
            // удалить пробелы для всех трех полей формы
            [['name', 'email', 'body'], 'trim'],
            // поле name обязательно для заполнения
            ['name', 'required', 'message' => 'Поле «Ваше имя» обязательно для заполнения'],
            // поле email обязательно для заполнения
            ['email', 'required', 'message' => 'Поле «Ваш email» обязательно для заполнения'],
            // поле body обязательно для заполнения
            ['body', 'required', 'message' => 'Поле «Сообщение» обязательно для заполнения'],
            // поле name должны быть не более 50 символов
            [
                ['name'],
                'string',
                'max' => 50,
                'tooLong' => 'Поле должно быть длиной не более 50 символов'
            ],
            // поле email должны быть не более 50 символов
            [
                ['email'],
                'string',
            ],
            // поле body должно быть не более 1000 символов
            [
                'body',                'string',
                'max' => 1000,
                'tooLong' => 'Сообщение должно быть длиной не более 1000 символов'
            ],
        ];
    }
}
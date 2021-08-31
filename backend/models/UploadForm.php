<?php


namespace backend\models;


use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'pdf'],

            'checkExtensionByMimeType' => true,
            'maxSize' => 20971520,
            'tooBig' => 'Лимит 20 мб'
        ];
    }
}
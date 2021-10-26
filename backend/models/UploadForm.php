<?php


namespace backend\models;


use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file_user;

    /**
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'file_user' => 'Файл импорта',
        ];
    }
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file_user'], 'file', 'extensions' => ['csv'], 'skipOnEmpty' => false],
            ];

    }

    public static function impotrSave($model){
        $session = Yii::$app->session;
        $fh = fopen($model->file_user->tempName, "r");
        fgetcsv($fh, 0, ',');


        while (($row = fgetcsv($fh, 0, ',')) !== false) {
            list($name, $email) = $row;

            $data[] = [
                'full_list' => $name . ' - ' . $email,
            ];
        }
        $session->set('import_list', $data);
    }
}
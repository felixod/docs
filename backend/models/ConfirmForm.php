<?php


namespace backend\models;


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

    /**
     * @param $length
     * @return string
     */
    public static function generateHash($length)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    public static function confirmDoc($model, $id_file_user)
    {
        $confirm = $model->readdoc;
        
        $date = date("Y-m-d H:i:s");
        $today = date("Y-m-d H:i:s");
        $unixDate = strtotime($today);

        $num = self::generateHash(22);
        $signature = $num . $unixDate;

        //Обновление данных
        // $sql_update = FileUser::findOne(base64_decode($id_file_user));
        $sql_update = FileUser::findOne(intval($id_file_user));
        $sql_update->confirm = $confirm;
        $sql_update->signature = $signature;
        $sql_update->date_confirm = $date;
        $sql_update->save();

    }
}
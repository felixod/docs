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

    public static function confirmDoc($model, $id_file_user)
    {
        $confirm = $model->readdoc;
        $date = date('Y-m-d H:i:s');
        $unixDate = strtotime($date);
        $num = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
        $signature = $unixDate.$num;

        //Обновление данных
        $sql_update = FileUser::findOne($id_file_user);
        $sql_update->confirm = $confirm;
        $sql_update->signature = $signature;
        $sql_update->date_confirm = $date;
        $sql_update->save();

    }
}
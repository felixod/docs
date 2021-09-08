<?php

namespace backend\models;

use backend\models\File;
use Yii;

/**
 * This is the model class for table "file_user".
 *
 * @property int $id_file_user
 * @property int $id_file
 * @property string $full_name
 * @property string $email
 * @property string $confirm
 * @property string|null $signature
 * @property string $date_confirm
 *
 * @property File $file
 */
class FileUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_file', 'full_name', 'email', 'confirm', 'date_confirm'], 'required'],
            [['id_file'], 'integer'],
            [['date_confirm'], 'safe'],
            [['full_name', 'email'], 'string', 'max' => 255],
            [['confirm'], 'string', 'max' => 13],
            [['signature'], 'string', 'max' => 900],
            [['id_file'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['id_file' => 'id_file']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_file_user' => 'Id File User',
            'id_file' => 'Id File',
            'full_name' => 'ФИО',
            'email' => 'Электронная почта',
            'confirm' => 'Ознакомился',
            'signature' => 'Цифровой идентификатор ознакомления',
            'date_confirm' => 'Дата ознакомления / уведомления',
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id_file' => 'id_file']);
    }
}

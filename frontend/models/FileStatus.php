<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file_status".
 *
 * @property int $id_file_status
 * @property int $id_file
 * @property string $status
 * @property string $date_status
 *
 * @property File $file
 */
class FileStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_file', 'status', 'date_status'], 'required'],
            [['id_file'], 'integer'],
            [['date_status'], 'safe'],
            [['status'], 'string', 'max' => 900],
            [['id_file'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['id_file' => 'id_file']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_file_status' => 'Id File Status',
            'id_file' => 'Id File',
            'status' => 'Status',
            'date_status' => 'Date Status',
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

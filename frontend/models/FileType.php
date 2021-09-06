<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file_type".
 *
 * @property int $id_type_file
 * @property string $name_type_file
 *
 * @property File[] $files
 */
class FileType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_type_file'], 'required'],
            [['name_type_file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_type_file' => 'Id Type File',
            'name_type_file' => 'Name Type File',
        ];
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id_type_file' => 'id_type_file']);
    }
}

<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "org_struktura".
 *
 * @property int $id_struktura
 * @property string $name_struktura
 *
 * @property File[] $files
 */
class OrgStruktura extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'org_struktura';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name_struktura'], 'required'],
            [['name_struktura'], 'string', 'max' => 900],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_struktura' => 'Id Struktura',
            'name_struktura' => 'Name Struktura',
        ];
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id_struktur' => 'id_struktura']);
    }
}

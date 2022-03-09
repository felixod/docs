<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag_keywords".
 *
 * @property int $id_tag
 * @property string $tagname
 */
class TagKeywords extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag_keywords';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tagname'], 'required'],
            [['tagname'], 'string', 'max' => 255],
            [['tagname'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tag' => 'Уникальный номер',
            'tagname' => 'Наименование',
        ];
    }

    /**
     * @param $model
     */
    public static function addTagname($model){

        $sql = new TagKeywords();
        $sql->tagname = $model['tagname'];
        $sql->save();
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag_file_keyword".
 *
 * @property int $id_tag_file_key
 * @property int $tag_file_id
 * @property int $tag_id
 */
class TagFileKeyword extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tag_file_keyword';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tag_file_id', 'tag_id'], 'required'],
            [['tag_file_id', 'tag_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tag_file_key' => 'Id Tag File Key',
            'tag_file_id' => 'Tag File ID',
            'tag_id' => 'Tag ID',
        ];
    }
}

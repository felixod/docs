<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag_file_keyword".
 *
 * @property int $id_tag_file_key
 * @property int $tag_file_id
 * @property int $tag_id
 *
 * @property File $tagFile
 * @property TagKeywords $tag
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
            [['tag_file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['tag_file_id' => 'id_file']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => TagKeywords::className(), 'targetAttribute' => ['tag_id' => 'id_tag']],
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

    /**
     * Gets query for [[TagFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagFile()
    {
        return $this->hasOne(File::className(), ['id_file' => 'tag_file_id']);
    }

    /**
     * Gets query for [[Tag]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(TagKeywords::className(), ['id_tag' => 'tag_id']);
    }
}

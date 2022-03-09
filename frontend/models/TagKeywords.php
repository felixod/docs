<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag_keywords".
 *
 * @property int $id_tag
 * @property string $tagname
 *
 * @property TagFileKeyword[] $tagFileKeywords
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
            'id_tag' => 'Id Tag',
            'tagname' => 'Tagname',
        ];
    }

    /**
     * Gets query for [[TagFileKeywords]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTagFileKeywords()
    {
        return $this->hasMany(TagFileKeyword::className(), ['tag_id' => 'id_tag']);
    }

    public static function getListFileTag(){
        $query = \Yii::$app->db->createCommand("SELECT 
                                                           tag_file_keyword.id_tag_file_key, 
                                                           tag_keywords.tagname, 
                                                           tag_file_keyword.tag_file_id 
                                                    FROM 
                                                         tag_keywords, tag_file_keyword 
                                                    WHERE 
                                                          tag_file_keyword.tag_id = tag_keywords.id_tag");

        return $query->queryAll();
    }

}

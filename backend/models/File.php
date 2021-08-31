<?php

namespace backend\models;

use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
 * This is the model class for table "file".
 *
 * @property int $id_file
 * @property int $id_user
 * @property int $id_struktur
 * @property string $themes
 * @property string $name_file
 * @property string $date_file
 * @property string $type_file
 * @property string $path
 *
 * @property OrgStruktura $struktur
 * @property User $user
 * @property FileStatus[] $fileStatuses
 * @property FileUser[] $fileUsers
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_struktur', 'themes', 'name_file', 'date_file', 'type_file', 'path'], 'required'],
            [['id_user', 'id_struktur'], 'integer'],
            [['date_file'], 'safe'],
            [['themes'], 'string', 'max' => 600],
            [['other_info'], 'string', 'max' => 755],
            [['name_file', 'type_file', 'path'], 'string', 'max' => 900],
            [['id_struktur'], 'exist', 'skipOnError' => true, 'targetClass' => OrgStruktura::className(), 'targetAttribute' => ['id_struktur' => 'id_struktura']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_file' => 'Id File',
            'id_user' => 'Id User',
            'id_struktur' => 'Id Struktur',
            'themes' => 'Themes',
            'name_file' => 'Name File',
            'other_info' => 'Other info',
            'date_file' => 'Date File',
            'type_file' => 'Type File',
            'path' => 'Path',
        ];
    }

    /**
     * Gets query for [[Struktur]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStruktur()
    {
        return $this->hasOne(OrgStruktura::className(), ['id_struktura' => 'id_struktur']);
    }

    public function getConfirm()
    {
        return $this->hasOne(FileUser::className(), ['confirm' => 'confirm']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * Gets query for [[FileStatuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFileStatuses()
    {
        return $this->hasMany(FileStatus::className(), ['id_file' => 'id_file']);
    }

    /**
     * Gets query for [[FileUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFileUsers()
    {
        return $this->hasMany(FileUser::className(), ['id_file' => 'id_file']);
    }


    public static function getFileInfo($pages, $id_user)
    {

        $themes = Yii::$app->db->createCommand('SELECT file.id_file, file.themes, file.other_info, COUNT(file_user.confirm) as confirm,
                                                      sum(CASE WHEN file_user.confirm= "0" THEN 1 ELSE 0 END) as no_ozn,
                                                      sum(CASE WHEN file_user.confirm = "1" THEN 1 ELSE 0 END) as ozn
                                                    FROM file_user, file
                                                    WHERE file_user.id_file=file.id_file AND file.id_user =' . $id_user . '
                                                    GROUP BY file.id_file
                                                    LIMIT 
                                                         ' . $pages->limit . '
                                                    OFFSET 
                                                         ' . $pages->offset)->queryAll();

        return $themes;
    }

    public static function getFileOrg()
    {
        return Yii::$app->db->createCommand('SELECT 
            file.id_file, 
            file.id_struktur, 
            org_struktura.name_struktura, 
            file.name_file
        FROM 
            file, 
            org_struktura 
        WHERE 
            file.id_struktur = org_struktura.id_struktura
        AND 
            file.parent is null')->queryAll();

    }
}

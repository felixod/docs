<?php

namespace backend\models;

use app\models\GenerReports;
use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $id_file
 * @property int $id_user
 * @property int $id_struktur
 * @property string $themes
 * @property string $name_file
 * @property string $other_info
 * @property string $date_file
 * @property string $type_file
 * @property string $path
 * @property int|null $id_type_file
 * @property int|null $parent
 *
 * @property OrgStruktura $struktur
 * @property User $user
 * @property FileType $typeFile
 * @property FileStatus[] $fileStatuses
 * @property FileUser[] $fileUsers
 * @property GenerReports[] $generReports
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
            [['id_user', 'id_struktur', 'themes', 'name_file', 'other_info', 'date_file', 'type_file', 'path'], 'required'],
            [['id_user', 'id_struktur', 'id_type_file', 'parent'], 'integer'],
            [['date_file'], 'safe'],
            [['themes'], 'string', 'max' => 600],
            [['name_file', 'type_file', 'path'], 'string', 'max' => 900],
            [['other_info'], 'string', 'max' => 755],
            [['id_struktur'], 'exist', 'skipOnError' => true, 'targetClass' => OrgStruktura::className(), 'targetAttribute' => ['id_struktur' => 'id_struktura']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_type_file'], 'exist', 'skipOnError' => true, 'targetClass' => FileType::className(), 'targetAttribute' => ['id_type_file' => 'id_type_file']],
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
            'other_info' => 'Other Info',
            'date_file' => 'Date File',
            'type_file' => 'Type File',
            'path' => 'Path',
            'id_type_file' => 'Id Type File',
            'parent' => 'Parent',
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
     * Gets query for [[TypeFile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTypeFile()
    {
        return $this->hasOne(FileType::className(), ['id_type_file' => 'id_type_file']);
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

    /**
     * Gets query for [[GenerReports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenerReports()
    {
        return $this->hasMany(GenerReports::className(), ['id_file' => 'id_file']);
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
            file.name_file,
            file.id_type_file
        FROM 
            file, 
            org_struktura 
        WHERE 
            file.id_struktur = org_struktura.id_struktura
        AND 
            file.parent is null')->queryAll();

    }
}

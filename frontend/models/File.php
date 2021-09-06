<?php

namespace app\models;

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

    public function search_2($institut)
    {
        $k = 0;

        foreach ($institut as $item) {


//            $query = FileUser::find()->where('id_file=' . $item['id_file']);
            $query = \Yii::$app->db->createCommand('SELECT 
                                                            file.id_file,
                                                            file.id_user,
                                                            file.id_struktur,
                                                            file.themes,
                                                            file.name_file,
                                                            file.other_info,
                                                            file.date_file,
                                                            file.type_file,
                                                            file.path,
                                                            file.id_type_file,
                                                            file.parent,
                                                            file_type.name_type_file,
                                                            file_status.status
                                                        FROM 
                                                            file, 
                                                            file_type,
                                                            file_status
                                                        WHERE 
                                                            file.id_type_file ='.$item['id_type_file'].'
                                                        AND 
                                                            file.id_type_file = file_type.id_type_file
                                                        AND
                                                            file_status.id_file = file.id_file');
            $f = $query->queryAll();

            foreach ($f as $key) {
                $institut[$k] = [
                    'id_file' => $key['id_file'],
                    'id_user' => $key['id_user'],
                    'id_struktur' => $key['id_struktur'],
                    'themes' => $key['themes'],
                    'name_file' => $key['name_file'],
                    'other_info' => $key['other_info'],
                    'date_file' => $key['date_file'],
                    'type_file' => $key['type_file'],
                    'path' => $key['path'],
                    'status' => $key['status'],
                    'id_type_file' => $key['id_type_file'],
                    'name_type_file' => $key['name_type_file'],
                    'parent' => $key['parent']
                ];
                $k++;
            }
        }

        $grouped = array();
        $groupBy = 'id_type_file';
        foreach ($institut as $v) {
            $key = $v[$groupBy];
            if (!array_key_exists($key, $grouped))
                $grouped[$key] = array($v);
            else
                $grouped[$key][] = $v;
        }

        return $grouped;
    }

}

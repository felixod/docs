<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $full_name
 * @property int $org_struktur
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property File[] $files
 * @property GenerReports[] $generReports
 * @property OrgStruktura $orgStruktur
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'full_name', 'org_struktur', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['org_struktur', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['full_name'], 'string', 'max' => 500],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['org_struktur'], 'exist', 'skipOnError' => true, 'targetClass' => OrgStruktura::className(), 'targetAttribute' => ['org_struktur' => 'id_struktura']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'full_name' => 'Full Name',
            'org_struktur' => 'Org Struktur',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
        ];
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id_user' => 'id']);
    }

    /**
     * Gets query for [[GenerReports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenerReports()
    {
        return $this->hasMany(GenerReports::className(), ['id_user' => 'id']);
    }

    /**
     * Gets query for [[OrgStruktur]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrgStruktur()
    {
        return $this->hasOne(OrgStruktura::className(), ['id_struktura' => 'org_struktur']);
    }
}

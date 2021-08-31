<?php
namespace backend\models;

use common\models\AuthAssignment;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $dropList;
    public $dropList_2;
    public $fullname;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Это имя пользователя уже используется'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['fullname', 'trim'],
            ['fullname', 'required'],
            ['fullname', 'string', 'min' => 1, 'max' => 500],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот адрес электронной почты уже был взят.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],

            ['dropList', 'required'],
            ['dropList', 'trim'],

            ['dropList_2', 'required'],
            ['dropList_2', 'trim'],



        ];
    }

    /**
     * @return \yii\rbac\Assignment|null
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        //todo Убрал подтверждение регистрации
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->full_name = $this->fullname;
        $user->org_struktur = $this->dropList_2;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->status = 10;
        $user->generateEmailVerificationToken();
        $user->save();

        $user_id = Yii::$app->db->getLastInsertID();
        $userRole = Yii::$app->authManager->getRole($this->dropList);

        return Yii::$app->authManager->assign($userRole, $user_id);

        //Раскоммнтировать при добавлении подтверждения регистрации
        //return $this->sendEmail($user);

    }

    /**
     * Changes the presentation of fields when displaying tooltips.
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'fullname' => 'Полное имя пользователя (ФИО)',
            'email' => 'Электронная почта',
            'dropList' => 'Права доступа для пользователя'
        ];
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Регистрация учетной записи - ' . Yii::$app->name)
            ->send();
    }
}

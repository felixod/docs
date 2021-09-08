<?php


namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\validators\EmailValidator;
use yii\web\UploadedFile;

class SendFileOrgForm extends Model
{
//    public $name;
    public $email;
    public $body_email;
    public $body;
    public $dropList;


    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'body_email' => 'Текст письма',
            'body' => 'Информация об документе',
            'dropList' => 'Документ'
        ];
    }

    public function rules()
    {
        return [
            // удалить пробелы для всех трех полей формы
            [['email', 'body'], 'trim'],
            // поле email обязательно для заполнения
            ['email', 'required', 'message' => 'Поле «Ваш email» обязательно для заполнения'],
            // поле body_email обязательно для заполнения
            ['body_email', 'required', 'message' => 'Поле «Текст письма» обязательно для заполнения'],
            // поле body обязательно для заполнения
            ['body', 'required', 'message' => 'Поле «Информация» обязательно для заполнения'],
            // поле email должны быть не более 50 символов
            [
                ['email'],
                'string',
            ],
            // поле body должно быть не более 1000 символов
            [
                'body', 'string',
                'max' => 1000,
                'tooLong' => 'Сообщение должно быть длиной не более 1000 символов'
            ],

            ['dropList', 'required'],
            ['dropList', 'trim'],
        ];
    }

    public static function SendFileOrg($model)
    {
        $date = date('Y-m-d H:i:s');

        $parent_file = File::find()->where(['id_file' => $model->dropList])->one();

        //Разбиваеи список полученных электронных адресов и помещяю в массив
        $mas_em = explode(";", strip_tags($model->email));

        //Запрос для первичного добавления файла
        $sql = new File();
        $sql->id_user = Yii::$app->user->id;

        //todo заменить id структуры или выкинуть совсем
        $sql->id_struktur = Yii::$app->user->identity->org_struktur;
        $sql->themes = strip_tags($parent_file['themes']);
        $sql->name_file = strip_tags($parent_file['name_file']);
        $sql->other_info = strip_tags($model->body);
        $sql->date_file = strip_tags($date);
        $sql->type_file = strip_tags($parent_file['type_file']);
        $sql->id_type_file = strip_tags($parent_file['id_type_file']);
        $sql->path = strip_tags($parent_file['path']);
        $sql->parent = strip_tags($model->dropList);
        $sql->save();

        //Возвращаю последний ID из Insert в MySQL
        $save_id_f = Yii::$app->db->getLastInsertID();

        $sql_2 = new FileStatus();
        $sql_2->id_file = $save_id_f;
        $sql_2->status = 'Подписан';
        $sql_2->date_status = strip_tags($date);
        $sql_2->save();

        foreach ($mas_em as $item) {

            $full_name = explode('-', strip_tags($item));
//            var_dump($full_name);
            if ($full_name[0] != "") {


                $full_user_email = preg_replace('/\s/', '', $full_name[1]);

                $sql_3 = new FileUser();
                $sql_3->id_file = $save_id_f;
                $sql_3->full_name = $full_name[0];
                $sql_3->email = $full_user_email;
                $sql_3->confirm = '0';
                $sql_3->signature = '';
                $sql_3->date_confirm = $date;
                $sql_3->save();

                $save_id_file_user = Yii::$app->db->getLastInsertID();


                $email = $full_user_email;

                $validator = new EmailValidator();
                if ($validator->validate($email, $error)) {

                    $path_ozn = Url::to(['sendfile/viewud', 'id_file' => $save_id_f, 'id_file_user' => $save_id_file_user], true);
                    $htmlBody = '<p>Уважаемый пользователь, ' . $full_name[0] . '.</p>';
                    $htmlBody .= '<p> Пройдите по ссылке из этого письма для ознакомления с новым документом.</p>';
                    $htmlBody .= "<a href=$path_ozn>Ссылка для ознакомления</a>";
                    $htmlBody .= '<p>' . $model->body_email . '</p>';
                    $htmlBody .= '<p>С Уважением, СамГУПС';
                    Yii::$app->mailer->compose()
                        ->setFrom(Yii::$app->params['senderEmail'])
                        ->setTo([
                            strip_tags($full_user_email)
                        ])
                        ->setSubject('Уведомление о новом документ')
                        ->setHtmlBody($htmlBody)
                        ->send();

                } else {
                    $error;
                }
            }

        }

        return Yii::$app->session->setFlash('success', 'Сообщения отправлены.');
    }
}
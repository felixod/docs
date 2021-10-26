<?php


namespace backend\models;



use app\models\TagFileKeyword;
use app\models\TagKeywords;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\validators\EmailValidator;

class SendFileForm extends Model
{
    public $name;
    public $body;
    public $list_email;
    public $tag_list;
    public $body_email;
    public $dropList;
    public $file;


    public function attributeLabels()
    {
        return [
            'name' => 'Ваша тема',
            'file_list_user' => 'Лист пользователей',
            'tag_list' => 'Ключевые слова',
            'list_email' => 'Список пользователей',
            'body_email' => 'Текст письма',
            'body' => 'Информация об документе',
            'dropList' => '',
            'file' => 'Ваш файл',
        ];
    }

    public function rules()
    {
        return [
            // удалить пробелы для всех  формы
            [['name', 'body_email','body'], 'trim'],
            // поле name обязательно для заполнения
            ['name', 'required', 'message' => 'Поле «Ваше имя» обязательно для заполнения'],
            // поле list_user обязательно для заполнения
            ['list_email', 'required', 'message' => 'Поле «Адреса почт» обязательно для заполнения'],
            // поле body_email обязательно для заполнения
            ['body_email', 'required', 'message' => 'Поле «Текст письма» обязательно для заполнения'],
            // поле body обязательно для заполнения
            ['body', 'required', 'message' => 'Поле «Сообщение» обязательно для заполнения'],
            //поле tag_list обязательно для заполнения
            ['tag_list', 'required', 'message' => 'Поле обязательно для заполнения'],
            //поле dropList обязательно для заполнения
            ['dropList', 'required', 'message' => 'Поле обязательно для заполнения'],
            // поле file обязательно для заполнения
            [['file'], 'file', 'extensions' => ['pdf'], 'skipOnEmpty' => false],
            // поле name должны быть не более 50 символов
            [
                ['name'],
                'string',
                'max' => 50,
                'tooLong' => 'Поле должно быть длиной не более 50 символов'
            ],
            // поле body должно быть не более 1000 символов
            [
                'body', 'string',
                'max' => 1000,
                'tooLong' => 'Описание документа не может превышать 755 символов '
            ],
            // поле body должно быть не более 1000 символов
            [
                'body_email', 'string',
                'max' => 1000,
                'tooLong' => 'Сообщение должно быть длиной не более 1000 символов'
            ],

        ];
    }

    public static function SendFile($model)
    {

        if (Yii::$app->request->isPost) {
            $date = date('Y-m-d H:i:s');
            if ($model->file && $model->validate()) {
                $namefile = strip_tags($model->file->baseName);
                $model->file->name = uniqid() . '.' . $model->file->extension;
                $structure = Yii::getAlias('@webroot') . '/uploads/' . Yii::$app->user->identity->orgstruktur . '/' . Yii::$app->user->identity->id . '/';
                if (!is_dir($structure)) {
                    mkdir($structure, 0750, true);
                }
                $full_path_file = strip_tags($structure . '/' . $model->file);
                $pathf = strip_tags('/uploads/' . Yii::$app->user->identity->orgstruktur . '/' . Yii::$app->user->identity->id . '/' . $model->file);
                $typef = strip_tags($model->file->type);
                $model->file->saveAs($full_path_file);
            }
        }

        $mas_em = array();
        //Разбиваеи список полученных электронных адресов и помещяю в массив
        foreach ($model->list_email as $list_email){
            array_push($mas_em, $list_email);
        }

        //Запрос для первичного добавления файла
        $sql = new File();
        $sql->id_user = Yii::$app->user->id;

        $sql->id_struktur = Yii::$app->user->identity->org_struktur;
        $sql->themes = strip_tags($model->name);
        $sql->name_file = strip_tags($namefile);
        $sql->other_info = strip_tags($model->body);
        $sql->date_file = strip_tags($date);
        $sql->type_file = strip_tags($typef);
        $sql->id_type_file = strip_tags($model->dropList);
        $sql->path = strip_tags($pathf);
        $sql->save();

        //Возвращаю последний ID из Insert в MySQL
        $save_id_f = Yii::$app->db->getLastInsertID();

        $sql_2 = new FileStatus();
        $sql_2->id_file = $save_id_f;
        $sql_2->status = 'Подписан';
        $sql_2->date_status = $date;
        $sql_2->save();


        foreach ($model->tag_list as $tag){
            $sql_4 = new TagFileKeyword();
            $sql_4->tag_file_id = $save_id_f;
            $sql_4->tag_id = $tag;
            $sql_4->save();
        }

        foreach ($mas_em as $item) {

            $full_name = explode('-', strip_tags($item));
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


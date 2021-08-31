<?php


namespace backend\controllers;


use backend\models\File;
use backend\models\FileStatus;
use backend\models\FileUser;
use backend\models\OrgStruktura;
use backend\models\SendFileForm;
use backend\models\ConfirmForm;
use backend\models\SendFileOrgForm;
use DirectoryIterator;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

class SendfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'sendu'],
                'rules' => [
                    [
                        'actions' => ['logout', 'sendu'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            [
                'class' => AccessControl::className(),
                'only' => ['sendu'],
                'rules' => [
                    [
                        'actions' => ['sendu'],
                        'allow' => true,
                        'roles' => ['editor'],
                    ],
                ],

            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @param $id_file
     * @param $id_file_user
     * @return string|\yii\web\Response
     */
    public function actionViewud($id_file, $id_file_user)
    {
        $model = new ConfirmForm();

        //если POST пришёл
        if ($model->load(Yii::$app->request->post())) {

            ConfirmForm::confirmDoc($model, $id_file_user);
            return $this->refresh();
        }

        $res_fu_1 = File::findOne($id_file);
        $res_fu_2 = FileUser::findOne($id_file_user);


        return $this->render('viewud', ['model' => $model, 'id_file' => $res_fu_1, 'id_file_user' => $res_fu_2]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSendu()
    {
        $model = new SendFileForm();
        /*
         * Если пришли post-данные, загружаем их в модель
         */
        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');
            // Проверяем эти данные
            if (!$model->validate()) {
                /*
                 * Данные не прошли валидацию
                 */
                Yii::$app->session->setFlash(
                    'sendu-success',
                    false
                );
                // сохраняем в сессии введенные пользователем данные
                Yii::$app->session->setFlash(
                    'sendu-data',
                    [
                        'name' => $model->name,
                        'email' => $model->email,
                        'body_email' => $model->body_email,
                        'body' => $model->body,

                    ]
                );
                /*
                 * Сохраняем в сессии массив сообщений об ошибках. Массив имеет вид
                 * [
                 *     'name' => [
                 *         'Поле «Ваше имя» обязательно для заполнения',
                 *     ],
                 *     'email' => [
                 *         'Поле «Ваш email» обязательно для заполнения',
                 *         'Поле «Ваш email» должно быть адресом почты'
                 *     ]
                 * ]
                 */
                Yii::$app->session->setFlash(
                    'sendu-errors',
                    $model->getErrors()
                );

            } else {
                /*
                 * Данные прошли валидацию
                 */
                SendFileForm::SendFile($model);


                return $this->refresh();
            }
        }


        return $this->render('sendu', ['model' => $model]);
    }

    /**
     * @return string
     */
    public function actionSenduorg()
    {
        $model = new SendFileOrgForm();
        /*
        * Если пришли post-данные, загружаем их в модель
        */
        if ($model->load(Yii::$app->request->post())) {
            // Проверяем эти данные
            if (!$model->validate()) {
                /*
                 * Данные не прошли валидацию
                 */
                Yii::$app->session->setFlash(
                    'sendu-success',
                    false
                );
                // сохраняем в сессии введенные пользователем данные
                Yii::$app->session->setFlash(
                    'sendu-data',
                    [
                        'name' => $model->name,
                        'email' => $model->email,
                        'body' => $model->body
                    ]
                );
                /*
                 * Сохраняем в сессии массив сообщений об ошибках. Массив имеет вид
                 * [
                 *     'name' => [
                 *         'Поле «Ваше имя» обязательно для заполнения',
                 *     ],
                 *     'email' => [
                 *         'Поле «Ваш email» обязательно для заполнения',
                 *         'Поле «Ваш email» должно быть адресом почты'
                 *     ]
                 * ]
                 */
                Yii::$app->session->setFlash(
                    'sendu-errors',
                    $model->getErrors()
                );
            } else {
                /*
                 * Данные прошли валидацию
                 */
                SendFileOrgForm::SendFileOrg($model);
                return $this->refresh();
            }
        }
        $access_control = File::getFileOrg();
        // Выводим все достпуные варианты прав доступа
        $items = ArrayHelper::map($access_control, 'id_file', 'name_file', 'name_struktura');

        //var_dump($items);
        $params = [
            'prompt' => 'Выберите документ'
        ];
        return $this->render('senduorg', ['model' => $model, 'params' => $params, 'items' => $items]);


    }
}
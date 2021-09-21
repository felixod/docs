<?php


namespace backend\controllers;


use backend\models\File;
use backend\models\FileStatus;
use backend\models\FileType;
use backend\models\FileUser;
use backend\models\OrgStruktura;
use backend\models\SendFileForm;
use backend\models\ConfirmForm;
use backend\models\SendFileOrgForm;
use DirectoryIterator;
use Yii;
use yii\bootstrap4\Progress;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
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


        if ($model->load(Yii::$app->request->post())) {


            $model->file = UploadedFile::getInstance($model, 'file');


            Yii::$app->session->setFlash(
                'sendu-success',
                true
            );

            if (!$model->validate()) {

                Yii::$app->session->setFlash(
                    'sendu-success',
                    false
                );

                Yii::$app->session->setFlash(
                    'sendu-errors',
                    $model->getErrors()
                );

            } else {
                SendFileForm::SendFile($model);

                return $this->refresh();
            }
        }
        $access_control = FileType::find()->all();
        // Выводим все достпуные варианты прав доступа
        $items = ArrayHelper::map($access_control, 'id_type_file', 'name_type_file');

        //var_dump($items);
        $params = [
            'prompt' => 'Выберите вид документа'
        ];
        return $this->render('sendu', ['model' => $model, 'params' => $params, 'items' => $items]);

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
        if (\Yii::$app->request->isAjax) {
            return 'Запрос принят!';
        }
        if ($model->load(Yii::$app->request->post())) {
            // Проверяем эти данные
            if (!$model->validate()) {

                Yii::$app->session->setFlash(
                    'sendu-success',
                    false
                );

                Yii::$app->session->setFlash(
                    'sendu-data',
                    [
                        'email' => $model->email,
                        'body' => $model->body
                    ]
                );
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
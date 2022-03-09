<?php


namespace backend\controllers;


use app\models\TagKeywords;
use backend\models\File;
use backend\models\FileType;
use backend\models\FileUser;
use backend\models\SendFileForm;
use backend\models\ConfirmForm;
use backend\models\TagkeyForm;
use backend\models\UploadForm;
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
    public function actionViewud()
    {   
        
        $model = new ConfirmForm();
        $id_file = Yii::$app->request->get('info_f');
        $id_file_user = Yii::$app->request->get('u_f');
        
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
        $data = [];
        $session = Yii::$app->session;

        if (!empty($session->get('import_list'))) {
            $data = $session->get('import_list');
            $session->destroy();
        }

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
        $find_tag = TagKeywords::find()->all();
        // Выводим все достпуные варианты прав доступа
        $items = ArrayHelper::map($access_control, 'id_type_file', 'name_type_file');
        $find_tag_items = ArrayHelper::map($find_tag, 'id_tag', 'tagname');
        $full_select = ArrayHelper::map($data, 'full_list', 'full_list');
        $params = [
            'prompt' => 'Выберите вид документа'
        ];


        return $this->render('sendu', ['model' => $model, 'tag_name' => $find_tag_items, 'items' => $items, 'email_list' => $full_select, 'data' => $data]);

    }


    /**
     * @return string
     */
    public function actionTagkey()
    {
        $model = new TagkeyForm();

        if ($model->load(Yii::$app->request->post())) {
            TagKeywords::addTagname($model);
        }

        return $this->renderAjax('tagkey', ['model' => $model]);
    }

    /**
     * @return string
     */
    public function actionImportlist()
    {
        $model = new UploadForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->file_user = UploadedFile::getInstance($model, 'file_user');
            UploadForm::impotrSave($model);
            return $this->redirect('sendu');
        }

        return $this->renderAjax('importlist', ['model' => $model]);
    }

}
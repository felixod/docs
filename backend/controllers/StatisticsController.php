<?php

namespace backend\controllers;

use app\models\GenerReports;
use backend\models\File;
use PhpOffice\PhpWord\TemplateProcessor;
use Yii;
use backend\models\FileUser;
use backend\models\FileUserSearch;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\validators\EmailValidator;

/**
 * StatisticsController implements the CRUD actions for FileUser model.
 */
class StatisticsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index', 'general', 'lkreport'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'general', 'lkreport'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index', 'general', 'lkreport'],
                        'allow' => true,
                        'roles' => ['editor'],
                    ],
                ],

            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all FileUser models.
     * @return mixed
     */
    public function actionIndex($id_file)
    {

        $searchModel = new FileUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id_file);

        //  todo вернуться и добавить документы имеющие родственников
        $query_2 = File::find('id_file')->where(['parent' => $id_file])->all();
        $institut = [];
        $k=0;
        if (!empty($query_2)) {

            foreach ($query_2 as $key) {

                $institut[$k] = [
                    'id_file' => $key['id_file'],
                ];
                $k++;
            }
        }

        $dataProvider_2 = $searchModel->search_2(Yii::$app->request->queryParams, $institut);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProvider_2' => $dataProvider_2,
        ]);
    }

    /**
     * @return string
     */
    public function actionLkreport()
    {
        $pathUser = '../web/reportPHPExcel/' . Yii::$app->user->id . '/';
        $dir = $pathUser;
        $id_user = Yii::$app->user->id;

        if (is_dir($dir)) {

            $count_files = GenerReports::find()->where(['id_user' => $id_user])->count();
            $pages = new Pagination(['totalCount' => $count_files, 'pageSize' => 3]);

            $pages->pageSizeParam = false;
            $info_file = GenerReports::allReports($id_user, $pages);


            return $this->render('lkreport', ['pages' => $pages, 'test' => $info_file, 'success' => 'success']);
        } else {

            Yii::$app->session->setFlash('error', 'Нет сформированных отчетов');
            return $this->render('lkreport', ['success' => 'error']);
        }
    }

    public function actionReportword($id_file)
    {
        return $this->render('reportword', ['str_file' => GenerReports::generateReportWord($id_file)]);
    }


    public function actionGeneral()
    {
        $id_user = Yii::$app->user->id;

        $countQuery = File::find()->where(['id_user' => $id_user])->count();
        $pages = new Pagination(['totalCount' => $countQuery, 'pageSize' => 7]);

        $themes = File::getFileInfo($pages, $id_user);

        return $this->render('general', [
            'model' => $themes,
            'pages' => $pages,
        ]);

    }

    /**
     * Displays a single FileUser model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FileUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FileUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_file_user]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FileUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_file_user,]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FileUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FileUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FileUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Запрошенная страница не существует.');
    }
}

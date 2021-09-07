<?php

namespace app\models;

use backend\models\File;
use backend\models\FileUser;
use common\models\User;
use PHPExcel_IOFactory;
use PHPExcel_Writer_Excel2007;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\TemplateProcessor;
use Yii;
use yii\data\Pagination;

/**
 * This is the model class for table "gener_reports".
 *
 * @property int $id_report
 * @property int $id_user
 * @property int $id_file
 * @property string $name_report
 * @property string $date_gener
 * @property string $caption
 *
 * @property File $file
 * @property User $user
 */
class GenerReports extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gener_reports';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_file', 'name_report', 'date_gener', 'caption'], 'required'],
            [['id_user', 'id_file'], 'integer'],
            [['date_gener'], 'safe'],
            [['name_report'], 'string', 'max' => 500],
            [['caption'], 'string', 'max' => 16],
            [['id_file'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['id_file' => 'id_file']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_report' => 'Id Report',
            'id_user' => 'Id User',
            'id_file' => 'Id File',
            'name_report' => 'Name Report',
            'date_gener' => 'Date Gener',
            'caption' => 'Caption',
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id_file' => 'id_file']);
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
     * @param $dir
     */
    public static function clear_dir($dir)
    {
        $list = GenerReports::myscandir($dir);

        foreach ($list as $file) {
            if (is_dir($dir . $file)) {
                GenerReports::clear_dir($dir . $file . '/');
                rmdir($dir . $file);
            } else {
                unlink($dir . $file);
            }
        }
    }

    /**
     * @param $dir
     * @return array
     */
    public static function myscandir($dir)
    {
        $list = scandir($dir);
        unset($list[0], $list[1]);
        return array_values($list);
    }


    /**
     * @param $length
     * @return string
     */
    public static function generateHash($length)
    {
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    public static function allReports($id_user, $pagination)
    {
        $model = Yii::$app->db->createCommand('
                    SELECT
                        gener_reports.id_report,
                        file.id_file as id_file,
                        file.id_user,
                        file.other_info,
                        file.themes,
                        gener_reports.date_gener,
                        gener_reports.name_report,
                        user.full_name
                    FROM
                        gener_reports
                    JOIN
                        file
                    ON
                        file.id_file = gener_reports.id_file
                    JOIN
                        user
                    ON 
                        gener_reports.id_user = user.id
                    WHERE
                        gener_reports.id_user =' . $id_user . '

                    LIMIT ' . $pagination->limit
            . '
                    OFFSET ' . $pagination->offset)->queryAll();

        Yii::$app->session->setFlash('success_report', "Отчет сформирован");
        return $model;
    }

    public static function generateReportWord($id_file)
    {


        $id_user = Yii::$app->user->id;
        $structure = '../web/reportPHPExcel/' . $id_user . '/' . $id_file . '/';
        $date = date('Y-m-d H:i:s');
        $unixDate = strtotime($date);

        $report_name = 'report_' . date('Y-m-d') . '_' . Yii::$app->user->identity->full_name . '.xlsx';
        $full_path = $structure . $report_name;
        $full_name_report = 'report_' . date('Y-m-d') . '_' . Yii::$app->user->identity->full_name . '.xlsx';
        $structure_path = '../reportPHPExcel/' . $id_user . '/' . $id_file . '/' . $report_name;

        if (!is_dir($structure)) {
            mkdir($structure, 0777, true);
        }

        GenerReports::clear_dir($structure);


//        $xls = new \PHPExcel();
//
//        $id_user = Yii::$app->user->id;
//        $structure = '../web/reportPHPExcel/' . $id_user . '/' . $id_file . '/';
//        $date = date('Y-m-d H:i:s');
//        $unixDate = strtotime($date);
//
//        $report_name = 'report_' . date('Y-m-d') . '_' . Yii::$app->user->identity->full_name . '.xlsx';
//        $full_path = $structure . $report_name;
//        $full_name_report = 'report_' . date('Y-m-d') . '_' . Yii::$app->user->identity->full_name . '.xlsx';
//        $structure_path = '../reportPHPExcel/' . $id_user . '/' . $id_file . '/' . $report_name;
//
//        if (!is_dir($structure)) {
//            mkdir($structure, 0777, true);
//        }
//
//        GenerReports::clear_dir($structure);
//
//
//        $aSheet = $xls->getActiveSheet();
//
//        $aSheet->mergeCells('A1:E1');
//        $aSheet->getRowDimension('1')->setRowHeight(20);
//        $aSheet->setCellValue('A1', 'ОТЧЕТ');
//
//        //Ширина столбцов
//        $aSheet->getColumnDimension('A')->setWidth(50);
//        $aSheet->getColumnDimension('B')->setWidth(13);
//        $aSheet->getColumnDimension('C')->setWidth(40);
//        $aSheet->getColumnDimension('D')->setWidth(20);
//
//
//        //Наименование столбцов
//        $aSheet->setCellValue('A2', 'ФИО');
//        $aSheet->setCellValue('B2', 'Ознакомился');
//        $aSheet->setCellValue('C2', 'Цифровой идентификатор ознакомления');
//        $aSheet->setCellValue('D2', 'Дата ознакомления');
//
//
//        $gttest = FileUser::find()->where(['id_file' => $id_file])->all();
//        $i = 2;
//        foreach ($gttest as $item) {
//            $aSheet->setCellValue('A' . ($i + 1), $item['full_name']);
//            if ($item['confirm'] == '1') {
//                $aSheet->setCellValue('B' . ($i + 1), 'Да');
//            } else {
//                $aSheet->setCellValue('B' . ($i + 1), 'Нет');
//            }
//            $aSheet->setCellValue('C' . ($i + 1), $item['signature']);
//            if (!empty($item['signature'])) {
//                $aSheet->setCellValue('D' . ($i + 1), $item['date_confirm']);
//            }
//            $i++;
//        }
//
//        $objWriter = new PHPExcel_Writer_Excel2007($xls);
//        $objWriter->save($full_path);

        $find = GenerReports::find()->where(['id_file' => $id_file])->one();

        if ($find == null) {

            $report = new GenerReports();
            $report->id_user = $id_user;
            $report->id_file = $id_file;
            $report->name_report = $full_name_report;
            $report->date_gener = $date;
            $report->caption = GenerReports::generateHash(16);
            $report->save();

            $model = Yii::$app->db->createCommand('
                    SELECT
                        gener_reports.id_report,
                        file.id_file as id_file,
                        file.id_user,
                        file.other_info,
                        file.themes,
                        gener_reports.date_gener,
                        gener_reports.name_report
                    FROM
                        gener_reports
                    JOIN
                        file
                    ON
                        file.id_file = gener_reports.id_file
                    WHERE
                        gener_reports.id_report =' . Yii::$app->db->getLastInsertID())->queryOne();

            $xls = PHPExcel_IOFactory::load('../web/reportPHPExcel/template_xlsx.xlsx');
            $aSheet = $xls->getActiveSheet();

            //Ширина столбцов
            $aSheet->getColumnDimension('A')->setWidth(50);
            $aSheet->getColumnDimension('B')->setWidth(13);
            $aSheet->getColumnDimension('C')->setWidth(40);
            $aSheet->getColumnDimension('D')->setWidth(20);


            $aSheet->setCellValue('A1', ' 
                        ОТЧЕТ
                         
                        Отчет ознакомления с документом «'.$model['themes'].'».
                        Дата размещения документа в системе (https://docs.samgups.ru): '.$model['date_gener'].' г.
                        Дата завершения ознакомления: '.$model['date_gener'].' г.
                        Отчет сгенерировал: '.$model['full_name']);

            //Наименование столбцов
            $aSheet->setCellValue('A2', 'ФИО');
            $aSheet->setCellValue('B2', 'Ознакомился');
            $aSheet->setCellValue('C2', 'Цифровой идентификатор ознакомления');
            $aSheet->setCellValue('D2', 'Дата ознакомления');


            $gttest = FileUser::find()->where(['id_file' => $id_file])->all();
            $i = 2;
            foreach ($gttest as $item) {
                $aSheet->setCellValue('A' . ($i + 1), $item['full_name']);
                if ($item['confirm'] == '1') {
                    $aSheet->setCellValue('B' . ($i + 1), 'Да');
                } else {
                    $aSheet->setCellValue('B' . ($i + 1), 'Нет');
                }
                $aSheet->setCellValue('C' . ($i + 1), $item['signature']);
                if (!empty($item['signature'])) {
                    $aSheet->setCellValue('D' . ($i + 1), $item['date_confirm']);
                }
                $i++;
            }

            $objWriter = new PHPExcel_Writer_Excel2007($xls);
            $objWriter->save($full_path);

            Yii::$app->session->setFlash('success_report', "Отчет сформирован");
            return [$model, $structure_path];

        } elseif ($find != null) {

            $report_upd = $find;
            $report_upd->date_gener = $date;
            $report_upd->name_report = $full_name_report;
            $report_upd->caption = GenerReports::generateHash(16);
            $report_upd->save();

            $model = Yii::$app->db->createCommand('
                    SELECT
                        gener_reports.id_report,
                        file.id_file as id_file,
                        file.id_user,
                        file.other_info,
                        file.themes,
                        user.full_name,
                        DATE_FORMAT( gener_reports.date_gener , "%d.%m.%y" )  AS date_gener ,
                        gener_reports.name_report
                    FROM
                        gener_reports
                    JOIN
                        file
                    ON
                        file.id_file = gener_reports.id_file
                    JOIN 
                        user
                    ON
                        gener_reports.id_user = user.id
                    WHERE
                        gener_reports.id_file =' . $id_file)->queryOne();


            $xls = PHPExcel_IOFactory::load('../web/reportPHPExcel/template_xlsx.xlsx');
            $aSheet = $xls->getActiveSheet();

            //Ширина столбцов
            $aSheet->getColumnDimension('A')->setWidth(50);
            $aSheet->getColumnDimension('B')->setWidth(13);
            $aSheet->getColumnDimension('C')->setWidth(40);
            $aSheet->getColumnDimension('D')->setWidth(20);


            $aSheet->setCellValue('A1', ' 
                        ОТЧЕТ
                         
                        Отчет ознакомления с документом «'.$model['themes'].'».
                        Дата размещения документа в системе (https://docs.samgups.ru): '.$model['date_gener'].' г.
                        Дата завершения ознакомления: '.$model['date_gener'].' г.
                        Отчет сгенерировал: '.$model['full_name']);

            //Наименование столбцов
            $aSheet->setCellValue('A2', 'ФИО');
            $aSheet->setCellValue('B2', 'Ознакомился');
            $aSheet->setCellValue('C2', 'Цифровой идентификатор ознакомления');
            $aSheet->setCellValue('D2', 'Дата ознакомления');


            $gttest = FileUser::find()->where(['id_file' => $id_file])->all();
            $i = 2;
            foreach ($gttest as $item) {
                $aSheet->setCellValue('A' . ($i + 1), $item['full_name']);
                if ($item['confirm'] == '1') {
                    $aSheet->setCellValue('B' . ($i + 1), 'Да');
                } else {
                    $aSheet->setCellValue('B' . ($i + 1), 'Нет');
                }
                $aSheet->setCellValue('C' . ($i + 1), $item['signature']);
                if (!empty($item['signature'])) {
                    $aSheet->setCellValue('D' . ($i + 1), $item['date_confirm']);
                }
                $i++;
            }

            $objWriter = new PHPExcel_Writer_Excel2007($xls);
            $objWriter->save($full_path);

            Yii::$app->session->setFlash('success_report', "Отчет сформирован");

            return [$model, $structure_path];

        }
        return $find;
    }

}

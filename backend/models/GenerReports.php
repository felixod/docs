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
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }


    /**
     * @param $id_file
     * @return array|\yii\db\ActiveRecord|null
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     * @throws \yii\db\Exception
     */
    public static function generateReportExcel($id_file)
    {
        $id_user = Yii::$app->user->id;
        $structure = '../../tmp/';
        $date = date('Y-m-d');

        $report_name = 'report_' . date('Y-m-d') . '_' . Yii::$app->user->identity->full_name . '.xlsx';
        $full_path = $structure . $report_name;


        $model = Yii::$app->db->createCommand('
                    SELECT
                        file.id_file as id_file,
                        file.id_user,
                        file.other_info,
                        file.themes,
                        user.full_name
                    FROM
                        file
                    JOIN 
                        user
                    WHERE
                        file.id_user = user.id')->queryOne();


        $xls = PHPExcel_IOFactory::load('../web/reportPHPExcel/template_xlsx.xlsx');
        $aSheet = $xls->getActiveSheet();

        //Ширина столбцов
        $aSheet->getColumnDimension('A')->setWidth(50);
        $aSheet->getColumnDimension('B')->setWidth(13);
        $aSheet->getColumnDimension('C')->setWidth(40);
        $aSheet->getColumnDimension('D')->setWidth(20);


        $aSheet->setCellValue('A1', '
                        ОТЧЕТ

                        Отчет ознакомления с документом «' . $model['themes'] . '».
                        Дата размещения документа в системе (https://docs.samgups.ru): ' . $date . ' г.
                        Дата завершения ознакомления: ' . $date . ' г.
                        Отчет сгенерировал: ' . $model['full_name']);

        //Наименование столбцов
        $aSheet->setCellValue('A2', 'ФИО');
        $aSheet->setCellValue('B2', 'Ознакомился');
        $aSheet->setCellValue('C2', 'Цифровой идентификатор ознакомления');
        $aSheet->setCellValue('D2', 'Дата ознакомления');


        $item_fileuser = FileUser::find()->where(['id_file' => $id_file])->all();
        $i = 2;
        foreach ($item_fileuser as $item) {
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
        Yii::$app->response->sendFile($full_path);
        unlink($full_path);
//        Yii::$app->session->setFlash('success', 'Отчет сформирован');
//        return Yii::$app->session->setFlash('success', 'Отчет сформирован');
    }

}

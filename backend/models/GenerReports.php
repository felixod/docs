<?php

namespace app\models;

use backend\models\File;
use backend\models\FileUser;
use common\models\User;
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

        foreach ($list as $file)
        {
            if (is_dir($dir.$file))
            {
                GenerReports::clear_dir($dir.$file.'/');
                rmdir($dir.$file);
            }
            else
            {
                unlink($dir.$file);
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
        unset($list[0],$list[1]);
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
                        gener_reports.id_user =' . $id_user.'

                    LIMIT '.$pagination->limit
                    .'
                    OFFSET '.$pagination->offset)->queryAll();

        Yii::$app->session->setFlash('success_report', "Отчет сформирован");
        return $model;
    }

    public static function generateReportWord($id_file)
    {
        $id_user = Yii::$app->user->id;
        $structure = '../web/reportPHPWord/' . $id_user . '/' . $id_file . '/';
        $date = date('Y-m-d H:i:s');
        $unixDate = strtotime($date);


        $report_name = 'report_' . date('Y-m-d') . '_' . Yii::$app->user->identity->full_name . '.docx';
        $full_path = $structure . $report_name;
        $full_name_report = 'report_' . date('Y-m-d') . '_' . Yii::$app->user->identity->full_name . '.docx';
        $structure_path = '../reportPHPWord/' . $id_user . '/' . $id_file . '/'.$report_name;

        if (!is_dir($structure)) {
            mkdir($structure, 0777, true);
        }

        $PHPWord = new PhpWord();
        $styleTable = array('borderSize' => 6, 'borderColor' => '006699', 'cellMargin' => 80);
        $templateProcessor = $PHPWord->loadTemplate('../web/reportPHPWord/shablon_otch_word.docx');

        GenerReports::clear_dir($structure);

        $templateProcessor->setValue('year', date('Y'));
        $templateProcessor->setValue('mes', date('m'));
        $templateProcessor->setValue('day', date('d'));
        $templateProcessor->setValue('num_doc', $id_file);
        $templateProcessor->setValue('fio_name', Yii::$app->user->identity->full_name);
        $templateProcessor->setValue('time', date('H:i:s'));
        $templateProcessor->setValue('fio_username', 'Иванов Иван Иванович');
        $templateProcessor->setValue('ecp', GenerReports::generateHash(16));


        $section = $PHPWord ->addSection();
        $header = array('size' => 16, 'bold' => true );
        $styleCell =
            [
                'borderColor' =>'#000000',
                'borderSize' => 6,
            ];

        $rows = 3;
        $cols = 5;
        $section->addText('Basic table');

        $table = $section->addTable();
        $table->addRow(900);
        // Add cells
        $table->addCell(2000, $styleCell)->addText('ФИО');
        $table->addCell(2000, $styleCell)->addText('Почта');
        $table->addCell(2000, $styleCell)->addText('Ознакомился');
//        $table->addCell(2000, $styleCell)->addText('Подпись');
        $table->addCell(2000, $styleCell)->addText('Дата');

        $gttest = FileUser::find()->where(['id_file' => $id_file])->all();
        //$gttest = Yii::$app->db->createCommand('SELECT * FROM file_user WHERE id_file='.$id_file)->queryAll();

        $count = 4;

            for ($r = 1; $r <= 1; $r++) {
                foreach($gttest as $item){
                $table->addRow();
                    $table->addCell(2000, $styleCell)->addText("{$item['full_name']}");
                    $table->addCell(2000, $styleCell)->addText("{$item['email']}");
                    if($item['confirm'] == 0){
                        $table->addCell(200, $styleCell)->addText("Нет");
                    }elseif ($item['confirm'] == 1){
                        $table->addCell(200, $styleCell)->addText("Да");
                    }
//                    $table->addCell(2000)->addText("{$item['signature']}");
                    $table->addCell(2500, $styleCell)->addText("{$item['date_confirm']}");
                }
        }

        $objWriter = IOFactory::createWriter($PHPWord, 'Word2007');
        $fullxml = $objWriter->getWriterPart('Document')->write();
        $tablexml = preg_replace('/^[\s\S]*(<w:tbl\b.*<\/w:tbl>).*/', '$1', $fullxml);
        $templateProcessor->setValue('myTable', $tablexml);
        $templateProcessor->saveAs($full_path);



        $find = GenerReports::find()->where(['id_file' => $id_file])->one();

        if($find == null) {

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
                        gener_reports.date_gener,
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

            Yii::$app->session->setFlash('success_report', "Отчет сформирован");

            return [$model, $structure_path];

        }
        return $find;
    }

}

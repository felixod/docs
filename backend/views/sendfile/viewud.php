<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Страница ознакомления';


?>
<p></p>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<?php if ($id_file_user['confirm'] == 0 ){ ?>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <?= $form->field($model, 'readdoc')->checkbox([])->label('Ознакомился')?>
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    </div>

            </div>
        </nav>
<?php } elseif ($id_file_user['confirm'] == 1){?>
    <!--Отображаем по желанию -->
<?php }?>
        <main role="main" class="col-md-30 ml-sm-auto col-lg-10 px-54"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Документ</h1>

            </div>
            <iframe src="<?= '/backend/web/'.$id_file['path']?>" name="mainframe" height="800px" width="80%"></iframe>
        </main>
    </div>
</div>

<?php ActiveForm::end(); ?>
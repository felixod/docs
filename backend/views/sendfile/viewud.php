<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = 'Страница ознакомления';


?>
<p></p>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<?php if ($id_file_user['confirm'] == 0) { ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Подтверждение ознакомления</span>
                </h4>
                <ul class="list-group mb-3">
                    <?= $form->field($model, 'readdoc')->checkbox([])->label('Ознакомился') ?>
                </ul>

                <form class="card p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Согласие" disabled="disabled">
                        <div class="input-group-append">
                            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-8 order-md-1">
                <h4 class="mb-3">Документ</h4>
                <iframe src="<?= '/backend/web/' . $id_file['path'] ?>" name="mainframe" height="800px"
                        width="100%"></iframe>
            </div>
        </div>
    </div>
<?php } elseif ($id_file_user['confirm'] == 1) { ?>
        <div class="container">
            <h4 class="mb-3">Документ</h4>
            <iframe src="<?= '/backend/web/' . $id_file['path'] ?>" name="mainframe" height="800px" width="100%"></iframe>
        </div>
<?php } ?>



<?php ActiveForm::end(); ?>
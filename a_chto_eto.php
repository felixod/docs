<?php
require_once 'common/config/main-local.php';


var_dump(yii::$app->db);
$tiho = Yii::$app->db->createCommand('SELECT 
	file_user.id_file_user, 
    file_user.id_file, file_user.full_name, 
    file_user.email, 
    file_user.confirm, file_user.signature,
    file_user.date_confirm, file.date_file
FROM 
	file_user, 
    file
WHERE
	file_user.id_file = file.id_file')->queryAll();

foreach ($tiho as $item)
{
    var_dump($item);
}


<?php

require_once('config.php'); 
require_once(VJ_CORE); 

function add_task_error_handler($msg)
{
     die($msg); 
}

foreach ($_POST as $i)
{
     if ($i == '') 
     {
          die('Info not complete'); 
     }
}

// if($_FILES['file']["error"] > 0)
// {
//   die('File upload error occurred'); 
// }

if (file_exists(VJ_TASKDIR . $_POST['code']))
{
     // die('Task with the same code already exists' ); 
}
else mkdir(VJ_TASKDIR . $_POST['code']);

$arr = array('desc', 'input', 'output', 'sinput', 'soutput', 'limit');

foreach ($arr as $str)
{
     if (!isset($_POST[$str])) die('Info not complete');
     vj_util_write_file(VJ_TASKDIR . $_POST['code'] . '/' . $str . '.txt', $_POST[$str], 'add_task_error_handler'); 
     unset($_POST[$str]); 
}

unset($_POST['submit']);
$code = $_POST['code']; 
unset($_POST['code']); 

vj_util_write_file(VJ_TASKDIR . $code . '/.conf', vj_write_task_conf_file($_POST, 'data/', 'add_task_error_handler'), 'add_task_error_handler'); 

mkdir(VJ_TASKDIR . $code . '/data'); 

move_uploaded_file($_FILES['file']['tmp_name'], './' . VJ_TASKDIR . $code . '/data/data.zip'); 

system("ls"); 

system("unzip " . VJ_TASKDIR . $code . '/data/data.zip -d ' . VJ_TASKDIR . $code . '/'); 

vj_add_pending_task($code);

vj_util_navigate('index.php', 'add_task_error_handler'); 

?>
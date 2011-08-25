<?php

require_once('config.php'); 
require_once(VJ_CORE);

if ($_GET['tid'] == '') $tid = 1; 
else $tid = $_GET['tid']; 
$task = vj_get_task_detail_by_tid($tid); 

$TITLE = 'Task Detail';
$CONTENT = 'temp_show_task.php';
include('layout.php');

?>
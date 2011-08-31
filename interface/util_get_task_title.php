<?php 

require_once('config.php'); 
require_once(VJ_CORE); 

function util_get_task_title_error_handler($msg)
{
}

if (!isset($_GET['tid'])) return; 

$tid = $_GET['tid']; 

$task = vj_get_task_detail_by_tid($tid, 'util_get_task_title_error_handler', true); 

echo $task['title']; 

?>
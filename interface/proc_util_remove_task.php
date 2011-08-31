<?php

require_once('config.php'); 
require_once(VJ_CORE); 

include('admin_validate.php'); 

if (!isset($_GET['tid']))
{
     vj_error('No tid specified. '); 
     return; 
}

$tid = $_GET['tid']; 

vj_remove_task_by_tid($tid); 

vj_util_navigate('admin.php'); 

?>
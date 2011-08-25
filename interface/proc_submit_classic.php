<?php

require_once('config.php'); 
require_once(VJ_CORE); 

$tid = $_POST['tid']; 
$code = $_POST['code']; 
$type = $_POST['codetype'];

function submit_classic_error_handler($msg)
{
     vj_error_navigate('submit_classic.php', $msg); 
}

if (!is_numeric($tid))
{
     submit_classic_error_handler('TID not numeric. '); 
     return; 
}

if (!vj_valid_tid($tid))
{
     submit_classic_error_handler('TID not valid. '); 
     return; 
}

vj_submit_classic($code, $tid, $type, 'submit_classic_error_handler'); 

vj_util_navigate('status.php'); 

?>
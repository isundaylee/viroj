<?php 

require_once('config.php'); 
require_once(VJ_CORE);

if (!(isset($_GET['from']) && isset($_GET['to']) && $_GET['from'] <= $_GET['to']))
{
     die('Invalid parameters. '); 
}

$lb = $_GET['from'];
$ub = $_GET['to'];

for ($i=$lb; $i<=$ub; $i++)
{
     $req = VJ_REQUESTS_DIR . $i . '.req'; 
     $rep = VJ_REPORTS_DIR . $i . '.rep'; 
     $res = VJ_RESULTS_DIR . $i . '.res'; 
     
     unlink($req); 
     unlink($rep); 
     unlink($res);

     $submit = vj_get_submit_detail_by_sid($i); 
     $task = vj_get_task_detail_by_tid($submit['tid']); 

     vj_write_request_file($task['name'], $submit['sid'], $submit['type']); 
}

?>
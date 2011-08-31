<?php

require_once('config.php'); 
require_once(VJ_CORE); 

include('admin_validate.php'); 

if (!isset($_GET['ptid'])) 
{
     vj_error('No ptid specified. '); 
     return; 
}

vj_decline_pending_task($_GET['ptid']); 

vj_util_navigate('util_view_pending_tasks.php'); 

?>
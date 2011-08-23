<?php

require_once('config.php'); 
require_once(VJ_CORE); 

$ERRMSG = $_GET['errmsg'];
$TITLE = 'Fatal Error'; 
$CONTENT = 'temp_error.php'; 
include('layout.php');  

?>
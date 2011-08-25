<?php

require_once('config.php'); 
require_once(VJ_CORE);

if (vj_is_logged_in())
{
     vj_error("You've already logged in. "); 
}

$TITLE = 'Login'; 
$CONTENT = 'temp_login.php';
include('layout.php'); 

?>
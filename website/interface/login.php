<?php

require('../core/core_func.php'); 

if (vj_is_logged_in())
{
     vj_error("You've already logged in. "); 
}

$TITLE = 'Login'; 
$CONTENT = 'temp_login.php';
include('layout.php'); 

?>
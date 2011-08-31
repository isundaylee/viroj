<?php

require_once('config.php'); 
require_once(VJ_CORE); 

if ((!isset($_COOKIE['vj_admin'])) || ($_COOKIE['vj_admin'] != 1))
{
     vj_error('Not admin. '); 
     return; 
}

?>
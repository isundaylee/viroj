<?php

require_once('config.php'); 
require_once(VJ_CORE);

if (!vj_is_admin())
{
     vj_error('Not admin. '); 
     return; 
}

?>
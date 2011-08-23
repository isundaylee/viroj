<?php

require_once('config.php');
require_once(VJ_CORE); 

function problems_error_handler($errmsg)
{
     vj_error_navigate('problems.php', $errmsg); 
}

$num = vj_get_tasks_num();

if ($_GET['page'] == 0) $page = 1; 
else $page = $_GET['page']; 

$tot_pages = floor(($num - 1) / VJ_TASKS_PER_PAGE) + 1; 

if ($page > $tot_pages)
{
     problems_error_handler("Page number out of range. "); 
}

$lb = VJ_TASKS_PER_PAGE * ($page - 1) + 1;
$ub = VJ_TASKS_PER_PAGE * $page; 

$tasks = vj_get_tasks($lb, $ub);

$TITLE = 'Problems';
$CONTENT = 'temp_problems.php';
include('layout.php');

?>
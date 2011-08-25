<?php

define('VJ_PAGE_WIDTH', '800px'); 
define('VJ_SUBFRAME_WIDTH', '600px'); 
define('VJ_SUBFRAME_HALF_WIDTH', '300px'); 
define('VJ_CORE', '../core/core_func.php'); 
define('VJ_CONTENT_STYLE', 'font-family: Georgia, sans-serif; font-size: 15px; ');
define('VJ_SUBTITLE_STYLE', 'font-family: Georgia, sans-serif; font-size: 30px; text-align: center; '); 
define('VJ_SECTIONTITLE_STYLE', 'font-family: Georgia, sans-serif; font-size: 20px; text-align: center; '); 
define('VJ_TASKS_PER_PAGE', 10);  
define('VJ_PAGES_BEFORE', 4); 
define('VJ_PAGES_AFTER', 5); 
define('VJ_SPACES_BETWEEN_PAGE_NUMBERS', 3); 
// define('VJ_TASKDIR', '../taskdir/'); 
// define('VJ_SOURCEDIR', '../source/'); 
define('VJ_STATUS_PER_PAGE', 10); 
define('VJ_STATUS_PAGES_BEFORE', 4); 
define('VJ_STATUS_PAGES_AFTER', 5); 
define('VJ_STATUS_SPACES_BETWEEN_PAGE_NUMBERS', 3); 
define('VJ_STATUS_COLOR_PENDING', '#FFD306'); 

mb_internal_encoding("UTF-8");

function get_full_description($desc)
{
     switch ($desc)
     {
     case 'CTLE': return 'Compile Time Limit Exceeded'; 
     case 'SLLE': return 'Source Length Limit Exceeded'; 
     case 'OLE': return 'Output Limit Exceeded'; 
     case 'PE': return 'Presentation Error'; 
     case 'CE': return 'Compile Error'; 
     case 'AC': return 'Accepted'; 
     case 'WA': return 'Wrong Answer'; 
     case 'TLE': return 'Time Limit Exceeded'; 
     case 'RE': return 'Runtime Error';
     case 'MLE': return 'Memory Limit Exceeded'; 
     }
}

function get_display_color($desc)
{
     switch ($desc)
     {
     case 'AC': return '#00FF00'; 
     case 'CE': return 'blue';
     }
     return 'red'; 
}

?>
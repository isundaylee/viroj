<?php

require_once('config.php'); 

$navi_num = 6; 

$navi_title[1] = "Home"; 
$navi_title[2] = "Problems"; 
$navi_title[3] = "Status"; 
$navi_title[4] = "Submit";
$navi_title[5] = "Logout"; 
$navi_title[6] = "Register"; 

$navi_url[1] = "index.php"; 
$navi_url[2] = "problems.php"; 
$navi_url[3] = "status.php";
$navi_url[4] = "submit_classic.php"; 
$navi_url[5] = "logout.php";
$navi_url[6] = "register.php"; 

if (!vj_is_logged_in())
{
     $navi_title[5] = "Login"; 
     $navi_url[5] = "login.php"; 
}

$width = VJ_PAGE_WIDTH / $navi_num; 

for ($i=1; $i<=$navi_num; $i++)
{
     echo '<div style="text-align: center; float: left; width: ' . $width . 'px ">'; 
     echo '<span class="navibar">'; 
     echo '<a href="' . $navi_url[$i] . '">'; 
     echo $navi_title[$i]; 
     echo '</a>'; 
     echo '</span>'; 
     echo '</div>';
}

echo '<br />'; 

?>

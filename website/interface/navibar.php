<?php

require('consts.php'); 

$navi_num = 4; 

$navi_title[1] = "Problems"; 
$navi_title[2] = "Status"; 
$navi_title[3] = "Profile";
$navi_title[4] = "Logout"; 

$navi_url[1] = "problems.php"; 
$navi_url[2] = "status.php";
$navi_url[3] = "profile.php"; 
$navi_url[4] = "logout.php"; 

$width = $PAGE_WIDTH / $navi_num; 

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

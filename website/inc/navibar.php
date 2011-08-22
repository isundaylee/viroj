<?php
$navinum = 3; 
$navititle[1] = "Problems"; 
$navititle[2] = "Status"; 
$navititle[3] = "Logout";
$naviurl[1] = "problems.php"; 
$naviurl[2] = "status.php"; 
$naviurl[3] = "logout.php";

echo '<table id="navitable" width="800"><tr>'; 

for ($i=1; $i<=$navinum; $i++)
{
     echo '<td align="center"><div id="navibar"><a href="' . $naviurl[$i] . '">' . $navititle[$i] . '</a></span></td>'; 
}

echo '</tr></table>'; 

?>
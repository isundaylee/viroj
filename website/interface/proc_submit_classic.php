<?php

$fp = fopen("test.cpp", "w"); 

if (!$fp)
{
     echo 'Wrong!'; 
}

fwrite($fp, $_POST['code']); 

?>
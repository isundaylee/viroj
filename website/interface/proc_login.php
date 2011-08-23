<?php

require('../core/core_func.php'); 

$username = $_POST['username']; 
$password = $_POST['password'];

if (!vj_valid_username($username))
{
     vj_error('Username not valid. ');
}

if (!vj_valid_password($password))
{
     vj_error('Password not valid. ');
}

vj_login($username, $password);

vj_util_navigate('index.php'); 

?>
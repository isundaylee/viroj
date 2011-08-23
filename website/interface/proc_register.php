<?php

require_once('config.php'); 
require_once(VJ_CORE); 

$username = $_POST['username']; 
$password = $_POST['password'];

function register_error_handler($msg)
{
     vj_error_navigate('register.php', $msg); 
}

if (!vj_valid_username($username))
{
     register_error_handler('Username not valid. ');
}

if (!vj_valid_password($password))
{
     register_error_handler('Password not valid. ');
}

vj_register($username, $password, 'register_error_handler');

if (vj_is_logged_in())
{
     vj_logout();
}

vj_util_navigate('login.php'); 

?>
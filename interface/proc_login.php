<?php

require_once('config.php'); 
require_once(VJ_CORE); 

function login_error_handler($errmsg)
{
     vj_error_navigate('login.php', $errmsg); 
}

$username = $_POST['username']; 
$password = $_POST['password'];

if (!vj_valid_username($username))
{
     login_error_handler('Username not valid. ');
}

if (!vj_valid_password($password))
{
     login_error_handler('Password not valid. ');
}

vj_login($username, $password, 'login_error_handler');

vj_util_navigate('index.php'); 

?>
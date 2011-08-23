<?php

require('../core/config.php');

function vj_get_connection($error_handler = 'vj_error')
{
     $con = mysql_connect(VJ_DB_HOST, VJ_DB_USERNAME, VJ_DB_PASSWORD);

     if (!$con) 
     {
          call_user_func($error_handler, 'Could not connect to database. '); 
     }

     mysql_select_db(VJ_DB_NAME, $con); 

     return $con; 
}

function vj_util_navigate($dest)
{
     echo '<script type="text/javascript">';
     echo 'location.href="' . $dest . '"';
     echo '</script>'; 
}

function vj_error_navigate($dest, $errmsg)
{
     $url = $dest . '?errmsg=' . $errmsg; 
     vj_util_navigate($url); 
}

function vj_error($errmsg)
{
     vj_error_navigate('error.php', $errmsg); 
}

function vj_util_read_file($filename, $error_handler = 'vj_error')
{
     $fp = fopen($filename, 'r'); 

     if (!$fp)
     {
          call_user_func($error_handler, 'Could not open requested file. '); 
     }

     $content = ''; 

     while (!feof($fp))
     {
          $tmp = fgets($fp); 
          $content = $content . "\n" . $tmp; 
     }

     return $content; 
}

function vj_login($username, $password, $error_handler = 'vj_error')
{
     if ($_COOKIE['vj_username'] != '')
     {
          call_user_func($error_handler, 'Attempting to log in while is already in'); 
     }

     $con = vj_get_connection(error_handler);

     $exp = "SELECT * FROM " . VJ_DB_PREFIX . "accounts " . " WHERE username = '" . $username . "' AND PASSWORD = '" . $password . "';";

     $result = mysql_query($exp);

     if ($row = mysql_fetch_array($result))
     {
          setcookie('vj_username', $username); 
     }
     else 
     {
          call_user_func($error_handler, 'Wrong username-password combination. '); 
     }
}

function vj_is_logged_in()
{
     if (vj_get_username() == '')
     {
          return false; 
     }
     else 
     {
          return true; 
     }
}

function vj_logout($error_handler = 'vj_error')
{
     if (!vj_is_logged_in())
     {
          call_user_func($error_handler, 'Attemping to log out while not logged in.' );
     }

     setcookie('vj_username', ''); 
}

function vj_get_username()
{
     return $_COOKIE['vj_username']; 
}

function vj_get_filtered_username()
{
     $username = vj_get_username();

     if ($username == "")
     {
          return "not logged in"; 
     }
     else 
     {
          return $username; 
     }
}

function vj_valid_letter_num_lines($str)
{
     $len = strlen($str); 
     if ($len == 0) return false; 
     for ($i=0; $i<$len; $i++)
     {
          if ('a' <= $str[$i] && $str[$i] <= 'z') continue; 
          if ('A' <= $str[$i] && $str[$i] <= 'Z') continue; 
          if ('0' <= $str[$i] && $str[$i] <= '9') continue; 
          if ($str[$i] == '_' || $str[$i] == '-') continue; 
          return false; 
     }
     return true; 
}

function vj_valid_username($username)
{
     return vj_valid_letter_num_lines($username); 
}

function vj_valid_password($password)
{
     return vj_valid_letter_num_lines($password); 
}

?>
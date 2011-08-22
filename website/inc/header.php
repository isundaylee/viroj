<html>
  <head>
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo $TITLE; ?></title>
  </head>
  <body>
    <div id="pagealign">
    <hr width=800>
    <div align="center"><div id="title">Welcome to VIROJ</div>
    <div id="summary">An open-source Online Judge system for all OIers. </div></div>
    <hr width=800>
    <?php include('inc/navibar.php'); ?>
    <hr width=800>
    <div align="loginbar">
      Login Status:
<?php if ($_COOKIE['viroj_username'] == '') echo 'Not logged in. '; 
 else echo $_COOKIE['viroj_username']; ?>
    </div>
    </div>

<html>
  <head>
    <link rel="stylesheet" type="text/css" href="style/layout.css">
    <title><?php echo 'VIROJ - ' . $TITLE; ?></title>
  </head>
  
  <body>
    <hr />
    <div class="mtitle">Welcome to VIROJ</div>
    <div class="subtitle">An open-source Online Judge system for all OIers. </div>
    <hr />
    <?php include('navibar.php'); ?>
    <hr />
    <?php include($CONTENT); ?>
    <hr />
    <div class="maintainer">Maintainer: Sunday & Vani</div> 
  </body>
</html>

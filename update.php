<?php
/*
  Auto Update System by Geodar  
  Update every change from stable branch from GitHub
*/

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
  <title>XNova Updater</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="shortcut icon" href="favicon.ico" />
  <link rel="stylesheet" href="login/styles.css" type="text/css" />
  </head>
  <body link="white" alink="white" vlink="white" bgcolor="black">
   <div style="align: center;">
    <font color="red" size="5"><b>XNova Updater</b></font><br /><br />
<?php
include("version.php");
include("update_functions.php");
$base_stable_url="https://raw.github.com/freejerry/XNova-Redesigned-Re-Project/stable/";
if($_POST['i'])
{
  if($_POST['i']==1)
  {
    $update_info=@file($base_stable_url."updateinfo.php", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if($update_info[0] != ('Version='.VERSION))
    {
      echo "<font size=\"3\" color=\"white\">";
      $status_file=file("./status");
      if($status_file[0]=="INSTALLED")
      {
        define("INSIDE",true);
        include("game/config1.php");
        if($_POST['mysql_pass']==$dbsettings['pass']) //check for admin rights
        {
          echo "<font color=\"yellow\">Update started</font><br />";
          $update=ExtractVersionUpdate($update_info,VERSION);
          DoAllUpdateCommands($update,$base_stable_url);
          echo "<font color=\"yellow\">Update ended</font>";
        }
        else
          echo "<font color=\"red\">Passwords for XNova database doesn't match!</font>";
      }
      else
        echo "<font color=\"red\">You need to install XNova first!</font>";
      echo "</font>";
    }
    else
      echo "<font color=\"white\"><b>Your XNova version is up to date!</b></font>";
  }
}
else
{
?>
    <form method="post" action="update.php">
    <font color="white">Please enter your password for MySQL database to verify,<br>that you are owner of this XNova version</font><br />
    <input type="text" name="mysql_pass" size="24" /><br />
    <input type="submit" value="Update" />
    <input type="hidden" name="i" value="1" />
    </form>
<?php
}
?>
    </div>
  </body>
</html>

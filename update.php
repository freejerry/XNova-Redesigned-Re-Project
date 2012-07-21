<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <title>XNova Updater</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <link rel="shortcut icon" href="favicon.ico">
  <link rel="stylesheet" href="login/styles.css" type="text/css">
  <title></title>
  </head>
  <body link="white" alink="white" vlink="white" bgcolor="black">
    <center>
    <font color=red size=5><b>XNova Updater</b></font><br><br>
<?php
/*

  Auto Update System by Geodar
  
  Update only from stable branch from Github

*/

include("version.php");
function ExtractVersionUpdate($info_file,$version)
{
  $result = array();
  $i=0;
  $complete=false;
  while (($i<count($info_file)) and !($complete))
  {
    if($info_file[$i] != "Version=".$version)
    {
      $result[$i]=$info_file[$i];
    }
    else
    {
      $complete=true;
    }
    $i+=1;  
  }
  return $result;    
}

function DoUpdateCommands($update_array,$base_url)
{
  $i=0;
  $complete=false;
  while ($i<count($update_array))
  {
    $commandpar = explode('=',$update_array[$i]);
    $command = $commandpar[0];
    $par = $commandpar[1];
    if(strtolower($command)=="updatefile")
    {
      $openfile = @file($base_url.$par, FILE_SKIP_EMPTY_LINES);
      echo "Updating file ".$base_url.$par;
      if(is_writable($par))
      {
        file_put_contents($par,$openfile);
        echo "<font color=lime>Updated</font>";
      }
      else
      {
        echo "<font color=red>Cannot update file '".$par."'! File is not writeable! Check if CHMOD of all XNova files are set to 777!</font>";
      } 
    }
    /*else if(strlower($command)="updatesql")
    {
      $openfile = @file($base_url.$par);
       
    }*/
    $i+=1;  
  }      
}

$base_url='https://raw.github.com/freejerry/XNova-Redesigned-Re-Project/stable/';
$update_info=@file($base_url.'updateinfo.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if($update_info[0] != ('Version='.VERSION))
{
  if($_GET['i']==1)
  {
    echo "<font size=3>";
    $status_file=file('./status');
    if($status_file[0]=='INSTALLED')
    {
      include("game/config1.php");
      if($_GET['mysql_pass']==$dbsettings['pass']) //check for admin rights
      {
        echo "<font color=yellow>Update Started</font>";
        $update=ExtractVersionUpdate($update_info,VERSION);
        DoUpdateCommands($update,$base_url);
        echo "<font color=yellow>Update Ended</font>";
      }
      else
      {
        echo "<font color=red>Passwords for XNova database doesn't match!</font>";
      }
    }
    else
    {
      echo "<font color=red>You need to Install XNova first!</font>";
    }
    echo "</font>";
  }
  else
  {
?>
    <form method='post' action='?i=1'>
    <font color=white>Please enter your password for MySQL database to verify,<br>that you are owner of this XNova version</font>
    <input type='text' name='mysql_pass' size='24'>
    <input type='submit' value='Update'>
    </form>
<?php
  }
}
else
{
?>
    <font color=white><b>Your XNova Version is Up To Date!</b></font>
<?php
}
?>
    </center>
  </body>
</html>
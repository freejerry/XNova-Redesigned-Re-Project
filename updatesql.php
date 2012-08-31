<?php
/*
  Auto SQL Update System by Geodar  
  Update SQL changes from sqlupdates/ folder
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <title>XNova SQL Updater</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <link rel="shortcut icon" href="favicon.ico">
  <link rel="stylesheet" href="login/styles.css" type="text/css">
  <title></title>
  </head>
  <body link="white" alink="white" vlink="white" bgcolor="black">
    <center>
    <font color=red size=5><b>XNova SQL Updater</b></font><br><br>
<?php
include("version.php");
include("update_functions.php");

if($_POST['i'])
{
  if($_POST['i']==1)
  {
    echo "<font size='3' color='white'>";
    $status_file=file('./status');
    if($status_file[0]=='INSTALLED')
    {
      define("INSIDE",true);
      include("game/config1.php");
      if($_POST['mysql_pass']==$dbsettings['pass']) //check for admin rights
      {
        if(file_exists("sqlupdates/".$_POST['sqlfile']))
        {
          $openfile = @file("sqlupdates/".$_POST['sqlfile']);
          $p=0;
          echo "Executing SQL file '".$_POST['sqlfile']."'!<br>";
          while ($p<count($openfile))
          {
            if(!(($openfile[$p][0]=='/') and !($openfile[$p][1]=='/')))
            {
              doquery($openfile[$p], $openfile[$p+1]);            
              $p+=1;
            }
            $p+=1;
          }
          echo "<font color='lime'>SQL file '".$_POST['sqlfile']."' executed!</font><br>";
        }
        else
          echo "<font color='red'>SQL file doesn´t exists!</font>";
      }
      else
        echo "<font color='red'>Passwords for XNova database doesn't match!</font>";
    }
    else
      echo "<font color='red'>You need to install XNova first!</font>";
    echo "</font>";
  }
}
else
{
?>
    <form method='post' action='update.php'>
    <font color='white'>Please enter your password for MySQL database to verify,<br>that you are owner of this XNova version</font><br>
    <input type='text' name='mysql_pass' size='24'><br>
    <select name='sqlfile'>
    <?php
    //todo
    ?>
    </select><br>
    <input type='submit' value='Run SQL'>
    <input type='hidden' name='i' value='1'>
    </form>
<?php
}
?>
    </center>
  </body>
</html>

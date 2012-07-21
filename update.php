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
        echo "Updated";
      }
      else
      {
        echo "Cannot update file '".$par."'! File is not writeable! Check if CHMOD of all XNOVA files are set to 777!"
      } 
    }
    /*else if(strlower($command)="updatesql")
    {
      $openfile = @file($base_url.$par);
       
    }*/
    $i+=1;  
  }      
}

if($_GET['i']==1)
{
  if(file_exists('./status'))
  {
    include("game/config1.php");
    if($_GET['mysql_pass']==$dbsettings['pass']) //check for admin rights
    {
      $base_url = 'https://raw.github.com/XNovaRedesignedReProject/XNova_Redesigned_Re_Project/stable/';
      $update_info = @file($base_url.'updateinfo.php', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      $update=ExtractVersionUpdate($update_info,VERSION);
      DoUpdateCommands($update,$base_url);
    }
    else
    {
      echo "Passwords for XNOVA database doesn't match!";
    }
  }
  else
  {
    echo "You need to Install XNOVA first!";
  }
}
else
{
?>
<center>
<font color=red size=5><b>XNova Updater</b></font><br><br>
<form method='post' action='?i=1'>

</center>
<?php
}
?>

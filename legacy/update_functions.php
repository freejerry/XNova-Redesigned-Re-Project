<?php
/*
  Auto Update System Functions by Geodar
  Update every change from stable branch from GitHub
  This file is updateable
*/

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
function DoAllUpdateCommands($update_array,$base_url)
{
  $i=0;
  $complete=false;
  @include("game/db/mysql.php");
  while ($i<count($update_array))
  {
    $commandpar = explode('=',$update_array[$i]);
    $command = $commandpar[0];
    if(count($commandpar)>1)
      $par = $commandpar[1];
    if(strtolower($command)=="updatefile")
    {
      $openfile = @file($base_url.$par, FILE_SKIP_EMPTY_LINES);
      echo "Updating file ".$par."<br />";
      if(is_writable($par))
      {
        file_put_contents($par,$openfile);
        echo "<font color=\"lime\">Updated!</font><br />";
      }
      else
      {
        echo "<font color=\"red\">Cannot update file \"".$par."\"! File is not writeable! Check if CHMOD of all XNova files are set to 777!</font><br />";
      } 
    }
    else if(strtolower($command)=="deletefile")
    {
      echo "Deleting file ".$par."<br />";
      if(unlink($par))
      {
        echo "<font color=\"lime\">Deleted!</font><br />";
      }
      else
      {
        echo "<font color=\"red\">Cannot delete file \"".$par."\"!</font><br />";
      } 
    }
    else if(strtolower($command)=="backupfile")
    {
      if(file_exists($par))
      {
        if(is_writable($par.".backup"))
        {
          if(copy($par,$par.".backup"))
          {
            echo "<font color=\"lime\">Backup file for \"".$par."\" created!</font><br />";
          }
          else
          {
            echo "<font color=\"red\">Cannot backup file \"".$par."\"! Copy failed!</font><br />";
          }          
        }
        else
        {
          echo "<font color=\"red\">Cannot backup file \"".$par."\"! File \"".$par.".backup\" is not writeable! Check if CHMOD of all XNova files are set to 777!</font><br />";
        }
      }
    }
    else if(strtolower($command)=="renewfile")
    {
      if(file_exists($par.".backup"))
      {
        if(is_writable($par))
        {
          if(copy($par.".backup",$par))
          {
            echo "<font color=\"lime\">File \"".$par."\" was renewed!</font><br />";
          }
          else
          {
            echo "<font color=\"red\">Cannot renew file \"".$par."\"! Copy failed!</font><br />";
          }          
        }
        else
        {
          echo "<font color=\"red\">Cannot renew file \"".$par."'! File \"".$par."\" is not writeable! Check if CHMOD of all XNova files are set to 777!</font><br />";
        }
      }
    }
    else if(strtolower($command)=="updatesql")
    {
      $openfile = @file($base_url."sqlupdates/".$par);
      $p=0;
      echo "Executing SQL file \"".$par."\"!<br />";
      while ($p<count($openfile))
      {
        $openfile[$p]=str_replace('\n','',$openfile[$p]);
        if(!(($openfile[$p][0]=='/') and ($openfile[$p][1]=='/')))
        {
          doquery($openfile[$p], $openfile[$p+1]);            
          $p+=1;
        }
        $p+=1;
      }
      echo "<font color=\"lime\">SQL file \"".$par."\" executed!</font><br />"; 
    }
    $i+=1;  
  }      
}
?>

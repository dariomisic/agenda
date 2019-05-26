<?
 
include('check.php');
check_login('3');

include('header.php');

if(!isset($included))
include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

if(isset($gets['id']))
{

  $sql = "DELETE FROM files WHERE id=".$gets['id'];
    
  $result = mysql_query($sql);

}

?>
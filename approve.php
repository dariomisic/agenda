<?php

if(isset($_GET['id']))
{
include("functions/functions.php");

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

if(isset($gets['event']))
{
$sql="UPDATE event SET approved = 1 WHERE id=".$gets["id"];
}
else
{
$sql="UPDATE activity SET approved = 1 WHERE activity_id=".$gets["id"];
}
$result=mysql_query($sql);

header('Location: dashboard.php');

}


?>
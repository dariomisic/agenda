<?php

include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

if(isset($gets['e']))
{
$employee=$gets['e'];


$sql="SELECT TIMEDIFF(event.end,event.start) FROM event INNER JOIN activity ON event.activity=activity.activity_id WHERE activity.employee='" . $employee . "'";

		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
		$d=explode(":",$row[0]);
		$h+=$d[0];
		$m+=$d[1];
		}

if($m>59)
{
$h+=(int)$m/60;
$m=$m%60;
$h+=(int)$m/60;
}

if(!$h)
$h="0";
echo $h.'<div style="font-size:16px; display:inline-block;">hours</div>';

}

?>
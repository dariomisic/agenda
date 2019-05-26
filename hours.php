<?php


function get_finished($employee,$t,$offset_w,$offset_year)
{

$sql="SELECT TIMEDIFF(event.end,event.start),TIMESTAMPDIFF(DAY,event.start,event.end),event.allday FROM event INNER JOIN activity ON event.activity=activity.activity_id WHERE activity.employee='" . $employee . "' AND event.done=".$t." AND WEEK(event.start)=".$offset_w." AND YEAR(event.start)=".$offset_year;

		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
		$d=explode(":",$row[0]);
		if($row[2]==0)
		{
		$h+=$d[0];
		$m+=$d[1];
		}
			if($row[2]==1)
			{
			$h+=($row[1]+1)*8;
			}
		}
		

if($m>59)
{
$h+=(int)$m/60;
$m=$m%60;
$h+=(int)$m/60;
}
else
{
$h+=(int)$m/60;
}

if(!$h)
$h="0";

$sql2="SELECT TIMEDIFF(event.end,event.start),TIMESTAMPDIFF(DAY,event.start,event.end),event.allday FROM event WHERE event.activity=0 AND event.employee='" . $employee . "' AND event.done=".$t." AND WEEK(event.start)=".$offset_w." AND YEAR(event.start)=".$offset_year;

		$result2 = mysql_query($sql2);
		while($row2 = mysql_fetch_array($result2))
		{
		$d2=explode(":",$row2[0]);
		if($row2[2]==0)
		{
		$h2+=$d2[0];
		$m2+=$d2[1];
		}
			if($row2[2]==1)
			{
			$h2+=($row2[1]+1)*8;
			}
		}
		

if($m2>59)
{
$h2+=(int)$m2/60;
$m2=$m2%60;
$h2+=(int)$m2/60;
}
else
{
$h2+=(int)$m2/60;
}

if(!$h2)
$h2="0";



return $h+$h2;

}


include_once("functions/functions.php");

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

if(isset($posts['y'])&&isset($posts['w']))
{
$year=$posts['y'];
$week_no=$posts['w'];
}
else
{
$year=date("Y");
$week_no=date("W");
}

if(isset($gets['e']))
$employee=$gets['e'];

if($gets['domain']=="statistics")
{
$count=0;
for($i=0;$i<20;$i++)
{
if(($week_no-$i)<1)
{
$week_no=date("W", mktime(0,0,0,12,28,$year-1));
$year=$year-1;
$week_no++;
$count++;
}


if($count)
$d=array("WEEK ".($week_no-$count)." ".$year, get_finished($employee,1,$week_no-$count,$year));
else
$d=array("WEEK ".($week_no-$i)." ".$year, get_finished($employee,1,$week_no-$i,$year));

$data[]=$d;


if($count)
$count++;
}
$bar=array("color"=> "#86D5A1","label"=> "FINISHED HOURS","data"=>array_reverse($data));

echo json_encode($bar);
}
elseif($gets['domain']=="statistics2")
{
$count=0;
for($i=0;$i<20;$i++)
{
if(($week_no-$i)<1)
{
$week_no=date("W", mktime(0,0,0,12,28,$year-1));
$year=$year-1;
$week_no++;
$count++;
}

if($count)
$d=array("WEEK ".($week_no-$count)." ".$year, get_finished($employee,0,$week_no-$count,$year));
else
$d=array("WEEK ".($week_no-$i)." ".$year, get_finished($employee,0,$week_no-$i,$year));

$data[]=$d;

if($count)
$count++;
}
$bar=array("color"=> "#FF7878","label"=> "UNFINISHED HOURS","data"=>array_reverse($data));

echo json_encode($bar);
}
else
{

if($employee=="no")
{
$sql="SELECT TIMEDIFF(event.end,event.start),TIMESTAMPDIFF(DAY,event.start,event.end),event.allday FROM event INNER JOIN activity ON event.activity=activity.activity_id WHERE WEEKOFYEAR(event.start)='" . $week_no . "' AND YEAR(event.start)='" . $year . "'";
}
else
{

$sql="SELECT TIMEDIFF(event.end,event.start),TIMESTAMPDIFF(DAY,event.start,event.end),event.allday FROM event INNER JOIN activity ON event.activity=activity.activity_id WHERE WEEKOFYEAR(event.start)='" . $week_no . "' AND YEAR(event.start)='" . $year . "' AND activity.employee='" . $employee . "'";

}

$sql2="SELECT TIMEDIFF(event.end,event.start),TIMESTAMPDIFF(DAY,event.start,event.end),event.allday FROM event WHERE event.employee='".$employee."' AND WEEKOFYEAR(event.start)='" . $week_no . "' AND YEAR(event.start)='" . $year . "'";

		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
		$d=explode(":",$row[0]);
		if($row[2]==0)
		{
		$h+=$d[0];
		$m+=$d[1];
		}
		if($row[2]==1)
			{
			$h+=($row[1]+1)*8;
			}
		}
		

if($m>59)
{
$h+=(int)$m/60;
$m=$m%60;
$h+=(int)$m/60;
}
else
{
$h+=(int)$m/60;
}

if(!$h)
$h="0";


		$result2 = mysql_query($sql2);
		while($row2 = mysql_fetch_array($result2))
		{
		$d2=explode(":",$row2[0]);
		if($row2[2]==0)
		{
		$h2+=$d2[0];
		$m2+=$d2[1];
		}
		if($row2[2]==1)
			{
			$h2+=($row2[1]+1)*8;
			}
		}
		

if($m2>59)
{
$h2+=(int)$m2/60;
$m2=$m2%60;
$h2+=(int)$m2/60;
}
else
{
$h2+=(int)$m2/60;
}

if(!$h2)
$h2="0";


echo $h+$h2.'<div style="font-size:16px; display:inline-block;">hours</div>';

}

?>
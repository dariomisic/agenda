<?php

if(!isset($check))
include('check.php');
check_login('3');

if(!isset($included))
include('functions/functions.php');

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

    $week_start = new DateTime();
    $week_start->setISODate($year, $week_no);

    $seven_day_week = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday','sunday');
    $week = array();

    for ($i = 0; $i < 7; $i++) {
        $day = $seven_day_week[$i];
        $week[$i] = $week_start->format('Y-m-d');
        $week_start->modify('+1 day');
    }
$c=0;

$buffer = array();

foreach($week as $w)
{
$c++;
if($c%2)
$margin="20";
else
$margin="0";
$sql="SELECT user.fname,user.lname,activity.name,HOUR(event.start),MINUTE(event.start),HOUR(event.end),MINUTE(event.end),allday FROM event INNER JOIN activity ON activity.activity_id=event.activity INNER JOIN user ON activity.employee=user.user_id  WHERE DATE(event.end)='".$w."' OR DATE(event.start)='".$w."'";

echo '<div class="col-md-6"><div class="box"><div class="box-header"><h3 class="box-title">'.ucfirst($seven_day_week[$c-1]).'</h3></div><div class="box-body no-padding box-scroll-day"><table class="table"><tbody>';

if(isset($buffer))
{
unset($buffer);
$buffer = array();
}
else
{
$buffer = array();
}

if(isset($key_start))
{
unset($key_start);
$key_start = array();
}
else
{
$key_start = array();
}

$index=0;

		$result = mysql_query($sql);
		while($row = mysql_fetch_array($result))
		{
		$f_name=$row[0]." ".$row[1];
		$activity_name=$row[2];
		if($row[4]==0)
		$row[4]="00";
		if($row[6]==0)
		$row[6]="00";
		$start=$row[3].":".$row[4];
		$end=$row[5].":".$row[6];
		if($row[7]=="1")
		{
			
		$start='';
		$end='AD';
		}
		

$temp='<tr><td>'.$f_name.'</td><td>'.$activity_name.'</td><td class="table-b"><span class="label label-red">EVENT</span></td><td class="table-d">'.$start.'</td><td class="table-d">'.$end.'</td></tr>';
		
$buffer[$index]['time']=$start;
$buffer[$index]['content']=$temp;
$index++;
		
		} 
		
		
		
		
		
		$sql2="SELECT user.fname,user.lname,event.title,HOUR(event.start),MINUTE(event.start),HOUR(event.end),MINUTE(event.end),event.allday FROM event INNER JOIN user ON event.employee=user.user_id WHERE event.activity=0 AND event.place IS NULL AND (DATE(event.end)='".$w."' OR DATE(event.start)='".$w."')";

		$result2 = mysql_query($sql2);
		while($row2 = mysql_fetch_array($result2))
		{
		$f_name=$row2[0]." ".$row2[1];
		$activity_name=$row2[2];
		if($row2[4]==0)
		$row2[4]="00";
		if($row2[6]==0)
		$row2[6]="00";
		$start2=$row2[3].":".$row2[4];
		$end2=$row2[5].":".$row2[6];
		if($row2[7]=="1")
		{
		$start2='';
		$end2='AD';
		}

$temp='<tr><td>'.$f_name.'</td><td>'.$activity_name.'</td><td class="table-b"><span class="label label-aqua">EVENT</span></td><td class="table-d">'.$start2.'</td><td class="table-d">'.$end2.'</td></tr>';

$buffer[$index]['time']=$start2;
$buffer[$index]['content']=$temp;
$index++;
		
		} 
		
	 $sql3="SELECT user.fname,user.lname,event.title,HOUR(event.start),MINUTE(event.start),HOUR(event.end),MINUTE(event.end),event.allday,event.place,event.phone FROM event INNER JOIN user ON event.employee=user.user_id WHERE event.activity=0 AND event.place IS NOT NULL AND (DATE(event.end)='".$w."' OR DATE(event.start)='".$w."')";

		$result3 = mysql_query($sql3);
		while($row3 = mysql_fetch_array($result3))
		{
		$f_name=$row3[0]." ".$row3[1];
		$activity_name=$row3[2];
		if($row3[4]==0)
		$row3[4]="00";
		if($row3[6]==0)
		$row3[6]="00";
		$start3=$row3[3].":".$row3[4];
		$end3=$row3[5].":".$row3[6];
		if($row3[7]=="1")
		{
		$start3='';
		$end3='AD';
		}
		
$temp='<tr><td>'.$f_name.'</td><td>'.$activity_name.'</td><td class="table-b"><span class="label label-yellow">APP.</span></td><td class="table-d">'.$start3.'</td><td class="table-d">'.$end3.'</td></tr>';

$buffer[$index]['time']=$start3;
$buffer[$index]['content']=$temp;
$index++;
				
		}
		
if(isset($parts))
{
unset($parts);
}

if(isset($key_time))
{
unset($key_time);
}
		
foreach ($buffer as $key => $row) {


	if($row['time']=="")
	{
	$val=999999;
	}
	else
	{
	$parts=explode(':',$row['time']);
	$val=(int)$parts[0].$parts[1];
	}
    $key_time[$key]  = $val;
}
		
array_multisort($key_time,SORT_ASC,$buffer);

foreach($buffer as $b)
{
echo $b['content'];
}
		
echo '</tbody></table></div></div></div>';	
}

?>
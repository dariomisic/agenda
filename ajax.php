<?

if(!isset($check))
include('check.php');
check_login('3');

function encode_weekdays($id)
{
		$sql = "SELECT workday FROM working WHERE user=".$id;
		$result = mysql_query($sql);
		$w=array(0,0,0,0,0,0,0);
		while($row = mysql_fetch_array($result))
		{
			$w[$row[0]-1]=1;
		}
return implode($w);
}

if(!isset($included))
include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

if(isset($_GET["action"]))
{

if($gets["action"]=="add_action")
{
if($posts["n"]!="")
{
$sql="INSERT INTO activity (project, name, description, hours, tarrif, status, employee, dependency) VALUES ('" . $posts["project_id"] . "', '" . $posts["n"] . "', '" . $posts["d"] . "', '" . $posts["h"] . "', '" . $posts["t"] . "', '" . $posts["s"] . "', '" . $posts["e"] . "', '" . $posts["dependent"] . "');";

$result=mysql_query($sql);

if(mysql_affected_rows())
{
$result2 = mysql_query("SELECT activity_id FROM activity WHERE activity_id = LAST_INSERT_ID();");
$row = mysql_fetch_array($result2);
echo $row[0];
}
else
echo "error";
}
else
{
echo 1;
}
}
elseif($gets["action"]=="add_event")
{

if(date('Y',$posts["end"])=="0000")
$posts["end"]==$posts["start"];

$sql="INSERT INTO event (title,start,end,activity,allday) VALUES ('" . $posts["title"] . "', '" . $posts["start"] . "', '" . $posts["end"] . "', '" . $posts["activity"] . "', '" . $posts['allday'] . "');";

$result=mysql_query($sql);


$sql="SELECT id FROM event WHERE id=LAST_INSERT_ID();";

$result=mysql_query($sql);

$row = mysql_fetch_array($result,MYSQL_ASSOC);

echo $row["id"];

}
elseif($gets["action"]=="add_fevent")
{

if(date('Y',$posts["end"])=="0000")
$posts["end"]==$posts["start"];

$a=0;

$allday=$posts['allday'];

$sql="INSERT INTO event (title,start,end,activity,employee,allday) VALUES ('" . $posts["title"] . "', '" . $posts["start"] . "', '" . $posts["end"] . "', '" . $a . "', '" . $posts["employee"] . "', '" . $allday . "');";

$result=mysql_query($sql);


$sql="SELECT id,allday FROM event WHERE id=LAST_INSERT_ID();";

$result=mysql_query($sql);

$row = mysql_fetch_array($result,MYSQL_ASSOC);

echo $row["id"];

}
elseif($gets["action"]=="add_appointment")
{

if(date('Y',$posts["end"])=="0000")
$posts["end"]==$posts["start"];

$a=0;

$allday=$posts['allday'];

$sql="INSERT INTO event (title,start,end,activity,employee,allday,phone,place,done) VALUES ('" . $posts["title"] . "', '" . $posts["start"] . "', '" . $posts["end"] . "', '" . $a . "', '" . $posts["employee"] . "', '" . $allday . "', '" . $posts["phone"] . "', '" . $posts["place"] . "',1);";

$result=mysql_query($sql);


$sql="SELECT id,allday FROM event WHERE id=LAST_INSERT_ID();";

$result=mysql_query($sql);

$row = mysql_fetch_array($result,MYSQL_ASSOC);

echo $row["id"];

}
elseif($gets["action"]=="update_appointment")
{

if(date('Y',$posts["end"])=="0000")
$posts["end"]==$posts["start"];

$a=0;

$allday=$posts['allday'];


$sql="UPDATE event SET allday='" . $allday . "',start='" . $posts["start"] . "',end='" . $posts["end"] . "' WHERE id='" . $posts["id"] . "'";

$result=mysql_query($sql);

}
elseif($gets["action"]=="list_event")
{

$sql="SELECT event.id,event.title,event.start,event.end,event.allday FROM activity INNER JOIN event ON activity.activity_id=event.activity WHERE activity.employee=".$gets["employee"];
$result=mysql_query($sql);

while($row = mysql_fetch_array($result))
{
if($row[4]==1)
$row['allDay']=true;
else
$row['allDay']=false;

$row['color']='#ccc';
$row['editable']=false;
$events[]=$row;
}

echo json_encode($events);

}
elseif($gets["action"]=="update_event")
{

if(date('Y',$posts["end"])=="0000")
$posts["end"]==$posts["start"];


$sql="UPDATE event SET activity='" . $posts["activity"] . "',title='" . $posts["title"] . "',allday='" . $posts['allday'] . "',start='" . $posts["start"] . "',end='" . $posts["end"] . "' WHERE id='" . $posts["id"] . "'";



$result=mysql_query($sql);

}
elseif($gets["action"]=="update_fevent")
{

if(date('Y',$posts["end"])=="0000")
$posts["end"]==$posts["start"];

if($posts['allDay'])
$allday=1;
else
$allday=0;


$sql="UPDATE event SET activity='0',title='" . $posts["title"] . "',start='" . $posts["start"] . "',end='" . $posts["end"] . "',allday='" . $allday . "' WHERE id='" . $posts["id"] . "'";



$result=mysql_query($sql);

}
elseif($gets["action"]=="get_working")
{
echo encode_weekdays($posts['employee']);
}
elseif($gets["action"]=="list_user")
{

$sql="SELECT event.id,event.title,event.start,event.end,event.allday FROM activity INNER JOIN event ON activity.activity_id=event.activity WHERE activity.employee=".$gets["employee"];
$result=mysql_query($sql);

while($row = mysql_fetch_array($result,MYSQL_ASSOC))
{
if($row['allday']=="1")
$row['allDay']=true;
else
$row['allDay']=false;
$row['editable']=false;
$events[]=$row;
}



$sql2="SELECT id,title,start,end,allday FROM event WHERE activity=0 AND employee=".$gets["employee"];


$result2=mysql_query($sql2);

while($row2 = mysql_fetch_array($result2,MYSQL_ASSOC))
{
if($row2['allday']=="1")
$row2['allDay']=true;
else
$row2['allDay']=false;
$row2['editable']=false;
$events[]=$row2;
}

echo json_encode($events);

}
elseif($gets["action"]=="list_activity")
{

$sql="SELECT event.*,activity.*,project.name AS project,client.name AS client,CONCAT(user.fname,' ',user.lname) AS employee FROM activity INNER JOIN event ON event.activity=activity.activity_id INNER JOIN project ON activity.project=project.project_id INNER JOIN client ON project.client=client.client_id INNER JOIN user ON activity.employee=user.user_id WHERE event.activity=".$gets["activity"];
$result=mysql_query($sql);

while($row = mysql_fetch_array($result,MYSQL_ASSOC))
{
$row['allDay']=false;
$row['editable']=false;
$row['title'].=' <- '.$row['project'].' <- '.$row['client'].' <- '.$row['employee'];
$events[]=$row;
}

echo json_encode($events);

}
elseif($gets["action"]=="list_event_approve")
{

$sql="SELECT * FROM event WHERE id=".$gets['event'];
$result=mysql_query($sql);

while($row = mysql_fetch_array($result,MYSQL_ASSOC))
{
$row['allDay']=false;
$row['editable']=false;
$events[]=$row;
}

echo json_encode($events);

}
elseif($gets["action"]=="list_appointment")
{

$sql="SELECT * FROM activity INNER JOIN event ON event.activity=activity.activity_id WHERE activity.employee=".$gets["employee"];

$sql_free="SELECT * FROM event WHERE activity=0 AND employee=".$gets['employee'];

$result_free=mysql_query($sql_free);
$result=mysql_query($sql);

while($row = mysql_fetch_array($result,MYSQL_ASSOC))
{
$row['allDay']=false;
$row['editable']=false;
$row['color']='#ccc';
$events[]=$row;
}

while($rowf = mysql_fetch_array($result_free,MYSQL_ASSOC))
{
if($rowf['allday']==0)
$rowf['allDay']=false;
else
$rowf['allDay']=true;
$rowf['editable']=false;
$rowf['color']='#ccc';
$events[]=$rowf;
}


echo json_encode($events);

}
elseif($gets["action"]=="list_appointments")
{

$sql="SELECT * FROM activity INNER JOIN event ON event.activity=activity.activity_id";

$sql_free="SELECT * FROM event INNER JOIN user ON event.employee=user.user_id WHERE activity=0 AND place IS NOT NULL";

$result_free=mysql_query($sql_free);
$result=mysql_query($sql);

while($rowf = mysql_fetch_array($result_free,MYSQL_ASSOC))
{
if($rowf['allday']==0)
$rowf['allDay']=false;
else
$rowf['allDay']=true;
$rowf['editable']=true;
$rowf['title']='D:'.$rowf['title']."\nE:".$rowf['fname']." ".$rowf['lname']."\nP:".$rowf['place'];
$events[]=$rowf;
}


echo json_encode($events);

}
elseif($gets["action"]=="list_dashboard")
{

$sql="SELECT event.*,activity.*,project.name AS project,client.name AS client FROM activity INNER JOIN event ON event.activity=activity.activity_id INNER JOIN project ON activity.project=project.project_id INNER JOIN client ON project.client=client.client_id WHERE activity.employee=".$gets["employee"];

$sql_free="SELECT * FROM event WHERE activity=0 AND event.place IS NULL AND employee=".$gets['employee'];

$sql_a="SELECT * FROM event WHERE activity=0 AND event.place IS NOT NULL AND employee=".$gets['employee'];

$result_free=mysql_query($sql_free);
$result_a=mysql_query($sql_a);
$result=mysql_query($sql);

while($row = mysql_fetch_array($result,MYSQL_ASSOC))
{
$row['allDay']=false;
$row['editable']=false;
if($row['done']==1)
$row['color']='#ff8971';
else
$row['color']='#f56954';
$row['title'].=' <- '.$row['project'].' <- '.$row['client'];
$events[]=$row;
}

while($rowf = mysql_fetch_array($result_free,MYSQL_ASSOC))
{
if($rowf['allday']==0)
$rowf['allDay']=false;
else
$rowf['allDay']=true;
$rowf['editable']=true;
if($rowf['done']!=1)
$rowf['color']='#00c0ef';
else
$rowf['color']='#41d8ff';
$events[]=$rowf;
}

while($rowa = mysql_fetch_array($result_a,MYSQL_ASSOC))
{
if($rowa['allday']==0)
$rowa['allDay']=false;
else
$rowa['allDay']=true;
$rowa['editable']=false;
$rowa['color']='#f39c12';
$events[]=$rowa;
}

echo json_encode($events);

}
elseif($gets["action"]=="mark_event_done")
{

$sql="UPDATE event SET done=1 WHERE id=".$posts["id"];
$result=mysql_query($sql);

echo 'ok';

}
elseif($gets["action"]=="delete_event")
{

$sql="DELETE FROM event WHERE id=".$posts["id"];
$result=mysql_query($sql);

echo 'ok';

}
elseif($gets["action"]=="delete_activity")
{

$sql="DELETE FROM activity WHERE activity_id=".$posts["id"];
$result=mysql_query($sql);

$sql="DELETE FROM event WHERE activity=".$posts["id"];
$result=mysql_query($sql);

echo 'ok';

}
elseif($gets["action"]=="delete_fevent")
{

$sql="DELETE FROM event WHERE id=".$posts["id"];
$result=mysql_query($sql);

echo 'ok';

}


}


?>
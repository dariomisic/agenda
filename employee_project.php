<?
 
include('check.php');
check_login('3');

if(!isset($included))
include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

include('header.php');

include('sc.php');


function safe($s) {
    $result = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($s, ENT_QUOTES));
    return stripslashes($result);
}

function get_employee_hours_all($employee,$activity)
{

$sql="SELECT TIMEDIFF(event.end,event.start),TIMESTAMPDIFF(DAY,event.start,event.end),event.allday FROM event INNER JOIN activity ON event.activity=activity.activity_id WHERE event.activity='" . $activity . "' AND activity.employee='" . $employee . "'";

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


return $h.' hours';

}

function get_finished($project,$t)
{

$sql="SELECT TIMEDIFF(event.end,event.start),TIMESTAMPDIFF(DAY,event.start,event.end),event.allday FROM event INNER JOIN activity ON event.activity=activity.activity_id INNER JOIN project ON activity.project=project.project_id WHERE activity.project='" . $project . "' AND event.done=".$t;

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
return $h;

}


function get_employee_hours_project($employee,$project)
{

$sql="SELECT TIMEDIFF(event.end,event.start),TIMESTAMPDIFF(DAY,event.start,event.end),event.allday FROM event INNER JOIN activity ON event.activity=activity.activity_id INNER JOIN project ON activity.project=project.project_id WHERE activity.project='" . $project . "' AND activity.employee='" . $employee . "'";

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
return $h;

}

if(isset($gets['id']))
{

if(!isset($_SESSION['username']))

    
    $sql = "SELECT name FROM project WHERE project_id=".$gets['id'];
    
	$result = mysql_query($sql);
	
	$row = mysql_fetch_array($result);
	


$sql2 = "SELECT activity_id,name,description from activity WHERE activity.project=".$gets['id']." AND activity.employee=".$User_ID;


$result2 = mysql_query($sql2);

while($row2 = mysql_fetch_array($result2))
{

$m.='<tr><td>'.$row2[1].'</td><td>'.get_employee_hours_all($User_ID,$row2[0]).'</td></tr>';


}


$sql3 = 'SELECT activity.activity_id,activity.name,activity.description,CONCAT(user.fname,\' \',user.lname) FROM activity INNER JOIN user ON activity.employee=user.user_id WHERE activity.project='.$gets['id'].' AND NOT activity.employee='.$User_ID;


$result3 = mysql_query($sql3);

while($row3 = mysql_fetch_array($result3))
{

$c.='<tr><td>'.$row3[1].'</td><td>'.$row3[3].'</td></tr>';


}



$sql4='SELECT DISTINCT(user.user_id),CONCAT(user.fname,\' \',user.lname) FROM activity INNER JOIN project ON project.project_id=activity.project INNER JOIN user ON activity.employee=user.user_id WHERE activity.project='.$gets['id'];
	
	
	
$result4 = mysql_query($sql4);

while($row4 = mysql_fetch_array($result4))
{
$hours[]=get_employee_hours_project($row4[0],$gets[id]);
$e[]=$row4[1];
}


for($i=0;$i<count($hours);$i++)
{


$se= array(
    'label' => $e[$i], 
    'data' => array(array($e[$i], $hours[$i]))
);

$pie3[]=$se;

}


$f['finished']=get_finished($gets['id'],1);
$f['unfinished']=get_finished($gets['id'],0);


$se2= array(
    'label' => "FINISHED",
    'color' => "#86D5A1",
    'data' => array(array("FINISHED", $f['finished']))
);

$pie4[]=$se2;

$se2= array(
    'label' => "UNFINISHED",
    'color' => "#FF7878",
    'data' => array(array("UNFINISHED", $f['unfinished']))
);

$pie4[]=$se2;

$total = array_sum($hours);

foreach($hours as &$hits) {
   $hits = round($hits / $total * 100, 1);
}

for($i=0;$i<count($hours);$i++)
{
$sequence['label']=$e[$i];
$sequence['data']=$hours[$i];

$returnArray[]=$sequence;

}
	
	
	
	
	
$total = array_sum($f);

foreach($f as &$hits) {
   $hits = round($hits / $total * 100, 1);
}


$sequence['label']="FINISHED";
$sequence['data']=$f['finished'];
$sequence['color']="#86D5A1";

$pie2[]=$sequence;

$sequence['label']="UNFINISHED";
$sequence['data']=$f['unfinished'];
$sequence['color']="#FF7878";

$pie2[]=$sequence;

?>



<section class="content">
<div class="row">
<div class="col-md-6">
<div class="box"><div class="box-header"><i class="fa fa-user"></i><h3 class="box-title">My activities</h3></div><div class="box-body"><table class="table">
<?php echo $m; ?>
</table></div></div></div>

<div class="col-md-6">
<div class="box"><div class="box-header"><i class="fa fa-users"></i><h3 class="box-title">Coworker activities</h3></div><div class="box-body"><table class="table">
<?php echo $c; ?>
</table></div></div></div>

<div class="col-md-6">
<div class="box"><div class="box-header"><i class="fa fa-pie-chart"></i><h3 class="box-title">Employee distribution</h3></div><div class="box-body"><div id="pie" style="height:210px;">
</div></div></div></div>

<div class="col-md-6">
<div class="box"><div class="box-header"><i class="fa fa-pie-chart"></i><h3 class="box-title">Finished ratio</h3></div><div class="box-body"><div id="pie2" style="height:210px;">
</div></div></div></div>

<div class="col-md-6">
<div class="box"><div class="box-header"><i class="fa fa-bar-chart"></i><h3 class="box-title">Hours distribution</h3></div><div class="box-body"><div id="pie3" style="height:210px;">
</div></div></div></div>

<div class="col-md-6">
<div class="box"><div class="box-header"><i class="fa fa-bar-chart"></i><h3 class="box-title">Finished/unfinished hours</h3></div><div class="box-body"><div id="pie4" style="height:210px;">
</div></div></div></div>

<script type="text/javascript">

        $('.scroll').slimScroll({
        height: '160px',
            color: '#ccc',
    alwaysVisible: true
    });


var data = <?php echo json_encode($returnArray); ?>;

$.plot('#pie', data, {
    series: {
        pie: {
            show: true
        }
    },
    grid: {
        hoverable: true,
        clickable: true
    }
});



var data2 = <?php echo json_encode($pie2); ?>;

$.plot('#pie2', data2, {
    series: {
        pie: {
            show: true
        }
    },
    grid: {
        hoverable: true,
        clickable: true
    }
});


var options = {        
    series: {
        bars: {
            show: true,
            barWidth: .1,
            align: 'center'
        }
    },
    xaxis: {
        tickSize: 1,
        mode: "categories"
    }

};

var data3 = <?php echo json_encode($pie3); ?>;

$.plot('#pie3', data3, options);

			
			
var data4 = <?php echo json_encode($pie4); ?>;

$.plot('#pie4', data4, options);
			

			$('#pie,#pie2,#pie3,#pie4').bind("plotclick", function(event, pos, obj) {

				if (!obj) {
					return;
				}

				percent = parseFloat(obj.series.percent).toFixed(2);
				alert(""  + obj.series.label + ": " + percent + "%");
			});

</script>


<?
	
}

include('footer.php');

?>
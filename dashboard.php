<?
include('check.php');
check_login('3');
$check=1;

include('header.php');
if(!isset($_SESSION['username']))
include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

$included=1;


include('sc.php');


    $sql = "SELECT activity.activity_id,activity.name,user.fname,user.lname from activity INNER JOIN user ON activity.employee=user.user_id WHERE approved=0";
    
	$result = mysql_query($sql);

    $a='<table class="table"><tr><th>Name</th><th>Assigned employee</th><th style="width:80px;">Approval</th></tr>';
	
	while($r = mysql_fetch_array($result))
	{
        $a.='<tr><td>'.$r[1].'</td><td>'.$r[2].' '.$r[3].'</td><td><a class="btn btn-info" href="approve_activity.php?id='.$r[0].'">Approve</a></td></tr>';
	}
	
	
	$sql = "SELECT event.id,event.title,user.fname,user.lname FROM event INNER JOIN user on event.employee=user.user_id WHERE approved=0 AND activity=0";

    
	$result = mysql_query($sql);
	
	while($r3 = mysql_fetch_array($result))
	{

        $a.='<tr><td>'.$r3[1].'</td><td>'.$r3[2].' '.$r3[3].'</td><td><a class="btn btn-info" href="approve_event.php?id='.$r3[0].'">Approve</a></td></tr>';

	}
	

    $a.='</table>';
	
	$sql = "SELECT DISTINCT project.project_id,project.name,project.end from project INNER JOIN activity ON project.project_id=activity.project WHERE activity.employee=".$User_ID;
    
	$result = mysql_query($sql);

    $e='<table class="table"><tr><th>Project name</th><th>Go to project</th><th style="width:110px;">Deadline</th></tr>';
	
	while($r = mysql_fetch_array($result))
	{
	
    $e.='<tr><td>'.$r[1].'</td><td style="width:80px;"><a class="btn btn-info" href="employee_project.php?id='.$r[0].'">Go to project</a></td><td>'.$r[2].'</td></tr>';
	
	}

    $e.='</table>';


$sql_files = "SELECT files.title,files.type,files.id,files.name,activity.name,activity.activity_id FROM files INNER JOIN activity ON files.activity=activity.activity_id WHERE activity.employee=".$User_ID;
    

$result = mysql_query($sql_files);


if(!mysql_num_rows($result))
{

$files_table.='<tr><td style="text-align:center !important; width="100%">No files associated.</td></tr>';

}
else
{

$files_table='<table class="table"><tr><th>File name</th><th>Type</th><th class="hidden-xs">Activity</th><th class="hidden-xs">Go to activity</th><th>Download file</th></tr>';

}

while($r = mysql_fetch_array($result))
{

if(strpos($r[1],'image') !== false)
{

  $icon="fa-file-image-o";

}
else if(strpos($r[1],'zip') !== false)
{


$icon="fa-file-zip-o";

}
else if(strpos($r[1],'msword') !== false)
{


$icon="fa-file-word-o";

}
else if(strpos($r[1],'wordprocessing') !== false)
{


$icon="fa-file-word-o";

}
else if(strpos($r[1],'excel') !== false)
{

$icon="fa-file-excel-o";

}
else if(strpos($r[1],'spreadsheet') !== false)
{

$icon="fa-file-excel-o";

}
else if(strpos($r[1],'pdf') !== false)
{


$icon="fa-file-pdf-o";

}
else if(strpos($r[1],'powerpoint') !== false)
{


$icon="fa-file-powerpoint-o";

}
else if(strpos($r[1],'presentation') !== false)
{


$icon="fa-file-powerpoint-o";

}
else if(strpos($r[1],'text') !== false)
{


$icon="fa-file-text-o";

}
else if(strpos($r[1],'audio') !== false)
{


$icon="fa-file-audio-o";

}
else if(strpos($r[1],'video') !== false)
{


$icon="fa-file-video-o";

}
else
{

  $icon="fa-file-o";

}

$files_table.='<tr id="r'.$r[2].'"><td style="vertical-align:middle;">'.$r[0].'</td><td style="width:50px; vertical-align:middle;"><i class="fa '.$icon.' fa-2x"></i></td><td style="vertical-align:middle;" class="hidden-xs">'.$r[4].'</td><td style="width:80px;" class="hidden-xs"><a class="btn btn-info" href="list_activity.php?id='.$r[5].'">Go</a></td><td><a class="btn btn-primary" href="files/'.$r[3].'" target="_blank">Download</a></td></tr>';
}

$files_table.='</table>';
	
	
?>
                <!-- Main content -->
                <section class="content">
                
<?php include('count.php'); ?>        
                
<div class="row">

<div class="col-lg-6 col-md-12">
<div class="box"><div class="box-header"><i class="fa fa-file"></i><h3 class="box-title">My files</h3></div>
<div class="box-body">
<?php echo $files_table; ?>
</div>
</div>
</div>

<?php

if($Level==3) {

?>

<div class="col-md-6">
<div class="box"><div class="box-header"><i class="fa fa-folder-open"></i><h3 class="box-title">My active projects</h3></div>
<div class="box-body box-scroll">
<?php echo $e; ?>
</div>
</div>
</div>

<?php

}

?>


<?php

if($Level==1) {


echo '<div class="col-lg-6 col-md-12">
<div class="box"><div class="box-header"><i class="fa fa-check"></i><h3 class="box-title">Approve activities and events</h3></div>
<div class="box-body box-scroll">
'.$a.'
</div>
</div>
</div>';

}

?>

<?php

if($Level==2) {

?>

<script type="text/javascript">

$(document).ready(function($)
{

    $.ajax({
    url: 'crud.php?domain=project&action=e',
    data: 'employee=a' ,
    type: "POST",
    success: function(json) {
        
        var employees=JSON.parse(json);
        
        employees.Options.forEach(function(value) {
        $('#e').append('<option value="'+value.Value+'">'+value.DisplayText+'</option>');
        });
        
                
    }
   });


});


</script>


<form action="appointment.php" method="post">
<div class="col-lg-6 col-md-12">
<div class="box"><div class="box-header"><i class="fa fa-clock-o"></i><h3 class="box-title">Add a new appointment</h3></div>
<div class="box-body">
<label>Employee: </label><select name="e" id="e" class="form-control"></select>
<div style="margin:23px auto;">
<button type="submit" class="btn btn-info">Add appointment</button>
</div>
</div>
</div>
</div>
</form>

</div>


<?php

}

?>

</div>

<div class="row">

<div class="col-md-12">

<div class="box">
                                <div class="box-header ui-sortable-handle" style="cursor: move;">
                                    <div class="box-tools pull-left col-md-4">
                                            <a class="btn btn-default pull-left" href="javascript:week(<?php echo date("W")-1; ?>,<?php echo date("Y"); ?>)" id="slide_prev"><i class="fa fa-chevron-left"></i></a>
                                    </div>
                                   <h3 class="box-title col-md-4 box-center-kubed">Agenda view for week <span><?php echo date("W"); ?></span></h3>
                                   <div class="box-tools pull-right col-md-4">
                                            <a class="btn btn-default pull-right" href="javascript:week(<?php echo date("W")+1; ?>,<?php echo date("Y"); ?>)" id="slide_next"><i class="fa fa-chevron-right"></i></a>
                                    </div>

                                </div>
                                </div>
                                
                                
</div> <!-- end 12 col -->
</div> <!-- end row -->

<div class="row" id="dash_content">

<?php

include('dash.php');

?>

</div>

<div class="row">
<div class="col-md-12">
                            <div class="box">
                                <div class="box-body no-padding">
                                    <!-- THE CALENDAR -->
                                    <div id="calendar-main"></div>
                                </div><!-- /.box-body -->
                            </div><!-- /. box -->

</div> <!-- end col 12 -->
</div> <!-- end row -->
        
		<script>
		
		$('#calendar3').datepicker()
    .on('changeDate', function(e){
   
   	   alert(e.date);
   	   
    });
    
    
    function calendar(activity_id,employee,activity_name)
{
$('#activity_container').css("background-color","#fff;");
$('#bc').html('<div class="button"><a href="javascript:finish('+activity_id+',\''+activity_name+'\')">SAVE CURRENT ACTIVITY</a></div>');
//$('#bc').html('<a href="javascript:finish('+activity_id+',\''+activity_name+'\')"><button type="button" id="new">FINISH</button></a>');
$('#bc').show();
//$('#new').button();
$('#activity_container').html('<div id="calendar"></div>');
  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();
  
  
    $.ajax({
    url: 'ajax.php?action=get_working',
    data: 'employee='+ employee ,
    type: "POST",
    success: function(result) {
    
    
    
    
var wd = [];

if(result[6]=="0")
wd.push(0);

for(br=0;br<6;br++)
{
if(result[br]=="0")
wd.push(br+1);
} 
  
  var calendar = $('#calendar-main').fullCalendar({
   editable: true,
   hiddenDays: wd,
   allDaySlot: true,
   height: 450,
   header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
   },
   
   events: "ajax.php?action=list_dashboard&activity="+activity_id+"&employee="+employee,
   
   eventRender: function(event, element, view) {

   },
   selectable: true,
   selectHelper: true,
   select: function(start, end, allDay) {

   if (activity_name) {
   
   var title = prompt('Please enter Title of an Event:');
   var startf = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
   var endf = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
   if(title)
   {
   if(allDay)
   ad=1;
   else
   ad=0
   $.ajax({
   url: 'ajax.php?action=add_fevent',
   data: 'title='+ title.replace(/[|&;$%@"<>+,]/g, "")+'&start='+ startf +'&end='+ endf +'&employee='+employee+"&allday="+ad,
   type: "POST",
   success: function(json) {
      calendar.fullCalendar('renderEvent',
   {
   id: json,
   title: title,
   start: start,
   end: end,
   allDay: allDay
   },
   true
   );
   }
   });
   }

   }
   calendar.fullCalendar('unselect');
   },
   
   editable: true,
   eventDrop: function(event, delta) {
   var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
   url: 'ajax.php?action=update_fevent',
   data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id + '&activity='+ activity_id,
   type: "POST",
   success: function(json) {
   }
   });
   },
   eventResize: function(event) {
   var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
    url: 'ajax.php?action=update_fevent',
    data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id+ '&activity='+ activity_id ,
    type: "POST",
    success: function(json) {
    }
   });

},
    eventClick: function(calEvent, jsEvent, view) {
    
    if(calEvent.color=='#f39c12')
    alert("This is an appointment");    
    
    
    if(calEvent.done!=1)
    {
		var choose = confirm('Do you want to mark this event as finished?');
		
		if(choose)
		{
		t=$(this);


   $.ajax({
    url: 'ajax.php?action=mark_event_done',
    data: 'id='+calEvent.id,
    type: "POST",
    success: function(json) {
		t.css('background-color', '#ff8971');
        t.css('border-color', '#ff8971');
    }
   });


		}
		}
		
		
		if(calEvent.color=='#41d8ff' || calEvent.color=='#00c0ef')
		{
		var choose2 = confirm('Do you want to delete this free event?');
		
		if(choose2)
		{
		t2=$(this);


   $.ajax({
    url: 'ajax.php?action=delete_event',
    data: 'id='+calEvent.id,
    type: "POST",
    success: function(json) {
    
    $('#calendar').fullCalendar('removeEvents',calEvent.id);
    }
   });


		}
		
		}
		
		
    }
   
  });






    }
   });
  




}

calendar(1,<?php echo $User_ID; ?>,"a");

function getWeeksOfYear(year)
 {
   var firstDayOfYear = new Date(year, 0, 1);
   var days = firstDayOfYear.getDay() + (isLeapYear(year) ? 366 : 365);

   return Math.ceil(days/7)
}

function isLeapYear(year)
{
   return (year % 4 === 0) && (year % 100 !== 0) || (year % 400 === 0);
}


function week(w,y)
{


    if(w>0)
    {
    ww=w-1;
    yy=y;
    }
    else
    {
	yy=y-1;    
	ww=getWeeksOfYear(yy);
	w=ww;
	y=yy;
	ww--;
    }
    
    
    if(w>getWeeksOfYear(y))
    {
    www=01;
    yyy=y+1;
    w=www;
    y=yyy;
    www++;
    }
    else
    {
	www=w+1;    
	yyy=y;
    }
    
    if(w<10)
    wm='0'+w;
    else
    wm=w;
    
   $.ajax({
   url: 'dash.php',
   data: 'w='+wm+'&y='+y,
   type: "POST",
   success: function(json) {
    $('#dash_content').html(json);
    

    

    $('#slide_prev').attr('href', 'javascript:week('+ww+','+yy+')');
    $('#slide_next').attr('href', 'javascript:week('+www+','+yyy+')');
    $('.box-title span').html(wm);
    
        $('.scroll').slimScroll({
        height: '120px',
            color: '#ccc',
    alwaysVisible: true
    });
   }
   });
   
   id="<?php echo $User_ID; ?>";
   
      $.ajax({
   url: 'count.php',
   data: 'w='+wm+'&y='+y+"&id="+id,
   type: "POST",
   success: function(json) {
    $('.articles_list').html(json);
   }
   });
   
}


    
		
		</script>
<?php

include('footer.php');

?>

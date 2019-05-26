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

include('sc.php');



$sql = "SELECT * FROM files WHERE activity=".$gets['id'];
    
$result = mysql_query($sql);
  
$files_table='<table class="table">';

if(!mysql_num_rows($result))
{

$files_table.='<tr><td style="text-align:center;">No files associated.</td></tr>';

}

while($r = mysql_fetch_array($result))
{

if(strpos($r['type'],'image') !== false)
{

  $icon="fa-file-image-o";

}
else if(strpos($r['type'],'zip') !== false)
{


$icon="fa-file-zip-o";

}
else if(strpos($r['type'],'msword') !== false)
{


$icon="fa-file-word-o";

}
else if(strpos($r['type'],'wordprocessing') !== false)
{


$icon="fa-file-word-o";

}
else if(strpos($r['type'],'excel') !== false)
{


$icon="fa-file-excel-o";

}
else if(strpos($r['type'],'spreadsheet') !== false)
{

$icon="fa-file-excel-o";

}
else if(strpos($r['type'],'pdf') !== false)
{


$icon="fa-file-pdf-o";

}
else if(strpos($r['type'],'powerpoint') !== false)
{


$icon="fa-file-powerpoint-o";

}
else if(strpos($r['type'],'presentation') !== false)
{


$icon="fa-file-powerpoint-o";

}
else if(strpos($r['type'],'text') !== false)
{


$icon="fa-file-text-o";

}
else if(strpos($r['type'],'audio') !== false)
{


$icon="fa-file-audio-o";

}
else if(strpos($r['type'],'video') !== false)
{


$icon="fa-file-video-o";

}
else
{

  $icon="fa-file-o";

}

$files_table.='<tr id="r'.$r['id'].'"><td style="vertical-align:middle;">'.$r['title'].'</td><td style="width:80px; vertical-align:middle;"><i class="fa '.$icon.' fa-2x"></i></td><td style="width:80px;"><a class="btn btn-primary" href="files/'.$r['name'].'" target="_blank">Download</a></td><td style="width:80px;"><a class="btn btn-danger" href="javascript:delete_file('.$r['id'].');">Delete</a></td></tr>';
}

$files_table.='</table>';


$sql = "SELECT user.fname,user.lname FROM user INNER JOIN activity ON user.user_id=activity.employee WHERE activity.activity_id=".$gets['id'];
    
$result = mysql_query($sql);

$info=mysql_fetch_array($result);


$sql = "SELECT COUNT(id) FROM event INNER JOIN activity ON event.activity=activity.activity_id WHERE activity.activity_id=".$gets['id'];
    
$result = mysql_query($sql);

$info_event=mysql_fetch_array($result);

  
$info_table='<table class="table"><tr><td>ASSIGNED TO</td><td>'.$info[0].' '.$info[1].'</td></tr><tr><td>TOTAL EVENTS</td><td>'.$info_event[0].'</td></tr></table>';

?>


<script type="text/javascript">

function delete_file(id) {

   $.ajax({
    url: 'delete_file.php',
    data: 'id='+ id,
    type: "GET",
    success: function(json) {
    $('#r'+id).hide();
    }
   });  
  
  
}


function calendar(activity_id,employee,activity_name)
{
  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();
  
  
    $.ajax({
    url: 'ajax.php?action=get_working',
    data: 'employee='+ employee ,
    type: "POST",
    success: function(json) {
    

  
  var calendar = $('#calendar').fullCalendar({
   editable: true,
   allDaySlot: true,
   height: 450,
   header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
   },
   
   events: "ajax.php?action=list_activity&activity="+activity_id+"&employee="+employee,

   eventRender: function(event, element, view) {
    if (event.allDay === 'true') {
     event.allDay = true;
    } else {
     event.allDay = false;
    }
   },
   selectable: true,
   selectHelper: true,
   select: function(start, end, allDay) {
   if(allDay==true)
   {
	   return false;
   }

   var start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
   url: 'ajax.php?action=add_event',
   data: 'title='+ activity_name+'&start='+ start +'&end='+ end + '&activity='+ activity_id,
   type: "POST",
   success: function(json) {
      calendar.fullCalendar('renderEvent',
   {
   id: json,
   title: activity_name,
   start: start,
   end: end,
   allDay: allDay
   },
   true
   );
   }
   });

   
   calendar.fullCalendar('unselect');
   },
   
   editable: true,
   eventDrop: function(event, delta) {
   var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
   url: 'ajax.php?action=update_event',
   data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id + '&activity='+ activity_id,
   type: "POST",
   success: function(json) {
    alert("Updated Successfully");
   }
   });
   },
   eventClick: function(event, delta) {
   alert(event.title);
   },
   eventResize: function(event) {
   alert(event.title);
   alert(event.id);
   var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
    url: 'ajax.php?action=update_event',
    data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id+ '&activity='+ activity_id ,
    type: "POST",
    success: function(json) {
     alert("Updated Successfully");
    }
   });

}
   
  });






    }
   });
  




}
<?php
$sql="SELECT name FROM activity WHERE activity_id=".$gets['id'];

$result=mysql_query($sql);

$row = mysql_fetch_array($result);
echo 'calendar('.$gets['id'].',1,"'.$row[0].'");';
?>

</script>

<section class="content">
<div class="row">


<div class="col-md-6">
<div class="box"><div class="box-header"><i class="fa fa-gears"></i><h3 class="box-title">Basic info</h3></div><div class="box-body">
<?php echo $info_table; ?>
</div>
</div>
</div>


<div class="col-md-6">
<div class="box"><div class="box-header"><i class="fa fa-file"></i><h3 class="box-title">Associated files</h3></div>
<div class="box-body">
<?php echo $files_table; ?>
</div>
</div>
</div>


<div class="col-md-12">
<div class="box"><div class="box-header"><i class="fa fa-cog"></i><h3 class="box-title">Activity view</h3></div>
<div class="box-body">
<div id="calendar"></div>
</div>
</div>
</div>

</div>

<?
	
}

include('footer.php');

?>
<?
 
include('check.php');
check_login('2');

if(!isset($included))
include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

include('header.php');

if(isset($posts['e']))
{

$sql="SELECT fname,lname FROM user WHERE user_id=".$posts['e'];

$result=mysql_query($sql);

$row = mysql_fetch_array($result);

$fn=$row[0]." ".$row[1];


include('sc.php');

?>


<script type="text/javascript">


function calendar(activity_id,employee,activity_name)
{
var ad=0;
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
   defaultView: 'agendaWeek',
   allDaySlot: true	,
   height: 450,
   header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
   },
   
   events: "ajax.php?action=list_appointment&employee="+employee,
   
   // Convert the allDay from string to boolean
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

   var start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
   
   var title = prompt('Description of an Appointment:');
   var place = prompt('Place:');
   var phone = prompt('Phone Number:');
   if(title)
   {
   
   if(allDay)
   ad=1;
   else
   ad=0;
   
   $.ajax({
   url: 'ajax.php?action=add_appointment',
   data: 'title='+title+'&start='+ start +'&end='+ end + '&employee='+ employee +'&place='+ place +'&phone='+ phone+'&allday='+ ad,
   type: "POST",
   success: function(json) {
      calendar.fullCalendar('renderEvent',
   {
   id: json,
   title: title,
   start: start,
   end: end,
   allDay: allDay,
   editable:true
   },
   true // make the event "stick"
   );
   }
   });
   }
   
   calendar.fullCalendar('unselect');
   },
   
   editable: true,
   
   eventDrop: function(event, delta) {
   var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
   
      
   if(event.allDay)
   ad=1;
   else
   ad=0;
   
   $.ajax({
   url: 'ajax.php?action=update_appointment',
   data: 'start='+ start +'&end='+ end + '&allday='+ ad+'&id='+ event.id,
   type: "POST",
   success: function(json) {
    //alert("Updated Successfully");
   }
   });
   },
   eventResize: function(event) {
   //alert(event.title);
   //alert(event.id);
   var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
   
   if(event.allDay)
   ad=1;
   else
   ad=0;
      
   $.ajax({
    url: 'ajax.php?action=update_appointment',
    data: 'start='+ start +'&end='+ end + '&allday='+ ad+'&id='+ event.id,
    type: "POST",
    success: function(json) {
     //updated
    }
   });

}   
  });






    }
   });
  




}

calendar(1,<?php echo $posts['e']; ?>,"null");
</script>

<section class="content">
<div class="row">


<div class="col-md-12">
<div class="box"><div class="box-header"><i class="fa fa-clock-o"></i><h3 class="box-title">Add an appointment for <?php echo $fn; ?></h3><div class="box-tools pull-right"><a class="btn btn-info" style="color:#fff !important;" href="dashboard.php">Finish</a></div></div><div class="box-body">
<div id="calendar"></div>
</div>
</div>
</div>

</div>

<?
	
}

include('footer.php');

?>
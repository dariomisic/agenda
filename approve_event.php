<?
 
include('check.php');
check_login('2');

if(!isset($included))
include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

include('header.php');

if(isset($gets['id']))
{

include('sc.php');

?>


<script type="text/javascript">


function calendar(activity_id,employee,activity_name)
{
$('#activity_container').css("background-color","#fff;");
$('#bc').html('<div class="button"><a href="javascript:finish('+activity_id+',\''+activity_name+'\')">SAVE CURRENT ACTIVITY</a></div>');
$('#bc').show();
$('#activity_container').html('<div id="calendar"></div>');
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
   allDaySlot: false,
   height: 450,
   header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
   },
   
   events: "ajax.php?action=list_event_approve&event="+activity_id+"&employee="+employee,
   
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

   if (activity_name) {
   var start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
   url: 'ajax2.php?action=add_event',
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

   }
   calendar.fullCalendar('unselect');
   },
   
   editable: true,
   eventDrop: function(event, delta) {
   var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
   url: 'ajax2.php?action=update_event',
   data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id + '&activity='+ activity_id,
   type: "POST",
   success: function(json) {
    alert("Updated Successfully");
   }
   });
   },
   eventResize: function(event) {
   alert(event.title);
   alert(event.id);
   var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
    url: 'ajax2.php?action=update_event',
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

calendar(<?php echo $gets['id']; ?>,1,0);
</script>

<section class="content">
<div class="row">
<div class="col-md-12">
<div class="box"><div class="box-header"><i class="fa fa-cog"></i><h3 class="box-title">Event view</h3><div class="box-tools pull-right"><a class="btn btn-info" style="color:#fff !important;" href="approve.php?event=1&id=<?php echo $gets['id']; ?>">Approve</a></div></div>
<div class="box-body">
<div id="calendar"></div>
</div>
</div>
</div>
</div>
</div>

<?
	
}

include('footer.php');

?>
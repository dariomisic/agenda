<?
 
include('check.php');
check_login('2');

include('header.php');

include('sc.php');


?>


<script type="text/javascript">


function calendar()
{
var ad=0;
  var date = new Date();
  var d = date.getDate();
  var m = date.getMonth();
  var y = date.getFullYear();
  
  employee=1;
  
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
   
   events: "ajax.php?action=list_appointments",
   
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
   }
   });
   },
   eventResize: function(event) {
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
    }
   });

},
eventClick: function(calEvent, jsEvent, view) {

		var choose2 = confirm('Do you want to delete this appointment?');
		
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

 
  });






    }
   });
  




}

calendar();
</script>

<section class="content">
<div class="row">


<div class="col-md-8">
<div class="box"><div class="box-header"><i class="fa fa-clock-o"></i><h3 class="box-title">Manage appointments</h3></div><div class="box-body">
<div id="calendar"></div>
</div>
</div>
</div>

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
<div class="col-md-4">
<div class="box"><div class="box-header"><i class="fa fa-plus"></i><h3 class="box-title">Add a new appointment</h3></div>
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

<?

include('footer.php');

?>
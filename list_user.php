<?
 
include('check.php');
check_login('2');

include('header.php');

if(isset($_GET['id']))
{

if(!isset($_SESSION['username']))
	include('functions/functions.php');

	$posts = array_map("xss_clean",$posts);
	$gets = array_map("xss_clean",$gets);

    $sql = "SELECT user.fname,user.lname,user_levels.name,user.email,user.sex,user.birthdate,user.address,user.zip,user.residence,user.hphone,user.mphone,user.user_id,user.city,function.name,department.name,user.d_employment,user.hour_wage,tariff.name FROM user INNER JOIN user_levels ON user_levels.id=user.user_level INNER JOIN function ON user.function=function.function_id INNER JOIN department ON user.department=department.department_id INNER JOIN tariff ON user.tarrif=tariff.tariff_id WHERE user.user_id=".$gets['id'];
    
	$result = mysql_query($sql);
	
	$row = mysql_fetch_array($result);
	

	$content.='<tr><td style="width:40%;">NAME</td><td>'.$row[0].' '.$row[1].'</td></tr>';
	$content.='<tr><td>USER CODE</td><td>'.$row[11].$row[12].'</td></tr>';
	$content.='<tr><td>USER LEVEL</td><td>'.$row[2].'&nbsp</div></div>';
	$content.='<tr><td>E-MAIL</td><td>'.$row[3].'&nbsp</div></div>';
	$content.='<tr><td>GENDER</td><td>'.$row[4].'&nbsp</div></div>';
	$content.='<tr><td>DATE OF BIRTH</td><td>'.$row[5].'&nbsp</div></div>';
	$content.='<tr><td>ADDRESS</td><td>'.$row[6].'&nbsp</div></div>';
	$content.='<tr><td>POSTAL CODE</td><td>'.$row[7].'&nbsp</div></div>';
	$content.='<tr><td>RESIDENCE</td><td>'.$row[8].'&nbsp</div></div>';
	$content.='<tr><td>HOME PHONE</td><td>'.$row[9].'&nbsp</div></div>';
	$content.='<tr><td>MOBILE PHONE</td><td>'.$row[10].'&nbsp</div></div>';
	$content.='<tr><td>FUNCTION</td><td>'.$row[13].'&nbsp</div></div>';
	$content.='<tr><td>DEPARTMENT</td><td>'.$row[14].'&nbsp</div></div>';
	$content.='<tr><td>EMPLOY. DATE</td><td>'.$row[15].'&nbsp</div></div>';
	$content.='<tr><td>HOUR WAGE</td><td>'.$row[16].'&nbsp</div></div>';
	$content.='<tr><td>TARRIF</td><td>'.$row[17].'&nbsp</div></div>';
	
	
	$s='SELECT COUNT(project) FROM working_on_project WHERE user='.$gets['id'];
	
	
	$result = mysql_query($s);
	
	$r = mysql_fetch_array($result);
	
	$content.='<tr><td># PROJECTS</td><td>'.$r[0].'</td></tr>';
	
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
    

var wd = [];

if(!(json[6]=="1"))
wd.push(0);

for(br=0;br<6;br++)
{
if(!(json[br]=="1"))
wd.push(br+1);
} 
  
  var calendar = $('#calendar').fullCalendar({
   editable: true,
   defaultView: 'agendaWeek',
   hiddenDays: wd,
   allDaySlot: true,
   height: 450,
   header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay'
   },
   
   events: "ajax.php?action=list_user&activity="+activity_id+"&employee="+employee,
   
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
   url: 'hours.php?e='+<?php echo $gets['id']; ?>,
   data: 'w='+wm+'&y='+y,
   type: "POST",
   success: function(json) {
    $('#display_hours').html(json);

    $('#slide_prev').attr('href', 'javascript:week('+ww+','+yy+')');
    $('#slide_next').attr('href', 'javascript:week('+www+','+yyy+')');
   // $('#contain3').html($('#contain3').html().replace(/Employee workload for week\s\d{2}/,'Employee workload for week '+wm));

   $('.box-title span').html(wm);
    
        $('.scroll').slimScroll({
        height: '120px',
            color: '#ccc',
    alwaysVisible: true
    });
   }
   });
}

function week_stat(w,y)
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
    
    
    ww-=19;
    www+=19;
   $.ajax({
   url: 'hours.php?domain=statistics&e='+<?php echo $gets['id']; ?>,
   data: 'w='+wm+'&y='+y,
   type: "POST",
   dataType: "json",
   success: function(json) {
	
    $('#slide_prev_stat').attr('href', 'javascript:week_stat('+ww+','+yy+')');
    $('#slide_next_stat').attr('href', 'javascript:week_stat('+www+','+yyy+')');
    
    
    
		var options = {
			lines: {
				show: true
			},
			points: {
				show: true
			},
    xaxis: {
        tickSize: 1,
        mode: "categories"
    }
		};
		
		data = [ json ];

$.plot('#bar', data, options);
    
   }
   });
}

function week_stat2(w,y)
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
    
    
    ww-=19;
    www+=19;
   $.ajax({
   url: 'hours.php?domain=statistics2&e='+<?php echo $gets['id']; ?>,
   data: 'w='+wm+'&y='+y,
   type: "POST",
   dataType: "json",
   success: function(json) {
	
    $('#slide_prev_stat2').attr('href', 'javascript:week_stat2('+ww+','+yy+')');
    $('#slide_next_stat2').attr('href', 'javascript:week_stat2('+www+','+yyy+')');
    
    
    
		var options = {
			lines: {
				show: true
			},
			points: {
				show: true
			},
    xaxis: {
        tickSize: 1,
        mode: "categories"
    }
		};
		
		data = [ json ];

$.plot('#bar2', data, options);
    
   }
   });
}

calendar(1,<?php echo $gets['id']; ?>,0);

week_stat(<?php echo date("W").",".date("Y"); ?>);
week_stat2(<?php echo date("W").",".date("Y"); ?>);
</script>

<section class="content">
<div class="row">
<div class="col-md-4">
<div class="box"><div class="box-header"><i class="fa fa-user"></i><h3 class="box-title">User info</h3></div><div class="box-body"><table class="table">
<?php echo $content; ?>
</table></div></div></div>

<div class="col-md-8">
<div class="box"><div class="box-header"><i class="fa fa-cogs"></i><h3 class="box-title">Employee workload for week <span><?php echo date("W"); ?></span></h3><div class="box-tools pull-right"><div id="contain3"><a href="javascript:week(<?php echo date("W")-1; ?>,<?php echo date("Y"); ?>)" id="slide_prev"><button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button></a><a href="javascript:week(<?php echo date("W")+1; ?>,<?php echo date("Y"); ?>)" id="slide_next"><button class="btn btn-default btn-sm" title=""><i class="fa fa-chevron-right"></i></button></a></div></div></div><div class="box-body"><div id="display_hours" style="text-align:center; font-size:60px;">
<?php $employee=$gets['id']; include('hours.php'); ?>
</div></div></div></div>


<div class="col-md-8">
<div class="box"><div class="box-header"><i class="fa fa-bar-chart"></i><h3 class="box-title">Employee finished effectiveness</h3><div class="box-tools pull-right"><div id="contain3"><a href="javascript:week(<?php echo date("W")-1; ?>,<?php echo date("Y"); ?>)" id="slide_prev_stat"><button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button></a><a href="javascript:week(<?php echo date("W")+1; ?>,<?php echo date("Y"); ?>)" id="slide_next_stat"><button class="btn btn-default btn-sm" title=""><i class="fa fa-chevron-right"></i></button></a></div></div></div><div class="box-body"><div id="bar" style="height:230px;">
</div></div></div></div>

<div class="col-md-8">
<div class="box"><div class="box-header"><i class="fa fa-bar-chart"></i><h3 class="box-title">Employee unfinished effectiveness</h3><div class="box-tools pull-right"><div id="contain3"><a href="javascript:week(<?php echo date("W")-1; ?>,<?php echo date("Y"); ?>)" id="slide_prev_stat2"><button class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button></a><a href="javascript:week(<?php echo date("W")+1; ?>,<?php echo date("Y"); ?>)" id="slide_next_stat2"><button class="btn btn-default btn-sm" title=""><i class="fa fa-chevron-right"></i></button></a></div></div></div><div class="box-body"><div id="bar2" style="height:230px;">
</div></div></div></div>

</div>

<div class="row">
<div class="col-md-12">
<div class="box"><div class="box-header"><i class="fa fa-calendar"></i><h3 class="box-title">Employee calendar</h3></div><div class="box-body">
<div id="calendar"></div>
</div>
</div>
</div>
</div>

<?
	
}

include('footer.php');

?>
<?
 
include('check.php');
check_login('3');

include('header.php');



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
		//echo $row[0]."---".($row[1]+1)."<br>";
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


if(isset($_GET['id']))
{

if(!isset($included))
include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

    
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

$pie[]=$se;

}

$f['finished']=get_finished($gets['id'],1);
$f['unfinished']=get_finished($gets['id'],0);

$total = array_sum($f);
if($total)
{
foreach($f as &$hits) {
   $hits = round($hits / $total * 100, 1);
}
}

$sequence['label']="FINISHED";
$sequence['data']=$f['finished'];
$sequence['color']="#86D5A1";

$pie2[]=$sequence;

$sequence['label']="UNFINISHED";
$sequence['data']=$f['unfinished'];
$sequence['color']="#FF7878";

$pie2[]=$sequence;
    
    
    $sql = "SELECT project.name,project.type,client.name,project.price,user.fname,user.lname,project.start,project.end,project.status FROM project INNER JOIN client ON project.client=client.client_id INNER JOIN user ON project.manager=user.user_id WHERE project_id=".$gets['id'];
    
	$result = mysql_query($sql);
	
	$row = mysql_fetch_array($result);
	
	//echo $row[8];
	if($row[8]=="1")
	$status="ACTIVE";
	else
	$status="FINISHED";

	$content.='<tr><td>PROJECT NAME</td><td>'.$row[0].'</td></tr>';
	$content.='<tr><td>PROJECT TYPE</td><td>'.$row[1].'</td></tr>';
	$content.='<tr><td>CLIENT</td><td>'.$row[2].'</td></tr>';
	if($Level==1)
	$content.='<tr><td>PRICE</td><td>'.$row[3].'</td></tr>';
	$content.='<tr><td>MANAGER</td><td>'.$row[4].' '.$row[5].'</td></tr>';
	$content.='<tr><td>START</td><td>'.$row[6].'</td></tr>';
	$content.='<tr><td>END</td><td>'.$row[7].'</td></tr>';
	$content.='<tr><td>STATUS</td><td>'.$status.'</td></tr>';
	
	
	
	    
    $sql = "SELECT activity_id,name from activity WHERE project=".$gets['id'];
    
	$result = mysql_query($sql);
	
	$a='<table class="table table-activity" style="max-height:428px !important;">';
	while($r = mysql_fetch_array($result))
	{
	if($Level<3)
	$a.='<tr id="r'.$r[0].'"><td style="line-height:34px;">'.$r[1].'</td><td style="width:125px;"><a id="aaaa" class="btn btn-info" href="javascript:add_file(\''.$r[0].'\');">Upload Files</a></td><td style="width:80px;"><a id="aa" class="btn btn-primary" href="list_activity.php?id='.$r[0].'">View</a></td><td style="width:80px;"><a class="btn btn-danger" href="javascript:delete_activity('.$r[0].');">Delete</a></td></tr>';
	else
	$a.='<tr id="r'.$r[0].'"><td>'.$r[1].'</td></tr>';
	}
	
	$a.="</table>";


if($Level<=2)
{
$add_new='<div class="box-tools pull-right"><a class="btn btn-success" style="color:#fff !important;" href="javascript:add('.$gets['id'].');">Add new</a></div>';
}
else
{
$add_new='';
}

include('sc.php');
	
?>

<script type="text/javascript">

function upload_close() {

  $('#activity_container').hide();

}

function delete_activity(id) {

   $.ajax({
    url: 'ajax.php?action=delete_activity',
    data: 'id='+ id,
    type: "POST",
    success: function(json) {
    $('#r'+id).hide();
    }
   });	
	
	
	
}

global_id=0;
flag=0;


function finish(activity,name)
{
$('#bc').html('<a href="javascript:add('+global_id+')" class="btn btn-success">Add new activity</a><a href="project.php" class="btn btn-danger" style="margin-left:10px;">Finish project entry</a>');
$('#activity_container').hide();


$('#add').html('');

$('#add').hide();

$('.table-activity').append('<tr id="r'+activity+'"><td style="line-height:34px;">'+name+'</td><td style="width:125px;"><a id="aaaa" class="btn btn-info" href="javascript:add_file(\''+activity+'\');">Upload Files</a></td><td style="width:80px;"><a id="aa" class="btn btn-primary" href="list_activity.php?id='+activity+'">View</a></td><td style="width:80px;"><a class="btn btn-danger" href="javascript:delete_activity('+activity+');">Delete</a></td></tr>');
}

function calendar(activity_id,employee,activity_name)
{
$('#activity_container').css("background-color","#fff;");
$('#add').html('<a href="javascript:finish('+activity_id+',\''+activity_name+'\')" class="btn btn-success">Save current activity</a>');
$('#add').show();
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
   
   events: "ajax.php?action=list_event&activity="+activity_id+"&employee="+employee,
   
   eventRender: function(event, element, view) {
   },
   selectable: true,
   selectHelper: true,
   select: function(start, end, allDay) {


if(allDay)
allday=1;
else
allday=0;

   if (activity_name) {
   var start = $.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
   url: 'ajax.php?action=add_event',
   data: 'title='+ activity_name+'&start='+ start +'&end='+ end + '&activity='+ activity_id+"&allday="+allday,
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
   
   
if(event.allDay)
allday=1;
else
allday=0;

   var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
   url: 'ajax.php?action=update_event',
   data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id + '&activity='+ activity_id + '&allday='+ allday,
   type: "POST",
   success: function(json) {
    alert("Updated Successfully");
   }
   });
   },
   eventResize: function(event) {
   
if(event.allDay)
allday=1;
else
allday=0;

   var start = $.fullCalendar.formatDate(event.start, "yyyy-MM-dd HH:mm:ss");
   var end = $.fullCalendar.formatDate(event.end, "yyyy-MM-dd HH:mm:ss");
   $.ajax({
    url: 'ajax.php?action=update_event',
    data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&id='+ event.id+ '&activity='+ activity_id + '&allday='+ allday,
    type: "POST",
    success: function(json) {
     alert("Updated Successfully");
    }
   });

},
    eventClick: function(calEvent, jsEvent, view) {
    
    if(!calEvent.color)
    {
		var choose = confirm('Are you sure you want to delete this event?');
		
		if(choose)
		{
		t=$(this);


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


function vc(status, form, json, options){
			if (status === true) {
				form.validationEngine('detach');
				
	var postData = $('#ajaxform').serializeArray();
    var formURL = $('#ajaxform').attr("action");
    $.ajax(
    {
        url : formURL,
        type: "POST",
        data : postData,
        success:function(data, textStatus, jqXHR) 
        {
         if(data!="error")
         {
	     employee=0;
	     activity_name="undefined";
	         jQuery.each(postData, function( i, field ) {
				 if(field.name=="e")
				 employee=field.value;
				 if(field.name=="n")
				 activity_name=field.value;
	  		});
	     calendar(data,employee,activity_name);
	    $('#calendar').delay(800).fullCalendar( 'changeView', 'agendaWeek' );
      $('body').scrollTo('#add',{duration:'300', offsetTop : '10'});
	             }
         else
         {
	         
	     alert("error");  
	         
         }

        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
        alert("e");      
        }
    });
			}
		}
		


$.fn.scrollTo = function( target, options, callback ){
  if(typeof options == 'function' && arguments.length == 2){ callback = options; options = target; }
  var settings = $.extend({
    scrollTarget  : target,
    offsetTop     : 50,
    duration      : 500,
    easing        : 'swing'
  }, options);
  return this.each(function(){
    var scrollPane = $(this);
    var scrollTarget = (typeof settings.scrollTarget == "number") ? settings.scrollTarget : $(settings.scrollTarget);
    var scrollY = (typeof scrollTarget == "number") ? scrollTarget : scrollTarget.offset().top + scrollPane.scrollTop() - parseInt(settings.offsetTop);
    scrollPane.animate({scrollTop : scrollY }, parseInt(settings.duration), settings.easing, function(){
      if (typeof callback == 'function') { callback.call(this); }
    });
  });
}



function add_file(id) {

$('#bc').hide();

$('#activity_container').html('<div class="box box-info"><div class="box-header"><i class="fa fa-file"></i><h3 class="box-title">Upload a new file</h3><div class="box-tools pull-right"><a class="btn btn-info" style="color:#fff !important;" href="javascript:upload_close();">Close</a></div></div><div class="box-body"><div class="progress"><div class="progress-bar progress-bar-aqua" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div></div><form id="fileuploadform" action="upload.php" method="POST" enctype="multipart/form-data"><input class="form-control" type="text" name="title" value="File title" style="margin-bottom:30px;"><input type="hidden" name="activity" value="'+id+'"><input id="fileupload" style="margin: 0 auto; line-height:0px;" type="file" name="files[]" data-url="upload.php" multiple></form></div></div>');
$('#activity_container').show();

$('body').scrollTo('#activity_container',{duration:'600', offsetTop : '30'});

$('#fileuploadform').fileupload({
    url: 'upload.php',
        progressall: function (e, data) {
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('.progress-bar').css(
            'width',
            progress + '%'
        );
    }
}).bind('fileuploaddone', function (e, data) {

$('#activity_container').append('<div class="alert alert-info alert-dismissable"><i class="fa fa-info"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>File <b>'+data.files[0].name+'</b> uploaded. You can see it in its <b><a href="list_activity.php?id='+id+'">respective activity</a></b>.');

$('body').scrollTo('.alert',{duration:'600', offsetTop : '0'});

});
}


function add(project_id) {

//$('#activity_container').css("background-color","#48B2DF;");

$('#bc').hide();

$('#activity_container').html('<div class="box box-success"><div class="box-header"><i class="fa fa-cog"></i><h3 class="box-title">Define an activity</h3></div><div class="box-body"><form name="ajaxform" id="ajaxform" action="ajax.php?action=add_action" method="POST"><div class="form-group"><label for="n">Name</label><input type="text" class="form-control validate[required,maxSize[250]]" name="n"/></div><div class="form-group"><label for="d">Description</label><textarea class="form-control" rows="4" cols="50" name="d" id="d" value=""></textarea></div><div class="form-group"><label for="h">Hours</label><input class="form-control" type="text" name="h" value=""/></div><div class="form-group"><label for="t">Tarrif</label><select class="form-control" name="t" id="tt" ></select></div><div class="form-group"><label for="s">Status</label><select class="form-control" name="s" id="s" ><option value="1">Active</option><option value="0">Finished</option></select></div><div class="form-group"><label for="e">Employee</label><select class="form-control" name="e" id="e" ></select></div><div class="form-group"><label for="dependent">Depends on</label><select class="form-control" name="dependent" id="dependent" ><option value="0">None</option></select></div><input type="submit" class="bbb btn btn-success" value="Next" id="next"></form></div></div>');
$('#activity_container').show();

$('body').scrollTo('#activity_container',{duration:'600', offsetTop : '30'});

/*	
	$('#ajaxform label').css("display","inline-block").css("width","150px").css("text-align","right").css("margin","10px").css("color","#fff").css("font-size","14px");

	$('#ajaxform input').css("border","0").css("font-size","14px").css("padding","6px");
	$('#ajaxform textarea').css("border","0").css("font-size","14px").css("padding","6px");
	$('#ajaxform select').css("font-size","14px").css("padding","6px").css("height","20px");

*/

	$('#ajaxform').append('<input type="hidden" name="project_id" value="'+project_id+'">');

	$.ajax({
        url: "crud.php?domain=user&action=dependent&project="+project_id,
        success: function(data) {
        var row_dependent=jQuery.parseJSON(data);
            $.each(row_dependent.Options, function (index, value) {
            
			$('#dependent').append('<option value="'+value.Value+'">'+value.DisplayText+'</option>');
			
			});

        }
    });

	$.ajax({
        url: "crud.php?domain=user&action=tarrif",
        success: function(data) {
        var row_tarrif=jQuery.parseJSON(data);
            $.each(row_tarrif.Options, function (index, value) {
            
			$('#tt').append('<option value="'+value.Value+'">'+value.DisplayText+'</option>');
			
			});

        }
    });
    $.ajax({
        url: "crud.php?action=e&domain=project",
        success: function(data) {
        var row_employee=jQuery.parseJSON(data);
        
            $.each(row_employee.Options, function (index, value) {
            
			$('#e').append('<option value="'+value.Value+'">'+value.DisplayText+'</option>');
			
			});
        }
    });

	
	  	$('#ajaxform').validationEngine({
				ajaxFormValidation: true,
				ajaxFormValidationMethod: 'get',
				onAjaxFormComplete: vc
			});
	
	
}

		function ajaxValidationCallback(status, form, json, options){
			if (window.console) 
			console.log(status);
                
			if (status === true) {
				alert("the form is valid!");
				
			}
			else
			{
				alert("invalid");
			}
		}

$(document).ready(function () {
        $('#UserTableContainer').jtable({
            title: 'Project Directory',
            paging: true,
            pageSize: 10,
            sorting: true,
            defaultSorting: 'status DESC,end DESC',
            actions: {
                listAction:'crud.php?action=list&domain=project'<?php
                if($Level<3) echo',
                createAction: \'crud.php?action=create&domain=project\',
                updateAction: \'crud.php?action=update&domain=project\',
                deleteAction: \'crud.php?action=delete&domain=project\'';
                ?>
            }, 
            fields: {
                project_id: {
                  title: 'Project ID',
                    key: true,
                    create:false,
                    list: false,
                    edit: false
                },
                name: {
                    title: 'Project Name',
                    create: true,
                    edit: true,
                    list: true,
                    inputClass: 'validate[required,maxSize[250]]'
                },
                description: {
                    title: 'Description',
                    type: 'textarea',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[maxSize[1500]]'
                },
                
               working: {
                    title: 'Working on project',
                    type: 'multiselectddl',
                    options: 'crud.php?action=employee&domain=project',    
                    create: true,
                    edit: true,
                    list: false
                },       
                         
               type: {
                    title: 'Type',
                    options: { 'external': 'External', 'internal': 'Internal' },
                    create: true,
                    edit: true,
                    list: false
                },
                
                
              client: {
                    title: 'Client',
                    options: 'crud.php?action=client&domain=project',
                    create: true,
                    edit: true,
                    list: true

                },
                
                price: {
                    title: 'Price(if applicable)',
                    create: true,
                    edit: false,
                    list: false,
                    inputClass: 'validate[custom[integer]]'
                },
                
                
                
        manager: {
                    title: 'Project manager',
                    options: 'crud.php?action=manager&domain=project',
                    create: true,
                    edit: true,
                    list: false

                },
                
        code: {
                    title: 'Project code',
                    create: true,
                    edit: false,
                    list: false,
                    sortable:false,
                    inputClass: 'validate[custom[integer]]'
                },
                
               start: {
                    title: 'Project start',
                    type: 'date',
          displayFormat: 'dd-mm-yy',
                    create: true,
                    edit: true,
                    width: '5%',
                    list: true,
                    inputClass: 'validate[required,custom[date]]'
                },
               
               end: {
                    title: 'Project deadline',
                    type: 'date',
          displayFormat: 'dd-mm-yy',
                    create: true,
                    edit: true,
                    width: '5%',
                    list: true,
                    inputClass: 'validate[required,custom[date]]'
                },
                
               status: {
                    title: 'Status',
                    options: { '1': 'Active', '0': 'Inactive' },
                    create: true,
                    width:'2%',
                    edit: true,
                    list: true
                },
                stat: {
                    title: '',
                    sorting: false,
                    edit: false,
                    create: false,
                    width:'2%',
                    display: function (data) {
                        var $img = $('<a href="list_project.php?id='+data.record.project_id+'"><button class="btn btn-primary">View</button></a>');

                        return $img;
                    }
                }
                

                
                
            },
            
            formCreated: function (event, data) {


              $('.selectpicker').selectpicker();
            
            
                
                var f=$(".selectpicker");

                f.css("width","350px");
        
        
       // $("#Edit-name").css("width","300px");
                            
                data.form.validationEngine({ 
                  binded: true
                }
                );
            },
            formSubmitting: function (event, data) {
                return data.form.validationEngine('validate');
            },
            recordAdded: function (event, data) {
                global_id=data.record.project_id;
                $('#add').append('<div id="bc" style="margin-bottom:30px;"><a href="javascript:add('+data.record.project_id+')"><button class="btn btn-success">Add new activity</button></a></div>');
                
                $('#t h3').html(data.record.name.toUpperCase());
                
                $('#UserTableContainer').hide();

                $('#add').show(300);
                
    $('body').scrollTo('#add',{duration:'600', offsetTop : '30'});
                
                
            },
            formClosed: function (event, data) {
                data.form.validationEngine('hide');
                data.form.validationEngine('detach');
            }
        });
        
        
        
        
                $('#LoadRecordsButton').click(function (e) {
            e.preventDefault();
            $('#UserTableContainer').jtable('load', {
                search: $('#search').val()
            });
        });
        $('#LoadRecordsButton').click();
        
        <?php
        
        if($Level==3)
        {
        echo '$(".jtable-toolbar-item-add-record").hide();';
        }
        
        ?>
        
    });
</script>

<section class="content">

<?php
if($Level<=2)
echo '

<div class="row">

<div class="col-md-6">
<div class="box"><div class="box-header"><i class="fa fa-bar-chart"></i><h3 class="box-title">Employee distribution in hours</h3></div><div class="box-body"><div id="pie" style="height:210px;">
</div></div></div></div>

<div class="col-md-6">
<div class="box"><div class="box-header"><i class="fa fa-pie-chart"></i><h3 class="box-title">Finished hours ratio</h3></div><div class="box-body"><div id="pie2" style="height:210px;">
</div></div></div></div>

</div>
';

?>

<div class="row">
<div class="col-md-6">
<div class="box"><div class="box-header"><i class="fa fa-folder-open"></i><h3 class="box-title">Project info</h3></div><div class="box-body"><table class="table">
<?php echo $content; ?>
</table></div></div></div>

<?php
if($Level<=2)
{
?>

<div class="col-md-6">
<div class="box"><div class="box-header"><i class="fa fa-cogs"></i><h3 class="box-title">Activities</h3><?php echo $add_new; ?></div><div class="box-body">
<?php echo $a; ?>
</div></div></div>

</div>

<?php

}

if($Level<3)
{

?>

<div class="row">
<div class="col-md-8 col-md-offset-2">
<div id="add" style="width:100%; margin-top:20px; text-align:center; display:none; height:60px;" class="column_right_grid date_events">
</div>
</div>
</div>

<div class="row">
<div class="col-md-8 col-md-offset-2">
<div id="activity_container" style="display:none;">
</div>
</div>
</div>

<script type="text/javascript">
        $('#scroll').slimScroll({
        height: '160px',
            color: '#ccc',
    alwaysVisible: true
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

var data = <?php echo json_encode($pie); ?>;

$.plot('#pie', data, options);

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

			$('#pie2').bind("plotclick", function(event, pos, obj) {

				if (!obj) {
					return;
				}

				percent = parseFloat(obj.series.percent).toFixed(2);
				alert(""  + obj.series.label + ": " + percent + "%");
			});

</script>

<?php

}

?>


<?
	
}

include('footer.php');

?>
<?
 
include('check.php');
check_login('3');

include('header.php');
?>
<section class="content">
<div class="row">
<div class="col-md-12">

    <form>

    <div class="input-group" style="margin-bottom:17px;">
                                        <input type="text" class="form-control search" id="search">
                                        <span class="input-group-btn">
                                            <button type="submit" id="LoadRecordsButton" class="btn btn-info btn-flat" type="button" style="width:150px;">Search</button>
                                        </span>
                                    </div>

    </form>

</div>
</div>

<div class="row">
<div class="col-md-12">

<div id="UserTableContainer"></div>

</div>
</div>


<div class="row">
<div class="col-md-8 col-md-offset-2">
<div id="add" style="width:100%; margin-top:20px; text-align:center; display:none;" class="column_right_grid date_events">
<div id="t" style="width:100%; text-align:center; margin-top:10px;"><h3 style="background-color:transparent !important;">mirza</h3></div>
<div id="activities" style="width:100%; margin-bottom:30px;"><i>Please add activities to the project</i></div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div id="activity_container" style="display:none;">
</div>
</div>

<?php include('sc.php'); ?>


<script type="text/javascript">

global_id=0;
flag=0;


function finish(activity,name)
{
$('#bc').html('<a href="javascript:add('+global_id+')" class="btn btn-success">Add new activity</a><a href="project.php" class="btn btn-danger" style="margin-left:10px;">Finish project entry</a>');
$('#activity_container').hide();

if(!flag)
{
$('#activities').html('<div class="box"><div class="box-header"><i class="fa fa-cogs"></i><h3 class="box-title">Existing activities in this project</h3><div class="box-body"><table class="table" id="table"></table>');
flag=1;
}
$('#table').append('<tr><td style="width:15px;">'+activity+'</td><td>'+name+'</td></tr>');
}

function calendar(activity_id,employee,activity_name)
{
$('#activity_container').css("background-color","#fff;");
$('#bc').html('<a href="javascript:finish('+activity_id+',\''+activity_name+'\')" class="btn btn-success">Save current activity</a>');
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
	    $('#calendar').fullCalendar( 'changeView', 'agendaWeek' );
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
		



function add(project_id) {

//$('#activity_container').css("background-color","#48B2DF;");

$('#bc').hide();

$('#activity_container').html('<div class="box box-success"><div class="box-header"><i class="fa fa-cog"></i><h3 class="box-title">Define an activity</h3></div><div class="box-body"><form name="ajaxform" id="ajaxform" action="ajax.php?action=add_action" method="POST"><div class="form-group"><label for="n">Name</label><input type="text" class="form-control validate[required,maxSize[250]]" name="n"/></div><div class="form-group"><label for="d">Description</label><textarea class="form-control" rows="4" cols="50" name="d" id="d" value=""></textarea></div><div class="form-group"><label for="h">Hours</label><input class="form-control" type="text" name="h" value=""/></div><div class="form-group"><label for="t">Tarrif</label><select class="form-control" name="t" id="tt" ></select></div><div class="form-group"><label for="s">Status</label><select class="form-control" name="s" id="s" ><option value="1">Active</option><option value="0">Finished</option></select></div><div class="form-group"><label for="e">Employee</label><select class="form-control" name="e" id="e" ></select></div><div class="form-group"><label for="dependent">Depends on</label><select class="form-control" name="dependent" id="dependent" ><option value="0">None</option></select></div><input type="submit" class="bbb btn btn-success" value="Next" id="next"></form></div></div>');
$('#activity_container').show();

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
	

		
//$('#next').css("margin-left","100px");



	
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
                    inputClass: 'validate[required,custom[date]]',
                    listClass:'hidden-xs'
                },
               
               end: {
                    title: 'Project deadline',
                    type: 'date',
					displayFormat: 'dd-mm-yy',
                    create: true,
                    edit: true,
                    width: '5%',
                    list: true,
                    inputClass: 'validate[required,custom[date]]',
                    listClass:'hidden-xs'
                },
                
               status: {
                    title: 'Status',
                    options: { '1': 'Active', '0': 'Inactive' },
                    create: true,
                    width:'2%',
                    edit: true,
                    list: true,
                    listClass:'hidden-xs'
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
                
                $('html, body').animate({
        scrollTop: $("#add").offset().top
    }, 500);
                
                
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

<?

include('footer.php');

?>
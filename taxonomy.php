<?

include('check.php');
check_login('3');


include('header.php');

include('sc.php');

?>
<section class="content">
<div class="row">
<div class="col-md-12">
<div id="FunctionTableContainer"></div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div id="CityTableContainer"></div>
</div>
</div>

<div class="row">
<div class="col-md-12">
<div id="DepartmentTableContainer"></div>
</div>
</div>

<script type="text/javascript">


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
        $('#FunctionTableContainer').jtable({
            title: 'Function list',
            actions: {
                listAction:'crud.php?action=list&domain=function'<?php
                if($Level<3) echo',
                createAction: \'crud.php?action=create&domain=function\',
                updateAction: \'crud.php?action=update&domain=function\'';
                ?>
            }, 
            fields: {
                function_id: {
                	title: 'Function ID',
                    key: true,
                    create:false,
                    list: true,
                    edit: false
                },
				name: {
                    title: 'Function Name',
                    create: true,
                    edit: true,
                    list: true,
                    inputClass: 'validate[required,maxSize[250]]'
                }
                
                
            },
            formCreated: function (event, data) {
                data.form.validationEngine({ 
	                binded: true
                }
                );
            },
            formSubmitting: function (event, data) {
                return data.form.validationEngine('validate');
            },
            formClosed: function (event, data) {
                data.form.validationEngine('hide');
                data.form.validationEngine('detach');
            }
        });
        
        
        $('#FunctionTableContainer').jtable('load');
    });
    
    
        $(document).ready(function () {
        $('#CityTableContainer').jtable({
            title: 'City list',
            actions: {
                listAction:'crud.php?action=list&domain=city'<?php
                if($Level<3) echo',
                createAction: \'crud.php?action=create&domain=city\',
                updateAction: \'crud.php?action=update&domain=city\'';
                ?>
            }, 
            fields: {
                city_id: {
                	title: 'City ID',
                    key: true,
                    create:false,
                    list: true,
                    edit: false
                },
				name: {
                    title: 'City Name',
                    create: true,
                    edit: true,
                    list: true,
                    inputClass: 'validate[required,maxSize[250]]'
                }
                
                
            },
            formCreated: function (event, data) {
                data.form.validationEngine({ 
	                binded: true
                }
                );
            },
            formSubmitting: function (event, data) {
                return data.form.validationEngine('validate');
            },
            formClosed: function (event, data) {
                data.form.validationEngine('hide');
                data.form.validationEngine('detach');
            }
        });
        
        
        $('#CityTableContainer').jtable('load');
    });
    
    
            $(document).ready(function () {
        $('#DepartmentTableContainer').jtable({
            title: 'Department list',
            actions: {
                listAction:'crud.php?action=list&domain=department'<?php
                if($Level<3) echo',
                createAction: \'crud.php?action=create&domain=department\',
                updateAction: \'crud.php?action=update&domain=department\'';
                ?>
            }, 
            fields: {
                department_id: {
                	title: 'Department ID',
                    key: true,
                    create:false,
                    list: true,
                    edit: false
                },
				name: {
                    title: 'Department Name',
                    create: true,
                    edit: true,
                    list: true,
                    inputClass: 'validate[required,maxSize[250]]'
                }
                
                
            },
            formCreated: function (event, data) {
                data.form.validationEngine({ 
	                binded: true
                }
                );
            },
            formSubmitting: function (event, data) {
                return data.form.validationEngine('validate');
            },
            formClosed: function (event, data) {
                data.form.validationEngine('hide');
                data.form.validationEngine('detach');
            }
        });
        
        
        $('#DepartmentTableContainer').jtable('load');
        
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
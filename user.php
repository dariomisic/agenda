<?

include('check.php');
check_login('2');


include('header.php');

?>
<section class="content">
<div class="row">
<div class="col-md-12">

<div id="UserTableContainer"></div>

</div>
</div>

<?php include('sc.php'); ?>

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
        $('#UserTableContainer').jtable({
            title: 'Users Directory',
            bootstrap3: true,
            bs3UseFormGroup: true,
            jqueryuiTheme: false,
            bs3UseFormGroup: true,
            actions: {
                listAction:'crud.php?action=list&domain=user',
                createAction: 'crud.php?action=create&domain=user'
                <?php if($Level==1) echo ',
                updateAction: \'crud.php?action=update&domain=user\',
                deleteAction: \'crud.php?action=delete&domain=user\''; ?>
            }, 
            fields: {
                user_id: {
                    key: true,
                    create:false,
                    list: false,
                    edit: false
                },
                concatenated_id: {
                	title: 'ID',
                    create:false,
                    edit:false,
                    width:'1%'
                },
                username: {
                    title: 'Create an Username',
                    create: true,
                    edit: false,
                    list: false,
                    inputClass: 'validate[required,maxSize[20],custom[onlyLetterNumber],ajax[ajaxUserCallPhp]]'
                },
                user_level: {
                    title: 'User Type',
                    options: { <?php if($Level==1) echo '\'3\': \'Employee\', \'2\': \'Manager\',\'1\': \'Admin\''; else echo '\'3\': \'Employee\''; ?> },
                    create: true,
                    edit: false,
                    list: false
                },
                
                fname: {
                    title: 'First Name',
                    create: true,
                    edit: true,
                    list: true,
                    inputClass: 'validate[required,maxSize[250]]'
                },
                lname: {
                    title: 'Last Name',
                    create: true,
                    edit: true,
                    list: true,
                    inputClass: 'validate[required,maxSize[250]]'
                }, 
                sex: {
                    title: 'Gender',
                    options: { 'F': 'Female', 'M': 'Male' },
                    create: true,
                    edit: true,
                    list: false
                }, 
                birthdate: {
                    title: 'Date of Birth',
                    type: 'date',
                    displayFormat: 'dd-mm-yy',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[required,custom[date]]'
                },   
                
               address: {
                    title: 'Address',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[required,maxSize[250]]'
                }, 
                
              zip: {
                    title: 'Postal Code',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[required,maxSize[10]]'
                },     
                
              residence: {
                    title: 'Residence',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[required,maxSize[250]]'
                }, 
                
                func: {
                    title: 'Function',
                    options: 'crud.php?action=function&domain=user',
                    create: true,
                    edit: true,
                    list: true,
                    listClass:'hidden-xs'

                },
               department: {
                    title: 'Department',
                    options: 'crud.php?action=department&domain=user',
                    create: true,
                    edit: true,
                    list: false

                },
              hphone: {
                    title: 'Home Phone',
                    create: true,
                    edit: true,
                    list: true,
                    inputClass: 'validate[required,maxSize[50]]',
                    listClass:'hidden-xs'
                }, 
                
               mphone: {
                    title: 'Mobile Phone',
                    create: true,
                    edit: true,
                    list: true,
                    inputClass: 'validate[required,maxSize[50]]',
                    listClass:'hidden-xs'
                },   
                
               email: {
                    title: 'E-mail',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[required,maxSize[250],custom[email]]'
                }, 
                
               d_employment: {
                    title: 'Date of Employment',
                    type: 'date',
					displayFormat: 'dd-mm-yy',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[required,custom[date]]'
                },
                
                
              d_service: {
                    title: 'Date of Service',
                    type: 'date',
					displayFormat: 'dd-mm-yy',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[required,custom[date]]'
                },
                
               user_active: {
                    title: 'Status',
                    options: { 1: 'Active', 0: 'Inactive' },
                    create: true,
                    edit: true,
                    list: false
                }, 
                
                hour_wage: {
                    title: 'Hour Wage',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[required,maxSize[10],custom[number]]'
                },   
                
                tarrif: {
                    title: 'Hourly Tarrif',
                    options: 'crud.php?action=tarrif&domain=user',
                    create: true,
                    edit: true,
                    list: false
                }, 
                
               min_hours: {
                    title: 'Minumum Work Hours',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[required,custom[integer],max[127]]'
                }, 
                
                Weekdays: {
    title: 'Workdays',
    list: false,
    input: function (data) {
        if (data.formType=="edit") {
        monday=tuesday=wednesday=thursday=friday=saturday=sunday="";
		if(parseInt(data.record.Weekdays[0]))
		monday=" checked";
		if(parseInt(data.record.Weekdays[1]))
		tuesday=" checked";
		if(parseInt(data.record.Weekdays[2]))
		wednesday=" checked";
		if(parseInt(data.record.Weekdays[3]))
		thursday=" checked";
		if(parseInt(data.record.Weekdays[4]))
		friday=" checked";
		if(parseInt(data.record.Weekdays[5]))
		saturday=" checked";
		if(parseInt(data.record.Weekdays[6]))
		sunday=" checked";
        
            return '<input type="checkbox" class="iCheck-helper" name="1"'+monday+'>Mo&nbsp;&nbsp;<input type="checkbox" class="iCheck-helper" name="2"'+tuesday+'>Tu&nbsp;&nbsp;<input type="checkbox" class="iCheck-helper" name="3"'+wednesday+'>We&nbsp;&nbsp;<input type="checkbox" class="iCheck-helper" name="4"'+thursday+'>Th&nbsp;&nbsp;<input type="checkbox" class="iCheck-helper" name="5"'+friday+'>Fr&nbsp;&nbsp;<input type="checkbox" class="iCheck-helper" name="6"'+saturday+'>Sa&nbsp;&nbsp;<input type="checkbox" class="iCheck-helper" name="7"'+sunday+'>Su&nbsp;&nbsp;<a>edit';
        } else {
            return '<input type="checkbox" class="iCheck-helper" name="1">Mo&nbsp;&nbsp;<input type="checkbox" class="iCheck-helper" name="2">Tu&nbsp;&nbsp;<input type="checkbox" class="iCheck-helper" name="3">We&nbsp;&nbsp;<input type="checkbox" class="iCheck-helper" name="4">Th&nbsp;&nbsp;<input type="checkbox" class="iCheck-helper" name="5">Fr&nbsp;&nbsp;<input type="checkbox" class="iCheck-helper" name="6">Sa&nbsp;&nbsp;<input type="checkbox" class="iCheck-helper" name="7">Su&nbsp;&nbsp;<a>';
        }
    }
},

                city: {
                    title: 'City(workplace)',
                    options: 'crud.php?action=city&domain=user',
                    create: true,
                    edit: false,
                    list: false
                },
                
                password: {
                    title: 'Password',
                    type: 'password',
                    create: true,
                    edit: true,
                    list: false,
                                    },   
                passwordr: {
                    title: 'Password(repeat)',
                    type: 'password',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[equals[Edit-password]]'
                },
                
                 e: {
                    title: '',
                    width: "2%",
                    sorting: false,
                    edit: false,
                    create: false,
                    listClass:'hidden-xs',
                    display: function (data) {
                        var $img = $('<a href="mailto:'+data.record.email+'"><button class="btn btn-info">E-mail</button></a>');

                        return $img;
                    }
                },
                stat: {
                    title: '',
                    width: "2%",
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function (data) {
                        var $img = $('<a href="list_user.php?id='+data.record.user_id+'"><button class="btn btn-primary">View</button></a>');

                        return $img;
                    }
                }

                
                
            },
            formCreated: function (event, data) {

                $('input[type="checkbox"]').iCheck({  checkboxClass: 'icheckbox_minimal' });
                
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
        
        
        $('#UserTableContainer').jtable('load');
    });
</script>


<?

include('footer.php');

?>
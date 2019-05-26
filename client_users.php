<?

include('check.php');
check_login('2');

include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

include('header.php');

?>
<div class="wrap">

<div id="UserTableContainer"></div>


</div>

<script type="text/javascript">


		function ajaxValidationCallback(status, form, json, options){
			if (window.console) 
			console.log(status);
                
			if (status === true) {
				alert("the form is valid!");
				// uncomment these lines to submit the form to form.action
				// form.validationEngine('detach');
				// form.submit();
				// or you may use AJAX again to submit the data
			}
			else
			{
				alert("invalid");
			}
		}
		
    $(document).ready(function () {
        $('#UserTableContainer').jtable({
            title: 'Client Users Directory',
            actions: {
                listAction:'crud.php?action=list&domain=cuser',
                createAction: 'crud.php?action=create&domain=cuser',
                updateAction: 'crud.php?action=update&domain=cuser',
                deleteAction: 'crud.php?action=delete&domain=cuser'
            }, 
            fields: {
                id: {
                title: 'ID',
                    key: true,
                    create:false,
                    list: true,
                    edit: false
                },
                username: {
                    title: 'Username',
                    create: true,
                    edit: false,
                    list: true,
                    inputClass: 'validate[required,maxSize[20],custom[onlyLetterNumber],ajax[ajaxNameCall]]'
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
                client: {
                    title: 'Associated Client',
                    options: 'crud.php?action=client&domain=cuser',
                    create: true,
                    edit: true,
                    list: false

                },
                
                
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
        
        
        $('#UserTableContainer').jtable('load');
    });
</script>
<br><br><br><br><br><br><br><br>


<?
	


include('footer.php');

?>
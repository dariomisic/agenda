<?

include('check.php');
check_login('2');


if(isset($gets["project"]))
{
include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

include('header.php');

$sql="SELECT * FROM project WHERE project_id=".$gets["project"];
$result = mysql_query($sql);

if(mysql_num_rows($result))
{
$row=mysql_fetch_array($result);
echo $row["name"];
}
else
{
die("no such project!");
}

?>

<div id="UserTableContainer"></div>


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
            title: 'Clients Directory',
            actions: {
                listAction:'crud.php?action=list&domain=client',
                createAction: 'crud.php?action=create&domain=client',
                updateAction: 'crud.php?action=update&domain=client',
                deleteAction: 'crud.php?action=delete&domain=client'
            }, 
            fields: {
                client_id: {
                	title: 'Client ID',
                    key: true,
                    create:false,
                    list: true,
                    edit: false
                },
                name: {
                    title: 'Client Name',
                    create: true,
                    edit: true,
                    list: true,
                    inputClass: 'validate[required,maxSize[250]]'
                },
                client_status: {
                    title: 'Status',
                    options: { '1': 'Active', '0': 'Inactive' },
                    create: true,
                    edit: true,
                    list: false
                },
                
                address: {
                    title: 'Address',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[required,maxSize[250]]'
                },
                
                
                zip: {
                    title: 'Postal code',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[required,maxSize[20]]'
                },
                
                city: {
                    title: 'City',
                    create: true,
                    edit: true,
                    list: true,
                    inputClass: 'validate[required,maxSize[250]]'
                },
                
               phone: {
                    title: 'Phone',
                    create: true,
                    edit: true,
                    list: true,
                    inputClass: 'validate[required,maxSize[50]]'
                },
               kvk: {
                    title: 'KVK number',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[maxSize[20]]'
                },
                
               btw: {
                    title: 'BTW number',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[maxSize[20]]'
                },
                
                
                 t: {
    title: 'CONTACT PERSON',
    list: false,
    input: function (data) {
	    
	    return '';
	    
    }
},

               fname: {
                    title: 'Firstname',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[maxSize[250]]'
                },
                lname: {
                    title: 'Lastname',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[maxSize[250]]'
                },
                sex: {
                    title: 'Gender',
                    options: { 'F': 'Female', 'M': 'Male' },
                    create: true,
                    edit: true,
                    list: false
                },

              hphone: {
                    title: 'Home Phone',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[maxSize[50]]'
                }, 
                
               mphone: {
                    title: 'Mobile Phone',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[maxSize[50]]'
                }, 
                
                email: {
                    title: 'E-mail',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[required,maxSize[250],custom[email]]'
                }, 
                
                                 t1: {
    title: 'POSTAL ADDRESS',
    list: false,
    input: function (data) {
	    
	    return '';
	    
    }
},

                p_address: {
                    title: 'Postal address',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[maxSize[250]]'
                }, 
                
                mailbox: {
                    title: 'Mailbox',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[maxSize[50]]'
                }, 
                
                p_zip: {
                    title: 'Postal code',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[maxSize[20]]'
                }, 
                p_city: {
                    title: 'City',
                    create: true,
                    edit: true,
                    list: false,
                    inputClass: 'validate[maxSize[250]]'
                },
                
                contact_person: {
                    title: 'Contact person',
                    create: false,
                    edit: false,
                    list: true
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
        
        
        $('#UserTableContainer').jtable('load');
    });
</script>



<?
	


include('footer.php');

}
else
{
echo "You must provide a project to display!";
}

?>
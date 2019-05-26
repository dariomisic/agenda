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
            title: 'Clients Directory',
            paging: true,
            pageSize: 10,
            sorting: true,
            defaultSorting: 'client_id ASC',
            actions: {
                listAction:'crud.php?action=list&domain=client'<?php
                if($Level<3) echo',
                createAction: \'crud.php?action=create&domain=client\',
                updateAction: \'crud.php?action=update&domain=client\',
                deleteAction: \'crud.php?action=delete&domain=client\'';
                ?>
            }, 
            fields: {
                client_id: {
                	title: 'ID',
                    key: true,
                    create:false,
                    list: true,
                    edit: false,
                    width:'1%'
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
                    inputClass: 'validate[required,maxSize[250]]',
                    listClass:'hidden-xs'
                },
                
               phone: {
                    title: 'Phone',
                    create: true,
                    edit: true,
                    list: false,
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
                
                
                 ttt: {
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
                    title: 'Phone',
                    create: true,
                    edit: true,
                    list: true,
                    inputClass: 'validate[maxSize[50]]',
                    listClass:'hidden-xs'
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
                    list: true,
                    sorting: false,
                    listClass:'hidden-xs'
                },
                
                stat: {
                    title: '',
                    width: "2%",
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function (data) {
                        var $img = $('<a href="list_client.php?id='+data.record.client_id+'"><button class="btn btn-primary">View</button></a>');

                        return $img;
                    }
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
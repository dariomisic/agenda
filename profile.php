<?
 
include('check.php');
check_login('3');

include('header.php');

if(!isset($included))
include('functions/functions.php');

$posts = array_map("xss_clean",$_POST);
$gets = array_map("xss_clean",$_GET);

$message='';

if(isset($_POST['e9_element']))
{

$sql="UPDATE user SET skin='" . $posts['skin'] . "', layout='" . $posts['layout'] . "', avatar='" . $posts['e9_element'] . "' WHERE user_id='" . $User_ID . "'";

$result=mysql_query($sql);

$message='<div class="alert alert-info alert-dismissable">
                                        <i class="fa fa-info"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        Settings are saved.
                                    </div>';

}

include('sc.php');

?>

<section class="content">

<div class="row">
<div class="col-md-6 col-md-offset-3">
<form name="profile" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
<div class="box box-info"><div class="box-header"><i class="fa fa-cog"></i><h3 class="box-title">Set your profile preferences</h3><div class="box-tools pull-right"><button type="submit" class="btn btn-info" style="color:#fff !important;">Save</button></div></div><div class="box-body">
<h4>Profile Avatar</h4>
<input type="text" id="e9_element" name="e9_element" />
<br/>
<br/>
<h4>Layout</h4>

<select class="form-control" style="width:150px;" name="layout">
                                                <option value="fluid" <?php if($Layout=='fluid') echo 'selected'; ?>>Fluid</option>
                                                <option value="fixed" <?php if($Layout=='fixed') echo 'selected'; ?>>Fixed</option>
</select>


<br/>
<h4>Skin</h4>
<select class="form-control" style="width:150px;" name="skin">
                                                <option value="light" <?php if($Skin=='light') echo 'selected'; ?>>Light</option>
                                                <option value="dark" <?php if($Skin=='dark') echo 'selected'; ?>>Dark</option>
</select>

<br/>

</div>
</div>
<?php echo $message; ?>
</div>
</form>

</div>


<script>

jQuery(document).ready(function($) {
 
    /**
     * Example 9
     * Load icons from icomoon JSON selections file
     */
 
    // Init the font icon picker
    var e9_element = $('#e9_element').fontIconPicker({
        theme: 'fip-bootstrap',
        emptyIcon:true,
        hasSearch:false
        });

 
        // Show processing message
        $(this).prop('disabled', true).html('<i class="icon-cog demo-animate-spin"></i> Please wait...');

 
        // Get the JSON file
        $.ajax({
            url: 'icomoon/selection.json',
            type: 'GET',
            dataType: 'json'
        })
        .done(function(response) {
 
            // Get the class prefix
            var classPrefix = response.preferences.fontPref.prefix,
                icomoon_json_icons = [],
                icomoon_json_search = [];
 
            // For each icon
            $.each(response.icons, function(i, v) {
 
                // Set the source
                icomoon_json_icons.push( classPrefix + v.properties.name );
 
                // Create and set the search source
                if ( v.icon && v.icon.tags && v.icon.tags.length ) {
                    icomoon_json_search.push( v.properties.name + ' ' + v.icon.tags.join(' ') );
                } else {
                    icomoon_json_search.push( v.properties.name );
                }
            });
 
            // Set new fonts on fontIconPicker
            e9_element.setIcons(icomoon_json_icons, icomoon_json_search);

            $('.selected-icon').html('<i class="<?php echo $Avatar; ?>"></i>');

            $('#e9_element').val('<?php echo $Avatar; ?>');
 
            // Show success message and disable
            //$('#e9_buttons button').removeClass('btn-primary').addClass('btn-success').text('Successfully loaded icons').prop('disabled', true);
 
        })
        .fail(function() {
            // Show error message and enable
            //$('#e9_buttons button').removeClass('btn-primary').addClass('btn-danger').text('Error: Try Again?').prop('disabled', false);
        });
        //e.stopPropagation();
});


</script>


<?

include('footer.php');



?>
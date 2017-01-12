<h1>Ninja to Drive</h1>
<form method="POST">
<?php
	if(isset($_POST["id_form"])){
		save_form_values_nd($_POST["id_form"]);
	}
	$forms = ninja_forms_get_all_forms();
	print_forms_select($forms); 

?>
	<div class="nd_loader" style="display: none; margin-left: 10px;"><img style="width:25px;vertical-align:middle;"src="<?php echo ND_PLUGIN_PATH ?>img/loading.gif"></div>
	<div id="form_content_nd"></div>
	 <?php
	submit_button();
	?>
</form>
<?php
function print_form_fields_nd() { ?>
	<script type="text/javascript" >
	jQuery(document).ready(function($) {
		jQuery(".select_forms_nd").on("change", function(){
			jQuery(".nd_loader").attr('style', 'display: inline-block; margin-left: 10px;');
			
			var form_id = jQuery(this).val();
			
			if(form_id != ""){
				var data = {
					'action': 'get_form_nd',
					'form_id': form_id
				};
				
				jQuery.post(ajaxurl, data, function(response) {
					jQuery('#form_content_nd').html( response );
					jQuery(".nd_loader").attr('style', 'display: none; margin-left: 10px;');
				});
				
			}else{
				jQuery('#form_content_nd').html( '' );
				jQuery(".nd_loader").attr('style', 'display: none; margin-left: 10px;');
			}
			
			
		})
	});
	</script> <?php
}
add_action( 'admin_footer', 'print_form_fields_nd' );
?>

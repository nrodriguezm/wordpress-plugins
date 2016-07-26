<h1>Ninja to Drive</h1>
<form method="POST">
<?php
	if(isset($_POST["id_form"])){
		save_form_values_nd($_POST["id_form"]);
	}
	$forms = ninja_forms_get_all_forms();
	print_forms_select($forms); 
?>
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
			var form_id = jQuery(this).val();
			var data = {
				'action': 'get_form_nd',
				'form_id': form_id
			};
			
			jQuery.post(ajaxurl, data, function(response) {
				jQuery('#form_content_nd').html( response );
			});
		})
	});
	</script> <?php
}
add_action( 'admin_footer', 'print_form_fields_nd' );
?>

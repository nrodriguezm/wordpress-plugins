<?php
function ds_create_template() {
	$labels = array(
		'name'               => _x( 'Ds Templates', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'Ds template', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Ds Templates', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'Ds Template', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add Ds Template', 'book', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Ds Template', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Ds Template', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Ds Template', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Ds Template', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Ds Templates', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Ds Templates', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Ds Template:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No Ds Template found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No Ds Template found in Trash.', 'your-plugin-textdomain' )
	);
	
	$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'dstemplate' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author' )
	);
	
    register_post_type( 'ds_template', $args );
}
add_action( 'init', 'ds_create_template' );

add_action( 'add_meta_boxes', 'ds_cd_meta_box_add' );

function ds_cd_meta_box_add(){
  add_meta_box( 'ds_field_shortcodes', 'Fields Shortcodes', 'ds_display_field_shortcodes', 'ds_template', 'normal', 'high' );
}


function ds_display_field_shortcodes(){
	?>
	<div class="ds-template">
		<select class="ds_form_shortcode">
			<option value="">Select Form</option>
		
		<?php
		$forms = Ninja_Forms()->form()->get_forms();
		foreach($forms as $form){
			$form_id = $form->get_id();
			$title = $form->get_settings('title');
			?>
			<option value="<?php echo $form_id; ?>"><?php echo $title;?></option>
			<?php
		}
		?>
		</select>
		<div id="res">
		</div>
	</div>
	<script>
	jQuery(document).ready(function(){
		jQuery(".ds_form_shortcode").on("change", function(){
			var id_form = jQuery(this).val();
			
			var param = {
				"id_form" : id_form,
				"action":"ds_get_form_fields"
			};
			jQuery.ajax({
				data:  param,
				url:   '<?php echo admin_url('admin-ajax.php'); ?>',
				type:  'post',
				beforeSend: function () {
					jQuery("#res").html("Processing...");
				},
				success:  function (response) {
					jQuery("#res").html(response);
				},		
				error:  function (response) {
						jQuery("#res").html("error");
				}
			});

		});
	});
	</script>
	<?php
}

function ds_get_form_fields () {
	$id_form = $_POST['id_form'];
	$fields = Ninja_Forms()->form( $id_form )->get_fields();
	foreach($fields as $field){
		$label = $field->get_settings('label');
		$key = $field->get_settings('key');
		$type = $field->get_settings('type');
		echo '<p><strong>'.$label.':</strong> [ds_field type="'.$type.'" key="'.$key.'"]</p>';
	}
	
	wp_reset_postdata();
	
	die();
}
add_action('wp_ajax_ds_get_form_fields', 'ds_get_form_fields');
add_action('wp_ajax_nopriv_ds_get_form_fields', 'ds_get_form_fields');

add_filter('single_template', 'ds_template_file');
function ds_template_file($single) {
	
    global $wp_query, $post;

    /* Checks for single template by post type */
    if ( $post->post_type == 'ds_template' ) {
        if ( file_exists( PLUGIN_DIR . '/templates/single-ds_template.php' ) ) {
            return PLUGIN_DIR . '/templates/single-ds_template.php';
        }
    }

    return $single;

}



?>
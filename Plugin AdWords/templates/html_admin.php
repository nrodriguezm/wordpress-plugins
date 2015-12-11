<?php

function html_post_asociado($post) {
	
	wp_nonce_field( 'html_post_asociado', 'nonce_post_asociado' );
	$post_types = get_post_types();

	//Obtengo todos los tipos de post
	/*
	* Excluidos: attachment, revision, nav_menu_item, nf_sub, adwords
	*
	*
	*/
	$exluidos = array('attachment', 'revision', 'nav_menu_item', 'nf_sub', 'adwords');
	$id_post_asociados = get_post_meta( $post->ID, 'post_asociado', true );
	
	foreach ($post_types as $post_type){
	
		if(!(in_array($post_type, $exluidos))) {
			
			$args = array(
				'post_status' 		=> 'publish',
				'post_type' 		=> $post_type,
				'posts_per_page'	=> -1,
				'orderby' 			=> 'title',
				'order'				=> 'ASC'
			);
			
			$query = new WP_Query( $args );
			$posts = $query->posts;
		
			?>
			<h3><?php echo $post_type; ?></h3>
			
			<select name="campo_post_asociado[]">
				<option value="">Seleccionar</option>
			<?php
				if(count($posts)>0){
					foreach($posts as $post){ 
						?>
						<option value= "<?php echo $post->ID; ?>" <?php if(($id_post_asociados != '') and (in_array((string) $post->ID, $id_post_asociados))){echo 'selected';}?> ><?php echo $post->post_title; ?></option>
						<?php
					}
				}
			?>
			</select>
			<?php
		}
	
	
	}
}
	


function html_conversion_id($post) {
	
	wp_nonce_field( 'html_conversion_id', 'nonce_conversion_id' );
	
	$valor_id = get_post_meta( $post->ID, 'conversion_id', true );
	?>
	<input type="text" name="campo_conversion_id" value="<?php echo $valor_id; ?>">
	<ul style="background-color: #DEDDDD;padding: 15px;">
		<li>var google_conversion_id = <strong>934343665;</strong></li>
		<li>var google_conversion_language = "en";</li>
		<li>var google_conversion_format = "3";</li>
		<li>var google_conversion_color = "ffffff";</li>
		<li>var google_conversion_label = "18XeCNvQ5GEQ8efDvQM";</li>
		<li>var google_remarketing_only = false;</li>
	</ul>	
	<?php
	
}

function html_conversion_label($post) {
	
	wp_nonce_field( 'html_conversion_label', 'nonce_conversion_label' );
	
	$valor_label = get_post_meta( $post->ID, 'conversion_label', true );
	?>
	
	<input type="text" name="campo_conversion_label" value="<?php echo $valor_label; ?>">
	<ul style="background-color: #DEDDDD;padding: 15px;">
		<li>var google_conversion_id = 934343665;</li>
		<li>var google_conversion_language = "en";</li>
		<li>var google_conversion_format = "3";</li>
		<li>var google_conversion_color = "ffffff";</li>
		<li>var google_conversion_label = <strong>"18XeCNvQ5GEQ8efDvQM";</strong></li>
		<li>var google_remarketing_only = false;</li>
	</ul>
	<?php
	
}

function adwords( $atts ){
	echo("<!-- Google Code -->\n");
	echo("<script type='text/javascript'>/*<![CDATA[ */\n");
	echo("var google_conversion_id = ".$atts['id'].";\n");
	echo("var google_conversion_language = '".$atts['language']."';\n");
	echo("var google_conversion_format = '".$atts['format']."';\n");
	echo("var google_conversion_color = '".$atts['color']."';\n");
	echo("var google_conversion_label = '".$atts['label']."';\n");
	echo("var google_remarketing_only = ".$atts['remarketing'].";\n");
	echo("/* ]]> */</script>");
	echo("<script type='text/javascript' src='http://www.googleadservices.com/pagead/conversion.js'></script>");
	echo("<noscript>");
	echo("<div style='display:inline;'>");
	echo("<img height='1' width='1' style='border-style:none;' alt='' src='//www.googleadservices.com/pagead/conversion/".$atts['id']."/?label=".$atts['label']."&amp;guid=ON&amp;script=0'/>");
	echo("</div></noscript>");
}
add_shortcode( 'adWords', 'adwords' );

?>
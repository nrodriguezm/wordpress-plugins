<?php
function codigoconversion($content) {
	
	$postid = get_the_ID();
	$content = '';
	
	//Obtengo los post de tipo adwords y almaceno en array los post que tienen adwords.
	$args = array(
				'post_status' 		=> 'publish',
				'post_type' 		=> 'adwords',
				'posts_per_page'	=> -1,
				'orderby' 			=> 'title',
				'order'				=> 'ASC'
			);
			
	$query = new WP_Query( $args );
	$posts = $query->posts;
	
	
	if(count($posts)>0){
		
		foreach($posts as $post){
			
			$post_asociados = get_post_meta( $post->ID, 'post_asociado', true );
			
			if(in_array((string) $postid, $post_asociados)){
				
				$id_conversion = get_post_meta( $post->ID, 'conversion_id', true );
				
				$label = get_post_meta( $post->ID, 'conversion_label', true );
				//echo do_shortcode("[adWords id='$id_conversion' language='en' format='3' color='fffff' label='$label' remarketing='false']");
				echo("<!-- Google Code -->\n");
				echo("<script type='text/javascript'>/*<![CDATA[ */\n");
				echo("var google_conversion_id = ".$id_conversion.";\n");
				echo("var google_conversion_language = 'en';\n");
				echo("var google_conversion_format = '3';\n");
				echo("var google_conversion_color = 'fffff';\n");
				echo("var google_conversion_label = '".$label."';\n");
				echo("var google_remarketing_only = 'false';\n");
				echo("/* ]]> */</script>");
				echo("<script type='text/javascript' src='http://www.googleadservices.com/pagead/conversion.js'></script>");
				echo('<noscript><div style="display:inline;"><img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/'.$id_conversion.'/?label='.$label.'&amp;guid=ON&amp;script=0"/></div></noscript>');
			}
		}
		
	}
	
	return $content;
}   

add_action( 'wp_footer', 'codigoconversion' );


?>
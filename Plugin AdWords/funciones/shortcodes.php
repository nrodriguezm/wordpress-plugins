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
				echo do_shortcode("[adWords id='$id_conversion' language='en' format='3' color='fffff' label='$label' remarketing='false']");
			}
		}
		
	}
	
	return $content;
}   

add_action('the_content', 'codigoconversion');


?>
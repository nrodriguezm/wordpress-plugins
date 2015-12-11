<?php
/***Guardar cambios Post AdWords***/
add_action( 'save_post', 'guardar_datos_adwords' );
function guardar_datos_adwords( $post_id ) {
	
	
	if ( ! isset( $_POST['nonce_post_asociado'] ) ) {
		return;
	}
	
	
	if ( ! wp_verify_nonce( $_POST['nonce_post_asociado'], 'html_post_asociado' ) ) {
		return;
	}
	
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	
	// Permisos de usuario
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}
	
	if ( ! isset( $_POST['campo_post_asociado'] ) ) {
		return;
	}
	
	
	// Atualizo capacidad.
	update_post_meta( $post_id, 'post_asociado', $_POST['campo_post_asociado'] );
	update_post_meta( $post_id, 'conversion_id', $_POST['campo_conversion_id'] );
	update_post_meta( $post_id, 'conversion_label', $_POST['campo_conversion_label'] );
	
}

?>
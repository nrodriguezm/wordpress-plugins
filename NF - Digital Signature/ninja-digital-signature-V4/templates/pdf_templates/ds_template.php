<?php 

function ds_template ($args){ 
	
	$fields 		= $args['fields'];
	$logo			= $args['logo'];
	$id_template	= (int) $args['id_template'];
	
	$html='<!doctype html><html lang="en"><head><meta charset="UTF-8"><title>Autoclima Uruguay</title><style type="text/css">';
	$html .= get_page_css();
	$html .='</style></head><body class="page-template-default page page-id-96 logged-in admin-bar color-custom style-default button-default layout-full-width header-classic sticky-header sticky-tb-color ab-hide subheader-both-center menu-link-color menuo-right mobile-tb-hide mobile-side-slide mobile-mini-mr-ll be-178 wpb-js-composer js-comp-ver-5.2.1 vc_responsive customize-support">';
	$html .= get_page_content($id_template);
	$html .= '</body></html>';
	return $html;
}

add_filter("ds_register_template", "ds_template");

function get_page_content($id){

    $page_data = get_post( $id );

    WPBMap::addAllMappedShortcodes();

    $html = apply_filters('the_content', $page_data->post_content);
	
    return $html;
}
add_action( 'wp_ajax_nopriv_get_page_content', 'get_page_content' );
add_action( 'wp_ajax_get_page_content', 'get_page_content' );

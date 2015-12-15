<?php
/*
Plugin Name: AdWords
Plugin URI: http://www.trepcom.com
Description: Plugin para integrar código de Google adwords
Version: 1.0
Author: Andrés Beraldo
Author URI: http://www.trepcom.com
*/
include_once 'funciones/funciones_admin.php';
include_once 'templates/html_admin.php';
include_once 'funciones/shortcodes.php';
/***Registrar el post adWords***/
add_action( 'init', 'crear_adwords' );
function crear_adwords() {

  $args = array(
		'labels'             => array('name' => __( 'AdWords' ), 'singular_name' => __( 'PAdWords' ), 'add_new_item' => 'Añadir AdWords'),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'PAdWords' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title')
	);
  
    register_post_type( 'PAdWords', $args);
}

/***Registrar los campos del post AdWords***/
add_action( 'add_meta_boxes', 'agregar_campos_adwords' );
function agregar_campos_adwords() {

	add_meta_box('post_asociado','Seleccionar posts', 'html_post_asociado', 'PAdWords');
	
}

add_action( 'add_meta_boxes', 'conversion_id' );
function conversion_id() {

	add_meta_box('conversion_id','Ingresar conversion id', 'html_conversion_id', 'PAdWords');
	
}

add_action( 'add_meta_boxes', 'conversion_label' );
function conversion_label() {

	add_meta_box('conversion_label','Ingresar conversion label', 'html_conversion_label', 'PAdWords');
	
}

?>
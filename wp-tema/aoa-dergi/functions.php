<?php
/**
 * AOA Dergi theme functions.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', function () {
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'aoa-fonts', 'https://fonts.googleapis.com/css2?family=Literata:ital,opsz,wght@0,7..72,400;0,7..72,500;0,7..72,600;0,7..72,700;1,7..72,400;1,7..72,500&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap', array(), null );
	wp_enqueue_style( 'aoa-dergi', get_stylesheet_uri(), array( 'aoa-fonts' ), $ver );
	wp_enqueue_script( 'aoa-dergi', get_theme_file_uri( 'assets/site.js' ), array(), $ver, true );
} );

add_action( 'after_setup_theme', function () {
	add_editor_style( 'style.css' );
} );

add_action( 'init', function () {
	register_block_pattern_category( 'aoa', array( 'label' => 'AOA Dergi' ) );
} );

/*
 * Elementor eklentisi kalıntısı: global "kit" sınıfı tüm bağlantıları
 * kendi vurgu rengine boyuyor. Bu tema Elementor kullanmadığı için
 * sınıfı gövdeden kaldırıyoruz.
 */
add_filter( 'body_class', function ( $classes ) {
	return array_values( array_filter( $classes, function ( $c ) {
		return 0 !== strpos( $c, 'elementor-kit-' );
	} ) );
}, 99 );

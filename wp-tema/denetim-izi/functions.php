<?php
/**
 * Denetim İzi theme functions.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', function () {
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'aoa-fonts', 'https://fonts.googleapis.com/css2?family=Literata:ital,opsz,wght@0,7..72,400;0,7..72,500;0,7..72,600;0,7..72,700;1,7..72,400;1,7..72,500&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap', array(), null );
	wp_enqueue_style( 'aoa-dergi', get_stylesheet_uri(), array( 'aoa-fonts' ), $ver );
	wp_enqueue_script( 'aoa-dergi', get_theme_file_uri( 'assets/site.js' ), array(), $ver, true );
	wp_add_inline_script( 'aoa-dergi', 'window.AOA_VIDEO=' . wp_json_encode( get_theme_file_uri( 'assets/video/' ) ) . ';', 'before' );
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

/*
 * Dosya kategorisindeki yazılar başlığı videolu şeritte gösteren
 * single-dosya şablonunu kullanır.
 */
add_filter( 'single_template_hierarchy', function ( $templates ) {
	if ( is_singular( 'post' ) && has_category( 'dosya' ) ) {
		array_unshift( $templates, 'single-dosya.php' );
	}
	return $templates;
} );

/*
 * Denetim İzi simgeleri temadan gelir. 16 piksellik sürümde nokta
 * okunmadığı için yalnız tik kullanılır.
 */
add_filter( 'site_icon_meta_tags', function () {
	$u = function ( $f ) {
		return esc_url( get_theme_file_uri( 'assets/' . $f ) );
	};
	return array(
		'<link rel="icon" href="' . $u( 'icon-32.png' ) . '" sizes="32x32" />',
		'<link rel="icon" href="' . $u( 'icon-16.png' ) . '" sizes="16x16" />',
		'<link rel="apple-touch-icon" href="' . $u( 'icon-180.png' ) . '" />',
		'<meta name="msapplication-TileImage" content="' . $u( 'icon-512.png' ) . '" />',
	);
} );
add_filter( 'get_site_icon_url', function ( $url, $size ) {
	return esc_url( get_theme_file_uri( 'assets/' . ( $size > 180 ? 'icon-512.png' : ( $size > 32 ? 'icon-180.png' : 'icon-32.png' ) ) ) );
}, 10, 2 );

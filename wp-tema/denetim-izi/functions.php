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

/*
 * Akademik bölüm: çok yazarlı yapı.
 * - "akademisyen" sınıflaması: her hoca bir terim. Açıklama = biyografi;
 *   unvan, kurum, alan, bağlantı ve fotoğraf terim alanlarında.
 * - Akademik yazılar "akademik" kategorisinde; künye bilgileri yazı alanlarında.
 */
add_action( 'init', function () {
	register_taxonomy( 'akademisyen', 'post', array(
		'labels'            => array(
			'name'          => 'Akademisyenler',
			'singular_name' => 'Akademisyen',
			'add_new_item'  => 'Yeni akademisyen ekle',
			'edit_item'     => 'Akademisyeni düzenle',
			'search_items'  => 'Akademisyen ara',
		),
		'public'            => true,
		'hierarchical'      => false,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'akademisyen' ),
	) );
	foreach ( array( 'ak_unvan', 'ak_kurum', 'ak_alan' ) as $k ) {
		register_term_meta( 'akademisyen', $k, array( 'type' => 'string', 'single' => true, 'show_in_rest' => true, 'sanitize_callback' => 'sanitize_text_field' ) );
	}
	register_term_meta( 'akademisyen', 'ak_baglanti', array( 'type' => 'string', 'single' => true, 'show_in_rest' => true, 'sanitize_callback' => 'esc_url_raw' ) );
	register_term_meta( 'akademisyen', 'ak_foto', array( 'type' => 'integer', 'single' => true, 'show_in_rest' => true ) );

	$yetki = function () {
		return current_user_can( 'edit_posts' );
	};
	foreach ( array( 'ak_tur', 'ak_ilk_yayin', 'ak_atif' ) as $k ) {
		register_post_meta( 'post', $k, array( 'type' => 'string', 'single' => true, 'show_in_rest' => true, 'sanitize_callback' => 'sanitize_text_field', 'auth_callback' => $yetki ) );
	}
	register_post_meta( 'post', 'ak_pdf', array( 'type' => 'string', 'single' => true, 'show_in_rest' => true, 'sanitize_callback' => 'esc_url_raw', 'auth_callback' => $yetki ) );
}, 5 );

/* Bir akademisyenin görüntülenecek bilgileri. */
function denetim_izi_akademisyen( $term ) {
	$foto_id = (int) get_term_meta( $term->term_id, 'ak_foto', true );
	return array(
		'ad'       => $term->name,
		'unvan'    => get_term_meta( $term->term_id, 'ak_unvan', true ),
		'kurum'    => get_term_meta( $term->term_id, 'ak_kurum', true ),
		'alan'     => get_term_meta( $term->term_id, 'ak_alan', true ),
		'baglanti' => get_term_meta( $term->term_id, 'ak_baglanti', true ),
		'foto'     => $foto_id ? wp_get_attachment_url( $foto_id ) : '',
		'bio'      => term_description( $term ),
		'link'     => get_term_link( $term ),
		'sayi'     => (int) $term->count,
	);
}

/* Yazar kartı: "tam" yazı sonunda ve yazar sayfasında, "kucuk" listelerde. */
function denetim_izi_yazar_karti( $term, $tur = 'tam', $baslik = 'h2' ) {
	$a    = denetim_izi_akademisyen( $term );
	$alt  = trim( implode( ' · ', array_filter( array( $a['kurum'], $a['alan'] ) ) ) );
	$ad   = trim( $a['unvan'] . ' ' . $a['ad'] );
	$foto = $a['foto']
		? '<img class="ak-foto" src="' . esc_url( $a['foto'] ) . '" alt="' . esc_attr( $a['ad'] ) . '" loading="lazy" width="160" height="200">'
		: '<span class="ak-foto ak-bos" aria-hidden="true">' . esc_html( mb_substr( $a['ad'], 0, 1 ) ) . '</span>';
	if ( 'kucuk' === $tur ) {
		$n = $a['sayi'] ? '<span class="ak-sayi">' . $a['sayi'] . ' çalışma</span>' : '';
		return '<a class="ak-kart ak-kucuk" href="' . esc_url( $a['link'] ) . '">' . $foto . '<span class="ak-metin"><b>' . esc_html( $ad ) . '</b>' . ( $alt ? '<span>' . esc_html( $alt ) . '</span>' : '' ) . $n . '</span></a>';
	}
	$isim = 'h1' === $baslik ? '<h1>' . esc_html( $ad ) . '</h1>' : '<' . $baslik . '><a href="' . esc_url( $a['link'] ) . '">' . esc_html( $ad ) . '</a></' . $baslik . '>';
	$dis  = $a['baglanti'] ? '<p class="ak-dis"><a href="' . esc_url( $a['baglanti'] ) . '" target="_blank" rel="noopener">Akademik profil</a></p>' : '';
	$tum  = 'h1' === $baslik ? '' : '<p class="ak-dis"><a href="' . esc_url( $a['link'] ) . '">Yazarın Denetim İzi\'ndeki tüm çalışmaları</a></p>';
	return '<div class="ak-kart ak-tam">' . $foto . '<div class="ak-metin">' . $isim . ( $alt ? '<p class="ak-alt">' . esc_html( $alt ) . '</p>' : '' ) . '<div class="ak-bio">' . wp_kses_post( $a['bio'] ) . '</div>' . $dis . $tum . '</div></div>';
}

/* Akademik yazılar kendi şablonunu kullanır. */
add_filter( 'single_template_hierarchy', function ( $templates ) {
	if ( is_singular( 'post' ) && has_category( 'akademik' ) ) {
		array_unshift( $templates, 'single-akademik.php' );
	}
	return $templates;
} );

/* Akademik yazının sonuna künye, atıf, yazar kartı ve sorumluluk notu. */
add_filter( 'the_content', function ( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() || ! has_category( 'akademik' ) ) {
		return $content;
	}
	$id      = get_the_ID();
	$yazarlar = get_the_terms( $id, 'akademisyen' );
	$yazarlar = is_array( $yazarlar ) ? $yazarlar : array();
	$tur     = get_post_meta( $id, 'ak_tur', true );
	$ilk     = get_post_meta( $id, 'ak_ilk_yayin', true );
	$pdf     = get_post_meta( $id, 'ak_pdf', true );
	$atif    = get_post_meta( $id, 'ak_atif', true );
	if ( ! $atif ) {
		$adlar = array();
		foreach ( $yazarlar as $t ) {
			$p       = preg_split( '/\s+/u', trim( $t->name ) );
			$soyad   = array_pop( $p );
			$bas     = implode( ' ', array_map( function ( $x ) { return mb_substr( $x, 0, 1 ) . '.'; }, $p ) );
			$adlar[] = $soyad . ( $bas ? ', ' . $bas : '' );
		}
		$atif = implode( ' ve ', $adlar ) . ' (' . get_the_date( 'Y' ) . '). ' . get_the_title() . '. Denetim İzi. ' . get_permalink();
	}
	$kunye = '<aside class="ak-kunye" aria-label="Künye">';
	$kunye .= '<dl>' . ( $tur ? '<dt>Tür</dt><dd>' . esc_html( $tur ) . '</dd>' : '' );
	$kunye .= '<dt>Yayın</dt><dd>' . esc_html( $ilk ? $ilk : 'İlk kez Denetim İzi\'nde yayımlanmıştır.' ) . '</dd></dl>';
	$kunye .= '<div class="acts">' . ( $pdf ? '<a class="dl" href="' . esc_url( $pdf ) . '" download>PDF indir</a>' : '' );
	$kunye .= '<button type="button" data-cite-toggle="cite-ak" aria-controls="cite-ak" aria-expanded="false">Atıf bilgisi</button></div>';
	$kunye .= '<div class="cite" id="cite-ak" hidden><span id="cite-ak-t">' . esc_html( wp_strip_all_tags( $atif ) ) . '</span> <button type="button" data-copy="cite-ak-t">Kopyala</button></div></aside>';
	$kartlar = '';
	foreach ( $yazarlar as $t ) {
		$kartlar .= denetim_izi_yazar_karti( $t, 'tam', 'h2' );
	}
	$kartlar = $kartlar ? '<section class="ak-yazarlar" aria-label="Yazar hakkında"><div class="kick">Yazar hakkında</div>' . $kartlar . '</section>' : '';
	$not = '<p class="ak-not">Bu yazıdaki görüşler yazarına aittir ve Denetim İzi\'nin görüşlerini yansıtmaz.</p>';
	return $content . $kunye . $kartlar . $not;
}, 20 );

/* Yazar sayfasında terim açıklaması bloğu tam profile dönüşür. */
add_filter( 'render_block_core/term-description', function ( $html ) {
	if ( ! is_tax( 'akademisyen' ) ) {
		return $html;
	}
	return '<div class="ak-profil">' . denetim_izi_yazar_karti( get_queried_object(), 'tam', 'h1' ) . '</div>';
} );

/* Ana sayfadaki genel yazı akışlarında akademik yazılar yer almaz; onlar akademik kutusunda. */
add_filter( 'query_loop_block_query_vars', function ( $vars, $block ) {
	if ( is_front_page() && in_array( (int) ( $block->context['queryId'] ?? 0 ), array( 1, 2 ), true ) ) {
		$ak = get_category_by_slug( 'akademik' );
		if ( $ak ) {
			$vars['category__not_in'] = array_merge( (array) ( $vars['category__not_in'] ?? array() ), array( $ak->term_id ) );
		}
	}
	return $vars;
}, 10, 2 );

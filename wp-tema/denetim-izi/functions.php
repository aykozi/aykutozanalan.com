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

/*
 * Bülten (MailPoet): konuk akademik yazılarda e-postadaki yazar satırı
 * WordPress hesabı yerine sitedeki akademisyen kaydından gelir.
 */
add_filter( 'mailpoet_newsletter_post_author', function ( $author, $post_id = 0 ) {
	$yazarlar = $post_id ? get_the_terms( (int) $post_id, 'akademisyen' ) : false;
	if ( ! is_array( $yazarlar ) || ! $yazarlar ) {
		return $author;
	}
	$adlar = array();
	foreach ( $yazarlar as $t ) {
		$adlar[] = trim( get_term_meta( $t->term_id, 'ak_unvan', true ) . ' ' . $t->name );
	}
	return esc_html( implode( ', ', $adlar ) );
}, 10, 2 );

/* ---------------------------------------------------------------
 * Yazı görselleri (1.12): konu motifleri, öne çıkan kutu, son yazılar
 * şeritleri ve yazı sonundaki "ilginizi çekebilecek" kutuları.
 * Her yazının motifi `di_motif`, kısa konu ifadesi `di_konu` ve alt
 * satırı `di_konu_alt` alanlarından gelir; boşsa yedekler kullanılır.
 * ------------------------------------------------------------- */
add_action( 'init', function () {
	$yetki = function () {
		return current_user_can( 'edit_posts' );
	};
	foreach ( array( 'di_motif', 'di_konu', 'di_konu_alt' ) as $k ) {
		register_post_meta( 'post', $k, array( 'type' => 'string', 'single' => true, 'show_in_rest' => true, 'sanitize_callback' => 'sanitize_text_field', 'auth_callback' => $yetki ) );
	}
	register_block_type( 'denetim-izi/one-cikan', array( 'api_version' => 3, 'render_callback' => 'denetim_izi_one_cikan' ) );
	register_block_type( 'denetim-izi/son-yazilar', array( 'api_version' => 3, 'render_callback' => 'denetim_izi_son_yazilar' ) );
	register_block_type( 'denetim-izi/ilgili', array( 'api_version' => 3, 'render_callback' => 'denetim_izi_ilgili' ) );
}, 6 );

function denetim_izi_motifler() {
	return array( 'ag', 'lisans', 'venn', 'terazi', 'belge', 'katman', 'iz' );
}

function denetim_izi_motif_adi( $post ) {
	$m = get_post_meta( $post->ID, 'di_motif', true );
	$hepsi = denetim_izi_motifler();
	return in_array( $m, $hepsi, true ) ? $m : $hepsi[ $post->ID % count( $hepsi ) ];
}

/* Konu motifi: ince çizgi, kesik ikincil çizgiler, logodaki turuncu nokta. */
function denetim_izi_motif( $ad, $sinif = '', $kucuk = false ) {
	$k = $kucuk ? '' : ' stroke-dasharray="1.5 4.5"';
	$r = $kucuk ? 11 : 5.5;
	$p = array(
		'iz'     => array( '<path d="M8 92 L34 62 L54 74 L80 36 L104 48"' . $k . '/>', 104, 48 ),
		'ag'     => array( '<circle cx="26" cy="62" r="13"/><circle cx="92" cy="30" r="13"/><circle cx="92" cy="92" r="13"/><path d="M39 56 L79 36 M39 68 L79 86"' . $k . '/>', 92, 30 ),
		'lisans' => array( '<rect x="20" y="12" width="70" height="90" rx="3"/><path d="M34 34 h42 M34 48 h42 M34 62 h24"' . $k . '/><circle cx="82" cy="86" r="14"/>', 82, 86 ),
		'venn'   => array( '<circle cx="45" cy="60" r="31"/><circle cx="77" cy="60" r="31"' . $k . '/>', 61, 60 ),
		'terazi' => array( '<path d="M60 16 V102 M38 104 H82 M22 34 H98"/><path d="M22 34 L10 64 H34 Z M98 34 L86 64 H110 Z"' . $k . '/>', 60, 16 ),
		'belge'  => array( '<rect x="18" y="12" width="84" height="96" rx="3"/><path d="M18 36 H102 M18 60 H102 M18 84 H102 M46 12 V108 M74 12 V108"' . $k . '/>', 60, 72 ),
		'katman' => array( '<path d="M60 20 L106 43 L60 66 L14 43 Z"/><path d="M14 62 L60 85 L106 62"' . $k . '/><path d="M14 81 L60 104 L106 81"' . $k . '/>', 60, 20 ),
	);
	$m = $p[ $ad ] ?? $p['ag'];
	return '<svg class="motif ' . esc_attr( $sinif ) . '" viewBox="0 0 120 120" aria-hidden="true" focusable="false" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">'
		. $m[0] . '<circle class="motif-nokta" cx="' . $m[1] . '" cy="' . $m[2] . '" r="' . $r . '" stroke="none"/></svg>';
}

function denetim_izi_kategori( $post ) {
	$c = get_the_category( $post->ID );
	return $c ? $c[0] : null;
}

function denetim_izi_kategori_rengi( $kat ) {
	$renk = array( 'ic-denetim' => '#14322B', 'uyum-ve-aml' => '#7A4E0E', 'dosya' => '#0E1A2B', 'dosyalar' => '#0E1A2B', 'akademik' => '#2E3F4A' );
	return $kat && isset( $renk[ $kat->slug ] ) ? $renk[ $kat->slug ] : '#14322B';
}

function denetim_izi_akademik_disi() {
	$ak = get_category_by_slug( 'akademik' );
	return $ak ? array( $ak->term_id ) : array();
}

/* Ana sayfa: en son yazı, uzun başlığı içinde taşıyan yeşil kutu. */
function denetim_izi_one_cikan() {
	$q = get_posts( array( 'numberposts' => 1, 'category__not_in' => denetim_izi_akademik_disi() ) );
	if ( ! $q ) {
		return '';
	}
	$p   = $q[0];
	$kat = denetim_izi_kategori( $p );
	return '<a class="onc has-bgv" href="' . esc_url( get_permalink( $p ) ) . '">'
		. '<span class="bgv" aria-hidden="true" data-bgv="' . esc_url( get_theme_file_uri( 'assets/video/yazi' ) ) . '"></span>'
		. '<span class="onc-ust"><span class="onc-kick">' . esc_html( $kat ? $kat->name : '' ) . '</span>' . denetim_izi_motif( denetim_izi_motif_adi( $p ), 'onc-motif' ) . '</span>'
		. '<h1 class="onc-baslik">' . esc_html( get_the_title( $p ) ) . '</h1>'
		. '<span class="onc-ozet">' . esc_html( wp_strip_all_tags( get_the_excerpt( $p ) ) ) . '</span>'
		. '<span class="onc-alt"><span>' . esc_html( get_the_date( 'j F Y', $p ) ) . '</span><span class="onc-oku">Yazıyı okuyun &rarr;</span></span>'
		. '</a>';
}

function denetim_izi_serit_kart( $p, $baslik = 'h3' ) {
	$kat  = denetim_izi_kategori( $p );
	$link = esc_url( get_permalink( $p ) );
	return '<article class="sy-k">'
		. '<a class="sy-serit" href="' . $link . '" tabindex="-1" aria-hidden="true" style="--kr:' . esc_attr( denetim_izi_kategori_rengi( $kat ) ) . '">'
		. '<span class="sy-bilgi"><span class="sy-kick">' . esc_html( $kat ? $kat->name : '' ) . '</span><span class="sy-tarih">' . esc_html( get_the_date( 'd.m.Y', $p ) ) . '</span></span>'
		. denetim_izi_motif( denetim_izi_motif_adi( $p ), 'sy-motif', true ) . '</a>'
		. '<' . $baslik . ' class="sy-baslik"><a href="' . $link . '">' . esc_html( get_the_title( $p ) ) . '</a></' . $baslik . '>'
		. '<p class="sy-ozet">' . esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt( $p ) ), 24, '…' ) ) . '</p>'
		. '</article>';
}

/* Ana sayfa: öne çıkandan sonraki üç yazı, ince kategori şeritli kartlar. */
function denetim_izi_son_yazilar() {
	$q = get_posts( array( 'numberposts' => 3, 'offset' => 1, 'category__not_in' => denetim_izi_akademik_disi() ) );
	if ( ! $q ) {
		return '<p class="empty">İlk analizler hazırlanıyor. Yayımlandıkça burada yer alacak.</p>';
	}
	return '<div class="sy">' . implode( '', array_map( 'denetim_izi_serit_kart', $q ) ) . '</div>';
}

/* Yazı sonu: aynı kategoriden (yetmezse en yenilerden) üç yazı, motifli kutular. */
function denetim_izi_ilgili() {
	if ( ! is_singular( 'post' ) ) {
		return '';
	}
	$id  = get_the_ID();
	$kat = denetim_izi_kategori( get_post( $id ) );
	$liste = $kat ? get_posts( array( 'numberposts' => 3, 'category' => $kat->term_id, 'exclude' => array( $id ) ) ) : array();
	if ( count( $liste ) < 3 ) {
		$haric = array_merge( array( $id ), wp_list_pluck( $liste, 'ID' ) );
		$liste = array_merge( $liste, get_posts( array( 'numberposts' => 3 - count( $liste ), 'exclude' => $haric ) ) );
	}
	if ( ! $liste ) {
		return '';
	}
	$out = '';
	foreach ( $liste as $p ) {
		$k     = denetim_izi_kategori( $p );
		$konu  = get_post_meta( $p->ID, 'di_konu', true );
		$alt   = get_post_meta( $p->ID, 'di_konu_alt', true );
		$out  .= '<a class="kb" href="' . esc_url( get_permalink( $p ) ) . '" aria-label="' . esc_attr( get_the_title( $p ) ) . '">'
			. denetim_izi_motif( denetim_izi_motif_adi( $p ), 'kb-motif' )
			. '<span class="kb-kick">' . esc_html( $k ? $k->name : '' ) . '</span>'
			. '<span class="kb-orta"><span class="kb-konu">' . esc_html( $konu ? $konu : get_the_title( $p ) ) . '</span>'
			. ( $alt ? '<span class="kb-alt">' . esc_html( $alt ) . '</span>' : '' ) . '</span>'
			. '<span class="kb-son"><span class="kb-marka">denetim <span>izi</span></span><span>' . esc_html( get_the_date( 'j F Y', $p ) ) . '</span></span>'
			. '</a>';
	}
	$tumu = $kat ? '<a class="ilgili-tumu" href="' . esc_url( get_category_link( $kat ) ) . '">' . esc_html( $kat->name ) . ' yazılarının tümü &rarr;</a>' : '';
	return '<section class="ilgili" aria-labelledby="ilgili-baslik"><div class="w"><div class="ilgili-bas"><h2 id="ilgili-baslik">İlginizi çekebilecek diğer yazılar</h2>' . $tumu . '</div><div class="ilgili-liste">' . $out . '</div></div></section>';
}

/* ---------------------------------------------------------------
 * Paylaşım görseli (1.13): her yazı için 1200×630 yeşil kapak
 * (kategori, kısa konu ifadesi, motif, marka). İlk istekte üretilip
 * uploads/di-kapak/ altında saklanır; içerik değişince yenisi üretilir.
 * ------------------------------------------------------------- */
require_once get_theme_file_path( 'inc/kapak.php' );

function denetim_izi_kapak_url( $post = null ) {
	if ( ! function_exists( 'imagettftext' ) ) {
		return '';
	}
	if ( $post ) {
		$kat  = denetim_izi_kategori( $post );
		$konu = get_post_meta( $post->ID, 'di_konu', true );
		$v    = array(
			'kick'  => $kat ? $kat->name : 'Denetim İzi',
			'konu'  => $konu ? $konu : wp_strip_all_tags( get_the_title( $post ) ),
			'alt'   => (string) get_post_meta( $post->ID, 'di_konu_alt', true ),
			'tarih' => get_the_date( 'j F Y', $post ),
			'motif' => denetim_izi_motif_adi( $post ),
		);
		$ad = 'yazi-' . $post->ID;
	} else {
		$v  = array( 'kick' => 'Denetim · Suistimal · Uyum', 'konu' => 'Denetim İzi', 'alt' => 'Denetim, suistimal ve uyum üzerine yazılar', 'tarih' => 'denetimizi.com', 'motif' => 'iz' );
		$ad = 'site';
	}
	$up    = wp_upload_dir();
	$klas  = trailingslashit( $up['basedir'] ) . 'di-kapak';
	$dosya = $ad . '-' . substr( md5( wp_json_encode( $v ) . '|2' ), 0, 10 ) . '.png';
	if ( ! file_exists( $klas . '/' . $dosya ) ) {
		wp_mkdir_p( $klas );
		foreach ( (array) glob( $klas . '/' . $ad . '-*.png' ) as $eski ) {
			@unlink( $eski );
		}
		$fontlar = array(
			'serif'  => get_theme_file_path( 'assets/fonts/Literata36pt-SemiBold.ttf' ),
			'normal' => get_theme_file_path( 'assets/fonts/WorkSans-Regular.ttf' ),
			'kalin'  => get_theme_file_path( 'assets/fonts/WorkSans-Bold.ttf' ),
		);
		if ( ! denetim_izi_kapak_ciz( $v, $klas . '/' . $dosya, $fontlar ) ) {
			return '';
		}
	}
	return trailingslashit( $up['baseurl'] ) . 'di-kapak/' . $dosya;
}

add_filter( 'jetpack_open_graph_tags', function ( $tags ) {
	$post = is_singular( 'post' ) ? get_queried_object() : null;
	$url  = denetim_izi_kapak_url( $post );
	if ( ! $url ) {
		return $tags;
	}
	$tags['og:image']        = $url;
	$tags['og:image:width']  = 1200;
	$tags['og:image:height'] = 630;
	$tags['og:image:alt']    = $post ? wp_strip_all_tags( get_the_title( $post ) ) : 'Denetim İzi';
	$tags['twitter:image']   = $url;
	$tags['twitter:card']    = 'summary_large_image';
	unset( $tags['og:image:secure_url'] );
	return $tags;
}, 20 );

/* Arşiv sayfaları (1.13.1): videolu başlık şeridi ve şeritli kartlar. */
add_action( 'init', function () {
	register_block_type( 'denetim-izi/arsiv-ust', array( 'api_version' => 3, 'render_callback' => 'denetim_izi_arsiv_ust' ) );
	register_block_type( 'denetim-izi/arsiv', array( 'api_version' => 3, 'render_callback' => 'denetim_izi_arsiv' ) );
}, 7 );

function denetim_izi_arsiv_ust() {
	$o     = get_queried_object();
	$dosya = is_category() && $o && 'dosya' === $o->slug;
	$ust   = is_category() ? 'Kategori' : ( is_tag() ? 'Etiket' : 'Arşiv' );
	$baslik = ( is_category() || is_tag() ) ? single_term_title( '', false ) : wp_strip_all_tags( get_the_archive_title() );
	$acik   = is_category() || is_tag() ? term_description() : '';
	global $wp_query;
	$video = get_theme_file_uri( 'assets/video/' . ( $dosya ? 'dosyalar' : 'yazi' ) );
	return '<header class="ahs has-bgv' . ( $dosya ? ' ahs-dosya' : '' ) . '"><div class="bgv" aria-hidden="true" data-bgv="' . esc_url( $video ) . '"></div>'
		. '<div class="w"><div class="yhero-in"><div class="ahs-ust"><span>' . esc_html( $ust ) . '</span><span class="sayi">' . (int) $wp_query->found_posts . ' yazı</span></div>'
		. '<h1>' . esc_html( $baslik ) . '</h1>' . ( $acik ? '<div class="ahs-acik">' . wp_kses_post( $acik ) . '</div>' : '' ) . '</div></div></header>';
}

function denetim_izi_arsiv() {
	global $wp_query;
	if ( ! $wp_query->have_posts() ) {
		return '<p class="empty">Henüz yazı yok.</p>';
	}
	$out = '<div class="sy">' . implode( '', array_map( function ( $p ) {
		return denetim_izi_serit_kart( $p, 'h2' );
	}, $wp_query->posts ) ) . '</div>';
	$sayfa = paginate_links( array( 'prev_text' => 'Önceki', 'next_text' => 'Sonraki' ) );
	return $out . ( $sayfa ? '<nav class="arsiv-sayfa" aria-label="Sayfalar">' . $sayfa . '</nav>' : '' );
}

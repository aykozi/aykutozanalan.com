<?php
/**
 * Title: Akademik
 * Slug: aoa/akademik
 * Categories: aoa
 * Inserter: no
 */
$aoa_v   = esc_url( get_theme_file_uri( 'assets/video/' ) );
$aoa_tez = esc_url( get_theme_file_uri( 'assets/tez/' ) );
// PDF'ler ortam kütüphanesinde.
$pdf_dr  = 'https://denetimizi.com/wp-content/uploads/2026/11/Alan-2024-Doktora-Tezi-Local-Agricultural-Relations-Cigdemli.pdf';
$pdf_yl  = 'https://denetimizi.com/wp-content/uploads/2026/11/Alan-2012-Yuksek-Lisans-Tezi-Mitos-Tarih-Iliskisi.pdf';
?>
<!-- wp:html -->
<section class="akhero has-bgv" aria-labelledby="ak-baslik"><div class="bgv" aria-hidden="true" data-bgv="<?php echo $aoa_v; ?>akademik"></div><div class="w">
<div class="fno">AKADEMİK</div>
<h1 id="ak-baslik">Hukuk, kamu yönetimi ve yönetişim üzerine akademik yazılar</h1>
<p>Farklı üniversitelerden akademisyenlerin makaleleri, güncel değerlendirmeleri ve tezleri.</p>
</div></section>
<?php
$ak_kat     = get_category_by_slug( 'akademik' );
$ak_yazilar = $ak_kat ? get_posts( array( 'category' => $ak_kat->term_id, 'numberposts' => 50, 'post_status' => 'publish' ) ) : array();
$ak_hocalar = taxonomy_exists( 'akademisyen' ) ? get_terms( array( 'taxonomy' => 'akademisyen', 'hide_empty' => true, 'orderby' => 'name' ) ) : array();
$ak_hocalar = is_wp_error( $ak_hocalar ) ? array() : $ak_hocalar;
if ( $ak_hocalar ) :
?>
<div class="w"><section class="ak-blok" aria-labelledby="ak-yazarlar-h">
<h2 id="ak-yazarlar-h" class="ak-blok-h">Yazarlar</h2>
<div class="ak-yazar-izgara">
<?php foreach ( $ak_hocalar as $t ) { echo denetim_izi_yazar_karti( $t, 'kucuk' ); } ?>
</div></section></div>
<?php endif; ?>
<div class="w"><section class="ak-blok" aria-labelledby="ak-son-h">
<h2 id="ak-son-h" class="ak-blok-h">Çalışmalar</h2>
<?php if ( $ak_yazilar ) : ?>
<ol class="ak-son">
<?php foreach ( $ak_yazilar as $p ) :
	$yz  = get_the_terms( $p, 'akademisyen' );
	$adl = is_array( $yz ) ? implode( ', ', wp_list_pluck( $yz, 'name' ) ) : '';
	$tur = get_post_meta( $p->ID, 'ak_tur', true );
?>
<li><div class="meta"><?php echo esc_html( trim( implode( ' · ', array_filter( array( $tur, get_the_date( 'Y', $p ) ) ) ) ) ); ?></div>
<h3><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a></h3>
<?php if ( $adl ) : ?><p class="ak-kim"><?php echo esc_html( $adl ); ?></p><?php endif; ?>
<?php if ( has_excerpt( $p ) ) : ?><p class="ak-oz"><?php echo esc_html( get_the_excerpt( $p ) ); ?></p><?php endif; ?></li>
<?php endforeach; ?>
</ol>
<?php else : ?>
<p class="empty">Konuk akademisyenlerin ilk yazıları hazırlanıyor.</p>
<?php endif; ?>
</section></div>
<!-- /wp:html -->

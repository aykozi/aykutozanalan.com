<?php
/**
 * Paylaşım görseli (og:image): 1200×630 yeşil kapak, konu motifi,
 * kategori, kısa konu ifadesi ve marka. GD ile 2 kat büyüklükte
 * çizilip küçültülür (yumuşak kenarlar için).
 */

function denetim_izi_kapak_tr_buyuk( $s ) {
	return mb_strtoupper( str_replace( array( 'i', 'ı' ), array( 'İ', 'I' ), $s ), 'UTF-8' );
}

/* 120 birimlik motif tanımları: [tür, kesik mi, veri] */
function denetim_izi_kapak_motif_parcalari( $ad ) {
	$ring = function ( $cx, $cy, $r ) {
		$p = array();
		for ( $i = 0; $i <= 96; $i++ ) {
			$a   = 2 * M_PI * $i / 96;
			$p[] = array( $cx + $r * cos( $a ), $cy + $r * sin( $a ) );
		}
		return $p;
	};
	$rect = function ( $x, $y, $w, $h ) {
		return array( array( $x, $y ), array( $x + $w, $y ), array( $x + $w, $y + $h ), array( $x, $y + $h ), array( $x, $y ) );
	};
	$m = array(
		'iz'     => array( array( array( array( 8, 92 ), array( 34, 62 ), array( 54, 74 ), array( 80, 36 ), array( 104, 48 ) ), true ) ),
		'ag'     => array( array( $ring( 26, 62, 13 ), false ), array( $ring( 92, 30, 13 ), false ), array( $ring( 92, 92, 13 ), false ), array( array( array( 39, 56 ), array( 79, 36 ) ), true ), array( array( array( 39, 68 ), array( 79, 86 ) ), true ) ),
		'lisans' => array( array( $rect( 20, 12, 70, 90 ), false ), array( array( array( 34, 34 ), array( 76, 34 ) ), true ), array( array( array( 34, 48 ), array( 76, 48 ) ), true ), array( array( array( 34, 62 ), array( 58, 62 ) ), true ), array( $ring( 82, 86, 14 ), false ) ),
		'venn'   => array( array( $ring( 45, 60, 31 ), false ), array( $ring( 77, 60, 31 ), true ) ),
		'terazi' => array( array( array( array( 60, 16 ), array( 60, 102 ) ), false ), array( array( array( 38, 104 ), array( 82, 104 ) ), false ), array( array( array( 22, 34 ), array( 98, 34 ) ), false ), array( array( array( 22, 34 ), array( 10, 64 ), array( 34, 64 ), array( 22, 34 ) ), true ), array( array( array( 98, 34 ), array( 86, 64 ), array( 110, 64 ), array( 98, 34 ) ), true ) ),
		'belge'  => array( array( $rect( 18, 12, 84, 96 ), false ), array( array( array( 18, 36 ), array( 102, 36 ) ), true ), array( array( array( 18, 60 ), array( 102, 60 ) ), true ), array( array( array( 18, 84 ), array( 102, 84 ) ), true ), array( array( array( 46, 12 ), array( 46, 108 ) ), true ), array( array( array( 74, 12 ), array( 74, 108 ) ), true ) ),
		'katman' => array( array( array( array( 60, 20 ), array( 106, 43 ), array( 60, 66 ), array( 14, 43 ), array( 60, 20 ) ), false ), array( array( array( 14, 62 ), array( 60, 85 ), array( 106, 62 ) ), true ), array( array( array( 14, 81 ), array( 60, 104 ), array( 106, 81 ) ), true ) ),
		'hafta'  => array( array( $rect( 14, 22, 92, 82 ), false ), array( array( array( 14, 44 ), array( 106, 44 ) ), false ), array( array( array( 38, 12 ), array( 38, 30 ) ), false ), array( array( array( 82, 12 ), array( 82, 30 ) ), false ), array( array( array( 28, 62 ), array( 42, 62 ) ), true ), array( array( array( 53, 62 ), array( 67, 62 ) ), true ), array( array( array( 78, 62 ), array( 92, 62 ) ), true ), array( array( array( 28, 84 ), array( 42, 84 ) ), true ), array( array( array( 53, 84 ), array( 67, 84 ) ), true ) ),
	);
	$nokta = array( 'iz' => array( 104, 48 ), 'ag' => array( 92, 30 ), 'lisans' => array( 82, 86 ), 'venn' => array( 61, 60 ), 'terazi' => array( 60, 16 ), 'belge' => array( 60, 72 ), 'katman' => array( 60, 20 ), 'hafta' => array( 85, 84 ) );
	$ad = isset( $m[ $ad ] ) ? $ad : 'ag';
	return array( $m[ $ad ], $nokta[ $ad ] );
}

/* Bir yolu boyunca daireler basarak çizer; kesikse yalnız aralıklı noktalar. */
function denetim_izi_kapak_yol( $im, $pts, $kesik, $renk, $ox, $oy, $sc, $kalin ) {
	$r    = $kalin / 2;
	$adim = $kesik ? 6 * $sc : max( 1, $r / 2 );
	$kalan = 0;
	for ( $i = 1; $i < count( $pts ); $i++ ) {
		$x1 = $ox + $pts[ $i - 1 ][0] * $sc;
		$y1 = $oy + $pts[ $i - 1 ][1] * $sc;
		$x2 = $ox + $pts[ $i ][0] * $sc;
		$y2 = $oy + $pts[ $i ][1] * $sc;
		$len = hypot( $x2 - $x1, $y2 - $y1 );
		$t   = $kalan;
		while ( $t <= $len ) {
			$f = $len > 0 ? $t / $len : 0;
			imagefilledellipse( $im, (int) round( $x1 + ( $x2 - $x1 ) * $f ), (int) round( $y1 + ( $y2 - $y1 ) * $f ), (int) round( $kalin ), (int) round( $kalin ), $renk );
			$t += $adim;
		}
		$kalan = $t - $len;
	}
}

function denetim_izi_kapak_satirlar( $metin, $font, $boy, $genislik, $en_cok ) {
	$kelimeler = preg_split( '/\s+/u', trim( $metin ) );
	$satirlar  = array();
	$satir     = '';
	foreach ( $kelimeler as $k ) {
		$dene = '' === $satir ? $k : $satir . ' ' . $k;
		$b    = imagettfbbox( $boy, 0, $font, $dene );
		if ( $b[2] - $b[0] > $genislik && '' !== $satir ) {
			$satirlar[] = $satir;
			$satir      = $k;
		} else {
			$satir = $dene;
		}
	}
	if ( '' !== $satir ) {
		$satirlar[] = $satir;
	}
	if ( count( $satirlar ) > $en_cok ) {
		$satirlar = array_slice( $satirlar, 0, $en_cok );
		$satirlar[ $en_cok - 1 ] = rtrim( $satirlar[ $en_cok - 1 ], ' ,.:;' ) . '…';
	}
	return $satirlar;
}

/**
 * $v: kick, konu, alt, tarih, motif. $dosya: yazılacak PNG yolu.
 */
function denetim_izi_kapak_ciz( $v, $dosya, $fontlar ) {
	$S  = 2;
	$W  = 1200 * $S;
	$H  = 630 * $S;
	$im = imagecreatetruecolor( $W, $H );
	$c  = function ( $hex ) use ( $im ) {
		return imagecolorallocate( $im, hexdec( substr( $hex, 1, 2 ) ), hexdec( substr( $hex, 3, 2 ) ), hexdec( substr( $hex, 5, 2 ) ) );
	};
	imagefilledrectangle( $im, 0, 0, $W, $H, $c( '#14322B' ) );

	/* motif: sağda, 400 px */
	list( $parcalar, $nokta ) = denetim_izi_kapak_motif_parcalari( $v['motif'] );
	$sc = 3.4 * $S;
	$ox = 1135 * $S - 120 * $sc;
	$oy = 315 * $S - 60 * $sc;
	$amber = $c( '#C6A760' );
	foreach ( $parcalar as $p ) {
		denetim_izi_kapak_yol( $im, $p[0], $p[1], $amber, $ox, $oy, $sc, 1.7 * $sc );
	}
	$nr = 5.5 * $sc * 2;
	imagefilledellipse( $im, (int) ( $ox + $nokta[0] * $sc ), (int) ( $oy + $nokta[1] * $sc ), (int) $nr, (int) $nr, $c( '#D4952B' ) );

	/* yazılar */
	$x = 72 * $S;
	imagettftext( $im, 17 * $S, 0, $x, 92 * $S, $c( '#F2C46D' ), $fontlar['kalin'], denetim_izi_kapak_tr_buyuk( $v['kick'] ) );
	$satirlar = denetim_izi_kapak_satirlar( $v['konu'], $fontlar['serif'], 50 * $S, 610 * $S, 3 );
	$y        = 250 * $S - ( count( $satirlar ) - 1 ) * 32 * $S;
	foreach ( $satirlar as $s ) {
		imagettftext( $im, 50 * $S, 0, $x, (int) $y, $c( '#F4F1EA' ), $fontlar['serif'], $s );
		$y += 66 * $S;
	}
	if ( ! empty( $v['alt'] ) ) {
		$alt = denetim_izi_kapak_satirlar( $v['alt'], $fontlar['normal'], 21 * $S, 600 * $S, 1 );
		imagettftext( $im, 21 * $S, 0, $x, (int) ( $y - 8 * $S ), $c( '#C9D6CF' ), $fontlar['normal'], $alt[0] );
	}

	/* alt satır: logo + marka, tarih */
	$by = 560 * $S;
	$t  = 0.36 * $S;
	$lx = $x;
	$ly = $by - 40 * $S;
	denetim_izi_kapak_yol( $im, array( array( 26, 72 ), array( 48, 98 ), array( 70, 46 ) ), false, $c( '#F4F1EA' ), $lx, $ly, $t, 17 * $t );
	imagefilledellipse( $im, (int) ( $lx + 81 * $t ), (int) ( $ly + 20 * $t ), (int) ( 24 * $t ), (int) ( 24 * $t ), $c( '#D4952B' ) );
	$mx = $lx + 52 * $S;
	imagettftext( $im, 24 * $S, 0, (int) $mx, (int) $by, $c( '#E7EFEA' ), $fontlar['kalin'], 'denetim' );
	$b = imagettfbbox( 24 * $S, 0, $fontlar['kalin'], 'denetim ' );
	imagettftext( $im, 24 * $S, 0, (int) ( $mx + $b[2] - $b[0] ), (int) $by, $c( '#F2C46D' ), $fontlar['kalin'], 'izi' );
	if ( ! empty( $v['tarih'] ) ) {
		$b = imagettfbbox( 19 * $S, 0, $fontlar['normal'], $v['tarih'] );
		imagettftext( $im, 19 * $S, 0, (int) ( 1128 * $S - ( $b[2] - $b[0] ) ), (int) $by, $c( '#C9D6CF' ), $fontlar['normal'], $v['tarih'] );
	}

	$out = imagecreatetruecolor( 1200, 630 );
	imagecopyresampled( $out, $im, 0, 0, 0, 0, 1200, 630, $W, $H );
	$ok = imagepng( $out, $dosya, 6 );
	imagedestroy( $im );
	imagedestroy( $out );
	return $ok;
}

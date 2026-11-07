<?php
/**
 * Title: Ana sayfa
 * Slug: aoa/home
 * Categories: aoa
 * Inserter: no
 */
$aoa_v = esc_url( get_theme_file_uri( 'assets/video/' ) );
?>
<!-- wp:group {"className":"w","layout":{"type":"default"}} -->
<div class="wp-block-group w"><!-- wp:group {"tagName":"section","className":"lead","layout":{"type":"default"}} -->
<section class="wp-block-group lead"><!-- wp:group {"className":"lead-box has-bgv","layout":{"type":"default"}} -->
<div class="wp-block-group lead-box has-bgv"><!-- wp:html -->
<div class="bgv" aria-hidden="true" data-bgv="<?php echo $aoa_v; ?>yazi"></div>
<!-- /wp:html -->

<!-- wp:query {"queryId":1,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":false,"sticky":""},"className":"lead-main"} -->
<div class="wp-block-query lead-main"><!-- wp:post-template -->
<!-- wp:post-terms {"term":"category","className":"kick"} /-->
<!-- wp:post-title {"level":1,"isLink":true} /-->
<!-- wp:post-excerpt {"moreText":"","excerptLength":45} /-->
<!-- wp:post-date {"format":"j F Y"} /-->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:html -->
<div class="kick">Hoş geldiniz</div>
<h1>Denetim, suistimal ve uyum üzerine notlar</h1>
<p class="dek">Kamu ve özel sektörde on beş yıllık denetim ve inceleme deneyiminden analizler, yöntem dosyaları ve kaynaklar. İlk yazılar hazırlanıyor; o zamana kadar Dosyalar bölümüne göz atabilirsiniz.</p>
<div class="by">Aykut Ozan Alan</div>
<!-- /wp:html -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="stack">
<article><div class="kick">Dosya 01</div><h3><a href="/dosyalar/#dosya-01">E-fatura ve e-defter verisinde suistimal izleri</a></h3><div class="meta">İzler ve kontroller</div></article>
<article><div class="kick">Dosya 02</div><h3><a href="/dosyalar/#dosya-02">Satın almada çıkar çatışması ve tedarikçi suistimali</a></h3><div class="meta">İzler ve kontroller</div></article>
<article><div class="kick">Akademik</div><h3><a href="/akademik/">Tezler ve akademik çalışmalar</a></h3><div class="meta">Doktora ve yüksek lisans</div></article>
</div>
<!-- /wp:html --></section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","className":"sec","anchor":"yazilar","layout":{"type":"default"}} -->
<section id="yazilar" class="wp-block-group sec"><!-- wp:html -->
<div class="sec-head"><h2>Son yazılar</h2></div>
<!-- /wp:html -->

<!-- wp:query {"queryId":2,"query":{"perPage":3,"pages":0,"offset":1,"postType":"post","order":"desc","orderBy":"date","inherit":false},"className":"cards"} -->
<div class="wp-block-query cards"><!-- wp:post-template -->
<!-- wp:post-terms {"term":"category"} /-->
<!-- wp:post-title {"level":3,"isLink":true} /-->
<!-- wp:post-excerpt {"moreText":"","excerptLength":24} /-->
<!-- wp:post-date {"format":"j F Y"} /-->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:html -->
<p class="empty">İlk analizler hazırlanıyor. Yayımlandıkça burada yer alacak.</p>
<!-- /wp:html -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></section>
<!-- /wp:group -->

</div>
<!-- /wp:group -->

<!-- wp:html -->
<section class="fileband has-bgv" aria-labelledby="dosya-baslik"><div class="bgv" aria-hidden="true" data-bgv="<?php echo $aoa_v; ?>dosyalar"></div><div class="w">
<div>
<div class="fno">DOSYALAR</div>
<h2 id="dosya-baslik">Suistimal çoğu zaman kayıtlarda görünür. Mesele nereye bakacağını bilmek.</h2>
<p>Her dosya bir suistimal türünü uçtan uca ele alır: nasıl işler, hangi izleri bırakır, hangi kontroller önler.</p>
<a class="go" href="/dosyalar/">Tüm dosyalar</a>
</div>
<div class="flist">
<a href="/dosyalar/#dosya-01"><span class="n">01</span><div><h3>E-fatura ve e-defter verisinde suistimal izleri</h3><p>Mükerrer ödeme, yuvarlak tutar, hafta sonu kaydı</p></div></a>
<a href="/dosyalar/#dosya-02"><span class="n">02</span><div><h3>Satın almada çıkar çatışması ve tedarikçi suistimali</h3><p>Çalışan ile tedarikçi arasındaki görünmeyen bağlar</p></div></a>
<a href="/dosyalar/#dosya-03"><span class="n">03</span><div><h3>Sahte ve yanıltıcı belge</h3><p>Kapasitesi olmayan tedarikçi, geri dönen ödeme</p></div></a>
</div>
</div></section>
<!-- /wp:html -->

<!-- wp:html -->
<div class="w">
<section class="sec">
<div class="sec-head"><h2>Rakamlarla mesleki suistimal</h2></div>
<div class="nums">
<div><b>%5</b><span>Kuruluşların suistimale kaptırdığı tahmini yıllık gelir payı</span></div>
<div><b>2.402</b><span>143 ülkede incelenen gerçek suistimal vakası</span></div>
<div><b>%50+</b><span>İç kontrol eksikliği ya da kontrollerin aşılmasıyla bağlantılı vakalar</span></div>
<div><b>%43</b><span>Bir ihbarla ortaya çıkan vakalar; ihbarların yarısından fazlası çalışanlardan</span></div>
</div>
<p class="src-note">Kaynak: ACFE, <a href="https://www.acfe.com/about-the-acfe/newsroom-for-media/press-releases/press-release-detail?s=occupational-fraud-2026-a-report-to-the-nations-pr" target="_blank" rel="noopener">Occupational Fraud 2026: A Report to the Nations</a> (Mayıs 2026)</p>
</section>

</div>
<section class="libband has-bgv" id="kutuphane" aria-labelledby="kutuphane-baslik"><div class="bgv" aria-hidden="true" data-bgv="<?php echo $aoa_v; ?>kutuphane"></div><div class="w">
<div>
<div class="fno">KÜTÜPHANE</div>
<h2 id="kutuphane-baslik">Temel kaynaklar</h2>
<p>Denetim, suistimal incelemesi ve uyum çalışmalarında başvurduğum standartlar, çerçeveler ve mevzuat.</p>
</div>
<ul class="lib">
<li><a href="https://www.theiia.org/en/standards/" target="_blank" rel="noopener">Küresel İç Denetim Standartları</a><span>The IIA · standartlar</span></li>
<li><a href="https://www.coso.org/" target="_blank" rel="noopener">COSO İç Kontrol Çerçevesi</a><span>COSO · çerçeve</span></li>
<li><a href="https://www.fatf-gafi.org/" target="_blank" rel="noopener">FATF Tavsiyeleri</a><span>FATF · AML/CFT</span></li>
<li><a href="https://masak.hmb.gov.tr/" target="_blank" rel="noopener">MASAK mevzuatı</a><span>Türkiye · uyum</span></li>
<li><a href="https://www.kgk.gov.tr/" target="_blank" rel="noopener">KGK denetim standartları</a><span>Türkiye · denetim</span></li>
<li><a href="https://www.acfe.com/" target="_blank" rel="noopener">ACFE kaynakları</a><span>Suistimal inceleme</span></li>
</ul>
</div></section>
<div class="w">
<section class="sec acad-sec">
<aside class="acad has-bgv"><div class="bgv" aria-hidden="true" data-bgv="<?php echo $aoa_v; ?>akademik"></div>
<?php
$ak_kat  = get_category_by_slug( 'akademik' );
$ak_son  = $ak_kat ? get_posts( array( 'category' => $ak_kat->term_id, 'numberposts' => 1, 'post_status' => 'publish' ) ) : array();
if ( $ak_son ) :
	$p   = $ak_son[0];
	$yz  = get_the_terms( $p, 'akademisyen' );
	$kim = is_array( $yz ) ? implode( ', ', array_map( function ( $t ) { return trim( get_term_meta( $t->term_id, 'ak_unvan', true ) . ' ' . $t->name ); }, $yz ) ) : '';
?>
<div class="kick">Akademik<?php echo $kim ? ' · ' . esc_html( $kim ) : ''; ?></div>
<h3><a href="<?php echo esc_url( get_permalink( $p ) ); ?>"><?php echo esc_html( get_the_title( $p ) ); ?></a></h3>
<?php if ( has_excerpt( $p ) ) : ?><p><?php echo esc_html( get_the_excerpt( $p ) ); ?></p><?php endif; ?>
<div class="links"><a href="<?php echo esc_url( get_permalink( $p ) ); ?>">Yazıyı oku</a><a href="/akademik/">Tüm akademik yazılar ve tezler</a></div>
<?php else : ?>
<div class="kick">Akademik</div>
<h3>Local Agricultural Relations and Farmer Strategies: The Case of Çiğdemli</h3>
<p>Doktora tezi, ODTÜ, 2024. Orta Anadolu'da bir kasabada tarımsal ilişkiler, sınıflar ve çiftçi stratejileri.</p>
<div class="links"><a href="/akademik/">Tezler, özetler ve PDF</a><a href="https://open.metu.edu.tr/handle/11511/111315" target="_blank" rel="noopener">OpenMETU</a></div>
<?php endif; ?>
</aside>
</section>
</div>
<!-- /wp:html -->

<!-- wp:html -->
<div class="w"><aside class="yazar" aria-label="Yazar"><svg class="imza" viewBox="86.9 61.1 906.4 957.8" aria-hidden="true"><path fill="currentColor" d="M549.3,1018.7c-29-1.2-58.2-3.3-86.3-10.6c-18.5-5.3-36.3-13.3-53.7-21.4c-87-40.5-162.9-107.3-208.1-192.2c-24,29.8-47.9,59.6-71.8,89.4c-6.6,8.2-13.2,16.4-19.8,24.6c-5.3,7.9-12.1,14.4-21.1,17.8c-0.4,0.4-1.2-0.2-1.4-0.6c-2.1-14.3,11.1-24.3,18.4-35.1c29.2-37.2,58.8-74.1,88.5-110.9c-47.7-99.8-36.3-217,4.9-317c73.8-182.1,274.6-295.3,466.8-236.5c33.3-38.5,65.2-78,97.5-117.3c11.7-13.9,23.2-28.5,35.8-41.6c2.3-2.5,4.7-5,8-6.1c7.6-0.8,15.3,5.2,18.4,11.9c2,4.9-0.6,10.4-2.3,15.1c-3.7,9.6-8,19.1-12.6,28.3c-23,46-47.5,91.3-70.5,137.3c155.6,70.7,282.8,219.5,247.2,399.3c-12.6,82.8-55.6,160.8-120.9,213.5c-82.4,70-200.3,62.8-257.6-34.1c-33.4-56.7-40.2-124.7-37.2-189.3c6.3-139.3,63.9-270,128.2-391.6c-11.4-4-23-7.8-34.8-10.7C512.6,421.8,358,600.8,209.1,784.6C257.8,890,357.2,967.1,465.2,1005c17.6,4.7,35.4,6.9,53.4,8.4c10.6,0.9,21.3,1.3,32,1.8c2.1,0.3,4.3,1.1,6.1,2c-1.1,1.4-2.8,1.7-4.5,1.7C551.2,1018.9,550.2,1018.8,549.3,1018.7z M622.2,570.2c-21,112.5-37.8,348,136,323.4c0,0-0.1,0-0.1,0c53.9-9,98.6-44.9,132.5-86c55.6-66.9,80.5-155.8,77.5-241.8C960.3,429,855.9,317.4,734.2,265.3C686.2,362.5,642.7,463.4,622.2,570.2z M229.5,450.9c-41.6,83.7-63.9,188.5-39,280c1.7,6.5,3.6,13,5.6,19.5c1.9,6.3,4.1,12.4,6.5,18.5c147.3-179.8,302.1-353.3,452.5-530.5c-26.9-6.7-54-9.9-80.8-9.9C430.2,228.6,292.6,320,229.5,450.9z M725.5,170.7c-17,19.2-33.8,38.7-50.4,58.3c1.2,0.4,2.5,0.7,3.7,1.1c6.8,2,13.4,4.5,20.1,6.8c2.5,0.8,4.9,1.8,7.4,2.7c23.7-43.2,48.7-85.7,73.9-128C761.6,130.9,743.3,150.6,725.5,170.7z"/></svg><div><b>Aykut Ozan Alan</b><p>Denetim İzi'nin kurucusu ve editörü. Siyaset bilimi ve kamu yönetimi doktoru, Sertifikalı İç Denetçi (CIA).</p></div><a href="/hakkinda/">Hakkında &rarr;</a></aside></div>
<!-- /wp:html -->

<!-- wp:group {"className":"w","layout":{"type":"default"}} -->
<div class="wp-block-group w"><!-- wp:group {"tagName":"section","className":"sec news","layout":{"type":"default"}} -->
<section class="wp-block-group sec news"><!-- wp:html -->
<div><h2>Yeni yazılar e-postanızda</h2><p>Her ay bir analiz ve bir suistimal dosyası yayımlıyorum. Abone olursanız yeni yazılar yayımlandığında e-postanıza gelir.</p></div>
<!-- /wp:html -->

<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:jetpack/subscriptions {"showSubscribersTotal":false,"buttonOnNewLine":false,"submitButtonText":"Abone ol"} /-->

<!-- wp:html -->
<p class="kvkk">E-posta adresiniz yalnızca yeni yazıların gönderimi için kullanılır; dilediğiniz an abonelikten çıkabilirsiniz. Ayrıntılar: <a href="/gizlilik/">Gizlilik ve kişisel veriler</a>.</p>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group --></div>
<!-- /wp:group -->

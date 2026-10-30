<?php
/**
 * Title: Ana sayfa
 * Slug: aoa/home
 * Categories: aoa
 * Inserter: no
 */
?>
<!-- wp:group {"className":"w","layout":{"type":"default"}} -->
<div class="wp-block-group w"><!-- wp:group {"tagName":"section","className":"lead","layout":{"type":"default"}} -->
<section class="wp-block-group lead"><!-- wp:query {"queryId":1,"query":{"perPage":1,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","inherit":false,"sticky":""},"className":"lead-main"} -->
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
<!-- /wp:query -->

<!-- wp:html -->
<div class="stack">
<article><div class="kick">Dosya 01</div><h3><a href="/dosyalar/#dosya-01">E-fatura ve e-defter verisinde suistimal izleri</a></h3><div class="meta">İzler ve kontroller</div></article>
<article><div class="kick">Dosya 02</div><h3><a href="/dosyalar/#dosya-02">Satın almada çıkar çatışması ve tedarikçi suistimali</a></h3><div class="meta">İzler ve kontroller</div></article>
<article><div class="kick">Akademik</div><h3><a href="/hakkinda/#akademik">Tezler ve akademik çalışmalar</a></h3><div class="meta">Doktora ve yüksek lisans</div></article>
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
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:html -->
<section class="fileband" aria-labelledby="dosya-baslik"><div class="w">
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
<div><b>1.921</b><span>138 ülkede incelenen gerçek suistimal vakası</span></div>
<div><b>%50+</b><span>İç kontrol eksikliği ya da kontrollerin aşılmasıyla bağlantılı vakalar</span></div>
<div><b>%63</b><span>Sürpriz denetimlerin suistimal kaybında sağladığı azalma</span></div>
</div>
<p class="src-note">Kaynak: ACFE, <a href="https://www.acfe.com/fraud-resources/report-to-the-nations-archive" target="_blank" rel="noopener">Occupational Fraud 2024: A Report to the Nations</a></p>
</section>

<section class="sec duo" id="kutuphane">
<div>
<div class="sec-head"><h2>Kütüphane</h2></div>
<ul class="lib">
<li><a href="https://www.theiia.org/en/standards/" target="_blank" rel="noopener">Küresel İç Denetim Standartları</a><span>The IIA · standartlar</span></li>
<li><a href="https://www.coso.org/" target="_blank" rel="noopener">COSO İç Kontrol Çerçevesi</a><span>COSO · çerçeve</span></li>
<li><a href="https://www.fatf-gafi.org/" target="_blank" rel="noopener">FATF Tavsiyeleri</a><span>FATF · AML/CFT</span></li>
<li><a href="https://masak.hmb.gov.tr/" target="_blank" rel="noopener">MASAK mevzuatı</a><span>Türkiye · uyum</span></li>
<li><a href="https://www.kgk.gov.tr/" target="_blank" rel="noopener">KGK denetim standartları</a><span>Türkiye · denetim</span></li>
<li><a href="https://www.acfe.com/" target="_blank" rel="noopener">ACFE kaynakları</a><span>Suistimal inceleme</span></li>
</ul>
</div>
<aside class="acad">
<div class="kick">Akademik</div>
<h3>Local Agricultural Relations and Farmer Strategies: The Case of Çiğdemli</h3>
<p>Doktora tezi, ODTÜ, 2024. Orta Anadolu'da bir kasabada tarımsal ilişkiler, sınıflar ve çiftçi stratejileri.</p>
<div class="links"><a href="/hakkinda/#akademik">Tüm akademik çalışmalar</a><a href="https://open.metu.edu.tr/handle/11511/111315" target="_blank" rel="noopener">OpenMETU</a></div>
</aside>
</section>
</div>
<!-- /wp:html -->

<!-- wp:group {"className":"w","layout":{"type":"default"}} -->
<div class="wp-block-group w"><!-- wp:group {"tagName":"section","className":"sec news","layout":{"type":"default"}} -->
<section class="wp-block-group sec news"><!-- wp:html -->
<div><h2>Haftalık not</h2><p>Her cuma, denetim ve uyum dünyasından seçilmiş gelişmeler ve kısa bir yorum.</p></div>
<!-- /wp:html -->

<!-- wp:group {"layout":{"type":"default"}} -->
<div class="wp-block-group"><!-- wp:jetpack/subscriptions {"showSubscribersTotal":false,"buttonOnNewLine":false,"submitButtonText":"Abone ol"} /-->

<!-- wp:html -->
<p class="kvkk">E-posta adresiniz yalnızca haftalık notun gönderimi için kullanılır; dilediğiniz an abonelikten çıkabilirsiniz.</p>
<!-- /wp:html --></div>
<!-- /wp:group --></section>
<!-- /wp:group --></div>
<!-- /wp:group -->

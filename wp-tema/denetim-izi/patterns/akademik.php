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
<p>Farklı üniversitelerden akademisyenlerin makaleleri, değerlendirmeleri ve tezleri. Her çalışmanın künyesi, atıf bilgisi ve yazarının profili kendi sayfasında.</p>
</div></section>
<?php
$ak_kat     = get_category_by_slug( 'akademik' );
$ak_yazilar = $ak_kat ? get_posts( array( 'category' => $ak_kat->term_id, 'numberposts' => 12, 'post_status' => 'publish' ) ) : array();
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
<h2 id="ak-son-h" class="ak-blok-h">Son eklenenler</h2>
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
<div class="w"><h2 class="ak-blok-h ak-tez-h" id="tezler">Tezler</h2></div>
<div class="w"><div class="theses">

<article class="thesis" id="doktora" aria-labelledby="dr-h">
<a class="cover" href="<?php echo $pdf_dr; ?>" target="_blank" rel="noopener" aria-label="Doktora tezinin tam metnini aç (PDF)"><img src="<?php echo $aoa_tez; ?>doktora.webp" alt="Doktora tezinin kapak sayfası" width="480" height="679" loading="lazy"></a>
<div class="tbody">
<div class="kick">Doktora · 2024</div>
<h2 id="dr-h">Local Agricultural Relations and Farmer Strategies: The Case of Çiğdemli</h2>
<p class="tr-title" lang="tr">Yerel Tarımsal İlişkiler ve Çiftçi Stratejileri: Çiğdemli Örneği</p>
<p class="inst">Orta Doğu Teknik Üniversitesi, Sosyal Bilimler Enstitüsü, Siyaset Bilimi ve Kamu Yönetimi · Tez yöneticisi: Doç. Dr. Münis Seven Ağır · Eylül 2024, 512 sayfa · İngilizce</p>
<div class="abs" lang="tr">
<h3>Öz</h3>
<div class="clamp" id="dr-oz">
<p>Köyün ve köylülüğün bir araştırma nesnesi olarak işlevini kaybetmesi, kırsal ve kentsel alanlar arasındaki sınırların bulanıklaşması ve tarımın tarım-gıda zincirleri, çevre ve gıda güvenliği konularının birer alt unsuruna indirgenmesi, yerel tarımsal ilişkilerin özgün bir inceleme alanı olarak ihmal edilmesine yol açmıştır. Buna paralel olarak özellikle İç Anadolu’nun tarımsal şartlar açısından dezavantajlı, nüfusu yaşlanan ve azalan kasaba ve köyleri adeta ölüm döşeğinde görülmekte, bu bölgelerde küçük çiftçilerin, hatta tüm çiftçilerin sahneyi terk ettiği bir gelecek tasavvur edilmektedir. Ancak, gerçekte, bu kasaba ve köyler, sosyal sınıfların dönüştüğü, tasfiye edildiği ve yeni sınıfların ortaya çıktığı büyük bir sosyal, kültürel, demografik ve ekonomik dönüşümün merkezindedir.</p>
<p>Bu dönüşümü anlamak için, tarımsal ilişkilerin çok boyutlu yapısını ve çevresel ve tarım dışı etkenlerle olan etkileşimlerini gösterebilecek bütüncül ve aşağıdan yukarı bir yaklaşıma ihtiyaç vardır. Bu tez, belirtilen özellikleri sergileyen bir Anadolu kasabası olan Çiğdemli'deki tarımsal alandaki sosyal ve sınıfsal yapıları, ekonomik ve ekonomi dışı ilişkileri ve güç dinamiklerini Bourdieu'nun teorik çerçevesi ve tarımsal alan, tarımsal habitus ve tarımsal sermaye kavramlarını kullanarak analiz etmeyi amaçlamaktadır. Bu bağlamda, değişen dış koşullar altında sosyal sınıflar arasındaki farklılaşmayı dikkate alarak, çiftçi ailelerinin tarımsal sektörden çıkma veya tarımsal sektörde kalma stratejilerini, tarımsal alana yeni girenleri, tarımsal ilişkilerdeki enformel yapıları ve nesiller arası bir perspektiften ekonomik olmayan değerlerin ve siyasal ilişkilerin rolünü incelemektedir.</p>
</div>
<button type="button" class="more" data-clamp="dr-oz" aria-controls="dr-oz" aria-expanded="false">Özetin tamamı</button>
</div>
<details class="en" lang="en"><summary>Abstract (English)</summary>
<p>The decline of the village and peasantry as objects of research, the blurring of boundaries between rural and urban areas, and the reduction of agriculture to a subordinate element of agri-food chains, environment and food security have led to the neglect of local agricultural relations as a distinct field of study. Correspondingly, particularly in Central Anatolia, towns and villages that are disadvantaged in terms of agricultural conditions, with aging and declining populations, appear to be on their deathbeds, with a future envisioned where small farmers, and indeed all farmers, have exited the scene. However, these towns and villages are at the heart of a significant social, cultural, demographic, and economic transformation, where social classes are being transformed, dissolved, and new classes are emerging.</p>
<p>To understand this transformation, there is a need for a holistic and bottom-up approach that can illustrate the multidimensional structure of agricultural relations, and their interactions with environmental and non-agricultural factors. This dissertation aims to analyze the social and class structures, economic and non-economic relationships, and power dynamics in the agricultural field of Çiğdemli, an Anatolian town exhibiting above-mentioned characteristics, using Bourdieu's theoretical framework and concepts of agricultural field, agricultural habitus, and agricultural capital. It considers the differentiation among social classes under changing external conditions, examining the strategies of farming families to either exit or remain within the agricultural field, the new entrants into the agricultural field, the informal structures within agricultural relations, and the role of non-economic values and political relationships from an intergenerational perspective.</p>
</details>
<div class="chips"><span>Bourdieu</span><span>Tarımsal alan</span><span>Tarımsal sermaye</span><span>Tarımsal ilişkiler</span><span>Çiğdemli</span></div>
<div class="acts">
<a class="dl" href="<?php echo $pdf_dr; ?>" download>PDF indir <small>10,8 MB</small></a>
<a href="<?php echo $pdf_dr; ?>" target="_blank" rel="noopener">Tarayıcıda aç</a>
<a href="https://open.metu.edu.tr/handle/11511/111315" target="_blank" rel="noopener">OpenMETU kaydı</a>
<a href="https://tez.yok.gov.tr/UlusalTezMerkezi/" target="_blank" rel="noopener" title="Ulusal Tez Merkezi'nde tez numarasıyla aratın">YÖK Tez Merkezi · Tez No 896505</a>
<button type="button" data-cite-toggle="cite-dr" aria-controls="cite-dr" aria-expanded="false">Atıf bilgisi</button>
</div>
<div class="cite" id="cite-dr" hidden><span id="cite-dr-t">Alan, A. O. (2024). <i>Local agricultural relations and farmer strategies: The case of Çiğdemli</i> [Doctoral dissertation, Middle East Technical University]. OpenMETU. https://open.metu.edu.tr/handle/11511/111315</span> <button type="button" class="copy" data-copy="cite-dr-t">Kopyala</button></div>
</div>
</article>

<article class="thesis" id="yuksek-lisans" aria-labelledby="yl-h">
<a class="cover" href="<?php echo $pdf_yl; ?>" target="_blank" rel="noopener" aria-label="Yüksek lisans tezinin tam metnini aç (PDF)"><img src="<?php echo $aoa_tez; ?>yuksek-lisans.webp" alt="Yüksek lisans tezinin kapak sayfası" width="480" height="678" loading="lazy"></a>
<div class="tbody">
<div class="kick">Yüksek lisans · 2012</div>
<h2 id="yl-h">Mitos – Tarih İlişkisi: Siyasal Bir İnceleme</h2>
<p class="inst">Ankara Üniversitesi, Sosyal Bilimler Enstitüsü, Kamu Yönetimi ve Siyaset (Siyaset Bilimi) Anabilim Dalı · Danışman: Prof. Dr. Zeliha Etöz · Türkçe</p>
<div class="abs" lang="tr">
<h3>Özet</h3>
<div class="clamp" id="yl-oz">
<p>Tez, modern toplumlarda tarihin nasıl çarpıtıldığını anlayabilmek için toplumsal bellek temelli bir yaklaşım geliştirmek gerektiğini varsaymaktadır. Günümüzde mit, uyduruk ve çarpıtılmış tarihi adlandırmak için kullanılmakta; bu çarpıtılma, çeşitli öznelerin siyasal amaçlarla tarihi çarpıtma istekleri ile açıklanmaktadır. Oysa tezde, tarihin sürekli olarak çarpıtılması sürecini anlamak için, çarpıtan öznelerin amaçlarına değil, toplumsal yapı ve süreçlere bakmak gerektiği varsayılmaktadır.</p>
<p>Mitin kurucu özelliklerinin, ilkel toplumlar ile modern toplumları birbirinden ayırdığı düşünülen zihinsel farklar olmadığı, bunun yerine mitin toplumsal bellek ile birlikte düşünülmesi ve toplumsal bellek çalışmalarının sağladığı imkanlar üzerinden tanımlanması gerektiği ileri sürülecektir. Bu yönden tez, modern toplumlar ile ilkel toplumları kapsayacak, siyasal nitelikli bir mit kavramsallaştırılması girişimidir. Bu bağlamda, kökene işaret eden bir tarihsel anlatının, yoğun simgeler içerdiğinde, çerçeve bir anlatı niteliği aldığında mit olarak adlandırılabileceği iddia edilecektir.</p>
</div>
<button type="button" class="more" data-clamp="yl-oz" aria-controls="yl-oz" aria-expanded="false">Özetin tamamı</button>
</div>
<details class="en" lang="en"><summary>Abstract (English)</summary>
<p>The thesis assumes that it needs to be improved an approach based on collective memory to understand how the history is being distorted. Contemporarily myth is used to refer to invented/distorted history and this distortion is explained with the abuses of subjects for political purposes. Whereas, it is assumed that, it needs to be focused on social constructions to understand this process. It is asserted that the consisting features of myth are not the differences that divide the primitive societies and the modern ones; instead of this, myth have to be considered with the collective memory and be defined via conceptual advantages of this definition. Therefore, the thesis is a attempt of conceptionalization that is political and that includes both primitive and modern societies. In this context, it will be argued that whereas a historical narrative includes dense symbols and becomes a framework, then it should be defined as myth.</p>
</details>
<div class="chips"><span>Mit</span><span>Tarih</span><span>Toplumsal bellek</span><span>Siyaset kuramı</span></div>
<div class="acts">
<a class="dl" href="<?php echo $pdf_yl; ?>" download>PDF indir <small>1,6 MB</small></a>
<a href="<?php echo $pdf_yl; ?>" target="_blank" rel="noopener">Tarayıcıda aç</a>
<button type="button" data-cite-toggle="cite-yl" aria-controls="cite-yl" aria-expanded="false">Atıf bilgisi</button>
</div>
<div class="cite" id="cite-yl" hidden><span id="cite-yl-t">Alan, A. O. (2012). <i>Mitos – tarih ilişkisi: Siyasal bir inceleme</i> [Yüksek lisans tezi, Ankara Üniversitesi]. https://denetimizi.com/akademik/</span> <button type="button" class="copy" data-copy="cite-yl-t">Kopyala</button></div>
</div>
</article>


</div></div>
<!-- /wp:html -->

(function () {
	var path = location.pathname.replace(/\/+$/, '') || '/';
	document.querySelectorAll('nav.main a').forEach(function (a) {
		var p = (a.getAttribute('href') || '').split('#')[0].replace(/\/+$/, '') || '/';
		if (a.getAttribute('href').indexOf('#') === -1 && p === path) { a.setAttribute('aria-current', 'page'); }
	});
	document.querySelectorAll('[data-cite-toggle]').forEach(function (btn) {
		var box = document.getElementById(btn.getAttribute('data-cite-toggle'));
		if (!box) { return; }
		btn.addEventListener('click', function () {
			box.hidden = !box.hidden;
			btn.setAttribute('aria-expanded', String(!box.hidden));
		});
	});
	document.querySelectorAll('[data-copy]').forEach(function (btn) {
		btn.addEventListener('click', function () {
			var el = document.getElementById(btn.getAttribute('data-copy'));
			if (!el) { return; }
			var text = el.textContent.trim();
			function select() { var r = document.createRange(); r.selectNodeContents(el); var s = getSelection(); s.removeAllRanges(); s.addRange(r); }
			try {
				navigator.clipboard.writeText(text).then(function () {
					var t = btn.textContent; btn.textContent = 'Kopyalandı';
					setTimeout(function () { btn.textContent = t; }, 2000);
				}, select);
			} catch (e) { select(); }
		});
	});
	if (/^#dosya-\d{2}$/.test(location.hash)) {
		var d = document.querySelector(location.hash);
		if (d && d.tagName === 'DETAILS') { d.open = true; d.scrollIntoView(); }
	}
	(function () {
		// dosya yazıları: videoyu adresteki dosya numarasından seç (yoksa genel dosyalar videosu)
		var DOSYA_VIDEOLARI = ['01', '02', '03', '04', '05', '06'];
		var me = document.querySelector('script[src*="/assets/site.js"]');
		var vdir = me ? me.src.split('/assets/site.js')[0] + '/assets/video/' : '';
		document.querySelectorAll('[data-bgv-dosya]').forEach(function (b) {
			var m = location.pathname.match(/\/dosya-(\d{2})-/);
			b.setAttribute('data-bgv', vdir + (m && DOSYA_VIDEOLARI.indexOf(m[1]) > -1 ? 'dosya-' + m[1] : 'dosyalar'));
		});
		var boxes = document.querySelectorAll('[data-bgv]');
		if (!boxes.length) { return; }
		var still = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
		var save = navigator.connection && navigator.connection.saveData;
		boxes.forEach(function (box) {
			var base = box.getAttribute('data-bgv');
			box.style.backgroundImage = 'url("' + base + '.jpg")';
			if (still || save || !('IntersectionObserver' in window)) { return; }
			var v;
			new IntersectionObserver(function (es) {
				es.forEach(function (e) {
					if (e.isIntersecting) {
						if (!v) {
							v = document.createElement('video');
							v.muted = true; v.loop = true; v.playsInline = true; v.preload = 'auto';
							v.setAttribute('muted', ''); v.setAttribute('playsinline', '');
							['webm', 'mp4'].forEach(function (x) { var s = document.createElement('source'); s.src = base + '.' + x; s.type = 'video/' + x; v.appendChild(s); });
							v.addEventListener('playing', function () { v.classList.add('on'); });
							box.appendChild(v);
						}
						var p = v.play(); if (p && p.catch) { p.catch(function () {}); }
					} else if (v) { v.pause(); }
				});
			}, { rootMargin: '120px' }).observe(box);
		});
	})();
})();

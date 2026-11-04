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
	document.querySelectorAll('[data-clamp]').forEach(function (btn) {
		var box = document.getElementById(btn.getAttribute('data-clamp'));
		if (!box) { return; }
		btn.addEventListener('click', function () {
			var open = box.classList.toggle('open');
			btn.setAttribute('aria-expanded', String(open));
			btn.textContent = open ? 'Özeti kısalt' : 'Özetin tamamı';
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
		var vdir = window.AOA_VIDEO || (location.origin + '/wp-content/themes/denetim-izi/assets/video/');
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
			var v, gorunur = false;
			document.addEventListener('visibilitychange', function () {
				if (!v) { return; }
				if (document.hidden) { v.pause(); } else if (gorunur) { var q = v.play(); if (q && q.catch) { q.catch(function () {}); } }
			});
			new IntersectionObserver(function (es) {
				es.forEach(function (e) {
					gorunur = e.isIntersecting;
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
	(function () {
		// gündem şeridi: içerik sürekli akar; üzerine gelince ya da klavyeyle odaklanınca durur
		var w = document.querySelector('.ticker .w');
		if (!w || w.querySelector('.tk-view')) { return; }
		var lbl = w.querySelector('.lbl');
		var view = document.createElement('div'); view.className = 'tk-view';
		var track = document.createElement('div'); track.className = 'tk-track';
		var set = document.createElement('div'); set.className = 'tk-set';
		Array.prototype.slice.call(w.children).forEach(function (el) {
			if (el === lbl || el.classList.contains('components-placeholder')) { return; }
			if (el.classList.contains('wp-block-rss') && !el.querySelector('li')) { return; }
			set.appendChild(el);
		});
		if (!set.querySelector('a')) { return; }
		set.querySelectorAll('a').forEach(function (a) { a.target = '_blank'; a.rel = 'noopener'; });
		track.appendChild(set); view.appendChild(track); w.appendChild(view);
		if (window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches) { w.classList.add('tk-still'); return; }
		var copy = set.cloneNode(true);
		copy.setAttribute('aria-hidden', 'true');
		copy.querySelectorAll('a').forEach(function (a) { a.setAttribute('tabindex', '-1'); });
		track.appendChild(copy);
		function hiz() { track.style.animationDuration = Math.max(30, set.offsetWidth / 45) + 's'; }
		hiz(); window.addEventListener('resize', hiz);
		// fareyle tıklanan bağlantı odakta kalıp şeridi durdurmasın
		track.addEventListener('click', function (e) {
			var a = e.target.closest && e.target.closest('a');
			if (a && e.detail > 0) { setTimeout(function () { a.blur(); }, 0); }
		});
		w.classList.add('tk-on');
	})();
})();

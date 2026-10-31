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
})();

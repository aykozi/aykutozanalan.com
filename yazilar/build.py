import json, re, html

ACFE_PR = "https://www.acfe.com/about-the-acfe/newsroom-for-media/press-releases/press-release-detail?s=occupational-fraud-2026-a-report-to-the-nations-pr"
DISC = "Bu yazı genel bilgilendirme amaçlıdır; {} görüş niteliği taşımaz."
DOSDISC = "Bu dosya yöntem anlatır; gerçek kişi, kurum ya da vaka içermez. Genel bilgilendirme amaçlıdır."

def inline(s):
    s = html.escape(s, quote=False)
    s = re.sub(r'\*\*(.+?)\*\*', r'<strong>\1</strong>', s)
    s = re.sub(r'\[([^\]]+)\]\(([^)]+)\)', r'<a href="\2">\1</a>', s)
    s = re.sub(r'(?<!href=")(https?://[^\s<]+)', lambda m: '<a href="%s" target="_blank" rel="noopener">%s</a>' % (m.group(1), m.group(1)), s)
    return s

def blocks(md):
    out = []
    lines = md.strip('\n').split('\n')
    i = 0
    while i < len(lines):
        l = lines[i].rstrip()
        if not l:
            i += 1; continue
        if l.startswith('### '):
            out.append('<!-- wp:heading {"level":3} -->\n<h3 class="wp-block-heading">%s</h3>\n<!-- /wp:heading -->' % inline(l[4:])); i += 1; continue
        if l.startswith('## '):
            out.append('<!-- wp:heading -->\n<h2 class="wp-block-heading">%s</h2>\n<!-- /wp:heading -->' % inline(l[3:])); i += 1; continue
        m = re.match(r'^(- |\d+\. )', l)
        if m:
            ordered = l[0].isdigit()
            items = []
            while i < len(lines) and re.match(r'^(- |\d+\. )', lines[i]):
                items.append(re.sub(r'^(- |\d+\. )', '', lines[i].rstrip())); i += 1
            lis = '\n'.join('<!-- wp:list-item -->\n<li>%s</li>\n<!-- /wp:list-item -->' % inline(x) for x in items)
            if ordered:
                out.append('<!-- wp:list {"ordered":true} -->\n<ol class="wp-block-list">%s</ol>\n<!-- /wp:list -->' % lis)
            else:
                out.append('<!-- wp:list -->\n<ul class="wp-block-list">%s</ul>\n<!-- /wp:list -->' % lis)
            continue
        if l.startswith('_') and l.endswith('_'):
            out.append('<!-- wp:paragraph {"className":"note"} -->\n<p class="note"><em>%s</em></p>\n<!-- /wp:paragraph -->' % inline(l[1:-1])); i += 1; continue
        out.append('<!-- wp:paragraph -->\n<p>%s</p>\n<!-- /wp:paragraph -->' % inline(l)); i += 1
    return '\n\n'.join(out)

posts = []
def add(key, slug, title, cat, excerpt, md, date):
    posts.append(dict(key=key, slug=slug, title=title, cat=cat, excerpt=excerpt, content=blocks(md), date=date))

exec(open('/home/claude/yazilar/texts.py', encoding='utf-8').read())

json.dump(posts, open('/home/claude/yazilar/posts.json', 'w', encoding='utf-8'), ensure_ascii=False)
for p in posts:
    words = len(re.sub('<[^>]+>', ' ', p['content']).split())
    print(p['key'], p['slug'], p['cat'], words)

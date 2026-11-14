"""Gündem ve rehber taslaklarını (md) Gutenberg bloklarına çevirir. build.py'deki blocks() kullanılır."""
import json, re, sys, html
src = open('build.py', encoding='utf-8').read().split('posts = []')[0]
exec(src)
def ext(s):  # site dışı bağlantılar yeni sekmede
    return re.sub(r'<a href="(https?://(?!denetimizi\.com)[^"]+)">', r'<a href="\1" target="_blank" rel="noopener">', s)
def convert(md):
    out, buf = [], []
    def flush():
        if buf: out.append(blocks('\n'.join(buf))); buf.clear()
    lines = md.split('\n'); i = 0
    while i < len(lines):
        l = lines[i]
        if l.startswith('KAYNAK: '):
            flush(); out.append('<!-- wp:paragraph {"className":"gd-kaynak"} -->\n<p class="gd-kaynak">Kaynak: %s</p>\n<!-- /wp:paragraph -->' % inline(l[8:])); i += 1; continue
        if l.startswith('| '):
            flush(); rows = []
            while i < len(lines) and lines[i].startswith('| '):
                rows.append([c.strip() for c in lines[i].strip().strip('|').split('|')]); i += 1
            th = ''.join('<th>%s</th>' % inline(c) for c in rows[0])
            tb = ''.join('<tr>%s</tr>' % ''.join('<td>%s</td>' % inline(c) for c in r) for r in rows[1:])
            out.append('<!-- wp:table -->\n<figure class="wp-block-table"><table class="has-fixed-layout"><thead><tr>%s</tr></thead><tbody>%s</tbody></table></figure>\n<!-- /wp:table -->' % (th, tb)); continue
        buf.append(l); i += 1
    flush()
    return ext('\n\n'.join(out))
res = {}
for key, f in [('gu', 'gundem/gu-2026-46.md'), ('rh', 'rehber/rh-01.md')]:
    c = convert(open(f, encoding='utf-8').read()); res[key] = c
    print(key, len(re.sub('<[^>]+>', ' ', c).split()), 'kelime')
json.dump(res, open('/tmp/yayin.json', 'w', encoding='utf-8'), ensure_ascii=False)

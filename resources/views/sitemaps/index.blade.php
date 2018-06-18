<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ url(route('sitemaps.routes')) }}</loc>
    </sitemap>
@foreach($sitemaps as $sitemap)
@foreach(range(1, $sitemap['pages']) as $page)
    <sitemap>
        <loc>{{ url(route('sitemaps.show', ['type' => $sitemap['type'], 'page' => $page])) }}</loc>
    </sitemap>
@endforeach
@endforeach
</sitemapindex>
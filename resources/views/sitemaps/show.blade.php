<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($results as $result)
   <url>
      <loc>{{ $result->url }}</loc>
   </url>
@endforeach
</urlset> 
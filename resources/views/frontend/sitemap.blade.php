<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ route('home') }}</loc>
        <lastmod>{{ now()->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    @foreach($services as $service)
    @if ($service->service_type == 'server_service')
    <url>
        <loc>{{ route('server_service_view', $service->slug) }}</loc>
        <lastmod>{{ $service->updated_at->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    @endif
    @if ($service->service_type == 'imei_service')
    <url>
        <loc>{{ route('imei_service_view', $service->slug) }}</loc>
        <lastmod>{{ $service->updated_at->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    @endif
    @if ($service->service_type == 'credit_service')
    <url>
        <loc>{{ route('credit_service_view', $service->slug) }}</loc>
        <lastmod>{{ $service->updated_at->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    @endif
    @endforeach
</urlset>

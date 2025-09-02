User-agent: *
Disallow: /login
Disallow: /my/dashboard
Disallow: /my/invoice
Disallow: /my/statement
Disallow: /my/order-history

# Allow resource files in /public
Allow: /public/*.css
Allow: /public/*.js
Allow: /public/*.jpg
Allow: /public/*.png

Sitemap: {{ route('sitemap_xml') }}

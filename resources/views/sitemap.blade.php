<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc>{{ url('/') }}</loc><changefreq>weekly</changefreq><priority>1.0</priority></url>
    <url><loc>{{ url('/services') }}</loc><changefreq>monthly</changefreq><priority>0.9</priority></url>
    <url><loc>{{ url('/portfolio') }}</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>
    <url><loc>{{ url('/blog') }}</loc><changefreq>weekly</changefreq><priority>0.8</priority></url>
    <url><loc>{{ url('/guides') }}</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>
    <url><loc>{{ url('/about') }}</loc><changefreq>monthly</changefreq><priority>0.6</priority></url>
    <url><loc>{{ url('/contact') }}</loc><changefreq>monthly</changefreq><priority>0.6</priority></url>
    <url><loc>{{ url('/faq') }}</loc><changefreq>monthly</changefreq><priority>0.5</priority></url>

    @foreach($publications as $pub)
    <url>
        <loc>{{ url('/blog/'.$pub->slug) }}</loc>
        <lastmod>{{ $pub->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>
    @endforeach

    @foreach($guides as $guide)
    <url>
        <loc>{{ url('/guides/'.$guide->slug) }}</loc>
        <lastmod>{{ $guide->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endforeach

    @foreach($portfolios as $project)
    @if($project->slug)
    <url>
        <loc>{{ url('/portfolio/'.$project->slug) }}</loc>
        <lastmod>{{ $project->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.6</priority>
    </url>
    @endif
    @endforeach
</urlset>

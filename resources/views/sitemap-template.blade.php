<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    <url>
        <loc>https://isol.is</loc>
        <changefreq>weekly</changefreq>
        <priority>0.6</priority>
    </url>
    @foreach($subpages as $page)
        <url>
            <loc>https://isol.is/{{$page->url}}</loc>
            <changefreq>monthly</changefreq>
            <priority>0.5</priority>
        </url>
    @endforeach
    @foreach($categories as $category)
        <url>
            <loc>https://isol.is/vorur/{{$category->slug}}</loc>
            <changefreq>monthly</changefreq>
            <priority>0.5</priority>
        </url>
        @if(count($category->children) > 0)
            @foreach($category->children as $child)
                <url>
                    <loc>https://isol.is/vorur/{{$category->slug}}/{{$child->slug}}</loc>
                    <changefreq>monthly</changefreq>
                    <priority>0.5</priority>
                </url>
                @if(count($child->children) > 0)
                    @foreach($child->children as $grandChild)
                        <url>
                            <loc>https://isol.is/vorur/{{$category->slug}}/{{$child->slug}}/{{$grandChild->slug}}</loc>
                            <changefreq>monthly</changefreq>
                            <priority>0.5</priority>
                        </url>
                    @endforeach
                @endif
            @endforeach
        @endif
    @endforeach
    @foreach($products as $product)
        <url>
            <loc>https://isol.is/vara/{{$product->slug}}</loc>
            <changefreq>daily</changefreq>
            <priority>0.9</priority>
            @if($product->image != null)
                <image:image>
                    <image:loc>{{url($product->image)}}</image:loc>
                    <image:caption>{{$product->name}}</image:caption>
                </image:image>
            @endif
        </url>
    @endforeach
</urlset>

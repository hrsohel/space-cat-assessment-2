<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 40px;
            padding: 20px;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .stats {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 15px 25px;
            display: inline-block;
            margin-top: 15px;
            color: white;
            font-weight: 500;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .photo-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .photo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .photo-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
            background: #f0f0f0;
        }

        .photo-card img.error {
            background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-placeholder {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #e0e0e0 0%, #f5f5f5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 3rem;
        }

        .photo-info {
            padding: 15px;
        }

        .photo-title {
            font-size: 0.95rem;
            color: #333;
            line-height: 1.5;
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .photo-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: #666;
        }

        .album-badge {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .photo-id {
            color: #999;
        }

        .pagination-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 15px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 4px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 4px 8px;
            background: white;
            border: 2px solid #667eea;
            color: #667eea;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            min-width: 32px;
            text-align: center;
        }

        .pagination a:hover {
            background: #667eea;
            color: white;
            transform: scale(1.05);
        }

        .pagination .active span {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        .pagination .disabled span {
            background: #f5f5f5;
            color: #ccc;
            border-color: #e0e0e0;
            cursor: not-allowed;
        }

        /* Style SVG arrows in pagination - More robust selectors for Laravel defaults */
        .pagination-wrapper svg,
        .pagination svg,
        nav[role="navigation"] svg {
            width: 20px !important;
            height: 20px !important;
            vertical-align: middle;
            display: inline-block;
        }

        /* Hide the redundant "Showing X to Y" text that Laravel sometimes adds */
        .pagination-wrapper nav > div:first-child {
            display: none;
        }

        /* Ensure the navigation container is centered and clean */
        .pagination-wrapper nav {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Make rel links (Previous/Next) more prominent */
        .pagination a[rel="prev"],
        .pagination a[rel="next"],
        nav span[aria-hidden="true"],
        nav a[rel="prev"],
        nav a[rel="next"] {
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Hide page numbers on small screens, show only prev/next */
        @media (max-width: 640px) {
            .pagination a,
            .pagination span {
                padding: 5px 10px;
                font-size: 0.85rem;
                min-width: 32px;
            }

            .pagination svg {
                width: 14px;
                height: 14px;
            }
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: white;
        }

        .empty-state h2 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .empty-state p {
            font-size: 1.1rem;
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .photo-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📸 Photo Gallery</h1>
            <p>Explore thousands of beautiful photos</p>
            <div class="stats">
                Showing {{ $photos->firstItem() ?? 0 }} - {{ $photos->lastItem() ?? 0 }} of {{ $photos->total() }} photos
            </div>
        </div>

        @if($photos->count() > 0)
            <div class="photo-grid">
                @foreach($photos as $photo)
                    @php
                        // Extract dimensions and color from the original URL
                        // Original format: https://via.placeholder.com/150/92c952
                        // New format: https://placehold.co/150x150/92c952/FFF
                        preg_match('/\/(\d+)\/([a-f0-9]{6})/i', $photo->thumbnail_url, $matches);
                        $size = $matches[1] ?? '150';
                        $color = $matches[2] ?? '92c952';
                        $workingImage = "https://placehold.co/{$size}x{$size}/{$color}/FFF/png?text=Photo+{$photo->id}";
                    @endphp
                    <div class="photo-card">
                        <img src="{{ $workingImage }}" alt="{{ $photo->title }}" loading="lazy">
                        <div class="photo-info">
                            <div class="photo-title">{{ $photo->title }}</div>
                            <div class="photo-meta">
                                <span class="album-badge">Album {{ $photo->album_id }}</span>
                                <span class="photo-id">#{{ $photo->id }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $photos->links() }}
            </div>
        @else
            <div class="empty-state">
                <h2>No Photos Available</h2>
                <p>Please run the fetch command to populate the database with photos.</p>
            </div>
        @endif
    </div>

    <script>
        // Handle broken images
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.photo-card img');
            let loadedCount = 0;
            let errorCount = 0;
            
            images.forEach(function(img) {
                // Check if image loads successfully
                img.addEventListener('load', function() {
                    loadedCount++;
                    console.log('Image loaded:', this.src);
                });
                
                // Handle broken images
                img.addEventListener('error', function() {
                    errorCount++;
                    console.error('Image failed to load:', this.src);
                    
                    // Create a placeholder
                    const placeholder = document.createElement('div');
                    placeholder.className = 'image-placeholder';
                    placeholder.textContent = '🖼️';
                    placeholder.title = 'Image not available: ' + this.src;
                    
                    this.parentNode.replaceChild(placeholder, this);
                });
            });
            
            // Debug info
            setTimeout(function() {
                console.log('Image loading stats:', {
                    total: images.length,
                    loaded: loadedCount,
                    errors: errorCount
                });
                
                if (errorCount > 0) {
                    console.warn('Some images failed to load. This might be due to:');
                    console.warn('1. CORS policy blocking external images');
                    console.warn('2. JSONPlaceholder URLs being unavailable');
                    console.warn('3. Network connectivity issues');
                }
            }, 3000);
        });
    </script>
</body>
</html>

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
            margin-top: 50px;
            padding: 20px;
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .pagination-wrapper nav {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 10px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: fit-content;
        }

        .pagination-wrapper nav > div:first-child,
        .pagination-wrapper nav p,
        .pagination-wrapper .hidden.sm\:flex-1 {
            display: none !important;
        }

        .pagination-wrapper nav > div:last-child,
        .pagination-wrapper .flex.justify-between.flex-1,
        .pagination-wrapper .sm\:flex.sm\:items-center.sm\:justify-between {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px;
            width: auto;
        }

        .pagination-wrapper span[aria-label="Pagination Navigation"],
        .pagination-wrapper div[role="navigation"] {
             display: flex;
             align-items: center;
             justify-content: center;
             gap: 6px;
        }

        .pagination-wrapper a, 
        .pagination-wrapper span[aria-current="page"] span,
        .pagination-wrapper span[aria-disabled="true"] span {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 42px;
            height: 42px;
            padding: 0;
            border-radius: 50%;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            line-height: 1;
        }

        .pagination-wrapper a[rel="prev"],
        .pagination-wrapper a[rel="next"],
        .pagination-wrapper span[aria-disabled="true"]:first-child span,
        .pagination-wrapper span[aria-disabled="true"]:last-child span {
            border-radius: 25px;
            padding: 0 15px;
            min-width: 50px;
        }

        .pagination-wrapper a {
            color: rgba(255, 255, 255, 0.9);
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .pagination-wrapper a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .pagination-wrapper span[aria-current="page"] span {
            background: white;
            color: #764ba2;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border: none;
        }

        .pagination-wrapper span[aria-disabled="true"] span {
            color: rgba(255, 255, 255, 0.3);
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.05);
            cursor: not-allowed;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .pagination-wrapper svg {
            width: 20px;
            height: 20px;
            stroke-width: 3;
            display: block;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .pagination-wrapper nav {
                padding: 6px;
                border-radius: 30px;
            }
            
            .pagination-wrapper a:not([rel="prev"]):not([rel="next"]),
            .pagination-wrapper span[aria-current="page"]:not(:last-child):not(:first-child) {
                display: none !important;
            }
            
            .pagination-wrapper span[aria-current="page"] span,
            .pagination-wrapper a[rel="prev"],
            .pagination-wrapper a[rel="next"] {
                display: inline-flex !important;
            }

            .pagination-wrapper a, 
            .pagination-wrapper span {
                min-width: 38px !important;
                height: 38px !important;
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
                <p>Run the fetch command to populate the database.</p>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.photo-card img').forEach(function(img) {
                img.addEventListener('error', function() {
                    const placeholder = document.createElement('div');
                    placeholder.className = 'image-placeholder';
                    placeholder.textContent = '🖼️';
                    this.parentNode.replaceChild(placeholder, this);
                });
            });
        });
    </script>
</body>
</html>

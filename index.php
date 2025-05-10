<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Image Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .gallery-item {
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 3px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .gallery-item:hover {
            transform: scale(1.02);
        }
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }
        .filename {
            padding: 10px;
            text-align: center;
            background: #f8f9fa;
            font-size: 14px;
        }
        .no-images {
            grid-column: 1/-1;
            text-align: center;
            padding: 40px;
            color: #666;
        }
        @media (max-width: 600px) {
            .gallery {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Image Gallery</h1>
        
        <div class="gallery">
            <?php
            $imageDir = 'images/';
            
            if(is_dir($imageDir)) {
                $files = scandir($imageDir);
                $imageFound = false;
                
                foreach($files as $file) {
                    if($file != '.' && $file != '..') {
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        
                        if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                            $imageFound = true;
                            echo '<div class="gallery-item">';
                            echo '<img src="'.$imageDir.$file.'" alt="'.$file.'">';
                            echo '<div class="filename">'.$file.'</div>';
                            echo '</div>';
                        }
                    }
                }
                
                if(!$imageFound) {
                    echo '<div class="no-images">No images found in images folder</div>';
                }
            } else {
                echo '<div class="no-images">Images folder not found</div>';
            }
            ?>
        </div>
    </div>
</body>
</html>

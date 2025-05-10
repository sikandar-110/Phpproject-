<?php
// Optional image upload handling
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $targetDir = "images/";
    $targetFile = $targetDir . basename($_FILES['image']['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Check if image file is actual image
    $check = getimagesize($_FILES['image']['tmp_name']);
    if($check !== false) {
        // Allow certain file formats
        if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {
            // Move the file
            if(move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $uploadSuccess = "Image uploaded successfully!";
            } else {
                $uploadError = "Sorry, there was an error uploading your file.";
            }
        } else {
            $uploadError = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    } else {
        $uploadError = "File is not an image.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Image Gallery</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .upload-form {
            margin: 20px 0;
            padding: 20px;
            background: #f0f0f0;
            border-radius: 5px;
            text-align: center;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .gallery-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            transition: transform 0.3s;
        }
        .gallery-item:hover {
            transform: scale(1.03);
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
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
            background: #f9f9f9;
            font-size: 14px;
            word-break: break-all;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
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
        <h1>PHP Image Gallery</h1>
        
        <!-- Image Upload Form -->
        <div class="upload-form">
            <form action="" method="post" enctype="multipart/form-data">
                <h3>Upload New Image</h3>
                <input type="file" name="image" accept="image/*" required>
                <button type="submit">Upload Image</button>
            </form>
            <?php
            if(isset($uploadSuccess)) {
                echo '<div class="message success">'.$uploadSuccess.'</div>';
            }
            if(isset($uploadError)) {
                echo '<div class="message error">'.$uploadError.'</div>';
            }
            ?>
        </div>
        
        <!-- Image Gallery -->
        <div class="gallery">
            <?php
            $imageDir = 'images/';
            
            // Create images directory if it doesn't exist
            if(!file_exists($imageDir)) {
                mkdir($imageDir, 0777, true);
            }
            
            if(is_dir($imageDir)) {
                $files = scandir($imageDir);
                
                foreach($files as $file) {
                    if($file != '.' && $file != '..') {
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        
                        if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                            echo '<div class="gallery-item">';
                            echo '<img src="'.$imageDir.$file.'" alt="'.$file.'">';
                            echo '<div class="filename">'.$file.'</div>';
                            echo '</div>';
                        }
                    }
                }
                
                if(count($files) <= 2) {
                    echo '<p style="grid-column:1/-1;text-align:center;">No images found. Please upload some images.</p>';
                }
            } else {
                echo '<p class="message error">Images directory not found!</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>

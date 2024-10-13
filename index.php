<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="asset/img/icon.png">
    <link rel="stylesheet" href="asset/css/style.css">
    <title>File Bridge</title>
</head>
<body>
    <?php
        $url = $_SERVER['REQUEST_URI'];
        $href = basename($url);
        $href = htmlspecialchars($href);
        
        try {
            include_once "asset/php/connection.php";
            $stmt = $db->prepare("SELECT * FROM files WHERE href = :href");
            $stmt->bindParam(":href", $href);
            $stmt->execute();
            $fileData = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($fileData) {
                $path = $fileData['path'];
                if (file_exists($path)) {
                    header('Content-Type: ' . mime_content_type($path));
                    readfile($path);
                }
            }
        } catch (Exception $e) {
            echo "Veri tabanına bağlanılamadı.";
        }
    ?>
    <section class="href-section">
        <div class="href-container">
            <div class="titleBox">
                <h1>Dosya Adresi Oluşturuldu</h1>
            </div>
            <div class="hrefBox">
                <span>
                    <?php
                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                        $host = $_SERVER['HTTP_HOST'];                        
                        $baseUrl = $protocol . $host . "/";
                        echo $baseUrl;
                    ?>
                </span>
                <p></p>
            </div>
        </div>
    </section>
    <section class="file-container">
        <div class="titleBox">
            <h1>File Bridge</h1>
        </div>
        <div class="descriptionBox">
            Make a bridge with your file.
        </div>
        <label class="uploadBox" for="uploadInput">
            <input type="file" id="uploadInput" name="file">
            <img src="asset/img/upload.png">
            <div class="text">
                <p>Drag and drop or click here<br>to upload file</p>
                <span>Upload any file from desktop</span>
            </div>
        </label>
        <div class="suffix">
            <p>Created by <a href="https://trinsyca.com" target="_blank">TrinsyCa</a></p>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="asset/script/upload.js"></script>
</body>
</html>
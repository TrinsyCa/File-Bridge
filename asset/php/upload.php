<?php
if($_SERVER['REQUEST_METHOD'] === "POST") {
    if(isset($_FILES["file"])) {
        $file = $_FILES["file"];
        $fileTmpName = $file["tmp_name"];
        $fileExt = pathinfo($file["name"], PATHINFO_EXTENSION);
        $uploadDir = "api/f/";
        $fileName = date("Y-m-d_H.i.s") . "={" . rand(1000,9999) . "}." . $fileExt;
        $filePath = $uploadDir.basename($fileName);

        // If folder isn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, recursive: true);
        }
        // Upload picture to server
        $uploadPath = "../../" . $uploadDir . basename($fileName);
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            include_once "connection.php";
            include_once "uuid.php";
            
            $href = generateUniqueUUID($db);

            $stmt = $db->prepare("INSERT INTO files SET href = :href, path = :path");
            $stmt->bindParam(":href", $href);
            $stmt->bindParam(":path",$filePath);
            $stmt->execute();

            if($stmt) {
                echo $href;
            }
        }
    }
}
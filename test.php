<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "mapdb";
$connection = mysqli_connect($host, $user, $password, $database);

if (!$connection) {
    echo "<h1>Error in DB Connection</h1>";
    die();
}

$uploadDirectory = 'uploads/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];

        // Check if the file is an image
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedExtensions)) {
            // Generate a unique filename for the image
            $uniqueFilename = uniqid() . '.' . $fileExtension;
            $targetPath = $uploadDirectory . $uniqueFilename;

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($image['tmp_name'], $targetPath)) {
                // Insert the image path into the database
                $sql = "INSERT INTO asetest (catg_type,latitude,longitude,image,datetime) VALUES ('c2','34.0015859','71.4856761',?,now())";
                $stmt = mysqli_prepare($connection, $sql);
                mysqli_stmt_bind_param($stmt, "s", $targetPath);
                mysqli_stmt_execute($stmt);

                // Return a success message
                echo json_encode(['message' => 'Image uploaded successfully']);
            } else {
                echo json_encode(['message' => 'Failed to move the uploaded file']);
            }
        } else {
            echo json_encode(['message' => 'Invalid file format. Allowed formats: jpg, jpeg, png, gif']);
        }
    } else {
        echo json_encode(['message' => 'No file uploaded']);
    }
}

mysqli_close($connection);
?>

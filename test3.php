<?php
// Configuration for your database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "mapdb";
$connection = mysqli_connect($host, $user, $password, $database);


try {
    // Create a PDO connection to the database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch image paths from the database
    $sql = "SELECT image_path FROM images";
    $stmt = $pdo->query($sql);
    $imagePaths = $stmt->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Gallery</title>
</head>
<body>
    <h1>Image Gallery</h1>
    
    <?php foreach ($imagePaths as $imagePath): ?>
        <img src="<?php echo $imagePath; ?>" alt="Image">
    <?php endforeach; ?>
</body>
</html>

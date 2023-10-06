<?php

require '_includes/connect.php';

if(isset($_POST['id'])) {
    $id = $_POST['id'];

    // Retrieve the image filename from the row being deleted
    $query = "SELECT image FROM electrocure WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    $image_filename = $row['image'];

    // Delete the row from the database
    $query = "DELETE FROM electrocure WHERE id = $id";
    if(mysqli_query($connection, $query)) {
        // Course deleted successfully

        // Delete the image file from the server folder
        if($image_filename != "") {
            $image_path = "images/elec/" . $image_filename;
            if(file_exists($image_path)) {
                unlink($image_path);
            }
        }

        header("Location: index.php");
        exit();
    } else {
        // Error deleting course
        echo "Error deleting data: " . mysqli_error($connection);
    }
} else {
    // ID parameter not found
    header("Location: index.php");
    exit();
}
?>
<?php
// Include your database connection file (e.g., dbh.php)
include '../dbh.php';

// Check if the ID parameter is passed through the URL
if (isset($_GET['id'])) {
    // Retrieve the User ID from the URL and sanitize it
    $id = intval($_GET['id']); // Assuming id is an integer

    // Delete the User record from the database
    $sql = "DELETE FROM user WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        // Redirect to view_User.php after successful deletion
        header("Location: login.php");
        exit();
    } else {
        echo "Error deleting User: " . mysqli_error($conn);
    }
} else {
    // ID parameter is not provided
    echo "User ID not specified.";
}
?>

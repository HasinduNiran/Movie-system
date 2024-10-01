<?php

// Include the database connection file
include '../dbh.php';

// Check if the HTTP request method is GET and if the 'id' parameter is set
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    // Sanitize and retrieve the booking ID from the GET parameters
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Construct the SQL query to delete the booking with the given ID
    $query = "DELETE FROM booking WHERE id = $id";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // If the query is successful, redirect the user to the view_booking.php page
        header("Location: view_booking.php");
        exit(); // Stop further script execution
    } else {
        // If there is an error with the query execution, display an error message
        echo "Error deleting booking: " . mysqli_error($conn);
    }
} else {
    // If the request method is not GET or the 'id' parameter is not set, display an error message
    echo "Invalid request.";
}
?>

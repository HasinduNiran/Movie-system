<?php
// Include your database connection script (e.g., dbh.php)
include '../dbh.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the movies data before deleting (optional, for confirmation)
    $query = "SELECT * FROM movies WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $movies_data = mysqli_fetch_assoc($result);

    if ($movies_data) {
        // Perform the movies deletion
        $delete_query = "DELETE FROM movies WHERE id = $id";

        if (mysqli_query($conn, $delete_query)) {
            // movies deleted successfully
            echo '<script type="text/javascript">
        window.onload = function () { alert("movies Deleted !"); 
            window.location.href = "view_movies.php";}
        </script>'; // Redirect to a success page
            exit;
        } else {
            // Database deletion failed
            header('Location: delete_error.php'); // Redirect to an error page
            exit;
        }
    } else {
        // movies not found
        header('Location: delete_error.php'); // Redirect to an error page
        exit;
    }
} else {
    // Invalid request
    header('Location: delete_error.php'); // Redirect to an error page
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Movie Booking</title>
    <link rel="stylesheet" href="update.css">
</head>
<body>
<?php
include '../header2.php'; 
include '../dbh.php';

// Check if ID is provided and fetch booking details
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM booking WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
}

// If booking details are found, display update form
if (isset($row) && $row) {
    // Fetch available movies from the database
    $movieQuery = "SELECT title FROM movies";
    $movieResult = mysqli_query($conn, $movieQuery);

    echo '<div class="container">
    <h2>Update Movie Booking</h2>
    <form action="update_booking.php" method="post" class="update-booking-form yx-form">
        <input type="hidden" name="id" value="' . $row['id'] . '">
        <div class="row">
            <div class="col-25">
                <label for="name">Name:</label>
            </div>
            <div class="col-75">
                <input type="text" id="name" name="name" value="' . htmlspecialchars($row['name']) . '" required>
            </div>
            <div class="col-25">
                <label for="email">Email:</label>
            </div>
            <div class="col-75">
                <input type="email" id="email" name="email" value="' . htmlspecialchars($row['email']) . '" required>
            </div>
            <div class="col-25">
                <label for="phone">Phone:</label>
            </div>
            <div class="col-75">
                <input type="text" id="phone" name="phone" value="' . htmlspecialchars($row['phone']) . '" pattern="[0-9]{10}" title="Please enter a 10-digit phone number" required>
            </div>
        
            <div class="col-25">
                <label for="movie">Movie:</label>
            </div>
            <div class="col-75">
                <select id="movie" name="movie" required>';
    while ($movie = mysqli_fetch_assoc($movieResult)) {
        echo '<option value="' . htmlspecialchars($movie['title']) . '"';
        if ($row['movie'] == $movie['title']) {
            echo ' selected';
        }
        echo '>' . htmlspecialchars($movie['title']) . '</option>';
    }
    echo '</select>
            </div>
            <div class="col-25">
                <label for="show_date">Show Date:</label>
            </div>
            <div class="col-75">
                <input type="date" id="show_date" name="show_date" value="' . htmlspecialchars($row['show_date']) . '" required min="' . date('Y-m-d') . '">
            </div>
        
            <div class="col-25">
                <label for="tickets">Tickets:</label>
            </div>
            <div class="col-75">
                <input type="number" id="tickets" name="tickets" value="' . htmlspecialchars($row['tickets']) . '" required min="1">
            </div>
        
        </div>
        <button type="submit" name="submit">Update</button>
    </form>
</div>';
} else {
    echo "Booking not found";
}

// Update booking if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $movie = $_POST['movie'];
    $show_date = $_POST['show_date'];
    $tickets = $_POST['tickets'];

    // Prepare and bind SQL statement
    $query_update = "UPDATE booking SET name = ?, email = ?, phone = ?, movie = ?, show_date = ?, tickets = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($conn, $query_update);
    mysqli_stmt_bind_param($stmt_update, "ssssiii", $name, $email, $phone, $movie, $show_date, $tickets, $id);
    mysqli_stmt_execute($stmt_update);

    // Check for successful update
    if (mysqli_stmt_affected_rows($stmt_update) > 0) {
        // Redirect to view_booking.php after successful update
        header("Location: view_booking.php");
        exit; // Ensure script execution stops after redirection
    } else {
        echo "Error updating booking";
    }

    // Close statement
    mysqli_stmt_close($stmt_update);
}

// Close connection
mysqli_close($conn);
?>
</body>
</html>

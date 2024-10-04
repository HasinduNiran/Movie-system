<?php
include '../dbh.php';
include '../header2.php'; 

// Retrieve the list of movies from the database
$query = "SELECT title FROM movies";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error retrieving Movies: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie Booking</title>
    <link rel="stylesheet" type="text/css" href="yx.css">
</head>
<body>

<h1>Add Movie Booking</h1>

<div class="yx-form">
    <h2>Book a Movie</h2>
    <form action="add_booking.php" method="post" onsubmit="return validateBookingDate()">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required maxlength="10">

        <label for="movie">Movie:</label>
        <select name="movie" id="movie" required>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <option value="<?php echo htmlspecialchars($row['title']); ?>">
                    <?php echo htmlspecialchars($row['title']); ?>
                </option>
            <?php } ?>
        </select>

        <label for="show_date">Show Date:</label>
        <input type="date" id="show_date" name="show_date" required min="<?php echo date('Y-m-d'); ?>">

        <label for="tickets">Number of Tickets:</label>
        <input type="number" id="tickets" name="tickets" required min="1" max="10">

        <button type="submit" name="submit">Submit</button>
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    // Sanitize and retrieve form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $movie = mysqli_real_escape_string($conn, $_POST['movie']);
    $show_date = mysqli_real_escape_string($conn, $_POST['show_date']);
    $tickets = intval($_POST['tickets']);

    // Insert booking into the database
    $query = "INSERT INTO booking (name, email, phone, movie, show_date, tickets) 
              VALUES ('$name', '$email', '$phone', '$movie', '$show_date', '$tickets')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Booking added successfully";
        header('Location: ../index.html');
        exit;
    } else {
        echo "Error adding booking: " . mysqli_error($conn);
    }
}
?>

</body>
</html>

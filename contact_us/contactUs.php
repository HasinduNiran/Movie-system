<?php
include '../dbh.php'; // Database connection
include '../header2.php'; 

// Fetch movie titles from the database
$query = "SELECT title FROM movies";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error retrieving movies: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" type="text/css" href="add.css"> <!-- Link to your CSS file -->
</head>
<body>

    <div class="contact-form">
        <h1>Contact Us</h1>

        <form action="contactUs.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="movie">Movie:</label>
                <select name="movie" id="movie" required>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <option value="<?php echo htmlspecialchars($row['title']); ?>">
                            <?php echo htmlspecialchars($row['title']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>
            </div>

            <button type="submit" name="submit">Submit</button>
        </form>
    </div>

</body>
</html>

<?php
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $movie = $_POST['movie']; // Correct variable name from form
    $msg = $_POST['message'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO contact (name, email, movie, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $movie, $msg);

    if ($stmt->execute()) {
        // Show success message and redirect to 'viewc.php'
        echo '<script type="text/javascript">
        window.onload = function () {
            alert("Data Inserted Successfully!");
            window.location.href = "viewc.php";
        };
        </script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close(); // Close statement
}

mysqli_close($conn); // Close connection
?>

<?php include '../header2.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Contact</title>
    <link rel="stylesheet" type="text/css" href="update.css">
</head>
<body>
    <h1>Update Contact</h1>

    <?php
    // Include database connection
    include '../dbh.php';

    // Check if the request method is GET and the id is provided
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch the specific contact entry from the database using prepared statements
        $query = "SELECT * FROM contact WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Fetch movie titles for the dropdown using prepared statement
            $moviequery = "SELECT title FROM movies"; // Assuming 'title' is the correct column
            $moviestmt = mysqli_prepare($conn, $moviequery);
            mysqli_stmt_execute($moviestmt);
            $movieresult = mysqli_stmt_get_result($moviestmt);

            // Display the form with pre-filled values
            echo '<form action="updatec.php" method="post">
                <input type="hidden" name="feedback_id" value="' . $row['id'] . '">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="' . htmlspecialchars($row['name']) . '" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="' . htmlspecialchars($row['email']) . '" required>
                </div>

                <div class="form-group">
                    <label for="movie">Movie:</label>
                    <select id="movie" name="movie" required>';
                    while ($movie = mysqli_fetch_assoc($movieresult)) {
                        echo '<option value="' . htmlspecialchars($movie['title']) . '"';
                        if ($row['movie'] == $movie['title']) {
                            echo ' selected';
                        }
                        echo '>' . htmlspecialchars($movie['title']) . '</option>';
                    }
                echo '</select>
                </div>

                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="4" required>' . htmlspecialchars($row['message']) . '</textarea>
                </div>

                <button type="submit" name="submit">Update</button>
            </form>';
        } else {
            echo 'Contact entry not found.';
        }

        mysqli_stmt_close($stmt); // Close the statement after fetching
    }
    ?>
</body>
</html>

<?php
include '../dbh.php';

if (isset($_POST['submit'])) {
    $id = $_POST['feedback_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $movie = $_POST['movie'];
    $msg = $_POST['message'];

    // Use prepared statements for updating the contact
    $sql = "UPDATE contact SET name = ?, email = ?, movie = ?, message = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $email, $movie, $msg, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo '<script type="text/javascript">
        window.onload = function () {
            alert("Data Updated Successfully!");
            window.location.href = "viewc.php";
        };
        </script>';
    } else {
        echo "Failed to update the contact.";
    }

    mysqli_stmt_close($stmt); // Close the statement
}

mysqli_close($conn); // Close the database connection
?>

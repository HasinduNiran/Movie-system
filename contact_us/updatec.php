<?php include '../header2.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Contact</title>
    <link rel="stylesheet" type="text/css" href="add.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --background-color: #ecf0f1;
            --text-color: #34495e;
            --input-background: #fff;
            --input-border: #bdc3c7;
            --input-focus: #3498db;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .edit-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 800px;
            display: flex;
        }

        .edit-info {
            background-color: var(--secondary-color);
            color: #fff;
            padding: 40px;
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .edit-info h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .info-content p {
            margin-bottom: 1rem;
        }

        .edit-form {
            padding: 40px;
            width: 60%;
        }

        .edit-form h2 {
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-group label {
            position: absolute;
            left: 15px;
            margin-top: -5%;
            font-size: 0.8rem;
            color: var(--primary-color);
            background-color: var(--input-background);
            padding: 0 5px;
            transition: all 0.3s ease;
        }

        input[type="text"],
        input[type="email"],
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--input-border);
            border-radius: 5px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus,
        textarea:focus {
            border-color: var(--input-focus);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 12px 25px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .edit-container {
                flex-direction: column;
            }
            .edit-info,
            .edit-form {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <div class="edit-info">
            <h2>Edit Contact</h2>
            <div class="info-content">
                <p>Update the contact information using the form on the right.</p>
                <p>All fields are required to ensure we have complete information.</p>
            </div>
        </div>
        <div class="edit-form">
            <h2>Update Information</h2>
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
                            <input type="text" id="name" name="name" value="' . htmlspecialchars($row['name']) . '" required>
                            <label for="name">Name</label>
                        </div>

                        <div class="form-group">
                            <input type="email" id="email" name="email" value="' . htmlspecialchars($row['email']) . '" required>
                            <label for="email">Email</label>
                        </div>

                        <div class="form-group">
                            <select id="movie" name="movie" required>';
                            while ($movie = mysqli_fetch_assoc($movieresult)) {
                                echo '<option value="' . htmlspecialchars($movie['title']) . '"';
                                if ($row['movie'] == $movie['title']) {
                                    echo ' selected';
                                }
                                echo '>' . htmlspecialchars($movie['title']) . '</option>';
                            }
                    echo '</select>
                            <label for="movie">Movie</label>
                        </div>

                        <div class="form-group">
                            <textarea id="message" name="message" rows="4" required>' . htmlspecialchars($row['message']) . '</textarea>
                            <label for="message">Message</label>
                        </div>

                        <button type="submit" name="submit">Update Contact</button>
                    </form>';
                } else {
                    echo '<p>Contact entry not found.</p>';
                }

                mysqli_stmt_close($stmt); // Close the statement after fetching
            }
            ?>
        </div>
    </div>

    <script>
        // This script ensures labels stay up if fields are filled
        document.querySelectorAll('.form-group input, .form-group textarea, .form-group select').forEach(element => {
            if (element.value !== '') {
                element.parentElement.classList.add('active');
            }
            element.addEventListener('focus', () => {
                element.parentElement.classList.add('active');
            });
            element.addEventListener('blur', () => {
                if (element.value === '') {
                    element.parentElement.classList.remove('active');
                }
            });
        });
    </script>
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

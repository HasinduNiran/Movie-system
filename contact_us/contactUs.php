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
            margin-top:5%;
        }

        .contact-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 800px;
            display: flex;
        }

        .contact-info {
            background-color: var(--secondary-color);
            color: #fff;
            padding: 40px;
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .contact-info h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .info-item i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .contact-form {
            padding: 40px;
            width: 60%;
        }

        .contact-form h2 {
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
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--input-background);
            padding: 0 5px;
            font-size: 0.9rem;
            color: #7f8c8d;
            transition: all 0.3s ease;
        }

        .form-group.active label {
            top: 0;
            font-size: 0.8rem;
            color: var(--primary-color);
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
            .contact-container {
                flex-direction: column;
            }
            .contact-info,
            .contact-form {
                width: 100%;
            }
        }
    </style>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="contact-container">
        <div class="contact-info">
            <h2>Get in Touch</h2>
            <div class="info-content">
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>Colombo 07, CA 90001</p>
                </div>
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <p>071 2345678</p>
                </div>
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <p>FamalyCinama@gmail.com</p>
                </div>
            </div>
        </div>
        <div class="contact-form">
            <h2>Contact Us</h2>
            <form action="contactUs.php" method="post">
                <div class="form-group">
                    <input type="text" id="name" name="name" required>
                    <label for="name">Name</label>
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" required>
                    <label for="email">Email</label>
                </div>
                <div class="form-group">
                    <select name="movie" id="movie" required>
                        <option value="" disabled selected>Select a Movie</option>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <option value="<?php echo htmlspecialchars($row['title']); ?>">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <textarea id="message" name="message" rows="4" required></textarea>
                    <label for="message">Message</label>
                </div>
                <button type="submit" name="submit">Send Message</button>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.form-group input, .form-group textarea').forEach(element => {
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

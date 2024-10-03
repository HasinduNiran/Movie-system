<?php
// Include your database connection file (e.g., dbh.php)
include '../dbh.php';
include '../header2.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = intval($_POST['price']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']); // corrected variable name

    // Check if a file was uploaded
    if (isset($_FILES['photo'])) {
        $file = $_FILES['photo'];

        // Check if the file is an image
        if (getimagesize($file['tmp_name'])) {
            // Generate a unique filename
            $image_filename = uniqid() . '_' . $file['name'];

            // Define the upload path
            $upload_path = 'uploads/' . $image_filename; // Change 'uploads/' to your desired directory

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                // Insert data into the database
                $insert_query = "INSERT INTO movies (title, price, duration, category, description, photo) 
                    VALUES ('$title', $price, '$duration', '$category', '$description', '$upload_path')";

                if (mysqli_query($conn, $insert_query)) {
                    // Movie added successfully
                    echo '<script type="text/javascript">
                            window.onload = function () { 
                                alert("Movie Added!"); 
                                window.location.href = "view_movies.php";
                            }
                        </script>'; // Redirect to view_movies.php
                    exit;
                } else {
                    // Database insertion failed
                    header('Location: error_page.php'); // Redirect to an error page
                    exit;
                }
            } else {
                // File upload failed
                header('Location: error_page.php'); // Redirect to an error page
                exit;
            }
        } else {
            // The uploaded file is not an image
            header('Location: error_page.php'); // Redirect to an error page
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <link rel="stylesheet" href="../css/style.css">
    <meta charset="UTF-8">
    <title>Add Movie</title>
    <style>
.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    -webkit-backdrop-filter: blur(5px);
  backdrop-filter: blur(5px);
    border-radius: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
    background-image: url('../image/form1.jpg');
    background-size: cover;
    background-repeat: repeat;
    font-family: Arial, sans-serif;
}

h1 {
    text-align: center;
    color: white;
    margin-top: 90px; 
}

form {
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    background-color: white;

    
}

label {
    font-weight: bold;
    margin-bottom: 10px;
    display: block;
    color: black;
}

input[type="text"],
input[type="number"],
textarea {
    width: calc(100% - 22px);
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

img {
    display: block;
    margin-bottom: 10px;
    max-width: 100%;
    height: auto;
    border-radius: 5px;
    color: #fff;

}

button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>

<script>
    function validateForm() {
        var title = document.getElementById('title').value;
        var duration = document.getElementById('duration').value;

        // Regular expression to check if the input contains numbers
        var containsNumber = /\d/.test(title);

        // Check if the title contains numbers
        if (containsNumber) {
            alert("Title cannot contain numbers");
            return false; // Prevent form submission
        }

        // Check if the duration contains numbers
        if (containsNumber) {
            alert("Duration cannot contain numbers");
            return false; // Prevent form submission
        }

        // If validation passes, allow form submission
        return true;
    }
</script>

<h1>Add Movie</h1>

<div class="container">
    <form action="add_movie.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required>

        <label for="duration">Duration:</label>
        <input type="text" id="duration" name="duration" required>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="photo">Movie photo:</label>
        <input type="file" id="photo" name="photo" accept="image/*" required><br><br>

        <button type="submit">Add Movie</button>
    </form>
</div>

</body>
</html>

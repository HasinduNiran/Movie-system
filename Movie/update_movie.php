<?php
// Include your database connection and header files
include '../dbh.php';
include '../header2.php';

// Check if the movie ID is provided
if (isset($_GET['id'])) {
    $movie_id = intval($_GET['id']);

    // Fetch existing movie data from the database
    $select_query = "SELECT * FROM movies WHERE id = $movie_id";
    $result = mysqli_query($conn, $select_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $movie = mysqli_fetch_assoc($result);
    } else {
        // Movie not found
        header('Location: error_page.php'); // Redirect to an error page
        exit;
    }
} else {
    // No movie ID provided
    header('Location: error_page.php'); // Redirect to an error page
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = intval($_POST['price']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Initialize variables
    $update_image = false;
    $image_filename = $movie['photo']; // Keep the existing image by default

    // Check if a new image was uploaded
    if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
        $file = $_FILES['photo'];

        // Check if the file is an image
        if (getimagesize($file['tmp_name'])) {
            // Generate a unique filename
            $image_filename = uniqid() . '_' . $file['name'];
            $upload_path = 'uploads/' . $image_filename;

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                $update_image = true;
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

    // Update query
    $update_query = "UPDATE movies SET 
        title = '$title', 
        price = $price, 
        duration = '$duration', 
        category = '$category', 
        description = '$description'";

    // Add photo to query only if a new image was uploaded
    if ($update_image) {
        $update_query .= ", photo = '$upload_path'";
    }

    $update_query .= " WHERE id = $movie_id";

    // Execute the query
    if (mysqli_query($conn, $update_query)) {
        // Movie updated successfully
        echo '<script type="text/javascript">
                window.onload = function () { 
                    alert("Movie Updated Successfully!"); 
                    window.location.href = "view_movies.php";
                }
            </script>';
        exit;
    } else {
        // Database update failed
        header('Location: error_page.php'); // Redirect to an error page
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/style.css">
    <meta charset="UTF-8">
    <title>Update Movie</title>
    <style>
        /* CSS for Update Movie Form */
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            background-image: url('../image/bg6.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 90px; 
        }

        form {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
            color: #333;
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

<h1>Update Movie</h1>

<div class="container">
    <form action="update_movie.php?id=<?php echo $movie_id; ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($movie['title']); ?>" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo $movie['price']; ?>" required>

        <label for="duration">Duration:</label>
        <input type="text" id="duration" name="duration" value="<?php echo $movie['duration']; ?>" required>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?php echo $movie['category']; ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($movie['description']); ?></textarea>

        <label for="photo">Movie photo (leave blank to keep current image):</label>
        <input type="file" id="photo" name="photo" accept="image/*"><br><br>
        <img src="<?php echo $movie['photo']; ?>" alt="Current Movie photo"><br>

        <button type="submit">Update Movie</button>
    </form>
</div>

</body>
</html>

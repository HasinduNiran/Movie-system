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
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --background-color: #f4f7f9;
            --text-color: #333;
            --input-bg: #fff;
            --input-border: #ddd;
            --input-focus: #3498db;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('../image/form1.jpg');
    background-size: cover;
    background-repeat: repeat;
            color: var(--text-color);
            line-height: 1.6;
            padding: 20px;
            margin-top:7%;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: var(--shadow);
        }

        h1 {
            text-align: center;
            color: var(--secondary-color);
            margin-bottom: 30px;
            font-size: 2.5em;
        }

        form {
            display: grid;
            gap: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--secondary-color);
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--input-border);
            border-radius: 4px;
            font-size: 16px;
            transition: var(--transition);
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            outline: none;
            border-color: var(--input-focus);
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        .file-input {
            margin-top: 10px;
        }

        .current-image {
            margin-top: 20px;
            text-align: center;
        }

        .current-image img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            box-shadow: var(--shadow);
        }

        button {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            padding: 14px 20px;
            font-size: 18px;
            border-radius: 4px;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            font-weight: 600;
        }

        button:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
        <h1>Update Movie</h1>
        <form action="update_movie.php?id=<?php echo $movie_id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($movie['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" id="price" name="price" value="<?php echo $movie['price']; ?>" required>
            </div>

            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="text" id="duration" name="duration" value="<?php echo $movie['duration']; ?>" required>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" value="<?php echo $movie['category']; ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($movie['description']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="photo">Movie Photo</label>
                <input type="file" id="photo" name="photo" accept="image/*" class="file-input">
                <p class="file-hint">Leave blank to keep the current image</p>
            </div>

            <div class="current-image">
                <img src="<?php echo $movie['photo']; ?>" alt="Current Movie Photo">
            </div>

            <button type="submit">Update Movie</button>
        </form>
    </div>
</body>
</html>

<?php
    // Include database connection and header
    include '../dbh.php';
    include '../header2.php';

    // Retrieve movies from the database
    $sql = "SELECT * FROM movies";
    $result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Movies</title>
    <link rel="stylesheet" href="card.css">
    <style>
        /* Basic styling for movie display */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .movie {
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 10px;
        }

        img {
            max-width: 150px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        p {
            color: #666;
            margin: 5px 0;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        button.delete-btn {
            background-color: #dc3545;
        }

        button:hover {
            background-color: #0056b3;
        }

        button.delete-btn:hover {
            background-color: #c82333;
        }

        a {
            text-decoration: none;
        }

        .movie img {
            display: block;
        }

    </style>
</head>
<body>

    <div class="container">
        
        <?php
            // Loop through each row in the result set
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='movie'>";
                echo "<h2>" . htmlspecialchars($row['title']) . "</h2>"; // Use htmlspecialchars to prevent XSS attacks
                echo '<img src="' . htmlspecialchars($row['photo']) . '" alt="Movie photo" width="150">'; // Sanitize output
                
                echo "<p><strong>Price:</strong> $" . htmlspecialchars($row['price']) . "</p>"; // Sanitize output
                echo "<p><strong>Duration:</strong> " . htmlspecialchars($row['duration']) . " minutes</p>"; // Sanitize output
                echo "<p><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>"; // Sanitize output
                echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>"; // Sanitize output
                
                // Edit button
                echo "<a href='update_movie.php?id=" . $row['id'] . "'><button>Edit</button></a>";
                
                // Delete button
                echo "<a href='delete_movie.php?id=" . $row['id'] . "'><button class='delete-btn'>Delete</button></a>";

                echo "</div>";
            }
        ?>
    
    </div>
</body>
</html>

<?php
    // Free result set
    mysqli_free_result($result);

    // Close connection
    mysqli_close($conn);
?>

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
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --background-color: #f4f7f9;
            --card-background: #ffffff;
            --text-color: #333333;
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
        }

        .container {
            max-width: 350px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 20px;
            
        }

        .movie {
            background-color: var(--card-background);
            border-radius: 8px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
            margin-top: 10%;
        }

        .movie:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .movie h2 {
            font-size: 1.5em;
            color: var(--secondary-color);
            margin: 0;
            padding: 20px 20px 10px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .movie img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid var(--primary-color);
        }

        .movie-info {
            padding: 20px;
        }

        .movie p {
            margin-bottom: 10px;
            font-size: 0.9em;
        }

        .movie p strong {
            color: var(--secondary-color);
        }

        .movie .description {
            height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .button-group {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        .button-group a {
            text-decoration: none;
            width: 48%;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
            transition: var(--transition);
        }

        button:hover {
            opacity: 0.9;
        }

        button:active {
            transform: scale(0.98);
        }

        .edit-btn {
            background-color: var(--primary-color);
            color: white;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        @media (max-width: 600px) {
            .container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div class="container">
        <?php
        // Loop through each row in the result set
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='movie'>";
            echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
            echo '<img src="' . htmlspecialchars($row['photo']) . '" alt="Movie photo">';
            echo "<div class='movie-info'>";
            echo "<p><strong>Price:</strong> $" . htmlspecialchars($row['price']) . "</p>";
            echo "<p><strong>Duration:</strong> " . htmlspecialchars($row['duration']) . " minutes</p>";
            echo "<p><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>";
            echo "<p class='description'><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>";
            echo "</div>";
            echo "<div class='button-group'>";
            echo "<a href='update_movie.php?id=" . $row['id'] . "'><button class='edit-btn'>Edit</button></a>";
            echo "<a href='delete_movie.php?id=" . $row['id'] . "'><button class='delete-btn'>Delete</button></a>";
            echo "</div>";
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

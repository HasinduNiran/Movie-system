<?php

    // Include header and database connection
    include '../header2.php'; 
    include '../dbh.php';

    // Retrieve movies from the database
    $sql = "SELECT * FROM movies";
    $result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Movies</title>
    <!-- <link rel="stylesheet" href="../css/style.css"> -->
    <link rel="stylesheet" href="card.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
            margin-top:7%;
            background-image: url('/image/form1.jpg');
              background-size: cover;
              background-repeat: repeat;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .movie {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .movie:hover {
            transform: translateY(-5px);
        }
        .movie img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .movie-info {
            padding: 15px;
        }
        .movie h2 {
            margin: 0 0 10px;
            font-size: 1.2em;
            color: #333;
        }
        .movie p {
            margin: 5px 0;
            font-size: 0.9em;
            color: #666;
        }
        .movie strong {
            color: #333;
        }
        .book-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 0 0 8px 8px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .book-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
        <?php
        // Assuming $result contains your database query result
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='movie'>";
            echo "<img src='" . htmlspecialchars($row['photo']) . "' alt='Movie poster for " . htmlspecialchars($row['title']) . "'>";
            echo "<div class='movie-info'>";
            echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
            echo "<p><strong>Price:</strong> $" . htmlspecialchars($row['price']) . "</p>";
            echo "<p><strong>Duration:</strong> " . htmlspecialchars($row['duration']) . " minutes</p>";
            echo "<p><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>";
            echo "<p><strong>Description:</strong> " . htmlspecialchars(substr($row['description'], 0, 100)) . "...</p>";
            echo "</div>";
            echo "<a href='../Booking/add_booking.php' class='book-btn'>Book Now</a>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>

<?php
    // Free the result set
    mysqli_free_result($result);

    // Close the database connection
    mysqli_close($conn);
?>

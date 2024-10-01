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
</head>
<body>

    <div class="container">
        
        <?php
            // Loop through each row in the result set
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='movie'>";
                
                // Display the movie title
                echo "<h2>" . htmlspecialchars($row['title']) . "</h2>"; // Prevent XSS by escaping output
                
                // Display the movie photo image
                echo '<img src="' . htmlspecialchars($row['photo']) . '" alt="Movie photo" width="100">';
                
                // Display the movie price
                echo "<p><strong>Price:</strong> $" . htmlspecialchars($row['price']) . "</p>"; // Sanitize output
                
                // Display the movie duration
                echo "<p><strong>Duration:</strong> " . htmlspecialchars($row['duration']) . " minutes</p>"; // Sanitize output
                
                // Display the movie category
                echo "<p><strong>Category:</strong> " . htmlspecialchars($row['category']) . "</p>"; // Sanitize output
                
                // Display the movie description
                echo "<p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>"; // Sanitize output
                
                // Add a button to book the movie
                echo "<a href='../Booking/add_booking.php'><button>Book</button></a>";

                echo "</div>"; // Close the movie div
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

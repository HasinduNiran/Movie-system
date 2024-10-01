<?php 
include '../header2.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    echo "You must be logged in to view bookings.";
    exit; // Stop further script execution if not logged in
}

$email = $_SESSION['email'];

include '../dbh.php'; // Include the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Booking</title>
    <link rel="stylesheet" href="view.css">
</head>
<body>
    <div class="container">
        <h2>View Booking</h2>

        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>movie</th>
                    <th>show_date</th>
                    <th>tickets</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Use prepared statements for security
                $stmt = $conn->prepare("SELECT * FROM booking WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();

                // Loop through each row in the result set
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['movie']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['show_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tickets']) . "</td>";
                        echo "<td>
                                <a href='update_booking.php?id=" . htmlspecialchars($row['id']) . "' class='edit-btn'>Edit</a> | 
                                <a href='delete_booking.php?id=" . htmlspecialchars($row['id']) . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this booking?\")'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo '<tr><td colspan="8">No bookings found.</td></tr>';
                }
                
                $stmt->close(); // Close the prepared statement
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>

<?php
// Include database connection
include '../dbh.php';
include '../header2.php'; 

// Check if user is logged in (implement your own authentication logic)
// For example, you might have session variables set after successful login
session_start();
if(!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php"); // Redirect to your login page
    exit();
}

// Retrieve logged-in user details from the database
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM user WHERE id = $userId";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}

// Check if user exists
if(mysqli_num_rows($result) == 0) {
    // Redirect or display a message if the user doesn't exist
    echo "User not found!";
    exit();
}

// Fetch user details
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View User</title>
    <link rel="stylesheet" href="../css/style.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="viewuser.css">
</head>
<body>
    <div class="container">
        <div class="user">
            <h2>User Profile</h2>
            <?php
          
            ?>
            <img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="User Image" width="100">
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($row['firstname']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($row['lastname']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
            <?php 
            if(isset($row['telphone']) && !empty($row['telphone'])) {
                echo "<p><strong>Telephone:</strong> " . htmlspecialchars($row['telphone']) . "</p>";
            } else {
                echo "<p><strong>Telephone:</strong> Not Available</p>";
            }
            ?>
            <p><strong>Password:</strong> <?php echo htmlspecialchars($row['password']); ?></p>

            <div class="buttons">
                <a href='update_user.php?id=<?php echo $row['id']; ?>'><button class="edit-btn">Edit</button></a>
                <a href='delete_user.php?id=<?php echo $row['id']; ?>'><button class="delete-btn">Delete</button></a>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Free result set
mysqli_free_result($result);

// Close connection
mysqli_close($conn);
?>

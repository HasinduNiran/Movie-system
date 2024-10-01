<?php
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
include '../dbh.php';

// Fetch user's first name and last name based on session user ID
$user_id = $_SESSION["user_id"];
$sql = "SELECT firstname, lastname FROM user WHERE id = $user_id";
$result = mysqli_query($conn, $sql);

// Check if query was successful and if a row was returned
if ($result && mysqli_num_rows($result) > 0) {
    // Fetch the first row from the result
    $row = mysqli_fetch_assoc($result);
    // Extract the first name and last name from the row
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
} else {
    // Handle error if user data couldn't be retrieved
    $firstname = "User";
    $lastname = "";
}

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Booking</title>
    <link rel="stylesheet" href="dash.css" />
</head>

<body>

    <div class="wrapper">

        <div class="sidebar">
            <div class="profile">
                <img style="width: 100px; " src="image/LOGO.png" alt="" />
                <h3>User Dashboard</h3>
                
            </div>
            <ul>
                <li>
                    <a href="../index.html" class="active">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span class="item">Home</span>
                    </a>
                </li>

                <li>
                    <a href="view_User.php">
                        <span class="icon"><i class="fas fa-plus"></i></span>
                        <span class="item"> View Profile</span>
                    </a>
                </li>

               

                <li>
                    <a href="../movie/movie.php">
                        <span class="icon"><i class="fas fa-users"></i></span>
                        <span class="item">View movie</span>
                    </a>
                </li>

                <li>
                    <a href="../Booking/view_booking.php">
                        <span class="icon"><i class="fas fa-plus"></i></span>
                        <span class="item"> View My Booking</span>
                    </a>
                </li>

                <li>
                    <a href="../Contact_us/contactUs.php">
                        <span class="icon"><i class="fas fa-trash"></i></span>
                        <span class="item">contact_Us</span>
                    </a>
                </li>

                <!-- <li>
                    <a href="profile/view.php">
                        <span class="icon"><i class="fas fa-address-book"></i></span>
                        <span class="item">My Profile</span>
                    </a>
                </li> -->
                <li>
                    <a href="logout.php">
                        <span class="icon"><i class="fas fa-address-book"></i></span>
                        <span class="item">Log Out</span>
                    </a>
                </li>
                </ul>
        </div>
    </div>

    <div>
        <!-- <div style="margin-top: 100px; margin-left: 500px; position: absolute ">
            <img src="image/chch.png" alt="">
        </div> -->
      <h1>Welcome !!!<br>
      <?php echo $firstname; ?> <?php echo $lastname; ?> 
      
        
    
    </h1>
        
    </div>

</body>

</html>

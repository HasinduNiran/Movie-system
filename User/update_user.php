<?php
// Include your database connection file (e.g., dbh.php)
include '../dbh.php';
include '../header2.php'; 

// Check if the ID parameter is passed through the URL
if (isset($_GET['id'])) {
    // Retrieve the user ID from the URL and sanitize it
    $id = intval($_GET['id']); // Assuming id is an integer

    // Fetch user details from the database
    $sql = "SELECT * FROM user WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Assign user details to variables
        $firstname = $row['firstname'];
        $lastname = $row['lastname'];
        $email = $row['email'];
        $password = $row['password'];
        $telphone = $row['telphone'];
        $photo = $row['photo']; // existing photo path
    } else {
        // User with the specified ID not found
        echo "User not found.";
        exit;
    }
} else {
    // ID parameter is not provided
    echo "User ID not specified.";
    exit;
}

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve updated data from the form
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telphone = mysqli_real_escape_string($conn, $_POST['telphone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Update user data in the database
    $sql = "UPDATE user SET 
            firstname = '$firstname',
            lastname = '$lastname',
            email = '$email',
            telphone = '$telphone',
            password = '$password'
            WHERE id = $id";

    // Execute the update query
    if (mysqli_query($conn, $sql)) {
        // Check if a new file is uploaded
        if ($_FILES['photo']['name']) {
            // Handle file upload
            // (add your file upload logic here)
        }
        // Redirect to view_user.php
        header("Location: view_User.php?id=$id");
        exit(); // Ensure that code execution stops after redirection
    } else {
        echo "Error updating user data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
    <h1>Edit Profile</h1>
    <!-- Update user Form -->
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label for="firstname">Full Name</label>
        <input type="text" name="firstname" value="<?php echo $firstname; ?>" required>

        <label for="lastname">Living Town</label>
        <input type="text" name="lastname" value="<?php echo $lastname; ?>" required>

        <label for="email">Email</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required>

        <label for="telphone">Telphone Number</label>
        <input type="text" name="telphone" id="telphone" value="<?php echo $telphone; ?>" required>

        <label for="password">Password</label>
        <input type="password" name="password" value="<?php echo $password; ?>" required>

        <label for="photo">Photo</label>
        <img src="<?php echo $photo; ?>" alt="Current Photo" style="max-width: 200px;">
        <input type="file" name="photo">

        <button type="submit" name="submit">Update User</button>
    </form>
</div>
</body>
</html>

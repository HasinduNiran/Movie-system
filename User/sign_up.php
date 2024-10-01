<?php
// Include your database connection file (e.g., dbh.php)
include '../dbh.php';
include '../header2.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data and sanitize
    $id = intval($_POST['id']); // Assuming id is an integer
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $telphone = mysqli_real_escape_string($conn, $_POST['telphone']);

     // Check if a file was uploaded
     if (isset($_FILES['photo'])) {
        $file = $_FILES['photo'];

        // Check if the file is an image
        if (getimagesize($file['tmp_name'])) {
            // Generate a unique filename
            $image_filename = uniqid() . '_' . $file['name'];

            // Define the upload path
            $upload_path = 'uploads/' . $image_filename; // Change 'uploads/' to your desired directory

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                // Insert data into the database
                $insert_query = "INSERT INTO user (firstname, lastname, email, password,telphone, photo) 
                    VALUES ('$firstname', '$lastname','$email','$password','$telphone','$upload_path')";

                if (mysqli_query($conn, $insert_query)) {
                    // user added successfully
                    echo '<script type="text/javascript">
                            window.onload = function () { 
                                alert("User Added!"); 
                                window.location.href = "login.php";
                            }
                        </script>'; // Redirect to view_user.php
                    exit;
                } else {
                    // Database insertion failed
                    header('Location: error_page.php'); // Redirect to an error page
                    exit;
                }
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add user</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="../css/style.css">
  
</head>
<body>
    
   
    <div class="container">
        <form action="sign_up.php" method="post" enctype="multipart/form-data">
        <h1>Register Form</h1>

            <label for="firstname">First Name</label>
            <input type="text" name="firstname" required>

            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" required>

            
            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="telphone">Contact Number:</label>
<input type="text" id="telphone" name="telphone" pattern="\d{10,}" title="Please enter a 10-digit contact number" required>



            <label for="password">Password</label>
            <input type="password" name="password" required>

            <label for="photo">Photo</label>
            <input type="file" name="photo" required>

            <button type="submit" name="submit">Register</button>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');

        form.addEventListener('submit', function(event) {
            let errorMessages = [];

            // Validation for Name With Initials and Full Name
            const firstname = form.querySelector('input[name="firstname"]').value;
            const lastname = form.querySelector('input[name="lastname"]').value;
            const nameRegex = /^[a-zA-Z\s]*$/; // Allows only letters and spaces
            if (!nameRegex.test(firstname) || !nameRegex.test(lastname)) {
                errorMessages.push('Name should only contain letters and spaces.');
            }
            
        });
    });
</script>

</body>
</html>

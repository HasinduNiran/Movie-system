<?php include '../header2.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Details</title>
    <link rel="stylesheet" href="v.css">
</head>
<body>
   
    <h1>Contact Details</h1>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>movie</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>
        <?php
        // Include your database connection script (e.g., dbh.php)
        include '../dbh.php';

        // Fetch data from the database
        $query = "SELECT * FROM contact";
        $result = mysqli_query($conn, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . $row['name'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>' . $row['movie'] . '</td>';
            echo '<td>' . $row['message'] . '</td>';
            echo '<td>
                    <a class="up" href="updatec.php?id=' . $row['id'] . '">Update</a> |
                    <a class="del"href="deletec.php?id=' . $row['id'] . '">Delete</a>
                  </td>';
            echo '</tr>';
        }
        ?>
    </table>
</body>
</html>

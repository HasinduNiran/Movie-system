<?php include '../header2.php';


?>

<!DOCTYPE html>
<html>

<head>
    <title>Contact Details</title>
    <link rel="stylesheet" href="v.css">
    <style>
        :root {
            --primary-color: #4a90e2;
            --secondary-color: #f5f7fa;
            --text-color: #333;
            --text-light: #777;
            --danger-color: #e74c3c;
            --success-color: #2ecc71;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-color);
            line-height: 1.6;
        }



        h1 {
            color: var(--primary-color);
            margin-bottom: 2rem;
            font-weight: 600;
        }

        .contact-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        .contact-table th {
            background-color: var(--primary-color);
            color: #fff;
            font-weight: 500;
            text-align: left;
            padding: 12px;
            border-radius: 5px 5px 0 0;
        }

        .contact-table td {
            background-color: var(--secondary-color);
            padding: 12px;
        }

        .contact-table tr:hover td {
            background-color: #e6e6e6;
            transition: background-color 0.3s ease;
        }

        .contact-table tr td:first-child {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .contact-table tr td:last-child {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .action-btn {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .update-btn {
            background-color: var(--success-color);
            color: #fff;
            margin-right: 5px;
        }

        .delete-btn {
            background-color: var(--danger-color);
            color: #fff;
        }

        .update-btn:hover,
        .delete-btn:hover {
            opacity: 0.8;
        }

        .message-cell {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 768px) {
            .dashboard {
                padding: 1rem;
            }

            .contact-table {
                font-size: 0.9rem;
            }

            .action-btn {
                padding: 4px 8px;
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <h1><i class="fas fa-address-book"></i> Contact Details</h1>

        <table class="contact-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Movie</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include your database connection script
                include '../dbh.php';

                // Fetch data from the database
                $query = "SELECT * FROM contact";
                $result = mysqli_query($conn, $query);

                // Use prepared statements for security
                // $stmt = $conn->prepare("SELECT * FROM contact WHERE email = ?");
                // $stmt->bind_param("s", $email);
                // $stmt->execute();
                // $result = $stmt->get_result();


                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['movie']) . '</td>';
                    echo '<td class="message-cell">' . htmlspecialchars($row['message']) . '</td>';
                    echo '<td>
                            <a class="action-btn update-btn" href="updatec.php?id=' . $row['id'] . '"><i class="fas fa-edit"></i> Update</a>
                            <a class="action-btn delete-btn" href="deletec.php?id=' . $row['id'] . '"><i class="fas fa-trash-alt"></i> Delete</a>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Add any necessary JavaScript here
    </script>
</body>

</html>
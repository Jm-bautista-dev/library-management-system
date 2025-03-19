<?php
    require "../db_connect.php";
    require "verify_librarian.php";
    require "header_librarian.php";
?>

<html>
    <head>
        <title>View Student Details</title>
        <link rel="stylesheet" type="text/css" href="../css/global_styles.css">
        <link rel="stylesheet" type="text/css" href="css/view_student_details_style.css">
    </head>
    <body>
        <?php
            // Query to fetch all student details from the member table
            $query = $con->prepare("SELECT id, username, name, email FROM member;");
            $query->execute();
            $result = $query->get_result();
            $rows = mysqli_num_rows($result);

            if ($rows == 0) {
                echo "<h2 align='center'>No student records found!</h2>";
            } else {
                echo "<table class='student-table'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Full Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>";

                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "</tr>";
                }

                echo "    </tbody>
                      </table>";
            }
        ?>
    </body>
</html>

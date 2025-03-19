<?php
    require "../db_connect.php";
    require "../message_display.php";
    require "../header.php";
?>

<html>
    <head>
        <title>LMS</title>
        <link rel="stylesheet" type="text/css" href="../css/global_styles.css">
        <link rel="stylesheet" type="text/css" href="../css/form_styles.css">
        <link rel="stylesheet" href="css/register_style.css">
    </head>
    <body>
        <form class="cd-form" method="POST" action="#">
            <center><legend>Member Registration</legend><p>Please fill up the form below:</p></center>
            
                <div class="error-message" id="error-message">
                    <p id="error"></p>
                </div>

                <div class="icon">
                    <input class="m-name" type="text" name="m_name" placeholder="Full Name" required />
                </div>

                <div class="icon">
                    <input class="m-email" type="email" name="m_email" id="m_email" placeholder="Email" required />
                </div>
                
                <div class="icon">
                    <input class="m-user" type="text" name="m_user" id="m_user" placeholder="Username" required />
                </div>
                
                <div class="icon">
                    <input class="m-pass" type="password" name="m_pass" placeholder="Password" required />
                </div>
                
                <br />
                <input type="submit" name="m_register" value="Submit" />
        </form>
    </body>
    
    <?php
        if (isset($_POST['m_register'])) {
            // Check if the username is already taken
            $query = $con->prepare("(SELECT username FROM member WHERE username = ?) UNION (SELECT username FROM pending_registrations WHERE username = ?);");
            $query->bind_param("ss", $_POST['m_user'], $_POST['m_user']);
            $query->execute();
            if (mysqli_num_rows($query->get_result()) != 0) {
                echo error_with_field("The username you entered is already taken", "m_user");
            } else {
                // Check if the email is already registered
                $query = $con->prepare("(SELECT email FROM member WHERE email = ?) UNION (SELECT email FROM pending_registrations WHERE email = ?);");
                $query->bind_param("ss", $_POST['m_email'], $_POST['m_email']);
                $query->execute();
                if (mysqli_num_rows($query->get_result()) != 0) {
                    echo error_with_field("An account is already registered with that email", "m_email");
                } else {
                    // Prepare the password variable first to avoid passing an expression directly
                    $passwordHash = sha1($_POST['m_pass']);
                    $query = $con->prepare("INSERT INTO pending_registrations(username, password, name, email) VALUES(?, ?, ?, ?);");
                    $query->bind_param("ssss", $_POST['m_user'], $passwordHash, $_POST['m_name'], $_POST['m_email']);
                    if ($query->execute()) {
                        echo success("Details submitted. Soon, you'll be notified after verifications!");
                    } else {
                        echo error_without_field("Couldn't record details. Please try again later.");
                    }
                }
            }
        }
    ?>
</html>

<?php
    session_start();
    require "../db_connect.php";
    require "../message_display.php";
    require "../verify_logged_out.php";
    require "../header.php";
?>

<html>
    <head>
        <title>LMS</title>
        <link rel="stylesheet" type="text/css" href="../css/global_styles.css">
        <link rel="stylesheet" type="text/css" href="../css/form_styles.css">
        <link rel="stylesheet" type="text/css" href="css/index_style.css">
    </head>
    <body>
        <form class="cd-form" method="POST" action="#">
        
        <center><legend>Admin Login</legend></center>

            <div class="error-message" id="error-message">
                <p id="error"></p>
            </div>
            
            <div class="icon">
                <input class="l-user" type="text" name="l_user" placeholder="Username" required />
            </div>
            
            <div class="icon">
                <input class="l-pass" type="password" name="l_pass" placeholder="Password" required />
            </div>
            
            <input type="submit" value="Login" name="l_login"/>

            
            
        </form>
        <p align="center"><a href="../index.php" style="text-decoration:none;">Go Back</a>
    </body>
    
    <?php
        if(isset($_POST['l_login']))
        {
            $passwordHash = sha1($_POST['l_pass']); // Store hashed password in a variable
            $query = $con->prepare("SELECT id FROM librarian WHERE username = ? AND password = ?;");
            $query->bind_param("ss", $_POST['l_user'], $passwordHash); // Use variable
            $query->execute();
            $result = $query->get_result(); // Store query result
            if(mysqli_num_rows($result) != 1)
                echo error_without_field("Invalid username/password combination");
            else
            {
                $_SESSION['type'] = "librarian";
                $row = mysqli_fetch_array($result); // Fetch result properly
                $_SESSION['id'] = $row[0];
                $_SESSION['username'] = $_POST['l_user'];
                header('Location: home.php');
            }
        }
    ?>
</html>

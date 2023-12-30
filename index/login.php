<?php

// Include your database connection file
include('../session/db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Fetch user input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT Email, password, Role FROM users WHERE Email = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    // Check if a user with the given username exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($dbUsername, $dbPassword, $userRole);
        $stmt->fetch();

        // Verify the entered password against the hashed password in the database
        if (password_verify($password, $dbPassword)) {
            // Password is correct, set up a session or redirect based on the role
            session_start();

            // Set session variables
            $_SESSION['username'] = $dbUsername;
            $_SESSION['role'] = $userRole;

            // Redirect based on the role
            if ($userRole == 'Admin') {
                header("Location: ../admin/dashboard.php");
            } elseif ($userRole == 'User') {
                header("Location: ../dashboard/dashboard.html");
            } else {
                // Handle other roles as needed
                echo "<script>alert('Unknown role.');</script>";
            }

            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Incorrect password. Please try again.');</script>";
        }
    } else {
        // User with the given username does not exist
        echo "<script>alert('User not found. Please check your username.');</script>";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENIOR CITIZEN INFORMATION SYSTEM</title>
    <link rel="stylesheet" href="login.css">


    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
<!----icon------>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">
<!---font--->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    
</head>
<body>
   


    <section class="first-section">


        <div class="auth-container">
            <div class="auth-header">
              <h2>Login</h2>
            </div>
            <div class="auth-form">
            <form id="login-form" method="post" action="">
                <div class="form-group">
                  <label for="username">Username:</label>
                  <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                  <label for="password">Password:</label>
                  <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                  <button type="submit">Login</button>
                </div>
              </form>
           
            </div>
            <div class="switch-form">
            <a href="signup.php"> <button>Switch to Sign Up</button> </a>
            </div>
          </div>

    </section>


</body>
</html>
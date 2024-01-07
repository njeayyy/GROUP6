<?php

// Include your database connection file
include('../session/db.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Fetch user input
    $firstName = ucwords($_POST['newFirstName']);
    $lastName = ucwords($_POST['newLastName']);
    $username = $_POST['newUsername'];
    $password = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if the passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
        exit(); // Stop execution if passwords don't match
    }

    // Handle file upload
    if (isset($_FILES['idPicture']) && $_FILES['idPicture']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../admin/SeniorID-verification';
        $uploadFile = $uploadDir . basename($_FILES['idPicture']['name']);

        // Move the uploaded file to the desired location
        if (move_uploaded_file($_FILES['idPicture']['tmp_name'], $uploadFile)) {
            // File upload successful, you can use $uploadFile or other relevant information
            // ...
        } else {
            echo "<script>alert('Error uploading ID picture.');</script>";
            exit();
        }
    } else {
        echo "<script>alert('ID picture upload failed.');</script>";
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (First_Name, Last_Name, Email, Password, Role, Status ,ID_Picture) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $firstName, $lastName, $username, $hashedPassword, $role, 'Not Verified', $uploadFile);
    
    // Set the value of $role to 'User'
    $role = 'User';
    
    // Check if the statement is executed successfully
    if ($stmt->execute()) {
        // Registration successful
        echo "<script>alert('Registration successful!');</script>";
    
    } else {
        // Registration failed
        echo "<script>alert('Error during registration: " . $stmt->error . "');</script>";
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
    <link rel="stylesheet" href="signup.css">


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
              <h2>Sign Up</h2>
            </div>
            <div class="auth-form">
            <form method="post" action="" enctype="multipart/form-data">
                <!-- Add newFirstName and newLastName fields -->
                <div class="form-group">
                  <label for="newFirstName">First Name:</label>
                  <input type="text" id="newFirstName" name="newFirstName" required>
                </div>
                <div class="form-group">
                  <label for="newLastName">Last Name:</label>
                  <input type="text" id="newLastName" name="newLastName" required>
                </div>
                <!-- End of modifications -->
                <div class="form-group">
                  <label for="newUsername">Username:</label>
                  <input type="text" id="newUsername" name="newUsername" required>
                </div>
                <div class="form-group">
                  <label for="newPassword">Password:</label>
                  <input type="password" id="newPassword" name="newPassword" required>
                </div>
                <div class="form-group">
                  <label for="confirmPassword">Re-enter Password:</label>
                  <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>

                <div class="form-group">
      <label for="idPicture">Upload ID Picture:</label>
      <input type="file" id="idPicture" name="idPicture" accept="image/*" required>
  </div>




                <div class="form-group">
                  <button type="submit">Sign Up</button>
                </div>
              </form>
            </div>
            <div class="switch-form">
               <a href="login.php"> <button>Switch to Sign In</button> </a>
            </div>
          </div>
    </section>
</body>
</html>
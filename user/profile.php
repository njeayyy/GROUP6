    <?php
    // Include the session manager

    require '../session/db.php';



    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect the user to the login page or another page as needed
        header("Location: ../index/login.php");
        exit();
    }   

    // If you need additional user information, you can fetch it from the session
    $userID = $_SESSION['user_id'];
    $lastname = $_SESSION['Last_name'];
    $firstName = $_SESSION['First_name'];
    $dbUsername = $_SESSION['email'];
    $fullName = $lastname . ' ' . $firstName;


    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save_btn'])) {
        // Get the new values from the form
        $newFirstName = $_POST['firstname'];
        $newLastName = $_POST['lastname'];


        require '../session/db.php';
    
        // Validate and update the user's information in the database
        if (!empty($newFirstName) && !empty($newLastName)) {
            // Connect to your database (replace with your database credentials)
     
    
            // Update user information in the database
            $updateQuery = "UPDATE users SET First_name=?, Last_name=? WHERE user_id=?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("sss", $newFirstName, $newLastName, $userID);
            
            if ($stmt->execute()) {
                // Update session variables with new values
                $_SESSION['First_name'] = $newFirstName;
                $_SESSION['Last_name'] = $newLastName;
    
                // Set success message
                $_SESSION['successMessage'] = "Profile updated successfully!";
            } else {
                // Set error message
                $_SESSION['errorMessage'] = "Error updating profile. Please try again.";
            }
    
            // Close the database connection
            $stmt->close();
            $conn->close();
        } else {
            // Set error message if required fields are empty
            $_SESSION['errorMessage'] = "First name and last name are required.";
        }
    
        // Redirect back to the same page to clear the form data from the URL
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    ?>

    









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USER DASHBOARD</title>
    <link rel="stylesheet" href="style/dashboard.css">


    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    
</head>
<body>



<div id="sidebar" class="sidebar">
        <div class="logo">
        <img src="../admin/images/logo2.png" alt="">

        </div>
            <ul class="menu">

                <li >
                    <a href="userdashboard.php" >
                    <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


            
                

                
            
     


                <li >
                    <a href="" >
                    <i class="ri-account-pin-box-line"></i>
                        <span>Profile</span>
                    </a>
                </li>

                
              


          

                <li class="logout">
                    <a href="../index/logout.php" id="logout-link">
                    <i class="ri-logout-box-line"></i>
                        <span>Logout</span>
                    </a>
                </li>






            </ul>
    
</div>




<div class="main--content">

        <div class="header--wrapper">
        
                <div class="menu-search">
                
                    <i class="ri-menu-2-fill"></i>

                        
                </div>



                <div class="profile">

                    <img src="" alt="" class="profile-image">

                    <div class="profile-name">

                                <p><?php echo $fullName; ?></p>
                                <span><?php echo $dbUsername; ?></span>

                    </div>
                    



                    <button class="dropdown-btn">  <i class="ri-arrow-down-s-fill"></i>   </button>  


                    <div class="dropdown-content">

                        <div class="a-content">
                                <a href="#">Edit Profile</a>
                                <a href="#">Settings</a>
                                <a href="#">Help and Support</a>

                        </div>

                    </div>



          
                    
                </div>
        
        
        
        </div>



        <div class="body--wrapper">

                <h1>Profile</h1>


                <form action="" method="post">

                    <div class="service-box">
                        <label for="email">Email:</label>
                        <input type="email" name="email" value="<?php echo $dbUsername; ?>" required readonly>
                    </div>


                    
                    <div class="service-box">
                        <label for="firstname">First Name:</label>
                        <input type="text" name="firstname" value="<?php echo $firstName; ?>" required>
                    </div>

                        <div class="service-box">
                        <label for="lastname">Last Name:</label>
                        <input type="text" name="lastname" value="<?php echo $lastname; ?>" required>
                    </div>




                    <button type="submit" name="save_btn" class="Save-Btn">Save</button>

                    </form>



<div id="successMessage" class="success-message"><i id="bx-check" class='bx bx-check'></i></div>

<div id="errorMessage" class="errorMessage"><i id="bx-error" class='bx bx-x-circle'></i></div>




            







        </div>





</div>

   
</body>


<script> 

/* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
                var dropdown = document.getElementsByClassName("dropdown-btn");
                var i;

                for (i = 0; i < dropdown.length; i++) {
                dropdown[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
                } else {
                dropdownContent.style.display = "block";
                }
                });
                }


                
          
    // Check if the success parameter is present in the URL
    var successMessage = "<?php echo isset($_SESSION['successMessage']) ? $_SESSION['successMessage'] : ''; ?>";
    if (successMessage !== "") {
        var successMessageDiv = document.getElementById("successMessage");
        successMessageDiv.textContent = successMessage;
        successMessageDiv.style.display = "block";

        // Scroll to the success message for better visibility
        successMessageDiv.scrollIntoView({ behavior: 'smooth' });

        // Remove the session variable to avoid displaying the message on subsequent page loads
        <?php unset($_SESSION['successMessage']); ?>
    }

    var errorMessage = "<?php echo isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : ''; ?>";
    if (errorMessage !== "") {
        var errorMessageDiv = document.getElementById("errorMessage");
        errorMessageDiv.textContent = errorMessage;
        errorMessageDiv.style.display = "block";

        // Scroll to the error message for better visibility
        errorMessageDiv.scrollIntoView({ behavior: 'smooth' });

        // Remove the session variable to avoid displaying the message on subsequent page loads
        <?php unset($_SESSION['errorMessage']); ?>
    }









                


    </script>
</html>
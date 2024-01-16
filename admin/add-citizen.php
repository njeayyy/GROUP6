<?php
// Include the session manager
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include your database connection file
include('../session/db.php');
require '../vendor/autoload.php';
require '../session/config.php';


session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page or another page as needed
    header("Location: ../index/login.php");
    exit();
}


$userID = $_SESSION['user_id'];
$lastname = $_SESSION['Last_name'];
$firstName = $_SESSION['First_name'];
$dbUsername = $_SESSION['email'];

$fullName = $lastname . ' ' . $firstName;


// ... (your existing code)

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Your existing code to check if the user is logged in...

    // Retrieve form data
    $email = $_POST['email'];
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $dob = $_POST['DOB'];
    $contactPerson = $_POST['ContactPerson'];
    $contactNumber = $_POST['ContactNumber'];
    $contactAddress = $_POST['ContactAddress'];
    $address = $_POST['Address'];
    $pension = $_POST['Pension'];
    $rawPassword = generateRandomPassword(12); // Use the random password function with length 12
    $hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT); // Hash the password

    // Insert data into the database
    // (Assuming you have a database connection and a table named 'senior_citizens')
    $sql = "INSERT INTO users (email, first_name, last_name, dob, Contact_person, Contact_number, Contact_address,  pension, password, Status, Role) 
            VALUES ('$email', '$firstName', '$lastName', '$dob', '$contactPerson', '$contactNumber', '$contactAddress',  '$pension', '$hashedPassword' , 'Verified', 'User')";
    if (mysqli_query($conn, $sql)) {
        // Create a PHPMailer instance
        $mail = new PHPMailer;

        // Set up SMTP for sending the email
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->Username = SMTP_USERNAME; // Use the constant
        $mail->Password = SMTP_PASSWORD; // Use the constant

            $mail->setFrom(SMTP_USERNAME,  'Account Added');
        $mail->addAddress($email, $firstName . ' ' . $lastName);

        // Set email subject and body
        $mail->Subject = 'Welcome to Senior Citizen Information System';
        $mail->Body = 'Dear ' . $firstName . ', 

        Thank you for registering with Senior Citizen Information System. Your password is: ' . $rawPassword . '

        Best regards,
        Senior Citizen Information System Team';

        // Send the email
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            $_SESSION['successMessage'] = "Senior citizen added successfully! Email sent.";
        }
    } else {
        $_SESSION['errorMessage'] = "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);

    // Redirect back to the same page to display success/error messages
    header("Location: add-citizen.php");
    exit();
}
function generateRandomPassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_';
    $password = '';
    
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $password;
}

// Usage
$randomPassword = generateRandomPassword(12);





?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SENIOR CITIZEN INFORMATION SYSTEM</title>
    <link rel="stylesheet" href="style/dashboard.css">


    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.6.0/fonts/remixicon.css" rel="stylesheet">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">



    <!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<!-- Include DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<!-- Include DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

<!-- Your other styles and scripts -->
    

    
</head>
<body>



<div id="sidebar" class="sidebar">
        <div class="logo">
        <img src="images/logo2.png" alt="">

        </div>
            <ul class="menu">

                <li >
                    <a href="dashboard.php" >
                    <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                
            
                <li >
                    <a href="events.php" >
                    <i class="ri-calendar-event-fill"></i>
                        <span>Events</span>
                    </a>
                </li>

                <li >
                    <a href="announcements.php" >
                    <i class="ri-megaphone-line"></i>
                        <span>Announcements</span>
                    </a>
                </li>




                <li>    
                    <button class="dropdown-btn">
                        <i class="ri-user-6-line"></i>
                        <span>Senior Citizen</span>
                        <i id="chevron-down" class='bx bxs-chevron-down'></i>
                    </button>

                    <div class="dropdown-container">
                        <a href="citizens-list.php">List of Seniors</a>
                            <a href="add-citizen.php">Add Senior </a>
                          

                    </div>

                </li>



             
                
                <li>    
                    <button class="dropdown-btn">
                    <i class="ri-service-line"></i>
                        <span>Services</span>
                        <i id="chevron-down" class='bx bxs-chevron-down'></i>
                    </button>

                    <div class="dropdown-container">
                            <a href="services-list.php">List of Services</a>
                            <a href="add-services.php">Add Services </a>
                          

                    </div>

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



               <i class="ri-arrow-down-s-fill"></i>


            
            </div>
        
        
        
        </div>



        <div class="body--wrapper">

                <p class="AddMember-title">Add New Member</p>

                <form action="" method="post">

                <div class="input-box">
                        <label for="email">Email: </label>
                        <input type="email" name="email" placeholder="Email: " required>
                    </div>

                    <div class="input-box">
                        <label for="FirstName">First Name: </label>
                        <input type="text" name="FirstName" placeholder="First Name" required>
                    </div>



                    <div class="input-box">
                        <label for="LastName">Last Name: </label>
                        <input type="text" name="LastName" placeholder="Last Name" required>
                    </div>

                    <div class="input-box">
                        <label for="DOB">Date of Birth: </label>
                        <input type="date" name="DOB" placeholder="Date of Birth" required>
                    </div>


                    <div class="input-box">
                        <label for="ContactPerson">Contact Person: </label>
                        <input type="text" name="ContactPerson" placeholder="Contact Person" required>
                    </div>

                    <div class="input-box">
                        <label for="ContactNumber">Contact Number: </label>
                        <input type="text" name="ContactNumber" placeholder="Contact Number" required >
                    </div>

                    <div class="input-box">
                        <label for="ContactAddress">Contact Address:  </label>
                        <input type="text" name="ContactAddress" placeholder="Contact Address" required>
                    </div>

                    <div class="input-box">
                        <label for="Address">Address: </label>
                        <input type="text" name="Address" placeholder="Address" required >
                    </div>

                    <div class="input-box">
                        <label for="Pension">Pension: </label>
                        <input type="text" name="Pension" placeholder="Pension" required>
                    </div>


                    <button type="submit" class="Save-Btn">Add</button>






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
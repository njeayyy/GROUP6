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


$sql = "SELECT service_id, Service_Title, Description, Date_Created FROM services";
$result = $conn->query($sql);

// Close the database connection
$conn->close();



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
            <img src="#" alt="">

        </div>
            <ul class="menu">

                <li >
                    <a href="userdashboard.php" >
                    <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                
                <li >
                    <a href="pensionhistory.php" >
                    <i class="ri-history-line"></i>
                        <span>Pension History</span>
                    </a>
                </li>

                

                
            
     


                <li >
                    <a href="profile.php" >
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

                <h1>Service Announcements</h1>


                <div class="service-container">
                        <?php
                        // Iterate through the fetched services
                        while ($row = $result->fetch_assoc()) {
                            $serviceId = $row['service_id'];
                            $serviceTitle = $row['Service_Title'];
                            $description = $row['Description'];
                            $dateCreated = $row['Date_Created'];

                            // Check if the service is within the last 14 days
                            $currentDate = new DateTime();
                            $serviceDate = new DateTime($dateCreated);
                            $interval = $currentDate->diff($serviceDate);

                            // Display the service only if it's within the last 14 days
                            if ($interval->days <= 14) {
                                echo '<div class="service-inside-container">';
                                echo '<h3 class="service-title">' . $serviceTitle . '</h3>';
                                echo '<p class="service-description">' . $description . '</p>';
                                echo '<p class="date">' . $dateCreated . '</p>';
                                echo '</div>';
                            }
                        }
                        ?>









               
            







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





                


    </script>
</html>
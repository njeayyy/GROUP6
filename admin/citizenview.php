<?php
session_start();
require '../session/db.php';



// Check if the patient ID is provided in the URL
if (!isset($_GET['user_id'])) {
    header("Location: citizens-list.php");
    exit();
}

$user_id= $_GET['user_id'];



// Fetch patient details based on the provided ID
$sql = "SELECT * FROM users WHERE user_id = $user_id";
$result = $conn->query($sql);
$seniorDetails = $result->fetch_assoc();


$sql_pensions = "SELECT * FROM pension_history WHERE Senior_ID = $user_id";
$result_pensions = $conn->query($sql_pensions);



// Close the database connection
$conn->close();



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

</head>
<body>



<div id="sidebar" class="sidebar">
        <div class="logo">
            <img src="#" alt="">

        </div>
            <ul class="menu">

                <li >
                    <a href="dashboard.php" >
                    <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                
            
                <li>
                    <button class="dropdown-btn">
                    <i class="ri-building-4-line"></i>
                        <span>Barangays</span>
                        <i id="chevron-down" class='bx bxs-chevron-down'></i>
                    </button>

                    <div class="dropdown-container">
                            <a href="#">List of Barangays</a>
                          

                    </div>

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


                <li >
                    <a href="claim-pension.php" >
                    <i class="ri-account-pin-box-line"></i>
                        <span>Pension</span>
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

               <button class="profile-image">

               </button>

               <div class="profile-name">

                        <p>Customer Name</p>
                        <span>Customer Email</span>

               </div>


               <i class="ri-arrow-down-s-fill"></i>


            
            </div>
        
        
        
        </div>



        <div class="body--wrapper">

                    <h1 class="Seniorh1">Senior Details</h1>
                    <div class="citizen-container">
                          <p>Senior ID:  <span><?php echo $seniorDetails['user_id']; ?></span>   </p>
                          <p>First Name: <span><?php echo $seniorDetails['First_Name']; ?></span>   </p>
                          <p>Last Name: <span><?php echo $seniorDetails['Last_Name']; ?></span>   </p>
                       
                          <p>Pension per Month: <span><?php echo $seniorDetails['Pension']; ?></span>   </p>
                          <p>Date of Birth: <span><?php echo $seniorDetails['DOB']; ?> </span>  </p>
                          <p>Contact Person: <span><?php echo $seniorDetails['Contact_Person']; ?></span>   </p>
                          <p>Contact Number:  <span><?php echo $seniorDetails['Contact_Number']; ?></span>   </p>
                          <p>Contact Address:  <span><?php echo $seniorDetails['Contact_Address']; ?></span>    </p>


                    </div>

                    <h1 class="Seniorh1">Pension History</h1>
                    <div class="pension-container">
                        <?php
                        // Loop through each pension record and display the details
                        while ($pensionDetails = $result_pensions->fetch_assoc()) {
                            echo "<p>Pension ID: <span>{$pensionDetails['pension_id']}</span></p>";
                   
            $formattedClaimDate = date('F j, Y', strtotime($pensionDetails['claim_Date']));
            echo "<p>Claim Date: <span>{$formattedClaimDate}</span></p>";
                            echo "<p>Amount: <span>{$pensionDetails['Amount']}</span></p>";
                            echo "<hr>"; // Add a horizontal line between pension records
                        }
                        ?>
                    </div>




               







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
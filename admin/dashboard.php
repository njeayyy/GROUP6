<?php
// Include the session manager

require '../session/db.php';


session_start();


// Your other code here

if (!isset($_SESSION["username"])) {
    header("Location: login.php"); 
    exit;
}






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



                <li >
                    <a href="users-list.php" >
                    <i class="ri-account-pin-box-line"></i>
                        <span>Users</span>
                    </a>
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

                <div class="info-wrap">

                            <div class="info-container">

                                    <p class="info-title">
                                        Total Users
                                    </p>

                                    <p class="info-maintext">
                                        180
                                    </p>

                                    <a href="" class="info-link">
                                        View All
                                    </a>
                                  


                            </div>


                            <div class="info-container">

                            <p class="info-title">
                                Total Users
                            </p>

                            <p class="info-maintext">
                                180
                            </p>

                            <a href="" class="info-link">
                                View All
                            </a>



                            </div>


                            <div class="info-container">

                            <p class="info-title">
                                Total Users
                            </p>

                            <p class="info-maintext">
                                180
                            </p>

                            <a href="" class="info-link">
                                View All
                            </a>



                            </div>


                            <div class="info-container">

                            <p class="info-title">
                                Total Users
                            </p>

                            <p class="info-maintext">
                                180
                            </p>

                            <a href="" class="info-link">
                                View All
                            </a>



                            </div>






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
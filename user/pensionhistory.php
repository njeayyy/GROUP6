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



       <!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<!-- Include DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<!-- Include DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <script defer>
$(document).ready(function () {
    // Initialize DataTable with additional options
    var dataTable = $('#myTable').DataTable({
        "lengthMenu": [10, 25, 50, 75, 100],
        "pageLength": 10,
        "pagingType": "full_numbers",
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "Next",
                "previous": "Previous"
            }
        }
    });

});




    </script>
    
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
                    <a href="" >
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

                <h1>Pension</h1>



                <table id="myTable" class="display">

                    <thead id="thead" >

                    <tr>
                        <th>Pension ID</th>
                        <th>Senior ID</th>
                        <th>Claim Date</th>
                        <th>Amount</th>
                  
                        

                    </tr>



                    </thead>


                    <tbody>



                    </tbody>

                    </table>




              
            







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
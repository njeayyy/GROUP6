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

                <div class="claim-wrap">

                         
                    <div class="form-container">



                    <form action="claim-pension-action.php" method="POST" id="claimForm">


                            <h1>Search User</h1>


                            <div class="claim-container">
                            <label for="user">Search user</label>
                            <select name="user" id="userSelect">
                                <?php
                                // Fetch all users from the database and populate the dropdown
                                $allUsersQuery = "SELECT user_id, First_Name, Last_Name FROM users";
                                $allUsersResult = mysqli_query($conn, $allUsersQuery);

                                if ($allUsersResult) {
                                    while ($userRow = mysqli_fetch_assoc($allUsersResult)) {
                                        $userId = $userRow['user_id'];
                                        $userName = $userRow['First_Name'] . ' ' . $userRow['Last_Name'];
                                        echo "<option value='$userId'>$userName, User ID: $userId</option>";
                                    }

                                    mysqli_free_result($allUsersResult);
                                } else {
                                    echo "<option value='' disabled selected>No users available</option>";
                                }
                                ?>
                            </select>
                        </div>

                                    

                               




                            
                         

                            <div class="claim-container">

                            <label for="">Enter amount to be claimed</label>
                            <input type="text" name="amount">


                            </div>


                            <button class="Save-btn" type="submit">Claim Pension</button>





                            </form>




                       


                        



                    </div>

                          

                            <hr>


                                 
                            <div class="user-information" id="userInformation">




                                <h1>Senior Citizen Information</h1>


                                    <p class="name">User ID:</p>
                                    <p class="email">Email: </p>
                                    <p class="dob">Date of birth: <span></span></p>
                                    <p class="status">Status: <span> </span></p>
                                    <p class="pension">Pension per month: </p>





                            
                            </div>


                 




                    

                          





                </div>







        </div>





</div>

   
</body>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // Get the userSelect dropdown element
    var userSelect = document.getElementById('userSelect');

    // Add a change event listener to the dropdown
    userSelect.addEventListener('change', function () {
        // Get the selected user ID
        var selectedUserId = userSelect.value;

        // Check if a user is selected
        if (selectedUserId !== '') {
            // Make an AJAX request to fetch user information
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'fetch-user-info.php?user_id=' + selectedUserId, true);

            // Define the callback function to handle the response
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Parse the JSON response
                    var userInfo = JSON.parse(xhr.responseText);

                    // Display user information in the userInformation div
                    document.getElementById('userInformation').innerHTML = `
                        <h1>Senior Citizen Information</h1>
                        <p class="name">User ID: ${userInfo.user_id}</p>
                        <p class="email">Email: ${userInfo.Email}</p>
                        <p class="dob">Date of birth: ${userInfo.DOB}</p>
                        <p class="status">Status: ${userInfo.Status}</p>
                        <p class="pension">Pension per month: ${userInfo.Pension}</p>
                    `;
                }
            };

            // Send the AJAX request
            xhr.send();
        } else {
            // Clear the user information if no user is selected
            document.getElementById('userInformation').innerHTML = '';
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    // Get the claimForm element
    var claimForm = document.getElementById('claimForm');

    // Add a submit event listener to the form
    claimForm.addEventListener('submit', function (event) {
        // Prevent the default form submission
        event.preventDefault();

        // Submit the form using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'claim-pension-action.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            // Handle the response, you can redirect or show a message
            if (xhr.status === 200) {
                alert('Pension claimed successfully!');
                // You may want to redirect to another page or update the UI
            } else {
                alert('Failed to claim pension. Please try again.');
                // Handle the error, show an error message, or redirect
            }
        };

        // Get form data and send the request
        var formData = new FormData(claimForm);
        xhr.send(new URLSearchParams(formData));
    });
});

</script>


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
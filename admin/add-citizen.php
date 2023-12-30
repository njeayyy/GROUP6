<?php
session_start();
require '../session/db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and capitalize first letter of each word
    $firstName = ucwords(strtolower($_POST["FirstName"]));
    $lastName = ucwords(strtolower($_POST["LastName"]));
    $dob = $_POST["DOB"];
    $contactPerson = ucwords(strtolower($_POST["ContactPerson"]));
    $contactNumber = $_POST["ContactNumber"];
    $contactAddress = ucwords(strtolower($_POST["ContactAddress"]));
    $address = ucwords(strtolower($_POST["Address"]));
    $pension = $_POST["Pension"];
    $status = "Active"; // You can set a default status

    // Prepare and bind the SQL statement with placeholders
    $stmt = $conn->prepare("INSERT INTO senior_table (First_Name, Last_Name, DoB, Contact_Person, Contact_Number, Contact_Address, Address, Pension, Status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters to the placeholders, using "s" for string type
    $stmt->bind_param("sssssssss", $firstName, $lastName, $dob, $contactPerson, $contactNumber, $contactAddress, $address, $pension, $status);

    // Execute the statement
    if ($stmt->execute()) {
        // Set success message in the session
        $_SESSION['successMessage'] = "Record added successfully";
       
        header("Location: add-citizen.php");
        exit();
    } else {
        // Set error message in the session
        $_SESSION['errorMessage'] = "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

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



    <!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<!-- Include DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<!-- Include DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

<!-- Your other styles and scripts -->

<script defer>
    $(document).ready(function () {
        // Initialize DataTable with additional options
        $('#myTable').DataTable({
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

    /* Other scripts and functions */
</script>
    
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
                    <a href="logout.php" id="logout-link">
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

                <p class="AddMember-title">Add New Member</p>

                <form action="" method="post">

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
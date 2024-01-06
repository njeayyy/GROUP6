<?php
session_start();
require '../session/db.php';

// Check if service_id parameter is set in the URL
if (isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];

    // Fetch the service data from the database based on service_id
    $query = "SELECT * FROM services WHERE service_id = $service_id";
    $result = mysqli_query($conn, $query);

    // Check for errors in query execution
    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Check if a service with the given service_id exists
    if (mysqli_num_rows($result) == 1) {
        $serviceDetails = mysqli_fetch_assoc($result);

        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle form submission and update the service in the database

            // Get the new title and description from the form
            $newTitle = mysqli_real_escape_string($conn, $_POST['newTitle']);
            $newDescription = mysqli_real_escape_string($conn, $_POST['newDescription']);

            // Update the service in the database
            $updateQuery = "UPDATE services SET Service_Title = '$newTitle', Description = '$newDescription' WHERE service_id = $service_id";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                // Set success message
                $_SESSION['successMessage'] = "Service updated successfully";
            } else {
                // Set error message
                $_SESSION['errorMessage'] = "Error updating service: " . mysqli_error($conn);
            }

            // Redirect to the same page to prevent form resubmission
            header("Location: edit-services.php?service_id=$service_id");
            exit();
        }
    } else {
        echo "Service not found!";
    }

    mysqli_free_result($result);
} else {
    echo "Service ID not provided!";
}

mysqli_close($conn);
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

                <p class="AddMember-title">Edit Services</p>

                <form action="" method="post">

                    <div class="service-box">
                        <label for="newTitle">Service Title:</label>
                        <input type="text" name="newTitle" value="<?php echo htmlspecialchars($serviceDetails['Service_Title']); ?>" required>
                    </div>

                    <div class="service-box">
                        <label for="newDescription">Description:</label>
                        <textarea name="newDescription" required><?php echo htmlspecialchars($serviceDetails['Description']); ?></textarea>
                    </div>

                    <button type="submit" class="Save-Btn">Save</button>

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
<?php
session_start();
require '../session/db.php';

// Fetch data from the database
$query = "SELECT * FROM senior_table";
$result = mysqli_query($conn, $query);


// Check for errors in query execution
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}




// Get the total number of members
$totalMembers = mysqli_num_rows($result);

// Get the count of active members
$activeMembersQuery = "SELECT COUNT(*) AS activeCount FROM senior_table WHERE status = 'Active'";
$activeMembersResult = mysqli_query($conn, $activeMembersQuery);

// Check for errors in the active members query execution
if (!$activeMembersResult) {
    die("Active members query failed: " . mysqli_error($conn));
}

$activeCountRow = mysqli_fetch_assoc($activeMembersResult);
$activeMembers = $activeCountRow['activeCount'];

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

                <div class="table-title">

                    <p >Members</p>

                    <a href="add-citizen.php" class="add-member">Add New</a>   

                    <a href="" class="import-member">Import Members</a>

                    <a href="" class="export-member">Export Members(Excel)</a>

                    <div class="table-title-info">
                            <p>Total Members: <span><?php echo $totalMembers; ?></span></p>
                            <p>Current Active: <span><?php echo $activeMembers; ?></span></p>
                    </div>


                </div>


                <div class="rectangle">

        
                                
                            <table id="myTable" class="display">

                            <thead id="thead" >

                            <tr>
                                <th>ID No.</th>
                                <th>Full Name</th>
                                <th>Age</th>
                                <th>Birthday</th>
                                <th>Contact No.</th>
                                <th>Contact Person</th>
                                <th>Address</th>

                                <th>Monthly Pension</th>

                                <th>Status</th>

                                <th>Action</th>
                                
                        
                            </tr>



                            </thead>


                            <tbody>


                            <?php 

                            

                            if (mysqli_num_rows($result) > 0) {
                                // Generate HTML table rows based on the database columns
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>{$row['Senior_ID']}</td>";
                                    echo "<td>{$row['First_Name']} {$row['Last_Name']}</td>";
                                
                                    // Calculate age based on DoB
                                    $dob = new DateTime($row['DoB']);
                                    $currentDate = new DateTime();
                                    $age = $currentDate->diff($dob)->y;
                                
                                    echo "<td>{$age}</td>"; // Display age instead of directly fetching 'Age' from the database
                                    echo "<td>{$row['DoB']}</td>";
                                    echo "<td>{$row['Contact_Number']}</td>";
                                    echo "<td>{$row['Contact_Person']}</td>";
                                    echo "<td>{$row['Address']}</td>";
                                    echo "<td>{$row['Pension']}</td>";
                                    echo "<td>{$row['Status']}</td>";
                                    
                                    // Add additional columns and formatting as needed
                                    
                                   


                                                                        
                                    echo "<td class='button-action'>
                                    <a href='doctor-viewpatient.php?patient_id={$row['Senior_ID']}' class='view-button'>View <i class='bx bxs-show'></i></a>
                                    <a href='doctor-editpatient.php?patient_id={$row['Senior_ID']}' class='edit-button'>Edit <i class='bx bxs-message-square-edit'></i></a>
                                    <button class='delete-button' data-patient-id='{$row['Senior_ID']}' type='button'>Delete <i class='bx bxs-checkbox-minus'></i></button>


                                </td>";


                                    echo "</tr>";
                                } 
                                
                                
                                } else {
                                    // Handle the case when no rows are returned
                                    echo "<tr><td colspan='10'>No records found</td></tr>";
                                }
                                
                                
                                
                                
                                mysqli_free_result($result);
                                
                                mysqli_close($conn);
                            
                            
                            
                            
                            
                            ?>

                                


                            </tbody>

                            </table>




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
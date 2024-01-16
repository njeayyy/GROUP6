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

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    events: {
      url: 'get-events.php',
      method: 'POST',
      extraParams: {
        custom_param: 'No events'
      },
      failure: function() {
        alert('There was an error while fetching events!');
      },
      color: 'yellow',   // a non-ajax option
      textColor: 'black' // a non-ajax option   
    },
    eventClick: function(info) {
        var eventDetails = "Title: " + info.event.title + "\n";

        if (info.event.start) {
            eventDetails += "Start: " + info.event.start.toLocaleString() + "\n";
        }

        if (info.event.end) {
            eventDetails += "End: " + info.event.end.toLocaleString() + "\n";
        }

        eventDetails += "Place: " + (info.event.extendedProps.place || 'N/A') + "\n";
        eventDetails += "Author: " + (info.event.extendedProps.author || 'N/A');

        alert(eventDetails);

    }
  });
  calendar.render();
});


  $(document).ready(function() {
    $('#add-event-btn').on('click', function() {
      $('#event-form').show();
    });

    $('#save-event-btn').on('click', function() {
      var title = $('#event-title').val();
      var start = $('#event-start').val();
      var end = $('#event-end').val();
      var place = $('#event-place').val();
      var author = $('#event-author').val();

      $.ajax({
        url: 'save-event.php',
        type: 'POST',
        data: {
          title: title,
          start: start,
          end: end,
          place: place,
          author: author
        },
        success: function(response) {
        console.log(response);

        // Check the response for success and show alert
        if (response.trim() === "Event saved successfully") {
            alert('Event added successfully!');
        } else {
            alert('Error adding event. Please try again.');
        }

        // Handle the response (if needed)
    },
    error: function(error) {
        console.error(error);
    }
      });

      // Hide the form after saving
      $('#event-form').hide();
    });

    $('#close-event-btn').on('click', function() {
        // Hide the form when the close button is clicked
        $('#event-form').hide();
    });
  });
</script>

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
                    



                    <button class="dropdown-btn">  <i class="ri-arrow-down-s-fill"></i>   </button>  


                    <div class="dropdown-content">

                        <div class="a-content">
                                <a href="profile.php">Edit Profile</a>
                                <a href="#">Settings</a>
                                <a href="#">Help and Support</a>

                        </div>

                    </div>



          
                    
                </div>
        
        
        
        </div>



        <div class="body--wrapper">

           
                <div class="calender-container">

                        
                        <button id="add-event-btn">Add Event</button>


                        <div id="calendar"></div>   
                </div>







        </div>





</div>



<div class="modal-container" id="event-form" style="display: none;" >

            <div class="event-form">
                <h2>Add Event</h2>
                <label for="event-title">Title:</label>
                <input type="text" id="event-title" required>

                <label for="event-start">Start Time:</label>
                <input type="datetime-local" id="event-start" required>

                <label for="event-end">End Time:</label>
                <input type="datetime-local" id="event-end" required>

                <label for="event-place">Place:</label>
                <input type="text" id="event-place" required>

                <label for="event-author">Author:</label>
                <input type="text" id="event-author" required>

               
                <button id="save-event-btn" class="save-event-btn">Save Event</button>
                <button id="close-event-btn" class="close-event-btn">Close</button>
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
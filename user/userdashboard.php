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


$servicesql = "SELECT service_id, Service_Title, Description, Date_Created FROM services";
$serviceresult = $conn->query($servicesql);


$current_date = date('Y-m-d');
$sql = "SELECT * FROM images WHERE expiration_date >= '$current_date'";
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
            <img src="../admin/images/logo2.png" alt="">

        </div>
            <ul class="menu">

                <li >
                    <a href="userdashboard.php" >
                    <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
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

                <h1>Dashboard</h1>

                <!-- Slider container -->
                <div class="slider" width="100%" height="200px">


                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="slide">
                            <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['caption']; ?>" />
                        </div>
                    <?php endwhile; ?>
                        
                <!-- Control buttons -->
                <button class="btn btn-next"> > </button>
                <button class="btn btn-prev">
                    < </button>

</div>



                 <!-- Calendar -->



                <div class="calender-container">


                <div id="calendar"></div>   
                </div>


                <!-- Calendar -->
                                

                <!-- Services -->

                        <h2>Services</h2>



                        <div class="service-container">

                                            
                        <?php
                        // Iterate through the fetched services
                        while ($row = $serviceresult->fetch_assoc()) {
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


<script>

"use strict";
// Select all slides
const slides = document.querySelectorAll(".slide");

// loop through slides and set each slides translateX
slides.forEach((slide, indx) => {
  slide.style.transform = `translateX(${indx * 100}%)`;
});

// select next slide button
const nextSlide = document.querySelector(".btn-next");

// current slide counter
let curSlide = 0;
// maximum number of slides
let maxSlide = slides.length - 1;

// add event listener and navigation functionality
nextSlide.addEventListener("click", function () {
  // check if current slide is the last and reset current slide
  if (curSlide === maxSlide) {
    curSlide = 0;
  } else {
    curSlide++;
  }

  //   move slide by -100%
  slides.forEach((slide, indx) => {
    slide.style.transform = `translateX(${100 * (indx - curSlide)}%)`;
  });
});

// select next slide button
const prevSlide = document.querySelector(".btn-prev");

// add event listener and navigation functionality
prevSlide.addEventListener("click", function () {
  // check if current slide is the first and reset current slide to last
  if (curSlide === 0) {
    curSlide = maxSlide;
  } else {
    curSlide--;
  }

  //   move slide by 100%
  slides.forEach((slide, indx) => {
    slide.style.transform = `translateX(${100 * (indx - curSlide)}%)`;
  });
});





</script>





</html>
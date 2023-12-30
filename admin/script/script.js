document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const sidebar = document.querySelector(".sidebar");

    menuToggle.addEventListener("click", function () {
        sidebar.classList.toggle("minimized");
    });


       // Add code to handle the close button click
       const closeSidebarButton = document.getElementById("close-sidebar");
       closeSidebarButton.addEventListener("click", function () {
           sidebar.classList.remove("minimized");
       });
   });

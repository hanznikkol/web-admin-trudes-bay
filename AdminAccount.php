
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trudes Bay Admin Homepage</title>
    <link rel="stylesheet" href="AdminAccounts-style.css?ver=<?php echo time();?>">
    <link rel="website icon" type="png" href="Images/Trudes Bay_Final.png" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header>
        <img src="Images/Trudes Bay Strip logo.png" alt="Trudes Bay Beach Resort">
        <svg class="svg-hamburger" onclick="toggleNavigation()" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M7.5 42.5H52.5M7.5 30H52.5M7.5 17.5H52.5" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <script>
            function toggleNavigation() {
                const navMenu = document.querySelector('nav'); // Select the nav element
                navMenu.classList.toggle('active'); // Toggle the 'active' class
            }
        </script>
    </header>
    
     <!--Show only in mobile-->
     <nav class="mobile-nav">
        <a href="AdminAccount.php"><i class='bx bxs-user-account'></i> <span class="nav-item">Accounts</span></a>
        <a href="AdminIndex.php"><i class='bx bxs-home-circle'></i> <span class="nav-item">Home</span></a>
        <a href="AdminReservationList.php"><i class='bx bxs-book-content'></i> <span class="nav-item">Reservation</span></a>
        <a href="AdminAmenities.php"><i class='bx bxs-image'></i> <span class="nav-item">Amenities</span></a>
        <a href="AdminActivities.php"><i class='bx bx-swim'></i> <span class="nav-item">Activities</span></a>
        <a href="AdminAbout.php"><i class='bx bxs-news'></i> <span class="nav-item">About</span></a>
        <a href="AdminFAQ.php"><i class='bx bx-help-circle'></i> <span class="nav-item">FAQ's</span></a>
        <a onclick="logout()"><i class="bx bxs-log-out"></i> <span class="nav-item">Logout</span></a>
    </nav>
    <!--Show only in Desktop-->
    <div class="sidebar">
        <div class="top">
            <div class="logo">
                <!--make this larger-->
                <i class="bx bxl=codepen"></i>
                <span class="bold">Trudes Bay Beach Resort</span>
            </div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <div class="user">
           
            
        </div>
        <ul>
            <li><a href="AdminAccount.php"><i class='bx bxs-user-account'></i> <span class="nav-item">Accounts</span></a></li>
            <li><a href="AdminIndex.php"><i class='bx bxs-home-circle'></i> <span class="nav-item">Home</span></a></li>
            <li><a href="AdminReservationList.php"><i class='bx bxs-book-content'></i> <span class="nav-item">Reservation</span></a></li>
            <li><a href="AdminAmenities.php"><i class='bx bxs-image'></i> <span class="nav-item">Amenities</span></a></li>
            <li><a href="AdminActivities.php"><i class='bx bx-swim'></i> <span class="nav-item">Activities</span></a></li>
            <li><a href="AdminAbout.php"><i class='bx bxs-news'></i> <span class="nav-item">About</span></a></li>
            <li><a href="AdminFAQ.php"><i class='bx bx-help-circle'></i> <span class="nav-item">FAQ's</span></a></li>
            <li><a onclick="logout()"><i class="bx bxs-log-out"></i> <span class="nav-item">Logout</span></a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container">
            <h1>Staff Management</h1>
        </div>

        <div class="tabular--wrapper">
            <h3>Staff List</h3>
            
            <div class="table-container" id="cottage-list"> <!-- Container for dynamically loaded activities -->
                <!-- This section will be populated with reservation data -->
            </div>
        </div>


        <!-- Modal Form -->   
        <div id="addReservationModal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2>Add Staff</h2>
                <form id="reservationForm">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" id="contact_number" name="contact_number" required>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <label for="status">Status:</label>
                    <select id="status" name="status">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="position">Position:</label>
                    <select id="position" name="position">
                        <option value="ADMIN">ADMIN</option>
                        <option value="STAFF">STAFF</option>
                    </select>
                    <div class="button-container">
                        <button type="submit">Add Staff</button>
                    </div>
                </form>
            </div>
        </div>


                <!-- Edit Reservation Modal -->
        <div id="editReservationModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close-button">&times;</span> <!-- New close button -->
                <h2>Edit Staff</h2>
                <form id="editReservationForm">
                    <input type="hidden" id="editReservationId">
                    <label for="editName">Name:</label>
                    <input type="text" id="editName">
                    <label for="editContact">Contact:</label>
                    <input type="text" id="editContact">
                    <label for="editEmail">Email:</label>
                    <input type="email" id="editEmail">
                    <label for="editAddress">Address:</label>
                    <input type="text" id="editAddress">
                    <label for="editUsername">Username:</label>
                    <input type="text" id="editUsername">
                    <label for="editPassword">Password:</label>
                    <input type="text" id="editPassword">
                    <!-- fetch here -->
                    <label for="editStatus">Status:</label>
                    <select id="editStatus" name="status">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    <label for="editPosition">Position:</label>
                    <select id="editPosition">
                        <option value="ADMIN">ADMIN</option>
                        <option value="STAFF">STAFF</option>
                    </select>
                    <div class="button-container">
                        <button type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>

             
    </div>

    <script src="AdminAccounts-scripts.js?ver=<?php echo time();?>"></script>
    <script src="sessionchecker.js?ver=<?php echo time();?>"></script>
    <footer>
        <p>&copy; Trudes Bay Beach Resort</p>
    </footer>
</body>
</html>

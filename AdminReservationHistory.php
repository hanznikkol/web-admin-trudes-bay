<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trudes Bay Admin Reservation List</title>
    <link rel="stylesheet" href="AdminReservationsLists-style.css?ver=<?php echo time();?>">
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
            <li>
                <a href="AdminAccount.php">
                    <i class='bx bxs-user-account' ></i>
                    <span class="nav-item">Accounts</span>
                </a>
                <span class="tooltip">Accounts Management</span>
            </li>

            <li>
                <a href="AdminIndex.php">
                    <i class='bx bxs-home-circle'></i>
                    <span class="nav-item">Home</span>
                </a>
                <span class="tooltip">Home</span>
            </li>

            <li>
                <a href="AdminReservationList.php">
                    <i class='bx bxs-book-content'></i>
                    <span class="nav-item">Reservation</span>
                </a>
                <span class="tooltip">Reservation List</span>
            </li>

            <li>
                <a href="AdminAmenities.php">
                    <i class='bx bxs-image'></i>
                    <span class="nav-item">Amenities</span>
                </a>
                <span class="tooltip">Amenities&Facilities</span>
            </li>

            <li>
                <a href="AdminActivities.php">
                    <i class='bx bx-swim' ></i>
                    <span class="nav-item">Activities</span>
                </a>
                <span class="tooltip">Activities</span>
            </li>

            <li>
                <a href="AdminAbout.php">
                    <i class='bx bxs-news'></i>
                    <span class="nav-item">About</span>
                </a>
                <span class="tooltip">About Us</span>
            </li>

            <li>
                <a href="AdminFAQ.php">
                    <i class='bx bx-help-circle' ></i>
                    <span class="nav-item">FAQ's</span>
                </a>
                <span class="tooltip">FAQ's</span>
            </li>


            <li>
                <a onclick="logout()">
                    <i class="bx bxs-log-out"></i>
                    <span class="nav-item">Logout</span>
                </a>
                <span class="tooltip">Logout</span>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container">
            <h1>Reservation List</h1>
        </div>

        <div class="tabular--wrapper">
            <div style="display: flex; justify-content: space-between; align-items: center;" class="title-wrapper">
                <h3>Reservation History</h3>
                <a href="AdminReservationList.php" class="cta-button-history">Current Reservations</a>
            </div>
            <div style="display: flex; gap: 10px;" class="cottage-selection">
                <div>
                <label for="monthPicker">Select Month:</label>
                <select id="monthPicker" class="select">
                    <option value="1">January</option> <!-- Display all the cottage when selected  -->
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                </div>
                
                <div>
                    <label for="yearPicker">Select Year:</label>
                    <select id="yearPicker" class="select">
                </div>
            </div>

            <div class="table-container" id="cottage-list"> <!-- Container for dynamically loaded activities -->
            </div>

        </div>

                        <!-- Modal Form -->   
        <div id="addReservationModal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2>Add Reservation</h2>
                <form id="reservationForm">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" required>

                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" required>

                    <label for="middlename">Middle Name:</label>
                    <input type="text" id="middlename" name="middlename" required>
                    
                    <label for="contact_contact">Contact Number:</label>
                    <input type="text" id="contact_contact" name="contact_contact" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                    
                    <label for="note">Special Notes:</label>
                    <textarea id="note" name="note"></textarea>
                    
                    <label for="checkindate">Check-in Date:</label>
                    <input type="date" id="checkindate" name="checkindate" required>

                    <label for="checkoutdate">Check-out Date:</label>
                    <input type="date" id="checkoutdate" name="checkoutdate" required>
                    
                    <label for="checkin">Check-in Time:</label>
                    <input type="time" id="checkin" name="checkin" required>
                    
                    <label for="checkout">Check-out Time:</label>
                    <input type="time" id="checkout" name="checkout" required>
                    
                    <label for="guests">Number of Guests:</label>
                    <input type="number" id="guests" name="guests" required>

                    <label for="selectcottage">Select Cottage:</label>
                    <select id="selectcottage" name="selectcottage" required>
                        <option value="">Select a cottage</option>
                        <option value="Cottage 1">Cottage 1</option>
                        <option value="Cottage 2">Cottage 2</option>
                        <option value="Cottage 3">Cottage 3</option>
                        <option value="Cottage 4">Cottage 4</option>
                        <option value="Cottage 5">Cottage 5</option>
                        <option value="Cottage 6">Cottage 6</option>
                    </select>
                    
                    <label for="reference">Reference:</label>
                    <input type="number" id="reference" name="reference" required>

                    <input type="hidden" id="reservationtype" name="reservationtype">
                    <button type="submit">Add Reservation</button>
                </form>
            </div>
        </div>

    

                <!-- Edit Reservation Modal -->
        <div id="editReservationModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close-button">&times;</span> <!-- New close button -->
                <h2>Edit Reservation</h2>
                <form id="editReservationForm">
                    <input type="hidden" id="editReservationId">
                    <label for="editFirstname">First Name:</label>
                    <input type="text" id="editFirstname">
                    <label for="editLastname">Last Name:</label>
                    <input type="text" id="editLastname">
                    <label for="editMiddlename">Middle Name:</label>
                    <input type="text" id="editMiddlename">

                    <label for="editContact">Contact:</label>
                    <input type="text" id="editContact">
                    <label for="editEmail">Email:</label>
                    <input type="email" id="editEmail">
                    <label for="editAddress">Address:</label>
                    <input type="text" id="editAddress">
                    <label for="editNote">Note:</label>
                    <input type="text" id="editNote">
                    <label for="editCheck-inDate">Check-in Date:</label>
                    <input type="date" id="editCheck-inDate">
                    <label for="editCheck-outDate">Check-out Date:</label>
                    <input type="date" id="editCheck-outDate">
                    <label for="editCheckin">Check-in:</label>
                    <input type="time" id="editCheckin">
                    <label for="editCheckout">Check-out:</label>
                    <input type="time" id="editCheckout">

                    <label for="editSelectCottage">Select Cottage:</label>
                    <select id="editSelectCottage">
                        <option value="Cottage 1">Cottage 1</option>
                        <option value="Cottage 2">Cottage 2</option>
                        <option value="Cottage 3">Cottage 3</option>
                        <option value="Cottage 4">Cottage 4</option>
                        <option value="Cottage 5">Cottage 5</option>
                        <option value="Cottage 6">Cottage 6</option>
                    </select>

                    <label for="editGuests">Number of Guests:</label>
                    <input type="number" id="editGuests">
                    <label for="editReference">Reference:</label>
                    <input type="number" id="editReference">
                    <button type="submit">Save</button>
                </form>
            </div>
        </div>


    </div>
    <script src="AdminReservationHistory-script.js?ver=<?php echo time();?>"></script>
    <script src="sessionchecker.js?ver=<?php echo time();?>"></script>
    <footer>
        <p>&copy; Trudes Bay Beach Resort</p>
    </footer>
</body>
</html>

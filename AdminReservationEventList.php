<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trudes Bay Admin Reservation List</title>
    <link rel="stylesheet" href="AdminReservationsLists-style.css">
    <link rel="website icon" type="png" href="Images/Trudes Bay_Final.png" />

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <header>
        <img src="Images/Trudes Bay Strip logo.png" alt="Trudes Bay Beach Resort">
    </header>

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
                <a href="#">
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
            <h3>Event</h3>
            <a href="AdminReservationList.php" class="cta-button">Cottage</a>
            <a href="AdminReservationRoomList.php" class="cta-button">Room</a>
            <a href="AdminReservationTentList.php" class="cta-button">Tent</a>
            <a href="AdminReservationEventList.php" class="cta-button">Event</a>
            
            <div class="table-container" id="cottage-list"> <!-- Container for dynamically loaded activities -->
                <!-- This section will be populated with reservation data -->
            </div>
        </div>


                        <!-- Modal Form -->   
        <div id="addReservationModal" class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <h2>Add Reservation</h2>
                <form id="reservationForm">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                    
                    <label for="contact">Contact Number:</label>
                    <input type="text" id="contact" name="contact" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                    
                    <label for="note">Special Notes:</label>
                    <textarea id="note" name="note"></textarea>
                    
                    <label for="date">Date (YYYY-MM-DD):</label>
                    <input type="date" id="date" name="date" required>
                    
                    <label for="checkin">Check-in Time:</label>
                    <input type="time" id="checkin" name="checkin" required>
                    
                    <label for="checkout">Check-out Time:</label>
                    <input type="time" id="checkout" name="checkout" required>

                    <label for="guests">Number of Tent Quantitys:</label>
                    <input type="number" id="tentquantity" name="tentquantity" required>
                    
                    <label for="guests">Number of Guests:</label>
                    <input type="number" id="guests" name="guests" required>
                    
                    <input type="hidden" id="cottage_no" name="cottage_no">
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
                    <label for="editName">Name:</label>
                    <input type="text" id="editName">
                    <label for="editContact">Contact:</label>
                    <input type="text" id="editContact">
                    <label for="editEmail">Email:</label>
                    <input type="email" id="editEmail">
                    <label for="editAddress">Address:</label>
                    <input type="text" id="editAddress">
                    <label for="editNote">Note:</label>
                    <input type="text" id="editNote">
                    <label for="editDate">Date:</label>
                    <input type="date" id="editDate">
                    <label for="editCheckin">Check-in:</label>
                    <input type="time" id="editCheckin">
                    <label for="editCheckout">Check-out:</label>
                    <input type="time" id="editCheckout">
                    <label for="editTentQ">Number of Tent Quantity:</label>
                    <input type="number" id="editTentQ">
                    <label for="editGuests">Number of Guests:</label>
                    <input type="number" id="editGuests">
                    <button type="submit">Save</button>
                </form>
            </div>
        </div>

             
    </div>
    <script src="AdminReservationEventList-script.js"></script>

    <footer>
        <p>&copy; Trudes Bay Beach Resort</p>
    </footer>
</body>
</html>

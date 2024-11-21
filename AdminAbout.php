<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trudes Bay Admin Homepage</title>
    <link rel="stylesheet" href="AdminAbouts-styles.css">
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
                    <h1>About Us</h1>
                </div>

                <div class="content">
                    <div class="table-container" id="about-list"> <!-- Container for dynamically loaded activities -->
                    </div>

                    <button class="Abtn add-button" onclick="openAddForm()">Add</button>
            
                    <div class="about-form" id="addAbouts" style="display: none;">
                        <div class="phone-form">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone" name="phone" placeholder="Enter Phone" required>
                        </div>
                        <button type="button" onclick="addAboutEntry()">Add</button>
                    </div>

                    <div class="modal" id="editModal" style="display: none;">
                        <div class="modal-content">
                            <span class="close" onclick="closeEditModal()">&times;</span>
                            <h2>Edit About Entry</h2>
                            <input type="hidden" id="edit-id" name="edit-id"> <!-- Hidden ID input -->
                            <div>
                                <label for="edit-phone">Phone Number</label>
                                <input type="text" id="edit-phone" name="edit-phone" placeholder="Enter Phone" required>
                            </div>
                            <button type="button" onclick="updateAboutEntry()">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>

    <script src="AdminAbouts-scripts.js"></script>

    <footer>
        <p>&copy; Trudes Bay Beach Resort</p>
    </footer>
</body>
</html>

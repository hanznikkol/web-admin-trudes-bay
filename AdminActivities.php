<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trudes Bay Admin Homepage</title>
    <link rel="stylesheet" href="AdminActivity-style.css?ver=<?php echo time();?>">
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
            <h1>Activities</h1>
        </div>


        <section class="start-section">
            <div class="section-intro">
                <h2>Beach Activities</h2>
                <p>Allow us to introduce the main highlights of the beach which are the white sands and refreshing waves crashing down ashore <br> that gives you thrill to feel the vibes of summer vacation.</p>
            </div>
            
            <div id="activity-list"></div> <!-- Container for dynamically loaded activities -->

            <button class="Abtn add-btn" onclick="toggleActivityForm()">Add</button>

            <!-- Hidden form for adding/editing activity -->
            <div class="act-form" id="activity-form" style="display: none;">
                <input type="text" id="activity-title" placeholder="Enter Activity Title">
                <input type="text" id="activity-description" placeholder="Enter Description">
                <input type="file" id="activity-image" accept="image/*">
                <button id="save-btn" onclick="saveActivity()">Save</button>
                <button id="cancel-btn" onclick="cancelActivity()">Cancel</button>
            </div>
        </section>



    </div>

    <script src="AdminActivity-script.js?ver=<?php echo time();?>"></script>
    <script src="sessionchecker.js?ver=<?php echo time();?>"></script>
    <footer>
        <p>&copy; Trudes Bay Beach Resort</p>
    </footer>
</body>
</html>

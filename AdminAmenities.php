<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trudes Bay Admin Homepage</title>
    <link rel="stylesheet" href="AdminAmenities-styles.css">
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
            <h1>Amenities & Facilities</h1>
        </div>

        <div class="content">
            <p>Explore our wide range of amenities and facilities to make your stay unforgettable.</p>
            
            <form id="amenities-form">
                <label for="beach-checkbox">
                    <input type="checkbox" id="beach-checkbox" name="amenities" value="Beach">
                    <span></span> Beach
                </label>
                <label for="rooms-checkbox">
                    <input type="checkbox" id="rooms-checkbox" name="amenities" value="Rooms">
                    <span></span> Rooms
                </label>
                <label for="cottages-checkbox">
                    <input type="checkbox" id="cottages-checkbox" name="amenities" value="Cottages">
                    <span></span> Cottages
                </label>
                <label for="event-hall-checkbox">
                    <input type="checkbox" id="event-hall-checkbox" name="amenities" value="Event Hall">
                    <span></span> Event Hall
                </label>
                <label for="transient-house-checkbox">
                    <input type="checkbox" id="transient-house-checkbox" name="amenities" value="Transient House">
                    <span></span> Transient House
                </label>
            </form>

            <div id="selected-amenities" class="amenities-container"></div>
            
            <div class="upload-container">
                <button id="upload-btn">Upload New Amenity</button>
            </div>

            <div class="gallery-form" id="gallery-form" style="display: none;">
                <select id="gallery-category">
                    <option value="Beach">Beach</option>
                    <option value="Rooms">Rooms</option>
                    <option value="Cottages">Cottages</option>
                    <option value="Event Hall">Event Hall</option>
                    <option value="Transient House">Transient House</option>
                  
                </select>    
                <input type="file" id="activity-image" accept="image/*">
                <button id="save-btn">Save</button>
                <button id="cancel-btn">Cancel</button>
            </div>
        </div>





    </div>

    <script src="AdminAmenity-scripts.js"></script>

    <footer>
        <p>&copy; Trudes Bay Beach Resort</p>
    </footer>
</body>
</html>

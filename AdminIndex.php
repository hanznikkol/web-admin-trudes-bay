<?php
// Database connection
$servername = "localhost"; // or your server name
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "db_trudes"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch images from the database
function fetchImages($conn) {
    $sql = "SELECT image_data, image_type FROM dashboard_upload";
    $result = $conn->query($sql);
    $images = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $images[] = [
                'data' => $row['image_data'], // Use raw data instead of base64_encode
                'type' => $row['image_type']
            ];
        }
    }
    return $images;
}


$images = fetchImages($conn);

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trudes Bay Admin Homepage</title>
    <link rel="stylesheet" href="AdminIndex-style.css">
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
            <li><a href="AdminAccount.php"><i class='bx bxs-user-account'></i> <span class="nav-item">Accounts</span></a></li>
            <li><a href="AdminIndex.php"><i class='bx bxs-home-circle'></i> <span class="nav-item">Home</span></a></li>
            <li><a href="AdminReservationList.php"><i class='bx bxs-book-content'></i> <span class="nav-item">Reservation</span></a></li>
            <li><a href="AdminAmenities.php"><i class='bx bxs-image'></i> <span class="nav-item">Amenities</span></a></li>
            <li><a href="AdminActivities.php"><i class='bx bx-swim'></i> <span class="nav-item">Activities</span></a></li>
            <li><a href="AdminAbout.php"><i class='bx bxs-news'></i> <span class="nav-item">About</span></a></li>
            <li><a href="AdminFAQ.php"><i class='bx bx-help-circle'></i> <span class="nav-item">FAQ's</span></a></li>
            <li><a href="#"><i class="bx bxs-log-out"></i> <span class="nav-item">Logout</span></a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="container">
            <h1>Homepage</h1>
        </div>

        
        <section class="hero"> 
                <?php foreach ($images as $index => $image): ?>
                    <div class="hero-slide <?php echo $index === 0 ? 'active' : ''; ?>">
                        <img src="data:<?php echo $image['type']; ?>;base64,<?php echo $image['data']; ?>" alt="Uploaded Image <?php echo $index + 1; ?>">
                        <div class="hero-text">
                            <h2>Welcome to Trudes Bay Beach Resort</h2>
                            <p>Discover the tranquility of our resort with pristine beaches and luxury amenities.</p>
                            <a href="reservation.html" class="cta-button">Book Now</a>

                            <!-- Remove Button -->
                            <form action="remove_image.php" method="post" style="margin-top: 1rem;">
                                <input type="hidden" name="image_index" value="<?php echo $index; ?>">
                                <button type="submit" class="remove-button">Remove</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="hero-controls">
                    <button onclick="changeSlide(-1)">&#10094;</button>
                    <button onclick="changeSlide(1)">&#10095;</button>
                </div>
            </section>

        
        <div class="upload-section">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <label for="file-upload" class="cta-button">Browse Image</label>
                <input type="file" id="file-upload" name="file-upload" style="display: none;" accept="image/*" onchange="imageSelected(event)">
                
                <!-- Preview and Upload button in modal -->
                <div id="imagePreviewModal" class="modal">
                    <div class="modal-content">
                        <span class="close-btn" onclick="closeModal()">&times;</span>
                        <img id="image-preview" alt="Image Preview" style="max-width: 100%; height: auto;">
                        <br>
                        <input type="submit" value="Upload" class="cta-button">
                    </div>
                </div>
            </form>
        </div>

    </div>    
    <script src="AdminIndex-scripts.js"></script>

    <footer>
        <p>&copy; Trudes Bay Beach Resort</p>
    </footer>
</body>
</html>

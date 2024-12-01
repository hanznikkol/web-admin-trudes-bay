<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOXICONS -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Login-style.css?ver=<?php echo time();?>">
    <title>Ludiflex | Login & Registration</title>
</head>
<body>
    <div class="wrapper">
       <nav class="nav">
           <div class="nav-logo">
            <img src="Images/Trudes Bay Strip logo.png" alt="Trudes Bay Beach Resort">
           </div>
       </nav>
       <!----------------------------- Form box ----------------------------------->    
       <div class="form-box">
           <!------------------- login form --------------------------> 
               <div class="login-container" id="login">
                   <div class="top">
                       <span>Don't have an account?</span>
                       <header>Login</header>
                   </div>
                   <div class="input-box">
                       <input type="text" name="username" class="input-field" placeholder="Username" required>
                       <i class="bx bx-user"></i>
                   </div>
                   <div class="input-box">
                       <input type="password" name="password" class="input-field" id="password" placeholder="Password" required>
                       <i class="bx bx-lock-alt"></i>
                   </div>
                   <div class="input-box">
                       <button class="submit" onclick="loginUser()">Sign In</button>
                   </div>

                   <!-- Show password checkbox -->
                   <div class="two-col">
                       <div class="one">
                           <input type="checkbox" id="login-check" onclick="togglePassword()">
                           <label for="login-check">Show Password</label>
                       </div>
                   </div>
               </div>
           <!------------------- registration form --------------------------> 
       </div>
   </div>   

   <script src="Login-script.js?ver=<?php echo time();?>"></script>
</body>
</html>

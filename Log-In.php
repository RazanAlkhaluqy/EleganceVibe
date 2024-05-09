<!DOCTYPE html>

<html><head>
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>log-In page </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
     <header>
     <div id="head">
        <a href="index.php"> <img src="image/logo.png" alt="logo" class="logo"> </a>
     </div>
      </header>
      <h1 class="header">Log-In Page </h1>
      <div class="cont">
             <h2>Login</h2>
             <form id="loginForm"  action="logIn.php" method="post"> 
              <label for="email">Email:</label>
              <input type="text" id="email" name="email" required="">
              <label for="password">Password:</label>
              <input type="password" id="password" name="password" required="">
              <label for="userType">User Type:</label>
              <select id="userType" name="userType">
                  <option value="designer">Designer</option>
                  <option value="client">Client</option>
              </select>
             <input type="submit" value="Log In" id=""> 
             <h5> New user ? <a href="SignUp.php" class="link">Sign Up</a> </h5> 
             <?php 
              if (isset($_GET['error'])): ?>
                <p style="color: red;">Invalid email address or password.</p>
              <?php endif;?>    
             </form>
      </div>
     
      <footer>
        <div id="footer">
            <p id="contact"> Contact Us  <br>
                Riaydh, Saudi Arabia <br>
                <a id="link" href="mailto: ContactUs@EleganceVibe.com"> ContactUs@EleganceVibe.com</a>
               </p>
           <div class="footer-sections">
               <div id="fot1">
                   <br>
                   <a href="" class="footer">About Elegance Vibe </a> <br>
                   <a href="" class="footer">FAQ</a>
               </div>

              

               <div id="fot2">
                   <br>
                   <a href="" class="footer">Terms of Use</a><br>
                    <a href="" class="footer">Privacy Policy</a>
               </div>
           </div>
           <div id="fot3">
              
               <p>
                   <a href="" class="footer"><img src="image/whatsapp.png" alt="whatsapp"></a>
                   <a href="" class="footer"><img src="image/twitter.png" alt="twitter"></a>
                   <a href="" class="footer"><img src="image/instagram.png" alt="instagram"></a>
                   <br> 
                   © 2024 Elegance Vibe
               </p>
           </div>
       </div>
   </footer>
      
     


</body></html>
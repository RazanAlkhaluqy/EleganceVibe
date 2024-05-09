<!DOCTYPE html>
<html><head>
    <link rel="stylesheet" href="style.css" type="text/css">
    <title> Homepage </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
     <header>
     <div id="head">
        <a href="index.php"> <img src="image/logo.png" alt="logo" class="logo"> </a>
     </div>
      </header>
    
     <h1 class="header">Homepage </h1>
     <div class="container">
         <h1 class="index"> WELCOME TO ELEGANCE VIBE </h1><br>
         <button id="index" onclick="redirectlogInPage()"> Log In </button> <br><br>
     <h3 class="index"> New user ? <a href="SignUp.php" class="link">Sign Up</a> </h3>
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

     <script>
         function redirectlogInPage(){
          window.location.assign("Log-In.php");}
         </script>
</body></html>

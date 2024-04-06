
<!DOCTYPE html>
<html lang="en">
  
  <?php session_start();
?>
<head>
    
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <link href="SignUp.css" rel="stylesheet" type="text/css">
        <script src="SignUp.js" type="text/javascript"></script>

  <title>Sign Up </title>
  
</head>
  
  <body>
    <header>
        <div id="head">
          <a href="index.php"> <img src="image/logo.png" alt="logo" class="logo"> </a>
        </div>
         </header>
         <h1 class="header"> Sign-Up page </h1>
 <div class="cont">
    <h2 style="text-align: center; color:  #140061 ; ">Sign Up</h2>
    <hr>
    <div class="user">
    <label style="font-weight: bold; padding:4px;">User Type:</label>
    <br>
    <br>
    <input  class="user" type="radio" id="designer" name="userType" value="designer" onclick="showForm('designer')">
    <label class="user" for="designer">Designer</label>
    
    <br>
    <br>
    <input  class="user" type="radio" id="client" name="userType" value="client" onclick="showForm('client')">
    <label class="user" for="client">Client</label>
    
  </div>

      <br>
      <br>
   
  <form id="designer-form" action="SU.php" method="post"> <!--this changed-->
    <label for="first-name-designer">First Name:</label>
      <input type="text" id="first-name-designer" name="firstName" required="">
      <label for="last-name-designer">Last Name:</label>
      <input type="text" id="last-name-designer" name="lastName" required="">
      <label for="email-designer">Email:</label>
      <input type="email" id="email-designer" name="email" placeholder="example@email.com" required="">
      <label for="password-designer">Password:</label>
      <input type="password" id="password-designer" name="password" placeholder="**********" required="">
      <label for="brand-name">Brand Name:</label>
      <input type="text" id="brand-name" name="brandName" required="">
      <label>Speciality in Interior Design:</label>
      <br><br>
      <input type="checkbox" class="check" id="modern"> <label for="modern">Modern</label><br>
      <input type="checkbox" class="check" id="country"> <label for="country">Country</label><br>
      <input type="checkbox" class="check" id="coastal"> <label for="coastal">Coastal</label><br>
      <input type="checkbox" class="check" id="bohemian"> <label for="bohemian">Bohemian</label><br><br>
      <input type="submit" value="Sign Up" class="button">
  </form>

  <form id="client-form" action="SU.php" method="post"> <!--this changed-->
    <label for="first-name-client">First Name:</label>
      <input type="text" id="first-name-client" name="firstName" required="">
      <label for="last-name-client">Last Name:</label>
      <input type="text" id="last-name-client" name="lastName" required="">
      <label for="email-client">Email:</label>
      <input type="email" id="email-client" name="email" placeholder="example@email.com" required="">
      <label for="password-client">Password:</label>
      <input type="password" id="password-client" name="password" placeholder="**********" required="">
      <input type="submit" value="Sign Up" class="button">
  </form>
  <?php
if(isset($_GET["error"])){
    if($_GET["error"]=="stmtfailed"){
        echo"<p>Sorry! Something went wrong, please try again</p>";
    }
    if($_GET["error"]=="emailtaken"){
        echo'<p>Sorry! Email is already taken,try something else!<a href="Login.php" class="button" id="loginLink">Log in</a>?</p>';
    }
    if($_GET["error"]=="noUpload"){
        echo"<p>Sorry! Error in uploading the Image</p>";
    }
}
?> 
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

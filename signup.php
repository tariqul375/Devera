<?php
session_start();
if(!empty($_SESSION["username"]))
{
      if($_SESSION["username"] =="admin")
      {
        header('Location: admin.php');
      }else{
        header('Location: home.php');
      }
}
require 'connection.php';
if(isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']))
{
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    list($user, $domain) = explode('@', $email);
    if ($domain == 'northsouth.edu') {
    $insert_user ="INSERT INTO `userinfo`(`fullname`, `username`, `email`, `password`) VALUES ('$fullname','$username','$email','$password')";
    if ($conn->query($insert_user) === TRUE) {
        $_SESSION["username"] = $username;
        $_SESSION["email"] = $email;
        header('Location: home.php'); 
    } else {
        echo "Error: " . $insert_user . "<br>" . $conn->error;
    }
    }else{
      $msg="Only For NSU Student";
    }
  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>MyVideo | Signup</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
body  {
    background-image: url("image/ocean.jpg");
    background-color: #cccccc;
}
.container{
  margin-top: 50px;
}
</style>
<body>
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"></div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <center><h4>Sign Up</h4></center>
        </div>
        <div class="panel-body">
          <?php
          if(isset($_POST['submit']))
          { 
          ?>
          <div class="alert alert-success alert-dismissible fade in">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <?php echo $msg;?>
          </div>
          <?php
          }
          ?>
          <form action="signup.php" method="POST">
            <div class="form-group">
              <label for="fullname">Full Name:</label>
              <input type="text" class="form-control" id="fullname" name="fullname" required placeholder="Full Name">
            </div>
            <div class="form-group">
              <label for="username">User Name:</label>
              <input type="text" class="form-control" id="username" name="username" required placeholder="Username">
            </div>
            <div class="form-group">
              <label for="email">Email address:</label>
              <input type="email" class="form-control" id="email" name="email" required placeholder="@northsouth.edu">
            </div>
            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password" required placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
              <input type="checkbox" onclick="myFunction()"> &nbsp;Show Password
            </div>
            <input type="submit" name="submit" class="btn btn-primary btn-block" value="Sign Up">
          </form> 
        </div>
        <div class="panel-footer" align="right">
          <p>Already have an account? <a href="login.php">Log In</a></p>
        </div>
      </div> 
    </div>
  </div>
</div>
</body>
</html>
<script type="text/javascript">
function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
<script>
var myInput = document.getElementById("password");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
  document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
myInput.onblur = function() {
  document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
myInput.onkeyup = function() {
  // Validate lowercase letters
  var lowerCaseLetters = /[a-z]/g;
  if(myInput.value.match(lowerCaseLetters)) {  
    letter.classList.remove("invalid");
    letter.classList.add("valid");
  } else {
    letter.classList.remove("valid");
    letter.classList.add("invalid");
  }
  
  // Validate capital letters
  var upperCaseLetters = /[A-Z]/g;
  if(myInput.value.match(upperCaseLetters)) {  
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  } else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }

  // Validate numbers
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) {  
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  
  // Validate length
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>
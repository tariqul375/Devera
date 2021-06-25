<?php
session_start();
if(empty($_SESSION["username"]))
{
  header('Location: login.php');
}else{
  if($_SESSION["username"] != "admin")
  {
    header('Location: home.php');
  }
}
require 'connection.php';
$msg="";
if(isset($_POST['submit']))
{
  $userinfo_id =$_POST['id'];
  $user_delete = "delete from userinfo where userinfo_id=$userinfo_id";
  if ($conn->query($user_delete) === TRUE) {
    $msg="successfully deleted";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>DevEra | User</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css">
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
</head>
<body>
<script>
  $(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop( true, true ).slideDown("fast");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).not('.in .dropdown-menu').stop( true, true ).slideUp("fast");
            $(this).toggleClass('open');       
        }
    );
});
</script>
<style>
.navbar {
   background-color: #2F4F4F;
}

 .navbar li a, .navbar .navbar-brand { 
      color: #d5d5d5 ;
  }

  .navbar .navbar-nav li a {
    color: #F8F8F8 ;
  }

  .navbar li a, .navbar .navbar-brand:hover { 
      color: #FFFF00 ;
  }

    .navbar .navbar-nav li a:hover {
    color: #F8F8F8;
  } 
  .carousel{
    margin-top: 0px;
    margin-bottom: 0px;
     padding-top: 0px;
     padding-bottom: 0px;
  }
.dropdown-menu li a{
 color: black !important;
}
.container{
  margin-top: 80px;
}
 </style>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="home.php">DevEra</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="#"  class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION["username"] ?><span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="admin.php">Profile</a></li>
          <li><a href="logout.php">Log Out</a></li>
          </ul>
      </li>
    </ul>
    </div>
  </div>
</nav>

<div class="container">
  <div class="panel panel-default">
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
       <center><h3>User Record</h3></center>
       <div class="table-responsive">
    <table class="table table-striped table-bordered" id="example">
      <thead>
      <tr>
        <th>Full Name</th>
        <th>User Name</th>
        <th>Email</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
          $show_user ="select * from userinfo";
          $result = $conn->query($show_user);
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              if($row['username'] != "admin")
              {
      ?>
      <tr>
        <td><?php echo $row['fullname']?></td>
        <td><?php echo $row['username']?></td>
        <td><?php echo $row['email']?></td>
        <td>
            <form action="admin_userview.php" method="post">
              <input type="hidden" name="id" value="<?php echo $row['userinfo_id'] ?>">
              <input type="submit" name="submit" class="btn btn-danger btn-xs" value="delete">
            </form>
        </td>
      </tr>
      <?php
              }
            }
          }
      ?>
    </tbody>
    </table>
  </div>
  </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
</body>
</html>

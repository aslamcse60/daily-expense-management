<?php
include("functions.php");

$wrongpass = '';
$wronginfo = '<div class="alert alert-danger" role="alert">  <span class="fa-solid fa-square-xmark" aria-hidden="true"></span> Wrong login detail</div>';
if(isloggedin()==FALSE)
{
}
else
{
header("location:home.php");  
  
}
  
  if(isset($_POST['email']) && ($_POST['pass']))
{

$pass= mysqli_real_escape_string($conn, $_POST['pass']);
$email= mysqli_real_escape_string($conn, $_POST['email']);
$query="SELECT * from users where uemail='$email'";
$result = $conn->query($query);

if ($result->num_rows < 1) 
  {
      $wrongpass = $wronginfo;
  }

 while($row = $result->fetch_assoc()) 
    {
  if(md5($pass)==$row['upass'])
  {
    $_SESSION['logged_in']=TRUE;
    $_SESSION['id']=$row['uid'];
    $_SESSION['unaam']=$row['uname'];
    $_SESSION['ueid']=$row['uemail'];
    session_start();
    header("location:home.php");
  }
  else
   {
    $wrongpass = $wronginfo;
   }
    }
  }


?>
<head>
    <title>Daily Expense Management</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="js/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <meta name=viewport content="width=device-width, initial-scale=1">

<script type="text/javascript">
$(document).ready(function(){
$("#name").keyup(function() {
var name = $('#name').val();
if(name=="")
{
$("#disp").html("");
}
else
{
$.ajax({
type: "POST",
url: "check.php",
data: "name="+ name ,
success: function(html){
$("#disp").html(html);
}
});
return false;
}
});
});
</script>
</head>
<body>
<header class="p-3 mb-2 text-white" style="background-color:#708090">
<h2 class="text-center" style="font-family:fantasy"><i class="fa solid fa-indian-rupee-sign"></i> Daily Expense Management</h2>
</header>
<div style="padding:15px; margin:15px;">
<div>
<div class="panel panel-primary">
  <div class="panel-body">
  <div class="row">
  <div class="col-md-3">
  

  <div class="panel panel-success" >
  <div class="panel-heading"><span class="fa-solid fa-computer" aria-hidden="true"></span><b> Sign in with your existing Account</b></div>
  <div class="panel-body">


  <form class="form-horizontal" name="login" action="index.php" method="post">
  <div class="form-group">
    <label for="Email" class="col-sm-3 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" style="font-family:arial,fontawesome;" class="form-control" id="Email" placeholder="&#xf0e0; Email" name="email" required>
    </div>
  </div>
  <div class="form-group">
    <label for="Password" class="col-sm-3 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" style="font-family:arial,fontawesome;" class="form-control" id="Password" placeholder="&#xf023; Password" name="pass" required>
    </div>
  </div>
  <?php
echo $wrongpass;
?>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary"><i class="fa-solid fa-right-to-bracket"></i> Sign in</button>
    </div>
  </div>
</form>

  </div>
  </div>


  </div>
    <div class="col-md-3">
    <img src="banner.jpg" alt="..." class="img-thumbnail img-responsive">
    </div>

  <div class="col-md-6">
 <div class="panel panel-primary">
  <div class="panel-heading"><b><i class="fa solid fa-user-pen"></i> New user? Create your free Account</b></div>
  <div class="panel-body">



<form class="form-horizontal" action="index.php" method="post">
  <div class="form-group">
    <label for="fname" class="col-sm-2 control-label" >Full Name</label>
    <div class="col-sm-10">
      <input type="text" style="font-family:arial,fontawesome;" class="form-control" id="fname" name="fname" autocomplete="off" required placeholder="&#xf007; Enter your full name here">
    </div>
  </div>

  <div class="form-group">
    <label for="name" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" style="font-family:arial,fontawesome;" id="name" name="name" class="form-control"  autocomplete="off" required placeholder="&#xf0e0; Email">
      <div id="disp"></div>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" style="font-family:arial,fontawesome;" name="password" class="form-control" id="inputPassword3" required placeholder="&#xf502; Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox" required> <a href="agreement.html" class="text-danger" target="_blank">I agree with terms and conditions</a>
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success"><i class="fa solid fa-check"></i> Create My Account</button>
    </div>
  </div>
</form>
<?php

if(isset($_POST['name']) && trim($_POST['password']) != "")
{

$name= mysqli_real_escape_string($conn, $_POST['name']);
$query="SELECT * from users where uemail='$name'";
$result = $conn->query($query);
if ($result->num_rows < 1) 
  {
$uname = mysqli_real_escape_string($conn, $_POST['fname']);
$uname = strip_tags($uname);
$uemail = mysqli_real_escape_string($conn, $_POST['name']);
$uemail = strip_tags($uemail);
$upass = mysqli_real_escape_string($conn, $_POST['password']);
$upass = md5($upass);

$sql = "INSERT INTO users (uname, uemail, upass)
VALUES ('$uname','$uemail','$upass')";
if ($conn->query($sql) === TRUE) 
  {
  echo '<div class="alert alert-success" role="alert">
  <span class="fa-solid fa-square-check" aria-hidden="true"></span> Your account has been created successfully!
</div>';
  } else 
  {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
} else
{
   echo '<div class="alert alert-danger" role="alert">
  <span class="fa-solid fa-user-xmark" aria-hidden="true"></span> You already have an account and can access from login form
</div>';
}
}
?>
  </div>
  </div>

  </div>
  </div>
  </div>
  </div> 
    <div class="alert alert-info" role="alert">
      </div>  
</div>
</div>
</div>
<?PHP 
  Include ('footer.php'); 
?>
</body>


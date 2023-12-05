<?php
include("functions.php");
if(isloggedin()==FALSE)
{
header("location:index.php");  
}
else
{
  
}
$sid=$_SESSION['id'];
?>
<head>
    <title>Daily Expense Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.form.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> 
    <meta name=viewport content="width=device-width, initial-scale=1">
  <script>

 $(function() {
    $( "#datepicker1" ).datepicker({dateFormat: "dd-mm-yy"});
    $( "#datepicker2" ).datepicker({dateFormat: "dd-mm-yy"});
    $( "#datepicker3" ).datepicker({dateFormat: "dd-mm-yy"});

  });
  </script>

   <script> 
        $(document).ready(function() { 
            $('#myForm').ajaxForm(function() { 
                 alert("Given information Successfully Saved"); 
                 location.href = 'home.php';
            }); 
        }); 
    </script>

<body onLoad="document.showexp.edetail.focus()">
<div style="padding:10px; margin:10px;">
<div class="panel panel-primary">
  <div class="panel-heading"><b>Daily Expense Management</b></div>
  <div class="panel-body">

<div class="media">
<div class="media-body">

<blockquote>
<div class="text-right"><a href='signout.php'  class="btn btn-danger" ><span class="glyphicon glyphicon-log-out"></span> Logout</a></div>
<h3 id="media-heading" class="media-heading"><b>Welcome <span class="text-warning"><?php    echo $_SESSION['unaam']; ?></span></b></h3> 
<strong>Total Earning :</strong> <span class="label label-success">
<?php 
$today = date("Y-m-d");
$dtstart = date("1950-m-d");
$thiyear = date("y-01-01");


$query = "SELECT SUM(tvalue) FROM income WHERE date >= '$dtstart' AND date <= '$today' AND uid='$sid' AND isdel=0"; 
$result = $conn->query($query);
    while($psum = $result->fetch_assoc()) 
{
$tisum = $psum['SUM(tvalue)']; 
if ($tisum == '')
{echo "Add income to display here";}
else
{echo $tisum;}
} 

?></span>
<!-- Today's Expenses Start-->
<br><strong>Today's Expenses :</strong> <span class="label label-danger" id='exptop'><?php 
$query = "SELECT SUM(pprice) FROM expense WHERE date = '$today' AND uid='$sid' AND isdel=0"; 
$result = $conn->query($query);
    while($psum = $result->fetch_assoc()) 
{
$tesum = $psum['SUM(pprice)']; 
if ($tesum== '')
{echo "No Expense Today";}
else
{echo $tesum;}
} 

?></span>
<!-- Today's Expenses End -->

<br><strong>Total Expenses :</strong> <span class="label label-danger" id='exptop'><?php 
$query = "SELECT SUM(pprice) FROM expense WHERE date >= '$dtstart' AND date <= '$today' AND uid='$sid' AND isdel=0"; 
$result = $conn->query($query);
    while($psum = $result->fetch_assoc()) 
{
$tesum = $psum['SUM(pprice)']; 
if ($tesum== '')
{echo "Add expenses to display here";}
else
{echo $tesum;}
} 

?></span>



<br><strong>Total Balance :</strong> <span class="label label-default"><?php $rbalance = $tisum - $tesum;
if ($tisum == '')
{echo "NIL";}
else
{echo $rbalance;}
?></span></blockquote>

</div>

</div>



<div class="panel panel-info">
<div class="panel-heading"><a href="home.php"><b><span class="glyphicon glyphicon-home"></span> Home</b></a>
</div>



<?php

if (!empty($_POST["endd"])) {

$dstart = $_POST['startd'];
$dend = $_POST['endd'];

$dstart = strtotime($dstart);
$dend = strtotime($dend);

$dstart= date('Y-m-d', $dstart);
$dend = date('Y-m-d', $dend);
  }
  else
  {
    $dstart = date("Y-m-01");
    $dend = date("Y-m-d");
  }

$expdetail = '';
if(!empty($_POST['expdetail']))
{
$expdetail = mysqli_real_escape_string($conn, $_POST['expdetail']);
}

$dstartn = strtotime($dstart);
$dstartn = date('d M Y', $dstartn);
$dendn = strtotime($dend);
$dendn = date('d M Y', $dendn);

echo '<table class="table table-hover table-striped table-bordered">';
   echo'<caption><h4><span class="glyphicon glyphicon-file" ></span> Expense report';
   echo '<br>';
   echo '<br>';
   echo '<br>';
$con=mysqli_connect('localhost', 'root', '','exp');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql="select * from expense where date >= '$dstart' AND date <= '$dend' AND uid='$sid'  AND isdel=0";
$records=mysqli_query($con,$sql);



echo '</span>';


echo '<table>';
  echo '<tr>';

 echo '<th> NAME</th>';
 
echo '<th>&ensp;PRICE</th>';

 
 echo '</tr>';

while($row=mysqli_fetch_array($records))
{
  echo "<tr><form action = update.php method=post class=form-group>";
  echo "<td><input type= text name =pname class=form-control value= ' ".$row['pname']." '></td>";
  echo "<td style=padding:8px><input type= text name =pprice class=form-control value= ' ".$row['pprice']." '></td>"; 
  echo "<td><input type= hidden name =id value= ' ".$row['id']." '></td>";
  echo "<td><input type= hidden name =uid value= ' ".$row['uid']." '></td>";
  echo "<td><input type= hidden name=isdel value= ' ".$row['isdel']." '>";
  echo '<td ><input type=submit style=margin-left:10px>';
  echo '</form></tr>';

}


?>


</div>
</div>
</div>
</div>



</body>



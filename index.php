<?php

session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']!=true){
    header("location: login.php");
    exit;
}
require ('config.php');
$systemID = $_SESSION['systemID'];
$sql = "SELECT StudentName FROM student WHERE SystemID=$systemID";
$execQuery = mysqli_query($db, $sql);
$data = mysqli_fetch_assoc($execQuery);
$studentName = $data['StudentName'];
$_SESSION['studentName'] = $studentName;
?>

<h1>Sharda University's Own iCloud</h1>
<h3>Welcome <?php echo $studentName ?></h3>
<font>Choose Attendance View : </font>
<button><a href="dayWiseAttendance.php">Day-Wise Attendance</a></button>
<button><a href="courseWiseAttendance.php">Course-Wise Attendance</a></button>
<br><br>
<button><a href="logout.php">Logout</a></button>
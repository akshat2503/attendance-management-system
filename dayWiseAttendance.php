<?php

session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']!=true){
    header("location: login.php");
    exit;
}
if (isset($_POST['monthChoice'])){
    $firstDayOfMonth = date("1-" . $_POST['monthChoice'] . "-Y");
}else {
    $firstDayOfMonth = date("1-m-Y");
    $_POST['monthChoice'] = date("m");
}

$totalDaysInMonth = date("t", strtotime($firstDayOfMonth));
$month = date("m", strtotime($firstDayOfMonth));
$totalNumberOfLectureSlots = 9;
$lectureSlotsArray = array("08:35 - 09:25", "09:30 - 10:20", "10:25 - 11:15", "11:20 - 12:10", "12:15 - 13:05", "13:10 - 14:00", "14:05 - 14:55", "15:00 - 15:50", "15:50 - 16:40");
$studentID = $_SESSION['systemID'];

require_once('config.php');

?>

<h3>Attendance Records for <?php echo(strtoupper(date("F", strtotime($firstDayOfMonth)))) ?></h3>
<h3>Day-Wise Attendance for <?php echo $_SESSION['studentName'] ?> - <?php echo $studentID ?></h3>
<button ><a href="/index.php">Return Home</a></button>
<br><br>

<form name = "lecture-choice" action="" method="POST">
    <label for="monthChoice">Choose Month:</label>
    <select name="monthChoice" id="" onchange="submit()">
        <option value="1" <?php if (isset($_POST['monthChoice']) && $_POST['monthChoice'] == 1) echo 'selected'; ?>>January</option>
        <option value="2" <?php if (isset($_POST['monthChoice']) && $_POST['monthChoice'] == 2) echo 'selected'; ?>>February</option>
        <option value="3" <?php if (isset($_POST['monthChoice']) && $_POST['monthChoice'] == 3) echo 'selected'; ?>>March</option>
        <option value="4" <?php if (isset($_POST['monthChoice']) && $_POST['monthChoice'] == 4) echo 'selected'; ?>>April</option>
        <option value="5" <?php if (isset($_POST['monthChoice']) && $_POST['monthChoice'] == 5) echo 'selected'; ?>>May</option>
        <option value="6" <?php if (isset($_POST['monthChoice']) && $_POST['monthChoice'] == 6) echo 'selected'; ?>>June</option>
        <option value="7" <?php if (isset($_POST['monthChoice']) && $_POST['monthChoice'] == 7) echo 'selected'; ?>>July</option>
        <option value="8" <?php if (isset($_POST['monthChoice']) && $_POST['monthChoice'] == 8) echo 'selected'; ?>>August</option>
        <option value="9" <?php if (isset($_POST['monthChoice']) && $_POST['monthChoice'] == 9) echo 'selected'; ?>>September</option>
        <option value="10" <?php if (isset($_POST['monthChoice']) && $_POST['monthChoice'] == 10) echo 'selected'; ?>>October</option>
        <option value="11" <?php if (isset($_POST['monthChoice']) && $_POST['monthChoice'] == 11) echo 'selected'; ?>>November</option>
        <option value="12" <?php if (isset($_POST['monthChoice']) && $_POST['monthChoice'] == 12) echo 'selected'; ?>>December</option>
    </select>
    <label for="name">Show Lecture Name : </label>
    <input type="checkbox" name="choice" value="1" onchange="submit()" <?php if (isset($_POST['choice']) && $_POST['choice'] == 1) echo 'checked'; ?>>
</form>

<?php 
    if (isset($_POST['choice'])){
        if ($_POST['choice'] == 1){
            $choice = 1;
        }
    }
    else {
        $choice = 0;
    }
    
?>





<table border="1" cellspacing="0">

    <?php
    $counter = 1;
    for ($i=1; $i<=$totalNumberOfLectureSlots + 2; $i++){
        if ($i==1){
        echo ("<tr>");
        echo ("<th rowspan = '2'>Lecture Timings</th>");
            for ($j=1; $j<=$totalDaysInMonth; $j++){
                echo("<th>$j/$month</th>");
            }
        echo ("</tr>");
        }
        else if ($i==2){
            echo ("<tr>");
                for ($j=0; $j<$totalDaysInMonth; $j++){
                    echo("<th>" . date("D", strtotime("+$j days", strtotime($firstDayOfMonth))) . "</th>");
                }
            echo ("</tr>");
        }
        else {
            echo ("<tr>");
            echo ("<th>" . $lectureSlotsArray[$i - 3] . "</th>");
                for ($j=1; $j<=$totalDaysInMonth; $j++){
                    $dateOfAttendance = date("Y-" . $_POST['monthChoice'] . "-$j");
                    $fetchingAttendance = "SELECT attendance.Status, lecture.LectureName FROM attendance JOIN lecture ON attendance.LectureID = lecture.LectureID WHERE attendance.SystemID=$studentID AND attendance.LectureID=$counter AND LectureDate='$dateOfAttendance'";
                    $execQuery = mysqli_query($db, $fetchingAttendance) or die(mysqli_error($db));
                    $isAttendanceAdded = mysqli_num_rows($execQuery);
                    if ($isAttendanceAdded > 0){
                        $studentAttendance = mysqli_fetch_assoc($execQuery);
                        if ($studentAttendance['Status'] == '0'){
                            if ($choice == 1){
                                echo("<td bgcolor='Red' style='color: white;' align='center'>A<br>" . $studentAttendance['LectureName'] . "</td>");
                            }
                            else {
                                echo("<td bgcolor='Red' style='color: white;' align='center'>A</td>");
                            }
                            
                        }
                        else {
                            if ($choice == 1){
                                echo("<td bgcolor='Green' style='color: white;' align='center'>P<br>" . $studentAttendance['LectureName'] . "</td>");
                            }
                            else {
                                echo("<td bgcolor='Green' style='color: white;' align='center'>P</td>");
                            }
                            
                        }
                        
                    }
                    else {
                        echo("<td align='center'>-</td>");
                    }      
                }
                
            echo ("</tr>");
            $counter++;
        }
    }
    ?>


</table>
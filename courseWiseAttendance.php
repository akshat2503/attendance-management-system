<?php

session_start();

if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn']!=true){
    header("location: login.php");
    exit;
}

$termStartingDate = "2023-01-01";
$termEndingDate = "2023-06-30";
$studentID = $_SESSION['systemID'];
$totalNumberOfCourses = 6;

require_once('config.php');

?>

<h3>Attendance Records for Semester - 4</h3>   
<h3>Course-Wise Attendance for <?php echo $_SESSION['studentName'] ?> - <?php echo $studentID ?></h3>
<h3>From <?php echo $termStartingDate ?> to <?php echo $termEndingDate ?></h3>
<button ><a href="/index.php">Return Home</a></button>
<br><br>
<table border="1" cellspacing="0">
        <tr>
            <th>Sr. No</th>
            <th>Course Name</th>
            <th>Course Code</th>
            <th>Attended/Delivered</th>
            <th>Percentage</th>
        </tr>
        
    <?php
    $serialNo = 1;
    $overallAttended = 0;
    $overallClasses = 0;
    $fetchingAttendance = "SELECT lecture.LectureName, lecture.LectureCode FROM student JOIN lecture ON student.Section = lecture.Section WHERE student.SystemID = $studentID;";
    $execQuery = mysqli_query($db, $fetchingAttendance) or die(mysqli_error($db));
    while ($courseList = mysqli_fetch_assoc($execQuery)){
        echo "<tr>";
        echo "<td>" . $serialNo . "</td>";
        $serialNo++;
        echo "<td>" . $courseList['LectureName'] . "</td>";
        echo "<td>" . $courseList['LectureCode'] . "</td>";
        
        $fetchingAttendance = "SELECT COUNT(*) as total_classes, 
            SUM(CASE WHEN attendance.Status=1 THEN 1 ELSE 0 END) as classes_attended
            FROM attendance
            JOIN lecture ON attendance.LectureID = lecture.LectureID
            WHERE attendance.SystemID = $studentID
            AND lecture.LectureCode = '{$courseList['LectureCode']}'
            AND attendance.LectureDate BETWEEN '$termStartingDate' AND '$termEndingDate';";
        $attendance = mysqli_query($db, $fetchingAttendance);
        if (mysqli_num_rows($attendance) > 0){
            while ($row = mysqli_fetch_assoc($attendance)){
                $total_classes = $row["total_classes"];
                if ($total_classes > 0){
                    $classes_attended = $row["classes_attended"];
                } else {
                    $classes_attended = 0;
                }
                echo "<td>" . $classes_attended . "/" . $total_classes . "</td>";
            }
        }
        $overallAttended += $classes_attended;
        $overallClasses += $total_classes;
        if ($total_classes > 0){
            echo "<td>" . round($classes_attended/$total_classes*100, 0) . "%" . "</td>";
        } else {
            echo "<td>0%</td>";
        }
    }
    echo "</tr>";
    echo "<tr>";
    echo "<th colspan='3' align='right'>Total Percentage</th>";
    echo "<th>" . $overallAttended . "/" . $overallClasses . "</th>";
    echo "<th>" . round($overallAttended/$overallClasses*100, 0) . "%" . "</th>";
    echo "</tr>";
    ?>


</table>
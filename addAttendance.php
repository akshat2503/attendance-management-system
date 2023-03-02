<?php
    date_default_timezone_set('Asia/Kolkata');   
    $selected_date = isset($_POST['selected_date']) ? $_POST['selected_date'] : date("Y-m-d");
    // echo $selected_date;
    // $selected_date = $_POST['selected-date'];
?>

<form action="" method="POST">
    <label for="section">Select section for attendance : </label>
    <select name="section" id="" onchange="submit()">
        <option value="">Select Section</option>
        <option value="C" <?php if (isset($_POST['section']) && $_POST['section'] == "C") echo 'selected'; ?>>C</option>
        <option value="E" <?php if (isset($_POST['section']) && $_POST['section'] == "E") echo 'selected'; ?>>E</option>
    </select>
    <br><br>
    <label for="selected_date">Select date for attendance : </label>
    <input type="date" name="selected_date" onchange="submit()" value="<?php echo $selected_date; ?>">
</form>

<?php
    require_once ('config.php');
    $section = "";
    $section = isset($_POST['section']) ? $_POST['section'] : "";
    $lecture_id = 1;
    $fetchingAttendance = mysqli_query($db, "SELECT SystemID FROM attendance WHERE LectureDate = '$selected_date' AND Status = 1 AND LectureID = $lecture_id") or die(mysqli_error($db));
    $presentIDs = mysqli_fetch_all($fetchingAttendance, MYSQLI_ASSOC);
    $presentIDs = array_column($presentIDs, 'SystemID');
    ?>

<table border="1" cellspacing="0">
    <form action="" method="POST">
    <input type="hidden" name="selected_date" value="<?php echo $selected_date; ?>">
        <tr>
            <th>System ID</th>
            <th>Student Name</th>
            <th>P</th>
        </tr>
        <tr>
            <td colspan="2" align="right">All Present</td>
            <th>
                <input type="checkbox" id="select-all">
            </th>
        </tr>
        <?php 
            require_once('config.php');
            $fetchingStudents = mysqli_query($db, "SELECT SystemID, StudentName FROM student WHERE Section = '$section'") or die(mysqli_error($db));
            while ($data = mysqli_fetch_assoc($fetchingStudents)){
                $systemID = $data['SystemID'];
                $studentName = $data['StudentName'];
                $checked = in_array($systemID, $presentIDs) ? 'checked' : '';
        ?>
            <tr>
                <td><?php echo $systemID; ?></td>
                <td><?php echo $studentName; ?></td>
                <td><input type="checkbox" class="checkbox" name="studentAttendance[]" value="<?php echo $systemID; ?>" <?php echo $checked; ?>></td>
            </tr>
        <?php
            }
        ?>
        <tr>
            <td colspan="3" align="right"><input type="submit" name="attendanceBTN"></td>
        </tr>
    </form>
</table>

<script>
  const selectAllCheckbox = document.querySelector("#select-all");
  const checkboxes = document.querySelectorAll(".checkbox");

  selectAllCheckbox.addEventListener("click", function() {
    for (let i = 0; i < checkboxes.length; i++) {
      checkboxes[i].checked = selectAllCheckbox.checked;
    }
  });
</script>

<?php 
    // print_r($_POST['attendanceBTN']);
    // print_r($_POST['studentAttendance']);
    $_POST['studentAttendance'] = isset($_POST['studentAttendance']) ? $_POST['studentAttendance'] : array();
    if (isset($_POST['attendanceBTN'])){
        // if ($_POST['selected_date'] == NULL){
        //     $selected_date = date("Y-m-d");
        // }
        // else {
        //     $selected_date = $_POST['selected_date'];
        // }
        if (isset($_POST['studentAttendance'])){
            $studentPresentID = $_POST['studentAttendance'];
            $presentStatus = 1;
            $presentValues = array();
            foreach ($studentPresentID as $studentID) {
                $presentValues[] = "($studentID, $lecture_id, $presentStatus, '$selected_date')";
            }
            // print_r($presentValues);
            if ($presentValues) {
                
                $presentValuesStr = implode(',', $presentValues);
                $pushingPresentAttendanceSQL = "INSERT INTO attendance (SystemID, LectureID, Status, LectureDate) VALUES $presentValuesStr ON DUPLICATE KEY UPDATE Status = VALUES(Status)";
                $execQuery = mysqli_query($db, $pushingPresentAttendanceSQL) or die(mysqli_error($db));
                // echo $pushingPresentAttendanceSQL;
            }

            //Marking students absent
            $absentStatus = 0;
            $getAllStudentsSQL = "SELECT SystemID from student WHERE Section = 'E'";
            $allStudentsResult = mysqli_query($db, $getAllStudentsSQL) or die (mysqli_error($db));
            $allStudents = mysqli_fetch_all($allStudentsResult, MYSQLI_ASSOC);
            
            $absentValues = array();
            foreach ($allStudents as $studentID) {
                if (!in_array($studentID['SystemID'], $studentPresentID)){
                        $absentValues[] = "({$studentID['SystemID']}, $lecture_id, $absentStatus, '$selected_date')";
                        // print_r($absentValues);
                }
            }
            if ($absentValues){
                $absentValuesStr = implode(',', $absentValues);
                $pushingAbsentAttendanceSQL = "INSERT INTO attendance (SystemID, LectureID, Status, LectureDate) VALUES $absentValuesStr ON DUPLICATE KEY UPDATE Status = VALUES(Status)";
                $execQuery = mysqli_query($db, $pushingAbsentAttendanceSQL) or die (mysqli_error($db));
                // echo $pushingAbsentAttendanceSQL;
            }
            

            echo "<br>Attendance Marked Successfully !";
        }
    }
?>
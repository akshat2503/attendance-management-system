<form action="" method="POST">
    <label for="lecture_name">Enter lecture name :</label>
    <input type="text" name="lecture_name" placeholder="Lecture Name" required>
    <br><br> 
    <label for="lecture_day">Select day :</label>
    <select id="lecture_day" name="lecture_day" required>
        <option value="">Select day</option>
        <option value="1">Monday</option>
        <option value="2">Tuesday</option>
        <option value="3">Wednesday</option>
        <option value="4">Thursday</option>
        <option value="5">Friday</option>
        <option value="6">Saturday</option>
    </select>
    <br><br>
    <label for="lecture_slot">Select time :</label>
    <select id="lecture_slot" name="lecture_slot" required>
        <option value="">Select time</option>
        <option value="1">08:35 - 09:25</option>
        <option value="2">09:30 - 10:20</option>
        <option value="3">10:25 - 11:15</option>
        <option value="4">11:20 - 12:10</option>
        <option value="5">12:15 - 13:05</option>
        <option value="6">13:10 - 14:00</option>
        <option value="7">14:05 - 14:55</option>
        <option value="8">15:00 - 15:50</option>
        <option value="9">15:50 - 16:40</option>
    </select>
    <br><br>
    <label for="section">Enter section :</label>
    <input type="text" name="section" placeholder="Section" required>
    <br><br>
    <input type="submit" value="Add Lecture" name="submit">
</form>

<?php 

if (isset($_POST['submit'])){
    require_once('config.php');
    $lecture_name = $_POST['lecture_name'];
    $lecture_day = $_POST['lecture_day'];
    $lecture_slot = $_POST['lecture_slot'];
    $section = $_POST['section'];

    $query = "INSERT INTO lecture(LectureName, LectureDay, LectureSlot, Section) VALUES('$lecture_name', $lecture_day, $lecture_slot, '$section')";
    $execQuery = mysqli_query($db, $query) or die(mysqli_error($db));
    echo ("Lecture added sucessfully !");
}

?>
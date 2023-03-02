<?php
    $showError = False;
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once('config.php');
        $systemID = $_POST['sysID'];
        $password = $_POST['password'];

        $sql = "SELECT Password FROM userlogin WHERE SystemID=$systemID";
        $execQuery = mysqli_query($db, $sql);
        $num = mysqli_num_rows($execQuery);
        if ($num == 1){
            $passarray = mysqli_fetch_assoc($execQuery);
            $passhash = $passarray['Password'];
            if (password_verify($password, $passhash) == true){
                $login = True;
                session_start();
                $_SESSION['loggedIn'] = true;
                $_SESSION['systemID'] = $systemID;
                // echo "LoggedIn!";
                header("location: /index.php"); 
            } else {
                $showError = "Invalid Credentials !";
            } 
        }
        else {
            $showError = "Invalid Credentials !";
        }
    }

?>

<h1>Sharda University's Own iCloud</h1>
<h3>Login</h3>
<form action="/login.php" method="post">
    <label for="sysID">Enter System ID : </label>
    <input type="text" name="sysID" maxlength="10" required>
    <br><br>
    <label for="password">Password : </label>
    <input type="password" name="password" required>
    <br><br>
    <input type="submit">
</form>

<?php 
    if ($showError){
        echo $showError;
    }
?>
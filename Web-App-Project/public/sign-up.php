<?php
session_start();
include("../private/config.php");

if (isset($_POST['signup-btn'])) { // Retrieve the values from the form submission
    $role = $_POST['role'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($role == 1)
        $table_name = 'training_provider';
    else if ($role == 2)
        $table_name = 'student';
    else if ($role == 3)
        $table_name = 'instructor';

    if (!empty($email) && !empty($password) && !is_numeric($email)) {
        $query = "INSERT INTO $table_name (fname,lname,email,password) VALUES ('$fname','$lname','$email','$password')";
        mysqli_query($con, $query);
        echo "<script type='text/javascript'> alert('Successfully registered!')</script>";
    } else {
        echo "<script type='text/javascript'> alert('Fail to register')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | SkillToGo</title>
    <link rel="stylesheet" href="../css/index.css">
    <!-- Font Awesome Cdn Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>
    <div class="wrapper">
        <img src="../img/logo.png" alt="logo">
        <br>
        <h1>Hello there!</h1>
        <p>Join our comminity and unlock your learning journey!</p>
        <form action="" method="POST" id="signup-form">
            <label for="roles">Sign up as:</label>
            <select name="role" id="roles">
                <option value="1">Training Provider</option>
                <option value="2">Student</option>
                <option value="3">Instructor</option>
            </select>
            <input type="text" id="fname" name="fname" placeholder="Enter your first name" required="">
            <input type="text" id="lname" name="lname" placeholder="Enter your last name" required="">
            <input type="email" id="email" name="email" placeholder="Enter your email" required="">
            <input type="password" id="password" name="password" placeholder="Enter your password" required="">
            <button type="submit" name="signup-btn" form="signup-form" value="Submit">Submit</button>
        </form>
        <div class="not-member">
            Already a member? <a href="index.php">Sign in Now</a>
        </div>
    </div>

</body>

</html>
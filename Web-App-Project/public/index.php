<?php
session_start();
include("../private/config.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $role = $_POST['role'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if ($role == 1)
    $table_name = 'training_provider';
  else if ($role == 2)
    $table_name = 'student';
  else if ($role == 3)
    $table_name = 'instructor';

  if (!empty($email) && !empty($password) && !is_numeric($email)) {
    $query = "SELECT * FROM $table_name WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($result) {
      if ($result && mysqli_num_rows($result) > 0) {
        $row = $result->fetch_assoc();

        // Store the student's information in session variables
        $_SESSION['student_id'] = $row['student_id'];
        $_SESSION['instructor_id'] = $row['instructor_id'];
        $_SESSION['tp_id'] = $row['tp_id'];
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];

        header("location: $table_name.php");
        die;
      }
      echo "<script type='text/javascript'> alert('ERROR: Wrong email or password')</script>";
    } else {
      echo "<script>";
      echo "type='text/javascript'> alert('ERROR: Wrong email or password')";
      echo "window.location.href = 'index.php'";
      echo "</script>";
    }
  }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the login form data
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Prepare the SQL statement to authenticate the user
  $sql = "SELECT * FROM student WHERE email = '$email' AND password = '$password'";
  $result = $con->query($sql);

  if ($result->num_rows == 1) {
    // Fetch the student's information
    $row = $result->fetch_assoc();

    // Store the student's information in session variables
    $_SESSION['student_id'] = $row['student_id'];
    $_SESSION['student_name'] = $row['student_name'];
    // Add any other relevant information you want to store in the session

    // Redirect the user to the home page (student.php)
    header("Location: student.php");
    exit();
  } else {
    echo "Invalid username or password.";
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
    <h1>Welcome back!</h1>
    <p>Please sign in using your registered email to continue</p>
    <form action="" method="POST" id="signin-form">
      <label for="roles">Sign in as:</label>
      <select name="role" id="roles">
        <option value="1">Training Provider</option>
        <option value="2">Student</option>
        <option value="3">Instructor</option>
      </select>
      <input type="email" id="email" name="email" placeholder="abcde@skill2go.com" required="">
      <input type="password" id="password" name="password" placeholder="Password" required="">
    </form>
    <button type="submit" form="signin-form" value="Submit">Sign In</button>
    <div class="not-member">
      Not a member? <a href="sign-up.php">Register Now</a>
    </div>
  </div>
</body>

</html>
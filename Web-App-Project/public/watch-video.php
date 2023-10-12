<?php
session_start();
include("../private/config.php");

$student_id = $_SESSION['student_id'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];

// Check if the user is not logged in
if (!isset($_SESSION['student_id'])) {
    // Redirect to the login page
    header("Location: index.php");
    exit();
}

if (isset($_POST['logout-btn'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

function convertYoutube($yt_link)
{
    return preg_replace(
        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
        "<iframe width=\"680\" height=\"480\" style='padding: 10px; margin-left: 25px;' src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>",
        $yt_link
    );
}

// GET from URL
$course_id = $_GET['course_id'];
$title = $_GET['title'];
$progress = $_GET['progress'];
$link_no = $_GET['link_no'];
if ($progress == 0 || $link_no == 1)
    $yt_link = $_GET['yt_link1'];
else if ($progress == 35 || $link_no == 2)
    $yt_link = $_GET['yt_link2'];
else if ($progress == 70 || $link_no == 3)
    $yt_link = $_GET['yt_link3'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn Course</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" type="text/css" href="../css/student.css">
</head>

<body>
    <header>
        <div class="logo">
            <a href="student.php">
                <img src="../img/logo.png" alt="logo">
            </a>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="my-courses.php">My Courses</a></li>
                <li><a href="test-profile.php"><i class="fas fa-user"></i></a></li>
                <li>
                    <form method="post">
                        <button type="submit" name="logout-btn"
                            style="border: none; background: none; cursor: pointer;"><i
                                class="fas fa-sign-out-alt"></i></button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <section class="section">
        <h2><b><?php echo $title ?>: Episode <?php echo $link_no ?></b></h2>
        <table id="vid-table" class="table">
            <tbody>
                <tr>
                    <th>
                        <?php
                        $query = "SELECT MC.*, C.*, AVC.*
                                    FROM my_course MC
                                    INNER JOIN course C ON MC.course_fk = C.course_id
                                    INNER JOIN available_course AVC ON C.av_course_fk = AVC.av_course_id
                                    WHERE course_fk = C.course_id LIMIT 1";
                        $result = $con->query($query);

                        if ($result->num_rows == 1) {
                            while ($row = $result->fetch_assoc()) {
                                // Access the values from each row
                                $yt_link;
                                echo convertYoutube($yt_link);
                            }
                        } else {
                            echo "<script type='text/javascript'> alert('ERROR: No data found')</script>";
                        }

                        // Update progress for watched/played YouTube Video
                        $add_progress = $progress + 35;
                        if ($add_progress == 105)
                            $add_progress = 100;
                        $sql = "UPDATE `my_course` set progress = $add_progress where course_fk = $course_id";
                        mysqli_query($con, $sql);
                        ?>
                    </th>
                    <th>
                        <h3><b>Feedbacks<b></h3>
                        <form action="" method="POST" id="feedb-form">
                            <textarea id="feedback" name="user_feedback" style="font-weight: normal;" placeholder="Have any feedbacks? Don't hesitate to tell us here!"></textarea><br>
                            <?php echo "<input type='hidden' name='course_id' value='" . $course_id . "'>" ?>
                            <?php echo "<input type='hidden' name='student_id' value='" . $student_id . "'>" ?>
                            <button type='submit' name='feedb-btn' class='feedb-button' style="font-weight: normal; float: right; margin-right: 10%;">Send</button>
                        </form>
                    </th>
                </tr>
            </tbody>
        </table>
    </section> 

    <?php
    if (isset($_POST['feedb-btn'])) { 
        $userFeedback = $_POST['user_feedback'];
        $courseId = $_POST['course_id'];
        $studentId = $_POST['student_id'];

        $insertsql = "INSERT INTO feedback (user_feedb, course_fk, student_fk) VALUES (\"$userFeedback\", $courseId, $studentId)";
        $result = $con->query($insertsql);

        if ($result) {
            echo "<script>alert('Feedback sent!');</script>";
        } else {
            echo "<script>alert('Error: " . $con->error . "');</script>";
        }

    }
    ?>
    
    <section class="section">
        <button type="button" name="finish-btn" class="feedb-button" style="float: right;" onclick="window.location.href='my-courses.php'">Finish</button>
    </section>
</body>

</html>
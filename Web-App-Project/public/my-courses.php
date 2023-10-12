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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Courses</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <li><a href="my-profile.php"><i class="fas fa-user"></i></a></li>
                <li>
                    <form method="post">
                        <button type="submit" name="logout-btn" style="border: none; background: none; cursor: pointer;"><i class="fas fa-sign-out-alt"></i></button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <section id="ongoing-courses" class="section">
        <h2><b>Ongoing Courses</b></h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Progress</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT C.*, AVC.*, MC.progress
                        FROM my_course MC 
                        INNER JOIN course C ON MC.course_fk = C.course_id
                        INNER JOIN available_course AVC ON C.av_course_fk = AVC.av_course_id
                        INNER JOIN student S ON MC.student_fk = S.student_id
                        WHERE MC.progress != 100 AND MC.student_fk=$student_id;";
                $result = $con->query($sql);

                if ($result) {
                    // Loop through the result set and echo the data
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['start_date'] . "</td>";
                        echo "<td>" . $row['end_date'] . "</td>";
                        echo "<td>";
                        echo "<div class='w3-light-grey w3-round'>";
                        echo "<div class='w3-container w3-round w3-blue w3-center' style='width:" . $row['progress'] . "%'>" . $row['progress'] . "%</div>";
                        echo "</div>";
                        if ($row['progress'] == 0) {
                            $link_no = 1;
                            echo "<td><a href='watch-video.php?course_id=" . $row['course_id'] . "&title=" . $row['title'] . "&progress=" . $row['progress'] . "&link_no=" . $link_no . "&yt_link" . $link_no . "=" . $row['yt_link1'] . "'>Continue</a></td>";
                        } else if ($row['progress'] == 35) {
                            $link_no = 2;
                            echo "<td><a href='watch-video.php?course_id=" . $row['course_id'] . "&title=" . $row['title'] . "&progress=" . $row['progress'] . "&link_no=" . $link_no . "&yt_link" . $link_no . "=" . $row['yt_link2'] . "'>Continue</a></td>";
                        } else if ($row['progress'] == 70) {
                            $link_no = 3;
                            echo "<td><a href='watch-video.php?course_id=" . $row['course_id'] . "&title=" . $row['title'] . "&progress=" . $row['progress'] . "&link_no=" . $link_no . "&yt_link" . $link_no . "=" . $row['yt_link3'] . "'>Continue</a></td>";
                        }
                        echo "</tr>";
                    }
                    $result->free_result();
                } else {
                    echo "ERROR: " . $con->error;
                }
                ?>
            </tbody>
        </table>
    </section>

    <section id="completed-courses" class="section">
        <h2><b>Completed Courses</b></h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Episode 1</th>
                    <th>Episode 2</th>
                    <th>Episode 3</th>
                    <th>Progress</th>
                    <th>Certificate</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT C.*, AVC.*, MC.progress
                        FROM my_course MC 
                        INNER JOIN course C ON MC.course_fk = C.course_id
                        INNER JOIN available_course AVC ON C.av_course_fk = AVC.av_course_id
                        INNER JOIN student S ON MC.student_fk = S.student_id
                        WHERE progress > 70 AND MC.student_fk=$student_id;";
                $result = $con->query($sql);

                if ($result) {
                    // Loop through the result set and echo the data
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td><a href='" . $row['yt_link1'] . " target='_blank'>Rewatch</a>";
                        echo "<td><a href='" . $row['yt_link2'] . " target='_blank'>Rewatch</a>";
                        echo "<td><a href='" . $row['yt_link3'] . " target='_blank'>Rewatch</a>";
                        echo "<td>";
                        echo "<div class='w3-light-grey w3-round'>";
                        echo "<div class='w3-container w3-round w3-green w3-center' style='width:" . $row['progress'] . "%'>" . $row['progress'] . "%</div>";
                        echo "</div>";
                        echo "<td><a href='../img/cert.jpeg' target='_blank'>View</a></td>";
                        echo "</tr>";
                    }
                    $result->free_result();
                } else {
                    echo "ERROR: " . $con->error;
                }
                ?>
            </tbody>
        </table>
    </section>

    <script>
        var links = document.getElementsByClassName('openImageLink');
        for (var i = 0; i < links.length; i++) {
            links[i].addEventListener('click', function (event) {
                event.preventDefault();
                var certificatePath = 'certificates/' + this.getAttribute('data-certificate');
                window.open(certificatePath, '_blank');
            });
        }
    </script>
</body>

</html>
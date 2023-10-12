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
    <title>My Profile</title>
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
                        <button type="submit" name="logout-btn"
                            style="border: none; background: none; cursor: pointer;"><i
                                class="fas fa-sign-out-alt"></i></button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <section class="section">
        <h2><b>My User Profile</b></h2>
        <table class="table" style="pointer-events: none; background-color: #f2f2f2">
            <tbody>
                <tr style="background-color: #dfe9f5;">
                    <td>
                        <table class="table" style="pointer-events: none;">
                            <tbody>
                                <tr style="background-color: #dfe9f5">
                                    <td style="text-align:center;">
                                        <img src="../img/user-profile.png" alt="User Profile Picture">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table class="table" style="pointer-events: none;">
                            <tbody>
                                <th colspan="3">User details</th>
                                <?php
                                $sql = "SELECT *
                                    FROM student S;";
                                $result = $con->query($sql);

                                if ($result) {
                                    $row = $result->fetch_assoc();
                                    echo "<tr>";
                                    echo "<td><img src=\"../img/student-id-icon.png\" alt=\"person\"></td>";
                                    echo "<td>Student ID: </td>";
                                    echo "<td>" . $row['student_id'] . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><img src='../img/email-icon.png' alt='email'></td>";
                                    echo "<td>E-mail: </td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><img src=\"../img/person-icon.png\" alt=\"person\"></td>";
                                    echo "<td>First Name: </td>";
                                    echo "<td>" . $row['fname'] . "</td>";
                                    echo "</tr>";

                                    echo "<tr>";
                                    echo "<td><img src=\"../img/person-icon.png\" alt=\"person\"></td>";
                                    echo "<td>Last Name: </td>";
                                    echo "<td>" . $row['lname'] . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    <section class="section">
        <h2><b>My Courses</b></h2>
        <table class="table">
            <tbody>
                <tr>
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Course Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <?php
                            $sql = "SELECT C.*, AVC.*, MC.progress
                                    FROM my_course MC 
                                    INNER JOIN course C ON MC.course_fk = C.course_id
                                    INNER JOIN available_course AVC ON C.av_course_fk = AVC.av_course_id
                                    INNER JOIN student S ON MC.student_fk = S.student_id
                                    WHERE MC.student_fk=$student_id;";
                            $result = $con->query($sql);

                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    if ($row['progress'] > 70) {
                                        echo "<tr>";
                                        echo "<td>" . $row['title'] . "</td>";
                                        echo "<td>Completed</td>";
                                        echo "<td><a style='color: green;' href='../img/cert.jpeg' target='_blank'>View Certificate</a></td>";
                                        echo "</tr>";
                                    } else if ($row['progress'] != 100) {
                                        echo "<tr>";
                                        echo "<td>" . $row['title'] . "</td>";
                                        if ($row['progress'] == 0) {
                                            $link_no = 1;
                                            echo "<td>Ongoing</td>";
                                            echo "<td><a href='watch-video.php?course_id=" . $row['course_id'] . "&title=" . $row['title'] . "&progress=" . $row['progress'] . "&link_no=" . $link_no . "&yt_link" . $link_no . "=" . $row['yt_link1'] . "'>Continue</a></td>";
                                        } else if ($row['progress'] == 35) {
                                            $link_no = 2;
                                            echo "<td>Ongoing</td>";
                                            echo "<td><a href='watch-video.php?course_id=" . $row['course_id'] . "&title=" . $row['title'] . "&progress=" . $row['progress'] . "&link_no=" . $link_no . "&yt_link" . $link_no . "=" . $row['yt_link2'] . "'>Continue</a></td>";
                                        } else if ($row['progress'] == 70) {
                                            $link_no = 3;
                                            echo "<td>Ongoing</td>";
                                            echo "<td><a href='watch-video.php?course_id=" . $row['course_id'] . "&title=" . $row['title'] . "&progress=" . $row['progress'] . "&link_no=" . $link_no . "&yt_link" . $link_no . "=" . $row['yt_link3'] . "'>Continue</a></td>";
                                        }
                                        echo "</tr>";
                                    }
                                }
                                $result->free_result();
                            } else {
                                echo "ERROR: " . $con->error;
                            }
                            ?>
                        </tbody>
                    </table>
                </tr>
            </tbody>
        </table>
    </section>
</body>
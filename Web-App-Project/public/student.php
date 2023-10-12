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
<html>

<head>
    <title>Online Course Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" type="text/css" href="../css/student.css">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

</head>

<body>
    <!-- HEADER -->
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

    <!-- BROWSE NEW COURSES SLIDER -->
    <h2 style="margin: 20px 40px;"><b>Browse New Courses</b></h2>
    <div class="course-cards swiper">
        <div class="swiper-wrapper">
            <?php
            $sql = "SELECT C.*, AVC.*, I.fname, I.lname
                    FROM course C 
                    INNER JOIN instructor I ON C.instructor_fk = I.instructor_id
                    INNER JOIN available_course AVC ON C.av_course_fk = AVC.av_course_id
                    ORDER BY course_id DESC;";
            $result = $con->query($sql);

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='course-card swiper-slide'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>" . $row['description'] . "</p>";
                    echo "<div class='browse-courses-details'>";
                    echo "<p><span><strong>Start date:</strong> " . $row['start_date'] . "</span></p>";
                    echo "<p><span><strong>End date:</strong> " . $row['end_date'] . "</span></p>";
                    echo "<p><span><strong>Instructor:</strong> " . $row['fname'] . " " . $row['lname'] . "</span></p>";
                    echo "</div>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='course_id' value='" . $row['course_id'] . "'>";
                    echo "<input type='hidden' name='student_id' value='$student_id'>";
                    echo "<button type='submit' name='enroll-btn' class='enroll-button'>Enroll</button>";
                    echo "</form>";
                    echo "</div>";
                }
                $result->free_result();
            } else {
                echo "ERROR: " . $con->error;
            }

            if (isset($_POST['enroll-btn'])) { // Retrieve the values from the form submission
                $courseId = $_POST['course_id'];
                $studentId = $_POST['student_id'];

                // Check if the enrollment already exists for the student and course
                $checkSql = "SELECT * FROM my_course WHERE course_fk = $courseId AND student_fk = $studentId";
                $checkResult = $con->query($checkSql);

                if ($checkResult->num_rows > 0) {
                    // Enrollment already exists
                    echo "<script>alert('You are already enrolled in this course.');</script>";
                } else {
                    // Perform the database insertion
                    $insertSql = "INSERT INTO my_course (course_fk, student_fk, progress) VALUES ($courseId, $studentId, 0)";
                    if ($con->query($insertSql) === TRUE) {
                        // Insertion successful
                        echo "<script>alert('Enrollment successful!');</script>";
                    } else {
                        // Insertion failed
                        echo "<script>alert('Error: " . $con->error . "');</script>";
                    }
                }
                $checkResult->free_result();
            }
            ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- REGISTERED COURSES TABLE -->
    <section id="registered-courses" class="section">
        <h2><b>All Registered Courses</b></h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Progress</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT AVC.*, MC.progress
                FROM my_course MC
                INNER JOIN course C ON MC.course_fk = C.course_id
                INNER JOIN available_course AVC ON C.av_course_fk = AVC.av_course_id
                WHERE MC.student_fk = $student_id;";
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
                        if ($row['progress'] <= 75) {
                            echo "<div class='w3-light-grey w3-round'>";
                            echo "<div class='w3-container w3-round w3-blue w3-center' style='width:" . $row['progress'] . "%'>" . $row['progress'] . "%</div>";
                            echo "</div>";
                            echo "<td>Ongoing</td>";
                        } else {
                            echo "<div class='w3-light-grey w3-round'>";
                            echo "<div class='w3-container w3-round w3-green w3-center' style='width:" . $row['progress'] . "%'>" . $row['progress'] . "%</div>";
                            echo "</div>";
                            echo "<td>Completed</td>";
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

    <!-- FEEDBACKS SECTION -->
    <h2 style="margin: 20px 40px;"><b>Feedbacks From the Community</b></h2>
    <div class="swiper feedb-swiper">
        <div class="swiper-wrapper">
            <?php
            $sql = "SELECT F.*, AVC.*, S.fname, S.lname FROM feedback F
                    INNER JOIN course C ON F.course_fk = C.course_id
                    INNER JOIN student S ON F.student_fk = S.student_id
                    INNER JOIN available_course AVC ON C.av_course_fk = AVC.av_course_id
                    ORDER BY F.feedb_id DESC;";
            $result = $con->query($sql);

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='swiper-slide' id='auto-swiper'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p style='font-weight:bold;'>By " . $row['fname'] . " " . $row['lname'] . "</p>";
                    echo "<p><small>\"" . $row['user_feedb'] . "\"</small></p>";
                    echo "<br>";
                    echo "</div>";
                }
            } else {
                echo "ERROR: " . $con->error;
            }
            $result->free_result();
            ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".feedb-swiper", {
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>

    <!--  JavaScript -->
    <script src="../js/script.js"></script>
</body>

</html>
<?php
session_start();
include("../private/config.php");

$instructor_id = $_SESSION['instructor_id'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];

// Check if the user is not logged in
if (!isset($_SESSION['instructor_id'])) {
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
    <link rel="stylesheet" type="text/css" href="../css/instructor.css">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <style></style>

</head>

<body>
    <header>
        <div class="logo">
            <a href="instructor.php">
                <img src="../img/logo.png" alt="logo">
            </a>
        </div>
        <nav>
            <ul class="menu">
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

    <h2 style="margin: 20px 40px;"><b>Browse New Courses</b></h2>
    <div class="course-cards swiper">
        <div class="swiper-wrapper">
            <?php
            $sql = "SELECT AVC.*, I.fname, I.lname
                    FROM available_course AVC 
                    INNER JOIN instructor I
                    ON AVC.instructor_fk = I.instructor_id
                    WHERE AVC.instructor_fk = $instructor_id
                    ORDER BY AVC.status = 1 DESC";
            $result = $con->query($sql);

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='course-card swiper-slide'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>" . $row['description'] . "</p>";
                    echo "<div class=browse-courses-details'>";
                    echo "<p><span><strong>Start date:</strong> " . $row['start_date'] . "</span></p>";
                    echo "<p><span><strong>End date:</strong> " . $row['end_date'] . "</span></p>";
                    echo "<p><span><strong>Instructor:</strong> " . $row['fname'] . " " . $row['lname'] . "</span></p>";
                    echo "</div>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' name='av_course_id' value='" . $row['av_course_id'] . "'>";
                    echo "<input type='hidden' name='title' value='" . $row['title'] . "'>";
                    echo "<input type='hidden' name='description' value='" . $row['description'] . "'>";
                    echo "<input type='hidden' name='start_date' value='" . $row['start_date'] . "'>";
                    echo "<input type='hidden' name='end_date' value='" . $row['end_date'] . "'>";
                    echo "<input type='hidden' name='instructor_id' value='" . $row['instructor_fk'] . "'>";
                    echo "<input type='hidden' name='yt_link1' value='" . $row['yt_link1'] . "'>";
                    echo "<input type='hidden' name='yt_link2' value='" . $row['yt_link2'] . "'>";
                    echo "<input type='hidden' name='yt_link3' value='" . $row['yt_link3'] . "'>";
                    if($row['status']==true) {
                        echo "<button type='submit' name='available-btn' class='available-button'>Available</button>";
                        echo "<button type='submit' name='not-available-btn' class='not-available-button'>Not Available</button>";
                    }
                    else if($row['status']==false) {
                        echo "<br>";
                        echo "<text class='taken-text' style='color: red; text-decoration: underline; font-weight: bold;'>Confirmed</text>";
                    }
                    echo "</form>";
                    echo "</div>";
                }

                $result->free_result();
            } else {
                echo "ERROR: " . $con->error;
            }

            if (isset($_POST['available-btn'])) { 
                $av_courseId = $_POST['av_course_id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $start_date = $_POST['start_date'];
                $end_date = $_POST['end_date'];
                $instructorId = $_POST['instructor_id'];
                $yt_link1 = $_POST['yt_link1'];
                $yt_link2 = $_POST['yt_link2'];
                $yt_link3 = $_POST['yt_link3'];

                    $insertSql = "INSERT INTO course (av_course_fk, instructor_fk) VALUES ($av_courseId, $instructorId)";
                    if ($con->query($insertSql)) {
                        $updateSql = "UPDATE `available_course` SET `status`=0 WHERE av_course_id = $av_courseId";
                        $con->query($updateSql);

                        echo "<script>alert('You are set to be teaching " . $title . "!');</script>";
                        ?><script>window.location = "instructor.php";</script><?php
                    } else {
                        echo "<script>alert('Error: " . $con->error . "');</script>";
                    }                
            }
            if (isset($_POST['not-available-btn'])) {
                $av_courseId = $_POST['av_course_id'];
                $title = $_POST['title'];

                $updateSql = "UPDATE `available_course` SET `status`=1,`instructor_fk`=-1 WHERE av_course_id = $av_courseId";
                if ($con->query($updateSql)) {
                    echo "<script>alert('You will not be registered to teach "  . $title . "!');</script>";
                    ?><script>window.location = "instructor.php";</script><?php
                } else {
                    echo "<script>alert('Error: " . $con->error . "');</script>";
                }
            }

            ?>

        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>

    <section id="registered-courses" class="section">
        <h2><b>All Registered Courses</b></h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT C.*, AVC.*
                        FROM course C 
                        INNER JOIN instructor I ON C.instructor_fk = I.instructor_id
                        INNER JOIN available_course AVC ON C.av_course_fk = AVC.av_course_id
                        WHERE C.instructor_fk=$instructor_id;";
                $result = $con->query($sql);

                if ($result) {
                    // Loop through the result set and echo the data
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['start_date'] . "</td>";
                        echo "<td>" . $row['end_date'] . "</td>";
                        echo "<td>Confirmed</td>";
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

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
      var swiper = new Swiper(".course-cards", {
        slidesPerView: 1,
        watchOverflow: true,
        spaceBetween: 30,
        loop: true,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        breakpoints: {
          320: {
            slidesPerView: 1,
          },
          430: {
            slidesPerView: 2,
          },
          768: {
            slidesPerView: 3,
          },
          1200: {
            slidesPerView: 4,
          },
        },
      });

      // from my-courses.php
      document.getElementById('openImageLink').addEventListener('click', function() {
        var image = document.getElementById('imageDisplay');
        var imageName = 'logo.png'; // Replace with the actual name of the image file
        var imagePath = '../img/' + imageName;
        image.src = imagePath;
      });
    </script>
</body>

</html>

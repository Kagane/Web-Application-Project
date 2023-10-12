<?php
session_start();
include("../private/config.php");

$tProvider_id = $_SESSION['tp_id'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];

// Check if the user is not logged in
if (!isset($_SESSION['tp_id'])) {
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
    <link rel="stylesheet" type="text/css" href="../css/tprovider.css">

    <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <style>
        .form-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: #ffeed2;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-container input[type="text"],
        .form-container input[type="date"],
        .form-container input[type="url"],
        .form-container select,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .form-container .row {
            display: flex;
            justify-content: space-between;
        }

        .form-container .row .col {
            width: 48%;
        }

        .form-container textarea {
            height: 80px;
        }

        .form-container button {
            background-color: #e98800;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            float: right;
        }

        .form-container button:hover {
            background-color: #ff9500;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <a href="training_provider.php">
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

    <div class="form-container">
        <h2><b>Add New Courses</b></h2>
        <form method="POST" action="" id="add-course-form">
            <div class="row">
                <div class="col">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" placeholder="Enter the course title" required>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" placeholder="Enter the course description"
                        required></textarea>
                    <label for="start-date">Start Date:</label>
                    <input type="date" id="start-date" name="start_date" required>
                    <label for="end-date">End Date:</label>
                    <input type="date" id="end-date" name="end_date" required>
                </div>
                <div class="col">
                    <label for="instructor">Instructor:</label>
                    <select id="instructor" name="instructor_id" required>
                        <option value="">Assign an instructor</option>
                        <?php
                        // Fetch instructor names from the database table
                        $query = "SELECT * FROM instructor WHERE instructor_id > 0";
                        $result = $con->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['instructor_id'] . "'>" . $row['instructor_id'] . " - " . $row['fname'] . " " . $row['lname'] . "</option>";
                            }
                        } else {
                            echo "<script>alert('Error: " . $con->error . "');</script>";
                        }
                        ?>
                    </select>
                    <label for="youtube-link1">YouTube Link 1:</label>
                    <input type="url" id="youtube-link1" name="youtube_link1" placeholder="Enter the YouTube link 1">
                    <label for="youtube-link2">YouTube Link 2:</label>
                    <input type="url" id="youtube-link2" name="youtube_link2" placeholder="Enter the YouTube link 2">
                    <label for="youtube-link3">YouTube Link 3:</label>
                    <input type="url" id="youtube-link3" name="youtube_link3" placeholder="Enter the YouTube link 3">
                    <button type="submit" name='add-btn' form="add-course-form">Add</button>
                </div>
            </div>
        </form>
    </div>

    <?php
    if (isset($_POST['add-btn'])) { // Retrieve the values from the form submission
        $cTitle = $_POST['title'];
        $cDescription = $_POST['description'];
        $cStartDate = $_POST['start_date'];
        $cEndDate = $_POST['end_date'];
        $instructorFk = $_POST['instructor_id'];
        $ytLink1 = $_POST['youtube_link1'];
        $ytLink2 = $_POST['youtube_link2'];
        $ytLink3 = $_POST['youtube_link3'];

        $query = "INSERT INTO `available_course`
                (`description`,`title`,`start_date`,`end_date`,`instructor_fk`,`yt_link1`,`yt_link2`,`yt_link3`,`tp_fk`)
                VALUES ('$cDescription','$cTitle','$cStartDate','$cEndDate',$instructorFk,'$ytLink1','$ytLink2','$ytLink3',$tProvider_id)";
        $result = $con->query($query);

        if ($result) {
            echo "<script>alert('$cTitle course has been added!');</script>";
        } else {
            // Insertion failed
            echo "<script>alert('Error: " . $con->error . "');</script>";
        }
    }
    ?>

    <!-- ADDED COURSES -->
    <section class="section">
        <h2><b>Added Courses</b></h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Description</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Instructor</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT AVC.*, I.*, C.course_id
                    FROM available_course AVC
                    INNER JOIN instructor I ON AVC.instructor_fk = I.instructor_id
                    LEFT JOIN course C ON AVC.av_course_id = C.av_course_fk
                    WHERE AVC.tp_fk = $tProvider_id
                    ORDER BY AVC.instructor_fk = -1 DESC, AVC.av_course_id DESC;";
                $result = $con->query($sql);

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['start_date'] . "</td>";
                        echo "<td>" . $row['end_date'] . "</td>";
                        if ($row['instructor_fk'] == -1) {
                            echo "<td style='color:red;'><b>REASSIGN NEW INSTRUCTOR</b></td>";
                        } else {
                            echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
                        }
                        echo "<form method='POST'>";
                        echo "<input type='hidden' name='course_id' value='" . $row['course_id'] . "'>";
                        echo "<input type='hidden' name='av_course_id' value='" . $row['av_course_id'] . "'>";
                        echo "<input type='hidden' name='title' value='" . $row['title'] . "'>";
                        echo "<td>";
                        echo "<a class='edit-btn' id='edit-btn' href='edit-course.php?course_id=" . $row['course_id'] . "&av_course_id=" . $row['av_course_id'] . "&description=" . $row['description'] . "&title=" . $row['title'] . "&start_date=" . $row['start_date'] . "&end_date=" . $row['end_date'] . "&instructor_fk=" . $row['instructor_fk'] . "&yt_link1=" . $row['yt_link1'] . "&yt_link2=" . $row['yt_link2'] . "&yt_link3=" . $row['yt_link3'] . "'><i class='fas fa-edit' style='color: white;'></i></a>";
                        echo "<button type='submit' name='delete-btn' class='delete-btn' id='delete-btn'><i class='fas fa-trash-alt'></i></button>";
                        echo "</td>";
                        echo "</form>";
                        echo "</tr>";
                    }
                } else {
                    echo "ERROR: " . $con->error;
                }

                if (isset($_POST['delete-btn'])) { // Retrieve the values from the form submission
                    $courseId = $_POST['course_id'];
                    $av_courseId = $_POST['av_course_id'];
                    $av_courseTitle = $_POST['title'];

                    // Prepare the first query to delete from the 'feedback' table
                    $query1 = "DELETE FROM feedback WHERE course_fk = ?";

                    // Prepare the second query to delete from the 'my_course' table
                    $query2 = "DELETE FROM my_course WHERE course_fk = ?";

                    // Prepare the third query to delete from the 'course' table
                    $query3 = "DELETE FROM course WHERE course_id = ?";

                    // Prepare the fourth query to delete from the 'available_course' table
                    $query4 = "DELETE FROM available_course WHERE av_course_id = ?";

                    // Bind the values to the placeholders
                    $stmt1 = $con->prepare($query1);
                    $stmt1->bind_param("i", $courseId);

                    $stmt2 = $con->prepare($query2);
                    $stmt2->bind_param("i", $courseId);

                    $stmt3 = $con->prepare($query3);
                    $stmt3->bind_param("i", $courseId);

                    $stmt4 = $con->prepare($query4);
                    $stmt4->bind_param("i", $av_courseId);

                    // Execute the queries
                    if ($stmt1->execute() && $stmt2->execute() && $stmt3->execute() && $stmt4->execute()) {
                        // Deletion successful
                        echo "<script>alert('" . $av_courseTitle . " has been deleted!');</script>";
                        ?>
                        <script>window.location = "training_provider.php";</script>
                        <?php
                    } else {
                        // Handle errors if needed
                        echo "<script>alert('Error: " . $con->error . "');</script>";
                    }
                }
                ?>
            </tbody>
        </table>
    </section>
</body>

</html>
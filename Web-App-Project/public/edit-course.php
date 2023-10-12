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
    <title>Training Provider Dashboard</title>
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
            margin: 50px auto;
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

    <!-- EDIT COURSES -->
    <div class="form-container">
        <h2><b>EDIT Courses</b></h2>
        <?php
        $course_id = $_GET['course_id'];
        $av_course_id = $_GET['av_course_id'];
        $description = $_GET['description'];
        $title = $_GET['title'];
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];
        $instructor_fk = $_GET['instructor_fk'];
        $yt_link1 = $_GET['yt_link1'];
        $yt_link2 = $_GET['yt_link2'];
        $yt_link3 = $_GET['yt_link3'];
        ?>
        <form method="POST" action="" id="save-course-form">
            <div class="row">
                <div class="col">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo $title ?>">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description"></textarea>
                    <label for="start-date">Start Date:</label>
                    <input type="date" id="start-date" name="start_date" value="<?php echo $start_date ?>">
                    <label for="end-date">End Date:</label>
                    <input type="date" id="end-date" name="end_date" value="<?php echo $end_date ?>">
                </div>
                <div class="col">
                    <label for="instructor">Instructor:</label>
                    <select id="instructor" name="instructor_id">
                        <?php
                        $sql = "SELECT instructor_id, fname, lname FROM instructor WHERE instructor_id = $instructor_fk";
                        $result1 = $con->query($sql);
                        if ($result1) {
                            while ($row = $result1->fetch_assoc()) {
                                echo "<option value='" . $row['instructor_id'] . "'>" . $row['instructor_id'] . " - " . $row['fname'] . " " . $row['lname'] . "</option>";
                            }
                        } else {
                            echo "<script>alert('Error: " . $con->error . "');</script>";
                        }

                        $query = "SELECT * FROM instructor WHERE instructor_id > 0 AND instructor_id != $instructor_fk";
                        $result2 = $con->query($query);

                        if ($result2->num_rows > 0) {
                            while ($row = $result2->fetch_assoc()) {
                                echo "<option value='" . $row['instructor_id'] . "'>" . $row['instructor_id'] . " - " . $row['fname'] . " " . $row['lname'] . "</option>";
                            }
                        } else {
                            echo "<script>alert('Error: " . $con->error . "');</script>";
                        }
                        ?>
                    </select>
                    <label for="youtube-link1">YouTube Link 1:</label>
                    <input type="url" id="youtube-link1" name="youtube_link1" value="<?php echo $yt_link1 ?>">
                    <label for="youtube-link2">YouTube Link 2:</label>
                    <input type="url" id="youtube-link2" name="youtube_link2" value="<?php echo $yt_link2 ?>">
                    <label for="youtube-link3">YouTube Link 3:</label>
                    <input type="url" id="youtube-link3" name="youtube_link3" value="<?php echo $yt_link3 ?>">
                    <input type='hidden' name='av_course_id' value="<?php echo $av_course_id ?>">
                    <button type="submit" name='save-btn' form="save-course-form">Save</button>
                </div>
            </div>
        </form>
        <a class='back-button' name='back-btn' href="training_provider.php" style="float: left; margin: 40px 0;">Back</a>

    </div>

    <?php
    if (isset($_POST['save-btn'])) { // Retrieve the values from the form submission
        $avCourseId = $_POST['av_course_id'];
        $cTitle = $_POST['title'];
        $cDescription = $_POST['description'];
        $cStartDate = $_POST['start_date'];
        $cEndDate = $_POST['end_date'];
        $instructorFk = $_POST['instructor_id'];
        $ytLink1 = $_POST['youtube_link1'];
        $ytLink2 = $_POST['youtube_link2'];
        $ytLink3 = $_POST['youtube_link3'];

        $query = "UPDATE `available_course` SET `description`='$cDescription',`title`='$cTitle',`start_date`='$cStartDate',`end_date`='$cEndDate',`instructor_fk`=$instructorFk,`yt_link1`='$ytLink1',`yt_link2`='$ytLink2',`yt_link3`='$ytLink3'
        WHERE `av_course_id`=$avCourseId;";
        $result = $con->query($query);

        if ($result) {
            echo "<script>alert('Changes in $cTitle course have been updated!'); window.location.href = 'training_provider.php';</script>";
            
        } else {
            // Insertion failed
            echo "<script>alert('Error: " . $con->error . "');</script>";
        }
    }

    if (isset($_POST['back-btn'])) {
        
    }
    ?>

    <script>
        // Retrieve the description value from the URL parameter
        var description = '<?php echo $_GET["description"]; ?>';

        // Set the description value in the textarea
        document.getElementById('description').value = description;
    </script>
</body>

</html>
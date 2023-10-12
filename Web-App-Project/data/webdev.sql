-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 21, 2023 at 10:18 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webdev`
--

-- --------------------------------------------------------

--
-- Table structure for table `available_course`
--

CREATE TABLE `available_course` (
  `av_course_id` int(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `instructor_fk` int(100) NOT NULL,
  `yt_link1` varchar(255) DEFAULT NULL,
  `yt_link2` varchar(255) DEFAULT NULL,
  `yt_link3` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `tp_fk` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `available_course`
--

INSERT INTO `available_course` (`av_course_id`, `description`, `title`, `start_date`, `end_date`, `instructor_fk`, `yt_link1`, `yt_link2`, `yt_link3`, `status`, `tp_fk`) VALUES
(1, 'Get to know DL!', 'Deep Learning', '2023-04-13', '2023-07-20', 4, 'https://www.youtube.com/watch?v=CS4cs9xVecg&list=PLkDaE6sCZn6Ec-XTbcX1uRg2_u4xOEky0', 'https://www.youtube.com/watch?v=n1l-9lIMW7E&list=PLkDaE6sCZn6Ec-XTbcX1uRg2_u4xOEky0&index=2', 'https://www.youtube.com/watch?v=BYGpKPY9pO0&list=PLkDaE6sCZn6Ec-XTbcX1uRg2_u4xOEky0&index=3', 0, 1),
(2, 'Learn how to code C++!', 'C++', '2023-06-03', '2023-11-03', 3, 'https://www.youtube.com/watch?v=brqRL_t0RmM&list=PLfVsf4Bjg79Cu5MYkyJ-u4SyQmMhFeC1C&index=2', 'https://www.youtube.com/watch?v=ZTu0kf-7h08&list=PLfVsf4Bjg79Cu5MYkyJ-u4SyQmMhFeC1C&index=3', 'https://www.youtube.com/watch?v=ZTu0kf-7h08&list=PLfVsf4Bjg79Cu5MYkyJ-u4SyQmMhFeC1C&index=3', 1, 2),
(3, 'Learn OOP with Java', 'Java', '2023-06-03', '2023-11-03', 1, 'https://www.youtube.com/watch?v=VHbSopMyc4M&list=PLBlnK6fEyqRjKA_NuK9mHmlk0dZzuP1P5', 'https://www.youtube.com/watch?v=-C88r0niLQQ&list=PLBlnK6fEyqRjKA_NuK9mHmlk0dZzuP1P5&index=2', 'https://www.youtube.com/watch?v=mG4NLNZ37y4&list=PLBlnK6fEyqRjKA_NuK9mHmlk0dZzuP1P5&index=3', 0, 3),
(4, 'Learn how to code in Python', 'Python', '2023-06-03', '2023-11-03', 2, 'https://www.youtube.com/watch?v=hEgO047GxaQ&list=PLsyeobzWxl7poL9JTVyndKe62ieoN-MZ3&index=2', 'https://www.youtube.com/watch?v=mbryl4MZJms&list=PLsyeobzWxl7poL9JTVyndKe62ieoN-MZ3&index=3', 'https://www.youtube.com/watch?v=DWgzHbglNIo&list=PLsyeobzWxl7poL9JTVyndKe62ieoN-MZ3&index=4', 0, 4),
(5, 'Learn how to build Android app', 'Android Studio', '2023-06-03', '2023-11-03', 1, 'https://www.youtube.com/watch?v=7FOv6txKzMg&list=PLOWkC81NKMXOsBUkyQutW0cQOjjudcveE', 'https://www.youtube.com/watch?v=7d2DJap5yMg&list=PLOWkC81NKMXOsBUkyQutW0cQOjjudcveE&index=2', 'https://www.youtube.com/watch?v=j_p0E70hZps&list=PLOWkC81NKMXOsBUkyQutW0cQOjjudcveE&index=3', 0, 1),
(6, 'Learn how to build a website', 'HTML', '2023-06-03', '2023-11-03', 3, 'https://www.youtube.com/watch?v=dD2EISBDjWM&list=PLr6-GrHUlVf_ZNmuQSXdS197Oyr1L9sPB', 'https://www.youtube.com/watch?v=-USAeFpVf_A&list=PLr6-GrHUlVf_ZNmuQSXdS197Oyr1L9sPB&index=2', 'https://www.youtube.com/watch?v=i3GE-toQg-o&list=PLr6-GrHUlVf_ZNmuQSXdS197Oyr1L9sPB&index=3', 0, 2),
(7, 'Learn how to build iOS app', 'Swift', '2023-06-03', '2023-11-03', 4, 'https://www.youtube.com/watch?v=bjPENR6sHRU&list=PL5PR3UyfTWvfacnfUsvNcxIiKIgidNRoW', 'https://www.youtube.com/watch?v=xKf6iNilRYI&list=PL5PR3UyfTWvfacnfUsvNcxIiKIgidNRoW&index=2', 'https://www.youtube.com/watch?v=48v8FH46mQs&list=PL5PR3UyfTWvfacnfUsvNcxIiKIgidNRoW&index=3', 0, 3),
(8, 'Get to know network protocols!', 'Computer Network', '2023-05-31', '2023-11-22', 2, 'https://www.youtube.com/watch?v=aHJElrgj6UA&list=PLBbU9-SUUCwVmwRswAHdqoJw-D2WeD9CN', 'https://www.youtube.com/watch?v=8npT9AALbrI&list=PLBbU9-SUUCwVmwRswAHdqoJw-D2WeD9CN&index=2', 'https://www.youtube.com/watch?v=BnWn18qUYyA&list=PLBbU9-SUUCwVmwRswAHdqoJw-D2WeD9CN&index=3', 0, 4),
(9, 'Learn how to code in R!', 'R', '2023-04-13', '2023-07-20', 3, 'https://www.youtube.com/watch?v=SWxoJqTqo08&list=PLjgj6kdf_snYBkIsWQYcYtUZiDpam7ygg', 'https://www.youtube.com/watch?v=hxlHQ2AtLUk&list=PLjgj6kdf_snYBkIsWQYcYtUZiDpam7ygg&index=2', 'https://www.youtube.com/watch?v=w5dOALbZ9HE&list=PLjgj6kdf_snYBkIsWQYcYtUZiDpam7ygg&index=3', 0, 1),
(10, 'Learn to code in Ruby!', 'Ruby', '2023-06-21', '2023-11-21', 1, 'https://www.youtube.com/watch?v=UU09eguVzFE&list=PL6SEI86zExmsdxwsyEQcFpF9DWmvttPPu', 'https://www.youtube.com/watch?v=BblDZc_Q_Ug&list=PL6SEI86zExmsdxwsyEQcFpF9DWmvttPPu&index=2', 'https://www.youtube.com/watch?v=6VARmwz2QPY&list=PL6SEI86zExmsdxwsyEQcFpF9DWmvttPPu&index=3', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(100) NOT NULL,
  `av_course_fk` int(100) NOT NULL,
  `instructor_fk` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `av_course_fk`, `instructor_fk`) VALUES
(1, 3, 1),
(2, 8, 2),
(3, 9, 3),
(4, 7, 4),
(5, 5, 1),
(6, 4, 2),
(7, 1, 4),
(8, 6, 3);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedb_id` int(100) NOT NULL,
  `user_feedb` varchar(255) NOT NULL,
  `course_fk` int(100) NOT NULL,
  `student_fk` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedb_id`, `user_feedb`, `course_fk`, `student_fk`) VALUES
(1, "The instructor explained programming concepts clearly, and the course materials were helpful. I feel more confident in my coding abilities now.", 3, 3),
(2, "I found the programming course engaging and the interactive coding sessions helpful in understanding the topics better.", 5, 4),
(3, "I enrolled in the Python course to enhance my programming skills, and it delivered on that front. The course content was well-organized and covered a wide range of Python topics.", 2, 5),
(4, "The Swift course gave me a solid understanding of the language syntax and core concepts. Now, I am ready to build my first iOS app!", 4, 2),
(5, "I\'m grateful for the Java course I took. It gave me a strong foundation in object-oriented programming and taught me how to write clean and efficient Java code.", 1, 1),
(6, "I found the computer network course to be comprehensive and well-structured. The instructor\'s explanations were clear, and the course materials were informative. It greatly improved my understanding of network architecture and troubleshooting.", 6, 7),
(7, "I highly recommend the R programming course to anyone interested in data science. The instructor\'s explanations were clear, and the course covered a wide range of topics, including data manipulation, statistical analysis, and data visualization using R.", 7, 6);

-- --------------------------------------------------------

--
-- Table structure for table `instructor`
--

CREATE TABLE `instructor` (
  `instructor_id` int(100) NOT NULL,
  `fname` varchar(32) NOT NULL,
  `lname` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instructor`
--

INSERT INTO `instructor` (`instructor_id`, `fname`, `lname`, `email`, `password`) VALUES
(-1, 'Temporary', 'Instructor', 'temp@skilltogo.com', 'temp123'),
(1, 'Iman', 'Zailani', 'iman@skilltogo.com', 'iman123'),
(2, 'Brad', 'Pitt', 'brad@skilltogo.com', 'brad123'),
(3, 'Steve', 'Jobs', 'steve@skilltogo.com', 'steve123'),
(4, 'James', 'Bond', 'james@skilltogo.com', 'james123');

-- --------------------------------------------------------

--
-- Table structure for table `my_course`
--

CREATE TABLE `my_course` (
  `course_fk` int(100) NOT NULL,
  `student_fk` int(100) NOT NULL,
  `progress` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `my_course`
--

INSERT INTO `my_course` (`course_fk`, `student_fk`, `progress`) VALUES
(1, 1, 100),
(4, 1, 100),
(3, 3, 100),
(4, 2, 100),
(5, 4, 35),
(2, 5, 35),
(7, 6, 100),
(6, 7, 100),
(5, 1, 35),
(2, 1, 35);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(100) NOT NULL,
  `fname` varchar(32) NOT NULL,
  `lname` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `fname`, `lname`, `email`, `password`) VALUES
(1, 'Adlina', 'Amir', 'dina@skilltogo.com', 'dina123'),
(2, 'Luke', 'Skywalker', 'luke@skilltogo.com', 'luke123'),
(3, 'Peter', 'Parker', 'peter@skilltogo.com', 'peter123'),
(4, 'Troye', 'Sivan', 'troye@skilltogo.com', 'troye123'),
(5, 'Sam', 'Smith', 'sam@skilltogo.com', 'sam123'),
(6, 'Jaden', 'Smith', 'jaden@skilltogo.com', 'jaden123'),
(7, 'Conan', 'Gray', 'conan@skilltogo.com', 'conan123');

-- --------------------------------------------------------

--
-- Table structure for table `training_provider`
--

CREATE TABLE `training_provider` (
  `tp_id` int(100) NOT NULL,
  `fname` varchar(32) NOT NULL,
  `lname` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `training_provider`
--

INSERT INTO `training_provider` (`tp_id`, `fname`, `lname`, `email`, `password`) VALUES
(1, 'Lewis', 'Hammilton', 'lewis@skilltogo.com', 'lewis123'),
(2, 'Tony', 'Stark', 'tony@skilltogo.com', 'tony123'),
(3, 'Harry', 'Potter', 'harry@skilltogo.com', 'harry123'),
(4, 'Taylor', 'Swift', 'tailor@skilltogo.com', 'tailor123');

-- --------------------------------------------------------
--
-- Indexes for table `available_course`
--
ALTER TABLE `available_course`
  ADD PRIMARY KEY (`av_course_id`),
  ADD KEY `instructor_fk` (`instructor_fk`),
  ADD KEY `tp_fk` (`tp_fk`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `instructor_fk` (`instructor_fk`),
  ADD KEY `av_course_fk` (`av_course_fk`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedb_id`),
  ADD KEY `course_fk` (`course_fk`),
  ADD KEY `student_fk` (`student_fk`);

--
-- Indexes for table `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`instructor_id`);

--
-- Indexes for table `my_course`
--
ALTER TABLE `my_course`
  ADD KEY `course_fk` (`course_fk`),
  ADD KEY `student_fk` (`student_fk`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `training_provider`
--
ALTER TABLE `training_provider`
  ADD PRIMARY KEY (`tp_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `available_course`
--
ALTER TABLE `available_course`
  MODIFY `av_course_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `course_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedb_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `instructor`
--
ALTER TABLE `instructor`
  MODIFY `instructor_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `training_provider`
--
ALTER TABLE `training_provider`
  MODIFY `tp_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `available_course`
--
ALTER TABLE `available_course`
  ADD CONSTRAINT `available_course_ibfk_1` FOREIGN KEY (`instructor_fk`) REFERENCES `instructor` (`instructor_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `available_course_ibfk_2` FOREIGN KEY (`tp_fk`) REFERENCES `training_provider` (`tp_id`) ON UPDATE CASCADE;

--
-- Constraints for table `course`
--
ALTER TABLE `course`
  ADD CONSTRAINT `course_ibfk_1` FOREIGN KEY (`instructor_fk`) REFERENCES `instructor` (`instructor_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `course_ibfk_2` FOREIGN KEY (`av_course_fk`) REFERENCES `available_course` (`av_course_id`) ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`student_fk`) REFERENCES `student` (`student_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_3` FOREIGN KEY (`course_fk`) REFERENCES `course` (`course_id`) ON UPDATE CASCADE;

--
-- Constraints for table `my_course`
--
ALTER TABLE `my_course`
  ADD CONSTRAINT `my_course_ibfk_2` FOREIGN KEY (`student_fk`) REFERENCES `student` (`student_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `my_course_ibfk_3` FOREIGN KEY (`course_fk`) REFERENCES `course` (`course_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 22, 2017 at 10:13 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `egn_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `egn_admin_login`
--

CREATE TABLE `egn_admin_login` (
  `id` int(11) NOT NULL,
  `username` varchar(5) NOT NULL,
  `passwd` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_attendance`
--

CREATE TABLE `egn_attendance` (
  `id` int(11) NOT NULL,
  `date_of_attendance` date NOT NULL,
  `timetable_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_batch`
--

CREATE TABLE `egn_batch` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_batch`
--

INSERT INTO `egn_batch` (`id`, `name`, `branch_id`) VALUES
(2, 'Batch 1', 10),
(3, 'Batch 1', 11),
(4, 'Batch 2', 10),
(7, '\'Test\'', 10);

-- --------------------------------------------------------

--
-- Table structure for table `egn_branch`
--

CREATE TABLE `egn_branch` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_branch`
--

INSERT INTO `egn_branch` (`id`, `name`) VALUES
(10, 'Information Technology'),
(11, 'Computer Engineering'),
(12, 'EXTC'),
(13, 'ETRX');

-- --------------------------------------------------------

--
-- Table structure for table `egn_course`
--

CREATE TABLE `egn_course` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `batch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_course`
--

INSERT INTO `egn_course` (`id`, `name`, `batch_id`) VALUES
(1, 'Course 1', 2),
(2, 'Course 2', 3),
(3, 'Test', 7),
(4, 'Test', 2);

-- --------------------------------------------------------

--
-- Table structure for table `egn_course_reg`
--

CREATE TABLE `egn_course_reg` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_course_reg`
--

INSERT INTO `egn_course_reg` (`id`, `student_id`, `course_id`) VALUES
(3, 3, 1),
(4, 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `egn_notes`
--

CREATE TABLE `egn_notes` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `file` varchar(100) NOT NULL,
  `course_id` int(11) NOT NULL,
  `downloadable` varchar(3) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_noticeboard`
--

CREATE TABLE `egn_noticeboard` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `notice` varchar(500) NOT NULL,
  `file` varchar(128) DEFAULT NULL,
  `urgent_notice` varchar(3) NOT NULL,
  `type` varchar(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_noticeboard`
--

INSERT INTO `egn_noticeboard` (`id`, `title`, `notice`, `file`, `urgent_notice`, `type`, `user_id`) VALUES
(1, 'Test Title', 'ksjdbfsjk', '../uploads/bill.pdf', '', '1', 2),
(2, 'Test Title', 'ksjdbfsjk', '../uploads/bill.pdf', '', '2', 2),
(3, 'wqr', 'qrqwr', '../uploads/asd.txt', '', '10', 2),
(4, 'wqr', 'qrqwr', '../uploads/asd.txt', '', '11', 2),
(5, 'wqr', 'qrqwr', '../uploads/asd.txt', '', '12', 2),
(6, 'wqr', 'qrqwr', '../uploads/', '', '10', 2),
(7, 'wqr', 'qrqwr', '../uploads/asd.txt', '', '10', 2),
(8, 'wqr', 'qrqwr', '../uploads/asd.txt', 'u', '10', 2),
(9, 'wqr', 'qrqwr', '../uploads/', '', '11', 2),
(10, 'wqr', 'qrqwr', '../uploads/', '', '11', 2),
(11, 'wqr', 'qrqwr', '../uploads/', '', '11', 2),
(12, 'wqr', 'qrqwr', '../uploads/', '', '11', 2),
(13, 'wqr', 'qrqwr', '../uploads/', '', '11', 2),
(14, 'wqr', 'qrqwr', '', '', '11', 2),
(15, 'wqr', 'qrqwr', '', '', '11', 2),
(16, 'wqrnir', 'qrqwr', '', '', 'c', 2),
(17, 'Nir', 'rqr', '', '', 'c', 2),
(18, 'Nirwqrqre', 'q3tq33q', '', '', 'c', 2),
(19, 'Nirwqrqre', 'q3tq33q', '', '', 'c', 2),
(20, 'Nirwqrqre', 'q3tq33q', '', '', '12', 2),
(21, 'Nirwqrqre', 'q3tq33q', '', '', '10', 2),
(22, 'Nirwqrqre', 'q3tq33q', '', '', '12', 2),
(23, 'Nirwqrqre', 'q3tq33q', '../uploads/M5L0QT.jpg', '', '10', 2),
(24, 'Nirwqrqre', 'q3tq33q', '../uploads/M5L0QT.jpg', '', '12', 2),
(25, 'asdaNNNNNNNNNN', 'dqwdqw', '../uploads/', 'u', 'c', 2);

-- --------------------------------------------------------

--
-- Table structure for table `egn_privilege`
--

CREATE TABLE `egn_privilege` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `folder` varchar(60) NOT NULL,
  `dashboard_name` varchar(60) NOT NULL,
  `admin_level` varchar(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_privilege`
--

INSERT INTO `egn_privilege` (`id`, `name`, `folder`, `dashboard_name`, `admin_level`) VALUES
(1, 'Add / Update Notes', 'manage_notes', 'Notes', 'N'),
(2, 'View Notes', 'manage_notes', 'Notes', 'N'),
(3, 'Delete Notes', 'manage_notes', 'Notes', 'N'),
(4, 'Add / Update Submission', 'manage_submission', 'Submissions', 'N'),
(5, 'View Submissions', 'manage_submission', 'Submissions', 'N'),
(6, 'Delete Submissions', 'manage_submission', 'Submissions', 'N'),
(7, 'View Submissions Report', 'manage_submission', 'Submissions', 'N'),
(8, 'Add / Update Tests', 'manage_test', 'Tests', 'N'),
(9, 'View Tests', 'manage_test', 'Tests', 'N'),
(10, 'Delete Tests', 'manage_test', 'Tests', 'N'),
(11, 'View Result', 'manage_result', 'Result', 'N'),
(12, 'Add / Update Result', 'manage_result', 'Result', 'N'),
(13, 'Delete Result', 'manage_result', 'Result', 'N'),
(14, 'Add / Update Timetable', 'manage_timetable', 'Timetable', 'N'),
(15, 'View Timetable', 'manage_timetable', 'Timetable', 'N'),
(16, 'Add Syllabus', 'manage_syllabus', 'Syllabus', 'N'),
(17, 'View Syllabus', 'manage_syllabus', 'Syllabus', 'N'),
(18, 'Delete Syllabus', 'manage_syllabus', 'Syllabus', 'N'),
(19, 'Add / Update Attendance', 'manage_attendance', 'Attendance', 'N'),
(20, 'Delete Attendance', 'manage_attendance', 'Attendance', 'N'),
(21, 'View / Generate Attendance Reports', 'manage_attendance', 'Attendance', 'N'),
(22, 'Delete Discussion Thread', 'discussion_forum', 'Discussion Forum', 'N'),
(23, 'Discussion Forum', 'discussion_forum', 'Discussion Forum', 'N'),
(24, 'Add / Update Notice', 'manage_noticeboard', 'Noticeboard', 'N'),
(25, 'View Notice Board', 'manage_noticeboard', 'Noticeboard', 'N'),
(26, 'Delete Notice', 'manage_noticeboard', 'Noticeboard', 'N'),
(29, 'View Suggestions and Complaints', 'manage_suggestions', 'Suggestions and Complaints', 'N'),
(30, 'Give Suggestions and Compliants', 'manage_suggestions', 'Suggestions and Complaints', 'N'),
(31, 'Manage Branch', 'manage_branch', 'Manage Branch', 'Y'),
(32, 'Manage Batch', 'manage_batch', 'Manage Batch', 'Y'),
(33, 'Manage Course', 'manage_course', 'Manage Course', 'Y'),
(34, 'Manage Users', 'manage_user', 'Manage Users', 'Y'),
(35, 'Manage Students', 'manage_student', 'Manage Students', 'Y'),
(36, 'Manage Role', 'manage_role', 'Manage Role', 'Y'),
(37, 'Manage Fees', 'manage_fees', 'Manage Fees', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `egn_role`
--

CREATE TABLE `egn_role` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `is_teacher` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_role`
--

INSERT INTO `egn_role` (`id`, `name`, `is_teacher`) VALUES
(1, 'Student', 0),
(2, 'Teacher', 1),
(3, 'Parent', 0),
(7, 'Test Role', 0),
(8, 'Test Role 2', 0),
(9, 'Admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `egn_role_privilege`
--

CREATE TABLE `egn_role_privilege` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `privilege_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_role_privilege`
--

INSERT INTO `egn_role_privilege` (`id`, `role_id`, `privilege_id`) VALUES
(1, 2, 1),
(2, 2, 2),
(3, 2, 3),
(4, 2, 4),
(5, 2, 5),
(6, 2, 6),
(7, 2, 7),
(8, 2, 8),
(9, 2, 9),
(10, 2, 10),
(11, 2, 11),
(12, 2, 12),
(13, 2, 13),
(14, 2, 15),
(15, 2, 16),
(16, 2, 17),
(17, 2, 18),
(18, 2, 19),
(19, 2, 20),
(20, 2, 22),
(21, 2, 23),
(22, 2, 25),
(23, 1, 2),
(24, 1, 5),
(25, 1, 9),
(26, 1, 11),
(27, 1, 15),
(28, 1, 17),
(29, 1, 23),
(30, 1, 25),
(31, 1, 30),
(32, 2, 22),
(33, 3, 7),
(34, 3, 11),
(35, 3, 15),
(36, 3, 17),
(37, 3, 21),
(66, 8, 19),
(68, 8, 1),
(69, 8, 29),
(70, 8, 17),
(71, 8, 9),
(72, 8, 15),
(90, 9, 31),
(91, 9, 32),
(92, 9, 33),
(93, 9, 34),
(94, 9, 35),
(95, 9, 36),
(96, 7, 1),
(97, 7, 2),
(98, 7, 3),
(99, 7, 4),
(100, 7, 5),
(101, 7, 6),
(102, 7, 7),
(103, 7, 8),
(104, 7, 9),
(105, 7, 10),
(106, 7, 11),
(107, 7, 12),
(108, 7, 13),
(109, 7, 14),
(110, 7, 15),
(111, 7, 16),
(112, 7, 17),
(113, 7, 18),
(114, 7, 19),
(115, 7, 20),
(116, 7, 21),
(117, 7, 22),
(118, 7, 23),
(119, 7, 24),
(120, 7, 25),
(121, 7, 26),
(124, 7, 29),
(125, 7, 30),
(126, 9, 37);

-- --------------------------------------------------------

--
-- Table structure for table `egn_student`
--

CREATE TABLE `egn_student` (
  `id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `student_passwd` varchar(15) DEFAULT NULL,
  `mobile` bigint(15) DEFAULT NULL,
  `gender` varchar(1) DEFAULT NULL,
  `parent_name` varchar(30) DEFAULT NULL,
  `parent_email` varchar(30) DEFAULT NULL,
  `parent_passwd` varchar(15) DEFAULT NULL,
  `total_fees` int(10) NOT NULL,
  `fees_paid` int(15) DEFAULT NULL,
  `fees_comment` varchar(50) DEFAULT NULL,
  `date_of_admission` date DEFAULT NULL,
  `parent_mobile` bigint(12) NOT NULL,
  `student_profile_photo` varchar(100) DEFAULT NULL,
  `parent_profile_photo` varchar(100) DEFAULT NULL,
  `batch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_student`
--

INSERT INTO `egn_student` (`id`, `firstname`, `lastname`, `email`, `student_passwd`, `mobile`, `gender`, `parent_name`, `parent_email`, `parent_passwd`, `total_fees`, `fees_paid`, `fees_comment`, `date_of_admission`, `parent_mobile`, `student_profile_photo`, `parent_profile_photo`, `batch_id`) VALUES
(3, 'Badal', 'Kotak', 'badalkotak@gmail.com', 'v2DV', 9769766016, 'M', 'Manoj', 'mkotak@gmail.com', 'P0f7', 10000, 0, '--', '2017-11-25', 9820003397, 'EGyaan_OpenSource/Resources/images/boy.png', 'EGyaan_OpenSource/Resources/images/boy.png', 2);

-- --------------------------------------------------------

--
-- Table structure for table `egn_student_attendance`
--

CREATE TABLE `egn_student_attendance` (
  `id` int(11) NOT NULL,
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `attended` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_submissions`
--

CREATE TABLE `egn_submissions` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `file` varchar(100) NOT NULL,
  `date_of_submission` date NOT NULL,
  `date_of_upload` date NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_suggestion_complaint`
--

CREATE TABLE `egn_suggestion_complaint` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` varchar(500) NOT NULL,
  `type` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_suggestion_complaint`
--

INSERT INTO `egn_suggestion_complaint` (`id`, `title`, `description`, `type`) VALUES
(2, 'Nir', 'This is nir', 'c'),
(3, 'Hello', 'tesing', 'c'),
(4, 'asf', 'sus', 's');

-- --------------------------------------------------------

--
-- Table structure for table `egn_syllabus`
--

CREATE TABLE `egn_syllabus` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `file` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_teacher_course`
--

CREATE TABLE `egn_teacher_course` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_teacher_course`
--

INSERT INTO `egn_teacher_course` (`id`, `user_id`, `course_id`) VALUES
(1, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `egn_test`
--

CREATE TABLE `egn_test` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `total_marks` int(5) NOT NULL,
  `date_of_test` date NOT NULL,
  `date_of_result` date DEFAULT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_test_marks`
--

CREATE TABLE `egn_test_marks` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `marks` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_timetable`
--

CREATE TABLE `egn_timetable` (
  `id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `time_id` int(11) NOT NULL,
  `teacher_course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_time_timetable`
--

CREATE TABLE `egn_time_timetable` (
  `id` int(11) NOT NULL,
  `from_time` time NOT NULL,
  `to_time` time NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_time_type`
--

CREATE TABLE `egn_time_type` (
  `id` int(11) NOT NULL,
  `name` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_time_type`
--

INSERT INTO `egn_time_type` (`id`, `name`) VALUES
(2, 'Break'),
(1, 'Lecture');

-- --------------------------------------------------------

--
-- Table structure for table `egn_users`
--

CREATE TABLE `egn_users` (
  `id` int(11) NOT NULL,
  `email` varchar(150) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `mobile` bigint(15) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_users`
--

INSERT INTO `egn_users` (`id`, `email`, `passwd`, `role_id`, `gender`, `mobile`, `name`) VALUES
(1, 'badal.k@somaiya.edu', 'efHm', 7, 'M', 9769766016, 'Badal Kotak'),
(2, 'admin@e-gyaan.in', 'admin123', 9, 'M', 9820003397, 'Admin'),
(3, 't@gmail.com', 't123', 2, 'M', 92374938759, 'Teacher 1');

-- --------------------------------------------------------

--
-- Table structure for table `egn_user_role`
--

CREATE TABLE `egn_user_role` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `egn_admin_login`
--
ALTER TABLE `egn_admin_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `egn_attendance`
--
ALTER TABLE `egn_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timetable_id` (`timetable_id`);

--
-- Indexes for table `egn_batch`
--
ALTER TABLE `egn_batch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branchId` (`branch_id`);

--
-- Indexes for table `egn_branch`
--
ALTER TABLE `egn_branch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `egn_course`
--
ALTER TABLE `egn_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `egn_course_reg`
--
ALTER TABLE `egn_course_reg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `egn_notes`
--
ALTER TABLE `egn_notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `addedby_user_id` (`user_id`);

--
-- Indexes for table `egn_noticeboard`
--
ALTER TABLE `egn_noticeboard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addedby_user_id` (`user_id`);

--
-- Indexes for table `egn_privilege`
--
ALTER TABLE `egn_privilege`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `egn_role`
--
ALTER TABLE `egn_role`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `egn_role_privilege`
--
ALTER TABLE `egn_role_privilege`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `privilege_id` (`privilege_id`);

--
-- Indexes for table `egn_student`
--
ALTER TABLE `egn_student`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batch_id` (`batch_id`);

--
-- Indexes for table `egn_student_attendance`
--
ALTER TABLE `egn_student_attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_id` (`attendance_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `egn_submissions`
--
ALTER TABLE `egn_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `egn_suggestion_complaint`
--
ALTER TABLE `egn_suggestion_complaint`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `egn_syllabus`
--
ALTER TABLE `egn_syllabus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `egn_syllabus_ibfk_1` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `egn_teacher_course`
--
ALTER TABLE `egn_teacher_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `egn_test`
--
ALTER TABLE `egn_test`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `egn_test_marks`
--
ALTER TABLE `egn_test_marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `egn_timetable`
--
ALTER TABLE `egn_timetable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `time_id` (`time_id`),
  ADD KEY `teacher_course_id` (`teacher_course_id`);

--
-- Indexes for table `egn_time_timetable`
--
ALTER TABLE `egn_time_timetable`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `egn_time_type`
--
ALTER TABLE `egn_time_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `egn_users`
--
ALTER TABLE `egn_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `passwd` (`passwd`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `egn_user_role`
--
ALTER TABLE `egn_user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `egn_admin_login`
--
ALTER TABLE `egn_admin_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_attendance`
--
ALTER TABLE `egn_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_batch`
--
ALTER TABLE `egn_batch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `egn_branch`
--
ALTER TABLE `egn_branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `egn_course`
--
ALTER TABLE `egn_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `egn_course_reg`
--
ALTER TABLE `egn_course_reg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `egn_notes`
--
ALTER TABLE `egn_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_noticeboard`
--
ALTER TABLE `egn_noticeboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `egn_privilege`
--
ALTER TABLE `egn_privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `egn_role`
--
ALTER TABLE `egn_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `egn_role_privilege`
--
ALTER TABLE `egn_role_privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT for table `egn_student`
--
ALTER TABLE `egn_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `egn_student_attendance`
--
ALTER TABLE `egn_student_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_submissions`
--
ALTER TABLE `egn_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_suggestion_complaint`
--
ALTER TABLE `egn_suggestion_complaint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `egn_syllabus`
--
ALTER TABLE `egn_syllabus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_teacher_course`
--
ALTER TABLE `egn_teacher_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `egn_test`
--
ALTER TABLE `egn_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_test_marks`
--
ALTER TABLE `egn_test_marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_timetable`
--
ALTER TABLE `egn_timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_time_timetable`
--
ALTER TABLE `egn_time_timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_time_type`
--
ALTER TABLE `egn_time_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `egn_users`
--
ALTER TABLE `egn_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `egn_user_role`
--
ALTER TABLE `egn_user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `egn_attendance`
--
ALTER TABLE `egn_attendance`
  ADD CONSTRAINT `egn_attendance_ibfk_1` FOREIGN KEY (`timetable_id`) REFERENCES `egn_timetable` (`id`);

--
-- Constraints for table `egn_batch`
--
ALTER TABLE `egn_batch`
  ADD CONSTRAINT `egn_batch_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `egn_branch` (`id`);

--
-- Constraints for table `egn_course`
--
ALTER TABLE `egn_course`
  ADD CONSTRAINT `egn_course_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `egn_batch` (`id`);

--
-- Constraints for table `egn_course_reg`
--
ALTER TABLE `egn_course_reg`
  ADD CONSTRAINT `egn_course_reg_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `egn_student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `egn_course_reg_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `egn_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `egn_notes`
--
ALTER TABLE `egn_notes`
  ADD CONSTRAINT `egn_notes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `egn_course` (`id`),
  ADD CONSTRAINT `egn_notes_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `egn_users` (`id`);

--
-- Constraints for table `egn_noticeboard`
--
ALTER TABLE `egn_noticeboard`
  ADD CONSTRAINT `egn_noticeboard_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `egn_users` (`id`);

--
-- Constraints for table `egn_role_privilege`
--
ALTER TABLE `egn_role_privilege`
  ADD CONSTRAINT `egn_role_privilege_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `egn_role` (`id`),
  ADD CONSTRAINT `egn_role_privilege_ibfk_2` FOREIGN KEY (`privilege_id`) REFERENCES `egn_privilege` (`id`);

--
-- Constraints for table `egn_student`
--
ALTER TABLE `egn_student`
  ADD CONSTRAINT `egn_student_ibfk_1` FOREIGN KEY (`batch_id`) REFERENCES `egn_batch` (`id`);

--
-- Constraints for table `egn_student_attendance`
--
ALTER TABLE `egn_student_attendance`
  ADD CONSTRAINT `egn_student_attendance_ibfk_1` FOREIGN KEY (`attendance_id`) REFERENCES `egn_attendance` (`id`),
  ADD CONSTRAINT `egn_student_attendance_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `egn_student` (`id`);

--
-- Constraints for table `egn_submissions`
--
ALTER TABLE `egn_submissions`
  ADD CONSTRAINT `egn_submissions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `egn_users` (`id`),
  ADD CONSTRAINT `egn_submissions_ibfk_3` FOREIGN KEY (`course_id`) REFERENCES `egn_course` (`id`);

--
-- Constraints for table `egn_syllabus`
--
ALTER TABLE `egn_syllabus`
  ADD CONSTRAINT `egn_syllabus_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `egn_course` (`id`),
  ADD CONSTRAINT `egn_syllabus_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `egn_users` (`id`);

--
-- Constraints for table `egn_teacher_course`
--
ALTER TABLE `egn_teacher_course`
  ADD CONSTRAINT `egn_teacher_course_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `egn_users` (`id`),
  ADD CONSTRAINT `egn_teacher_course_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `egn_course` (`id`);

--
-- Constraints for table `egn_test`
--
ALTER TABLE `egn_test`
  ADD CONSTRAINT `egn_test_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `egn_course` (`id`),
  ADD CONSTRAINT `egn_test_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `egn_users` (`id`);

--
-- Constraints for table `egn_test_marks`
--
ALTER TABLE `egn_test_marks`
  ADD CONSTRAINT `egn_test_marks_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `egn_test` (`id`),
  ADD CONSTRAINT `egn_test_marks_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `egn_student` (`id`);

--
-- Constraints for table `egn_timetable`
--
ALTER TABLE `egn_timetable`
  ADD CONSTRAINT `egn_timetable_ibfk_1` FOREIGN KEY (`time_id`) REFERENCES `egn_time_type` (`id`),
  ADD CONSTRAINT `egn_timetable_ibfk_2` FOREIGN KEY (`teacher_course_id`) REFERENCES `egn_teacher_course` (`id`);

--
-- Constraints for table `egn_time_timetable`
--
ALTER TABLE `egn_time_timetable`
  ADD CONSTRAINT `egn_time_timetable_ibfk_2` FOREIGN KEY (`type`) REFERENCES `egn_time_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `egn_users`
--
ALTER TABLE `egn_users`
  ADD CONSTRAINT `egn_users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `egn_role` (`id`);

--
-- Constraints for table `egn_user_role`
--
ALTER TABLE `egn_user_role`
  ADD CONSTRAINT `egn_user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `egn_users` (`id`),
  ADD CONSTRAINT `egn_user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `egn_role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

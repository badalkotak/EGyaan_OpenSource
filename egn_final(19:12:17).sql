-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 19, 2017 at 08:43 AM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(7, '''Test''', 10),
(8, 'Test 123', 10);

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
(1, 'Course 1 - IT', 2),
(3, 'Test', 7),
(5, 'Course 2 - IT', 2),
(6, 'Course 4', 2),
(7, 'Course 5', 2),
(8, 'Course 3 - IT', 2);

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
(7, 6, 1),
(8, 6, 5),
(9, 7, 1),
(10, 5, 1),
(11, 5, 5),
(12, 3, 8),
(13, 7, 5),
(14, 7, 8);

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

--
-- Dumping data for table `egn_notes`
--

INSERT INTO `egn_notes` (`id`, `title`, `file`, `course_id`, `downloadable`, `user_id`) VALUES
(4, 'Chapter 1', 'uploads/59c7586ad6a99Chapter1.pdf', 1, 'Yes', 1),
(5, 'Chapter 2', 'uploads/59c7588b7c5e3Chapter2.pdf', 1, 'No', 1),
(7, 'Chapter 1', 'uploads/5a34fc5961dfaConsent_form_for_students_and_parents-1.pdf', 6, 'No', 4),
(8, 'Chapter 2', 'uploads/5a34fc7ad0984Presentation.ppt', 6, 'No', 4);

-- --------------------------------------------------------

--
-- Table structure for table `egn_noticeboard`
--

CREATE TABLE `egn_noticeboard` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `notice` varchar(2000) NOT NULL,
  `file` varchar(128) DEFAULT NULL,
  `urgent_notice` varchar(3) NOT NULL,
  `type` varchar(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notice_date` date NOT NULL,
  `notice_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_noticeboard`
--

INSERT INTO `egn_noticeboard` (`id`, `title`, `notice`, `file`, `urgent_notice`, `type`, `user_id`, `notice_date`, `notice_time`) VALUES
(242, 'csa', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop p Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop pLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop pLorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop ', '', '', '10', 2, '2017-07-14', '15:06:35'),
(243, 'csa', 'csacs', '', '', '11', 2, '2017-07-14', '15:06:35'),
(244, 'fsa', 'fs', '', '', '11', 2, '2017-07-14', '15:12:14'),
(245, 'fsa', 'saf', '', '', '11', 2, '2017-07-14', '15:13:55'),
(246, 'fsa', 'saf', '', '', '10', 2, '2017-07-14', '15:18:31'),
(247, 'sccs', 'cs', '', '', '10', 2, '2017-07-14', '15:49:59'),
(248, 'sccs', 'cs', '', '', '11', 2, '2017-07-14', '15:50:06'),
(249, 'ss', 'ss', '', 'u', '10', 2, '2017-08-11', '21:57:14'),
(250, 'ss', 'ss', '', 'u', '10', 2, '2017-08-11', '21:57:40'),
(251, 'saffs', 'saf', '', '', '10', 2, '2017-08-11', '22:14:12'),
(252, 'saffs', 'saf', '', '', '10', 2, '2017-08-11', '22:14:14'),
(253, 'saffs', 'saffsaf', '', '', '10', 2, '2017-08-11', '22:14:17'),
(254, 'fsaf', 'afs', '', '', '10', 2, '2017-08-11', '22:14:24'),
(255, 'm', 'kk', '', '', '12', 2, '2017-08-11', '22:54:28'),
(256, 'm', 'kk', '', '', '10', 2, '2017-08-11', '22:54:36'),
(257, 'm', 'kk', '', '', '12', 2, '2017-08-11', '22:54:36'),
(258, 'm', 'kk', '', '', '12', 2, '2017-08-11', '22:54:43'),
(259, 'm', 'm', '', '', '10', 2, '2017-08-11', '22:56:11'),
(260, 'afsasf', 'asf', '', '', '10', 2, '2017-08-11', '23:00:14'),
(261, 'Common Notice', 'Common Notice', '', '', 'c', 2, '2017-11-16', '12:26:20'),
(262, 'saf', 'saffsa', '', '', 'c', 2, '2017-11-16', '12:26:21'),
(263, 'saf', 'saffsa', '', '', 'c', 2, '2017-11-16', '12:26:22'),
(264, 'saf', 'saffsa', '', '', 'c', 2, '2017-11-16', '12:26:22'),
(265, 'saf', 'saffsa', '', '', 'c', 2, '2017-11-16', '12:26:22'),
(266, 'saf', 'saffsa', '', '', 'c', 2, '2017-11-16', '12:26:22'),
(267, 'saf', 'saffsa', '', '', 'c', 2, '2017-11-16', '12:26:38');

-- --------------------------------------------------------

--
-- Table structure for table `egn_privilege`
--

CREATE TABLE `egn_privilege` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `folder` varchar(60) NOT NULL,
  `dashboard_name` varchar(60) NOT NULL,
  `admin_level` varchar(1) NOT NULL DEFAULT 'N',
  `course_needed` varchar(1) NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_privilege`
--

INSERT INTO `egn_privilege` (`id`, `name`, `folder`, `dashboard_name`, `admin_level`, `course_needed`) VALUES
(1, 'Add / Update Notes', 'manage_notes', 'Notes', 'N', 'Y'),
(2, 'View Notes', 'manage_notes', 'Notes', 'N', 'Y'),
(3, 'Delete Notes', 'manage_notes', 'Notes', 'N', 'Y'),
(4, 'Add / Update Submission', 'manage_submission', 'Submissions', 'N', 'Y'),
(5, 'View Submissions', 'manage_submission', 'Submissions', 'N', 'Y'),
(6, 'Delete Submissions', 'manage_submission', 'Submissions', 'N', 'Y'),
(7, 'View Submissions Report', 'manage_submission', 'Submissions', 'N', 'Y'),
(8, 'Add / Update Tests', 'manage_test', 'Tests', 'N', 'Y'),
(9, 'View Tests', 'manage_test', 'Tests', 'N', 'Y'),
(10, 'Delete Tests', 'manage_test', 'Tests', 'N', 'Y'),
(11, 'View Result', 'manage_result', 'Result', 'N', 'Y'),
(12, 'Add / Update Result', 'manage_result', 'Result', 'N', 'Y'),
(13, 'Delete Result', 'manage_result', 'Result', 'N', 'Y'),
(14, 'Add / Update Timetable', 'manage_timetable', 'Timetable', 'N', 'N'),
(15, 'View Timetable', 'manage_timetable', 'Timetable', 'N', 'N'),
(16, 'Add Syllabus', 'manage_syllabus', 'Syllabus', 'N', 'Y'),
(17, 'View Syllabus', 'manage_syllabus', 'Syllabus', 'N', 'Y'),
(18, 'Delete Syllabus', 'manage_syllabus', 'Syllabus', 'N', 'Y'),
(19, 'Add / Update Attendance', 'manage_attendance', 'Attendance', 'N', 'Y'),
(20, 'Delete Attendance', 'manage_attendance', 'Attendance', 'N', 'Y'),
(21, 'View / Generate Attendance Reports', 'manage_attendance', 'Attendance', 'N', 'Y'),
(22, 'Delete Discussion Thread', 'discussion_forum', 'Discussion Forum', 'N', 'Y'),
(23, 'Discussion Forum', 'discussion_forum', 'Discussion Forum', 'N', 'Y'),
(24, 'Add / Update Notice', 'manage_noticeboard', 'Noticeboard', 'N', 'N'),
(25, 'View Notice Board', 'manage_noticeboard', 'Noticeboard', 'N', 'N'),
(26, 'Delete Notice', 'manage_noticeboard', 'Noticeboard', 'N', 'N'),
(29, 'View Suggestions and Complaints', 'manage_suggestions', 'Suggestions and Complaints', 'N', 'N'),
(30, 'Give Suggestions and Compliants', 'manage_suggestions', 'Suggestions and Complaints', 'N', 'N'),
(31, 'Manage Branch', 'manage_branch', 'Manage Branch', 'Y', 'N'),
(32, 'Manage Batch', 'manage_batch', 'Manage Batch', 'Y', 'N'),
(33, 'Manage Course', 'manage_course', 'Manage Course', 'Y', 'N'),
(34, 'Manage Users', 'manage_user', 'Manage Users', 'Y', 'N'),
(35, 'Manage Students', 'manage_student', 'Manage Students', 'Y', 'N'),
(36, 'Manage Role', 'manage_role', 'Manage Role', 'Y', 'N'),
(37, 'Manage Fees', 'manage_fees', 'Manage Fees', 'Y', 'N');

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
(90, 9, 31),
(91, 9, 32),
(92, 9, 33),
(93, 9, 34),
(94, 9, 35),
(95, 9, 36),
(126, 9, 37),
(127, 9, 24),
(184, 7, 1),
(185, 7, 2),
(186, 7, 3),
(187, 7, 4),
(188, 7, 5),
(189, 7, 6),
(190, 7, 7),
(191, 7, 8),
(192, 7, 9),
(193, 7, 10),
(194, 7, 11),
(195, 7, 12),
(196, 7, 13),
(197, 7, 14),
(198, 7, 15),
(199, 7, 16),
(200, 7, 17),
(201, 7, 18),
(202, 7, 19),
(203, 7, 20),
(204, 7, 21),
(205, 7, 22),
(206, 7, 23),
(207, 7, 24),
(208, 7, 25),
(209, 7, 26),
(210, 7, 29),
(211, 7, 30);

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
(3, 'Badal', 'Kotak', 'badalkotak@gmail.com', 'bk123', 9769766016, 'M', 'Manoj', 'mkotak@gmail.com', 'P0f7', 10000, 3500, '--', '2017-11-25', 9820003397, '453118.jpg', '832903.png', 2),
(5, 'Nir', 'Jakharia', 'nj@gmail.com', '3yBT', 9283920192, 'M', 'Rasik', 'rj@gmail.com', '7ncf', 10000, 7500, '--', '2017-06-19', 8798765432, 'boy.png', 'boy.png', 2),
(6, 'Kamakshi', 'Thakkar', 'kt@gmail.com', 'SyqF', 9871028394, 'F', 'Jignesh', 'jt@gmail.com', 'cRJJ', 7500, 5000, '--', '2017-12-16', 9203948102, '859240.jpg', '414753.jpg', 2),
(7, 'Jignesh', 'Davda', 'jd@gmail.com', 'jEte', 9820391283, 'M', 'Arvind', 'ad@gmail.com', '4ivP', 5000, 5000, '--', '2017-12-16', 823032910, '701624.jpg', '237380.jpg', 2);

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

--
-- Dumping data for table `egn_submissions`
--

INSERT INTO `egn_submissions` (`id`, `title`, `file`, `date_of_submission`, `date_of_upload`, `user_id`, `course_id`) VALUES
(4, 'Assignment 1', 'uploads/594839e7b1b3degyaan.pdf', '2017-06-26', '2017-06-19', 3, 1);

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
(1, 3, 1),
(2, 3, 3),
(3, 5, 5),
(4, 5, 7),
(5, 4, 1),
(6, 4, 6),
(9, 6, 8);

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

--
-- Dumping data for table `egn_test`
--

INSERT INTO `egn_test` (`id`, `title`, `total_marks`, `date_of_test`, `date_of_result`, `course_id`, `user_id`, `type`) VALUES
(1, 'Test', 30, '2017-06-22', NULL, 1, 3, 'O'),
(3, 'Test 2', 20, '2017-06-22', NULL, 1, 3, 'F'),
(5, 'Assignment 1', 20, '2017-06-24', NULL, 1, 3, 'F'),
(6, 'Class', 20, '2017-09-24', NULL, 1, 1, 'O'),
(9, 'Chapter 1 Class Test', 30, '2017-12-16', NULL, 1, 4, 'F'),
(11, 'Chapter', 20, '2017-12-16', NULL, 1, 4, 'O');

-- --------------------------------------------------------

--
-- Table structure for table `egn_test_answers`
--

CREATE TABLE `egn_test_answers` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_test_answers`
--

INSERT INTO `egn_test_answers` (`id`, `student_id`, `question_id`, `option_id`) VALUES
(1, 3, 1, 1),
(2, 3, 2, 1),
(3, 3, 3, 3);

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

--
-- Dumping data for table `egn_test_marks`
--

INSERT INTO `egn_test_marks` (`id`, `student_id`, `test_id`, `marks`) VALUES
(1, 3, 1, 25),
(2, 3, 3, 15),
(3, 3, 5, 20),
(4, 3, 9, 15),
(5, 6, 9, 30),
(6, 7, 9, 20),
(7, 5, 9, 15);

-- --------------------------------------------------------

--
-- Table structure for table `egn_test_questions`
--

CREATE TABLE `egn_test_questions` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option1` varchar(30) NOT NULL,
  `option2` varchar(30) NOT NULL,
  `option3` varchar(30) DEFAULT NULL,
  `option4` varchar(30) DEFAULT NULL,
  `answer` int(11) NOT NULL,
  `marks` int(11) NOT NULL,
  `test_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_test_questions`
--

INSERT INTO `egn_test_questions` (`id`, `question`, `option1`, `option2`, `option3`, `option4`, `answer`, `marks`, `test_id`) VALUES
(1, 'Question 1', 'O1', 'O2', 'O3', 'O4', 1, 5, 1),
(2, 'QUESTION 2', 'O1', 'O2', 'O3', 'O4', 2, 5, 1),
(3, 'QUESTION 3', 'O1', 'O2', 'O3O', 'O4', 3, 20, 1),
(4, 'Question 1 ?', 'A', 'B', 'C', 'D', 1, 4, 6),
(5, 'Question 2 ?', 'A', 'B', 'C', 'D', 2, 4, 6),
(6, 'Question 3?', 'A', 'B', 'C', 'D', 3, 4, 6),
(7, 'Question 4 ?', 'A', 'B', 'C', 'D', 4, 4, 6),
(8, 'Question 5 ?', 'A', 'B', 'C', 'D', 1, 4, 6),
(9, 'What is a function ?', 'Option 1', 'Option 2', 'Option 3', 'Option 4', 1, 5, 11),
(10, 'What is an object ?', 'Option 1', 'Option 2', 'Option 3', 'Option 4', 2, 5, 11),
(11, 'What is an abstract class ?', 'Option 1', 'Option 2', 'Option 3', 'Option 4', 3, 5, 11),
(12, 'What is a class ?', 'Option 1', 'Option 2', 'Option 3', 'Option 4', 2, 5, 11);

-- --------------------------------------------------------

--
-- Table structure for table `egn_timetable`
--

CREATE TABLE `egn_timetable` (
  `id` int(11) NOT NULL,
  `day_id` int(11) NOT NULL,
  `time_id` int(11) NOT NULL,
  `teacher_course_id` int(11) NOT NULL,
  `comment` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `egn_timetable`
--

INSERT INTO `egn_timetable` (`id`, `day_id`, `time_id`, `teacher_course_id`, `comment`) VALUES
(1, 1, 1, 1, '123'),
(4, 1, 2, 1, ''),
(5, 1, 5, 6, 'Tutorial'),
(6, 2, 7, 4, ''),
(7, 2, 1, 5, ''),
(8, 2, 2, 6, ''),
(9, 1, 7, 4, ''),
(10, 3, 1, 4, 'Tutorial'),
(11, 2, 5, 4, 'Tutorial'),
(12, 3, 2, 1, 'Practical'),
(13, 3, 5, 1, 'Practical'),
(14, 3, 7, 6, ''),
(15, 4, 1, 3, ''),
(16, 4, 2, 3, ''),
(17, 4, 5, 2, ''),
(18, 4, 5, 6, ''),
(19, 4, 7, 4, ''),
(20, 5, 5, 3, ''),
(21, 5, 2, 6, ''),
(22, 5, 7, 1, ''),
(23, 5, 1, 3, '');

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

--
-- Dumping data for table `egn_time_timetable`
--

INSERT INTO `egn_time_timetable` (`id`, `from_time`, `to_time`, `type`) VALUES
(1, '09:00:00', '10:00:00', 1),
(2, '10:00:00', '11:00:00', 1),
(5, '11:00:00', '12:00:00', 1),
(6, '12:00:00', '13:15:00', 2),
(7, '13:15:00', '14:15:00', 1);

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
(1, 'Lecture'),
(3, 'Practical');

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
(1, 'badal.k@somaiya.edu', 'bk123', 7, 'M', 9769766016, 'Manoj Kotak'),
(2, 'admin@e-gyaan.in', 'admin123', 9, 'M', 9820003397, 'Admin'),
(3, 't@gmail.com', 't123', 2, 'M', 9237493875, 'Teacher 1'),
(4, 'ak@gmail.com', 'ak123', 2, 'M', 8293049182, 'Akash Parmar'),
(5, 'np@gmail.com', 'Px1Y', 2, 'M', 8394038940, 'Nikhil Parmar'),
(6, 'vg@somaiya.edu', 'n7Hh', 2, 'F', 9102938475, 'Vaishali G'),
(7, 'rl@somaiya.edu', 'kBjj', 2, 'F', 9304958291, 'Reena Lokare'),
(8, 'ur@somaiya.edu', 'BXf7', 2, 'M', 8392010934, 'Uday Rote');

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
-- Indexes for table `egn_test_answers`
--
ALTER TABLE `egn_test_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `egn_test_marks`
--
ALTER TABLE `egn_test_marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `egn_test_questions`
--
ALTER TABLE `egn_test_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_id` (`test_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `egn_branch`
--
ALTER TABLE `egn_branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `egn_course`
--
ALTER TABLE `egn_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `egn_course_reg`
--
ALTER TABLE `egn_course_reg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `egn_notes`
--
ALTER TABLE `egn_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `egn_noticeboard`
--
ALTER TABLE `egn_noticeboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;
--
-- AUTO_INCREMENT for table `egn_student`
--
ALTER TABLE `egn_student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `egn_student_attendance`
--
ALTER TABLE `egn_student_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_submissions`
--
ALTER TABLE `egn_submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `egn_suggestion_complaint`
--
ALTER TABLE `egn_suggestion_complaint`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_syllabus`
--
ALTER TABLE `egn_syllabus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_teacher_course`
--
ALTER TABLE `egn_teacher_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `egn_test`
--
ALTER TABLE `egn_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `egn_test_answers`
--
ALTER TABLE `egn_test_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `egn_test_marks`
--
ALTER TABLE `egn_test_marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `egn_test_questions`
--
ALTER TABLE `egn_test_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `egn_timetable`
--
ALTER TABLE `egn_timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `egn_time_timetable`
--
ALTER TABLE `egn_time_timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `egn_time_type`
--
ALTER TABLE `egn_time_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `egn_users`
--
ALTER TABLE `egn_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
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
  ADD CONSTRAINT `egn_role_privilege_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `egn_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
  ADD CONSTRAINT `egn_test_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `egn_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `egn_test_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `egn_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `egn_test_answers`
--
ALTER TABLE `egn_test_answers`
  ADD CONSTRAINT `egn_test_answers_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `egn_student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `egn_test_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `egn_test_questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `egn_test_marks`
--
ALTER TABLE `egn_test_marks`
  ADD CONSTRAINT `egn_test_marks_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `egn_test` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `egn_test_marks_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `egn_student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `egn_test_questions`
--
ALTER TABLE `egn_test_questions`
  ADD CONSTRAINT `egn_test_questions_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `egn_test` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `egn_timetable`
--
ALTER TABLE `egn_timetable`
  ADD CONSTRAINT `egn_timetable_ibfk_1` FOREIGN KEY (`time_id`) REFERENCES `egn_time_timetable` (`id`),
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

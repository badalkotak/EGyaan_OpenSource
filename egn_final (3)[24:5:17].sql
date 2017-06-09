-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 24, 2017 at 09:13 AM
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
(1, 'Computer Engineering'),
(2, 'Information Technology'),
(3, 'EXTC');

-- --------------------------------------------------------

--
-- Table structure for table `egn_course`
--

CREATE TABLE `egn_course` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `batch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_course_reg`
--

CREATE TABLE `egn_course_reg` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_privilege`
--

CREATE TABLE `egn_privilege` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_role`
--

CREATE TABLE `egn_role` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `is_teacher` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `egn_role_privilege`
--

CREATE TABLE `egn_role_privilege` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `privilege_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `course_id` int(11) NOT NULL,
  `addedby_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `addedby_user_id` (`addedby_user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_branch`
--
ALTER TABLE `egn_branch`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `egn_course`
--
ALTER TABLE `egn_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_course_reg`
--
ALTER TABLE `egn_course_reg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_notes`
--
ALTER TABLE `egn_notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_noticeboard`
--
ALTER TABLE `egn_noticeboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_privilege`
--
ALTER TABLE `egn_privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_role`
--
ALTER TABLE `egn_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_role_privilege`
--
ALTER TABLE `egn_role_privilege`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  ADD CONSTRAINT `egn_course_reg_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `egn_student` (`id`),
  ADD CONSTRAINT `egn_course_reg_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `egn_course` (`id`);

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
  ADD CONSTRAINT `egn_teacher_course_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `egn_course` (`id`),
  ADD CONSTRAINT `egn_teacher_course_ibfk_3` FOREIGN KEY (`addedby_user_id`) REFERENCES `egn_users` (`id`);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

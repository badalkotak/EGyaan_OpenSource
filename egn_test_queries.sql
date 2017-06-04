-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 04, 2017 at 06:51 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.9

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
-- Table structure for table `egn_test_answers`
--

CREATE TABLE `egn_test_answers` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL
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
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `egn_test`
--
ALTER TABLE `egn_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_test_answers`
--
ALTER TABLE `egn_test_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_test_marks`
--
ALTER TABLE `egn_test_marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `egn_test_questions`
--
ALTER TABLE `egn_test_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

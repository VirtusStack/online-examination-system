CREATE DATABASE IF NOT EXISTS online_exam_system;
USE online_exam_system;
CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `name`, `email`, `password_hash`, `created_at`) VALUES
(1, 'admin', 'admin@12.com', '$2y$10$T3g4wVh2ygCCvDPKOiTeteYmGB6RbLtSTpWN25/glk0z8EnF3vVVS', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `classrooms`
--

CREATE TABLE `classrooms` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classrooms`
--

INSERT INTO `classrooms` (`class_id`, `class_name`) VALUES
(1, 'Class A'),
(2, 'Class B'),
(3, 'Class C'),
(4, 'Class D'),
(5, 'Class E');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `exam_id` int(11) NOT NULL,
  `exam_title` varchar(200) NOT NULL,
  `exam_description` text DEFAULT NULL,
  `total_questions` int(11) DEFAULT 0,
  `total_marks` decimal(6,2) NOT NULL DEFAULT 0.00,
  `pass_marks` decimal(6,2) NOT NULL DEFAULT 0.00,
  `duration_minutes` int(11) DEFAULT 30,
  `shuffle_questions` tinyint(1) DEFAULT 1,
  `shuffle_options` tinyint(1) DEFAULT 1,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `negative_marking` decimal(5,2) DEFAULT 0.00,
  `status` enum('Active','Inactive') DEFAULT 'Inactive',
  `assign_type` enum('class','individual') DEFAULT 'individual',
  `assign_data` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `easy_percentage` int(11) DEFAULT 0,
  `medium_percentage` int(11) DEFAULT 0,
  `hard_percentage` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`exam_id`, `exam_title`, `exam_description`, `total_questions`, `total_marks`, `pass_marks`, `duration_minutes`, `shuffle_questions`, `shuffle_options`, `start_time`, `end_time`, `negative_marking`, `status`, `assign_type`, `assign_data`, `created_at`, `easy_percentage`, `medium_percentage`, `hard_percentage`) VALUES
(1, 'Science Midterm Exam', 'Covers Physics, Chemistry, Biology', 10, 0.00, 0.00, 30, 1, 1, '2025-12-06 12:00:00', '2025-12-06 17:35:00', 0.00, 'Inactive', 'class', NULL, '2025-12-03 00:20:17', 70, 20, 10),
(2, 'Commerce Midterm Exam', 'Covers Accountancy, Economics, Business Studies', 3, 0.00, 0.00, 30, 1, 1, '2025-12-03 12:05:00', '2025-12-03 12:35:00', 0.00, 'Inactive', 'class', NULL, '2025-12-03 01:05:11', 0, 0, 0),
(3, 'Science Midterm', 'Biology and chemistry', 30, 0.00, 0.00, 30, 1, 1, '2025-12-04 14:02:00', '2025-12-04 18:00:00', 0.00, 'Inactive', 'class', NULL, '2025-12-04 00:07:44', 0, 0, 0),
(4, 'GK Midterm Exam', 'Current Affairs and General Knowledge', 30, 0.00, 0.00, 30, 1, 1, '2025-12-04 14:00:00', '2025-12-04 19:30:00', 0.00, 'Inactive', 'class', NULL, '2025-12-04 03:01:14', 70, 20, 10),
(6, 'mix', 'Biology and Gk', 30, 0.00, 0.00, 30, 1, 1, '2025-12-04 18:18:00', '2025-12-04 19:30:00', 0.00, 'Inactive', 'class', NULL, '2025-12-04 07:19:58', 0, 0, 0),
(7, 'Commerce', 'Business Studies and Economics', 30, 0.00, 0.00, 30, 1, 1, '2025-12-06 12:20:00', '2025-12-06 19:30:00', 0.00, 'Inactive', 'class', NULL, '2025-12-04 08:09:51', 60, 30, 10),
(8, 'Science', 'biology and chemistry', 20, 0.00, 0.00, 30, 1, 1, '2025-12-06 10:00:00', '2025-12-06 19:34:00', 0.00, 'Inactive', 'class', NULL, '2025-12-04 08:34:33', 70, 25, 5),
(9, 'Science exam', 'Biology and Physics', 20, 0.00, 0.00, 30, 1, 1, '2025-12-09 10:30:00', '2025-12-09 19:30:00', 0.00, 'Inactive', 'class', NULL, '2025-12-04 23:31:10', 60, 30, 10),
(10, 'Art', 'GK and Current Affairs', 30, 0.00, 0.00, 30, 1, 1, '2025-12-08 11:00:00', '2025-12-08 19:28:00', 0.00, 'Inactive', 'class', NULL, '2025-12-05 01:23:19', 60, 30, 10),
(11, 'Gk', 'General Knowledge', 10, 10.00, 4.00, 30, 1, 0, '2025-12-06 12:10:00', '2025-12-06 18:00:00', 0.00, 'Inactive', 'class', NULL, '2025-12-06 01:47:13', 70, 20, 10),
(12, 'Chemistry', 'Science', 20, 20.00, 14.00, 30, 1, 1, '2025-12-12 11:01:00', '2025-12-12 19:30:00', 0.00, 'Inactive', 'class', NULL, '2025-12-09 05:02:41', 70, 25, 5);

-- --------------------------------------------------------

--
-- Table structure for table `exam_answers`
--

CREATE TABLE `exam_answers` (
  `id` int(11) NOT NULL,
  `result_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_option` enum('A','B','C','D') DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_answers`
--

INSERT INTO `exam_answers` (`id`, `result_id`, `question_id`, `selected_option`, `is_correct`) VALUES
(1, 1, 59, 'A', 1),
(2, 1, 27, 'A', 1),
(3, 2, 73, 'C', 0),
(4, 2, 115, 'A', 1),
(5, 3, 42, 'A', 1),
(6, 3, 48, 'B', 0),
(7, 3, 56, 'A', 1),
(8, 3, 46, 'A', 1),
(9, 3, 44, 'D', 0),
(10, 3, 41, 'A', 1),
(11, 3, 54, 'A', 1),
(12, 3, 58, 'A', 1),
(13, 3, 59, 'A', 1),
(14, 3, 49, 'A', 1),
(15, 3, 33, 'A', 1),
(16, 3, 36, 'A', 1),
(17, 3, 26, 'A', 1),
(18, 3, 27, 'A', 1),
(19, 3, 37, 'B', 0),
(20, 3, 34, 'A', 1),
(21, 3, 21, 'A', 1),
(22, 3, 35, 'A', 1),
(23, 3, 28, 'A', 1),
(24, 3, 24, 'A', 1),
(25, 3, 13, 'A', 1),
(26, 3, 11, 'A', 1),
(27, 3, 20, 'A', 1),
(28, 3, 6, 'A', 1),
(29, 3, 18, 'A', 1),
(30, 3, 12, 'A', 1),
(31, 3, 2, 'A', 1),
(32, 3, 19, 'A', 1),
(33, 3, 3, 'A', 1),
(34, 4, 155, 'A', 1),
(35, 4, 148, 'A', 1),
(36, 4, 160, 'C', 0),
(37, 5, 49, 'A', 1),
(38, 5, 50, 'A', 1),
(39, 5, 44, 'D', 0),
(40, 5, 48, 'B', 0),
(41, 5, 47, 'B', 0),
(42, 5, 46, 'A', 1),
(43, 5, 57, 'A', 1),
(44, 5, 52, 'B', 0),
(45, 5, 60, 'A', 1),
(46, 5, 10, 'A', 1),
(47, 5, 1, 'A', 1),
(48, 5, 18, 'A', 1),
(49, 5, 20, 'A', 1),
(50, 5, 11, 'A', 1),
(51, 5, 6, 'A', 1),
(52, 5, 5, 'B', 0),
(53, 5, 17, 'C', 0),
(54, 5, 15, 'A', 1),
(55, 6, 123, 'A', 1),
(56, 6, 128, 'C', 0),
(57, 6, 125, 'A', 1),
(58, 6, 124, 'A', 1),
(59, 6, 138, 'A', 1),
(60, 6, 126, 'A', 1),
(61, 6, 135, 'B', 0),
(62, 6, 130, 'A', 1),
(63, 7, 157, 'A', 1),
(64, 7, 160, 'C', 0),
(65, 7, 152, 'D', 0),
(66, 7, 155, 'A', 1),
(67, 7, 148, 'A', 1),
(68, 7, 145, 'D', 1),
(69, 7, 143, 'A', 0),
(70, 7, 147, 'B', 0),
(71, 7, 142, 'C', 1),
(72, 7, 154, 'B', 0),
(73, 7, 156, 'A', 1),
(74, 7, 136, 'A', 1),
(75, 7, 138, 'A', 1),
(76, 7, 140, 'A', 1),
(77, 7, 131, 'A', 1),
(78, 7, 123, 'A', 1),
(79, 7, 128, 'C', 0),
(80, 7, 135, 'B', 0),
(81, 7, 124, 'A', 1),
(82, 7, 125, 'A', 1),
(83, 7, 134, 'A', 1),
(84, 7, 137, 'A', 1),
(85, 7, 130, 'A', 1),
(86, 8, 125, 'A', 1),
(87, 8, 122, 'A', 1),
(88, 8, 140, 'A', 1),
(89, 8, 133, 'A', 1),
(90, 8, 131, 'A', 1),
(91, 8, 124, 'A', 1),
(92, 8, 132, 'A', 1),
(93, 8, 130, 'A', 1),
(94, 9, 47, 'B', 0),
(95, 9, 50, 'A', 1),
(96, 9, 59, 'A', 1),
(97, 9, 56, 'B', 0),
(98, 9, 41, 'A', 1),
(99, 9, 43, 'A', 1),
(100, 9, 58, 'C', 0),
(101, 9, 60, 'A', 1),
(102, 9, 45, 'A', 1),
(103, 9, 11, 'A', 1),
(104, 9, 12, 'A', 1),
(105, 9, 6, 'A', 1),
(106, 9, 8, 'A', 1),
(107, 9, 4, 'A', 1),
(108, 9, 18, 'A', 1),
(109, 9, 20, 'C', 0),
(110, 9, 17, 'D', 0),
(111, 9, 7, 'A', 1),
(112, 10, 102, 'A', 1),
(113, 10, 116, 'A', 1),
(114, 10, 105, 'D', 0),
(115, 10, 101, 'A', 1),
(116, 10, 114, 'A', 1),
(117, 10, 108, 'A', 1),
(118, 10, 106, 'B', 0),
(119, 10, 103, 'A', 1),
(120, 10, 117, 'A', 1),
(121, 10, 111, 'A', 1),
(122, 10, 119, 'C', 0),
(123, 10, 118, 'A', 1),
(124, 10, 107, 'A', 1),
(125, 10, 97, 'A', 1),
(126, 10, 88, 'A', 1),
(127, 10, 82, 'A', 1),
(128, 10, 83, 'A', 1),
(129, 10, 94, 'B', 0),
(130, 10, 81, 'A', 1),
(131, 10, 87, 'A', 1),
(132, 10, 100, 'A', 1),
(133, 10, 96, 'C', 0),
(134, 10, 95, 'D', 0),
(135, 10, 86, 'A', 1),
(136, 10, 98, 'D', 0),
(137, 11, 54, 'A', 1),
(138, 11, 48, 'A', 1),
(139, 11, 42, 'B', 0),
(140, 11, 41, 'A', 1),
(141, 11, 51, 'A', 1),
(142, 11, 29, 'A', 1),
(143, 11, 19, 'A', 1),
(144, 13, 104, 'A', 1),
(145, 13, 108, 'A', 1),
(146, 13, 112, 'C', 0),
(147, 13, 116, 'A', 1),
(148, 13, 114, 'A', 1),
(149, 13, 120, 'A', 1),
(150, 13, 102, 'A', 1),
(151, 13, 106, 'A', 1),
(152, 13, 113, 'B', 0),
(153, 13, 118, 'A', 1),
(154, 13, 119, 'D', 0),
(155, 13, 107, 'A', 1),
(156, 13, 110, 'A', 1),
(157, 13, 82, 'A', 1),
(158, 13, 85, 'A', 1),
(159, 13, 100, 'A', 1),
(160, 13, 92, 'A', 1),
(161, 13, 84, 'A', 1),
(162, 13, 96, 'C', 0),
(163, 13, 81, 'B', 0),
(164, 13, 97, 'A', 1),
(165, 13, 95, 'A', 1),
(166, 13, 90, 'B', 0),
(167, 13, 86, 'B', 0),
(168, 14, 50, 'A', 1),
(169, 14, 47, 'B', 0),
(170, 14, 48, 'B', 0),
(171, 14, 41, 'A', 1),
(172, 14, 56, 'A', 1),
(173, 14, 43, 'A', 1),
(174, 14, 59, 'A', 1),
(175, 14, 60, 'A', 1),
(176, 14, 55, 'C', 1),
(177, 14, 12, 'A', 1),
(178, 14, 2, 'B', 0),
(179, 14, 13, 'A', 1),
(180, 14, 10, 'A', 1),
(181, 14, 20, 'C', 0),
(182, 14, 6, 'A', 1),
(183, 14, 4, 'A', 1),
(184, 14, 14, 'D', 0),
(185, 14, 5, 'B', 0),
(186, 15, 35, 'A', 1),
(187, 15, 32, 'A', 1),
(188, 15, 37, 'B', 0),
(189, 15, 29, 'A', 1),
(190, 15, 24, 'A', 1),
(191, 15, 26, 'A', 1),
(192, 15, 23, 'D', 0),
(193, 15, 36, 'A', 1),
(194, 15, 39, 'A', 1),
(195, 15, 34, 'A', 1),
(196, 15, 33, 'A', 1),
(197, 15, 21, 'A', 1),
(198, 15, 28, 'A', 1),
(199, 15, 27, 'A', 1),
(200, 15, 22, 'A', 1),
(201, 15, 40, 'A', 1),
(202, 15, 30, 'A', 1),
(203, 15, 25, 'A', 1),
(204, 15, 38, 'A', 1),
(205, 16, 23, 'D', 0),
(206, 16, 21, 'A', 1),
(207, 16, 26, 'A', 1),
(208, 16, 29, 'A', 1),
(209, 16, 33, 'A', 1),
(210, 16, 37, 'B', 0),
(211, 16, 34, 'A', 1),
(212, 16, 30, 'A', 1),
(213, 16, 22, 'A', 1),
(214, 16, 40, 'A', 1),
(215, 16, 28, 'A', 1),
(216, 16, 32, 'A', 1),
(217, 16, 39, 'A', 1),
(218, 16, 27, 'A', 1),
(219, 16, 35, 'A', 1),
(220, 16, 24, 'A', 1),
(221, 16, 36, 'A', 1),
(222, 16, 25, 'A', 1),
(223, 16, 31, 'A', 1),
(224, 16, 38, 'A', 1),
(225, 17, 29, 'A', 1),
(226, 17, 32, 'A', 1),
(227, 17, 39, 'A', 1),
(228, 17, 35, 'A', 1),
(229, 17, 21, 'A', 1),
(230, 17, 33, 'A', 1),
(231, 17, 36, 'A', 1),
(232, 17, 37, 'B', 0),
(233, 17, 22, 'A', 1),
(234, 17, 24, 'A', 1),
(235, 17, 23, 'D', 0),
(236, 17, 30, 'A', 1),
(237, 17, 27, 'A', 1),
(238, 17, 28, 'A', 1),
(239, 17, 26, 'A', 1),
(240, 17, 34, 'A', 1),
(241, 17, 40, 'A', 1),
(242, 17, 38, 'A', 1),
(243, 17, 25, 'A', 1);

-- --------------------------------------------------------

--
-- Table structure for table `exam_assigned_students`
--

CREATE TABLE `exam_assigned_students` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_assigned_students`
--

INSERT INTO `exam_assigned_students` (`id`, `exam_id`, `student_id`) VALUES
(46, 2, 1),
(47, 2, 2),
(48, 2, 9),
(49, 2, 10),
(70, 5, 1),
(71, 5, 2),
(72, 5, 9),
(73, 5, 10),
(82, 3, 1),
(83, 3, 2),
(84, 3, 9),
(85, 3, 10),
(86, 6, 1),
(87, 6, 2),
(88, 6, 9),
(89, 6, 10),
(143, 8, 1),
(144, 8, 2),
(145, 8, 9),
(146, 8, 10),
(151, 7, 1),
(152, 7, 2),
(153, 7, 9),
(154, 7, 10),
(171, 10, 1),
(172, 10, 2),
(173, 10, 9),
(174, 10, 10),
(175, 4, 1),
(176, 4, 2),
(177, 4, 9),
(178, 4, 10),
(179, 9, 1),
(180, 9, 2),
(181, 9, 9),
(182, 9, 10),
(183, 1, 1),
(184, 1, 2),
(185, 1, 9),
(186, 1, 10),
(201, 11, 1),
(202, 11, 2),
(203, 11, 9),
(204, 11, 10),
(215, 12, 1),
(216, 12, 2),
(217, 12, 9),
(218, 12, 10),
(219, 12, 11);

-- --------------------------------------------------------

--
-- Table structure for table `exam_links`
--

CREATE TABLE `exam_links` (
  `link_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `unique_link` varchar(255) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `student_name` varchar(150) DEFAULT NULL,
  `student_email` varchar(200) DEFAULT NULL,
  `student_class` varchar(50) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `is_used` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_links`
--

INSERT INTO `exam_links` (`link_id`, `exam_id`, `unique_link`, `password`, `student_name`, `student_email`, `student_class`, `expires_at`, `is_used`, `created_at`) VALUES
(1, 1, 'exam_692fcf9984a537.76633127', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', 'Alice Smith', 'alice@example.com', NULL, '2025-12-03 12:32:00', 0, '2025-12-03 00:20:17'),
(2, 1, 'exam_692fcf9986ae43.68810739', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-03 12:32:00', 0, '2025-12-03 00:20:17'),
(3, 1, 'exam_692fcf99875d84.58635436', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', 'Isla Adams', 'isla@example.com', NULL, '2025-12-03 12:32:00', 0, '2025-12-03 00:20:17'),
(4, 1, 'exam_692fcf9987efa9.44783430', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', 'Jack Baker', 'jack@example.com', NULL, '2025-12-03 12:32:00', 0, '2025-12-03 00:20:17'),
(5, 1, 'exam-1-90c560f7', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', NULL, NULL, NULL, '2025-12-03 12:32:00', 0, '2025-12-03 00:20:17'),
(6, 2, 'exam_692fda1f1ba752.47433683', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', 'Alice Smith', 'alice@example.com', NULL, '2025-12-03 13:07:00', 0, '2025-12-03 01:05:11'),
(7, 2, 'exam-2-b06d2abe', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', NULL, NULL, NULL, '2025-12-03 13:07:00', 0, '2025-12-03 01:05:11'),
(8, 2, 'exam_692fdaaf044c64.50989660', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-03 13:07:00', 0, '2025-12-03 01:07:35'),
(9, 2, 'exam_692fdaaf058051.62156593', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', 'Isla Adams', 'isla@example.com', NULL, '2025-12-03 13:07:00', 0, '2025-12-03 01:07:35'),
(10, 2, 'exam_692fdaaf06a1e7.06203442', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', 'Jack Baker', 'jack@example.com', NULL, '2025-12-03 13:07:00', 0, '2025-12-03 01:07:35'),
(11, 3, 'exam_69311e280c96f4.17571917', '$2y$10$h7kjpmMBg/hhgFxMayly8OQUZIcz1gt2DWmDuVHmIhceQf.zKSnvm', 'Alice Smith', 'alice@example.com', NULL, '2025-12-04 19:30:00', 0, '2025-12-04 00:07:44'),
(12, 3, 'exam_69311e280d6bb3.99862612', '$2y$10$h7kjpmMBg/hhgFxMayly8OQUZIcz1gt2DWmDuVHmIhceQf.zKSnvm', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-04 19:30:00', 0, '2025-12-04 00:07:44'),
(13, 3, 'exam_69311e280ea7a4.79907493', '$2y$10$h7kjpmMBg/hhgFxMayly8OQUZIcz1gt2DWmDuVHmIhceQf.zKSnvm', 'Isla Adams', 'isla@example.com', NULL, '2025-12-04 19:30:00', 0, '2025-12-04 00:07:44'),
(14, 3, 'exam_69311e280f6956.66697445', '$2y$10$h7kjpmMBg/hhgFxMayly8OQUZIcz1gt2DWmDuVHmIhceQf.zKSnvm', 'Jack Baker', 'jack@example.com', NULL, '2025-12-04 19:30:00', 0, '2025-12-04 00:07:44'),
(15, 3, 'exam-3-7986e524', '$2y$10$h7kjpmMBg/hhgFxMayly8OQUZIcz1gt2DWmDuVHmIhceQf.zKSnvm', NULL, NULL, NULL, '2025-12-04 19:30:00', 0, '2025-12-04 00:07:44'),
(16, 4, 'exam_693146d2c23fd8.96082513', '$2y$10$22lInCPZBL98mtJcUB43g.DM.ZF7TkTEVed3.rMcCYJNrnYCy0jHW', 'Alice Smith', 'alice@example.com', NULL, '2025-12-04 19:36:00', 0, '2025-12-04 03:01:14'),
(17, 4, 'exam_693146d2c3b011.13586377', '$2y$10$22lInCPZBL98mtJcUB43g.DM.ZF7TkTEVed3.rMcCYJNrnYCy0jHW', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-04 19:36:00', 0, '2025-12-04 03:01:14'),
(18, 4, 'exam_693146d2c4bfc8.17044816', '$2y$10$22lInCPZBL98mtJcUB43g.DM.ZF7TkTEVed3.rMcCYJNrnYCy0jHW', 'Isla Adams', 'isla@example.com', NULL, '2025-12-04 19:36:00', 0, '2025-12-04 03:01:14'),
(19, 4, 'exam_693146d2c5f450.62745054', '$2y$10$22lInCPZBL98mtJcUB43g.DM.ZF7TkTEVed3.rMcCYJNrnYCy0jHW', 'Jack Baker', 'jack@example.com', NULL, '2025-12-04 19:36:00', 0, '2025-12-04 03:01:14'),
(20, 4, 'exam-4-fd078b88', '$2y$10$22lInCPZBL98mtJcUB43g.DM.ZF7TkTEVed3.rMcCYJNrnYCy0jHW', NULL, NULL, NULL, '2025-12-04 19:36:00', 0, '2025-12-04 03:01:15'),
(26, 6, 'exam_693183769d73f8.25339927', NULL, 'Alice Smith', 'alice@example.com', NULL, NULL, 0, '2025-12-04 07:19:58'),
(27, 6, 'exam_693183769f0703.49855114', NULL, 'Bob Johnson', 'bob@example.com', NULL, NULL, 0, '2025-12-04 07:19:58'),
(28, 6, 'exam_69318376a023a3.77213354', NULL, 'Isla Adams', 'isla@example.com', NULL, NULL, 0, '2025-12-04 07:19:58'),
(29, 6, 'exam_69318376a22ec9.35373299', NULL, 'Jack Baker', 'jack@example.com', NULL, NULL, 0, '2025-12-04 07:19:58'),
(30, 6, 'exam-6-fa910817', '$2y$10$YT5qYRwTHrPwmMgQzot5FeU1kMoKJDTngY5NsKgH8pbLIr93gRi3m', NULL, NULL, NULL, '2025-12-04 19:30:00', 0, '2025-12-04 07:19:58'),
(31, 7, 'exam_69318f276d5d98.80552294', NULL, 'Alice Smith', 'alice@example.com', NULL, '2025-12-06 17:41:00', 0, '2025-12-04 08:09:51'),
(32, 7, 'exam_69318f276f1c07.96629835', NULL, 'Bob Johnson', 'bob@example.com', NULL, '2025-12-06 17:41:00', 0, '2025-12-04 08:09:51'),
(33, 7, 'exam_69318f27704447.67883235', NULL, 'Isla Adams', 'isla@example.com', NULL, '2025-12-06 17:41:00', 0, '2025-12-04 08:09:51'),
(34, 7, 'exam_69318f277266e9.47907509', NULL, 'Jack Baker', 'jack@example.com', NULL, '2025-12-06 17:41:00', 0, '2025-12-04 08:09:51'),
(35, 7, 'exam-7-eea92ca9', NULL, NULL, NULL, NULL, '2025-12-06 17:41:00', 0, '2025-12-04 08:09:51'),
(36, 8, 'exam_693194f171d2d6.38351520', NULL, 'Alice Smith', 'alice@example.com', NULL, '0000-00-00 00:00:00', 0, '2025-12-04 08:34:33'),
(37, 8, 'exam_693194f173cd51.29926238', NULL, 'Bob Johnson', 'bob@example.com', NULL, '0000-00-00 00:00:00', 0, '2025-12-04 08:34:33'),
(38, 8, 'exam_693194f1751183.86502391', NULL, 'Isla Adams', 'isla@example.com', NULL, '0000-00-00 00:00:00', 0, '2025-12-04 08:34:33'),
(39, 8, 'exam_693194f176cd16.26821545', NULL, 'Jack Baker', 'jack@example.com', NULL, '0000-00-00 00:00:00', 0, '2025-12-04 08:34:33'),
(40, 8, 'exam-8-bbe47086', NULL, NULL, NULL, NULL, '0000-00-00 00:00:00', 0, '2025-12-04 08:34:33'),
(41, 9, 'exam_69326716561ea0.90367878', '$2y$10$mghvRu7zXzVglik31BzH.OiCtiFQdS65dqqI5GVNCcdBYIiUX0E.O', 'Alice Smith', 'alice@example.com', NULL, '2025-12-09 19:00:00', 0, '2025-12-04 23:31:10'),
(42, 9, 'exam_69326716573042.16669386', '$2y$10$mghvRu7zXzVglik31BzH.OiCtiFQdS65dqqI5GVNCcdBYIiUX0E.O', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-09 19:00:00', 0, '2025-12-04 23:31:10'),
(43, 9, 'exam_693267165892b6.32140913', '$2y$10$mghvRu7zXzVglik31BzH.OiCtiFQdS65dqqI5GVNCcdBYIiUX0E.O', 'Isla Adams', 'isla@example.com', NULL, '2025-12-09 19:00:00', 0, '2025-12-04 23:31:10'),
(44, 9, 'exam_6932671659c5f5.33948213', '$2y$10$mghvRu7zXzVglik31BzH.OiCtiFQdS65dqqI5GVNCcdBYIiUX0E.O', 'Jack Baker', 'jack@example.com', NULL, '2025-12-09 19:00:00', 0, '2025-12-04 23:31:10'),
(45, 9, 'exam-9-92f9121b', '$2y$10$mghvRu7zXzVglik31BzH.OiCtiFQdS65dqqI5GVNCcdBYIiUX0E.O', NULL, NULL, NULL, '2025-12-09 19:00:00', 0, '2025-12-04 23:31:10'),
(46, 10, 'exam_6932815f12bd53.97690333', '$2y$10$lq2RywVOFDkiByPYJbHs4O0P.UgabUAR79sCoqoJ0AQLoZTBJnKyy', 'Alice Smith', 'alice@example.com', NULL, '2025-12-08 19:30:00', 0, '2025-12-05 01:23:19'),
(47, 10, 'exam_6932815f140814.35878927', '$2y$10$lq2RywVOFDkiByPYJbHs4O0P.UgabUAR79sCoqoJ0AQLoZTBJnKyy', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-08 19:30:00', 0, '2025-12-05 01:23:19'),
(48, 10, 'exam_6932815f1526a2.55460779', '$2y$10$lq2RywVOFDkiByPYJbHs4O0P.UgabUAR79sCoqoJ0AQLoZTBJnKyy', 'Isla Adams', 'isla@example.com', NULL, '2025-12-08 19:30:00', 0, '2025-12-05 01:23:19'),
(49, 10, 'exam_6932815f16f185.17585246', '$2y$10$lq2RywVOFDkiByPYJbHs4O0P.UgabUAR79sCoqoJ0AQLoZTBJnKyy', 'Jack Baker', 'jack@example.com', NULL, '2025-12-08 19:30:00', 0, '2025-12-05 01:23:19'),
(50, 10, 'exam-10-8045503c', '$2y$10$lq2RywVOFDkiByPYJbHs4O0P.UgabUAR79sCoqoJ0AQLoZTBJnKyy', NULL, NULL, NULL, '2025-12-08 19:30:00', 0, '2025-12-05 01:23:19'),
(56, 11, 'exam_6933de85de54e2.44420192', '$2y$10$IIh383zpGx725s32KlFut.ghhwLPpsGG/A0MVOPFoJ1fRtm/V5NqC', 'Alice Smith', 'alice@example.com', NULL, '2025-12-12 16:51:00', 0, '2025-12-06 02:13:01'),
(57, 11, 'exam_6933de85df7f53.91706074', '$2y$10$IIh383zpGx725s32KlFut.ghhwLPpsGG/A0MVOPFoJ1fRtm/V5NqC', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-12 16:51:00', 0, '2025-12-06 02:13:01'),
(58, 11, 'exam_6933de85e0bcb2.35495952', '$2y$10$IIh383zpGx725s32KlFut.ghhwLPpsGG/A0MVOPFoJ1fRtm/V5NqC', 'Isla Adams', 'isla@example.com', NULL, '2025-12-12 16:51:00', 0, '2025-12-06 02:13:01'),
(59, 11, 'exam_6933de85e29e82.90994181', '$2y$10$IIh383zpGx725s32KlFut.ghhwLPpsGG/A0MVOPFoJ1fRtm/V5NqC', 'Jack Baker', 'jack@example.com', NULL, '2025-12-12 16:51:00', 0, '2025-12-06 02:13:01'),
(60, 11, 'exam-11-1da656b9', '$2y$10$IIh383zpGx725s32KlFut.ghhwLPpsGG/A0MVOPFoJ1fRtm/V5NqC', NULL, NULL, NULL, '2025-12-12 16:51:00', 0, '2025-12-06 02:13:02'),
(61, 12, 'exam_6937fac915cd04.79806351', '$2y$10$TcpxAVLpfZG2.KPYnnNv2OxObBbk2CjOMyg/B0NHAKVgMH2kGJC/G', 'Charlie Lee', 'charlie@example.com', NULL, '2025-12-12 16:56:00', 0, '2025-12-09 05:02:41'),
(62, 12, 'exam_6937fac9187fa4.06248514', '$2y$10$TcpxAVLpfZG2.KPYnnNv2OxObBbk2CjOMyg/B0NHAKVgMH2kGJC/G', 'David Kim', 'david@example.com', NULL, '2025-12-12 16:56:00', 0, '2025-12-09 05:02:41'),
(63, 12, 'exam-12-f338ef9a', '$2y$10$TcpxAVLpfZG2.KPYnnNv2OxObBbk2CjOMyg/B0NHAKVgMH2kGJC/G', NULL, NULL, NULL, '2025-12-12 16:56:00', 0, '2025-12-09 05:02:41'),
(64, 12, 'exam_6937fc1c48ead9.53586022', '$2y$10$TcpxAVLpfZG2.KPYnnNv2OxObBbk2CjOMyg/B0NHAKVgMH2kGJC/G', 'Alice Smith', 'alice@example.com', NULL, '2025-12-12 16:56:00', 0, '2025-12-09 05:08:20'),
(65, 12, 'exam_6937fc1c49e604.14573940', '$2y$10$TcpxAVLpfZG2.KPYnnNv2OxObBbk2CjOMyg/B0NHAKVgMH2kGJC/G', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-12 16:56:00', 0, '2025-12-09 05:08:20'),
(66, 12, 'exam_6937fc1c4b09b9.61425980', '$2y$10$TcpxAVLpfZG2.KPYnnNv2OxObBbk2CjOMyg/B0NHAKVgMH2kGJC/G', 'Isla Adams', 'isla@example.com', NULL, '2025-12-12 16:56:00', 0, '2025-12-09 05:08:20'),
(67, 12, 'exam_6937fc1c4d5097.14844949', '$2y$10$TcpxAVLpfZG2.KPYnnNv2OxObBbk2CjOMyg/B0NHAKVgMH2kGJC/G', 'Jack Baker', 'jack@example.com', NULL, '2025-12-12 16:56:00', 0, '2025-12-09 05:08:20'),
(68, 12, 'exam_693bc39eed7963.73523091', '$2y$10$TcpxAVLpfZG2.KPYnnNv2OxObBbk2CjOMyg/B0NHAKVgMH2kGJC/G', 'Martin Smith', 'martin@example.com', NULL, '2025-12-12 16:56:00', 0, '2025-12-12 07:26:22');

-- --------------------------------------------------------

--
-- Table structure for table `exam_questions`
--

CREATE TABLE `exam_questions` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_questions`
--

INSERT INTO `exam_questions` (`id`, `exam_id`, `question_id`) VALUES
(27, 1, 53),
(28, 1, 37),
(29, 1, 4),
(30, 2, 73),
(31, 2, 115),
(32, 2, 87),
(687, 4, 145),
(688, 4, 148),
(689, 4, 155),
(690, 4, 157),
(691, 4, 160),
(692, 4, 143),
(693, 4, 152),
(694, 4, 138),
(695, 4, 132),
(696, 4, 136),
(697, 4, 133),
(698, 4, 124),
(699, 4, 123),
(700, 4, 140),
(701, 4, 125),
(702, 4, 122),
(703, 4, 126),
(704, 4, 128),
(705, 4, 135),
(706, 4, 131),
(737, 3, 42),
(738, 3, 44),
(739, 3, 47),
(740, 3, 58),
(741, 3, 49),
(742, 3, 59),
(743, 3, 54),
(744, 3, 43),
(745, 3, 46),
(746, 3, 48),
(747, 3, 24),
(748, 3, 29),
(749, 3, 21),
(750, 3, 27),
(751, 3, 39),
(752, 3, 28),
(753, 3, 30),
(754, 3, 23),
(755, 3, 37),
(756, 3, 40),
(757, 3, 8),
(758, 3, 1),
(759, 3, 11),
(760, 3, 19),
(761, 3, 12),
(762, 3, 10),
(763, 3, 3),
(764, 3, 18),
(765, 3, 6),
(766, 3, 13);

-- --------------------------------------------------------

--
-- Table structure for table `exam_question_sources`
--

CREATE TABLE `exam_question_sources` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `difficulty` enum('Easy','Medium','Hard') DEFAULT NULL,
  `question_limit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_question_sources`
--

INSERT INTO `exam_question_sources` (`id`, `exam_id`, `bank_id`, `subject_id`, `difficulty`, `question_limit`) VALUES
(36, 2, 2, 4, NULL, 1),
(37, 2, 2, 6, NULL, 1),
(38, 2, 2, 5, NULL, 1),
(75, 3, 1, 3, 'Easy', 10),
(76, 3, 1, 2, 'Easy', 10),
(77, 3, 1, 1, 'Easy', 10),
(78, 6, 3, 7, 'Easy', 9),
(79, 6, 3, 7, 'Medium', 4),
(80, 6, 3, 7, 'Hard', 2),
(81, 6, 1, 3, 'Easy', 9),
(82, 6, 1, 3, 'Medium', 4),
(83, 6, 1, 3, 'Hard', 2),
(153, 8, 1, 3, 'Easy', 7),
(154, 8, 1, 3, 'Medium', 2),
(155, 8, 1, 3, 'Hard', 1),
(156, 8, 1, 1, 'Easy', 7),
(157, 8, 1, 1, 'Medium', 2),
(158, 8, 1, 1, 'Hard', 1),
(165, 7, 2, 6, 'Easy', 9),
(166, 7, 2, 6, 'Medium', 4),
(167, 7, 2, 6, 'Hard', 2),
(168, 7, 2, 5, 'Easy', 9),
(169, 7, 2, 5, 'Medium', 4),
(170, 7, 2, 5, 'Hard', 2),
(198, 10, 3, 8, 'Easy', 9),
(199, 10, 3, 8, 'Medium', 4),
(200, 10, 3, 8, 'Hard', 2),
(201, 10, 3, 7, 'Easy', 9),
(202, 10, 3, 7, 'Medium', 4),
(203, 10, 3, 7, 'Hard', 2),
(204, 4, 3, 8, 'Easy', 10),
(205, 4, 3, 8, 'Medium', 3),
(206, 4, 3, 8, 'Hard', 2),
(207, 4, 3, 7, 'Easy', 10),
(208, 4, 3, 7, 'Medium', 3),
(209, 4, 3, 7, 'Hard', 2),
(210, 9, 1, 3, 'Easy', 6),
(211, 9, 1, 3, 'Medium', 3),
(212, 9, 1, 3, 'Hard', 1),
(213, 9, 1, 1, 'Easy', 6),
(214, 9, 1, 1, 'Medium', 3),
(215, 9, 1, 1, 'Hard', 1),
(216, 1, 1, 3, 'Easy', 4),
(217, 1, 1, 3, 'Medium', 1),
(218, 1, 1, 3, 'Hard', 1),
(219, 1, 1, 2, 'Easy', 1),
(220, 1, 1, 2, 'Hard', 1),
(221, 1, 1, 1, 'Easy', 1),
(222, 1, 1, 1, 'Hard', 1),
(235, 11, 3, 7, 'Easy', 7),
(236, 11, 3, 7, 'Medium', 2),
(237, 11, 3, 7, 'Hard', 1),
(244, 12, 1, 2, 'Easy', 14),
(245, 12, 1, 2, 'Medium', 5),
(246, 12, 1, 2, 'Hard', 1);

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `result_id` int(11) NOT NULL,
  `link_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `student_name` varchar(150) DEFAULT NULL,
  `student_email` varchar(200) DEFAULT NULL,
  `total_marks` decimal(5,2) DEFAULT 0.00,
  `obtained_marks` decimal(5,2) DEFAULT 0.00,
  `started_at` datetime DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_results`
--

INSERT INTO `exam_results` (`result_id`, `link_id`, `exam_id`, `student_name`, `student_email`, `total_marks`, `obtained_marks`, `started_at`, `submitted_at`) VALUES
(1, 1, 1, 'Alice Smith', 'alice@example.com', 0.00, 0.00, '2025-12-03 11:25:38', '2025-12-03 11:25:38'),
(2, 6, 2, 'Alice Smith', 'alice@example.com', 0.00, 0.00, '2025-12-03 12:14:57', '2025-12-03 12:14:57'),
(3, 11, 3, 'Alice Smith', 'alice@example.com', 0.00, 0.00, '2025-12-04 16:48:22', '2025-12-04 16:48:22'),
(4, 46, 10, 'Alice Smith', 'alice@example.com', 0.00, 0.00, '2025-12-06 12:11:44', '2025-12-06 12:11:44'),
(5, 41, 9, 'Alice Smith', 'alice@example.com', 0.00, 0.00, '2025-12-06 13:11:35', '2025-12-06 13:11:35'),
(6, 56, 11, 'Alice Smith', 'alice@example.com', 0.00, 0.00, '2025-12-06 13:18:49', '2025-12-06 13:18:49'),
(7, 47, 10, 'Bob Johnson', 'bob@example.com', 0.00, 0.00, '2025-12-06 13:24:54', '2025-12-06 13:24:54'),
(8, 57, 11, 'Bob Johnson', 'bob@example.com', 0.00, 0.00, '2025-12-06 14:04:36', '2025-12-06 14:04:36'),
(9, 37, 8, 'Bob Johnson', 'bob@example.com', 0.00, 0.00, '2025-12-06 14:13:14', '2025-12-06 14:13:14'),
(10, 32, 7, 'Bob Johnson', 'bob@example.com', 0.00, 0.00, '2025-12-06 14:42:13', '2025-12-06 14:42:13'),
(11, 2, 1, 'Bob Johnson', 'bob@example.com', 0.00, 0.00, '2025-12-06 15:14:16', '2025-12-06 15:14:16'),
(12, 42, 9, 'Bob Johnson', 'bob@example.com', 0.00, 0.00, '2025-12-06 15:14:44', '2025-12-06 15:14:44'),
(13, 31, 7, 'Alice Smith', 'alice@example.com', 0.00, 0.00, '2025-12-06 15:31:19', '2025-12-06 15:31:19'),
(14, 36, 8, 'Alice Smith', 'alice@example.com', 0.00, 0.00, '2025-12-06 15:35:17', '2025-12-06 15:35:17'),
(15, 68, 12, 'Martin Smith', 'martin@example.com', 19.00, 17.00, '2025-12-12 12:56:52', '2025-12-12 13:10:29'),
(16, 64, 12, 'Alice Smith', 'alice@example.com', 20.00, 18.00, '2025-12-12 13:27:53', '2025-12-12 13:27:53'),
(17, 67, 12, 'Jack Baker', 'jack@example.com', 19.00, 17.00, '2025-12-12 13:29:47', '2025-12-12 13:29:47');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_option` enum('A','B','C','D') NOT NULL,
  `marks_per_question` decimal(5,2) DEFAULT 1.00,
  `difficulty` enum('Easy','Medium','Hard') DEFAULT 'Easy'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `bank_id`, `subject_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks_per_question`, `difficulty`) VALUES
(1, 1, 1, 'What is the unit of Force?', 'Newton', 'Joule', 'Watt', 'Pascal', 'A', 1.00, 'Easy'),
(2, 1, 1, 'Speed of light is approximately?', '3×10^8 m/s', '3×10^6 m/s', '3×10^5 m/s', '3×10^4 m/s', 'A', 1.00, 'Easy'),
(3, 1, 1, 'Which law explains inertia?', 'Newton’s 1st law', 'Newton’s 2nd law', 'Newton’s 3rd law', 'Gravitation law', 'A', 1.00, 'Easy'),
(4, 1, 1, 'SI unit of power?', 'Watt', 'Joule', 'Newton', 'Ampere', 'A', 1.00, 'Easy'),
(5, 1, 1, '1 kWh = ?', '3.6×10^6 J', '3600 J', '36 J', '3.6 J', 'A', 1.00, 'Medium'),
(6, 1, 1, 'Which mirror is used in vehicles?', 'Convex', 'Concave', 'Plane', 'None', 'A', 1.00, 'Easy'),
(7, 1, 1, 'Which quantity is vector?', 'Velocity', 'Speed', 'Distance', 'Energy', 'A', 1.00, 'Medium'),
(8, 1, 1, 'Formula of momentum?', 'mv', 'm/v', 'v/m', 'm+v', 'A', 1.00, 'Easy'),
(9, 1, 1, 'Which wave needs medium?', 'Sound', 'Light', 'X-ray', 'Radio', 'A', 1.00, 'Medium'),
(10, 1, 1, 'Which lens forms real inverted image?', 'Convex', 'Concave', 'Cylindrical', 'None', 'A', 1.00, 'Easy'),
(11, 1, 1, 'Value of g on Earth?', '9.8 m/s²', '8.9 m/s²', '7.8 m/s²', '10 m/s²', 'A', 1.00, 'Easy'),
(12, 1, 1, 'Which device measures electric current?', 'Ammeter', 'Voltmeter', 'Ohmmeter', 'Capacitor', 'A', 1.00, 'Hard'),
(13, 1, 1, 'Ohm’s law states?', 'V = IR', 'P = VI', 'E = mc²', 'F = ma', 'A', 1.00, 'Easy'),
(14, 1, 1, 'Unit of electric charge?', 'Coulomb', 'Farad', 'Henry', 'Tesla', 'A', 1.00, 'Medium'),
(15, 1, 1, 'Which has maximum energy?', 'Gamma rays', 'Infrared', 'Microwave', 'Radio', 'A', 1.00, 'Medium'),
(16, 1, 1, 'Which has highest frequency?', 'Violet light', 'Red light', 'Green light', 'Yellow light', 'A', 1.00, 'Hard'),
(17, 1, 1, 'Magnetic field unit?', 'Tesla', 'Newton', 'Joule', 'Ampere', 'A', 1.00, 'Medium'),
(18, 1, 1, 'Fuse works on principle of?', 'Heating effect', 'Magnetic effect', 'Chemical effect', 'None', 'A', 1.00, 'Hard'),
(19, 1, 1, 'Acceleration unit?', 'm/s²', 'm/s', 'm', 'kg', 'A', 1.00, 'Easy'),
(20, 1, 1, 'Instrument to measure pressure?', 'Barometer', 'Hygrometer', 'Ammeter', 'Thermometer', 'A', 1.00, 'Easy'),
(21, 1, 2, 'Atomic number represents?', 'Number of protons', 'Number of neutrons', 'Mass number', 'Electrons in outer shell', 'A', 1.00, 'Easy'),
(22, 1, 2, 'pH of neutral solution is?', '7', '5', '9', '11', 'A', 1.00, 'Easy'),
(23, 1, 2, 'Which gas is used in balloons?', 'Helium', 'Oxygen', 'Nitrogen', 'Hydrogen', 'A', 1.00, 'Hard'),
(24, 1, 2, 'HCl is?', 'Strong acid', 'Weak acid', 'Neutral', 'Base', 'A', 1.00, 'Hard'),
(25, 1, 2, 'Which metal is most reactive?', 'Potassium', 'Gold', 'Silver', 'Copper', 'A', 1.00, 'Medium'),
(26, 1, 2, 'Formula of methane?', 'CH4', 'C2H6', 'C3H8', 'C4H10', 'A', 1.00, 'Easy'),
(27, 1, 2, 'Rusting is?', 'Oxidation', 'Reduction', 'Neutralization', 'Substitution', 'A', 1.00, 'Hard'),
(28, 1, 2, 'Which is a noble gas?', 'Neon', 'Carbon', 'Chlorine', 'Hydrogen', 'A', 1.00, 'Easy'),
(29, 1, 2, 'Baking soda formula?', 'NaHCO3', 'Na2CO3', 'K2CO3', 'CaCO3', 'A', 1.00, 'Easy'),
(30, 1, 2, 'Common salt is?', 'NaCl', 'KCl', 'MgCl2', 'CaCl2', 'A', 1.00, 'Easy'),
(31, 1, 2, 'Covalent bond is formed by?', 'Sharing electrons', 'Losing electrons', 'Gaining electrons', 'Transfer of proton', 'A', 1.00, 'Medium'),
(32, 1, 2, 'Vinegar contains?', 'Acetic acid', 'Citric acid', 'Nitric acid', 'Sulphuric acid', 'A', 1.00, 'Easy'),
(33, 1, 2, 'Which metal is liquid?', 'Mercury', 'Sodium', 'Aluminum', 'Lead', 'A', 1.00, 'Easy'),
(34, 1, 2, 'Which is an alloy?', 'Brass', 'Gold', 'Silver', 'Iron', 'A', 1.00, 'Easy'),
(35, 1, 2, 'Which gas turns lime water milky?', 'CO2', 'O2', 'N2', 'H2', 'A', 1.00, 'Easy'),
(36, 1, 2, 'Which acid is in stomach?', 'HCl', 'H2SO4', 'HNO3', 'CH3COOH', 'A', 1.00, 'Easy'),
(37, 1, 2, 'Which ion is contained in acids?', 'H+', 'OH-', 'Na+', 'K+', 'A', 1.00, 'Easy'),
(38, 1, 2, 'Bleaching powder formula?', 'CaOCl2', 'CaCO3', 'CaCl2', 'CaSO4', 'A', 1.00, 'Medium'),
(39, 1, 2, 'Which is hardest substance?', 'Diamond', 'Graphite', 'Iron', 'Copper', 'A', 1.00, 'Easy'),
(40, 1, 2, 'Organic chemistry is study of?', 'Carbon compounds', 'Metals', 'Acids', 'Bases', 'A', 1.00, 'Easy'),
(41, 1, 3, 'Basic unit of life?', 'Cell', 'Tissue', 'Organ', 'Organ system', 'A', 1.00, 'Easy'),
(42, 1, 3, 'Which organ purifies blood?', 'Kidney', 'Heart', 'Liver', 'Lungs', 'A', 1.00, 'Easy'),
(43, 1, 3, 'Which vitamin is from sunlight?', 'Vitamin D', 'Vitamin A', 'Vitamin C', 'Vitamin B', 'A', 1.00, 'Easy'),
(44, 1, 3, 'Plant breathes through?', 'Stomata', 'Chlorophyll', 'Roots', 'Stem', 'A', 1.00, 'Easy'),
(45, 1, 3, 'Blood group universal donor?', 'O negative', 'AB positive', 'A positive', 'B positive', 'A', 1.00, 'Medium'),
(46, 1, 3, 'Which carries oxygen?', 'RBC', 'WBC', 'Platelets', 'Plasma', 'A', 1.00, 'Easy'),
(47, 1, 3, 'Photosynthesis occurs in?', 'Chloroplast', 'Mitochondria', 'Nucleus', 'Golgi bodies', 'A', 1.00, 'Easy'),
(48, 1, 3, 'Largest organ in body?', 'Skin', 'Liver', 'Brain', 'Heart', 'A', 1.00, 'Easy'),
(49, 1, 3, 'Human heart has?', '4 chambers', '3 chambers', '2 chambers', '1 chamber', 'A', 1.00, 'Easy'),
(50, 1, 3, 'Genetic material is?', 'DNA', 'RNA', 'Protein', 'Carbohydrate', 'A', 1.00, 'Easy'),
(51, 1, 3, 'Which disease is waterborne?', 'Cholera', 'TB', 'AIDS', 'Cancer', 'A', 1.00, 'Medium'),
(52, 1, 3, 'Which is a plant hormone?', 'Auxin', 'Insulin', 'Adrenaline', 'Thyroxine', 'A', 1.00, 'Medium'),
(53, 1, 3, 'Site of digestion?', 'Small intestine', 'Large intestine', 'Stomach', 'Mouth', 'A', 1.00, 'Hard'),
(54, 1, 3, 'Seeds are formed in?', 'Flower', 'Root', 'Stem', 'Leaf', 'A', 1.00, 'Easy'),
(55, 1, 3, 'Mosquito spreads?', 'Malaria', 'Dengue', 'All of these', 'None', 'C', 1.00, 'Medium'),
(56, 1, 3, 'Sugar stored in plants is?', 'Starch', 'Sucrose', 'Glucose', 'Fructose', 'A', 1.00, 'Easy'),
(57, 1, 3, 'Nervous system unit?', 'Neuron', 'Axon', 'Dendrite', 'Brain', 'A', 1.00, 'Medium'),
(58, 1, 3, 'Which organ produces bile?', 'Liver', 'Kidney', 'Pancreas', 'Heart', 'A', 1.00, 'Easy'),
(59, 1, 3, 'Respiration uses?', 'Oxygen', 'Carbon dioxide', 'Nitrogen', 'Argon', 'A', 1.00, 'Easy'),
(60, 1, 3, 'Energy currency of cell?', 'ATP', 'ADP', 'DNA', 'RNA', 'A', 1.00, 'Medium'),
(61, 2, 4, 'Which equation is basic accounting equation?', 'Assets = Liabilities + Capital', 'Capital = Assets + Liabilities', 'Liabilities = Assets + Capital', 'Capital = Liabilities - Assets', 'A', 1.00, 'Easy'),
(62, 2, 4, 'Which is a real account?', 'Machinery', 'Commission', 'Salary', 'Capital', 'A', 1.00, 'Easy'),
(63, 2, 4, 'Cash account is?', 'Real account', 'Nominal account', 'Personal account', 'None', 'A', 1.00, 'Easy'),
(64, 2, 4, 'Purchase return is also called?', 'Return outward', 'Return inward', 'Sales return', 'Goods return', 'A', 1.00, 'Easy'),
(65, 2, 4, 'Depreciation is?', 'Decrease in value', 'Increase in value', 'Liability', 'Asset', 'A', 1.00, 'Easy'),
(66, 2, 4, 'Which side is debit?', 'Left side', 'Right side', 'Both', 'None', 'A', 1.00, 'Easy'),
(67, 2, 4, 'Bills receivable is?', 'Asset', 'Liability', 'Expense', 'Revenue', 'A', 1.00, 'Easy'),
(68, 2, 4, 'Outstanding salary is?', 'Liability', 'Asset', 'Expense', 'Income', 'A', 1.00, 'Medium'),
(69, 2, 4, 'Carriage inward is added to?', 'Purchases', 'Sales', 'Expenses', 'Profit', 'A', 1.00, 'Easy'),
(70, 2, 4, 'Goodwill is?', 'Intangible asset', 'Tangible asset', 'Liability', 'Income', 'A', 1.00, 'Medium'),
(71, 2, 4, 'Bank overdraft is?', 'Liability', 'Asset', 'Income', 'Expense', 'A', 1.00, 'Easy'),
(72, 2, 4, 'Trial balance is prepared to?', 'Check arithmetical accuracy', 'Find profit', 'Find loss', 'Find capital', 'A', 1.00, 'Medium'),
(73, 2, 4, 'Capital is?', 'Owner’s equity', 'Liability', 'Asset', 'Expense', 'A', 1.00, 'Easy'),
(74, 2, 4, 'Which is an indirect expense?', 'Rent', 'Wages', 'Power', 'Raw material', 'A', 1.00, 'Medium'),
(75, 2, 4, 'Salary outstanding appears in?', 'Balance sheet', 'P&L account', 'Trading account', 'Journal', 'A', 1.00, 'Medium'),
(76, 2, 4, 'Sales return is?', 'Contra revenue', 'Liability', 'Expense', 'Asset', 'A', 1.00, 'Medium'),
(77, 2, 4, 'Ledger contains?', 'Accounts', 'Journal entries', 'Voucher', 'Bank details', 'A', 1.00, 'Easy'),
(78, 2, 4, 'Closing stock is shown in?', 'Trading account & balance sheet', 'Trading only', 'Balance sheet only', 'None', 'A', 1.00, 'Medium'),
(79, 2, 4, 'Cash book is?', 'Both journal & ledger', 'Only ledger', 'Only journal', 'None', 'A', 1.00, 'Medium'),
(80, 2, 4, 'Rent received is?', 'Income', 'Asset', 'Expense', 'Liability', 'A', 1.00, 'Easy'),
(81, 2, 5, 'Economics is study of?', 'Scarcity & choice', 'Money', 'Population', 'Politics', 'A', 1.00, 'Easy'),
(82, 2, 5, 'Law of demand shows relation between?', 'Price & quantity demanded', 'Income & demand', 'Population & supply', 'Cost & profit', 'A', 1.00, 'Easy'),
(83, 2, 5, 'Which is a macroeconomic concept?', 'National income', 'Consumer demand', 'Individual supply', 'Firm output', 'A', 1.00, 'Easy'),
(84, 2, 5, 'GDP stands for?', 'Gross Domestic Product', 'Gross Demand Product', 'General Domestic Price', 'Great Demand Price', 'A', 1.00, 'Easy'),
(85, 2, 5, 'Which is a factor of production?', 'Land', 'Bank', 'Money', 'Government', 'A', 1.00, 'Easy'),
(86, 2, 5, 'Elasticity of demand measures?', 'Responsiveness', 'Stability', 'Production', 'Consumption', 'A', 1.00, 'Medium'),
(87, 2, 5, 'Market price is determined by?', 'Demand & supply', 'Government', 'Company', 'Consumer', 'A', 1.00, 'Easy'),
(88, 2, 5, 'Inflation means?', 'Rise in price', 'Fall in price', 'Stable price', 'High savings', 'A', 1.00, 'Easy'),
(89, 2, 5, 'Which sector is agriculture?', 'Primary', 'Secondary', 'Tertiary', 'Quaternary', 'A', 1.00, 'Easy'),
(90, 2, 5, 'Opportunity cost is?', 'Next best alternative', 'Actual cost', 'Profit', 'Revenue', 'A', 1.00, 'Medium'),
(91, 2, 5, 'Population growth increases?', 'Demand', 'Supply', 'Cost', 'None', 'A', 1.00, 'Medium'),
(92, 2, 5, 'National income is?', 'Total income of country', 'Company income', 'Household income', 'Govt income', 'A', 1.00, 'Easy'),
(93, 2, 5, 'Which is a direct tax?', 'Income tax', 'GST', 'Custom duty', 'Service charge', 'A', 1.00, 'Medium'),
(94, 2, 5, 'Which curve slopes downward?', 'Demand curve', 'Supply curve', 'Production curve', 'Saving curve', 'A', 1.00, 'Easy'),
(95, 2, 5, 'Consumer surplus means?', 'Extra benefit', 'Loss', 'Profit', 'Saving', 'A', 1.00, 'Medium'),
(96, 2, 5, 'Which is capital?', 'Machine', 'Coal', 'Land', 'Labour', 'A', 1.00, 'Easy'),
(97, 2, 5, 'Bank lends money as?', 'Loan', 'Rent', 'Gift', 'Subsidy', 'A', 1.00, 'Easy'),
(98, 2, 5, 'Poverty is measured by?', 'Income level', 'Wealth', 'Tax rate', 'GDP', 'A', 1.00, 'Medium'),
(99, 2, 5, 'Demand increases when?', 'Income rises', 'Price rises', 'Population falls', 'Taste worsens', 'A', 1.00, 'Medium'),
(100, 2, 5, 'Full form of WTO?', 'World Trade Organization', 'World Tourism Office', 'World Transfer Organization', 'Western Trade Office', 'A', 1.00, 'Easy'),
(101, 2, 6, 'Business refers to?', 'Economic activity', 'Social activity', 'Political activity', 'Religious activity', 'A', 1.00, 'Easy'),
(102, 2, 6, 'Management is?', 'Process', 'Object', 'Goal', 'Law', 'A', 1.00, 'Easy'),
(103, 2, 6, 'Planning is?', 'First function', 'Last function', 'Optional', 'None', 'A', 1.00, 'Easy'),
(104, 2, 6, 'Marketing deals with?', 'Customer needs', 'Production only', 'Finance only', 'HR only', 'A', 1.00, 'Easy'),
(105, 2, 6, 'Organizing means?', 'Assigning work', 'Supervising', 'Motivating', 'Planning', 'A', 1.00, 'Easy'),
(106, 2, 6, 'Directing includes?', 'Motivation', 'Auditing', 'Recruitment', 'Accounting', 'A', 1.00, 'Easy'),
(107, 2, 6, 'Communication is?', 'Two-way process', 'One-way', 'Written only', 'Verbal only', 'A', 1.00, 'Medium'),
(108, 2, 6, 'Recruitment is?', 'Hiring employees', 'Paying salary', 'Firing employees', 'Buying goods', 'A', 1.00, 'Easy'),
(109, 2, 6, 'Leadership means?', 'Influencing people', 'Punishing people', 'Monitoring', 'Controlling', 'A', 1.00, 'Medium'),
(110, 2, 6, 'Coordination is?', 'Synchronizing efforts', 'Increasing cost', 'Decreasing workers', 'Buying machines', 'A', 1.00, 'Medium'),
(111, 2, 6, 'Which is financial decision?', 'Investment', 'Production', 'Advertising', 'Staffing', 'A', 1.00, 'Medium'),
(112, 2, 6, 'Business risk arises due to?', 'Uncertainty', 'Profit', 'Loss', 'Salary', 'A', 1.00, 'Easy'),
(113, 2, 6, 'Entrepreneur is?', 'Risk taker', 'Owner', 'Employee', 'Manager', 'A', 1.00, 'Easy'),
(114, 2, 6, 'Trade means?', 'Buying & selling', 'Manufacturing', 'Planning', 'Hiring', 'A', 1.00, 'Easy'),
(115, 2, 6, 'E-commerce means?', 'Online business', 'Offline business', 'Import only', 'Export only', 'A', 1.00, 'Easy'),
(116, 2, 6, 'Bank provides?', 'Loans', 'Books', 'Machines', 'Food', 'A', 1.00, 'Easy'),
(117, 2, 6, 'Goal of business?', 'Profit', 'Loss', 'Charity', 'None', 'A', 1.00, 'Easy'),
(118, 2, 6, 'Supervision is?', 'Monitoring work', 'Planning', 'Recruitment', 'Staffing', 'A', 1.00, 'Medium'),
(119, 2, 6, 'Insurance is?', 'Risk coverage', 'Profit plan', 'Tax scheme', 'Production', 'A', 1.00, 'Medium'),
(120, 2, 6, 'Warehouse is used for?', 'Storage', 'Selling', 'Recruiting', 'Marketing', 'A', 1.00, 'Easy'),
(121, 3, 7, 'Who is the current UN Secretary-General?', 'António Guterres', 'Ban Ki-moon', 'Kofi Annan', 'Boutros Boutros-Ghali', 'A', 1.00, 'Medium'),
(122, 3, 7, 'Which planet is called Red Planet?', 'Mars', 'Jupiter', 'Saturn', 'Venus', 'A', 1.00, 'Easy'),
(123, 3, 7, 'First man on the moon?', 'Neil Armstrong', 'Buzz Aldrin', 'Yuri Gagarin', 'Michael Collins', 'A', 1.00, 'Easy'),
(124, 3, 7, 'Olympics 2024 host city?', 'Paris', 'Tokyo', 'Los Angeles', 'Beijing', 'A', 1.00, 'Easy'),
(125, 3, 7, 'Which gas do plants produce?', 'Oxygen', 'Carbon dioxide', 'Nitrogen', 'Hydrogen', 'A', 1.00, 'Easy'),
(126, 3, 7, 'India gained independence in?', '1947', '1950', '1935', '1942', 'A', 1.00, 'Easy'),
(127, 3, 7, 'Longest river in the world?', 'Nile', 'Amazon', 'Yangtze', 'Mississippi', 'A', 1.00, 'Medium'),
(128, 3, 7, 'Smallest country in the world?', 'Vatican City', 'Monaco', 'Malta', 'San Marino', 'A', 1.00, 'Hard'),
(129, 3, 7, 'World’s largest ocean?', 'Pacific', 'Atlantic', 'Indian', 'Arctic', 'A', 1.00, 'Medium'),
(130, 3, 7, 'Nobel Prize in Physics 2023?', 'Pierre Agostini', 'Albert Einstein', 'Isaac Newton', 'Marie Curie', 'A', 1.00, 'Medium'),
(131, 3, 7, 'Which country has maple leaf in flag?', 'Canada', 'USA', 'UK', 'Australia', 'A', 1.00, 'Easy'),
(132, 3, 7, 'Currency of Japan?', 'Yen', 'Dollar', 'Euro', 'Rupee', 'A', 1.00, 'Easy'),
(133, 3, 7, 'Which continent is Sahara Desert in?', 'Africa', 'Asia', 'Europe', 'Australia', 'A', 1.00, 'Easy'),
(134, 3, 7, 'Fastest land animal?', 'Cheetah', 'Lion', 'Tiger', 'Leopard', 'A', 1.00, 'Medium'),
(135, 3, 7, 'Which organ purifies blood?', 'Kidney', 'Heart', 'Liver', 'Lungs', 'A', 1.00, 'Easy'),
(136, 3, 7, 'Biggest planet in solar system?', 'Jupiter', 'Saturn', 'Neptune', 'Earth', 'A', 1.00, 'Easy'),
(137, 3, 7, 'Longest reigning British monarch?', 'Elizabeth II', 'Victoria', 'George III', 'Edward VII', 'A', 1.00, 'Medium'),
(138, 3, 7, 'Which is a greenhouse gas?', 'Carbon dioxide', 'Oxygen', 'Nitrogen', 'Hydrogen', 'A', 1.00, 'Easy'),
(139, 3, 7, 'First Indian woman in space?', 'Kalpana Chawla', 'Sunita Williams', 'Ritu Karidhal', 'Anousheh Ansari', 'A', 1.00, 'Medium'),
(140, 3, 7, 'Current Prime Minister of India?', 'Narendra Modi', 'Manmohan Singh', 'Rahul Gandhi', 'Atal Bihari Vajpayee', 'A', 1.00, 'Easy'),
(141, 3, 8, 'Which country recently launched Artemis I mission?', 'USA', 'India', 'Russia', 'China', 'A', 1.00, 'Medium'),
(142, 3, 8, 'Who won the 2024 Australian Open Men’s singles?', 'Novak Djokovic', 'Rafael Nadal', 'Carlos Alcaraz', 'Daniil Medvedev', 'C', 1.00, 'Medium'),
(143, 3, 8, 'G20 Summit 2025 was held in?', 'Brazil', 'India', 'Japan', 'Germany', 'B', 1.00, 'Easy'),
(144, 3, 8, 'Nobel Peace Prize 2024 winner?', 'Malala Yousafzai', 'UN Peace Council', 'World Food Program', 'Greta Thunberg', 'C', 1.00, 'Medium'),
(145, 3, 8, 'Which Indian state recently launched \"One Nation One Ration Card\" fully?', 'Kerala', 'Rajasthan', 'Punjab', 'Maharashtra', 'D', 1.00, 'Easy'),
(146, 3, 8, 'Which company became first $5 trillion market cap?', 'Apple', 'Microsoft', 'Saudi Aramco', 'Amazon', 'C', 1.00, 'Medium'),
(147, 3, 8, 'Current Chairperson of IMF?', 'Kristalina Georgieva', 'Christine Lagarde', 'Raghuram Rajan', 'David Malpass', 'A', 1.00, 'Medium'),
(148, 3, 8, 'Which country hosted 2024 Olympics?', 'France', 'Japan', 'USA', 'China', 'A', 1.00, 'Easy'),
(149, 3, 8, 'First private company to land on moon?', 'SpaceX', 'Blue Origin', 'ISRO', 'NASA', 'A', 1.00, 'Medium'),
(150, 3, 8, 'Which vaccine was recently approved for malaria?', 'RTS,S/AS01', 'Covaxin', 'Pfizer', 'Moderna', 'A', 1.00, 'Medium'),
(151, 3, 8, 'India’s first green hydrogen plant location?', 'Odisha', 'Gujarat', 'Tamil Nadu', 'Karnataka', 'B', 1.00, 'Medium'),
(152, 3, 8, 'Which country recently banned single-use plastics?', 'India', 'USA', 'Canada', 'Australia', 'A', 1.00, 'Easy'),
(153, 3, 8, 'Nobel Prize in Literature 2024?', 'Annie Ernaux', 'Haruki Murakami', 'Chimamanda Ngozi Adichie', 'Salman Rushdie', 'A', 1.00, 'Medium'),
(154, 3, 8, 'Which company launched AI Chatbot 2025?', 'OpenAI', 'Google', 'Microsoft', 'Meta', 'A', 1.00, 'Medium'),
(155, 3, 8, 'India won ICC cricket trophy in?', '2023', '2022', '2021', '2020', 'A', 1.00, 'Easy'),
(156, 3, 8, 'Which country recently launched 6G satellite?', 'China', 'USA', 'South Korea', 'Japan', 'A', 1.00, 'Medium'),
(157, 3, 8, 'Current UN Secretary-General?', 'Antonio Guterres', 'Ban Ki-moon', 'Kofi Annan', 'Boutros Boutros-Ghali', 'A', 1.00, 'Hard'),
(158, 3, 8, 'Which Indian state got UNESCO World Heritage site recently?', 'Madhya Pradesh', 'Rajasthan', 'Tamil Nadu', 'Gujarat', 'A', 1.00, 'Medium'),
(159, 3, 8, 'COP28 conference 2025 held in?', 'UAE', 'India', 'Germany', 'Brazil', 'A', 1.00, 'Medium'),
(160, 3, 8, 'Which country legalized electric vehicles target by 2030?', 'Norway', 'USA', 'India', 'China', 'A', 1.00, 'Hard'),
(161, 3, 8, 'India’s new digital currency launched?', 'Digital Rupee', 'Bitcoin', 'Ethereum', 'Tether', 'A', 1.00, 'Medium');

-- --------------------------------------------------------

--
-- Table structure for table `question_banks`
--

CREATE TABLE `question_banks` (
  `bank_id` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_banks`
--

INSERT INTO `question_banks` (`bank_id`, `bank_name`, `description`, `created_at`) VALUES
(1, 'Science Bank', 'Covers Physics, Chemistry, Biology for 11th & 12th', '2025-12-02 23:34:16'),
(2, 'Commerce Bank', 'Covers Accounts, Economics, Business Studies', '2025-12-02 23:34:16'),
(3, 'General Knowledge Bank', 'Covers GK & Current Affairs', '2025-12-02 23:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `question_bank_subjects`
--

CREATE TABLE `question_bank_subjects` (
  `id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `question_bank_subjects`
--

INSERT INTO `question_bank_subjects` (`id`, `bank_id`, `subject_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 4),
(5, 2, 5),
(6, 2, 6),
(7, 3, 7),
(8, 3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `roll_no` varchar(50) NOT NULL,
  `section` varchar(10) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `class_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `name`, `email`, `password_hash`, `roll_no`, `section`, `phone`, `status`, `class_id`) VALUES
(1, 'Alice Smith', 'alice@example.com', '$2y$10$7j8dFZiGN2oq7yInVX/jjOabkz2L8G4tN77M4zNIXDl/GV5gQHIGa', 'R101', 'A', '2474787989', 'Active', 1),
(2, 'Bob Johnson', 'bob@example.com', '$2y$10$q2XZ8yPb3Muf87.ZwSOARe/qJpYeWaqeaqRgbL.2eRChTYUyHc4FW', 'R102', 'A', '9876543240', 'Active', 1),
(3, 'Charlie Lee', 'charlie@example.com', '$2y$10$rsd52aQbleYu.4TIgeNi3.VCUhX.PAtd6Rkf9PYTBGxWnw.Wg/N1K', 'R103', 'B', '2474787989', 'Active', 2),
(4, 'David Kim', 'david@example.com', '$2y$10$e0acpkCPBO1j2xTs5JyuE.Ctf8t7wnoetrvIdYMRGNoPmtZUD519e', 'R104', 'B', '9876543210', 'Active', 2),
(5, 'Eva Brown', 'eva@example.com', '$2y$10$.OsDKLzUOCgr4ZAzxRt9juQ1VybhacyxhXDLASyV/73yD5Jt9KbfG', 'R105', 'C', '0233758449', 'Active', 3),
(6, 'Frank White', 'frank@example.com', '$2y$10$f2r4fEaIL8RVUFxhxMy2WO0Lw7EQxHFtgT5VQgw6XK7Kx1jTi1.4u', 'R106', 'C', '0233758449', 'Active', 3),
(7, 'Grace Hall', 'grace@example.com', '$2y$10$4WpfhrLeZmzH7F2z4yxjlOJckmY1Ki4FnFtV5wE8xIjdRwYIpyLXC', 'R107', 'D', '374848893', 'Active', 4),
(8, 'Henry Scott', 'henry@example.com', '$2y$10$olV3n8RAuh1xEySyXjPa3.3L0TEI4hfWb2CdrvagxxPw9BhxDNbjO', 'R108', 'D', '1327449392', 'Active', 4),
(9, 'Isla Adams', 'isla@example.com', '$2y$10$3i0F.QW8nvrluIffAUaCIO.dVROwaiNFYiiKgtg67Z.pRLduNLgr.', 'R109', 'A', '9237223367', 'Active', 1),
(10, 'Jack Baker', 'jack@example.com', '$2y$10$apxAwVmNVZ7conlco5yz7.jB9EP/dne.V4aBdaGOam6UbNO8QO6z6', 'R110', 'A', '982233778', 'Active', 1),
(11, 'Martin Smith', 'martin@example.com', '$2y$10$wiA1Ew/W5zePGgWa.4WPqeEExkD1BV5I41oe8iOimy4JleQ47SMim', 'R114', 'A', '1327449392', 'Active', 1);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `description`, `created_at`) VALUES
(1, 'Physics', 'Mechanics, Waves, EM, Modern Physics', '2024-01-11 13:00:00'),
(2, 'Chemistry', 'Organic, Inorganic, Physical Chemistry', '2024-01-14 13:00:00'),
(3, 'Biology', 'Botany, Zoology, Genetics, Evolution', '2024-01-17 13:00:00'),
(4, 'Accountancy', 'Financial Accounting, Ledger, Final Accounts', '2024-02-01 13:00:00'),
(5, 'Economics', 'Micro, Macro, Indian Economy', '2024-02-03 13:00:00'),
(6, 'Business Studies', 'Management, Marketing, Finance', '2024-02-05 13:00:00'),
(7, 'General Knowledge', 'Static GK, Geography, Polity, History', '2024-02-29 13:00:00'),
(8, 'Current Affairs', 'Latest National & International news', '2025-12-02 23:48:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `classrooms`
--
ALTER TABLE `classrooms`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`exam_id`);

--
-- Indexes for table `exam_answers`
--
ALTER TABLE `exam_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `result_id` (`result_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `exam_assigned_students`
--
ALTER TABLE `exam_assigned_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `exam_links`
--
ALTER TABLE `exam_links`
  ADD PRIMARY KEY (`link_id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `exam_question_sources`
--
ALTER TABLE `exam_question_sources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_id` (`exam_id`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `link_id` (`link_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `bank_id` (`bank_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `question_banks`
--
ALTER TABLE `question_banks`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `question_bank_subjects`
--
ALTER TABLE `question_bank_subjects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bank_id` (`bank_id`,`subject_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_student_class` (`class_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `subject_name` (`subject_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `classrooms`
--
ALTER TABLE `classrooms`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `exam_answers`
--
ALTER TABLE `exam_answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `exam_assigned_students`
--
ALTER TABLE `exam_assigned_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT for table `exam_links`
--
ALTER TABLE `exam_links`
  MODIFY `link_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `exam_questions`
--
ALTER TABLE `exam_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=767;

--
-- AUTO_INCREMENT for table `exam_question_sources`
--
ALTER TABLE `exam_question_sources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `question_banks`
--
ALTER TABLE `question_banks`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `question_bank_subjects`
--
ALTER TABLE `question_bank_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exam_answers`
--
ALTER TABLE `exam_answers`
  ADD CONSTRAINT `exam_answers_ibfk_1` FOREIGN KEY (`result_id`) REFERENCES `exam_results` (`result_id`),
  ADD CONSTRAINT `exam_answers_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`);

--
-- Constraints for table `exam_links`
--
ALTER TABLE `exam_links`
  ADD CONSTRAINT `exam_links_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_questions`
--
ALTER TABLE `exam_questions`
  ADD CONSTRAINT `exam_questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `exam_questions_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_question_sources`
--
ALTER TABLE `exam_question_sources`
  ADD CONSTRAINT `exam_question_sources_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`),
  ADD CONSTRAINT `exam_results_ibfk_2` FOREIGN KEY (`link_id`) REFERENCES `exam_links` (`link_id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`bank_id`) REFERENCES `question_banks` (`bank_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_student_class` FOREIGN KEY (`class_id`) REFERENCES `classrooms` (`class_id`) ON DELETE CASCADE;
COMMIT;
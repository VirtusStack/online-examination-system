CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `exams` (
  `exam_id` int(11) NOT NULL,
  `exam_title` varchar(200) NOT NULL,
  `exam_description` text DEFAULT NULL,
  `total_questions` int(11) DEFAULT 0,
  `duration_minutes` int(11) DEFAULT 30,
  `shuffle_questions` tinyint(1) DEFAULT 1,
  `shuffle_options` tinyint(1) DEFAULT 1,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `passing_marks` decimal(5,2) DEFAULT 0.00,
  `negative_marking` decimal(5,2) DEFAULT 0.00,
  `status` enum('Active','Inactive') DEFAULT 'Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `exam_answers` (
  `id` int(11) NOT NULL,
  `result_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_option` enum('A','B','C','D') DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `exam_links` (
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

CREATE TABLE IF NOT EXISTS `exam_questions` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `exam_question_sources` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `difficulty` enum('Easy','Medium','Hard') DEFAULT NULL,
  `question_limit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `exam_results` (
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

CREATE TABLE IF NOT EXISTS `questions` (
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

CREATE TABLE IF NOT EXISTS `question_banks` (
  `bank_id` int(11) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add primary keys and indexes (structure only)
ALTER TABLE `admin` ADD PRIMARY KEY (`admin_id`), ADD UNIQUE KEY `email` (`email`);
ALTER TABLE `exams` ADD PRIMARY KEY (`exam_id`);
ALTER TABLE `exam_answers` ADD PRIMARY KEY (`id`), ADD KEY `result_id` (`result_id`), ADD KEY `question_id` (`question_id`);
ALTER TABLE `exam_links` ADD PRIMARY KEY (`link_id`), ADD KEY `exam_id` (`exam_id`);
ALTER TABLE `exam_questions` ADD PRIMARY KEY (`id`), ADD KEY `exam_id` (`exam_id`), ADD KEY `question_id` (`question_id`);
ALTER TABLE `exam_question_sources` ADD PRIMARY KEY (`id`), ADD KEY `exam_id` (`exam_id`);
ALTER TABLE `exam_results` ADD PRIMARY KEY (`result_id`), ADD KEY `exam_id` (`exam_id`), ADD KEY `link_id` (`link_id`);
ALTER TABLE `questions` ADD PRIMARY KEY (`question_id`), ADD KEY `bank_id` (`bank_id`), ADD KEY `subject_id` (`subject_id`);
ALTER TABLE `question_banks` ADD PRIMARY KEY (`bank_id`);
ALTER TABLE `subjects` ADD PRIMARY KEY (`subject_id`), ADD UNIQUE KEY `subject_name` (`subject_name`);
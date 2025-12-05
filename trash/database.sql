-- =============================
-- ADMIN
-- =============================
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- CLASSROOMS
-- =============================
CREATE TABLE IF NOT EXISTS `classrooms` (
  `class_id` INT(11) NOT NULL AUTO_INCREMENT,
  `class_name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- EXAMS
-- =============================
CREATE TABLE IF NOT EXISTS `exams` (
  `exam_id` INT(11) NOT NULL AUTO_INCREMENT,
  `exam_title` VARCHAR(200) NOT NULL,
  `exam_description` TEXT DEFAULT NULL,
  `total_questions` INT(11) DEFAULT 0,
  `duration_minutes` INT(11) DEFAULT 30,
  `shuffle_questions` TINYINT(1) DEFAULT 1,
  `shuffle_options` TINYINT(1) DEFAULT 1,
  `rules_page` TINYINT(1) DEFAULT 0,
  `start_time` DATETIME DEFAULT NULL,
  `end_time` DATETIME DEFAULT NULL,
  `passing_marks` DECIMAL(5,2) DEFAULT 0.00,
  `negative_marking` DECIMAL(5,2) DEFAULT 0.00,
  `status` ENUM('Active','Inactive') DEFAULT 'Inactive',
  `assign_type` ENUM('class','individual') DEFAULT 'individual',
  `assign_data` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  `easy_percentage` INT(11) DEFAULT 0,
  `medium_percentage` INT(11) DEFAULT 0,
  `hard_percentage` INT(11) DEFAULT 0,
  PRIMARY KEY (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- EXAM ANSWERS
-- =============================
CREATE TABLE IF NOT EXISTS `exam_answers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `result_id` INT(11) NOT NULL,
  `question_id` INT(11) NOT NULL,
  `selected_option` ENUM('A','B','C','D') DEFAULT NULL,
  `is_correct` TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `result_id` (`result_id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- ASSIGNED STUDENTS
-- =============================
CREATE TABLE IF NOT EXISTS `exam_assigned_students` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `exam_id` INT(11) NOT NULL,
  `student_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_id` (`exam_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- EXAM LINKS
-- =============================
CREATE TABLE IF NOT EXISTS `exam_links` (
  `link_id` INT(11) NOT NULL AUTO_INCREMENT,
  `exam_id` INT(11) NOT NULL,
  `unique_link` VARCHAR(255) NOT NULL,
  `password` VARCHAR(100) DEFAULT NULL,
  `student_name` VARCHAR(150) DEFAULT NULL,
  `student_email` VARCHAR(200) DEFAULT NULL,
  `student_class` VARCHAR(50) DEFAULT NULL,
  `expires_at` DATETIME DEFAULT NULL,
  `is_used` TINYINT(1) DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`link_id`),
  KEY `exam_id` (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- EXAM QUESTIONS
-- =============================
CREATE TABLE IF NOT EXISTS `exam_questions` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `exam_id` INT(11) NOT NULL,
  `question_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_id` (`exam_id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- QUESTION SOURCES
-- =============================
CREATE TABLE IF NOT EXISTS `exam_question_sources` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `exam_id` INT(11) NOT NULL,
  `bank_id` INT(11) DEFAULT NULL,
  `subject_id` INT(11) DEFAULT NULL,
  `difficulty` ENUM('Easy','Medium','Hard') DEFAULT NULL,
  `question_limit` INT(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_id` (`exam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- EXAM RESULTS
-- =============================
CREATE TABLE IF NOT EXISTS `exam_results` (
  `result_id` INT(11) NOT NULL AUTO_INCREMENT,
  `link_id` INT(11) NOT NULL,
  `exam_id` INT(11) NOT NULL,
  `student_name` VARCHAR(150) DEFAULT NULL,
  `student_email` VARCHAR(200) DEFAULT NULL,
  `total_marks` DECIMAL(5,2) DEFAULT 0.00,
  `obtained_marks` DECIMAL(5,2) DEFAULT 0.00,
  `started_at` DATETIME DEFAULT NULL,
  `submitted_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`result_id`),
  KEY `exam_id` (`exam_id`),
  KEY `link_id` (`link_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- QUESTIONS
-- =============================
CREATE TABLE IF NOT EXISTS `questions` (
  `question_id` INT(11) NOT NULL AUTO_INCREMENT,
  `bank_id` INT(11) NOT NULL,
  `subject_id` INT(11) NOT NULL,
  `question_text` TEXT NOT NULL,
  `option_a` VARCHAR(255) DEFAULT NULL,
  `option_b` VARCHAR(255) DEFAULT NULL,
  `option_c` VARCHAR(255) DEFAULT NULL,
  `option_d` VARCHAR(255) DEFAULT NULL,
  `correct_option` ENUM('A','B','C','D') NOT NULL,
  `marks_per_question` DECIMAL(5,2) DEFAULT 1.00,
  `difficulty` ENUM('Easy','Medium','Hard') DEFAULT 'Easy',
  PRIMARY KEY (`question_id`),
  KEY `bank_id` (`bank_id`),
  KEY `subject_id` (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- QUESTION BANKS
-- =============================
CREATE TABLE IF NOT EXISTS `question_banks` (
  `bank_id` INT(11) NOT NULL AUTO_INCREMENT,
  `bank_name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- BANK SUBJECTS
-- =============================
CREATE TABLE IF NOT EXISTS `question_bank_subjects` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `bank_id` INT(11) NOT NULL,
  `subject_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bank_subject` (`bank_id`,`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- STUDENTS
-- =============================
CREATE TABLE IF NOT EXISTS `students` (
  `student_id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `roll_no` VARCHAR(50) NOT NULL,
  `section` VARCHAR(10) DEFAULT NULL,
  `phone` VARCHAR(15) DEFAULT NULL,
  `status` ENUM('Active','Inactive') DEFAULT 'Active',
  `class_id` INT(11) NOT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE (`email`),
  KEY `fk_student_class` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- SUBJECTS
-- =============================
CREATE TABLE IF NOT EXISTS `subjects` (
  `subject_id` INT(11) NOT NULL AUTO_INCREMENT,
  `subject_name` VARCHAR(100) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`subject_id`),
  UNIQUE KEY `subject_name` (`subject_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- =============================
-- FOREIGN KEYS
-- =============================
ALTER TABLE `exam_answers`
  ADD CONSTRAINT `ea_result_fk` FOREIGN KEY (`result_id`) REFERENCES `exam_results` (`result_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ea_question_fk` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE;

ALTER TABLE `exam_links`
  ADD CONSTRAINT `el_exam_fk` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE;

ALTER TABLE `exam_questions`
  ADD CONSTRAINT `eq_exam_fk` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `eq_question_fk` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE;

ALTER TABLE `exam_question_sources`
  ADD CONSTRAINT `eqs_exam_fk` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE;

ALTER TABLE `exam_results`
  ADD CONSTRAINT `er_exam_fk` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `er_link_fk` FOREIGN KEY (`link_id`) REFERENCES `exam_links` (`link_id`) ON DELETE CASCADE;

ALTER TABLE `questions`
  ADD CONSTRAINT `q_bank_fk` FOREIGN KEY (`bank_id`) REFERENCES `question_banks` (`bank_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `q_subject_fk` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE;

ALTER TABLE `students`
  ADD CONSTRAINT `student_class_fk` FOREIGN KEY (`class_id`) REFERENCES `classrooms` (`class_id`) ON DELETE CASCADE;

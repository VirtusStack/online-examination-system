USE online_exam_system;

-- Admin
INSERT INTO `admin` (`admin_id`, `name`, `email`, `password_hash`, `created_at`) VALUES
(1, 'admin', 'admin@12.com', '$2y$10$T3g4wVh2ygCCvDPKOiTeteYmGB6RbLtSTpWN25/glk0z8EnF3vVVS', '2025-11-25 01:18:44');

-- Exams
INSERT INTO `exams` (`exam_id`, `exam_title`, `exam_description`, `total_questions`, `duration_minutes`, `shuffle_questions`, `shuffle_options`, `start_time`, `end_time`, `passing_marks`, `negative_marking`, `status`, `created_at`) VALUES
(1, 'Math Exam 1', '', 10, 30, 1, 1, NULL, NULL, 0.00, 0.00, 'Active', '2025-11-26 07:19:30'),
(2, 'Physics Exam 1', 'Basic Physics Exam', 5, 30, 1, 1, '2025-12-02 10:00:00', '2025-12-02 11:00:00', 50.00, 0.00, 'Active', '2025-11-26 07:19:30'),
(3, 'Chemistry Exam 1', 'Basic Chemistry Exam', 5, 30, 1, 1, '2025-12-03 10:00:00', '2025-12-03 11:00:00', 50.00, 0.00, 'Active', '2025-11-26 07:19:30'),
(4, 'Biology Exam 1', 'Basic Biology Exam', 5, 30, 1, 1, '2025-12-04 10:00:00', '2025-12-04 11:00:00', 50.00, 0.00, 'Active', '2025-11-26 07:19:30'),
(5, 'CS Exam 1', 'Basic CS Exam', 5, 30, 1, 1, '2025-12-05 10:00:00', '2025-12-05 11:00:00', 50.00, 0.00, 'Active', '2025-11-26 07:19:30');

-- Exam Answers
INSERT INTO `exam_answers` (`id`, `result_id`, `question_id`, `selected_option`, `is_correct`) VALUES
(1, 1, 1, 'B', 1),
(2, 1, 2, 'A', 1),
(3, 2, 3, 'A', 1),
(4, 2, 4, 'A', 1);

-- Exam Links
INSERT INTO `exam_links` (`link_id`, `exam_id`, `unique_link`, `password`, `student_name`, `student_email`, `student_class`, `expires_at`, `is_used`, `created_at`) VALUES
(1, 1, 'link1', NULL, 'Alice', 'alice@example.com', '10th', '2025-12-10 23:59:59', 0, '2025-11-26 07:20:48'),
(2, 2, 'link2', NULL, 'Bob', 'bob@example.com', '10th', '2025-12-11 23:59:59', 0, '2025-11-26 07:20:48'),
(3, 3, 'link3', NULL, 'Charlie', 'charlie@example.com', '10th', '2025-12-12 23:59:59', 0, '2025-11-26 07:20:48'),
(4, 4, 'link4', NULL, 'David', 'david@example.com', '10th', '2025-12-13 23:59:59', 0, '2025-11-26 07:20:48'),
(5, 5, 'link5', NULL, 'Eve', 'eve@example.com', '10th', '2025-12-14 23:59:59', 0, '2025-11-26 07:20:48'),
(6, 4, 'f4ef69ef55c34b57', 'pass123', 'bob', '', '', '2025-12-03 00:00:00', 0, '2025-11-26 08:11:37'),
(7, 2, '584c99dcbef64050', 'pass@12', '', '', 'bscit', '2025-12-04 00:00:00', 0, '2025-11-26 08:37:42');

-- Exam Questions
INSERT INTO `exam_questions` (`id`, `exam_id`, `question_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 3),
(4, 2, 4),
(5, 3, 5),
(6, 3, 6),
(7, 4, 7),
(8, 5, 8);

-- Exam Question Sources
INSERT INTO `exam_question_sources` (`id`, `exam_id`, `bank_id`, `subject_id`, `difficulty`, `question_limit`) VALUES
(1, 1, 1, 1, 'Easy', 2),
(2, 2, 2, 2, 'Medium', 2),
(3, 3, 3, 3, 'Easy', 2),
(4, 4, 4, 4, 'Medium', 2),
(5, 5, 5, 5, 'Easy', 2);

-- Exam Results
INSERT INTO `exam_results` (`result_id`, `link_id`, `exam_id`, `student_name`, `student_email`, `total_marks`, `obtained_marks`, `started_at`, `submitted_at`) VALUES
(1, 1, 1, 'Alice', 'alice@example.com', 5.00, 4.00, '2025-12-10 10:00:00', '2025-12-10 10:30:00'),
(2, 2, 2, 'Bob', 'bob@example.com', 5.00, 3.00, '2025-12-11 10:00:00', '2025-12-11 10:30:00');

-- Questions
INSERT INTO `questions` (`question_id`, `bank_id`, `subject_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks_per_question`, `difficulty`) VALUES
(1, 1, 1, '2 + 2 = ?', '3', '4', '5', '6', 'B', 1.00, 'Easy'),
(2, 1, 1, '5 * 6 = ?', '30', '25', '35', '20', 'A', 1.00, 'Easy'),
(3, 2, 2, 'Speed of light?', '3x10^8 m/s', '5x10^6 m/s', '1x10^8 m/s', '7x10^7 m/s', 'A', 1.00, 'Medium'),
(4, 2, 2, 'Newton''s 2nd Law?', 'F=ma', 'E=mc^2', 'P=mv', 'V=IR', 'A', 1.00, 'Medium'),
(5, 3, 3, 'Water formula?', 'H2O', 'CO2', 'O2', 'H2', 'A', 1.00, 'Easy'),
(6, 3, 3, 'Boiling point of water?', '100°C', '90°C', '80°C', '120°C', 'A', 1.00, 'Easy'),
(7, 4, 4, 'Largest organ in human body?', 'Skin', 'Liver', 'Heart', 'Lungs', 'A', 1.00, 'Medium'),
(8, 5, 5, 'What does HTML stand for?', 'Hyper Text Markup Language', 'Hyperlinks and Text Markup Language', 'Home Tool Markup Language', 'Hyper Tool Multi Language', 'A', 1.00, 'Easy'),
(9, 5, 5, 'What is CSS?', 'Cascading Style Sheets', 'Creative Style Sheets', 'Colorful Style Sheets', 'Computer Style Sheets', 'A', 1.00, 'Easy');

-- Question Banks
INSERT INTO `question_banks` (`bank_id`, `bank_name`, `description`, `created_at`) VALUES
(1, 'Math Bank 1', 'Algebra and arithmetic questions', '2025-11-26 07:18:37'),
(2, 'Physics Bank 1', 'Mechanics questions', '2025-11-26 07:18:37'),
(3, 'Chemistry Bank 1', 'Chemical reactions questions', '2025-11-26 07:18:37'),
(4, 'Biology Bank 1', 'Human biology questions', '2025-11-26 07:18:37'),
(5, 'CS Bank 1', 'Programming questions', '2025-11-26 07:18:37');

-- Subjects
INSERT INTO `subjects` (`subject_id`, `subject_name`, `description`, `created_at`) VALUES
(1, 'Mathematics', 'Basic and advanced math topics', '2025-11-26 07:18:15'),
(2, 'Physics', 'Mechanics, optics, thermodynamics', '2025-11-26 07:18:15'),
(3, 'Chemistry', 'Organic, inorganic, and physical chemistry', '2025-11-26 07:18:15'),
(4, 'Biology', 'Botany, Zoology, Genetics', '2025-11-26 07:18:15'),
(5, 'Computer Science', 'Programming, algorithms, data structures', '2025-11-26 07:18:15');

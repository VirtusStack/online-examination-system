INSERT INTO `admin` (`admin_id`, `name`, `email`, `password_hash`, `created_at`) VALUES
(1, 'admin', 'admin@12.com', '$2y$10$T3g4wVh2ygCCvDPKOiTeteYmGB6RbLtSTpWN25/glk0z8EnF3vVVS', '0000-00-00 00:00:00');

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`exam_id`, `subject_id`, `exam_title`, `duration_minutes`, `total_marks`, `start_date`, `end_date`, `status`, `created_at`) VALUES
(1, 1, 'Mathematics Exam 1', 30, 5.00, '2025-11-15 11:00:00', '2025-11-15 11:30:00', 'Active', '2025-11-17 10:15:42'),
(2, 2, 'Physics Exam 1', 30, 4.00, '2025-11-21 11:00:00', '2025-11-21 11:30:00', 'Active', '2025-11-17 11:35:32'),
(3, 2, 'Physics Exam 2', 30, 4.00, '2025-11-21 11:00:00', '2025-11-21 11:30:00', 'Active', '2025-11-17 11:35:44'),
(4, 5, 'Computer Science Exam 1', 30, 30.00, '2025-11-21 11:00:00', '2025-11-21 11:30:00', 'Active', '2025-11-17 13:20:15');

--
-- Dumping data for table `exam_questions`
--

INSERT INTO `exam_questions` (`id`, `exam_id`, `question_id`) VALUES
(22, 4, 8),
(23, 1, 2),
(24, 1, 1),
(28, 2, 7),
(29, 2, 6),
(30, 2, 5),
(31, 3, 5),
(32, 3, 4);

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `bank_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `marks`, `negative_marks`, `difficulty`, `created_at`) VALUES
(1, 1, 'Solve 2x + 3 = 7. Find x.', '1', '2', '3', '4', 'A', 1.00, 0.00, 'Easy', '2025-11-17 10:09:13'),
(2, 1, 'What is (x+2)(x-3)?', 'x^2 - x - 6', 'x^2 + x - 6', 'x^2 - 6', 'x^2 + 6', 'A', 1.00, 0.00, 'Medium', '2025-11-15 01:40:00'),
(3, 2, 'Sum of angles in a triangle?', '90', '180', '360', '270', 'B', 1.00, 0.00, 'Easy', '2025-11-15 01:50:00'),
(4, 2, 'Area of circle formula?', 'πr^2', '2πr', 'πd', 'πr', 'A', 1.00, 0.00, 'Easy', '2025-11-15 02:00:00'),
(5, 3, 'Newton’s second law?', 'F = ma', 'E = mc^2', 'P = mv', 'V = IR', 'A', 1.00, 0.00, 'Easy', '2025-11-15 02:10:00'),
(6, 3, 'Unit of force?', 'Newton', 'Joule', 'Watt', 'Pascal', 'A', 1.00, 0.00, 'Easy', '2025-11-15 02:20:00'),
(7, 4, 'Speed of light in vacuum?', '3×10^8 m/s', '1.5×10^8 m/s', '3×10^6 m/s', '3×10^9 m/s', 'A', 1.00, 0.00, 'Easy', '2025-11-15 02:30:00'),
(8, 5, 'Which language is used for web development?', 'Python', 'HTML', 'C++', 'Java', 'B', 1.00, 0.00, 'Easy', '2025-11-15 02:40:00'),
(9, 5, 'What is the output of print(2 + 3)?', '23', '5', '2+3', 'Error', 'B', 1.00, 0.00, 'Easy', '2025-11-15 02:50:00');

--
-- Dumping data for table `question_banks`
--

INSERT INTO `question_banks` (`bank_id`, `subject_id`, `bank_name`, `description`, `created_at`) VALUES
(1, 1, 'Algebra Bank', 'Questions related to algebra', '2025-11-17 10:03:41'),
(2, 1, 'Geometry Bank', 'Questions related to geometry', '2025-11-17 10:05:08'),
(3, 2, 'Mechanics Bank', 'Questions on motion and forces', '0000-00-00 00:00:00'),
(4, 2, 'Optics Bank', 'Questions on light and optics', '0000-00-00 00:00:00'),
(5, 5, 'Programming Bank', 'Basic programming questions', '0000-00-00 00:00:00');

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `description`, `created_at`) VALUES
(1, 'Mathematics', 'Covers algebra, geometry, trigonometry, and basic calculus\', '2025-11-15 04:30:00'),
(2, 'Physics', 'Covers motion, heat, light, and electricity', '2025-11-15 04:40:00'),
(3, 'Chemistry', 'Covers organic, inorganic, and physical chemistry', '2025-11-15 04:50:00'),
(4, 'Biology', 'Covers cell biology, genetics, human body.', '2025-11-15 05:00:00'),
(5, 'Computer Science', 'Covers basics of programming, DBMS, networking', '2025-11-15 05:10:00');
COMMIT;


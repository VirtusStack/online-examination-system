-- -------------------------------
-- Exams
-- -------------------------------
INSERT INTO `exams` ( `exam_title`, `exam_description`, `total_questions`, `total_marks`, `pass_marks`, `duration_minutes`, `shuffle_questions`, `shuffle_options`, `start_time`, `end_time`, `negative_marking`, `status`, `assign_type`, `assign_data`, `created_at`, `easy_percentage`, `medium_percentage`, `hard_percentage`) VALUES
( 'Science Midterm Exam', 'Covers Physics, Chemistry, Biology', 10, 0.00, 0.00, 30, 1, 1, '2025-12-06 12:00:00', '2025-12-06 17:35:00', 0.00, 'Inactive', 'class', NULL, '2025-12-02 13:20:17', 70, 20, 10),
( 'Commerce Midterm Exam', 'Covers Accountancy, Economics, Business Studies', 3, 0.00, 0.00, 30, 1, 1, '2025-12-03 12:05:00', '2025-12-03 12:35:00', 0.00, 'Inactive', 'class', NULL, '2025-12-02 14:05:11', 0, 0, 0),
( 'GK Midterm Exam', 'Current Affairs and General Knowledge', 30, 0.00, 0.00, 30, 1, 1, '2025-12-04 14:00:00', '2025-12-04 19:30:00', 0.00, 'Inactive', 'class', NULL, '2025-12-03 16:01:14', 70, 20, 10),
( 'mix', 'Biology and Gk', 30, 0.00, 0.00, 30, 1, 1, '2025-12-04 18:18:00', '2025-12-04 19:30:00', 0.00, 'Inactive', 'class', NULL, '2025-12-03 20:19:58', 0, 0, 0),
('Commerce', 'Business Studies and Economics', 30, 0.00, 0.00, 30, 1, 1, '2025-12-06 12:20:00', '2025-12-06 19:30:00', 0.00, 'Inactive', 'class', NULL, '2025-12-03 21:09:51', 60, 30, 10),
('Science', 'biology and chemistry', 20, 20.00, 7.00, 30, 1, 1, '2025-12-13 10:00:00', '2025-12-13 19:34:00', 0.00, 'Inactive', 'class', NULL, '2025-12-03 21:34:33', 60, 20, 20),
('Science exam', 'Biology and Physics', 20, 0.00, 0.00, 30, 1, 1, '2025-12-09 10:30:00', '2025-12-09 19:30:00', 0.00, 'Inactive', 'class', NULL, '2025-12-04 12:31:10', 60, 30, 10),
('Art', 'GK and Current Affairs', 30, 0.00, 0.00, 30, 1, 1, '2025-12-08 11:00:00', '2025-12-08 19:28:00', 0.00, 'Inactive', 'class', NULL, '2025-12-04 14:23:19', 60, 30, 10),
('Gk', 'General Knowledge', 10, 10.00, 4.00, 30, 1, 0, '2025-12-06 12:10:00', '2025-12-06 18:00:00', 0.00, 'Inactive', 'class', NULL, '2025-12-05 14:47:13', 70, 20, 10),
('Chemistry', 'Science', 10, 20.00, 14.00, 30, 1, 1, '2025-12-13 11:00:00', '2025-12-13 19:30:00', 0.00, 'Inactive', 'class', NULL, '2025-12-08 18:02:41', 60, 20, 20);

-- -------------------------------
-- Exam links
-- -------------------------------
INSERT INTO `exam_links` ( `exam_id`, `unique_link`, `password`, `student_name`, `student_email`, `student_class`, `expires_at`, `is_used`, `created_at`) VALUES
(1, 'exam_692fcf9984a537.76633127', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', 'Alice Smith', 'alice@example.com', NULL, '2025-12-03 12:32:00', 0, '2025-12-02 13:20:17'),
(1, 'exam_692fcf9986ae43.68810739', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-03 12:32:00', 0, '2025-12-02 13:20:17'),
( 1, 'exam_692fcf99875d84.58635436', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', 'Isla Adams', 'isla@example.com', NULL, '2025-12-03 12:32:00', 0, '2025-12-02 13:20:17'),
( 1, 'exam_692fcf9987efa9.44783430', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', 'Jack Baker', 'jack@example.com', NULL, '2025-12-03 12:32:00', 0, '2025-12-02 13:20:17'),
( 1, 'exam-1-90c560f7', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', NULL, NULL, NULL, '2025-12-03 12:32:00', 0, '2025-12-02 13:20:17'),
( 2, 'exam_692fda1f1ba752.47433683', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', 'Alice Smith', 'alice@example.com', NULL, '2025-12-03 13:07:00', 0, '2025-12-02 14:05:11'),
( 2, 'exam-2-b06d2abe', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', NULL, NULL, NULL, '2025-12-03 13:07:00', 0, '2025-12-02 14:05:11'),
(2, 'exam_692fdaaf044c64.50989660', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-03 13:07:00', 0, '2025-12-02 14:07:35'),
( 2, 'exam_692fdaaf058051.62156593', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', 'Isla Adams', 'isla@example.com', NULL, '2025-12-03 13:07:00', 0, '2025-12-02 14:07:35'),
( 2, 'exam_692fdaaf06a1e7.06203442', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', 'Jack Baker', 'jack@example.com', NULL, '2025-12-03 13:07:00', 0, '2025-12-02 14:07:35'),
( 3, 'exam_693146d2c23fd8.96082513', '$2y$10$22lInCPZBL98mtJcUB43g.DM.ZF7TkTEVed3.rMcCYJNrnYCy0jHW', 'Alice Smith', 'alice@example.com', NULL, '2025-12-04 19:36:00', 0, '2025-12-03 16:01:14'),
( 3, 'exam_693146d2c3b011.13586377', '$2y$10$22lInCPZBL98mtJcUB43g.DM.ZF7TkTEVed3.rMcCYJNrnYCy0jHW', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-04 19:36:00', 0, '2025-12-03 16:01:14'),
( 3, 'exam_693146d2c4bfc8.17044816', '$2y$10$22lInCPZBL98mtJcUB43g.DM.ZF7TkTEVed3.rMcCYJNrnYCy0jHW', 'Isla Adams', 'isla@example.com', NULL, '2025-12-04 19:36:00', 0, '2025-12-03 16:01:14'),
( 3, 'exam_693146d2c5f450.62745054', '$2y$10$22lInCPZBL98mtJcUB43g.DM.ZF7TkTEVed3.rMcCYJNrnYCy0jHW', 'Jack Baker', 'jack@example.com', NULL, '2025-12-04 19:36:00', 0, '2025-12-03 16:01:14'),
( 3, 'exam-4-fd078b88', '$2y$10$22lInCPZBL98mtJcUB43g.DM.ZF7TkTEVed3.rMcCYJNrnYCy0jHW', NULL, NULL, NULL, '2025-12-04 19:36:00', 0, '2025-12-03 16:01:15'),
(4, 'exam_693183769d73f8.25339927', NULL, 'Alice Smith', 'alice@example.com', NULL, NULL, 0, '2025-12-03 20:19:58'),
( 4, 'exam_693183769f0703.49855114', NULL, 'Bob Johnson', 'bob@example.com', NULL, NULL, 0, '2025-12-03 20:19:58'),
( 4, 'exam_69318376a023a3.77213354', NULL, 'Isla Adams', 'isla@example.com', NULL, NULL, 0, '2025-12-03 20:19:58'),
( 4, 'exam_69318376a22ec9.35373299', NULL, 'Jack Baker', 'jack@example.com', NULL, NULL, 0, '2025-12-03 20:19:58'),
( 4, 'exam-6-fa910817', '$2y$10$YT5qYRwTHrPwmMgQzot5FeU1kMoKJDTngY5NsKgH8pbLIr93gRi3m', NULL, NULL, NULL, '2025-12-04 19:30:00', 0, '2025-12-03 20:19:58'),
( 5, 'exam_69318f276d5d98.80552294', NULL, 'Alice Smith', 'alice@example.com', NULL, '2025-12-06 17:41:00', 0, '2025-12-03 21:09:51'),
( 5, 'exam_69318f276f1c07.96629835', NULL, 'Bob Johnson', 'bob@example.com', NULL, '2025-12-06 17:41:00', 0, '2025-12-03 21:09:51'),
( 5, 'exam_69318f27704447.67883235', NULL, 'Isla Adams', 'isla@example.com', NULL, '2025-12-06 17:41:00', 0, '2025-12-03 21:09:51'),
( 5, 'exam_69318f277266e9.47907509', NULL, 'Jack Baker', 'jack@example.com', NULL, '2025-12-06 17:41:00', 0, '2025-12-03 21:09:51'),
( 5, 'exam-7-eea92ca9', NULL, NULL, NULL, NULL, '2025-12-06 17:41:00', 0, '2025-12-03 21:09:51'),
( 6, 'exam_693194f171d2d6.38351520', '$2y$10$.NAoOX4IzC25GoS79T0fXOT/0LJ1N22QRa.HoWwTOI.dcW7eI1md2', 'Alice Smith', 'alice@example.com', NULL, '2025-12-13 14:24:00', 0, '2025-12-03 21:34:33'),
( 6, 'exam_693194f173cd51.29926238', '$2y$10$.NAoOX4IzC25GoS79T0fXOT/0LJ1N22QRa.HoWwTOI.dcW7eI1md2', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-13 14:24:00', 0, '2025-12-03 21:34:33'),
( 6, 'exam_693194f1751183.86502391', '$2y$10$.NAoOX4IzC25GoS79T0fXOT/0LJ1N22QRa.HoWwTOI.dcW7eI1md2', 'Isla Adams', 'isla@example.com', NULL, '2025-12-13 14:24:00', 0, '2025-12-03 21:34:33'),
( 6, 'exam_693194f176cd16.26821545', '$2y$10$.NAoOX4IzC25GoS79T0fXOT/0LJ1N22QRa.HoWwTOI.dcW7eI1md2', 'Jack Baker', 'jack@example.com', NULL, '2025-12-13 14:24:00', 0, '2025-12-03 21:34:33'),
( 6, 'exam-8-bbe47086', '$2y$10$.NAoOX4IzC25GoS79T0fXOT/0LJ1N22QRa.HoWwTOI.dcW7eI1md2', NULL, NULL, NULL, '2025-12-13 14:24:00', 0, '2025-12-03 21:34:33'),
( 7, 'exam_69326716561ea0.90367878', '$2y$10$mghvRu7zXzVglik31BzH.OiCtiFQdS65dqqI5GVNCcdBYIiUX0E.O', 'Alice Smith', 'alice@example.com', NULL, '2025-12-09 19:00:00', 0, '2025-12-04 12:31:10'),
( 7, 'exam_69326716573042.16669386', '$2y$10$mghvRu7zXzVglik31BzH.OiCtiFQdS65dqqI5GVNCcdBYIiUX0E.O', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-09 19:00:00', 0, '2025-12-04 12:31:10'),
( 7, 'exam_693267165892b6.32140913', '$2y$10$mghvRu7zXzVglik31BzH.OiCtiFQdS65dqqI5GVNCcdBYIiUX0E.O', 'Isla Adams', 'isla@example.com', NULL, '2025-12-09 19:00:00', 0, '2025-12-04 12:31:10'),
( 7, 'exam_6932671659c5f5.33948213', '$2y$10$mghvRu7zXzVglik31BzH.OiCtiFQdS65dqqI5GVNCcdBYIiUX0E.O', 'Jack Baker', 'jack@example.com', NULL, '2025-12-09 19:00:00', 0, '2025-12-04 12:31:10'),
( 7, 'exam-9-92f9121b', '$2y$10$mghvRu7zXzVglik31BzH.OiCtiFQdS65dqqI5GVNCcdBYIiUX0E.O', NULL, NULL, NULL, '2025-12-09 19:00:00', 0, '2025-12-04 12:31:10'),
( 8, 'exam_6932815f12bd53.97690333', '$2y$10$lq2RywVOFDkiByPYJbHs4O0P.UgabUAR79sCoqoJ0AQLoZTBJnKyy', 'Alice Smith', 'alice@example.com', NULL, '2025-12-08 19:30:00', 0, '2025-12-04 14:23:19'),
( 8, 'exam_6932815f140814.35878927', '$2y$10$lq2RywVOFDkiByPYJbHs4O0P.UgabUAR79sCoqoJ0AQLoZTBJnKyy', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-08 19:30:00', 0, '2025-12-04 14:23:19'),
( 8, 'exam_6932815f1526a2.55460779', '$2y$10$lq2RywVOFDkiByPYJbHs4O0P.UgabUAR79sCoqoJ0AQLoZTBJnKyy', 'Isla Adams', 'isla@example.com', NULL, '2025-12-08 19:30:00', 0, '2025-12-04 14:23:19'),
( 8, 'exam_6932815f16f185.17585246', '$2y$10$lq2RywVOFDkiByPYJbHs4O0P.UgabUAR79sCoqoJ0AQLoZTBJnKyy', 'Jack Baker', 'jack@example.com', NULL, '2025-12-08 19:30:00', 0, '2025-12-04 14:23:19'),
( 8, 'exam-10-8045503c', '$2y$10$lq2RywVOFDkiByPYJbHs4O0P.UgabUAR79sCoqoJ0AQLoZTBJnKyy', NULL, NULL, NULL, '2025-12-08 19:30:00', 0, '2025-12-04 14:23:19'),
( 9, 'exam_6933de85de54e2.44420192', '$2y$10$IIh383zpGx725s32KlFut.ghhwLPpsGG/A0MVOPFoJ1fRtm/V5NqC', 'Alice Smith', 'alice@example.com', NULL, '2025-12-12 16:51:00', 0, '2025-12-05 15:13:01'),
( 9, 'exam_6933de85df7f53.91706074', '$2y$10$IIh383zpGx725s32KlFut.ghhwLPpsGG/A0MVOPFoJ1fRtm/V5NqC', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-12 16:51:00', 0, '2025-12-05 15:13:01'),
( 9, 'exam_6933de85e0bcb2.35495952', '$2y$10$IIh383zpGx725s32KlFut.ghhwLPpsGG/A0MVOPFoJ1fRtm/V5NqC', 'Isla Adams', 'isla@example.com', NULL, '2025-12-12 16:51:00', 0, '2025-12-05 15:13:01'),
( 9, 'exam_6933de85e29e82.90994181', '$2y$10$IIh383zpGx725s32KlFut.ghhwLPpsGG/A0MVOPFoJ1fRtm/V5NqC', 'Jack Baker', 'jack@example.com', NULL, '2025-12-12 16:51:00', 0, '2025-12-05 15:13:01'),
( 9, 'exam-11-1da656b9', '$2y$10$IIh383zpGx725s32KlFut.ghhwLPpsGG/A0MVOPFoJ1fRtm/V5NqC', NULL, NULL, NULL, '2025-12-12 16:51:00', 0, '2025-12-05 15:13:02'),
( 10, 'exam_6937fac915cd04.79806351', '$2y$10$wLZr/ykz9k.L8RQcKFGZauLOyFt73etYFKZfMx7/C1X3yTHVZI4P.', 'Charlie Lee', 'charlie@example.com', NULL, '2025-12-13 16:56:00', 0, '2025-12-08 18:02:41'),
( 10, 'exam_6937fac9187fa4.06248514', '$2y$10$wLZr/ykz9k.L8RQcKFGZauLOyFt73etYFKZfMx7/C1X3yTHVZI4P.', 'David Kim', 'david@example.com', NULL, '2025-12-13 16:56:00', 0, '2025-12-08 18:02:41'),
(10, 'exam-12-f338ef9a', '$2y$10$wLZr/ykz9k.L8RQcKFGZauLOyFt73etYFKZfMx7/C1X3yTHVZI4P.', NULL, NULL, NULL, '2025-12-13 16:56:00', 0, '2025-12-08 18:02:41'),
(10, 'exam_6937fc1c48ead9.53586022', '$2y$10$wLZr/ykz9k.L8RQcKFGZauLOyFt73etYFKZfMx7/C1X3yTHVZI4P.', 'Alice Smith', 'alice@example.com', NULL, '2025-12-13 16:56:00', 0, '2025-12-08 18:08:20'),
(10, 'exam_6937fc1c49e604.14573940', '$2y$10$wLZr/ykz9k.L8RQcKFGZauLOyFt73etYFKZfMx7/C1X3yTHVZI4P.', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-13 16:56:00', 0, '2025-12-08 18:08:20'),
(10, 'exam_6937fc1c4b09b9.61425980', '$2y$10$wLZr/ykz9k.L8RQcKFGZauLOyFt73etYFKZfMx7/C1X3yTHVZI4P.', 'Isla Adams', 'isla@example.com', NULL, '2025-12-13 16:56:00', 0, '2025-12-08 18:08:20'),
(10, 'exam_6937fc1c4d5097.14844949', '$2y$10$wLZr/ykz9k.L8RQcKFGZauLOyFt73etYFKZfMx7/C1X3yTHVZI4P.', 'Jack Baker', 'jack@example.com', NULL, '2025-12-13 16:56:00', 0, '2025-12-08 18:08:20'),
(10, 'exam_693bc39eed7963.73523091', '$2y$10$wLZr/ykz9k.L8RQcKFGZauLOyFt73etYFKZfMx7/C1X3yTHVZI4P.', 'Martin Smith', 'martin@example.com', NULL, '2025-12-13 16:56:00', 0, '2025-12-11 20:26:22'),
(6, 'exam_693cff8b0c7d20.07712686', '$2y$10$.NAoOX4IzC25GoS79T0fXOT/0LJ1N22QRa.HoWwTOI.dcW7eI1md2', 'Martin Smith', 'martin@example.com', NULL, '2025-12-13 14:24:00', 0, '2025-12-13 05:54:19');

-- -------------------------------
-- Exams Question Sources	
-- -------------------------------
INSERT INTO `exam_question_sources`
(`exam_id`, `bank_id`, `subject_id`, `difficulty`, `question_limit`) VALUES
(2, 2, 4, NULL, 1),
(2, 2, 6, NULL, 1),
(2, 2, 5, NULL, 1),

(4, 3, 7, 'Easy', 9),
(4, 3, 7, 'Medium', 4),
(4, 3, 7, 'Hard', 2),
(4, 1, 3, 'Easy', 9),
(4, 1, 3, 'Medium', 4),
(4, 1, 3, 'Hard', 2),

(5, 2, 6, 'Easy', 9),
(5, 2, 6, 'Medium', 4),
(5, 2, 6, 'Hard', 2),
(5, 2, 5, 'Easy', 9),
(5, 2, 5, 'Medium', 4),
(5, 2, 5, 'Hard', 2),

(8, 3, 8, 'Easy', 9),
(8, 3, 8, 'Medium', 4),
(8, 3, 8, 'Hard', 2),
(8, 3, 7, 'Easy', 9),
(8, 3, 7, 'Medium', 4),
(8, 3, 7, 'Hard', 2),

(3, 3, 8, 'Easy', 10),
(3, 3, 8, 'Medium', 3),
(3, 3, 8, 'Hard', 2),
(3, 3, 7, 'Easy', 10),
(3, 3, 7, 'Medium', 3),
(3, 3, 7, 'Hard', 2),

(7, 1, 3, 'Easy', 6),
(7, 1, 3, 'Medium', 3),
(7, 1, 3, 'Hard', 1),
(7, 1, 1, 'Easy', 6),
(7, 1, 1, 'Medium', 3),
(7, 1, 1, 'Hard', 1),

(1, 1, 3, 'Easy', 4),
(1, 1, 3, 'Medium', 1),
(1, 1, 3, 'Hard', 1),
(1, 1, 2, 'Easy', 1),
(1, 1, 2, 'Hard', 1),
(1, 1, 1, 'Easy', 1),
(1, 1, 1, 'Hard', 1),

(9, 3, 7, 'Easy', 7),
(9, 3, 7, 'Medium', 2),
(9, 3, 7, 'Hard', 1),

(10, 1, 2, 'Easy', 6),
(10, 1, 2, 'Medium', 2),
(10, 1, 2, 'Hard', 2),

(6, 1, 3, 'Easy', 6),
(6, 1, 3, 'Medium', 2),
(6, 1, 3, 'Hard', 2),
(6, 1, 1, 'Easy', 6),
(6, 1, 1, 'Medium', 2),
(6, 1, 1, 'Hard', 2);


-- -------------------------------
-- Exams Question 	
-- -------------------------------
INSERT INTO `exam_questions` ( `exam_id`, `question_id`) VALUES
( 1, 53),
( 1, 37),
( 1, 4),
( 2, 73),
( 2, 115),
( 2, 87),
( 4, 145),
( 4, 148),
( 4, 155),
( 4, 157),
( 4, 160),
( 4, 143),
( 4, 152),
( 4, 138),
( 4, 132),
( 4, 136),
( 4, 133),
( 4, 124),
( 4, 123),
( 4, 140),
( 4, 125),
( 4, 122),
( 4, 126),
( 4, 128),
( 4, 135),
( 4, 131),
( 8, 44),
( 8, 48),
( 8, 43),
( 8, 59),
( 8, 52),
( 8, 53),
( 8, 41),
( 8, 54),
( 8, 58),
( 8, 55),
( 8, 20),
( 8, 2),
( 8, 8),
( 8, 3),
( 8, 17),
( 8, 12),
( 8, 4),
( 8, 18),
( 8, 10),
( 8, 16);

-- -------------------------------
-- Exam Assigned Student
-- -------------------------------
INSERT INTO `exam_assigned_students` (`exam_id`, `student_id`) VALUES
(2, 1),
(2, 2),
(2, 9),
(2, 10),

(4, 1),
(4, 2),
(4, 9),
(4, 10),

(1, 1),
(1, 2),
(1, 9),
(1, 10),

(8, 1),
(8, 2),
(8, 9),
(8, 10);


 




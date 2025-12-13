
SET FOREIGN_KEY_CHECKS=0;

-- =============================
-- ADMIN
-- =============================
CREATE TABLE IF NOT EXISTS admin (
  admin_id INT(11) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================
-- CLASSROOMS
-- =============================
CREATE TABLE IF NOT EXISTS classrooms (
  class_id INT(11) AUTO_INCREMENT PRIMARY KEY,
  class_name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- =============================
-- SUBJECTS
-- =============================
CREATE TABLE IF NOT EXISTS subjects (
  subject_id INT(11) AUTO_INCREMENT PRIMARY KEY,
  subject_name VARCHAR(100) NOT NULL UNIQUE,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================
-- QUESTION BANKS
-- =============================
CREATE TABLE IF NOT EXISTS question_banks (
  bank_id INT(11) AUTO_INCREMENT PRIMARY KEY,
  bank_name VARCHAR(100) NOT NULL,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =============================
-- QUESTION BANK SUBJECTS
-- =============================
CREATE TABLE IF NOT EXISTS question_bank_subjects (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  bank_id INT(11) NOT NULL,
  subject_id INT(11) NOT NULL,
  UNIQUE KEY bank_subject (bank_id, subject_id),
  FOREIGN KEY (bank_id) REFERENCES question_banks(bank_id) ON DELETE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects(subject_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================
-- QUESTIONS
-- =============================
CREATE TABLE IF NOT EXISTS questions (
  question_id INT(11) AUTO_INCREMENT PRIMARY KEY,
  bank_id INT(11) NOT NULL,
  subject_id INT(11) NOT NULL,
  question_text TEXT NOT NULL,
  option_a VARCHAR(255),
  option_b VARCHAR(255),
  option_c VARCHAR(255),
  option_d VARCHAR(255),
  correct_option ENUM('A','B','C','D') NOT NULL,
  marks_per_question DECIMAL(5,2) DEFAULT 1.00,
  difficulty ENUM('Easy','Medium','Hard') DEFAULT 'Easy',
  FOREIGN KEY (bank_id) REFERENCES question_banks(bank_id) ON DELETE CASCADE,
  FOREIGN KEY (subject_id) REFERENCES subjects(subject_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================
-- STUDENTS
-- =============================
CREATE TABLE IF NOT EXISTS students (
  student_id INT(11) AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  roll_no VARCHAR(50) NOT NULL,
  section VARCHAR(10),
  phone VARCHAR(15),
  status ENUM('Active','Inactive') DEFAULT 'Active',
  class_id INT(11) NOT NULL,
  FOREIGN KEY (class_id) REFERENCES classrooms(class_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================
-- EXAMS
-- =============================
CREATE TABLE IF NOT EXISTS exams (
  exam_id INT(11) AUTO_INCREMENT PRIMARY KEY,
  exam_title VARCHAR(200) NOT NULL,
  exam_description TEXT,
  total_questions INT DEFAULT 0,
  total_marks DECIMAL(6,2) DEFAULT 0.00,
  pass_marks DECIMAL(6,2) DEFAULT 0.00,
  duration_minutes INT DEFAULT 30,
  shuffle_questions TINYINT(1) DEFAULT 1,
  shuffle_options TINYINT(1) DEFAULT 1,
  start_time DATETIME,
  end_time DATETIME,
  negative_marking DECIMAL(5,2) DEFAULT 0.00,
  status ENUM('Active','Inactive') DEFAULT 'Inactive',
  assign_type ENUM('class','individual') DEFAULT 'individual',
  assign_data TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  easy_percentage INT DEFAULT 0,
  medium_percentage INT DEFAULT 0,
  hard_percentage INT DEFAULT 0
) ENGINE=InnoDB;

-- =============================
-- EXAM QUESTION SOURCES
-- =============================
CREATE TABLE IF NOT EXISTS exam_question_sources (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  exam_id INT(11) NOT NULL,
  bank_id INT(11),
  subject_id INT(11),
  difficulty ENUM('Easy','Medium','Hard'),
  question_limit INT,
  FOREIGN KEY (exam_id) REFERENCES exams(exam_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================
-- EXAM QUESTIONS
-- =============================
CREATE TABLE IF NOT EXISTS exam_questions (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  exam_id INT(11) NOT NULL,
  question_id INT(11) NOT NULL,
  FOREIGN KEY (exam_id) REFERENCES exams(exam_id) ON DELETE CASCADE,
  FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================
-- EXAM ASSIGNED STUDENTS
-- =============================
CREATE TABLE IF NOT EXISTS exam_assigned_students (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  exam_id INT(11) NOT NULL,
  student_id INT(11) NOT NULL,
  FOREIGN KEY (exam_id) REFERENCES exams(exam_id) ON DELETE CASCADE,
  FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================
-- EXAM LINKS
-- =============================
CREATE TABLE IF NOT EXISTS exam_links (
  link_id INT(11) AUTO_INCREMENT PRIMARY KEY,
  exam_id INT(11) NOT NULL,
  unique_link VARCHAR(255) NOT NULL,
  password VARCHAR(100),
  student_name VARCHAR(150),
  student_email VARCHAR(200),
  student_class VARCHAR(50),
  expires_at DATETIME,
  is_used TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (exam_id) REFERENCES exams(exam_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =============================
-- EXAM RESULTS
-- =============================
CREATE TABLE IF NOT EXISTS exam_results (
  result_id INT(11) AUTO_INCREMENT PRIMARY KEY,
  link_id INT(11) NOT NULL,
  exam_id INT(11) NOT NULL,
  student_name VARCHAR(150),
  student_email VARCHAR(200),
  total_marks DECIMAL(5,2) DEFAULT 0.00,
  obtained_marks DECIMAL(5,2) DEFAULT 0.00,
  started_at DATETIME,
  submitted_at DATETIME,
  FOREIGN KEY (exam_id) REFERENCES exams(exam_id),
  FOREIGN KEY (link_id) REFERENCES exam_links(link_id)
) ENGINE=InnoDB;

-- =============================
-- EXAM ANSWERS
-- =============================
CREATE TABLE IF NOT EXISTS exam_answers (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  result_id INT(11) NOT NULL,
  question_id INT(11) NOT NULL,
  selected_option ENUM('A','B','C','D'),
  is_correct TINYINT(1) DEFAULT 0,
  FOREIGN KEY (result_id) REFERENCES exam_results(result_id) ON DELETE CASCADE,
  FOREIGN KEY (question_id) REFERENCES questions(question_id) ON DELETE CASCADE
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS=1;

-- -------------------------------
-- Admin (only one, safe)
-- -------------------------------
INSERT INTO `admin` (`admin_id`, `name`, `email`, `password_hash`, `created_at`)
VALUES (1, 'admin', 'admin@12.com', '$2y$10$T3g4wVh2ygCCvDPKOiTeteYmGB6RbLtSTpWN25/glk0z8EnF3vVVS', NOW())
ON DUPLICATE KEY UPDATE admin_id=admin_id;

-- -------------------------------
-- Classroom
-- -------------------------------
INSERT INTO `classrooms` (`class_id`, `class_name`) VALUES
(1, 'Class A'),
(2, 'Class B'),
(3, 'Class C'),
(4, 'Class D'),
(5, 'Class E')
ON DUPLICATE KEY UPDATE class_id=class_id;

-- -------------------------------
-- Students
-- -------------------------------
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
(10, 'Jack Baker', 'jack@example.com', '$2y$10$apxAwVmNVZ7conlco5yz7.jB9EP/dne.V4aBdaGOam6UbNO8QO6z6', 'R110', 'A', '982233778', 'Active', 1)
ON DUPLICATE KEY UPDATE student_id=student_id;

-- -------------------------------
-- Subjects
-- -------------------------------
INSERT INTO `subjects` (`subject_id`, `subject_name`, `description`, `created_at`)
VALUES
(1, 'Physics', 'Mechanics, Waves, EM, Modern Physics', '2024-01-11 18:30:00'),
(2, 'Chemistry', 'Organic, Inorganic, Physical Chemistry', '2024-01-14 18:30:00'),
(3, 'Biology', 'Botany, Zoology, Genetics, Evolution', '2024-01-17 18:30:00'),
(4, 'Accountancy', 'Financial Accounting, Ledger, Final Accounts', '2024-02-01 18:30:00'),
(5, 'Economics', 'Micro, Macro, Indian Economy', '2024-02-03 18:30:00'),
(6, 'Business Studies', 'Management, Marketing, Finance', '2024-02-05 18:30:00'),
(7, 'General Knowledge', 'Static GK, Geography, Polity, History', '2024-02-29 18:30:00'),
(8, 'Current Affairs', 'Latest National & International news', '2025-12-03 05:18:29')
ON DUPLICATE KEY UPDATE subject_id=subject_id;

-- -------------------------------
-- Question banks
-- -------------------------------
INSERT INTO `question_banks` (`bank_id`, `bank_name`, `description`, `created_at`)
VALUES
(1, 'Science Bank', 'Covers Physics, Chemistry, Biology for 11th & 12th', '2025-12-03 05:04:16'),
(2, 'Commerce Bank', 'Covers Accounts, Economics, Business Studies', '2025-12-03 05:04:16'),
(3, 'General Knowledge Bank', 'Covers GK & Current Affairs', '2025-12-03 05:04:16')
ON DUPLICATE KEY UPDATE bank_id=bank_id;

-- -------------------------------
-- Question banks subject
-- -------------------------------
INSERT INTO `question_bank_subjects` (`id`, `bank_id`, `subject_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 4),
(5, 2, 5),
(6, 2, 6),
(7, 3, 7),
(8, 3, 8)
ON DUPLICATE KEY UPDATE id=id;

-- -------------------------------
-- Questions
-- -------------------------------
INSERT INTO `questions` (`question_id`,`bank_id`,`subject_id`,`question_text`,`option_a`,`option_b`,`option_c`,`option_d`,`correct_option`,`marks_per_question`,`difficulty`)
VALUES
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
(12, 1, 1, 'Which device measures electric current?', 'Ammeter', 'Voltmeter', 'Ohmmeter', 'Capacitor', 'A', 1.00, 'Easy'),
(13, 1, 1, 'Ohm’s law states?', 'V = IR', 'P = VI', 'E = mc²', 'F = ma', 'A', 1.00, 'Easy'),
(14, 1, 1, 'Unit of electric charge?', 'Coulomb', 'Farad', 'Henry', 'Tesla', 'A', 1.00, 'Medium'),
(15, 1, 1, 'Which has maximum energy?', 'Gamma rays', 'Infrared', 'Microwave', 'Radio', 'A', 1.00, 'Medium'),
(16, 1, 1, 'Which has highest frequency?', 'Violet light', 'Red light', 'Green light', 'Yellow light', 'A', 1.00, 'Hard'),
(17, 1, 1, 'Magnetic field unit?', 'Tesla', 'Newton', 'Joule', 'Ampere', 'A', 1.00, 'Medium'),
(18, 1, 1, 'Fuse works on principle of?', 'Heating effect', 'Magnetic effect', 'Chemical effect', 'None', 'A', 1.00, 'Easy'),
(19, 1, 1, 'Acceleration unit?', 'm/s²', 'm/s', 'm', 'kg', 'A', 1.00, 'Easy'),
(20, 1, 1, 'Instrument to measure pressure?', 'Barometer', 'Hygrometer', 'Ammeter', 'Thermometer', 'A', 1.00, 'Easy'),
(21, 1, 2, 'Atomic number represents?', 'Number of protons', 'Number of neutrons', 'Mass number', 'Electrons in outer shell', 'A', 1.00, 'Easy'),
(22, 1, 2, 'pH of neutral solution is?', '7', '5', '9', '11', 'A', 1.00, 'Easy'),
(23, 1, 2, 'Which gas is used in balloons?', 'Helium', 'Oxygen', 'Nitrogen', 'Hydrogen', 'A', 1.00, 'Easy'),
(24, 1, 2, 'HCl is?', 'Strong acid', 'Weak acid', 'Neutral', 'Base', 'A', 1.00, 'Easy'),
(25, 1, 2, 'Which metal is most reactive?', 'Potassium', 'Gold', 'Silver', 'Copper', 'A', 1.00, 'Medium'),
(26, 1, 2, 'Formula of methane?', 'CH4', 'C2H6', 'C3H8', 'C4H10', 'A', 1.00, 'Easy'),
(27, 1, 2, 'Rusting is?', 'Oxidation', 'Reduction', 'Neutralization', 'Substitution', 'A', 1.00, 'Easy'),
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
(53, 1, 3, 'Site of digestion?', 'Small intestine', 'Large intestine', 'Stomach', 'Mouth', 'A', 1.00, 'Easy'),
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
(128, 3, 7, 'Smallest country in the world?', 'Vatican City', 'Monaco', 'Malta', 'San Marino', 'A', 1.00, 'Easy'),
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
(157, 3, 8, 'Current UN Secretary-General?', 'Antonio Guterres', 'Ban Ki-moon', 'Kofi Annan', 'Boutros Boutros-Ghali', 'A', 1.00, 'Easy'),
(158, 3, 8, 'Which Indian state got UNESCO World Heritage site recently?', 'Madhya Pradesh', 'Rajasthan', 'Tamil Nadu', 'Gujarat', 'A', 1.00, 'Medium'),
(159, 3, 8, 'COP28 conference 2025 held in?', 'UAE', 'India', 'Germany', 'Brazil', 'A', 1.00, 'Medium'),
(160, 3, 8, 'Which country legalized electric vehicles target by 2030?', 'Norway', 'USA', 'India', 'China', 'A', 1.00, 'Easy'),
(161, 3, 8, 'India’s new digital currency launched?', 'Digital Rupee', 'Bitcoin', 'Ethereum', 'Tether', 'A', 1.00, 'Medium')
ON DUPLICATE KEY UPDATE question_id=question_id;

/*
-- -------------------------------
-- Exams
-- -------------------------------
INSERT INTO `exams` (`exam_id`, `exam_title`, `exam_description`, `total_questions`, `duration_minutes`, `shuffle_questions`, `shuffle_options`, `rules_page`, `start_time`, `end_time`, `passing_marks`, `negative_marking`, `status`, `assign_type`, `assign_data`, `created_at`, `easy_percentage`, `medium_percentage`, `hard_percentage`) VALUES
(1, 'Science Midterm Exam', 'Covers Physics, Chemistry, Biology', 3, 30, 1, 1, 0, '2025-12-03 12:00:00', '2025-12-03 12:30:00', 0.00, 0.00, 'Inactive', 'class', NULL, '2025-12-03 05:50:17', 0, 0, 0),
(2, 'Commerce Midterm Exam', 'Covers Accountancy, Economics, Business Studies', 3, 30, 1, 1, 0, '2025-12-03 12:05:00', '2025-12-03 12:35:00', 0.00, 0.00, 'Inactive', 'class', NULL, '2025-12-03 06:35:11', 0, 0, 0),
(3, 'Science Midterm', 'Biology and chemistry', 30, 30, 1, 1, 0, '2025-12-04 14:02:00', '2025-12-04 18:00:00', 0.00, 0.00, 'Inactive', 'class', NULL, '2025-12-04 05:37:44', 0, 0, 0),
(4, 'GK Midterm Exam', 'Current Affairs and General Knowledge', 30, 30, 1, 1, 0, '2025-12-04 14:00:00', '2025-12-04 19:30:00', 0.00, 0.00, 'Inactive', 'class', NULL, '2025-12-04 08:31:14', 0, 0, 0),
(6, 'mix', 'Biology and Gk', 30, 30, 1, 1, 0, '2025-12-04 18:18:00', '2025-12-04 19:30:00', 0.00, 0.00, 'Inactive', 'class', NULL, '2025-12-04 12:49:58', 0, 0, 0),
(7, 'Commerce', 'Business Studies and Economics', 30, 30, 1, 1, 0, '2025-12-04 18:18:00', '2025-12-04 19:30:00', 0.00, 0.00, 'Inactive', 'class', NULL, '2025-12-04 13:39:51', 60, 30, 10),
(8, 'Science', 'biology and chemistry', 20, 30, 1, 1, 0, '2025-12-05 10:00:00', '2025-12-05 19:34:00', 0.00, 0.00, 'Inactive', 'class', NULL, '2025-12-04 14:04:33', 70, 25, 5),
(9, 'Science exam', 'Biology and Physics', 20, 30, 1, 1, 0, '2025-12-05 10:30:00', '2025-12-05 19:30:00', 0.00, 0.00, 'Inactive', 'class', NULL, '2025-12-05 05:01:10', 60, 30, 10),
(10, 'Art', 'GK and Current Affairs', 30, 30, 1, 1, 0, '2025-12-05 12:22:00', '2025-12-05 19:28:00', 0.00, 0.00, 'Inactive', 'class', NULL, '2025-12-05 06:53:19', 60, 30, 10)
ON DUPLICATE KEY UPDATE exam_id=exam_id;


-- -------------------------------
-- Exams Question Sources	
-- -------------------------------
INSERT INTO `exam_question_sources` (`id`, `exam_id`, `bank_id`, `subject_id`, `difficulty`, `question_limit`) VALUES
(30, 1, 1, 3, NULL, 1),
(31, 1, 1, 2, NULL, 1),
(32, 1, 1, 1, NULL, 1),
(36, 2, 2, 4, NULL, 1),
(37, 2, 2, 6, NULL, 1),
(38, 2, 2, 5, NULL, 1),
(70, 4, 3, 8, 'Easy', 15),
(71, 4, 3, 7, 'Easy', 15),
(75, 3, 1, 3, 'Easy', 10),
(76, 3, 1, 2, 'Easy', 10),
(77, 3, 1, 1, 'Easy', 10),
(78, 6, 3, 7, 'Easy', 9),
(79, 6, 3, 7, 'Medium', 4),
(80, 6, 3, 7, 'Hard', 2),
(81, 6, 1, 3, 'Easy', 9),
(82, 6, 1, 3, 'Medium', 4),
(83, 6, 1, 3, 'Hard', 2),
(96, 9, 1, 3, 'Easy', 6),
(97, 9, 1, 3, 'Medium', 3),
(98, 9, 1, 3, 'Hard', 1),
(99, 9, 1, 1, 'Easy', 6),
(100, 9, 1, 1, 'Medium', 3),
(101, 9, 1, 1, 'Hard', 1),
(102, 8, 1, 3, 'Easy', 7),
(103, 8, 1, 3, 'Medium', 2),
(104, 8, 1, 3, 'Hard', 1),
(105, 8, 1, 1, 'Easy', 7),
(106, 8, 1, 1, 'Medium', 2),
(107, 8, 1, 1, 'Hard', 1),
(108, 7, 2, 6, 'Easy', 9),
(109, 7, 2, 6, 'Medium', 4),
(110, 7, 2, 6, 'Hard', 2),
(111, 7, 2, 5, 'Easy', 9),
(112, 7, 2, 5, 'Medium', 4),
(113, 7, 2, 5, 'Hard', 2),
(120, 10, 3, 8, 'Easy', 9),
(121, 10, 3, 8, 'Medium', 4),
(122, 10, 3, 8, 'Hard', 2),
(123, 10, 3, 7, 'Easy', 9),
(124, 10, 3, 7, 'Medium', 4),
(125, 10, 3, 7, 'Hard', 2)
ON DUPLICATE KEY UPDATE id=id;

-- -------------------------------
-- Exam Assigned Student
-- -------------------------------
INSERT INTO `exam_assigned_students` (`id`, `exam_id`, `student_id`) VALUES
(41, 1, 1),
(42, 1, 2),
(43, 1, 9),
(44, 1, 10),
(46, 2, 1),
(47, 2, 2),
(48, 2, 9),
(49, 2, 10),
(70, 5, 1),
(71, 5, 2),
(72, 5, 9),
(73, 5, 10),
(74, 4, 1),
(75, 4, 2),
(76, 4, 9),
(77, 4, 10),
(82, 3, 1),
(83, 3, 2),
(84, 3, 9),
(85, 3, 10),
(86, 6, 1),
(87, 6, 2),
(88, 6, 9),
(89, 6, 10),
(98, 9, 1),
(99, 9, 2),
(100, 9, 9),
(101, 9, 10),
(102, 8, 1),
(103, 8, 2),
(104, 8, 9),
(105, 8, 10),
(106, 7, 1),
(107, 7, 2),
(108, 7, 9),
(109, 7, 10),
(114, 10, 1),
(115, 10, 2),
(116, 10, 9),
(117, 10, 10);
ON DUPLICATE KEY UPDATE id=id;

-- -------------------------------
-- Exam links
-- -------------------------------
INSERT INTO `exam_links` (`link_id`, `exam_id`, `unique_link`, `password`, `student_name`, `student_email`, `student_class`, `expires_at`, `is_used`, `created_at`) VALUES
(1, 1, 'exam_692fcf9984a537.76633127', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', 'Alice Smith', 'alice@example.com', NULL, '2025-12-03 12:32:00', 0, '2025-12-03 05:50:17'),
(2, 1, 'exam_692fcf9986ae43.68810739', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-03 12:32:00', 0, '2025-12-03 05:50:17'),
(3, 1, 'exam_692fcf99875d84.58635436', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', 'Isla Adams', 'isla@example.com', NULL, '2025-12-03 12:32:00', 0, '2025-12-03 05:50:17'),
(4, 1, 'exam_692fcf9987efa9.44783430', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', 'Jack Baker', 'jack@example.com', NULL, '2025-12-03 12:32:00', 0, '2025-12-03 05:50:17'),
(5, 1, 'exam-1-90c560f7', '$2y$10$QUau.v/Iu6LpWwPRlLkDd.KZe0b9Zo8vARXs.haxi0poenTa2tKAG', NULL, NULL, NULL, '2025-12-03 12:32:00', 0, '2025-12-03 05:50:17'),
(6, 2, 'exam_692fda1f1ba752.47433683', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', 'Alice Smith', 'alice@example.com', NULL, '2025-12-03 13:07:00', 0, '2025-12-03 06:35:11'),
(7, 2, 'exam-2-b06d2abe', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', NULL, NULL, NULL, '2025-12-03 13:07:00', 0, '2025-12-03 06:35:11'),
(8, 2, 'exam_692fdaaf044c64.50989660', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-03 13:07:00', 0, '2025-12-03 06:37:35'),
(9, 2, 'exam_692fdaaf058051.62156593', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', 'Isla Adams', 'isla@example.com', NULL, '2025-12-03 13:07:00', 0, '2025-12-03 06:37:35'),
(10, 2, 'exam_692fdaaf06a1e7.06203442', '$2y$10$mmsVVnRXw2JpSzEkv/nEZubgoSaTntmKcIFsi78/YphVCKhvsUkLa', 'Jack Baker', 'jack@example.com', NULL, '2025-12-03 13:07:00', 0, '2025-12-03 06:37:35'),
(11, 3, 'exam_69311e280c96f4.17571917', '$2y$10$h7kjpmMBg/hhgFxMayly8OQUZIcz1gt2DWmDuVHmIhceQf.zKSnvm', 'Alice Smith', 'alice@example.com', NULL, '2025-12-04 19:30:00', 0, '2025-12-04 05:37:44'),
(12, 3, 'exam_69311e280d6bb3.99862612', '$2y$10$h7kjpmMBg/hhgFxMayly8OQUZIcz1gt2DWmDuVHmIhceQf.zKSnvm', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-04 19:30:00', 0, '2025-12-04 05:37:44'),
(13, 3, 'exam_69311e280ea7a4.79907493', '$2y$10$h7kjpmMBg/hhgFxMayly8OQUZIcz1gt2DWmDuVHmIhceQf.zKSnvm', 'Isla Adams', 'isla@example.com', NULL, '2025-12-04 19:30:00', 0, '2025-12-04 05:37:44'),
(14, 3, 'exam_69311e280f6956.66697445', '$2y$10$h7kjpmMBg/hhgFxMayly8OQUZIcz1gt2DWmDuVHmIhceQf.zKSnvm', 'Jack Baker', 'jack@example.com', NULL, '2025-12-04 19:30:00', 0, '2025-12-04 05:37:44'),
(15, 3, 'exam-3-7986e524', '$2y$10$h7kjpmMBg/hhgFxMayly8OQUZIcz1gt2DWmDuVHmIhceQf.zKSnvm', NULL, NULL, NULL, '2025-12-04 19:30:00', 0, '2025-12-04 05:37:44'),
(16, 4, 'exam_693146d2c23fd8.96082513', '$2y$10$CKfKzu6SpmJHZyA2HBdSRelKHbKkhfLXSePadkmEvHE.mnZfHn4Jq', 'Alice Smith', 'alice@example.com', NULL, '2025-12-04 19:36:00', 0, '2025-12-04 08:31:14'),
(17, 4, 'exam_693146d2c3b011.13586377', '$2y$10$CKfKzu6SpmJHZyA2HBdSRelKHbKkhfLXSePadkmEvHE.mnZfHn4Jq', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-04 19:36:00', 0, '2025-12-04 08:31:14'),
(18, 4, 'exam_693146d2c4bfc8.17044816', '$2y$10$CKfKzu6SpmJHZyA2HBdSRelKHbKkhfLXSePadkmEvHE.mnZfHn4Jq', 'Isla Adams', 'isla@example.com', NULL, '2025-12-04 19:36:00', 0, '2025-12-04 08:31:14'),
(19, 4, 'exam_693146d2c5f450.62745054', '$2y$10$CKfKzu6SpmJHZyA2HBdSRelKHbKkhfLXSePadkmEvHE.mnZfHn4Jq', 'Jack Baker', 'jack@example.com', NULL, '2025-12-04 19:36:00', 0, '2025-12-04 08:31:14'),
(20, 4, 'exam-4-fd078b88', '$2y$10$CKfKzu6SpmJHZyA2HBdSRelKHbKkhfLXSePadkmEvHE.mnZfHn4Jq', NULL, NULL, NULL, '2025-12-04 19:36:00', 0, '2025-12-04 08:31:15'),
(26, 6, 'exam_693183769d73f8.25339927', NULL, 'Alice Smith', 'alice@example.com', NULL, NULL, 0, '2025-12-04 12:49:58'),
(27, 6, 'exam_693183769f0703.49855114', NULL, 'Bob Johnson', 'bob@example.com', NULL, NULL, 0, '2025-12-04 12:49:58'),
(28, 6, 'exam_69318376a023a3.77213354', NULL, 'Isla Adams', 'isla@example.com', NULL, NULL, 0, '2025-12-04 12:49:58'),
(29, 6, 'exam_69318376a22ec9.35373299', NULL, 'Jack Baker', 'jack@example.com', NULL, NULL, 0, '2025-12-04 12:49:58'),
(30, 6, 'exam-6-fa910817', '$2y$10$YT5qYRwTHrPwmMgQzot5FeU1kMoKJDTngY5NsKgH8pbLIr93gRi3m', NULL, NULL, NULL, '2025-12-04 19:30:00', 0, '2025-12-04 12:49:58'),
(31, 7, 'exam_69318f276d5d98.80552294', NULL, 'Alice Smith', 'alice@example.com', NULL, NULL, 0, '2025-12-04 13:39:51'),
(32, 7, 'exam_69318f276f1c07.96629835', NULL, 'Bob Johnson', 'bob@example.com', NULL, NULL, 0, '2025-12-04 13:39:51'),
(33, 7, 'exam_69318f27704447.67883235', NULL, 'Isla Adams', 'isla@example.com', NULL, NULL, 0, '2025-12-04 13:39:51'),
(34, 7, 'exam_69318f277266e9.47907509', NULL, 'Jack Baker', 'jack@example.com', NULL, NULL, 0, '2025-12-04 13:39:51'),
(35, 7, 'exam-7-eea92ca9', '$2y$10$AClev0iGumtHS28FndZZ9.v6k0CQg4qivjh8v8U72V25vofdyxxra', NULL, NULL, NULL, '2025-12-04 19:30:00', 0, '2025-12-04 13:39:51'),
(36, 8, 'exam_693194f171d2d6.38351520', NULL, 'Alice Smith', 'alice@example.com', NULL, NULL, 0, '2025-12-04 14:04:33'),
(37, 8, 'exam_693194f173cd51.29926238', NULL, 'Bob Johnson', 'bob@example.com', NULL, NULL, 0, '2025-12-04 14:04:33'),
(38, 8, 'exam_693194f1751183.86502391', NULL, 'Isla Adams', 'isla@example.com', NULL, NULL, 0, '2025-12-04 14:04:33'),
(39, 8, 'exam_693194f176cd16.26821545', NULL, 'Jack Baker', 'jack@example.com', NULL, NULL, 0, '2025-12-04 14:04:33'),
(40, 8, 'exam-8-bbe47086', '$2y$10$Z2tTEmCGrHY7MeyvkNo1COM0r/4sWp9VHzmzCtFE8vFE4fC/VfxBa', NULL, NULL, NULL, '2025-12-05 19:34:00', 0, '2025-12-04 14:04:33'),
(41, 9, 'exam_69326716561ea0.90367878', NULL, 'Alice Smith', 'alice@example.com', NULL, NULL, 0, '2025-12-05 05:01:10'),
(42, 9, 'exam_69326716573042.16669386', NULL, 'Bob Johnson', 'bob@example.com', NULL, NULL, 0, '2025-12-05 05:01:10'),
(43, 9, 'exam_693267165892b6.32140913', NULL, 'Isla Adams', 'isla@example.com', NULL, NULL, 0, '2025-12-05 05:01:10'),
(44, 9, 'exam_6932671659c5f5.33948213', NULL, 'Jack Baker', 'jack@example.com', NULL, NULL, 0, '2025-12-05 05:01:10'),
(45, 9, 'exam-9-92f9121b', '$2y$10$3qa8axhB446Q40mqw1Rie.IEk1E2Hwkiwg.lPQEfW6IVH60kzh6Fq', NULL, NULL, NULL, '2025-12-05 19:30:00', 0, '2025-12-05 05:01:10'),
(46, 10, 'exam_6932815f12bd53.97690333', '$2y$10$gLXvcKTLn.Bh2fVqCvaBVOC9.qf6my/4JebRZVZPb01Xaj4pErxAK', 'Alice Smith', 'alice@example.com', NULL, '2025-12-05 19:30:00', 0, '2025-12-05 06:53:19'),
(47, 10, 'exam_6932815f140814.35878927', '$2y$10$gLXvcKTLn.Bh2fVqCvaBVOC9.qf6my/4JebRZVZPb01Xaj4pErxAK', 'Bob Johnson', 'bob@example.com', NULL, '2025-12-05 19:30:00', 0, '2025-12-05 06:53:19'),
(48, 10, 'exam_6932815f1526a2.55460779', '$2y$10$gLXvcKTLn.Bh2fVqCvaBVOC9.qf6my/4JebRZVZPb01Xaj4pErxAK', 'Isla Adams', 'isla@example.com', NULL, '2025-12-05 19:30:00', 0, '2025-12-05 06:53:19'),
(49, 10, 'exam_6932815f16f185.17585246', '$2y$10$gLXvcKTLn.Bh2fVqCvaBVOC9.qf6my/4JebRZVZPb01Xaj4pErxAK', 'Jack Baker', 'jack@example.com', NULL, '2025-12-05 19:30:00', 0, '2025-12-05 06:53:19'),
(50, 10, 'exam-10-8045503c', '$2y$10$gLXvcKTLn.Bh2fVqCvaBVOC9.qf6my/4JebRZVZPb01Xaj4pErxAK', NULL, NULL, NULL, '2025-12-05 19:30:00', 0, '2025-12-05 06:53:19')
ON DUPLICATE KEY UPDATE link_id=link_id;   */





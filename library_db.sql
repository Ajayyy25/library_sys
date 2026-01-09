-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2026 at 08:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_author`
--

CREATE TABLE `tbl_author` (
  `author_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `bio` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_author`
--

INSERT INTO `tbl_author` (`author_id`, `name`, `bio`) VALUES
(5, 'F. Scott Fitzgerald', 'F. Scott Fitzgerald was an American novelist known for portraying life in the 1920s. His works often explore themes of wealth, ambition, and the American Dream.'),
(6, 'Harper Lee', 'Harper Lee was an American writer best known for this novel, which addresses racial injustice and moral growth. It became one of the most influential books in American literature.'),
(7, 'Anne Frank', 'Anne Frank was a Jewish teenager who documented her life while hiding during World War II. Her diary became one of the most important historical accounts of the Holocaust.'),
(8, 'Nelson Mandela', 'Nelson Mandela was a South African anti-apartheid leader and the country’s first Black president. His autobiography tells the story of his fight for equality and justice.'),
(9, 'Jane Austen', 'Jane Austen was an English novelist famous for her romantic fiction. Her works focus on social class, marriage, and strong female characters.'),
(10, 'Jojo Moyes', 'Jojo Moyes is a British author known for emotional romance novels. Her books often explore love, relationships, and personal growth.'),
(11, 'J.K. Rowling', 'J.K. Rowling is a British author who created the Harry Potter series. Her books became a global phenomenon and inspired movies, games, and theme parks.'),
(12, 'J.R.R. Tolkien', 'J.R.R. Tolkien was an English writer and professor. He is considered the father of modern fantasy and created the fictional world of Middle-earth.'),
(13, 'Arthur Conan Doyle', 'Arthur Conan Doyle was a British writer and physician. He is best known for creating the famous detective Sherlock Holmes.'),
(14, 'Agatha Christie', 'Agatha Christie was an English writer known as the “Queen of Mystery.” She wrote many bestselling detective novels and short stories.'),
(15, 'V. Rajaraman', 'V. Rajaraman is an Indian computer scientist and educator. He has written several textbooks used by students learning computer science and IT fundamentals.'),
(16, 'Serge Lang', 'Serge Lang was a mathematician and professor who authored many textbooks. His books are widely used for teaching mathematics at beginner and college levels.');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_book`
--

CREATE TABLE `tbl_book` (
  `book_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `total_copies` int(11) NOT NULL,
  `available_copies` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_book`
--

INSERT INTO `tbl_book` (`book_id`, `title`, `author_id`, `category_id`, `total_copies`, `available_copies`) VALUES
(30, 'The Great Gatsby', 5, 8, 1, 1),
(31, 'To Kill a Mockingbird', 6, 8, 1, 1),
(32, 'The Diary of a Young Girl', 7, 13, 1, 1),
(33, 'Long Walk to Freedom', 8, 13, 1, 1),
(34, 'Pride and Prejudice', 9, 6, 1, 1),
(35, 'Me Before You', 10, 6, 1, 0),
(36, 'Harry Potter and the Sorcerer’s Stone', 11, 5, 1, 1),
(37, 'The Hobbit', 12, 5, 1, 1),
(38, 'The Hound of the Baskervilles', 13, 7, 1, 1),
(39, 'Murder on the Orient Express', 14, 7, 1, 1),
(40, 'Introduction to Information Technology', 15, 14, 1, 1),
(41, 'Basic Mathematics', 16, 14, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_id`, `category_name`) VALUES
(14, 'Educational'),
(5, 'Fantasy'),
(8, 'Fiction'),
(7, 'Mystery'),
(13, 'Non-fiction'),
(6, 'Romance');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_record`
--

CREATE TABLE `tbl_record` (
  `borrow_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `status` varchar(20) DEFAULT 'Borrowed',
  `return_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_record`
--

INSERT INTO `tbl_record` (`borrow_id`, `student_id`, `book_id`, `borrow_date`, `due_date`, `status`, `return_date`) VALUES
(22, 10, 40, '2026-01-09', '2026-01-11', 'Returned', '2026-01-09'),
(23, 9, 35, '2026-01-09', '2026-01-11', 'Borrowed', NULL),
(24, 7, 41, '2026-01-09', '2026-01-11', 'Borrowed', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_reservation`
--

CREATE TABLE `tbl_reservation` (
  `reservation_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `status` enum('Reserved','Done','Cancelled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reservation`
--

INSERT INTO `tbl_reservation` (`reservation_id`, `student_id`, `book_id`, `reservation_date`, `status`) VALUES
(12, 12, 35, '2026-01-09', 'Reserved');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_return`
--

CREATE TABLE `tbl_return` (
  `return_id` int(11) NOT NULL,
  `borrow_id` int(11) NOT NULL,
  `return_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_return`
--

INSERT INTO `tbl_return` (`return_id`, `borrow_id`, `return_date`) VALUES
(9, 22, '2026-01-09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student`
--

CREATE TABLE `tbl_student` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `contact_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_student`
--

INSERT INTO `tbl_student` (`student_id`, `first_name`, `last_name`, `middle_name`, `contact_number`) VALUES
(7, 'Bjorn ', 'Rosal', 'Latrell', '09361234321'),
(9, 'Cyra ', 'Samillano', 'Mae', '09361237896'),
(10, 'Ronald ', 'Damo', 'Dams', '09361234563'),
(11, 'Irene ', 'Romitares', 'Mae', '09361239876'),
(12, 'Jodisa ', 'Deligero', 'Mae', '09361236543');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `user_id` int(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`user_id`, `username`, `password`, `first_name`, `last_name`, `middle_name`) VALUES
(1, 'Admin123', '123', 'Admin', 'Amper', 'Amps');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_author`
--
ALTER TABLE `tbl_author`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `tbl_book`
--
ALTER TABLE `tbl_book`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `author_id` (`author_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `tbl_record`
--
ALTER TABLE `tbl_record`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `tbl_reservation_ibfk_1` (`student_id`);

--
-- Indexes for table `tbl_return`
--
ALTER TABLE `tbl_return`
  ADD PRIMARY KEY (`return_id`),
  ADD KEY `borrow_id` (`borrow_id`);

--
-- Indexes for table `tbl_student`
--
ALTER TABLE `tbl_student`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_author`
--
ALTER TABLE `tbl_author`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_book`
--
ALTER TABLE `tbl_book`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_record`
--
ALTER TABLE `tbl_record`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_reservation`
--
ALTER TABLE `tbl_reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_return`
--
ALTER TABLE `tbl_return`
  MODIFY `return_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_student`
--
ALTER TABLE `tbl_student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `user_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

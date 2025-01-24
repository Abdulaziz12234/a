-- استخدام قاعدة البيانات
USE reg;

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `bookings` (`id`, `username`, `room_name`, `price`, `check_in`, `check_out`) VALUES
(3, 'a', 'Single Room', 100.00, '1919-12-19', '1919-12-19'),
(4, 'a', 'Single Room', 100.00, '1512-10-20', '0000-00-00'),
(5, 'a', 'Single Room', 100.00, '1512-10-20', '0000-00-00'),
(6, 'a', 'Single Room', 100.00, '4121-02-19', '5121-12-14'),
(11, 'a', 'Business Suite', 150.00, '8888-08-08', '8888-08-08');

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `Username` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `registration` (`id`, `Username`, `Email`, `Password`) VALUES
(1, 'a', 'a@example.com', 'password123'),
(2, 'b', 'b@example.com', 'password456');

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `available` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `rooms` (`id`, `name`, `price`, `description`, `available`) VALUES
(1, 'Single Room', 100.00, 'A cozy single room.', 5),
(2, 'Double Room', 200.00, 'A spacious double room.', 3),
(3, 'Business Suite', 300.00, 'A luxurious business suite.', 2);

ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `std_works` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `work_type` int(11) NOT NULL,
  `action_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `std_works` (`id`, `user`, `work_type`, `action_date`) VALUES
(1, 'Дмитрий', 2, '2024-12-10 01:58:48');

CREATE TABLE `std_workslist` (
  `id` int(11) NOT NULL,
  `worktype` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `std_workslist` (`id`, `worktype`) VALUES
(1, 'Сварка'),
(2, 'Полировка'),
(3, 'Зачистка'),
(4, 'Покраска'),
(5, 'Грунтование');

ALTER TABLE `std_works`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_type` (`work_type`);

ALTER TABLE `std_workslist`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `std_works`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `std_workslist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `std_works`
  ADD CONSTRAINT `std_works_ibfk_1` FOREIGN KEY (`work_type`) REFERENCES `std_workslist` (`id`);
COMMIT;

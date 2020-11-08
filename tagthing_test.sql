-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2020. Nov 08. 16:39
-- Kiszolgáló verziója: 10.3.25-MariaDB-0ubuntu1
-- PHP verzió: 7.3.24-2+ubuntu20.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `tagthing_test`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `Product`
--

CREATE TABLE `Product` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `base_price` int(11) NOT NULL DEFAULT 0,
  `final_prices_sum` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `Product`
--

INSERT INTO `Product` (`id`, `name`, `base_price`, `final_prices_sum`) VALUES
(1, 'Gyűrü', 25, 25),
(2, 'Gyűrü', 20, 0),
(3, 'Gyűrü', 20, 0),
(4, 'Gyűrü', 21, 0),
(5, 'Gyűrü', 20, 0),
(6, 'Gyűrü', 20, 0),
(7, 'Gyűrü', 20, 0),
(8, 'Gyűrü', 20, 0),
(9, 'Baba', 11, 0),
(10, 'Baba', 13, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `Reservation`
--

CREATE TABLE `Reservation` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `base_price` int(11) NOT NULL DEFAULT 0,
  `final_price` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- A tábla adatainak kiíratása `Reservation`
--

INSERT INTO `Reservation` (`id`, `product_id`, `base_price`, `final_price`) VALUES
(2, 1, 25, 25);

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `Product`
--
ALTER TABLE `Product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT a táblához `Reservation`
--
ALTER TABLE `Reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `Reservation`
--
ALTER TABLE `Reservation`
  ADD CONSTRAINT `Reservation_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `Product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

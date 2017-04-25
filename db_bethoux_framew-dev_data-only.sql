-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2017 at 12:56 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recipe-manager-test`
--

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `name`, `shared`, `owner`) VALUES
(1, 'Test one', 0, 3),
(2, 'Test antonin shared', 1, 1);

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`name`) VALUES
('Eggs'),
('Flour'),
('Milk'),
('Sugar'),
('Vanilla extract');

--
-- Dumping data for table `ingredients_used`
--

INSERT INTO `ingredients_used` (`recipe_id`, `ingredient_id`, `quantity`) VALUES
(1, 'Eggs', '3'),
(1, 'Flour', '250 g'),
(1, 'Milk', '1/2 L'),
(1, 'Vanilla extract', '1 tbsp');

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `title`, `summary`, `public`, `photo`, `creation`, `last_edit`, `author_id`, `content`) VALUES
(1, 'Pancakes', 'Simple & quick method for a hearty breakfast. ', 1, NULL, '2017-03-14 16:28:20', '2017-03-16 10:40:00', 3, '1. Beat the eggs and sugar 2. Add the flour and mix, use a little bit of milk if the dough becomes too thick. 3. Add the milk 4. Chill for 2 hours in the fridge 5. To cook, pour thin layers of dough in a hot greased pan until solid. 6. Enjoy with nutella, sugar, or whatever you like, eh.'),
(2, 'Pot noodles', 'Do you really need a recipe for that ?', 0, NULL, '2017-03-22 16:16:04', '2017-03-22 16:16:04', 3, '1. Boil water 2. Put water in pot up to the mark. 3. Wait 2 minutes 4. Enjoy, you lazy person.'),
(3, 'Test recipe', 'How to bake a test.', 1, NULL, '2017-04-01 15:19:47', '2017-04-01 15:19:47', 3, '1. Assert recipe is correct 2. Make recipe 3. Report back to test framework if the test tasted bad.'),
(4, 'Orphaned recipe', 'This recipe should have a deleted author', 1, NULL, '2017-04-12 17:11:37', '2017-04-12 17:11:40', NULL, 'Orphaned recipe steps.');

--
-- Dumping data for table `recipes_ptags`
--

INSERT INTO `recipes_ptags` (`Recipe_id`, `Tag_id`) VALUES
(3, 51);

--
-- Dumping data for table `recipes_tags`
--

INSERT INTO `recipes_tags` (`recipe_id`, `tag_id`) VALUES
(1, 47);

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `owner_id`, `type`, `score`) VALUES
(45, 'Italian', NULL, 'pendingtag', 0),
(46, 'Diet', NULL, 'pendingtag', 0),
(47, 'Easy', NULL, 'tag', NULL),
(48, 'Hard', NULL, 'tag', NULL),
(49, 'Tasty', NULL, 'tag', NULL),
(50, 'Traditional', NULL, 'tag', NULL),
(51, 'Test perso', 3, 'personaltag', NULL),
(52, 'It works !', 3, 'personaltag', NULL);

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `enabled`, `username_canonical`, `email_canonical`, `salt`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`) VALUES
(1, 'antonin', '$2y$13$VhHBRPoFhEZAXqXX4Ly3HOoLpOxflaPCeGLEYNh6TTMM6J.zyFjnm', 'bethouxa+dev@gmail.com', 1, 'antonin', 'bethouxa+dev@gmail.com', NULL, '2017-04-01 15:39:09', NULL, NULL, 'a:0:{}'),
(2, 'admin', '$2y$13$oAiQDhb5PMxq0EejkaWm5eHIX6m4PN.FZEtDxCRjY9IY3hVCyaxpG', 'null@null.com', 1, 'admin', 'null@null.com', NULL, '2017-04-10 17:33:14', NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}'),
(3, 'test', '$2y$13$h5ES9upEsxvKxMIkr1DCyeXWF1jEvDo02gRjDGHvbjwgcXbfW8k.G', 'plop@plop.fr', 1, 'test', 'plop@plop.fr', NULL, '2017-04-12 08:39:22', NULL, NULL, 'a:0:{}');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 22, 2016 at 09:14 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.5.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jrdncchr_directmail`
--

-- --------------------------------------------------------

--
-- Table structure for table `abbreviations`
--

CREATE TABLE `abbreviations` (
  `id` int(11) NOT NULL,
  `abbr` varchar(20) NOT NULL,
  `value` varchar(45) NOT NULL,
  `created_by` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `abbreviations`
--

INSERT INTO `abbreviations` (`id`, `abbr`, `value`, `created_by`, `company_id`, `date_created`) VALUES
(3, 'Bld', 'Building', 2, 1, '2016-11-28 08:55:01'),
(4, 'St', 'Street', 2, 1, '2016-11-28 08:56:46'),
(6, 'Ave', 'Avenue', 2, 1, '2016-11-28 08:58:25'),
(7, 'Apt', 'Apartment', 2, 1, '2016-11-29 06:20:35');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_key` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_key`, `name`, `deleted`, `date_created`) VALUES
(1, 'danero', 'Danero', 0, '2016-10-06 09:04:38'),
(2, 'directmail', 'Direct Mail', 0, '2016-10-06 09:04:38');

-- --------------------------------------------------------

--
-- Table structure for table `list`
--

CREATE TABLE `list` (
  `id` int(11) NOT NULL,
  `list_category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `show_deceased` tinyint(1) NOT NULL DEFAULT '1',
  `show_pr` tinyint(1) NOT NULL DEFAULT '1',
  `show_attorney` tinyint(1) NOT NULL DEFAULT '1',
  `show_mail` tinyint(1) NOT NULL DEFAULT '1',
  `active` tinyint(4) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `created_by` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `list`
--

INSERT INTO `list` (`id`, `list_category_id`, `name`, `show_deceased`, `show_pr`, `show_attorney`, `show_mail`, `active`, `deleted`, `created_by`, `company_id`, `date_created`) VALUES
(1, 2, 'Obituary', 1, 1, 1, 1, 1, 0, 2, 1, '2016-11-10 03:28:54'),
(2, 2, 'Probate', 1, 1, 1, 1, 1, 0, 2, 1, '2016-10-25 04:57:41'),
(3, 2, 'Inherited Trust List', 1, 1, 0, 0, 1, 0, 2, 1, '2016-11-23 05:20:43'),
(9, 2, 'Jordan', 1, 1, 1, 1, 1, 1, 2, 1, '2016-11-18 06:54:49'),
(10, 2, 'Private', 1, 1, 1, 1, 1, 0, 20, 1, '2016-11-10 06:41:35'),
(11, 2, 'Test', 1, 1, 1, 1, 1, 1, 2, 1, '2016-11-18 06:57:02'),
(12, 2, 'Wat', 1, 1, 1, 1, 1, 1, 2, 1, '2016-11-18 07:03:58'),
(13, 4, 'Test 1', 1, 1, 1, 1, 1, 0, 23, 2, '2016-12-22 07:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `list_bullet_point`
--

CREATE TABLE `list_bullet_point` (
  `id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `list_bullet_point`
--

INSERT INTO `list_bullet_point` (`id`, `list_id`, `number`, `content`, `date_created`) VALUES
(1, 2, 1, 'Quia fuga veniam perspiciatis voluptas commodi officia a ea.', '2016-11-09 08:29:15'),
(2, 3, 1, 'Rerum quae nesciunt minima aut modi.', '2016-11-09 08:29:15'),
(3, 3, 1, 'Qui quod quibusdam enim voluptatum consequatur.', '2016-11-09 08:29:15'),
(5, 3, 1, 'Nesciunt corrupti ipsa similique sapiente.', '2016-11-09 08:29:15'),
(8, 3, 1, 'Dolor perferendis delectus amet asperiores.', '2016-11-09 08:29:15'),
(9, 2, 1, 'Suscipit vero suscipit aut nesciunt architecto unde praesentium quo.', '2016-11-09 08:29:15'),
(10, 1, 4, 'Culpa consequatur facilis ut iste occaecati molestias quia placeat.', '2016-11-09 08:29:16'),
(12, 3, 1, 'Quis a iusto deleniti.', '2016-11-09 08:29:16'),
(13, 3, 1, 'Quisquam error maiores recusandae placeat.', '2016-11-09 08:29:16'),
(15, 2, 1, 'Magni ab non quam ea expedita ut et nam.', '2016-11-09 08:29:16'),
(16, 2, 1, 'Necessitatibus accusamus quam qui voluptas tenetur ut quia.', '2016-11-09 08:29:16'),
(19, 1, 3, 'Earum fugiat sed excepturi sed nesciunt non.', '2016-11-09 08:29:16'),
(20, 2, 1, 'Ex odio voluptatum vel.', '2016-11-09 08:29:16'),
(22, 3, 1, 'Soluta dolor molestiae mollitia molestias ullam et soluta quia.', '2016-11-09 08:29:16'),
(23, 2, 1, 'Assumenda ullam quo quas voluptatum distinctio vitae molestias.', '2016-11-09 08:29:16'),
(24, 1, 2, 'Aut sint harum quasi nemo.', '2016-11-09 08:29:16'),
(25, 1, 1, '123', '2016-11-09 08:29:16'),
(26, 3, 1, 'Placeat nobis dolorem sed mollitia rerum.', '2016-11-09 08:29:16'),
(28, 3, 1, 'Quasi quidem optio reiciendis recusandae aliquam similique.', '2016-11-09 08:29:16'),
(31, 1, 5, 'ASD123', '2016-11-09 08:30:20'),
(32, 9, 1, 'asd22', '2016-11-10 06:07:31'),
(33, 9, 2, 'ddd', '2016-11-10 06:07:31');

-- --------------------------------------------------------

--
-- Table structure for table `list_category`
--

CREATE TABLE `list_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `list_category`
--

INSERT INTO `list_category` (`id`, `name`, `description`, `active`, `deleted`, `company_id`, `date_created`) VALUES
(1, 'Category C', 'Category Description Category Description Category Description Category Description ', 1, 1, 1, '2016-10-19 08:37:16'),
(2, 'Default', 'Sample Description', 1, 0, 1, '2016-10-19 08:51:17'),
(3, 'List Category B', 'Sample Category...... Wowness Overload', 1, 0, 1, '2016-10-19 08:52:04'),
(4, 'Test', 'asd', 1, 0, 2, '2016-12-22 07:34:59'),
(5, 'Test 2', '', 1, 0, 2, '2016-12-22 08:03:20');

-- --------------------------------------------------------

--
-- Table structure for table `list_paragraph`
--

CREATE TABLE `list_paragraph` (
  `id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `type` varchar(45) NOT NULL,
  `number` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `list_paragraph`
--

INSERT INTO `list_paragraph` (`id`, `list_id`, `type`, `number`, `content`, `date_created`) VALUES
(1, 1, 'second', 1, 'Ea nam exercitationem laudantium qui aspernatur exercitationem. Doloribus sit voluptas aperiam repudiandae consequatur. Fuga rerum doloremque molestias. Iusto temporibus ad dolores minus non.', '2016-11-08 05:19:31'),
(2, 2, 'ps', 1, 'Nihil omnis itaque deleniti quia et sint et. Fuga non qui ipsa vitae. Est nesciunt dignissimos consequatur aliquid et facere.', '2016-11-08 05:19:31'),
(3, 2, 'intro', 1, 'Quidem labore autem voluptatibus itaque sed. Nesciunt voluptates voluptatem fugit labore sunt et eos. Nulla eligendi aut vel sint.', '2016-11-08 05:19:31'),
(4, 2, 'ps', 2, 'Et praesentium aut et. Inventore sint et temporibus et aut veniam. Odio asperiores in recusandae et porro blanditiis veniam.', '2016-11-08 05:19:31'),
(5, 2, 'second', 2, 'Eius numquam maiores incidunt commodi. Officia consequatur nisi magnam magnam. Tempore voluptatem voluptas praesentium impedit officia. Incidunt temporibus quo odit velit quos dolor sed.', '2016-11-08 05:19:31'),
(6, 2, 'bbb', 1, 'Vel nobis qui et. Pariatur facere doloremque fuga sunt impedit molestiae. Est pariatur officia est aut saepe. Cum sed recusandae consequatur quaerat officiis exercitationem. Omnis harum est blanditiis eum.', '2016-11-08 05:19:31'),
(7, 1, 'kim', 1, 'Neque voluptate voluptatum corrupti incidunt sed. Animi voluptatem enim dolores reiciendis voluptatibus nemo. Quia exercitationem et id ea sunt. Sit non libero est voluptatem doloremque eos placeat.', '2016-11-08 05:19:31'),
(8, 3, 'ps', 3, 'Molestiae impedit cupiditate expedita amet veritatis explicabo rerum. Autem perferendis qui ut quidem odit est.', '2016-11-08 05:19:31'),
(9, 2, 'cta', 1, 'Enim et recusandae deleniti numquam natus dolorem dolor. Corrupti autem repudiandae aliquam fuga ut veritatis tenetur. Earum ex asperiores voluptatem beatae ex modi.', '2016-11-08 05:19:31'),
(10, 2, 'cta', 2, 'Consequatur voluptatem autem recusandae tempore et autem. Ducimus aperiam in eos et. Voluptas sequi officiis fuga itaque.', '2016-11-08 05:19:31'),
(11, 3, 'bbb', 2, 'Dolores ut et sit autem quae qui repellendus. Sint debitis molestias sit quia voluptates sequi voluptates. Illum aut velit voluptate fugit hic omnis.', '2016-11-08 05:19:31'),
(12, 2, 'bbb', 3, 'Reiciendis alias corrupti at possimus assumenda. Quia sit fugit est quae necessitatibus nihil. Odit eum qui et.', '2016-11-08 05:19:31'),
(13, 3, 'bbb', 4, 'Nobis delectus sit enim pariatur dolorem doloribus ut. Qui sed consequuntur voluptatem fuga ratione voluptatibus.', '2016-11-08 05:19:31'),
(14, 2, 'bbb', 5, 'Aut magni corrupti occaecati consequatur saepe quae tenetur. Dignissimos beatae explicabo eaque. Praesentium dolores voluptas vel cum.', '2016-11-08 05:19:32'),
(15, 1, 'bbb', 6, 'Ratione tempora asperiores quibusdam omnis facere similique optio. Iste aut laudantium optio aperiam explicabo quod at. Perspiciatis quia dolorum excepturi eum unde voluptatem.', '2016-11-08 05:19:32'),
(16, 3, 'second', 3, 'Aliquam voluptas natus at est qui. Quidem nam aut voluptatem praesentium facere. Quidem dolore non odit itaque. Ab tempore minima autem impedit.', '2016-11-08 05:19:32'),
(17, 2, 'intro', 2, 'Aperiam sed enim velit sunt sed. Nobis tenetur ex nostrum occaecati nemo similique. Sunt natus qui molestiae rerum.', '2016-11-08 05:19:32'),
(18, 3, 'second', 4, 'Soluta id voluptatem at quos qui quis ut quae. Deserunt dolorem omnis vero aperiam error et. Iure voluptatem voluptatibus officia corporis quia ut.', '2016-11-08 05:19:32'),
(19, 1, 'second', 5, 'Occaecati ut voluptatum eaque facilis dolor voluptatem cumque. Unde sed saepe et laborum qui a. Culpa inventore voluptatibus est molestias.', '2016-11-08 05:19:32'),
(20, 3, 'intro', 1, 'Autem molestias aut laborum asperiores. Autem a laborum et eos. Quas laudantium nihil sunt incidunt.', '2016-11-08 05:19:32'),
(21, 1, 'bbb', 7, 'Aliquid omnis quaerat corrupti officiis odio adipisci eligendi. Pariatur odit ea corporis vel numquam commodi impedit. Exercitationem fuga mollitia tempore et.', '2016-11-08 05:19:32'),
(22, 3, 'intro', 2, 'Et sunt non possimus accusantium et maiores rerum voluptatem. Officia qui tenetur quia. Assumenda et culpa libero veritatis. Voluptatem dolorem corrupti distinctio ducimus.', '2016-11-08 05:19:32'),
(23, 2, 'kim', 2, 'Facere inventore ea dolor eos reprehenderit beatae. Iusto non voluptas odit amet consequatur laboriosam possimus.', '2016-11-08 05:19:32'),
(24, 3, 'cta', 3, 'Assumenda explicabo nihil quibusdam nostrum voluptatibus. Recusandae necessitatibus voluptatem non cupiditate est voluptatibus velit dolor. Soluta aut ut veritatis blanditiis nemo quod est. Expedita maxime assumenda doloribus quidem totam aut.', '2016-11-08 05:19:32'),
(25, 2, 'second', 6, 'Dolorem illo dolorum neque et et ea voluptatem. Qui error dicta autem pariatur et eveniet ut. Ducimus itaque rerum delectus id accusantium voluptates quaerat quis. Laudantium expedita aut natus expedita consectetur ut est.', '2016-11-08 05:19:32'),
(26, 3, 'kim', 3, 'In veniam voluptates corrupti. Sunt hic illo veritatis perspiciatis et. Distinctio cum nihil omnis minus quis doloremque quam. Rerum pariatur quia incidunt.', '2016-11-08 05:19:32'),
(27, 1, 'bbb', 8, 'Sed sed velit cumque accusantium qui nisi. Quo a iusto repudiandae aperiam incidunt impedit et. Ut eligendi rerum facere id quia mollitia illo. Itaque ad et ut nihil est. Necessitatibus quis inventore consequatur ut nisi voluptates totam.', '2016-11-08 05:19:32'),
(28, 1, 'intro', 1, 'Optio fuga cum pariatur at omnis ea minima. Dolores nisi est aliquam excepturi. Et voluptatum sed recusandae distinctio libero officiis. Ut aperiam natus hic aspernatur.', '2016-11-08 05:19:32'),
(29, 2, 'bbb', 9, 'Sunt quis autem rerum error. Repellendus est a enim. Enim esse nesciunt perspiciatis accusamus.', '2016-11-08 05:19:32'),
(30, 3, 'bbb', 10, 'Molestiae illum voluptatum hic nisi tenetur at. Reprehenderit ad aut aut voluptatem. Rerum quia iure aut distinctio.', '2016-11-08 05:19:32'),
(33, 1, 'ps', 1, 'asd 222', '2016-11-08 07:19:16'),
(34, 1, 'ps', 2, 'asdd ccc', '2016-11-08 07:19:16'),
(35, 1, 'ps', 3, 'asd 213 d', '2016-11-08 07:19:16'),
(36, 1, 'cta', 1, 'sd', '2016-11-09 08:42:31'),
(37, 9, 'intro', 1, 'ASd', '2016-11-10 06:07:24'),
(38, 9, 'intro', 2, 'asd2', '2016-11-10 06:07:24'),
(39, 9, 'cta', 1, 'asddd', '2016-11-10 06:07:48'),
(40, 9, 'cta', 2, 'dd', '2016-11-10 06:07:48'),
(41, 3, 'intro', 3, 'asd', '2016-11-14 06:58:35');

-- --------------------------------------------------------

--
-- Table structure for table `list_testimonial`
--

CREATE TABLE `list_testimonial` (
  `id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `content` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `list_testimonial`
--

INSERT INTO `list_testimonial` (`id`, `list_id`, `number`, `content`, `date_created`) VALUES
(1, 3, 1, 'Quis aut adipisci quis doloribus vel debitis. Alias dolor quidem ut nesciunt quod. Perferendis assumenda occaecati corporis rerum consequatur itaque placeat.', '2016-11-09 09:21:46'),
(2, 2, 1, 'Sed quia consectetur earum voluptatem quis est aut. Molestiae reiciendis sit dolorem voluptas tempora.', '2016-11-09 09:21:46'),
(3, 2, 1, 'Ea repudiandae dolorum molestiae debitis in consectetur. Veniam maxime voluptatibus aut. Delectus perspiciatis amet sit. Quasi excepturi velit aspernatur nisi aut ea.', '2016-11-09 09:21:46'),
(4, 3, 1, 'Eaque dolorum fugiat molestiae error. Perferendis qui odio repudiandae dolor. Aspernatur ea aut incidunt vitae.', '2016-11-09 09:21:46'),
(5, 2, 1, 'Placeat nostrum maxime et quidem sint. Voluptatum iure aut iure quia pariatur quas. Rerum perspiciatis et minima sunt rem libero minus. Rerum quas explicabo ut qui nesciunt quo id.', '2016-11-09 09:21:46'),
(7, 1, 1, 'asd', '2016-11-09 09:21:46'),
(8, 2, 1, 'Et rerum voluptatem et voluptates dolorum. Nostrum nihil illo enim facilis facere quis commodi quia.', '2016-11-09 09:21:46'),
(9, 2, 1, 'Adipisci qui necessitatibus molestias sed voluptatibus. Fugiat fuga sed distinctio totam nemo odio. Libero officiis qui nobis modi. Aliquam dolores neque aut placeat qui.', '2016-11-09 09:21:46'),
(10, 3, 1, 'Qui impedit fuga ab maiores iure incidunt explicabo. Beatae sit recusandae temporibus facilis. Asperiores et cum vero quas magni nam culpa et.', '2016-11-09 09:21:46'),
(11, 2, 1, 'Eum dolorem optio fuga adipisci quis et. In laboriosam voluptate dolorem ut. Omnis ea odit quisquam rem deserunt architecto. Magni qui minima est est dolor.', '2016-11-09 09:21:46'),
(13, 2, 1, 'Neque tenetur et repudiandae aut repellat similique porro. Neque vel optio ullam quis velit. Esse commodi earum sed ea corrupti voluptas recusandae. Blanditiis qui alias recusandae aut quis error eum.', '2016-11-09 09:21:46'),
(15, 2, 1, 'Autem autem odio possimus quis. Eum autem qui molestiae repellat doloribus. Qui consequatur inventore consequuntur et atque. A aperiam velit nihil et.', '2016-11-09 09:21:46'),
(16, 3, 1, 'Et autem porro dolor porro vel sit. Eligendi et molestiae adipisci autem. Cumque hic est ducimus eos recusandae. Reiciendis hic perferendis corporis.', '2016-11-09 09:21:46'),
(17, 2, 1, 'Sint at earum et placeat et. Molestiae minima architecto et. Reprehenderit voluptatibus maxime voluptatem nesciunt doloremque et. Consectetur minima id iusto odit et minus.', '2016-11-09 09:21:46'),
(19, 3, 1, 'Adipisci tempora vitae magnam nostrum. Nihil voluptatem asperiores cupiditate est soluta et. Repellendus natus enim nihil error at. Est consequatur molestias quasi minima est.', '2016-11-09 09:21:46'),
(20, 3, 1, 'Quod expedita est ipsam praesentium at nostrum sunt. Nihil eum aliquam est rerum vel tenetur a laborum. Dolorum alias dicta harum impedit. Enim exercitationem minus beatae et voluptate.', '2016-11-09 09:21:46'),
(21, 3, 1, 'Tempore ut neque rerum voluptatibus voluptas necessitatibus. Sunt ex quo velit a sunt ut et. Maiores et est cumque suscipit quia ut veniam.', '2016-11-09 09:21:47'),
(22, 1, 2, 'Consequatur assumenda et dolorum ut quia voluptate voluptas et. Ea id aliquam soluta tenetur ratione. Qui repellat sed laborum doloremque optio. Quia dolores culpa asperiores itaque consequatur.', '2016-11-09 09:21:47'),
(23, 3, 1, 'Non illo et magni voluptatibus sunt libero est. Nam laudantium tempora provident illo. Sit dolorem earum sit magni. Mollitia porro dolorem ut odit in rem consectetur.', '2016-11-09 09:21:47'),
(24, 2, 1, 'Natus nemo velit qui. Ad natus qui dolores. Praesentium est earum facere deserunt error. Id voluptas assumenda vero dolores velit.', '2016-11-09 09:21:47'),
(25, 1, 3, 'Omnis dignissimos deserunt recusandae eos debitis voluptatem voluptas. Reiciendis cupiditate quis eos dolore ex quo aliquam. Tempore sit occaecati eum aut dolor.', '2016-11-09 09:21:47'),
(26, 3, 1, 'At beatae aspernatur voluptates quasi. Omnis dolores deleniti autem consequatur. Sunt laudantium dolorum minima officiis sed sit. Quis quis qui fuga libero quia sequi.', '2016-11-09 09:21:47'),
(27, 2, 1, 'Ipsum et et officia est sed perferendis. Molestiae libero ea delectus earum cumque.', '2016-11-09 09:21:47'),
(28, 2, 1, 'Quidem omnis et omnis sed blanditiis. Dignissimos fugit aut veniam adipisci dolore. Dolor beatae reiciendis eos sit quis qui ut.', '2016-11-09 09:21:47'),
(29, 3, 1, 'Non aut fugiat aut animi. Sed cupiditate voluptas quia sed architecto et est voluptate. Vel cum ducimus quia. Quisquam repellendus qui quis odit id.', '2016-11-09 09:21:47'),
(30, 2, 1, 'Harum optio aliquam odit minus. Dolorum eum pariatur et reiciendis ratione mollitia. Asperiores quo facilis nulla.', '2016-11-09 09:21:47'),
(31, 1, 4, 'Wahahaha', '2016-11-09 09:22:05'),
(32, 1, 5, 'asdadsad', '2016-11-09 09:22:05'),
(33, 9, 1, 'sss', '2016-11-10 06:07:40'),
(34, 9, 2, 'sss', '2016-11-10 06:07:40'),
(35, 10, 1, 'awaaa', '2016-11-10 06:41:48');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(45) NOT NULL,
  `description` varchar(300) NOT NULL,
  `link` varchar(200) NOT NULL DEFAULT '#',
  `parent_id` int(11) DEFAULT NULL,
  `display_order` int(11) NOT NULL DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `icon` varchar(100) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `code`, `description`, `link`, `parent_id`, `display_order`, `active`, `icon`, `date_created`) VALUES
(1, 'Dashboard', 'dashboard', 'Default page when user logged in.', '#', 0, 1, 1, '<i class="fa fa-dashboard"></i>', '2016-10-12 07:25:27'),
(2, 'List', 'list', 'Lists', 'lists/category/add', 0, 2, 1, '<i class="fa fa-list"></i>', '2016-10-12 07:25:27'),
(8, 'Templates', 'templates', '', '#', 0, 3, 1, '<i class="fa fa-file-text-o"></i>', '2016-10-12 07:34:12'),
(14, 'Reports', 'reports', '', '#', 0, 5, 1, '<i class="fa fa-bar-chart"></i>', '2016-10-12 07:38:20'),
(15, 'Mailings', 'reports-mailings', '', '#', 14, 1, 1, '', '2016-10-12 07:40:37'),
(16, 'Tags', 'repots-tags', '', '#', 14, 2, 1, '', '2016-10-12 07:40:37'),
(17, 'Names', 'reports-names', '', '#', 14, 3, 1, '', '2016-10-12 07:42:08'),
(18, 'Settings', 'settings', '', '#', 0, 6, 1, '<i class="fa fa-cog"></i>', '2016-10-12 07:42:40'),
(19, 'General', 'settings-general', '', '#', 18, 1, 1, '', '2016-10-12 07:43:54'),
(20, 'Notification', 'settings-notification', '', '#', 18, 2, 1, '', '2016-10-12 07:43:54'),
(21, 'Management', 'management', '', '#', 0, 7, 1, '<i class=''fa fa-wrench''></i>', '2016-10-13 04:48:43'),
(22, 'Users', 'management-users', '', 'management/users', 21, 1, 1, '', '2016-10-13 04:49:28'),
(23, 'Roles', 'management-roles', '', 'management/roles', 21, 2, 1, '', '2016-10-13 04:49:55'),
(24, 'List Categories', 'management-list-categories', 'Categories of Lists', 'management/list_categories', 21, 3, 1, '', '2016-10-18 08:00:47'),
(27, 'Approval', 'approval', '', '#', 0, 4, 1, '<i class="fa fa-thumbs-up"></i>', '2016-10-12 07:38:20'),
(28, 'Properties', 'approval-properties', '', 'approval/properties', 27, 1, 1, '', '2016-10-12 07:40:37'),
(29, 'Mail Templates', 'mail-templates', '', 'templates/mail', 8, 1, 1, '', '2016-10-12 07:43:54'),
(30, 'Abbreviations', 'settings-abbreviations', '', 'settings/abbreviations', 18, 3, 1, '', '2016-10-12 07:43:54'),
(31, 'Similar Address Generator', 'management-similar-address-generator', 'Similar Address Checker', 'management/similar_address_generator', 21, 4, 1, '', '2016-10-18 08:00:47'),
(32, 'Replacements', 'approval-replacements', '', 'approval/replacements', 27, 2, 1, '', '2016-10-12 07:40:37');

-- --------------------------------------------------------

--
-- Table structure for table `property`
--

CREATE TABLE `property` (
  `id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'pending',
  `funeral_home` varchar(100) NOT NULL,
  `deceased_first_name` varchar(100) NOT NULL,
  `deceased_middle_name` varchar(100) NOT NULL,
  `deceased_last_name` varchar(100) NOT NULL,
  `deceased_address` varchar(255) NOT NULL,
  `deceased_city` varchar(50) NOT NULL,
  `deceased_state` varchar(20) NOT NULL,
  `deceased_zipcode` varchar(20) NOT NULL,
  `pr_first_name` varchar(100) NOT NULL,
  `pr_middle_name` varchar(100) NOT NULL,
  `pr_last_name` varchar(100) NOT NULL,
  `pr_address` varchar(200) NOT NULL,
  `pr_city` varchar(50) NOT NULL,
  `pr_state` varchar(20) NOT NULL,
  `pr_zipcode` varchar(20) NOT NULL,
  `attorney_name` varchar(150) NOT NULL,
  `attorney_first_address` varchar(200) NOT NULL,
  `attorney_second_address` varchar(200) NOT NULL,
  `attorney_city` varchar(50) NOT NULL,
  `attorney_state` varchar(50) NOT NULL,
  `attorney_zipcode` varchar(20) NOT NULL,
  `mail_first_name` varchar(100) NOT NULL,
  `mail_last_name` varchar(100) NOT NULL,
  `mail_address` varchar(200) NOT NULL,
  `mail_city` varchar(50) NOT NULL,
  `mail_state` varchar(50) NOT NULL,
  `mail_zipcode` varchar(20) NOT NULL,
  `start_quarterly_mail` tinyint(4) NOT NULL,
  `elligible_letter_mailings` tinyint(4) DEFAULT '0',
  `elligible_postcard_mailings` tinyint(4) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `last_update` date NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property`
--

INSERT INTO `property` (`id`, `list_id`, `status`, `funeral_home`, `deceased_first_name`, `deceased_middle_name`, `deceased_last_name`, `deceased_address`, `deceased_city`, `deceased_state`, `deceased_zipcode`, `pr_first_name`, `pr_middle_name`, `pr_last_name`, `pr_address`, `pr_city`, `pr_state`, `pr_zipcode`, `attorney_name`, `attorney_first_address`, `attorney_second_address`, `attorney_city`, `attorney_state`, `attorney_zipcode`, `mail_first_name`, `mail_last_name`, `mail_address`, `mail_city`, `mail_state`, `mail_zipcode`, `start_quarterly_mail`, `elligible_letter_mailings`, `elligible_postcard_mailings`, `company_id`, `created_by`, `active`, `deleted`, `last_update`, `date_created`) VALUES
(1, 3, 'pending', '8265 Hudson Crescent\nSouth Murlshire, TX 88549', 'Constantin', 'Reinger', 'Jenkins', '#147 Cist FallsWest Vigiiebuy, MS 35271-3190', 'Daphneville', 'stad', '79586-8060', 'Melissa', 'Simonis', 'Kulas', '196 Wiegand Course Suite 401\nSouth Chazfort, NY 37687-7936', 'Archibaldfurt', 'stad', '15316', 'Dr. Ike Ankunding', '338 Greenholt Squares Apt. 825\nNorth Kamilleview, FL 10153-6098', '555 Rebekah Mews Suite 737\nCrooksfurt, VT 52450-9323', 'Powlowskiview', 'side', '82212', 'Tatum', 'Schultz', '172 Effertz Heights Suite 104\nArielstad, IL 36944', 'Turnerhaven', 'furt', '91541', 0, 1, 0, 1, 2, 1, 0, '2016-12-06', '2016-11-18 07:12:57'),
(2, 1, 'pending', '87304 Krajcik Roads\nPort Carolinamouth, MT 04471', 'Lazaro', 'Yundt', 'Blanda', '#99101 Will Steet Apt. #178O', 'North Brenden', 'borough', '76611', 'Cassidy', 'Schaefer', 'Jones', '643 Rico Unions\nNorth Norwoodbury, OR 75496-5828', 'New August', 'land', '34702', 'Dr. Troy Boyer', '2512 Von Run\nTrompshire, WI 29407', '5384 Leopold Camp\nChristiansenchester, ND 50481-4538', 'Lake Edd', 'view', '81229-8904', 'Roslyn', 'Kshlerin', '876 Pearl Manors Apt. 462\nGerryport, AL 42594', 'New Otha', 'stad', '90622-2891', 0, 1, 1, 1, 33, 1, 0, '2016-12-20', '2016-11-18 07:12:58'),
(3, 3, 'pending', '8067 Monserrate Isle\nSouth Adellemouth, AL 91623', 'Bailee', 'Greenfelder', 'Haag', '33681 Majoy ValleyBeiepot, ID 93121', 'Westchester', 'land', '74415', 'Deonte', 'Kilback', 'O''Hara', '789 O''Keefe Ridge\nO''Konport, NV 75188-8728', 'Stiedemannborough', 'shire', '82063-1287', 'Jaeden Ondricka', '12267 Mosciski Vista Suite 282\nSouth Griffin, TN 34488', '3819 Kris Junctions\nDouglasville, MI 74757-9515', 'Schowalterside', 'borough', '39579-5579', 'Judson', 'Emard', '1809 Mauricio Prairie\nNew Clarabelleburgh, NV 00931', 'North Abigale', 'town', '11133', 0, 0, 1, 1, 38, 1, 0, '2016-11-18', '2016-11-18 07:12:58'),
(4, 1, 'pending', '865 Upton Prairie\nEast Blaketon, NM 57757-4785', 'Raheem', 'Kozey', 'Hodkiewicz', '17613 Demacus Extesio Apt. 842Kisville, CO 38932', 'East Abigayle', 'land', '71667', 'Alexa', 'Altenwerth', 'Jaskolski', '47760 Konopelski Mill\nLake Margie, OK 77681-5426', 'Lebsackchester', 'fort', '33557-8727', 'Jeremy Wolff', '44103 Delta Row Suite 525\nFelipebury, NJ 89198-6821', '46645 Kassulke Plaza\nNorth Aiden, MO 83616-2943', 'Dustinberg', 'bury', '98918', 'Kenyon', 'Lynch', '514 Turner Common\nBatzfurt, CA 02476', 'East Krystalbury', 'chester', '21554-7607', 1, 0, 1, 1, 19, 1, 0, '2016-11-18', '2016-11-18 07:12:58'),
(5, 3, 'pending', '73992 Edythe Lights Apt. 211 East Kelsie, KY 80195', 'Dena', 'Sporer', 'Jaskolski', '#49473 Jaio Paks Apt. 22', 'East Myaside', 'chester', '09022', 'Ocie', 'Jaskolski', 'Blanda', '46413 Kista LockElbettow', 'Morissettestad', 'MO', '75566', 'Ocie', 'Jaskolski', '46413 Kista LockElbettow', 'Morissettestad', 'MO', '75566', 'Ocie', 'Jaskolski', '46413 Kista LockElbettow', 'Morissettestad', 'MO', '75566', 0, 0, 0, 1, 2, 1, 0, '2016-12-20', '2016-11-18 07:12:58'),
(6, 1, 'pending', '1134 Ondricka Trail Apt. 951\nEffieton, TN 82147', 'Samara', 'Harris', 'Hegmann', '12288 Bato DivesWest Bettyebugh, RI 10809', 'North Judyside', 'ville', '46486', 'Roxanne', 'Schoen', 'Schamberger', '883 Annabelle Track\nWeldontown, MA 99569', 'Dereckhaven', 'fort', '17691-3849', 'Martina Bogisich II', '18438 Schneider Bypass\nEast Arjunmouth, WV 89036', '630 Liza Drives Suite 316\nMalvinaton, WA 62427', 'Jakubowskichester', 'ton', '62469', 'Bruce', 'Yost', '89941 Gulgowski Mountain\nLeschland, IN 51965', 'Huelsport', 'mouth', '14073-6515', 1, 1, 0, 1, 2, 1, 0, '2016-11-18', '2016-11-18 07:12:58'),
(7, 3, 'pending', '633 Hessel Rapid\nBalistreriborough, NM 37818-5424', 'Carli', 'Ritchie', 'Considine', '223 Ebet Highway Apt. 155New Ibahim, VA 67675', 'East Kenyattaland', 'view', '24414-8006', 'Josefina', 'Quigley', 'Blanda', '16527 Satterfield Vista Suite 328\nDurwardbury, KY 95708', 'Marlinton', 'fort', '08583-1474', 'Bethany Cole III', '5911 Eulalia Fall\nNew Marlenville, TX 18124', '736 Watsica Station\nNorth Thaddeus, NE 92524', 'West Moriah', 'bury', '57136', 'Shanna', 'Osinski', '400 Roberts Mission\nHettingerside, MO 61869', 'Kerluketon', 'shire', '11071-2538', 0, 1, 1, 1, 28, 1, 0, '2016-11-18', '2016-11-18 07:12:59'),
(8, 1, 'pending', '488 Emelia Highway Apt. 532\nDavisport, LA 73291', 'Willy', 'Barton', 'Williamson', '6318 Esteba SkywayLake Destieymouth, OR 70932', 'Lake Kianaview', 'bury', '59032-0152', 'Otto', 'Steuber', 'Wisoky', '474 Damon Center\nWest Chance, LA 77622', 'East Devyn', 'furt', '47031', 'Melany Streich', '314 Garth Courts\nNew Tiaville, AL 45901', '87294 Upton Extension Apt. 038\nWest Destineeport, NE 56276', 'Lake Brendon', 'mouth', '63393', 'Toy', 'Funk', '847 Wisoky Spurs Suite 470\nDickiview, OH 11128-4297', 'Port Nolaside', 'burgh', '42478', 0, 1, 0, 1, 40, 1, 0, '2016-11-18', '2016-11-18 07:12:59'),
(9, 1, 'pending', '94467 Daniela Mission\nVivianneville, AZ 86977', 'Maryam', 'Orn', 'Doyle', '60313 Boye MissioAikaview, NV 73174-3353', 'Port Rodview', 'land', '32491', 'Magdalena', 'Schmitt', 'Ledner', '635 Hodkiewicz Point\nPort Joseburgh, ND 05659', 'South Dovieland', 'berg', '14212', 'Mr. Justen Kerluke', '5856 Elna Flats Suite 136\nPatiencemouth, VA 51573', '2787 Ullrich Street Apt. 512\nPredovicchester, FL 23673', 'Daynefurt', 'shire', '04820', 'Tomasa', 'Schmitt', '91995 Orn Harbor\nSouth Wayne, WI 44156-0190', 'Bergstromfurt', 'ville', '84896-7692', 0, 0, 1, 1, 13, 1, 0, '2016-11-18', '2016-11-18 07:12:59'),
(10, 2, 'pending', '750 Haven Expressway Apt. 041\nSouth Jaquelinshire, CA 83283-1094', 'Payton', 'Auer', 'O''Conner', '91920 Lowe Plaza Apt. 841Lake Amaya, ID 46344-0184', 'Hellershire', 'burgh', '48299-1525', 'Roslyn', 'Hermiston', 'Nitzsche', '65334 Flossie Avenue Suite 328\nLake Macyborough, CO 57404', 'South Chauncey', 'land', '81554', 'Lue Pacocha', '271 Kuhn Locks\nNew Alexandrachester, MA 67697-6090', '8846 Cesar Shores\nNew Pansymouth, OH 17327', 'West Beulahland', 'town', '05095-6815', 'Howard', 'McCullough', '214 Berge Union\nEast Georgiannaville, AR 03953', 'Doloresport', 'berg', '56100-2319', 1, 0, 1, 1, 50, 1, 0, '2016-11-18', '2016-11-18 07:12:59'),
(11, 3, 'pending', '1784 Graham Shore\nEast Frederickshire, MS 53828-0472', 'Rosalinda', 'Ortiz', 'Rice', '452 Ruolfsso Have Suite 637Jackiefut, DC 56916-2982', 'Benjaminside', 'berg', '29197-8628', 'Claudine', 'Barrows', 'Veum', '972 Maximus Springs\nVestaville, CT 75576-7631', 'West Alvenastad', 'land', '47580-9788', 'Geoffrey Medhurst', '786 Dario Orchard\nKihnfort, DE 66781-9896', '14302 Beatty Walks Apt. 911\nLake Tracy, ND 82244', 'New Sybleville', 'view', '44408-8652', 'Rodolfo', 'Terry', '8289 Abernathy Glen\nTillmanberg, NM 96564-0483', 'McClureburgh', 'chester', '89038', 1, 0, 0, 1, 18, 1, 0, '2016-11-18', '2016-11-18 07:12:59'),
(12, 1, 'pending', '782 Meggie Well Apt. 716\nLake Carrieville, NH 76607', 'Lance', 'Bednar', 'Dickens', '9157 Khalid Roads Suite 950South Isidofut, DE 67894', 'Kilbackfurt', 'mouth', '36561-5124', 'Flo', 'Robel', 'Ritchie', '5444 Beatty Circle Suite 771\nPort Janechester, NM 17396-8593', 'Danielfurt', 'borough', '20811', 'Thaddeus Abernathy', '944 Bartell Squares Apt. 251\nEast Vita, NM 99194-8156', '1812 Marvin Place\nEast Diego, MI 64372', 'New Magnolia', 'ville', '04087', 'Mackenzie', 'Emard', '29585 Boehm Islands\nIsaitown, NY 95989', 'Klockofort', 'berg', '46198-8408', 0, 1, 0, 1, 38, 1, 0, '2016-11-18', '2016-11-18 07:13:00'),
(13, 2, 'pending', '815 Marquise Junction Apt. 233\nWest Vanborough, KY 52392-3727', 'Providenci', 'Wisozk', 'Hudson', '386 Stacke RoadsSouth Aissa, MD 20489-0130', 'New Mayside', 'port', '08637', 'Summer', 'Olson', 'Stoltenberg', '64320 Elfrieda Springs Suite 987\nRyleighville, MN 19917-2209', 'Lake Solonside', 'view', '25217', 'Scotty Bauch', '442 Earline Circles Suite 248\nSouth Wilhelm, DE 96653-4865', '61566 Alexane Mill Suite 679\nNorth Candido, CA 69129', 'Winifredberg', 'bury', '19951', 'Julianne', 'Baumbach', '4474 Cecelia Fork Apt. 840\nBrisabury, SD 03824-3460', 'South Alisonton', 'ton', '48691', 0, 0, 1, 1, 27, 1, 0, '2016-11-18', '2016-11-18 07:13:00'),
(14, 3, 'pending', '9722 Bergstrom Lakes Apt. 082\nKautzerfurt, PA 86423-0022', 'Maximus', 'Miller', 'Harber', '203 Gehold PoitNew Megaefut, OR 15679', 'Haleighton', 'chester', '23875-6996', 'Percy', 'Larson', 'Schumm', '5162 Bartoletti Manors\nKeeblerton, KY 07454', 'North Reyna', 'furt', '85161', 'Jay Pfannerstill IV', '6577 Breana Cliffs Suite 219\nSouth Darron, NY 90931', '48334 Aaron Keys Apt. 249\nSouth Ariannamouth, MN 16195', 'Lake Bert', 'fort', '82409', 'Aurelie', 'Casper', '7325 Lindgren Mill\nMaxchester, MD 84064', 'East Freida', 'borough', '27752', 1, 1, 0, 1, 26, 1, 0, '2016-11-18', '2016-11-18 07:13:00'),
(15, 2, 'pending', '790 Newell Gateway\nTravisview, DE 67406-7219', 'Golda', 'Pacocha', 'Koelpin', '455 Boehm CausewayNew Jodyfot, MD 34884', 'Mullertown', 'mouth', '86843-3423', 'Myrtice', 'Murray', 'Schamberger', '175 Keara Flats\nDaughertyton, CT 48420', 'New Granvilleland', 'haven', '88349-0299', 'Miss Marge Witting MD', '5554 Kylie Isle\nNew Kirafurt, WI 76462', '5915 Liza Park\nKihnbury, CT 46944', 'Adrienview', 'bury', '29040-2823', 'Aurore', 'Farrell', '25035 Alexandrine Springs\nStammmouth, WI 99049-8968', 'West Macberg', 'shire', '85731', 1, 0, 1, 1, 12, 1, 0, '2016-11-18', '2016-11-18 07:13:00'),
(16, 3, 'pending', '5625 Dietrich Gateway\nSouth Alannafurt, TN 43433', 'Edmond', 'Pfannerstill', 'Russel', '942 Katia Coes Apt. 404Fosteville, NV 52668', 'East Mathew', 'shire', '36736-8066', 'Kamille', 'Marquardt', 'Ortiz', '2826 Sadie Glen\nElwinview, MI 27546', 'Ernestinemouth', 'port', '18253-4495', 'Dr. Oswald Dietrich MD', '981 Llewellyn Fall\nWest Buster, TN 44228-6347', '9338 Jacobson Mission\nNew Martafurt, NM 04498-8268', 'Bernitaview', 'borough', '73651-4334', 'Vergie', 'McGlynn', '1122 Stamm Pike\nLake Dahlia, SD 70752-7021', 'Lake Damienside', 'furt', '94378', 0, 1, 1, 1, 39, 1, 0, '2016-11-18', '2016-11-18 07:13:01'),
(17, 2, 'pending', '6599 Ari Ports\nSylvesterborough, ME 09381-8297', 'Casey', 'Considine', 'Shanahan', '874 Amstog PlaisWest Lamot, WY 70032-3232', 'Lake Drakehaven', 'burgh', '41515-8565', 'Haylie', 'Hammes', 'Ankunding', '34497 Torp Land\nHeathcoteberg, RI 54576', 'Lake Christian', 'borough', '13732-6607', 'Miss Zoie Miller', '54609 Abbott Trace\nKlingside, NC 15215-4504', '3821 Lucius Pass\nWest Forrestburgh, MS 12691', 'Legrosbury', 'haven', '38108', 'Alanis', 'Gibson', '78467 Dickinson Underpass Apt. 284\nSanfordborough, CA 79593', 'Beattyside', 'burgh', '93227-7090', 1, 0, 1, 1, 26, 1, 0, '2016-11-18', '2016-11-18 07:13:01'),
(18, 1, 'pending', '28125 Kyleigh Forges Suite 854\nWatersfurt, WI 14760-6051', 'Samir', 'Adams', 'Harvey', '205 Uba Cove Apt. 476South Mya, CO 41285', 'Lake Marcos', 'ville', '71525-1537', 'Chyna', 'Schultz', 'Brekke', '3349 Therese Island\nRosalindastad, MD 99529-9842', 'Mertzville', 'haven', '51852-5528', 'Nathanael Gibson', '31565 Candelario Drive Suite 437\nEleazarburgh, OR 07646', '7719 Florine Garden Apt. 023\nLubowitzmouth, MD 07683-6557', 'Skylarhaven', 'ville', '18549', 'Lenny', 'Walker', '27475 Katharina Court Suite 632\nEast Meghanview, PA 99594', 'Bradtkemouth', 'chester', '45666', 0, 0, 0, 1, 40, 1, 0, '2016-11-18', '2016-11-18 07:13:01'),
(19, 2, 'pending', '96804 Hane Inlet Apt. 092\nAdrainborough, OH 82889', 'Bert', 'Wilkinson', 'Koelpin', '668 Top Bidge Apt. 022Gottliebbuy, IN 16144-7575', 'Henrietteshire', 'berg', '75671-4030', 'Ismael', 'Auer', 'Gislason', '2965 Jaclyn Forge Suite 562\nWest Kyla, IL 80076', 'Lake Zelma', 'town', '50550-0340', 'Queen Schmidt', '417 Rachelle Common Apt. 472\nNew Murraybury, RI 96007', '3151 Jerde Track Suite 218\nRachelleborough, CT 63240', 'Port Samantahaven', 'mouth', '57580-7539', 'Jose', 'Koelpin', '348 Althea Summit Apt. 890\nReynoldbury, OH 66600-5982', 'Doylefort', 'shire', '91586', 1, 1, 1, 1, 14, 1, 0, '2016-11-18', '2016-11-18 07:13:01'),
(20, 3, 'pending', '19573 Golden Passage Suite 653\nPort Ryleebury, AZ 96841-2538', 'Juliana', 'Corkery', 'Fisher', '88978 Spoe Pakway Apt. 933Tatowside, AZ 04401-3600', 'New Agnesshire', 'chester', '28676-0249', 'Tate', 'Schamberger', 'Bernier', '237 Christop Square\nWest Bettie, AZ 33129-7859', 'Port Jaydachester', 'borough', '64122', 'Dr. Mervin Feeney Jr.', '54212 Jacobs Heights\nNew Geovanni, SC 11334', '26507 Nader Mount\nLake Matilda, WA 51321', 'East Corbin', 'mouth', '05631', 'Hester', 'Gutkowski', '912 Jones Forks Apt. 919\nSouth Lorenzville, CA 51043-3890', 'Troyberg', 'mouth', '40612', 1, 0, 0, 1, 17, 1, 0, '2016-11-18', '2016-11-18 07:13:01'),
(21, 1, 'pending', '547 Elissa Dale Suite 329\nDavidton, SD 47263', 'Deron', 'Mills', 'McGlynn', '#877 Pacocha Cicle Apt. 851East Alfedamouth', 'North Ivaview', 'bury', '82500', 'Janet', 'Bartoletti', 'Berge', '753 Malvina Common Apt. 187\nLake Mossie, AK 13967', 'Stammside', 'furt', '19002', 'Dr. Darby Purdy', '46490 Barrett Inlet\nSteuberland, IN 15648', '90407 Ziemann Junction Apt. 667\nEast Esperanzashire, FL 72087', 'Riverbury', 'borough', '07296', 'Zola', 'Wiegand', '86015 Sipes Drive\nTurcottefort, IN 79099', 'Mrazchester', 'side', '17087', 1, 1, 1, 1, 17, 1, 0, '2016-12-20', '2016-11-18 07:13:02'),
(22, 2, 'pending', '1811 Hattie Ridges\nEast Alice, NM 51515', 'Janice', 'Hirthe', 'O''Hara', '947 Zola Light Suite 702Kaleetow, NE 63045-5033', 'Heidishire', 'view', '10677', 'Monroe', 'Buckridge', 'Turner', '518 Johnny Tunnel\nEstelport, AR 39495-5405', 'Mantehaven', 'port', '22285-2785', 'Prof. Antonia Herzog', '8537 Jude Courts\nHoegerville, MA 23188-8392', '9714 Jakubowski Plain\nMaurinefurt, NM 80710', 'Ferrymouth', 'side', '16378', 'Ethyl', 'Bernhard', '8105 Rolfson Junction Apt. 993\nEast Noe, KY 00584-8793', 'Prohaskaland', 'borough', '48010-5305', 0, 1, 1, 1, 37, 1, 0, '2016-11-18', '2016-11-18 07:13:02'),
(23, 1, 'pending', '784 Streich Lights Apt. 230\nDavemouth, UT 37156-2468', 'Jaylon', 'Goldner', 'Thompson', '537 Towe FeyJeodbugh, MT 21103', 'New Ova', 'town', '66275', 'Loraine', 'Welch', 'Aufderhar', '724 Stokes Streets Apt. 506\nWest Murrayhaven, DE 56987-8383', 'Ziemannburgh', 'mouth', '06417', 'Coralie Simonis', '2583 Lurline Glens Suite 054\nEast Keely, AR 05242-2869', '191 Russel Route Suite 847\nPort Dorothy, SC 73986-9387', 'Guiseppefurt', 'mouth', '84258', 'Bud', 'Mohr', '3439 Collier Throughway\nNew Franco, VA 84355-7523', 'Waterschester', 'port', '50460', 0, 1, 1, 1, 33, 1, 0, '2016-11-18', '2016-11-18 07:13:02'),
(24, 1, 'pending', '9476 Kaitlyn Villages\nWest Dangelofort, WY 99679', 'Randal', 'Nikolaus', 'Brakus', '62523 Jado Tace Apt. 831Nasiside, MO 73438-5757', 'Emardfurt', 'ton', '23237', 'Rossie', 'Bergstrom', 'Nikolaus', '38185 Izabella Plaza\nBoehmview, MS 85525', 'Port Brandtfort', 'town', '76779-9491', 'Ivory Satterfield V', '929 Buford Lock Apt. 658\nLittelville, IN 84115', '2217 Sim Mission Suite 052\nSouth Timmyburgh, ME 06996-6792', 'East Jaunita', 'stad', '54150-4790', 'Shanna', 'Schaefer', '9034 Itzel Via\nKirstinfort, ND 46664-6133', 'Boganview', 'town', '93796-8017', 1, 1, 0, 1, 25, 1, 0, '2016-11-18', '2016-11-18 07:13:02'),
(25, 1, 'pending', '158 Torphy Cliffs Suite 983\nLake Tiarafurt, FL 38241', 'Paris', 'West', 'Ledner', '9166 Sofia SpigsEmauellad, VT 22434', 'Camilleport', 'ton', '77064', 'Chyna', 'Stracke', 'Daugherty', '665 Nader Greens\nNew Murrayton, AK 83094', 'North Bettye', 'mouth', '55683-7371', 'Clovis Keeling', '467 Edwina Bypass Apt. 241\nMacejkovicborough, IL 13308', '17686 Mraz Gardens Apt. 083\nPort Bobbie, NV 24128-3629', 'Howeside', 'land', '88744-9694', 'Noemie', 'Wiegand', '5048 Simonis Valley Apt. 782\nSchimmeltown, NH 32919-2744', 'Justiceton', 'bury', '67027-8465', 1, 1, 0, 1, 41, 1, 0, '2016-11-18', '2016-11-18 07:13:02'),
(26, 1, 'pending', '475 Uriah Pike Suite 498\nKundemouth, WI 31898-6062', 'Taylor', 'Huels', 'Cassin', '270 Peta SpigsOdickaboough, OR 22692-6449', 'East Marlin', 'mouth', '43643-3486', 'Edmond', 'Bartell', 'Witting', '3400 Raoul Gardens Apt. 444\nVeummouth, KY 44764-5468', 'East Donnyhaven', 'view', '51025', 'Mr. Cecil Barton', '49366 Rosa Forges Apt. 037\nMohrview, MS 92453-8046', '3011 Allan Square\nPfefferburgh, MI 70612', 'Ikeside', 'furt', '80211-4200', 'Jayda', 'Lang', '973 Aimee Mission\nLake Dallin, SD 38063-9393', 'Pinkshire', 'port', '36389', 1, 0, 0, 1, 20, 1, 0, '2016-11-18', '2016-11-18 07:13:03'),
(27, 2, 'pending', '6269 Sophia Rapid Apt. 592\nNicolasfort, MS 60152', 'Adan', 'Pagac', 'Witting', '252 Ilee WalksYostville, HI 52057-5422', 'North Macimouth', 'berg', '03683-2763', 'Uriah', 'Bernier', 'Predovic', '479 Shanie Crossing\nPollichborough, ID 62700-0843', 'South Alysha', 'ton', '43128-2083', 'Tracey Doyle', '99242 Schroeder Stream\nLake Kurtisside, DC 09634', '33710 Beatty Village\nNew Jeramychester, ND 55051-4016', 'Donnellyshire', 'burgh', '91635', 'Korey', 'Hyatt', '6530 Sanford Route Suite 542\nBergnaumshire, WI 72378-6605', 'McLaughlinburgh', 'furt', '35220-9427', 0, 1, 0, 1, 49, 1, 0, '2016-11-18', '2016-11-18 07:13:03'),
(28, 3, 'pending', '64308 Mossie Viaduct Apt. 729\nNew Jocelyn, MN 44616', 'Jimmie', 'Kutch', 'Wisoky', '1409 Caolye Bug Apt. 202East Sabya, KS 71010-4517', 'North Bobbiehaven', 'port', '37922', 'Gerry', 'Veum', 'Keebler', '2413 Keebler Cliffs\nEast Aurore, CA 60308-9083', 'North Joanashire', 'ton', '67209', 'Dr. Marcelo Rice V', '88161 Yoshiko Mission\nNew Dejahfurt, WA 92582', '311 Haley Valley Apt. 786\nBabychester, NM 56356-5573', 'Jadashire', 'fort', '85207-1191', 'Millie', 'Schoen', '7273 Justina Cape Apt. 368\nNorth Orenport, MT 51355-9494', 'Cassinmouth', 'town', '48671', 1, 0, 0, 1, 47, 1, 0, '2016-11-18', '2016-11-18 07:13:03'),
(29, 3, 'pending', '22596 Darwin Drive Suite 595\nAnthonyton, IL 19070', 'Rita', 'Oberbrunner', 'Jacobi', '8892 Gimes JuctiosRoscoebeg, MS 60539', 'East Kiera', 'furt', '06511', 'Yesenia', 'Parisian', 'Koss', '5299 Botsford Heights Suite 435\nEast Oswald, WI 43676', 'Bulahville', 'port', '92416-9982', 'Johan Towne IV', '4558 Keebler Mall Suite 989\nJaskolskiberg, NC 87970', '776 Moriah Centers Suite 446\nPort Chet, RI 65827', 'Miloside', 'borough', '11501-8040', 'Halle', 'Kris', '8265 Christa Route Apt. 990\nNorth Charlie, FL 16247', 'Manteborough', 'town', '68432-2672', 0, 0, 1, 1, 36, 1, 0, '2016-11-18', '2016-11-18 07:13:03'),
(30, 2, 'pending', '876 Russel Views Suite 321\nSouth Kellie, CA 56273-1010', 'Shayne', 'Kuphal', 'Bednar', '95975 Roscoe UiosKatelytow, OR 51512', 'Terrellbury', 'port', '28473-4230', 'Addison', 'Purdy', 'Abbott', '4346 Antonia Walks\nNew Lizethmouth, CA 70106-6175', 'Reillyton', 'furt', '38966', 'Ewell Ernser', '89660 Auer Lodge Suite 705\nPort Guyberg, WA 68032', '304 Edwin Row\nChaddton, MO 55709', 'South Ellie', 'bury', '08945-9733', 'Gracie', 'Mann', '955 Doyle Ports\nFrederiquestad, VA 67107-5022', 'West Jerry', 'port', '05192-6619', 1, 0, 0, 1, 49, 1, 0, '2016-11-18', '2016-11-18 07:13:03'),
(31, 1, 'pending', '43858 Vilma Key\nEnolaton, DC 11302', 'Dorthy', 'Thiel', 'Kemmer', '2687 Fiese Moutais Apt. 720South Avillabuy, UT 78195', 'Port Murphy', 'mouth', '41193', 'Bradly', 'Hilll', 'Conroy', '734 Murray Lodge\nNorth Priscillahaven, IN 94199-6884', 'New Andychester', 'furt', '90107-6371', 'Prof. Elnora O''Connell V', '23103 Ziemann Unions\nJulioborough, HI 23607-9181', '9794 Hirthe Well\nPaulineberg, DC 94731', 'West Herman', 'side', '17936', 'Amelia', 'Corkery', '1240 Bernhard Harbor\nRaynormouth, AZ 27278-9344', 'Bergechester', 'mouth', '68627', 0, 1, 0, 1, 3, 1, 0, '2016-11-18', '2016-11-18 07:13:04'),
(32, 3, 'pending', '5377 Cummings Mount Suite 629\nLake Allie, WY 07714', 'Madisyn', 'Kub', 'Adams', '7700 Katly Steam Suite 689New Ledabuy, MA 44005', 'Crawfordville', 'mouth', '48101', 'Retha', 'Hilpert', 'Bechtelar', '25900 Pouros Point Suite 546\nNew Sid, NM 34751-9314', 'West Brandon', 'mouth', '56533', 'Kayla Klocko', '58122 Alanna Springs\nNorth Clayfurt, OR 31185-1055', '8487 Keely Drive Suite 826\nDerickview, AL 33396-3014', 'West Sandyborough', 'shire', '50106', 'Lester', 'Zboncak', '720 Nikko Island\nNorth Aprilview, MD 51841-2520', 'Port Tyriquestad', 'bury', '26972', 1, 1, 1, 1, 16, 1, 0, '2016-11-18', '2016-11-18 07:13:04'),
(33, 1, 'pending', '651 Streich Circles Suite 182\nLake Arturo, VT 53509-7000', 'Emilia', 'Fadel', 'Graham', '5715 Kude StaveueNoth Moises, NV 81124', 'Haylieville', 'chester', '57760-4193', 'Idell', 'Davis', 'Okuneva', '2643 Dietrich Lane\nEast Janeborough, TX 81270', 'Franeckimouth', 'haven', '28169-5948', 'Abe Mitchell Jr.', '82434 Rickie Corners Suite 998\nO''Connellfort, WI 52803', '91041 Viva Camp Suite 331\nPort Kenyon, AZ 34062', 'New Athena', 'furt', '02882', 'Emmet', 'Ondricka', '78776 Asha Vista Suite 157\nWehnermouth, MT 71410-1893', 'Lake Lucilehaven', 'mouth', '72394', 1, 0, 0, 1, 39, 1, 0, '2016-11-18', '2016-11-18 07:13:04'),
(34, 2, 'pending', '23695 Kayley Drive\nWiegandside, NM 21955', 'Vern', 'Ullrich', 'Moore', '247 Koelpi SpigsEast Kia, CO 10138', 'West Mandyborough', 'ville', '38206-9267', 'Allen', 'Stehr', 'Hagenes', '470 Casimir Valleys\nSouth Katrina, CA 93433-1265', 'East Cleohaven', 'haven', '63008', 'Adell King', '3290 Klein Ramp\nLake Dallin, ND 03511', '70234 Jeanette Rapid\nPort Jarrell, MD 09073-4736', 'Duaneside', 'bury', '35811', 'Lyric', 'Kerluke', '18956 Beier Track\nSouth Brannon, NV 96056', 'Malcolmville', 'port', '98255', 1, 0, 1, 1, 27, 1, 0, '2016-11-18', '2016-11-18 07:13:04'),
(35, 3, 'pending', '84438 Ruthe Mews Apt. 270\nNew Camille, KY 95491-2911', 'Fannie', 'Jacobson', 'Kohler', '266 Rolfso FieldNoth Abdieltow, NH 74033', 'Ortizstad', 'haven', '37684-3058', 'Emily', 'Crooks', 'Parker', '1511 Witting Inlet\nWest Moriah, OK 50303', 'Terenceland', 'side', '13375-1271', 'Dr. Omer Dooley PhD', '20304 Lang Walks\nWinifredstad, MD 72137-1734', '1528 Littel Crossing Suite 347\nLake Jarrett, MN 21161', 'South Kennaview', 'view', '21012', 'Eugenia', 'Ratke', '1974 Annie Burg\nPort John, ID 22719-6710', 'North Berneice', 'bury', '52675', 1, 0, 1, 1, 19, 1, 0, '2016-11-18', '2016-11-18 07:13:05'),
(36, 3, 'pending', '92749 Brandyn Extension Suite 938\nEast Jazmin, IN 92882-1830', 'Arvel', 'Donnelly', 'Schroeder', '79677 Gage StaveueSouth Hobatfot, WV 01730', 'Nelsonshire', 'view', '04528', 'Arnulfo', 'Powlowski', 'Crona', '207 Borer Haven\nSouth Jamelberg, NC 71294', 'New Elvera', 'stad', '50433', 'Daniela Kautzer', '1764 Bernier Falls\nSouth Bobby, RI 11915', '46463 Emmanuel Crescent\nNew Maxland, WY 87654-4897', 'West Delmer', 'furt', '03738', 'Elmira', 'Ullrich', '956 Bayer Points\nAlanisside, WI 52083-5254', 'Sporerstad', 'haven', '74109-2771', 1, 1, 1, 1, 40, 1, 0, '2016-11-18', '2016-11-18 07:13:05'),
(37, 3, 'pending', '55631 Roman Center\nArichester, CO 20142', 'Landen', 'Weber', 'Balistreri', '17087 Delfia VistaWest Oie, CO 11020', 'Burniceburgh', 'view', '07019', 'Antonina', 'Bins', 'Kuphal', '75611 Michael Burg Suite 544\nSelinamouth, KS 70150-9851', 'Crooksfort', 'ville', '62635-4796', 'Brody Parisian', '63165 Velva Unions Apt. 242\nSouth Hershel, AK 38652', '830 Armand Run\nLake Stephania, TX 53040-3298', 'Rickeybury', 'mouth', '03208', 'Maximillian', 'Schultz', '33328 Howard Freeway Suite 252\nWest Clemmieborough, OR 05439-8218', 'New Jayce', 'mouth', '63251-4225', 0, 1, 0, 1, 20, 1, 0, '2016-11-18', '2016-11-18 07:13:05'),
(38, 2, 'pending', '3375 Krajcik Mount\nEast Mosheland, MA 18678-7466', 'Ottis', 'Brekke', 'Wiegand', '125 Kiea Causeway Apt. 576McLaughliboough, MN 71883', 'Bellehaven', 'haven', '03143', 'Kristofer', 'Goyette', 'Deckow', '653 Josie Drives Suite 517\nLuisaport, MT 75092', 'South Shany', 'haven', '62185-5054', 'Amalia Cormier', '9832 Tessie Springs\nJaceyport, MI 96040-7219', '1167 Ullrich Harbors Suite 086\nEast Brantville, OK 69053-0825', 'North Arielland', 'side', '55635', 'Rashad', 'Schaefer', '30548 Eldred Pike Apt. 774\nNorth Osbaldo, PA 29013', 'North Sheilaport', 'mouth', '84851', 0, 0, 1, 1, 36, 1, 0, '2016-11-18', '2016-11-18 07:13:06'),
(39, 1, 'pending', '59735 Christina Views Suite 406\nSimonisview, NE 67047', 'Zachariah', 'Hartmann', 'Pouros', '73868 Schulist TaceMitchellfot, AZ 13619-3656', 'Amyaton', 'haven', '53178', 'Brionna', 'Toy', 'Robel', '126 Cartwright Unions Apt. 763\nGerrytown, NC 71350-9159', 'North Omerhaven', 'chester', '62688', 'Mr. Houston Lowe DDS', '5773 Gulgowski Roads\nNorth Jess, LA 55914-5560', '8750 Leffler Harbors Apt. 821\nPort Katarinamouth, WV 44762-8243', 'Letitiahaven', 'borough', '43503-3795', 'Velma', 'Weimann', '31912 Liza Harbors\nEast Hillary, IA 99528-5992', 'Agneschester', 'ton', '49545', 1, 1, 0, 1, 42, 1, 0, '2016-11-18', '2016-11-18 07:13:06'),
(40, 3, 'pending', '589 Harvey Vista\nDenesikland, ND 73466', 'Eliza', 'Kohler', 'Auer', '11692 Wucket Gle Suite 801Pot Celia, IL 80394', 'Blickport', 'bury', '18493-1827', 'Aurelie', 'Hudson', 'Bradtke', '820 Rachelle Islands Suite 015\nEmmiemouth, KS 78548', 'Lake Luciusfurt', 'land', '65356', 'Prof. Lilla Goodwin', '21246 Zemlak Ville\nCarmelatown, VT 65528-3626', '435 Walker Shores\nLyricmouth, AZ 15208', 'Rempelmouth', 'shire', '53420-7286', 'Houston', 'Williamson', '3025 Ritchie Circle Suite 689\nWest Julietshire, AR 72799', 'South Lillaborough', 'view', '00032', 0, 1, 1, 1, 28, 1, 0, '2016-11-18', '2016-11-18 07:13:06'),
(41, 2, 'pending', '900 Kennith Fort\nPort Justynborough, VT 23670', 'Haylee', 'Wisozk', 'Ferry', '10324 Gutma Mout Suite 715Johstofot, NE 58286', 'North Magdalenfort', 'ville', '54490', 'Chelsea', 'Johnston', 'Bergstrom', '47751 Ratke Prairie Suite 018\nNorth Keyshawn, AK 65426-8964', 'Lake Davion', 'town', '73990', 'Clarabelle Gusikowski I', '15962 Rey Turnpike Apt. 095\nRosenbaumstad, MA 81325-5792', '610 Waters Turnpike\nPort Jaylin, MA 03931', 'New Johnny', 'side', '27481', 'Edyth', 'Hammes', '9572 Howell Forks\nEast Aniyah, NH 38117-4433', 'Port Rodrigohaven', 'chester', '81436-3745', 0, 0, 0, 1, 32, 1, 0, '2016-11-18', '2016-11-18 07:13:06'),
(42, 3, 'pending', '994 Cordie Manor\nNorth Theresa, DE 72611', 'Margie', 'Schmeler', 'Raynor', '4683 Elisabeth Path Suite 099Nolaville, OR 89239', 'Lake Marquise', 'bury', '56692-3902', 'Cecelia', 'Gorczany', 'Ruecker', '73932 Corkery Mills Suite 338\nMadalynshire, OK 28791-9601', 'Briaview', 'fort', '31726-7817', 'Dr. Roscoe Runolfsdottir DVM', '108 Hellen Club Apt. 416\nNorth Maryamfort, MI 57206', '382 Hahn Row Suite 553\nNew Jeanville, OR 81200', 'Port Damaris', 'furt', '78508-0811', 'Tressie', 'Lubowitz', '755 Crona Wells\nWiegandburgh, KY 07109-7571', 'Jacktown', 'view', '81522', 0, 0, 1, 1, 3, 1, 0, '2016-11-18', '2016-11-18 07:13:06'),
(43, 1, 'pending', '366 Laurie Common\nWisokyburgh, AL 99842', 'Tevin', 'Cole', 'Mann', '99001 Kali Ceek Suite 941Coipot, CA 47239', 'Douglasland', 'side', '18307-3621', 'Eino', 'Goldner', 'Keebler', '232 Kay Ville\nAliciafurt, WA 35665', 'North Danielle', 'ton', '44899', 'Jennie Eichmann', '115 Breitenberg Roads Suite 317\nCreminport, DE 42067', '188 Harmon Pines Apt. 022\nMaxiehaven, IL 93056', 'Elishafurt', 'borough', '38688', 'Myrl', 'Stamm', '7177 Saige Tunnel Apt. 829\nSouth Kaileestad, MN 19168-5695', 'Estebanland', 'burgh', '64506', 0, 1, 0, 1, 21, 1, 0, '2016-11-18', '2016-11-18 07:13:07'),
(44, 3, 'pending', '67019 Felicita Pines\nLake Leonortown, AZ 82801', 'Ernesto', 'Rau', 'Hermiston', '9334 Tey Cliffs Apt. 246Gusikowskiview, AR 66703-6385', 'West Rhiannaland', 'land', '00025-4844', 'Reymundo', 'Braun', 'Larkin', '881 Hayes Vista\nWest Deanbury, VA 36141-6578', 'Raynormouth', 'mouth', '30827-2573', 'Jordane Kovacek', '2091 Ritchie Turnpike Apt. 743\nLake Johannashire, CA 89388', '41618 Weber Stream Apt. 451\nJakobhaven, ID 00466', 'Bartellland', 'bury', '30008', 'Cleta', 'Okuneva', '135 Robel Harbor\nLangworthview, AK 05741-6184', 'North Jonchester', 'shire', '43814', 1, 1, 1, 1, 31, 1, 0, '2016-11-18', '2016-11-18 07:13:07'),
(45, 3, 'pending', '280 Isaias Avenue\nNew Jairoville, NH 24805', 'Esmeralda', 'Toy', 'Ruecker', '681 Buckidge FeyLailaview, CO 13888', 'Aureliastad', 'shire', '61468', 'Sarai', 'Marvin', 'Roob', '410 Bins Islands Apt. 629\nAurelioborough, NC 74455-4079', 'Franeckifurt', 'town', '79094', 'Ms. Evie Goldner', '3718 Windler Key\nWest Israel, MD 89917-5668', '5035 Rippin Vista Apt. 138\nSouth Elmore, DE 09523', 'Port Reaganburgh', 'mouth', '27571-8980', 'Alysa', 'Hegmann', '1186 Doyle Garden\nWest Martachester, SC 33739', 'Vandervortstad', 'furt', '57354', 1, 1, 1, 1, 15, 1, 0, '2016-11-18', '2016-11-18 07:13:07'),
(46, 3, 'pending', '1736 Sawayn Plains\nSouth Gianniberg, HI 27161', 'Ezekiel', 'Bailey', 'Runolfsdottir', '9782 Catwight Juctio Apt. 230Waelchibeg, PA 02679', 'Erichville', 'stad', '07673-9766', 'Minerva', 'Von', 'Jacobs', '36687 Coy Islands Apt. 953\nLeannonstad, HI 83787', 'New Linnie', 'view', '79082-0872', 'Alycia Witting', '573 Kiehn Views Suite 665\nLake Ernestburgh, SD 02846-1609', '41733 Terry Brook\nBayerfurt, UT 09188-7269', 'North Augusta', 'haven', '26901', 'Hillard', 'Bruen', '483 Pollich Harbors Suite 449\nPort Pascale, ND 28287-7470', 'West Clemmiebury', 'town', '56465-6655', 0, 0, 1, 1, 38, 1, 0, '2016-11-18', '2016-11-18 07:13:07'),
(47, 1, 'pending', '357 Woodrow Mall Suite 701\nDesmondville, AL 96024-1185', 'Macie', 'Ferry', 'Huel', '686 Wade CossigBayetow, UT 03815', 'New Charity', 'ton', '55294-7761', 'Brisa', 'Gulgowski', 'Rippin', '774 Novella Squares\nGutmannstad, WY 76522', 'Fisherland', 'chester', '61467-3530', 'Mr. Tremaine Reynolds III', '158 Huel Passage\nLindborough, VT 82008', '94152 Will Fords Apt. 725\nSouth Myrticeside, VT 58439-1369', 'North Arianna', 'ton', '97251', 'Edmund', 'Roberts', '8312 Dooley Glens\nBrekkemouth, OK 56346-1976', 'Williamsonstad', 'berg', '78731-6496', 1, 0, 0, 1, 46, 1, 0, '2016-11-18', '2016-11-18 07:13:08'),
(48, 1, 'pending', '9787 Gerhold Highway Apt. 041\nNew Derrick, UT 09743', 'Cierra', 'Hirthe', 'Ritchie', '91102 Collis Cossig Suite 199Hoegebeg, OK 28155', 'Terrychester', 'chester', '62371', 'Carson', 'Lowe', 'Pouros', '87559 Strosin Heights\nEast Celestinoberg, AZ 40576-6936', 'West Wainoborough', 'land', '93145', 'Tracy Harber DDS', '514 O''Keefe Brook\nSouth Nicole, SD 73631-7585', '91273 Hartmann Extension\nEast Skylarshire, TX 46499', 'Mooreton', 'chester', '24256-3807', 'Tod', 'Hudson', '35599 Hilma Cape\nSouth Augustineport, LA 20182', 'Zemlakton', 'ville', '58593-7593', 1, 0, 0, 1, 49, 1, 0, '2016-11-18', '2016-11-18 07:13:08'),
(49, 3, 'pending', '21957 Reagan Hill\nKemmerberg, SC 25317-9315', 'Hildegard', 'Kassulke', 'Schoen', '29820 Tisha FoksLake Willafot, CA 93257', 'Floyland', 'haven', '48684-8991', 'Felicity', 'Goodwin', 'Lynch', '102 Percival Lodge\nHeathcoteberg, NJ 81490', 'Susannafort', 'burgh', '30077', 'Hortense Yost', '6444 Mateo Alley\nMcLaughlinhaven, WI 64168-8400', '876 Hartmann Street\nSouth Libbiechester, MI 62559', 'Port Austin', 'haven', '44545-9198', 'Muriel', 'Reilly', '9114 Reilly Forks\nLorineburgh, MD 69397', 'South Kennyberg', 'port', '32609-8055', 0, 1, 0, 1, 49, 1, 0, '2016-11-18', '2016-11-18 07:13:08'),
(50, 1, 'pending', '5448 Billy Ramp\nSavannahburgh, SD 28763-4689', 'Marta', 'Gaylord', 'Parker', '84172 Ese Juctios Apt. 242New Mya, ID 15666', 'New Nehafort', 'berg', '99102', 'Fleta', 'Fadel', 'Fritsch', '788 Berenice Loop Apt. 173\nJudychester, KS 20450-2120', 'Lake Alexaport', 'borough', '42479-3509', 'Brandi Breitenberg', '472 Prudence Branch\nNew Jodyport, CT 67357-5829', '715 Liana Valley Apt. 962\nDenesikmouth, MN 98926-3742', 'New Mac', 'haven', '49698', 'Anissa', 'Little', '69520 Jena Flat Suite 700\nLake Elroyburgh, SD 05572-7733', 'Veumfort', 'view', '96487', 0, 1, 1, 1, 49, 1, 0, '2016-11-18', '2016-11-18 07:13:08'),
(51, 3, 'pending', '57096 Eugene Passage Apt. 316\nSouth Allie, IN 97384-3491', 'Annabel', 'Bailey', 'Kiehn', '352 Deote LocksLake Lucas, MT 20412-7300', 'West Polly', 'borough', '05686-0955', 'Immanuel', 'Jacobs', 'Hamill', '916 Hoyt Prairie\nEast Hattie, ID 21500-2872', 'South Karashire', 'stad', '97389', 'Paris Feil', '4756 Wolf Ports Apt. 481\nCassandreville, NC 08508-2720', '934 Faustino Course\nRozellabury, DE 87076-4991', 'North Ahmad', 'fort', '42390', 'Candido', 'Baumbach', '3773 Rice Corner\nPort Quinten, IN 29210-5605', 'Lubowitzberg', 'ton', '89032-6423', 0, 0, 1, 1, 1, 1, 0, '2016-11-18', '2016-11-18 07:13:09'),
(52, 1, 'pending', '5061 Runolfsson Vista Suite 686\nNew Johan, WI 66507-1774', 'Santino', 'Sawayn', 'Runolfsdottir', '8022 Kale LadEast Domeica, ME 97433', 'Theodoreside', 'stad', '86502-1367', 'Kari', 'Kunde', 'Harris', '5362 Remington Falls\nLeannachester, CT 95396', 'Port Zoeybury', 'view', '28871-1859', 'Christophe Botsford', '3204 Hosea Land\nVernieland, NH 91011-8924', '703 Kozey Fords\nRohanmouth, ME 18734-7484', 'Mitchellchester', 'berg', '32221-6273', 'Rosalinda', 'Koss', '686 Layne Green Suite 250\nCorbinshire, OK 62799-4330', 'Brionnaberg', 'side', '29403-2557', 0, 0, 0, 1, 25, 1, 0, '2016-11-18', '2016-11-18 07:13:09'),
(53, 1, 'pending', '346 Kassulke Shores\nHettingerfurt, UT 70863-9804', 'Ramona', 'Monahan', 'Douglas', '506 Batell DiveEast Kiea, VT 73980-2098', 'South Julien', 'ville', '33258-2630', 'Griffin', 'Douglas', 'Kreiger', '15388 Furman Passage Suite 988\nKiannahaven, MS 91420-7492', 'Runolfsdottirton', 'chester', '60669', 'Alva Metz', '9939 Schmidt Lock\nKuvalisborough, NE 78030', '6094 Schumm Row Apt. 595\nMalindaside, MN 83092-0254', 'North Kelsie', 'land', '73568-2837', 'Buford', 'Lemke', '3337 Lennie Gardens\nDorcasstad, WV 81518', 'New Adelbert', 'berg', '62283-7444', 1, 0, 0, 1, 32, 1, 0, '2016-11-18', '2016-11-18 07:13:09'),
(54, 2, 'pending', '76493 Boyer Crest Apt. 254\nEvanshaven, MO 87245-4792', 'Santino', 'Hirthe', 'Nolan', '7962 Abeathy Squaes Apt. 828South Faeville, KY 57138', 'Lake Gerard', 'side', '99260-6928', 'Cullen', 'Padberg', 'Kuvalis', '5949 Nikolaus Track Suite 874\nWest Diegoberg, WA 32656', 'Jamarcusbury', 'land', '83271-7945', 'Dr. Laurel Gibson III', '69106 Braden Loaf Apt. 681\nReingerland, ID 66626-0389', '970 Watsica Flats Suite 918\nWest Shakiramouth, IL 15392', 'Jastport', 'mouth', '42101', 'Leanna', 'O''Hara', '6841 Fausto Fields Suite 911\nNorth Kariane, KY 04505-1144', 'North Lolita', 'ton', '30206', 0, 0, 1, 1, 27, 1, 0, '2016-11-18', '2016-11-18 07:13:10'),
(55, 2, 'pending', '497 Deven Prairie Suite 550\nLake Alejandrintown, ND 18111-6940', 'Godfrey', 'Kutch', 'Blanda', '4205 Gulgowski Cossoad Suite 320Bioastad, PA 87160', 'Lynchburgh', 'chester', '31989-5217', 'Jefferey', 'Walker', 'Powlowski', '39710 Rolfson Tunnel\nCarminetown, UT 61788-9020', 'East Kameron', 'shire', '80611', 'Katarina Bruen', '299 Hettinger Extensions\nLake Chesley, MS 83080', '23728 Talia Hills\nDaphneyshire, NV 55027', 'Kilbackland', 'ville', '40734-6508', 'Randy', 'Durgan', '80572 Schulist Inlet\nEast Julio, LA 49162-2957', 'North Ubaldo', 'fort', '19560', 1, 0, 0, 1, 19, 1, 0, '2016-11-18', '2016-11-18 07:13:10'),
(56, 3, 'pending', '338 Euna Tunnel Apt. 370\nNorth Fredberg, WI 76011-3971', 'Jaclyn', 'Glover', 'Dibbert', '519 Velie TuelAbdullahside, TN 88182', 'Kianmouth', 'view', '76415-6593', 'Ernestine', 'Gusikowski', 'Veum', '95545 Barbara Gardens\nEast Lethamouth, GA 63453', 'West Randihaven', 'mouth', '56297', 'Eva Metz', '25549 Coty Summit Apt. 473\nMaryamview, NE 91768', '56091 Gladys Hill\nBoscoville, NC 86275', 'Shanahanchester', 'mouth', '56662', 'Cordia', 'Yundt', '2410 Ortiz Rapids Suite 697\nLangton, MI 32889-8702', 'South Lucy', 'bury', '33663', 1, 0, 0, 1, 43, 1, 0, '2016-11-18', '2016-11-18 07:13:10'),
(57, 1, 'pending', '8813 Ondricka Village\nJeffereybury, AK 35487-6476', 'Olen', 'Rice', 'Borer', '952 Heta SteamAidamouth, MS 69238-3286', 'Lake Vaughnside', 'town', '44970-3968', 'Taryn', 'Casper', 'Stamm', '8777 Mante Heights\nNorth Jazmin, CT 26089-6051', 'Smithhaven', 'stad', '78127-0172', 'Fae Ortiz', '9125 Marilie Summit Suite 397\nNew Anibal, VA 03729', '528 Terrill Squares Suite 686\nEast Howellport, NJ 68434-5932', 'West Phyllis', 'town', '66897-0214', 'Frederik', 'Padberg', '96217 Lyla Flats Suite 276\nRueckerside, TN 21905', 'Christianland', 'burgh', '89561-9147', 0, 1, 1, 1, 43, 1, 0, '2016-11-18', '2016-11-18 07:13:10'),
(58, 1, 'pending', '49776 Witting Cove Apt. 850\nLakinfurt, FL 48338', 'Dasia', 'Okuneva', 'Predovic', '31910 Howe Shoes Suite 510Lake Nicolasside, IL 16759-9134', 'Macejkovictown', 'fort', '34979', 'Tamara', 'Strosin', 'Daniel', '79854 Boehm Islands\nWolfshire, NC 60415-9300', 'Fritztown', 'shire', '66090-1932', 'Dr. Ryder Koepp', '7186 Wunsch Green\nAlton, AL 30388-9365', '4332 Reichel Avenue Apt. 487\nWest Shemar, WY 58961-9150', 'Jasenborough', 'stad', '82984-4973', 'Buford', 'Dare', '18774 Reinger Divide Apt. 115\nPort Biankatown, WV 48437', 'Dawnville', 'town', '50508', 0, 0, 0, 1, 27, 1, 0, '2016-11-18', '2016-11-18 07:13:11'),
(59, 3, 'pending', '27080 Orpha Ports Suite 567\nStephanburgh, PA 96969-8329', 'Janessa', 'Boyle', 'Cremin', '529 Badtke FallEdmacheste, SC 20340-9092', 'Lake Velmaborough', 'stad', '94036', 'Arvel', 'Nienow', 'Emmerich', '1194 King Spring\nThompsonville, AL 51488', 'Howeshire', 'port', '00449', 'Mr. Hazle Ernser', '4935 Khalid Views Apt. 982\nRathfurt, NV 10054', '3703 Esteban Village Suite 797\nHayleyland, NY 78902', 'Lake Avisstad', 'side', '00435-4378', 'Emerson', 'Wintheiser', '14666 Jayden Light\nWeissnatshire, NJ 66378-3747', 'Batzshire', 'ville', '58376', 1, 0, 0, 1, 26, 1, 0, '2016-11-18', '2016-11-18 07:13:11'),
(60, 3, 'pending', '7731 Rolfson Station\nLake Salvatorechester, NC 59859-4143', 'Camylle', 'Waters', 'Jones', '777 Julie TupikePot Ciceo, NM 81443', 'Kingstad', 'furt', '89868-7517', 'Tania', 'Beer', 'Grimes', '608 Mann Springs\nHicklefort, WY 88448', 'West Alfordhaven', 'haven', '49349-6350', 'Sheldon Nader', '15815 Verna Grove Suite 303\nNew Zelmatown, MT 80335-9974', '55423 Teresa Causeway Apt. 318\nEast Coralie, MN 97049', 'Opalhaven', 'furt', '81178', 'Jamel', 'Bogan', '652 Bashirian Ways\nPort Maidaland, IN 53539-3182', 'Antonioside', 'mouth', '78863', 0, 1, 1, 1, 35, 1, 0, '2016-11-18', '2016-11-18 07:13:11'),
(61, 2, 'pending', '19824 Wunsch Loaf\nEast Sidneybury, WV 91461', 'Agnes', 'Rosenbaum', 'Tremblay', '34830 Skye Bugs Apt. 748West Rafaela, DC 69927-6749', 'South Jodyfurt', 'fort', '44658', 'Ahmed', 'Ratke', 'Larson', '403 Mason Freeway\nNew Stephaniafurt, HI 21447-0254', 'Wymanchester', 'bury', '92240', 'Ursula Yundt', '86688 Lewis Center Suite 806\nWest Athena, AZ 43013-0290', '352 O''Keefe Well\nWest Jesse, AZ 49344', 'West Milfordfurt', 'ville', '95651-5025', 'Amari', 'Hayes', '3261 Jennie Stream Suite 387\nEast Sincere, LA 30857-3697', 'Kayleeview', 'land', '51362', 0, 1, 1, 1, 15, 1, 0, '2016-11-18', '2016-11-18 07:13:11'),
(62, 3, 'pending', '58086 Cormier Orchard\nSheilafurt, KY 81416', 'Josue', 'Crooks', 'Jerde', '5250 Skiles CescetRowetow, KY 10471', 'North Hollie', 'haven', '87293', 'Chanelle', 'Gusikowski', 'Orn', '2328 Wuckert Court Suite 593\nWest Bobbyview, OR 65783-1874', 'West Damarismouth', 'stad', '89917-4938', 'Mr. Cameron Waelchi', '5018 Pedro Lake\nPort Izabella, MA 62403-1988', '1747 Quitzon Radial\nO''Keefeland, SD 38454', 'Rogahnmouth', 'chester', '67815', 'Freddie', 'Nikolaus', '1688 Kovacek Causeway\nPort Travonmouth, OH 18356', 'Clementinafort', 'furt', '44111-3900', 1, 0, 0, 1, 36, 1, 0, '2016-11-18', '2016-11-18 07:13:12'),
(63, 2, 'pending', '3158 Jacobs Port Suite 915\nEast Audie, DE 04471', 'Celestine', 'Steuber', 'Feest', '1596 Loyce Dive Apt. 844Noth Ayla, OH 18457', 'Port Robin', 'haven', '49271-3752', 'Kenny', 'Kuvalis', 'Renner', '7937 Hahn Locks Suite 875\nSkileschester, RI 92953-6710', 'Port Elyssafort', 'borough', '93613-9079', 'Melissa Hudson', '30573 Klein Manor Suite 559\nWeissnatstad, NJ 58195-8805', '7388 Beatty Cape Apt. 039\nWalterburgh, CO 24306-8190', 'South Erick', 'haven', '21452', 'Terrell', 'Swift', '6326 Violette Corner Apt. 021\nLake Ibrahimmouth, KY 56052-6966', 'North Dariana', 'mouth', '43960', 0, 1, 0, 1, 5, 1, 0, '2016-11-18', '2016-11-18 07:13:12'),
(64, 1, 'pending', '8908 Beier Walk\nStoltenbergtown, HI 04346', 'Kyler', 'Hermann', 'Goyette', '6683 Helme Tupike Apt. 501Lake Betomouth, DC 15772-6337', 'East Juanaburgh', 'borough', '86110-3462', 'Herbert', 'Windler', 'Von', '5338 Feil Pine\nNorth Oceanefurt, AK 64641-3803', 'East Sydniechester', 'haven', '88531', 'Maxie Marquardt', '43673 Felicita Course Apt. 260\nDickistad, NC 71767', '9920 Janae Ranch\nBriatown, RI 69157', 'Kozeychester', 'bury', '49321-9649', 'Jackie', 'Schaefer', '86244 Garrison Haven Suite 048\nEast Jared, VT 39074', 'West Ameliehaven', 'ville', '06748', 1, 1, 1, 1, 2, 1, 0, '2016-11-18', '2016-11-18 07:13:12'),
(65, 3, 'pending', '581 Kovacek Shore Suite 054\nMaxieland, OH 36157-2511', 'Marquis', 'O''Keefe', 'Durgan', '789 Deesik JuctiosEast Doie, CT 99577-7043', 'Schaeferchester', 'town', '74802', 'Sabina', 'Buckridge', 'Macejkovic', '2525 Toy Branch\nSouth Aylaburgh, MI 25984', 'East Virginia', 'stad', '17751-9952', 'Dortha Kling PhD', '73759 Jayme Roads\nSchillerville, MO 32002-7130', '682 Mann Circle Suite 460\nEast Shana, MT 49383-9476', 'Port Ottostad', 'furt', '68470-9731', 'Abbigail', 'Abshire', '6010 Stanton Walk Apt. 236\nCruickshankchester, TX 52362', 'Hagenesberg', 'side', '87332', 0, 0, 1, 1, 26, 1, 0, '2016-11-18', '2016-11-18 07:13:13'),
(66, 3, 'pending', '9632 Runolfsson Crest\nNew Crawford, IN 04931', 'Emmett', 'Predovic', 'Swaniawski', '90608 Costace CliffsPot Stepha, NC 10936', 'Braunbury', 'furt', '86126-3085', 'Monica', 'Herman', 'Herzog', '185 Marian Station Suite 179\nJordanhaven, ID 07115', 'New Trycia', 'burgh', '50515-7699', 'Dr. Boris West', '42528 Aufderhar Corners\nRollinberg, SC 67227-7936', '994 Waters Light\nPort Jonathon, OK 58338', 'West Maurine', 'side', '59606-3361', 'Sydni', 'Waters', '924 Powlowski Roads Suite 318\nEast Dale, NV 30023', 'North Sally', 'borough', '79671-3179', 0, 1, 1, 1, 29, 1, 0, '2016-11-18', '2016-11-18 07:13:13'),
(67, 1, 'pending', '235 Judge Pike\nFriesenborough, VA 55262-6570', 'Alexanne', 'Kris', 'Reynolds', '32447 Maya Divide Apt. 850Pot Taylobuy, AK 98651', 'Blandastad', 'shire', '39044-1020', 'Sarah', 'Fadel', 'Hermann', '9849 Walsh Knolls Suite 261\nSouth Vita, IL 66194', 'South Cassandra', 'bury', '47104', 'Esperanza Homenick', '8900 Morgan Flats Suite 268\nLake Corineton, AK 60913', '41626 Schaden Crossing Suite 288\nSouth Abagail, AR 22981', 'East Lucius', 'ville', '55585', 'Onie', 'Huel', '4346 Tatum Mills Apt. 884\nShieldshaven, DE 63121', 'Zellamouth', 'land', '73471', 0, 0, 1, 1, 15, 1, 0, '2016-11-18', '2016-11-18 07:13:13'),
(68, 1, 'pending', '284 Martine Divide\nBorermouth, MT 26698', 'Phoebe', 'Rice', 'King', '6325 Pfaestill Tace Apt. 980New Pasquale, TN 87160-9508', 'East Candidoland', 'burgh', '87732', 'Crystel', 'Spinka', 'Kohler', '84715 Larissa Harbor\nJadeshire, LA 22720-3706', 'Lake Majorburgh', 'side', '75662', 'Mrs. Frieda Hickle Jr.', '933 Sylvan Glen Suite 229\nLake Katarina, SC 54680', '947 Renner Hollow Apt. 296\nPort Rubie, CA 92676-5179', 'Eleazarland', 'stad', '51024-8462', 'Alvah', 'Keeling', '8594 D''Amore Vista Apt. 844\nEast Bertramburgh, SD 73741-1964', 'West Lafayette', 'chester', '39030-5191', 1, 0, 0, 1, 28, 1, 0, '2016-11-18', '2016-11-18 07:13:14'),
(69, 1, 'pending', '25330 Ferry Land Suite 803\nTerrellshire, DE 11407-2815', 'Jameson', 'White', 'Fay', '1177 Edma Shoal Suite 296Reillyto, ME 73493-7265', 'South Elodymouth', 'shire', '95839', 'Erin', 'McKenzie', 'Schoen', '7061 Zelda Club\nWest Maudside, MA 56696-7192', 'West Aleen', 'chester', '14708', 'Prof. Arianna Schuster', '4730 Kris Forge Apt. 566\nLoweberg, ID 62246-4477', '3433 Randal Alley\nCliftonside, RI 79149', 'East Ephraimside', 'stad', '71110-9131', 'Cassidy', 'Denesik', '6363 Barrows Burg Suite 871\nPort Ruthiestad, ME 57135-0194', 'West Darenburgh', 'burgh', '69696-3072', 1, 1, 0, 1, 43, 1, 0, '2016-11-18', '2016-11-18 07:13:14'),
(70, 3, 'pending', '7256 Kuvalis Island\nPort Darrylchester, AK 79592', 'Brandt', 'Hane', 'Hickle', '9987 Tey AlleySouth Roladohave, SD 08685-1532', 'Abbottborough', 'furt', '22140', 'Scot', 'Parisian', 'Kihn', '925 Tess Brooks Suite 510\nSouth Laylastad, AZ 85184', 'Hermanhaven', 'fort', '35040-1317', 'Ryann Franecki MD', '308 Rice Union\nEast Braden, MT 69752-1910', '2209 Terrill Causeway Apt. 986\nRosettaland, NM 64674-6756', 'North Misaelland', 'borough', '96712', 'Jess', 'Bahringer', '72673 Swift Stravenue Suite 114\nNorth Leonorbury, MT 52775', 'Port Katelynnmouth', 'chester', '15645-4531', 0, 0, 0, 1, 44, 1, 0, '2016-11-18', '2016-11-18 07:13:14'),
(71, 3, 'pending', '9702 Megane Greens\nEdenshire, SD 96617-2504', 'Andres', 'Shields', 'Funk', '7723 D''Amoe Tuel Apt. 027East Jaietow, GA 74136', 'North Laurianeview', 'stad', '62169-5125', 'Tod', 'Kutch', 'Wehner', '9926 Gwendolyn Row Suite 822\nWest Tressa, CA 10573-1445', 'Carlottaton', 'bury', '98947-0206', 'Bo Schoen DVM', '6142 Alexis Ports\nShermanchester, ND 34309', '6820 Beier Ways\nOranfort, NY 60952-6046', 'West Arielborough', 'shire', '66826-3103', 'Jeanie', 'Mann', '4630 Lamar Coves\nHintzborough, ME 79173', 'Joanbury', 'view', '73354-8808', 1, 0, 1, 1, 40, 1, 0, '2016-11-18', '2016-11-18 07:13:15'),
(72, 2, 'pending', '37771 Franecki Field\nClaudebury, NC 93514', 'Lafayette', 'Reichel', 'Weissnat', '7026 Imai Rapid Apt. 387South Esteva, IL 87830', 'Maggiostad', 'bury', '10657', 'Newell', 'Bergstrom', 'Schaden', '1083 Talon Stravenue Suite 745\nWestonfort, WI 57751', 'Romainemouth', 'mouth', '04726-9088', 'Abe Hoppe Sr.', '148 Abel Centers\nEast Alisonmouth, NM 81609', '49695 Zboncak Ville Suite 139\nNakiaview, NY 46988', 'North Traceyton', 'ton', '11758-0865', 'Gladyce', 'Runolfsson', '732 Lilyan Ways\nAmelieborough, KY 58358', 'Kirlinborough', 'stad', '07916-4379', 0, 0, 0, 1, 34, 1, 0, '2016-11-18', '2016-11-18 07:13:15'),
(73, 1, 'pending', '241 Jacobson Run Suite 714\nLake Jettie, DC 40864-9727', 'Alexane', 'Friesen', 'Green', '8853 Zetta Bugs Apt. 819Beckepot, WY 54694-7824', 'Damarisstad', 'side', '38031', 'Vernice', 'Schulist', 'Donnelly', '46254 Elsie Overpass\nPort Lexie, HI 25585-4683', 'Wolfstad', 'ville', '41854-7268', 'Dr. Kimberly Brakus V', '86175 Chloe Hills Suite 943\nIsadoremouth, NJ 27055', '47037 Jack Locks\nNorth Corrine, OR 63761', 'New Taya', 'ville', '08378-3580', 'Nella', 'Romaguera', '45696 Mueller Street Suite 277\nSchillerland, LA 89040', 'West Doris', 'mouth', '09717-1050', 1, 0, 0, 1, 49, 1, 0, '2016-11-18', '2016-11-18 07:13:15'),
(74, 2, 'pending', '4496 Nestor Island Apt. 565\nBogisichborough, NE 38414-4705', 'Jazlyn', 'Rogahn', 'Murray', '82045 Lave CescetNoth Electa, MS 95005-6684', 'East Felipe', 'view', '84572', 'Cole', 'Cole', 'Gerlach', '15169 Pearlie Corner Suite 554\nLehnertown, SD 29133-7197', 'Gloverton', 'town', '81162', 'Prof. Demond Cole DDS', '5721 Janice Drive\nNew Gerryburgh, TN 86631', '221 Stark Locks Apt. 359\nHermannburgh, RI 79535-4290', 'Boyleton', 'town', '43841', 'Liza', 'Runolfsdottir', '145 Shirley Path Apt. 315\nNorth Carey, MN 64694-3836', 'West Glennaburgh', 'land', '14155-2069', 0, 0, 0, 1, 22, 1, 0, '2016-11-18', '2016-11-18 07:13:16'),
(75, 1, 'pending', '2755 Breitenberg Port\nRamiroberg, DC 13541', 'Maximilian', 'Herman', 'Schaefer', '87329 Klocko Gees Suite 901New Rollibuy, HI 35885-2580', 'North Maraton', 'fort', '36297-5595', 'Johnpaul', 'Gottlieb', 'Borer', '600 Eula Bridge\nOnafurt, NM 76573-1541', 'New Jesse', 'shire', '59275-1173', 'Esperanza Botsford', '80420 Kerluke Pines Suite 518\nEast Herta, MT 27073', '7677 Purdy Court\nLake Muhammadhaven, KS 63867-9370', 'Lake Jeramymouth', 'stad', '69615', 'Jessika', 'Bosco', '79877 Wiegand Harbors Suite 107\nLake Demarcusview, NC 96777-5051', 'Durganmouth', 'berg', '11695-0062', 0, 0, 0, 1, 6, 1, 0, '2016-11-18', '2016-11-18 07:13:16'),
(76, 3, 'pending', '64033 Buckridge Spring\nNew Jedidiah, WV 03642-0683', 'Vincenza', 'Kovacek', 'Dooley', '3166 Zade Loaf Suite 947New Aastasia, NM 60107', 'Kochmouth', 'side', '24453', 'Audra', 'Huels', 'Emmerich', '35874 Mireya Court\nGenovevastad, DE 40251', 'West Cheyennestad', 'land', '17731', 'Tressa Torp', '39506 Cooper Neck\nPort Stacey, NV 60212-0866', '54618 Connie Curve Suite 011\nWest Chyna, MN 89395', 'Kohlertown', 'berg', '47520', 'Payton', 'Jenkins', '716 Elenora Streets Apt. 105\nSavionland, SC 97520', 'North Annie', 'shire', '57839-3856', 0, 1, 0, 1, 8, 1, 0, '2016-11-18', '2016-11-18 07:13:17'),
(77, 2, 'pending', '993 Renner Port Apt. 846\nEffiehaven, PA 97671-5752', 'Lloyd', 'Brekke', 'McKenzie', '55766 Gutma PassStomaview, MS 45604-6613', 'Kerlukeberg', 'stad', '86290-4602', 'Beaulah', 'Frami', 'Crist', '583 Sidney Corner Suite 852\nChloemouth, ND 58582-9088', 'Lillieview', 'view', '02581', 'Mike Reichert III', '994 McGlynn Ford\nEast Baileemouth, VA 22659-0055', '77898 McCullough Expressway\nLake Tressaton, FL 36434', 'Tommieborough', 'burgh', '01742-5680', 'Hudson', 'Emard', '3753 Russel Manors Apt. 633\nLake Casimerfort, ME 09244', 'Hintzfurt', 'ville', '39520-3996', 0, 1, 1, 1, 30, 1, 0, '2016-11-18', '2016-11-18 07:13:17');
INSERT INTO `property` (`id`, `list_id`, `status`, `funeral_home`, `deceased_first_name`, `deceased_middle_name`, `deceased_last_name`, `deceased_address`, `deceased_city`, `deceased_state`, `deceased_zipcode`, `pr_first_name`, `pr_middle_name`, `pr_last_name`, `pr_address`, `pr_city`, `pr_state`, `pr_zipcode`, `attorney_name`, `attorney_first_address`, `attorney_second_address`, `attorney_city`, `attorney_state`, `attorney_zipcode`, `mail_first_name`, `mail_last_name`, `mail_address`, `mail_city`, `mail_state`, `mail_zipcode`, `start_quarterly_mail`, `elligible_letter_mailings`, `elligible_postcard_mailings`, `company_id`, `created_by`, `active`, `deleted`, `last_update`, `date_created`) VALUES
(78, 3, 'pending', '117 Schroeder Trafficway\nSouth Aleen, WI 44499', 'Sally', 'Hodkiewicz', 'Weber', '474 Mady VistaPaucekside, VA 55584-0573', 'Lake Clairemouth', 'shire', '19056', 'Soledad', 'Christiansen', 'Wilderman', '219 Elfrieda Walk Suite 471\nBeverlyview, MT 88826', 'Port Earnestine', 'shire', '68217-3321', 'Kelton Tromp', '3985 Murphy Alley\nKathrynview, CO 04594', '63828 Nikolaus Circles Apt. 033\nPort Megane, NC 66363-8673', 'Lake Jacklynstad', 'fort', '58975', 'Aron', 'Weimann', '5525 Treutel Common\nWuckertview, HI 78996-9291', 'South Anyaview', 'haven', '38284', 0, 0, 0, 1, 24, 1, 0, '2016-11-18', '2016-11-18 07:13:17'),
(79, 3, 'pending', '61956 Lynch Center Apt. 266\nCloviston, MI 47330-4037', 'Earl', 'Roob', 'Zemlak', '7825 Ryla CoutMckaylapot, WV 72473-2952', 'New Rex', 'port', '98449', 'Easter', 'Torphy', 'Glover', '7320 Treutel Heights\nLake Tremaineview, OR 71210', 'Roobbury', 'stad', '97225', 'Cale Lindgren DVM', '589 Constantin Light Suite 435\nEast Kris, MT 75044', '232 Drake Causeway\nDanielaview, OH 77306', 'Fritschstad', 'mouth', '17782', 'Vern', 'Stark', '20364 Mertz Crescent Apt. 328\nPort Nakiaview, MT 25974-6740', 'Jettiemouth', 'bury', '08602-6536', 1, 1, 1, 1, 28, 1, 0, '2016-11-18', '2016-11-18 07:13:18'),
(80, 1, 'pending', '228 Stehr Lock\nHagenesland, NE 80376', 'Lorenz', 'Rempel', 'Lynch', '38246 Shau CiclesNew Roxaeto, OK 03422', 'Lake Elwyn', 'port', '49590', 'Caterina', 'Considine', 'Huels', '572 Rogahn Street\nEichmannchester, IL 43321-9665', 'Rempelchester', 'view', '74107-4320', 'Coralie Dickinson IV', '40671 Xavier Lodge\nMaybellburgh, NH 03840', '42740 Koepp Way\nReichertmouth, AL 96487', 'Langworthtown', 'berg', '59827-1648', 'Donnie', 'Mertz', '4881 Daniella Prairie Apt. 339\nEast Gaylord, NJ 88672', 'Greenfelderburgh', 'stad', '11533', 1, 0, 1, 1, 32, 1, 0, '2016-11-18', '2016-11-18 07:13:18'),
(81, 3, 'pending', '4491 Johns Estate\nNorth Ceciltown, OK 21700-6941', 'Franz', 'Stoltenberg', 'Rau', '287 Mavi PlaisOlsofot, MN 79118', 'Dickiberg', 'bury', '47591-7210', 'Hattie', 'Krajcik', 'Mosciski', '4011 Jenifer Parkways Suite 452\nNorth Shermanmouth, DE 21971-4232', 'Stanville', 'berg', '29931-2496', 'Mrs. Ericka Carroll', '902 Joelle Junction\nGreenholtview, TX 17442-1541', '9888 O''Hara Lane\nBeckerton, UT 48907-7184', 'South Shyann', 'mouth', '62333', 'Stefanie', 'Schoen', '7601 Laurianne Villages\nNorth Jaylin, IA 67659', 'Howemouth', 'berg', '50465-0868', 1, 1, 1, 1, 25, 1, 0, '2016-11-18', '2016-11-18 07:13:19'),
(82, 1, 'pending', '20027 Mittie Unions Suite 066\nStromanmouth, RI 80658-5589', 'Andres', 'Bins', 'Smith', '54446 Ullich Cescet Suite 282Temblaycheste, RI 55249', 'New Antonia', 'stad', '30794', 'Mackenzie', 'Mertz', 'Berge', '1049 Roger Oval\nBettieport, AR 55761', 'Port Miaville', 'haven', '19395-9692', 'Robyn Borer', '15671 Tony Parks Apt. 324\nDominiquehaven, DC 52703', '3390 Mosciski Mountains Apt. 896\nDickinsonbury, HI 36553-8063', 'Donatotown', 'side', '91233-9964', 'Albertha', 'Miller', '4197 Fred Curve Apt. 746\nAbbottmouth, FL 49945-4780', 'Lake Juvenalmouth', 'mouth', '51977', 1, 1, 1, 1, 42, 1, 0, '2016-11-18', '2016-11-18 07:13:19'),
(83, 1, 'pending', '33798 Smitham Ranch Suite 596\nEast Thorabury, MS 26008-6842', 'Bridget', 'Hettinger', 'Parisian', '31762 Block Estate Apt. 446New Keya, GA 36740', 'North Michellemouth', 'chester', '04965', 'Alia', 'Reinger', 'Zulauf', '77885 Jayce Knolls Suite 940\nBettyebury, WY 00182', 'Kristaport', 'fort', '38785-6140', 'Kathlyn Breitenberg', '77060 Shannon Spur\nNorth Chloe, MD 24302-9233', '483 Batz Knoll\nMarksbury, MN 88899-8095', 'Kayleyside', 'shire', '18572-1165', 'Alice', 'O''Hara', '9699 Bashirian Court\nPort Alyciaside, HI 75664-1588', 'Monahanfurt', 'haven', '59338', 0, 1, 0, 1, 16, 1, 0, '2016-11-18', '2016-11-18 07:13:19'),
(84, 1, 'pending', '2342 Cole Drive\nWest Misaelberg, KY 94843-0642', 'Etha', 'O''Kon', 'Rodriguez', '168 Haiso FlatSouth Isido, OH 75435', 'Port Aubreeside', 'stad', '45890-9696', 'Nannie', 'Jacobs', 'Moen', '9596 Schamberger Valley\nAidenville, CO 89969-2805', 'South Jaquelineshire', 'mouth', '41712', 'Helena Schinner', '99831 Hackett Stream\nClemensborough, AL 58031', '37706 Tremblay Highway Apt. 453\nWest Taramouth, WA 31964', 'New Kathryneville', 'side', '51043', 'Brisa', 'Ferry', '8124 Else Fort\nEast Keegan, OH 84611-8393', 'Eichmannton', 'burgh', '13236-0689', 1, 1, 1, 1, 47, 1, 0, '2016-11-18', '2016-11-18 07:13:20'),
(85, 2, 'pending', '10922 Lincoln Cliff Apt. 152\nReynoldston, LA 82528-4820', 'Payton', 'Nicolas', 'Abshire', '5028 Ashly RoadSouth Coalie, CA 61979-0281', 'O''Connellmouth', 'haven', '98630-4253', 'Claud', 'Cartwright', 'Konopelski', '881 Zakary Overpass\nPort Ceasarmouth, LA 13270-5278', 'New Anastasia', 'land', '83022-8369', 'Prof. Adah Harvey II', '3680 Lynch Orchard\nWest Susana, OR 69227-5881', '7379 Terry Field Apt. 651\nSouth Loren, KY 79614-8830', 'Lake Lavinia', 'view', '85707', 'Elmira', 'Lang', '15127 Mariana Dam\nWillamouth, SD 39037-0398', 'North Claude', 'land', '48768-6243', 1, 0, 0, 1, 38, 1, 0, '2016-11-18', '2016-11-18 07:13:20'),
(86, 2, 'pending', '70054 Orn Bypass\nKundefort, NY 25577', 'Richard', 'Yundt', 'Gulgowski', '91980 Joge Village Suite 734Heiside, WY 72145-3248', 'Aubreeland', 'stad', '93818-6577', 'Merle', 'Marks', 'Russel', '4803 Towne Courts Suite 177\nLaynemouth, NM 83778-3874', 'West Bonitashire', 'land', '62099', 'Reanna Prohaska', '785 Hermann Field\nWest Ryleigh, WY 82190-8952', '4719 Halvorson Pine Suite 175\nWilkinsonton, TX 13970-1082', 'Jaidenport', 'town', '64299', 'Amelia', 'Kautzer', '13454 Labadie Parks\nChanelborough, ID 22849-6535', 'Kyliehaven', 'borough', '35321-8428', 1, 1, 0, 1, 5, 1, 0, '2016-11-18', '2016-11-18 07:13:20'),
(87, 3, 'pending', '94395 Barrows Dam\nCassinhaven, IA 29250-2623', 'Cullen', 'Schulist', 'Donnelly', '2550 Moissette Habo Suite 287Lake Thea, ID 90902', 'North Yessenia', 'borough', '19359', 'Lincoln', 'Cremin', 'Walker', '4045 Ledner Inlet\nAbdullahtown, MI 60663', 'Adellchester', 'ton', '60868-8390', 'Teagan Farrell', '507 Roger Park\nBrianaborough, CA 85683-0482', '885 Ferry Track Suite 181\nEast Raoul, OH 75183-8951', 'North Yesenialand', 'furt', '78976-7092', 'Brandi', 'Ullrich', '9245 Maximilian Islands Apt. 320\nNew Lewis, CA 38501-9748', 'Kundeport', 'mouth', '32762-3280', 1, 0, 1, 1, 12, 1, 0, '2016-11-18', '2016-11-18 07:13:21'),
(88, 1, 'pending', '756 Dickens Prairie\nNorth Camilleside, DC 27126-4310', 'Coy', 'Will', 'Kris', '1350 Keelig Cliffs Apt. 996New Vigiia, NC 23082-5333', 'Bradtkeside', 'shire', '86206', 'Ottilie', 'Robel', 'Mante', '23398 Powlowski Ramp\nNew Dewitt, CO 31863', 'South Alanaport', 'port', '73040-9028', 'Kolby Ferry', '40383 Balistreri Rapids Suite 776\nEast Evans, NM 93794', '308 Tillman Branch\nNew Bradenfurt, WA 26232', 'Gorczanyborough', 'side', '96140', 'Prudence', 'Braun', '7211 Bahringer Squares\nSouth Khalid, GA 35579-0948', 'Juanitatown', 'bury', '12167-5744', 1, 1, 0, 1, 37, 1, 0, '2016-11-18', '2016-11-18 07:13:21'),
(89, 1, 'pending', '929 Hilll Way\nWest Dejuanfurt, MS 96192', 'Eldora', 'Hahn', 'Ondricka', '161 Howell FallsEast Roelside, NC 61079-2293', 'North Rettaborough', 'burgh', '56241', 'Alene', 'Keebler', 'Tremblay', '28313 Allan Wall Suite 467\nDickensburgh, MT 72209', 'Amosshire', 'ville', '60882', 'Nova Spinka', '34067 Rusty Centers\nSouth Thalia, OH 39956', '69060 Euna Trail\nSatterfieldshire, AK 69139', 'Port Evans', 'side', '34128', 'Rita', 'Feil', '55532 Farrell Burgs\nEmardtown, ID 08770-9356', 'Bergeshire', 'stad', '08225-6588', 0, 0, 1, 1, 22, 1, 0, '2016-11-18', '2016-11-18 07:13:21'),
(90, 3, 'replacement', '246 Cordelia Common\nPort Hannafort, AK 95260-1095', 'Brady', 'Berge', 'Fisher', '342 Williamso Plaza Suite 709Rutheto', 'Hirthechester', 'shire', '05936-9575', 'Margarette', 'Fisher', 'Ferry', '7523 Karen Meadow Apt. 212\nNorth Clairefort, MN 31484', 'Pfefferport', 'chester', '27913', 'Esther Koss', '85584 McCullough Junctions\nWest Aisha, KS 61556-0743', '7024 Schowalter Bypass\nTurnerview, GA 07946', 'Lake Cleta', 'side', '92283-8516', 'Duncan', 'Lindgren', '25391 Colten Roads Apt. 070\nAufderharton, UT 83049-9253', 'Dickensfort', 'ton', '83581-0905', 1, 1, 1, 1, 2, 1, 1, '2016-12-05', '2016-11-18 07:13:22'),
(91, 2, 'pending', '338 Kohler Villages Apt. 190\nBergstromberg, LA 92958', 'Alberto', 'Altenwerth', 'Stiedemann', '333 Kole WellsLake Lacyfot, DC 79001-3097', 'Haneview', 'shire', '83241', 'Vidal', 'Reichel', 'Leffler', '8183 Zena Turnpike Apt. 608\nLake Gaylestad, CA 00228', 'Rubenton', 'fort', '19008', 'Reggie Kub', '49205 Vincenza Prairie Suite 247\nBeattyburgh, FL 20637-9339', '5777 McLaughlin Ports\nBalistreriville, PA 60187-6559', 'South Verna', 'ville', '47453', 'Sydney', 'O''Hara', '5101 Glennie Road Suite 413\nPort Alivia, ND 36679-8894', 'Jastside', 'burgh', '66950', 1, 0, 0, 1, 3, 1, 0, '2016-11-18', '2016-11-18 07:13:22'),
(92, 1, 'pending', '9690 Brigitte Garden Apt. 778\nBeierside, WV 33859', 'Beaulah', 'Fritsch', 'Terry', '67117 Metz Wall Suite 228East Daoview, WA 58332', 'Mittiestad', 'port', '40535-6750', 'Gerard', 'Herman', 'Stracke', '56198 Lavinia Inlet\nPfefferburgh, ID 83114-3820', 'O''Keefeburgh', 'ville', '86293-0492', 'Jared Turner', '13944 Alayna Stravenue Apt. 102\nSouth Aliceside, OH 84135-7060', '341 Abbott Underpass Suite 041\nTheronmouth, CT 36230', 'East Drakeburgh', 'mouth', '31210-4380', 'Rhoda', 'Kerluke', '271 Pollich Ports Apt. 332\nMcGlynnchester, MD 90517', 'West Genevieve', 'bury', '70900', 0, 1, 1, 1, 36, 1, 0, '2016-11-18', '2016-11-18 07:13:22'),
(93, 2, 'pending', '681 Purdy Views Apt. 589\nWest Rozella, WA 59671', 'Rogers', 'Ratke', 'Eichmann', '36562 Kista PieSouth Naomi, NM 52694', 'Immanuelberg', 'land', '59087', 'Randal', 'Rice', 'D''Amore', '491 Rempel Court\nLake Gregoryfort, NC 41935-6242', 'Lake Tracey', 'mouth', '66987', 'Selena Windler', '903 Claudie Lock\nGulgowskifort, MA 78224', '89773 Yesenia Flat\nEast Andrew, CT 85218-4989', 'West Ivahmouth', 'ville', '05839', 'Ricardo', 'Carroll', '739 Ewell Ridges Suite 713\nBernadinestad, PA 89619', 'Ardithborough', 'stad', '63585', 0, 0, 0, 1, 43, 1, 0, '2016-11-18', '2016-11-18 07:13:23'),
(94, 2, 'pending', '51356 Boyer Station Apt. 253\nLabadieburgh, UT 50546', 'Abel', 'Maggio', 'Schowalter', '46413 Kista LockElbettow, WY 62023', 'Bodefort', 'bury', '27657', 'Maximillia', 'Ledner', 'Lubowitz', '108 Waelchi Lodge\nPercivalfort, WV 68826', 'New Garlandfurt', 'port', '76184-0688', 'Angelita VonRueden', '438 Stehr Parkways Suite 506\nEast Sincereview, WY 71235', '7052 Reichert Junctions Apt. 942\nSouth Camyllefurt, MS 86292-5172', 'East Santino', 'port', '14135', 'Abbey', 'Prosacco', '1196 Deckow Pike\nGaylestad, WA 23527', 'Ivyton', 'ville', '89910', 0, 1, 0, 1, 11, 1, 0, '2016-11-18', '2016-11-18 07:13:23'),
(95, 3, 'replacement', '73992 Edythe Lights Apt. 211\r East Kelsie, KY 8019522', 'Dena22', 'Erdman22', 'Collier22', '#6195 brenda drives suite 464 emmaborough', 'Arnaldohaven', 'furt', '61277-9803', 'Rafael', 'Schuster', 'Kerluke', '72786 Johnson Spurs Apt. 071\nPort Sibylmouth, CT 73503', 'Danielport', 'ville', '59029', 'Dr. Vernon Little', '4621 Howell Mount Suite 829\nSouth Alyssonville, PA 24617', '395 Roberts Oval Suite 725\nColeside, LA 01151', 'Jennyferstad', 'shire', '91960-8857', 'Leola', 'Reilly', '12387 Nella Causeway Apt. 671\nJazminville, AR 96693', 'Murphyhaven', 'shire', '33955-5548', 1, 0, 1, 1, 2, 0, 0, '2016-12-15', '2016-11-18 07:13:23'),
(96, 1, 'pending', '588 Beer Crossroad Suite 719\nLake Joanview, AZ 30855-6324', 'Ocie', 'Sporer', 'Jaskolski', '26320 Toi Commo Apt. 953Koeppville, PA 24579', 'West Charleyfort', 'port', '57147-7903', 'Deion', 'Batz', 'Ledner', '5949 Keanu Course\nNew Romanbury, NC 58913', 'Barrowsmouth', 'mouth', '67589-8471', 'Turner Spinka III', '124 Gleichner Canyon\nEast Sarah, KY 75761-2506', '252 Wendell Junction Apt. 289\nWhitefort, NE 47602', 'McGlynnfurt', 'town', '40971', 'Jess', 'Tremblay', '5572 Brendan Path\nLake Desmondton, SD 35792-4182', 'South Billieview', 'borough', '71197', 0, 1, 0, 1, 32, 1, 0, '2016-11-18', '2016-11-18 07:13:24'),
(97, 1, 'pending', '87304 Krajcik Roads\nPort Carolinamouth, MT 04471', 'Lazaro', 'Yundt', 'Blanda', '312 Tay Way Suite 049Stephaialad, DE 78052-7743', 'Port Benmouth', 'chester', '28605-2328', 'Cassidy', 'Schaefer', 'Jones', '643 Rico Unions\nNorth Norwoodbury, OR 75496-5828', 'New August', 'land', '34702', 'Dr. Troy Boyer', '2512 Von Run\nTrompshire, WI 29407', '5384 Leopold Camp\nChristiansenchester, ND 50481-4538', 'Lake Edd', 'view', '81229-8904', 'Roslyn', 'Kshlerin', '876 Pearl Manors Apt. 462\nGerryport, AL 42594', 'New Otha', 'stad', '90622-2891', 0, 1, 1, 1, 33, 0, 0, '2016-11-18', '2016-11-18 07:13:24'),
(98, 1, 'pending', '665 Jesse Walks Apt. 278\nLangbury, ME 05752-3182', 'Afton', 'Rippin', 'Moen', '#99101 Will Steet Apt. 178Olobuys', 'North Brenden', 'borough', '76611', 'Natalie', 'Leuschke', 'Rempel', '85312 Margarett Spring\nElishaland, PA 66996-5488', 'Lake Gageside', 'haven', '68227', 'Araceli Bahringer', '424 Arnulfo Prairie Apt. 361\nNew Maryse, AL 01227', '9105 Goyette Center Apt. 603\nBlandabury, WA 91581', 'Alyshahaven', 'bury', '82155', 'Nelda', 'Lakin', '351 Gennaro Dale\nRaynorport, NJ 93381', 'Bayershire', 'port', '96167', 1, 1, 1, 1, 2, 0, 0, '2016-12-20', '2016-11-18 07:13:24'),
(99, 1, 'pending', '547 Elissa Dale Suite 329\nDavidton, SD 47263', 'Deron', 'Mills', 'McGlynn', '#877 Pacocha Cicle Apt. 851East Alfedamouths', 'North Ivaview', 'bury', '82500', 'Janet', 'Bartoletti', 'Berge', '753 Malvina Common Apt. 187\nLake Mossie, AK 13967', 'Stammside', 'furt', '19002', 'Dr. Darby Purdy', '46490 Barrett Inlet\nSteuberland, IN 15648', '90407 Ziemann Junction Apt. 667\nEast Esperanzashire, FL 72087', 'Riverbury', 'borough', '07296', 'Zola', 'Wiegand', '86015 Sipes Drive\nTurcottefort, IN 79099', 'Mrazchester', 'side', '17087', 1, 1, 1, 1, 2, 0, 0, '2016-12-20', '2016-11-18 07:13:25'),
(134, 3, 'active', '\n547 Elissa Dale Suite 329 Davidton, SD 47263', 'Velva', 'Rempel', 'Weber', '147 Cist Falls West Vigiiebuy', 'Arnaldohaven', 'MO', '75562', 'Velva', 'Rempel', 'Dena', '147 Cist Falls West Vigiiebuy', 'Arnaldohaven', 'MO', '75562', 'Velva', 'Rempel', '147 Cist Falls West Vigiiebuy', 'Arnaldohaven', 'MO', '75562', 'Velva', 'Rempel', '147 Cist Falls West Vigiiebuy', 'Arnaldohaven', 'MO', '75562', 0, 0, 0, 1, 2, 1, 0, '2016-12-21', '2016-12-22 05:52:08'),
(135, 3, 'active', '665 Jesse Walks Apt. 278 Langbury, ME 05752-3182', 'Deron', 'Mills', 'McGlynn', '325 Robets PakwayNew Tessieboough', 'New Loyalfurt', 'MO', '75562', 'Rippin', 'Weber', 'Deron', '325 Robets PakwayNew Tessieboough', 'New Loyalfurt', 'MO', '75563', 'Rippin', 'Weber', '325 Robets PakwayNew Tessieboough', 'New Loyalfurt', 'MO', '75563', 'Rippin', 'Weber', '325 Robets PakwayNew Tessieboough', 'New Loyalfurt', 'MO', '75563', 0, 0, 0, 1, 2, 1, 0, '2016-12-21', '2016-12-22 05:52:08'),
(136, 3, 'pending', '87304 Krajcik Roads Port Carolinamouth, MT 04471', 'Lazaro', 'Rippin', 'Moen', '#147 Cist FallsWest Vigiiebuy', 'Daphneville', 'stad', '79586-8060', 'Rempel', 'Moen', 'Velva', '312 Tay Way Suite 049Stephaialad', 'Morissettestad', 'MO', '75564', 'Rempel', 'Moen', '312 Tay Way Suite 049Stephaialad', 'Morissettestad', 'MO', '75564', 'Rempel', 'Moen', '312 Tay Way Suite 049Stephaialad', 'Morissettestad', 'MO', '75564', 0, 0, 0, 1, 2, 1, 0, '2016-12-22', '2016-12-22 05:52:09'),
(137, 3, 'lead', '588 Beer Crossroad Suite 719 Lake Joanview, AZ 30855-6324', 'Ocie', 'Yundt', 'Blanda', '#26320 Toi Commo Apt. 953Koeppville', 'New Loyalfurt', 'MO', '75562', 'Sporer', 'McGlynn', 'Rippin', '26320 Toi Commo Apt. 953Koeppville', 'New Loyalfurt', 'MO', '75565', 'Sporer', 'McGlynn', '26320 Toi Commo Apt. 953Koeppville', 'New Loyalfurt', 'MO', '75565', 'Sporer', 'McGlynn', '26320 Toi Commo Apt. 953Koeppville', 'New Loyalfurt', 'MO', '75565', 0, 0, 0, 1, 2, 1, 0, '2016-12-21', '2016-12-22 05:52:09'),
(138, 3, 'stop', '73992 Edythe Lights Apt. 211 East Kelsie, KY 80195', 'Dena', 'Sporer', 'Jaskolski', '46413 Kista LockElbettow', 'Morissettestad', 'MO', '75562', 'Ocie', 'Jaskolski', 'Blanda', '46413 Kista LockElbettow', 'Morissettestad', 'MO', '75566', 'Ocie', 'Jaskolski', '46413 Kista LockElbettow', 'Morissettestad', 'MO', '75566', 'Ocie', 'Jaskolski', '46413 Kista LockElbettow', 'Morissettestad', 'MO', '75566', 0, 0, 0, 1, 2, 1, 0, '2016-12-22', '2016-12-22 05:52:09'),
(139, 3, 'replacement', '\n547 Elissa Dale Suite 329 Davidton, SD 47263', 'Velva', 'Rempel', 'Weber', '147 Cist Falls West Vigiiebuy', 'Arnaldohaven', 'MO', '75562', 'Velva', 'Rempel', 'Dena', '147 Cist Falls West Vigiiebuy', 'Arnaldohaven', 'MO', '75562', 'Velva', 'Rempel', '147 Cist Falls West Vigiiebuy', 'Arnaldohaven', 'MO', '75562', 'Velva', 'Rempel', '147 Cist Falls West Vigiiebuy', 'Arnaldohaven', 'MO', '75562', 0, 0, 0, 1, 2, 1, 0, '2016-12-22', '2016-12-22 06:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `property_comment`
--

CREATE TABLE `property_comment` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'comment',
  `comment` varchar(1000) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property_comment`
--

INSERT INTO `property_comment` (`id`, `property_id`, `type`, `comment`, `user_id`, `date_created`) VALUES
(1, 1, 'comment', 'Et ut aut sequi sint possimus.', 10, '2016-11-13 07:09:32'),
(2, 1, 'comment', 'Magnam quisquam alias qui nisi enim.', 15, '2016-10-31 13:58:21'),
(3, 1, 'comment', 'Fuga unde autem dolorum amet.', 9, '2016-11-11 14:07:16'),
(4, 1, 'comment', 'Vitae dolores minus voluptates.', 21, '2016-11-17 21:31:30'),
(5, 1, 'comment', 'Voluptatem autem est sunt sequi alias aut repudiandae.', 21, '2016-11-11 02:45:25'),
(6, 1, 'comment', 'Necessitatibus consequatur sint quam velit.', 17, '2016-10-21 22:42:43'),
(7, 1, 'comment', 'Quaerat officia ut quaerat ad.', 7, '2016-11-11 18:05:31'),
(8, 1, 'comment', 'Ex consequatur voluptas facilis et.', 20, '2016-11-10 20:24:10'),
(9, 2, 'comment', 'Magni aut nulla distinctio ipsum harum porro occaecati.', 5, '2016-11-17 23:19:55'),
(10, 2, 'comment', 'At est omnis esse libero explicabo facilis quia.', 7, '2016-11-09 14:09:23'),
(11, 2, 'comment', 'Vel rerum non iure natus est.', 12, '2016-10-31 17:57:17'),
(12, 2, 'comment', 'Unde ad qui id aliquam nemo.', 13, '2016-10-31 09:48:27'),
(13, 2, 'comment', 'Porro earum iure incidunt pariatur modi est.', 13, '2016-11-10 02:32:00'),
(14, 2, 'comment', 'Architecto animi quia similique incidunt reiciendis distinctio ea.', 14, '2016-11-12 09:04:52'),
(15, 3, 'comment', 'Nostrum accusantium omnis quasi ex.', 16, '2016-10-22 14:09:44'),
(16, 3, 'comment', 'Quae nam aut voluptates ipsa consequatur.', 3, '2016-11-04 19:47:46'),
(17, 3, 'comment', 'Dolores consectetur et qui quia.', 11, '2016-10-30 10:01:38'),
(18, 3, 'comment', 'Ut aut voluptate minus ut.', 13, '2016-10-25 06:25:46'),
(19, 4, 'comment', 'Asperiores voluptatem eaque fugiat voluptatem inventore.', 16, '2016-11-10 13:20:57'),
(20, 4, 'comment', 'Aut est ullam commodi quis sit animi.', 6, '2016-11-16 11:40:43'),
(21, 4, 'comment', 'Aliquam necessitatibus rerum non nostrum non consequatur sit accusantium.', 13, '2016-10-30 16:39:05'),
(22, 4, 'comment', 'Et et laboriosam enim sequi non omnis repudiandae enim.', 21, '2016-10-28 12:07:48'),
(23, 5, 'comment', 'Laboriosam repellat qui voluptatem temporibus aperiam.', 20, '2016-11-08 12:22:23'),
(24, 5, 'comment', 'Adipisci fuga voluptatem voluptatem quod saepe omnis quidem.', 22, '2016-11-03 20:45:07'),
(25, 5, 'comment', 'Deserunt enim minus quod quia velit voluptatem dolores.', 19, '2016-10-26 23:18:07'),
(26, 5, 'comment', 'Dolores sed voluptatem velit.', 19, '2016-11-11 08:01:15'),
(27, 6, 'comment', 'Iure repudiandae libero ut consequatur.', 13, '2016-11-02 23:42:49'),
(28, 6, 'comment', 'Impedit possimus sunt et harum qui.', 2, '2016-11-07 15:50:03'),
(29, 6, 'comment', 'Id corporis esse eveniet autem.', 14, '2016-10-20 10:49:49'),
(30, 6, 'comment', 'Minima velit voluptas earum omnis amet nulla deleniti vitae.', 13, '2016-10-29 12:12:22'),
(31, 6, 'comment', 'Eos neque nam ut quas pariatur excepturi.', 22, '2016-10-27 09:34:13'),
(32, 6, 'comment', 'Ut qui amet vitae numquam laborum expedita delectus.', 16, '2016-10-26 16:43:33'),
(33, 6, 'comment', 'Perferendis numquam dicta velit accusantium reprehenderit totam.', 15, '2016-11-13 19:43:39'),
(34, 6, 'comment', 'Ab dicta officiis rerum dolor laboriosam reiciendis et.', 2, '2016-11-09 08:25:56'),
(35, 7, 'comment', 'Vero sunt mollitia eos voluptates eum qui ut ex.', 8, '2016-11-14 04:18:30'),
(36, 7, 'comment', 'Exercitationem quia facere et rerum at.', 22, '2016-11-06 02:23:17'),
(37, 7, 'comment', 'Laborum est quia eum ipsa.', 21, '2016-10-19 07:55:39'),
(38, 7, 'comment', 'Nesciunt nihil voluptas et suscipit.', 2, '2016-11-06 12:29:54'),
(39, 7, 'comment', 'Maiores quo tempore quam assumenda consectetur qui beatae.', 5, '2016-10-22 19:07:45'),
(40, 7, 'comment', 'Sed dolores quae magni quia animi.', 2, '2016-10-22 15:01:52'),
(41, 7, 'comment', 'Porro ut laudantium assumenda veniam exercitationem ut molestiae libero.', 2, '2016-11-15 15:57:48'),
(42, 7, 'comment', 'Nesciunt et voluptatibus magnam voluptas sed fuga fugit.', 19, '2016-11-08 09:09:02'),
(43, 8, 'comment', 'Aut illo sint eaque vel aliquid modi.', 17, '2016-11-04 18:11:01'),
(44, 8, 'comment', 'Ut dolorum voluptatem quia possimus reiciendis nihil et.', 9, '2016-11-02 02:04:41'),
(45, 8, 'comment', 'Beatae dolorem occaecati est et quidem dolorem delectus molestiae.', 2, '2016-10-23 23:08:12'),
(46, 8, 'comment', 'Quasi quia nihil qui eos provident.', 21, '2016-11-14 06:11:38'),
(47, 8, 'comment', 'Distinctio porro odit eum facilis enim exercitationem.', 12, '2016-11-11 21:37:27'),
(48, 9, 'comment', 'Soluta cumque beatae perspiciatis aut.', 19, '2016-10-26 22:01:13'),
(49, 9, 'comment', 'Voluptatem et omnis molestiae soluta porro tempore molestias harum.', 15, '2016-11-12 16:08:32'),
(50, 9, 'comment', 'Eum tempore vitae quis ducimus facilis quod autem.', 20, '2016-10-23 04:14:44'),
(51, 9, 'comment', 'Sint est numquam sapiente veniam ipsum ducimus ipsam.', 11, '2016-11-15 16:22:30'),
(52, 10, 'comment', 'Quasi cum sint recusandae.', 8, '2016-10-27 08:09:57'),
(53, 10, 'comment', 'Eius tempore natus facilis laudantium incidunt quia illum.', 7, '2016-10-26 09:00:38'),
(54, 10, 'comment', 'Repellendus harum ea dolore minima blanditiis non.', 2, '2016-11-13 02:59:37'),
(55, 10, 'comment', 'Deleniti sunt nobis repudiandae est qui adipisci.', 13, '2016-10-21 23:28:38'),
(56, 10, 'comment', 'Provident excepturi rerum culpa facilis fugiat cum.', 13, '2016-11-16 18:49:40'),
(57, 11, 'comment', 'Temporibus repellat eius et sunt aut.', 21, '2016-11-14 23:06:45'),
(58, 11, 'comment', 'Et facere voluptatem ipsa eveniet.', 2, '2016-10-26 16:35:07'),
(59, 11, 'comment', 'Cum hic culpa quia quasi.', 12, '2016-11-07 19:02:27'),
(60, 11, 'comment', 'Fugit fugit quos dolore quibusdam in enim qui.', 4, '2016-11-07 03:13:59'),
(61, 12, 'comment', 'Tempore animi voluptatem velit natus qui placeat.', 13, '2016-10-25 00:58:14'),
(62, 12, 'comment', 'Veritatis repudiandae tempora optio odio.', 5, '2016-11-17 20:02:20'),
(63, 12, 'comment', 'Voluptates dolorem molestias et delectus.', 4, '2016-10-28 05:22:24'),
(64, 12, 'comment', 'Voluptatem ullam aut non voluptatem earum consequatur.', 2, '2016-10-18 22:21:57'),
(65, 13, 'comment', 'Eos quis nemo tempore eum.', 4, '2016-11-08 07:55:08'),
(66, 13, 'comment', 'Magni qui nihil saepe saepe iste nihil.', 14, '2016-11-01 23:10:57'),
(67, 13, 'comment', 'Alias vel eligendi minus facere unde.', 22, '2016-10-19 18:49:28'),
(68, 13, 'comment', 'Minima omnis aspernatur voluptas est.', 13, '2016-11-14 22:17:48'),
(69, 13, 'comment', 'Accusantium possimus aut dolorum placeat rerum debitis quidem.', 16, '2016-10-25 07:27:20'),
(70, 13, 'comment', 'Distinctio porro occaecati labore cupiditate blanditiis aut.', 16, '2016-11-16 11:28:41'),
(71, 13, 'comment', 'Maiores id ab nemo eum sint delectus pariatur.', 9, '2016-11-05 03:35:45'),
(72, 14, 'comment', 'Aut sed nulla rem dolor laborum odio dicta.', 10, '2016-11-07 21:31:42'),
(73, 14, 'comment', 'Omnis quo consequatur sit beatae culpa odit.', 9, '2016-10-30 18:52:53'),
(74, 14, 'comment', 'Saepe rerum suscipit et maiores omnis sint non.', 11, '2016-10-20 04:52:52'),
(75, 14, 'comment', 'Exercitationem eum eveniet qui soluta dolorem laudantium.', 18, '2016-11-08 05:15:35'),
(76, 14, 'comment', 'Quae ratione assumenda ut maiores itaque ut velit pariatur.', 19, '2016-11-08 05:16:31'),
(77, 15, 'comment', 'Officiis neque dignissimos reprehenderit quo.', 10, '2016-11-17 21:48:08'),
(78, 15, 'comment', 'Id voluptatem sunt nisi cum ipsum.', 11, '2016-11-09 04:19:45'),
(79, 15, 'comment', 'Voluptatem quis aut aut atque commodi ad distinctio.', 8, '2016-10-23 07:26:11'),
(80, 15, 'comment', 'Labore laboriosam velit sit ex sit repellendus ut.', 16, '2016-11-15 23:03:39'),
(81, 16, 'comment', 'Quia in voluptatem consequatur exercitationem.', 19, '2016-11-02 20:29:02'),
(82, 16, 'comment', 'Reiciendis libero beatae pariatur.', 2, '2016-10-30 23:01:07'),
(83, 16, 'comment', 'Odio nemo reprehenderit commodi ratione unde voluptas.', 22, '2016-10-21 03:29:30'),
(84, 16, 'comment', 'Ut cum omnis culpa quidem cupiditate qui.', 7, '2016-10-20 05:07:01'),
(85, 16, 'comment', 'Consequuntur aut fugit fugiat dolores cumque id ut.', 10, '2016-11-10 15:36:03'),
(86, 17, 'comment', 'Omnis eius natus est et debitis laboriosam.', 7, '2016-11-11 19:14:10'),
(87, 17, 'comment', 'Sunt illum quibusdam nostrum enim in et.', 6, '2016-11-05 15:44:17'),
(88, 17, 'comment', 'Facilis quisquam nostrum excepturi voluptatem non distinctio enim numquam.', 18, '2016-10-18 06:52:19'),
(89, 18, 'comment', 'Dolorem eum qui voluptas.', 19, '2016-11-12 19:33:17'),
(90, 18, 'comment', 'Odit rem modi rerum eius aperiam aliquid accusamus.', 9, '2016-11-12 04:47:23'),
(91, 18, 'comment', 'Facere molestiae eum quo molestiae illo.', 12, '2016-11-05 20:38:53'),
(92, 18, 'comment', 'Omnis exercitationem qui quibusdam id id modi sed.', 2, '2016-11-15 09:48:37'),
(93, 18, 'comment', 'Et qui laborum sunt dolores saepe.', 21, '2016-10-27 11:27:18'),
(94, 18, 'comment', 'In autem dolor non omnis mollitia.', 10, '2016-11-04 20:00:13'),
(95, 18, 'comment', 'Velit vitae eos aut et.', 11, '2016-11-13 04:34:22'),
(96, 19, 'comment', 'Soluta quia atque modi omnis consequatur et repellendus.', 14, '2016-11-14 21:42:02'),
(97, 19, 'comment', 'Voluptatibus pariatur tenetur quis iste.', 10, '2016-11-12 03:44:09'),
(98, 19, 'comment', 'Ab magnam et numquam architecto blanditiis nostrum est aut.', 11, '2016-10-19 00:22:30'),
(99, 19, 'comment', 'Illum quasi adipisci aut nam.', 15, '2016-10-28 13:35:45'),
(100, 20, 'comment', 'Optio culpa adipisci et quod laborum dignissimos.', 8, '2016-11-15 06:01:37'),
(101, 20, 'comment', 'Eos labore non quisquam ut.', 14, '2016-10-27 00:53:38'),
(102, 20, 'comment', 'Accusamus illo aut consectetur est magnam vitae voluptatum corrupti.', 10, '2016-11-05 11:27:24'),
(103, 20, 'comment', 'Qui fugit laboriosam temporibus et ab.', 8, '2016-10-31 19:36:00'),
(104, 20, 'comment', 'Animi reiciendis eaque deserunt voluptate aut animi ut consequuntur.', 22, '2016-11-04 07:04:19'),
(105, 21, 'comment', 'Voluptatem aliquam voluptate sunt adipisci ut.', 10, '2016-11-03 09:48:55'),
(106, 21, 'comment', 'Iste itaque aliquam aut voluptatem minus minima aut commodi.', 9, '2016-11-01 16:56:28'),
(107, 21, 'comment', 'Quasi cum mollitia qui quia est eaque excepturi sit.', 22, '2016-11-08 22:49:25'),
(108, 21, 'comment', 'Incidunt cum commodi qui rem repellendus cumque sed.', 12, '2016-10-30 13:04:53'),
(109, 22, 'comment', 'Cupiditate reiciendis iusto optio voluptas quas tenetur illum nobis.', 6, '2016-10-19 14:51:38'),
(110, 22, 'comment', 'Vel est ducimus velit velit est amet quia.', 14, '2016-10-27 09:27:26'),
(111, 22, 'comment', 'Aut veritatis accusantium aliquid.', 2, '2016-10-19 10:00:30'),
(112, 22, 'comment', 'Consectetur dicta voluptatem dignissimos velit.', 4, '2016-10-31 06:00:43'),
(113, 23, 'comment', 'Necessitatibus labore est inventore asperiores.', 21, '2016-10-20 22:20:37'),
(114, 23, 'comment', 'Aliquid dolores est est.', 16, '2016-11-07 00:21:27'),
(115, 23, 'comment', 'Velit error qui beatae qui.', 21, '2016-10-30 15:14:42'),
(116, 23, 'comment', 'Sint sunt quia aliquid sit iusto.', 12, '2016-10-24 20:55:03'),
(117, 23, 'comment', 'Autem quo aliquam iusto qui recusandae sed.', 20, '2016-10-22 08:06:12'),
(118, 23, 'comment', 'Dolore expedita qui et nam temporibus officiis eveniet.', 21, '2016-11-12 13:06:24'),
(119, 23, 'comment', 'Quos pariatur ex maxime ut quas excepturi sit sed.', 12, '2016-10-31 00:43:54'),
(120, 24, 'comment', 'Harum doloribus laudantium rerum quas aperiam reprehenderit.', 8, '2016-11-01 18:27:34'),
(121, 24, 'comment', 'Iure excepturi suscipit et architecto ex consequatur temporibus.', 19, '2016-10-30 13:50:20'),
(122, 24, 'comment', 'Ab sint voluptatibus architecto itaque sed eius.', 7, '2016-10-31 15:10:35'),
(123, 24, 'comment', 'Ullam nemo mollitia a qui suscipit occaecati dolor.', 5, '2016-11-08 22:37:00'),
(124, 24, 'comment', 'Neque voluptatem molestiae voluptas repudiandae repellendus dolorem.', 5, '2016-10-26 22:10:50'),
(125, 24, 'comment', 'Dolorem eius eos ut et labore officiis neque sed.', 19, '2016-11-04 16:04:27'),
(126, 25, 'comment', 'Cum eum aperiam amet ratione quis dolor non est.', 2, '2016-10-27 15:38:35'),
(127, 25, 'comment', 'Ut necessitatibus optio et quo quia vitae ipsa.', 6, '2016-10-31 09:57:49'),
(128, 25, 'comment', 'Iste praesentium non laboriosam aut.', 17, '2016-10-29 12:03:22'),
(129, 25, 'comment', 'Ut dicta labore quam sequi.', 22, '2016-11-10 11:40:54'),
(130, 25, 'comment', 'Quae molestiae voluptatem iste quia porro sunt labore.', 5, '2016-11-04 19:21:51'),
(131, 26, 'comment', 'Hic facere itaque dolorum earum.', 2, '2016-11-05 22:35:30'),
(132, 26, 'comment', 'Maxime nulla sit sit eos beatae sint.', 17, '2016-10-19 16:57:59'),
(133, 26, 'comment', 'Sint est soluta assumenda tempore.', 15, '2016-11-12 17:15:50'),
(134, 26, 'comment', 'Velit dolores ex magnam est aut recusandae voluptatem aperiam.', 19, '2016-11-17 19:36:13'),
(135, 27, 'comment', 'Veritatis commodi iusto quidem exercitationem placeat.', 3, '2016-11-17 14:49:49'),
(136, 27, 'comment', 'Amet et molestias debitis quia sint consequatur.', 20, '2016-10-28 18:08:18'),
(137, 27, 'comment', 'Eum unde ab dolor magnam similique quaerat mollitia.', 20, '2016-10-21 16:27:21'),
(138, 27, 'comment', 'Quod officiis est sunt nostrum maiores.', 20, '2016-11-02 16:24:48'),
(139, 28, 'comment', 'Aliquid et sit itaque suscipit.', 5, '2016-10-23 05:05:38'),
(140, 28, 'comment', 'Ea minus voluptatem qui quibusdam unde.', 19, '2016-11-05 07:40:42'),
(141, 28, 'comment', 'Vel sequi quibusdam velit similique error.', 14, '2016-10-28 14:54:25'),
(142, 28, 'comment', 'Vel veniam eos sunt ut cum recusandae qui.', 15, '2016-10-23 18:20:22'),
(143, 28, 'comment', 'Amet nobis id vel odio nesciunt consectetur officiis.', 12, '2016-10-19 18:23:46'),
(144, 29, 'comment', 'Ex iure quos explicabo.', 16, '2016-10-25 19:20:09'),
(145, 29, 'comment', 'Quod et vero a.', 16, '2016-11-03 18:18:51'),
(146, 29, 'comment', 'Expedita qui aut consequuntur natus.', 4, '2016-10-31 15:44:00'),
(147, 29, 'comment', 'Nemo harum et sequi et fuga ad explicabo.', 21, '2016-10-27 15:09:27'),
(148, 30, 'comment', 'Enim voluptatem eos occaecati architecto illo natus.', 3, '2016-10-26 10:56:35'),
(149, 30, 'comment', 'Dolor eveniet molestiae repellendus nemo quia.', 13, '2016-11-02 03:59:57'),
(150, 30, 'comment', 'Vel et officiis nostrum voluptatem modi maiores.', 15, '2016-11-03 18:50:17'),
(151, 30, 'comment', 'Neque omnis illum et libero.', 13, '2016-11-03 19:20:00'),
(152, 30, 'comment', 'Numquam dolor voluptatem non perferendis nobis at qui.', 20, '2016-10-19 17:15:41'),
(153, 30, 'comment', 'Recusandae porro natus optio dolorem.', 17, '2016-11-05 09:06:47'),
(154, 31, 'comment', 'Voluptas fuga provident quia ullam et.', 18, '2016-10-29 09:24:53'),
(155, 31, 'comment', 'Beatae dolores sapiente sit id quia quia.', 16, '2016-11-12 14:10:33'),
(156, 31, 'comment', 'Vero et est eos accusamus sequi deserunt.', 17, '2016-10-26 07:46:18'),
(157, 31, 'comment', 'Est ipsa dignissimos voluptatum.', 9, '2016-11-09 03:56:12'),
(158, 31, 'comment', 'Vel nihil accusamus quaerat qui non.', 9, '2016-11-14 07:35:26'),
(159, 31, 'comment', 'Odit qui libero velit.', 15, '2016-11-08 18:14:01'),
(160, 32, 'comment', 'Aut et iure velit incidunt corporis velit et.', 19, '2016-10-21 10:57:00'),
(161, 32, 'comment', 'Omnis vero vel atque.', 19, '2016-10-25 12:31:42'),
(162, 32, 'comment', 'Omnis exercitationem vel dolor ex id.', 12, '2016-11-08 05:48:34'),
(163, 32, 'comment', 'Dicta recusandae aut officiis ut molestiae vel quod.', 9, '2016-11-15 18:23:50'),
(164, 32, 'comment', 'Ut reprehenderit dolorem dolorem laboriosam corrupti.', 3, '2016-11-10 19:07:21'),
(165, 32, 'comment', 'Possimus amet aperiam laudantium.', 6, '2016-11-10 21:52:24'),
(166, 32, 'comment', 'Reiciendis qui eius dolorem tenetur.', 18, '2016-11-12 18:58:57'),
(167, 33, 'comment', 'Provident vel beatae sequi perspiciatis.', 5, '2016-11-08 15:35:22'),
(168, 33, 'comment', 'Et quasi nam eum similique inventore.', 16, '2016-10-23 04:05:39'),
(169, 33, 'comment', 'Eius est rerum possimus.', 15, '2016-10-20 22:09:30'),
(170, 33, 'comment', 'Nobis sint iure eaque ut amet at dolorum.', 8, '2016-11-13 11:28:25'),
(171, 33, 'comment', 'Possimus sed maiores maiores eaque.', 12, '2016-10-22 16:12:15'),
(172, 34, 'comment', 'Et veniam nobis sit impedit asperiores sunt voluptates.', 12, '2016-10-24 22:26:36'),
(173, 34, 'comment', 'Ut non ab quam voluptate esse molestias velit.', 9, '2016-11-10 06:30:53'),
(174, 34, 'comment', 'Labore natus ducimus eius perspiciatis et maiores.', 7, '2016-10-29 06:25:19'),
(175, 34, 'comment', 'Doloribus nulla omnis est illo voluptas eum suscipit dolorum.', 6, '2016-10-25 07:35:52'),
(176, 34, 'comment', 'Numquam ducimus qui enim sit dolorem provident.', 19, '2016-11-17 07:50:18'),
(177, 34, 'comment', 'Excepturi dignissimos alias dolor.', 3, '2016-10-18 17:22:23'),
(178, 35, 'comment', 'Eveniet autem dicta voluptas iusto tenetur.', 9, '2016-10-26 09:29:48'),
(179, 35, 'comment', 'Eaque veritatis et possimus eligendi autem unde totam.', 22, '2016-11-14 19:54:18'),
(180, 35, 'comment', 'Et odio esse quam ipsa.', 2, '2016-10-31 10:20:45'),
(181, 35, 'comment', 'Ut voluptatum sequi est ut esse iste.', 18, '2016-11-08 07:41:18'),
(182, 35, 'comment', 'In dolorem itaque odio mollitia.', 22, '2016-10-28 12:09:33'),
(183, 35, 'comment', 'Hic minus quasi amet.', 9, '2016-10-20 21:18:03'),
(184, 35, 'comment', 'Rerum vel laudantium sit fuga.', 14, '2016-11-07 14:29:04'),
(185, 36, 'comment', 'Consequatur temporibus ut dolorum omnis libero quia velit.', 15, '2016-11-03 22:35:03'),
(186, 36, 'comment', 'Quaerat fuga eligendi autem.', 8, '2016-10-29 10:04:23'),
(187, 36, 'comment', 'Quidem enim architecto nihil est.', 7, '2016-11-05 13:34:27'),
(188, 36, 'comment', 'Sint enim ipsum optio quos sit voluptatum.', 22, '2016-11-13 23:22:21'),
(189, 37, 'comment', 'Sed natus iste et repellat sunt ea.', 16, '2016-10-21 04:34:52'),
(190, 37, 'comment', 'Rerum perferendis blanditiis architecto id consequuntur voluptatem.', 4, '2016-10-28 17:03:03'),
(191, 37, 'comment', 'Et fuga et velit qui illo occaecati quasi necessitatibus.', 11, '2016-11-10 14:01:16'),
(192, 37, 'comment', 'Et nobis nam minus.', 20, '2016-11-16 05:12:44'),
(193, 37, 'comment', 'Qui quod sunt reiciendis unde velit sint corrupti.', 16, '2016-11-10 06:52:03'),
(194, 37, 'comment', 'Eius rerum rem nisi quis nulla quia.', 2, '2016-10-26 01:11:13'),
(195, 38, 'comment', 'Nemo et qui animi officia suscipit voluptatibus.', 10, '2016-11-10 00:30:11'),
(196, 38, 'comment', 'Maxime et reiciendis consequatur deleniti deleniti.', 5, '2016-11-16 10:45:31'),
(197, 38, 'comment', 'Cum voluptatem voluptas eum suscipit et unde.', 19, '2016-11-04 09:43:34'),
(198, 38, 'comment', 'Quos incidunt repellat nihil unde.', 12, '2016-11-04 22:44:47'),
(199, 39, 'comment', 'Maxime aliquam similique magni voluptatem ab sunt et.', 19, '2016-10-25 19:16:17'),
(200, 39, 'comment', 'Commodi non et expedita cupiditate odio.', 14, '2016-11-03 17:37:06'),
(201, 39, 'comment', 'Cupiditate placeat sapiente ut inventore qui et.', 11, '2016-11-03 22:23:10'),
(202, 39, 'comment', 'Illo animi a quo eaque ad.', 5, '2016-10-30 09:14:15'),
(203, 39, 'comment', 'Et nesciunt illum aspernatur ducimus eligendi in.', 10, '2016-11-16 20:02:46'),
(204, 40, 'comment', 'Mollitia reiciendis ipsa dolorum sit et aliquam aspernatur non.', 2, '2016-10-28 13:30:22'),
(205, 40, 'comment', 'Numquam assumenda ipsum repellendus voluptas dolores illo autem.', 14, '2016-10-24 12:06:39'),
(206, 40, 'comment', 'Velit aliquid qui similique iusto est sint.', 9, '2016-10-30 07:10:46'),
(207, 40, 'comment', 'Corrupti quo quaerat ab amet nostrum architecto dolore.', 18, '2016-10-30 04:43:37'),
(208, 40, 'comment', 'Dolor quia et est quo voluptatem.', 10, '2016-10-22 11:27:05'),
(209, 41, 'comment', 'Placeat corrupti sapiente corrupti nobis tempore dignissimos soluta.', 8, '2016-11-09 04:47:40'),
(210, 41, 'comment', 'Voluptatem dolor veniam architecto provident.', 11, '2016-10-27 22:43:27'),
(211, 41, 'comment', 'Aperiam error placeat ratione ea aut.', 20, '2016-11-01 14:46:59'),
(212, 42, 'comment', 'Fugit quod consequuntur similique deserunt similique.', 6, '2016-10-30 08:32:16'),
(213, 42, 'comment', 'Quae sint vitae et accusamus ipsum voluptatum aut.', 2, '2016-10-20 15:34:00'),
(214, 42, 'comment', 'Modi perspiciatis explicabo quidem.', 16, '2016-11-15 14:59:09'),
(215, 42, 'comment', 'Maiores quae voluptate ad voluptatum.', 4, '2016-11-05 00:46:45'),
(216, 42, 'comment', 'Sed esse sit vitae ipsam maxime sed soluta aut.', 22, '2016-11-07 03:50:37'),
(217, 43, 'comment', 'Laboriosam quaerat quasi qui nihil et.', 19, '2016-11-12 18:12:37'),
(218, 43, 'comment', 'Mollitia veniam voluptatibus dolores ut molestiae tempore.', 18, '2016-10-20 05:38:33'),
(219, 43, 'comment', 'Tempora minus libero quod non quo sint ut aut.', 5, '2016-11-15 04:21:29'),
(220, 43, 'comment', 'Mollitia architecto animi praesentium.', 15, '2016-11-17 09:28:34'),
(221, 43, 'comment', 'Et ipsum et sed voluptatem fugiat.', 15, '2016-10-23 12:05:13'),
(222, 44, 'comment', 'Velit voluptas sed et.', 3, '2016-11-15 07:00:10'),
(223, 44, 'comment', 'Autem sit quod accusamus id quod modi deserunt in.', 20, '2016-11-05 06:26:28'),
(224, 44, 'comment', 'Non nihil et expedita.', 17, '2016-11-09 12:17:43'),
(225, 44, 'comment', 'Voluptatum et saepe ratione ab sit.', 2, '2016-10-23 17:30:32'),
(226, 45, 'comment', 'Non delectus porro iusto ut quo natus.', 15, '2016-11-11 10:43:53'),
(227, 45, 'comment', 'Illo sit dolor veritatis iste.', 21, '2016-10-29 12:00:33'),
(228, 45, 'comment', 'Sed aspernatur sed inventore pariatur reprehenderit numquam.', 9, '2016-11-02 05:55:31'),
(229, 45, 'comment', 'Et perferendis nobis ex magnam.', 9, '2016-11-10 08:23:55'),
(230, 45, 'comment', 'Qui quia veniam animi quas voluptates.', 7, '2016-10-27 12:29:25'),
(231, 46, 'comment', 'Qui magni non et excepturi quibusdam sit.', 13, '2016-11-14 17:48:33'),
(232, 46, 'comment', 'Amet id aut similique labore perferendis molestiae molestias animi.', 8, '2016-10-19 22:03:01'),
(233, 46, 'comment', 'Eum vitae accusantium et dolore consequuntur aliquam quis molestiae.', 4, '2016-11-03 19:59:47'),
(234, 46, 'comment', 'Sed rerum quasi ea harum.', 4, '2016-11-12 09:52:04'),
(235, 47, 'comment', 'Magni vel veritatis rem.', 8, '2016-10-18 04:33:05'),
(236, 47, 'comment', 'Sed iste saepe aut.', 7, '2016-11-02 19:39:29'),
(237, 47, 'comment', 'Commodi eius et et velit alias totam aut.', 9, '2016-10-29 19:27:43'),
(238, 47, 'comment', 'Qui fugit eum similique omnis.', 7, '2016-10-18 15:07:50'),
(239, 47, 'comment', 'Nihil consequatur sequi amet ratione aut.', 22, '2016-11-01 23:04:09'),
(240, 48, 'comment', 'Odio ut maxime eos odio magni id.', 21, '2016-10-29 11:13:06'),
(241, 48, 'comment', 'Perspiciatis dolorem necessitatibus earum sed quod.', 20, '2016-11-14 08:13:28'),
(242, 48, 'comment', 'Aut laborum ratione quas beatae voluptatibus accusamus.', 21, '2016-10-31 17:37:23'),
(243, 49, 'comment', 'Consequatur consequatur nihil quia sit qui facere.', 22, '2016-10-22 12:46:16'),
(244, 49, 'comment', 'Porro sint qui laboriosam ut rerum quisquam possimus.', 9, '2016-10-25 07:24:23'),
(245, 49, 'comment', 'Velit sed velit et cupiditate ipsum sit eum.', 16, '2016-11-14 11:45:33'),
(246, 49, 'comment', 'Ducimus assumenda atque autem.', 8, '2016-10-31 02:12:11'),
(247, 50, 'comment', 'Minima et eligendi eligendi ullam voluptas.', 13, '2016-10-24 01:52:01'),
(248, 50, 'comment', 'Consequatur labore mollitia ut.', 6, '2016-11-09 01:00:47'),
(249, 50, 'comment', 'Impedit et assumenda autem et.', 4, '2016-11-02 14:48:48'),
(250, 50, 'comment', 'Sequi quia ut recusandae voluptatem.', 12, '2016-10-24 19:52:19'),
(251, 50, 'comment', 'Ullam in ut vero nemo.', 13, '2016-10-20 13:33:08'),
(252, 50, 'comment', 'Eum quae incidunt adipisci voluptas libero est.', 21, '2016-11-16 08:03:24'),
(253, 51, 'comment', 'Ex quo et libero esse sequi eum consequatur.', 3, '2016-11-14 22:54:48'),
(254, 51, 'comment', 'Amet ut numquam et expedita tempora est.', 6, '2016-11-01 11:29:40'),
(255, 51, 'comment', 'Accusamus eum nihil necessitatibus sint unde.', 11, '2016-10-21 23:09:10'),
(256, 51, 'comment', 'Eos sunt sed dolorem fugiat repellat quo.', 15, '2016-11-03 01:20:24'),
(257, 51, 'comment', 'Quae cumque aspernatur harum illum ut molestiae.', 8, '2016-10-28 03:30:47'),
(258, 51, 'comment', 'Accusamus quo qui alias et aliquam eaque in quam.', 7, '2016-10-25 05:43:38'),
(259, 52, 'comment', 'Accusamus praesentium enim voluptatum aut rerum recusandae ipsum adipisci.', 15, '2016-11-16 03:42:22'),
(260, 52, 'comment', 'Incidunt dolorum facere qui iste optio.', 11, '2016-10-18 10:47:45'),
(261, 52, 'comment', 'Facilis eligendi temporibus distinctio.', 15, '2016-11-16 17:55:22'),
(262, 53, 'comment', 'Et ab est quia mollitia dolore.', 10, '2016-10-29 13:10:21'),
(263, 53, 'comment', 'Accusantium tenetur aliquid repellat omnis culpa distinctio.', 13, '2016-10-21 23:43:11'),
(264, 53, 'comment', 'Modi rem deserunt minima in qui itaque fugit.', 10, '2016-10-19 00:24:07'),
(265, 53, 'comment', 'Quod exercitationem aut aperiam unde nam cupiditate quam.', 14, '2016-10-19 14:28:50'),
(266, 53, 'comment', 'Reprehenderit dolorum aliquid voluptates qui et eum iste.', 10, '2016-11-13 05:34:06'),
(267, 53, 'comment', 'Et in quod nihil porro nostrum.', 20, '2016-11-14 06:37:57'),
(268, 53, 'comment', 'In delectus soluta itaque voluptas ipsam.', 8, '2016-10-22 14:37:34'),
(269, 53, 'comment', 'Sed modi ea aliquid magnam.', 2, '2016-10-27 05:15:57'),
(270, 54, 'comment', 'Ratione incidunt iste minima laudantium aut.', 18, '2016-11-05 06:29:56'),
(271, 54, 'comment', 'Alias debitis officia veritatis fugit.', 3, '2016-11-05 09:37:12'),
(272, 54, 'comment', 'Accusamus quasi consequatur sed eos.', 3, '2016-11-09 17:19:44'),
(273, 54, 'comment', 'A nobis autem omnis velit debitis sint.', 19, '2016-11-08 08:26:06'),
(274, 55, 'comment', 'Eligendi delectus blanditiis porro voluptas sed.', 22, '2016-11-15 12:59:19'),
(275, 55, 'comment', 'Quis velit provident reprehenderit id ullam et velit.', 3, '2016-10-18 20:39:40'),
(276, 55, 'comment', 'Nam aperiam ipsam velit vitae.', 13, '2016-11-05 19:05:21'),
(277, 55, 'comment', 'Minus dolor corrupti consequatur non.', 19, '2016-10-28 02:36:30'),
(278, 56, 'comment', 'Magni et tempore quis delectus corrupti quidem.', 5, '2016-11-16 03:19:33'),
(279, 56, 'comment', 'Sed rerum et numquam est inventore similique error.', 18, '2016-10-23 22:55:38'),
(280, 56, 'comment', 'Sint ut autem at.', 12, '2016-11-13 17:42:58'),
(281, 56, 'comment', 'Omnis sit odit excepturi at est.', 20, '2016-10-19 03:19:22'),
(282, 57, 'comment', 'Tenetur assumenda eligendi et nihil doloremque in.', 9, '2016-11-02 13:06:43'),
(283, 57, 'comment', 'Numquam quia fugit et fugiat.', 14, '2016-11-14 18:25:35'),
(284, 57, 'comment', 'Nihil ratione aliquid eos nobis totam unde ut.', 21, '2016-10-28 08:24:24'),
(285, 57, 'comment', 'Optio perspiciatis excepturi reprehenderit consectetur et doloribus quaerat.', 22, '2016-11-16 12:24:58'),
(286, 58, 'comment', 'Non vel dicta et itaque sapiente ut.', 15, '2016-11-06 04:35:16'),
(287, 58, 'comment', 'Repellat recusandae quis nam aut dolores reiciendis.', 16, '2016-10-29 22:21:36'),
(288, 58, 'comment', 'Repellendus eveniet quisquam iste modi.', 14, '2016-10-20 09:46:30'),
(289, 58, 'comment', 'Vel dolor harum dicta aut.', 11, '2016-11-08 19:13:29'),
(290, 58, 'comment', 'Pariatur quia nulla itaque nihil recusandae autem.', 13, '2016-10-31 08:17:32'),
(291, 58, 'comment', 'Quis possimus exercitationem ut ipsa.', 3, '2016-10-26 13:57:13'),
(292, 59, 'comment', 'Nostrum atque libero quos ea recusandae adipisci.', 20, '2016-11-16 02:31:06'),
(293, 59, 'comment', 'Odit labore corporis harum rerum illum qui non.', 5, '2016-10-25 23:10:23'),
(294, 59, 'comment', 'Dolor praesentium qui consequatur qui blanditiis.', 7, '2016-10-27 09:41:03'),
(295, 59, 'comment', 'Atque qui et fugit delectus ut vitae itaque et.', 6, '2016-11-07 07:07:09'),
(296, 60, 'comment', 'Dolorum magni voluptatum quam soluta.', 12, '2016-11-02 16:54:20'),
(297, 60, 'comment', 'Quos accusantium fuga doloremque et suscipit.', 21, '2016-10-25 14:56:07'),
(298, 60, 'comment', 'Et a quia at laudantium dolorem.', 9, '2016-11-02 09:08:22'),
(299, 60, 'comment', 'Sunt quasi nam consequatur dolorum non et.', 11, '2016-10-28 17:02:07'),
(300, 60, 'comment', 'Et perferendis qui et aut quia.', 2, '2016-10-23 10:15:05'),
(301, 61, 'comment', 'Possimus cupiditate aut dolorem.', 13, '2016-11-03 04:20:28'),
(302, 61, 'comment', 'Aut necessitatibus placeat sit explicabo assumenda aliquam.', 18, '2016-11-10 10:27:03'),
(303, 61, 'comment', 'Non nihil praesentium quisquam sunt.', 4, '2016-11-11 10:54:47'),
(304, 61, 'comment', 'Incidunt voluptate rerum cum quo minima nulla magnam.', 22, '2016-11-16 06:56:04'),
(305, 61, 'comment', 'Blanditiis placeat fugit animi.', 20, '2016-11-17 05:58:44'),
(306, 61, 'comment', 'Possimus necessitatibus est totam adipisci rem molestiae odio.', 5, '2016-11-10 18:32:54'),
(307, 62, 'comment', 'Laudantium laboriosam atque unde sapiente aut aperiam debitis.', 12, '2016-11-13 19:37:06'),
(308, 62, 'comment', 'Consequuntur dolorem ut et nemo nihil officia corporis ut.', 12, '2016-11-17 11:57:11'),
(309, 62, 'comment', 'Voluptas omnis non exercitationem aut molestiae quasi eius.', 19, '2016-11-12 19:13:11'),
(310, 62, 'comment', 'Magnam corporis quis natus aut quo.', 19, '2016-11-14 14:29:08'),
(311, 62, 'comment', 'Eligendi quae aut provident accusantium.', 14, '2016-10-20 18:59:01'),
(312, 62, 'comment', 'Voluptate id ea ullam est esse sunt atque.', 18, '2016-11-06 19:55:10'),
(313, 63, 'comment', 'Maiores eveniet aut pariatur et excepturi fuga labore sapiente.', 11, '2016-11-06 17:55:13'),
(314, 63, 'comment', 'Sit rerum facere consequatur iusto alias nesciunt.', 3, '2016-11-01 21:53:42'),
(315, 63, 'comment', 'Consequuntur voluptatem ex rerum consequuntur.', 20, '2016-11-02 00:30:14'),
(316, 63, 'comment', 'Voluptatibus odit amet autem alias.', 18, '2016-11-11 12:43:57'),
(317, 63, 'comment', 'Dolores aliquam aut est et odio.', 8, '2016-11-05 23:32:54'),
(318, 63, 'comment', 'Sequi inventore quasi vitae provident aut quibusdam est.', 5, '2016-11-03 23:22:59'),
(319, 63, 'comment', 'Incidunt est qui saepe.', 8, '2016-10-25 07:40:05'),
(320, 63, 'comment', 'Expedita optio reprehenderit incidunt.', 12, '2016-11-08 17:04:53'),
(321, 64, 'comment', 'Eaque itaque quisquam illum maxime dignissimos.', 20, '2016-11-16 22:54:46'),
(322, 64, 'comment', 'Voluptatum omnis quibusdam quis aliquam sit in aut.', 10, '2016-11-09 23:22:20'),
(323, 64, 'comment', 'Autem delectus voluptates eos dolorum.', 5, '2016-11-02 00:11:01'),
(324, 64, 'comment', 'Facilis ratione unde occaecati sed magnam a.', 17, '2016-11-01 02:48:53'),
(325, 65, 'comment', 'Consequatur qui expedita quaerat expedita nobis assumenda qui velit.', 7, '2016-10-30 19:14:40'),
(326, 65, 'comment', 'Quae eos ut adipisci deleniti exercitationem ipsa sunt.', 19, '2016-10-22 23:06:55'),
(327, 65, 'comment', 'Enim molestiae inventore velit.', 4, '2016-11-11 06:11:34'),
(328, 65, 'comment', 'Dicta sit eos sint qui enim itaque nesciunt.', 11, '2016-11-17 18:19:32'),
(329, 65, 'comment', 'Pariatur officia ratione voluptatem consequatur praesentium laborum.', 8, '2016-10-25 23:12:17'),
(330, 65, 'comment', 'Et et corrupti voluptates illum ipsam.', 19, '2016-11-13 22:36:58'),
(331, 65, 'comment', 'Dolor labore quaerat quos adipisci laudantium accusantium.', 21, '2016-11-11 23:48:13'),
(332, 66, 'comment', 'Aliquid asperiores ea suscipit nisi.', 10, '2016-11-17 21:02:17'),
(333, 66, 'comment', 'Soluta nihil velit magni.', 4, '2016-11-12 15:43:01'),
(334, 66, 'comment', 'Et reiciendis eum earum fuga vel.', 21, '2016-10-23 19:48:45'),
(335, 66, 'comment', 'Voluptatem qui nisi voluptatibus accusamus eaque eius repellat.', 18, '2016-11-13 11:44:16'),
(336, 66, 'comment', 'Ipsam dolorem omnis amet suscipit id qui inventore.', 7, '2016-10-24 02:05:40'),
(337, 66, 'comment', 'Qui ut incidunt velit quaerat.', 9, '2016-11-12 17:03:39'),
(338, 67, 'comment', 'Dicta non sit recusandae magni quia molestiae modi.', 5, '2016-11-04 10:23:58'),
(339, 67, 'comment', 'Molestias voluptatibus a quibusdam dignissimos voluptatibus saepe placeat voluptatem.', 15, '2016-10-28 03:43:34'),
(340, 67, 'comment', 'Error et et ut quis.', 13, '2016-11-04 11:16:33'),
(341, 68, 'comment', 'Ut at laboriosam error eveniet dolores voluptatibus qui.', 15, '2016-11-13 20:35:21'),
(342, 68, 'comment', 'Assumenda eum id eveniet eum omnis voluptas.', 18, '2016-11-12 10:27:54'),
(343, 68, 'comment', 'Facilis corrupti atque aperiam.', 12, '2016-11-02 14:03:53'),
(344, 68, 'comment', 'Numquam id eos laborum quidem et et.', 11, '2016-11-05 00:00:52'),
(345, 68, 'comment', 'Animi quos natus ut minus dolores aperiam est.', 5, '2016-11-13 10:37:00'),
(346, 68, 'comment', 'Voluptates ut quia veritatis tempore eaque et quaerat.', 17, '2016-10-25 13:42:40'),
(347, 68, 'comment', 'Veniam rerum incidunt sit nemo aperiam rerum.', 13, '2016-11-11 12:45:07'),
(348, 69, 'comment', 'Ut non quia tenetur consequatur architecto adipisci dicta.', 6, '2016-11-15 05:50:13'),
(349, 69, 'comment', 'Libero voluptas qui itaque suscipit harum.', 10, '2016-10-28 15:59:02'),
(350, 69, 'comment', 'Numquam qui et odio iusto eum.', 15, '2016-11-07 17:15:16'),
(351, 70, 'comment', 'Autem qui id veniam.', 3, '2016-10-24 06:41:00'),
(352, 70, 'comment', 'Debitis suscipit dolor quia dolor laboriosam.', 12, '2016-10-25 17:33:39'),
(353, 70, 'comment', 'Voluptatum et et aspernatur delectus.', 6, '2016-11-02 11:52:57'),
(354, 70, 'comment', 'Beatae natus occaecati enim non rerum necessitatibus.', 10, '2016-10-20 00:05:14'),
(355, 70, 'comment', 'Aut distinctio laboriosam veniam.', 22, '2016-11-11 01:06:17'),
(356, 70, 'comment', 'Itaque nostrum ut quidem et et recusandae vitae.', 14, '2016-11-13 23:15:03'),
(357, 70, 'comment', 'Cumque sed eos qui vitae aut ipsa est sunt.', 4, '2016-10-29 09:02:23'),
(358, 71, 'comment', 'Iusto in ipsa ut natus fugit nisi.', 15, '2016-11-10 09:48:31'),
(359, 71, 'comment', 'Autem et a ut quisquam omnis.', 12, '2016-10-20 05:40:09'),
(360, 71, 'comment', 'Tenetur nulla earum itaque ipsam rerum.', 4, '2016-11-01 05:15:20'),
(361, 71, 'comment', 'Deserunt pariatur vel sapiente aut voluptates et nesciunt ut.', 20, '2016-11-16 23:11:20'),
(362, 71, 'comment', 'In et et dolores maxime dolor consequuntur dolor.', 11, '2016-11-09 19:07:44'),
(363, 71, 'comment', 'Eveniet perspiciatis earum consequuntur corporis rerum enim qui.', 14, '2016-10-20 03:06:52'),
(364, 71, 'comment', 'Voluptas sit voluptatem iure quaerat et id.', 20, '2016-10-23 23:17:24'),
(365, 72, 'comment', 'Laboriosam et magni eligendi debitis quo qui eos.', 4, '2016-10-19 21:04:24'),
(366, 72, 'comment', 'Fugiat eos aspernatur repudiandae sapiente.', 18, '2016-10-22 22:19:42'),
(367, 72, 'comment', 'Dignissimos et eum ad facere quos.', 3, '2016-10-22 16:07:46'),
(368, 72, 'comment', 'Qui laborum veniam repellat sit accusantium in.', 13, '2016-10-24 06:53:56'),
(369, 72, 'comment', 'Nihil iste consequatur sint provident fugit.', 14, '2016-10-25 06:46:08'),
(370, 73, 'comment', 'Reprehenderit qui sit veniam aperiam non nam autem.', 22, '2016-10-29 10:55:15'),
(371, 73, 'comment', 'Voluptatem quo tempore quis quia aut.', 8, '2016-10-20 13:34:33'),
(372, 73, 'comment', 'Amet molestias fuga consequatur praesentium.', 3, '2016-11-09 11:21:39'),
(373, 73, 'comment', 'In in laudantium dolores et dolores.', 15, '2016-10-31 19:10:49'),
(374, 73, 'comment', 'Distinctio sint voluptates delectus porro iusto.', 3, '2016-11-03 17:56:35'),
(375, 73, 'comment', 'Non non reiciendis fuga omnis debitis.', 4, '2016-10-28 22:54:11'),
(376, 73, 'comment', 'Quibusdam aperiam tenetur repudiandae aut expedita magni hic.', 19, '2016-11-15 13:40:16'),
(377, 73, 'comment', 'Aliquid incidunt quis excepturi itaque.', 9, '2016-10-31 20:18:22'),
(378, 74, 'comment', 'Iusto iste et vero eaque.', 19, '2016-11-15 17:19:17'),
(379, 74, 'comment', 'Unde molestias quia temporibus eius est.', 11, '2016-11-16 18:42:51'),
(380, 74, 'comment', 'Nostrum dicta est qui id adipisci necessitatibus impedit odio.', 18, '2016-11-08 12:59:57'),
(381, 74, 'comment', 'Quia dolorem totam voluptas sed cum aut id.', 14, '2016-10-26 19:42:17'),
(382, 74, 'comment', 'Omnis dolore voluptas ut totam ipsum.', 19, '2016-10-18 08:50:35'),
(383, 75, 'comment', 'Earum esse perspiciatis sed corrupti.', 3, '2016-11-12 05:23:46'),
(384, 75, 'comment', 'In inventore velit nihil dolores.', 15, '2016-10-28 10:31:41'),
(385, 75, 'comment', 'Recusandae quia nobis aut quia nesciunt alias.', 2, '2016-10-31 21:21:10'),
(386, 75, 'comment', 'Id autem adipisci fugiat qui soluta et.', 16, '2016-10-31 14:00:09'),
(387, 75, 'comment', 'Laborum praesentium pariatur commodi sequi qui sunt porro.', 10, '2016-11-17 05:20:10'),
(388, 75, 'comment', 'Aut rerum repudiandae reiciendis error et vel molestiae.', 14, '2016-10-21 12:02:55'),
(389, 75, 'comment', 'Aut accusamus exercitationem sint tenetur quaerat eveniet nam.', 9, '2016-10-25 19:30:17'),
(390, 75, 'comment', 'Quis ratione iusto mollitia numquam ea.', 4, '2016-11-15 15:54:08'),
(391, 75, 'comment', 'Sunt dolore voluptates id.', 11, '2016-11-12 20:29:44'),
(392, 76, 'comment', 'Culpa et necessitatibus nemo.', 3, '2016-10-28 20:20:21'),
(393, 76, 'comment', 'Ut perspiciatis suscipit dolores et voluptatum quasi.', 18, '2016-10-19 18:21:35'),
(394, 76, 'comment', 'Et amet dolorem laboriosam voluptatem exercitationem.', 6, '2016-11-04 14:40:06'),
(395, 77, 'comment', 'Velit quaerat accusamus beatae aut assumenda aperiam.', 7, '2016-10-31 18:07:36'),
(396, 77, 'comment', 'Voluptas soluta ut sequi qui perspiciatis eos fugiat.', 21, '2016-11-12 03:27:37'),
(397, 77, 'comment', 'Accusamus qui architecto nihil perferendis molestiae.', 18, '2016-11-10 07:07:16'),
(398, 77, 'comment', 'Rerum et voluptatem excepturi at quos voluptatem.', 20, '2016-11-03 02:51:01'),
(399, 78, 'comment', 'Minus ullam reiciendis similique sit.', 8, '2016-11-15 14:04:54'),
(400, 78, 'comment', 'Repellendus molestiae praesentium incidunt maxime.', 7, '2016-10-28 00:12:18'),
(401, 78, 'comment', 'Repellendus totam neque provident consequuntur sit sed quod.', 3, '2016-10-20 03:51:14'),
(402, 78, 'comment', 'Quos nam in qui rerum.', 15, '2016-10-21 09:19:10'),
(403, 78, 'comment', 'Unde eligendi laboriosam maxime.', 18, '2016-11-11 08:38:49'),
(404, 78, 'comment', 'Ea eos et aliquam mollitia quaerat est velit.', 17, '2016-11-06 22:41:33'),
(405, 78, 'comment', 'Dolores sapiente incidunt earum consequatur dolore.', 7, '2016-11-02 14:26:33'),
(406, 78, 'comment', 'Non voluptates esse exercitationem dolorem aperiam amet in.', 4, '2016-10-27 02:14:30'),
(407, 79, 'comment', 'Incidunt asperiores autem in.', 14, '2016-11-04 18:46:47'),
(408, 79, 'comment', 'Consequatur et unde est ut.', 12, '2016-11-06 14:06:38'),
(409, 79, 'comment', 'Sequi molestiae vero enim molestiae sit commodi et qui.', 10, '2016-11-05 17:52:03'),
(410, 79, 'comment', 'Accusamus quas veniam placeat eum ut aut qui.', 15, '2016-10-27 17:30:05'),
(411, 79, 'comment', 'Excepturi qui quis molestias qui voluptas ducimus.', 19, '2016-10-20 23:24:11'),
(412, 79, 'comment', 'Aut totam ratione reprehenderit in debitis vitae laborum.', 9, '2016-10-28 08:24:38'),
(413, 80, 'comment', 'Nihil officia aliquid provident et quas est vitae laudantium.', 4, '2016-11-07 09:49:17'),
(414, 80, 'comment', 'Voluptas et laboriosam quia voluptatibus omnis cum suscipit cum.', 15, '2016-11-10 21:48:25'),
(415, 80, 'comment', 'Expedita id vel voluptatum aperiam qui illo quia vel.', 10, '2016-10-23 11:34:07'),
(416, 80, 'comment', 'Magni ut ex porro temporibus dolorum dolor.', 16, '2016-11-07 14:57:41'),
(417, 80, 'comment', 'Tempore neque voluptas dolore consectetur odio ut dignissimos.', 14, '2016-11-03 12:04:52'),
(418, 80, 'comment', 'Non dolorem aperiam velit consequatur quasi repellendus.', 20, '2016-10-30 14:00:57'),
(419, 80, 'comment', 'Recusandae odit et illo dicta.', 13, '2016-11-16 11:05:05'),
(420, 81, 'comment', 'Autem dignissimos odio aut nobis quaerat.', 12, '2016-10-22 23:29:39'),
(421, 81, 'comment', 'Possimus id commodi voluptas sint voluptatibus.', 14, '2016-10-21 06:42:01'),
(422, 81, 'comment', 'Sit magnam consectetur et architecto impedit aut quasi.', 16, '2016-11-04 13:23:29'),
(423, 81, 'comment', 'Alias corporis ducimus doloribus nostrum et.', 7, '2016-11-08 09:52:41'),
(424, 82, 'comment', 'Possimus ut illo modi.', 21, '2016-10-29 04:09:30'),
(425, 82, 'comment', 'Nobis vero maiores aliquid et officia.', 21, '2016-11-06 19:18:07'),
(426, 82, 'comment', 'Quia dolorem nihil inventore alias perspiciatis temporibus ea.', 15, '2016-11-07 23:50:16'),
(427, 82, 'comment', 'Fugit qui optio ut.', 15, '2016-11-02 00:57:40'),
(428, 83, 'comment', 'Temporibus vero in dolorum blanditiis.', 22, '2016-10-20 16:46:31'),
(429, 83, 'comment', 'Delectus vero illum reprehenderit itaque.', 21, '2016-10-30 21:08:56'),
(430, 83, 'comment', 'Quisquam molestiae dignissimos eveniet.', 16, '2016-11-04 06:55:34'),
(431, 83, 'comment', 'Qui consequuntur assumenda vel perferendis qui.', 17, '2016-11-03 09:33:39'),
(432, 83, 'comment', 'Tempore qui ut ut qui.', 11, '2016-11-05 23:38:37'),
(433, 83, 'comment', 'Ea architecto modi ratione autem iste ad.', 19, '2016-11-01 01:49:37'),
(434, 84, 'comment', 'Iusto ut facilis nam pariatur.', 13, '2016-10-23 00:57:24'),
(435, 84, 'comment', 'Quasi repellat est asperiores cupiditate.', 19, '2016-10-19 15:54:22'),
(436, 84, 'comment', 'Dolore omnis dolores eum nemo quam debitis.', 22, '2016-11-11 02:33:11'),
(437, 84, 'comment', 'Corporis maiores nemo culpa optio porro quis illum id.', 4, '2016-10-23 15:41:53'),
(438, 84, 'comment', 'Harum accusantium harum optio natus.', 22, '2016-10-25 21:16:39'),
(439, 85, 'comment', 'Nulla ut aspernatur autem cupiditate.', 18, '2016-11-11 15:19:27'),
(440, 85, 'comment', 'Ab quos quia est suscipit molestiae.', 7, '2016-10-26 12:56:51'),
(441, 85, 'comment', 'Rerum quia iure maxime enim molestiae.', 7, '2016-10-29 12:01:40'),
(442, 85, 'comment', 'Et rerum dignissimos possimus repellendus.', 14, '2016-11-09 04:30:55'),
(443, 85, 'comment', 'Minima ut veniam optio voluptatem et.', 17, '2016-10-19 02:30:45'),
(444, 85, 'comment', 'At natus voluptatem a placeat.', 12, '2016-11-04 00:58:13'),
(445, 85, 'comment', 'Qui inventore asperiores soluta sequi eligendi veritatis deserunt velit.', 19, '2016-10-19 04:15:52'),
(446, 86, 'comment', 'Corporis similique unde eos consequatur praesentium quidem.', 15, '2016-10-29 02:52:17'),
(447, 86, 'comment', 'Illum non eos quia voluptas impedit.', 21, '2016-10-23 19:42:30'),
(448, 86, 'comment', 'Dicta quo harum et culpa.', 4, '2016-11-09 18:14:58'),
(449, 86, 'comment', 'Exercitationem itaque hic laboriosam dolores.', 17, '2016-11-08 20:20:16'),
(450, 86, 'comment', 'Et quaerat dignissimos quas reiciendis aut quasi quibusdam earum.', 12, '2016-11-10 22:27:08'),
(451, 87, 'comment', 'Ratione quibusdam maxime iusto culpa in omnis consequatur.', 5, '2016-11-16 10:03:32'),
(452, 87, 'comment', 'Libero aut soluta aut dignissimos optio culpa ut.', 4, '2016-11-09 16:00:24'),
(453, 87, 'comment', 'Commodi est et qui inventore aut ullam.', 3, '2016-11-12 22:35:39'),
(454, 87, 'comment', 'Eos dolores aut accusamus totam ut vitae qui.', 8, '2016-11-17 08:48:19'),
(455, 87, 'comment', 'Omnis id saepe mollitia libero numquam assumenda enim.', 8, '2016-10-31 06:04:21'),
(456, 88, 'comment', 'Esse id in est voluptatem a amet aut.', 17, '2016-10-18 18:07:52'),
(457, 88, 'comment', 'Totam mollitia doloribus et voluptatem voluptates.', 4, '2016-11-10 10:59:06'),
(458, 88, 'comment', 'Quasi et dolor minus.', 14, '2016-10-24 17:08:12'),
(459, 89, 'comment', 'Voluptas quidem optio quae aut quas laboriosam.', 14, '2016-11-06 22:32:58'),
(460, 89, 'comment', 'Animi perspiciatis qui blanditiis accusantium.', 13, '2016-10-24 21:09:58'),
(461, 89, 'comment', 'Officiis aliquid et est incidunt repellat nesciunt.', 10, '2016-10-31 16:35:06'),
(462, 89, 'comment', 'Est rerum et veniam esse sed neque.', 22, '2016-11-11 10:48:15'),
(463, 89, 'comment', 'Eveniet iusto in consequatur facilis vel eveniet.', 17, '2016-11-08 16:11:08'),
(464, 89, 'comment', 'Voluptatem dolor impedit autem aperiam non.', 12, '2016-10-18 12:34:10'),
(465, 89, 'comment', 'Et deserunt omnis minus repellendus quia blanditiis.', 5, '2016-10-29 18:30:25'),
(466, 89, 'comment', 'Aut et odio ea nihil nisi.', 11, '2016-11-12 10:52:50'),
(467, 90, 'comment', 'Sunt reiciendis perferendis quis consequatur et labore.', 16, '2016-10-28 10:29:28'),
(468, 90, 'comment', 'Aut sint minus et consequatur dolorum voluptatem.', 11, '2016-11-08 05:54:46'),
(469, 90, 'comment', 'Repellendus voluptatem aut praesentium quas magnam quia quo.', 4, '2016-10-28 15:36:46'),
(470, 90, 'comment', 'Quos omnis mollitia quia vitae molestias nostrum.', 6, '2016-11-17 21:59:11'),
(471, 90, 'comment', 'Ullam qui corporis alias laboriosam beatae nisi aut.', 9, '2016-11-09 09:56:25'),
(472, 91, 'comment', 'Dolor sapiente atque suscipit consequuntur aut est.', 6, '2016-10-19 23:15:34'),
(473, 91, 'comment', 'Illum fugit est in voluptatem expedita.', 18, '2016-10-24 05:09:55'),
(474, 91, 'comment', 'Aut enim tempora dolorum distinctio.', 2, '2016-11-08 02:03:08'),
(475, 91, 'comment', 'Sapiente qui in rerum at sit.', 10, '2016-10-24 21:07:28'),
(476, 91, 'comment', 'Illum incidunt ea architecto.', 3, '2016-10-23 02:19:00'),
(477, 91, 'comment', 'Eum ipsam vero error perspiciatis incidunt ducimus nulla.', 21, '2016-10-30 07:18:06'),
(478, 91, 'comment', 'Esse aut dolorem sapiente nobis ratione.', 5, '2016-11-14 21:07:49'),
(479, 92, 'comment', 'Voluptate quaerat possimus culpa nemo hic quae sed.', 8, '2016-11-16 09:08:40'),
(480, 92, 'comment', 'Dolorem qui ipsa quod consequatur ut molestiae ea officia.', 15, '2016-10-24 13:16:11'),
(481, 92, 'comment', 'Fugit porro voluptatem non.', 15, '2016-11-14 08:52:17'),
(482, 92, 'comment', 'Laboriosam alias sed commodi similique magnam voluptas ut.', 20, '2016-11-08 02:05:50'),
(483, 93, 'comment', 'Voluptates nulla quod et non doloremque.', 6, '2016-10-18 23:38:40'),
(484, 93, 'comment', 'Iusto voluptatum amet molestiae placeat doloremque ut sit.', 22, '2016-11-06 06:44:07'),
(485, 93, 'comment', 'Architecto rerum laborum est rerum aliquid.', 22, '2016-11-16 12:13:57'),
(486, 93, 'comment', 'Ut totam corporis reiciendis quia.', 2, '2016-10-19 18:36:20'),
(487, 94, 'comment', 'Quasi molestiae aut dolores adipisci iusto et.', 21, '2016-11-16 21:30:33'),
(488, 94, 'comment', 'Sit aspernatur sapiente neque dignissimos pariatur rerum quo.', 8, '2016-11-15 07:21:46'),
(489, 94, 'comment', 'Necessitatibus sit odio quia officiis.', 21, '2016-11-06 11:49:48'),
(490, 94, 'comment', 'Iste dolorum et atque eum distinctio.', 11, '2016-11-08 23:07:27'),
(491, 94, 'comment', 'Perspiciatis rem maxime sint.', 8, '2016-11-05 19:33:25'),
(492, 94, 'comment', 'Perferendis vitae est et et possimus.', 14, '2016-11-03 09:21:10'),
(493, 95, 'comment', 'Omnis sapiente autem animi harum amet.', 2, '2016-11-17 03:23:58'),
(494, 95, 'comment', 'Quas animi nisi inventore dolores laboriosam in ut.', 7, '2016-11-04 11:29:39'),
(495, 95, 'comment', 'Pariatur nihil voluptate voluptatem at incidunt maxime.', 22, '2016-11-12 00:15:30'),
(496, 95, 'comment', 'Omnis odio veniam facilis dolores ratione quasi tempora ut.', 10, '2016-11-05 10:56:14'),
(497, 95, 'comment', 'Sit iusto excepturi amet iste molestiae.', 9, '2016-11-05 03:51:52'),
(498, 96, 'comment', 'Reprehenderit autem adipisci et vero fugit et ratione.', 8, '2016-10-29 12:59:27'),
(499, 96, 'comment', 'Accusantium rerum sint nihil aliquid eos quia asperiores aliquam.', 21, '2016-11-12 05:02:02'),
(500, 96, 'comment', 'Laborum aut et voluptatum voluptatem aliquam.', 14, '2016-11-01 23:49:16'),
(501, 97, 'comment', 'Ad voluptatem enim neque vitae et at in.', 6, '2016-10-24 22:29:03'),
(502, 97, 'comment', 'Et nisi nam ut impedit esse repellendus.', 6, '2016-10-20 15:21:38'),
(503, 97, 'comment', 'Eos accusantium et similique voluptas sequi qui beatae.', 6, '2016-11-07 13:03:42'),
(504, 97, 'comment', 'Voluptatem voluptatem libero et.', 21, '2016-11-02 07:09:13'),
(505, 97, 'comment', 'Et amet omnis non architecto.', 8, '2016-10-26 15:32:41'),
(506, 98, 'comment', 'Accusantium nesciunt assumenda veniam maiores fugit odio.', 17, '2016-11-01 01:01:34'),
(507, 98, 'comment', 'Qui rerum distinctio porro ut quisquam.', 16, '2016-11-14 03:16:43'),
(508, 98, 'comment', 'Hic aut consequatur a beatae minima neque.', 16, '2016-10-29 18:15:03'),
(509, 98, 'comment', 'Et aut commodi molestiae eum voluptatem.', 8, '2016-10-19 15:29:46'),
(510, 98, 'comment', 'Corrupti vel dolorum qui est laboriosam quis at.', 4, '2016-11-08 15:37:30'),
(511, 98, 'comment', 'Quo et sint laborum dicta.', 17, '2016-11-11 06:57:01'),
(512, 99, 'comment', 'Et omnis id sed velit tenetur velit.', 22, '2016-11-02 04:27:29'),
(513, 99, 'comment', 'Voluptatum ut quia vel itaque.', 18, '2016-11-07 15:21:44'),
(514, 99, 'comment', 'Asperiores reprehenderit nesciunt facilis.', 22, '2016-11-06 03:14:27'),
(515, 99, 'comment', 'Exercitationem delectus architecto nemo qui exercitationem.', 3, '2016-11-12 02:31:33'),
(516, 99, 'comment', 'Debitis minus sit voluptatem velit nulla id.', 6, '2016-10-22 02:02:00'),
(517, 99, 'comment', 'Nostrum ut sint iusto eos odit ea quis.', 7, '2016-10-20 21:19:48'),
(518, 100, 'comment', 'Aut quae assumenda quis qui consequatur.', 11, '2016-10-24 03:32:43'),
(519, 100, 'comment', 'Quia laboriosam est quidem quia.', 2, '2016-10-29 09:50:41'),
(520, 100, 'comment', 'Quis saepe vitae repudiandae sed.', 3, '2016-11-07 05:04:49'),
(521, 100, 'comment', 'Quisquam dolore quod qui eos placeat facere commodi unde.', 12, '2016-10-26 03:57:49'),
(522, 102, 'comment', 'po', 2, '2016-12-02 06:49:47');

-- --------------------------------------------------------

--
-- Table structure for table `property_replacement`
--

CREATE TABLE `property_replacement` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `target_property_id` int(11) NOT NULL,
  `status` varchar(45) NOT NULL DEFAULT 'pending',
  `requested_by` int(11) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `company_id` int(11) NOT NULL,
  `date_updated` datetime DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property_replacement`
--

INSERT INTO `property_replacement` (`id`, `property_id`, `target_property_id`, `status`, `requested_by`, `comment`, `company_id`, `date_updated`, `date_created`) VALUES
(5, 95, 100, 'replaced_all', 1, 'ALL', 1, '2016-12-20 06:58:15', '2016-12-15 08:35:18'),
(7, 128, 5, 'replaced_all', 2, 'All', 1, '2016-12-20 09:12:28', '2016-12-20 08:06:26'),
(11, 133, 123, 'replaced_all', 2, 'Test', 1, '2016-12-20 09:57:21', '2016-12-20 08:56:59'),
(12, 139, 134, 'pending', 2, '', 1, NULL, '2016-12-22 06:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(200) NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `deleted`, `company_id`) VALUES
(1, 'Super Admin', 'Admin of Direct Mail', 0, 0),
(3, 'Administrator', 'Can handle all modules in a certain company.', 0, 1),
(4, 'Basic', 'Handles only basic features.', 0, 1),
(7, 'Sample Role', 'Test', 1, 1),
(8, 'Admin', 'Test', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `roles_list_category_permission`
--

CREATE TABLE `roles_list_category_permission` (
  `id` int(11) NOT NULL,
  `list_category_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `create_action` tinyint(4) NOT NULL DEFAULT '0',
  `retrieve_action` tinyint(4) NOT NULL DEFAULT '1',
  `update_action` tinyint(4) NOT NULL DEFAULT '0',
  `delete_action` tinyint(4) NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles_list_category_permission`
--

INSERT INTO `roles_list_category_permission` (`id`, `list_category_id`, `role_id`, `create_action`, `retrieve_action`, `update_action`, `delete_action`, `last_update`) VALUES
(1, 1, 3, 1, 1, 1, 1, '2016-11-09 01:00:05'),
(2, 2, 3, 1, 1, 1, 1, '2016-12-21 00:25:48'),
(3, 3, 3, 1, 1, 1, 1, '2016-12-21 00:25:48'),
(4, 1, 4, 0, 1, 0, 0, '2016-10-31 21:39:22'),
(5, 2, 4, 0, 1, 0, 0, '2016-10-31 21:39:23'),
(6, 4, 8, 1, 1, 1, 1, '2016-12-22 00:57:14');

-- --------------------------------------------------------

--
-- Table structure for table `roles_list_permission`
--

CREATE TABLE `roles_list_permission` (
  `id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `create_action` tinyint(4) NOT NULL DEFAULT '0',
  `retrieve_action` tinyint(4) NOT NULL DEFAULT '1',
  `update_action` tinyint(4) NOT NULL DEFAULT '0',
  `delete_action` tinyint(4) NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles_list_permission`
--

INSERT INTO `roles_list_permission` (`id`, `list_id`, `role_id`, `create_action`, `retrieve_action`, `update_action`, `delete_action`, `last_update`) VALUES
(7, 1, 3, 1, 1, 1, 1, '2016-12-21 00:25:48'),
(8, 2, 3, 1, 1, 1, 1, '2016-12-21 00:25:48'),
(9, 3, 3, 1, 1, 1, 1, '2016-12-21 00:25:48'),
(10, 1, 4, 0, 1, 0, 0, '2016-10-31 21:39:23'),
(11, 2, 4, 0, 1, 0, 0, '2016-10-31 21:39:23'),
(12, 3, 4, 0, 1, 0, 0, '2016-10-31 21:39:23'),
(13, 10, 3, 1, 1, 1, 1, '2016-12-21 00:25:48');

-- --------------------------------------------------------

--
-- Table structure for table `roles_module_permission`
--

CREATE TABLE `roles_module_permission` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `create_action` tinyint(4) NOT NULL DEFAULT '0',
  `retrieve_action` tinyint(4) NOT NULL DEFAULT '1',
  `update_action` tinyint(4) NOT NULL DEFAULT '0',
  `delete_action` tinyint(4) NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles_module_permission`
--

INSERT INTO `roles_module_permission` (`id`, `module_id`, `role_id`, `create_action`, `retrieve_action`, `update_action`, `delete_action`, `last_update`) VALUES
(83, 1, 3, 1, 1, 1, 1, '2016-12-21 00:26:10'),
(84, 2, 3, 1, 1, 1, 1, '2016-12-21 00:26:10'),
(85, 8, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(86, 14, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(87, 15, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(88, 16, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(89, 17, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(90, 18, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(91, 19, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(92, 20, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(93, 21, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(94, 22, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(95, 23, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(97, 24, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(100, 26, 3, 1, 1, 1, 1, '2016-11-09 00:27:10'),
(101, 1, 4, 0, 1, 0, 0, '2016-10-31 21:35:57'),
(102, 2, 4, 0, 1, 0, 0, '2016-10-31 21:35:57'),
(103, 8, 4, 0, 1, 0, 0, '2016-10-31 21:35:57'),
(104, 14, 4, 0, 1, 0, 0, '2016-10-31 21:35:57'),
(105, 15, 4, 0, 1, 0, 0, '2016-10-31 21:35:57'),
(106, 16, 4, 0, 1, 0, 0, '2016-10-31 21:35:58'),
(107, 17, 4, 0, 1, 0, 0, '2016-10-31 21:35:58'),
(108, 18, 4, 0, 1, 0, 0, '2016-10-31 21:35:58'),
(109, 19, 4, 0, 1, 0, 0, '2016-10-31 21:35:58'),
(110, 20, 4, 0, 1, 0, 0, '2016-10-31 21:35:58'),
(111, 26, 4, 0, 1, 0, 0, '2016-10-31 21:35:58'),
(112, 21, 4, 0, 1, 0, 0, '2016-10-31 21:35:58'),
(113, 22, 4, 0, 1, 0, 0, '2016-10-31 21:35:58'),
(114, 23, 4, 0, 1, 0, 0, '2016-10-31 21:35:58'),
(115, 24, 4, 0, 1, 0, 0, '2016-10-31 21:35:58'),
(116, 27, 3, 1, 1, 0, 1, '2016-12-21 00:26:11'),
(117, 28, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(118, 29, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(119, 30, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(120, 31, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(121, 32, 3, 1, 1, 1, 1, '2016-12-21 00:26:11'),
(122, 1, 8, 1, 1, 1, 1, '2016-12-22 00:16:11'),
(123, 2, 8, 1, 1, 1, 1, '2016-12-22 00:16:11'),
(124, 8, 8, 1, 1, 1, 1, '2016-12-22 00:16:11'),
(125, 29, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(126, 27, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(127, 28, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(128, 32, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(129, 14, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(130, 15, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(131, 16, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(132, 17, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(133, 18, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(134, 19, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(135, 20, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(136, 30, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(137, 21, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(138, 22, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(139, 23, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(140, 24, 8, 1, 1, 1, 1, '2016-12-22 00:16:12'),
(141, 31, 8, 1, 1, 1, 1, '2016-12-22 00:16:12');

-- --------------------------------------------------------

--
-- Table structure for table `secret`
--

CREATE TABLE `secret` (
  `id` int(11) NOT NULL,
  `k` varchar(100) NOT NULL,
  `v` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `secret`
--

INSERT INTO `secret` (`id`, `k`, `v`) VALUES
(1, 'SEND_GRID_API_KEY', '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');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `hash` varchar(150) NOT NULL,
  `created_by` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `name`, `hash`, `created_by`, `company_id`, `date_created`) VALUES
(4, 'Sample Template', 'af9556d36c33c12e0dddf6301940cc6957b731d29a87b78bbcde46d3ab12aaec', 2, 1, '2016-11-25 08:08:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(200) NOT NULL,
  `contact_no` varchar(45) NOT NULL,
  `company_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  `confirmed` tinyint(4) DEFAULT '0',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `first_name`, `last_name`, `contact_no`, `company_id`, `role_id`, `deleted`, `confirmed`, `date_created`) VALUES
(2, 'danero@gmail.com', 'Jordan', 'Cachero', '09162553791', 1, 3, 0, 1, '2016-11-17 07:05:34'),
(3, 'joy.klein@champlin.biz', 'Zella', 'Smitham', '+1-681-680-5884', 1, 0, 0, 1, '2016-11-17 07:05:34'),
(4, 'blanda.kenton@reynolds.com', 'Brianne', 'Kemmer', '987-685-2846 x6963', 1, 0, 0, 1, '2016-11-17 07:05:34'),
(5, 'sroob@hotmail.com', 'Johann', 'Roob', '559-372-6351', 1, 0, 0, 1, '2016-11-17 07:05:34'),
(6, 'hlittel@hotmail.com', 'Noemy', 'Rolfson', '(781) 700-5333 x5570', 1, 0, 0, 1, '2016-11-17 07:05:34'),
(7, 'seth.bayer@yahoo.com', 'Nathan', 'Volkman', '1-484-278-4522 x51954', 1, 0, 0, 1, '2016-11-17 07:05:34'),
(8, 'murray.rowe@hotmail.com', 'Nya', 'Gusikowski', '252-598-0558', 1, 0, 0, 1, '2016-11-17 07:05:34'),
(9, 'janae58@gmail.com', 'Ludie', 'Runte', '1-979-485-5215', 1, 0, 0, 1, '2016-11-17 07:05:35'),
(10, 'aric14@yahoo.com', 'Ludie', 'Haley', '941.335.8692 x407', 1, 0, 0, 1, '2016-11-17 07:05:35'),
(11, 'ybradtke@yahoo.com', 'Erling', 'Conn', '309-213-4437', 1, 0, 0, 1, '2016-11-17 07:05:35'),
(12, 'samara.jast@kilback.com', 'Rosa', 'Nader', '+1-590-868-3653', 1, 0, 0, 1, '2016-11-17 07:05:35'),
(13, 'nwyman@kuphal.info', 'Austen', 'Ziemann', '+1-361-340-4028', 1, 0, 0, 1, '2016-11-17 07:05:35'),
(14, 'brisa.dickens@wisozk.org', 'Tanner', 'Ernser', '734-929-3111 x35197', 1, 0, 0, 1, '2016-11-17 07:05:35'),
(15, 'price.cristian@hotmail.com', 'Evert', 'Denesik', '(773) 801-3164', 1, 0, 0, 1, '2016-11-17 07:05:35'),
(16, 'sibyl.gutmann@barton.info', 'Dorothea', 'Morar', '679-875-4111', 1, 0, 0, 1, '2016-11-17 07:05:35'),
(17, 'klocko.aric@nicolas.biz', 'Mertie', 'Padberg', '1-231-737-1166', 1, 0, 0, 1, '2016-11-17 07:05:35'),
(18, 'frami.greta@gutmann.com', 'Mavis', 'Cartwright', '557.960.7767 x517', 1, 0, 0, 1, '2016-11-17 07:05:35'),
(19, 'okuneva.norbert@gmail.com', 'Lurline', 'Graham', '776-391-2773', 1, 0, 0, 1, '2016-11-17 07:05:35'),
(20, 'allison.oreilly@yahoo.com', 'Cristal', 'Marvin', '292-342-1957 x2476', 1, 0, 0, 1, '2016-11-17 07:05:35'),
(21, 'lockman.lavinia@spinka.org', 'Emilie', 'Gutkowski', '350-590-8203 x5050', 1, 0, 0, 1, '2016-11-17 07:05:36'),
(22, 'zwehner@hotmail.com', 'Pascale', 'Dicki', '+1.662.345.2266', 1, 0, 0, 1, '2016-11-17 07:05:36'),
(23, 'directmail@gmail.com', 'Jordan', 'Cachero', '09162553791', 2, 8, 0, 1, '2016-11-17 07:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `user_list_category_permission`
--

CREATE TABLE `user_list_category_permission` (
  `id` int(11) NOT NULL,
  `list_category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_action` tinyint(4) NOT NULL DEFAULT '0',
  `retrieve_action` tinyint(4) NOT NULL DEFAULT '1',
  `update_action` tinyint(4) NOT NULL DEFAULT '0',
  `delete_action` tinyint(4) NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_list_category_permission`
--

INSERT INTO `user_list_category_permission` (`id`, `list_category_id`, `user_id`, `create_action`, `retrieve_action`, `update_action`, `delete_action`, `last_update`) VALUES
(1, 1, 2, 0, 0, 0, 0, '2016-11-09 21:54:17'),
(2, 2, 2, 1, 1, 1, 1, '2016-11-09 21:54:17'),
(3, 1, 20, 0, 1, 1, 0, '2016-11-01 01:01:39'),
(4, 2, 20, 1, 1, 1, 0, '2016-11-09 23:40:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_list_permission`
--

CREATE TABLE `user_list_permission` (
  `id` int(11) NOT NULL,
  `list_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_action` tinyint(4) NOT NULL DEFAULT '0',
  `retrieve_action` tinyint(4) NOT NULL DEFAULT '1',
  `update_action` tinyint(4) NOT NULL DEFAULT '0',
  `delete_action` tinyint(4) NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_list_permission`
--

INSERT INTO `user_list_permission` (`id`, `list_id`, `user_id`, `create_action`, `retrieve_action`, `update_action`, `delete_action`, `last_update`) VALUES
(1, 1, 2, 1, 1, 0, 0, '2016-11-09 21:54:17'),
(2, 2, 2, 1, 1, 1, 1, '2016-11-09 21:54:17'),
(3, 3, 2, 1, 1, 0, 0, '2016-11-03 00:57:58'),
(4, 1, 20, 0, 1, 1, 0, '2016-11-09 23:40:16'),
(5, 2, 20, 0, 1, 1, 0, '2016-11-09 23:40:16'),
(6, 3, 20, 0, 1, 1, 0, '2016-11-09 23:40:16'),
(7, 9, 2, 1, 1, 1, 1, '2016-11-10 06:06:43'),
(8, 9, 20, 0, 0, 0, 0, '2016-11-09 23:40:16'),
(9, 10, 20, 1, 1, 1, 1, '2016-11-10 06:41:35'),
(10, 11, 2, 1, 1, 1, 1, '2016-11-18 06:56:54'),
(11, 12, 2, 1, 1, 1, 1, '2016-11-18 07:02:50'),
(12, 13, 23, 1, 1, 1, 1, '2016-12-22 07:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_module_permission`
--

CREATE TABLE `user_module_permission` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_action` tinyint(4) NOT NULL DEFAULT '0',
  `retrieve_action` tinyint(4) NOT NULL DEFAULT '1',
  `update_action` tinyint(4) NOT NULL DEFAULT '0',
  `delete_action` tinyint(4) NOT NULL DEFAULT '0',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_module_permission`
--

INSERT INTO `user_module_permission` (`id`, `module_id`, `user_id`, `create_action`, `retrieve_action`, `update_action`, `delete_action`, `last_update`) VALUES
(1, 1, 2, 0, 1, 0, 0, '2016-11-01 00:20:07'),
(2, 2, 2, 0, 1, 0, 0, '2016-11-01 00:20:07'),
(3, 8, 2, 0, 1, 0, 0, '2016-11-01 00:20:07'),
(4, 14, 2, 0, 1, 0, 0, '2016-11-01 00:20:07'),
(5, 15, 2, 1, 1, 1, 0, '2016-11-01 00:20:07'),
(6, 16, 2, 0, 1, 0, 0, '2016-11-01 00:20:07'),
(7, 17, 2, 0, 1, 0, 1, '2016-11-01 00:20:07'),
(8, 18, 2, 0, 1, 1, 0, '2016-11-01 00:20:07'),
(9, 19, 2, 0, 1, 1, 0, '2016-11-01 00:20:07'),
(10, 20, 2, 0, 1, 0, 0, '2016-11-01 00:20:07'),
(11, 26, 2, 0, 1, 1, 0, '2016-11-01 00:20:07'),
(12, 21, 2, 1, 1, 0, 1, '2016-11-01 00:20:07'),
(13, 22, 2, 0, 1, 0, 0, '2016-11-01 00:20:07'),
(14, 23, 2, 0, 1, 0, 0, '2016-11-01 00:20:07'),
(15, 24, 2, 0, 1, 0, 0, '2016-11-01 00:20:07'),
(16, 1, 20, 1, 1, 1, 1, '2016-11-01 01:01:37'),
(17, 2, 20, 1, 1, 1, 1, '2016-11-01 01:01:37'),
(18, 8, 20, 1, 1, 1, 1, '2016-11-01 01:01:37'),
(19, 14, 20, 0, 1, 0, 1, '2016-11-01 01:01:37'),
(20, 15, 20, 1, 1, 1, 1, '2016-11-01 01:01:37'),
(21, 16, 20, 1, 1, 1, 1, '2016-11-01 01:01:37'),
(22, 17, 20, 1, 1, 1, 1, '2016-11-01 01:01:37'),
(23, 18, 20, 1, 1, 1, 1, '2016-11-01 01:01:37'),
(24, 19, 20, 1, 1, 1, 1, '2016-11-01 01:01:37'),
(25, 20, 20, 1, 1, 1, 1, '2016-11-01 01:01:37'),
(26, 26, 20, 1, 1, 1, 1, '2016-11-01 01:01:37'),
(27, 21, 20, 1, 1, 1, 1, '2016-11-01 01:01:37'),
(28, 22, 20, 1, 1, 1, 1, '2016-11-01 01:01:37'),
(29, 23, 20, 1, 1, 1, 1, '2016-11-01 01:01:37'),
(30, 24, 20, 1, 1, 1, 1, '2016-11-01 01:01:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_secret`
--

CREATE TABLE `user_secret` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `password` varchar(300) NOT NULL,
  `confirmation_key` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_secret`
--

INSERT INTO `user_secret` (`id`, `user_id`, `password`, `confirmation_key`) VALUES
(1, 2, 'qbThldWIQMTdI', 'oO3p5qzA82lEURHYILgcT1x6W7M9auv4KnFeNfwhXdt0CJsQyPBmkbDVjZGSri'),
(19, 20, 'XkaaypkHH5G/6', 'rX6Ux3YpCmK8PVJnb0QIeN2sDtOZMRkd1igjqGu75WEyfvwaFlhLB9AHozTc4S'),
(20, 2, 'w6Fwi9tAtmzn6', 'xhfolHjZOW4TABs6taYXd3pJ2kb70DwyGvNVcLq8U9RFEI5iKQgrM1uPnmezCS'),
(21, 2, 'TlRtrbcQdUpYQ', '6OamdhoTDHPRAXy5C7JGpVYIq19nLxubFfNzMi4ZUwsrE0jKvgS23l8eWkctBQ'),
(22, 2, 'wThpYd24ReF2g', '2YLTPpJMI9kDa1zBeqyg64ls5hVEr87fdjHRFK0boANntiXGUCmZcQOu3vxSWw'),
(23, 2, 'Fl6jtGm2Ri7aM', '3qaCpd2or6X9lZbTDsxzn0GQSgMRYIv1wfWiPJHyuVcj7U8LeKEFtkhAN5mOB4'),
(24, 3, 'wIx5u2q5EN7YM', 'mqLZN91V6DK38xioMagJWBUjuSvfkt7EzGIcA2yYFPebTpHdlnXshCw5Q40rRO'),
(25, 4, '14oAIZehXU2Rg', 'B1ARXSu3zw8jYQOq45ainxCDUVFrtgvlkGNZemhEb7pc9PdMs6y0f2oJIKHLTW'),
(26, 5, 'oLm8Qt4yJGb5g', '0Dwv2Rt4ofGcag5yKh8szbmiT7PeWCdLpMlBqZxF9IUQOHruYEVN6SXAnjkJ13'),
(27, 6, 'FGGErHwrtUd0g', '3T4ZFOerfCaUgK0EGPkNRDJxL72lvtWshXBbj68yM9pYI5oHViQnuS1dmAqwzc'),
(28, 7, 'YbCsz1Icgs6Qk', 'BQKW0J4RkwVMDhg1jm9c8T7NPizbH5YyvrZt6uSaIEs3UqCf2lLoeGnxApXdOF'),
(29, 8, 'parqm8GwAURgM', '9v5YXA3hS8Dm7sgKbxGyiZBEtwjQWcnp6JVPIuNrLoTqlM41O0eCkUf2aRdFzH'),
(30, 9, 'XNg56N0G9sIxQ', 'x1ILcwXETQmK34osCMOWaehP8UlujAZgDV9vJtYGBbRiF2q7zSynp6kHNr5d0f'),
(31, 10, 'uejFtr.dna3Tw', 'gdGcpVBbmXwjFEY9AoWCMf13rTQSD42vKxPi0ulet5Uy6Izq8HROaZNJ7shknL'),
(32, 11, 'G3BAus5oQZL0A', '8ktJ9LfbKBhYDOEd7zyNc1saZ4VPgXqwSmv3n5ojUHFG0lepCirAWQ6uI2RxMT'),
(33, 12, 'qDVAs77pVvwD.', '8RTib4ajXnkYKqoupcJSdQyxhvmAt1PIU09Nr23Cg7LVHGwsFZeBOM6zDEl5Wf'),
(34, 13, 'M5A9foros1iag', 'BSGQRlcXJuCL17OF3PaIW6w0VnrsxpgHDYhtkie5f8o4zNKZmj2vqMUEyd9ATb'),
(35, 14, '6D624yHTSDUUU', 'f4FJ2zaWBR0gujkNpsmHlZiQ8OTwIMdEqSDKbGc3XoUPhVtxe9r57yA6YnC1Lv'),
(36, 15, 'w4Fg897ZoFSmU', 'i7nHQ4uhapjXzZoGRCyEO9DT8wKfId1SrqNV3YtgWMFsmJ5vlU6Pc0kA2BLbxe'),
(37, 16, 'k9ynwesEEkkgQ', '2IJSxk6GLOoPcg5fleKsrWpUDz9uw7dT3avbnVhy4t8XiqB0YEZACNFj1RQHMm'),
(38, 17, 'NOuXDbPvGXM6w', 'ZRU7ygT8xjw5sPFXVqA4hmtevMOD139Sdo2HIJY6f0pGBzQuKncaLNWbkliErC'),
(39, 18, 'DOfba.gXJvn7s', 'CAXbFTGZncKkjf5U3vyIWNBtosOg1YErzpD07LQxmeVqJlMRH29w8S4Pd6hiua'),
(40, 19, '0au0gw0WB/9rI', 'sxPKwXvpqhe3yLMm5dAl6atGFY79fIo8jJg2UEZuHNiW0Q1nzbk4TBSDcVCROr'),
(41, 20, 'YqgrQZG3ptfOk', 'sZ7uWXG8OKV6hd350jDeckLtIaFySHEqvJCgzrw4ABfUp192YbomnTNQRixlPM'),
(42, 21, '7XDE5O494xKf2', 'uVGk5g6M1PHSy9dCtFBYmJ7KvQ48rjfWRcpXAws0qhEIxDb3Ll2UoNeTOzZani'),
(43, 22, 'iugV/CprjqSJE', 'dlrAIFv49L2eOpDCiyzo8qVZHBRKhkY5uM3JfT0bGXQE7sgnxatc1PNS6mUWjw'),
(44, 2, 'hk6xdw0tuFucA', '9kQD6C4E7WTr5ypSFoN8MGXabLwOeJH1xldZnst0vfVzUiBq3c2jgIRPKuAYmh'),
(45, 3, 'oAp1wKP6Nx1Pg', 'blGy87ktv1OLNWC5e4noDgiVpAJ3ImxzU2ShdXMwPauYBE0FfcsKZr9QTj6qHR'),
(46, 4, 'SwkODJXwhvGL2', 'gaw6DFA3BIl1o7k52tSKqd9WcVHUOh0iLY8TJrnfGCspQbXvMZRePmEy4xNjzu'),
(47, 5, 'V4q0cZTwV9iKc', '7ZP6FpU38krfqlb1D4WCYmTogwsiILtezuHRAG2QdxycKaENBj0JnMv5VShXO9'),
(48, 6, 'QCPsigtr0bev6', 'dE9j3W2MPSOQAFTpcoXvlsfICBYbK0VDZw8xLReJtgU6G71mrz5hiNukyanH4q'),
(49, 7, 'XWofd3z9rZZL.', 'ImJ6Wxf5nVFaOP97E0sLvBGtgqe83UMKN4YHuCyip2oTbwjRcrAlzDZX1QhSkd'),
(50, 8, 'D9WIgZ1cEWHiY', 'wCog3inbc9EsRuJAH1TV6e0D5X82daqMrNWmkyf4jvGZPQOzlpIBtYFLSh7KUx'),
(51, 9, '9t8xxa0rRxx9U', 'ueL8am3OVECrQHGwZ6NjWTsMlbk1zYhxDSinJAKyXIq2UpBt7Pdo4cg0vRF95f'),
(52, 10, '4NwDywFjsoRSo', '6L0buEzOCkRGaBgfqvsIDQ8iUZFNAycHY3TrJmWe1jn5pt2wxV4S7P9hXoldKM'),
(53, 11, 'Zaa5O1W/5m.KA', 'f817UtvHSNEYDMpJgxaOiKVW3IFCmnu4Z69TLsywQR2GPkqzdjBr05hbleAcoX'),
(54, 12, 'QWAVR.mc77j6s', '2geW8Fitd9znporIl7DRTK1j4BwYACbQ6xyMGh5J0mXkSVPLHvuNcOaq3sUfZE'),
(55, 13, 'wvAtKAEIa7K6.', 'FSqW9X3yZpYj7aUK5e6OnRhHGDd4PToulxQbgksJcIi1AtEVLNCrfvm0Mwz28B'),
(56, 14, 'hFvsAAcGLKAmg', '2Nn8oWOwJBY9QfGy0LKDTzkb4a56p3gEMUSrPF1dIhvmjqtHZiRXlCxusVeAc7'),
(57, 15, 'VsBh8qa3DDr0g', 'yBcr8b5HVd2FZzxnQglpEWwTfuIqiALsS1MGP04NY9UvtCah3ojOek7mJXK6DR'),
(58, 16, '3WRkFAQtC0wak', '0ViDo8NtKxXrIWBvhAdf4ELw27cskpUgqmaJGMlRQ1nObST63yjzFZHe9P5YuC'),
(59, 17, 'mbAoOBT5dHS66', 'lhgx5Cs8vzo6rJa2DXSkn97N1MujiqcEe3tpQT4PdR0WHOAfZUbFGBVLwyImKY'),
(60, 18, 'Dqa2REOdXojEc', 'zq0htYjUXfrWpLd2s5FVKgmO3kZ6iEebTuInyalxPCQ1cSoHA4GvRNwJ7BMD89'),
(61, 19, 'vb12AifOeRMDU', 'T3ODLuYwJV6xMUGtkAg2I8a1W7nSQcrzZCqiERHP94BdKs5mlvXpbfoh0eyjNF'),
(62, 20, 'Pfj.eOzwZmnSA', 'K5F61GevJhwzQy28lu7nCq94BLRrm3EDVSxZMkfpYUbjsWtIToNAOHiP0dXgca'),
(63, 21, 'StDTSbhV3otDA', '5wxHDEKRBk0pbINr7SvuVUYhtAcLze3oOlgQ4ayZWn2sM6XdG9m1jiCfqJPTF8'),
(64, 22, 'pWW/m6cI3N83Q', 'CLPJSqf14EoITGruc6Abam8gU0pNHxtF32eVdvzQswhjZBlk9RXynYWKO7M5iD'),
(65, 23, 'qbThldWIQMTdI', 'oO3p5qzA82lEURHYILgcT1x6W7M9auv4KnFeNfwhXdt0CJsQyPBmkbDVjZGSri');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abbreviations`
--
ALTER TABLE `abbreviations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_bullet_point`
--
ALTER TABLE `list_bullet_point`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_category`
--
ALTER TABLE `list_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_paragraph`
--
ALTER TABLE `list_paragraph`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `list_testimonial`
--
ALTER TABLE `list_testimonial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property`
--
ALTER TABLE `property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_comment`
--
ALTER TABLE `property_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_replacement`
--
ALTER TABLE `property_replacement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_list_category_permission`
--
ALTER TABLE `roles_list_category_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_list_permission`
--
ALTER TABLE `roles_list_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles_module_permission`
--
ALTER TABLE `roles_module_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `secret`
--
ALTER TABLE `secret`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_list_category_permission`
--
ALTER TABLE `user_list_category_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_list_permission`
--
ALTER TABLE `user_list_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_module_permission`
--
ALTER TABLE `user_module_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_secret`
--
ALTER TABLE `user_secret`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abbreviations`
--
ALTER TABLE `abbreviations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `list`
--
ALTER TABLE `list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `list_bullet_point`
--
ALTER TABLE `list_bullet_point`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `list_category`
--
ALTER TABLE `list_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `list_paragraph`
--
ALTER TABLE `list_paragraph`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `list_testimonial`
--
ALTER TABLE `list_testimonial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `property`
--
ALTER TABLE `property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;
--
-- AUTO_INCREMENT for table `property_comment`
--
ALTER TABLE `property_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=523;
--
-- AUTO_INCREMENT for table `property_replacement`
--
ALTER TABLE `property_replacement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `roles_list_category_permission`
--
ALTER TABLE `roles_list_category_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `roles_list_permission`
--
ALTER TABLE `roles_list_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `roles_module_permission`
--
ALTER TABLE `roles_module_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;
--
-- AUTO_INCREMENT for table `secret`
--
ALTER TABLE `secret`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `user_list_category_permission`
--
ALTER TABLE `user_list_category_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_list_permission`
--
ALTER TABLE `user_list_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `user_module_permission`
--
ALTER TABLE `user_module_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `user_secret`
--
ALTER TABLE `user_secret`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2023 at 08:31 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `transfermax_v3`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `username`, `email`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'admin@gmail.com', '6204f90bd1b001644493067.jpg', '$2y$10$5POucmxCmAhAth5EZ3UReuqG0p1LhmqcU.VtF8CqA6U7tiVfSDSnq', 'P9ehaHbxkd8NdgUgBm5XAFm9lB17pAXkdEhhxZLk5I1eHxGqbE2hPhoBCqv0', '2022-01-19 21:51:47', '2022-02-27 08:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `blog_id` int(19) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rate` decimal(28,8) NOT NULL,
  `charge` decimal(28,8) NOT NULL,
  `charge_type` tinyint(1) NOT NULL COMMENT '0=> fixed, 1=> percent\r\n',
  `min` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `max` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `country`, `name`, `image`, `rate`, `charge`, `charge_type`, `min`, `max`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bangladesh', 'BDT', '62f8c48db32681660470413.png', '89.00000000', '5.00000000', 1, '0.00000000', '0.00000000', 1, '2022-07-16 04:23:39', '2022-09-13 08:48:39'),
(2, 'United States', 'USD', '62f8c488df1f41660470408.png', '1.00000000', '5.00000000', 0, '0.00000000', '0.00000000', 1, '2022-07-16 04:52:10', '2022-08-14 03:46:48'),
(5, 'Anguilla', 'XCD', '62f8c4766c4351660470390.png', '50.00000000', '2.00000000', 0, '0.00000000', '0.00000000', 1, '2022-08-03 12:15:35', '2022-08-14 03:46:30'),
(14, 'Brazil', 'BRL', '63202c43d057e1663052867.png', '5.09000000', '3.00000000', 0, '0.00000000', '0.00000000', 1, '2022-09-13 05:07:47', '2022-09-13 05:07:47'),
(18, 'Cameroon', 'XAF', '63202dde66bca1663053278.jpg', '647.19000000', '2.00000000', 0, '0.00000000', '0.00000000', 1, '2022-09-13 05:14:38', '2022-09-13 05:14:38'),
(31, 'India', 'INR', '6320316c3bb821663054188.png', '79.13000000', '1.00000000', 0, '0.00000000', '0.00000000', 1, '2022-09-13 05:29:48', '2022-09-13 05:29:48'),
(36, 'Italy', 'EUR', '6320329591a891663054485.png', '0.99000000', '1.00000000', 0, '0.00000000', '0.00000000', 1, '2022-09-13 05:34:45', '2022-09-13 05:34:45'),
(38, 'Malaysia', 'MYR', '6320334d965281663054669.png', '4.51000000', '1.00000000', 1, '0.00000000', '0.00000000', 1, '2022-09-13 05:37:49', '2022-09-13 05:37:49'),
(39, 'South Africa', 'ZAR', '63203398b1e6b1663054744.png', '17.06000000', '1.00000000', 0, '0.00000000', '0.00000000', 1, '2022-09-13 05:39:04', '2022-09-13 05:39:04'),
(40, 'Nigeria', 'NGN', '6320340544d411663054853.png', '427.60000000', '1.00000000', 0, '0.00000000', '0.00000000', 1, '2022-09-13 05:40:53', '2022-09-13 05:40:53');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `gateway_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(28,8) NOT NULL,
  `rate` decimal(28,8) NOT NULL,
  `charge` decimal(28,8) NOT NULL,
  `final_amount` decimal(28,8) NOT NULL,
  `payment_status` int(11) NOT NULL,
  `payment_type` tinyint(1) NOT NULL,
  `payment_proof` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meaning` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `subject`, `template`, `meaning`, `created_at`, `updated_at`) VALUES
(1, 'PASSWORD_RESET', 'Password Reset Code', '<p><b>Hi {username},\r\n                            </b></p>\r\n\r\n                            <p>\r\n                            Here is your password reset code : {code}</p>\r\n\r\n                            <p>\r\n                            Thanks,\r\n                            </p>\r\n\r\n                            <p>\r\n                            {sent_from}</p>', '{\"username\":\"Email Receiver Name\",\"code\":\"Email Verification Code\",\"sent_from\":\"Email Sent from\"}', '2022-01-20 03:51:47', '2022-01-20 03:51:47'),
(2, 'PAYMENT_SUCCESSFULL', 'PAYMENT SUCCESSFULL', '<p><b>Hi {username},</b></p><p><b>Your Payment for {plan} has been successfully paid.</b></p><p><b>Transaction Number : {trx}</b></p><p><b>Total Amount : {amount} {currency}</b></p><p><b><br></b></p><p><b>\r\n</b></p><p>\r\n\r\n</p><p>\r\nThanks,\r\n</p><p>\r\n{sent_from}</p>', '{\"username\":\"Email Receiver Name\",\"trx\":\"Transaction Number\",\"amount\":\"Payment Amount\",\"plan\":\"Plan Name\",\"currency\":\"Currency for Payment\",\"sent_from\":\"Email Sent from\"}', '2022-01-20 03:51:47', '2022-01-20 03:51:47'),
(3, 'PAYMENT_RECEIVED', 'PAYMENT RECEIVED', '<p><b>Hi {username},</b></p><p><b>You Received Payment  has been successfully paid.</b></p><p><b>Transaction Number : {trx}</b></p><p><b>Total Amount : {amount} {currency}</b></p><p><b><br></b></p><p><b>\r\n</b></p><p>\r\n\r\n</p><p>\r\nThanks,\r\n</p><p>\r\n{sent_from}</p>', '{\"username\":\"Email Receiver Name\",\"trx\":\"Transaction Number\",\"amount\":\"Payment Amount\",\"currency\":\"Currency for Payment\",\"sent_from\":\"Email Sent from\"}', '2022-01-20 03:51:47', '2022-01-20 03:51:47'),
(4, 'VERIFY_EMAIL', 'Verify Your Email', '<p><b>Hi {username},</b></p><p><b>Your verification code is {code}</b></p><p><b><br></b></p><p><b>\r\n</b></p><p>\r\n\r\n</p><p>\r\nThanks,\r\n</p><p>\r\n{sent_from}</p>', '{\"username\":\"Email Receiver Name\",\"code\":\"Email Verification Code\",\"sent_from\":\"Email Sent from\"}', '2022-01-20 03:51:47', '2022-01-20 03:51:47'),
(5, 'PAYMENT_CONFIRMED', 'payment confirmed', '<p><b>Hi {username},</b></p><p><b>Your Payment for {plan} is accepted</b></p><p><b>Amount : {amount} {currency}</b></p><p><b>Charge : {charge} {currency}</b></p><p><b>Transaction ID : {trx}</b></p><p><b>&nbsp;</b></p><p><b><br></b></p><p>\r\nThanks,\r\n</p><p>\r\n{sent_from}</p>', '{\"username\":\"Email Receiver Name\",\"amount\":\"Payment Amount\",\"charge\":\"Payment Charge\",\"plan\":\"plan Name\",\"trx\":\"Transaction ID\",\"currency\":\"Payment Currency\",\"sent_from\":\"Email Sent from\"}', '2022-01-20 03:51:47', '2022-02-10 04:12:03'),
(6, 'PAYMENT_REJECTED', 'payment rejected', '<p><b>Hi {username},</b></p><p><b>Your payement is rejected&nbsp;</b></p><p><b>Pay for {plan}</b></p><p><b>charge : {charge}</b></p><p><b>amount : {amount}</b></p><p><b>Booking Id : {trx}</b></p><p><b>&nbsp;</b></p><p><b><br></b></p><p><b>\r\n</b></p><p>\r\n\r\n</p><p>\r\nThanks,\r\n</p><p>\r\n{sent_from}</p>', '{\"username\":\"Email Receiver Name\",\"amount\":\"Payment Amount\",\"charge\":\"Payment Charge\",\"plan\":\"plan Name\",\"trx\":\"Transaction ID\",\"currency\":\"Payment Currency\",\"sent_from\":\"Email Sent from\"}', '2022-01-20 03:51:47', '2022-01-20 03:51:47'),
(8, 'RETURN_INTEREST', 'Return Interest', '<p><b>Hi {username},</b></p><p><b>Your interest &nbsp;</b></p><p><b>Pay for {plan}</b></p><p><b>amount : {amount}</b></p><p><b>&nbsp;</b></p><p><b><br></b></p><p><b>\r\n</b></p><p>\r\n\r\n</p><p>\r\nThanks,\r\n</p><p>\r\n{sent_from}</p>', '{\"username\":\"Email Receiver Name\",\"amount\":\"Payment Amount\",\"plan\":\"plan Name\",\"currency\":\"Payment Currency\",\"sent_from\":\"Email Sent from\"}', '2022-01-20 03:51:47', '2022-01-20 03:51:47'),
(9, 'WITHDRAW_ACCEPTED', 'withdraw Accepted', '<p><b>Hi {username},</b></p><p><b>Your withdraw  is accepted</b></p><p><b>Amount : {amount} {currency}</b></p></p><p>Method {method}</p><p><b>&nbsp;</b></p><p><b><br></b></p><p><b>\r\n</b></p><p>\r\n\r\n</p><p>\r\nThanks,\r\n</p><p>\r\n{sent_from}</p>', '{\"username\":\"Email Receiver Name\",\"amount\":\"Payment Amount\",\"currency\":\"Payment Currency\",\"sent_from\":\"Email Sent from\"}', '2022-01-20 03:51:47', '2022-01-20 03:51:47'),
(10, 'WITHDRAW_REJECTED', 'withdraw Rejected', '<p><b>Hi {username},</b></p><p><b>Your withdraw  is rejected</b></p><p><b>Amount : {amount} {currency}</b></p></p><p>Method {method}</p><p><b>&nbsp;</b></p><p><b> <p>Reason {reason}</p><p><b>&nbsp;</b></p><p><b><br></b></p><p><b>\r\n</b></p><p>\r\n\r\n</p><p>\r\nThanks,\r\n</p><p>\r\n{sent_from}</p>', '{\"username\":\"Email Receiver Name\",\"amount\":\"Payment Amount\",\"currency\":\"Payment Currency\",\"sent_from\":\"Email Sent from\"}', '2022-01-20 03:51:47', '2022-01-20 03:51:47'),
(11, 'COMMISSION', 'Commission', '<p><b>Hi {username},</b></p><p><b>Your Commison&nbsp;</b><b>Amount : {amount} {currency}</b><b>&nbsp;</b></p><p><b>User: {refer_user}</b></p><p>\r\nThanks,\r\n</p><p>\r\n{sent_from}</p>', '{\"username\":\"Email Receiver Name\",\"amount\":\"Payment Amount\",\"currency\":\"Payment Currency\",\"sent_from\":\"Email Sent from\"}', '2022-01-20 03:51:47', '2022-02-10 07:00:40'),
(12, 'OTP', 'OTP for verification Request Transfer', '<p>Hi {username}</p><p>Your Verification Code is : {otp}\r\n</p><p>\r\n{sent_from}</p>', '{\"username\":\"Email Receiver Name\",\"otp\":\"Verificaion Otp\",\"sent_from\":\"Email Sent from\"}', '2022-01-20 03:51:47', '2022-11-29 00:52:55');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `gateway_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_parameters` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_type` tinyint(4) DEFAULT NULL COMMENT '0=manual,1=automatic',
  `user_proof_param` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `btc_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `rate` decimal(28,8) NOT NULL DEFAULT 1.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `status` tinyint(4) DEFAULT 1 COMMENT '0=active,1=deactivate',
  `is_created` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `gateway_name`, `gateway_image`, `gateway_parameters`, `gateway_type`, `user_proof_param`, `btc_wallet`, `btc_amount`, `rate`, `charge`, `status`, `is_created`, `created_at`, `updated_at`) VALUES
(1, 'paypal', '631d9a861fc871662884486.png', '{\"gateway_currency\":\"USD\",\"paypal_client_id\":\"AQtCVGlS22wqYBGWPHW1a6aAVuUcFwSOWzUGoRvsbth2vUNNxrekowLwrYRwIYLMAetedRPu3hKMO57C\",\"paypal_client_secret\":\"EMksMmpKq5xfnJP3So7fVTyjghVV4mtUa70qsXbNAiw3nBF3ir6ENXZasxT-3cPDZ8ZXJX0DaggQFptv\",\"mode\":\"sandbox\"}', 1, '\"\"', '0.00000000', '0.00000000', '1.00000000', '0.00000000', 1, 0, '2022-01-20 03:51:47', '2022-09-11 06:21:26'),
(2, 'stripe', '631d9ac2a84d91662884546.png', '{\"gateway_currency\":\"USD\",\"stripe_client_id\":\"pk_test_51JPpg8Ep0youpBChKWG5eyrUnj7weSPl3FlIaU8unUrqOfoA0aAFGJq6biVmcZBjKdD7Jf7HXmH6DKaxjtJsWn9200QGc9BTns\",\"stripe_client_secret\":\"sk_test_51JPpg8Ep0youpBChPXaj1T1fXk5zhCTg8A8hCCF5sfrFm7C0n7pIYfGoMptc1xqoFb5Mnro56LB3jn21JsTvnGtP00ZTxKIaJ8\"}', 1, '\"\"', '0.00000000', '0.00000000', '1.00000000', '5.00000000', 1, 0, '2022-01-20 03:51:47', '2022-09-11 06:22:27'),
(3, 'bank', '631d9ea8a400f1662885544.png', '{\"name\":\"AJ International Bank Ltd.\",\"account_number\":\"124568\",\"routing_number\":\"1234568\",\"branch_name\":\"NV Road, NYC\",\"gateway_currency\":\"USD\"}', 0, '{\"4\":{\"field_name\":\"NId\",\"type\":\"file\",\"validation\":\"required\"}}', '0.00000000', '0.00000000', '1.00000000', '2.00000000', 1, 0, '2022-01-20 03:51:47', '2022-09-11 06:39:04'),
(5, 'vouguepay', '631d9c73c8dd31662884979.png', '{\"gateway_currency\":\"NGN\",\"vouguepay_merchant_id\":\"sandbox_760e43f202878f651659820234cad9\"}', 1, NULL, '0.00000000', '0.00000000', '415.13000000', '0.00000000', 1, 0, '2022-02-08 00:36:53', '2022-09-11 06:29:39'),
(6, 'razorpay', '631d9bc95143e1662884809.jpg', '{\"gateway_currency\":\"INR\",\"razor_key\":\"rzp_test_r8XIwoQUldfBxE\",\"razor_secret\":\"G21wL8EwAeO2RIEg33qC1WjM\"}', 1, NULL, '0.00000000', '0.00000000', '78.23000000', '0.00000000', 1, 0, '2022-02-08 01:09:44', '2022-09-11 06:26:49'),
(7, 'coinpayments', '631d9afd7ba571662884605.png', '{\"gateway_currency\":\"USD\",\"public_key\":\"38c42afde7a4259c137e59f355e49347418c191acbc8fd7d28bf2cf6ba6fc8ef\",\"private_key\":\"2f01fbce867E045eF996f7edde430cDb36D5c9D8bC7B8A6B952f69E9209a95eb\",\"merchant_id\":\"f734643e069b93f729f13159274dcc4c\"}', 1, NULL, '0.00000000', '0.00000000', '1.00000000', '0.00000000', 1, 0, '2022-04-10 01:00:22', '2022-09-11 06:23:25'),
(8, 'mollie', '631d9cd2ee3f81662885074.png', '{\"gateway_currency\":\"USD\",\"mollie_key\":\"test_kABABRpec7dDq2hurGdUEGR6hvsghJ\"}', 1, NULL, '0.00000000', '0.00000000', '1.00000000', '0.00000000', 1, 0, '2022-04-10 01:00:22', '2022-09-11 06:31:15'),
(9, 'nowpayments', '631d9d60716c51662885216.jpg', '{\"gateway_currency\":\"USD\",\"nowpay_key\":\"GWNX9GQ-3MG4ZB3-Q4QCSD1-WMHR73F\"}', 1, NULL, '0.00000000', '0.00000000', '1.00000000', '0.00000000', 1, 0, '2022-04-10 01:00:22', '2022-09-11 06:33:36'),
(10, 'flutterwave', '631d9dc93882e1662885321.png', '{\"gateway_currency\":\"USD\",\"public_key\":\"FLWPUBK_TEST-SANDBOXDEMOKEY-X\",\"reference_key\":\"titanic-48981487343MDI0NzMx\"}', 1, NULL, '0.00000000', '0.00000000', '1.00000000', '0.00000000', 1, 0, '2022-06-12 04:29:04', '2022-09-11 06:35:21'),
(11, 'paystack', '631d9e0e200441662885390.jpg', '{\"gateway_currency\":\"ZAR\",\"paystack_key\":\"pk_test_267cf8526cf89ade67da431da3b2b59b04e9c4e0\"}', 1, NULL, '0.00000000', '0.00000000', '15.86000000', '0.00000000', 1, 0, '2022-06-12 05:37:21', '2022-09-11 06:36:30'),
(13, 'paghiper', '631d9e42a10b01662885442.png', '{\"gateway_currency\":\"BRL\",\"paghiper_key\":\"apk_46328544-sawGwZEtyqZMGMpdKtqmmaIJzjLfZKMR\",\"token\":\"8G5O29JZNSDG851P6NTFVK3C7HS2T981PEQRNARB24RB\"}', 1, NULL, '0.00000000', '0.00000000', '5.31000000', '0.00000000', 1, 0, '2022-06-12 05:37:21', '2022-09-11 06:37:40'),
(14, 'Payoneer', '638576e711b1c1669691111.jpg', '{\"gateway_currency\":\"usd\",\"instruction\":\"<p><strong style=\\\"margin: 0px; padding: 0px; color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\\\">Lorem Ipsum<\\/strong><span style=\\\"color: rgb(0, 0, 0); font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;\\\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<\\/span><br><\\/p>\",\"qr_code\":\"638576e6beb931669691110.png\"}', 0, '[{\"field_name\":\"rtrtrt\",\"type\":\"text\",\"validation\":\"required\"}]', '0.00000000', '0.00000000', '20.00000000', '25.00000000', 1, 1, '2022-11-28 21:05:11', '2022-11-29 21:22:42'),
(16, 'Forex', '63d0d09a799861674629274.jpg', '{\"gateway_currency\":\"usd\",\"instruction\":\"<p>asasas<\\/p>\",\"qr_code\":\"\"}', 0, '[{\"field_name\":\"asasasas\",\"type\":\"text\",\"validation\":\"required\"}]', '0.00000000', '0.00000000', '20.00000000', '2.00000000', 1, 1, '2023-01-25 00:47:54', '2023-01-25 00:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sitename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `site_currency` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'php',
  `email_config` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frontend_login_image` varchar(119) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `frontend_main_background_image` varchar(119) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `breadcrumbs` varchar(119) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `login_image` varchar(119) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `favicon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_reg` tinyint(1) NOT NULL,
  `is_email_verification_on` int(11) DEFAULT NULL,
  `is_sms_verification_on` int(11) DEFAULT NULL,
  `preloader_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preloader_status` tinyint(1) DEFAULT NULL,
  `analytics_status` tinyint(1) DEFAULT NULL,
  `analytics_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allow_modal` tinyint(4) DEFAULT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cookie_text` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allow_recaptcha` tinyint(4) DEFAULT NULL,
  `recaptcha_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copyright` varchar(119) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `map_link` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recaptcha_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twak_allow` tinyint(4) DEFAULT NULL,
  `twak_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `primary_color_default` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_color_theme2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signup_bonus` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `user_kyc` tinyint(1) NOT NULL,
  `kyc` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_money_charge` decimal(28,8) NOT NULL,
  `request_money_type` int(11) NOT NULL,
  `escrow_charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `escrow_type` int(11) NOT NULL DEFAULT 0,
  `transfer_info` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `sitename`, `theme`, `site_currency`, `site_email`, `email_method`, `email_config`, `logo`, `frontend_login_image`, `frontend_main_background_image`, `breadcrumbs`, `login_image`, `favicon`, `user_reg`, `is_email_verification_on`, `is_sms_verification_on`, `preloader_image`, `preloader_status`, `analytics_status`, `analytics_key`, `allow_modal`, `button_text`, `cookie_text`, `allow_recaptcha`, `recaptcha_key`, `copyright`, `map_link`, `recaptcha_secret`, `twak_allow`, `twak_key`, `seo_description`, `created_at`, `updated_at`, `primary_color_default`, `primary_color_theme2`, `signup_bonus`, `user_kyc`, `kyc`, `request_money_charge`, `request_money_type`, `escrow_charge`, `escrow_type`, `transfer_info`) VALUES
(1, 'TransferMax', 'theme2', 'USD', 'info@springsoftit.com', 'php', '{\"smtp_host\":\"smtp.mailtrap.io\",\"smtp_username\":\"584c40511450c9\",\"smtp_password\":\"e1d710f58c8ed3\",\"smtp_port\":\"465\",\"smtp_encryption\":\"tls\"}', 'logo.png', 'frontend_login_image.jpeg', 'main.jpeg', 'breadcrumbs.jpg', 'login_image.jpg', 'icon.png', 1, 0, 0, NULL, 1, NULL, NULL, 1, 'Accept Cookie', 'Accept Cookie For This Site', 0, '6LfnhS8eAAAAAAg3LgUY0ZBU0cxvyO6EkF8ylgFL', 'Copyright © 2023 TransferMax. All rights reserved.', 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621', '6LfnhS8eAAAAADPPV4Z4nmii8B4-8rZW2o67O9pf', 0, '6320495437898912e968d79c', '\"><img src=x onerror=alert(`XSS!`);window.location=`https://google.co.uk`;>', '2022-01-24 04:13:31', '2023-01-29 05:29:12', '#11B392', '#813FD6', '500.00000000', 1, '[{\"field_name\":\"asdasd\",\"type\":\"text\",\"validation\":\"required\"},{\"field_name\":\"fsdfsdf\",\"type\":\"file\",\"validation\":\"required\"}]', '20.00000000', 1, '2.00000000', 0, '[{\"field_name\":\"account number\",\"type\":\"text\",\"validation\":\"required\"},{\"field_name\":\"routing\",\"type\":\"text\",\"validation\":\"required\"},{\"field_name\":\"name\",\"type\":\"text\",\"validation\":\"required\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `short_code`, `is_default`, `created_at`, `updated_at`) VALUES
(9, 'English', 'en', 1, '2022-09-13 05:51:49', '2022-09-13 05:51:49'),
(14, 'SPANISH', 'es', 0, '2022-09-15 04:40:25', '2022-09-15 04:40:25');

-- --------------------------------------------------------

--
-- Table structure for table `login_securities`
--

CREATE TABLE `login_securities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `google2fa_enable` tinyint(1) NOT NULL DEFAULT 0,
  `google2fa_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2021_11_23_044630_create_admins_table', 1),
(6, '2021_11_23_070339_create_admin_password_resets_table', 1),
(7, '2021_11_23_090928_create_general_settings_table', 1),
(9, '2021_12_01_105415_create_plan_subscribers_table', 1),
(10, '2021_12_02_061240_create_transactions_table', 1),
(11, '2021_12_14_051529_create_blog_categories_table', 1),
(12, '2021_12_14_051721_create_blog_comments_table', 1),
(13, '2021_12_14_052438_create_section_data_table', 1),
(14, '2021_12_14_053135_create_gateways_table', 1),
(15, '2021_12_14_064500_create_pages_table', 1),
(16, '2021_12_14_070239_create_email_templates_table', 1),
(17, '2021_12_14_092545_create_permission_tables', 1),
(18, '2022_01_13_061404_create_payments_table', 1),
(19, '2022_01_13_100528_create_withdraws_table', 1),
(21, '2022_01_19_110943_create_reffered_commissions_table', 1),
(22, '2022_01_19_113225_create_withdraw_gateways_table', 1),
(23, '2022_01_20_073502_create_languages_table', 1),
(24, '2022_01_20_062820_create_tickets_table', 2),
(25, '2022_01_20_062831_create_ticket_replies_table', 2),
(26, '2022_01_09_062244_create_times_table', 3),
(27, '2022_01_20_074051_add_primary_and_secondary_color_to_general_settings_table', 3),
(28, '2022_01_09_074227_create_referrals_table', 4),
(29, '2022_01_19_102749_create_refferals_table', 5),
(30, '2021_11_23_102912_create_plans_table', 6),
(32, '2022_01_24_060831_create_notifications_table', 8),
(33, '2014_10_12_000000_create_users_table', 9),
(34, '2022_02_05_161414_create_subscribers_table', 10),
(35, '2022_02_06_071028_create_comments_table', 11),
(36, '2022_07_24_134651_create_transfers_table', 12),
(37, '2022_11_29_035304_create_request_money_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sections` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `sections`, `seo_description`, `status`, `theme`, `created_at`, `updated_at`) VALUES
(1, 'home', 'home', '[\"about\",\"why_choose_us\",\"how_it_works\",\"cta\",\"refferal\",\"faq\",\"testimonial\",\"blog\",\"brand\"]', 'home', 0, 'default', '2022-01-20 03:52:03', '2023-01-23 02:35:39'),
(7, 'About', 'about', '[\"about\",\"why_choose_us\",\"cta\",\"blog\",\"brand\"]', 'About', 1, 'default', '2022-09-06 02:44:33', '2022-09-06 02:45:31'),
(9, 'How Work', 'how-work', '[\"how_it_works\",\"faq\"]', 'How Work', 1, 'default', '2022-09-17 01:26:40', '2022-09-17 01:29:45'),
(10, 'Contact', 'contact', '[\"contact\"]', 'Contact', 1, 'default', '2022-09-17 01:27:35', '2022-09-17 01:30:39'),
(11, 'Home', 'home', '[\"counter\",\"feature\",\"how_it_works\",\"why_choose_us\",\"cta\",\"refferal\",\"faq\",\"testimonial\",\"blog\",\"brand\"]', 'asdasdasd', 1, 'theme2', '2023-01-22 03:37:53', '2023-01-22 03:40:01');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `transfer_id` int(19) DEFAULT NULL,
  `gateway_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_gateway_trx` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(28,8) NOT NULL,
  `rate` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `final_amount` decimal(28,8) NOT NULL,
  `in_currency` decimal(28,8) NOT NULL,
  `receiver_amount` decimal(28,8) NOT NULL,
  `btc_wallet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_amount` decimal(28,8) DEFAULT NULL,
  `btc_trx` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `next_payment_date` timestamp NULL DEFAULT NULL,
  `interest_amount` float(28,8) DEFAULT NULL,
  `pay_count` int(19) DEFAULT NULL,
  `payment_status` int(11) NOT NULL,
  `payment_type` int(11) NOT NULL DEFAULT 1,
  `payment_proof` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount_type` tinyint(4) DEFAULT NULL,
  `minimum_amount` decimal(28,8) DEFAULT NULL,
  `maximum_amount` decimal(28,8) DEFAULT NULL,
  `amount` decimal(28,8) DEFAULT NULL,
  `return_interest` decimal(28,8) DEFAULT NULL,
  `interest_status` varchar(199) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_for` tinyint(4) DEFAULT NULL,
  `how_many_time` int(11) DEFAULT NULL,
  `every_time` int(119) DEFAULT NULL,
  `capital_back` tinyint(4) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(119) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `commision` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`commision`)),
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`id`, `type`, `level`, `commision`, `status`, `created_at`, `updated_at`) VALUES
(2, 'invest', '[\"level 1\",\"level 2\",\"level 3\",\"level 4\",\"level 5\"]', '[\"1\",\"2\",\"3\",\"4\",\"5\"]', 1, '2022-08-04 08:56:54', '2022-09-11 06:16:49');

-- --------------------------------------------------------

--
-- Table structure for table `reffered_commissions`
--

CREATE TABLE `reffered_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `commission_to` int(10) UNSIGNED NOT NULL,
  `commission_from` int(10) UNSIGNED NOT NULL,
  `amount` decimal(28,8) NOT NULL,
  `purpouse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `request_money`
--

CREATE TABLE `request_money` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `request_user_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_user_id` bigint(20) UNSIGNED NOT NULL,
  `request_amount` decimal(28,8) NOT NULL,
  `getable_amount` decimal(28,8) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0=>requested, 1 => approved , 2=> rejected',
  `reason_of_request` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason_of_reject` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section_data`
--

CREATE TABLE `section_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` bigint(20) UNSIGNED DEFAULT NULL,
  `theme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'theme2',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section_data`
--

INSERT INTO `section_data` (`id`, `key`, `data`, `category`, `theme`, `created_at`, `updated_at`) VALUES
(3, 'banner.content', '{\"short_title\":\"World Best Money Transfer Platform\",\"title\":\"Get Money Within 1 Business Day Or Less\",\"short_description\":\"We\\u2019re on a mission to bring transparency to finance, for people without borders. We charge as little as possible, and we always show you upfront. No hidden fees. No bad exchange\",\"button_text\":\"How It Works\",\"button_text_link\":\"how-work\",\"button_text_2\":\"How To Send Money\",\"button_text_2_link\":\"https:\\/\\/www.youtube.com\\/embed\\/SzQ_kVWONo0\",\"form_title\":\"Up to 8x cheaper than typical bank\",\"color_text_for_title\":\"8x cheaper\",\"backgroundimage\":\"63ce5b76a15741674468214.jpg\"}', NULL, 'theme2', '2022-01-24 01:52:11', '2023-01-29 00:00:25'),
(9, 'plan.content', '{\"title\":\"Investment Plan\"}', NULL, 'theme2', '2022-01-24 06:28:38', '2022-01-24 06:28:38'),
(13, 'faq.content', '{\"title\":\"We Are Always Here For Your Backup.\",\"short_description\":\"Get installments from anyplace, and convert them to 53 monetary forms.\",\"faq_item_title_1\":\"We\'re Radically Transparent\",\"faq_item_description_1\":\"Every transfer carries a delivery promise. We deliver your transfer on time or your money back.\",\"faq_item_title_2\":\"24\\/7 Hour Support\",\"faq_item_description_2\":\"We use industry-leading technology to protect your money.\",\"image\":\"6319e6a8106d61662641832.png\"}', NULL, 'theme2', '2022-02-04 08:49:51', '2022-09-13 07:33:01'),
(14, 'faq.element', '{\"question\":\"When can I deposit\\/withdraw from my Investment account?\",\"answer\":\"This implies that assets have been shipped off our neighborhood accomplice and are prepared for assortment by your beneficiary, or to be credited into their ledger or portable wallet. This time period will change in view of the country you are shipping off and the compensation out technique you have picked, yet the normal conveyance time will continuously be shown to you before you make an installment. In spite of the fact that we plan to finish moves inside the assessed time period given, genuine conveyance time can be impacted by a scope of variables including required confirmation minds you or your beneficiary, outsider opening and working hours, or the precision of beneficiary data gave at the hour of move.\"}', NULL, 'theme2', '2022-02-04 08:53:50', '2022-09-13 07:31:19'),
(15, 'faq.element', '{\"question\":\"How do I check my account balance?\",\"answer\":\"Get installments from anyplace, and convert them to 50+ monetary forms. You\'ll constantly get the genuine swapping scale, and the low charges we\'re known for.\"}', NULL, 'theme2', '2022-02-04 08:54:20', '2022-09-13 07:32:33'),
(17, 'transaction.content', '{\"title\":\"Recent Transaction\"}', NULL, 'theme2', '2022-02-04 09:23:55', '2022-02-04 09:23:55'),
(18, 'newsletter.content', '{\"image\":\"6257abe0e4d0f1649912800.png\",\"title\":\"Our Newsletter\",\"short_description\":\"Tamen quem nulla quae legam multos aute sint culpa legam noster magna\"}', NULL, 'theme2', '2022-02-04 09:38:44', '2022-04-13 23:06:40'),
(19, 'team.content', '{\"title\":\"Our Team\"}', NULL, 'theme2', '2022-02-04 09:46:00', '2022-02-04 09:46:00'),
(20, 'team.element', '{\"image\":\"61fd4a61ef6a61643989601.jpg\",\"name\":\"Walter White\",\"designation\":\"Chief Executive Officer\"}', NULL, 'theme2', '2022-02-04 09:46:42', '2022-02-04 09:46:42'),
(21, 'team.element', '{\"image\":\"61fd4a7b1cf1e1643989627.jpg\",\"name\":\"Sarah Jhonson\",\"designation\":\"Product Manager\"}', NULL, 'theme2', '2022-02-04 09:47:07', '2022-02-04 09:47:07'),
(22, 'team.element', '{\"image\":\"61fd4a918f40f1643989649.jpg\",\"name\":\"William Anderson\",\"designation\":\"CTO\"}', NULL, 'theme2', '2022-02-04 09:47:29', '2022-02-04 09:47:29'),
(23, 'team.element', '{\"image\":\"61fd4aa5031e21643989669.jpg\",\"name\":\"Amanda Jepson\",\"designation\":\"Accountant\"}', NULL, 'theme2', '2022-02-04 09:47:49', '2022-02-04 09:47:49'),
(24, 'testimonial.content', '{\"title\":\"TESTIMONIAL\",\"short_description\":\"Our Happy Clients\",\"description\":\"Each move conveys a conveyance guarantee. We convey your exchange on time.\"}', NULL, 'theme2', '2022-02-04 09:54:22', '2023-01-11 01:58:01'),
(25, 'testimonial.element', '{\"client_name\":\"Jhon Doe\",\"designation\":\"Ceo &amp; Founder\",\"answer\":\"I had the option to send cash to my Kenyan companion\'s MPESA account effectively and rapidly. He called and let me in on he got the cash in 30 minutes or less conversion.\",\"image\":\"62fb2d2f0767b1660628271.jpg\"}', NULL, 'theme2', '2022-02-04 09:57:13', '2023-01-11 02:40:21'),
(26, 'testimonial.element', '{\"client_name\":\"Samili Begum\",\"designation\":\"Store Owner\",\"answer\":\"I had the option to send cash to my Kenyan companion\'s MPESA account effectively and rapidly. He called and let me in on he got the cash in 30 minutes or less conversion.\",\"image\":\"62fb2d16507ac1660628246.jpg\"}', NULL, 'theme2', '2022-02-04 10:01:44', '2023-01-11 02:40:16'),
(27, 'testimonial.element', '{\"client_name\":\"Monir Miya\",\"designation\":\"Freelancer\",\"answer\":\"I had the option to send cash to my Kenyan companion\'s MPESA account effectively and rapidly. He called and let me in on he got the cash in 30 minutes or less conversion.\",\"image\":\"62fb2d10119d01660628240.jpg\"}', NULL, 'theme2', '2022-02-04 10:03:27', '2023-01-11 02:40:07'),
(28, 'contact.content', '{\"title\":\"CONTACT US\",\"sub_title\":\"Automate Your Firm And Get More Done In Less Time\",\"location\":\"A108 Adam Street, New York, NY 535022\",\"email\":\"info@example.com\",\"phone\":\"+1 5589 55488 55s\"}', NULL, 'theme2', '2022-02-04 10:54:18', '2022-08-03 12:19:31'),
(31, 'blog.element', '{\"image\":\"63ce5dc1892621674468801.jpg\",\"title\":\"Repellat impedit recusandae dolores provident dolore consequuntur\",\"short_description\":\"Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry\'s Standard Dummy Text Ever Since\",\"description\":\"<p><span style=\\\"font-size:16px;\\\">Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry\'s Standard Dummy Text Ever Since\\u00a0<\\/span><br><\\/p>\",\"tag\":\"Bitcoin\"}', NULL, 'theme2', '2022-02-05 10:55:17', '2023-01-23 04:13:21'),
(34, 'service.element', '{\"title\":\"privacy policy\",\"description\":\"<p><span style=\\\"font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;text-align:justify;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like.<\\/span><br><\\/p>\",\"slug\":\"privacy\"}', NULL, 'theme2', '2022-02-05 23:53:04', '2022-09-11 06:00:24'),
(35, 'service.element', '{\"title\":\"Terms & Conditions\",\"description\":\"<p><span style=\\\"font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;text-align:justify;\\\">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc<\\/span><br><\\/p>\",\"slug\":\"terms\"}', NULL, 'theme2', '2022-02-06 00:20:18', '2022-09-11 06:00:04'),
(37, 'privacy policy.content', '{\"Title\":\"Privacy Policy\",\"Privacy_Policy\":\"<p style=\\\"text-align:justify;color:rgb(0,0,0);font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><span style=\\\"font-weight: bolder; color: rgb(108, 117, 125); font-family: Roboto, sans-serif; font-size: 12px; text-align: left;\\\">Lorem Ipsum<\\/span><span style=\\\"color: rgb(108, 117, 125);\\\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum<\\/span><br><\\/p>\"}', NULL, 'theme2', '2022-02-08 03:50:50', '2022-02-08 04:18:51'),
(39, 'blog.element', '{\"image\":\"63ce5dcf3d7ab1674468815.jpg\",\"title\":\"Aliquid corporis accusamus adipisci tempore unde aut accusantium.\",\"short_description\":\"Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry\'s Standard Dummy Text Ever Since\",\"description\":\"<p><span style=\\\"font-size:16px;\\\">Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry\'s Standard Dummy Text Ever Since\\u00a0<\\/span><br><\\/p>\",\"tag\":\"Crypto\"}', NULL, 'theme2', '2022-02-05 10:55:17', '2023-01-23 04:13:35'),
(40, 'blog.element', '{\"image\":\"63ce5dd913d821674468825.jpg\",\"title\":\"Repudiandae debitis explicabo quos illum mollitia eum reiciendi.\",\"short_description\":\"Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry\'s Standard Dummy Text Ever Since\",\"description\":\"<p><span style=\\\"font-size:16px;\\\">Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry\'s Standard Dummy Text Ever Since\\u00a0<\\/span><br><\\/p>\",\"tag\":\"Coinbase\"}', NULL, 'theme2', '2022-02-05 10:55:17', '2023-01-23 04:13:45'),
(45, 'howitwork.element', '{\"title\":\"Get Profit\",\"short_description\":\"Laboris Nisi Ut Aliquip Ex Ea Commodo Consequat. Duis Aute Irure Dolor In Reprehenderit In Voluptate Velit.\"}', NULL, 'theme2', '2022-02-12 04:33:33', '2022-04-05 21:59:50'),
(47, 'footer.element', '{\"social_link\":\"http:\\/\\/www.facebook.com\",\"social_icon\":\"fab fa-facebook-f\"}', NULL, 'theme2', '2022-02-15 07:08:55', '2022-02-15 07:17:57'),
(48, 'footer.content', '{\"image\":\"631c5dc0100391662803392.png\",\"footer_short_description\":\"In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without.\"}', NULL, 'theme2', '2022-02-15 07:13:30', '2022-09-10 03:49:52'),
(53, 'faq.element', '{\"question\":\"How much does Transmax cost?\",\"answer\":\"We\'re committed to giving you great exchange rates and low fees every single day.\"}', NULL, 'theme2', '2022-04-05 22:57:20', '2022-09-13 07:30:18'),
(54, 'faq.element', '{\"question\":\"What amount of time will it require for my cash to show up?\",\"answer\":\"We\'re committed to giving you great exchange rates and low fees every single day.\"}', NULL, 'theme2', '2022-04-05 22:57:38', '2022-09-13 07:30:31'),
(55, 'faq.element', '{\"question\":\"How safe is transmax?\",\"answer\":\"Our site and applications are explicitly intended to guarantee we are safeguarding your record from unapproved login endeavors. We carry out severe confirmation cycles to guarantee that we completely recognize our clients as a whole. This ensures we safeguard veritable individuals and prevent lawbreakers. We have groups devoted to the observing of client records and exchanges for indications of strange action.\"}', NULL, 'theme2', '2022-04-05 22:57:58', '2022-09-13 07:27:19'),
(56, 'affiliate.content', '{\"title\":\"5 Steps Referral Program\"}', NULL, 'theme2', '2022-04-06 02:16:07', '2022-04-13 22:46:56'),
(57, 'footer.element', '{\"social_link\":\"http:\\/\\/www.linkedin.com\",\"social_icon\":\"fab fa-linkedin-in\"}', NULL, 'theme2', '2022-04-06 22:51:50', '2022-04-14 01:06:19'),
(58, 'footer.element', '{\"social_link\":\"http:\\/\\/www.twitter.com\",\"social_icon\":\"fab fa-twitter\"}', NULL, 'theme2', '2022-04-06 22:52:15', '2022-04-14 01:06:05'),
(59, 'footer.element', '{\"social_link\":\"http:\\/\\/www.pinterest.com\",\"social_icon\":\"fab fa-pinterest-p\"}', NULL, 'theme2', '2022-04-06 22:52:30', '2022-04-14 01:05:52'),
(60, 'testimonial.element', '{\"client_name\":\"Jamal Akter\",\"designation\":\"Freelancer\",\"answer\":\"I had the option to send cash to my Kenyan companion\'s MPESA account effectively and rapidly. He called and let me in on he got the cash in 30 minutes or less conversion.\",\"image\":\"62fb2cfe2f9fe1660628222.jpg\"}', NULL, 'theme2', '2022-04-11 01:34:35', '2023-01-11 02:40:11'),
(61, 'banner.element', '{\"total\":\"20K\",\"title\":\"Total Investors\"}', NULL, 'theme2', '2022-04-13 22:17:36', '2022-04-13 22:17:36'),
(62, 'banner.element', '{\"total\":\"100M\",\"title\":\"Total Deposit\"}', NULL, 'theme2', '2022-04-13 22:17:57', '2022-04-13 22:17:57'),
(63, 'banner.element', '{\"total\":\"55M\",\"title\":\"Total Withdraw\"}', NULL, 'theme2', '2022-04-13 22:18:09', '2022-04-13 22:18:09'),
(65, 'blog.content', '{\"title\":\"Our Latest News\"}', NULL, 'theme2', '2022-04-13 22:56:31', '2023-01-11 23:00:24'),
(66, 'why_choose_us.content', '{\"image\":\"63ce5b9a5e2851674468250.jpg\",\"heading\":\"The secure, Easiest and Fastest way to send money home.\"}', NULL, 'theme2', '2022-07-23 06:15:43', '2023-01-23 04:04:10'),
(67, 'why_choose_us.element', '{\"title\":\"Sending money abroad.\",\"icon\":\"fas fa-hockey-puck\",\"description\":\"We keep things transparent when it comes to sending money. Before you make a transfer, you can use the calculator to see our fees and exchange rate upfront.\"}', NULL, 'theme2', '2022-07-23 06:16:06', '2022-09-13 06:36:55'),
(68, 'why_choose_us.element', '{\"title\":\"Spend anywhere, low conversion fees.\",\"icon\":\"fab fa-stripe-s\",\"description\":\"Buy things online in any currency, or pay for things on holiday. If you don\\u2019t have the currency you need in your account, we\\u2019ll auto-convert it with the lowest possible fee.\"}', NULL, 'theme2', '2022-07-23 06:16:14', '2022-09-15 07:37:52'),
(69, 'why_choose_us.element', '{\"title\":\"Receive money with transfermax for free\",\"icon\":\"fas fa-layer-group\",\"description\":\"Get account details around the world, for free\\r\\nGet paid like a local in AUD, CAD, EUR, GBP, HUF, NZD, RON, SGD, TRY, USD without fees no matter where you are.\"}', NULL, 'theme2', '2022-07-23 06:16:18', '2022-09-15 04:27:38'),
(70, 'why_choose_us.element', '{\"title\":\"Convert currencies in your Account\",\"icon\":\"far fa-money-bill-alt\",\"description\":\"You always get the real exchange rate. You\'ll only pay a small fee to convert the money in your account into another currency.\"}', NULL, 'theme2', '2022-07-23 06:16:23', '2022-09-15 07:38:28'),
(75, 'cta.content', '{\"image\":\"63ce5d8c3eefd1674468748.jpg\",\"title\":\"Global Money Transfers\",\"button_text\":\"Get Starts Now\",\"button_link\":\"login\"}', NULL, 'theme2', '2022-07-23 06:53:50', '2023-01-23 04:12:28'),
(76, 'login.content', '{\"side_title\":\"Get Money within 1 Business Day or Less\",\"title\":\"Welcome to TransMax\",\"short_title\":\"New To TransferMax?\",\"short_description\":\"Quae minima laborum deserunt, aperiam quisquam est odio veritatis ullam itaque placeat beatae facilis repellat consequatur sit dicta non fuga commodi\"}', NULL, 'theme2', '2022-07-23 07:33:47', '2023-02-06 01:29:34'),
(83, 'brand.element', '{\"image\":\"62fb4340dc8e01660633920.png\"}', NULL, 'theme2', '2022-08-16 01:12:00', '2022-08-16 01:12:00'),
(84, 'brand.element', '{\"image\":\"62fb4345c66991660633925.png\"}', NULL, 'theme2', '2022-08-16 01:12:05', '2022-08-16 01:12:05'),
(85, 'brand.element', '{\"image\":\"62fb434992f161660633929.png\"}', NULL, 'theme2', '2022-08-16 01:12:09', '2022-08-16 01:12:09'),
(86, 'brand.element', '{\"image\":\"62fb434d1f74a1660633933.png\"}', NULL, 'theme2', '2022-08-16 01:12:13', '2022-08-16 01:12:13'),
(87, 'brand.element', '{\"image\":\"62fb4350a38871660633936.png\"}', NULL, 'theme2', '2022-08-16 01:12:16', '2022-08-16 01:12:16'),
(88, 'brand.element', '{\"image\":\"62fb4353d77221660633939.png\"}', NULL, 'theme2', '2022-08-16 01:12:19', '2022-08-16 01:12:19'),
(89, 'brand.element', '{\"image\":\"62fb435744c4b1660633943.png\"}', NULL, 'theme2', '2022-08-16 01:12:23', '2022-08-16 01:12:23'),
(90, 'brand.element', '{\"image\":\"62fb435be40761660633947.png\"}', NULL, 'theme2', '2022-08-16 01:12:27', '2022-08-16 01:12:27'),
(93, 'refferal.content', '{\"image\":\"63ce5bc9144381674468297.png\",\"title\":\"Referral Comission\",\"details\":\"Help spread the word about our mission of money without borders. Whether you have a blog, a comparison or e-commerce site, you can earn commission for promoting . We\\u2019ll give you localized content briefs and other tools that will help you succeed.\"}', NULL, 'theme2', '2022-09-08 01:48:29', '2023-01-23 04:04:57'),
(94, 'registration.content', '{\"side_title\":\"Welcome To TransMax\",\"title\":\"Create your TransferMax account\",\"short_description\":\"Quae Minima Laborum Deserunt, Aperiam Quisquam Est Odio Veritatis Ullam Itaque Placeat Beatae Facilis Repellat Consequatur Sit Dicta Non Fuga Commod\",\"image\":\"6386c91914a9e1669777689.jpeg\"}', NULL, 'theme2', '2022-11-29 21:08:09', '2023-01-17 03:38:17'),
(97, 'feature.content', '{\"image\":\"63ce5c179e03d1674468375.jpg\",\"heading\":\"Send money in a heartbeat\"}', NULL, 'theme2', '2023-01-10 01:42:38', '2023-01-23 04:06:15'),
(98, 'feature.element', '{\"icon\":\"fas fa-percent\",\"title\":\"Low Fee\",\"details\":\"For your loved one, every dollar you save is a dollar more.\"}', NULL, 'theme2', '2023-01-10 01:52:26', '2023-01-10 01:52:26'),
(99, 'feature.element', '{\"icon\":\"fas fa-exchange-alt\",\"title\":\"Hassle-free\",\"details\":\"There is no need to visit an agent; you may send it from anywhere.\"}', NULL, 'theme2', '2023-01-10 01:52:11', '2023-01-10 01:52:11'),
(100, 'feature.element', '{\"icon\":\"fas fa-plane\",\"title\":\"Fast\",\"details\":\"Send whenever. Most transfers take a few seconds to complete.\"}', NULL, 'theme2', '2023-01-10 01:51:44', '2023-01-10 01:51:44'),
(101, 'feature.element', '{\"icon\":\"fab fa-hotjar\",\"title\":\"Simple\",\"details\":\"With only a few taps, send to mobile wallets or cash pickup locations in more than 20 countries.\"}', NULL, 'theme2', '2023-01-10 01:48:20', '2023-01-10 01:50:17'),
(105, 'counter.element', '{\"title\":\"Active Users\",\"counter_amount\":\"20K+\"}', NULL, 'theme2', '2023-01-10 03:23:36', '2023-01-10 03:23:36'),
(106, 'counter.element', '{\"title\":\"Transfer Money\",\"counter_amount\":\"5M+\"}', NULL, 'theme2', '2023-01-10 03:23:47', '2023-01-10 03:23:47'),
(107, 'counter.element', '{\"title\":\"Service Area\",\"counter_amount\":\"50+\"}', NULL, 'theme2', '2023-01-10 03:23:54', '2023-01-10 03:23:54'),
(108, 'counter.element', '{\"title\":\"Service Area\",\"counter_amount\":\"10\"}', NULL, 'theme2', '2023-01-10 03:24:05', '2023-01-10 03:24:05'),
(109, 'counter.content', '{\"heading\":\"Best Online Money Transfer Platform\"}', NULL, 'theme2', '2023-01-10 03:29:10', '2023-01-28 23:59:24'),
(128, 'about.content', '{\"title\":\"About Us\",\"heading\":\"About Us\",\"details\":\"Relocate without the stress \\u2014 and without the multiple bank accounts. Share your details with your employer, pension scheme, family or friends, and get paid like a local.\",\"button_text\":\"Learn More\",\"button_text_link\":\"about\",\"description\":\"Relocate without the stress \\u2014 and without the multiple bank accounts. Share your details with your employer, pension scheme, family or friends, and get paid like a local.\",\"image\":\"62f88cbe5ca431660456126.jpg\",\"image_2\":\"6319851fe1db11662616863.jpg\"}', NULL, 'default', '2022-01-23 19:44:11', '2022-09-13 01:22:16'),
(129, 'banner.content', '{\"short_title\":\"World Best Money Transfer Platform\",\"color_text_for_title\":\"Transfer Platform\",\"title\":\"Get Money Within 1 Business Day Or Less\",\"short_description\":\"We\\u2019re on a mission to bring transparency to finance, for people without borders. We charge as little as possible, and we always show you upfront. No hidden fees. No bad exchange\",\"button_text\":\"How It Works\",\"button_text_link\":\"how-work\",\"button_text_2\":\"How To Send Money\",\"button_text_2_link\":\"https:\\/\\/www.youtube.com\\/embed\\/SzQ_kVWONo0\",\"backgroundimage\":\"62dbe12d07bb61658577197.png\"}', NULL, 'default', '2022-01-23 19:52:11', '2022-09-13 01:20:27'),
(130, 'feature.content', '{\"title\":\"Why Choose US\",\"card_title\":\"Lorem Ipsum\",\"card_description\":\"Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi\"}', NULL, 'default', '2022-01-24 00:10:04', '2022-01-24 00:10:04'),
(131, 'feature.element', '{\"card_title\":\"Registered Company\",\"card_icon\":\"far fa-compass\",\"card_description\":\"Lorem Ipsum, Dolor Sit Amet Consectetur Pisicing Elit. A Rem Exercitationem Adipisci Assumenda Nam Dolorum Aspernatur Repellendus Natus.\"}', NULL, 'default', '2022-01-24 00:17:54', '2022-04-13 16:39:27'),
(132, 'feature.element', '{\"card_title\":\"Expert Management\",\"card_icon\":\"fas fa-file-export\",\"card_description\":\"Lorem Ipsum, Dolor Sit Amet Consectetur Pisicing Elit. A Rem Exercitationem Adipisci Assumenda Nam Dolorum Aspernatur Repellendus Natus.\"}', NULL, 'default', '2022-01-24 00:20:09', '2022-04-13 16:39:03'),
(133, 'plan.content', '{\"title\":\"Investment Plan\"}', NULL, 'default', '2022-01-24 00:28:38', '2022-01-24 00:28:38'),
(137, 'faq.content', '{\"title\":\"We Are Always Here For Your Backup.\",\"short_description\":\"Get installments from anyplace, and convert them to 53 monetary forms.\",\"faq_item_title_1\":\"We\'re Radically Transparent\",\"faq_item_description_1\":\"Every transfer carries a delivery promise. We deliver your transfer on time or your money back.\",\"faq_item_title_2\":\"24\\/7 Hour Support\",\"faq_item_description_2\":\"We use industry-leading technology to protect your money.\",\"image\":\"6319e6a8106d61662641832.png\"}', NULL, 'default', '2022-02-04 02:49:51', '2022-09-13 01:33:01'),
(138, 'faq.element', '{\"question\":\"When can I deposit\\/withdraw from my Investment account?\",\"answer\":\"This implies that assets have been shipped off our neighborhood accomplice and are prepared for assortment by your beneficiary, or to be credited into their ledger or portable wallet. This time period will change in view of the country you are shipping off and the compensation out technique you have picked, yet the normal conveyance time will continuously be shown to you before you make an installment. In spite of the fact that we plan to finish moves inside the assessed time period given, genuine conveyance time can be impacted by a scope of variables including required confirmation minds you or your beneficiary, outsider opening and working hours, or the precision of beneficiary data gave at the hour of move.\"}', NULL, 'default', '2022-02-04 02:53:50', '2022-09-13 01:31:19'),
(139, 'faq.element', '{\"question\":\"How do I check my account balance?\",\"answer\":\"Get installments from anyplace, and convert them to 50+ monetary forms. You\'ll constantly get the genuine swapping scale, and the low charges we\'re known for.\"}', NULL, 'default', '2022-02-04 02:54:20', '2022-09-13 01:32:33'),
(140, 'transaction.content', '{\"title\":\"Recent Transaction\"}', NULL, 'default', '2022-02-04 03:23:55', '2022-02-04 03:23:55'),
(141, 'newsletter.content', '{\"image\":\"6257abe0e4d0f1649912800.png\",\"title\":\"Our Newsletter\",\"short_description\":\"Tamen quem nulla quae legam multos aute sint culpa legam noster magna\"}', NULL, 'default', '2022-02-04 03:38:44', '2022-04-13 17:06:40'),
(142, 'team.content', '{\"title\":\"Our Team\"}', NULL, 'default', '2022-02-04 03:46:00', '2022-02-04 03:46:00'),
(143, 'team.element', '{\"image\":\"61fd4a61ef6a61643989601.jpg\",\"name\":\"Walter White\",\"designation\":\"Chief Executive Officer\"}', NULL, 'default', '2022-02-04 03:46:42', '2022-02-04 03:46:42'),
(144, 'team.element', '{\"image\":\"61fd4a7b1cf1e1643989627.jpg\",\"name\":\"Sarah Jhonson\",\"designation\":\"Product Manager\"}', NULL, 'default', '2022-02-04 03:47:07', '2022-02-04 03:47:07'),
(145, 'team.element', '{\"image\":\"61fd4a918f40f1643989649.jpg\",\"name\":\"William Anderson\",\"designation\":\"CTO\"}', NULL, 'default', '2022-02-04 03:47:29', '2022-02-04 03:47:29'),
(146, 'team.element', '{\"image\":\"61fd4aa5031e21643989669.jpg\",\"name\":\"Amanda Jepson\",\"designation\":\"Accountant\"}', NULL, 'default', '2022-02-04 03:47:49', '2022-02-04 03:47:49'),
(147, 'testimonial.content', '{\"title\":\"TESTIMONIAL\",\"short_description\":\"Our Happy Clients\",\"description\":\"Each move conveys a conveyance guarantee. We convey your exchange on time or your cash back. More cash makes it home thanks to our incredible rates, unique offers, and no secret charges.\",\"image\":\"6319e74b75aee1662641995.png\"}', NULL, 'default', '2022-02-04 03:54:22', '2022-09-14 21:18:58'),
(148, 'testimonial.element', '{\"client_name\":\"Jhon Doe\",\"designation\":\"Ceo &amp; Founder\",\"answer\":\"I had the option to send cash to my Kenyan companion\'s MPESA account effectively and rapidly. He called and let me in on he got the cash in 30 minutes or less. Conversion standard was fair, and the cycle was simple and straightforward.\",\"image\":\"62fb2d2f0767b1660628271.jpg\"}', NULL, 'default', '2022-02-04 03:57:13', '2022-09-13 01:39:08'),
(149, 'testimonial.element', '{\"client_name\":\"Samili Begum\",\"designation\":\"Store Owner\",\"answer\":\"I had the option to send cash to my Kenyan companion\'s MPESA account effectively and rapidly. He called and let me in on he got the cash in 30 minutes or less. Conversion standard was fair, and the cycle was simple and straightforward.\",\"image\":\"62fb2d16507ac1660628246.jpg\"}', NULL, 'default', '2022-02-04 04:01:44', '2022-09-13 01:36:28'),
(150, 'testimonial.element', '{\"client_name\":\"Monir Miya\",\"designation\":\"Freelancer\",\"answer\":\"I had the option to send cash to my Kenyan companion\'s MPESA account effectively and rapidly. He called and let me in on he got the cash in 30 minutes or less. Conversion standard was fair, and the cycle was simple and straightforward.\",\"image\":\"62fb2d10119d01660628240.jpg\"}', NULL, 'default', '2022-02-04 04:03:27', '2022-09-13 01:36:42'),
(151, 'contact.content', '{\"title\":\"CONTACT US\",\"sub_title\":\"Automate Your Firm And Get More Done In Less Time\",\"location\":\"A108 Adam Street, New York, NY 535022\",\"email\":\"info@example.com\",\"phone\":\"+1 5589 55488 55s\"}', NULL, 'default', '2022-02-04 04:54:18', '2022-08-03 06:19:31'),
(152, 'blog.element', '{\"title\":\"Repellat impedit recusandae dolores provident dolore consequuntur\",\"short_description\":\"Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry\'s Standard Dummy Text Ever Since\",\"description\":\"<p><span style=\\\"font-size:16px;\\\">Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry\'s Standard Dummy Text Ever Since\\u00a0<\\/span><br><\\/p>\",\"tag\":\"Bitcoin\",\"image\":\"62dbf26f6b0eb1658581615.jpg\"}', NULL, 'default', '2022-02-05 04:55:17', '2022-08-15 17:46:14'),
(153, 'service.element', '{\"title\":\"privacy policy\",\"description\":\"<p><span style=\\\"font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;text-align:justify;\\\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like.<\\/span><br><\\/p>\",\"slug\":\"privacy\"}', NULL, 'default', '2022-02-05 17:53:04', '2022-09-11 00:00:24'),
(154, 'service.element', '{\"title\":\"Terms & Conditions\",\"description\":\"<p><span style=\\\"font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;text-align:justify;\\\">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc<\\/span><br><\\/p>\",\"slug\":\"terms\"}', NULL, 'default', '2022-02-05 18:20:18', '2022-09-11 00:00:04'),
(155, 'privacy policy.content', '{\"Title\":\"Privacy Policy\",\"Privacy_Policy\":\"<p style=\\\"text-align:justify;color:rgb(0,0,0);font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;\\\"><span style=\\\"font-weight: bolder; color: rgb(108, 117, 125); font-family: Roboto, sans-serif; font-size: 12px; text-align: left;\\\">Lorem Ipsum<\\/span><span style=\\\"color: rgb(108, 117, 125);\\\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum<\\/span><br><\\/p>\"}', NULL, 'default', '2022-02-07 21:50:50', '2022-02-07 22:18:51'),
(156, 'blog.element', '{\"title\":\"Aliquid corporis accusamus adipisci tempore unde aut accusantium.\",\"short_description\":\"Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry\'s Standard Dummy Text Ever Since\",\"description\":\"<p><span style=\\\"font-size:16px;\\\">Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry\'s Standard Dummy Text Ever Since\\u00a0<\\/span><br><\\/p>\",\"tag\":\"Crypto\",\"image\":\"62dbf27975a2b1658581625.jpg\"}', NULL, 'default', '2022-02-05 04:55:17', '2022-08-15 17:45:58'),
(157, 'blog.element', '{\"title\":\"Repudiandae debitis explicabo quos illum mollitia eum reiciendi.\",\"short_description\":\"Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry\'s Standard Dummy Text Ever Since\",\"description\":\"<p><span style=\\\"font-size:16px;\\\">Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry. Lorem Ipsum Has Been The Industry\'s Standard Dummy Text Ever Since\\u00a0<\\/span><br><\\/p>\",\"tag\":\"Coinbase\",\"image\":\"62dbf282900181658581634.jpg\"}', NULL, 'default', '2022-02-05 04:55:17', '2022-08-15 17:45:41'),
(159, 'footer.element', '{\"social_link\":\"http:\\/\\/www.facebook.com\",\"social_icon\":\"fab fa-facebook-f\"}', NULL, 'default', '2022-02-15 01:08:55', '2022-02-15 01:17:57'),
(160, 'footer.content', '{\"image\":\"631c5dc0100391662803392.png\",\"footer_short_description\":\"In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without.\"}', NULL, 'default', '2022-02-15 01:13:30', '2022-09-09 21:49:52'),
(161, 'feature.element', '{\"card_title\":\"Verified Security\",\"card_icon\":\"fas fa-user-secret\",\"card_description\":\"Lorem Ipsum, Dolor Sit Amet Consectetur Pisicing Elit. A Rem Exercitationem Adipisci Assumenda Nam Dolorum Aspernatur Repellendus Natus.\"}', NULL, 'default', '2022-04-04 17:34:11', '2022-04-13 16:38:37'),
(162, 'feature.element', '{\"card_title\":\"Instant Withdrawal\",\"card_icon\":\"fas fa-money-bill-wave\",\"card_description\":\"Lorem Ipsum, Dolor Sit Amet Consectetur Pisicing Elit. A Rem Exercitationem Adipisci Assumenda Nam Dolorum Aspernatur Repellendus Natus.\"}', NULL, 'default', '2022-04-04 17:34:17', '2022-04-13 16:38:19'),
(163, 'feature.element', '{\"card_title\":\"Registered Company\",\"card_icon\":\"fas fa-registered\",\"card_description\":\"Lorem Ipsum, Dolor Sit Amet Consectetur Pisicing Elit. A Rem Exercitationem Adipisci Assumenda Nam Dolorum Aspernatur Repellendus Natus.\"}', NULL, 'default', '2022-04-04 17:34:37', '2022-04-13 16:37:32'),
(164, 'faq.element', '{\"question\":\"How much does Transmax cost?\",\"answer\":\"We\'re committed to giving you great exchange rates and low fees every single day.\"}', NULL, 'default', '2022-04-05 16:57:20', '2022-09-13 01:30:18'),
(165, 'faq.element', '{\"question\":\"What amount of time will it require for my cash to show up?\",\"answer\":\"We\'re committed to giving you great exchange rates and low fees every single day.\"}', NULL, 'default', '2022-04-05 16:57:38', '2022-09-13 01:30:31'),
(166, 'faq.element', '{\"question\":\"How safe is transmax?\",\"answer\":\"Our site and applications are explicitly intended to guarantee we are safeguarding your record from unapproved login endeavors. We carry out severe confirmation cycles to guarantee that we completely recognize our clients as a whole. This ensures we safeguard veritable individuals and prevent lawbreakers. We have groups devoted to the observing of client records and exchanges for indications of strange action.\"}', NULL, 'default', '2022-04-05 16:57:58', '2022-09-13 01:27:19'),
(167, 'affiliate.content', '{\"title\":\"5 Steps Referral Program\"}', NULL, 'default', '2022-04-05 20:16:07', '2022-04-13 16:46:56'),
(168, 'footer.element', '{\"social_link\":\"http:\\/\\/www.linkedin.com\",\"social_icon\":\"fab fa-linkedin-in\"}', NULL, 'default', '2022-04-06 16:51:50', '2022-04-13 19:06:19'),
(169, 'footer.element', '{\"social_link\":\"http:\\/\\/www.twitter.com\",\"social_icon\":\"fab fa-twitter\"}', NULL, 'default', '2022-04-06 16:52:15', '2022-04-13 19:06:05'),
(170, 'footer.element', '{\"social_link\":\"http:\\/\\/www.pinterest.com\",\"social_icon\":\"fab fa-pinterest-p\"}', NULL, 'default', '2022-04-06 16:52:30', '2022-04-13 19:05:52'),
(171, 'testimonial.element', '{\"client_name\":\"Jamal Akter\",\"designation\":\"Freelancer\",\"answer\":\"They transfered my money. That\'s all I wanted. I am satisfied with transmax and I hope we can continue to work together peacefully.\",\"image\":\"62fb2cfe2f9fe1660628222.jpg\"}', NULL, 'default', '2022-04-10 19:34:35', '2022-09-13 01:34:06'),
(172, 'banner.element', '{\"total\":\"20K\",\"title\":\"Total Investors\"}', NULL, 'default', '2022-04-13 16:17:36', '2022-04-13 16:17:36'),
(173, 'banner.element', '{\"total\":\"100M\",\"title\":\"Total Deposit\"}', NULL, 'default', '2022-04-13 16:17:57', '2022-04-13 16:17:57'),
(174, 'banner.element', '{\"total\":\"55M\",\"title\":\"Total Withdraw\"}', NULL, 'default', '2022-04-13 16:18:09', '2022-04-13 16:18:09'),
(175, 'feature.element', '{\"card_title\":\"Secure Investment\",\"card_icon\":\"fas fa-fingerprint\",\"card_description\":\"Lorem Ipsum, Dolor Sit Amet Consectetur Pisicing Elit. A Rem Exercitationem Adipisci Assumenda Nam Dolorum Aspernatur Repellendus Natus\"}', NULL, 'default', '2022-04-13 16:34:26', '2022-04-13 16:34:26'),
(176, 'blog.content', '{\"title\":\"Blog\",\"short_description\":\"Our Latest News\"}', NULL, 'default', '2022-04-13 16:56:31', '2022-07-23 01:02:28'),
(177, 'why_choose_us.content', '{\"heading\":\"Why Choose Us\",\"title\":\"Why we are the best money transfer platform?\",\"cta_title_1\":\"Active Users\",\"cta_counter_1\":\"20K+\",\"cta_title_2\":\"Transfer Money\",\"cta_counter_2\":\"5M+\",\"cta_title_3\":\"Service Area\",\"cta_counter_3\":\"50+\",\"cta_title_4\":\"Service Area\",\"cta_counter_4\":\"10\",\"image\":\"63199bfc142991662622716.png\"}', NULL, 'default', '2022-07-23 00:15:43', '2022-09-07 19:40:31'),
(178, 'why_choose_us.element', '{\"title\":\"Sending money abroad.\",\"icon\":\"fas fa-hockey-puck\",\"description\":\"We keep things transparent when it comes to sending money. Before you make a transfer, you can use the calculator to see our fees and exchange rate upfront.\"}', NULL, 'default', '2022-07-23 00:16:06', '2022-09-13 00:36:55'),
(179, 'why_choose_us.element', '{\"title\":\"Spend anywhere, low conversion fees.\",\"icon\":\"fab fa-stripe-s\",\"description\":\"Buy things online in any currency, or pay for things on holiday. If you don\\u2019t have the currency you need in your account, we\\u2019ll auto-convert it with the lowest possible fee.\"}', NULL, 'default', '2022-07-23 00:16:14', '2022-09-15 01:37:52'),
(180, 'why_choose_us.element', '{\"title\":\"Receive money with transfermax for free\",\"icon\":\"fas fa-layer-group\",\"description\":\"Get account details around the world, for free\\r\\nGet paid like a local in AUD, CAD, EUR, GBP, HUF, NZD, RON, SGD, TRY, USD without fees no matter where you are.\"}', NULL, 'default', '2022-07-23 00:16:18', '2022-09-14 22:27:38'),
(181, 'why_choose_us.element', '{\"title\":\"Convert currencies in your Account\",\"icon\":\"far fa-money-bill-alt\",\"description\":\"You always get the real exchange rate. You\'ll only pay a small fee to convert the money in your account into another currency.\"}', NULL, 'default', '2022-07-23 00:16:23', '2022-09-15 01:38:28'),
(182, 'how_it_works.content', '{\"title\":\"HOW IT WORKS\",\"short_description\":\"Send money with TransferMax in 3 simple steps\"}', NULL, 'default', '2022-07-23 00:29:31', '2022-07-23 00:29:31'),
(183, 'how_it_works.element', '{\"image\":\"6317289b24c141662462107.png\",\"title\":\"Open a free account\",\"short_description\":\"Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ullam dolorum officiis dolor neque.\"}', NULL, 'default', '2022-07-23 00:31:47', '2022-09-05 23:01:47'),
(184, 'how_it_works.element', '{\"image\":\"631728e1bad101662462177.png\",\"title\":\"Deposit Money\",\"short_description\":\"Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ullam dolorum officiis dolor neque.\"}', NULL, 'default', '2022-07-23 00:32:25', '2022-09-05 23:02:57'),
(185, 'how_it_works.element', '{\"image\":\"631728a4e911d1662462116.png\",\"title\":\"Transfer Money\",\"short_description\":\"Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ullam dolorum officiis dolor neque.\"}', NULL, 'default', '2022-07-23 00:32:48', '2022-09-05 23:01:56'),
(186, 'cta.content', '{\"title\":\"GET STARTED\",\"short_description\":\"Global Money Transfers at Your Fingertips\",\"button_text\":\"Get Starts Now\",\"button_link\":\"login\",\"image\":\"62dbef5dcd13f1658580829.png\"}', NULL, 'default', '2022-07-23 00:53:50', '2022-09-05 20:50:25'),
(187, 'login.content', '{\"side_title\":\"Get Money within 1 Business Day or Less\",\"title\":\"Welcome to TransMax\",\"short_description\":\"Quae minima laborum deserunt, aperiam quisquam est odio veritatis ullam itaque placeat beatae facilis repellat consequatur sit dicta non fuga commodi\"}', NULL, 'default', '2022-07-23 01:33:47', '2022-07-23 01:37:41'),
(188, 'brand.element', '{\"image\":\"62fb4340dc8e01660633920.png\"}', NULL, 'default', '2022-08-15 19:12:00', '2022-08-15 19:12:00'),
(189, 'brand.element', '{\"image\":\"62fb4345c66991660633925.png\"}', NULL, 'default', '2022-08-15 19:12:05', '2022-08-15 19:12:05'),
(190, 'brand.element', '{\"image\":\"62fb434992f161660633929.png\"}', NULL, 'default', '2022-08-15 19:12:09', '2022-08-15 19:12:09'),
(191, 'brand.element', '{\"image\":\"62fb434d1f74a1660633933.png\"}', NULL, 'default', '2022-08-15 19:12:13', '2022-08-15 19:12:13'),
(192, 'brand.element', '{\"image\":\"62fb4350a38871660633936.png\"}', NULL, 'default', '2022-08-15 19:12:16', '2022-08-15 19:12:16'),
(193, 'brand.element', '{\"image\":\"62fb4353d77221660633939.png\"}', NULL, 'default', '2022-08-15 19:12:19', '2022-08-15 19:12:19'),
(194, 'brand.element', '{\"image\":\"62fb435744c4b1660633943.png\"}', NULL, 'default', '2022-08-15 19:12:23', '2022-08-15 19:12:23'),
(195, 'brand.element', '{\"image\":\"62fb435be40761660633947.png\"}', NULL, 'default', '2022-08-15 19:12:27', '2022-08-15 19:12:27'),
(196, 'about.element', '{\"icon\":\"fas fa-exchange-alt\",\"title\":\"The best money transfer platform.\",\"details\":\"Send within minutes from your phone. Status updates for you and your recipient.\"}', NULL, 'default', '2022-09-07 19:33:31', '2022-09-13 01:23:24'),
(197, 'about.element', '{\"icon\":\"fas fa-exchange-alt\",\"title\":\"Trusted by all over the world.\",\"details\":\"Every transfer carries a delivery promise. We deliver your transfer on time or your money back.\"}', NULL, 'default', '2022-09-07 19:33:46', '2022-09-13 01:22:52'),
(198, 'refferal.content', '{\"title\":\"Referral Comission\",\"details\":\"Help spread the word about our mission of money without borders. Whether you have a blog, a comparison or e-commerce site, you can earn commission for promoting . We\\u2019ll give you localized content briefs and other tools that will help you succeed.\",\"image\":\"63199e4dc2b841662623309.png\"}', NULL, 'default', '2022-09-07 19:48:29', '2022-09-13 01:24:20'),
(199, 'registration.content', '{\"image\":\"6386c91914a9e1669777689.jpeg\",\"side_title\":\"asdasda\",\"title\":\"asdasd\",\"short_description\":\"asdasd\"}', NULL, 'default', '2022-11-29 15:08:09', '2022-11-29 15:08:09'),
(200, 'how_it_works.content', '{\"top_title\":\"HOW IT WORKS\",\"title\":\"Join the 3 million users worldwide trusting Transfer everyday\",\"color_text_for_title\":\"3 million users\"}', NULL, 'theme2', '2023-01-23 03:04:30', '2023-01-29 00:00:00'),
(201, 'about.content', '{\"image\":\"63ce5bfd816331674468349.jpg\",\"heading\":\"adasdasdasdasdasd\"}', NULL, 'theme2', '2023-01-23 04:05:49', '2023-01-23 04:05:49'),
(202, 'how_it_works.element', '{\"title\":\"Open a free account\",\"short_description\":\"from anywhere in the world\",\"image\":\"63ce5e17766491674468887.png\"}', NULL, 'theme2', '2023-01-23 04:14:25', '2023-01-29 00:06:51'),
(203, 'how_it_works.element', '{\"title\":\"Deposit Money\",\"short_description\":\"to your loved ones all over the world\",\"image\":\"63ce5e21da29f1674468897.png\"}', NULL, 'theme2', '2023-01-23 04:14:57', '2023-01-29 00:07:05'),
(204, 'how_it_works.element', '{\"title\":\"Transfer Money\",\"short_description\":\"while we do the hard lifting fro you\",\"image\":\"63ce5e27af7411674468903.png\"}', NULL, 'theme2', '2023-01-23 04:15:03', '2023-01-29 00:07:17');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL COMMENT '1=Closed,2=Pending, 3=Answered',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_replies`
--

CREATE TABLE `ticket_replies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `times`
--

CREATE TABLE `times` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trx` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gateway_transaction` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `gateway_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(28,2) NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charge` decimal(28,2) NOT NULL,
  `details` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` int(11) DEFAULT 0,
  `sender_currency` bigint(20) UNSIGNED NOT NULL,
  `receiver_currency` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sender_amount` decimal(28,8) NOT NULL,
  `exchange_rate` decimal(28,8) NOT NULL,
  `charge` decimal(28,8) NOT NULL,
  `payable_amount` decimal(28,8) NOT NULL,
  `amount_in_site_currency` decimal(28,8) NOT NULL,
  `receiver_amount_in_site_currrency` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `charge_in_site_currrency` decimal(28,8) NOT NULL,
  `receiver_amount` decimal(28,8) NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` int(11) NOT NULL DEFAULT 0,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transfer_info` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_sent` int(11) NOT NULL DEFAULT 1 COMMENT '1= sent, 2 => pending, 3=> rejected',
  `reason_of_reject` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `get_paid_date` date DEFAULT NULL,
  `image` varchar(119) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_verification_code` int(11) DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=active, 0=deactivate',
  `reffered_by` bigint(20) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp(),
  `ev` tinyint(1) NOT NULL DEFAULT 0,
  `sv` tinyint(1) NOT NULL DEFAULT 0,
  `kyc` tinyint(1) NOT NULL DEFAULT 0,
  `kyc_infos` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_interests`
--

CREATE TABLE `user_interests` (
  `id` int(19) NOT NULL,
  `user_id` int(19) DEFAULT NULL,
  `payment_id` int(11) DEFAULT NULL,
  `interest_amount` float(28,8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `withdraws`
--

CREATE TABLE `withdraws` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `withdraw_method_id` bigint(20) UNSIGNED NOT NULL,
  `withdraw_amount` decimal(28,8) NOT NULL,
  `final_amount` decimal(28,8) NOT NULL DEFAULT 0.00000000,
  `withdraw_charge` decimal(28,8) NOT NULL,
  `user_withdraw_prof` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason_of_reject` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `withdraw_gateways`
--

CREATE TABLE `withdraw_gateways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_amount` decimal(28,8) NOT NULL,
  `max_amount` decimal(28,8) NOT NULL,
  `charge_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `charge` decimal(28,8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `withdraw_instruction` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `withdraw_gateways`
--

INSERT INTO `withdraw_gateways` (`id`, `name`, `min_amount`, `max_amount`, `charge_type`, `charge`, `status`, `withdraw_instruction`, `created_at`, `updated_at`) VALUES
(1, 'Stripe', '1.00000000', '50.00000000', 'fixed', '3.00000000', 1, '<p>You Have to Withdraw Amount</p>', '2022-02-05 04:45:49', '2022-04-09 22:08:55'),
(2, 'Bank Wire', '10.00000000', '10000.00000000', 'percent', '0.20000000', 1, '<div style=\"font-family: Consolas, &quot;Courier New&quot;, monospace; font-size: 14px; line-height: 19px; white-space: pre;\"><font color=\"#000000\" style=\"\"><span style=\"font-family: Helvetica;\">Lorem ipsum, <b>dolor sit </b>amet consectetur adipisicing elit.</span></font></div><div style=\"font-family: Consolas, &quot;Courier New&quot;, monospace; font-size: 14px; line-height: 19px; white-space: pre;\"><font color=\"#000000\" style=\"\"><span style=\"font-family: Helvetica;\"> Quasi reiciendis ipsam hic, optio nihil sapiente minus</span></font></div><div style=\"font-family: Consolas, &quot;Courier New&quot;, monospace; font-size: 14px; line-height: 19px; white-space: pre;\"><font color=\"#000000\" style=\"\"><span style=\"font-family: Helvetica;\"> nostrum mollitia deleniti at amet, inventore recusandae</span></font></div><div style=\"font-family: Consolas, &quot;Courier New&quot;, monospace; font-size: 14px; line-height: 19px; white-space: pre;\"><font color=\"#000000\" style=\"\"><span style=\"font-family: Helvetica;\"> temporibus, fugit maiores quia. Accusamus, cupiditate facere.</span></font></div>', '2022-04-09 22:11:32', '2022-09-17 03:04:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_securities`
--
ALTER TABLE `login_securities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_transaction_id_unique` (`transaction_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plans_plan_name_unique` (`plan_name`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reffered_commissions`
--
ALTER TABLE `reffered_commissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_money`
--
ALTER TABLE `request_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_data`
--
ALTER TABLE `section_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_data_category_foreign` (`category`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`);

--
-- Indexes for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_replies_ticket_id_foreign` (`ticket_id`),
  ADD KEY `ticket_replies_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `times`
--
ALTER TABLE `times`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_interests`
--
ALTER TABLE `user_interests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraws`
--
ALTER TABLE `withdraws`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `withdraws_transaction_id_unique` (`transaction_id`);

--
-- Indexes for table `withdraw_gateways`
--
ALTER TABLE `withdraw_gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `withdraw_gateways_name_unique` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `login_securities`
--
ALTER TABLE `login_securities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reffered_commissions`
--
ALTER TABLE `reffered_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `request_money`
--
ALTER TABLE `request_money`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section_data`
--
ALTER TABLE `section_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `times`
--
ALTER TABLE `times`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_interests`
--
ALTER TABLE `user_interests`
  MODIFY `id` int(19) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraws`
--
ALTER TABLE `withdraws`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `withdraw_gateways`
--
ALTER TABLE `withdraw_gateways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_replies`
--
ALTER TABLE `ticket_replies`
  ADD CONSTRAINT `ticket_replies_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_replies_ticket_id_foreign` FOREIGN KEY (`ticket_id`) REFERENCES `tickets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2026 at 05:11 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `3s-medicare`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admins', 'admin@site.com', 'admin', NULL, '65ab3ca7a4f281705720999.png', '$2y$12$D9Xf8T.CW8CLYFR.77jtSuCD0BbD5NKRk2CVz7cpniQ/RlfvhwtKq', 'a5EVuU67YVbLeOFDiQR4o4wMObFwaWmS4MlRdkKtTnr7S6a5tQ2GwHM5A8Tl', NULL, '2024-02-18 21:23:58');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `click_url` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_password_resets`
--

INSERT INTO `admin_password_resets` (`id`, `email`, `token`, `status`, `created_at`) VALUES
(1, 'admin@site.com', '373624', 0, '2023-04-19 21:02:14'),
(2, 'admin@site.com', '411229', 0, '2024-01-19 03:57:43'),
(3, 'admin@site.com', '438885', 1, '2024-01-19 04:26:16'),
(4, 'admin@site.com', '342212', 1, '2024-01-19 04:30:52'),
(5, 'admin@site.com', '317578', 0, '2024-01-19 04:55:02'),
(6, 'admin@site.com', '180202', 0, '2024-02-18 21:21:28'),
(7, 'admin@site.com', '132832', 0, '2024-02-18 21:23:06');

-- --------------------------------------------------------

--
-- Table structure for table `ai_requests`
--

CREATE TABLE `ai_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `solution_type` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `project_field` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_description` longtext COLLATE utf8mb4_unicode_ci,
  `objective` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `project_size` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `expected_start_date` date DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `assistant_answer_caches`
--

CREATE TABLE `assistant_answer_caches` (
  `id` bigint UNSIGNED NOT NULL,
  `query_hash` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `kb_version` int NOT NULL DEFAULT '1',
  `answer` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `sources` text COLLATE utf8mb4_unicode_ci,
  `suggested_replies` text COLLATE utf8mb4_unicode_ci,
  `suggested_route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confidence` double NOT NULL DEFAULT '0',
  `hits` int NOT NULL DEFAULT '0',
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assistant_chunks`
--

CREATE TABLE `assistant_chunks` (
  `id` bigint UNSIGNED NOT NULL,
  `assistant_document_id` bigint UNSIGNED NOT NULL,
  `ordinal` int NOT NULL DEFAULT '0',
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `embedding` blob,
  `dim` smallint NOT NULL DEFAULT '0',
  `norm` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assistant_chunks`
--

INSERT INTO `assistant_chunks` (`id`, `assistant_document_id`, `ordinal`, `lang`, `content`, `embedding`, `dim`, `norm`, `created_at`, `updated_at`) VALUES
(630, 210, 0, 'en', 'Page: 3S Medi Care - Healthcare Expertise. Our Digital Growth.\nURL: /\nDescription: Your Healthcare Expertise, Our Digital Growth. We help doctors, clinics, hospitals, and diagnostic centers build modern websites, rank #1 on Google, and simplify patient access.\nCompany: 3S Medi Care', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(631, 210, 0, 'ar', 'Page: 3S Medi Care - Healthcare Expertise. Our Digital Growth.\nURL: /\nDescription: Your Healthcare Expertise, Our Digital Growth. We help doctors, clinics, hospitals, and diagnostic centers build modern websites, rank #1 on Google, and simplify patient access.\nCompany: 3S Medi Care', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(632, 211, 0, 'en', 'Page: Healthcare Digital Growth Services\nURL: /services\nDescription: Comprehensive digital solutions tailored for healthcare practices: Medical Website Design & Development, Healthcare SEO & Google Ranking, Social Media & Marketing, Patient Appointment & Queue Systems, Medical Branding & Identity, and HIPAA Compliant Hosting.\nCompany: 3S Medi Care', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(633, 211, 0, 'ar', 'Page: Healthcare Digital Growth Services\nURL: /services\nDescription: Comprehensive digital solutions tailored for healthcare practices: Medical Website Design & Development, Healthcare SEO & Google Ranking, Social Media & Marketing, Patient Appointment & Queue Systems, Medical Branding & Identity, and HIPAA Compliant Hosting.\nCompany: 3S Medi Care', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(634, 212, 0, 'en', 'Page: About 3S Medi Care\nURL: /about-us\nDescription: Specialized healthcare digital agency. We bridge the gap between healthcare excellence and patient acquisition through modern technology, design, and search engine optimization.\nCompany: 3S Medi Care', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(635, 212, 0, 'ar', 'Page: About 3S Medi Care\nURL: /about-us\nDescription: Specialized healthcare digital agency. We bridge the gap between healthcare excellence and patient acquisition through modern technology, design, and search engine optimization.\nCompany: 3S Medi Care', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(636, 213, 0, 'en', 'Page: Request a Tailored Healthcare Quote\nURL: /get-quote\nDescription: Get a fixed-scope digital proposal and cost estimate for your practice within 24 hours. Zero obligation, 100% medical privacy compliant.\nCompany: 3S Medi Care', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(637, 213, 0, 'ar', 'Page: Request a Tailored Healthcare Quote\nURL: /get-quote\nDescription: Get a fixed-scope digital proposal and cost estimate for your practice within 24 hours. Zero obligation, 100% medical privacy compliant.\nCompany: 3S Medi Care', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(638, 214, 0, 'en', 'Page: Contact 3S Medi Care\nURL: /contact\nDescription: Get in touch with our medical digital consultants via phone at +1 (555) 234-5678 or email at info@3smedicare.com. Located at Medical Arts Plaza, Suite 400.\nCompany: 3S Medi Care', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(639, 214, 0, 'ar', 'Page: Contact 3S Medi Care\nURL: /contact\nDescription: Get in touch with our medical digital consultants via phone at +1 (555) 234-5678 or email at info@3smedicare.com. Located at Medical Arts Plaza, Suite 400.\nCompany: 3S Medi Care', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(640, 215, 0, 'en', 'Service: Website Development\nCategory: Digital Presence\nDetails: Professional, responsive websites that present your healthcare services clearly.\nKey Features: \nExplore Service: /services#website-development\nRequest a Quote: /get-quote?service=Website+Development\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(641, 215, 0, 'ar', 'Service: Website Development\nCategory: Digital Presence\nDetails: Professional, responsive websites that present your healthcare services clearly.\nKey Features: \nExplore Service: /services#website-development\nRequest a Quote: /get-quote?service=Website+Development\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(642, 216, 0, 'en', 'Service: SEO Services\nCategory: Digital Presence\nDetails: Improve how your practice appears when people search online.\nKey Features: \nExplore Service: /services#seo-services\nRequest a Quote: /get-quote?service=SEO+Services\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(643, 216, 0, 'ar', 'Service: SEO Services\nCategory: Digital Presence\nDetails: Improve how your practice appears when people search online.\nKey Features: \nExplore Service: /services#seo-services\nRequest a Quote: /get-quote?service=SEO+Services\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(644, 217, 0, 'en', 'Service: Profile Listing\nCategory: Digital Presence\nDetails: Keep your practice information visible on online listing platforms.\nKey Features: \nExplore Service: /services#profile-listing\nRequest a Quote: /get-quote?service=Profile+Listing\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(645, 217, 0, 'ar', 'Service: Profile Listing\nCategory: Digital Presence\nDetails: Keep your practice information visible on online listing platforms.\nKey Features: \nExplore Service: /services#profile-listing\nRequest a Quote: /get-quote?service=Profile+Listing\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(646, 218, 0, 'en', 'Service: Digital Marketing\nCategory: Marketing & Creative\nDetails: Plan and run campaigns around your healthcare practice.\nKey Features: \nExplore Service: /services#digital-marketing\nRequest a Quote: /get-quote?service=Digital+Marketing\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(647, 218, 0, 'ar', 'Service: Digital Marketing\nCategory: Marketing & Creative\nDetails: Plan and run campaigns around your healthcare practice.\nKey Features: \nExplore Service: /services#digital-marketing\nRequest a Quote: /get-quote?service=Digital+Marketing\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(648, 219, 0, 'en', 'Service: Social Media\nCategory: Marketing & Creative\nDetails: Consistent, engaging presence on all relevant social channels.\nKey Features: \nExplore Service: /services#social-media\nRequest a Quote: /get-quote?service=Social+Media\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(649, 219, 0, 'ar', 'Service: Social Media\nCategory: Marketing & Creative\nDetails: Consistent, engaging presence on all relevant social channels.\nKey Features: \nExplore Service: /services#social-media\nRequest a Quote: /get-quote?service=Social+Media\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(650, 220, 0, 'en', 'Service: Graphic Design\nCategory: Marketing & Creative\nDetails: Visual branding and graphics that match your clinic identity.\nKey Features: \nExplore Service: /services#graphic-design\nRequest a Quote: /get-quote?service=Graphic+Design\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(651, 220, 0, 'ar', 'Service: Graphic Design\nCategory: Marketing & Creative\nDetails: Visual branding and graphics that match your clinic identity.\nKey Features: \nExplore Service: /services#graphic-design\nRequest a Quote: /get-quote?service=Graphic+Design\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(652, 221, 0, 'en', 'Service: Facebook Ads\nCategory: Marketing & Creative\nDetails: Targeted paid reach on Facebook to attract prospective patients.\nKey Features: \nExplore Service: /services#facebook-ads\nRequest a Quote: /get-quote?service=Facebook+Ads\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(653, 221, 0, 'ar', 'Service: Facebook Ads\nCategory: Marketing & Creative\nDetails: Targeted paid reach on Facebook to attract prospective patients.\nKey Features: \nExplore Service: /services#facebook-ads\nRequest a Quote: /get-quote?service=Facebook+Ads\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(654, 222, 0, 'en', 'Service: Google Ads\nCategory: Marketing & Creative\nDetails: High-intent search visibility on Google for your medical specialties.\nKey Features: \nExplore Service: /services#google-ads\nRequest a Quote: /get-quote?service=Google+Ads\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(655, 222, 0, 'ar', 'Service: Google Ads\nCategory: Marketing & Creative\nDetails: High-intent search visibility on Google for your medical specialties.\nKey Features: \nExplore Service: /services#google-ads\nRequest a Quote: /get-quote?service=Google+Ads\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(656, 223, 0, 'en', 'Service: E-Prescription\nCategory: Patient-Focused Digital Services\nDetails: Digital prescription support and paperless record keeping.\nKey Features: \nExplore Service: /services#e-prescription\nRequest a Quote: /get-quote?service=E-Prescription\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(657, 223, 0, 'ar', 'Service: E-Prescription\nCategory: Patient-Focused Digital Services\nDetails: Digital prescription support and paperless record keeping.\nKey Features: \nExplore Service: /services#e-prescription\nRequest a Quote: /get-quote?service=E-Prescription\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(658, 224, 0, 'en', 'Service: Patient Appointment\nCategory: Patient-Focused Digital Services\nDetails: Simpler, seamless appointment booking for your patients.\nKey Features: \nExplore Service: /services#patient-appointment\nRequest a Quote: /get-quote?service=Patient+Appointment\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(659, 224, 0, 'ar', 'Service: Patient Appointment\nCategory: Patient-Focused Digital Services\nDetails: Simpler, seamless appointment booking for your patients.\nKey Features: \nExplore Service: /services#patient-appointment\nRequest a Quote: /get-quote?service=Patient+Appointment\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(660, 225, 0, 'en', 'Service: Patient Queue\nCategory: Patient-Focused Digital Services\nDetails: Clearer patient queue handling and reduced waiting room friction.\nKey Features: \nExplore Service: /services#patient-queue\nRequest a Quote: /get-quote?service=Patient+Queue\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(661, 225, 0, 'ar', 'Service: Patient Queue\nCategory: Patient-Focused Digital Services\nDetails: Clearer patient queue handling and reduced waiting room friction.\nKey Features: \nExplore Service: /services#patient-queue\nRequest a Quote: /get-quote?service=Patient+Queue\nOffered by 3S Medi Care.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(662, 226, 0, 'en', 'Maintenance\n\nWhat information do we collect?\nWe gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(663, 226, 0, 'ar', 'Maintenance\n\nWhat information do we collect?\nWe gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(664, 227, 0, 'en', 'App Download\n\nYour gate to commercial properties\nSearch easily for your desired properties\nProperties for sales, rent, auctions, and other services, all in one place\n65b3eb81481401706290049.png\n65b3eb81494e21706290049.png', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(665, 227, 0, 'ar', 'بوابتك للعقارات التجارية\n\nبوابتك للعقارات التجارية\nابحث بكل سهولة ويسر عن العقارات المناسبة لك\nعقارات للبيع, للايجار, مزادات, وخدمات أخرى, كلها بمكان واحد\n65b3eb81481401706290049.png\n65b3eb81494e21706290049.png', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(666, 228, 0, 'en', 'Hero Section\n\n+4.9 Rating\nFormed over 200+ businesses\nAmlaek… A Platform Connecting Investment with Opportunities\nA holding group and\nbusiness incubator operating as a company factory, driving\ninnovation and supporting the growth of projects and investments through an\nintegrated ecosystem that combines digital transformation, innovation, and\nsustainabilityWe develop and manage business ecosystems across strategic economic sectors,\nproviding a comprehensive environment that enables investors,\nentrepreneurs, and companies to grow and expand in both local\nand global markets.\nExplore Sectors\nExplore Investment opportunities\n25 Years of Experience\nOver 200 Commercial & Investment Activities', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(667, 228, 0, 'ar', 'أسس أكثر من 200 شركة\n\nتقييم +4.9\nأسس أكثر من 200 شركة\nتنمية الاملاك… ربط المستثمرين بالمشاريع و الموردين و الفرص الاستراتيجية\n \nمجموعة قابضة حاضنة كمصنع شركات تقود الابتكار وتدعم نمو المشاريع والاستثمارات عبر منظومة متكاملة تجمع بين التحول الرقمي، الابتكار، والاستدامةنعمل على تطوير وإدارة منظومات أعمال في قطاعات اقتصادية استراتيجية، مع توفير بيئة متكاملة لتمكين المستثمرين ورواد الأعمال والشركات من النمو والتوسع في الأسواق المحلية والعالمية\nاستكشف القطاعات\nاستكشف فرص الاستثمار\n25 عامًا من الخبرة\nأكثر من 200 نشاط تجاري واستثماري', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(668, 229, 0, 'en', 'Static Banner\n\n25+\nYears of experience in business development and investment\n200+\nCommercial and investment activities\n12+\nEconomic sectors\n100+\nLocal and international strategic partners', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(669, 229, 0, 'ar', 'Static Banner\n\n25+\nسنة من الخبرة في تطوير الأعمال والاستثمار\n200+\nنشاط تجاري و استثماري\n12+\nقطاع اقتصادي\n100+\nشريك استراتيجي محلي و دولي', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(670, 230, 0, 'en', 'Our Business Model\n\nOur Business Model\nAmlaek Development adopts a Platform-Based Investment Model that connects:\nBusiness model canvas, digital solutions, strategic planning and investor enablement.\nThis model creates an integrated environment for business development and investment growth.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(671, 230, 0, 'ar', 'تعتمد تملك على نموذج استثماري الذي يربط بين:\n\nنموذج أعمالنا\nتعتمد تملك على نموذج استثماري الذي يربط بين:\nنموذج العمل التجاري، والحلول الرقمية، والتخطيط الاستراتيجي، وتمكين المستثمرين.\nيساهم هذا النموذج في خلق بيئة متكاملة لتطوير الأعمال والاستثمار.', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(672, 231, 0, 'en', 'Our Business Model\n\nSpecialized economic incubators\nDigital platforms for projects management\nA network of strategic partners\nA unified data and communication ecosystem\nProject and initiative management teams', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(673, 231, 0, 'ar', 'الحاضنات الاقتصادية المتخصصة\n\nالحاضنات الاقتصادية المتخصصة\nالمنصات الرقمية لإدارة المشاريع\nشبكة شركاء استراتيجيين\nمنظومة بيانات واتصال موحدة\nفرق إدارة المشاريع والمبادرات', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(674, 232, 0, 'en', 'Business Network\n\nAt Amlaek, we believe that strategic partnerships are the foundation of economic growth. Therefore, we collaborate with a wide network of:', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(675, 232, 0, 'ar', 'في شركة تنمية الاملاك، نؤمن بأن الشراكات الاستراتيجية هي أساس النمو الاقتصادي. لذلك، نتعاون مع شبكة واسعة من:\n\nفي شركة تنمية الاملاك، نؤمن بأن الشراكات الاستراتيجية هي أساس النمو الاقتصادي. لذلك، نتعاون مع شبكة واسعة من:', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(676, 233, 0, 'en', 'Business Network\n\nInvestors\nCompanies\nGovernment Entities\nGovernment Entities Incubators & Accelerators\nAcademic & Research Institutions', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(677, 233, 0, 'ar', 'مستثمرين\n\nمستثمرين\nالشركات\nالجهات الحكومية\nالحاضنات والمسرعات\nالمؤسسات الأكاديمية والبحثية', NULL, 0, 0, '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(678, 234, 0, 'en', 'Start Your Journey\n\nChoose how you want to work with us Whether you are:\nAmlaek provides the integrated environment needed to achieve growth and investment success..\nExplore Opportunities\nJoin our partners\n69f7724158e251777824321.png', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(679, 234, 0, 'ar', 'اختر الطريقة التي ترغب في العمل بها معنا سواء كنت:\n\nاختر الطريقة التي ترغب في العمل بها معنا سواء كنت:\nفإن تنمية الاملاك توفر لك البيئة المتكاملة لتحقيق النمو والاستثمار.\nاستكشف الفرص\nانضم إلى شركائنا\n69f7724158e251777824321.png', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(680, 235, 0, 'en', 'Start Your Journey\n\nAn investor\nAn entrepreneur\nA company seeking expansion\nAn organization looking for a strategic partner', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(681, 235, 0, 'ar', 'مستثمراً\n\nمستثمراً\nرائد أعمال\nشركة تبحث عن التوسع\nجهة تبحث عن شريك استراتيجي', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(682, 236, 0, 'en', 'Why Amlaek\n\nWhy Amlaek', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(683, 236, 0, 'ar', 'لماذا تملك\n\nلماذا تملك', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(684, 237, 0, 'en', 'Why Amlaek\n\nA multi-sector business platform\nExtensive experience in project development and investment\nIntegrated economic incubator ecosystem\nLocal and international partnerships\nA scalable global operational model', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(685, 237, 0, 'ar', 'منصة أعمال متعددة القطاعات\n\nمنصة أعمال متعددة القطاعات\nخبرة واسعة في تطوير المشاريع والاستثمار\nنظام بيئي متكامل لحاضنات الأعمال الاقتصادية\nالشراكات المحلية والدولية\nنموذج تشغيلي عالمي قابل للتطوير', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(686, 238, 0, 'en', 'Network Economic\n\nA Network of Economic Ventures\nAmlaek manages a network of specialized economic initiatives designed to support the development of projects and sectors, including:\nThese initiatives empower entrepreneurs and companies, accelerate the growth of economic initiatives, and connect them with investment and strategic partnerships, contributing to the creation of an integrated economic ecosystem that supports innovation and sustainability.', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(687, 238, 0, 'ar', 'شبكة من المشاريع الاقتصادية\n\nشبكة من المشاريع الاقتصادية\nتدير شركة تنمية الاملاك شبكة من المبادرات الاقتصادية المتخصصة المصممة لدعم تطوير المشاريع والقطاعات، بما في ذلك:\nتعمل هذه المبادرات على تمكين رواد الأعمال والشركات، وتسريع نمو المبادرات الاقتصادية، وربطها بالاستثمار والشراكات الاستراتيجية، مما يساهم في إنشاء نظام بيئي اقتصادي متكامل يدعم الابتكار والاستدامة.', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(688, 239, 0, 'en', 'About Us\n\nAbout Amlaek\nAmlaek is the operational and investment platform of Amlaek Development Group, a diversified business group focused on \ndeveloping projects and investments through an integrated economic model that combines innovation, digital transformation, and \nsustainability.\n\nThe group manages a business ecosystem that includes more than 200 commercial and investment activities across diverse economic sectors, including technology, industry, agriculture, real estate, healthcare, trade, and logistics services, in addition to several high-growth economic sectors.\n\nThe digital platform has been designed to serve as a unified hub for managing businesses and investments, providing a centralized database, a unified communication system, and advanced digital platforms to support project management and strategic partnerships. This contributes to accelerating business growth and enhancing investment opportunities locally and internationally.', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(689, 239, 0, 'ar', 'حول تنمية الاملاك\n\nحول تنمية الاملاك\nتنمية الاملاك مجموعة أعمال متعددة الأنشطة تعمل على تطوير المشاريع والاستثمارات عبر نموذج اقتصادي متكامل يجمع بين الابتكار، التحول الرقمي، والاستدامة. تدير المجموعة منظومة أعمال تضم أكثر من 200 نشاط تجاري واستثماري في قطاعات اقتصادية متنوعة، تشمل التكنولوجيا، الصناعة، الزراعة، العقار، الصحة، التجارة والخدمات اللوجستية، إلى جانب عدد من القطاعات الاقتصادية ذات النمو المرتفع. تم تصميم المنصة الرقمية لتكون مركزاً موحداً لإدارة الأعمال والاستثمارات، حيث توفر قاعدة بيانات مركزية، ومنظومة اتصال موحدة، ومنصات رقمية متقدمة لدعم إدارة المشاريع والشراكات الاستراتيجية، مما يساهم في تسريع نمو الأعمال وتعزيز فرص الاستثمار محلياً ودولياً.', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(690, 240, 0, 'en', 'About Us\n\nInnovation\nDeveloping new ideas and solutions that \r\ncontribute to building advanced and scalable \r\nbusiness models\nPartnership\nBuilding long-term strategic relationships with investors, companies, and institutions.\nSustainability\nPromoting projects that balance economic growth with environmental and social responsibility.\nTransparency\nCommitment to clear governance and professional practices in managing businesses and investments.\nExcellence\nContinuously striving to deliver high-quality services and achieve the best results for our partners and clients.', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(691, 240, 0, 'ar', 'ابتكار\n\nابتكار\nتطوير أفكار وحلول جديدة تساهم في بناء نماذج أعمال متطورة وقابلة للتوسع.\nشراكة\nبناء علاقات استراتيجية طويلة الأمد مع المستثمرين والشركات والمؤسسات.\nالاستدامة\nتعزيز المشاريع التي تحقق توازناً بين النمو الاقتصادي والمسؤولية البيئية والاجتماعية.\nالشفافية\nالالتزام بالحوكمة الواضحة والممارسات المهنية في إدارة الأعمال والاستثمارات\nالتميز\nالسعي الدائم لتقديم خدمات عالية الجودة وتحقيق أفضل النتائج لشركائنا وعملائنا.', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(692, 241, 0, 'en', 'Our Values\n\nOur Values\nAt Amlaek Platform, we believe that successful\nbusinesses rely on a clear set of values that\nguide our decisions and partnerships,\nincluding: ', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(693, 241, 0, 'ar', 'قيمنا\n\nقيمنا\nنؤمن في منصة تنمية الاملاك بأن نجاح الاعمال يعتمد على منظومة\nقيم واضحة توجه قراراتنا وشراكاتنا، وتشمل', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(694, 242, 0, 'en', 'Our Vision\n\nOur Vision\nTo become a global multi-sector investment\nplatform that leads innovation and redefines\nbusiness ecosystems in emerging and global\nmarkets by developing high-quality projects\nand strategic partnerships that create\nsustainable value for investors, partners, and\nsociety. ', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(695, 242, 0, 'ar', 'رؤيتنا\n\nرؤيتنا\nان نكون منصة استثمار عالمية متعددة القطاعات تقود\nالابتكار وتعيد تعريف منظومات الاعمال في الاسواق\nالناشئة والعالمية، من خلال تطوير مشاريع نوعية وشراكات\nاستراتيجية تحقق قيمة مستدامة للمستثمرين والشركاء\nوالمجتمع', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(696, 243, 0, 'en', 'Our Mission\n\nOur Mission\nTo empower investments and projects through\nintegrated solutions, innovative digital\nplatforms, and strategic partnerships, with the\naim of building a modern economic\necosystem that supports sustainable growth\nand enhances innovation and expansion\nacross various economic sectors.', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(697, 243, 0, 'ar', 'رسالتنا\n\nرسالتنا\nتمكين الاستثمارات والمشاريع عبر حلول متكاملة ومنصات\nرقمية مبتكرة وشراكات استراتيجية، بهدف بناء منظومة\nاقتصادية حديثة تدعم النمو المستدام وتعزز الابتكار والتوسع\nفي مختلف القطاعات الاقتصادية', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(698, 244, 0, 'en', 'Business Sectors\n\nBusiness Sectors at Amlaek\nThe Amlaek Platform – Amlaek Development Group operates through an integrated economic ecosystem that includes a wide range of strategic sectors covering various fields of investment and business.\n\nThese sectors are designed to operate in an interconnected model based on economic projects, digital platforms, and strategic partnerships. This structure contributes to project development, attracting investments, \nand promoting sustainable growth.', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(699, 244, 0, 'ar', 'قطاعات الأعمال في تنمية الاملاك\n\nقطاعات الأعمال في تنمية الاملاك\nتعمل منصة تنمية الاملاك - مجموعة أملاك للتنمية من خلال منظومة اقتصادية متكاملة تشمل طيفًا واسعًا من القطاعات الاستراتيجية التي تغطي مجالات استثمارية وتجارية متنوعة.\n\nصُممت هذه القطاعات للعمل وفق نموذج مترابط قائم على المشاريع الاقتصادية والمنصات الرقمية والشراكات الاستراتيجية. يُسهم هذا الهيكل في تطوير المشاريع، وجذب الاستثمارات، وتعزيز النمو المستدام.', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(700, 245, 0, 'en', 'Engineering Solutions\n\nThe Engineering Solutions and\nInfrastructure Sector is one of the strategic\nsectors within the Amlaek business\necosystem, focusing on the development and\nimplementation of engineering and technical\nprojects that support urban, industrial, and\neconomic growth.\n\nThrough this sector, Amlaek provides\nintegrated solutions covering planning,\ndesign, execution, and project\nmanagement, while leveraging the latest\nengineering technologies and digital\ntransformation systems in project\nmanagement and operations.\n\nWe aim to support companies, investors, and\ngovernment entities in implementing\ninfrastructure and vital facilities projects\naccording to the highest standa \nBecome Supplier\n69e1ca5f8a92c1776405087.png\n69e1cb63ef73e1776405347.png', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(701, 245, 0, 'ar', 'Engineering Solutions\n\n.تعمل تنمية الاملاك من خلال هذا القطاع على تقديم حلول متكاملة تشمل التخطيط، التصميم، التنفيذ، وإدارة المشاريع، مع االستفادة من أحدث التقنيات الهندسية وأنظمة التحول الرقمي في إدارة وتشغيل المشاريع.\n\n.\nيُعد قطاع الحلول الهندسية والبنية التحتية أحد القطاعات\nالاستراتيجية ضمن منظومة أعمال تنمية الاملاك، حيث يركز على\nتطوير وتنفيذ المشاريع الهندسية والتقنية التي تدعم النمو\nالعمراني والصناعي واالقتصادي\n.\n\nنهدف إلى دعم الشركات والمستثمرين والجهات الحكومية\nفي تنفيذ مشاريع البنية التحتية والمرافق الحيوية وفق أعلى\nمعايير الجودة والكفاءة واالستدامة\nكن موردًا\n69e1ca5f8a92c1776405087.png\n69e1cb63ef73e1776405347.png', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(702, 246, 0, 'en', 'Sector Services\n\nSector Services\nThe Engineering Solutions and Infrastructure Sector provides a range of integrated services, including:', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(703, 246, 0, 'ar', 'خدمات القطاع\n\nخدمات القطاع\nيقدم قطاع الحلول الهندسية والبنية التحتية مجموعة من الخدمات المتكاملة، تشمل', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(704, 247, 0, 'en', 'Sector Services\n\nEngineering planning and design\nProject management and execution\nDevelopment of industrial facilities\nTechnical and engineering consulting\nDigital transformation solutions for projects\nInfrastructure development for economic zones', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(705, 247, 0, 'ar', ' التخطيط والتصميم الهندسي\n\n التخطيط والتصميم الهندسي\nإدارة وتنفيذ المشاريع\nتطوير المرافق الصناعية\n االستشارات الفنية والهندسية\nحلول التحول الرقمي للمشاريع\nتطوير البنية التحتية للمناطق االقتصادية', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(706, 248, 0, 'en', 'Added Value\n\nAdded Value\nThrough this sector, Amlaek provides an integrated ecosystem combining engineering, technical, and investment expertise, which contributes to:', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(707, 248, 0, 'ar', 'القيمة المضافة\n\nالقيمة المضافة\nتعمل تنمية الاملاك من خلال هذا القطاع على توفير منظومة متكاملة تجمع بين الخبرات الهندسية والتقنية واالستثمارية، بما يساهم في', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(708, 249, 0, 'en', 'Added Value\n\nAccelerating the execution of largescale projects\nImproving infrastructure efficiency\nSupporting urban and industrial development\nEnabling investors to implement projects efficiently\nPromoting sustainability and innovation in infrastructure projects', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(709, 249, 0, 'ar', 'تسريع تنفيذ المشاريع الكبرى\n\nتسريع تنفيذ المشاريع الكبرى\nرفع كفاءة البنية التحتية\nدعم التنمية العمرانية والصناعية\nتمكين المستثمرين من تنفيذ مشاريعهم بكفاءة عالية\nتعزيز االستدامة واالبتكار في مشاريع البنية التحتية', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(710, 250, 0, 'en', 'Investment Bot\n\nInvestment and BOT Model\nAmlaek provides advanced investment\nsolutions to support the development of\neconomic projects through flexible\npartnership models that bring together\ninvestors, government entities, and the private\nsector. One of the most important investment\nmodels adopted by the platform is the BOT\nmodel (Build – Operate – Transfer), which\nis widely used for implementing large-scale\nprojects and developing infrastructure and\neconomic facilities. \n\nThis model allows investors to participate in\nbuilding and operating projects for a\nspecified period of time before transferring\nownership to the owning entity, helping\naccelerate the implementation of strategic\nprojects without placing direct financing\nburdens on governments or project owners.', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(711, 250, 0, 'ar', 'الاستثمار ونموذجBOT\n\nالاستثمار ونموذجBOT\nتقدم تنمية الاملاك استثمارية متقدمة لدعم تطوير المشاريع\nالاقتصادية من خلال نماذج شراكة مرنة تجمع بين\nالمستثمرين والجهات الحكومية والقطاع الخاص. ويُعد\n أحد BOT (Build – Operate – Transfer) نموذج\nأهم النماذج االستثمارية التي تعتمدها المنصة لتنفيذ المشاريع\nالكبرى وتطوير البنية التحتية والمرافق االقتصادية\n\nيتيح هذا النموذج للمستثمرين المشاركة في إنشاء وتشغيل\nالمشاريع لفترة زمنية محددة قبل نقل ملكيتها إلى الجهة\nالمالكة، مما يساهم في تسريع تنفيذ المشاريع الاستراتيجية دون تحميل الحكومات أو الجهات المالكة تكاليف التمويل\nالمباشرة', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(712, 251, 0, 'en', 'What Is Bot\n\nWhat is the BOT Model?\nThis model is based on the investor or developer undertaking the following stages:', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(713, 251, 0, 'ar', 'ما هو نموذجBOT ؟\n\nما هو نموذجBOT ؟\nويعتمد هذا النموذج على قيام المستثمر أو المطور بـ:', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(714, 252, 0, 'en', 'What Is Bot\n\nBuild\nFinancing, designing, and constructing the project according to the agreed standards.\nOperate\nManaging and operating the project for a specified period to recover costs and generate investment returns.\nTransfer\nTransferring the ownership of the project to the owning entity or government authority after the concession period ends', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(715, 252, 0, 'ar', 'بناء المشروع\n\nبناء المشروع\nتمويل وتصميم وإنشاء المشروع وفق المعايير المتفق عليها\nتشغيل المشروع\nإدارة وتشغيل المشروع لفترة محددة السترداد التكلفة وتحقيق العائد االستثماري\nنقل المشروع\nنقل ملكية المشروع إلى الجهة المالكة أو الحكومية بعد انتهاء فترة االمتياز', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(716, 253, 0, 'en', 'Areas Of Bot\n\nAreas of BOT Implementation\nAmlaek supports the development and execution of BOT projects across multiple economic sectors, including:\n Infrastructure projects \n Industrial and logistics zones Ports and airports \n Energy projects \n Water and wastewater projects \n Healthcare and educational facilities \n Tourism and entertainment projects \n Smart cities and digital infrastructure ', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(717, 253, 0, 'ar', 'مجاالت تطبيق نموذجBOT\n\nمجاالت تطبيق نموذجBOT\nتدعم تنمية الاعمال تنفيذ مشاريع BOT في العديد من القطاعات االقتصادية، ومنها\n مشاريع البنية التحتية  المناطق الصناعية واللوجستية\n الموانئ والمطارات \n مشاريع الطاقة \n مشاريع المياه والصرف الصحي \n المرافق الصحية والتعليمية \n مشاريع السياحة والترفيه \n المدن الذكية والبنية التحتية الرقمية', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(718, 254, 0, 'en', 'Explore Investment Opportunities\n\nExplore Investment Opportunities\nAmlaek Development provides a variety of investment opportunities in multiple sectors including real estate, industry, trade, technology, infrastructure, and services. We work on developing high economic value investment projects and welcome investors and partners willing to participate in these opportunities and contribute to developing promising future projects. Through this page, investors can explore available opportunities and contact the investment team to study the possibility of participation or partnership in the proposed projects.', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(719, 254, 0, 'ar', 'صفحة استكشف الفرص الاستثمارية\n\nصفحة استكشف الفرص الاستثمارية\nتوفر تنمية الأملاك – مجموعة تنمية الأملاك مجموعة متنوعة من الفرص الاستثمارية في قطاعات متعددة تشمل العقارات، الصناعة، التجارة، التقنية، البنية التحتية، والخدمات.\n\nنحن نعمل على تطوير مشاريع استثمارية ذات قيمة اقتصادية عالية، ونرحب بالمستثمرين والشركاء الراغبين في المشاركة في هذه الفرص والمساهمة في تطوير مشاريع مستقبلية واعدة.\n\nمن خلال هذه الصفحة يمكن للمستثمرين التعرف على الفرص المتاحة والتواصل مع فريق الاستثمار لدراسة إمكانية المشاركة أو الشراكة في المشاريع المطروحة', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(720, 255, 0, 'en', 'Investment Sectors\n\nInvestment Sectors\nInvestment opportunities at Amlaek include several sectors, such as:', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(721, 255, 0, 'ar', 'القطاعات الاستثمارية\n\nالقطاعات الاستثمارية\nتشمل الفرص الاستثمارية في تنمية الاملاك عدة قطاعات، منها', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(722, 256, 0, 'en', 'Investment Sectors\n\nReal Estate Investment\nIndustrial Projects\nInfrastructure & Engineering\nInternational Trade & Procurement\nTechnology & Digital Transformation\nEnergy & Environment\nTourism & Entertainment', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(723, 256, 0, 'ar', 'الاستثمار العقاري\n\nالاستثمار العقاري\nالمشاريع الصناعية\nالبنية التحتية والهندسة\nالتجارة الدولية والتوريدات\nالتكنولوجيا والتحول الرقمي\nالطاقة والبيئة\nالسياحة والترفيه', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(724, 257, 0, 'en', 'Strategic Supply Sector\n\nStrategic Supply Sector\nThe Strategic Supply Sector is one of the\r\nkey sectors within the Amlaek Platform –\r\nAmlaek Development Group. It provides\r\nintegrated supply solutions for government\r\nand private sector projects and works to\r\nconnect manufacturers and suppliers with\r\nbeneficiary entities through a professional\r\nsupply system based on operational efficiency\r\nand competitive pricing.\r\n\nThe sector aims to provide comprehensive\r\nsupply solutions from the factory to the\r\nproject site, ensuring speed of execution,\r\nproduct quality, and service integration, with\r\nthe capability to meet the needs of major\r\nprojects across multiple sectors such as\r\ninfrastructure, industry, construction,\r\nhealthcare, and education.\r\n\nThe sector also supports the group’s\r\nparticipation in government and private\r\ntenders and projects by providing a wide\r\nnetwork of local and international suppliers\r\nand partners. \nBecome Supplier\n69dde16f276871776148847.png\n69dde16f535751776148847.png', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(725, 257, 0, 'ar', 'قطاع التوريدات االستراتيجية\n\nقطاع التوريدات االستراتيجية\nعد قطاع التوريدات االستراتيجية أحد القطاعات الرئيسية\r\nفي منصة تملك – مجموعة تنمية األمالك، حيث يوفر حلول\r\nتوريد متكاملة للمشاريع الحكومية والخاصة، ويعمل على\r\nربط المصانع والموردين بالجهات المستفيدة عبر منظومة\r\nتوريد احترافية تعتمد على الكفاءة التشغيلية واألسعار\r\nالتنافسية\n\nيهدف القطاع إلى توفير حلول توريد شاملة من المصنع إلى\r\nموقع المشروع، بما يضمن سرعة التنفيذ وجودة المنتجات\r\nوتكامل الخدمات، مع القدرة على تلبية احتياجات المشاريع\r\nالكبرى في قطاعات متعددة مثل البنية التحتية، الصناعة،\r\nالبناء، الصحة، والتعليم\n\nكما يعمل القطاع على دعم مشاركة المجموعة في\r\nالمناقصات والمشاريع الحكومية والخاصة عبر توفير شبكة\r\nواسعة من الموردين والشركاء المحليين والدوليين\n\n.\nكن موردًا\n69dde16f276871776148847.png\n69dde16f535751776148847.png', NULL, 0, 0, '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(726, 258, 0, 'en', 'Why Temlk\n\nA multi-sector business platform\nExtensive experience in project development and investment\nIntegrated economic incubator ecosystem\nLocal and international partnerships\nA scalable global operational model', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(727, 258, 0, 'ar', 'منصة أعمال متعددة القطاعات\n\nمنصة أعمال متعددة القطاعات\nخبرة طويلة في تطوير المشاريع و الاستثمار\nمنظومة حاضنات اقتصادية متكاملة\nشراكات محلية و دولية\nنموذج تشغيلي قابل للتوسع عالميا', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(728, 259, 0, 'en', 'Why Temlk\n\nWhy Amlaek Development?', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(729, 259, 0, 'ar', 'لماذا شركة تنمية الاملاك للتطوير؟\n\nلماذا شركة تنمية الاملاك للتطوير؟', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(730, 260, 0, 'en', 'Network Economic\n\nContributed to developing innovative business models that integrate digital transformation and sustainability to support the growth of projects and investments.\nParticipated in designing and operating incubation and business acceleration programs to support entrepreneurs and startups.\nContributed to developing digital stores and platforms that provide services supporting entrepreneurship and emerging businesses.\nContributed to preparing feasibility studies, economic analyses, and development consulting services for projects.\nParticipated in developing financing solutions and connecting projects with funding entities and financial institutions.\nContributed to the development and marketing of real estate assets, as well as the management of real estate projects and investments.\nParticipated in organizing trade missions and promoting investment opportunities and international cooperation.\nContributed to managing and operating export activities and developing export support services and international market expansion.\nContributed to developing technology solutions, digital systems, applications, and websites.\nParticipated in designing programs and initiatives that support the sustainability and growth of family businesses and connect them with specialized expertise.\nContributed to developing digital platforms for booking and managing spaces and venues for events and business activities.\nParticipated in developing specialized safety, security, and risk management solutions and products.\nContributed to providing and operating reliable support services for both the public and private sectors.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(731, 260, 0, 'ar', 'المساهمة في تطوير نماذج أعمال مبتكرة تجمع بين التحول الرقمي والاستدامة لدعم نمو المشاريع والاستثمارات.\n\nالمساهمة في تطوير نماذج أعمال مبتكرة تجمع بين التحول الرقمي والاستدامة لدعم نمو المشاريع والاستثمارات.\nالمساهمة في تصميم وتشغيل برامج احتضان وتسريع الأعمال لدعم رواد الأعمال والمشاريع الناشئة\n- المساهمة في تطوير متاجر ومنصات رقمية لتقديم الخدمات الداعمة لريادة الأعمال والمنشآت الناشئة.\nالمساهمة في إعداد دراسات الجدوى والتحليلات الاقتصادية والاستشارات التطويرية للمشاريع.\n- المساهمة في تطوير حلول تمويلية وربط المشاريع بالجهات التمويلية والمؤسسات المالية.\nالمساهمة في تطوير وتسويق الأصول العقارية وإدارة المشاريع والاستثمارات العقارية.\nالمساهمة في تنظيم البعثات التجارية وتعزيز فرص الاستثمار والتعاون الدولي.\nالمساهمة في إدارة وتشغيل عمليات التصدير وتطوير خدمات دعم الصادرات والأسواق الدولية.\n- المساهمة في تطوير الحلول التقنية والأنظمة الرقمية والتطبيقات والمواقع الإلكترونية.\nالمساهمة في تصميم برامج ومبادرات لدعم استدامة ونمو الشركات العائلية وربطها بالخبرات المتخصصة.\nالمساهمة في تطوير منصات رقمية لحجز وإدارة المساحات والمواقع المخصصة للفعاليات والأعمال.\nالمساهمة في تطوير حلول ومنتجات متخصصة في الأمن والسلامة وإدارة المخاطر.\nالمساهمة في تقديم وتشغيل خدمات مساندة موثوقة للقطاعين الحكومي والخاص.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(732, 261, 0, 'en', 'Sari Community\n\nSARI COMMUNITY\nBased on Mohammed Al Sari’s vision, which is to be an effective and contributor part and part of the change, and based on Mohammed Al Sari’s message to be a reliable strategic partner in helping others to make the right decision. Private government and non-profit sector as follows', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(733, 261, 0, 'ar', 'Sari Community\n\nمجتمع ساري\nانطلاقاً من رؤية محمد الساري، التي تتمثل في أن يكون جزءاً فاعلاً ومساهماً في التغيير، وانطلاقاً من رسالته في أن يكون شريكاً استراتيجياً موثوقاً به في مساعدة الآخرين على اتخاذ القرار الصائب، فإن القطاع الخاص والحكومي وغير الربحي يعملان على النحو التالي:', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(734, 262, 0, 'en', 'Home Hero Section\n\nYour Healthcare Digital Partner\nYour Healthcare Expertise.\nOur Digital Growth.\nWebsites, Branding, SEO and Digital Marketing for doctor, clinics, Hospitals and Diagnostic centers.\nGet a Quote\nView Our Work\nDoctors, Hospitals, Clinics, Diagnostic Centers', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(735, 262, 0, 'ar', 'Home Hero Section\n\nYour Healthcare Digital Partner\nYour Healthcare Expertise.\nOur Digital Growth.\nWebsites, Branding, SEO and Digital Marketing for doctor, clinics, Hospitals and Diagnostic centers.\nGet a Quote\nView Our Work\nDoctors, Hospitals, Clinics, Diagnostic Centers', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(736, 263, 0, 'en', 'Digital Impact Section\n\nDigital Impact\nBuild a Stronger Digital Presence for Your Healthcare Business.\nFrom professional websites and online visibility to patient-focused digital services, we help healthcare businesses create better digital experiences.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(737, 263, 0, 'ar', 'Digital Impact Section\n\nDigital Impact\nBuild a Stronger Digital Presence for Your Healthcare Business.\nFrom professional websites and online visibility to patient-focused digital services, we help healthcare businesses create better digital experiences.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(738, 264, 0, 'en', 'Who We Help Section\n\nWho We Help\nDigital Support for Every Healthcare Practice.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(739, 264, 0, 'ar', 'Who We Help Section\n\nWho We Help\nDigital Support for Every Healthcare Practice.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(740, 265, 0, 'en', 'Home Services Preview\n\nOur Services\nEverything Your Healthcare Business Needs to Grow Online.\nThree connected service groups make it easier to identify the right starting point.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(741, 265, 0, 'ar', 'Home Services Preview\n\nOur Services\nEverything Your Healthcare Business Needs to Grow Online.\nThree connected service groups make it easier to identify the right starting point.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(742, 266, 0, 'en', 'Why Choose Us Section\n\nWhy Choose Us\nHealthcare Expertise. Digital Solutions That Work for Your Practice.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(743, 266, 0, 'ar', 'Why Choose Us Section\n\nWhy Choose Us\nHealthcare Expertise. Digital Solutions That Work for Your Practice.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(744, 267, 0, 'en', 'How We Work (Process)\n\nHow We Work\nA Clear Process From Brief to Launch.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(745, 267, 0, 'ar', 'How We Work (Process)\n\nHow We Work\nA Clear Process From Brief to Launch.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(746, 268, 0, 'en', 'Our Work Showcase\n\nOur Work\nDigital Work Designed Around Healthcare Needs.\nView Case Studies', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(747, 268, 0, 'ar', 'Our Work Showcase\n\nOur Work\nDigital Work Designed Around Healthcare Needs.\nView Case Studies', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(748, 269, 0, 'en', 'Call To Action Banner\n\nReady to Strengthen Your Healthcare Online?\nTell us about your practice and the digital services you need.\nGet a Quote\nContact Us', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(749, 269, 0, 'ar', 'Call To Action Banner\n\nReady to Strengthen Your Healthcare Online?\nTell us about your practice and the digital services you need.\nGet a Quote\nContact Us', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(750, 270, 0, 'en', 'About Us Hero\n\nAbout Us\nA Digital Agency Focused on Healthcare.\nWe create professional, responsive websites that help doctors, clinics, hospitals, and diagnostic centers communicate their services clearly and provide visitors with an easy-to-use online experience.\nDiscuss Your Website\nExplore Our Services', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(751, 270, 0, 'ar', 'About Us Hero\n\nAbout Us\nA Digital Agency Focused on Healthcare.\nWe create professional, responsive websites that help doctors, clinics, hospitals, and diagnostic centers communicate their services clearly and provide visitors with an easy-to-use online experience.\nDiscuss Your Website\nExplore Our Services', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(752, 271, 0, 'en', 'About Our Approach\n\nOur Approach\nHealthcare-focused, from website to patient access', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(753, 271, 0, 'ar', 'About Our Approach\n\nOur Approach\nHealthcare-focused, from website to patient access', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(754, 272, 0, 'en', 'Services Hero\n\nOur Services\nDigital Solutions Built for Better Healthcare Growth.\nFrom healthcare websites and search visibility to digital marketing and patient-focused digital services, we help healthcare providers build a stronger digital presence.\nExplore Our Services\nBook a Consultation', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(755, 272, 0, 'ar', 'Services Hero\n\nOur Services\nDigital Solutions Built for Better Healthcare Growth.\nFrom healthcare websites and search visibility to digital marketing and patient-focused digital services, we help healthcare providers build a stronger digital presence.\nExplore Our Services\nBook a Consultation', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(756, 273, 0, 'en', 'Contact Page Banner\n\nContact Us\nTell Us About Your Practice.\nShare the digital services you need and our team will get back to you with the next steps.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(757, 273, 0, 'ar', 'Contact Page Banner\n\nContact Us\nTell Us About Your Practice.\nShare the digital services you need and our team will get back to you with the next steps.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(758, 274, 0, 'en', 'Contact Info & Quote Form\n\nGet in Touch\nWe help doctors, clinics, hospitals and diagnostic centers build a stronger online presence.\ninfo@3smedicare.com\n+1 (555) 234-5678\nMon - Fri: 9:00 AM - 6:00 PM\nMedical Arts Plaza, Suite 400', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(759, 274, 0, 'ar', 'Contact Info & Quote Form\n\nGet in Touch\nWe help doctors, clinics, hospitals and diagnostic centers build a stronger online presence.\ninfo@3smedicare.com\n+1 (555) 234-5678\nMon - Fri: 9:00 AM - 6:00 PM\nMedical Arts Plaza, Suite 400', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(760, 275, 0, 'en', 'Contact Location / Map\n\n3S Medi Care Headquarters\nMedical Arts Plaza, Suite 400', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(761, 275, 0, 'ar', 'Contact Location / Map\n\n3S Medi Care Headquarters\nMedical Arts Plaza, Suite 400', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(762, 276, 0, 'en', 'Digital Impact Section\n\nBe Found Online\nHelp patients discover your practice when they search.\nSEO Services, Profile Listing, Website Development\nassets/images/3s/card-be-found.jpg\nReach the Right Audience\nPromote your services to the people who need them.\nDigital Marketing, Facebook Ads, Google Ads\nassets/images/3s/card-reach.jpg\nSimplify Patient Access\nMake it easier for patients to reach and book you.\nPatient Appointment, Patient Queue, E-Prescription\nassets/images/3s/card-simplify.jpg', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49');
INSERT INTO `assistant_chunks` (`id`, `assistant_document_id`, `ordinal`, `lang`, `content`, `embedding`, `dim`, `norm`, `created_at`, `updated_at`) VALUES
(763, 276, 0, 'ar', 'Digital Impact Section\n\nBe Found Online\nHelp patients discover your practice when they search.\nSEO Services, Profile Listing, Website Development\nassets/images/3s/card-be-found.jpg\nReach the Right Audience\nPromote your services to the people who need them.\nDigital Marketing, Facebook Ads, Google Ads\nassets/images/3s/card-reach.jpg\nSimplify Patient Access\nMake it easier for patients to reach and book you.\nPatient Appointment, Patient Queue, E-Prescription\nassets/images/3s/card-simplify.jpg', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(764, 277, 0, 'en', 'Who We Help Section\n\nDoctors\nA professional online presence for individual practitioners.\nServices for doctors\nassets/images/3s/who-doctors.jpg\nHospitals\nConnected digital services for larger organizations.\nServices for hospitals\nassets/images/3s/who-hospitals.jpg\nClinics\nVisibility and patient access for your clinic.\nServices for clinics\nassets/images/3s/who-clinics.jpg\nDiagnostic Centers\nClear digital presence for diagnostic services.\nServices for diagnostic centers\nassets/images/3s/who-diagnostic.jpg', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(765, 277, 0, 'ar', 'Who We Help Section\n\nDoctors\nA professional online presence for individual practitioners.\nServices for doctors\nassets/images/3s/who-doctors.jpg\nHospitals\nConnected digital services for larger organizations.\nServices for hospitals\nassets/images/3s/who-hospitals.jpg\nClinics\nVisibility and patient access for your clinic.\nServices for clinics\nassets/images/3s/who-clinics.jpg\nDiagnostic Centers\nClear digital presence for diagnostic services.\nServices for diagnostic centers\nassets/images/3s/who-diagnostic.jpg', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(766, 278, 0, 'en', 'Why Choose Us Section\n\nHealthcare-Focused Approach\nBuilt around how healthcare practices work.\nConnected Digital Services\nWebsite, marketing and patient services that fit together.\nPatient-Friendly Digital Access\nSimple ways for patients to reach you.\nConsistent Brand Presence\nOne look across every channel.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(767, 278, 0, 'ar', 'Why Choose Us Section\n\nHealthcare-Focused Approach\nBuilt around how healthcare practices work.\nConnected Digital Services\nWebsite, marketing and patient services that fit together.\nPatient-Friendly Digital Access\nSimple ways for patients to reach you.\nConsistent Brand Presence\nOne look across every channel.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(768, 279, 0, 'en', 'How We Work (Process)\n\nDiscover\nWe learn about your practice audience and goals.\nStrategize\nWe shape the right digital strategy and project plan.\nDesign & Deliver\nWe design and build your website, branding or marketing solution.\nLaunch & Grow\nWe take it live and support you with ongoing improvements.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(769, 279, 0, 'ar', 'How We Work (Process)\n\nDiscover\nWe learn about your practice audience and goals.\nStrategize\nWe shape the right digital strategy and project plan.\nDesign & Deliver\nWe design and build your website, branding or marketing solution.\nLaunch & Grow\nWe take it live and support you with ongoing improvements.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(770, 280, 0, 'en', 'About Our Approach\n\nHealthcare-Focused Approach\nBuilt around how healthcare practices work.\nConnected Digital Services\nWebsite, marketing and patient services that fit together.\nPatient-Friendly Digital Access\nSimple ways for patients to reach you.\nConsistent Brand Presence\nOne look across every channel.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(771, 280, 0, 'ar', 'About Our Approach\n\nHealthcare-Focused Approach\nBuilt around how healthcare practices work.\nConnected Digital Services\nWebsite, marketing and patient services that fit together.\nPatient-Friendly Digital Access\nSimple ways for patients to reach you.\nConsistent Brand Presence\nOne look across every channel.', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(772, 281, 0, 'en', 'Get a Quote Form\n\nInstant Healthcare Quote\nRequest a Tailored Quote for Your Practice\nFill out the simple form below. Pick a category or type your custom practice type, select the services you need, and our medical growth specialists will get back to you within 24 hours.\nDoctor / Practitioner, Hospital, Specialized Clinic, Diagnostic & Imaging Center, Dental Practice, HealthTech & Startup, Other\nWebsite Design & Development, Healthcare SEO & Google Ranking, Social Media & Marketing, Patient Appointment & Queue, Branding & Identity, HIPAA Compliant Hosting\nWhy Healthcare Leaders Partner with 3S Medi Care\nWe specialize strictly in healthcare organizations. Our digital solutions are built around patient trust, medical accuracy, and conversion.\nFast 24-hour turnaround on custom proposals, 100% HIPAA & Medical Compliance focused, Specialized healthcare UI/UX design, Dedicated account manager and ongoing support\nSubmit Quote Request', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(773, 281, 0, 'ar', 'Get a Quote Form\n\nInstant Healthcare Quote\nRequest a Tailored Quote for Your Practice\nFill out the simple form below. Pick a category or type your custom practice type, select the services you need, and our medical growth specialists will get back to you within 24 hours.\nDoctor / Practitioner, Hospital, Specialized Clinic, Diagnostic & Imaging Center, Dental Practice, HealthTech & Startup, Other\nWebsite Design & Development, Healthcare SEO & Google Ranking, Social Media & Marketing, Patient Appointment & Queue, Branding & Identity, HIPAA Compliant Hosting\nWhy Healthcare Leaders Partner with 3S Medi Care\nWe specialize strictly in healthcare organizations. Our digital solutions are built around patient trust, medical accuracy, and conversion.\nFast 24-hour turnaround on custom proposals, 100% HIPAA & Medical Compliance focused, Specialized healthcare UI/UX design, Dedicated account manager and ongoing support\nSubmit Quote Request', NULL, 0, 0, '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(774, 282, 0, 'en', 'Who are we\n\nAmlaek is a leading platform specialized in marketing income-generating commercial properties, and for all the services you need at the highest international standards.', NULL, 0, 0, '2026-11-10 16:04:52', '2026-11-10 16:04:52'),
(775, 282, 0, 'ar', 'من نحن\n\nتنمية الأملاك هي منصة رائدة متخصصة في تسويق الاملاك التجارية المدرة للدخل , ولكل ما تحتاج إليه من خدمات بأعلى المعايير الدولية', NULL, 0, 0, '2026-11-10 16:04:52', '2026-11-10 16:04:52'),
(776, 283, 0, 'en', 'Kingdom of Saudi Property show Luxury Events 3\n\nThe Minister of Municipal, Rural Affairs and Housing, Chairman of the Board of Directors of the Real Estate Authority, Majid bin Abdullah Al-Hogail, inaugurates the second edition of the Second Maskan Real Estate Exhibition 2024. It is sponsored by the Ministry of Municipal, Rural Affairs and Housing and the General Real Estate Authority, and with the participation of a number of government agencies, banks, finance and real estate development companies.\nThe exhibition aims to provide a complete journey for the beneficiary to own his home by facilitating communication with developers and financing agencies and providing them with the necessary consultations. It also includes holding workshops and launching real estate investment funds. It also presented the most important real estate projects for developers, financing', NULL, 0, 0, '2026-11-10 16:04:52', '2026-11-10 16:04:52'),
(777, 283, 0, 'ar', 'المملكة العربية السعودية معرض العقارات الأحداث الفاخرة.\n\nافتتح وزير الشؤون البلدية والقروية والإسكان رئيس مجلس إدارة المؤسسة العقارية ماجد بن عبدالله الحقيل النسخة الثانية من معرض مسكن العقاري الثاني 2024 برعاية وزارة البلدية وشئون الريف والإسكان والهيئة العامة العقارية، وبمشاركة عدد من الجهات الحكومية والبنوك وشركات التمويل والتطوير العقاري.\nويهدف المعرض إلى تقديم رحلة كاملة للمستفيد لامتلاك منزله من خلال تسهيل التواصل مع المطورين وجهات التمويل وتقديم الاستشارات اللازمة لهم. كما يتضمن عقد ورش عمل وإطلاق صناديق الاستثمار العقاري. كما عرضت أهم المشاريع العقارية للمطورين والتمويل وزير الشؤون البلدية والقروية والإسكان رئيس مجلس إدارة المؤسسة العقارية ماجد بن عبدالله الحقيل يفتتح النسخة الثانية من معرض مسكن العقاري الثاني المعرض العقاري 2024. يقام برعاية وزارة الشؤون البلدية والقروية والإسكان والهيئة العامة العقارية، وبمشاركة عدد من الجهات الحكومية والبنوك وشركات التمويل والتطوير العقاري.\nويهدف المعرض إلى تقديم رحلة كاملة للمستفيد لامتلاك منزله من خلال تسهيل التواصل مع المطورين وجهات التمويل وتقديم الاستشارات اللازمة لهم. كما يتضمن عقد ورش عمل وإطلاق صناديق الاستثمار العقاري. كما عرضت أهم المشاريع العقارية للمطورين والتمويل', NULL, 0, 0, '2026-11-10 16:04:52', '2026-11-10 16:04:52'),
(778, 284, 0, 'en', 'Who are we 2\n\nAmlaek is a leading platform specialized in marketing income-generating commercial properties, and for all the services you need at the highest international standards.', NULL, 0, 0, '2026-11-10 16:04:52', '2026-11-10 16:04:52'),
(779, 284, 0, 'ar', 'من نحن\n\nتنمية الأملاك هي منصة رائدة متخصصة في تسويق الاملاك التجارية المدرة للدخل , ولكل ما تحتاج إليه من خدمات بأعلى المعايير الدولية', NULL, 0, 0, '2026-11-10 16:04:52', '2026-11-10 16:04:52'),
(780, 285, 0, 'en', 'Kingdom of Saudi Property show Luxury Events 5\n\nThe Minister of Municipal, Rural Affairs and Housing, Chairman of the Board of Directors of the Real Estate Authority, Majid bin Abdullah Al-Hogail, inaugurates the second edition of the Second Maskan Real Estate Exhibition 2024. It is sponsored by the Ministry of Municipal, Rural Affairs and Housing and the General Real Estate Authority, and with the participation of a number of government agencies, banks, finance and real estate development companies.\nThe exhibition aims to provide a complete journey for the beneficiary to own his home by facilitating communication with developers and financing agencies and providing them with the necessary consultations. It also includes holding workshops and launching real estate investment funds. It also presented the most important real estate projects for developers, financing', NULL, 0, 0, '2026-11-10 16:04:52', '2026-11-10 16:04:52'),
(781, 285, 0, 'ar', 'المملكة العربية السعودية معرض العقارات الأحداث الفاخرة.\n\nافتتح وزير الشؤون البلدية والقروية والإسكان رئيس مجلس إدارة المؤسسة العقارية ماجد بن عبدالله الحقيل النسخة الثانية من معرض مسكن العقاري الثاني 2024 برعاية وزارة البلدية وشئون الريف والإسكان والهيئة العامة العقارية، وبمشاركة عدد من الجهات الحكومية والبنوك وشركات التمويل والتطوير العقاري.\nويهدف المعرض إلى تقديم رحلة كاملة للمستفيد لامتلاك منزله من خلال تسهيل التواصل مع المطورين وجهات التمويل وتقديم الاستشارات اللازمة لهم. كما يتضمن عقد ورش عمل وإطلاق صناديق الاستثمار العقاري. كما عرضت أهم المشاريع العقارية للمطورين والتمويل وزير الشؤون البلدية والقروية والإسكان رئيس مجلس إدارة المؤسسة العقارية ماجد بن عبدالله الحقيل يفتتح النسخة الثانية من معرض مسكن العقاري الثاني المعرض العقاري 2024. يقام برعاية وزارة الشؤون البلدية والقروية والإسكان والهيئة العامة العقارية، وبمشاركة عدد من الجهات الحكومية والبنوك وشركات التمويل والتطوير العقاري.\nويهدف المعرض إلى تقديم رحلة كاملة للمستفيد لامتلاك منزله من خلال تسهيل التواصل مع المطورين وجهات التمويل وتقديم الاستشارات اللازمة لهم. كما يتضمن عقد ورش عمل وإطلاق صناديق الاستثمار العقاري. كما عرضت أهم المشاريع العقارية للمطورين والتمويل', NULL, 0, 0, '2026-11-10 16:04:52', '2026-11-10 16:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `assistant_conversations`
--

CREATE TABLE `assistant_conversations` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `session_uid` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locale` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message_count` smallint UNSIGNED NOT NULL DEFAULT '0',
  `last_message_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assistant_documents`
--

CREATE TABLE `assistant_documents` (
  `id` bigint UNSIGNED NOT NULL,
  `source_type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_hash` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chunk_count` int NOT NULL DEFAULT '0',
  `indexed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assistant_documents`
--

INSERT INTO `assistant_documents` (`id`, `source_type`, `source_key`, `route_name`, `url`, `title`, `title_ar`, `body_hash`, `chunk_count`, `indexed_at`, `created_at`, `updated_at`) VALUES
(210, 'service', 'page.home', 'home', '/', '3S Medi Care - Healthcare Expertise. Our Digital Growth.', '3S Medi Care - Healthcare Expertise. Our Digital Growth.', 'b6b086053eeefe0e965b12d92efe41c054013432', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(211, 'service', 'page.services', 'pages', '/services', 'Healthcare Digital Growth Services', 'Healthcare Digital Growth Services', '1f14f13f2523eb0906d5826fe45f82e5cf37a9e6', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(212, 'service', 'page.about-us', 'pages', '/about-us', 'About 3S Medi Care', 'About 3S Medi Care', '7ab2e7b05c47c320d57421352545907748087f5e', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(213, 'service', 'page.get-quote', 'get.quote', '/get-quote', 'Request a Tailored Healthcare Quote', 'Request a Tailored Healthcare Quote', 'ff6c2026fdb2871ccbd6c2267fad22d8fff88c36', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(214, 'service', 'page.contact', 'pages', '/contact', 'Contact 3S Medi Care', 'Contact 3S Medi Care', 'a5235fba55a49f088c584192d1ba69d4697a3e8d', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(215, 'service', 'service.1', 'get.quote', '/services#website-development', 'Website Development', 'Website Development', 'f04446315ee40a6a48b34989867ab69ef41e5cd0', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(216, 'service', 'service.2', 'get.quote', '/services#seo-services', 'SEO Services', 'SEO Services', '4d80a92f806c475a7a0c1bfc15d788af54554dc0', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(217, 'service', 'service.3', 'get.quote', '/services#profile-listing', 'Profile Listing', 'Profile Listing', '963ee545db116e94d1dd501886fb8c8eced29bb0', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(218, 'service', 'service.4', 'get.quote', '/services#digital-marketing', 'Digital Marketing', 'Digital Marketing', 'a2394091d0ab8293f9597b150bc182fbca6ff6d2', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(219, 'service', 'service.5', 'get.quote', '/services#social-media', 'Social Media', 'Social Media', '4b8a5da28b8e027bb6ddb0cbbb1baa3f8d1d6a1f', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(220, 'service', 'service.6', 'get.quote', '/services#graphic-design', 'Graphic Design', 'Graphic Design', '397e961ad4dc0dc90f55a3e01ed464afb13eb896', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(221, 'service', 'service.7', 'get.quote', '/services#facebook-ads', 'Facebook Ads', 'Facebook Ads', 'ddf03350045599fc8f86db197794894c9706439d', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(222, 'service', 'service.8', 'get.quote', '/services#google-ads', 'Google Ads', 'Google Ads', '31292058b07bf627230168c51468cf5b4aa1d14a', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(223, 'service', 'service.9', 'get.quote', '/services#e-prescription', 'E-Prescription', 'E-Prescription', '2cb1a16fa4b2286c25f5ee481d566e0712027bc0', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(224, 'service', 'service.10', 'get.quote', '/services#patient-appointment', 'Patient Appointment', 'Patient Appointment', 'da63c0cbe064861b8c4eeb25c7244a00d3226057', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(225, 'service', 'service.11', 'get.quote', '/services#patient-queue', 'Patient Queue', 'Patient Queue', '1785e879a9d05db1b3574d9e5d1a3dd5dfb70673', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(226, 'section', 'maintenance.data', NULL, '/', 'Maintenance', NULL, 'f884c1204e4f8d05fd2a23fa63d5d6bc0a497a86', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(227, 'section', 'app_download.content', NULL, '/', 'App Download', 'بوابتك للعقارات التجارية', '5596da6dd3564bfbacefdf8e1819756c5498b665', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(228, 'section', 'hero_section.content', NULL, '/', 'Hero Section', 'أسس أكثر من 200 شركة', '744fa69ec835a63e779392b82616f71ef10f0799', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(229, 'section', 'static_banner.element', NULL, '/', 'Static Banner', NULL, '8a4ed7310f2c504774a9d36945a164bf4ef02727', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(230, 'section', 'our_business_model.content', NULL, '/', 'Our Business Model', 'تعتمد تملك على نموذج استثماري الذي يربط بين:', 'd1e7164a72bb541a9c0caf5d26bc6e942aa279be', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(231, 'section', 'our_business_model.element', NULL, '/', 'Our Business Model', 'الحاضنات الاقتصادية المتخصصة', '0df7049e56bcd79ea2a1379862be4d76eb987635', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(232, 'section', 'business_network.content', NULL, '/', 'Business Network', 'في شركة تنمية الاملاك، نؤمن بأن الشراكات الاستراتيجية هي أساس النمو الاقتصادي. لذلك، نتعاون مع شبكة واسعة من:', '776eb00c1b6664414a3b3b83e0fb0b79907cfc49', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:44'),
(233, 'section', 'business_network.element', NULL, '/', 'Business Network', 'مستثمرين', 'e2e37d77a9318081bf882f8f68aafce6c17621ff', 2, '2026-11-10 16:04:44', '2026-11-10 16:04:44', '2026-11-10 16:04:47'),
(234, 'section', 'start_your_journey.content', NULL, '/', 'Start Your Journey', 'اختر الطريقة التي ترغب في العمل بها معنا سواء كنت:', '9f79b8e19309963dc575875e9a354929a0263848', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(235, 'section', 'start_your_journey.element', NULL, '/', 'Start Your Journey', 'مستثمراً', '65affc21390aa496701b7c00f3453ecfd6e9efd4', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(236, 'section', 'why_Amlaek.content', NULL, '/', 'Why Amlaek', 'لماذا تملك', 'db323169d8a43755073fbf43bb8954a2c6a25463', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(237, 'section', 'why_Amlaek.element', NULL, '/', 'Why Amlaek', 'منصة أعمال متعددة القطاعات', 'fb9de67e5e7cdd9f373e4b60cc4a647c38f5f6da', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(238, 'section', 'network_economic.content', NULL, '/', 'Network Economic', 'شبكة من المشاريع الاقتصادية', 'd9600d4cbf4b189ba79860e0cb625b1427907b48', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(239, 'section', 'about_us.content', NULL, '/', 'About Us', 'حول تنمية الاملاك', '2221ae719d8ef85062d4aab7638f32de93598a9f', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(240, 'section', 'about_us.element', NULL, '/', 'About Us', 'ابتكار', 'a13756ba136ba68cc5ffb567b23e103c70734ebe', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(241, 'section', 'our_values.content', NULL, '/', 'Our Values', 'قيمنا', '7cc9df6b66e728e0ed72ed3e4bdd4ba2671f5b18', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(242, 'section', 'our_vision.content', NULL, '/', 'Our Vision', 'رؤيتنا', '93d3d2b245dc8e51a5ef67a315b037cee77da45c', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(243, 'section', 'our_mission.content', NULL, '/', 'Our Mission', 'رسالتنا', '257beee20d912933c3098565e7c4e79458c0b80f', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(244, 'section', 'business_sectors.content', NULL, '/', 'Business Sectors', 'قطاعات الأعمال في تنمية الاملاك', '6f88a1e95836cdae31d225002f82569ceff479e5', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(245, 'section', 'engineering_solutions.content', NULL, '/', 'Engineering Solutions', NULL, 'cf47ecd9ec72bcf2f1847f42dc3e5d7613dd7743', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(246, 'section', 'sector_services.content', NULL, '/', 'Sector Services', 'خدمات القطاع', '4bc5e19e74699071188742cc98933b8fe929d014', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(247, 'section', 'sector_services.element', NULL, '/', 'Sector Services', ' التخطيط والتصميم الهندسي', 'a1766ab41485b911c4d9da691316acbc87a93482', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(248, 'section', 'added_value.content', NULL, '/', 'Added Value', 'القيمة المضافة', 'c9b99e0ebc6ce105ffac4a565a9a2ffb0b9ff930', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(249, 'section', 'added_value.element', NULL, '/', 'Added Value', 'تسريع تنفيذ المشاريع الكبرى', 'c1e5b8b697d862d7945f9d0f3bc9944ab66ae720', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(250, 'section', 'investment_bot.content', NULL, '/', 'Investment Bot', 'الاستثمار ونموذجBOT', '17aa133baf3744361409c1a2f19d05dab3808b3e', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(251, 'section', 'what_is_bot.content', NULL, '/', 'What Is Bot', 'ما هو نموذجBOT ؟', 'c8ad1e8adc274af73c3cbe0d021db88b262327c5', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(252, 'section', 'what_is_bot.element', NULL, '/', 'What Is Bot', 'بناء المشروع', 'b4cefb9635865b5a035e5ed835cea4d210923973', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(253, 'section', 'areas_of_bot.element', NULL, '/', 'Areas Of Bot', 'مجاالت تطبيق نموذجBOT', 'e16af79a954dd696a35c9a7b27e5dd5092505a47', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(254, 'section', 'explore_investment_opportunities.content', NULL, '/', 'Explore Investment Opportunities', 'صفحة استكشف الفرص الاستثمارية', 'aaee990a2a416f6c26f73f9adcd117421f97d736', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(255, 'section', 'investment_sectors.content', NULL, '/', 'Investment Sectors', 'القطاعات الاستثمارية', '4383955208d7b4795c7eec66b4f38660e665bc86', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(256, 'section', 'investment_sectors.element', NULL, '/', 'Investment Sectors', 'الاستثمار العقاري', 'dc4df67823ac88bdd38136d4bd4c9e39efb99adf', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:47'),
(257, 'section', 'strategic_supply_sector.content', NULL, '/', 'Strategic Supply Sector', 'قطاع التوريدات االستراتيجية', '93a4dc029b2dac5dccac33b0ed10e2d982fd277e', 2, '2026-11-10 16:04:47', '2026-11-10 16:04:47', '2026-11-10 16:04:49'),
(258, 'section', 'why_temlk.element', NULL, '/', 'Why Temlk', 'منصة أعمال متعددة القطاعات', '601ce5905a2fde0ad912d29eb964edb3d5488d84', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(259, 'section', 'why_temlk.content', NULL, '/', 'Why Temlk', 'لماذا شركة تنمية الاملاك للتطوير؟', '212858b8c327004027b45bfc123f876799ec924b', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(260, 'section', 'network_economic.element', NULL, '/', 'Network Economic', 'المساهمة في تطوير نماذج أعمال مبتكرة تجمع بين التحول الرقمي والاستدامة لدعم نمو المشاريع والاستثمارات.', 'd290a940b03d883f39793681be14968784886a07', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(261, 'section', 'sari_community.content', NULL, '/', 'Sari Community', NULL, '17cbbf2a6d7f1f43d59f2b5f3652716a03de4c1b', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(262, 'section', 'hero.content', NULL, '/', 'Home Hero Section', NULL, 'cbaa50504109507af05f83050bb7d19ec4f4f4b0', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(263, 'section', 'digital_impact.content', NULL, '/', 'Digital Impact Section', NULL, 'b41da6f9d64c25007ae0f69939bb98da8a483531', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(264, 'section', 'who_we_help.content', NULL, '/', 'Who We Help Section', NULL, 'f1f23452d3c9a7ec87b0ea7b0ffa3880bf6b5f66', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(265, 'section', 'services.content', NULL, '/', 'Home Services Preview', NULL, '9af2a2a91d0f0326b568c370da38113d8ab1a713', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(266, 'section', 'why_choose_us.content', NULL, '/', 'Why Choose Us Section', NULL, 'b09ea9da57ee116c503570a2ed9be0e57cfe83d8', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(267, 'section', 'process.content', NULL, '/', 'How We Work (Process)', NULL, 'eae28c5585b99aaf7527c72979090860c11a8e96', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(268, 'section', 'our_work.content', NULL, '/', 'Our Work Showcase', NULL, '9b8bc6927d93236a530f23066974dcd747277766', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(269, 'section', 'cta.content', NULL, '/', 'Call To Action Banner', NULL, 'e110aba3a47fde17e1130b37328f7313accd5234', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(270, 'section', 'about_hero.content', NULL, '/', 'About Us Hero', NULL, 'a2d017592798216a3c21e45adac1bb4ee99171fe', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(271, 'section', 'about_approach.content', NULL, '/', 'About Our Approach', NULL, 'c051a6b711171f82cd52a211a488f990c8695d27', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(272, 'section', 'services_hero.content', NULL, '/', 'Services Hero', NULL, '7d50dd3d489e7fee026ecdd4fe65d20def5eeebf', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(273, 'section', 'contact_banner.content', NULL, '/', 'Contact Page Banner', NULL, '907c0e84374ac4084e3cf35fb8d951e70c59f569', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(274, 'section', 'contact_form.content', NULL, '/', 'Contact Info & Quote Form', NULL, 'c40cd22587e055e3cbf3bd1c52ddaee00194f29d', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(275, 'section', 'contact_map.content', NULL, '/', 'Contact Location / Map', NULL, 'fc770393ca8750e43f5bc6f1699aacbfee0d086f', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(276, 'section', 'digital_impact.element', NULL, '/', 'Digital Impact Section', NULL, '190fe75cdddbb43ac6e6c0319f20e5a48c88fce4', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(277, 'section', 'who_we_help.element', NULL, '/', 'Who We Help Section', NULL, '2ed9e33336b1815e44b689b21da3bc205d656b49', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(278, 'section', 'why_choose_us.element', NULL, '/', 'Why Choose Us Section', NULL, '6edd92a05b1c0c03f4db92386c4700ec509203fb', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(279, 'section', 'process.element', NULL, '/', 'How We Work (Process)', NULL, '341a75a934c894af3c7dda0475b7d9453df461a4', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(280, 'section', 'about_approach.element', NULL, '/', 'About Our Approach', NULL, '30b0d66017d87396a494dd78ca16a5bd460941ba', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:49'),
(281, 'section', 'get_quote.content', NULL, '/', 'Get a Quote Form', NULL, '60a3d7f8ce2529d28f4e86ee3095a92dfb54f087', 2, '2026-11-10 16:04:49', '2026-11-10 16:04:49', '2026-11-10 16:04:52'),
(282, 'blog', '1', 'home', 'http://localhost', 'Who are we', 'من نحن', 'c25ee84542b275fcbfa20b637e836a480bdf75b2', 2, '2026-11-10 16:04:52', '2026-11-10 16:04:52', '2026-11-10 16:04:52'),
(283, 'blog', '2', 'home', 'http://localhost', 'Kingdom of Saudi Property show Luxury Events 3', 'المملكة العربية السعودية معرض العقارات الأحداث الفاخرة.', '7b24fd15a56a379817eca625aaddc373b70917d3', 2, '2026-11-10 16:04:52', '2026-11-10 16:04:52', '2026-11-10 16:04:52'),
(284, 'blog', '3', 'home', 'http://localhost', 'Who are we 2', 'من نحن', 'c2eaa1762840d9011d7172834ae8f2f1a02de0c5', 2, '2026-11-10 16:04:52', '2026-11-10 16:04:52', '2026-11-10 16:04:52'),
(285, 'blog', '4', 'home', 'http://localhost', 'Kingdom of Saudi Property show Luxury Events 5', 'المملكة العربية السعودية معرض العقارات الأحداث الفاخرة.', 'a5fe4d1052b23e46125c913bd7732a16dda380a3', 2, '2026-11-10 16:04:52', '2026-11-10 16:04:52', '2026-11-10 16:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `assistant_messages`
--

CREATE TABLE `assistant_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `assistant_conversation_id` bigint UNSIGNED NOT NULL,
  `assistant_query_id` bigint UNSIGNED DEFAULT NULL,
  `role` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `source_ids` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ok',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assistant_providers`
--

CREATE TABLE `assistant_providers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `purpose` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_key` text COLLATE utf8mb4_unicode_ci,
  `base_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `params` text COLLATE utf8mb4_unicode_ci,
  `priority` int NOT NULL DEFAULT '1',
  `status` tinyint NOT NULL DEFAULT '1',
  `last_check_at` timestamp NULL DEFAULT NULL,
  `last_error` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assistant_providers`
--

INSERT INTO `assistant_providers` (`id`, `name`, `driver`, `purpose`, `api_key`, `base_url`, `model`, `params`, `priority`, `status`, `last_check_at`, `last_error`, `created_at`, `updated_at`) VALUES
(1, 'Gemini (answers)', 'gemini', 'chat', 'eyJpdiI6ImN6b2FoV0RxN0hHRk02RE42a1duZHc9PSIsInZhbHVlIjoiTmNsUnkrSDFBK1UrOGNRUEVXQzlMVWlJaDNheWpNZ2NMaGcwQUpQbi80Yy9scTExdEpjR3lYeHlZUmFTQzRBM0Z2TGZTcTMwOW1QRFNWd2pqSmZuQmc9PSIsIm1hYyI6IjQwZThhNzJjMGMxODM1NzFiZDNlY2JlZWExYjQ1YmQ2MjkyNzJlMGFhZGRmZDcyNzcyNDlmOThlNDFhMzBmYTkiLCJ0YWciOiIifQ==', NULL, 'gemini-3.6-flash', '{\"embedding_model\":\"gemini-embedding-001\",\"timeout\":45,\"price_in\":0,\"price_out\":0,\"price_cached\":0}', 1, 1, '2026-11-10 16:36:07', 'Gemini HTTP 402: Your prepayment credits are depleted. Please go to AI Studio at https://ai.studio/projects to manage your project and billing. Learn more at https://ai.google.dev/gemini-api/docs/billing#prepay. ', '2026-09-07 08:41:37', '2026-11-10 16:36:07'),
(2, 'Gemini (embeddings)', 'gemini', 'embedding', 'eyJpdiI6InBSZ2NpVDNUdlZiUW9mTGFpRmFPUFE9PSIsInZhbHVlIjoicU83MDIyNmFpTDNOTkUzQllPSWJNUFdRb05TMjVZMTZWTXFaaVM5R2FkQWErdlZub1lLTzMwUEV0RHk1VllUc2lPK0N5eFZrK29JaVE1bGk2Q2xockE9PSIsIm1hYyI6IjYzMjM4YmRkMThmNTc2YzY4N2U2NmU2ZDkwNzU2Zjc1NDgwZWM4Mjg5MjFkMTM5MGI4M2UyODBmOTU2MWRmYWYiLCJ0YWciOiIifQ==', NULL, 'gemini-embedding-001', '{\"dimensions\":256,\"timeout\":60}', 1, 1, '2026-11-10 16:36:04', 'Gemini HTTP 402: Your prepayment credits are depleted. Please go to AI Studio at https://ai.studio/projects to manage your project and billing. Learn more at https://ai.google.dev/gemini-api/docs/billing#prepay. ', '2026-09-07 08:41:37', '2026-11-10 16:36:04');

-- --------------------------------------------------------

--
-- Table structure for table `assistant_queries`
--

CREATE TABLE `assistant_queries` (
  `id` bigint UNSIGNED NOT NULL,
  `assistant_provider_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `session_uid` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `query` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `query_norm` text COLLATE utf8mb4_unicode_ci,
  `query_hash` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `answer` longtext COLLATE utf8mb4_unicode_ci,
  `sources` text COLLATE utf8mb4_unicode_ci,
  `suggested_route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confidence` double NOT NULL DEFAULT '0',
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cache_layer` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `latency_ms` int NOT NULL DEFAULT '0',
  `tokens_in` int NOT NULL DEFAULT '0',
  `tokens_out` int NOT NULL DEFAULT '0',
  `tokens_cached` int NOT NULL DEFAULT '0',
  `cost_usd` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `status` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ok',
  `error` text COLLATE utf8mb4_unicode_ci,
  `ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `feedback` tinyint DEFAULT NULL,
  `clicked_route` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assistant_queries`
--

INSERT INTO `assistant_queries` (`id`, `assistant_provider_id`, `user_id`, `session_uid`, `query`, `query_norm`, `query_hash`, `lang`, `answer`, `sources`, `suggested_route`, `confidence`, `model`, `cache_layer`, `latency_ms`, `tokens_in`, `tokens_out`, `tokens_cached`, `cost_usd`, `status`, `error`, `ip`, `user_agent`, `page_url`, `feedback`, `clicked_route`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 'tell me about 3s medicare and about us', 'tell me about 3s medicare and about us', 'ebb507f5b8da611be93510904aa6fd7be6760fce8282995cff64482b8d3b5bbb', 'en', NULL, NULL, NULL, 0, NULL, 'none', 3954, 0, 0, 0, '0.000000', 'error', 'All chat providers failed. Gemini (answers): Gemini HTTP 402: Your prepayment credits are depleted. Please go to AI Studio at https://ai.studio/projects to manage your project and billing. Learn more at https://ai.google.dev/gemini-api/docs/billing#prepay. ', '127.0.0.1', NULL, NULL, NULL, 0, '2026-11-10 16:30:19', '2026-11-10 16:30:19'),
(2, NULL, NULL, 'dd99b9be6dc8d38ffd919f13b2b58830', 'about-us', 'about us', '7f04375708b83a248d64f94dabdf758b8bc735ffcfc054d77e6bad9c8b60f01c', 'en', NULL, NULL, NULL, 0, NULL, 'none', 1973, 0, 0, 0, '0.000000', 'no_answer', NULL, '127.0.0.1', 'Symfony', NULL, NULL, 0, '2026-11-10 16:32:52', '2026-11-10 16:32:52'),
(3, NULL, NULL, '703380e9717f793836a634506a431be1', 'about-us', 'about us', '7f04375708b83a248d64f94dabdf758b8bc735ffcfc054d77e6bad9c8b60f01c', 'en', NULL, NULL, NULL, 0, NULL, 'none', 6, 0, 0, 0, '0.000000', 'no_answer', NULL, '127.0.0.1', 'Symfony', NULL, NULL, 0, '2026-11-10 16:33:06', '2026-11-10 16:33:06'),
(4, NULL, NULL, '6ff6cb1fbf5c5ffe0b91c3d586db3b16', 'about-us', 'about us', '7f04375708b83a248d64f94dabdf758b8bc735ffcfc054d77e6bad9c8b60f01c', 'en', NULL, NULL, NULL, 0, NULL, 'none', 6, 0, 0, 0, '0.000000', 'no_answer', NULL, '127.0.0.1', 'Symfony', NULL, NULL, 0, '2026-11-10 16:34:43', '2026-11-10 16:34:43'),
(5, NULL, NULL, '6c542c48e5216d8a4b05cac6048c926d', 'about-us', 'about us', '7f04375708b83a248d64f94dabdf758b8bc735ffcfc054d77e6bad9c8b60f01c', 'en', NULL, NULL, NULL, 0, NULL, 'none', 4, 0, 0, 0, '0.000000', 'no_answer', NULL, '127.0.0.1', 'Symfony', NULL, NULL, 0, '2026-11-10 16:35:48', '2026-11-10 16:35:48'),
(6, NULL, NULL, 'e0df746aa938d3c60ff481e61f7a789b', 'tell me about about-us', 'tell me about about us', 'e50f0ecf916e8bf77d21ddd2ead182248cab7d96ad529298a6bd7abb42a1d933', 'en', 'Call To Action Banner Ready to Strengthen Your Healthcare Online? Tell us about your practice and the digital services you need. Get a Quote Contact Us', '[{\"id\":748,\"title\":\"Call To Action Banner\",\"url\":\"http:\\/\\/localhost\",\"route\":null,\"type\":\"section\",\"reason\":\"Relevant healthcare information\",\"score\":0.95},{\"id\":756,\"title\":\"Contact Page Banner\",\"url\":\"http:\\/\\/localhost\",\"route\":null,\"type\":\"section\",\"reason\":\"Relevant healthcare information\",\"score\":0.95}]', 'get.quote', 0.85, 'fallback-local', 'none', 4966, 0, 0, 0, '0.000000', 'ok', NULL, '127.0.0.1', 'Symfony', NULL, NULL, 0, '2026-11-10 16:36:07', '2026-11-10 16:36:07');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint UNSIGNED NOT NULL,
  `blog_category_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` text COLLATE utf8mb4_unicode_ci,
  `view` int DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `blog_category_id`, `title`, `title_ar`, `slug`, `description`, `description_ar`, `view`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Who are we', 'من نحن', 'who-are-we', '<span style=\"color: rgb(66, 66, 66); font-family: Inter, sans-serif; letter-spacing: normal;\">Amlaek is a leading platform specialized in marketing income-generating commercial properties, and for all the services you need at the highest international standards.</span>', '<span style=\"color: rgb(66, 66, 66); font-family: Inter, sans-serif; letter-spacing: normal;\">تنمية الأملاك هي منصة رائدة متخصصة في تسويق الاملاك التجارية المدرة للدخل , ولكل ما تحتاج إليه من خدمات بأعلى المعايير الدولية</span>', 181, '661f8ad2236ac1713343186.png', 'active', '2024-04-05 22:32:38', '2026-11-09 22:12:26');
INSERT INTO `blogs` (`id`, `blog_category_id`, `title`, `title_ar`, `slug`, `description`, `description_ar`, `view`, `image`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'Kingdom of Saudi Property show Luxury Events 3', 'المملكة العربية السعودية معرض العقارات الأحداث الفاخرة.', 'kingdom-of-saudi-property-show-luxury-events-3', '<span style=\"font-family: Inter, sans-serif; letter-spacing: normal; white-space-collapse: preserve; background-color: rgb(245, 251, 255);\">The Minister of Municipal, Rural Affairs and Housing, Chairman of the Board of Directors of the Real Estate Authority, Majid bin Abdullah Al-Hogail, inaugurates the second edition of the Second Maskan Real Estate Exhibition 2024. It is sponsored by the Ministry of Municipal, Rural Affairs and Housing and the General Real Estate Authority, and with the participation of a number of government agencies, banks, finance and real estate development companies.<br>The exhibition aims to provide a complete journey for the beneficiary to own his home by facilitating communication with developers and financing agencies and providing them with the necessary consultations. It also includes holding workshops and launching real estate investment funds. It also presented the most important real estate projects for developers, financing</span><span data-metadata=\"<!--(figmeta)eyJmaWxlS2V5IjoiR2pFVlkyQjVyR0VqRlNpQmRkQVJ4dyIsInBhc3RlSUQiOjMzMjI1Nzk4MiwiZGF0YVR5cGUiOiJzY2VuZSJ9Cg==(/figmeta)-->\" style=\"font-family: Inter, sans-serif; letter-spacing: normal; background-color: rgb(245, 251, 255);\"></span><span data-buffer=\"<!--(figma)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(/figma)-->\" style=\"font-family: Inter, sans-serif; letter-spacing: normal; background-color: rgb(245, 251, 255);\"></span><span style=\"font-family: Inter, sans-serif; letter-spacing: normal; white-space-collapse: preserve; background-color: rgb(245, 251, 255);\">The Minister of Municipal, Rural Affairs and Housing, Chairman of the Board of Directors of the Real Estate Authority, Majid bin Abdullah Al-Hogail, inaugurates the second edition of the Second Maskan Real Estate Exhibition 2024. It is sponsored by the Ministry of Municipal, Rural Affairs and Housing and the General Real Estate Authority, and with the participation of a number of government agencies, banks, finance and real estate development companies.<br>The exhibition aims to provide a complete journey for the beneficiary to own his home by facilitating communication with developers and financing agencies and providing them with the necessary consultations. It also includes holding workshops and launching real estate investment funds. It also presented the most important real estate projects for developers, financing&nbsp;</span><br>', '<div style=\"color: rgb(0, 0, 0); font-family: Inter, sans-serif; letter-spacing: normal; background-color: rgb(245, 251, 255);\">افتتح وزير الشؤون البلدية والقروية والإسكان رئيس مجلس إدارة المؤسسة العقارية ماجد بن عبدالله الحقيل النسخة الثانية من معرض مسكن العقاري الثاني 2024 برعاية وزارة البلدية وشئون الريف والإسكان والهيئة العامة العقارية، وبمشاركة عدد من الجهات الحكومية والبنوك وشركات التمويل والتطوير العقاري.</div><div style=\"color: rgb(0, 0, 0); font-family: Inter, sans-serif; letter-spacing: normal; background-color: rgb(245, 251, 255);\">ويهدف المعرض إلى تقديم رحلة كاملة للمستفيد لامتلاك منزله من خلال تسهيل التواصل مع المطورين وجهات التمويل وتقديم الاستشارات اللازمة لهم. كما يتضمن عقد ورش عمل وإطلاق صناديق الاستثمار العقاري. كما عرضت أهم المشاريع العقارية للمطورين والتمويل وزير الشؤون البلدية والقروية والإسكان رئيس مجلس إدارة المؤسسة العقارية ماجد بن عبدالله الحقيل يفتتح النسخة الثانية من معرض مسكن العقاري الثاني المعرض العقاري 2024. يقام برعاية وزارة الشؤون البلدية والقروية والإسكان والهيئة العامة العقارية، وبمشاركة عدد من الجهات الحكومية والبنوك وشركات التمويل والتطوير العقاري.</div><div style=\"color: rgb(0, 0, 0); font-family: Inter, sans-serif; letter-spacing: normal; background-color: rgb(245, 251, 255);\">ويهدف المعرض إلى تقديم رحلة كاملة للمستفيد لامتلاك منزله من خلال تسهيل التواصل مع المطورين وجهات التمويل وتقديم الاستشارات اللازمة لهم. كما يتضمن عقد ورش عمل وإطلاق صناديق الاستثمار العقاري. كما عرضت أهم المشاريع العقارية للمطورين والتمويل</div>', 94, '664d926215ae81716359778.png', 'active', '2024-05-22 10:36:18', '2026-11-10 11:27:15');
INSERT INTO `blogs` (`id`, `blog_category_id`, `title`, `title_ar`, `slug`, `description`, `description_ar`, `view`, `image`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'Who are we 2', 'من نحن', 'who-are-we-2', '<span style=\"color: rgb(66, 66, 66); font-family: Inter, sans-serif; letter-spacing: normal;\">Amlaek is a leading platform specialized in marketing income-generating commercial properties, and for all the services you need at the highest international standards.</span>', '<span style=\"color: rgb(66, 66, 66); font-family: Inter, sans-serif; letter-spacing: normal;\">تنمية الأملاك هي منصة رائدة متخصصة في تسويق الاملاك التجارية المدرة للدخل , ولكل ما تحتاج إليه من خدمات بأعلى المعايير الدولية</span>', 154, '661f8ad2236ac1713343186.png', 'active', '2024-04-05 22:32:38', '2026-11-10 04:21:47');
INSERT INTO `blogs` (`id`, `blog_category_id`, `title`, `title_ar`, `slug`, `description`, `description_ar`, `view`, `image`, `status`, `created_at`, `updated_at`) VALUES
(4, 1, 'Kingdom of Saudi Property show Luxury Events 5', 'المملكة العربية السعودية معرض العقارات الأحداث الفاخرة.', 'kingdom-of-saudi-property-show-luxury-events-5', '<span style=\"font-family: Inter, sans-serif; letter-spacing: normal; white-space-collapse: preserve; background-color: rgb(245, 251, 255);\">The Minister of Municipal, Rural Affairs and Housing, Chairman of the Board of Directors of the Real Estate Authority, Majid bin Abdullah Al-Hogail, inaugurates the second edition of the Second Maskan Real Estate Exhibition 2024. It is sponsored by the Ministry of Municipal, Rural Affairs and Housing and the General Real Estate Authority, and with the participation of a number of government agencies, banks, finance and real estate development companies.<br>The exhibition aims to provide a complete journey for the beneficiary to own his home by facilitating communication with developers and financing agencies and providing them with the necessary consultations. It also includes holding workshops and launching real estate investment funds. It also presented the most important real estate projects for developers, financing</span><span data-metadata=\"<!--(figmeta)eyJmaWxlS2V5IjoiR2pFVlkyQjVyR0VqRlNpQmRkQVJ4dyIsInBhc3RlSUQiOjMzMjI1Nzk4MiwiZGF0YVR5cGUiOiJzY2VuZSJ9Cg==(/figmeta)-->\" style=\"font-family: Inter, sans-serif; letter-spacing: normal; background-color: rgb(245, 251, 255);\"></span><span data-buffer=\"<!--(figma)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(/figma)-->\" style=\"font-family: Inter, sans-serif; letter-spacing: normal; background-color: rgb(245, 251, 255);\"></span><span style=\"font-family: Inter, sans-serif; letter-spacing: normal; white-space-collapse: preserve; background-color: rgb(245, 251, 255);\">The Minister of Municipal, Rural Affairs and Housing, Chairman of the Board of Directors of the Real Estate Authority, Majid bin Abdullah Al-Hogail, inaugurates the second edition of the Second Maskan Real Estate Exhibition 2024. It is sponsored by the Ministry of Municipal, Rural Affairs and Housing and the General Real Estate Authority, and with the participation of a number of government agencies, banks, finance and real estate development companies.<br>The exhibition aims to provide a complete journey for the beneficiary to own his home by facilitating communication with developers and financing agencies and providing them with the necessary consultations. It also includes holding workshops and launching real estate investment funds. It also presented the most important real estate projects for developers, financing&nbsp;</span><br>', '<div style=\"color: rgb(0, 0, 0); font-family: Inter, sans-serif; letter-spacing: normal; background-color: rgb(245, 251, 255);\">افتتح وزير الشؤون البلدية والقروية والإسكان رئيس مجلس إدارة المؤسسة العقارية ماجد بن عبدالله الحقيل النسخة الثانية من معرض مسكن العقاري الثاني 2024 برعاية وزارة البلدية وشئون الريف والإسكان والهيئة العامة العقارية، وبمشاركة عدد من الجهات الحكومية والبنوك وشركات التمويل والتطوير العقاري.</div><div style=\"color: rgb(0, 0, 0); font-family: Inter, sans-serif; letter-spacing: normal; background-color: rgb(245, 251, 255);\">ويهدف المعرض إلى تقديم رحلة كاملة للمستفيد لامتلاك منزله من خلال تسهيل التواصل مع المطورين وجهات التمويل وتقديم الاستشارات اللازمة لهم. كما يتضمن عقد ورش عمل وإطلاق صناديق الاستثمار العقاري. كما عرضت أهم المشاريع العقارية للمطورين والتمويل وزير الشؤون البلدية والقروية والإسكان رئيس مجلس إدارة المؤسسة العقارية ماجد بن عبدالله الحقيل يفتتح النسخة الثانية من معرض مسكن العقاري الثاني المعرض العقاري 2024. يقام برعاية وزارة الشؤون البلدية والقروية والإسكان والهيئة العامة العقارية، وبمشاركة عدد من الجهات الحكومية والبنوك وشركات التمويل والتطوير العقاري.</div><div style=\"color: rgb(0, 0, 0); font-family: Inter, sans-serif; letter-spacing: normal; background-color: rgb(245, 251, 255);\">ويهدف المعرض إلى تقديم رحلة كاملة للمستفيد لامتلاك منزله من خلال تسهيل التواصل مع المطورين وجهات التمويل وتقديم الاستشارات اللازمة لهم. كما يتضمن عقد ورش عمل وإطلاق صناديق الاستثمار العقاري. كما عرضت أهم المشاريع العقارية للمطورين والتمويل</div>', 105, '664d926215ae81716359778.png', 'active', '2024-05-22 10:36:18', '2026-11-10 04:29:03');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `title`, `title_ar`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Testing', 'Testing 2', NULL, 1, '2024-04-04 03:16:54', '2024-04-04 03:17:00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int DEFAULT '0',
  `type` enum('EMAIL','SMS') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'EMAIL',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `parent_id`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'User Group', 0, 'EMAIL', 1, '2024-02-28 00:41:44', '2024-02-28 00:42:16'),
(2, 'User Group 2', 0, 'EMAIL', 1, '2024-02-28 00:44:19', '2024-02-28 00:44:19');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint UNSIGNED NOT NULL,
  `country_id` int NOT NULL DEFAULT '0',
  `lat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lng` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `lat`, `lng`, `name`, `name_ar`, `image`, `created_at`, `updated_at`) VALUES
(1, 198, '24.774265', '46.738586', 'Riyadh', 'الرياض', '65d9571cbd2441708742428.png', '2024-02-10 07:46:59', '2024-02-23 20:40:29'),
(2, 198, '21.492500', '39.177570', 'Jeddah', 'جدة', NULL, '2024-02-10 07:49:24', '2024-02-10 07:49:24'),
(3, 198, '21.422510', '39.826168', 'Mecca', 'مكة المكرمة', NULL, '2024-02-10 07:50:21', '2024-02-10 08:16:05'),
(4, 198, '24.470901', '39.612236', 'Madinah', 'المدينة المنورة', NULL, '2024-02-10 07:51:46', '2024-02-10 07:51:46'),
(379, 238, '1', '12', 'dubai', 'دبي', '662cc23fec5291714209343.jpg', '2024-04-27 07:15:44', '2024-04-27 07:15:44'),
(380, 238, '13', '134', 'Abu Dhabi', 'ابو ظبي', '662cc2c683cf31714209478.jpg', '2024-04-27 07:17:58', '2024-04-27 07:18:20'),
(381, 238, '78', '87', 'Sharjah', 'الشارقة', '662cc3218cd761714209569.jpg', '2024-04-27 07:19:29', '2024-04-27 07:19:29'),
(382, 238, '56', '65', 'ِAl-ain', 'العين', '662cc36cab6a71714209644.jpg', '2024-04-27 07:20:44', '2024-04-27 07:21:00'),
(383, 238, '99', '77', 'Ajman', 'عجمان', '662cc3b5c2c341714209717.jpg', '2024-04-27 07:21:57', '2024-04-27 07:21:57'),
(384, 238, '69', '98', 'Fujairah', 'الفجيره', '662cc4027d6e41714209794.jpg', '2024-04-27 07:23:14', '2024-04-27 07:23:14'),
(385, 238, '34', '56', 'Zayed City', 'مدينة زايد', '662cc45299dd31714209874.jpg', '2024-04-27 07:24:34', '2024-04-27 07:24:34'),
(386, 238, '788', '456', 'Ras Al Khaimah', 'راس الخيمه', '662cc4f94fca31714210041.jpg', '2024-04-27 07:27:21', '2024-04-27 07:27:21'),
(387, 198, '55', '77', 'Dammam', 'الدمام', '662cc7b80496e1714210744.jpg', '2024-04-27 07:39:04', '2024-04-27 07:50:49'),
(388, 198, '45', '67', 'Tabuk', 'تبوك', '662ccab7814131714211511.jpg', '2024-04-27 07:51:51', '2024-04-27 07:51:51'),
(389, 198, '90', '99', 'Buraidah', 'بريدة', '662ccafb44a7c1714211579.jpg', '2024-04-27 07:52:59', '2024-04-27 07:52:59'),
(390, 198, '66', '44', 'Taif', 'الطائف', '662ccb329f40f1714211634.jpg', '2024-04-27 07:53:54', '2024-04-27 07:53:54'),
(391, 198, '24', '77', 'Khamis Mushait', 'خميس مشيط', '662cccc1644fe1714212033.jpg', '2024-04-27 08:00:33', '2024-04-27 08:00:33'),
(392, 198, '67', '99', 'Hail', 'حائل', '662ccceb6a90f1714212075.jpg', '2024-04-27 08:01:15', '2024-04-27 08:01:15'),
(393, 198, '888', '45', 'Najran', 'نجران', '662ccd3a6c9b71714212154.jpg', '2024-04-27 08:02:34', '2024-04-27 08:02:34'),
(394, 66, '4466', '55', 'cairo', 'القاهره', '662cce0c80dab1714212364.jpg', '2024-04-27 08:06:04', '2024-04-27 08:06:04'),
(395, 66, '33', '66', 'Giza', 'الجيزه', '662cce5cd62fa1714212444.jpg', '2024-04-27 08:07:24', '2024-04-27 08:07:24'),
(396, 66, '44', '56', 'Sixth of October', 'السادس من اكتوبر', '662ccf64212011714212708.jpg', '2024-04-27 08:11:48', '2024-04-27 08:11:48'),
(397, 66, '13', '55', 'sheikh Zayed', 'الشيخ زايد', '662ccf99d1ec01714212761.jpg', '2024-04-27 08:12:41', '2024-04-27 08:12:41'),
(398, 66, '55', '77', 'benha', 'بنها', '662ccfdb5ed6d1714212827.jpg', '2024-04-27 08:13:47', '2024-04-27 08:13:47'),
(399, 66, '10', '18', 'Beheira', 'البحيرة', '662cd04159c531714212929.jpg', '2024-04-27 08:15:29', '2024-04-27 08:15:29'),
(400, 66, '56', '78', 'Matrouh', 'مطروح', '662cd0967e64a1714213014.jpg', '2024-04-27 08:16:54', '2024-04-27 08:16:54'),
(401, 66, '77', '99', 'Damietta', 'دمياط', '662cd0f3af97e1714213107.jpg', '2024-04-27 08:18:27', '2024-04-27 08:18:27'),
(402, 66, '55', '88', 'Dakahlia', 'الدقهلية', '662cd13615fd41714213174.jpg', '2024-04-27 08:19:34', '2024-04-27 08:19:34'),
(403, 66, '7788', '66', 'Al Gharbia', 'الغربيه', '662cd1707cf2a1714213232.jpg', '2024-04-27 08:20:32', '2024-04-27 08:20:32'),
(404, 66, '77', '99', 'portsaid', 'بورسعيد', '662cd3a7be7001714213799.jpg', '2024-04-27 08:29:59', '2024-04-27 08:29:59'),
(405, 66, '567', '55', 'sharm elsheikh', 'شرم الشيخ', '662cd407a73131714213895.jpg', '2024-04-27 08:31:35', '2024-04-27 08:31:35'),
(406, 66, '55', '77', 'dahab', 'دهب', '662cd435089ec1714213941.jpg', '2024-04-27 08:32:21', '2024-04-27 08:32:21'),
(407, 66, '77', '88', 'taba', 'طابا', '662cd45622c291714213974.jpg', '2024-04-27 08:32:54', '2024-04-27 08:32:54'),
(408, 66, '33', '56', 'Hurghada', 'الغردقه', '662cd4987d6021714214040.jpg', '2024-04-27 08:34:00', '2024-04-27 08:34:00'),
(409, 232, '66', '9', 'Istanbul', 'اسطنبول', '662cd84fc13211714214991.jpg', '2024-04-27 08:49:51', '2024-04-27 08:49:51'),
(410, 232, '767', '746', 'Trabzon', 'طرابزون', '662cd8bc773d41714215100.jpg', '2024-04-27 08:51:40', '2024-04-27 08:51:40'),
(411, 232, '67', '33', 'Antalya', 'انطاليا', '662cd8e91d68b1714215145.jpg', '2024-04-27 08:52:25', '2024-04-27 08:52:25'),
(412, 232, '3', '56', 'bursa', 'بورصه', '662cd9263c7f91714215206.jpg', '2024-04-27 08:53:26', '2024-04-27 08:53:26'),
(413, 232, '224556', '666', 'Bodrum', 'بودروم', '662cd9b366b3f1714215347.jpg', '2024-04-27 08:55:47', '2024-04-27 08:55:47'),
(414, 232, '566', '878', 'Cappadocia', 'كابدوكيا', '662cd9ef13a891714215407.jpg', '2024-04-27 08:56:47', '2024-04-27 08:56:47'),
(415, 232, '55', '88', 'Kocaeli', 'كوجالي', '662cda4e0f2021714215502.jpg', '2024-04-27 08:58:22', '2024-04-27 08:58:22'),
(416, 120, '55', '77', 'Kuwait City', 'الكويت', '662cde97776891714216599.png', '2024-04-27 09:16:39', '2024-04-27 09:16:39'),
(417, 120, '66', '99', 'JAHRAA', 'الجهراء', '662cdeccc19e21714216652.png', '2024-04-27 09:17:32', '2024-04-27 09:17:32'),
(418, 120, '88', '455', 'Hawally', 'حولي', '662cdef6c103b1714216694.png', '2024-04-27 09:18:14', '2024-04-27 09:18:14'),
(419, 120, '88', '545', 'Al Farwaniyah', 'الفروانية', '662cdf2636b681714216742.png', '2024-04-27 09:19:02', '2024-04-27 09:19:02'),
(420, 120, '656', '99', 'Mubarak Al-Kabeer', 'مبارك الكبير', '662cdf54b07891714216788.png', '2024-04-27 09:19:48', '2024-04-27 09:19:48'),
(421, 120, '78', '5454', 'AHMADI', 'الاحمدي', '662cdfc8180151714216904.png', '2024-04-27 09:21:44', '2024-04-27 09:21:44'),
(422, 120, '6565', '848', 'Doha', 'الدوحة', '662ce002a60431714216962.png', '2024-04-27 09:22:42', '2024-04-27 09:22:42'),
(423, 120, '767', '545', 'Granada', 'غرناطه', '662ce0391cef41714217017.png', '2024-04-27 09:23:37', '2024-04-27 09:23:37'),
(424, 120, '989', '455', 'Qadsiya', 'القادسيه', '662ce06bc05161714217067.png', '2024-04-27 09:24:27', '2024-04-27 09:24:27'),
(425, 120, '767', '989', 'Al-Qurain', 'القرين', '662ce155e65641714217301.png', '2024-04-27 09:28:22', '2024-04-27 09:28:22'),
(426, 182, '67', '456', 'Doha', 'الدوحه', '662ce2c42ff071714217668.jpg', '2024-04-27 09:34:28', '2024-04-27 09:34:28'),
(427, 182, '22', '456', 'Al khor', 'الخور', '662ce31673f5b1714217750.jpg', '2024-04-27 09:35:50', '2024-04-27 09:35:50'),
(428, 182, '555', '437', 'Al-Shehaniya', 'الشيحانيه', '662ce34ba55251714217803.jpg', '2024-04-27 09:36:43', '2024-04-27 09:36:43'),
(429, 182, '656', '5445', 'Umm Al-Saeed', 'ام السعيد', '662d0762d3c4f1714227042.jpg', '2024-04-27 12:10:42', '2024-04-27 12:10:42'),
(430, 182, '4454', '868', 'Umm Salal', 'ام صلال', '662d079cea5101714227100.jpg', '2024-04-27 12:11:40', '2024-04-27 12:11:40'),
(431, 182, '545', '36767', 'Al Wakrah city', 'الوكرة', '662d0895ccaae1714227349.jpg', '2024-04-27 12:15:49', '2024-04-27 12:15:49'),
(432, 254, '6565', '35543', 'sohar', 'صحار', '662d092abb58e1714227498.jpg', '2024-04-27 12:18:18', '2024-04-27 12:18:18'),
(433, 169, '545', '3563', 'Muscat', 'مسقط', '662d095d2170f1714227549.jpg', '2024-04-27 12:19:09', '2024-04-27 12:19:09'),
(434, 169, '656', '847', 'Rustaq', 'الرستاق', '662d098cbb0701714227596.jpg', '2024-04-27 12:19:56', '2024-04-27 12:19:56'),
(435, 169, '6776', '6746', 'Nizwa', 'نزوي', '662d09c2224b81714227650.jpg', '2024-04-27 12:20:50', '2024-04-27 12:20:50'),
(436, 169, '4664', '736767', 'sahib', 'صحب', '662d0a003fd531714227712.jpg', '2024-04-27 12:21:52', '2024-04-27 12:21:52'),
(437, 169, '73643', '7578', 'Salalah', 'صلاله', '662d0a7d2f19a1714227837.jpg', '2024-04-27 12:23:57', '2024-04-27 12:23:57'),
(438, 169, '656', '3787', 'Khasab', 'خصب', '662d0ac7ebbe61714227911.jpg', '2024-04-27 12:25:11', '2024-04-27 12:25:11'),
(439, 169, '587785', '859', 'seeb', 'سيب', '662d0af8356491714227960.jpg', '2024-04-27 12:26:00', '2024-04-27 12:26:00'),
(440, 169, '5464', '89896', 'Bahla city', 'بهلاء', '662d0b6a11ad51714228074.jpg', '2024-04-27 12:27:54', '2024-04-27 12:27:54'),
(441, 169, '454', '8948737', 'boshar', 'بوشر', '662d0b8fa1ee11714228111.jpg', '2024-04-27 12:28:31', '2024-04-27 12:28:31'),
(442, 18, '76799', '4566', 'Manama', 'المنامه', '662d0c4c85a021714228300.jpg', '2024-04-27 12:31:40', '2024-04-27 12:31:40'),
(443, 18, '888', '57888', 'Muharraq city', 'المحرق', '662d0cea895981714228458.jpg', '2024-04-27 12:34:18', '2024-04-27 12:34:18'),
(444, 18, '9968989', '8889', 'Sitra city', 'سترة', '662d0d416c9311714228545.jpg', '2024-04-27 12:35:45', '2024-04-27 12:35:45'),
(445, 18, '7997', '675', 'Riffa City', 'الرفاع', '662d0e12e79e21714228754.jpg', '2024-04-27 12:39:14', '2024-04-27 12:39:14'),
(446, 18, '7879', '8900', 'isa', 'عيسي', '662d0ec69e9661714228934.jpg', '2024-04-27 12:42:14', '2024-04-27 12:42:14'),
(447, 18, '9889', '787676', 'Hamad', 'حمد', '662d0f5663d421714229078.jpg', '2024-04-27 12:44:38', '2024-04-27 12:44:38'),
(448, 18, '090890', '64646', 'Zayed City', 'زايد', '662d0facd08911714229164.jpg', '2024-04-27 12:46:04', '2024-04-27 12:46:04');

-- --------------------------------------------------------

--
-- Table structure for table `contact_people`
--

CREATE TABLE `contact_people` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int NOT NULL,
  `type` enum('sms','email') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_people`
--

INSERT INTO `contact_people` (`id`, `name`, `title`, `city`, `phone`, `email`, `category_id`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'MixMax', NULL, NULL, '01710528972', 'mmix00595@gmail.com', 1, 'email', 1, '2024-02-28 02:20:48', '2024-02-28 02:20:48'),
(2, 'Hasan', NULL, NULL, '01710528972', 'mdrabbihasan610@gmail.com', 1, 'email', 1, '2024-02-28 02:21:06', '2024-02-28 02:21:06'),
(4, 'MD. ABU TALEB', 'Director', 'Dhaka', '01779325718', 'abutalebgmtt@gmail.com', 1, 'email', 1, '2024-04-17 06:58:41', '2024-04-17 06:58:41'),
(5, 'test1', NULL, NULL, '8801710528972', 'test1@gmail.com', 2, 'email', 1, '2024-05-13 09:37:40', '2024-05-13 09:37:40'),
(6, 'test2', NULL, NULL, '8801710528972', 'test2@gmail.com', 2, 'email', 1, '2024-05-13 09:37:40', '2024-05-13 09:37:40'),
(7, 'test3', NULL, NULL, '8801710528972', 'test3@gmail.com', 2, 'email', 1, '2024-05-13 09:37:40', '2024-05-13 09:37:40');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso_code_2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso_code_3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `name_ar`, `iso_code_2`, `iso_code_3`, `country_code`, `flag`, `slug`, `sort_order`, `is_active`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Afghanistan', 'أفغانستان', 'af', '', '', 'af.png', 'afghanistan', NULL, 0, NULL, NULL, NULL),
(2, 'Aland Islands', 'جزر آلاند', 'ax', '', '', 'ax.png', 'aland-islands', NULL, 0, NULL, NULL, NULL),
(3, 'Albania', 'ألبانيا', 'al', '', '', 'al.png', 'albania', NULL, 0, NULL, NULL, NULL),
(4, 'Algeria', 'الجزائر', 'dz', '', '', 'dz.png', 'algeria', NULL, 0, NULL, NULL, NULL),
(5, 'American Samoa', 'ساموا الأمريكية', 'as', '', '', 'as.png', 'american-samoa', NULL, 0, NULL, NULL, NULL),
(6, 'Andorra', 'أندورا', 'ad', '', '', 'ad.png', 'andorra', NULL, 0, NULL, NULL, NULL),
(7, 'Angola', 'أنغولا', 'ao', '', '', 'ao.png', 'angola', NULL, 0, NULL, NULL, NULL),
(8, 'Anguilla', 'أنغيلا', 'ai', '', '', 'ai.png', 'anguilla', NULL, 0, NULL, NULL, NULL),
(9, 'Antarctica', 'أنتاركتيكا', 'aq', '', '', 'aq.png', 'antarctica', NULL, 0, NULL, NULL, NULL),
(10, 'Antigua and Barbuda', 'أنتيغوا وبربودا', 'ag', '', '', 'ag.png', 'antigua-and-barbuda', NULL, 0, NULL, NULL, NULL),
(11, 'Argentina', 'الأرجنتين', 'ar', '', '', 'ar.png', 'argentina', NULL, 0, NULL, NULL, NULL),
(12, 'Armenia', 'أرمينيا', 'am', '', '', 'am.png', 'armenia', NULL, 0, NULL, NULL, NULL),
(13, 'Aruba', 'أروبا', 'aw', '', '', 'aw.png', 'aruba', NULL, 0, NULL, NULL, NULL),
(14, 'Australia', 'أستراليا', 'au', '', '', 'au.png', 'australia', NULL, 0, NULL, NULL, NULL),
(15, 'Austria', 'النمسا', 'at', '', '', 'at.png', 'austria', NULL, 0, NULL, NULL, NULL),
(16, 'Azerbaijan', 'أذربيجان', 'az', '', '', 'az.png', 'azerbaijan', NULL, 0, NULL, NULL, NULL),
(17, 'Bahamas', 'جزر البهاما', 'bs', '', '', 'bs.png', 'bahamas', NULL, 0, NULL, NULL, NULL),
(18, 'Bahrain', 'البحرين', 'bh', '', '', 'bh.png', 'bahrain', 4, 0, NULL, NULL, '2024-04-18 12:11:09'),
(19, 'Bangladesh', 'بنغلاديش', 'bd', 'ban', '+880', 'bd.png', 'bangladesh', 51, 1, NULL, NULL, '2024-04-30 08:37:22'),
(20, 'Barbados', 'بربادوس', 'bb', '', '', 'bb.png', 'barbados', NULL, 0, NULL, NULL, NULL),
(21, 'Belarus', 'بيلاروسيا', 'by', '', '', 'by.png', 'belarus', NULL, 0, NULL, NULL, NULL),
(22, 'Belgium', 'بلجيكا', 'be', '', '', 'be.png', 'belgium', NULL, 0, NULL, NULL, NULL),
(23, 'Belize', 'بليز', 'bz', '', '', 'bz.png', 'belize', NULL, 0, NULL, NULL, NULL),
(24, 'Benin', 'بنين', 'bj', '', '', 'bj.png', 'benin', NULL, 0, NULL, NULL, NULL),
(25, 'Bermuda', 'برمودا', 'bm', '', '', 'bm.png', 'bermuda', NULL, 0, NULL, NULL, NULL),
(26, 'Bhutan', 'بوتان', 'bt', '', '', 'bt.png', 'bhutan', NULL, 0, NULL, NULL, NULL),
(27, 'Bolivia', 'بوليفيا', 'bo', '', '', 'bo.png', 'bolivia', NULL, 0, NULL, NULL, NULL),
(28, 'Bosnia and Herzegovina', 'البوسنة والهرسك', 'ba', '', '', 'ba.png', 'bosnia-and-herzegovina', NULL, 0, NULL, NULL, NULL),
(29, 'Botswana', 'بوتسوانا', 'bw', '', '', 'bw.png', 'botswana', NULL, 0, NULL, NULL, NULL),
(30, 'Bouvet Island', 'جزيرة بوفيت', 'bv', '', '', 'bv.png', 'bouvet-island', NULL, 0, NULL, NULL, NULL),
(31, 'Brazil', 'البرازيل', 'br', '', '', 'br.png', 'brazil', NULL, 0, NULL, NULL, NULL),
(32, 'British Indian Ocean Territory', 'إقليم المحيط البريطاني الهندي', 'io', '', '', 'io.png', 'british-indian-ocean-territory', NULL, 0, NULL, NULL, NULL),
(33, 'British Virgin Islands', 'جزر فيرجن البريطانية', 'vg', '', '', 'vg.png', 'british-virgin-islands', NULL, 0, NULL, NULL, NULL),
(34, 'Brunei', 'بروناي', 'bn', '', '', 'bn.png', 'brunei', NULL, 0, NULL, NULL, NULL),
(35, 'Bulgaria', 'بلغاريا', 'bg', '', '', 'bg.png', 'bulgaria', NULL, 0, NULL, NULL, NULL),
(36, 'Burkina Faso', 'بوركينا فاسو', 'bf', '', '', 'bf.png', 'burkina-faso', NULL, 0, NULL, NULL, NULL),
(37, 'Burundi', 'بوروندي', 'bi', '', '', 'bi.png', 'burundi', NULL, 0, NULL, NULL, NULL),
(38, 'Cambodia', 'كمبوديا', 'kh', '', '', 'kh.png', 'cambodia', NULL, 0, NULL, NULL, NULL),
(39, 'Cameroon', 'الكاميرون', 'cm', '', '', 'cm.png', 'cameroon', NULL, 0, NULL, NULL, NULL),
(40, 'Canada', 'Canada', 'ca', '', '', 'ca.png', 'canada', NULL, 0, NULL, NULL, NULL),
(41, 'Cape Verde', 'الرأس الأخضر', 'cv', '', '', 'cv.png', 'cape-verde', NULL, 0, NULL, NULL, NULL),
(42, 'Caribbean Netherlands', 'هولندا الكاريبية', 'bq', '', '', 'bq.png', 'caribbean-netherlands', NULL, 0, NULL, NULL, NULL),
(43, 'Cayman Islands', 'جزر كايمان', 'ky', '', '', 'ky.png', 'cayman-islands', NULL, 0, NULL, NULL, NULL),
(44, 'Central African Republic', 'جمهورية افريقيا الوسطى', 'cf', '', '', 'cf.png', 'central-african-republic', NULL, 0, NULL, NULL, NULL),
(45, 'Chad', 'تشاد', 'td', '', '', 'td.png', 'chad', NULL, 0, NULL, NULL, NULL),
(46, 'Chile', 'تشيلي', 'cl', '', '', 'cl.png', 'chile', NULL, 0, NULL, NULL, NULL),
(47, 'China', 'الصين', 'cn', '', '', 'cn.png', 'china', NULL, 0, NULL, NULL, NULL),
(48, 'Christmas Island', 'جزيرة الكريسماس', 'cx', '', '', 'cx.png', 'christmas-island', NULL, 0, NULL, NULL, NULL),
(49, 'Cocos Islands', 'جزر كوكوس', 'cc', '', '', 'cc.png', 'cocos-islands', NULL, 0, NULL, NULL, NULL),
(50, 'Colombia', 'كولومبيا', 'co', '', '', 'co.png', 'colombia', NULL, 0, NULL, NULL, NULL),
(51, 'Comoros', 'جزر القمر', 'km', '', '', 'km.png', 'comoros', NULL, 0, NULL, NULL, NULL),
(52, 'Cook Islands', 'جزر كوك', 'ck', '', '', 'ck.png', 'cook-islands', NULL, 0, NULL, NULL, NULL),
(53, 'Costa Rica', 'كوستا ريكا', 'cr', '', '', 'cr.png', 'costa-rica', NULL, 0, NULL, NULL, NULL),
(54, 'Côte d\'Ivoire', 'كوت ديفوار', 'ci', '', '', 'ci.png', 'cote-divoire', NULL, 0, NULL, NULL, NULL),
(55, 'Croatia', 'كرواتيا', 'hr', '', '', 'hr.png', 'croatia', NULL, 0, NULL, NULL, NULL),
(56, 'Cuba', 'كوبا', 'cu', '', '', 'cu.png', 'cuba', NULL, 0, NULL, NULL, NULL),
(57, 'Curaçao', 'كوراساو', 'cw', '', '', 'cw.png', 'curacao', NULL, 0, NULL, NULL, NULL),
(58, 'Cyprus', 'قبرص', 'cy', '', '', 'cy.png', 'cyprus', NULL, 0, NULL, NULL, NULL),
(59, 'Czechia', 'التشيك', 'cz', '', '', 'cz.png', 'czechia', NULL, 0, NULL, NULL, NULL),
(60, 'Denmark', 'الدنمارك', 'dk', '', '', 'dk.png', 'denmark', NULL, 0, NULL, NULL, NULL),
(61, 'Djibouti', 'جيبوتي', 'dj', '', '', 'dj.png', 'djibouti', NULL, 0, NULL, NULL, NULL),
(62, 'Dominica', 'دومينيكا', 'dm', '', '', 'dm.png', 'dominica', NULL, 0, NULL, NULL, NULL),
(63, 'Dominican Republic', 'جمهورية الدومينيكان', 'do', '', '', 'do.png', 'dominican-republic', NULL, 0, NULL, NULL, NULL),
(64, 'DR Congo', 'جمهورية الكونغو الديمقراطية', 'cd', '', '', 'cd.png', 'dr-congo', NULL, 0, NULL, NULL, NULL),
(65, 'Ecuador', 'الاكوادور', 'ec', '', '', 'ec.png', 'ecuador', NULL, 0, NULL, NULL, NULL),
(66, 'Egypt', 'مصر', 'eg', '', '', 'eg.png', 'egypt', 7, 0, NULL, NULL, '2024-04-18 12:12:10'),
(67, 'El Salvador', 'السلفادور', 'sv', '', '', 'sv.png', 'el-salvador', NULL, 0, NULL, NULL, NULL),
(68, 'England', 'إنكلترا', 'gb-eng', '', '', 'gb-eng.png', 'england', NULL, 0, NULL, NULL, NULL),
(69, 'Equatorial Guinea', 'غينيا الإستوائية', 'gq', '', '', 'gq.png', 'equatorial-guinea', NULL, 0, NULL, NULL, NULL),
(70, 'Eritrea', 'إريتريا', 'er', '', '', 'er.png', 'eritrea', NULL, 0, NULL, NULL, NULL),
(71, 'Estonia', 'إستونيا', 'ee', '', '', 'ee.png', 'estonia', NULL, 0, NULL, NULL, NULL),
(72, 'Eswatini', 'إيسواتيني', 'sz', '', '', 'sz.png', 'eswatini', NULL, 0, NULL, NULL, NULL),
(73, 'Ethiopia', 'أثيوبيا', 'et', '', '', 'et.png', 'ethiopia', NULL, 0, NULL, NULL, NULL),
(74, 'Falkland Islands', 'جزر فوكلاند', 'fk', '', '', 'fk.png', 'falkland-islands', NULL, 0, NULL, NULL, NULL),
(75, 'Faroe Islands', 'جزر فاروس', 'fo', '', '', 'fo.png', 'faroe-islands', NULL, 0, NULL, NULL, NULL),
(76, 'Fiji', 'فيجي', 'fj', '', '', 'fj.png', 'fiji', NULL, 0, NULL, NULL, NULL),
(77, 'Finland', 'فنلندا', 'fi', '', '', 'fi.png', 'finland', NULL, 0, NULL, NULL, NULL),
(78, 'France', 'فرنسا', 'fr', '', '', 'fr.png', 'france', NULL, 0, NULL, NULL, NULL),
(79, 'French Guiana', 'غيانا الفرنسية', 'gf', '', '', 'gf.png', 'french-guiana', NULL, 0, NULL, NULL, NULL),
(80, 'French Polynesia', 'بولينيزيا الفرنسية', 'pf', '', '', 'pf.png', 'french-polynesia', NULL, 0, NULL, NULL, NULL),
(81, 'French Southern and Antarctic Lands', 'الأراضي الفرنسية الجنوبية وأنتاركتيكا', 'tf', '', '', 'tf.png', 'french-southern-and-antarctic-lands', NULL, 0, NULL, NULL, NULL),
(82, 'Gabon', 'الجابون', 'ga', '', '', 'ga.png', 'gabon', NULL, 0, NULL, NULL, NULL),
(83, 'Gambia', 'غامبيا', 'gm', '', '', 'gm.png', 'gambia', NULL, 0, NULL, NULL, NULL),
(84, 'Georgia', 'جورجيا', 'ge', '', '', 'ge.png', 'georgia', NULL, 0, NULL, NULL, NULL),
(85, 'Germany', 'ألمانيا', 'de', '', '', 'de.png', 'germany', NULL, 0, NULL, NULL, NULL),
(86, 'Ghana', 'غانا', 'gh', '', '', 'gh.png', 'ghana', NULL, 0, NULL, NULL, NULL),
(87, 'Gibraltar', 'جبل طارق', 'gi', '', '', 'gi.png', 'gibraltar', NULL, 0, NULL, NULL, NULL),
(88, 'Greece', 'اليونان', 'gr', '', '', 'gr.png', 'greece', NULL, 0, NULL, NULL, NULL),
(89, 'Greenland', 'الأرض الخضراء', 'gl', '', '', 'gl.png', 'greenland', NULL, 0, NULL, NULL, NULL),
(90, 'Grenada', 'غرينادا', 'gd', '', '', 'gd.png', 'grenada', NULL, 0, NULL, NULL, NULL),
(91, 'Guadeloupe', 'جوادلوب', 'gp', '', '', 'gp.png', 'guadeloupe', NULL, 0, NULL, NULL, NULL),
(92, 'Guam', 'غوام', 'gu', '', '', 'gu.png', 'guam', NULL, 0, NULL, NULL, NULL),
(93, 'Guatemala', 'غواتيمالا', 'gt', '', '', 'gt.png', 'guatemala', NULL, 0, NULL, NULL, NULL),
(94, 'Guernsey', 'غيرنسي', 'gg', '', '', 'gg.png', 'guernsey', NULL, 0, NULL, NULL, NULL),
(95, 'Guinea', 'غينيا', 'gn', '', '', 'gn.png', 'guinea', NULL, 0, NULL, NULL, NULL),
(96, 'Guinea-Bissau', 'غينيا بيساو', 'gw', '', '', 'gw.png', 'guinea-bissau', NULL, 0, NULL, NULL, NULL),
(97, 'Guyana', 'غيانا', 'gy', '', '', 'gy.png', 'guyana', NULL, 0, NULL, NULL, NULL),
(98, 'Haiti', 'هايتي', 'ht', '', '', 'ht.png', 'haiti', NULL, 0, NULL, NULL, NULL),
(99, 'Heard Island and McDonald Islands', 'قلب الجزيرة وجزر ماكدونالز', 'hm', '', '', 'hm.png', 'heard-island-and-mcdonald-islands', NULL, 0, NULL, NULL, NULL),
(100, 'Honduras', 'هندوراس', 'hn', '', '', 'hn.png', 'honduras', NULL, 0, NULL, NULL, NULL),
(101, 'Hong Kong', 'هونج كونج', 'hk', '', '', 'hk.png', 'hong-kong', NULL, 0, NULL, NULL, NULL),
(102, 'Hungary', 'هنغاريا', 'hu', '', '', 'hu.png', 'hungary', NULL, 0, NULL, NULL, NULL),
(103, 'Iceland', 'أيسلندا', 'is', '', '', 'is.png', 'iceland', NULL, 0, NULL, NULL, NULL),
(104, 'India', 'الهند', 'in', '', '', 'in.png', 'india', NULL, 0, NULL, NULL, NULL),
(105, 'Indonesia', 'إندونيسيا', 'id', '', '', 'id.png', 'indonesia', NULL, 0, NULL, NULL, NULL),
(106, 'Iran', 'إيران', 'ir', '', '', 'ir.png', 'iran', NULL, 0, NULL, NULL, NULL),
(107, 'Iraq', 'العراق', 'iq', '', '', 'iq.png', 'iraq', NULL, 0, NULL, NULL, NULL),
(108, 'Ireland', 'أيرلندا', 'ie', '', '', 'ie.png', 'ireland', NULL, 0, NULL, NULL, NULL),
(109, 'Isle of Man', 'جزيرة آيل أوف مان', 'im', '', '', 'im.png', 'isle-of-man', NULL, 0, NULL, NULL, NULL),
(110, 'Israel', 'إسرائيل', 'il', '', '', 'il.png', 'israel', NULL, 0, NULL, NULL, NULL),
(111, 'Italy', 'إيطاليا', 'it', '', '', 'it.png', 'italy', NULL, 0, NULL, NULL, NULL),
(112, 'Jamaica', 'جامايكا', 'jm', '', '', 'jm.png', 'jamaica', NULL, 0, NULL, NULL, NULL),
(113, 'Japan', 'اليابان', 'jp', '', '', 'jp.png', 'japan', NULL, 0, NULL, NULL, NULL),
(114, 'Jersey', 'جيرسي', 'je', '', '', 'je.png', 'jersey', NULL, 0, NULL, NULL, NULL),
(115, 'Jordan', 'الأردن', 'jo', '', '', 'jo.png', 'jordan', NULL, 0, NULL, NULL, NULL),
(116, 'Kazakhstan', 'كازاخستان', 'kz', '', '', 'kz.png', 'kazakhstan', NULL, 0, NULL, NULL, NULL),
(117, 'Kenya', 'كينيا', 'ke', '', '', 'ke.png', 'kenya', NULL, 0, NULL, NULL, NULL),
(118, 'Kiribati', 'كيريباتي', 'ki', '', '', 'ki.png', 'kiribati', NULL, 0, NULL, NULL, NULL),
(119, 'Kosovo', 'كوسوفو', 'xk', '', '', 'xk.png', 'kosovo', NULL, 0, NULL, NULL, NULL),
(120, 'Kuwait', 'الكويت', 'kw', '', '', 'kw.png', 'kuwait', 3, 0, NULL, NULL, '2024-04-18 12:10:59'),
(121, 'Kyrgyzstan', 'قيرغيزستان', 'kg', '', '', 'kg.png', 'kyrgyzstan', NULL, 0, NULL, NULL, NULL),
(122, 'Laos', 'لاوس', 'la', '', '', 'la.png', 'laos', NULL, 0, NULL, NULL, NULL),
(123, 'Latvia', 'لاتفيا', 'lv', '', '', 'lv.png', 'latvia', NULL, 0, NULL, NULL, NULL),
(124, 'Lebanon', 'لبنان', 'lb', '', '', 'lb.png', 'lebanon', NULL, 0, NULL, NULL, NULL),
(125, 'Lesotho', 'ليسوتو', 'ls', '', '', 'ls.png', 'lesotho', NULL, 0, NULL, NULL, NULL),
(126, 'Liberia', 'ليبيريا', 'lr', '', '', 'lr.png', 'liberia', NULL, 0, NULL, NULL, NULL),
(127, 'Libya', 'ليبيا', 'ly', '', '', 'ly.png', 'libya', NULL, 0, NULL, NULL, NULL),
(128, 'Liechtenstein', 'ليختنشتاين', 'li', '', '', 'li.png', 'liechtenstein', NULL, 0, NULL, NULL, NULL),
(129, 'Lithuania', 'ليتوانيا', 'lt', '', '', 'lt.png', 'lithuania', NULL, 0, NULL, NULL, NULL),
(130, 'Luxembourg', 'لوكسمبورغ', 'lu', '', '', 'lu.png', 'luxembourg', NULL, 0, NULL, NULL, NULL),
(131, 'Macau', 'ماكاو', 'mo', '', '', 'mo.png', 'macau', NULL, 0, NULL, NULL, NULL),
(132, 'Madagascar', 'مدغشقر', 'mg', '', '', 'mg.png', 'madagascar', NULL, 0, NULL, NULL, NULL),
(133, 'Malawi', 'ملاوي', 'mw', '', '', 'mw.png', 'malawi', NULL, 0, NULL, NULL, NULL),
(134, 'Malaysia', 'ماليزيا', 'my', '', '', 'my.png', 'malaysia', NULL, 0, NULL, NULL, NULL),
(135, 'Maldives', 'جزر المالديف', 'mv', '', '', 'mv.png', 'maldives', NULL, 0, NULL, NULL, NULL),
(136, 'Mali', 'مالي', 'ml', '', '', 'ml.png', 'mali', NULL, 0, NULL, NULL, NULL),
(137, 'Malta', 'مالطا', 'mt', '', '', 'mt.png', 'malta', NULL, 0, NULL, NULL, NULL),
(138, 'Marshall Islands', 'جزر مارشال', 'mh', '', '', 'mh.png', 'marshall-islands', NULL, 0, NULL, NULL, NULL),
(139, 'Martinique', 'مارتينيك', 'mq', '', '', 'mq.png', 'martinique', NULL, 0, NULL, NULL, NULL),
(140, 'Mauritania', 'موريتانيا', 'mr', '', '', 'mr.png', 'mauritania', NULL, 0, NULL, NULL, NULL),
(141, 'Mauritius', 'موريشيوس', 'mu', '', '', 'mu.png', 'mauritius', NULL, 0, NULL, NULL, NULL),
(142, 'Mayotte', 'مايوت', 'yt', '', '', 'yt.png', 'mayotte', NULL, 0, NULL, NULL, NULL),
(143, 'Mexico', 'المكسيك', 'mx', '', '', 'mx.png', 'mexico', NULL, 0, NULL, NULL, NULL),
(144, 'Micronesia', 'ميكرونيزيا', 'fm', '', '', 'fm.png', 'micronesia', NULL, 0, NULL, NULL, NULL),
(145, 'Moldova', 'مولدوفا', 'md', '', '', 'md.png', 'moldova', NULL, 0, NULL, NULL, NULL),
(146, 'Monaco', 'موناكو', 'mc', '', '', 'mc.png', 'monaco', NULL, 0, NULL, NULL, NULL),
(147, 'Mongolia', '	منغوليا', 'mn', '', '', 'mn.png', 'mongolia', NULL, 0, NULL, NULL, NULL),
(148, 'Montenegro', 'الجبل الأسود', 'me', '', '', 'me.png', 'montenegro', NULL, 0, NULL, NULL, NULL),
(149, 'Montserrat', 'مونتسيرات', 'ms', '', '', 'ms.png', 'montserrat', NULL, 0, NULL, NULL, NULL),
(150, 'Morocco', 'المغرب', 'ma', '', '', 'ma.png', 'morocco', NULL, 0, NULL, NULL, NULL),
(151, 'Mozambique', 'موزمبيق', 'mz', '', '', 'mz.png', 'mozambique', NULL, 0, NULL, NULL, NULL),
(152, 'Myanmar', 'ميانمار', 'mm', '', '', 'mm.png', 'myanmar', NULL, 0, NULL, NULL, NULL),
(153, 'Namibia', 'ناميبيا', 'na', '', '', 'na.png', 'namibia', NULL, 0, NULL, NULL, NULL),
(154, 'Nauru', 'ناورو', 'nr', '', '', 'nr.png', 'nauru', NULL, 0, NULL, NULL, NULL),
(155, 'Nepal', 'نيبال', 'np', '', '', 'np.png', 'nepal', NULL, 0, NULL, NULL, NULL),
(156, 'Netherlands', 'هولندا', 'nl', '', '', 'nl.png', 'netherlands', NULL, 0, NULL, NULL, NULL),
(157, 'New Caledonia', 'كاليدونيا الجديدة', 'nc', '', '', 'nc.png', 'new-caledonia', NULL, 0, NULL, NULL, NULL),
(158, 'New Zealand', 'نيوزيلندا', 'nz', '', '', 'nz.png', 'new-zealand', NULL, 0, NULL, NULL, NULL),
(159, 'Nicaragua', 'نيكاراغوا', 'ni', '', '', 'ni.png', 'nicaragua', NULL, 0, NULL, NULL, NULL),
(160, 'Niger', 'النيجر', 'ne', '', '', 'ne.png', 'niger', NULL, 0, NULL, NULL, NULL),
(161, 'Nigeria', 'نيجيريا', 'ng', '', '', 'ng.png', 'nigeria', NULL, 0, NULL, NULL, NULL),
(162, 'Niue', 'نيوي', 'nu', '', '', 'nu.png', 'niue', NULL, 0, NULL, NULL, NULL),
(163, 'Norfolk Island', 'جزيرة نورفولك', 'nf', '', '', 'nf.png', 'norfolk-island', NULL, 0, NULL, NULL, NULL),
(164, 'North Korea', 'كوريا الشمالية', 'kp', '', '', 'kp.png', 'north-korea', NULL, 0, NULL, NULL, NULL),
(165, 'North Macedonia', 'مقدونيا الشمالية', 'mk', '', '', 'mk.png', 'north-macedonia', NULL, 0, NULL, NULL, NULL),
(166, 'Northern Ireland', 'إيرلندا الشمالية', 'gb-nir', '', '', 'gb-nir.png', 'northern-ireland', NULL, 0, NULL, NULL, NULL),
(167, 'Northern Mariana Islands', 'جزر مريانا الشمالية', 'mp', '', '', 'mp.png', 'northern-mariana-islands', NULL, 0, NULL, NULL, NULL),
(168, 'Norway', 'النرويج', 'no', '', '', 'no.png', 'norway', NULL, 0, NULL, NULL, NULL),
(169, 'Oman', 'سلطنة عمان', 'om', '', '', 'om.png', 'oman', 6, 0, NULL, NULL, '2024-04-18 12:11:35'),
(170, 'Pakistan', 'باكستان', 'pk', '', '', 'pk.png', 'pakistan', NULL, 0, NULL, NULL, NULL),
(171, 'Palau', 'بالاو', 'pw', '', '', 'pw.png', 'palau', NULL, 0, NULL, NULL, NULL),
(172, 'Palestine', 'فلسطين', 'ps', '', '', 'ps.png', 'palestine', NULL, 0, NULL, NULL, NULL),
(173, 'Panama', 'بنما', 'pa', '', '', 'pa.png', 'panama', NULL, 0, NULL, NULL, NULL),
(174, 'Papua New Guinea', 'بابوا غينيا الجديدة', 'pg', '', '', 'pg.png', 'papua-new-guinea', NULL, 0, NULL, NULL, NULL),
(175, 'Paraguay', 'باراغواي', 'py', '', '', 'py.png', 'paraguay', NULL, 0, NULL, NULL, NULL),
(176, 'Peru', 'بيرو', 'pe', '', '', 'pe.png', 'peru', NULL, 0, NULL, NULL, NULL),
(177, 'Philippines', 'فيلبيني', 'ph', '', '', 'ph.png', 'philippines', NULL, 0, NULL, NULL, NULL),
(178, 'Pitcairn Islands', 'جزر بيتكيرن', 'pn', '', '', 'pn.png', 'pitcairn-islands', NULL, 0, NULL, NULL, NULL),
(179, 'Poland', 'بولندا', 'pl', '', '', 'pl.png', 'poland', NULL, 0, NULL, NULL, NULL),
(180, 'Portugal', 'البرتغال', 'pt', '', '', 'pt.png', 'portugal', NULL, 0, NULL, NULL, NULL),
(181, 'Puerto Rico', 'بورتوريكو', 'pr', '', '', 'pr.png', 'puerto-rico', NULL, 0, NULL, NULL, NULL),
(182, 'Qatar', 'دولة قطر', 'qa', '', '', 'qa.png', 'qatar', 5, 0, NULL, NULL, '2024-04-18 12:11:23'),
(183, 'Republic of the Congo', 'جمهورية الكونغو', 'cg', '', '', 'cg.png', 'republic-of-the-congo', NULL, 0, NULL, NULL, NULL),
(184, 'Réunion', 'جمع شمل', 're', '', '', 're.png', 'reunion', NULL, 0, NULL, NULL, NULL),
(185, 'Romania', 'رومانيا', 'ro', '', '', 'ro.png', 'romania', NULL, 0, NULL, NULL, NULL),
(186, 'Russia', 'روسيا', 'ru', '', '', 'ru.png', 'russia', NULL, 0, NULL, NULL, NULL),
(187, 'Rwanda', 'رواندا', 'rw', '', '', 'rw.png', 'rwanda', NULL, 0, NULL, NULL, NULL),
(188, 'Saint Barthélemy', 'سانت بارتيليمي', 'bl', '', '', 'bl.png', 'saint-barthelemy', NULL, 0, NULL, NULL, NULL),
(189, 'Saint Helena, Ascension and Tristan da Cunha', 'سانت هيلانة وأسنسيون وتريستان دا كونها', 'sh', '', '', 'sh.png', 'saint-helena-ascension-and-tristan-da-cunha', NULL, 0, NULL, NULL, NULL),
(190, 'Saint Kitts and Nevis', 'سانت كيتس ونيفيس', 'kn', '', '', 'kn.png', 'saint-kitts-and-nevis', NULL, 0, NULL, NULL, NULL),
(191, 'Saint Lucia', 'القديسة لوسيا', 'lc', '', '', 'lc.png', 'saint-lucia', NULL, 0, NULL, NULL, NULL),
(192, 'Saint Martin', 'القديس مارتن', 'mf', '', '', 'mf.png', 'saint-martin', NULL, 0, NULL, NULL, NULL),
(193, 'Saint Pierre and Miquelon', 'سانت بيير وميكلون', 'pm', '', '', 'pm.png', 'saint-pierre-and-miquelon', NULL, 0, NULL, NULL, NULL),
(194, 'Saint Vincent and the Grenadines', 'سانت فنسنت وجزر غرينادين', 'vc', '', '', 'vc.png', 'saint-vincent-and-the-grenadines', NULL, 0, NULL, NULL, NULL),
(195, 'Samoa', 'ساموا', 'ws', '', '', 'ws.png', 'samoa', NULL, 0, NULL, NULL, NULL),
(196, 'San Marino', 'سان مارينو', 'sm', '', '', 'sm.png', 'san-marino', NULL, 0, NULL, NULL, NULL),
(197, 'São Tomé and Príncipe', 'ساو تومي وبرينسيبي', 'st', '', '', 'st.png', 'sao-tome-and-principe', NULL, 0, NULL, NULL, NULL),
(198, 'Saudi Arabia', 'المملكة العربية السعودية', 'sa', 'sar', '+966', 'sa.png', 'saudi-arabia', 1, 1, NULL, NULL, '2024-04-30 08:37:22'),
(199, 'Scotland', 'اسكتلندا', 'gb-sct', '', '', 'gb-sct.png', 'scotland', NULL, 0, NULL, NULL, NULL),
(200, 'Senegal', 'السنغال', 'sn', '', '', 'sn.png', 'senegal', NULL, 0, NULL, NULL, NULL),
(201, 'Serbia', 'صربيا', 'rs', '', '', 'rs.png', 'serbia', NULL, 0, NULL, NULL, NULL),
(202, 'Seychelles', 'سيشيل', 'sc', '', '', 'sc.png', 'seychelles', NULL, 0, NULL, NULL, NULL),
(203, 'Sierra Leone', 'سيرا ليون', 'sl', '', '', 'sl.png', 'sierra-leone', NULL, 0, NULL, NULL, NULL),
(204, 'Singapore', 'سنغافورة', 'sg', '', '', 'sg.png', 'singapore', NULL, 0, NULL, NULL, NULL),
(205, 'Sint Maarten', 'سينت مارتن', 'sx', '', '', 'sx.png', 'sint-maarten', NULL, 0, NULL, NULL, NULL),
(206, 'Slovakia', 'سلوفاكيا', 'sk', '', '', 'sk.png', 'slovakia', NULL, 0, NULL, NULL, NULL),
(207, 'Slovenia', 'سلوفينيا', 'si', '', '', 'si.png', 'slovenia', NULL, 0, NULL, NULL, NULL),
(208, 'Solomon Islands', 'جزر سليمان', 'sb', '', '', 'sb.png', 'solomon-islands', NULL, 0, NULL, NULL, NULL),
(209, 'Somalia', 'الصومال', 'so', '', '', 'so.png', 'somalia', NULL, 0, NULL, NULL, NULL),
(210, 'South Africa', 'جنوب أفريقيا', 'za', '', '', 'za.png', 'south-africa', NULL, 0, NULL, NULL, NULL),
(211, 'South Georgia', 'جورجيا الجنوبية', 'gs', '', '', 'gs.png', 'south-georgia', NULL, 0, NULL, NULL, NULL),
(212, 'South Korea', 'كوريا الجنوبية', 'kr', '', '', 'kr.png', 'south-korea', NULL, 0, NULL, NULL, NULL),
(213, 'South Sudan', 'جنوب السودان', 'ss', '', '', 'ss.png', 'south-sudan', NULL, 0, NULL, NULL, NULL),
(214, 'Spain', 'إسبانيا', 'es', '', '', 'es.png', 'spain', NULL, 0, NULL, NULL, NULL),
(215, 'Sri Lanka', 'سيريلانكا', 'lk', '', '', 'lk.png', 'sri-lanka', NULL, 0, NULL, NULL, NULL),
(216, 'Sudan', 'السودان', 'sd', '', '', 'sd.png', 'sudan', NULL, 0, NULL, NULL, NULL),
(217, 'Suriname', 'سورينام', 'sr', '', '', 'sr.png', 'suriname', NULL, 0, NULL, NULL, NULL),
(218, 'Svalbard and Jan Mayen', 'سفالبارد وجان ماين', 'sj', '', '', 'sj.png', 'svalbard-and-jan-mayen', NULL, 0, NULL, NULL, NULL),
(219, 'Sweden', 'السويد', 'se', '', '', 'se.png', 'sweden', NULL, 0, NULL, NULL, NULL),
(220, 'Switzerland', 'سويسرا', 'ch', '', '', 'ch.png', 'switzerland', NULL, 0, NULL, NULL, NULL),
(221, 'Syria', 'سوريا', 'sy', '', '', 'sy.png', 'syria', NULL, 0, NULL, NULL, NULL),
(222, 'Taiwan', 'تايوان', 'tw', '', '', 'tw.png', 'taiwan', NULL, 0, NULL, NULL, NULL),
(223, 'Tajikistan', 'طاجيكستان', 'tj', '', '', 'tj.png', 'tajikistan', NULL, 0, NULL, NULL, NULL),
(224, 'Tanzania', 'تنزانيا', 'tz', '', '', 'tz.png', 'tanzania', NULL, 0, NULL, NULL, NULL),
(225, 'Thailand', 'تايلاند', 'th', '', '', 'th.png', 'thailand', NULL, 0, NULL, NULL, NULL),
(226, 'Timor-Leste', 'تيمور ليشتي', 'tl', '', '', 'tl.png', 'timor-leste', NULL, 0, NULL, NULL, NULL),
(227, 'Togo', 'توجو', 'tg', '', '', 'tg.png', 'togo', NULL, 0, NULL, NULL, NULL),
(228, 'Tokelau', 'توكيلاو', 'tk', '', '', 'tk.png', 'tokelau', NULL, 0, NULL, NULL, NULL),
(229, 'Tonga', 'تونغا', 'to', '', '', 'to.png', 'tonga', NULL, 0, NULL, NULL, NULL),
(230, 'Trinidad and Tobago', 'ترينداد وتوباغو', 'tt', '', '', 'tt.png', 'trinidad-and-tobago', NULL, 0, NULL, NULL, NULL),
(231, 'Tunisia', 'تونس', 'tn', '', '', 'tn.png', 'tunisia', NULL, 0, NULL, NULL, NULL),
(232, 'Turkey', 'تركيا', 'tr', '', '', 'tr.png', 'turkey', NULL, 0, NULL, NULL, '2024-04-27 09:04:41'),
(233, 'Turkmenistan', 'تركمانستان', 'tm', '', '', 'tm.png', 'turkmenistan', NULL, 0, NULL, NULL, NULL),
(234, 'Turks and Caicos Islands', 'جزر تركس وكايكوس', 'tc', '', '', 'tc.png', 'turks-and-caicos-islands', NULL, 0, NULL, NULL, NULL),
(235, 'Tuvalu', ' توفالو', 'tv', '', '', 'tv.png', 'tuvalu', NULL, 0, NULL, NULL, NULL),
(236, 'Uganda', 'أوغندا', 'ug', '', '', 'ug.png', 'uganda', NULL, 0, NULL, NULL, NULL),
(237, 'Ukraine', 'أوكرانيا', 'ua', '', '', 'ua.png', 'ukraine', NULL, 0, NULL, NULL, NULL),
(238, 'United Arab Emirates', 'الإمارات العربية المتحدة', 'ae', '', '', 'ae.png', 'united-arab-emirates', 2, 0, NULL, NULL, '2024-04-18 12:10:38'),
(239, 'United Kingdom', 'المملكة المتحدة', 'gb', '', '', 'gb.png', 'united-kingdom', NULL, 0, NULL, NULL, NULL),
(240, 'United States', 'الولايات المتحدة', 'us', 'usa', '+10', 'us.png', 'united-states', NULL, 1, NULL, NULL, NULL),
(241, 'United States Minor Outlying Islands', 'جزر الولايات المتحدة البعيدة الصغرى', 'um', '', '', 'um.png', 'united-states-minor-outlying-islands', NULL, 0, NULL, NULL, NULL),
(242, 'United States Virgin Islands', 'جزر فيرجن التابعة للولايات المتحدة', 'vi', '', '', 'vi.png', 'united-states-virgin-islands', NULL, 0, NULL, NULL, NULL),
(243, 'Uruguay', 'أوروغواي', 'uy', '', '', 'uy.png', 'uruguay', NULL, 0, NULL, NULL, NULL),
(244, 'Uzbekistan', 'أوزبكستان', 'uz', '', '', 'uz.png', 'uzbekistan', NULL, 0, NULL, NULL, NULL),
(245, 'Vanuatu', 'فانواتو', 'vu', '', '', 'vu.png', 'vanuatu', NULL, 0, NULL, NULL, NULL),
(246, 'Vatican City', 'مدينة الفاتيكان', 'va', '', '', 'va.png', 'vatican-city', NULL, 0, NULL, NULL, NULL),
(247, 'Venezuela', 'فنزويلا', 've', '', '', 've.png', 'venezuela', NULL, 0, NULL, NULL, NULL),
(248, 'Vietnam', 'فيتنام', 'vn', '', '', 'vn.png', 'vietnam', NULL, 0, NULL, NULL, NULL),
(249, 'Wales', 'ويلز', 'gb-wls', '', '', 'gb-wls.png', 'wales', NULL, 0, NULL, NULL, NULL),
(250, 'Wallis and Futuna', 'واليس وفوتونا', 'wf', '', '', 'wf.png', 'wallis-and-futuna', NULL, 0, NULL, NULL, NULL),
(251, 'Western Sahara', 'الصحراء الغربية', 'eh', '', '', 'eh.png', 'western-sahara', NULL, 0, NULL, NULL, NULL),
(252, 'Yemen', 'اليمن', 'ye', '', '', 'ye.png', 'yemen', NULL, 0, NULL, NULL, NULL),
(253, 'Zambia', 'زامبيا', 'zm', '', '', 'zm.png', 'zambia', NULL, 0, NULL, NULL, NULL),
(254, 'Zimbabwe', 'زيمبابوي', 'zw', '', '', 'zw.png', 'zimbabwe', NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `domain_configs`
--

CREATE TABLE `domain_configs` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `config` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `domain_configs`
--

INSERT INTO `domain_configs` (`id`, `title`, `logo`, `domain`, `note`, `config`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Test', NULL, 'noreply@amlaek.com', NULL, '{\"mail\":\"smtp\",\"host\":\"mail.amlaek.com\",\"port\":\"465\",\"user_name\":\"noreply@amlaek.com\",\"password\":\"noreply2024\",\"encryption\":\"ssl\",\"name\":\"Test\",\"address\":\"noreply@amlaek.com\"}', 1, '2024-02-28 02:19:01', '2024-02-28 02:19:01'),
(2, 'test@amlaek.com', NULL, 'test@amlaek.com', NULL, '{\"mail\":\"SMTP\",\"host\":\"mail.amlaek.com\",\"port\":\"465\",\"user_name\":\"test@amlaek.com\",\"password\":\"Test@%789\",\"encryption\":\"ssl\",\"name\":\"Test\",\"address\":\"test@amlaek.com\"}', 1, '2024-04-16 02:20:32', '2024-04-16 02:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text COLLATE utf8mb4_unicode_ci,
  `shortcode` text COLLATE utf8mb4_unicode_ci COMMENT 'object',
  `support` text COLLATE utf8mb4_unicode_ci COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Tawk.to', 'Key location is shown bellow', 'tawky_big.png', '<script>\r\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n                        (function(){\r\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n                        s1.async=true;\r\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\r\n                        s1.charset=\"UTF-8\";\r\n                        s1.setAttribute(\"crossorigin\",\"*\");\r\n                        s0.parentNode.insertBefore(s1,s0);\r\n                        })();\r\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"------\"}}', 'twak.png', 0, '2019-10-18 23:16:05', '2022-03-22 05:22:24'),
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"---\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"---\"}}', 'recaptcha.png', 0, '2019-10-18 23:16:05', '2024-01-19 11:26:03'),
(3, 'custom-captcha', 'Custom Captcha', 'Just put any random string', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureStringggg\"}}', 'na', 0, '2019-10-18 23:16:05', '2024-01-21 11:21:13'),
(4, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', 'google_analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{app_key}}\"></script>\n                <script>\n                  window.dataLayer = window.dataLayer || [];\n                  function gtag(){dataLayer.push(arguments);}\n                  gtag(\"js\", new Date());\n                \n                  gtag(\"config\", \"{{app_key}}\");\n                </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"------\"}}', 'ganalytics.png', 0, NULL, '2021-05-04 10:19:12'),
(7, 'google-site-verification', 'Google Search Console', 'Paste the content value of the HTML tag Google Search Console gives you when you verify site ownership.', 'google_analytics.png', '<meta name=\"google-site-verification\" content=\"{{verification_code}}\">', '{\"verification_code\":{\"title\":\"Verification Code\",\"value\":\"------\"}}', 'na', 0, '2026-09-06 11:26:08', '2026-09-06 11:29:16'),
(8, 'bing-site-verification', 'Bing Webmaster Tools', 'Paste the content value of the msvalidate.01 meta tag from Bing Webmaster Tools.', NULL, '<meta name=\"msvalidate.01\" content=\"{{verification_code}}\">', '{\"verification_code\":{\"title\":\"Verification Code\",\"value\":\"------\"}}', 'na', 0, '2026-09-06 11:26:08', '2026-09-06 11:26:08'),
(9, 'yandex-site-verification', 'Yandex Webmaster', 'Paste the content value of the yandex-verification meta tag from Yandex Webmaster.', NULL, '<meta name=\"yandex-verification\" content=\"{{verification_code}}\">', '{\"verification_code\":{\"title\":\"Verification Code\",\"value\":\"------\"}}', 'na', 0, '2026-09-06 11:26:08', '2026-09-06 11:26:08'),
(10, 'google-tag-manager', 'Google Tag Manager', 'Container ID from Google Tag Manager, in the format GTM-XXXXXXX. The noscript fallback is added automatically.', 'google_analytics.png', '<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\"gtm.start\":new Date().getTime(),event:\"gtm.js\"});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!=\"dataLayer\"?\"&l=\"+l:\"\";j.async=true;j.src=\"https://www.googletagmanager.com/gtm.js?id=\"+i+dl;f.parentNode.insertBefore(j,f);})(window,document,\"script\",\"dataLayer\",\"{{container_id}}\");</script>', '{\"container_id\":{\"title\":\"Container ID (GTM-XXXXXXX)\",\"value\":\"GTM-XXXXXXX\"}}', 'na', 0, '2026-09-06 11:26:08', '2026-09-06 11:29:16'),
(11, 'facebook-pixel', 'Facebook Pixel', 'Meta (Facebook) Pixel ID from Events Manager.', 'Facebook.png', '<script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version=\"2.0\";n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,\"script\",\"https://connect.facebook.net/en_US/fbevents.js\");fbq(\"init\",\"{{pixel_id}}\");fbq(\"track\",\"PageView\");</script>', '{\"pixel_id\":{\"title\":\"Pixel ID\",\"value\":\"------\"}}', 'na', 0, '2026-09-06 11:26:08', '2026-09-06 11:26:08'),
(12, 'linkedin-insight', 'LinkedIn Insight Tag', 'Partner ID from your LinkedIn Campaign Manager Insight Tag.', NULL, '<script>_linkedin_partner_id=\"{{partner_id}}\";window._linkedin_data_partner_ids=window._linkedin_data_partner_ids||[];window._linkedin_data_partner_ids.push(_linkedin_partner_id);(function(l){if(!l){window.lintrk=function(a,b){window.lintrk.q.push([a,b])};window.lintrk.q=[]}var s=document.getElementsByTagName(\"script\")[0];var b=document.createElement(\"script\");b.type=\"text/javascript\";b.async=true;b.src=\"https://snap.licdn.com/li.lms-analytics/insight.min.js\";s.parentNode.insertBefore(b,s);})(window.lintrk);</script>', '{\"partner_id\":{\"title\":\"Partner ID\",\"value\":\"------\"}}', 'na', 0, '2026-09-06 11:26:08', '2026-09-06 11:26:08'),
(13, 'tiktok-pixel', 'TikTok Pixel', 'Pixel ID from TikTok Ads Manager.', NULL, '<script>!function(w,d,t){w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=[\"page\",\"track\",\"identify\",\"instances\",\"debug\",\"on\",\"off\",\"once\",\"ready\",\"alias\",\"group\",\"enableCookie\",\"disableCookie\"];ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e};ttq.load=function(e,n){var i=\"https://analytics.tiktok.com/i18n/pixel/events.js\";ttq._i=ttq._i||{};ttq._i[e]=[];ttq._i[e]._u=i;ttq._t=ttq._t||{};ttq._t[e]=+new Date;ttq._o=ttq._o||{};ttq._o[e]=n||{};var o=document.createElement(\"script\");o.type=\"text/javascript\";o.async=!0;o.src=i+\"?sdkid=\"+e+\"&lib=\"+t;var a=document.getElementsByTagName(\"script\")[0];a.parentNode.insertBefore(o,a)};ttq.load(\"{{pixel_id}}\");ttq.page();}(window,document,\"ttq\");</script>', '{\"pixel_id\":{\"title\":\"Pixel ID\",\"value\":\"------\"}}', 'na', 0, '2026-09-06 11:26:08', '2026-09-06 11:26:08');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_data` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `act`, `form_data`, `created_at`, `updated_at`) VALUES
(2, 'manual_deposit', '{\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"nid_number_22\":{\"name\":\"NID Number 22\",\"label\":\"nid_number_22\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"textarea\"},\"sadfg\":{\"name\":\"sadfg\",\"label\":\"sadfg\",\"is_required\":\"optional\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"asdf\":{\"name\":\"asdf\",\"label\":\"asdf\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"Test\",\"Test2\",\"Test3\"],\"type\":\"select\"},\"nid_number_226985\":{\"name\":\"NID Number 226985\",\"label\":\"nid_number_226985\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"Test\",\"Test 2\",\"Test 3\"],\"type\":\"checkbox\"},\"nid_number_3333\":{\"name\":\"NID Number 3333\",\"label\":\"nid_number_3333\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"Test\",\"asdf\"],\"type\":\"radio\"},\"nid_number_3333587\":{\"name\":\"NID Number 3333587\",\"label\":\"nid_number_3333587\",\"is_required\":\"optional\",\"extensions\":\"jpg,bmp,png,pdf\",\"options\":[],\"type\":\"file\"}}', '2022-03-16 01:09:49', '2022-03-17 00:02:54'),
(3, 'manual_deposit', '{\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"nid_number_226985\":{\"name\":\"NID Number 226985\",\"label\":\"nid_number_226985\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"textarea\"}}', '2022-03-16 04:32:29', '2022-03-16 04:35:32'),
(5, 'withdraw_method', '{\"nid_number_33\":{\"name\":\"NID Number 33\",\"label\":\"nid_number_33\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"textarea\"}}', '2022-03-17 00:45:35', '2022-03-17 00:53:17'),
(6, 'withdraw_method', '{\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"textarea\"}}', '2022-03-17 00:47:04', '2022-03-17 00:47:04'),
(7, 'kyc', '{\"full_name\":{\"name\":\"Full Name\",\"label\":\"full_name\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"gender\":{\"name\":\"Gender\",\"label\":\"gender\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"Male\",\"Female\",\"Others\"],\"type\":\"select\"}}', '2022-03-17 02:56:14', '2024-01-12 13:48:08'),
(8, 'manual_deposit', '{\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2022-03-21 07:53:25', '2022-03-21 07:53:25'),
(9, 'manual_deposit', '{\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2022-03-21 07:54:15', '2022-03-21 07:54:15'),
(10, 'manual_deposit', '{\"nid_number\":{\"name\":\"NID Number\",\"label\":\"nid_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"textarea\"}}', '2022-03-21 07:55:15', '2022-03-21 07:55:22'),
(11, 'withdraw_method', '{\"nid_number_2658\":{\"name\":\"NID Number 2658\",\"label\":\"nid_number_2658\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[\"asdf\"],\"type\":\"checkbox\"}}', '2022-03-22 00:14:09', '2022-03-22 00:14:18'),
(12, 'withdraw_method', '[]', '2022-03-30 09:03:12', '2022-03-30 09:03:12'),
(13, 'withdraw_method', '{\"bank_name\":{\"name\":\"Bank Name\",\"label\":\"bank_name\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"account_name\":{\"name\":\"Account Name\",\"label\":\"account_name\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"account_number\":{\"name\":\"Account Number\",\"label\":\"account_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2022-03-30 09:09:11', '2022-04-03 06:38:57'),
(14, 'withdraw_method', '{\"mobile_number\":{\"name\":\"Mobile Number\",\"label\":\"mobile_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2022-03-30 09:10:12', '2022-03-30 09:10:12'),
(15, 'manual_deposit', '{\"send_from_number\":{\"name\":\"Send From Number\",\"label\":\"send_from_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"transaction_number\":{\"name\":\"Transaction Number\",\"label\":\"transaction_number\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"screenshot\":{\"name\":\"Screenshot\",\"label\":\"screenshot\",\"is_required\":\"required\",\"extensions\":\"jpg,jpeg,png\",\"options\":[],\"type\":\"file\"}}', '2022-03-30 09:15:27', '2022-03-30 09:15:27'),
(16, 'manual_deposit', '{\"transaction_number\":{\"name\":\"Transaction Number\",\"label\":\"transaction_number\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"screenshot\":{\"name\":\"Screenshot\",\"label\":\"screenshot\",\"is_required\":\"required\",\"extensions\":\"jpg,pdf,docx\",\"options\":[],\"type\":\"file\"}}', '2022-03-30 09:16:43', '2022-04-11 03:19:54'),
(17, 'manual_deposit', '[]', '2022-03-30 09:21:19', '2022-03-30 09:21:19'),
(18, 'manual_deposit', '[]', '2022-07-26 05:53:36', '2022-07-26 05:53:36'),
(19, 'propert_type_form_1', '{\"factory_activity\":{\"name\":\"Factory Activity\",\"label\":\"factory_activity\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"engineering\",\"chemical\",\"food\",\"pharmaceutical\",\"spinning and weaving\",\"building materials\",\"warehousing\"],\"type\":\"select\"},\"year_of_construction\":{\"name\":\"Year of construction\",\"label\":\"year_of_construction\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"land_area\":{\"name\":\"Land area\",\"label\":\"land_area\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"number_of_floors\":{\"name\":\"Number of floors\",\"label\":\"number_of_floors\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"factory_location\":{\"name\":\"Factory location\",\"label\":\"factory_location\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"price_of_one_meter\":{\"name\":\"Price of one meter\",\"label\":\"price_of_one_meter\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"}}', '2024-03-02 05:47:16', '2024-03-03 06:04:15'),
(20, 'propert_type_form_4', '{\"hospital_location\":{\"name\":\"Hospital location\",\"label\":\"hospital_location\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"year_of_construction\":{\"name\":\"Year of construction\",\"label\":\"year_of_construction\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"land_area\":{\"name\":\"Land area\",\"label\":\"land_area\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"building_area\":{\"name\":\"Building area\",\"label\":\"building_area\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"basement_area\":{\"name\":\"Basement area\",\"label\":\"basement_area\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"number_of_floors\":{\"name\":\"Number of floors\",\"label\":\"number_of_floors\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"the_number_of_rooms\":{\"name\":\"The number of rooms\",\"label\":\"the_number_of_rooms\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"number_of_bathrooms\":{\"name\":\"Number of bathrooms\",\"label\":\"number_of_bathrooms\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"finishing_type\":{\"name\":\"Finishing type\",\"label\":\"finishing_type\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[\"super luxury finishing\",\"semi-finishing\",\"unfinished\"],\"type\":\"select\"},\"price_of_one_meter\":{\"name\":\"Price of one meter\",\"label\":\"price_of_one_meter\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2024-03-02 05:52:16', '2024-03-02 05:52:16'),
(21, 'propert_type_form_12', '{\"mall_location\":{\"name\":\"Mall location\",\"label\":\"mall_location\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"year_of_construction\":{\"name\":\"Year of construction\",\"label\":\"year_of_construction\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"type_of_mall\":{\"name\":\"Type of mall\",\"label\":\"type_of_mall\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"administrative\",\"medical\",\"commercial\",\"entertainment\",\"other\"],\"type\":\"select\"},\"number_of_floors\":{\"name\":\"Number of floors\",\"label\":\"number_of_floors\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"building_area\":{\"name\":\"Building area\",\"label\":\"building_area\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"land_area\":{\"name\":\"Land area\",\"label\":\"land_area\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"finishing_type\":{\"name\":\"Finishing type\",\"label\":\"finishing_type\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"fully finished\",\"semi-finished\",\"unfinished\"],\"type\":\"select\"},\"licensing\":{\"name\":\"Licensing\",\"label\":\"licensing\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"real estate registry license\",\"unlicensed\"],\"type\":\"select\"},\"advantages\":{\"name\":\"Advantages\",\"label\":\"advantages\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"the malls own outdoor space\",\"central air conditioning\",\"full surveillance camera system\",\"elevators\",\"full safety\",\"civil defense and safety security\",\"electricity\",\"water and sewage meters\",\"others\"],\"type\":\"select\"},\"price_of_one_meter\":{\"name\":\"price of one meter\",\"label\":\"price_of_one_meter\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2024-03-02 05:56:57', '2024-03-21 09:47:16'),
(22, 'propert_type_form_3', '{\"school_website\":{\"name\":\"School website\",\"label\":\"school_website\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"year_of_construction\":{\"name\":\"Year of construction\",\"label\":\"year_of_construction\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"land_area\":{\"name\":\"Land area\",\"label\":\"land_area\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"number_of_buildings\":{\"name\":\"Number of buildings\",\"label\":\"number_of_buildings\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"building_area\":{\"name\":\"Building area\",\"label\":\"building_area\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"number_of_floors\":{\"name\":\"Number of floors\",\"label\":\"number_of_floors\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"number_of_bathrooms\":{\"name\":\"Number of bathrooms\",\"label\":\"number_of_bathrooms\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"number_of_classes\":{\"name\":\"Number of classes\",\"label\":\"number_of_classes\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"capacity\":{\"name\":\"Capacity\",\"label\":\"capacity\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"how many students\"],\"type\":\"select\"},\"finishing_type\":{\"name\":\"Finishing type\",\"label\":\"finishing_type\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"fully finished\",\"semi-finished\",\"unfinished\"],\"type\":\"select\"},\"other_benefits\":{\"name\":\"Other benefits\",\"label\":\"other_benefits\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"landscape\",\"inside a compound\",\"Other\"],\"type\":\"select\"},\"price_of_one_meter\":{\"name\":\"Price of one meter\",\"label\":\"price_of_one_meter\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"}}', '2024-03-02 06:03:21', '2024-03-21 09:31:29'),
(23, 'propert_type_form_16', '{\"office_location\":{\"name\":\"Office location\",\"label\":\"office_location\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"office_space\":{\"name\":\"Office space\",\"label\":\"office_space\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"floor\":{\"name\":\"Floor\",\"label\":\"floor\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[\"ground\",\"first\",\"second\",\"other\"],\"type\":\"select\"},\"furnishing\":{\"name\":\"Furnishing\",\"label\":\"furnishing\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[\"furnished\",\"unfurnished\"],\"type\":\"select\"},\"advantages\":{\"name\":\"Advantages\",\"label\":\"advantages\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[\"there are elevators\",\"inside an administrative mall\",\"garages\",\"banks\",\"security services\",\"cafes and restaurants\",\"electric gates\",\"others\"],\"type\":\"select\"},\"price_of_one_meter\":{\"name\":\"Price of one meter\",\"label\":\"price_of_one_meter\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2024-03-02 06:07:40', '2024-03-02 06:07:40'),
(24, 'propert_type_form_10', '{\"land_area\":{\"name\":\"Land area\",\"label\":\"land_area\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"farm_location\":{\"name\":\"Farm location\",\"label\":\"farm_location\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"advantages\":{\"name\":\"Advantages\",\"label\":\"advantages\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"productive land\",\"rest area\",\"building\",\"electricity meter\",\"water storage basin\",\"others\"],\"type\":\"select\"},\"price_per_acre\":{\"name\":\"Price per acre\",\"label\":\"price_per_acre\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2024-03-02 05:56:57', '2024-03-21 09:50:21'),
(25, 'propert_type_form_5', '{\"hospital_location\":{\"name\":\"Hospital location\",\"label\":\"hospital_location\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"year_of_construction\":{\"name\":\"Year of construction\",\"label\":\"year_of_construction\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"land_area\":{\"name\":\"Land area\",\"label\":\"land_area\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"building_area\":{\"name\":\"Building area\",\"label\":\"building_area\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"basement_area\":{\"name\":\"Basement area\",\"label\":\"basement_area\",\"is_required\":\"optional\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"number_of_floors\":{\"name\":\"Number of floors\",\"label\":\"number_of_floors\",\"is_required\":\"optional\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"the_number_of_rooms\":{\"name\":\"The number of rooms\",\"label\":\"the_number_of_rooms\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"number_of_bathrooms\":{\"name\":\"Number of bathrooms\",\"label\":\"number_of_bathrooms\",\"is_required\":\"optional\",\"extensions\":null,\"options\":[],\"type\":\"text\"},\"finishing_type\":{\"name\":\"Finishing type\",\"label\":\"finishing_type\",\"is_required\":\"required\",\"extensions\":null,\"options\":[\"super luxury finishing\",\"semi-finishing\",\"unfinished\"],\"type\":\"select\"},\"price_of_one_meter\":{\"name\":\"price of one meter\",\"label\":\"price_of_one_meter\",\"is_required\":\"required\",\"extensions\":null,\"options\":[],\"type\":\"text\"}}', '2024-03-21 09:30:06', '2024-03-21 09:30:19'),
(26, 'propert_type_form_13', '{\"commercial_store_location\":{\"name\":\"Commercial store location\",\"label\":\"commercial_store_location\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"store_space\":{\"name\":\"Store space\",\"label\":\"store_space\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"store_features\":{\"name\":\"Store features\",\"label\":\"store_features\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"inside a mall\",\"security and guarding services\",\"24-hour surveillance cameras\",\"car garages\",\"seating areas\",\"fire alarm system\",\"central air conditioning system\",\"electric generators in emergency cases\",\"banks and cash machines\",\"restaurants and cafes area\",\"supermarket\",\"pharmacy\",\"Others\"],\"type\":\"select\"}}', '2024-03-21 09:35:59', '2024-03-21 09:35:59'),
(27, 'propert_type_form_2', '{\"office_location\":{\"name\":\"Office location\",\"label\":\"office_location\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"office_space\":{\"name\":\"Office space\",\"label\":\"office_space\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"floor\":{\"name\":\"Floor\",\"label\":\"floor\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"ground\",\"first\",\"second\",\"other\"],\"type\":\"select\"},\"furnishing\":{\"name\":\"Furnishing\",\"label\":\"furnishing\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"furnished\",\"unfurnished\"],\"type\":\"select\"},\"advantages\":{\"name\":\"Advantages\",\"label\":\"advantages\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"there are elevators\",\"inside an administrative mall\",\"garages\",\"banks\",\"security services\",\"cafes and restaurants\",\"electric gates\",\"others\"],\"type\":\"select\"},\"price_of_one_meter\":{\"name\":\"price of one meter\",\"label\":\"price_of_one_meter\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2024-03-21 09:42:07', '2024-03-21 09:42:07'),
(28, 'propert_type_form_8', '{\"property_location\":{\"name\":\"Property location\",\"label\":\"property_location\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"property_area\":{\"name\":\"Property area\",\"label\":\"property_area\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"the_city\":{\"name\":\"The city\",\"label\":\"the_city\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"name_of_the_neighborhood\":{\"name\":\"Name of the neighborhood\",\"label\":\"name_of_the_neighborhood\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"the_specific_location,_a_location_close_to_the_property_and_other_vital_places._location_of_the_property\":{\"name\":\"The specific location, a location close to the property and other vital places. Location of the property\",\"label\":\"the_specific_location,_a_location_close_to_the_property_and_other_vital_places._location_of_the_property\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"its_boundaries_and_lengths\":{\"name\":\"Its boundaries and lengths\",\"label\":\"its_boundaries_and_lengths\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"age_of_the_property\":{\"name\":\"Age of the property\",\"label\":\"age_of_the_property\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"garden_or_courtyard_area\":{\"name\":\"Garden or courtyard area\",\"label\":\"garden_or_courtyard_area\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"surface_area\":{\"name\":\"Surface area\",\"label\":\"surface_area\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"finishing\":{\"name\":\"Finishing\",\"label\":\"finishing\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"unfinished\",\"semi-finished\",\"fully finished\"],\"type\":\"select\"},\"number_of_rooms\":{\"name\":\"Number of rooms\",\"label\":\"number_of_rooms\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"number_of_bathrooms\":{\"name\":\"Number of bathrooms\",\"label\":\"number_of_bathrooms\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"number_of_maids_rooms\":{\"name\":\"Number of maids rooms\",\"label\":\"number_of_maids_rooms\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"benefits\":{\"name\":\"Benefits\",\"label\":\"benefits\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"private garden\",\"shared health club\",\"security guard\",\"shared gym\",\"swimming pool\",\"others\"],\"type\":\"select\"},\"additional_benefits\":{\"name\":\"Additional benefits\",\"label\":\"additional_benefits\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"a distinguished location within a compound\",\"facilities and amenities\",\"a sports club\",\"schools\",\"picnic areas\",\"smart gates\",\"sewage management\",\"garbage management\",\"fire-fighting systems\",\"security systems\",\"private and public parking lots\",\"others\"],\"type\":\"select\"},\"evaluation_and_evaluation\":{\"name\":\"Evaluation and evaluation\",\"label\":\"evaluation_and_evaluation\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"yes\",\"none\"],\"type\":\"select\"},\"asking_price\":{\"name\":\"Asking price\",\"label\":\"asking_price\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"the_relationship_with_the_agent_or_directly_with_the_owner\":{\"name\":\"The relationship with the agent or directly with the owner\",\"label\":\"the_relationship_with_the_agent_or_directly_with_the_owner\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2024-03-21 09:59:51', '2024-03-21 09:59:51'),
(29, 'propert_type_form_7', '{\"land_area\":{\"name\":\"Land area\",\"label\":\"land_area\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"land_location\":{\"name\":\"Land location\",\"label\":\"land_location\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"},\"advantages\":{\"name\":\"Advantages\",\"label\":\"advantages\",\"is_required\":\"optional\",\"extensions\":\"\",\"options\":[\"building\",\"electricity meter\",\"water storage basin\",\"others\"],\"type\":\"select\"},\"required_price\":{\"name\":\"Required price\",\"label\":\"required_price\",\"is_required\":\"required\",\"extensions\":\"\",\"options\":[],\"type\":\"text\"}}', '2024-03-21 10:02:16', '2024-03-21 10:02:16');

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint UNSIGNED NOT NULL,
  `data_keys` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_values` longtext COLLATE utf8mb4_unicode_ci,
  `tempname` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `tempname`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"google_verification\":\"\",\"bing_verification\":\"\",\"keywords\":[\"Healthcare Digital Growth\",\"Medical Website Design\",\"Doctor SEO\",\"Clinic Marketing\",\"Hospital Software\",\"Patient Appointment System\",\"Healthcare IT Solutions\",\"HIPAA Compliant Hosting\"],\"description\":\"3S Medi Care provides end-to-end digital growth solutions for doctors, clinics, hospitals, and diagnostic centers: high-converting medical websites, healthcare SEO ranking, patient appointment management, and specialized medical marketing.\",\"robots_meta\":\"index, follow\",\"canonical_url\":null,\"social_title\":\"3S Medi Care - Healthcare Expertise. Our Digital Growth.\",\"social_description\":\"Healthcare digital growth agency specializing in medical websites, local SEO ranking, patient appointment systems, and healthcare marketing for practices.\",\"image\":\"6af339f9bcebf1794324985.png\"}', NULL, '2020-07-04 23:42:52', '2026-11-10 15:54:32'),
(41, 'cookie.data', '{\"short_desc\":\"We use cookies to enhance your browsing experience and analyze our traffic.\",\"description\":\"<div class=\\\"cookie-policy-article\\\">\\n  <p class=\\\"lead text-secondary mb-4\\\" style=\\\"font-size: 1.05rem; line-height: 1.7;\\\">\\n    This Cookie Policy explains how <strong>3S Medi Care<\\/strong> uses cookies and similar tracking technologies when you visit our website, client portals, and digital tools. By continuing to browse or use our site, you agree to our use of cookies as described in this policy.\\n  <\\/p>\\n\\n  <div class=\\\"card bg-light border-0 p-3 mb-4 rounded-3\\\">\\n    <div class=\\\"d-flex align-items-center gap-2 text-dark small\\\">\\n      <i class=\\\"bi bi-info-circle text-primary fs-5\\\"><\\/i>\\n      <span><strong>Last Updated:<\\/strong> January 2026 | <strong>Scope:<\\/strong> 3S Medi Care Web Platforms & Portals<\\/span>\\n    <\\/div>\\n  <\\/div>\\n\\n  <h4 class=\\\"fw-bold text-dark mt-4 mb-3\\\">1. What Are Cookies?<\\/h4>\\n  <p class=\\\"mb-4\\\">\\n    Cookies are small text files placed on your computer or mobile device when you visit websites. They are widely used to make websites function efficiently, remember user preferences, provide seamless navigation between pages, and deliver anonymized analytical data to site operators.\\n  <\\/p>\\n\\n  <h4 class=\\\"fw-bold text-dark mt-4 mb-3\\\">2. Types of Cookies We Use<\\/h4>\\n  <p>We categorize cookies on 3S Medi Care into the following functional types:<\\/p>\\n  <ul class=\\\"mb-4\\\">\\n    <li><strong>Essential \\/ Strictly Necessary Cookies:<\\/strong> Required for the fundamental operation of our website, including security tokens, session management, CSRF protection on quote forms, and authentication for client accounts. Without these cookies, services you request cannot be provided.<\\/li>\\n    <li><strong>Performance &amp; Analytics Cookies:<\\/strong> Collect aggregated, non-personally identifiable information about how visitors interact with our pages (e.g., most visited sections, average time on site, bounce rates). This allows us to improve website responsiveness and streamline navigation for healthcare professionals.<\\/li>\\n    <li><strong>Functionality Cookies:<\\/strong> Remember your preferences (such as selected language, region, or previously viewed healthcare service categories) to provide a tailored, faster browsing experience.<\\/li>\\n    <li><strong>Security Cookies:<\\/strong> Used to detect fraudulent activity, verify legitimate inquiries, and safeguard our contact forms against automated bot submissions.<\\/li>\\n  <\\/ul>\\n\\n  <h4 class=\\\"fw-bold text-dark mt-4 mb-3\\\">3. Managing &amp; Controlling Cookies<\\/h4>\\n  <p>You have full control over your cookie settings. Most web browsers automatically accept cookies, but you can modify your browser settings to decline cookies or alert you when a cookie is placed:<\\/p>\\n  <ul class=\\\"mb-3\\\">\\n    <li><strong>Google Chrome:<\\/strong> Settings &rarr; Privacy and security &rarr; Cookies and other site data<\\/li>\\n    <li><strong>Mozilla Firefox:<\\/strong> Settings &rarr; Privacy &amp; Security &rarr; Cookies and Site Data<\\/li>\\n    <li><strong>Apple Safari:<\\/strong> Preferences &rarr; Privacy &rarr; Manage Website Data<\\/li>\\n    <li><strong>Microsoft Edge:<\\/strong> Settings &rarr; Cookies and site permissions<\\/li>\\n  <\\/ul>\\n  <p class=\\\"text-muted small mb-4\\\"><em>Note: Disabling essential cookies may impact certain interactive features, such as quote form submissions or client portal logins.<\\/em><\\/p>\\n\\n  <h4 class=\\\"fw-bold text-dark mt-4 mb-3\\\">4. Third-Party Analytics<\\/h4>\\n  <p class=\\\"mb-4\\\">\\n    We may partner with privacy-focused third-party analytics providers (such as Google Analytics with IP anonymization enabled) to analyze web traffic trends. These providers have their own independent privacy and cookie policies.\\n  <\\/p>\\n\\n  <h4 class=\\\"fw-bold text-dark mt-4 mb-3\\\">5. Updates to This Cookie Policy<\\/h4>\\n  <p class=\\\"mb-4\\\">\\n    We may periodically update this Cookie Policy to reflect changes in legal requirements or our operational practices. Any revisions will be published on this page with an updated effective date.\\n  <\\/p>\\n\\n  <h4 class=\\\"fw-bold text-dark mt-4 mb-3\\\">6. Inquiries<\\/h4>\\n  <p class=\\\"mb-0\\\">\\n    If you have any questions regarding our use of cookies, please reach out via email to <strong>privacy@3smedicare.com<\\/strong> or our general office at <strong>info@3smedicare.com<\\/strong>.\\n  <\\/p>\\n<\\/div>\"}', NULL, '2020-07-04 23:42:52', '2026-11-10 14:46:00'),
(42, 'policy_pages.element', '{\"title\":\"Privacy Policy\",\"details\":\"<div class=\\\"policy-article\\\">\\n  <p class=\\\"lead text-secondary mb-4\\\" style=\\\"font-size: 1.05rem; line-height: 1.7;\\\">\\n    At <strong>3S Medi Care<\\/strong>, we are committed to safeguarding the privacy and confidential information of healthcare providers, medical practitioners, clinics, hospitals, diagnostic centers, and their website visitors. This Privacy Policy outlines our practices regarding data collection, usage, storage, and protection when you use our websites, digital platforms, and healthcare marketing solutions.\\n  <\\/p>\\n\\n  <div class=\\\"card bg-light border-0 p-3 mb-4 rounded-3\\\">\\n    <div class=\\\"d-flex align-items-center gap-2 text-dark small\\\">\\n      <i class=\\\"bi bi-shield-check text-primary fs-5\\\"><\\/i>\\n      <span><strong>Effective Date:<\\/strong> January 2026 | <strong>Jurisdiction:<\\/strong> Healthcare Digital Compliance & Data Privacy Guidelines<\\/span>\\n    <\\/div>\\n  <\\/div>\\n\\n  <h4 class=\\\"fw-bold text-dark mt-4 mb-3\\\">1. Information We Collect<\\/h4>\\n  <p>We collect information necessary to provide specialized digital growth services for healthcare businesses, including:<\\/p>\\n  <ul class=\\\"mb-4\\\">\\n    <li><strong>Direct Contact Information:<\\/strong> Full name, professional medical title, business email address, telephone\\/WhatsApp number, office address, and clinic or organization name provided via our contact or quote forms.<\\/li>\\n    <li><strong>Practice &amp; Project Scope:<\\/strong> Medical specialty (e.g., Doctor, Hospital, Clinic, Diagnostic Center), desired services (e.g., Website Development, Healthcare SEO, Patient Appointment integrations), and project requirements.<\\/li>\\n    <li><strong>Technical &amp; Usage Data:<\\/strong> IP address, browser type, device information, operating system, and anonymized interaction statistics collected to optimize website performance.<\\/li>\\n  <\\/ul>\\n\\n  <h4 class=\\\"fw-bold text-dark mt-4 mb-3\\\">2. How We Use Your Information<\\/h4>\\n  <p>The information collected is used exclusively for legitimate business and healthcare service purposes:<\\/p>\\n  <ul class=\\\"mb-4\\\">\\n    <li>To evaluate your project requirements and prepare accurate, customized proposals and estimates.<\\/li>\\n    <li>To deliver, maintain, and optimize healthcare websites, portals, and digital marketing campaigns.<\\/li>\\n    <li>To communicate project updates, technical maintenance alerts, and respond to support inquiries.<\\/li>\\n    <li>To ensure compliance with applicable healthcare advertising guidelines, search engine standards, and data security protocols.<\\/li>\\n  <\\/ul>\\n\\n  <h4 class=\\\"fw-bold text-dark mt-4 mb-3\\\">3. Healthcare Data &amp; HIPAA Awareness<\\/h4>\\n  <p class=\\\"mb-4\\\">\\n    As a specialized digital agency serving the medical industry, <strong>3S Medi Care does not store or process patient Protected Health Information (PHI)<\\/strong> on our corporate promotional website. For client projects involving patient portals, telemedicine integrations, or appointment forms, we implement industry-standard encryption (TLS\\/SSL), HIPAA-compliant infrastructure recommendations, and strict role-based access control.\\n  <\\/p>\\n\\n  <h4 class=\\\"fw-bold text-dark mt-4 mb-3\\\">4. Information Sharing &amp; Third Parties<\\/h4>\\n  <p class=\\\"mb-4\\\">\\n    <strong>We never sell, rent, or trade your personal or business information to third-party advertisers.<\\/strong> We may share data strictly with trusted service providers who assist us in operating our platform (e.g., cloud hosting infrastructure, transactional email gateways), provided they agree to maintain strict confidentiality and security standards equivalent to our own.\\n  <\\/p>\\n\\n  <h4 class=\\\"fw-bold text-dark mt-4 mb-3\\\">5. Data Security &amp; Retention<\\/h4>\\n  <p class=\\\"mb-4\\\">\\n    We deploy robust administrative, technical, and physical safeguards to prevent unauthorized access, alteration, disclosure, or destruction of your information. Data is retained only for as long as necessary to fulfill the purposes outlined in this policy or as required by applicable laws.\\n  <\\/p>\\n\\n  <h4 class=\\\"fw-bold text-dark mt-4 mb-3\\\">6. Your Rights &amp; Choices<\\/h4>\\n  <p>Healthcare partners and website users have the right to:<\\/p>\\n  <ul class=\\\"mb-4\\\">\\n    <li>Request access to the personal data we hold about you.<\\/li>\\n    <li>Request correction of inaccurate or incomplete data.<\\/li>\\n    <li>Request deletion of your contact records from our communication databases.<\\/li>\\n    <li>Opt-out of non-essential communications at any time.<\\/li>\\n  <\\/ul>\\n\\n  <h4 class=\\\"fw-bold text-dark mt-4 mb-3\\\">7. Contact Our Privacy Officer<\\/h4>\\n  <p>If you have questions, concerns, or requests regarding this Privacy Policy or our data handling practices, please contact our team:<\\/p>\\n  <ul class=\\\"mb-0\\\">\\n    <li><strong>Email:<\\/strong> privacy@3smedicare.com \\/ info@3smedicare.com<\\/li>\\n    <li><strong>Phone:<\\/strong> +1 (555) 234-5678<\\/li>\\n    <li><strong>Division:<\\/strong> 3S Medi Care Healthcare Digital Division<\\/li>\\n  <\\/ul>\\n<\\/div>\"}', 'basic', '2021-06-09 08:50:42', '2026-11-10 14:46:00'),
(43, 'policy_pages.element', '{\"title\":\"Terms of Service\",\"details\":\"<div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><p class=\\\"MsoNormal\\\" style=\\\"background:#EDEDED;\\\"><b><span style=\\\"font-size:18pt;line-height:107%;\\\">Terms\\nof use<\\/span><\\/b><\\/p><p><b><\\/b><\\/p><b><\\/b><p class=\\\"MsoNormal\\\"><b><span style=\\\"font-size:14pt;line-height:107%;\\\">By\\nagreeing to use the site\'s services, you must comply with the following:<\\/span><\\/b><\\/p><p><b><\\/b><\\/p><b><\\/b><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">\\u00a0<\\/span><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\nadvertise or upload content or items that are inappropriate for the ratings\\navailable on the site that are allowed to be sold. You should review the\\nadvertising terms.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\nviolate or circumvent the laws, policies and regulations of the site or any\\nrights related to a third party.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\ncopy the advertisement from property incubator website and publish it on other\\nsites.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to use\\nany illegal means to access advertisements or other users\' data, to violate the\\npolicy and rights of property incubator, to access the content of the site, or\\nto collect and collect information and data related to property incubator or\\nthe customers of the site, and to benefit from it in any way or republish it.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\nviolate the restrictions on the site or the application, or to bypass or\\ncircumvent the breach of other measures used with the aim of preventing or\\nrestricting access to this site<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to use\\nour services if you are not legally qualified to complete this agreement, for\\nexample that you are under 18 years of age or you are temporarily or\\npermanently blocked from using the site.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\nmanipulate prices, whether in buying or selling, and causing harm to other\\ncustomers.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\npublish fake or speculative advertisements or false, inaccurate, misleading,\\ndeceptive, defamatory, or libelous comments, and Property Incubator website may\\ncancel, without prior notice, all unreal advertisements.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\ntake any action based on the opinions and evaluation of customers or depart\\nfrom the content of the advertisement.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to be\\nexposed to international policies, sovereignties, dignitaries, or any\\ndiscussions that are not related to legitimate buying and selling in property\\nincubator.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\npost, distribute or upload any defamatory, offensive, infringing, harmful,\\nthreatening, abusive, tortuous, racist, morally inappropriate or otherwise\\nunlawful content or information<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\nforge any file attached to property incubator website.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\ncopy the advertiser\'s right to any advertisement that has been added.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Do not\\ntransfer your account or activity to other sites while carrying our logo or\\nservices.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\nviolate copyrights, trademarks, patents, advertising, databases or other\\nproperty or intellectual rights belonging to property incubator or licensed to\\nthe property incubator.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\nviolate others\' property, intellectual or patent rights.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\ncollect information about other site users for commercial or other purposes.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to do\\nanything that might harm the reputation of property incubator<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\nimpersonate property custodian, representative or employee, or any capacity\\nsuggesting that you are affiliated with the company, unless you have official\\npermission from the company.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to\\nobtain or attempt to obtain unauthorized access to the site or any account of a\\nmember on the site, or to impersonate any person or misrepresent the membership\\nwith another person.<\\/span><\\/p><p><\\/p><p class=\\\"MsoNormal\\\"><span style=\\\"font-size:14pt;line-height:107%;\\\">- Not to use\\nany automated device, software or means to access, retrieve, copy or index the\\nApplication and\\/or our website or any content on our website.<\\/span><\\/p><p><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;padding:0px;text-align:justify;color:rgb(0,0,0);font-family:\'Open Sans\', Arial, sans-serif;font-size:14px;letter-spacing:normal;\\\">\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n<span style=\\\"font-size:14pt;line-height:107%;font-family:Calibri, sans-serif;\\\">- Not to perform any action that imposes any\\nburden or causes an increase in traffic demands on our infrastructure in the\\nway that we deem - in our sole discretion - to use the Site as unreasonable or\\ninappropriate.<\\/span><br \\/><\\/p><\\/div>\",\"details_ar\":\"<p class=\\\"MsoNormal\\\" align=\\\"right\\\" style=\\\"text-align:right;background:#EDEDED;\\\"><b><span lang=\\\"ar-sa\\\" dir=\\\"rtl\\\" style=\\\"font-size:20pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0634\\u0631\\u0648\\u0637 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062e\\u062f\\u0627\\u0645<\\/span><\\/b><b><span style=\\\"font-size:20pt;line-height:107%;\\\"><\\/span><\\/b><\\/p><p><b><\\/b><\\/p><b><\\/b><p class=\\\"MsoNormal\\\" dir=\\\"rtl\\\"><b><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0628\\u0645\\u0648\\u0627\\u0641\\u0642\\u062a\\u0643 \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0627\\u0633\\u062a\\u0641\\u0627\\u062f\\u0629 \\u0645\\u0646 \\u062e\\u062f\\u0645\\u0627\\u062a \\u0627\\u0644\\u0645\\u0648\\u0642\\u0639,\\n\\u0641\\u0639\\u0644\\u064a\\u0643 \\u0627\\u0644\\u0627\\u0644\\u062a\\u0632\\u0627\\u0645 \\u0628\\u0645\\u0627 \\u064a\\u0644\\u064a<\\/span><\\/b><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><b><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>:<\\/span><\\/b><\\/p><p><b><\\/b><\\/p><b><\\/b><p class=\\\"MsoNormal\\\" dir=\\\"rtl\\\"><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><\\/span><\\/p><p>\\u00a0<\\/p><p class=\\\"MsoListParagraphCxSpFirst\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0644\\u0625\\u0639\\u0644\\u0627\\u0646 \\u0623\\u0648 \\u062a\\u062d\\u0645\\u064a\\u0644 \\u0645\\u062d\\u062a\\u0648\\u0649 \\u0623\\u0648 \\u0639\\u0646\\u0627\\u0635\\u0631 \\u063a\\u064a\\u0631 \\u0645\\u0644\\u0627\\u0626\\u0645\\u0629 \\u0644\\u0644\\u062a\\u0635\\u0646\\u064a\\u0641\\u0627\\u062a \\u0627\\u0644\\u0645\\u062a\\u0627\\u062d\\u0629 \\u0641\\u064a\\n\\u0627\\u0644\\u0645\\u0648\\u0642\\u0639 \\u0648\\u0627\\u0644\\u0645\\u0633\\u0645\\u0648\\u062d \\u0628\\u0628\\u064a\\u0639\\u0647\\u0627. \\u0648\\u0639\\u0644\\u064a\\u0643 \\u0645\\u0631\\u0627\\u062c\\u0639\\u0629 \\u0634\\u0631\\u0648\\u0637 \\u0627\\u0644\\u0625\\u0639\\u0644\\u0627\\u0646<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0644\\u0627\\u062e\\u062a\\u0631\\u0627\\u0642 \\u0623\\u0648 \\u0627\\u0644\\u062a\\u062d\\u0627\\u064a\\u0644 \\u0639\\u0644\\u0649 \\u0642\\u0648\\u0627\\u0646\\u064a\\u0646 \\u0648\\u0633\\u064a\\u0627\\u0633\\u0629 \\u0648\\u0623\\u0646\\u0638\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0648\\u0642\\u0639 \\u0623\\u0648 \\u0623\\u064a \\u062d\\u0642\\u0648\\u0642\\n\\u062a\\u062a\\u0639\\u0644\\u0642 \\u0628\\u0637\\u0631\\u0641 \\u062b\\u0627\\u0644\\u062b<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0646\\u0633\\u062e \\u0627\\u0644\\u0625\\u0639\\u0644\\u0627\\u0646 \\u0645\\u0646 \\u0645\\u0648\\u0642\\u0639 \\u062d\\u0627\\u0636\\u0646\\u0629 \\u0627\\u0644\\u0623\\u0645\\u0644\\u0627\\u0643 \\u0648\\u0646\\u0634\\u0631\\u0647 \\u0641\\u064a \\u0645\\u0648\\u0627\\u0642\\u0639 \\u0623\\u062e\\u0631\\u0649<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0633\\u062a\\u062e\\u062f\\u0627\\u0645 \\u0623\\u064a \\u0648\\u0633\\u064a\\u0644\\u0629 \\u063a\\u064a\\u0631 \\u0634\\u0631\\u0639\\u064a\\u0629 \\u0644\\u0644\\u0648\\u0635\\u0648\\u0644 \\u0644\\u0644\\u0625\\u0639\\u0644\\u0627\\u0646\\u0627\\u062a \\u0623\\u0648 \\u0644\\u0628\\u064a\\u0627\\u0646\\u0627\\u062a \\u0627\\u0644\\u0645\\u0633\\u062a\\u062e\\u062f\\u0645\\u064a\\u0646\\n\\u0627\\u0644\\u0622\\u062e\\u0631\\u064a\\u0646 \\u0623\\u0648 \\u0627\\u0646\\u062a\\u0647\\u0627\\u0643 \\u0644\\u0633\\u064a\\u0627\\u0633\\u0629 \\u0648\\u062d\\u0642\\u0648\\u0642 \\u062d\\u0627\\u0636\\u0646\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643 \\u0623\\u0648 \\u0627\\u0644\\u0648\\u0635\\u0648\\u0644 \\u0644\\u0645\\u062d\\u062a\\u0648\\u0649 \\u0627\\u0644\\u0645\\u0648\\u0642\\u0639 \\u0623\\u0648 \\u062a\\u062c\\u0645\\u064a\\u0639\\n\\u0648\\u062a\\u062d\\u0635\\u064a\\u0644 \\u0645\\u0639\\u0644\\u0648\\u0645\\u0627\\u062a \\u0648\\u0628\\u064a\\u0627\\u0646\\u0627\\u062a \\u062a\\u062e\\u0635 \\u062d\\u0627\\u0636\\u0646\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643 \\u0623\\u0648 \\u0639\\u0645\\u0644\\u0627\\u0621 \\u0627\\u0644\\u0645\\u0648\\u0642\\u0639 \\u0648 \\u0627\\u0644\\u0627\\u0633\\u062a\\u0641\\u0627\\u062f\\u0629 \\u0645\\u0646\\u0647\\u0627 \\u0628\\u0623\\u064a\\n\\u0634\\u0643\\u0644 \\u0645\\u0646 \\u0627\\u0644\\u0623\\u0634\\u0643\\u0627\\u0644 \\u0623\\u0648 \\u0625\\u0639\\u0627\\u062f\\u0629 \\u0646\\u0634\\u0631\\u0647\\u0627<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0646\\u062a\\u0647\\u0627\\u0643 \\u0627\\u0644\\u0642\\u064a\\u0648\\u062f \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0645\\u0648\\u0642\\u0639 \\u0623\\u0648 \\u0627\\u0644\\u062a\\u0637\\u0628\\u064a\\u0642 \\u0623\\u0648 \\u0623\\u064a \\u062a\\u062c\\u0627\\u0648\\u0632 \\u0623\\u0648 \\u062a\\u062d\\u0627\\u064a\\u0644 \\u0644\\u062e\\u0631\\u0642\\n\\u0627\\u0644\\u062a\\u062f\\u0627\\u0628\\u064a\\u0631 \\u0627\\u0644\\u0623\\u062e\\u0631\\u0649 \\u0627\\u0644\\u0645\\u0633\\u062a\\u062e\\u062f\\u0645\\u0629 \\u0628\\u0647\\u062f\\u0641 \\u0645\\u0646\\u0639 \\u0623\\u0648 \\u062a\\u0642\\u064a\\u064a\\u062f \\u0627\\u0644\\u0648\\u0635\\u0648\\u0644 \\u0644\\u0647\\u0630\\u0627 \\u0627\\u0644\\u0645\\u0648\\u0642\\u0639<\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0633\\u062a\\u062e\\u062f\\u0627\\u0645 \\u062e\\u062f\\u0645\\u0627\\u062a\\u0646\\u0627 \\u0625\\u0630\\u0627 \\u0643\\u0646\\u062a \\u063a\\u064a\\u0631 \\u0645\\u0624\\u0647\\u0644 \\u0642\\u0627\\u0646\\u0648\\u0646\\u064a\\u0627 \\u0644\\u0625\\u062a\\u0645\\u0627\\u0645 \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0627\\u062a\\u0641\\u0627\\u0642\\u064a\\u0629,\\n\\u0639\\u0644\\u0649 \\u0633\\u0628\\u064a\\u0644 \\u0627\\u0644\\u0645\\u062b\\u0627\\u0644 \\u0623\\u0646\\u0643 \\u0623\\u0642\\u0644 \\u0645\\u0646 18 \\u0633\\u0646\\u0629 \\u0623\\u0648 \\u0623\\u0646\\u0643 \\u0645\\u062d\\u062c\\u0648\\u0628 \\u0628\\u0634\\u0643\\u0644 \\u0645\\u0624\\u0642\\u062a \\u0623\\u0648 \\u062f\\u0627\\u0626\\u0645 \\u0645\\u0646 \\u0627\\u0633\\u062a\\u062e\\u062f\\u0627\\u0645\\n\\u0627\\u0644\\u0645\\u0648\\u0642\\u0639<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0644\\u062a\\u0644\\u0627\\u0639\\u0628 \\u0628\\u0627\\u0644\\u0623\\u0633\\u0639\\u0627\\u0631 \\u0633\\u0648\\u0627\\u0621 \\u0641\\u064a \\u0627\\u0644\\u0628\\u064a\\u0639 \\u0623\\u0648 \\u0627\\u0644\\u0634\\u0631\\u0627\\u0621 \\u0648 \\u0625\\u0644\\u062d\\u0627\\u0642 \\u0627\\u0644\\u0636\\u0631\\u0631 \\u0628\\u0627\\u0644\\u0639\\u0645\\u0644\\u0627\\u0621\\n\\u0627\\u0644\\u0622\\u062e\\u0631\\u064a\\u0646<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0646\\u0634\\u0631 \\u0625\\u0639\\u0644\\u0627\\u0646\\u0627\\u062a \\u0648\\u0647\\u0645\\u064a\\u0629 \\u0627\\u0648 \\u062a\\u062e\\u0645\\u064a\\u0646\\u064a\\u0629 \\u0623\\u0648 \\u062a\\u0639\\u0644\\u064a\\u0642\\u0627\\u062a \\u0643\\u0627\\u0630\\u0628\\u0629 \\u0623\\u0648 \\u063a\\u064a\\u0631 \\u062f\\u0642\\u064a\\u0642\\u0629 \\u0623\\u0648\\n\\u0645\\u0636\\u0644\\u0644\\u0629 \\u0623\\u0648 \\u062e\\u0627\\u062f\\u0639\\u0629 \\u0623\\u0648 \\u0642\\u0630\\u0641\\u060c \\u0623\\u0648 \\u062a\\u0634\\u0647\\u064a\\u0631 \\u0648 \\u0645\\u0646 \\u0627\\u0644\\u0645\\u0645\\u0643\\u0646 \\u0644\\u0645\\u0648\\u0642\\u0639 \\u062d\\u0627\\u0636\\u0646\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643 \\u0623\\u0646 \\u064a\\u0642\\u0648\\u0645\\n\\u0628\\u0627\\u0644\\u0625\\u0644\\u063a\\u0627\\u0621\\u060c \\u0648\\u0628\\u062f\\u0648\\u0646 \\u0633\\u0627\\u0628\\u0642 \\u0625\\u0646\\u0630\\u0627\\u0631\\u060c \\u0643\\u0644 \\u0627\\u0644\\u0625\\u0639\\u0644\\u0627\\u0646\\u0627\\u062a \\u0627\\u0644\\u063a\\u064a\\u0631 \\u062d\\u0642\\u064a\\u0642\\u0629<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span> .<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u062a\\u062e\\u0627\\u0630 \\u0623\\u064a \\u0625\\u062c\\u0631\\u0627\\u0621 \\u0645\\u0628\\u0646\\u064a \\u0639\\u0644\\u0649 \\u0623\\u0631\\u0627\\u0621 \\u0648\\u062a\\u0642\\u064a\\u064a\\u0645 \\u0627\\u0644\\u0639\\u0645\\u0644\\u0627\\u0621 \\u0623\\u0648 \\u0627\\u0644\\u062e\\u0631\\u0648\\u062c \\u0639\\u0646 \\u0645\\u062d\\u062a\\u0648\\u0649\\n\\u0627\\u0644\\u0625\\u0639\\u0644\\u0627\\u0646<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span> .<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0644\\u062a\\u0639\\u0631\\u0636 \\u0644\\u0644\\u0633\\u064a\\u0627\\u0633\\u0627\\u062a \\u0623\\u0648 \\u0627\\u0644\\u0633\\u064a\\u0627\\u062f\\u0627\\u062a \\u0627\\u0644\\u062f\\u0648\\u0644\\u064a\\u0629 \\u0623\\u0648 \\u0627\\u0644\\u0634\\u062e\\u0635\\u064a\\u0627\\u062a \\u0627\\u0644\\u0645\\u0639\\u062a\\u0628\\u0631\\u0629 \\u0623\\u0648 \\u0623\\u064a\\n\\u0645\\u0646\\u0627\\u0642\\u0634\\u0627\\u062a \\u0644\\u0627 \\u062a\\u062a\\u0639\\u0644\\u0642 \\u0628\\u0627\\u0644\\u0628\\u064a\\u0639 \\u0648\\u0627\\u0644\\u0634\\u0631\\u0627\\u0621 \\u0627\\u0644\\u0645\\u0634\\u0631\\u0648\\u0639\\u0629 \\u0641\\u064a \\u062d\\u0627\\u0636\\u0646\\u0629 \\u0627\\u0644\\u0623\\u0645\\u0644\\u0627\\u0643<\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0646\\u0634\\u0631\\u060c \\u062a\\u0648\\u0632\\u064a\\u0639 \\u0623\\u0648 \\u062a\\u062d\\u0645\\u064a\\u0644 \\u0623\\u064a \\u0645\\u0648\\u0627\\u062f \\u062a\\u0634\\u0647\\u064a\\u0631\\u064a\\u0629\\u060c \\u0647\\u062c\\u0648\\u0645\\u064a\\u0629\\u060c \\u0627\\u0646\\u062a\\u0647\\u0627\\u0643\\u064a\\u0629\\u060c \\u0645\\u0636\\u0631\\u0629\\u060c\\n\\u062a\\u0647\\u062f\\u064a\\u062f\\u064a\\u0629\\u060c \\u0645\\u0633\\u064a\\u0626\\u0629\\u060c \\u0645\\u0644\\u062a\\u0648\\u064a\\u0629 \\u0623\\u0648 \\u0639\\u0646\\u0635\\u0631\\u064a\\u0629 \\u060c\\u0623\\u0648 \\u063a\\u064a\\u0631 \\u0645\\u0644\\u0627\\u0626\\u0645\\u0629 \\u0623\\u062e\\u0644\\u0627\\u0642\\u064a\\u0627\\u064b \\u0623\\u0648 \\u063a\\u064a\\u0631 \\u0630\\u0644\\u0643 \\u0645\\u0646 \\u0645\\u062d\\u062a\\u0648\\u0649 \\u0623\\u0648\\n\\u0645\\u0639\\u0644\\u0648\\u0645\\u0627\\u062a \\u063a\\u064a\\u0631 \\u0642\\u0627\\u0646\\u0648\\u0646\\u064a\\u0629<\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0644\\u0642\\u064a\\u0627\\u0645 \\u0628\\u062a\\u0632\\u0648\\u064a\\u0631 \\u0623\\u064a \\u0645\\u0644\\u0641 \\u0645\\u0631\\u0641\\u0642 \\u0644\\u0645\\u0648\\u0642\\u0639 \\u062d\\u0627\\u0636\\u0646\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>\\n.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0644\\u0642\\u064a\\u0627\\u0645 \\u0628\\u0646\\u0633\\u062e \\u062d\\u0642 \\u0627\\u0644\\u0645\\u0639\\u0644\\u0646 \\u0641\\u064a \\u0623\\u064a \\u0625\\u0639\\u0644\\u0627\\u0646 \\u062a\\u0645 \\u0627\\u0636\\u0627\\u0641\\u062a\\u0647<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>\\n.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0646\\u0642\\u0644 \\u062d\\u0633\\u0627\\u0628\\u0643 \\u0623\\u0648 \\u0646\\u0634\\u0627\\u0637\\u0643 \\u0625\\u0644\\u0649 \\u0645\\u0648\\u0627\\u0642\\u0639 \\u0623\\u062e\\u0631\\u0649 \\u0628\\u0627\\u0644\\u0648\\u0642\\u062a \\u0627\\u0644\\u0630\\u064a \\u0647\\u0648 \\u064a\\u062d\\u0645\\u0644 \\u0634\\u0639\\u0627\\u0631 \\u0623\\u0648 \\u062e\\u062f\\u0645\\u0627\\u062a\\u0646\\u0627<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0646\\u062a\\u0647\\u0627\\u0643 \\u062d\\u0642\\u0648\\u0642 \\u0627\\u0644\\u0637\\u0628\\u0639 \\u0648\\u0627\\u0644\\u0646\\u0634\\u0631 \\u0648\\u0627\\u0644\\u0639\\u0644\\u0627\\u0645\\u0627\\u062a \\u0627\\u0644\\u062a\\u062c\\u0627\\u0631\\u064a\\u0629\\u060c \\u0648\\u0628\\u0631\\u0627\\u0621\\u0627\\u062a \\u0627\\u0644\\u0627\\u062e\\u062a\\u0631\\u0627\\u0639\\n\\u0648\\u0627\\u0644\\u062f\\u0639\\u0627\\u064a\\u0629 \\u0648\\u0642\\u0648\\u0627\\u0639\\u062f \\u0627\\u0644\\u0628\\u064a\\u0627\\u0646\\u0627\\u062a \\u0623\\u0648 \\u063a\\u064a\\u0631\\u0647\\u0627 \\u0645\\u0646 \\u062d\\u0642\\u0648\\u0642 \\u0627\\u0644\\u0645\\u0644\\u0643\\u064a\\u0629 \\u0623\\u0648 \\u0627\\u0644\\u0641\\u0643\\u0631\\u064a\\u0629 \\u0627\\u0644\\u062a\\u064a \\u062a\\u0646\\u062a\\u0645\\u064a \\u0644\\u062d\\u0627\\u0636\\u0646\\u0629\\n\\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643 \\u0623\\u0648 \\u0645\\u0631\\u062e\\u0635\\u0629 \\u0644\\u062d\\u0627\\u0636\\u0646\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0646\\u062a\\u0647\\u0627\\u0643 \\u062d\\u0642\\u0648\\u0642 \\u0627\\u0644\\u0622\\u062e\\u0631\\u064a\\u0646 \\u0627\\u0644\\u0645\\u0644\\u0643\\u064a\\u0629 \\u0623\\u0648 \\u0627\\u0644\\u0641\\u0643\\u0631\\u064a\\u0629 \\u0623\\u0648 \\u0628\\u0631\\u0627\\u0621\\u0629 \\u0627\\u0644\\u0627\\u062e\\u062a\\u0631\\u0627\\u0639<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u062c\\u0645\\u0639 \\u0645\\u0639\\u0644\\u0648\\u0645\\u0627\\u062a \\u0639\\u0646 \\u0645\\u0633\\u062a\\u062e\\u062f\\u0645\\u064a \\u0627\\u0644\\u0645\\u0648\\u0642\\u0639 \\u0627\\u0644\\u0622\\u062e\\u0631\\u064a\\u0646 \\u0644\\u0623\\u063a\\u0631\\u0627\\u0636 \\u062a\\u062c\\u0627\\u0631\\u064a\\u0629 \\u0623\\u0648 \\u063a\\u064a\\u0631\\u0647\\u0627<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0644\\u0625\\u0642\\u062f\\u0627\\u0645 \\u0639\\u0644\\u0649 \\u0623\\u064a \\u0645\\u0627 \\u0645\\u0646 \\u0634\\u0623\\u0646\\u0647 \\u0625\\u0644\\u062d\\u0627\\u0642 \\u0627\\u0644\\u0636\\u0631\\u0631 \\u0628\\u0633\\u0645\\u0639\\u0629 \\u062d\\u0627\\u0636\\u0646\\u0629 \\u0627\\u0644\\u0623\\u0645\\u0644\\u0627\\u0643<\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0646\\u062a\\u062d\\u0627\\u0644 \\u0635\\u0641\\u0629 \\u062d\\u0627\\u0636\\u0646\\u0629 \\u0627\\u0644\\u0623\\u0645\\u0644\\u0627\\u0643 \\u0623\\u0648 \\u0645\\u0645\\u062b\\u0644 \\u0644\\u0647\\u0627 \\u0623\\u0648 \\u0645\\u0648\\u0638\\u0641 \\u0641\\u064a\\u0647\\u0627 \\u0623\\u0648 \\u0623\\u064a \\u0635\\u0641\\u0629\\n\\u062a\\u0648\\u062d\\u064a \\u0628\\u0623\\u0646\\u0643 \\u062a\\u0627\\u0628\\u0639 \\u0644\\u0644\\u0634\\u0631\\u0643\\u0629 \\u0645\\u0627 \\u0644\\u0645 \\u064a\\u0643\\u0648\\u0646 \\u0644\\u062f\\u064a\\u0643 \\u0623\\u0630\\u0646 \\u0631\\u0633\\u0645\\u064a \\u0645\\u0646 \\u0627\\u0644\\u0634\\u0631\\u0643\\u0629<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpMiddle\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0644\\u062d\\u0635\\u0648\\u0644 \\u0623\\u0648 \\u0645\\u062d\\u0627\\u0648\\u0644\\u0629 \\u0627\\u0644\\u062d\\u0635\\u0648\\u0644 \\u0639\\u0644\\u0649 \\u062f\\u062e\\u0648\\u0644 \\u063a\\u064a\\u0631 \\u0645\\u0635\\u0631\\u062d \\u0628\\u0647 \\u0644\\u0644\\u0645\\u0648\\u0642\\u0639 \\u0623\\u0648 \\u0623\\u064a \\u062d\\u0633\\u0627\\u0628\\n\\u0644\\u0639\\u0636\\u0648 \\u0645\\u062a\\u0648\\u0627\\u062c\\u062f \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0645\\u0648\\u0642\\u0639 \\u060c\\u0623\\u0648 \\u0627\\u0646\\u062a\\u062d\\u0627\\u0644 \\u0623\\u064a \\u0634\\u062e\\u0635\\u064a\\u0629 \\u0623\\u0648 \\u062a\\u062d\\u0631\\u064a\\u0641 \\u0627\\u0644\\u0639\\u0636\\u0648\\u064a\\u0629 \\u0645\\u0639 \\u0634\\u062e\\u0635 \\u0622\\u062e\\u0631<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>.<\\/span><\\/p><p><\\/p><p class=\\\"MsoListParagraphCxSpLast\\\" dir=\\\"rtl\\\" style=\\\"margin:0cm 36pt 8pt 0cm;text-indent:-18pt;\\\"><span style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\">-<span style=\\\"font-size:7pt;line-height:normal;font-family:\'Times New Roman\';\\\">\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\u00a0\\n<\\/span><\\/span><span dir=\\\"rtl\\\"><\\/span><span lang=\\\"ar-sa\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645 \\u0627\\u0633\\u062a\\u062e\\u062f\\u0627\\u0645 \\u0623\\u064a \\u062c\\u0647\\u0627\\u0632 \\u0622\\u0644\\u064a\\u060c \\u0623\\u0648 \\u0628\\u0631\\u0627\\u0645\\u062c \\u0623\\u0648 \\u0648\\u0633\\u064a\\u0644\\u0629 \\u0644\\u0644\\u0648\\u0635\\u0648\\u0644 \\u0625\\u0644\\u0649 \\u0623\\u0648 \\u0627\\u0633\\u062a\\u0631\\u062f\\u0627\\u062f \\u0623\\u0648\\n\\u0646\\u0633\\u062e \\u0623\\u0648 \\u0641\\u0647\\u0631\\u0633\\u0629 \\u0627\\u0644\\u062a\\u0637\\u0628\\u064a\\u0642 \\u0648\\/\\u0627\\u0648 \\u0627\\u0644\\u0645\\u0648\\u0642\\u0639 \\u0627\\u0644\\u0625\\u0644\\u0643\\u062a\\u0631\\u0648\\u0646\\u064a \\u0627\\u0644\\u062e\\u0627\\u0635 \\u0628\\u0646\\u0627 \\u0623\\u0648 \\u0623\\u064a \\u0645\\u062d\\u062a\\u0648\\u0649 \\u0639\\u0644\\u0649 \\u0645\\u0648\\u0642\\u0639\\u0646\\u0627\\n\\u0639\\u0644\\u0649 \\u0627\\u0644\\u0625\\u0646\\u062a\\u0631\\u0646\\u062a<\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\" style=\\\"font-size:16pt;line-height:107%;\\\"><span dir=\\\"ltr\\\"><\\/span><span dir=\\\"ltr\\\"><\\/span>.<\\/span><\\/p><p><\\/p><p style=\\\"margin-right:0px;margin-bottom:15px;margin-left:0px;padding:0px;text-align:justify;\\\">\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n\\n<span lang=\\\"ar-sa\\\" dir=\\\"rtl\\\" style=\\\"font-size:16pt;line-height:107%;font-family:Arial, sans-serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0639\\u062f\\u0645\\n\\u062a\\u0646\\u0641\\u064a\\u0630 \\u0623\\u064a \\u0639\\u0645\\u0644 \\u064a\\u0648\\u0642\\u0639 \\u0623\\u064a \\u0639\\u0628\\u0621 \\u0623\\u0648 \\u064a\\u062a\\u0633\\u0628\\u0628 \\u0641\\u064a \\u0632\\u064a\\u0627\\u062f\\u0629 \\u0637\\u0644\\u0628\\u0627\\u062a \\u062d\\u0631\\u0643\\u0629 \\u0627\\u0644\\u0628\\u064a\\u0627\\u0646\\u0627\\u062a \\u0639\\u0644\\u0649 \\u0628\\u0646\\u064a\\u062a\\u0646\\u0627\\n\\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629 \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0646\\u062d\\u0648 \\u0627\\u0644\\u0630\\u064a \\u0646\\u0631\\u0627\\u0647 - \\u0628\\u0645\\u062d\\u0636 \\u062a\\u0642\\u062f\\u064a\\u0631\\u0646\\u0627 - \\u0627\\u0633\\u062a\\u062e\\u062f\\u0627\\u0645\\u0627\\u064b \\u063a\\u064a\\u0631 \\u0645\\u0639\\u0642\\u0648\\u0644 \\u0623\\u0648 \\u063a\\u064a\\u0631 \\u0645\\u0646\\u0627\\u0633\\u0628\\n\\u0644\\u0644\\u0645\\u0648\\u0642\\u0639<\\/span><br \\/><\\/p>\"}', 'basic', '2021-06-09 08:51:18', '2024-04-18 12:05:41');
INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `tempname`, `created_at`, `updated_at`) VALUES
(44, 'maintenance.data', '{\"description\":\"<div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"text-align: center; font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">What information do we collect?<\\/h3><p class=\\\"font-18\\\" style=\\\"text-align: center; margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">We gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p><\\/div>\"}', NULL, '2020-07-04 23:42:52', '2024-01-02 22:32:57'),
(46, 'app_download.content', '{\"has_image\":\"1\",\"heading\":\"Your gate to commercial properties\",\"heading_ar\":\"\\u0628\\u0648\\u0627\\u0628\\u062a\\u0643 \\u0644\\u0644\\u0639\\u0642\\u0627\\u0631\\u0627\\u062a \\u0627\\u0644\\u062a\\u062c\\u0627\\u0631\\u064a\\u0629\",\"subheading\":\"Search easily for your desired properties\",\"subheading_ar\":\"\\u0627\\u0628\\u062d\\u062b \\u0628\\u0643\\u0644 \\u0633\\u0647\\u0648\\u0644\\u0629 \\u0648\\u064a\\u0633\\u0631 \\u0639\\u0646 \\u0627\\u0644\\u0639\\u0642\\u0627\\u0631\\u0627\\u062a \\u0627\\u0644\\u0645\\u0646\\u0627\\u0633\\u0628\\u0629 \\u0644\\u0643\",\"description\":\"Properties for sales, rent, auctions, and other services, all in one place\",\"description_ar\":\"\\u0639\\u0642\\u0627\\u0631\\u0627\\u062a \\u0644\\u0644\\u0628\\u064a\\u0639, \\u0644\\u0644\\u0627\\u064a\\u062c\\u0627\\u0631, \\u0645\\u0632\\u0627\\u062f\\u0627\\u062a, \\u0648\\u062e\\u062f\\u0645\\u0627\\u062a \\u0623\\u062e\\u0631\\u0649, \\u0643\\u0644\\u0647\\u0627 \\u0628\\u0645\\u0643\\u0627\\u0646 \\u0648\\u0627\\u062d\\u062f\",\"app_store_link\":\"#\",\"google_store_link\":\"#\",\"image\":\"65b3eb80741051706290048.png\",\"app_store\":\"65b3eb81481401706290049.png\",\"google_play\":\"65b3eb81494e21706290049.png\"}', 'basic', '2024-01-26 11:27:28', '2024-02-27 05:37:41'),
(242, 'footer.content', '{\"about_text\":\"Healthcare-focused digital services for practices ready to build a stronger online presence.\",\"email\":\"info@3smedicare.com\",\"phone\":\"+1 (555) 234-5678\",\"hours\":\"Mon - Fri: 9:00 AM - 6:00 PM\",\"location\":\"Medical Arts Plaza, Suite 400\",\"copyright_text\":\"All rights reserved.\"}', NULL, '2024-07-30 06:37:39', '2026-11-10 15:31:02'),
(243, 'hero_section.content', '{\"rating\":\"+4.9 Rating\",\"rating_ar\":\"\\u062a\\u0642\\u064a\\u064a\\u0645 +4.9\",\"title\":\"Formed over 200+ businesses\",\"title_ar\":\"\\u0623\\u0633\\u0633 \\u0623\\u0643\\u062b\\u0631 \\u0645\\u0646 200 \\u0634\\u0631\\u0643\\u0629\",\"heading\":\"Amlaek\\u2026 A Platform Connecting Investment with Opportunities\",\"heading_ar\":\"\\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643\\u2026 \\u0631\\u0628\\u0637 \\u0627\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646 \\u0628\\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0648 \\u0627\\u0644\\u0645\\u0648\\u0631\\u062f\\u064a\\u0646 \\u0648 \\u0627\\u0644\\u0641\\u0631\\u0635 \\u0627\\u0644\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629\",\"description\":\"<span style=\\\"font-size:11pt;line-height:107%;font-family:Calibri, sans-serif;\\\">A holding group and\\nbusiness incubator operating as a <strong>company factory<\\/strong>, driving\\ninnovation and supporting the growth of projects and investments through an\\nintegrated ecosystem that combines <strong>digital transformation, innovation, and\\nsustainability<\\/strong><\\/span><div><span style=\\\"font-size:11pt;line-height:107%;font-family:Calibri, sans-serif;\\\"><\\/span><p>We develop and manage business ecosystems across strategic economic sectors,\\nproviding a comprehensive environment that enables <strong>investors,\\nentrepreneurs, and companies<\\/strong> to grow and expand in both <strong>local\\nand global markets<\\/strong>.<\\/p><p><\\/p><\\/div>\",\"description_ar\":\"<p class=\\\"MsoNormal\\\" dir=\\\"rtl\\\" style=\\\"direction:rtl;\\\"><b><span dir=\\\"ltr\\\" style=\\\"font-size:18pt;line-height:107%;font-family:\'Times New Roman\', serif;\\\"><\\/span><\\/b><\\/p><p><b>&nbsp;<\\/b><\\/p><b><\\/b><span style=\\\"font-family:\'Times New Roman\', serif;font-size:12pt;\\\">\\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0642\\u0627\\u0628\\u0636\\u0629 \\u062d\\u0627\\u0636\\u0646\\u0629 \\u0643\\u0645\\u0635\\u0646\\u0639 \\u0634\\u0631\\u0643\\u0627\\u062a \\u062a\\u0642\\u0648\\u062f \\u0627\\u0644\\u0627\\u0628\\u062a\\u0643\\u0627\\u0631 \\u0648\\u062a\\u062f\\u0639\\u0645 \\u0646\\u0645\\u0648 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u0627\\u062a \\u0639\\u0628\\u0631 \\u0645\\u0646\\u0638\\u0648\\u0645\\u0629 \\u0645\\u062a\\u0643\\u0627\\u0645\\u0644\\u0629 \\u062a\\u062c\\u0645\\u0639 \\u0628\\u064a\\u0646 <\\/span><b style=\\\"font-family:\'Times New Roman\', serif;font-size:12pt;\\\">\\u0627\\u0644\\u062a\\u062d\\u0648\\u0644 \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a\\u060c \\u0627\\u0644\\u0627\\u0628\\u062a\\u0643\\u0627\\u0631\\u060c \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062f\\u0627\\u0645\\u0629<\\/b><p class=\\\"MsoNormal\\\" dir=\\\"rtl\\\" style=\\\"direction:rtl;\\\"><span lang=\\\"ar-sa\\\" dir=\\\"rtl\\\" style=\\\"font-size:12pt;line-height:107%;font-family:\'Times New Roman\', serif;\\\" xml:lang=\\\"ar-sa\\\">\\u0646\\u0639\\u0645\\u0644 \\u0639\\u0644\\u0649 \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0648\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0645\\u0646\\u0638\\u0648\\u0645\\u0627\\u062a \\u0623\\u0639\\u0645\\u0627\\u0644 \\u0641\\u064a \\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629 \\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629\\u060c \\u0645\\u0639 \\u062a\\u0648\\u0641\\u064a\\u0631 \\u0628\\u064a\\u0626\\u0629 \\u0645\\u062a\\u0643\\u0627\\u0645\\u0644\\u0629 \\u0644\\u062a\\u0645\\u0643\\u064a\\u0646 \\u0627\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646 \\u0648\\u0631\\u0648\\u0627\\u062f \\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644 \\u0648\\u0627\\u0644\\u0634\\u0631\\u0643\\u0627\\u062a \\u0645\\u0646 \\u0627\\u0644\\u0646\\u0645\\u0648 \\u0648\\u0627\\u0644\\u062a\\u0648\\u0633\\u0639 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0633\\u0648\\u0627\\u0642 \\u0627\\u0644\\u0645\\u062d\\u0644\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0639\\u0627\\u0644\\u0645\\u064a\\u0629<\\/span><b style=\\\"font-family:\'Times New Roman\', serif;font-size:12pt;\\\"><\\/b><\\/p>\",\"explore_button\":\"Explore Sectors\",\"explore_button_ar\":\"\\u0627\\u0633\\u062a\\u0643\\u0634\\u0641 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a\",\"explore_button_link\":\"\\/sectors\",\"investment_button\":\"Explore Investment opportunities\",\"investment_button_ar\":\"\\u0627\\u0633\\u062a\\u0643\\u0634\\u0641 \\u0641\\u0631\\u0635 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\",\"investment_button_link\":\"\\/opportunities\",\"experience\":\"25 Years of Experience\",\"experience_ar\":\"25 \\u0639\\u0627\\u0645\\u064b\\u0627 \\u0645\\u0646 \\u0627\\u0644\\u062e\\u0628\\u0631\\u0629\",\"activities\":\"Over 200 Commercial & Investment Activities\",\"activities_ar\":\"\\u0623\\u0643\\u062b\\u0631 \\u0645\\u0646 200 \\u0646\\u0634\\u0627\\u0637 \\u062a\\u062c\\u0627\\u0631\\u064a \\u0648\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\",\"has_image\":\"1\",\"image\":\"69d7934b00ca31775735627.jpg\"}', NULL, '2026-04-07 11:02:41', '2026-05-13 19:08:00'),
(244, 'static_banner.element', '{\"title\":\"25+\",\"title_ar\":\"25+\",\"subtitle\":\"Years of experience in business development and investment\",\"subtitle_ar\":\"\\u0633\\u0646\\u0629 \\u0645\\u0646 \\u0627\\u0644\\u062e\\u0628\\u0631\\u0629 \\u0641\\u064a \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644 \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\"}', NULL, '2026-04-07 11:55:21', '2026-04-28 13:53:06'),
(245, 'static_banner.element', '{\"title\":\"200+\",\"title_ar\":\"200+\",\"subtitle\":\"Commercial and investment activities\",\"subtitle_ar\":\"\\u0646\\u0634\\u0627\\u0637 \\u062a\\u062c\\u0627\\u0631\\u064a \\u0648 \\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\"}', NULL, '2026-04-07 11:55:40', '2026-04-28 13:52:50'),
(246, 'static_banner.element', '{\"title\":\"12+\",\"title_ar\":\"12+\",\"subtitle\":\"Economic sectors\",\"subtitle_ar\":\"\\u0642\\u0637\\u0627\\u0639 \\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\"}', NULL, '2026-04-07 11:56:05', '2026-04-28 13:52:06'),
(247, 'static_banner.element', '{\"title\":\"100+\",\"title_ar\":\"100+\",\"subtitle\":\"Local and international strategic partners\",\"subtitle_ar\":\"\\u0634\\u0631\\u064a\\u0643 \\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a \\u0645\\u062d\\u0644\\u064a \\u0648 \\u062f\\u0648\\u0644\\u064a\"}', NULL, '2026-04-07 11:56:27', '2026-04-28 13:52:30'),
(248, 'our_business_model.content', '{\"has_image\":\"1\",\"heading\":\"Our Business Model\",\"heading_ar\":\"\\u0646\\u0645\\u0648\\u0630\\u062c \\u0623\\u0639\\u0645\\u0627\\u0644\\u0646\\u0627\",\"title\":\"Amlaek Development adopts a Platform-Based Investment Model that connects:\",\"title_ar\":\"\\u062a\\u0639\\u062a\\u0645\\u062f \\u062a\\u0645\\u0644\\u0643 \\u0639\\u0644\\u0649 \\u0646\\u0645\\u0648\\u0630\\u062c \\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a \\u0627\\u0644\\u0630\\u064a \\u064a\\u0631\\u0628\\u0637 \\u0628\\u064a\\u0646:\",\"subtitle\":\"Business model canvas, digital solutions, strategic planning and investor enablement.\",\"subtitle_ar\":\"\\u0646\\u0645\\u0648\\u0630\\u062c \\u0627\\u0644\\u0639\\u0645\\u0644 \\u0627\\u0644\\u062a\\u062c\\u0627\\u0631\\u064a\\u060c \\u0648\\u0627\\u0644\\u062d\\u0644\\u0648\\u0644 \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a\\u0629\\u060c \\u0648\\u0627\\u0644\\u062a\\u062e\\u0637\\u064a\\u0637 \\u0627\\u0644\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u060c \\u0648\\u062a\\u0645\\u0643\\u064a\\u0646 \\u0627\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646.\",\"description\":\"This model creates an integrated environment for business development and investment growth.\",\"description_ar\":\"\\u064a\\u0633\\u0627\\u0647\\u0645 \\u0647\\u0630\\u0627 \\u0627\\u0644\\u0646\\u0645\\u0648\\u0630\\u062c \\u0641\\u064a \\u062e\\u0644\\u0642 \\u0628\\u064a\\u0626\\u0629 \\u0645\\u062a\\u0643\\u0627\\u0645\\u0644\\u0629 \\u0644\\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644 \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631.\",\"image\":\"69e47d90d874b1776582032.jpg\"}', NULL, '2026-04-07 13:49:43', '2026-04-28 17:10:57'),
(249, 'our_business_model.element', '{\"icon\":\"fa-solid fa-business-time\",\"icon_ar\":\"fa-solid fa-business-time\",\"title\":\"Specialized economic incubators\",\"title_ar\":\"\\u0627\\u0644\\u062d\\u0627\\u0636\\u0646\\u0627\\u062a \\u0627\\u0644\\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629 \\u0627\\u0644\\u0645\\u062a\\u062e\\u0635\\u0635\\u0629\"}', NULL, '2026-04-07 13:50:30', '2026-04-28 17:00:55'),
(250, 'our_business_model.element', '{\"icon\":\"fa-solid fa-laptop-code\",\"icon_ar\":\"fa-solid fa-laptop-code\",\"title\":\"Digital platforms for projects management\",\"title_ar\":\"\\u0627\\u0644\\u0645\\u0646\\u0635\\u0627\\u062a \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a\\u0629 \\u0644\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639\"}', NULL, '2026-04-07 13:57:57', '2026-04-28 17:02:22'),
(251, 'our_business_model.element', '{\"icon\":\"fa-solid fa-network-wired\",\"icon_ar\":\"fa-solid fa-network-wired\",\"title\":\"A network of strategic partners\",\"title_ar\":\"\\u0634\\u0628\\u0643\\u0629 \\u0634\\u0631\\u0643\\u0627\\u0621 \\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u064a\\u0646\"}', NULL, '2026-04-07 13:58:36', '2026-04-28 17:03:05'),
(252, 'our_business_model.element', '{\"icon\":\"fa-solid fa-database\",\"icon_ar\":\"fa-solid fa-database\",\"title\":\"A unified data and communication ecosystem\",\"title_ar\":\"\\u0645\\u0646\\u0638\\u0648\\u0645\\u0629 \\u0628\\u064a\\u0627\\u0646\\u0627\\u062a \\u0648\\u0627\\u062a\\u0635\\u0627\\u0644 \\u0645\\u0648\\u062d\\u062f\\u0629\"}', NULL, '2026-04-07 14:00:28', '2026-04-28 17:04:30'),
(253, 'our_business_model.element', '{\"icon\":\"fa-solid fa-users\",\"icon_ar\":\"fa-solid fa-users\",\"title\":\"Project and initiative management teams\",\"title_ar\":\"\\u0641\\u0631\\u0642 \\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0648\\u0627\\u0644\\u0645\\u0628\\u0627\\u062f\\u0631\\u0627\\u062a\"}', NULL, '2026-04-07 14:01:10', '2026-04-28 17:05:03'),
(254, 'business_network.content', '{\"title\":\"At Amlaek, we believe that strategic partnerships are the foundation of economic growth. Therefore, we collaborate with a wide network of:\",\"title_ar\":\"\\u0641\\u064a \\u0634\\u0631\\u0643\\u0629 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643\\u060c \\u0646\\u0624\\u0645\\u0646 \\u0628\\u0623\\u0646 \\u0627\\u0644\\u0634\\u0631\\u0627\\u0643\\u0627\\u062a \\u0627\\u0644\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629 \\u0647\\u064a \\u0623\\u0633\\u0627\\u0633 \\u0627\\u0644\\u0646\\u0645\\u0648 \\u0627\\u0644\\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a. \\u0644\\u0630\\u0644\\u0643\\u060c \\u0646\\u062a\\u0639\\u0627\\u0648\\u0646 \\u0645\\u0639 \\u0634\\u0628\\u0643\\u0629 \\u0648\\u0627\\u0633\\u0639\\u0629 \\u0645\\u0646:\"}', NULL, '2026-04-07 14:12:36', '2026-04-28 12:15:38'),
(255, 'business_network.element', '{\"title\":\"Investors\",\"title_ar\":\"\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646\",\"has_image\":\"1\",\"image\":\"69e27a305a3c21776450096.png\"}', NULL, '2026-04-07 14:13:13', '2026-04-28 17:34:13'),
(256, 'business_network.element', '{\"title\":\"Companies\",\"title_ar\":\"\\u0627\\u0644\\u0634\\u0631\\u0643\\u0627\\u062a\",\"has_image\":\"1\",\"image\":\"69e27bb8173a81776450488.png\"}', NULL, '2026-04-07 14:13:39', '2026-04-28 17:34:27'),
(257, 'business_network.element', '{\"title\":\"Government Entities\",\"title_ar\":\"\\u0627\\u0644\\u062c\\u0647\\u0627\\u062a \\u0627\\u0644\\u062d\\u0643\\u0648\\u0645\\u064a\\u0629\",\"has_image\":\"1\",\"image\":\"69e27ba2cf6681776450466.png\"}', NULL, '2026-04-07 14:14:12', '2026-04-17 22:27:46'),
(258, 'business_network.element', '{\"title\":\"Government Entities  Incubators & Accelerators\",\"title_ar\":\"\\u0627\\u0644\\u062d\\u0627\\u0636\\u0646\\u0627\\u062a \\u0648\\u0627\\u0644\\u0645\\u0633\\u0631\\u0639\\u0627\\u062a\",\"has_image\":\"1\",\"image\":\"69e27b06ea6701776450310.png\"}', NULL, '2026-04-07 14:15:36', '2026-04-28 17:35:24'),
(259, 'business_network.element', '{\"title\":\"Academic & Research Institutions\",\"title_ar\":\"\\u0627\\u0644\\u0645\\u0624\\u0633\\u0633\\u0627\\u062a \\u0627\\u0644\\u0623\\u0643\\u0627\\u062f\\u064a\\u0645\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0628\\u062d\\u062b\\u064a\\u0629\",\"has_image\":\"1\",\"image\":\"69e27a94d3f4e1776450196.png\"}', NULL, '2026-04-07 14:15:59', '2026-04-17 22:23:16'),
(260, 'start_your_journey.content', '{\"has_image\":\"1\",\"title\":\"Choose how you want to work with us Whether you are:\",\"title_ar\":\"\\u0627\\u062e\\u062a\\u0631 \\u0627\\u0644\\u0637\\u0631\\u064a\\u0642\\u0629 \\u0627\\u0644\\u062a\\u064a \\u062a\\u0631\\u063a\\u0628 \\u0641\\u064a \\u0627\\u0644\\u0639\\u0645\\u0644 \\u0628\\u0647\\u0627 \\u0645\\u0639\\u0646\\u0627 \\u0633\\u0648\\u0627\\u0621 \\u0643\\u0646\\u062a:\",\"subtitle\":\"Amlaek provides the integrated environment needed to achieve growth and investment success..\",\"subtitle_ar\":\"\\u0641\\u0625\\u0646 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643 \\u062a\\u0648\\u0641\\u0631 \\u0644\\u0643 \\u0627\\u0644\\u0628\\u064a\\u0626\\u0629 \\u0627\\u0644\\u0645\\u062a\\u0643\\u0627\\u0645\\u0644\\u0629 \\u0644\\u062a\\u062d\\u0642\\u064a\\u0642 \\u0627\\u0644\\u0646\\u0645\\u0648 \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631.\",\"book_button\":\"Explore Opportunities\",\"book_button_ar\":\"\\u0627\\u0633\\u062a\\u0643\\u0634\\u0641 \\u0627\\u0644\\u0641\\u0631\\u0635\",\"book_button_link\":\"#\",\"join_partner_button\":\"Join our partners\",\"join_partner_button_ar\":\"\\u0627\\u0646\\u0636\\u0645 \\u0625\\u0644\\u0649 \\u0634\\u0631\\u0643\\u0627\\u0626\\u0646\\u0627\",\"join_partner_button_link\":\"#\",\"image\":\"69f77189339fc1777824137.png\",\"image2\":\"69f7724158e251777824321.png\"}', NULL, '2026-04-07 15:25:29', '2026-05-03 20:05:21'),
(261, 'start_your_journey.element', '{\"title\":\"An investor\",\"title_ar\":\"\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u0627\\u064b\"}', NULL, '2026-04-07 15:26:55', '2026-04-28 17:53:55'),
(262, 'start_your_journey.element', '{\"title\":\"An entrepreneur\",\"title_ar\":\"\\u0631\\u0627\\u0626\\u062f \\u0623\\u0639\\u0645\\u0627\\u0644\"}', NULL, '2026-04-07 15:29:37', '2026-04-28 17:54:11'),
(263, 'start_your_journey.element', '{\"title\":\"A company seeking expansion\",\"title_ar\":\"\\u0634\\u0631\\u0643\\u0629 \\u062a\\u0628\\u062d\\u062b \\u0639\\u0646 \\u0627\\u0644\\u062a\\u0648\\u0633\\u0639\"}', NULL, '2026-04-07 15:29:51', '2026-04-28 17:54:27'),
(264, 'start_your_journey.element', '{\"title\":\"An organization looking for a strategic partner\",\"title_ar\":\"\\u062c\\u0647\\u0629 \\u062a\\u0628\\u062d\\u062b \\u0639\\u0646 \\u0634\\u0631\\u064a\\u0643 \\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\"}', NULL, '2026-04-07 15:30:07', '2026-04-28 17:55:04'),
(266, 'why_Amlaek.content', '{\"title\":\"Why Amlaek\",\"title_ar\":\"\\u0644\\u0645\\u0627\\u0630\\u0627 \\u062a\\u0645\\u0644\\u0643\"}', NULL, '2026-04-12 10:44:54', '2026-04-12 10:44:54'),
(267, 'why_Amlaek.element', '{\"title\":\"A multi-sector business platform\",\"title_ar\":\"\\u0645\\u0646\\u0635\\u0629 \\u0623\\u0639\\u0645\\u0627\\u0644 \\u0645\\u062a\\u0639\\u062f\\u062f\\u0629 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a\",\"has_image\":\"1\",\"image\":\"69e27697599ec1776449175.png\"}', NULL, '2026-04-12 10:45:56', '2026-04-17 22:06:15'),
(268, 'why_Amlaek.element', '{\"title\":\"Extensive experience in project  development and investment\",\"title_ar\":\"\\u062e\\u0628\\u0631\\u0629 \\u0648\\u0627\\u0633\\u0639\\u0629 \\u0641\\u064a \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\",\"has_image\":\"1\",\"image\":\"69e276a1324551776449185.png\"}', NULL, '2026-04-12 10:46:18', '2026-04-17 22:06:25'),
(269, 'why_Amlaek.element', '{\"title\":\"Integrated economic incubator ecosystem\",\"title_ar\":\"\\u0646\\u0638\\u0627\\u0645 \\u0628\\u064a\\u0626\\u064a \\u0645\\u062a\\u0643\\u0627\\u0645\\u0644 \\u0644\\u062d\\u0627\\u0636\\u0646\\u0627\\u062a \\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644 \\u0627\\u0644\\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629\",\"has_image\":\"1\",\"image\":\"69e276ad85fd51776449197.png\"}', NULL, '2026-04-12 10:46:37', '2026-04-17 22:06:37'),
(270, 'why_Amlaek.element', '{\"title\":\"Local and international partnerships\",\"title_ar\":\"\\u0627\\u0644\\u0634\\u0631\\u0627\\u0643\\u0627\\u062a \\u0627\\u0644\\u0645\\u062d\\u0644\\u064a\\u0629 \\u0648\\u0627\\u0644\\u062f\\u0648\\u0644\\u064a\\u0629\",\"has_image\":\"1\",\"image\":\"69e276b65f8601776449206.png\"}', NULL, '2026-04-12 10:46:59', '2026-04-17 22:06:46'),
(271, 'why_Amlaek.element', '{\"title\":\"A scalable global operational model\",\"title_ar\":\"\\u0646\\u0645\\u0648\\u0630\\u062c \\u062a\\u0634\\u063a\\u064a\\u0644\\u064a \\u0639\\u0627\\u0644\\u0645\\u064a \\u0642\\u0627\\u0628\\u0644 \\u0644\\u0644\\u062a\\u0637\\u0648\\u064a\\u0631\",\"has_image\":\"1\",\"image\":\"69e276c138b831776449217.png\"}', NULL, '2026-04-12 10:47:22', '2026-04-17 22:06:57'),
(272, 'network_economic.content', '{\"title\":\"A Network of Economic Ventures\",\"title_ar\":\"\\u0634\\u0628\\u0643\\u0629 \\u0645\\u0646 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629\",\"description_top\":\"Amlaek manages a network of specialized economic initiatives designed to support the development of projects and sectors, including:\",\"description_top_ar\":\"\\u062a\\u062f\\u064a\\u0631 \\u0634\\u0631\\u0643\\u0629 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643 \\u0634\\u0628\\u0643\\u0629 \\u0645\\u0646 \\u0627\\u0644\\u0645\\u0628\\u0627\\u062f\\u0631\\u0627\\u062a \\u0627\\u0644\\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629 \\u0627\\u0644\\u0645\\u062a\\u062e\\u0635\\u0635\\u0629 \\u0627\\u0644\\u0645\\u0635\\u0645\\u0645\\u0629 \\u0644\\u062f\\u0639\\u0645 \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0648\\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a\\u060c \\u0628\\u0645\\u0627 \\u0641\\u064a \\u0630\\u0644\\u0643:\",\"description_bottom\":\"These initiatives empower entrepreneurs and companies, accelerate the growth of economic initiatives, and connect them with investment and strategic partnerships, contributing to the creation of an integrated economic ecosystem that supports innovation and sustainability.\",\"description_bottom_ar\":\"\\u062a\\u0639\\u0645\\u0644 \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0645\\u0628\\u0627\\u062f\\u0631\\u0627\\u062a \\u0639\\u0644\\u0649 \\u062a\\u0645\\u0643\\u064a\\u0646 \\u0631\\u0648\\u0627\\u062f \\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644 \\u0648\\u0627\\u0644\\u0634\\u0631\\u0643\\u0627\\u062a\\u060c \\u0648\\u062a\\u0633\\u0631\\u064a\\u0639 \\u0646\\u0645\\u0648 \\u0627\\u0644\\u0645\\u0628\\u0627\\u062f\\u0631\\u0627\\u062a \\u0627\\u0644\\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629\\u060c \\u0648\\u0631\\u0628\\u0637\\u0647\\u0627 \\u0628\\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631 \\u0648\\u0627\\u0644\\u0634\\u0631\\u0627\\u0643\\u0627\\u062a \\u0627\\u0644\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629\\u060c \\u0645\\u0645\\u0627 \\u064a\\u0633\\u0627\\u0647\\u0645 \\u0641\\u064a \\u0625\\u0646\\u0634\\u0627\\u0621 \\u0646\\u0638\\u0627\\u0645 \\u0628\\u064a\\u0626\\u064a \\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a \\u0645\\u062a\\u0643\\u0627\\u0645\\u0644 \\u064a\\u062f\\u0639\\u0645 \\u0627\\u0644\\u0627\\u0628\\u062a\\u0643\\u0627\\u0631 \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062f\\u0627\\u0645\\u0629.\"}', NULL, '2026-04-12 10:53:48', '2026-04-28 12:58:59'),
(275, 'about_us.content', '{\"title\":\"About Amlaek\",\"title_ar\":\"\\u062d\\u0648\\u0644 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643\",\"description\":\"<div>Amlaek is the operational and investment platform of Amlaek Development Group, a diversified business group focused on\\u00a0<\\/div><div>developing projects and investments through an integrated economic model that combines innovation, digital transformation, and\\u00a0<\\/div><div>sustainability.<br \\/><br \\/>The group manages a business ecosystem that includes more than 200 commercial and investment activities across diverse economic sectors, including technology, industry, agriculture, real estate, healthcare, trade, and logistics services, in addition to several high-growth economic sectors.<br \\/><br \\/><div>The digital platform has been designed to serve as a unified hub for managing businesses and investments, providing a centralized database, a unified communication system, and advanced digital platforms to support project management and strategic partnerships. This contributes to accelerating business growth and enhancing investment opportunities locally and internationally.<\\/div><\\/div><div><br \\/><\\/div><div><br \\/><br \\/><\\/div>\",\"description_ar\":\"\\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0623\\u0639\\u0645\\u0627\\u0644 \\u0645\\u062a\\u0639\\u062f\\u062f\\u0629 \\u0627\\u0644\\u0623\\u0646\\u0634\\u0637\\u0629 \\u062a\\u0639\\u0645\\u0644 \\u0639\\u0644\\u0649 \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u0627\\u062a \\u0639\\u0628\\u0631 \\u0646\\u0645\\u0648\\u0630\\u062c \\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a \\u0645\\u062a\\u0643\\u0627\\u0645\\u0644 \\u064a\\u062c\\u0645\\u0639 \\u0628\\u064a\\u0646 \\u0627\\u0644\\u0627\\u0628\\u062a\\u0643\\u0627\\u0631\\u060c \\u0627\\u0644\\u062a\\u062d\\u0648\\u0644 \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a\\u060c \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062f\\u0627\\u0645\\u0629. \\u062a\\u062f\\u064a\\u0631 \\u0627\\u0644\\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u0646\\u0638\\u0648\\u0645\\u0629 \\u0623\\u0639\\u0645\\u0627\\u0644 \\u062a\\u0636\\u0645 \\u0623\\u0643\\u062b\\u0631 \\u0645\\u0646 200 \\u0646\\u0634\\u0627\\u0637 \\u062a\\u062c\\u0627\\u0631\\u064a \\u0648\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a \\u0641\\u064a \\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629 \\u0645\\u062a\\u0646\\u0648\\u0639\\u0629\\u060c \\u062a\\u0634\\u0645\\u0644 \\u0627\\u0644\\u062a\\u0643\\u0646\\u0648\\u0644\\u0648\\u062c\\u064a\\u0627\\u060c \\u0627\\u0644\\u0635\\u0646\\u0627\\u0639\\u0629\\u060c \\u0627\\u0644\\u0632\\u0631\\u0627\\u0639\\u0629\\u060c \\u0627\\u0644\\u0639\\u0642\\u0627\\u0631\\u060c \\u0627\\u0644\\u0635\\u062d\\u0629\\u060c \\u0627\\u0644\\u062a\\u062c\\u0627\\u0631\\u0629 \\u0648\\u0627\\u0644\\u062e\\u062f\\u0645\\u0627\\u062a \\u0627\\u0644\\u0644\\u0648\\u062c\\u0633\\u062a\\u064a\\u0629\\u060c \\u0625\\u0644\\u0649 \\u062c\\u0627\\u0646\\u0628 \\u0639\\u062f\\u062f \\u0645\\u0646 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u0627\\u0644\\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629 \\u0630\\u0627\\u062a \\u0627\\u0644\\u0646\\u0645\\u0648 \\u0627\\u0644\\u0645\\u0631\\u062a\\u0641\\u0639. \\u062a\\u0645 \\u062a\\u0635\\u0645\\u064a\\u0645 \\u0627\\u0644\\u0645\\u0646\\u0635\\u0629 \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a\\u0629 \\u0644\\u062a\\u0643\\u0648\\u0646 \\u0645\\u0631\\u0643\\u0632\\u0627\\u064b \\u0645\\u0648\\u062d\\u062f\\u0627\\u064b \\u0644\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644 \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u0627\\u062a\\u060c \\u062d\\u064a\\u062b \\u062a\\u0648\\u0641\\u0631 \\u0642\\u0627\\u0639\\u062f\\u0629 \\u0628\\u064a\\u0627\\u0646\\u0627\\u062a \\u0645\\u0631\\u0643\\u0632\\u064a\\u0629\\u060c \\u0648\\u0645\\u0646\\u0638\\u0648\\u0645\\u0629 \\u0627\\u062a\\u0635\\u0627\\u0644 \\u0645\\u0648\\u062d\\u062f\\u0629\\u060c \\u0648\\u0645\\u0646\\u0635\\u0627\\u062a \\u0631\\u0642\\u0645\\u064a\\u0629 \\u0645\\u062a\\u0642\\u062f\\u0645\\u0629 \\u0644\\u062f\\u0639\\u0645 \\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0648\\u0627\\u0644\\u0634\\u0631\\u0627\\u0643\\u0627\\u062a \\u0627\\u0644\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629\\u060c \\u0645\\u0645\\u0627 \\u064a\\u0633\\u0627\\u0647\\u0645 \\u0641\\u064a \\u062a\\u0633\\u0631\\u064a\\u0639 \\u0646\\u0645\\u0648 \\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644 \\u0648\\u062a\\u0639\\u0632\\u064a\\u0632 \\u0641\\u0631\\u0635 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631 \\u0645\\u062d\\u0644\\u064a\\u0627\\u064b \\u0648\\u062f\\u0648\\u0644\\u064a\\u0627\\u064b.\"}', NULL, '2026-04-12 11:23:08', '2026-05-13 19:10:43'),
(276, 'about_us.element', '{\"title\":\"Innovation\",\"title_ar\":\"\\u0627\\u0628\\u062a\\u0643\\u0627\\u0631\",\"description\":\"Developing new ideas and solutions that \\r\\ncontribute to building advanced and scalable \\r\\nbusiness models\",\"description_ar\":\"\\u062a\\u0637\\u0648\\u064a\\u0631 \\u0623\\u0641\\u0643\\u0627\\u0631 \\u0648\\u062d\\u0644\\u0648\\u0644 \\u062c\\u062f\\u064a\\u062f\\u0629 \\u062a\\u0633\\u0627\\u0647\\u0645 \\u0641\\u064a \\u0628\\u0646\\u0627\\u0621 \\u0646\\u0645\\u0627\\u0630\\u062c \\u0623\\u0639\\u0645\\u0627\\u0644 \\u0645\\u062a\\u0637\\u0648\\u0631\\u0629 \\u0648\\u0642\\u0627\\u0628\\u0644\\u0629 \\u0644\\u0644\\u062a\\u0648\\u0633\\u0639.\"}', NULL, '2026-04-12 11:50:57', '2026-04-13 07:29:41'),
(277, 'about_us.element', '{\"title\":\"Partnership\",\"title_ar\":\"\\u0634\\u0631\\u0627\\u0643\\u0629\",\"description\":\"Building long-term strategic relationships with investors, companies, and institutions.\",\"description_ar\":\"\\u0628\\u0646\\u0627\\u0621 \\u0639\\u0644\\u0627\\u0642\\u0627\\u062a \\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629 \\u0637\\u0648\\u064a\\u0644\\u0629 \\u0627\\u0644\\u0623\\u0645\\u062f \\u0645\\u0639 \\u0627\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646 \\u0648\\u0627\\u0644\\u0634\\u0631\\u0643\\u0627\\u062a \\u0648\\u0627\\u0644\\u0645\\u0624\\u0633\\u0633\\u0627\\u062a.\"}', NULL, '2026-04-12 11:52:09', '2026-04-13 07:32:53'),
(278, 'about_us.element', '{\"title\":\"Sustainability\",\"title_ar\":\"\\u0627\\u0644\\u0627\\u0633\\u062a\\u062f\\u0627\\u0645\\u0629\",\"description\":\"Promoting projects that balance economic growth with environmental and social responsibility.\",\"description_ar\":\"\\u062a\\u0639\\u0632\\u064a\\u0632 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u062a\\u064a \\u062a\\u062d\\u0642\\u0642 \\u062a\\u0648\\u0627\\u0632\\u0646\\u0627\\u064b \\u0628\\u064a\\u0646 \\u0627\\u0644\\u0646\\u0645\\u0648 \\u0627\\u0644\\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a \\u0648\\u0627\\u0644\\u0645\\u0633\\u0624\\u0648\\u0644\\u064a\\u0629 \\u0627\\u0644\\u0628\\u064a\\u0626\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0627\\u062c\\u062a\\u0645\\u0627\\u0639\\u064a\\u0629.\"}', NULL, '2026-04-12 11:52:37', '2026-04-13 07:33:48'),
(279, 'about_us.element', '{\"title\":\"Transparency\",\"title_ar\":\"\\u0627\\u0644\\u0634\\u0641\\u0627\\u0641\\u064a\\u0629\",\"description\":\"Commitment to clear governance and professional practices in managing businesses and investments.\",\"description_ar\":\"\\u0627\\u0644\\u0627\\u0644\\u062a\\u0632\\u0627\\u0645 \\u0628\\u0627\\u0644\\u062d\\u0648\\u0643\\u0645\\u0629 \\u0627\\u0644\\u0648\\u0627\\u0636\\u062d\\u0629 \\u0648\\u0627\\u0644\\u0645\\u0645\\u0627\\u0631\\u0633\\u0627\\u062a \\u0627\\u0644\\u0645\\u0647\\u0646\\u064a\\u0629 \\u0641\\u064a \\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644 \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u0627\\u062a\"}', NULL, '2026-04-12 11:53:51', '2026-04-13 07:34:49'),
(280, 'our_values.content', '{\"has_image\":\"1\",\"title\":\"Our Values\",\"title_ar\":\"\\u0642\\u064a\\u0645\\u0646\\u0627\",\"description\":\"<span><\\/span>At Amlaek Platform, we believe that successful\\nbusinesses rely on a clear set of values that\\nguide our decisions and partnerships,\\nincluding:\\u00a0\",\"description_ar\":\"\\u0646\\u0624\\u0645\\u0646 \\u0641\\u064a \\u0645\\u0646\\u0635\\u0629 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643\\u00a0\\u0628\\u0623\\u0646 \\u0646\\u062c\\u0627\\u062d \\u0627\\u0644\\u0627\\u0639\\u0645\\u0627\\u0644 \\u064a\\u0639\\u062a\\u0645\\u062f \\u0639\\u0644\\u0649 \\u0645\\u0646\\u0638\\u0648\\u0645\\u0629\\n\\u0642\\u064a\\u0645 \\u0648\\u0627\\u0636\\u062d\\u0629 \\u062a\\u0648\\u062c\\u0647 \\u0642\\u0631\\u0627\\u0631\\u0627\\u062a\\u0646\\u0627 \\u0648\\u0634\\u0631\\u0627\\u0643\\u0627\\u062a\\u0646\\u0627\\u060c \\u0648\\u062a\\u0634\\u0645\\u0644\",\"image\":\"69fb656bf1c811778083179.png\"}', NULL, '2026-04-12 11:54:34', '2026-05-06 19:59:40'),
(281, 'our_vision.content', '{\"has_image\":\"1\",\"title\":\"Our Vision\",\"title_ar\":\"\\u0631\\u0624\\u064a\\u062a\\u0646\\u0627\",\"description\":\"<span><\\/span>To become a global multi-sector investment\\nplatform that leads innovation and redefines\\nbusiness ecosystems in emerging and global\\nmarkets by developing high-quality projects\\nand strategic partnerships that create\\nsustainable value for investors, partners, and\\nsociety.\\u00a0\",\"description_ar\":\"\\u0627\\u0646 \\u0646\\u0643\\u0648\\u0646 \\u0645\\u0646\\u0635\\u0629 \\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631 \\u0639\\u0627\\u0644\\u0645\\u064a\\u0629 \\u0645\\u062a\\u0639\\u062f\\u062f\\u0629 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u062a\\u0642\\u0648\\u062f\\n\\u0627\\u0644\\u0627\\u0628\\u062a\\u0643\\u0627\\u0631 \\u0648\\u062a\\u0639\\u064a\\u062f \\u062a\\u0639\\u0631\\u064a\\u0641 \\u0645\\u0646\\u0638\\u0648\\u0645\\u0627\\u062a \\u0627\\u0644\\u0627\\u0639\\u0645\\u0627\\u0644 \\u0641\\u064a \\u0627\\u0644\\u0627\\u0633\\u0648\\u0627\\u0642\\n\\u0627\\u0644\\u0646\\u0627\\u0634\\u0626\\u0629 \\u0648\\u0627\\u0644\\u0639\\u0627\\u0644\\u0645\\u064a\\u0629\\u060c \\u0645\\u0646 \\u062e\\u0644\\u0627\\u0644 \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0646\\u0648\\u0639\\u064a\\u0629 \\u0648\\u0634\\u0631\\u0627\\u0643\\u0627\\u062a\\n\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629 \\u062a\\u062d\\u0642\\u0642 \\u0642\\u064a\\u0645\\u0629 \\u0645\\u0633\\u062a\\u062f\\u0627\\u0645\\u0629 \\u0644\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646 \\u0648\\u0627\\u0644\\u0634\\u0631\\u0643\\u0627\\u0621\\n\\u0648\\u0627\\u0644\\u0645\\u062c\\u062a\\u0645\\u0639\",\"image\":\"69fb65985541a1778083224.png\"}', NULL, '2026-04-12 11:55:49', '2026-05-06 20:00:24'),
(282, 'our_mission.content', '{\"has_image\":\"1\",\"title\":\"Our Mission\",\"title_ar\":\"\\u0631\\u0633\\u0627\\u0644\\u062a\\u0646\\u0627\",\"description\":\"To empower investments and projects through\\nintegrated solutions, innovative digital\\nplatforms, and strategic partnerships, with the\\naim of building a modern economic\\necosystem that supports sustainable growth\\nand enhances innovation and expansion\\nacross various economic sectors.\",\"description_ar\":\"\\u062a\\u0645\\u0643\\u064a\\u0646 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u0627\\u062a \\u0648\\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0639\\u0628\\u0631 \\u062d\\u0644\\u0648\\u0644 \\u0645\\u062a\\u0643\\u0627\\u0645\\u0644\\u0629 \\u0648\\u0645\\u0646\\u0635\\u0627\\u062a\\n\\u0631\\u0642\\u0645\\u064a\\u0629 \\u0645\\u0628\\u062a\\u0643\\u0631\\u0629 \\u0648\\u0634\\u0631\\u0627\\u0643\\u0627\\u062a \\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629\\u060c \\u0628\\u0647\\u062f\\u0641 \\u0628\\u0646\\u0627\\u0621 \\u0645\\u0646\\u0638\\u0648\\u0645\\u0629\\n\\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629 \\u062d\\u062f\\u064a\\u062b\\u0629 \\u062a\\u062f\\u0639\\u0645 \\u0627\\u0644\\u0646\\u0645\\u0648 \\u0627\\u0644\\u0645\\u0633\\u062a\\u062f\\u0627\\u0645 \\u0648\\u062a\\u0639\\u0632\\u0632 \\u0627\\u0644\\u0627\\u0628\\u062a\\u0643\\u0627\\u0631 \\u0648\\u0627\\u0644\\u062a\\u0648\\u0633\\u0639\\n\\u0641\\u064a \\u0645\\u062e\\u062a\\u0644\\u0641 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u0627\\u0644\\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629\",\"image\":\"69fb65825999f1778083202.png\"}', NULL, '2026-04-13 07:26:51', '2026-05-06 20:00:02'),
(283, 'about_us.element', '{\"title\":\"Excellence\",\"title_ar\":\"\\u0627\\u0644\\u062a\\u0645\\u064a\\u0632\",\"description\":\"Continuously striving to deliver high-quality services and achieve the best results for our partners and clients.\",\"description_ar\":\"\\u0627\\u0644\\u0633\\u0639\\u064a \\u0627\\u0644\\u062f\\u0627\\u0626\\u0645 \\u0644\\u062a\\u0642\\u062f\\u064a\\u0645 \\u062e\\u062f\\u0645\\u0627\\u062a \\u0639\\u0627\\u0644\\u064a\\u0629 \\u0627\\u0644\\u062c\\u0648\\u062f\\u0629 \\u0648\\u062a\\u062d\\u0642\\u064a\\u0642 \\u0623\\u0641\\u0636\\u0644 \\u0627\\u0644\\u0646\\u062a\\u0627\\u0626\\u062c \\u0644\\u0634\\u0631\\u0643\\u0627\\u0626\\u0646\\u0627 \\u0648\\u0639\\u0645\\u0644\\u0627\\u0626\\u0646\\u0627.\"}', NULL, '2026-04-13 07:35:27', '2026-04-13 07:35:27'),
(284, 'business_sectors.content', '{\"title\":\"Business Sectors at Amlaek\",\"title_ar\":\"\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644 \\u0641\\u064a \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643\",\"description\":\"<div>The Amlaek Platform \\u2013 Amlaek Development Group operates through an integrated economic ecosystem that includes a wide range of strategic sectors covering various fields of investment and business.<\\/div><div><br \\/><\\/div><div>These sectors are designed to operate in an interconnected model based on economic projects, digital platforms, and strategic partnerships. This structure contributes to project development, attracting investments,\\u00a0<\\/div><div>and promoting sustainable growth.<\\/div>\",\"description_ar\":\"<div>\\u062a\\u0639\\u0645\\u0644 \\u0645\\u0646\\u0635\\u0629 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643 - \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0623\\u0645\\u0644\\u0627\\u0643 \\u0644\\u0644\\u062a\\u0646\\u0645\\u064a\\u0629 \\u0645\\u0646 \\u062e\\u0644\\u0627\\u0644 \\u0645\\u0646\\u0638\\u0648\\u0645\\u0629 \\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629 \\u0645\\u062a\\u0643\\u0627\\u0645\\u0644\\u0629 \\u062a\\u0634\\u0645\\u0644 \\u0637\\u064a\\u0641\\u064b\\u0627 \\u0648\\u0627\\u0633\\u0639\\u064b\\u0627 \\u0645\\u0646 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u0627\\u0644\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629 \\u0627\\u0644\\u062a\\u064a \\u062a\\u063a\\u0637\\u064a \\u0645\\u062c\\u0627\\u0644\\u0627\\u062a \\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\\u0629 \\u0648\\u062a\\u062c\\u0627\\u0631\\u064a\\u0629 \\u0645\\u062a\\u0646\\u0648\\u0639\\u0629.<\\/div><div><br \\/><\\/div><div>\\u0635\\u064f\\u0645\\u0645\\u062a \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u0644\\u0644\\u0639\\u0645\\u0644 \\u0648\\u0641\\u0642 \\u0646\\u0645\\u0648\\u0630\\u062c \\u0645\\u062a\\u0631\\u0627\\u0628\\u0637 \\u0642\\u0627\\u0626\\u0645 \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0645\\u0646\\u0635\\u0627\\u062a \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0634\\u0631\\u0627\\u0643\\u0627\\u062a \\u0627\\u0644\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629. \\u064a\\u064f\\u0633\\u0647\\u0645 \\u0647\\u0630\\u0627 \\u0627\\u0644\\u0647\\u064a\\u0643\\u0644 \\u0641\\u064a \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639\\u060c \\u0648\\u062c\\u0630\\u0628 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u0627\\u062a\\u060c \\u0648\\u062a\\u0639\\u0632\\u064a\\u0632 \\u0627\\u0644\\u0646\\u0645\\u0648 \\u0627\\u0644\\u0645\\u0633\\u062a\\u062f\\u0627\\u0645.<\\/div>\",\"has_image\":\"1\",\"image\":\"69e1c96890fff1776404840.jpg\"}', NULL, '2026-04-13 07:40:45', '2026-04-28 12:16:43'),
(285, 'engineering_solutions.content', '{\"description\":\"The Engineering Solutions and\\nInfrastructure Sector is one of the strategic\\nsectors within the Amlaek business\\necosystem, focusing on the development and\\nimplementation of engineering and technical\\nprojects that support urban, industrial, and\\neconomic growth.<div><br \\/><\\/div><div>Through this sector, Amlaek provides\\nintegrated solutions covering planning,\\ndesign, execution, and project\\nmanagement, while leveraging the latest\\nengineering technologies and digital\\ntransformation systems in project\\nmanagement and operations.<\\/div><div><br \\/><\\/div><div>We aim to support companies, investors, and\\ngovernment entities in implementing\\ninfrastructure and vital facilities projects\\naccording to the highest standa<div>\\u00a0\\n<br \\/><br \\/><br \\/><br \\/><\\/div><\\/div>\",\"description_ar\":\"<div>.\\u062a\\u0639\\u0645\\u0644 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643 \\u0645\\u0646 \\u062e\\u0644\\u0627\\u0644 \\u0647\\u0630\\u0627 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639 \\u0639\\u0644\\u0649 \\u062a\\u0642\\u062f\\u064a\\u0645 \\u062d\\u0644\\u0648\\u0644 \\u0645\\u062a\\u0643\\u0627\\u0645\\u0644\\u0629 \\u062a\\u0634\\u0645\\u0644 \\u0627\\u0644\\u062a\\u062e\\u0637\\u064a\\u0637\\u060c \\u0627\\u0644\\u062a\\u0635\\u0645\\u064a\\u0645\\u060c \\u0627\\u0644\\u062a\\u0646\\u0641\\u064a\\u0630\\u060c \\u0648\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639\\u060c \\u0645\\u0639 \\u0627\\u0627\\u0644\\u0633\\u062a\\u0641\\u0627\\u062f\\u0629 \\u0645\\u0646 \\u0623\\u062d\\u062f\\u062b \\u0627\\u0644\\u062a\\u0642\\u0646\\u064a\\u0627\\u062a \\u0627\\u0644\\u0647\\u0646\\u062f\\u0633\\u064a\\u0629 \\u0648\\u0623\\u0646\\u0638\\u0645\\u0629 \\u0627\\u0644\\u062a\\u062d\\u0648\\u0644 \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a \\u0641\\u064a \\u0625\\u062f\\u0627\\u0631\\u0629 \\u0648\\u062a\\u0634\\u063a\\u064a\\u0644 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639.<\\/div><div><br \\/><\\/div><div>.<\\/div><div>\\u064a\\u064f\\u0639\\u062f \\u0642\\u0637\\u0627\\u0639 \\u0627\\u0644\\u062d\\u0644\\u0648\\u0644 \\u0627\\u0644\\u0647\\u0646\\u062f\\u0633\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0628\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629 \\u0623\\u062d\\u062f \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a\\n\\u0627\\u0644\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629 \\u0636\\u0645\\u0646 \\u0645\\u0646\\u0638\\u0648\\u0645\\u0629 \\u0623\\u0639\\u0645\\u0627\\u0644 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643\\u060c \\u062d\\u064a\\u062b \\u064a\\u0631\\u0643\\u0632 \\u0639\\u0644\\u0649\\n\\u062a\\u0637\\u0648\\u064a\\u0631 \\u0648\\u062a\\u0646\\u0641\\u064a\\u0630 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0647\\u0646\\u062f\\u0633\\u064a\\u0629 \\u0648\\u0627\\u0644\\u062a\\u0642\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u064a \\u062a\\u062f\\u0639\\u0645 \\u0627\\u0644\\u0646\\u0645\\u0648\\n\\u0627\\u0644\\u0639\\u0645\\u0631\\u0627\\u0646\\u064a \\u0648\\u0627\\u0644\\u0635\\u0646\\u0627\\u0639\\u064a \\u0648\\u0627\\u0627\\u0644\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a<\\/div><div>.<\\/div><div><br \\/><\\/div><div>\\u0646\\u0647\\u062f\\u0641 \\u0625\\u0644\\u0649 \\u062f\\u0639\\u0645 \\u0627\\u0644\\u0634\\u0631\\u0643\\u0627\\u062a \\u0648\\u0627\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646 \\u0648\\u0627\\u0644\\u062c\\u0647\\u0627\\u062a \\u0627\\u0644\\u062d\\u0643\\u0648\\u0645\\u064a\\u0629\\n\\u0641\\u064a \\u062a\\u0646\\u0641\\u064a\\u0630 \\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0628\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0645\\u0631\\u0627\\u0641\\u0642 \\u0627\\u0644\\u062d\\u064a\\u0648\\u064a\\u0629 \\u0648\\u0641\\u0642 \\u0623\\u0639\\u0644\\u0649\\n\\u0645\\u0639\\u0627\\u064a\\u064a\\u0631 \\u0627\\u0644\\u062c\\u0648\\u062f\\u0629 \\u0648\\u0627\\u0644\\u0643\\u0641\\u0627\\u0621\\u0629 \\u0648\\u0627\\u0627\\u0644\\u0633\\u062a\\u062f\\u0627\\u0645\\u0629<\\/div><div><br \\/><\\/div><div><br \\/><\\/div><div><br \\/><\\/div><div><br \\/><\\/div>\",\"become_button\":\"Become Supplier\",\"become_button_ar\":\"\\u0643\\u0646 \\u0645\\u0648\\u0631\\u062f\\u064b\\u0627\",\"become_link\":\"#\",\"has_image\":\"1\",\"image_1\":\"69e1ca5f8a92c1776405087.png\",\"image_2\":\"69e1cb63ef73e1776405347.png\"}', NULL, '2026-04-13 15:44:42', '2026-04-28 12:18:12'),
(286, 'sector_services.content', '{\"title\":\"Sector Services\",\"title_ar\":\"\\u062e\\u062f\\u0645\\u0627\\u062a \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\",\"subtitle\":\"The Engineering Solutions and Infrastructure Sector provides a range of integrated services, including:\",\"subtitle_ar\":\"\\u064a\\u0642\\u062f\\u0645 \\u0642\\u0637\\u0627\\u0639 \\u0627\\u0644\\u062d\\u0644\\u0648\\u0644 \\u0627\\u0644\\u0647\\u0646\\u062f\\u0633\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0628\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u0646 \\u0627\\u0644\\u062e\\u062f\\u0645\\u0627\\u062a \\u0627\\u0644\\u0645\\u062a\\u0643\\u0627\\u0645\\u0644\\u0629\\u060c \\u062a\\u0634\\u0645\\u0644\"}', NULL, '2026-04-13 18:15:00', '2026-04-13 18:15:00'),
(287, 'sector_services.element', '{\"title\":\"Engineering planning and design\",\"title_ar\":\"\\uf0b7 \\u0627\\u0644\\u062a\\u062e\\u0637\\u064a\\u0637 \\u0648\\u0627\\u0644\\u062a\\u0635\\u0645\\u064a\\u0645 \\u0627\\u0644\\u0647\\u0646\\u062f\\u0633\\u064a\",\"has_image\":\"1\",\"image\":\"69e28e30417a81776455216.png\"}', NULL, '2026-04-13 18:16:10', '2026-04-17 23:46:56'),
(288, 'sector_services.element', '{\"title\":\"Project management and execution\",\"title_ar\":\"\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0648\\u062a\\u0646\\u0641\\u064a\\u0630 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639\",\"has_image\":\"1\",\"image\":\"69e1d870925fe1776408688.png\"}', NULL, '2026-04-13 18:17:19', '2026-04-17 10:51:28'),
(289, 'sector_services.element', '{\"title\":\"Development of industrial facilities\",\"title_ar\":\"\\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u0645\\u0631\\u0627\\u0641\\u0642 \\u0627\\u0644\\u0635\\u0646\\u0627\\u0639\\u064a\\u0629\",\"has_image\":\"1\",\"image\":\"69e1d898235d71776408728.jpg\"}', NULL, '2026-04-13 18:17:44', '2026-04-17 10:52:08'),
(290, 'sector_services.element', '{\"title\":\"Technical and engineering consulting\",\"title_ar\":\"\\uf0b7 \\u0627\\u0627\\u0644\\u0633\\u062a\\u0634\\u0627\\u0631\\u0627\\u062a \\u0627\\u0644\\u0641\\u0646\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0647\\u0646\\u062f\\u0633\\u064a\\u0629\",\"has_image\":\"1\",\"image\":\"69e1d8bc0b19a1776408764.jpg\"}', NULL, '2026-04-13 18:19:01', '2026-04-17 10:52:44'),
(291, 'sector_services.element', '{\"title\":\"Digital transformation solutions for projects\",\"title_ar\":\"\\u062d\\u0644\\u0648\\u0644 \\u0627\\u0644\\u062a\\u062d\\u0648\\u0644 \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a \\u0644\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639\",\"has_image\":\"1\",\"image\":\"69e1d8d8762b51776408792.png\"}', NULL, '2026-04-13 18:19:29', '2026-04-17 10:53:12'),
(292, 'sector_services.element', '{\"title\":\"Infrastructure development for economic zones\",\"title_ar\":\"\\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u0628\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629 \\u0644\\u0644\\u0645\\u0646\\u0627\\u0637\\u0642 \\u0627\\u0627\\u0644\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629\",\"has_image\":\"1\",\"image\":\"69e1d9292ab591776408873.jpg\"}', NULL, '2026-04-13 18:21:41', '2026-04-17 10:54:33'),
(293, 'added_value.content', '{\"has_image\":\"1\",\"title\":\"Added Value\",\"title_ar\":\"\\u0627\\u0644\\u0642\\u064a\\u0645\\u0629 \\u0627\\u0644\\u0645\\u0636\\u0627\\u0641\\u0629\",\"subtitle\":\"Through this sector, Amlaek provides an integrated ecosystem combining engineering, technical, and investment expertise, which contributes to:\",\"subtitle_ar\":\"\\u062a\\u0639\\u0645\\u0644 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643 \\u0645\\u0646 \\u062e\\u0644\\u0627\\u0644 \\u0647\\u0630\\u0627 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639 \\u0639\\u0644\\u0649 \\u062a\\u0648\\u0641\\u064a\\u0631 \\u0645\\u0646\\u0638\\u0648\\u0645\\u0629 \\u0645\\u062a\\u0643\\u0627\\u0645\\u0644\\u0629 \\u062a\\u062c\\u0645\\u0639 \\u0628\\u064a\\u0646 \\u0627\\u0644\\u062e\\u0628\\u0631\\u0627\\u062a \\u0627\\u0644\\u0647\\u0646\\u062f\\u0633\\u064a\\u0629 \\u0648\\u0627\\u0644\\u062a\\u0642\\u0646\\u064a\\u0629 \\u0648\\u0627\\u0627\\u0644\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\\u0629\\u060c \\u0628\\u0645\\u0627 \\u064a\\u0633\\u0627\\u0647\\u0645 \\u0641\\u064a\",\"image\":\"69dd3559393531776104793.png\"}', NULL, '2026-04-13 18:26:33', '2026-04-28 12:12:11'),
(294, 'added_value.element', '{\"title\":\"Accelerating the execution of largescale projects\",\"title_ar\":\"\\u062a\\u0633\\u0631\\u064a\\u0639 \\u062a\\u0646\\u0641\\u064a\\u0630 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0643\\u0628\\u0631\\u0649\"}', NULL, '2026-04-13 18:27:06', '2026-04-13 18:27:06');
INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `tempname`, `created_at`, `updated_at`) VALUES
(295, 'added_value.element', '{\"title\":\"Improving infrastructure efficiency\",\"title_ar\":\"\\u0631\\u0641\\u0639 \\u0643\\u0641\\u0627\\u0621\\u0629 \\u0627\\u0644\\u0628\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629\"}', NULL, '2026-04-13 18:27:25', '2026-04-13 18:27:25'),
(296, 'added_value.element', '{\"title\":\"Supporting urban and industrial development\",\"title_ar\":\"\\u062f\\u0639\\u0645 \\u0627\\u0644\\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0639\\u0645\\u0631\\u0627\\u0646\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0635\\u0646\\u0627\\u0639\\u064a\\u0629\"}', NULL, '2026-04-13 18:27:42', '2026-04-13 18:27:42'),
(297, 'added_value.element', '{\"title\":\"Enabling investors to implement projects efficiently\",\"title_ar\":\"\\u062a\\u0645\\u0643\\u064a\\u0646 \\u0627\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646 \\u0645\\u0646 \\u062a\\u0646\\u0641\\u064a\\u0630 \\u0645\\u0634\\u0627\\u0631\\u064a\\u0639\\u0647\\u0645 \\u0628\\u0643\\u0641\\u0627\\u0621\\u0629 \\u0639\\u0627\\u0644\\u064a\\u0629\"}', NULL, '2026-04-13 18:28:04', '2026-04-13 18:28:04'),
(298, 'added_value.element', '{\"title\":\"Promoting sustainability and innovation in infrastructure projects\",\"title_ar\":\"\\u062a\\u0639\\u0632\\u064a\\u0632 \\u0627\\u0627\\u0644\\u0633\\u062a\\u062f\\u0627\\u0645\\u0629 \\u0648\\u0627\\u0627\\u0644\\u0628\\u062a\\u0643\\u0627\\u0631 \\u0641\\u064a \\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0628\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629\"}', NULL, '2026-04-13 18:28:27', '2026-04-13 18:28:27'),
(299, 'investment_bot.content', '{\"title\":\"Investment and BOT Model\",\"title_ar\":\"\\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631 \\u0648\\u0646\\u0645\\u0648\\u0630\\u062cBOT\",\"description\":\"Amlaek provides advanced investment\\nsolutions to support the development of\\neconomic projects through flexible\\npartnership models that bring together\\ninvestors, government entities, and the private\\nsector. One of the most important investment\\nmodels adopted by the platform is the BOT\\nmodel (Build \\u2013 Operate \\u2013 Transfer), which\\nis widely used for implementing large-scale\\nprojects and developing infrastructure and\\neconomic facilities.\\u00a0<div><br \\/><\\/div><div>This model allows investors to participate in\\nbuilding and operating projects for a\\nspecified period of time before transferring\\nownership to the owning entity, helping\\naccelerate the implementation of strategic\\nprojects without placing direct financing\\nburdens on governments or project owners.<br \\/><div><br \\/><br \\/><\\/div><\\/div>\",\"description_ar\":\"<br \\/>\\u062a\\u0642\\u062f\\u0645 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643\\u00a0\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\\u0629 \\u0645\\u062a\\u0642\\u062f\\u0645\\u0629 \\u0644\\u062f\\u0639\\u0645 \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639\\n\\u0627\\u0644\\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629 \\u0645\\u0646 \\u062e\\u0644\\u0627\\u0644 \\u0646\\u0645\\u0627\\u0630\\u062c \\u0634\\u0631\\u0627\\u0643\\u0629 \\u0645\\u0631\\u0646\\u0629 \\u062a\\u062c\\u0645\\u0639 \\u0628\\u064a\\u0646\\n\\u0627\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646 \\u0648\\u0627\\u0644\\u062c\\u0647\\u0627\\u062a \\u0627\\u0644\\u062d\\u0643\\u0648\\u0645\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0642\\u0637\\u0627\\u0639 \\u0627\\u0644\\u062e\\u0627\\u0635. \\u0648\\u064a\\u064f\\u0639\\u062f\\n \\u0623\\u062d\\u062f BOT (Build \\u2013 Operate \\u2013 Transfer) \\u0646\\u0645\\u0648\\u0630\\u062c\\n\\u0623\\u0647\\u0645 \\u0627\\u0644\\u0646\\u0645\\u0627\\u0630\\u062c \\u0627\\u0627\\u0644\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\\u0629 \\u0627\\u0644\\u062a\\u064a \\u062a\\u0639\\u062a\\u0645\\u062f\\u0647\\u0627 \\u0627\\u0644\\u0645\\u0646\\u0635\\u0629 \\u0644\\u062a\\u0646\\u0641\\u064a\\u0630 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639\\n\\u0627\\u0644\\u0643\\u0628\\u0631\\u0649 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u0628\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0645\\u0631\\u0627\\u0641\\u0642 \\u0627\\u0627\\u0644\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629<br \\/><br \\/><br \\/>\\u064a\\u062a\\u064a\\u062d \\u0647\\u0630\\u0627 \\u0627\\u0644\\u0646\\u0645\\u0648\\u0630\\u062c \\u0644\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u0643\\u0629 \\u0641\\u064a \\u0625\\u0646\\u0634\\u0627\\u0621 \\u0648\\u062a\\u0634\\u063a\\u064a\\u0644\\n\\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0644\\u0641\\u062a\\u0631\\u0629 \\u0632\\u0645\\u0646\\u064a\\u0629 \\u0645\\u062d\\u062f\\u062f\\u0629 \\u0642\\u0628\\u0644 \\u0646\\u0642\\u0644 \\u0645\\u0644\\u0643\\u064a\\u062a\\u0647\\u0627 \\u0625\\u0644\\u0649 \\u0627\\u0644\\u062c\\u0647\\u0629\\n\\u0627\\u0644\\u0645\\u0627\\u0644\\u0643\\u0629\\u060c \\u0645\\u0645\\u0627 \\u064a\\u0633\\u0627\\u0647\\u0645 \\u0641\\u064a \\u062a\\u0633\\u0631\\u064a\\u0639 \\u062a\\u0646\\u0641\\u064a\\u0630 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629\\u00a0\\u062f\\u0648\\u0646 \\u062a\\u062d\\u0645\\u064a\\u0644 \\u0627\\u0644\\u062d\\u0643\\u0648\\u0645\\u0627\\u062a \\u0623\\u0648 \\u0627\\u0644\\u062c\\u0647\\u0627\\u062a \\u0627\\u0644\\u0645\\u0627\\u0644\\u0643\\u0629 \\u062a\\u0643\\u0627\\u0644\\u064a\\u0641 \\u0627\\u0644\\u062a\\u0645\\u0648\\u064a\\u0644\\n\\u0627\\u0644\\u0645\\u0628\\u0627\\u0634\\u0631\\u0629<br \\/><div><br \\/><\\/div>\",\"has_image\":\"1\",\"image\":\"69e28bb5a9b771776454581.png\"}', NULL, '2026-04-13 19:27:37', '2026-04-28 12:57:22'),
(300, 'what_is_bot.content', '{\"title\":\"What is the BOT Model?\",\"title_ar\":\"\\u0645\\u0627 \\u0647\\u0648 \\u0646\\u0645\\u0648\\u0630\\u062cBOT \\u061f\",\"subtitle\":\"This model is based on the investor or developer undertaking the following stages:\",\"subtitle_ar\":\"\\u0648\\u064a\\u0639\\u062a\\u0645\\u062f \\u0647\\u0630\\u0627 \\u0627\\u0644\\u0646\\u0645\\u0648\\u0630\\u062c \\u0639\\u0644\\u0649 \\u0642\\u064a\\u0627\\u0645 \\u0627\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631 \\u0623\\u0648 \\u0627\\u0644\\u0645\\u0637\\u0648\\u0631 \\u0628\\u0640:\",\"has_image\":\"1\",\"image\":\"69e28d5ce83341776455004.png\"}', NULL, '2026-04-14 03:51:08', '2026-04-17 23:43:25'),
(301, 'what_is_bot.element', '{\"title\":\"Build\",\"title_ar\":\"\\u0628\\u0646\\u0627\\u0621 \\u0627\\u0644\\u0645\\u0634\\u0631\\u0648\\u0639\",\"subtitle\":\"Financing, designing, and constructing the project according to the agreed standards.\",\"subtitle_ar\":\"\\u062a\\u0645\\u0648\\u064a\\u0644 \\u0648\\u062a\\u0635\\u0645\\u064a\\u0645 \\u0648\\u0625\\u0646\\u0634\\u0627\\u0621 \\u0627\\u0644\\u0645\\u0634\\u0631\\u0648\\u0639 \\u0648\\u0641\\u0642 \\u0627\\u0644\\u0645\\u0639\\u0627\\u064a\\u064a\\u0631 \\u0627\\u0644\\u0645\\u062a\\u0641\\u0642 \\u0639\\u0644\\u064a\\u0647\\u0627\"}', NULL, '2026-04-14 03:52:05', '2026-04-14 03:52:05'),
(302, 'what_is_bot.element', '{\"title\":\"Operate\",\"title_ar\":\"\\u062a\\u0634\\u063a\\u064a\\u0644 \\u0627\\u0644\\u0645\\u0634\\u0631\\u0648\\u0639\",\"subtitle\":\"Managing and operating the project for a specified period to recover costs and generate investment returns.\",\"subtitle_ar\":\"\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0648\\u062a\\u0634\\u063a\\u064a\\u0644 \\u0627\\u0644\\u0645\\u0634\\u0631\\u0648\\u0639 \\u0644\\u0641\\u062a\\u0631\\u0629 \\u0645\\u062d\\u062f\\u062f\\u0629 \\u0627\\u0644\\u0633\\u062a\\u0631\\u062f\\u0627\\u062f \\u0627\\u0644\\u062a\\u0643\\u0644\\u0641\\u0629 \\u0648\\u062a\\u062d\\u0642\\u064a\\u0642 \\u0627\\u0644\\u0639\\u0627\\u0626\\u062f \\u0627\\u0627\\u0644\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\"}', NULL, '2026-04-14 04:00:05', '2026-04-14 04:01:44'),
(303, 'what_is_bot.element', '{\"title\":\"Transfer\",\"title_ar\":\"\\u0646\\u0642\\u0644 \\u0627\\u0644\\u0645\\u0634\\u0631\\u0648\\u0639\",\"subtitle\":\"Transferring the ownership of the project to the owning entity or government authority after the concession period ends\",\"subtitle_ar\":\"\\u0646\\u0642\\u0644 \\u0645\\u0644\\u0643\\u064a\\u0629 \\u0627\\u0644\\u0645\\u0634\\u0631\\u0648\\u0639 \\u0625\\u0644\\u0649 \\u0627\\u0644\\u062c\\u0647\\u0629 \\u0627\\u0644\\u0645\\u0627\\u0644\\u0643\\u0629 \\u0623\\u0648 \\u0627\\u0644\\u062d\\u0643\\u0648\\u0645\\u064a\\u0629 \\u0628\\u0639\\u062f \\u0627\\u0646\\u062a\\u0647\\u0627\\u0621 \\u0641\\u062a\\u0631\\u0629 \\u0627\\u0627\\u0644\\u0645\\u062a\\u064a\\u0627\\u0632\"}', NULL, '2026-04-14 04:02:30', '2026-04-14 04:02:30'),
(304, 'areas_of_bot.element', '{\"has_image\":[\"1\"],\"title\":\"Areas of BOT Implementation\",\"title_ar\":\"\\u0645\\u062c\\u0627\\u0627\\u0644\\u062a \\u062a\\u0637\\u0628\\u064a\\u0642 \\u0646\\u0645\\u0648\\u0630\\u062cBOT\",\"subtitle\":\"Amlaek supports the development and execution of BOT projects across multiple economic sectors, including:\",\"subtitle_ar\":\"\\u062a\\u062f\\u0639\\u0645 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0639\\u0645\\u0627\\u0644 \\u062a\\u0646\\u0641\\u064a\\u0630 \\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 BOT \\u0641\\u064a \\u0627\\u0644\\u0639\\u062f\\u064a\\u062f \\u0645\\u0646 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u0627\\u0627\\u0644\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629\\u060c \\u0648\\u0645\\u0646\\u0647\\u0627\",\"description\":\"\\uf0b7 Infrastructure projects <br \\/>\\uf0b7 Industrial and logistics zones\\u00a0<div>\\uf0b7Ports and airports <br \\/>\\uf0b7 Energy projects <br \\/>\\uf0b7 Water and wastewater projects <br \\/>\\uf0b7 Healthcare and educational facilities <br \\/>\\uf0b7 Tourism and entertainment projects <br \\/>\\uf0b7 Smart cities and digital infrastructure\\u00a0<\\/div>\",\"description_ar\":\"<div><br \\/><\\/div>\\uf0b7 \\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0628\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629\\u00a0<div>\\uf0b7 \\u0627\\u0644\\u0645\\u0646\\u0627\\u0637\\u0642 \\u0627\\u0644\\u0635\\u0646\\u0627\\u0639\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0644\\u0648\\u062c\\u0633\\u062a\\u064a\\u0629<br \\/>\\uf0b7 \\u0627\\u0644\\u0645\\u0648\\u0627\\u0646\\u0626 \\u0648\\u0627\\u0644\\u0645\\u0637\\u0627\\u0631\\u0627\\u062a\\u00a0<\\/div><div>\\uf0b7 \\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0637\\u0627\\u0642\\u0629\\u00a0<\\/div><div>\\uf0b7 \\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0645\\u064a\\u0627\\u0647 \\u0648\\u0627\\u0644\\u0635\\u0631\\u0641 \\u0627\\u0644\\u0635\\u062d\\u064a\\u00a0<\\/div><div>\\uf0b7 \\u0627\\u0644\\u0645\\u0631\\u0627\\u0641\\u0642 \\u0627\\u0644\\u0635\\u062d\\u064a\\u0629 \\u0648\\u0627\\u0644\\u062a\\u0639\\u0644\\u064a\\u0645\\u064a\\u0629\\u00a0<\\/div><div>\\uf0b7 \\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0633\\u064a\\u0627\\u062d\\u0629 \\u0648\\u0627\\u0644\\u062a\\u0631\\u0641\\u064a\\u0647\\u00a0<\\/div><div>\\uf0b7 \\u0627\\u0644\\u0645\\u062f\\u0646 \\u0627\\u0644\\u0630\\u0643\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0628\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629 \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a\\u0629<br \\/><div><br \\/><\\/div><\\/div>\",\"image\":\"69ddc018d4db01776140312.png\"}', NULL, '2026-04-14 04:18:32', '2026-04-28 12:13:04'),
(305, 'explore_investment_opportunities.content', '{\"title\":\"Explore Investment Opportunities\",\"title_ar\":\"\\u0635\\u0641\\u062d\\u0629 \\u0627\\u0633\\u062a\\u0643\\u0634\\u0641 \\u0627\\u0644\\u0641\\u0631\\u0635 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\\u0629\",\"description\":\"\\u062a\\u0648\\u0641\\u0631 \\u062a\\u0645\\u0644\\u0643 \\u2013 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0623\\u0645\\u0644\\u0627\\u0643 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u062a\\u0646\\u0648\\u0639\\u0629 \\u0645\\u0646 \\u0627\\u0644\\u0641\\u0631\\u0635 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\\u0629 \\u0641\\u064a \\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u0645\\u062a\\u0639\\u062f\\u062f\\u0629 \\u062a\\u0634\\u0645\\u0644 \\u0627\\u0644\\u0639\\u0642\\u0627\\u0631\\u0627\\u062a\\u060c \\u0627\\u0644\\u0635\\u0646\\u0627\\u0639\\u0629\\u060c \\u0627\\u0644\\u062a\\u062c\\u0627\\u0631\\u0629\\u060c \\u0627\\u0644\\u062a\\u0642\\u0646\\u064a\\u0629\\u060c \\u0627\\u0644\\u0628\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629\\u060c \\u0648\\u0627\\u0644\\u062e\\u062f\\u0645\\u0627\\u062a.\\n\\n\\u0646\\u062d\\u0646 \\u0646\\u0639\\u0645\\u0644 \\u0639\\u0644\\u0649 \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\\u0629 \\u0630\\u0627\\u062a \\u0642\\u064a\\u0645\\u0629 \\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629 \\u0639\\u0627\\u0644\\u064a\\u0629\\u060c \\u0648\\u0646\\u0631\\u062d\\u0628 \\u0628\\u0627\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646 \\u0648\\u0627\\u0644\\u0634\\u0631\\u0643\\u0627\\u0621 \\u0627\\u0644\\u0631\\u0627\\u063a\\u0628\\u064a\\u0646 \\u0641\\u064a \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u0643\\u0629 \\u0641\\u064a \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0641\\u0631\\u0635 \\u0648\\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0645\\u0633\\u062a\\u0642\\u0628\\u0644\\u064a\\u0629 \\u0648\\u0627\\u0639\\u062f\\u0629.\\n\\n\\u0645\\u0646 \\u062e\\u0644\\u0627\\u0644 \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0635\\u0641\\u062d\\u0629 \\u064a\\u0645\\u0643\\u0646 \\u0644\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646 \\u0627\\u0644\\u062a\\u0639\\u0631\\u0641 \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0641\\u0631\\u0635 \\u0627\\u0644\\u0645\\u062a\\u0627\\u062d\\u0629 \\u0648\\u0627\\u0644\\u062a\\u0648\\u0627\\u0635\\u0644 \\u0645\\u0639 \\u0641\\u0631\\u064a\\u0642 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631 \\u0644\\u062f\\u0631\\u0627\\u0633\\u0629 \\u0625\\u0645\\u0643\\u0627\\u0646\\u064a\\u0629 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u0643\\u0629 \\u0623\\u0648 \\u0627\\u0644\\u0634\\u0631\\u0627\\u0643\\u0629 \\u0641\\u064a \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0645\\u0637\\u0631\\u0648\\u062d\\u0629\",\"description_ar\":\"\\u062a\\u0648\\u0641\\u0631 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0623\\u0645\\u0644\\u0627\\u0643 \\u2013 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0623\\u0645\\u0644\\u0627\\u0643 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0645\\u062a\\u0646\\u0648\\u0639\\u0629 \\u0645\\u0646 \\u0627\\u0644\\u0641\\u0631\\u0635 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\\u0629 \\u0641\\u064a \\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u0645\\u062a\\u0639\\u062f\\u062f\\u0629 \\u062a\\u0634\\u0645\\u0644 \\u0627\\u0644\\u0639\\u0642\\u0627\\u0631\\u0627\\u062a\\u060c \\u0627\\u0644\\u0635\\u0646\\u0627\\u0639\\u0629\\u060c \\u0627\\u0644\\u062a\\u062c\\u0627\\u0631\\u0629\\u060c \\u0627\\u0644\\u062a\\u0642\\u0646\\u064a\\u0629\\u060c \\u0627\\u0644\\u0628\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629\\u060c \\u0648\\u0627\\u0644\\u062e\\u062f\\u0645\\u0627\\u062a.<br \\/><br \\/>\\u0646\\u062d\\u0646 \\u0646\\u0639\\u0645\\u0644 \\u0639\\u0644\\u0649 \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\\u0629 \\u0630\\u0627\\u062a \\u0642\\u064a\\u0645\\u0629 \\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629 \\u0639\\u0627\\u0644\\u064a\\u0629\\u060c \\u0648\\u0646\\u0631\\u062d\\u0628 \\u0628\\u0627\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646 \\u0648\\u0627\\u0644\\u0634\\u0631\\u0643\\u0627\\u0621 \\u0627\\u0644\\u0631\\u0627\\u063a\\u0628\\u064a\\u0646 \\u0641\\u064a \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u0643\\u0629 \\u0641\\u064a \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0641\\u0631\\u0635 \\u0648\\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0645\\u0633\\u062a\\u0642\\u0628\\u0644\\u064a\\u0629 \\u0648\\u0627\\u0639\\u062f\\u0629.<br \\/><br \\/>\\u0645\\u0646 \\u062e\\u0644\\u0627\\u0644 \\u0647\\u0630\\u0647 \\u0627\\u0644\\u0635\\u0641\\u062d\\u0629 \\u064a\\u0645\\u0643\\u0646 \\u0644\\u0644\\u0645\\u0633\\u062a\\u062b\\u0645\\u0631\\u064a\\u0646 \\u0627\\u0644\\u062a\\u0639\\u0631\\u0641 \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0641\\u0631\\u0635 \\u0627\\u0644\\u0645\\u062a\\u0627\\u062d\\u0629 \\u0648\\u0627\\u0644\\u062a\\u0648\\u0627\\u0635\\u0644 \\u0645\\u0639 \\u0641\\u0631\\u064a\\u0642 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631 \\u0644\\u062f\\u0631\\u0627\\u0633\\u0629 \\u0625\\u0645\\u0643\\u0627\\u0646\\u064a\\u0629 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u0643\\u0629 \\u0623\\u0648 \\u0627\\u0644\\u0634\\u0631\\u0627\\u0643\\u0629 \\u0641\\u064a \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0645\\u0637\\u0631\\u0648\\u062d\\u0629\",\"has_image\":\"1\",\"image\":\"69e28a07885c01776454151.png\",\"description_en\":\"Amlaek Development provides a variety of investment opportunities in multiple sectors including real estate, industry, trade, technology, infrastructure, and services. We work on developing high economic value investment projects and welcome investors and partners willing to participate in these opportunities and contribute to developing promising future projects. Through this page, investors can explore available opportunities and contact the investment team to study the possibility of participation or partnership in the proposed projects.\"}', NULL, '2026-04-14 05:29:18', '2026-05-12 20:16:53'),
(306, 'investment_sectors.content', '{\"title\":\"Investment Sectors\",\"title_ar\":\"\\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\\u0629\",\"subtitle\":\"Investment opportunities at Amlaek include several sectors, such as:\",\"subtitle_ar\":\"\\u062a\\u0634\\u0645\\u0644 \\u0627\\u0644\\u0641\\u0631\\u0635 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u064a\\u0629 \\u0641\\u064a \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643 \\u0639\\u062f\\u0629 \\u0642\\u0637\\u0627\\u0639\\u0627\\u062a\\u060c \\u0645\\u0646\\u0647\\u0627\"}', NULL, '2026-04-14 05:37:02', '2026-04-28 12:58:21'),
(307, 'investment_sectors.element', '{\"title\":\"Real Estate Investment\",\"title_ar\":\"\\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631 \\u0627\\u0644\\u0639\\u0642\\u0627\\u0631\\u064a\",\"has_image\":\"1\",\"image\":\"69e27f8f996f11776451471.jpeg\"}', NULL, '2026-04-14 05:38:37', '2026-04-28 12:58:03'),
(308, 'investment_sectors.element', '{\"title\":\"Industrial Projects\",\"title_ar\":\"\\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0635\\u0646\\u0627\\u0639\\u064a\\u0629\",\"has_image\":\"1\",\"image\":\"69e282959e9aa1776452245.jpg\"}', NULL, '2026-04-14 05:39:08', '2026-04-17 22:57:25'),
(309, 'investment_sectors.element', '{\"title\":\"Infrastructure & Engineering\",\"title_ar\":\"\\u0627\\u0644\\u0628\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0647\\u0646\\u062f\\u0633\\u0629\",\"has_image\":\"1\",\"image\":\"69e283119ab011776452369.png\"}', NULL, '2026-04-14 05:39:41', '2026-04-17 22:59:29'),
(310, 'investment_sectors.element', '{\"title\":\"International Trade & Procurement\",\"title_ar\":\"\\u0627\\u0644\\u062a\\u062c\\u0627\\u0631\\u0629 \\u0627\\u0644\\u062f\\u0648\\u0644\\u064a\\u0629 \\u0648\\u0627\\u0644\\u062a\\u0648\\u0631\\u064a\\u062f\\u0627\\u062a\",\"has_image\":\"1\",\"image\":\"69e285f0091671776453104.png\"}', NULL, '2026-04-14 05:40:34', '2026-04-17 23:11:44'),
(311, 'investment_sectors.element', '{\"title\":\"Technology & Digital Transformation\",\"title_ar\":\"\\u0627\\u0644\\u062a\\u0643\\u0646\\u0648\\u0644\\u0648\\u062c\\u064a\\u0627 \\u0648\\u0627\\u0644\\u062a\\u062d\\u0648\\u0644 \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a\",\"has_image\":\"1\",\"image\":\"69e286055e65e1776453125.png\"}', NULL, '2026-04-14 05:41:15', '2026-04-17 23:12:05'),
(312, 'investment_sectors.element', '{\"title\":\"Energy & Environment\",\"title_ar\":\"\\u0627\\u0644\\u0637\\u0627\\u0642\\u0629 \\u0648\\u0627\\u0644\\u0628\\u064a\\u0626\\u0629\",\"has_image\":\"1\",\"image\":\"69e2872dae1f61776453421.png\"}', NULL, '2026-04-14 05:41:59', '2026-04-17 23:17:01'),
(313, 'investment_sectors.element', '{\"title\":\"Tourism & Entertainment\",\"title_ar\":\"\\u0627\\u0644\\u0633\\u064a\\u0627\\u062d\\u0629 \\u0648\\u0627\\u0644\\u062a\\u0631\\u0641\\u064a\\u0647\",\"has_image\":\"1\",\"image\":\"69e2880e885f91776453646.png\"}', NULL, '2026-04-14 05:42:21', '2026-04-17 23:20:46'),
(314, 'strategic_supply_sector.content', '{\"title\":\"Strategic Supply Sector\",\"title_ar\":\"\\u0642\\u0637\\u0627\\u0639 \\u0627\\u0644\\u062a\\u0648\\u0631\\u064a\\u062f\\u0627\\u062a \\u0627\\u0627\\u0644\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629\",\"description\":\"The Strategic Supply Sector is one of the\\r\\nkey sectors within the Amlaek Platform \\u2013\\r\\nAmlaek Development Group. It provides\\r\\nintegrated supply solutions for government\\r\\nand private sector projects and works to\\r\\nconnect manufacturers and suppliers with\\r\\nbeneficiary entities through a professional\\r\\nsupply system based on operational efficiency\\r\\nand competitive pricing.\\r\\n<br \\/><br \\/>The sector aims to provide comprehensive\\r\\nsupply solutions from the factory to the\\r\\nproject site, ensuring speed of execution,\\r\\nproduct quality, and service integration, with\\r\\nthe capability to meet the needs of major\\r\\nprojects across multiple sectors such as\\r\\ninfrastructure, industry, construction,\\r\\nhealthcare, and education.\\r\\n<br \\/><br \\/>The sector also supports the group\\u2019s\\r\\nparticipation in government and private\\r\\ntenders and projects by providing a wide\\r\\nnetwork of local and international suppliers\\r\\nand partners.\\u00a0\",\"description_ar\":\"\\u0639\\u062f \\u0642\\u0637\\u0627\\u0639 \\u0627\\u0644\\u062a\\u0648\\u0631\\u064a\\u062f\\u0627\\u062a \\u0627\\u0627\\u0644\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0629 \\u0623\\u062d\\u062f \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u0627\\u0644\\u0631\\u0626\\u064a\\u0633\\u064a\\u0629\\r\\n\\u0641\\u064a \\u0645\\u0646\\u0635\\u0629 \\u062a\\u0645\\u0644\\u0643 \\u2013 \\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0623\\u0644\\u0645\\u0627\\u0644\\u0643\\u060c \\u062d\\u064a\\u062b \\u064a\\u0648\\u0641\\u0631 \\u062d\\u0644\\u0648\\u0644\\r\\n\\u062a\\u0648\\u0631\\u064a\\u062f \\u0645\\u062a\\u0643\\u0627\\u0645\\u0644\\u0629 \\u0644\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u062d\\u0643\\u0648\\u0645\\u064a\\u0629 \\u0648\\u0627\\u0644\\u062e\\u0627\\u0635\\u0629\\u060c \\u0648\\u064a\\u0639\\u0645\\u0644 \\u0639\\u0644\\u0649\\r\\n\\u0631\\u0628\\u0637 \\u0627\\u0644\\u0645\\u0635\\u0627\\u0646\\u0639 \\u0648\\u0627\\u0644\\u0645\\u0648\\u0631\\u062f\\u064a\\u0646 \\u0628\\u0627\\u0644\\u062c\\u0647\\u0627\\u062a \\u0627\\u0644\\u0645\\u0633\\u062a\\u0641\\u064a\\u062f\\u0629 \\u0639\\u0628\\u0631 \\u0645\\u0646\\u0638\\u0648\\u0645\\u0629\\r\\n\\u062a\\u0648\\u0631\\u064a\\u062f \\u0627\\u062d\\u062a\\u0631\\u0627\\u0641\\u064a\\u0629 \\u062a\\u0639\\u062a\\u0645\\u062f \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0643\\u0641\\u0627\\u0621\\u0629 \\u0627\\u0644\\u062a\\u0634\\u063a\\u064a\\u0644\\u064a\\u0629 \\u0648\\u0627\\u0623\\u0644\\u0633\\u0639\\u0627\\u0631\\r\\n\\u0627\\u0644\\u062a\\u0646\\u0627\\u0641\\u0633\\u064a\\u0629<br \\/><br \\/><br \\/>\\u064a\\u0647\\u062f\\u0641 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639 \\u0625\\u0644\\u0649 \\u062a\\u0648\\u0641\\u064a\\u0631 \\u062d\\u0644\\u0648\\u0644 \\u062a\\u0648\\u0631\\u064a\\u062f \\u0634\\u0627\\u0645\\u0644\\u0629 \\u0645\\u0646 \\u0627\\u0644\\u0645\\u0635\\u0646\\u0639 \\u0625\\u0644\\u0649\\r\\n\\u0645\\u0648\\u0642\\u0639 \\u0627\\u0644\\u0645\\u0634\\u0631\\u0648\\u0639\\u060c \\u0628\\u0645\\u0627 \\u064a\\u0636\\u0645\\u0646 \\u0633\\u0631\\u0639\\u0629 \\u0627\\u0644\\u062a\\u0646\\u0641\\u064a\\u0630 \\u0648\\u062c\\u0648\\u062f\\u0629 \\u0627\\u0644\\u0645\\u0646\\u062a\\u062c\\u0627\\u062a\\r\\n\\u0648\\u062a\\u0643\\u0627\\u0645\\u0644 \\u0627\\u0644\\u062e\\u062f\\u0645\\u0627\\u062a\\u060c \\u0645\\u0639 \\u0627\\u0644\\u0642\\u062f\\u0631\\u0629 \\u0639\\u0644\\u0649 \\u062a\\u0644\\u0628\\u064a\\u0629 \\u0627\\u062d\\u062a\\u064a\\u0627\\u062c\\u0627\\u062a \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639\\r\\n\\u0627\\u0644\\u0643\\u0628\\u0631\\u0649 \\u0641\\u064a \\u0642\\u0637\\u0627\\u0639\\u0627\\u062a \\u0645\\u062a\\u0639\\u062f\\u062f\\u0629 \\u0645\\u062b\\u0644 \\u0627\\u0644\\u0628\\u0646\\u064a\\u0629 \\u0627\\u0644\\u062a\\u062d\\u062a\\u064a\\u0629\\u060c \\u0627\\u0644\\u0635\\u0646\\u0627\\u0639\\u0629\\u060c\\r\\n\\u0627\\u0644\\u0628\\u0646\\u0627\\u0621\\u060c \\u0627\\u0644\\u0635\\u062d\\u0629\\u060c \\u0648\\u0627\\u0644\\u062a\\u0639\\u0644\\u064a\\u0645<br \\/><br \\/><br \\/>\\u0643\\u0645\\u0627 \\u064a\\u0639\\u0645\\u0644 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639 \\u0639\\u0644\\u0649 \\u062f\\u0639\\u0645 \\u0645\\u0634\\u0627\\u0631\\u0643\\u0629 \\u0627\\u0644\\u0645\\u062c\\u0645\\u0648\\u0639\\u0629 \\u0641\\u064a\\r\\n\\u0627\\u0644\\u0645\\u0646\\u0627\\u0642\\u0635\\u0627\\u062a \\u0648\\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u062d\\u0643\\u0648\\u0645\\u064a\\u0629 \\u0648\\u0627\\u0644\\u062e\\u0627\\u0635\\u0629 \\u0639\\u0628\\u0631 \\u062a\\u0648\\u0641\\u064a\\u0631 \\u0634\\u0628\\u0643\\u0629\\r\\n\\u0648\\u0627\\u0633\\u0639\\u0629 \\u0645\\u0646 \\u0627\\u0644\\u0645\\u0648\\u0631\\u062f\\u064a\\u0646 \\u0648\\u0627\\u0644\\u0634\\u0631\\u0643\\u0627\\u0621 \\u0627\\u0644\\u0645\\u062d\\u0644\\u064a\\u064a\\u0646 \\u0648\\u0627\\u0644\\u062f\\u0648\\u0644\\u064a\\u064a\\u0646<br \\/><br \\/>.<br \\/><br \\/>\",\"become_button\":\"Become Supplier\",\"become_button_ar\":\"\\u0643\\u0646 \\u0645\\u0648\\u0631\\u062f\\u064b\\u0627\",\"become_link\":\"#\",\"has_image\":\"1\",\"image_1\":\"69dde16f276871776148847.png\",\"image_2\":\"69dde16f535751776148847.png\"}', NULL, '2026-04-14 06:40:47', '2026-04-14 06:40:47'),
(315, 'why_temlk.element', '{\"title\":\"A multi-sector business platform\",\"title_ar\":\"\\u0645\\u0646\\u0635\\u0629 \\u0623\\u0639\\u0645\\u0627\\u0644 \\u0645\\u062a\\u0639\\u062f\\u062f\\u0629 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639\\u0627\\u062a\",\"has_image\":\"1\",\"image\":\"69f031f965a021777349113.png\"}', NULL, '2026-04-28 07:56:38', '2026-04-28 08:05:13'),
(317, 'why_temlk.content', '{\"title\":\"Why Amlaek Development?\",\"title_ar\":\"\\u0644\\u0645\\u0627\\u0630\\u0627 \\u0634\\u0631\\u0643\\u0629 \\u062a\\u0646\\u0645\\u064a\\u0629 \\u0627\\u0644\\u0627\\u0645\\u0644\\u0627\\u0643 \\u0644\\u0644\\u062a\\u0637\\u0648\\u064a\\u0631\\u061f\"}', NULL, '2026-04-28 08:02:00', '2026-04-28 14:01:02'),
(318, 'why_temlk.element', '{\"title\":\"Extensive experience in project development and investment\",\"title_ar\":\"\\u062e\\u0628\\u0631\\u0629 \\u0637\\u0648\\u064a\\u0644\\u0629 \\u0641\\u064a \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0648 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\",\"has_image\":\"1\",\"image\":\"69f0325944fe71777349209.png\"}', NULL, '2026-04-28 08:02:16', '2026-04-28 17:37:21'),
(319, 'why_temlk.element', '{\"title\":\"Integrated economic incubator ecosystem\",\"title_ar\":\"\\u0645\\u0646\\u0638\\u0648\\u0645\\u0629 \\u062d\\u0627\\u0636\\u0646\\u0627\\u062a \\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629 \\u0645\\u062a\\u0643\\u0627\\u0645\\u0644\\u0629\",\"has_image\":\"1\",\"image\":\"69f03289e12e91777349257.png\"}', NULL, '2026-04-28 08:02:58', '2026-04-28 17:37:53'),
(320, 'why_temlk.element', '{\"title\":\"Local and international partnerships\",\"title_ar\":\"\\u0634\\u0631\\u0627\\u0643\\u0627\\u062a \\u0645\\u062d\\u0644\\u064a\\u0629 \\u0648 \\u062f\\u0648\\u0644\\u064a\\u0629\",\"has_image\":\"1\",\"image\":\"69f03295773471777349269.png\"}', NULL, '2026-04-28 08:03:32', '2026-04-28 17:38:41'),
(321, 'why_temlk.element', '{\"title\":\"A scalable global operational model\",\"title_ar\":\"\\u0646\\u0645\\u0648\\u0630\\u062c \\u062a\\u0634\\u063a\\u064a\\u0644\\u064a  \\u0642\\u0627\\u0628\\u0644 \\u0644\\u0644\\u062a\\u0648\\u0633\\u0639 \\u0639\\u0627\\u0644\\u0645\\u064a\\u0627\",\"has_image\":\"1\",\"image\":\"69f032b082d8f1777349296.png\"}', NULL, '2026-04-28 08:04:05', '2026-04-28 17:39:37'),
(322, 'network_economic.element', '{\"title\":\"Contributed to developing innovative business models that integrate digital transformation and sustainability to support the growth of projects and investments.\",\"title_ar\":\"\\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0646\\u0645\\u0627\\u0630\\u062c \\u0623\\u0639\\u0645\\u0627\\u0644 \\u0645\\u0628\\u062a\\u0643\\u0631\\u0629 \\u062a\\u062c\\u0645\\u0639 \\u0628\\u064a\\u0646 \\u0627\\u0644\\u062a\\u062d\\u0648\\u0644 \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062f\\u0627\\u0645\\u0629 \\u0644\\u062f\\u0639\\u0645 \\u0646\\u0645\\u0648 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u0627\\u062a.\"}', NULL, '2026-04-28 22:32:33', '2026-05-14 17:44:55'),
(323, 'network_economic.element', '{\"title\":\"Participated in designing and operating incubation and business acceleration programs to support entrepreneurs and startups.\",\"title_ar\":\"\\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u062a\\u0635\\u0645\\u064a\\u0645 \\u0648\\u062a\\u0634\\u063a\\u064a\\u0644 \\u0628\\u0631\\u0627\\u0645\\u062c \\u0627\\u062d\\u062a\\u0636\\u0627\\u0646 \\u0648\\u062a\\u0633\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644 \\u0644\\u062f\\u0639\\u0645 \\u0631\\u0648\\u0627\\u062f \\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644 \\u0648\\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0627\\u0644\\u0646\\u0627\\u0634\\u0626\\u0629\"}', NULL, '2026-04-28 22:33:06', '2026-05-14 18:16:38'),
(324, 'network_economic.element', '{\"title\":\"Contributed to developing digital stores and platforms that provide services supporting entrepreneurship and emerging businesses.\",\"title_ar\":\"- \\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0645\\u062a\\u0627\\u062c\\u0631 \\u0648\\u0645\\u0646\\u0635\\u0627\\u062a \\u0631\\u0642\\u0645\\u064a\\u0629 \\u0644\\u062a\\u0642\\u062f\\u064a\\u0645 \\u0627\\u0644\\u062e\\u062f\\u0645\\u0627\\u062a \\u0627\\u0644\\u062f\\u0627\\u0639\\u0645\\u0629 \\u0644\\u0631\\u064a\\u0627\\u062f\\u0629 \\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644 \\u0648\\u0627\\u0644\\u0645\\u0646\\u0634\\u0622\\u062a \\u0627\\u0644\\u0646\\u0627\\u0634\\u0626\\u0629.\"}', NULL, '2026-04-30 05:09:14', '2026-05-14 18:17:00'),
(344, 'sari_community.content', '{\"page_title\":\"SARI COMMUNITY\",\"page_title_ar\":\"\\u0645\\u062c\\u062a\\u0645\\u0639 \\u0633\\u0627\\u0631\\u064a\",\"page_description\":\"Based on Mohammed Al Sari\\u2019s vision, which is to be an effective and contributor part and part of the change, and based on Mohammed Al Sari\\u2019s message to be a reliable strategic partner in helping others to make the right decision. Private government and non-profit sector as follows\",\"page_description_ar\":\"\\u0627\\u0646\\u0637\\u0644\\u0627\\u0642\\u0627\\u064b \\u0645\\u0646 \\u0631\\u0624\\u064a\\u0629 \\u0645\\u062d\\u0645\\u062f \\u0627\\u0644\\u0633\\u0627\\u0631\\u064a\\u060c \\u0627\\u0644\\u062a\\u064a \\u062a\\u062a\\u0645\\u062b\\u0644 \\u0641\\u064a \\u0623\\u0646 \\u064a\\u0643\\u0648\\u0646 \\u062c\\u0632\\u0621\\u0627\\u064b \\u0641\\u0627\\u0639\\u0644\\u0627\\u064b \\u0648\\u0645\\u0633\\u0627\\u0647\\u0645\\u0627\\u064b \\u0641\\u064a \\u0627\\u0644\\u062a\\u063a\\u064a\\u064a\\u0631\\u060c \\u0648\\u0627\\u0646\\u0637\\u0644\\u0627\\u0642\\u0627\\u064b \\u0645\\u0646 \\u0631\\u0633\\u0627\\u0644\\u062a\\u0647 \\u0641\\u064a \\u0623\\u0646 \\u064a\\u0643\\u0648\\u0646 \\u0634\\u0631\\u064a\\u0643\\u0627\\u064b \\u0627\\u0633\\u062a\\u0631\\u0627\\u062a\\u064a\\u062c\\u064a\\u0627\\u064b \\u0645\\u0648\\u062b\\u0648\\u0642\\u0627\\u064b \\u0628\\u0647 \\u0641\\u064a \\u0645\\u0633\\u0627\\u0639\\u062f\\u0629 \\u0627\\u0644\\u0622\\u062e\\u0631\\u064a\\u0646 \\u0639\\u0644\\u0649 \\u0627\\u062a\\u062e\\u0627\\u0630 \\u0627\\u0644\\u0642\\u0631\\u0627\\u0631 \\u0627\\u0644\\u0635\\u0627\\u0626\\u0628\\u060c \\u0641\\u0625\\u0646 \\u0627\\u0644\\u0642\\u0637\\u0627\\u0639 \\u0627\\u0644\\u062e\\u0627\\u0635 \\u0648\\u0627\\u0644\\u062d\\u0643\\u0648\\u0645\\u064a \\u0648\\u063a\\u064a\\u0631 \\u0627\\u0644\\u0631\\u0628\\u062d\\u064a \\u064a\\u0639\\u0645\\u0644\\u0627\\u0646 \\u0639\\u0644\\u0649 \\u0627\\u0644\\u0646\\u062d\\u0648 \\u0627\\u0644\\u062a\\u0627\\u0644\\u064a:\",\"has_image\":\"1\",\"intro_image\":\"69f99b87978e91777965959.png\"}', NULL, '2026-05-05 11:25:59', '2026-05-05 11:25:59'),
(346, 'network_economic.element', '{\"title\":\"Contributed to preparing feasibility studies, economic analyses, and development consulting services for projects.\",\"title_ar\":\"\\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u0625\\u0639\\u062f\\u0627\\u062f \\u062f\\u0631\\u0627\\u0633\\u0627\\u062a \\u0627\\u0644\\u062c\\u062f\\u0648\\u0649 \\u0648\\u0627\\u0644\\u062a\\u062d\\u0644\\u064a\\u0644\\u0627\\u062a \\u0627\\u0644\\u0627\\u0642\\u062a\\u0635\\u0627\\u062f\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u0634\\u0627\\u0631\\u0627\\u062a \\u0627\\u0644\\u062a\\u0637\\u0648\\u064a\\u0631\\u064a\\u0629 \\u0644\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639.\"}', NULL, '2026-05-14 17:47:07', '2026-05-14 18:19:39'),
(347, 'network_economic.element', '{\"title\":\"Participated in developing financing solutions and connecting projects with funding entities and financial institutions.\",\"title_ar\":\"- \\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u062a\\u0637\\u0648\\u064a\\u0631 \\u062d\\u0644\\u0648\\u0644 \\u062a\\u0645\\u0648\\u064a\\u0644\\u064a\\u0629 \\u0648\\u0631\\u0628\\u0637 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0628\\u0627\\u0644\\u062c\\u0647\\u0627\\u062a \\u0627\\u0644\\u062a\\u0645\\u0648\\u064a\\u0644\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0645\\u0624\\u0633\\u0633\\u0627\\u062a \\u0627\\u0644\\u0645\\u0627\\u0644\\u064a\\u0629.\"}', NULL, '2026-05-14 17:47:12', '2026-05-14 18:20:06'),
(348, 'network_economic.element', '{\"title\":\"Contributed to the development and marketing of real estate assets, as well as the management of real estate projects and investments.\",\"title_ar\":\"\\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0648\\u062a\\u0633\\u0648\\u064a\\u0642 \\u0627\\u0644\\u0623\\u0635\\u0648\\u0644 \\u0627\\u0644\\u0639\\u0642\\u0627\\u0631\\u064a\\u0629 \\u0648\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0634\\u0627\\u0631\\u064a\\u0639 \\u0648\\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631\\u0627\\u062a \\u0627\\u0644\\u0639\\u0642\\u0627\\u0631\\u064a\\u0629.\"}', NULL, '2026-05-14 17:47:17', '2026-05-14 18:20:35'),
(349, 'network_economic.element', '{\"title\":\"Participated in organizing trade missions and promoting investment opportunities and international cooperation.\",\"title_ar\":\"\\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u062a\\u0646\\u0638\\u064a\\u0645 \\u0627\\u0644\\u0628\\u0639\\u062b\\u0627\\u062a \\u0627\\u0644\\u062a\\u062c\\u0627\\u0631\\u064a\\u0629 \\u0648\\u062a\\u0639\\u0632\\u064a\\u0632 \\u0641\\u0631\\u0635 \\u0627\\u0644\\u0627\\u0633\\u062a\\u062b\\u0645\\u0627\\u0631 \\u0648\\u0627\\u0644\\u062a\\u0639\\u0627\\u0648\\u0646 \\u0627\\u0644\\u062f\\u0648\\u0644\\u064a.\"}', NULL, '2026-05-14 17:47:23', '2026-05-14 18:21:17'),
(350, 'network_economic.element', '{\"title\":\"Contributed to managing and operating export activities and developing export support services and international market expansion.\",\"title_ar\":\"\\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u0625\\u062f\\u0627\\u0631\\u0629 \\u0648\\u062a\\u0634\\u063a\\u064a\\u0644 \\u0639\\u0645\\u0644\\u064a\\u0627\\u062a \\u0627\\u0644\\u062a\\u0635\\u062f\\u064a\\u0631 \\u0648\\u062a\\u0637\\u0648\\u064a\\u0631 \\u062e\\u062f\\u0645\\u0627\\u062a \\u062f\\u0639\\u0645 \\u0627\\u0644\\u0635\\u0627\\u062f\\u0631\\u0627\\u062a \\u0648\\u0627\\u0644\\u0623\\u0633\\u0648\\u0627\\u0642 \\u0627\\u0644\\u062f\\u0648\\u0644\\u064a\\u0629.\"}', NULL, '2026-05-14 17:47:28', '2026-05-14 18:21:45'),
(351, 'network_economic.element', '{\"title\":\"Contributed to developing technology solutions, digital systems, applications, and websites.\",\"title_ar\":\"- \\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0627\\u0644\\u062d\\u0644\\u0648\\u0644 \\u0627\\u0644\\u062a\\u0642\\u0646\\u064a\\u0629 \\u0648\\u0627\\u0644\\u0623\\u0646\\u0638\\u0645\\u0629 \\u0627\\u0644\\u0631\\u0642\\u0645\\u064a\\u0629 \\u0648\\u0627\\u0644\\u062a\\u0637\\u0628\\u064a\\u0642\\u0627\\u062a \\u0648\\u0627\\u0644\\u0645\\u0648\\u0627\\u0642\\u0639 \\u0627\\u0644\\u0625\\u0644\\u0643\\u062a\\u0631\\u0648\\u0646\\u064a\\u0629.\"}', NULL, '2026-05-14 17:47:32', '2026-05-14 18:22:09'),
(352, 'network_economic.element', '{\"title\":\"Participated in designing programs and initiatives that support the sustainability and growth of family businesses and connect them with specialized expertise.\",\"title_ar\":\"\\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u062a\\u0635\\u0645\\u064a\\u0645 \\u0628\\u0631\\u0627\\u0645\\u062c \\u0648\\u0645\\u0628\\u0627\\u062f\\u0631\\u0627\\u062a \\u0644\\u062f\\u0639\\u0645 \\u0627\\u0633\\u062a\\u062f\\u0627\\u0645\\u0629 \\u0648\\u0646\\u0645\\u0648 \\u0627\\u0644\\u0634\\u0631\\u0643\\u0627\\u062a \\u0627\\u0644\\u0639\\u0627\\u0626\\u0644\\u064a\\u0629 \\u0648\\u0631\\u0628\\u0637\\u0647\\u0627 \\u0628\\u0627\\u0644\\u062e\\u0628\\u0631\\u0627\\u062a \\u0627\\u0644\\u0645\\u062a\\u062e\\u0635\\u0635\\u0629.\"}', NULL, '2026-05-14 17:47:37', '2026-05-14 18:22:40'),
(353, 'network_economic.element', '{\"title\":\"Contributed to developing digital platforms for booking and managing spaces and venues for events and business activities.\",\"title_ar\":\"\\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u062a\\u0637\\u0648\\u064a\\u0631 \\u0645\\u0646\\u0635\\u0627\\u062a \\u0631\\u0642\\u0645\\u064a\\u0629 \\u0644\\u062d\\u062c\\u0632 \\u0648\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u0633\\u0627\\u062d\\u0627\\u062a \\u0648\\u0627\\u0644\\u0645\\u0648\\u0627\\u0642\\u0639 \\u0627\\u0644\\u0645\\u062e\\u0635\\u0635\\u0629 \\u0644\\u0644\\u0641\\u0639\\u0627\\u0644\\u064a\\u0627\\u062a \\u0648\\u0627\\u0644\\u0623\\u0639\\u0645\\u0627\\u0644.\"}', NULL, '2026-05-14 17:47:42', '2026-05-14 18:23:08'),
(354, 'network_economic.element', '{\"title\":\"Participated in developing specialized safety, security, and risk management solutions and products.\",\"title_ar\":\"\\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u062a\\u0637\\u0648\\u064a\\u0631 \\u062d\\u0644\\u0648\\u0644 \\u0648\\u0645\\u0646\\u062a\\u062c\\u0627\\u062a \\u0645\\u062a\\u062e\\u0635\\u0635\\u0629 \\u0641\\u064a \\u0627\\u0644\\u0623\\u0645\\u0646 \\u0648\\u0627\\u0644\\u0633\\u0644\\u0627\\u0645\\u0629 \\u0648\\u0625\\u062f\\u0627\\u0631\\u0629 \\u0627\\u0644\\u0645\\u062e\\u0627\\u0637\\u0631.\"}', NULL, '2026-05-14 17:47:47', '2026-05-14 18:23:32'),
(355, 'network_economic.element', '{\"title\":\"Contributed to providing and operating reliable support services for both the public and private sectors.\",\"title_ar\":\"\\u0627\\u0644\\u0645\\u0633\\u0627\\u0647\\u0645\\u0629 \\u0641\\u064a \\u062a\\u0642\\u062f\\u064a\\u0645 \\u0648\\u062a\\u0634\\u063a\\u064a\\u0644 \\u062e\\u062f\\u0645\\u0627\\u062a \\u0645\\u0633\\u0627\\u0646\\u062f\\u0629 \\u0645\\u0648\\u062b\\u0648\\u0642\\u0629 \\u0644\\u0644\\u0642\\u0637\\u0627\\u0639\\u064a\\u0646 \\u0627\\u0644\\u062d\\u0643\\u0648\\u0645\\u064a \\u0648\\u0627\\u0644\\u062e\\u0627\\u0635.\"}', NULL, '2026-05-14 17:47:52', '2026-05-14 18:23:53'),
(356, 'hero.content', '{\"eyebrow\":\"Your Healthcare Digital Partner\",\"heading\":\"Your Healthcare Expertise.\",\"heading_accent\":\"Our Digital Growth.\",\"subheading\":\"Websites, Branding, SEO and Digital Marketing for doctor, clinics, Hospitals and Diagnostic centers.\",\"btn_1_text\":\"Get a Quote\",\"btn_1_url\":\"contact\",\"btn_2_text\":\"View Our Work\",\"btn_2_url\":\"#services\",\"hero_tags\":\"Doctors, Hospitals, Clinics, Diagnostic Centers\",\"hero_image\":\"assets\\/images\\/3s\\/hero-doctor.jpg\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 12:36:45'),
(357, 'digital_impact.content', '{\"eyebrow\":\"Digital Impact\",\"title\":\"Build a Stronger Digital Presence for Your Healthcare Business.\",\"lead\":\"From professional websites and online visibility to patient-focused digital services, we help healthcare businesses create better digital experiences.\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 12:36:45'),
(361, 'who_we_help.content', '{\"eyebrow\":\"Who We Help\",\"title\":\"Digital Support for Every Healthcare Practice.\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 12:36:45'),
(366, 'services.content', '{\"eyebrow\":\"Our Services\",\"title\":\"Everything Your Healthcare Business Needs to Grow Online.\",\"lead\":\"Three connected service groups make it easier to identify the right starting point.\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 12:36:45'),
(367, 'why_choose_us.content', '{\"eyebrow\":\"Why Choose Us\",\"title\":\"Healthcare Expertise. Digital Solutions That Work for Your Practice.\",\"image\":\"assets\\/images\\/3s\\/why-team.jpg\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 12:36:45'),
(372, 'process.content', '{\"eyebrow\":\"How We Work\",\"title\":\"A Clear Process From Brief to Launch.\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 12:36:45'),
(377, 'our_work.content', '{\"eyebrow\":\"Our Work\",\"title\":\"Digital Work Designed Around Healthcare Needs.\",\"btn_text\":\"View Case Studies\",\"btn_url\":\"services\",\"showcase_image\":\"assets\\/images\\/3s\\/work-showcase.jpg\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 12:36:45'),
(378, 'cta.content', '{\"heading\":\"Ready to Strengthen Your Healthcare Online?\",\"subheading\":\"Tell us about your practice and the digital services you need.\",\"btn_1_text\":\"Get a Quote\",\"btn_1_url\":\"contact\",\"btn_2_text\":\"Contact Us\",\"btn_2_url\":\"contact\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 14:15:58'),
(379, 'about_hero.content', '{\"eyebrow\":\"About Us\",\"heading\":\"A Digital Agency Focused on Healthcare.\",\"description\":\"We create professional, responsive websites that help doctors, clinics, hospitals, and diagnostic centers communicate their services clearly and provide visitors with an easy-to-use online experience.\",\"btn_1_text\":\"Discuss Your Website\",\"btn_1_url\":\"contact\",\"btn_2_text\":\"Explore Our Services\",\"btn_2_url\":\"services\",\"image\":\"assets\\/images\\/3s\\/about-hero.jpg\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 12:36:45'),
(380, 'about_approach.content', '{\"eyebrow\":\"Our Approach\",\"title\":\"Healthcare-focused, from website to patient access\",\"image\":\"assets\\/images\\/3s\\/why-team.jpg\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 12:36:45'),
(385, 'services_hero.content', '{\"eyebrow\":\"Our Services\",\"heading\":\"Digital Solutions Built for Better Healthcare Growth.\",\"description\":\"From healthcare websites and search visibility to digital marketing and patient-focused digital services, we help healthcare providers build a stronger digital presence.\",\"btn_1_text\":\"Explore Our Services\",\"btn_1_url\":\"#digital-presence\",\"btn_2_text\":\"Book a Consultation\",\"btn_2_url\":\"contact\",\"image\":\"assets\\/images\\/3s\\/services-hero.jpg\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 12:36:45'),
(386, 'contact_banner.content', '{\"eyebrow\":\"Contact Us\",\"heading\":\"Tell Us About Your Practice.\",\"subheading\":\"Share the digital services you need and our team will get back to you with the next steps.\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 12:36:45'),
(387, 'contact_form.content', '{\"card_title\":\"Get in Touch\",\"card_subtitle\":\"We help doctors, clinics, hospitals and diagnostic centers build a stronger online presence.\",\"email\":\"info@3smedicare.com\",\"phone\":\"+1 (555) 234-5678\",\"hours\":\"Mon - Fri: 9:00 AM - 6:00 PM\",\"location\":\"Medical Arts Plaza, Suite 400\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 12:36:45'),
(388, 'contact_map.content', '{\"location_name\":\"3S Medi Care Headquarters\",\"map_note\":\"Medical Arts Plaza, Suite 400\",\"embed_code\":\"\"}', NULL, '2026-11-10 12:36:45', '2026-11-10 12:36:45'),
(408, 'digital_impact.element', '{\"title\":\"Be Found Online\",\"description\":\"Help patients discover your practice when they search.\",\"tags\":\"SEO Services, Profile Listing, Website Development\",\"thumb\":\"assets\\/images\\/3s\\/card-be-found.jpg\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(409, 'digital_impact.element', '{\"title\":\"Reach the Right Audience\",\"description\":\"Promote your services to the people who need them.\",\"tags\":\"Digital Marketing, Facebook Ads, Google Ads\",\"thumb\":\"assets\\/images\\/3s\\/card-reach.jpg\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(410, 'digital_impact.element', '{\"title\":\"Simplify Patient Access\",\"description\":\"Make it easier for patients to reach and book you.\",\"tags\":\"Patient Appointment, Patient Queue, E-Prescription\",\"thumb\":\"assets\\/images\\/3s\\/card-simplify.jpg\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(411, 'who_we_help.element', '{\"title\":\"Doctors\",\"description\":\"A professional online presence for individual practitioners.\",\"link_text\":\"Services for doctors\",\"link_url\":\"services#doctors\",\"thumb\":\"assets\\/images\\/3s\\/who-doctors.jpg\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(412, 'who_we_help.element', '{\"title\":\"Hospitals\",\"description\":\"Connected digital services for larger organizations.\",\"link_text\":\"Services for hospitals\",\"link_url\":\"services#hospitals\",\"thumb\":\"assets\\/images\\/3s\\/who-hospitals.jpg\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(413, 'who_we_help.element', '{\"title\":\"Clinics\",\"description\":\"Visibility and patient access for your clinic.\",\"link_text\":\"Services for clinics\",\"link_url\":\"services#clinics\",\"thumb\":\"assets\\/images\\/3s\\/who-clinics.jpg\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(414, 'who_we_help.element', '{\"title\":\"Diagnostic Centers\",\"description\":\"Clear digital presence for diagnostic services.\",\"link_text\":\"Services for diagnostic centers\",\"link_url\":\"services#diagnostic\",\"thumb\":\"assets\\/images\\/3s\\/who-diagnostic.jpg\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(415, 'why_choose_us.element', '{\"title\":\"Healthcare-Focused Approach\",\"description\":\"Built around how healthcare practices work.\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(416, 'why_choose_us.element', '{\"title\":\"Connected Digital Services\",\"description\":\"Website, marketing and patient services that fit together.\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(417, 'why_choose_us.element', '{\"title\":\"Patient-Friendly Digital Access\",\"description\":\"Simple ways for patients to reach you.\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(418, 'why_choose_us.element', '{\"title\":\"Consistent Brand Presence\",\"description\":\"One look across every channel.\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(419, 'process.element', '{\"step_no\":\"01\",\"title\":\"Discover\",\"description\":\"We learn about your practice audience and goals.\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(420, 'process.element', '{\"step_no\":\"02\",\"title\":\"Strategize\",\"description\":\"We shape the right digital strategy and project plan.\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(421, 'process.element', '{\"step_no\":\"03\",\"title\":\"Design & Deliver\",\"description\":\"We design and build your website, branding or marketing solution.\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58');
INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `tempname`, `created_at`, `updated_at`) VALUES
(422, 'process.element', '{\"step_no\":\"04\",\"title\":\"Launch & Grow\",\"description\":\"We take it live and support you with ongoing improvements.\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(423, 'about_approach.element', '{\"title\":\"Healthcare-Focused Approach\",\"description\":\"Built around how healthcare practices work.\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(424, 'about_approach.element', '{\"title\":\"Connected Digital Services\",\"description\":\"Website, marketing and patient services that fit together.\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(425, 'about_approach.element', '{\"title\":\"Patient-Friendly Digital Access\",\"description\":\"Simple ways for patients to reach you.\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(426, 'about_approach.element', '{\"title\":\"Consistent Brand Presence\",\"description\":\"One look across every channel.\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58'),
(427, 'get_quote.content', '{\"eyebrow\":\"Instant Healthcare Quote\",\"title\":\"Request a Tailored Quote for Your Practice\",\"subheading\":\"Fill out the simple form below. Pick a category or type your custom practice type, select the services you need, and our medical growth specialists will get back to you within 24 hours.\",\"categories\":\"Doctor \\/ Practitioner, Hospital, Specialized Clinic, Diagnostic & Imaging Center, Dental Practice, HealthTech & Startup, Other\",\"services_list\":\"Website Design & Development, Healthcare SEO & Google Ranking, Social Media & Marketing, Patient Appointment & Queue, Branding & Identity, HIPAA Compliant Hosting\",\"side_card_title\":\"Why Healthcare Leaders Partner with 3S Medi Care\",\"side_card_desc\":\"We specialize strictly in healthcare organizations. Our digital solutions are built around patient trust, medical accuracy, and conversion.\",\"side_points\":\"Fast 24-hour turnaround on custom proposals, 100% HIPAA & Medical Compliance focused, Specialized healthcare UI\\/UX design, Dedicated account manager and ongoing support\",\"btn_text\":\"Submit Quote Request\"}', NULL, '2026-11-10 14:15:58', '2026-11-10 14:15:58');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `site_name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_reply_to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_signature` text COLLATE utf8mb4_unicode_ci,
  `email_signature_ar` text COLLATE utf8mb4_unicode_ci,
  `email_template` text COLLATE utf8mb4_unicode_ci,
  `sms_body` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` text COLLATE utf8mb4_unicode_ci COMMENT 'email configuration',
  `sms_config` text COLLATE utf8mb4_unicode_ci,
  `global_shortcodes` text COLLATE utf8mb4_unicode_ci,
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email verification, 0 - dont check, 1 - check',
  `en` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email notification, 0 - dont send, 1 - send',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'mobile verication, 0 - dont check, 1 - check',
  `sn` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'sms notification, 0 - dont send, 1 - send',
  `force_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT '0',
  `secure_password` tinyint(1) NOT NULL DEFAULT '0',
  `agree` tinyint(1) NOT NULL DEFAULT '0',
  `multi_language` tinyint(1) NOT NULL DEFAULT '1',
  `registration` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Off	, 1: On',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `cur_text`, `cur_sym`, `email_from`, `email_from_name`, `email_reply_to`, `email_signature`, `email_signature_ar`, `email_template`, `sms_body`, `sms_from`, `mail_config`, `sms_config`, `global_shortcodes`, `ev`, `en`, `sv`, `sn`, `force_ssl`, `maintenance_mode`, `secure_password`, `agree`, `multi_language`, `registration`, `created_at`, `updated_at`) VALUES
(1, '3S Medicare', 'BDT', '৳', 'info@3smedicare.com', 'Amlaek Development', NULL, NULL, NULL, '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n    <title></title>\r\n\r\n\r\n\r\n\r\n    <div style=\"max-width: 600px; margin: 0 auto;\">\r\n        <div style=\"text-align: center;\">\r\n            <img src=\"https://new.amlaek.com/assets/images/logoIcon/logo.png\" alt=\"Logo\" style=\"width: 180px;\">\r\n            <h1 style=\"font-size: 20px; margin: 0; padding-top: 10px;\">Hello {{fullname}} ({{username}})</h1>\r\n        </div>\r\n        <div style=\"background: #ffffff; margin-top: 20px; padding: 0 20px 20px 20px;\">\r\n            <div style=\"text-align: center; padding-top: 10px;\">\r\n                <img src=\"email.png\" alt=\"\" style=\"width: 80px;\">\r\n            </div>\r\n\r\n            <div style=\"padding: 40px 0;\">\r\n                {{message}}\r\n\r\n            </div>\r\n            <div style=\"border-top:1px solid #EAEFF2; text-align:center; padding-top: 15px; font-size: 18px;\">\r\n                © 2024<img style=\"color: var(--bs-card-color); font-size: 15px; font-weight: var(--bs-body-font-weight); text-align: var(--bs-body-text-align);\"><span style=\"color: var(--bs-card-color); font-weight: var(--bs-body-font-weight);\">&nbsp;{{site_name}} . All Rights Reserved.</span></div>\r\n        </div>\r\n    </div>', 'hi {{fullname}} ({{username}}), {{message}}', 'Amlak', '{\"name\":\"smtp\",\"host\":\"mail.amlaek.com\",\"port\":\"465\",\"enc\":\"ssl\",\"username\":\"test@amlaek.com\",\"password\":\"Test@%789\"}', '{\"name\":\"nexmo\",\"clickatell\":{\"api_key\":\"----------------\"},\"infobip\":{\"username\":\"------------8888888\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}', '{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}', 1, 1, 0, 0, 1, 0, 1, 1, 1, 1, NULL, '2026-11-10 16:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `healthcare_services`
--

CREATE TABLE `healthcare_services` (
  `id` bigint UNSIGNED NOT NULL,
  `group_key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(140) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'bi-window',
  `short_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `healthcare_services`
--

INSERT INTO `healthcare_services` (`id`, `group_key`, `group_name`, `title`, `slug`, `icon`, `short_description`, `description`, `image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'digital_presence', 'Digital Presence', 'Website Development', 'website-development', 'bi-window', 'Professional, responsive websites that present your healthcare services clearly.', NULL, NULL, 1, 1, '2026-11-10 12:34:21', '2026-11-10 12:34:21'),
(2, 'digital_presence', 'Digital Presence', 'SEO Services', 'seo-services', 'bi-search', 'Improve how your practice appears when people search online.', NULL, NULL, 2, 1, '2026-11-10 12:34:21', '2026-11-10 12:34:21'),
(3, 'digital_presence', 'Digital Presence', 'Profile Listing', 'profile-listing', 'bi-person-vcard', 'Keep your practice information visible on online listing platforms.', NULL, NULL, 3, 1, '2026-11-10 12:34:21', '2026-11-10 12:34:21'),
(4, 'marketing_creative', 'Marketing & Creative', 'Digital Marketing', 'digital-marketing', 'bi-bar-chart-line', 'Plan and run campaigns around your healthcare practice.', NULL, NULL, 4, 1, '2026-11-10 12:34:21', '2026-11-10 12:34:21'),
(5, 'marketing_creative', 'Marketing & Creative', 'Social Media', 'social-media', 'bi-share', 'Consistent, engaging presence on all relevant social channels.', NULL, NULL, 5, 1, '2026-11-10 12:34:21', '2026-11-10 12:34:21'),
(6, 'marketing_creative', 'Marketing & Creative', 'Graphic Design', 'graphic-design', 'bi-palette', 'Visual branding and graphics that match your clinic identity.', NULL, NULL, 6, 1, '2026-11-10 12:34:21', '2026-11-10 12:34:21'),
(7, 'marketing_creative', 'Marketing & Creative', 'Facebook Ads', 'facebook-ads', 'bi-facebook', 'Targeted paid reach on Facebook to attract prospective patients.', NULL, NULL, 7, 1, '2026-11-10 12:34:21', '2026-11-10 12:34:21'),
(8, 'marketing_creative', 'Marketing & Creative', 'Google Ads', 'google-ads', 'bi-google', 'High-intent search visibility on Google for your medical specialties.', NULL, NULL, 8, 1, '2026-11-10 12:34:21', '2026-11-10 12:34:21'),
(9, 'patient_services', 'Patient-Focused Digital Services', 'E-Prescription', 'e-prescription', 'bi-file-earmark-medical', 'Digital prescription support and paperless record keeping.', NULL, NULL, 9, 1, '2026-11-10 12:34:21', '2026-11-10 12:34:21'),
(10, 'patient_services', 'Patient-Focused Digital Services', 'Patient Appointment', 'patient-appointment', 'bi-calendar-check', 'Simpler, seamless appointment booking for your patients.', NULL, NULL, 10, 1, '2026-11-10 12:34:21', '2026-11-10 12:34:21'),
(11, 'patient_services', 'Patient-Focused Digital Services', 'Patient Queue', 'patient-queue', 'bi-people', 'Clearer patient queue handling and reduced waiting room friction.', NULL, NULL, 11, 1, '2026-11-10 12:34:21', '2026-11-10 12:34:21');

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` bigint UNSIGNED NOT NULL,
  `type` enum('sms','email') COLLATE utf8mb4_unicode_ci DEFAULT 'sms',
  `group_id` int DEFAULT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci,
  `message` text COLLATE utf8mb4_unicode_ci,
  `email` text COLLATE utf8mb4_unicode_ci,
  `phone` text COLLATE utf8mb4_unicode_ci,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `domain` int DEFAULT NULL,
  `template_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` longtext COLLATE utf8mb4_unicode_ci,
  `status` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `histories`
--

INSERT INTO `histories` (`id`, `type`, `group_id`, `subject`, `message`, `email`, `phone`, `code`, `domain`, `template_code`, `attachment`, `status`, `created_at`, `updated_at`) VALUES
(1, 'email', NULL, 'Testing', '\"adfasdf\"', '[\"abutaleb.bdg@gmail.com\"]', NULL, NULL, 1, NULL, '\"\"', 1, '2024-02-29 10:57:59', '2024-02-29 10:58:00'),
(2, 'email', NULL, 'Testing', '\"adfasdf\"', '[\"abutaleb.bdg@gmail.com\"]', NULL, NULL, 1, NULL, '\"\"', 0, '2024-02-29 11:03:14', '2024-02-29 11:03:14'),
(3, 'email', NULL, 'Testing', '\"adfasdf\"', '[\"abutaleb.bdg@gmail.com\"]', NULL, NULL, 1, NULL, '\"\"', 1, '2024-02-29 11:06:08', '2024-02-29 11:06:08'),
(4, 'email', NULL, 'Testing', '\"adfasdf\"', '[\"abutaleb.bdg@gmail.com\"]', NULL, NULL, 1, NULL, '\"\"', 1, '2024-02-29 11:06:26', '2024-02-29 11:06:26'),
(5, 'email', NULL, 'Testing', '\"Testing\"', '[\"abutaleb.bdg@gmail.com\"]', NULL, NULL, 1, NULL, '\"\"', 1, '2024-02-29 11:09:29', '2024-02-29 11:09:30'),
(6, 'email', NULL, 'hgjhgjhg', '\"fghfghfghfdghdgh\"', '[\"mdrabbihasan610@gmail.com\",\" mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 02:21:06', '2024-04-16 02:21:06'),
(7, 'email', NULL, 'fsafasfasf', '\"asfasfasf\"', '[\"mdrabbihasan610@gmail.com\",\" mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 02:24:23', '2024-04-16 02:24:23'),
(8, 'email', NULL, 'fghfghfh', '\"hgfghfghdfgdfg\"', '[\"mdrabbihasan610@gmail.com\",\" mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 02:31:54', '2024-04-16 02:31:54'),
(9, 'email', NULL, 'yugyugyug', '\"jhbjhbjhbjbhjb\"', '[\"mdrabbihasan610@gmail.com\",\" mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 02:37:57', '2024-04-16 02:37:57'),
(10, 'email', NULL, 'hgfhgfghf', '\"ghfghfgcfgcdfgg\"', '[\"mdrabbihasan610@gmail.com\",\" mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 02:50:18', '2024-04-16 02:50:18'),
(11, 'email', NULL, 'gdsgdsg', '\"sdgdgsdgsgd\"', '[\"mdrabbihasan610@gmail.com\",\" mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 02:55:27', '2024-04-16 02:55:27'),
(12, 'email', NULL, 'gsdgsdg', '\"sdgsdgsdg\"', '[\"mdrabbihasan610@gmail.com\",\" mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 03:05:01', '2024-04-16 03:05:01'),
(13, 'email', NULL, 'dsfgsdgsdg', '\"asdfgafgaa\"', '[\"mdrabbihasan610@gmail.com\",\" mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 03:06:51', '2024-04-16 03:06:51'),
(14, 'email', NULL, 'afasfasf', '\"asfasfasfasfasf\"', '[\"mdrabbihasan610@gmail.com\",\" mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 03:10:32', '2024-04-16 03:10:32'),
(15, 'email', NULL, 'afasfa', '\"afasfasfasfasfasfas\"', '[\"mdrabbihasan610@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 06:39:06', '2024-04-16 06:39:06'),
(16, 'email', NULL, 'afasfasfasf', '\"asfasfasfasfasfasfasfasf\"', '[\"mdrabbihasan610@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 06:40:27', '2024-04-16 06:40:27'),
(17, 'email', NULL, 'afgsafasfagagaafgaf', '\"asfafgagfa\"', '[\"mdrabbihasan610@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 06:41:52', '2024-04-16 06:41:52'),
(18, 'email', NULL, 'afgafa', '\"fafafgasfaf\"', '[\"mdrabbihasan610@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 06:44:38', '2024-04-16 06:44:38'),
(19, 'email', NULL, 'afasfafasf', '\"fafasfasfafafsasf\"', '[\"mdrabbihasan610@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 1, '2024-04-16 06:48:19', '2024-04-16 06:48:19'),
(20, 'email', NULL, 'Test cron email send', '\"Test cron email send body\"', '[\"mmix00595@gmail.com\",\" mdrabbihasan610@gmail.com\"]', NULL, NULL, 2, NULL, '[\"11407226_1417082401950136_1887148362324963047_n-4533.jpg\"]', 1, '2024-04-16 06:50:16', '2024-04-16 06:50:17'),
(21, 'email', NULL, 'Hello Dev', '\"Testing email\"', '[\"mdrabbihasan610@gmail.com\",\"mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '[\"screenshot (23)-2292.png\"]', 0, '2024-04-16 06:57:27', '2024-04-16 06:57:27'),
(22, 'email', NULL, 'Hello Dev', '\"Testing email\"', '[\"mdrabbihasan610@gmail.com\",\"mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '[\"screenshot (23)-9376.png\"]', 0, '2024-04-16 06:58:21', '2024-04-16 06:58:21'),
(23, 'email', NULL, 'Testing', '\"mdrabbihasan610@gmail.com, mmix00595@gmail.com\"', '[\"mdrabbihasan610@gmail.com\",\" mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '\"\"', 0, '2024-04-16 07:00:39', '2024-04-16 07:00:39'),
(24, 'email', NULL, 'Hello', '\"Hello\"', '[\"mdrabbihasan610@gmail.com\",\" mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '[\"whatsapp image 2024-04-16 at 12-8654.jpeg\"]', 0, '2024-04-16 07:04:02', '2024-04-16 07:04:02'),
(25, 'email', NULL, 'Test', '\"Testing\"', '[\"mdrabbihasan610@gmail.com\",\" mmix00595@gmail.com\"]', NULL, NULL, 2, NULL, '[\"whatsapp image 2024-04-16 at 12-3166.jpeg\",\"whatsapp image 2024-04-16 at 12-6771.jpeg\",\"whatsapp image 2024-04-16 at 12-5369.jpeg\"]', 1, '2024-04-16 07:05:32', '2024-04-16 07:05:32'),
(26, 'email', 1, 'Hello testing', '\"Dear, {{name}} congratulations for our application.\\r\\n                                    Thanks for,\\r\\n                                    WebLara\"', 'null', NULL, NULL, 2, 'student_code', '[\"qrcode (4)-1233.png\"]', 1, '2024-04-16 07:08:27', '2024-04-16 07:08:27'),
(27, 'email', 1, 'Testing', '\"Dear, {{name}} congratulations for our application.\\r\\n                                    Thanks for,\\r\\n                                    WebLara\"', 'null', NULL, NULL, 1, 'student_code', '[\"acknowledgement-572080569597-6885.pdf\"]', 1, '2024-04-17 06:59:14', '2024-04-17 06:59:15'),
(28, 'email', NULL, 'Testing', '\"safafasfasf\"', '[\"mdrabbihasan610@gmail.com\"]', NULL, NULL, 2, NULL, '[\"adsdsadsadsad-2377.png\"]', 2, '2024-04-23 02:45:28', '2024-04-23 02:45:59'),
(29, 'email', NULL, 'test email send', '\"Hello test email send\"', '[\"mdrabbihasan610@gmail.com\"]', NULL, NULL, 2, NULL, '[\"screenshot (62)-2665.png\"]', 2, '2024-05-12 07:49:17', '2024-05-12 01:49:48');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not default language, 1: default language',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 1, '2020-07-06 03:47:55', '2026-11-10 11:57:18');

-- --------------------------------------------------------

--
-- Table structure for table `mail_boxes`
--

CREATE TABLE `mail_boxes` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int NOT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `per_hour_limit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '40',
  `date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_code` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_events_requests`
--

CREATE TABLE `media_events_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_type` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `event_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_event_date` date DEFAULT NULL,
  `expected_attendees` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_description` longtext COLLATE utf8mb4_unicode_ci,
  `additional_services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `media_events_requests`
--

INSERT INTO `media_events_requests` (`id`, `full_name`, `company_name`, `job_title`, `email`, `phone`, `country`, `city`, `service_type`, `event_type`, `event_country`, `event_city`, `expected_event_date`, `expected_attendees`, `event_description`, `additional_services`, `attachment`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Md Rabbi Hasan', 'Developer', 'Developer', 'dev@gmail.com', '23324324', 'Bangladesh', 'Dhaka', '[\"organize_exhibition\", \"organize_institutional\"]', 'forum', 'Bangladesh', 'Dhaka', '2026-05-02', '200_500', 'Dhaka', '[\"event_marketing\", \"media_coverage\"]', 'media-events/ofUBH0cHV2bfvGj016WW8hyojXsJQ4tfCNg9JTi3.pdf', 'pending', '2026-05-02 06:49:32', '2026-05-02 06:49:32'),
(2, 'Md Rabbi Hasan', 'Developer', 'Developer', 'dev@gmail.com', '23324324', 'Bangladesh', 'Dhaka', '[\"organize_exhibition\", \"organize_institutional\"]', 'forum', 'Bangladesh', 'Dhaka', '2026-05-02', '200_500', 'Dhaka', '[\"event_marketing\", \"media_coverage\"]', 'media-events/Sk4E9ztcfKhTBDfBEq4Iew9nYBTe40ODnaq5mrIb.pdf', 'pending', '2026-05-02 07:24:41', '2026-05-02 07:24:41'),
(3, 'alaa', 'data', 'Owner', 'alaaamr153@gmail.com', '01559022852', 'Egypt', 'jgjguuyg', '[\"produce_media_content\"]', 'project_launch', 'Egypt', 'jgjguuyg', '2026-05-21', 'less_50', NULL, '[\"media_coverage\"]', NULL, 'pending', '2026-05-20 18:25:03', '2026-05-20 18:25:03'),
(4, 'alaa', 'data', 'Owner', 'alaaamr153@gmail.com', '01559022852', 'Egypt', 'jgjguuyg', '[\"organize_economic\"]', 'exhibition', 'Egypt', 'jgjguuyg', '2026-05-21', NULL, 'data', '[\"media_coverage\"]', NULL, 'pending', '2026-05-20 18:47:37', '2026-05-20 18:47:37'),
(5, 'adsadd asdasd', 'data', 'data', 'dnfjdnjnknk@dgf.com', '16511156651', 'jgjguuyg', 'jgjguuyg', '[\"manage_media_relations\"]', 'exhibition', 'jgjguuyg', 'jgjguuyg', '2026-05-20', 'less_50', 'data', '[\"video_production\"]', NULL, 'pending', '2026-05-20 18:59:37', '2026-05-20 18:59:37');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2026_11_10_190001_create_quote_requests_table', 2),
(3, '2026_11_10_190002_create_healthcare_services_table', 3),
(4, '2026_11_10_190003_create_projects_table', 4),
(5, '2026_11_10_200001_update_quote_requests_nullable_fields', 5);

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `sender` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_from` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_to` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `notification_type` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subj` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_body` text COLLATE utf8mb4_unicode_ci,
  `sms_body` text COLLATE utf8mb4_unicode_ci,
  `shortcodes` text COLLATE utf8mb4_unicode_ci,
  `email_status` tinyint(1) NOT NULL DEFAULT '1',
  `sms_status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subj`, `email_body`, `sms_body`, `shortcodes`, `email_status`, `sms_status`, `created_at`, `updated_at`) VALUES
(7, 'PASS_RESET_CODE', 'Password - Reset - Code', 'Password Reset', '<div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">{{time}} .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">{{code}}</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div>', 'Your account recovery code is: {{code}}', '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, 0, '2021-11-03 12:00:00', '2022-03-20 20:47:05'),
(8, 'PASS_RESET_DONE', 'Password - Reset - Confirmation', 'You have reset your password', '<p style=\"font-family: Montserrat, sans-serif;\">You have successfully reset your password.</p><p style=\"font-family: Montserrat, sans-serif;\">You changed from&nbsp; IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{time}}</span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><font color=\"#ff0000\">If you did not change that, please contact us as soon as possible.</font></span></p>', 'Your password has been changed successfully', '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, 1, '2021-11-03 12:00:00', '2022-04-05 03:46:35'),
(9, 'ADMIN_SUPPORT_REPLY', 'Support - Reply', 'Reply Support Ticket', '<div><p><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\">A member from our support team has replied to the following ticket:</span></span></p><p><span style=\"font-weight: bolder;\"><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\"><br></span></span></span></p><p><span style=\"font-weight: bolder;\">[Ticket#{{ticket_id}}] {{ticket_subject}}<br><br>Click here to reply:&nbsp; {{link}}</span></p><p>----------------------------------------------</p><p>Here is the reply :<br></p><p>{{reply}}<br></p></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', 'Your Ticket#{{ticket_id}} :  {{ticket_subject}} has been replied.', '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}', 1, 1, '2021-11-03 12:00:00', '2022-03-20 20:47:51'),
(10, 'EVER_CODE', 'Verification - Email', 'Please verify your email address', '<br><div><div style=\"font-family: Montserrat, sans-serif;\">Thanks For joining us.<br></div><div style=\"font-family: Montserrat, sans-serif;\">Please use the below code to verify your email address.<br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Your email verification code is:<font size=\"6\"><span style=\"font-weight: bolder;\">&nbsp;{{code}}</span></font></div></div>', '---', '{\"code\":\"Email verification code\"}', 1, 0, '2021-11-03 12:00:00', '2022-04-03 02:32:07'),
(11, 'SVER_CODE', 'Verification - SMS', 'Verify Your Mobile Number', 'Your phone verification code is: {{code}}', 'Your phone verification code is: {{code}}', '{\"code\":\"SMS Verification Code\"}', 1, 0, '2021-11-03 12:00:00', '2024-02-07 19:01:38'),
(16, 'KYC_APPROVE', 'KYC Approved', 'KYC has been approved', NULL, NULL, '[]', 1, 1, NULL, NULL),
(17, 'KYC_REJECT', 'KYC Rejected Successfully', 'KYC has been rejected', NULL, NULL, '[]', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secs` text COLLATE utf8mb4_unicode_ci,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `secs`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Home', '/', '[\"hero\",\"digital_impact\",\"who_we_help\",\"services\",\"why_choose_us\",\"process\",\"our_work\",\"cta\"]', 1, '2020-07-11 06:23:58', '2026-11-10 12:38:51'),
(36, 'About Us', 'about-us', '[\"about_hero\",\"about_approach\",\"process\",\"cta\"]', 0, '2026-04-07 07:15:25', '2026-11-10 14:00:02'),
(44, 'Our Services', 'services', '[\"services_hero\",\"services_groups\",\"cta\"]', 0, '2026-11-10 12:38:51', '2026-11-10 12:38:51'),
(45, 'Get a Quote', 'get-quote', '[\"get_quote\"]', 0, '2026-11-10 14:02:44', '2026-11-10 14:15:58'),
(47, 'Contact Us', 'contact', '[\"contact_banner\",\"contact_form\",\"contact_map\"]', 0, '2026-11-10 14:15:58', '2026-11-10 14:15:58');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('ronnie@gmail.com', '100375', '2020-07-07 05:44:47'),
('user@site.comfff', '988862', '2021-05-07 07:31:28'),
('mosta@gmail.com', '865544', '2021-06-10 09:21:05'),
('user@site.com', '727340', '2022-09-20 05:22:46'),
('xefunyj@mailinator.com', '328566', '2023-12-19 12:35:45'),
('demouser@gmail.com', '652611', '2024-02-23 21:01:42'),
('codeminion71@gmail.com', '842835', '2024-04-07 06:54:08'),
('abutaleb.bdg@gmail.com', '543546', '2024-04-17 07:47:27'),
('mhrhabib73@gmail.com', '551720', '2024-05-02 02:41:14'),
('mdrabbihasan610@gmail.com', '343126', '2024-05-12 07:57:58'),
('abutalebgmtt@gmail.com', '210657', '2024-05-12 08:04:13'),
('howidaelnagar15@gmail.com', '318827', '2024-05-12 11:06:52'),
('testing123@gmail.com', '821084', '2024-05-18 19:42:38'),
('shimantasarker504@gmail.com', '118830', '2024-05-26 08:32:36'),
('mhrhabib39@gmail.com', '338948', '2024-05-30 11:13:23'),
('mmix00595@gmail.com', '820208', '2024-06-06 04:46:34');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(170) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_name` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `live_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `slug`, `client_name`, `category`, `thumbnail`, `summary`, `live_url`, `sort_order`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'Al Shifa Specialized Medical Center', 'al-shifa-medical-center', 'Al Shifa Clinic', 'Clinic', 'assets/images/3s/work-showcase.jpg', 'Complete digital presence, patient appointment booking system, and local healthcare SEO.', '#', 1, 1, '2026-11-10 12:34:46', '2026-11-10 12:34:46');

-- --------------------------------------------------------

--
-- Table structure for table `quote_requests`
--

CREATE TABLE `quote_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_type` varchar(120) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `services` json DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quote_requests`
--

INSERT INTO `quote_requests` (`id`, `name`, `email`, `phone`, `client_type`, `services`, `message`, `status`, `admin_notes`, `ip_address`, `created_at`, `updated_at`) VALUES
(2, 'Dr. Rafiqul Islam', 'doctor@testclinic.com', '+8801700000000', 'Private Clinic', '[\"Website Design & Development\", \"Healthcare SEO & Google Ranking\"]', 'Test mobile quote submission from doctor clinic.', 'pending', NULL, '127.0.0.1', '2026-11-10 16:17:43', '2026-11-10 16:17:43');

-- --------------------------------------------------------

--
-- Table structure for table `request_orders`
--

CREATE TABLE `request_orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `form_checkbox` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `form_radio` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `form_file` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_seen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `request_orders`
--

INSERT INTO `request_orders` (`id`, `user_id`, `service_id`, `type`, `form_data`, `form_checkbox`, `form_radio`, `form_file`, `status`, `is_seen`, `created_at`, `updated_at`) VALUES
(1, 0, 8, 'BusinessSector', '{\"city\": \"Riyadh\", \"country\": \"Saudi Arabia\", \"full_name\": \"tetert\", \"job_title\": \"ertret\", \"email_address\": \"ertret@gmail.com\", \"project_field\": \"Healthcare\", \"phone_mobile_number\": \"ertert\", \"company_organization_name\": \"ertert\", \"estimated_budget_optional\": \"10,000 - 25,000 USD\", \"project_name_if_available\": \"ertert\", \"expected_project_start_date\": \"2026-04-15\", \"brief_description_of_the_project_or_technical_requirements\": \"erterte\"}', '{\"project_type\": [\"Startup Project\", \"Artificial intelligence Solutions\", \"E-commerce Store\", \"Administrative System\"], \"type_of_technology_service_required\": [\"Web Development\", \"Digital Platform Development\", \"Mobile Application Development\", \"Data Analytics\", \"Cloud Computing\"]}', '[]', '[]', 'approved', '0', '2026-04-15 11:11:41', '2026-04-15 11:12:14'),
(2, 0, 1, 'BusinessSector', '{\"full_name\":\"data\",\"company_organization_name\":\"data\",\"job_title\":\"data\",\"email_address\":\"data@mail.com\",\"phone_mobile_number\":\"16511156651\",\"country\":\"Bahrain\",\"city\":\"Madinah\",\"project_field\":\"Government Services\",\"project_name_if_available\":\"data\",\"brief_description_of_the_project_or_technical_requirements\":\"data\",\"estimated_budget_optional\":\"10,000 - 25,000 USD\",\"expected_project_start_date\":\"2026-05-29\"}', '{\"type_of_technology_service_required\":[\"Digital Platform Development\"],\"project_type\":[\"Company or Organization\"]}', '[]', '[]', 'pending', '0', '2026-05-20 17:09:37', '2026-05-20 17:09:37'),
(3, 0, 2, 'BusinessSector', '{\"full_name\":\"data\",\"company_organization_name\":\"data\",\"job_title\":\"data\",\"email_address\":\"data@mail.com\",\"phone_mobile_number\":\"16511156651\",\"country\":\"Bahrain\",\"city\":\"Madinah\",\"project_field\":\"Technology\",\"project_name_if_available\":\"data\",\"brief_description_of_the_project_or_technical_requirements\":\"data\",\"estimated_budget_optional\":null,\"expected_project_start_date\":\"2026-05-29\"}', '{\"type_of_technology_service_required\":[\"Cybersecurity\"],\"project_type\":[\"Administrative System\"]}', '[]', '[]', 'pending', '0', '2026-05-20 17:10:35', '2026-05-20 17:10:35'),
(4, 0, 3, 'BusinessSector', '{\"full_name\":\"data\",\"company_organization_name\":\"data\",\"job_title\":\"data\",\"email_address\":\"data@mail.com\",\"phone_mobile_number\":\"16511156651\",\"country\":\"Bahrain\",\"city\":\"Madinah\",\"project_field\":\"Healthcare\",\"project_name_if_available\":\"data\",\"brief_description_of_the_project_or_technical_requirements\":\"data\",\"estimated_budget_optional\":null,\"expected_project_start_date\":\"2026-05-29\"}', '{\"type_of_technology_service_required\":[\"Cloud Computing\"],\"project_type\":[\"Administrative System\"]}', '[]', '[]', 'pending', '0', '2026-05-20 17:11:31', '2026-05-20 17:11:31'),
(5, 0, 5, 'BusinessSector', '{\"full_name\":\"data\",\"company_organization_name\":\"data\",\"job_title\":\"data\",\"email_address\":\"data@mail.com\",\"phone_mobile_number\":\"16511156651\",\"country\":\"Bahrain\",\"city\":\"Madinah\",\"project_field\":\"Healthcare\",\"project_name_if_available\":\"data\",\"brief_description_of_the_project_or_technical_requirements\":\"data\",\"estimated_budget_optional\":null,\"expected_project_start_date\":\"2026-05-29\"}', '{\"type_of_technology_service_required\":[\"Cloud Computing\"],\"project_type\":[\"Startup Project\"]}', '[]', '[]', 'pending', '0', '2026-05-20 17:12:25', '2026-05-20 17:12:25');

-- --------------------------------------------------------

--
-- Table structure for table `sector_value_lists`
--

CREATE TABLE `sector_value_lists` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `val_id` bigint UNSIGNED NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sector_value_lists`
--

INSERT INTO `sector_value_lists` (`id`, `title`, `title_ar`, `service_id`, `val_id`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Improving operational efficiency', 'Improving operational efficiency', 8, 1, 'active', '2026-04-13 12:35:49', '2026-04-13 12:35:49');

-- --------------------------------------------------------

--
-- Table structure for table `sector_work_lists`
--

CREATE TABLE `sector_work_lists` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `val_id` bigint UNSIGNED NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sector_work_lists`
--

INSERT INTO `sector_work_lists` (`id`, `title`, `title_ar`, `service_id`, `val_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Preparation of engineering and  technical studies', 'Preparation of engineering and  technical studies', 8, 2, 'active', '2026-04-13 12:57:11', '2026-04-13 12:57:11');

-- --------------------------------------------------------

--
-- Table structure for table `sms_configs`
--

CREATE TABLE `sms_configs` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `config` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Daft','Active','Inactive') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_histories`
--

CREATE TABLE `sms_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Daft','Pending','Delivered','Failed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `created_at`, `updated_at`) VALUES
(1, 'bokul@gmail.com', NULL, NULL),
(2, 'asdf@gmail.com', '2024-02-12 22:21:00', '2024-02-12 22:21:00'),
(3, 'asdff@gmail.com', '2024-02-12 22:21:37', '2024-02-12 22:21:37');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_registrations`
--

CREATE TABLE `supplier_registrations` (
  `id` bigint UNSIGNED NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year_of_establishment` smallint UNSIGNED DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `responsible_person_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supply_area` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `product_description` text COLLATE utf8mb4_unicode_ci,
  `supply_scope` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `certifications` text COLLATE utf8mb4_unicode_ci,
  `commercial_registration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_profile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_catalog` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `support_message_id` int UNSIGNED DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `support_ticket_id` int UNSIGNED NOT NULL DEFAULT '0',
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `message` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT '0',
  `name` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `technology_digital_requests`
--

CREATE TABLE `technology_digital_requests` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_type` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `project_type` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_description` longtext COLLATE utf8mb4_unicode_ci,
  `estimated_budget` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expected_start_date` date DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `technology_digital_requests`
--

INSERT INTO `technology_digital_requests` (`id`, `full_name`, `company_name`, `job_title`, `email`, `phone`, `country`, `city`, `service_type`, `project_type`, `project_name`, `project_description`, `estimated_budget`, `expected_start_date`, `attachment`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Md Rabbi Hasan', 'Softech Dev', 'Developer', 'dev@gmail.com', '123445454', 'Bangladesh', 'Dhaka', '[\"Website Development\", \"Digital Platform Development\", \"Mobile Application Development\", \"Artificial Intelligence Solutions\", \"Data Analytics\", \"Cybersecurity\", \"Digital Transformation for Organizations\"]', '[\"Government Entity\", \"Online Platform\", \"E-commerce Store\", \"Administrative System\", \"Other\"]', 'Dhaka', 'Jani na', 'Less than $10,000', '2026-05-02', 'technology-digital/Xn3stcOS19UYg7VkSdjqJfFjXm1Jdn4tz2kQdkQB.pdf', 'pending', '2026-05-02 05:37:37', '2026-05-02 05:37:37'),
(2, 'data', 'data', 'data', 'data@mail.com', '16511156651', 'Angola', 'data', '[\"Artificial Intelligence Solutions\"]', '[\"Online Platform\"]', 'data', NULL, '$10,000 - $50,000', '2026-05-29', NULL, 'pending', '2026-05-20 18:11:44', '2026-05-20 18:11:44'),
(3, 'data', 'data', 'data', 'data@mail.com', '16511156651', 'Angola', 'data', '[\"Mobile Application Development\"]', NULL, 'data', 'data', 'Less than $10,000', '2026-05-29', NULL, 'pending', '2026-05-20 18:36:18', '2026-05-20 18:36:18'),
(4, 'data', 'data', 'data', 'data@mail.com', '16511156651', 'Angola', 'data', '[\"Mobile Application Development\"]', '[\"E-commerce Store\"]', 'data', 'data', 'Less than $10,000', '2026-05-29', NULL, 'pending', '2026-05-20 18:55:25', '2026-05-20 18:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message_body` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `title`, `code`, `subject`, `message_body`, `image`, `short_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Student Congratulations', 'student_code', '{{name}} congratulations', 'Dear, {{name}} congratulations for our application.\n                                    Thanks for,\n                                    WebLara\n                                    ', 'null.png', '[\"{{name}}\"]', 1, '2024-02-28 02:28:54', '2024-02-28 02:28:54'),
(2, 'Teacher Congratulations', 'teacher_code', '{{name}}  congratulations', 'Dear, {{name}} congratulations for our application.\n\n                                    Thanks for,\n                                    WebLara\n                                    ', 'null.png', '[\"{{name}}\"]', 1, '2024-02-28 02:28:54', '2024-02-28 02:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int UNSIGNED DEFAULT '0',
  `mobile` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `position_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `val_license_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: banned, 1: active',
  `ev` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: email unverified, 1: email verified',
  `sv` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: mobile unverified, 1: mobile verified',
  `profile_complete` tinyint(1) NOT NULL DEFAULT '0',
  `ver_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'stores verification code',
  `ver_code_send_at` datetime DEFAULT NULL COMMENT 'verification send time',
  `ban_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `dark_mode` tinyint(1) NOT NULL DEFAULT '0',
  `messenger_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `image`, `country_id`, `mobile`, `address`, `position_title`, `val_license_number`, `status`, `ev`, `sv`, `profile_complete`, `ver_code`, `ver_code_send_at`, `ban_reason`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `active_status`, `avatar`, `dark_mode`, `messenger_color`) VALUES
(35, 'Md Abu Taleb', 'abu2talebgmtt', 'abutalebgmtt12@gmail.com', NULL, 1, '880079325718', '{\"country\":\"Bangladesh\",\"address\":\"Chapra Mosjid\",\"state\":\"Dhaka\",\"zip\":\"1200\",\"city\":\"Dhaka\"}', 'Real estate marketer', NULL, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '$2y$12$xtLpjoBm5q80gQns7t7EA.Pa4eMYYW4CYPxwQYxoFgpEIL9aSwVLa', NULL, '2024-03-11 11:54:03', '2024-03-11 11:54:40', 0, 'avatar.png', 0, NULL),
(36, 'بسمة محمد', 'basma2024', 'basmoh2012@gmail.com', NULL, 2, '201282004745', '{\"country\":\"Egypt\",\"address\":\"\\u0645\\u0635\\u0631\",\"state\":\"\\u0627\\u0644\\u062c\\u064a\\u0632\\u0629\",\"zip\":\"12271\",\"city\":\"\\u0627\\u0644\\u062c\\u064a\\u0632\\u0629\"}', 'Real estate broker', NULL, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '$2y$12$8tDzIgw/ueGQA.rH1s2ZDO8sC2Uo/edVz3X8i08E89k7kbhche39S', 'lCDPPNCEupf1xziDsAjpsWQ2FjHlKJ40kxYU4X6RNbnYTMQ17TCRoE3aiq6I', '2024-03-11 13:08:59', '2024-03-11 13:10:48', 0, 'avatar.png', 0, NULL),
(37, 'howida', 'howida', 'howidaelnagar15@gmail.com', NULL, 66, '201050329155', '{\"address\":\"dfgfd\",\"city\":\"dfgdfg\",\"state\":\"fdgdfgdfg\",\"zip\":\"4545\"}', 'Real estate resident', NULL, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '$2y$12$Cz387mJMv2zfrdtxs8Pm9unrBX8e3bgSrjim.jhG7ePX8UyKT1/hK', 'bRtKdXSk5n1F5sX1jSTGOivUwAXPciOkr2LkaNGzPS4i6ipoT0SXxlOngJzp', '2024-03-20 08:29:08', '2024-05-12 11:09:05', 0, 'avatar.png', 0, NULL),
(41, 'codeminion2', 'codeminion2', 'codeminion712@gmail.com', NULL, 19, '01911948969', '{\"address\":\"gazipur\",\"state\":\"gazipur\",\"zip\":\"1700\",\"country\":null,\"city\":\"gazipur\"}', 'Real estate resident', NULL, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '$2y$12$D9Xf8T.CW8CLYFR.77jtSuCD0BbD5NKRk2CVz7cpniQ/RlfvhwtKq', 'nVt7lsYppEucQCGfOA0zEPnDauEHsmBl4J4RPqzHSsMN0ZiJonmJ2EghwTnM', '2024-03-20 18:53:45', '2024-04-06 01:03:29', 1, 'avatar.png', 1, 'messengerColor-2'),
(42, 'Test', 'codeminion3', 'codeminion3@gmail.com', '660cfca64d11a1712127142.png', 19, '01911948969', '{\"address\":null,\"state\":null,\"zip\":null,\"country\":null,\"city\":null}', 'Real estate resident', NULL, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '$2y$12$D9Xf8T.CW8CLYFR.77jtSuCD0BbD5NKRk2CVz7cpniQ/RlfvhwtKq', NULL, '2024-03-20 18:53:45', '2024-04-03 00:52:22', 0, 'avatar.png', 0, NULL),
(43, NULL, 'testing123', 'testing123@gmail.com', NULL, 1, '01745474857', '{\"address\":\"\",\"state\":\"\",\"zip\":\"\",\"city\":\"\"}', NULL, NULL, 1, 0, 1, 0, NULL, NULL, NULL, NULL, '$2y$12$icBbaFjJu5EkaIiNmRaQj.1GAmhW5fI7lnM2p9Guwu7ya.InlVqBO', NULL, '2024-04-02 22:58:54', '2024-04-02 22:58:54', 0, 'avatar.png', 0, NULL),
(52, NULL, 'rabbi610128', 'abutaleb.bdg@gmail.com', NULL, 1, '01710528978', '{\"address\":\"\",\"state\":\"\",\"zip\":\"\",\"city\":\"\"}', NULL, NULL, 1, 0, 1, 0, '352139', '2024-04-06 07:32:18', NULL, NULL, '$2y$12$4n8yA.Lf6LFZHxxn2a/Rl.SUkpt6DOWBhnXnYGSwj805xWcUBULYu', NULL, '2024-04-06 01:32:18', '2024-04-06 01:32:18', 0, 'avatar.png', 0, NULL),
(56, 'Transport', 'shimanta101', 'sarkershiman1ta@gmail.com', NULL, 1, '01969725808', '{\"address\":null,\"city\":null,\"state\":null,\"zip\":null}', NULL, NULL, 1, 0, 0, 0, '803203', '2024-05-05 11:27:44', NULL, NULL, '$2y$12$6nRRA0ze0dur.0l.ZNKLHef0.zysM6CS3s.60AVc8GzFipugQZ08G', NULL, '2024-05-05 09:27:44', '2024-05-12 10:16:31', 0, 'avatar.png', 0, NULL),
(57, NULL, 'zuhaira', 'gmjt@outlook.com', NULL, 198, '01282004745', '{\"address\":\"\",\"state\":\"\",\"zip\":\"\",\"city\":\"\"}', NULL, NULL, 1, 1, 0, 0, '578145', '2024-05-12 11:28:57', NULL, NULL, '$2y$12$X8QDAeAheRMrfryYaNBYjOg/dBhDzCN5gwXPY5bUTceEVBou03kwC', NULL, '2024-05-11 12:18:29', '2024-05-12 09:28:57', 0, 'avatar.png', 0, NULL),
(58, 'Md Abu Taleb', 'abutalebgmtt', 'abutalebgmtt@gmail.com', NULL, 198, '01779325718', '{\"country\":null,\"address\":\"Dhaka\",\"state\":\"Dhaka\",\"zip\":\"1229\",\"city\":\"Dhaka\"}', 'Real estate resident', NULL, 1, 1, 1, 1, NULL, NULL, NULL, NULL, '$2y$12$ZtKf8NoLKQgBdUN6obCsfeik6jcAG9J40dkWdzs.Vbg.ICmTUX7uC', NULL, '2024-05-11 14:00:11', '2024-05-12 08:04:54', 0, 'avatar.png', 0, NULL),
(64, 'shimanta', 'shimanta', 'shimantasarker504@gmail.com', NULL, 198, '01969705396', '{\"country\":null,\"address\":\"121\",\"state\":\"usa\",\"zip\":\"2213\",\"city\":\"ddsa\"}', 'Real estate marketer', '122233223', 1, 1, 1, 1, NULL, NULL, NULL, NULL, '$2y$12$O56wfrd/x.Bl9X8zRTJA3uANdI2F4r3Ba16Kn.ymYFWBmMMBp0Zx6', NULL, '2024-05-15 16:35:07', '2024-05-15 16:36:34', 0, 'avatar.png', 0, NULL),
(68, NULL, 'gmjt2024', 'basmoh2012@yahoo.com', NULL, 198, '00201282004745', '{\"address\":\"\",\"state\":\"\",\"zip\":\"\",\"city\":\"\"}', NULL, NULL, 1, 1, 1, 0, NULL, NULL, NULL, NULL, '$2y$12$oryvWJ5CFABmszzxlanc5eyhF.2LsxQOf7SL3Rs1.F9Kd/r7NuoxW', NULL, '2024-05-21 11:48:18', '2024-05-21 11:49:51', 0, 'avatar.png', 0, NULL),
(69, 'Test', 'rabbi610129', 'mmix00595@gmail.com', NULL, 1, '01710528979', '{\"address\":\"Dhaka\",\"state\":\"Dhaka\",\"zip\":\"5000\",\"country\":null,\"city\":\"Dhaka\"}', 'Real estate resident', '544545', 1, 1, 1, 1, NULL, NULL, NULL, NULL, '$2y$12$04DubIRLlmBjVWhhOkurOe6DpQRgk5HwDx5BdwUZcvUj5t.G.lQM6', NULL, '2024-05-22 12:46:03', '2024-06-06 04:47:21', 0, 'avatar.png', 0, NULL),
(73, NULL, 'rabbi6101288', 'mmix0095@gmail.com', NULL, 1, '01710528976', '{\"address\":\"\",\"state\":\"\",\"zip\":\"\",\"city\":\"\"}', NULL, NULL, 1, 0, 1, 0, '300321', '2024-05-25 12:20:59', NULL, NULL, '$2y$12$RGroNgCbEK/qYYd6GSA7JeaGjnV0c67pgh7.4KBLrqOylDPV77L2O', NULL, '2024-05-25 10:20:59', '2024-05-25 10:20:59', 0, 'avatar.png', 0, NULL),
(74, NULL, 'rabbi61012955', 'mmix005955@gmail.com', NULL, 1, '01710528970', '{\"address\":\"\",\"state\":\"\",\"zip\":\"\",\"city\":\"\"}', NULL, NULL, 1, 0, 1, 0, '790654', '2024-05-25 12:30:56', NULL, NULL, '$2y$12$QNJhvYnfBxBZYAxjwPKtFeSi.gdrnTa.cl3XyW7O0eJdSgVxXtQDS', NULL, '2024-05-25 10:30:56', '2024-05-25 10:30:56', 0, 'avatar.png', 0, NULL),
(76, NULL, 'rabbi6101g565gdf', 'mmi095@gmail.com', NULL, 1, '017105778976', '{\"address\":\"\",\"state\":\"\",\"zip\":\"\",\"city\":\"\"}', NULL, NULL, 1, 0, 1, 0, '262699', '2024-05-26 10:26:40', NULL, NULL, '$2y$12$jVml0cfbE/sk8lAuorXcwuFU7SSHGdVNLvaTb9H5W2SKfnDF6OdUC', NULL, '2024-05-26 08:26:40', '2024-05-26 08:26:40', 0, 'avatar.png', 0, NULL),
(78, NULL, 'rabbi610129dfgd', 'mmx005955@gmail.com', NULL, 1, '01710528974', '{\"address\":\"\",\"state\":\"\",\"zip\":\"\",\"city\":\"\"}', NULL, NULL, 1, 0, 1, 0, '873453', '2024-06-01 10:31:31', NULL, NULL, '$2y$12$uWm1qk1wEnrl2fwhjhLfiuLXJ1yNIhm0B6L.k2kQlkwvplEaHCT/6', NULL, '2024-06-01 08:31:31', '2024-06-01 08:31:31', 0, 'avatar.png', 0, NULL),
(82, NULL, 'asdfsd', 'dfksjdf@gmail.com', NULL, 198, '45345234452', '{\"address\":\"\",\"state\":\"\",\"zip\":\"\",\"city\":\"\"}', NULL, NULL, 1, 0, 1, 0, '656030', '2024-06-01 10:50:24', NULL, NULL, '$2y$12$BxB/1WF86/zoLOw21tbq2.mr49qHRdQ8eEnaMgxj.WLoxPh9E0ehG', NULL, '2024-06-01 08:50:24', '2024-06-01 08:50:24', 0, 'avatar.png', 0, NULL),
(83, NULL, 'safsdf', 'adfs@gmail.com', NULL, 169, '423452354', '{\"address\":\"\",\"state\":\"\",\"zip\":\"\",\"city\":\"\"}', NULL, NULL, 1, 0, 1, 0, '410129', '2024-06-01 10:52:33', NULL, NULL, '$2y$12$dJ1B63uBbC18cM26Xj1dFe1hxB2hFQ37FL36EygVy6ekCLjo3LnVi', NULL, '2024-06-01 08:52:33', '2024-06-01 08:52:33', 0, 'avatar.png', 0, NULL),
(85, 'habibur rahman', 'habib39', 'mhrhabib39@gmail.com', NULL, 198, '01774050226', '{\"country\":null,\"address\":\"fsdhfkshfls\",\"state\":\"dsfasgasg\",\"zip\":\"5345\",\"city\":\"adfsfds\"}', 'Real estate broker', '345sdgfsd', 1, 1, 1, 1, NULL, NULL, NULL, NULL, '$2y$12$FvWH70xcvNdH/LIYY9nx.etsRiFYFv96Ek2g10fen5qookJxxwc6W', NULL, '2024-06-01 09:03:31', '2024-06-01 09:04:22', 0, 'avatar.png', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_ip` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ai_requests`
--
ALTER TABLE `ai_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assistant_answer_caches`
--
ALTER TABLE `assistant_answer_caches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assistant_answer_cache_key` (`query_hash`,`lang`,`kb_version`);

--
-- Indexes for table `assistant_chunks`
--
ALTER TABLE `assistant_chunks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assistant_chunks_assistant_document_id_foreign` (`assistant_document_id`),
  ADD KEY `assistant_chunks_lang_index` (`lang`);
ALTER TABLE `assistant_chunks` ADD FULLTEXT KEY `assistant_chunks_content_fulltext` (`content`);

--
-- Indexes for table `assistant_conversations`
--
ALTER TABLE `assistant_conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assistant_conversations_uuid_unique` (`uuid`),
  ADD KEY `assistant_conversations_last_message_at_index` (`last_message_at`),
  ADD KEY `assistant_conversations_user_id_index` (`user_id`),
  ADD KEY `assistant_conversations_session_uid_index` (`session_uid`);

--
-- Indexes for table `assistant_documents`
--
ALTER TABLE `assistant_documents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assistant_documents_source_type_source_key_unique` (`source_type`,`source_key`);

--
-- Indexes for table `assistant_messages`
--
ALTER TABLE `assistant_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assistant_messages_assistant_conversation_id_id_index` (`assistant_conversation_id`,`id`),
  ADD KEY `assistant_messages_assistant_query_id_index` (`assistant_query_id`);

--
-- Indexes for table `assistant_providers`
--
ALTER TABLE `assistant_providers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assistant_providers_purpose_status_priority_index` (`purpose`,`status`,`priority`);

--
-- Indexes for table `assistant_queries`
--
ALTER TABLE `assistant_queries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assistant_queries_created_at_index` (`created_at`),
  ADD KEY `assistant_queries_status_lang_index` (`status`,`lang`),
  ADD KEY `assistant_queries_query_hash_index` (`query_hash`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_people`
--
ALTER TABLE `contact_people`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `domain_configs`
--
ALTER TABLE `domain_configs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `domain_configs_domain_unique` (`domain`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `healthcare_services`
--
ALTER TABLE `healthcare_services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `healthcare_services_slug_unique` (`slug`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mail_boxes`
--
ALTER TABLE `mail_boxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_events_requests`
--
ALTER TABLE `media_events_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `projects_slug_unique` (`slug`);

--
-- Indexes for table `quote_requests`
--
ALTER TABLE `quote_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request_orders`
--
ALTER TABLE `request_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sector_value_lists`
--
ALTER TABLE `sector_value_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sector_work_lists`
--
ALTER TABLE `sector_work_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms_configs`
--
ALTER TABLE `sms_configs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sms_configs_code_unique` (`code`);

--
-- Indexes for table `sms_histories`
--
ALTER TABLE `sms_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_registrations`
--
ALTER TABLE `supplier_registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `technology_digital_requests`
--
ALTER TABLE `technology_digital_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `templates_code_unique` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ai_requests`
--
ALTER TABLE `ai_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assistant_answer_caches`
--
ALTER TABLE `assistant_answer_caches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assistant_chunks`
--
ALTER TABLE `assistant_chunks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=782;

--
-- AUTO_INCREMENT for table `assistant_conversations`
--
ALTER TABLE `assistant_conversations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assistant_documents`
--
ALTER TABLE `assistant_documents`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=286;

--
-- AUTO_INCREMENT for table `assistant_messages`
--
ALTER TABLE `assistant_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assistant_providers`
--
ALTER TABLE `assistant_providers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assistant_queries`
--
ALTER TABLE `assistant_queries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=449;

--
-- AUTO_INCREMENT for table `contact_people`
--
ALTER TABLE `contact_people`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `domain_configs`
--
ALTER TABLE `domain_configs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=428;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `healthcare_services`
--
ALTER TABLE `healthcare_services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `mail_boxes`
--
ALTER TABLE `mail_boxes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_events_requests`
--
ALTER TABLE `media_events_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quote_requests`
--
ALTER TABLE `quote_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `request_orders`
--
ALTER TABLE `request_orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sector_value_lists`
--
ALTER TABLE `sector_value_lists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sector_work_lists`
--
ALTER TABLE `sector_work_lists`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms_configs`
--
ALTER TABLE `sms_configs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_histories`
--
ALTER TABLE `sms_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier_registrations`
--
ALTER TABLE `supplier_registrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `technology_digital_requests`
--
ALTER TABLE `technology_digital_requests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assistant_chunks`
--
ALTER TABLE `assistant_chunks`
  ADD CONSTRAINT `assistant_chunks_assistant_document_id_foreign` FOREIGN KEY (`assistant_document_id`) REFERENCES `assistant_documents` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assistant_messages`
--
ALTER TABLE `assistant_messages`
  ADD CONSTRAINT `assistant_messages_assistant_conversation_id_foreign` FOREIGN KEY (`assistant_conversation_id`) REFERENCES `assistant_conversations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

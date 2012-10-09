-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: 192.168.8.2
-- Generation Time: Aug 23, 2012 at 04:55 PM
-- Server version: 5.1.51
-- PHP Version: 5.2.9-1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cddecdatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `address1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address4` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `county` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `state` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `country` varchar(100) COLLATE utf8_unicode_ci DEFAULT '',
  `pincode` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `address1`, `address2`, `address3`, `address4`, `city`, `county`, `state`, `country`, `pincode`) VALUES
(0, '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `answer` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `question_id` int(11) NOT NULL,
  `correct_result` set('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `unhide_notes` set('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`answer_id`),
  KEY `fk_answers_question` (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=142 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answer_id`, `answer`, `question_id`, `correct_result`, `unhide_notes`) VALUES
(1, 'Yes', 1, 'N', 'N'),
(2, 'No', 1, 'Y', 'N'),
(3, 'Yes', 2, 'N', 'N'),
(4, 'No', 2, 'Y', 'N'),
(5, 'Yes', 3, 'N', 'N'),
(6, 'No', 3, 'Y', 'N'),
(7, 'Yes', 4, 'N', 'N'),
(8, 'No', 4, 'Y', 'N'),
(9, 'Yes', 5, 'Y', 'N'),
(10, 'No', 5, 'N', 'N'),
(11, 'N/A', 5, 'N', 'N'),
(12, 'Yes', 6, 'Y', 'N'),
(13, 'No', 6, 'N', 'N'),
(14, 'N/A', 6, 'N', 'N'),
(15, 'Yes', 7, 'Y', 'N'),
(16, 'No', 7, 'N', 'N'),
(17, 'N/A', 7, 'Y', 'N'),
(18, 'Yes', 8, 'Y', 'N'),
(19, 'No', 8, 'N', 'N'),
(20, 'Yes', 9, 'Y', 'N'),
(21, 'No', 9, 'N', 'N'),
(22, 'N/A', 9, 'N', 'N'),
(23, 'Yes', 10, 'Y', 'N'),
(24, 'No', 10, 'Y', 'N'),
(25, 'from addiction services?', 11, 'Y', 'N'),
(26, 'Do not supply/supply from elsewhere', 11, 'Y', 'N'),
(27, 'to doctors?', 12, 'Y', 'N'),
(28, 'to others?', 12, 'Y', 'Y'),
(29, 'Wholesalers', 13, 'Y', 'N'),
(30, 'Community Pharmacy', 13, 'Y', 'N'),
(31, 'Others', 13, 'N', 'Y'),
(32, 'Yes', 14, 'Y', 'N'),
(33, 'No', 14, 'N', 'N'),
(34, 'Yes', 15, 'N', 'N'),
(35, 'No', 15, 'Y', 'N'),
(36, 'Yes', 16, 'Y', 'N'),
(37, 'No', 16, 'N', 'N'),
(38, 'Yes', 17, 'N', 'N'),
(39, 'No', 17, 'Y', 'N'),
(40, 'Yes', 18, 'N', 'N'),
(41, 'No', 18, 'Y', 'N'),
(42, 'Yes', 19, 'N', 'N'),
(43, 'No', 19, 'Y', 'N'),
(44, 'stock CDs?', 20, 'Y', 'N'),
(45, 'patient''s own CDs?', 20, 'Y', 'N'),
(46, 'both?', 20, 'Y', 'N'),
(47, 'Yes', 21, 'Y', 'N'),
(48, 'No', 21, 'N', 'N'),
(49, 'Yes', 22, 'Y', 'N'),
(50, 'No', 22, 'N', 'N'),
(51, 'Yes', 23, 'N', 'N'),
(52, 'No', 23, 'Y', 'N'),
(53, 'Yes', 24, 'N', 'N'),
(54, 'No', 24, 'Y', 'N'),
(55, 'Yes', 25, 'N', 'N'),
(56, 'No', 25, 'Y', 'N'),
(57, 'a central store?', 26, 'Y', 'N'),
(58, 'doctors'' bags?', 26, 'Y', 'N'),
(59, 'other places?', 26, 'Y', 'N'),
(60, 'Yes', 27, 'Y', 'N'),
(61, 'No', 27, 'Y', 'N'),
(62, 'Yes', 28, 'Y', 'N'),
(63, 'No', 28, 'N', 'N'),
(64, 'Yes', 29, 'Y', 'N'),
(65, 'No', 29, 'N', 'N'),
(66, 'Yes', 30, 'N', 'N'),
(67, 'No', 30, 'Y', 'N'),
(68, 'Yes', 31, 'Y', 'N'),
(69, 'No', 31, 'N', 'N'),
(70, 'Yes', 32, 'Y', 'N'),
(71, 'No', 32, 'N', 'N'),
(72, 'N/A', 32, 'Y', 'N'),
(73, 'Yes', 33, 'Y', 'N'),
(74, 'No', 33, 'N', 'N'),
(75, 'Yes', 34, 'Y', 'N'),
(76, 'No', 34, 'N', 'N'),
(77, 'N/A', 34, 'N', 'N'),
(78, 'Yes', 35, 'Y', 'N'),
(79, 'No', 35, 'N', 'N'),
(80, 'Yes', 36, 'N', 'N'),
(81, 'No', 36, 'Y', 'N'),
(82, 'Yes', 37, 'Y', 'N'),
(83, 'No', 37, 'N', 'N'),
(84, 'Yes', 38, 'N', 'N'),
(85, 'No', 38, 'Y', 'N'),
(86, 'Yes', 39, 'Y', 'N'),
(87, 'No', 39, 'Y', 'N'),
(88, 'Yes', 40, 'Y', 'N'),
(89, 'No', 40, 'N', 'N'),
(90, 'Yes', 41, 'Y', 'N'),
(91, 'No', 41, 'N', 'N'),
(92, 'Yes', 42, 'Y', 'N'),
(93, 'No', 42, 'N', 'N'),
(94, 'Yes', 43, 'Y', 'N'),
(95, 'No', 43, 'N', 'N'),
(96, 'Yes', 44, 'Y', 'N'),
(97, 'No', 44, 'N', 'N'),
(98, 'Yes', 45, 'N', 'N'),
(99, 'No', 45, 'Y', 'N'),
(100, 'Yes', 46, 'Y', 'N'),
(101, 'No', 46, 'N', 'N'),
(102, 'Yes', 47, 'N', 'N'),
(103, 'No', 47, 'Y', 'N'),
(104, 'Yes', 48, 'N', 'N'),
(105, 'No', 48, 'Y', 'N'),
(106, 'Yes', 49, 'N', 'N'),
(107, 'No', 49, 'Y', 'N'),
(108, 'Yes', 50, 'Y', 'N'),
(109, 'No', 50, 'N', 'N'),
(110, 'Yes', 51, 'Y', 'N'),
(111, 'No', 51, 'N', 'N'),
(112, 'Free text box', 52, 'Y', 'N'),
(113, 'Yes', 53, 'Y', 'N'),
(114, 'No', 53, 'N', 'N'),
(115, 'Yes', 54, 'Y', 'N'),
(116, 'No', 54, 'N', 'N'),
(117, 'Monthly', 55, 'Y', 'N'),
(118, 'Every 1-3 months', 55, 'Y', 'N'),
(119, 'Every 3-6 months', 55, 'Y', 'N'),
(120, 'Every 6-12 months', 55, 'Y', 'N'),
(121, 'Greater than every 12 months', 55, 'Y', 'N'),
(122, 'Yes', 56, 'N', 'N'),
(123, 'No', 56, 'Y', 'N'),
(124, 'Free text box', 57, 'Y', 'N'),
(125, 'Free text box', 58, 'Y', 'N'),
(126, 'Yes', 59, 'Y', 'N'),
(127, 'No', 59, 'N', 'N'),
(128, 'Yes', 60, 'N', 'N'),
(129, 'No', 60, 'Y', 'N'),
(130, 'Yes', 61, 'N', 'N'),
(131, 'No', 61, 'Y', 'N'),
(132, 'Yes', 62, 'N', 'N'),
(133, 'No', 62, 'Y', 'N'),
(134, 'Yes', 63, 'Y', 'N'),
(135, 'No', 63, 'N', 'N'),
(136, 'Yes', 64, 'Y', 'N'),
(137, 'No', 64, 'N', 'N'),
(138, 'Yes', 65, 'Y', 'N'),
(139, 'No', 65, 'N', 'N'),
(140, 'Yes', 66, 'Y', 'N'),
(141, 'No', 66, 'Y', 'N');

-- --------------------------------------------------------


--
-- Table structure for table `declarations`
--

CREATE TABLE IF NOT EXISTS `declarations` (
  `decl_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `decl_started_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `decl_completed` set('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Y=Yes, N=No',
  `decl_completed_on` datetime DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `admin_comments` tinytext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`decl_id`),
  KEY `fk_declarations_users1` (`user_id`),
  KEY `fk_declarations_users2` (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;



-- --------------------------------------------------------

--
-- Table structure for table `declarations_arc`
--

CREATE TABLE IF NOT EXISTS `declarations_arc` (
  `decl_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `decl_started_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `decl_completed` set('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N' COMMENT 'Y=Yes, N=No',
  `decl_completed_on` datetime DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `admin_comments` tinytext COLLATE utf8_unicode_ci
) ENGINE=ARCHIVE DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



-- --------------------------------------------------------

--
-- Table structure for table `declaration_details`
--

CREATE TABLE IF NOT EXISTS `declaration_details` (
  `decl_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `decl_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `ans_id` int(11) NOT NULL,
  `prompted_comment` tinytext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`decl_detail_id`),
  UNIQUE KEY `unique_decid_qid` (`decl_id`,`question_id`,`ans_id`),
  KEY `fk_dd_declarations` (`decl_id`),
  KEY `fk_dd_questions` (`question_id`),
  KEY `fk_dd_answers` (`ans_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;


-- --------------------------------------------------------

--
-- Table structure for table `declaration_details_arc`
--

CREATE TABLE IF NOT EXISTS `declaration_details_arc` (
  `decl_detail_id` int(11) NOT NULL,
  `decl_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `ans_id` int(11) NOT NULL,
  `prompted_comment` tinytext COLLATE utf8_unicode_ci
) ENGINE=ARCHIVE DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `declaration_sections`
--

CREATE TABLE IF NOT EXISTS `declaration_sections` (
  `decl_section_id` int(11) NOT NULL AUTO_INCREMENT,
  `decl_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `user_confirmed` set('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `user_completed` set('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `confirmed_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_on` datetime DEFAULT NULL,
  PRIMARY KEY (`decl_section_id`),
  UNIQUE KEY `uniq_key` (`decl_id`,`section_id`),
  KEY `fk_decl_id` (`decl_id`),
  KEY `fk_section_id` (`section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;



-- --------------------------------------------------------

--
-- Table structure for table `declaration_sections_arc`
--

CREATE TABLE IF NOT EXISTS `declaration_sections_arc` (
  `decl_section_id` int(11) NOT NULL,
  `decl_id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `user_confirmed` set('Y','N') COLLATE utf8_unicode_ci NOT NULL,
  `user_completed` set('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `confirmed_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completed_on` datetime DEFAULT NULL
) ENGINE=ARCHIVE DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



-- --------------------------------------------------------

--
-- Table structure for table `incidentresponse`
--

CREATE TABLE IF NOT EXISTS `incidentresponse` (
  `resp_id` int(20) NOT NULL AUTO_INCREMENT,
  `inc_id` int(20) DEFAULT NULL,
  `response` text,
  `response_by` int(20) DEFAULT NULL,
  `responded_on` datetime DEFAULT NULL,
  PRIMARY KEY (`resp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;




-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE IF NOT EXISTS `incidents` (
  `inc_id` int(11) NOT NULL AUTO_INCREMENT,
  `incident` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `inc_raised_on` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `org_id` int(20) DEFAULT NULL,
  `user_anon` set('Y','N') COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'Y=Yes, N=No',
  `inc_status` set('N','R','U') COLLATE utf8_unicode_ci DEFAULT 'N' COMMENT 'N=New, R=Resolved, U=Unresolved',
  `anon_email` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desbody` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `accofficer` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lin` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linoff` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`inc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=0 ;



-- --------------------------------------------------------

--
-- Table structure for table `organisations`
--

CREATE TABLE IF NOT EXISTS `organisations` (
  `org_id` int(11) NOT NULL AUTO_INCREMENT,
  `organisation` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `povzone` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address_id` int(11) NOT NULL,
  PRIMARY KEY (`org_id`),
  KEY `fk_org_address` (`address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `organisations`
--

INSERT INTO `organisations` (`org_id`, `organisation`, `povzone`, `address_id`) VALUES
(1, 'Test Organisation', 'POV', 0);

-- --------------------------------------------------------

--
-- Table structure for table `professions`
--

CREATE TABLE IF NOT EXISTS `professions` (
  `profession_id` int(11) NOT NULL AUTO_INCREMENT,
  `profession` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`profession_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

--
-- Dumping data for table `professions`
--

INSERT INTO `professions` (`profession_id`, `profession`) VALUES
(1, 'GP - Principal'),
(2, 'GP - Employed Salaried'),
(3, 'GP - Locum'),
(4, 'GP - Registrar'),
(5, 'Doctor - Other'),
(6, 'Dentist - NHS'),
(7, 'Dentist - Private'),
(8, 'Pharmacist - Community'),
(9, 'Pharmacist - Supplementary Prescriber'),
(10, 'Pharmacist - Other'),
(11, 'Nurse - Independent Prescriber'),
(12, 'Nurse - Supplementary prescriber'),
(13, 'Nurse - Other'),
(14, 'Midwife'),
(15, 'Supplementary Prescriber - Other'),
(16, 'Paramedic'),
(17, 'Ambulance Technician'),
(18, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `section_id` int(11) NOT NULL,
  `notes_label` tinytext COLLATE utf8_unicode_ci,
  `question_tip` tinytext COLLATE utf8_unicode_ci,
  `failed_message` mediumtext COLLATE utf8_unicode_ci,
  `hide_notes` set('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `multiple` set('Y','N') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  PRIMARY KEY (`question_id`),
  KEY `fk_questions_sections` (`section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=67 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question`, `section_id`, `notes_label`, `question_tip`, `failed_message`, `hide_notes`, `multiple`) VALUES
(1, 'Are there any specific restrictions on the CD prescribing abilities of any of the healthcare professionals involved?', 1, 'Please provide further details', 'No additional information is available.', 'A medical practitioner convicted or cautioned in connection with a CD offence should report the conviction or caution to the General Medical Council (GMC), which should then report the facts and its own action to the practitioner''s employer or PCT. The GMC holds all current restrictions on a doctor''s clinical practice on the online version of the GMC Register. \r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(2, 'Have there been any patient or carer complaints* involving the prescribing of CDs? (*This includes complaints about failing to prescribe appropriate doses and/or appropriate medicines)', 1, 'Please provide further details on numbers of incidents since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Local complaint procedures, including those for NHS employees and employers should be followed as appropriate.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(3, 'Have there been any concerns expressed by colleagues, police, drugs misuse services or others about unusual, excessive or inappropriate prescribing of CDs?', 1, 'Please provide further details on concerns raised since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Copies of the PCT''s written policy and processes for raising concerns should be readily accessible to all relevant practitioners and staff to help minimise risks in the management of CDs.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(4, ' Have there been any significant events** involving the prescribing of CDs?  (**Significant event includes any incident where a patient is harmed or nearly harmed and includes ''near misses'', when things almost go wrong)', 1, 'Please provide further details of significant events since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Risk management systems should be used to help minimise risks in the management of CDs. Such systems should be written and readily accessible to all relevant practitioners and staff. They should include the following: Recording of critical incidents, errors and near misses with CDs through local systems and the confidential National Reporting and Learning System from the NPSA.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.  In analysing the reasons underlying an event and determining next steps the NPSA Incident Decision Tree will be helpful in many cases', 'N', 'N'),
(5, 'Are you using the correct prescription forms?', 1, NULL, 'No additional information is available.', NULL, 'N', 'N'),
(6, 'Are your spare prescription pads and blanks locked away?', 1, NULL, 'No additional information is available.', NULL, 'N', 'N'),
(7, 'After clinic are the prescription pads locked away at night?', 1, NULL, 'No additional information is available.', NULL, 'N', 'N'),
(8, 'Do you have a record of the batch numbers of all prescriptions?', 1, NULL, 'No additional information is available.', NULL, 'N', 'N'),
(9, 'Are staff aware of what they should do if they suspect that some prescriptions have gone missing?', 1, NULL, 'No additional information is available.', NULL, 'N', 'N'),
(10, 'Do you supply CDs to addicts?', 2, 'Please provide further details:', 'No additional information is available.', NULL, 'N', 'N'),
(11, 'Do you supply CDs against private prescriptions:', 2, 'Please provide further details:', 'No additional information is available.', NULL, 'Y', 'Y'),
(12, 'Do you supply controlled drugs:', 2, 'Please provide further details:', 'No additional information is available.', NULL, 'Y', 'Y'),
(13, 'From where do you obtain your stocks of CDs?', 2, 'Please provide further details:', 'No additional information is available.', NULL, 'Y', 'Y'),
(14, 'Do you provide advice to patients on the safekeeping and disposal of unwanted CDs?', 2, '', 'No additional information is available.', 'General information: To support patients and the public with information about the legal status of a CD, the NHS Choices website contains some general information that could be provided directly to the public. The text defines a CD in legal terms, how the regulations apply to them and directs patients to information about requirements for travelling abroad', 'N', 'N'),
(15, 'Are patient returned medicines ever re-used?', 2, NULL, 'No additional information is available.', 'Patient-returned controlled drugs must never be reused.  ''Patient-returned'' CDs are those that have been prescribed for, and dispensed to, a named patient, and then returned unused, or part-used, for destruction.  Legal framework: Controlled Drugs (Supervision of Management and Use) Regulations 2006 require SOPs to be in place for maintaining a record of Schedule 2 drugs that have been returned by patients.  Although it is not a legal requirement to witness destruction of returned CDs by an authorised witness, good practice would recommend that they are witnessed by another member of staff and the signature of both the person witnessing and the person destroying should be entered in the separate book set aside for this purpose.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(16, 'Are patient information leaflets supplied to all patients receiving CDs?', 2, NULL, 'No additional information is available.', 'Note:As with all dispensed medicinal products (except unlicensed medicines), it is a legal requirement to provide a manufacturer''s patient information leaflet when medicines are dispensed.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(17, 'Have there been any patient or carer complaints involving the supply of CDs?', 2, 'Please provide further details on number & nature of complaints since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Local complaint procedures, including those for NHS employees and employers should be followed as appropriate.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised. \r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(18, 'Have there been any concerns expressed by colleagues, police, drugs misuse services or others about the supply of CDs from the organisation/pharmacy?', 2, 'Please provide further details on number & nature of concerns since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Copies of the PCT''s written policy and processes for raising concerns should be readily accessible to all relevant practitioners and staff to help minimise risks in the management of CDs.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(19, 'Have there been any significant events* involving the supply of CDs? *Significant event includes any incident where a patient is harmed or nearly harmed and includes ''near misses'', when things almost go wrong.', 2, 'Please provide further details on number & nature of concerns since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Risk management systems should be used to help minimise risks in the management of CDs. Such systems should be written and readily accessible to all relevant practitioners and staff. They should include the following: Recording of critical incidents, errors and near misses with CDs through local systems and the confidential National Reporting and Learning System from the NPSA.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.  In analysing the reasons underlying an event and determining next steps the NPSA Incident Decision Tree will be helpful in many cases.\r\n\r\nwww.npsa.nhs.uk/patientsafety/ improvingpatientsafety/ incidentdecisiontree/\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(20, 'Are the CDs used for administration:', 3, '', 'No additional information is available.', '', 'N', 'N'),
(21, 'Do you maintain records of administration?', 3, 'Please give details of where? (Register, MAR chart etc). If not, what risk management policies are in place to cover administration?  Please give details.', 'No additional information is available.', 'Good Practice: Depending on the environment of care that the patient is in, a record of each administration should be kept in the relevant patient clinical notes. This record should specify the date, time, strength, presentation and form of administration, dose administered as well as the name and occupation of the person administering it.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/controlled_drugs_third_edition.pdf', 'N', 'N'),
(22, 'Is administration of CDs witnessed?', 3, '', 'No additional information is available.', 'Good Practice: Except in exceptional circumstances, the person prescribing the CD should not also personally undertake all of the following tasks: preparation, dispensing, transportation and administration of the CD. For safety reasons it is always good practice to ensure that wherever possible another appropriate competent individual is involved in, and thus can reflect on, the process. NMC Guidance for Nurses recommended that for the administration of controlled drugs a secondary signatory is required within secondary care and similar healthcare settings.  In care homes providing personal care, CDs should be administered by appropriately trained care staff, and this should be witnessed by another appropriate member of staff.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(23, 'Have there been any patient or carer complaints involving the administration of CDs?', 3, 'Please provide further details on number & nature of complaints since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Local complaint procedures, including those for NHS employees and employers should be followed as appropriate.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(24, 'Have there been any concerns expressed by colleagues, police, drugs misuse services or others about the administration of CDs?', 3, 'Please provide further details on number & nature of concerns since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Copies of the PCT''s written policy and processes for raising concerns should be readily accessible to all relevant practitioners and staff to help minimise risks in the management of CDs.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(25, 'Have there been any significant events* involving the administration of CDs? *Significant event includes any incident where a patient is harmed or nearly harmed and includes ''near misses'', when things almost go wrong.', 3, 'Please provide further details on number & nature of significant events since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Risk management systems should be used to help minimise risks in the management of CDs. Such systems should be written and readily accessible to all relevant practitioners and staff. They should include the following: Recording of critical incidents, errors and near misses with CDs through local systems and the confidential National Reporting and Learning System from the NPSA.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.  In analysing the reasons underlying an event and determining next steps the NPSA Incident Decision Tree will be helpful in many cases\r\n\r\nwww.npsa.nhs.uk/patientsafety/ improvingpatientsafety/ incidentdecisiontree/\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(26, 'Do you store CDs in:', 4, 'Please provide further details:', 'No additional information is available.', '''Doctor''s bag'': Where a practitioner carries a bag containing CDs for home visits, etc., a separate CDR must be kept for the CD stock held within that bag. Each doctor is responsible for the receipt and supply of CDs from their own bag. Restocking of the bag from practice stock should be witnessed by another member of the practice staff, as should the appropriate entries into the practice''s CDR. The Regulations also require that in other settings the CDs to which the provisions apply should be kept in a locked receptacle that can only by accessed by the person authorised to possess them (or a person authorised by that person to access them). All Schedule 2 and some Schedule 3 CDs (buprenorphine, diethylproprion, flunitrazepam and temazepam) should be stored securely in accordance with the Safe Custody Regulations. These Regulations state that such CDs must be stored in a cabinet or safe, locked with a key. It should be made of metal, with suitable hinges and fixed to a wall or the floor with rag bolts that are not accessible from outside the cabinet.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/controlled_drugs_third_edition.pdf', 'N', 'Y'),
(27, 'Do you have any current Chief Constable exemption certificates in operation for your CD storage facilities?(NB Not all premises will need exemption certificates for CD storage facilities)', 4, '', 'No additional information is available.', '', 'N', 'N'),
(28, 'Are all CDs kept under lock and key (including patient returned CDs or unwanted/obsolete CDs)?', 4, '', 'No additional information is available.', 'In residential and healthcare settings (including GP surgeries) it is recommended that the specifications of cabinets and safes set out in Schedule 2 of the Safe Custody Regulations should be regarded as a minimum standard for the storage of CDs. This is good practice rather than legislation. The Regulations also require that in other settings CDs to which the provisions apply should be kept in a locked receptacle that can only by accessed by the person authorised to possess them (or a person authorised by that person to access them). All Schedule 2 and some Schedule 3 CDs (buprenorphine, diethylproprion, flunitrazepam and temazepam) should be stored securely in accordance with the Safe Custody Regulations. These Regulations state that such CDs must be stored in a cabinet or safe, locked with a key. It should be made of metal, with suitable hinges and fixed to a wall or the floor with rag bolts that are not accessible from outside the cabinet.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(29, 'Is access to CDs controlled?', 4, 'If yes, then how?', 'No additional information is available.', 'The Regulations also require that in other settings the CDs to which the provisions apply should be kept in a locked receptacle that can only by accessed by the person authorised to possess them (or a person authorised by that person to access them). All Schedule 2 and some Schedule 3 CDs (buprenorphine, diethylproprion, flunitrazepam and temazepam) should be stored securely in accordance with the Safe Custody Regulations. These Regulations state that such CDs must be stored in a cabinet or safe, locked with a key. It should be made of metal, with suitable hinges and fixed to a wall or the floor with rag bolts that are not accessible from outside the cabinet.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(30, 'Do you utilise the CD storage facilities for storage of anything other than CDs? ', 4, 'If yes, please give further details:', 'No additional information is available.', 'Good Practice: If a safe is used to store CDs, then there should be a separate receptacle within the safe that keeps the CDs apart from other items, e.g. money, valuables etc. Nothing should be displayed outside to indicate that CDs are kept within the container. Other drugs that are liable to misuse can be locked in the container if this is deemed appropriate by the relevant healthcare professional.', 'N', 'N'),
(31, 'Does date checking of CD stock take place?', 4, 'If yes, how often:', 'No additional information is available.', '', 'N', 'N'),
(32, 'Does date checking of CD stock in doctors'' bags take place? (where applicable)', 4, 'If yes, how often:', 'No additional information is available.', '', 'N', 'N'),
(33, 'Are all stock CDs kept in the original container? ', 4, '', 'No additional information is available.', '', 'N', 'N'),
(34, 'Are dispensed patients'' medicines appropriately labelled?', 4, '', 'No additional information is available.', '', 'N', 'N'),
(35, 'Are different strengths of the same medicine segregated in any way?', 4, '', 'No additional information is available.', '', 'N', 'N'),
(36, 'Do you have out of date or obsolete stock CDs currently stored?', 4, '', 'No additional information is available.', '', 'N', 'N'),
(37, 'Are out of date/obsolete/patient returned CDs segregated from other CDs?', 4, '', 'No additional information is available.', '', 'N', 'N'),
(38, 'Are patient returned medicines ever reused?', 4, '', 'No additional information is available.', 'Patient-returned controlled drugs must never be reused. ''Patient-returned'' CDs are those that have been prescribed for, and dispensed to, a named patient, and then returned unused, or part-used, for destruction. Legal framework: Controlled Drugs (Supervision of Management and Use) Regulations 2006 require SOPs to be in place for maintaining a record of Schedule 2 drugs that have been returned by patients. Although it is not a legal requirement to witness destruction of returned CDs by an authorised witness, good practice would recommend that they are witnessed by another member of staff and the signature of both the person witnessing and the person destroying should be entered in the separate book set aside for this purpose.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(39, 'Do you transport or are you responsible for the transport of CDs (this includes sending CDs using third party carriers such as delivery drivers and postal system)? ', 5, '', 'No additional information is available.', '', 'Y', 'N'),
(40, 'Do you have a procedure in place for the transport of CDs?', 5, '', 'No additional information is available.', 'Legal framework: All healthcare professionals in legal possession of a CD have a professional duty of care to take all reasonable steps to maintain safe custody of that CD at all times.Legal requirements Regulations made under the Health Act 2006 require each healthcare organisation to have SOPs for the use and management of CDs. Such systems should be written and readily accessible to all relevant practitioners and staff. They should include the following: Security in relation to storage, and transportation, of CDs as required by Misuse of Drugs legislation.  Good Practice: Healthcare professionals involved in the delivery of patient care should not routinely transport a patient''s own CDs to and from that patient''s home. Where this is essential, part of an organised service, or where pharmacies operate collection and delivery schemes to the household and other needy patients, it is good practice to keep CDs out of view during transit.  CDs should not generally be transported via mail, taxi services or equivalent. However, in exceptional circumstances, where urgent clinical need dictates, dispensed CDs can be sent to a patient, or stock CDs to premises, via such routes. Where the mail route is used, the CD should always be sent as a special delivery item to ensure the pathway is auditable.  Information on personal security measures is available in the NHS CFSMS document ''Not Alone – A guide for the better protection of lone workers in the NHS'' at www.nhsbsa.nhs.uk/security\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'Y', 'N'),
(41, 'Are CDs routinely kept under lock and key during transport?', 5, 'Please give further details:', 'No additional information is available.', 'Legal framework: All healthcare professionals in legal possession of a CD have a professional duty of care to take all reasonable steps to maintain safe custody of that CD at all times. Legal requirements Regulations made under the Health Act 2006 require each healthcare organisation to have SOPs for the use and management of CDs. Such systems should be written and readily accessible to all relevant practitioners and staff. They should include the following: Security in relation to storage, and transportation, of CDs as required by Misuse of Drugs legislation.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf ', 'N', 'N'),
(42, 'Are records maintained of CDs in transport?', 5, 'Please give further details:', 'No additional information is available.', 'Legal framework: All healthcare professionals in legal possession of a CD have a professional duty of care to take all reasonable steps to maintain safe custody of that CD at all times. Legal requirements Regulations made under the Health Act 2006 require each healthcare organisation to have SOPs for the use and management of CDs. Such systems should be written and readily accessible to all relevant practitioners and staff. They should include the following: Security in relation to storage, and transportation, of CDs as required by Misuse of Drugs legislation.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf ', 'N', 'N'),
(43, 'Do you keep an up to date CD register?', 6, '', 'No additional information is available.', 'A record of all Schedule 2 controlled drugs obtained and supplied must be kept in a register, the form of which must comply with the relevant regulations.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(44, 'Do you keep running balances of stock CDs held?', 6, '(a) Do you audit your running totals? (State how often and date of last audit)\r\n(b) Are the running totals audited by outside management staff (area/regional managers)? (State how often and date of last audit)', 'No additional information is available.', 'Good Practice: Any person or organisation that holds stocks of CDs should keep stock levels to a minimum but enough to meet clinical need. CD usage, for example, over the last 2 years, should be reviewed when assessing current stock requirements. The level of stock held should then be reviewed on an appropriate/annual basis.  Requisitions and invoices for CDs should ideally be kept for longer than the mandatory 2 years, as cases often come to court at a much later date, by which time any evidence would have been destroyed.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(45, 'Have you identified any discrepancies between running totals and actual CDs held in the last 12 months?', 6, 'If yes, what was the explanation for the discrepancy?  What action was taken?', 'No additional information is available.', '', 'N', 'N'),
(46, 'Do you maintain records of all receipts and supplies of CDs?', 6, 'If yes, for how long do you keep records?', 'No additional information is available.', 'Good Practice: Requisitions and invoices for CDs should ideally be kept for longer than the mandatory 2 years, as cases often come to court at a much later date, by which time any evidence would have been destroyed. A dedicated requisition form is now available (FP10CDF) which it is good practice to use. These forms are available from the PCT or the agency which supplies prescription forms on behalf of the PCT. However, there is no legal requirement to use this form.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(47, 'Have there been any patient or carer complaints involving the storage, transport or record keeping of CDs?', 6, 'Please provide further details on number & nature of complaints since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Local complaint procedures, including those for NHS employees and employers should be followed as appropriate.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(48, 'Have there been any concerns expressed by colleagues, police, drugs misuse services or others about the storage, transport or record keeping of CDs?', 6, 'Please provide further details on number & nature of concerns since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Copies of the PCT''s written policy and processes for raising concerns should be readily accessible to all relevant practitioners and staff to help minimise risks in the management of CDs.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(49, 'Have there been any significant events* involving the storage, transport or record keeping of CDs? *Significant event includes any incident where a patient is harmed or nearly harmed and includes ''near misses'', when things almost go wrong.', 6, 'Please provide further details on number & nature of concerns since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Risk management systems should be used to help minimise risks in the management of CDs. Such systems should be written and readily accessible to all relevant practitioners and staff. They should include the following: Recording of critical incidents, errors and near misses with CDs through local systems and the confidential National Reporting and Learning System from the NPSA.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.  In analysing the reasons underlying an event and determining next steps the NPSA Incident Decision Tree will be helpful in many cases\r\n\r\nwww.npsa.nhs.uk/patientsafety/ improvingpatientsafety/ incidentdecisiontree/ \r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(50, 'Do you keep records of CDs returned to you by patients for disposal (where applicable)?', 7, '', 'No additional information is available.', 'Patient-returned controlled drugs must never be reused.  ''Patient-returned'' CDs are those that have been prescribed for, and dispensed to, a named patient, and then returned unused, or part-used, for destruction.  Legal framework: Controlled Drugs (Supervision of Management and Use) Regulations 2006 require SOPs to be in place for maintaining a record of Schedule 2 drugs that have been returned by patients.  Although it is not a legal requirement to witness destruction of returned CDs by an authorised witness, good practice would recommend that they are witnessed by another member of staff and the signature of both the person witnessing and the person destroying should be entered in the separate book set aside for this purpose.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(51, 'Do you routinely destroy patients'' old or obsolete CDs?', 7, '', 'No additional information is available.', '', 'N', 'N'),
(52, 'What systems do you have in place to dispose of patients'' old or obsolete controlled drugs?', 7, '', 'No additional information is available.', '', 'N', 'N'),
(53, 'Is the destruction of patients'' old or obsolete CDs witnessed?', 7, '', 'No additional information is available.', 'Although it is not a legal requirement to witness destruction of returned CDs by an authorised witness, good practice would recommend that they are witnessed by another member of staff and the signature of both the person witnessing and the person destroying should be entered in the separate book set aside for this purpose.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(54, 'Do you keep records of the destruction of patients'' old or obsolete CDs?', 7, '', 'No additional information is available.', 'Although it is not a legal requirement to witness destruction of returned CDs by an authorised witness, good practice would recommend that they are witnessed by another member of staff and the signature of both the person witnessing and the person destroying should be entered in the separate book set aside for this purpose.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(55, 'How often do you aim to destroy out of date or obsolete stock CDs?', 8, '', 'No additional information is available.', '', 'Y', 'N'),
(56, 'Do you have any out of date or obsolete stock CDs currently awaiting destruction?', 8, '', 'No additional information is available.', '', 'Y', 'N'),
(57, 'Who usually witnesses your stock destruction?', 8, '', 'No additional information is available.', '', 'N', 'N'),
(58, 'When was the last-witnessed CD stock destruction?', 8, '', 'No additional information is available.', '', 'N', 'N'),
(59, 'Are records of stock destruction kept in the CD register?', 8, '', 'No additional information is available.', 'The term ''stock'' refers to CDs that have not been issued/dispensed to a patient.  Those healthcare professionals and service providers required by law to maintain a CDR are not allowed to destroy expired Schedule 2 (or 1) CDs, from their stock, without destruction being witnessed by an authorised person.  If CDs kept in a bag for home visits, etc. expire, they should be returned to the central practice stock for future destruction in the presence of an authorised individual. If the practice does not hold central stock, then the CDs need to be destroyed directly from the bag, witnessed by an authorised individual and appropriate records made in the CDR. When a CD is destroyed, details of the destruction must be recorded. This should include: the name of the drug; form; strength and quantity; the date it was destroyed; and the signature of the authorised person who witnessed the destruction and the professional destroying it (i.e. two signatures).  Only certain individuals are authorised to witness CD destructions.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'Y', 'N'),
(60, 'Have there been any patient or carer complaints involving the destruction or disposal of CDs?', 8, 'Please provide further details on number & nature of complaints since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Local complaint procedures, including those for NHS employees and employers should be followed as appropriate.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.   Ref: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(61, 'Have there been any concerns expressed by colleagues, police, drugs misuse services or others about the destruction or disposal of CDs?', 8, 'Please provide further details on number & nature of concerns since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Copies of the PCT''s written policy and processes for raising concerns should be readily accessible to all relevant practitioners and staff to help minimise risks in the management of CDs.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(62, 'Have there been any significant events* involving the destruction or disposal of CDs? *Significant events includes any incident where a patient is harmed or nearly harmed and include ''near misses'', when things almost go wrong.', 8, 'Please provide further details on number & nature of concerns since the last declaration:', 'No additional information is available.', 'Managers, staff and healthcare professionals should know which member of staff at the PCT to contact if they have a concern regarding the performance or practice of healthcare professionals, or their staff, involving CDs. This would normally be the AO.  Risk management systems should be used to help minimise risks in the management of CDs. Such systems should be written and readily accessible to all relevant practitioners and staff. They should include the following: Recording of critical incidents, errors and near misses with CDs through local systems and the confidential National Reporting and Learning System from the NPSA.  It is a requirement [Reg 17 (2)(g)] on PCT AOs that the LIN has a process for establishing an incident panel if serious concerns are raised.  In analysing the reasons underlying an event and determining next steps the NPSA Incident Decision Tree will be helpful in many cases\r\n\r\nwww.npsa.nhs.uk/patientsafety/ improvingpatientsafety/ incidentdecisiontree/\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'N', 'N'),
(63, 'Do you have written standard operating procedures or written policies covering the handling and management of CDs, appropriate to the activities carried out at the premises?', 9, NULL, 'No additional information is available.', 'Regulations made under the Health Act 2006 require each healthcare organisation to have SOPs for the use and management of CDs. The regulations require AOs to ensure that their organisation and those providing services to the organisation has adequate and up-to-date SOPs in relation to the use of CDs.\r\nThe Regulations state that SOPs must cover the following:\r\n• Who has access to CDs\r\n• Where the CDs are stored\r\n• Security in relation to storage, and transportation, of CDs as required by Misuse of Drugs legislation\r\n• Disposal and destruction of CDs\r\n• Who is to be alerted if complications arise\r\n• Record keeping including:\r\n- Maintaining relevant CDRs under Misuse of Drugs legislation\r\n- Maintaining a record of Schedule 2 drugs that have been returned by patients                        \r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'Y', 'N'),
(64, 'Do you have in place a local procedure for dealing with a significant event* involving CDs? *Significant event includes any incident where a patient is harmed or nearly harmed and includes near misses, when things almost go wrong.', 9, NULL, 'No additional information is available.', 'Regulations made under the Health Act 2006 require each healthcare organisation to have SOPs for the use and management of CDs. The regulations require AOs to ensure that their organisation and those providing services to the organisation has adequate and up-to-date SOPs in relation to the use of CDs.\r\nThe Regulations state that SOPs must cover the following:\r\n• Who has access to CDs\r\n• Where the CDs are stored\r\n• Security in relation to storage, and transportation, of CDs as required by Misuse of Drugs legislation\r\n• Disposal and destruction of CDs\r\n• Who is to be alerted if complications arise\r\n• Record keeping including:\r\n- Maintaining relevant CDRs under Misuse of Drugs legislation\r\n- Maintaining a record of Schedule 2 drugs that have been returned by patients\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'Y', 'N'),
(65, 'Do you have appropriate procedures for the initial and continuing training or development of all staff involved in the prescribing, handling, supply and administration of CDs?', 9, NULL, 'No additional information is available.', 'Risk management systems should be used to help minimise risks in the management of CDs. Such systems should be written and readily accessible to all relevant practitioners and staff. They should include the following:\r\n• Assessment of risks arising from managing CDs\r\n• Procedures for training new members of staff or locums in management of CDs\r\n\r\nRef: http://www.npci.org.uk/cd/public/docs/\r\ncontrolled_drugs_third_edition.pdf', 'Y', 'N'),
(66, 'Are there any special factors which influence the prescribing or use of CDs by your organisation?', 9, 'If yes, please give details:', 'No additional information is available.', NULL, 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_desc` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_desc`) VALUES
(1, 'Administrator'),
(2, 'Lead Administrator'),
(3, 'Assistant Administrator'),
(4, 'Individual Practitioner'),
(5, 'Provider Accountable Officer');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `section_code` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `section_name` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `user_confirmation_text` tinytext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`section_id`, `section_code`, `section_name`, `user_confirmation_text`) VALUES
(1, '1', 'Section 1 - Prescribing', 'Do you prescribe controlled drugs? (NHS or Private)'),
(2, '2', 'Section 2 - Supply', 'Do you supply/dispense controlled drugs? (NHS or Private) '),
(3, '3', 'Section 3: Administration', 'Do you administer CDs? (or supervise or assist patients'' own administration?)'),
(4, '4A', 'Section 4A: Security or safe custody', 'Do you hold stock CDs either on the premises or off site?'),
(5, '4B', 'Section 4B: Security and safe custody in transport', 'Do you transport controlled drugs?'),
(6, '4C', 'Section 4C: Registers', 'Do you maintain a register to keep records of the CDs?'),
(7, '5A', 'Section 5A: Destruction or disposal', 'Do you destroy CDs returned by patients?'),
(8, '5B', 'Section 5B: Stock CDs', 'Do you dispose CDs which are expired?'),
(9, '6', 'General', 'This is mandatory section. Recommended to complete. Do you want to complete?');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_password` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `user_fname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_lname` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_registered_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_last_logged_on` datetime DEFAULT NULL,
  `profession_id` int(11) DEFAULT NULL,
  `prn` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `org_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `address_id` int(11) DEFAULT NULL,
  `user_salutation` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `gppcode` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `consortia` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imported` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `unique_email_id` (`email`),
  KEY `fk_users_address` (`address_id`),
  KEY `fk_users_organisations` (`org_id`),
  KEY `fk_users_professions` (`profession_id`),
  KEY `fk_users_roles` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_fname`, `user_lname`, `phone`, `email`, `user_registered_on`, `user_last_logged_on`, `profession_id`, `prn`, `org_id`, `role_id`, `address_id`, `user_salutation`, `active`, `gppcode`, `consortia`, `imported`) VALUES
(0, 'siteadmin', 'e74d23e1dc81a4940393c22973763cf7ddb95f08', 'Site', 'Admin', '3939393939339', 'siteadmin@myorg.org', '2012-01-20 19:15:27', '2012-08-19 22:48:18', 1, NULL, 1, 1, 1, '', 1, NULL, NULL, 0);
--
-- Constraints for dumped tables
--

--
-- Constraints for table `declaration_details`
--
ALTER TABLE `declaration_details`
  ADD CONSTRAINT `fk_dd_declarations` FOREIGN KEY (`decl_id`) REFERENCES `declarations` (`decl_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `declaration_sections`
--
ALTER TABLE `declaration_sections`
  ADD CONSTRAINT `declaration_sections_ibfk_5` FOREIGN KEY (`decl_id`) REFERENCES `declarations` (`decl_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

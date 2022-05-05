--
-- Database: `sager`
--

-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `sager`;
USE `sager`;

CREATE TABLE `lic_alerts` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `certificat_id` int(11) DEFAULT NULL,
  `label_id` int(11) DEFAULT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `period_id` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_article` (
  `id` int(11) NOT NULL,
  `slug` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `view` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `thumbnail_base_url` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnail_path` varchar(1024) COLLATE utf8_unicode_ci DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `updater_id` int(11) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `published_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `lic_article_attachment` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `base_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `lic_article_category` (
  `id` int(11) NOT NULL,
  `slug` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci,
  `parent_id` int(11) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `lic_certificates` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `added` datetime DEFAULT NULL,
  `expire` date DEFAULT NULL,
  `valable` varchar(10) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `modify_by` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `comments` text,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `lic_certificates_attach` (
  `id` int(11) NOT NULL,
  `certificat_id` int(11) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_certificates_types` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_certificates_types_items` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `lic_cities` (
  `id` int(11) NOT NULL,
  `title_en` varchar(60) CHARACTER SET latin1 NOT NULL,
  `title_fr` varchar(60) CHARACTER SET latin1 NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_companies` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `adress` text,
  `phone` varchar(18) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `description` longtext,
  `sender_name` varchar(18) DEFAULT NULL,
  `sender_email` varchar(50) DEFAULT NULL,
  `alert_email` int(1) DEFAULT NULL,
  `alert_sms` int(1) DEFAULT NULL,
  `alert_default` int(1) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `sms_time` time DEFAULT NULL,
  `shared` int(1) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `last_modify` datetime DEFAULT NULL,
  `locale` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_countries` (
  `id` int(11) NOT NULL,
  `code` varchar(3) NOT NULL,
  `title_en` varchar(150) NOT NULL,
  `title_fr` varchar(150) NOT NULL,
  `phonecode` int(11) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_file_storage_item` (
  `id` int(11) NOT NULL,
  `component` varchar(255) NOT NULL,
  `base_url` varchar(1024) NOT NULL,
  `path` varchar(1024) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `upload_ip` varchar(15) DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_i18n_message` (
  `id` int(11) NOT NULL,
  `language` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `translation` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `lic_key_storage_item` (
  `key` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `updated_at` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `lic_labels` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_notifications` (
  `id` int(11) NOT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `subject_en` varchar(255) DEFAULT NULL,
  `subject_fr` varchar(255) DEFAULT NULL,
  `text_en` longtext,
  `text_fr` longtext,
  `added` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_page` (
  `id` int(11) NOT NULL,
  `slug` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `view` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `lic_payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `payment_cycle` varchar(12) NOT NULL DEFAULT 'month',
  `payer_id` varchar(40) DEFAULT NULL,
  `payment_id` varchar(255) NOT NULL,
  `payment_state` varchar(20) NOT NULL,
  `payment_amount` double DEFAULT NULL,
  `payment_currency` char(3) DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `invoice_number` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `payer_email` varchar(60) DEFAULT NULL,
  `payer_first_name` varchar(40) DEFAULT NULL,
  `payer_last_name` varchar(40) DEFAULT NULL,
  `payer_phone` varchar(40) DEFAULT NULL,
  `payer_country_code` char(2) DEFAULT NULL,
  `plan_user_limit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_periods` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `days` int(11) DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `position` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `lic_phrases` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `title_ru` text NOT NULL,
  `title_en` text NOT NULL,
  `title_ro` text NOT NULL,
  `title_fr` varchar(255) NOT NULL,
  `title_de` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_plan` (
  `id` int(11) NOT NULL,
  `plan_slug` char(32) NOT NULL,
  `plan_title` varchar(255) NOT NULL,
  `plan_price_year` double DEFAULT NULL,
  `plan_price_month` double DEFAULT NULL,
  `plan_doc_limit` int(11) DEFAULT NULL,
  `plan_user_limit` int(11) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_products` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `cod` varchar(255) DEFAULT NULL,
  `title_en` varchar(255) DEFAULT NULL,
  `title_fr` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `certificat_id` int(11) DEFAULT NULL,
  `lot` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_rbac_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `lic_rbac_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `lic_rbac_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `lic_rbac_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `lic_reminders` (
  `id` int(11) NOT NULL,
  `certificat_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `certificat_type` int(11) DEFAULT NULL,
  `notification_id` int(11) DEFAULT NULL,
  `alert_id` int(11) DEFAULT NULL,
  `date_alert` datetime DEFAULT NULL,
  `last_send` datetime DEFAULT NULL,
  `days` int(11) DEFAULT NULL,
  `expire` datetime DEFAULT NULL,
  `label_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `comment` longtext,
  `group` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_settings` (
  `id` int(11) NOT NULL,
  `section` varchar(255) NOT NULL,
  `settings_key` varchar(255) NOT NULL,
  `settings_value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_states` (
  `id` int(11) NOT NULL,
  `title_en` varchar(60) NOT NULL,
  `title_fr` varchar(60) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `lic_subscription` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `plan_cycle` varchar(12) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'month',
  `purchased_at` int(11) NOT NULL,
  `start_at` int(11) DEFAULT NULL,
  `end_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `lic_system_db_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lic_system_log` (
  `id` bigint(20) NOT NULL,
  `level` int(11) DEFAULT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `log_time` double DEFAULT NULL,
  `prefix` text COLLATE utf8_unicode_ci,
  `message` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
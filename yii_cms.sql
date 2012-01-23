-- phpMyAdmin SQL Dump
-- version 3.3.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 25, 2011 at 07:31 PM
-- Server version: 5.1.54
-- PHP Version: 5.3.5-1ubuntu7.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yii_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `name` varchar(500) NOT NULL COMMENT 'Наименование',
  `place` varchar(900) NOT NULL COMMENT 'Место проведения',
  `desc` text NOT NULL COMMENT 'Описание события ',
  `image` varchar(50) NOT NULL COMMENT 'Фото',
  `date` varchar(50) NOT NULL COMMENT 'Дата проведения',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Добавлено',
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `actions`
--


-- --------------------------------------------------------

--
-- Table structure for table `actions_files`
--

CREATE TABLE IF NOT EXISTS `actions_files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `action_id` int(11) unsigned NOT NULL COMMENT 'Событие',
  `file` varchar(500) NOT NULL COMMENT 'Файл',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Добавлен',
  PRIMARY KEY (`id`),
  KEY `action_id` (`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `actions_files`
--


-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `section_id` int(11) unsigned NOT NULL COMMENT 'Раздел',
  `title` varchar(400) NOT NULL COMMENT 'Заголовок',
  `text` longtext NOT NULL COMMENT 'Текст',
  `date` date NOT NULL COMMENT 'Дата',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Создано',
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `lang`, `section_id`, `title`, `text`, `date`, `date_create`) VALUES
(2, 'ru', 1, 'aaaad', '<p>ddddd</p>', '2011-10-07', '2011-10-07 17:50:33');

-- --------------------------------------------------------

--
-- Table structure for table `articles_sections`
--

CREATE TABLE IF NOT EXISTS `articles_sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Родитель',
  `name` varchar(100) NOT NULL COMMENT 'Название',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создан',
  `in_sidebar` int(1) NOT NULL DEFAULT '0' COMMENT 'разместить на главной странице',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `parent_id` (`parent_id`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `articles_sections`
--

INSERT INTO `articles_sections` (`id`, `lang`, `parent_id`, `name`, `date_create`, `in_sidebar`) VALUES
(1, 'ru', NULL, 'www', '2011-09-14 19:08:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignments`
--

CREATE TABLE IF NOT EXISTS `auth_assignments` (
  `itemname` varchar(64) NOT NULL,
  `userid` int(11) unsigned NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_assignments`
--

INSERT INTO `auth_assignments` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('admin', 1, NULL, NULL),
('admin', 19, NULL, NULL),
('user', 17, NULL, NULL),
('user', 18, NULL, NULL);


-- --------------------------------------------------------

--
-- Table structure for table `auth_items`
--

CREATE TABLE IF NOT EXISTS `auth_items` (
  `name` varchar(64) NOT NULL COMMENT 'Название',
  `type` int(11) NOT NULL COMMENT 'Тип',
  `description` text COMMENT 'Описание',
  `bizrule` text COMMENT 'Бизнес-правило',
  `data` text COMMENT 'Данные',
  `allow_for_all` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Доступно всем',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_items`
--

INSERT INTO `auth_items` (`name`, `type`, `description`, `bizrule`, `data`, `allow_for_all`) VALUES
('ActionAdmin_Create', 0, 'Добавление мероприятия (админка)', NULL, 'N;', 0),
('ActionAdmin_Delete', 0, 'Удаление мероприятия (админка)', NULL, 'N;', 0),
('ActionAdmin_Manage', 0, 'Управление мероприятиями (админка)', NULL, 'N;', 0),
('ActionAdmin_Update', 0, 'Редактирование мероприятия (админка)', NULL, 'N;', 0),
('ActionAdmin_View', 0, 'Просмотр мероприятия (админка)', NULL, 'N;', 0),
('ActionFileAdmin_Create', 0, 'Добавление файла мероприятия (админка)', NULL, 'N;', 0),
('ActionFileAdmin_Delete', 0, 'Удаление файла мероприятия (админка)', NULL, 'N;', 0),
('ActionFileAdmin_Manage', 0, 'Управление файлами мероприятий (админка)', NULL, 'N;', 0),
('Actions_Admin', 1, 'Управление мероприятиями', '', 's:0:"";', 0),
('Action_Index', 0, 'Просмотр списка мероприятий', NULL, 'N;', 1),
('Action_View', 0, 'Просмотр мероприятия', NULL, 'N;', 1),
('admin', 2, 'Администратор', '', 's:0:"";', 0),
('Admin_Cities_Countries', 1, 'Управление городами и странами', NULL, 's:0:"";', 0),
('Admin_Content', 1, 'Управление контентом', '', 's:0:"";', 0),
('Admin_Documents', 1, 'Управление документами', '', 's:0:"";', 0),
('Admin_Faq', 1, 'Управление вопросами', '', 's:0:"";', 0),
('Admin_Feedback', 1, 'Управление обратной связью', '', 's:0:"";', 0),
('Admin_Languages', 1, 'Управление языками', '', 's:0:"";', 0),
('Admin_Main', 1, 'Админ панель', NULL, 's:0:"";', 0),
('Admin_News', 1, 'Управление новостями', '', 's:0:"";', 0),
('Admin_RBAC', 1, 'Управление контролем доступа', NULL, 's:0:"";', 0),
('Admin_Settings', 1, 'Управление настройками', '', 's:0:"";', 0),
('Admin_Users', 1, 'Управление пользователями', '', 's:0:"";', 0),
('ArticleAdmin_Create', 0, 'Добавление статьи (админка)', NULL, 'N;', 0),
('ArticleAdmin_Delete', 0, 'Удаление статьи (админка)', NULL, 'N;', 0),
('ArticleAdmin_Manage', 0, 'Управление статьями (админка)', NULL, 'N;', 0),
('ArticleAdmin_Update', 0, 'Редактирование статьи (админка)', NULL, 'N;', 0),
('ArticleAdmin_View', 0, 'Просмотр статьи (админка)', NULL, 'N;', 0),
('ArticleSectionAdmin_Create', 0, 'Добавление раздела статьи(админка)', '', 's:2:"N;";', 0),
('ArticleSectionAdmin_Delete', 0, 'Удаление раздела статьи(админка)', '', 's:2:"N;";', 0),
('ArticleSectionAdmin_GetSectionInSidebar', 0, 'Получить раздел статей, который в сайдбаре (админка)', '', 's:2:"N;";', 0),
('ArticleSectionAdmin_Manage', 0, 'Управление разделами статей(админка)', '', 's:2:"N;";', 0),
('ArticleSectionAdmin_Update', 0, 'Редактирование раздела статьи(админка)', '', 's:2:"N;";', 0),
('ArticleSectionAdmin_View', 0, 'Просмотр раздела статьи(админка)', '', 's:2:"N;";', 0),
('ArticleSection_GetChilds', 0, 'Получить подразделы статей', '', 's:2:"N;";', 1),
('Articles_Admin', 1, 'Управление статьями', '', 's:0:"";', 0),
('Article_Index', 0, 'Просмотр списка статей', NULL, 'N;', 1),
('Article_Search', 0, 'Поиск статей', NULL, 'N;', 1),
('Article_SectionArticles', 0, 'Просмотр статей раздела', NULL, 'N;', 1),
('Article_View', 0, 'Просмотр статьи', NULL, 'N;', 1),
('BannerAdmin_Create', 0, 'Создание баннера (админка)', NULL, 'N;', 0),
('BannerAdmin_Delete', 0, 'Удаление баннера (админка)', NULL, 'N;', 0),
('BannerAdmin_Manage', 0, 'Управление баннерами (админка)', NULL, 'N;', 0),
('BannerAdmin_Update', 0, 'Редактирование баннера (админка)', NULL, 'N;', 0),
('BannerAdmin_View', 0, 'Просмотр баннера (админка)', NULL, 'N;', 0),
('CertificateGroupAdmin_Create', 0, 'Создание группы сертификатов (админка)', NULL, 'N;', 0),
('CertificateGroupAdmin_Delete', 0, 'Удаление группы сертификатов (админка)', NULL, 'N;', 0),
('CertificateGroupAdmin_Manage', 0, 'Управление группами сертификатов (админка)', NULL, 'N;', 0),
('CertificateGroupAdmin_Update', 0, 'Редактирование группы сертификатов (админка)', NULL, 'N;', 0),
('CertificateTypeAdmin_Create', 0, 'Создание типа сертификатов (админка)', NULL, 'N;', 0),
('CertificateTypeAdmin_Delete', 0, 'Удаление типа сертификатов (админка)', NULL, 'N;', 0),
('CertificateTypeAdmin_Manage', 0, 'Управление типами сертификатов (админка)', NULL, 'N;', 0),
('CertificateTypeAdmin_Update', 0, 'Редактирование типа сертификатов (админка)', NULL, 'N;', 0),
('CityAdmin_Create', 0, 'Добавление города (админка)', NULL, 'N;', 0),
('CityAdmin_Delete', 0, 'Удаление города (админка)', NULL, 'N;', 0),
('CityAdmin_Manage', 0, 'Управление городами (админка)', NULL, 'N;', 0),
('CityAdmin_Update', 0, 'Редактирование города (админка)', NULL, 'N;', 0),
('City_AutoComplete', 0, 'Автодополнение городов', NULL, 'N;', 1),
('CountryAdmin_Create', 0, 'Добавление страны (админка)', NULL, 'N;', 0),
('CountryAdmin_Delete', 0, 'Удаление страны (админка)', NULL, 'N;', 0),
('CountryAdmin_Manage', 0, 'Управление странами (админка)', NULL, 'N;', 0),
('CountryAdmin_Update', 0, 'Редактирование страны (админка)', NULL, 'N;', 0),
('Country_AutoComplete', 0, 'Автодополнение стран', NULL, 'N;', 1),
('DocumentAdmin_Create', 0, 'Добавление документа (админка)', NULL, 'N;', 0),
('DocumentAdmin_Delete', 0, 'Удаление документа (админка)', NULL, 'N;', 0),
('DocumentAdmin_Manage', 0, 'Управление документами (админка)', NULL, 'N;', 0),
('DocumentAdmin_Update', 0, 'Редактирование документа (админка)', NULL, 'N;', 0),
('DocumentAdmin_View', 0, 'Просмотр документа (админка)', NULL, 'N;', 0),
('DocumentFileAdmin_Create', 0, 'Добавление файла документа (админка)', NULL, 'N;', 0),
('DocumentFileAdmin_Delete', 0, 'Удаление файла документа (админка)', NULL, 'N;', 0),
('DocumentFileAdmin_Manage', 0, 'Управление файлами документов (админка)', NULL, 'N;', 0),
('DocumentFileAdmin_Update', 0, 'Редактирование файла документа (админка)', NULL, 'N;', 0),
('Document_Index', 0, 'Просмотр списка документов', NULL, 'N;', 1),
('Document_View', 0, 'Просмотр документа', NULL, 'N;', 1),
('FaqAdmin_Create', 0, 'Добавление вопроса (админка)', NULL, 'N;', 0),
('FaqAdmin_Delete', 0, 'Удаление вопроса (админка)', NULL, 'N;', 0),
('FaqAdmin_Manage', 0, 'Управление вопросами (админка)', NULL, 'N;', 0),
('FaqAdmin_Update', 0, 'Редактирование вопроса (админка)', NULL, 'N;', 0),
('FaqAdmin_View', 0, 'Просмотр вопроса (админка)', NULL, 'N;', 0),
('FaqSectionAdmin_Create', 0, 'Добавление раздела вопросов (админка)', NULL, 'N;', 0),
('FaqSectionAdmin_Delete', 0, 'Удаление раздела вопросов (админка)', NULL, 'N;', 0),
('FaqSectionAdmin_Manage', 0, 'Управление разделами вопросов (админка)', NULL, 'N;', 0),
('FaqSectionAdmin_Update', 0, 'Редактирование раздела вопросов (админка)', NULL, 'N;', 0),
('FaqSectionAdmin_View', 0, 'Просмотр раздела вопросов (админка)', NULL, 'N;', 0),
('FaqSection_Index', 0, 'Просмотр разделов вопросов', NULL, 'N;', 1),
('Faq_Create', 0, 'Добавление вопроса', NULL, 'N;', 1),
('Faq_Index', 0, 'Просмотр списка вопросов', NULL, 'N;', 1),
('FeedbackAdmin_Delete', 0, 'Удаление сообщений (админка)', NULL, 'N;', 0),
('FeedbackAdmin_Manage', 0, 'Управление сообщениями (админка)', NULL, 'N;', 0),
('FeedbackAdmin_View', 0, 'Просмотр сообщений (админка)', NULL, 'N;', 0),
('Feedback_Create', 0, 'Добавление сообщения', NULL, 'N;', 1),
('FileManagerAdmin_Delete', 0, 'Файловый менеджер:Удаление файла (админка)', NULL, 'N;', 0),
('FileManagerAdmin_ExistFiles', 0, 'Файловый менеджер:Загрузка существующих файлов (админка)', NULL, 'N;', 0),
('FileManagerAdmin_Manage', 0, 'Файловый менеджер:Управление файлами (админка)', NULL, 'N;', 0),
('FileManagerAdmin_SavePriority', 0, 'Файловый менеджер:Сортировка (админка)', NULL, 'N;', 0),
('FileManagerAdmin_UpdateAttr', 0, 'Файловый менеджер:Редактирование файла (админка)', NULL, 'N;', 0),
('FileManagerAdmin_Upload', 0, 'Файловый менеджер:Загрузка файлов (админка)', NULL, 'N;', 0),
('FileManager_DownloadFile', 0, 'Файловый менеджер:Скачать файл', NULL, 'N;', 1),
('guest', 2, 'Гость', '', 's:0:"";', 0),
('LanguageAdmin_Create', 0, 'Добавление языка (админка)', NULL, 'N;', 0),
('LanguageAdmin_Delete', 0, 'Удаление языка (админка)', NULL, 'N;', 0),
('LanguageAdmin_Manage', 0, 'Управление языками (админка)', NULL, 'N;', 0),
('LanguageAdmin_Update', 0, 'Редактирование языка (админка)', NULL, 'N;', 0),
('LogAdmin_View', 0, 'Просмотр логово (админка)', NULL, 'N;', 0),
('MailerFieldAdmin_Create', 0, 'Добавление генерируемого поля (админка)', NULL, 'N;', 0),
('MailerFieldAdmin_Delete', 0, 'Удаление генерируемого поля (админка)', NULL, 'N;', 0),
('MailerFieldAdmin_Manage', 0, 'Управление генерируемыми полями (админка)', NULL, 'N;', 0),
('MailerFieldAdmin_Update', 0, 'Редактирование генерируемого поля (админка)', NULL, 'N;', 0),
('MailerLetterAdmin_Create', 0, 'Cоздание рассылки (админка)', NULL, 'N;', 0),
('MailerLetterAdmin_Delete', 0, 'Удаление рассылки (админка)', NULL, 'N;', 0),
('MailerLetterAdmin_Manage', 0, 'Отчеты о рассылках (админка)', NULL, 'N;', 0),
('MailerLetterAdmin_Update', 0, 'Редактирование рассылки (админка)', NULL, 'N;', 0),
('MailerLetterAdmin_View', 0, 'Отчет об отправке (админка)', NULL, 'N;', 0),
('MailerRecipientAdmin_Manage', 0, 'Статистика получателей рассылки (админка)', NULL, 'N;', 0),
('MailerTemplateAdmin_Create', 0, 'Добавление шаблона рассылки (админка)', NULL, 'N;', 0),
('MailerTemplateAdmin_Delete', 0, 'Удаление шаблона рассылки (админка)', NULL, 'N;', 0),
('MailerTemplateAdmin_Manage', 0, 'Управление шаблонами рассылки (админка)', NULL, 'N;', 0),
('MailerTemplateAdmin_Update', 0, 'Редактирование шаблона рассылки (админка)', NULL, 'N;', 0),
('MailerTemplateAdmin_View', 0, 'Просмотр шаблона рассылки (админка)', NULL, 'N;', 0),
('Mailer_ConfirmReceipt', 0, 'Подтверждение получения письма', NULL, 'N;', 1),
('Mailer_SendMails', 0, 'Отправить письма', NULL, 'N;', 1),
('MainAdmin_AdminLinkProcess', 0, 'Переход по ссылке в админ панель (админка)', NULL, 'N;', 0),
('MainAdmin_ChangeOrder', 0, 'Сортировка (админка)', NULL, 'N;', 0),
('MainAdmin_Index', 0, 'Просмотр главной страницы (админка)', NULL, 'N;', 0),
('MainAdmin_Modules', 0, 'Просмотр списка модулей (админка)', NULL, 'N;', 0),
('MainAdmin_SessionLanguage', 0, 'Установка языка (админка)', NULL, 'N;', 0),
('MainAdmin_SessionPerPage', 0, 'Установки кол-ва элементов на странице (админка)', NULL, 'N;', 0),
('Main_Error', 0, 'Ошибка на странице', NULL, 'N;', 1),
('Main_Search', 0, 'Поиск по сайту', NULL, 'N;', 1),
('MenuAdmin_Create', 0, 'Добавление меню (админка)', NULL, 'N;', 0),
('MenuAdmin_Delete', 0, 'Удаление меню (админка)', NULL, 'N;', 0),
('MenuAdmin_Manage', 0, 'Управление меню (админка)', NULL, 'N;', 0),
('MenuAdmin_Update', 0, 'Редактирование меню (админка)', NULL, 'N;', 0),
('MenuLinkAdmin_AjaxFillTree', 0, 'Загрузка дерева ссылок (админка)', NULL, 'N;', 0),
('MenuLinkAdmin_Create', 0, 'Добавление ссылки меню (админка)', NULL, 'N;', 0),
('MenuLinkAdmin_Delete', 0, 'Удаление ссылки меню (админка)', NULL, 'N;', 0),
('MenuLinkAdmin_Index', 0, 'Управление ссылками меню (админка)', NULL, 'N;', 0),
('MenuLinkAdmin_Update', 0, 'Редактирование ссылки меню (админка)', NULL, 'N;', 0),
('MenuLinkAdmin_View', 0, 'Просмотр ссылки меню (админка)', NULL, 'N;', 0),
('moderator', 2, 'Модератор', '', 's:0:"";', 0),
('NewsAdmin_Create', 0, 'Добавление новости (админка)', NULL, 'N;', 0),
('NewsAdmin_Delete', 0, 'Удаление новости (админка)', NULL, 'N;', 0),
('NewsAdmin_Manage', 0, 'Управление новостями (админка)', NULL, 'N;', 0),
('NewsAdmin_Update', 0, 'Редактирование новости (админка)', NULL, 'N;', 0),
('NewsAdmin_View', 0, 'Просмотр новости (админка)', NULL, 'N;', 0),
('News_Index', 0, 'Список новостей', NULL, 'N;', 1),
('News_View', 0, 'Просмотр новости', NULL, 'N;', 1),
('OperationAdmin_AddAllOperations', 0, 'Добавление всех операций модулей (админка)', NULL, 'N;', 0),
('OperationAdmin_Create', 0, 'Добавление операции (админка)', NULL, 'N;', 0),
('OperationAdmin_Delete', 0, 'Удаление операции (админка)', NULL, 'N;', 0),
('OperationAdmin_GetModuleActions', 0, 'Получение операции модуля, JSON (админка)', NULL, 'N;', 0),
('OperationAdmin_GetModules', 0, 'Получение модулей, JSON (админка)', NULL, 'N;', 0),
('OperationAdmin_Manage', 0, 'Управление операциями (админка)', NULL, 'N;', 0),
('OperationAdmin_Update', 0, 'Редактирование операции (админка)', NULL, 'N;', 0),
('OperationAdmin_View', 0, 'Просмотр операции (админка)', NULL, 'N;', 0),
('PageAdmin_Create', 0, 'Добавление страницы (админка)', NULL, 'N;', 0),
('PageAdmin_Delete', 0, 'Удаление страницы (админка)', NULL, 'N;', 0),
('PageAdmin_GetJsonData', 0, 'Получение данных страницы (JSON) (админка)', NULL, 'N;', 0),
('PageAdmin_Manage', 0, 'Управление страницами (админка)', NULL, 'N;', 0),
('PageAdmin_Update', 0, 'Редактирование страницы (админка)', NULL, 'N;', 0),
('PageAdmin_View', 0, 'Просмотр страницы (админка)', NULL, 'N;', 0),
('PageBlockAdmin_Create', 0, 'Добавление контентного блока (админка)', NULL, 'N;', 0),
('PageBlockAdmin_Delete', 0, 'Удаление контентного блока (админка)', NULL, 'N;', 0),
('PageBlockAdmin_Manage', 0, 'Управление контентными блоками (админка)', NULL, 'N;', 0),
('PageBlockAdmin_Update', 0, 'Редактирование контентного блока (админка)', NULL, 'N;', 0),
('PageBlockAdmin_View', 0, 'Просмотр контентного блока (админка)', NULL, 'N;', 0),
('Page_Main', 0, 'Главная страница', NULL, 'N;', 1),
('Page_View', 0, 'Просмотр страницы', NULL, 'N;', 1),
('RoleAdmin_Assignment', 0, 'Назначение ролей (админка)', NULL, 'N;', 0),
('RoleAdmin_Create', 0, 'Добавление роли (админка)', NULL, 'N;', 0),
('RoleAdmin_Delete', 0, 'Удаление роли (админка)', NULL, 'N;', 0),
('RoleAdmin_Manage', 0, 'Управление ролями (админка)', NULL, 'N;', 0),
('RoleAdmin_Update', 0, 'Редактирование роли (админка)', NULL, 'N;', 0),
('RoleAdmin_View', 0, 'Просмотр роли (админка)', NULL, 'N;', 0),
('SettingAdmin_Manage', 0, 'Управление настройками (админка)', NULL, 'N;', 0),
('SettingAdmin_Update', 0, 'Редактирование настройки (админка)', NULL, 'N;', 0),
('SettingAdmin_View', 0, 'Просмотр настройки (админка)', NULL, 'N;', 0),
('SiteActionAdmin_Index', 0, 'Просмотр действий сайта (админка)', NULL, 'N;', 0),
('TaskAdmin_Allow', 0, 'Разрешение задачи для роли (админка)', NULL, 'N;', 0),
('TaskAdmin_Create', 0, 'Добавление задачи (админка)', NULL, 'N;', 0),
('TaskAdmin_Delete', 0, 'Удаление задачи (админка)', NULL, 'N;', 0),
('TaskAdmin_Deny', 0, 'Запрещение задачи для роли (админка)', NULL, 'N;', 0),
('TaskAdmin_Manage', 0, 'Управление задачами (админка)', NULL, 'N;', 0),
('TaskAdmin_RolesTasks', 0, 'Назначение задач для роли (админка)', NULL, 'N;', 0),
('TaskAdmin_Update', 0, 'Редактирование задачи (админка)', NULL, 'N;', 0),
('TaskAdmin_View', 0, 'Просмотр задачи (админка)', NULL, 'N;', 0),
('user', 2, 'Пользователь', '', 's:7:"s:0:"";";', 0),
('UserAdmin_Create', 0, 'Добавление пользователя (админка)', NULL, 'N;', 0),
('UserAdmin_Delete', 0, 'Удаление пользователя (админка)', NULL, 'N;', 0),
('UserAdmin_Login', 0, 'Авторизация (админка)', NULL, 's:9:"s:2:"N;";";', 1),
('UserAdmin_Manage', 0, 'Управление пользователями (админка)', NULL, 'N;', 0),
('UserAdmin_Update', 0, 'Редактирование пользователя (админка)', NULL, 'N;', 0),
('UserAdmin_View', 0, 'Просмотр пользователя (админка)', NULL, 'N;', 0),
('Users_Account', 1, 'Авторизация, регистрация, смена пароля', NULL, 's:0:"";', 1),
('User_ActivateAccount', 0, 'Активация аккаунта', NULL, 'N;', 0),
('User_ActivateAccountRequest', 0, 'Пользователи:Запрос на активацию аккаунта', NULL, 'N;', 0),
('User_ChangePassword', 0, 'Смена пароля', NULL, 'N;', 0),
('User_ChangePasswordRequest', 0, 'Запрос на смену пароля', NULL, 'N;', 0),
('User_Login', 0, 'Авторизация', NULL, 'N;', 1),
('User_Logout', 0, 'Выход', NULL, 'N;', 1),
('User_Registration', 0, 'Регистрация', NULL, 'N;', 0),
('YmarketBrandAdmin_Manage', 0, 'Бренды (админка)', NULL, 'N;', 0),
('YmarketCronAdmin_Manage', 0, 'Фоновые задания (админка)', NULL, 'N;', 0),
('YmarketCronAdmin_Update', 0, 'Редактирование фонового задания (админка)', NULL, 'N;', 0),
('YmarketIPAdmin_Create', 0, 'Добавление IP адреса яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketIPAdmin_Delete', 0, 'Удаление IP адреса яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketIPAdmin_Manage', 0, 'IP адреса яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketIPAdmin_Update', 0, 'Редактирование IP адреса яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketProductAdmin_Delete', 0, 'Удаление продукта Яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketProductAdmin_Manage', 0, 'Продукты Яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketProductAdmin_View', 0, 'Просмотр продукта Яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketSectionAdmin_Create', 0, 'Создание раздела яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketSectionAdmin_Delete', 0, 'Удаление раздела яндекс маркета? (админка)', NULL, 'N;', 0),
('YmarketSectionAdmin_Manage', 0, 'Разделы яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketSectionAdmin_Update', 0, 'Редактирование раздела яндекс маркета (админка)', NULL, 'N;', 0),
('YmarketSectionAdmin_View', 0, 'Просмотр раздела яндекс маркета (админка)', NULL, 'N;', 0);

-- --------------------------------------------------------

--
-- Table structure for table `auth_items_childs`
--

CREATE TABLE IF NOT EXISTS `auth_items_childs` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_items_childs`
--

INSERT INTO `auth_items_childs` (`parent`, `child`) VALUES
('Actions_Admin', 'ActionAdmin_Create'),
('Actions_Admin', 'ActionAdmin_Delete'),
('Actions_Admin', 'ActionAdmin_Manage'),
('Actions_Admin', 'ActionAdmin_Update'),
('Actions_Admin', 'ActionAdmin_View'),
('Actions_Admin', 'ActionFileAdmin_Create'),
('Actions_Admin', 'ActionFileAdmin_Delete'),
('Actions_Admin', 'ActionFileAdmin_Manage'),
('moderator', 'Actions_Admin'),
('moderator', 'Admin_Content'),
('moderator', 'Admin_Documents'),
('moderator', 'Admin_Faq'),
('moderator', 'Admin_Feedback'),
('moderator', 'Admin_Main'),
('moderator', 'Admin_News'),
('Articles_Admin', 'ArticleAdmin_Create'),
('Articles_Admin', 'ArticleAdmin_Delete'),
('Articles_Admin', 'ArticleAdmin_Manage'),
('Articles_Admin', 'ArticleAdmin_Update'),
('Articles_Admin', 'ArticleAdmin_View'),
('Articles_Admin', 'ArticleSectionAdmin_Create'),
('Articles_Admin', 'ArticleSectionAdmin_Delete'),
('Articles_Admin', 'ArticleSectionAdmin_GetSectionInSidebar'),
('Articles_Admin', 'ArticleSectionAdmin_Manage'),
('Articles_Admin', 'ArticleSectionAdmin_Update'),
('Articles_Admin', 'ArticleSectionAdmin_View'),
('moderator', 'Articles_Admin'),
('Admin_Cities_Countries', 'CityAdmin_Create'),
('Admin_Cities_Countries', 'CityAdmin_Delete'),
('Admin_Cities_Countries', 'CityAdmin_Manage'),
('Admin_Cities_Countries', 'CityAdmin_Update'),
('Admin_Cities_Countries', 'CountryAdmin_Create'),
('Admin_Cities_Countries', 'CountryAdmin_Delete'),
('Admin_Cities_Countries', 'CountryAdmin_Manage'),
('Admin_Cities_Countries', 'CountryAdmin_Update'),
('Admin_Documents', 'DocumentAdmin_Create'),
('Admin_Documents', 'DocumentAdmin_Delete'),
('Admin_Documents', 'DocumentAdmin_Manage'),
('Admin_Documents', 'DocumentAdmin_Update'),
('Admin_Documents', 'DocumentAdmin_View'),
('Admin_Documents', 'DocumentFileAdmin_Create'),
('Admin_Documents', 'DocumentFileAdmin_Delete'),
('Admin_Documents', 'DocumentFileAdmin_Manage'),
('Admin_Documents', 'DocumentFileAdmin_Update'),
('Admin_Faq', 'FaqAdmin_Create'),
('Admin_Faq', 'FaqAdmin_Delete'),
('Admin_Faq', 'FaqAdmin_Manage'),
('Admin_Faq', 'FaqAdmin_Update'),
('Admin_Faq', 'FaqAdmin_View'),
('Admin_Faq', 'FaqSectionAdmin_Create'),
('Admin_Faq', 'FaqSectionAdmin_Delete'),
('Admin_Faq', 'FaqSectionAdmin_Manage'),
('Admin_Faq', 'FaqSectionAdmin_Update'),
('Admin_Faq', 'FaqSectionAdmin_View'),
('Admin_Feedback', 'FeedbackAdmin_Delete'),
('Admin_Feedback', 'FeedbackAdmin_Manage'),
('Admin_Feedback', 'FeedbackAdmin_View'),
('Admin_Languages', 'LanguageAdmin_Create'),
('Admin_Languages', 'LanguageAdmin_Delete'),
('Admin_Languages', 'LanguageAdmin_Manage'),
('Admin_Languages', 'LanguageAdmin_Update'),
('Admin_Main', 'LogAdmin_View'),
('Admin_Main', 'MainAdmin_ChangeOrder'),
('Admin_Main', 'MainAdmin_Index'),
('Admin_Main', 'MainAdmin_Modules'),
('Admin_Main', 'MainAdmin_SessionLanguage'),
('Admin_Main', 'MainAdmin_SessionPerPage'),
('Admin_Content', 'MenuAdmin_Create'),
('Admin_Content', 'MenuAdmin_Delete'),
('Admin_Content', 'MenuAdmin_Manage'),
('Admin_Content', 'MenuAdmin_Update'),
('Admin_Content', 'MenuLinkAdmin_AjaxFillTree'),
('Admin_Content', 'MenuLinkAdmin_Create'),
('Admin_Content', 'MenuLinkAdmin_Delete'),
('Admin_Content', 'MenuLinkAdmin_Index'),
('Admin_Content', 'MenuLinkAdmin_Update'),
('Admin_Content', 'MenuLinkAdmin_View'),
('Admin_News', 'NewsAdmin_Create'),
('Admin_News', 'NewsAdmin_Delete'),
('Admin_News', 'NewsAdmin_Manage'),
('Admin_News', 'NewsAdmin_Update'),
('Admin_News', 'NewsAdmin_View'),
('Admin_RBAC', 'OperationAdmin_AddAllOperations'),
('Admin_RBAC', 'OperationAdmin_Create'),
('Admin_RBAC', 'OperationAdmin_Delete'),
('Admin_RBAC', 'OperationAdmin_GetModuleActions'),
('Admin_Main', 'OperationAdmin_GetModules'),
('Admin_RBAC', 'OperationAdmin_Manage'),
('Admin_RBAC', 'OperationAdmin_Update'),
('Admin_RBAC', 'OperationAdmin_View'),
('Admin_Content', 'PageAdmin_Create'),
('Admin_Content', 'PageAdmin_Delete'),
('Admin_Content', 'PageAdmin_Manage'),
('Admin_Content', 'PageAdmin_Update'),
('Admin_Content', 'PageAdmin_View'),
('Admin_Content', 'PageBlockAdmin_Create'),
('Admin_Content', 'PageBlockAdmin_Delete'),
('Admin_Content', 'PageBlockAdmin_Manage'),
('Admin_Content', 'PageBlockAdmin_Update'),
('Admin_Content', 'PageBlockAdmin_View'),
('Admin_RBAC', 'RoleAdmin_Create'),
('Admin_RBAC', 'RoleAdmin_Delete'),
('Admin_RBAC', 'RoleAdmin_Manage'),
('Admin_RBAC', 'RoleAdmin_Update'),
('Admin_RBAC', 'RoleAdmin_View'),
('Admin_Settings', 'SettingAdmin_Manage'),
('Admin_Settings', 'SettingAdmin_Update'),
('Admin_Settings', 'SettingAdmin_View'),
('Admin_Main', 'SiteActionAdmin_Index'),
('Admin_RBAC', 'TaskAdmin_Create'),
('Admin_RBAC', 'TaskAdmin_Delete'),
('Admin_RBAC', 'TaskAdmin_Manage'),
('Admin_RBAC', 'TaskAdmin_Update'),
('Admin_RBAC', 'TaskAdmin_View'),
('Admin_Users', 'UserAdmin_Create'),
('Admin_Users', 'UserAdmin_Delete'),
('Users_Account', 'UserAdmin_Login'),
('Admin_Users', 'UserAdmin_Manage'),
('Admin_Users', 'UserAdmin_Update'),
('Admin_Users', 'UserAdmin_View'),
('Users_Account', 'User_ActivateAccount'),
('Users_Account', 'User_ChangePassword'),
('Users_Account', 'User_ChangePasswordRequest'),
('Users_Account', 'User_Login'),
('Users_Account', 'User_Registration');

-- --------------------------------------------------------

--
-- Table structure for table `auth_objects`
--

CREATE TABLE IF NOT EXISTS `auth_objects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(11) unsigned NOT NULL COMMENT 'Объект',
  `model_id` varchar(50) NOT NULL COMMENT 'Модель',
  `role` varchar(64) NOT NULL COMMENT 'Роль',
  PRIMARY KEY (`id`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `auth_objects`
--


-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `page_id` int(11) unsigned DEFAULT NULL COMMENT 'Раздел сайта',
  `name` varchar(50) NOT NULL COMMENT 'Название',
  `image` varchar(37) NOT NULL COMMENT 'Изображение',
  `url` varchar(500) DEFAULT NULL COMMENT 'URL-адрес',
  `is_active` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Активен',
  `priority` int(11) NOT NULL DEFAULT '0' COMMENT 'Приоритет',
  `date_start` date DEFAULT NULL COMMENT 'Дата начала показа',
  `date_end` date DEFAULT NULL COMMENT 'Дата окончания показа',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `banners`
--


-- --------------------------------------------------------

--
-- Table structure for table `banners_roles`
--

CREATE TABLE IF NOT EXISTS `banners_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `banner_id` int(11) unsigned NOT NULL,
  `role` varchar(64) NOT NULL COMMENT 'Роль',
  PRIMARY KEY (`id`),
  KEY `banner_id` (`banner_id`),
  KEY `role` (`role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=121 ;

--
-- Dumping data for table `banners_roles`
--


-- --------------------------------------------------------

--
-- Table structure for table `certificates_groups`
--

CREATE TABLE IF NOT EXISTS `certificates_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Название',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлена',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `certificates_groups`
--

INSERT INTO `certificates_groups` (`id`, `name`, `date_create`) VALUES
(5, 'Низкое напряжение', '2011-09-21 01:45:52'),
(6, 'Автоматизация зданий', '2011-09-21 01:45:52'),
(7, 'Электрооборудование для промышленных установок', '2011-09-21 01:45:52'),
(8, 'Электроустановочные изделия', '2011-09-21 01:45:52'),
(9, 'Кабеленесущие системы', '2011-09-21 01:45:52'),
(10, 'Приводная техника', '2011-09-21 01:45:52'),
(11, 'Сетевые фильтры и ИБП однофазные', '2011-09-21 01:45:52'),
(12, 'Промышленная автоматизация', '2011-09-21 01:45:52'),
(13, 'ИБП трехфазные и  инженерная инфраструктура', '2011-09-21 01:45:52');

-- --------------------------------------------------------

--
-- Table structure for table `certificates_types`
--

CREATE TABLE IF NOT EXISTS `certificates_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Тип',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлен',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `certificates_types`
--

INSERT INTO `certificates_types` (`id`, `name`, `date_create`) VALUES
(1, 'ГОСТ', '2011-09-21 01:45:58'),
(2, 'ПожБ', '2011-09-21 01:45:58'),
(3, 'Метр', '2011-09-21 01:45:58'),
(4, 'РТН', '2011-09-21 01:45:58'),
(5, 'АЭС', '2011-09-21 01:45:58'),
(6, 'РМРС', '2011-09-21 01:45:58'),
(7, 'РРР', '2011-09-21 01:45:58'),
(8, 'СЭЗ', '2011-09-21 01:45:58'),
(9, 'Минсвязь', '2011-09-21 01:45:58');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT 'Название',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`) VALUES
(13, 'Волгоград'),
(6, 'Екатеринбург'),
(10, 'Казань'),
(20, 'Майями'),
(3, 'Москва'),
(7, 'Нижний Новгород'),
(5, 'Новосибирск'),
(9, 'Омск'),
(12, 'Ростов-на-Дону'),
(8, 'Самара'),
(4, 'Санкт-Петербург'),
(21, 'Симферополь'),
(11, 'Челябинск'),
(17, 'Ялта');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Название',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=352 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`) VALUES
(3, 'Абхазия'),
(4, 'Австралия'),
(5, 'Австрия'),
(6, 'Азербайджан'),
(7, 'Албания'),
(8, 'Алжир'),
(220, 'Англия'),
(9, 'Ангола'),
(10, 'Ангуилья'),
(11, 'Андорра'),
(12, 'Антигуа и Барбуда'),
(13, 'Антильские о-ва'),
(14, 'Аргентина'),
(349, 'Арль-Авиньон'),
(15, 'Армения'),
(16, 'Арулько'),
(17, 'Афганистан'),
(342, 'Аяччо'),
(18, 'Багамские о-ва'),
(19, 'Бангладеш'),
(20, 'Барбадос'),
(346, 'Бастия'),
(21, 'Бахрейн'),
(23, 'Белиз'),
(22, 'Белоруссия'),
(24, 'Бельгия'),
(25, 'Бенин'),
(26, 'Бермуды'),
(27, 'Болгария'),
(28, 'Боливия'),
(334, 'Бордо'),
(258, 'Босния и Герцеговина'),
(29, 'Босния/Герцеговина'),
(30, 'Ботсвана'),
(31, 'Бразилия'),
(350, 'Брест'),
(32, 'Британские Виргинские о-ва'),
(33, 'Бруней'),
(340, 'Булонь'),
(34, 'Буркина Фасо'),
(302, 'Буркина-Фасо'),
(35, 'Бурунди'),
(36, 'Бутан'),
(336, 'Валансьен'),
(37, 'Валлис и Футуна о-ва'),
(38, 'Вануату'),
(39, 'Великобритания'),
(40, 'Венгрия'),
(41, 'Венесуэла'),
(42, 'Восточный Тимор'),
(43, 'Вьетнам'),
(44, 'Габон'),
(337, 'Гавр'),
(45, 'Гаити'),
(46, 'Гайана'),
(47, 'Гамбия'),
(48, 'Гана'),
(49, 'Гваделупа'),
(50, 'Гватемала'),
(51, 'Гвинея'),
(52, 'Гвинея-Бисау'),
(348, 'Генгам'),
(53, 'Германия'),
(54, 'Гернси о-в'),
(55, 'Гибралтар'),
(133, 'Голландия'),
(56, 'Гондурас'),
(57, 'Гонконг'),
(58, 'Гренада'),
(59, 'Гренландия'),
(339, 'Гренобль'),
(60, 'Греция'),
(61, 'Грузия'),
(62, 'Дания'),
(63, 'Джерси о-в'),
(64, 'Джибути'),
(65, 'Доминиканская республика'),
(307, 'ДР Конго'),
(66, 'Египет'),
(67, 'Замбия'),
(68, 'Западная Сахара'),
(69, 'Зимбабве'),
(70, 'Израиль'),
(71, 'Индия'),
(72, 'Индонезия'),
(73, 'Иордания'),
(74, 'Ирак'),
(75, 'Иран'),
(76, 'Ирландия'),
(77, 'Исландия'),
(78, 'Испания'),
(347, 'Истр'),
(79, 'Италия'),
(80, 'Йемен'),
(81, 'Кабо-Верде'),
(82, 'Казахстан'),
(83, 'Камбоджа'),
(84, 'Камерун'),
(321, 'Кан'),
(85, 'Канада'),
(86, 'Катар'),
(87, 'Кения'),
(88, 'Кипр'),
(310, 'Киргизия'),
(89, 'Кирибати'),
(90, 'Китай'),
(303, 'КНДР'),
(91, 'Колумбия'),
(92, 'Коморские о-ва'),
(315, 'Коморы'),
(312, 'Конго'),
(93, 'Конго (Brazzaville)'),
(94, 'Конго (Kinshasa)'),
(299, 'Корея'),
(95, 'Коста-Рика'),
(300, 'Кот д-Ивуар'),
(96, 'Кот-д''Ивуар'),
(97, 'Куба'),
(98, 'Кувейт'),
(99, 'Кука о-ва'),
(100, 'Кыргызстан'),
(327, 'Ланс'),
(101, 'Лаос'),
(102, 'Латвия'),
(332, 'Ле Ман'),
(103, 'Лесото'),
(104, 'Либерия'),
(105, 'Ливан'),
(106, 'Ливия'),
(333, 'Лилль'),
(320, 'Лион'),
(107, 'Литва'),
(108, 'Лихтенштейн'),
(329, 'Лорьян'),
(109, 'Люксембург'),
(110, 'Маврикий'),
(111, 'Мавритания'),
(112, 'Мадагаскар'),
(113, 'Македония'),
(114, 'Малави'),
(115, 'Малайзия'),
(116, 'Мали'),
(117, 'Мальдивские о-ва'),
(118, 'Мальта'),
(125, 'Марокко'),
(326, 'Марсель'),
(316, 'Мартиника'),
(119, 'Мартиника о-в'),
(120, 'Мексика'),
(330, 'Мец'),
(121, 'Мозамбик'),
(295, 'Молдавия'),
(122, 'Молдова'),
(123, 'Монако'),
(124, 'Монголия'),
(341, 'Монпелье'),
(351, 'Москва'),
(309, 'Мьянма'),
(126, 'Мьянма (Бирма)'),
(127, 'Мэн о-в'),
(128, 'Намибия'),
(319, 'Нанси'),
(338, 'Нант'),
(129, 'Науру'),
(130, 'Непал'),
(131, 'Нигер'),
(132, 'Нигерия'),
(313, 'Нидерландские Антилы'),
(134, 'Никарагуа'),
(325, 'Ницца'),
(135, 'Новая Зеландия'),
(306, 'Новая Каледония'),
(136, 'Новая Каледония о-в'),
(137, 'Норвегия'),
(138, 'Норфолк о-в'),
(139, 'О.А.Э.'),
(301, 'ОАЭ'),
(140, 'Оман'),
(328, 'Осер'),
(141, 'Пакистан'),
(142, 'Панама'),
(143, 'Папуа Новая Гвинея'),
(144, 'Парагвай'),
(335, 'Пари Сен-Жермен'),
(145, 'Перу'),
(146, 'Питкэрн о-в'),
(147, 'Польша'),
(148, 'Португалия'),
(149, 'Пуэрто Рико'),
(322, 'Ренн'),
(150, 'Реюньон'),
(1, 'Россия'),
(151, 'Руанда'),
(152, 'Румыния'),
(154, 'Сальвадор'),
(155, 'Самоа'),
(156, 'Сан-Марино'),
(157, 'Сан-Томе и Принсипи'),
(158, 'Саудовская Аравия'),
(159, 'Свазиленд'),
(160, 'Святая Люсия'),
(161, 'Святой Елены о-в'),
(296, 'Северная Ирландия'),
(162, 'Северная Корея'),
(344, 'Седан'),
(163, 'Сейшеллы'),
(317, 'Сейшелы'),
(164, 'Сен-Пьер и Микелон'),
(165, 'Сенегал'),
(166, 'Сент Китс и Невис'),
(167, 'Сент-Винсент и Гренадины'),
(318, 'Сент-Этьен'),
(168, 'Сербия'),
(305, 'Сербия и Черногория'),
(169, 'Сингапур'),
(170, 'Сирия'),
(171, 'Словакия'),
(172, 'Словения'),
(173, 'Соломоновы о-ва'),
(174, 'Сомали'),
(331, 'Сошо'),
(323, 'Страсбур'),
(175, 'Судан'),
(176, 'Суринам'),
(153, 'США'),
(177, 'Сьерра-Леоне'),
(178, 'Таджикистан'),
(180, 'Таиланд'),
(179, 'Тайвань'),
(181, 'Танзания'),
(182, 'Того'),
(183, 'Токелау о-ва'),
(184, 'Тонга'),
(185, 'Тринидад и Тобаго'),
(343, 'Труа'),
(186, 'Тувалу'),
(324, 'Тулуза'),
(187, 'Тунис'),
(345, 'Тур'),
(188, 'Туркменистан'),
(308, 'Туркмения'),
(189, 'Туркс и Кейкос'),
(190, 'Турция'),
(191, 'Уганда'),
(192, 'Узбекистан'),
(2, 'Украина'),
(193, 'Уругвай'),
(298, 'Уэльс'),
(194, 'Фарерские о-ва'),
(294, 'Фарерские острова'),
(195, 'Фиджи'),
(196, 'Филиппины'),
(197, 'Финляндия'),
(198, 'Франция'),
(199, 'Французская Гвинея'),
(200, 'Французская Полинезия'),
(201, 'Хорватия'),
(314, 'Центрально-Африканская Республика'),
(202, 'Чад'),
(203, 'Черногория'),
(204, 'Чехия'),
(304, 'Чехословакия'),
(205, 'Чили'),
(206, 'Швейцария'),
(207, 'Швеция'),
(297, 'Шотландия'),
(208, 'Шри-Ланка'),
(209, 'Эквадор'),
(210, 'Экваториальная Гвинея'),
(211, 'Эритрея'),
(212, 'Эстония'),
(213, 'Эфиопия'),
(214, 'ЮАР'),
(311, 'Югославия'),
(215, 'Южная Корея'),
(216, 'Южная Осетия'),
(217, 'Ямайка'),
(218, 'Япония');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `name` varchar(500) NOT NULL COMMENT 'Наименование',
  `desc` text NOT NULL COMMENT 'Описание',
  `is_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Опубликовано',
  `date_publish` date NOT NULL COMMENT 'Дата публикации',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания',
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `documents`
--


-- --------------------------------------------------------

--
-- Table structure for table `documents_files`
--

CREATE TABLE IF NOT EXISTS `documents_files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `document_id` int(11) unsigned NOT NULL COMMENT 'Документ',
  `title` varchar(250) NOT NULL COMMENT 'Заголовок',
  `file` varchar(50) NOT NULL COMMENT 'Файл',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Добавлен',
  PRIMARY KEY (`id`),
  KEY `document_id` (`document_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `documents_files`
--


-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `first_name` varchar(40) NOT NULL COMMENT 'Имя',
  `last_name` varchar(40) DEFAULT NULL COMMENT 'Фамилия',
  `patronymic` varchar(40) DEFAULT NULL COMMENT 'Отчество',
  `company` varchar(80) DEFAULT NULL COMMENT 'Компания',
  `position` varchar(50) DEFAULT NULL COMMENT 'Должность',
  `phone` varchar(50) DEFAULT NULL COMMENT 'Телефон',
  `email` varchar(80) NOT NULL COMMENT 'Email',
  `section_id` int(11) NOT NULL COMMENT 'Раздел',
  `question` longtext NOT NULL COMMENT 'Вопрос',
  `answer` longtext COMMENT 'Ответ',
  `is_published` int(1) NOT NULL DEFAULT '0' COMMENT 'Опубликовано',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добалено',
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`),
  KEY `date` (`date_create`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `faq`
--


-- --------------------------------------------------------

--
-- Table structure for table `faq_sections`
--

CREATE TABLE IF NOT EXISTS `faq_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `name` varchar(200) NOT NULL COMMENT 'Название',
  `is_published` int(1) NOT NULL DEFAULT '0' COMMENT 'Опубликован',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `faq_sections`
--


-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) NOT NULL COMMENT 'Имя',
  `last_name` varchar(40) DEFAULT NULL COMMENT 'Фамилия',
  `patronymic` varchar(40) DEFAULT NULL COMMENT 'Отчество',
  `company` varchar(80) DEFAULT NULL COMMENT 'Компания',
  `position` varchar(40) DEFAULT NULL COMMENT 'Должность',
  `phone` varchar(50) DEFAULT NULL COMMENT 'Телефон',
  `email` varchar(80) NOT NULL COMMENT 'Email',
  `comment` varchar(1000) NOT NULL COMMENT 'Комментарий',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создано',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `first_name`, `last_name`, `patronymic`, `company`, `position`, `phone`, `email`, `comment`, `date_create`) VALUES
(1, 'dawdawd', 'dawda', 'awdaw', 'dawdawd', 'awdawd', '+7-903-5492969', 'dwad@mail.ru', 'awd', '2011-09-11 23:13:31'),
(2, 'dawdawd', 'dawda', 'awdaw', 'dawdawd', 'awdawd', '+7-903-5492969', 'dwad@mail.ru', 'awd', '2011-09-11 23:15:47'),
(3, 'dawdawd', 'dawda', 'awdaw', 'dawdawd', 'awdawd', '+7-903-5492969', 'dwad@mail.ru', 'awd', '2011-09-11 23:15:55'),
(4, 'dawdawd', 'dawda', 'awdaw', 'dawdawd', 'awdawd', '+7-903-5492969', 'dwad@mail.ru', 'awd', '2011-09-11 23:16:39'),
(5, 'dawdawd', 'dawda', 'awdaw', 'dawdawd', 'awdawd', '+7-903-5492969', 'dwad@mail.ru', 'awd', '2011-09-11 23:17:02'),
(6, 'dawdawd', 'dawda', 'awdaw', 'dawdawd', 'awdawd', '+7-903-5492969', 'dwad@mail.ru', 'awd', '2011-09-11 23:21:32'),
(7, 'dawdawd', 'dawda', 'awdaw', 'dawdawd', 'awdawd', '+7-903-5492969', 'dwad@mail.ru', 'awd', '2011-09-11 23:22:39'),
(8, 'dawdawd', 'dawda', 'awdaw', 'dawdawd', 'awdawd', '+7-903-5492969', 'dwad@mail.ru', 'awd', '2011-09-11 23:23:13'),
(9, 'dawdawd', 'dawda', 'awdaw', 'dawdawd', 'awdawd', '+7-903-5492969', 'dwad@mail.ru', 'awd', '2011-09-11 23:23:34'),
(10, 'dawdawd', 'dawda', 'awdaw', 'dawdawd', 'awdawd', '+7-903-5492969', 'dwad@mail.ru', 'awd', '2011-09-11 23:25:31'),
(11, 'вфцв', 'вфцв', 'фцвфцв', 'фцвфцв', 'фцвфцвф', '+7-903-5492969', 'ada@mail.ru', 'dadaw', '2011-09-13 01:06:53'),
(12, 'wadaw', 'dawd', 'dwad', 'awdawd', 'dawddawdaw', '+7-903-5492969', 'dadwa@mail.ru', 'dawd', '2011-09-16 14:24:02'),
(13, 'dawdwa', 'dwad', 'dwad', 'dwad', 'dwadawd', '+7-903-5492969', 'dawd@mail.ru', 'dawda', '2011-09-16 14:41:54'),
(14, 'awdaw', 'dawd', 'dwd', 'dwad', 'dwadaw', '+7-903-5492969', 'dawdw@mail.ru', 'dawd', '2011-09-16 15:04:23'),
(15, 'adwa', 'dawdw', 'dwad', 'awdaw', 'dawd', '+7-903-5492969', 'awda@mail.ru', 'dawddawd', '2011-09-16 15:05:06'),
(16, 'awdwad', 'wwd', 'fawddawdaw', 'dawd', 'awdawd', '+7-903-5492969', 'awdawd@mail.ru', 'dwadaw', '2011-09-16 15:05:47');

-- --------------------------------------------------------

--
-- Table structure for table `file_manager`
--

CREATE TABLE IF NOT EXISTS `file_manager` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` varchar(100) DEFAULT NULL COMMENT 'ID объекта',
  `model_id` varchar(100) DEFAULT NULL COMMENT 'Модель',
  `name` varchar(100) NOT NULL COMMENT 'Файл',
  `path` varchar(100) NOT NULL COMMENT 'Путь до файла',
  `tag` varchar(100) DEFAULT NULL COMMENT 'Тег',
  `title` text COMMENT 'Название',
  `descr` text COMMENT 'Описание',
  `order` int(11) unsigned NOT NULL COMMENT 'Порядок',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `file_manager`
--

INSERT INTO `file_manager` (`id`, `object_id`, `model_id`, `name`, `tag`, `title`, `descr`, `order`) VALUES
(1, '13', 'News', 'e607ea11303b1ae216ce8410fb3d680f.jpg', 'files', 'DSCN2060(www.CoolWallpapers.org)-1280x10242.JPG', NULL, 1),
(2, '13', 'News', '88364aee8a6ef951dcfadcdbe576e550.png', 'files', 'GNOME-210SimpleAndElegant_1280x1024.png', NULL, 2),
(3, '13', 'News', 'a627f1aa47a9cd775c348578fc23da58.png', 'files', 'wallpaper-linux-cli-commands-1280-1024.png', NULL, 3),
(4, '13', 'News', 'b874601073fbc29c0ca0459d2ee7f7c8.jpg', 'files', 'OTHER-SmolovSummer2004_1024x768.jpg', NULL, 4),
(5, '13', 'News', '3c664f65c64426ff95f413f48e12088d.jpg', 'files', 'ubuntualien.jpg', NULL, 5),
(6, '13', 'News', 'b1d756441e6eae30632e1dc172041a8b.jpg', 'files', 'NATURE-AtTheEdgeOfAtmosphere_1024x768.jpg', NULL, 6),
(7, '13', 'News', '8b45f94c61220ccf25b4c666b11a1b6b.jpg', 'files', 'DSCN2060(www.CoolWallpapers.org)-1280x10242.JPG', NULL, 7),
(8, '13', 'News', '015e557b48ef1f20368f67dfd8fe3706.png', 'files', 'GNOME-210SimpleAndElegant_1280x1024.png', NULL, 8),
(9, '13', 'News', 'a91446c6617815267c8975043708464b.jpg', 'files', 'ski-resort-bad-hofgastein-1280x1024.jpg', NULL, 9),
(10, '13', 'News', '1995e2446badb63bba8e92978d400d37.jpg', 'files', 'DSCN2060(www.CoolWallpapers.org)-1280x1024.JPG', NULL, 10),
(11, '13', 'News', '61edbd42e55b69480b783b7054d370f5.jpg', 'files', 'awp05_alltolls_blogspot098-1280x1024.jpg', NULL, 11);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` char(2) NOT NULL COMMENT 'ID',
  `name` varchar(15) NOT NULL COMMENT 'Название',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`) VALUES
('en', 'english'),
('ru', 'русский');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(128) DEFAULT NULL COMMENT 'Тип',
  `category` varchar(128) DEFAULT NULL COMMENT 'Категория',
  `logtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Время',
  `message` text COMMENT 'Сообщение',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `log`
--


-- --------------------------------------------------------

--
-- Table structure for table `mailer_fields`
--

CREATE TABLE IF NOT EXISTS `mailer_fields` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL COMMENT 'Код ',
  `name` varchar(200) NOT NULL COMMENT 'Наименование',
  `value` varchar(250) NOT NULL COMMENT 'Значение',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `value` (`value`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `mailer_fields`
--

INSERT INTO `mailer_fields` (`id`, `code`, `name`, `value`) VALUES
(1, '{FIRST_NAME}', 'Имя', '$user->first_name'),
(2, '{LAST_NAME}', 'Фамилия', '$user->last_name'),
(3, '{PATRONYMIC}', 'Отчество', '$user->patronymic'),
(5, '{DATE}', 'Текущая дата', 'date(''d.m.Y'')'),
(6, '{ROLE}', 'Наименование группы к которой принадлежит пользователь', '$user->role->description'),
(7, '{APPEAL}', 'Обращение к пользователю', '$user->gender == User::GENDER_MAN ? ''Уважаемый'' : ''Уважаемая'''),
(9, '{SITE_NAME}', 'Название сайта', 'yii_cms'),
(10, '{ACTIVATE_ACCOUNT_URL}', 'URL ссылки активации аккаунта', '$user->activateAccountUrl();');

-- --------------------------------------------------------

--
-- Table structure for table `mailer_letters`
--

CREATE TABLE IF NOT EXISTS `mailer_letters` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) unsigned DEFAULT NULL COMMENT 'Шаблон',
  `subject` varchar(150) NOT NULL COMMENT 'Тема письма',
  `text` text NOT NULL COMMENT 'Текст письма',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата отправки',
  PRIMARY KEY (`id`),
  KEY `template_id` (`template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mailer_letters`
--

INSERT INTO `mailer_letters` (`id`, `template_id`, `subject`, `text`, `date_create`) VALUES
(5, NULL, 'Письмо с тегами {SITE_NAME}', '{SITE_NAME}  !<br /><br />{APPEAL}  {FIRST_NAME}&nbsp;  {LAST_NAME}  &nbsp;{PATRONYMIC}  .<br /><br />{DATE}&nbsp;  - {ROLE}  <br />Yo  ', '2011-09-30 19:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `mailer_recipients`
--

CREATE TABLE IF NOT EXISTS `mailer_recipients` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `letter_id` int(11) unsigned NOT NULL COMMENT 'Рассылка',
  `user_id` int(11) unsigned NOT NULL COMMENT 'Пользователь',
  `status` enum('accepted','fail','waiting','sent') DEFAULT 'waiting' COMMENT 'Статус',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата отправки',
  PRIMARY KEY (`id`),
  UNIQUE KEY `letter_id_2` (`letter_id`,`user_id`),
  KEY `letter_id` (`letter_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `mailer_recipients`
--

INSERT INTO `mailer_recipients` (`id`, `letter_id`, `user_id`, `status`, `date_create`) VALUES
(9, 5, 17, 'sent', '2011-09-30 19:18:22'),
(10, 5, 18, 'sent', '2011-09-30 19:18:22');

-- --------------------------------------------------------

--
-- Table structure for table `mailer_templates`
--

CREATE TABLE IF NOT EXISTS `mailer_templates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL COMMENT 'Название',
  `subject` varchar(150) NOT NULL COMMENT 'Тема письма',
  `text` text NOT NULL COMMENT 'Текст письма',
  `is_basic` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Основной',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создан',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mailer_templates`
--


-- --------------------------------------------------------

--
-- Table structure for table `mailer_templates_recipients`
--

CREATE TABLE IF NOT EXISTS `mailer_templates_recipients` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `template_id_2` (`template_id`,`user_id`),
  KEY `template_id` (`template_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `mailer_templates_recipients`
--


-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT 'Название',
  `is_visible` tinyint(1) NOT NULL COMMENT 'Отображать',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `is_visible`) VALUES
(6, 'Верхнее меню', 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_links`
--

CREATE TABLE IF NOT EXISTS `menu_links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `parent_id` int(11) unsigned DEFAULT NULL COMMENT 'Родитель',
  `page_id` int(11) unsigned DEFAULT NULL COMMENT 'Привязка к странице',
  `menu_id` int(11) unsigned NOT NULL COMMENT 'Меню',
  `title` varchar(50) NOT NULL COMMENT 'Заголовок',
  `url` varchar(200) NOT NULL COMMENT 'Адрес',
  `user_role` varchar(64) DEFAULT NULL COMMENT 'Только для',
  `not_user_role` varchar(64) DEFAULT NULL COMMENT 'Для всех кроме',
  `order` int(11) NOT NULL COMMENT 'Порядок',
  `is_visible` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Отображать',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `menu_id` (`menu_id`),
  KEY `parent_id` (`parent_id`),
  KEY `user_role` (`user_role`),
  KEY `not_user_role` (`not_user_role`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `menu_links`
--

INSERT INTO `menu_links` (`id`, `lang`, `parent_id`, `page_id`, `menu_id`, `title`, `url`, `user_role`, `not_user_role`, `order`, `is_visible`) VALUES
(1, 'ru', NULL, 1, 6, 'Главная', '/', NULL, NULL, 1, 1),
(2, 'ru', NULL, 2, 6, 'О нас', 'about_usss', NULL, NULL, 2, 1),
(3, 'ru', NULL, NULL, 6, 'Обратная связь', 'feedback', NULL, NULL, 3, 1),
(4, 'ru', NULL, NULL, 6, 'Войти', 'login', 'guest', NULL, 4, 1),
(6, 'ru', NULL, NULL, 6, 'Выйти', 'logout', NULL, 'guest', 6, 1),
(7, 'en', NULL, 3, 6, 'Main page', '', NULL, NULL, 1, 1),
(8, 'en', NULL, 4, 6, 'About us', '', NULL, NULL, 2, 1),
(9, 'en', NULL, NULL, 6, 'Feedback', 'feedback', NULL, NULL, 3, 1),
(10, 'en', NULL, NULL, 6, 'Login', 'login', 'guest', NULL, 4, 1),
(12, 'en', NULL, NULL, 6, 'Logout', 'logout', NULL, 'guest', 6, 1),
(13, 'ru', NULL, NULL, 6, 'Регистрация', 'registration', 'guest', NULL, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `meta_tags`
--

CREATE TABLE IF NOT EXISTS `meta_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(11) unsigned DEFAULT NULL COMMENT 'ID объекта',
  `model_id` varchar(50) NOT NULL COMMENT 'Модель',
  `title` varchar(300) DEFAULT NULL COMMENT 'Заголовок',
  `keywords` varchar(300) DEFAULT NULL COMMENT 'Ключевые слова',
  `description` varchar(300) DEFAULT NULL COMMENT 'Описание',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создано',
  `date_update` datetime DEFAULT NULL COMMENT 'Отредактирован',
  PRIMARY KEY (`id`),
  UNIQUE KEY `object_id` (`object_id`,`model_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `meta_tags`
--

INSERT INTO `meta_tags` (`id`, `object_id`, `model_id`, `title`, `keywords`, `description`, `date_create`, `date_update`) VALUES
(5, 2, 'Page', '111', '3333', '222', '2011-10-19 17:25:04', NULL),
(6, 17, 'Page', '45', '567', '67', '2011-10-19 17:25:17', NULL),
(7, 1, 'Page', 'www', 'rtyrtyry', 'trfyhr', '2011-10-19 17:25:29', NULL),
(8, 3, 'News', 'zzzz', 'keyww', 'oppp', '2011-10-20 13:10:13', '2011-10-20 13:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `user_id` int(11) unsigned NOT NULL COMMENT 'Автор',
  `title` varchar(250) NOT NULL COMMENT 'Заголовок',
  `text` longtext NOT NULL COMMENT 'Текст',
  `photo` varchar(50) DEFAULT NULL COMMENT 'Фото',
  `state` enum('active','hidden') NOT NULL COMMENT 'Состояние',
  `date` date NOT NULL COMMENT 'Дата',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Создана',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `lang`, `user_id`, `title`, `text`, `photo`, `state`, `date`, `date_create`) VALUES
(1, 'ru', 1, 'IdeaPad Y570: мощный ноутбук по разумной цене', '<p>В блоге компании Lenovo на Хабре мы уделяем наибольшее внимание серии ThinkPad, что вполне логично &ndash; судя по отзывам, большинству из вас по нраву как раз эти модели, созданные для работы и творчества, крепкие и строгие внешне. Но сегодня у нас обзор модели IdeaPad Y570, яркого представителя &laquo;пользовательской&raquo; серии ноутбуков Lenovo, весьма отличающейся от унаследованных у IBM бизнес-моделей. Обойти вниманием такой ноутбук сложно: при стоимости от 30 тысяч рублей он предоставляет в ваше распоряжение одну из самых мощных видеокарт, современный процессор Intel Core, а также невероятно быструю дисковую систему. Гибрид из емкого жесткого диска и быстрого SSD именно в &laquo;пятьсот семидесятом&raquo; стал штатным: им оснащается большинство модификаций ноутбука. В этом обзоре я расскажу о том, чем хороша загрузка за 15 секунд, какие изменения произошли в новой модели Y-серии, а также о том, почему стоит выбрать именно эту модель в качестве домашнего развлекательного центра.</p>', '80f3dfc8fb0c6fe5c33950e89eed32cf.jpeg', 'active', '2006-04-24', '0000-00-00 00:00:00'),
(2, 'ru', 1, 'Твиттер запустит инструмент для веб-аналитики', '<p>Сколько трафика ваш сайт получает из Твиттера? Дать ответ на этот вопрос позволит анонсированный Твиттером инструмент для веб-аналитики под названием Twitter Web Analytics.<br /><br />Новый инструмент призван дать владельцам сайтов больше данных об эффективности их интеграции с Твиттером. Он основан на технологиях компании BackType, которая занимается социальной аналитикой и которую Твиттер купил в июне.<br /><a></a><br />Как <a href="https://dev.twitter.com/blog/introducing-twitter-web-analytics">пояснил</a> основатель BackType и новый сотрудник Твиттера Кристофер Голда, Twitter Web Analytics поможет владельцам сайтов понимать три ключевых момента: сколько их контента распространяется в Твиттере, сколько трафика их сайт получает из Твиттера, и насколько эффективны кнопки Твиттера.<br /><br />Как видно на скриншоте, панель аналитики состоит из четырёх вкладок. Первая, &laquo;трафик&raquo;, отображает число твитов со ссылками на сайт и количество кликов по этим ссылкам. Графики доступны для текущего дня, прошлой недели и прошлого месяца. Вкладка &laquo;твиты&raquo; показывает все твиты, содержащие ссылки на сайт, а также все твиты, отправленные из встроенных кнопок Твиттера на сайте. Администратор может ретвитить и отвечать на твиты из этой панели. Вкладка &laquo;кнопка Твиттера&raquo; показывает, насколько активно используются кнопки Твиттера на сайте, а вкладка &laquo;контент&raquo; показывает наиболее эффективные страницы сайта.<br /><br />По словам директора Твиттера по развитию веб-бизнеса Эйприл Андервуд, данные будут очищены от ботов и спама. Твиттер также выпустит API инструмента для разработчиков.<br /><br />Twitter Web Analytics бесплатен и пока что в бета-версии. Небольшая группа партнёров получит к нему доступ на этой неделе, а для всех он будет запущен в течение нескольких недель.</p>', 'be8a93e588f5469ee426a77a66e2444a.png', 'active', '2011-09-05', '0000-00-00 00:00:00'),
(3, 'ru', 1, 'Microsoft выпустил Windows 8 Developer Preview', '<p>Разумеется, это не готовый продукт, поэтому будьте готовы к ошибкам, постоянным обновлениям и несовместимости программ. В общем, действуйте на свой риск.<br /><br />Если хотите получить некоторое представление о Windows 8 перед установкой, посмотрите скриншоты под катом.<br /><a></a>Разумеется, это не готовый продукт, поэтому будьте готовы к ошибкам, постоянным обновлениям и несовместимости программ. В общем, действуйте на свой риск.<br /><br />Если хотите получить некоторое представление о Windows 8 перед установкой, посмотрите скриншоты под катом.<br /><a></a><br />На конференции Microsoft продемонстрировал много устройств на Windo<strong>ws 8, в том числе планшетов:zz</strong></p>\r\n<p>&nbsp;</p>\r\n<p><strong>Разумеется, это не готовый продукт, поэтому будьте готовы к ошибкам, постоянным обновлениям и несовместимости программ. В общем, действуйте на свой риск.<br /><br />Если хотите получить некоторое представление о Windows 8 перед установкой, посмотрите скриншоты под катом.<br /><a></a><br />На конференции Microsoft продемонстрировал много устройств на Windo<strong>ws 8, в том числе планшетов:zz</strong></strong></p>\r\n<p>&nbsp;</p>\r\n<p><strong><strong>Разумеется, это не готовый продукт, поэтому будьте готовы к ошибкам, постоянным обновлениям и несовместимости программ. В общем, действуйте на свой риск.<br /><br />Если хотите получить некоторое представление о Windows 8 перед установкой, посмотрите скриншоты под катом.<br /><a></a><br />На конференции Microsoft продемонстрировал много устройств на Windo<strong>ws 8, в том числе планшетов:zz</strong><br /></strong></strong></p>\r\n<p>На конференции Microsoft продемонстрировал много устройств на Windo<strong>ws 8, в том числе планшетов:zz</strong></p>', '328a76e70961ee6f64165f802d281e09.jpg', 'active', '2011-09-14', '0000-00-00 00:00:00'),
(4, 'en', 1, 'Intel brandishes first Google Android tablet', '<p>SAN FRANCISCO--Intel hauled out its first\r\n<a href="http://www.cnet.com/android-atlas/">Android</a>\r\n<a href="http://reviews.cnet.com/tablets/">tablet</a>\r\n running on "Medfield," an upcoming Atom chip for smartphones and \r\ntablets, while two executives also chatted with CNET about their \r\nrelationship with Google, all at Intel''s developer conference today. </p>\r\n<p>The Medfield Atom chip is one of Intel''s most power-efficient chip \r\ndesigns--a strict requirement for tablets and smartphones. It contains a\r\n single processing core--as opposed to more power-hungry dual-core Atom \r\nchips used in Netbooks--and will be available in devices in the first \r\nhalf of 2012. </p>\r\n<p>The tablet that Intel showed today (see photo below) is a so-called \r\nreference design that the company will supply to tablet makers that \r\nwould use it as a template for their own product. </p>\r\n<p>Importantly, Intel-based tablets and smartphones will be targeted at \r\nGoogle''s Android software, not Intel''s internal MeeGo operating system. \r\nThe latter has been relegated to automotive and industrial applications \r\nmostly and is no longer seen as a promising operating system for \r\nconsumer devices. To drive this point home, Intel reaffirmed its \r\nrelationship with Google today. </p>\r\n<p>CNET sat down briefly with two Intel phone executives to talk about \r\nthe relationship. The reaffirmation of the relationship is about \r\n"optimizing Intel for the Android platform for phone and for tablets," \r\nsaid Mike Bell, co-general manager of the phone division. "So, as a \r\n[device maker] you''ll be able to go out and build a device with the full\r\n blessing and backing of Intel and Google," he said. </p>\r\n<p>Intel has done an about-face of sorts. Its phone efforts had focused \r\nheavily on Nokia until that company made a dramatic switch to \r\nMicrosoft''s Windows phone platform. "We were very focused on Nokia. Mike\r\n and I took over in April and got the company very focused on the \r\nAndroid ecosystem," said Dave Whalen, the other co-manager of the phone \r\ndivision. </p><div><br />Read more: <a href="http://news.cnet.com/8301-13924_3-20105608-64/intel-brandishes-first-google-android-tablet/#ixzz1Xw5pQIsr">http://news.cnet.com/8301-13924_3-20105608-64/intel-brandishes-first-google-android-tablet/#ixzz1Xw5pQIsr</a><br /></div>  ', 'c142759dc89ae8e20abc642e1dd0e99c.jpg', 'active', '2011-09-14', '0000-00-00 00:00:00'),
(5, 'en', 1, 'Windows 8 debuts at Microsoft Build (live blog)  Read more: http://news.cnet.com/8301-10805_3-20105152-75/windows-8-debuts-at-microsoft-build-live-blog/#ixzz1Xw61Mgip', '<p>A new analyst report making the rounds this morning asserts that \r\nApple''s putting the finishing touches on iOS 5, and plans to send it to \r\nits device assemblers as soon as next week. </p>\r\n<p>Analyst Ming-Chi Kuo of Concord Securities told <a href="http://www.appleinsider.com/articles/11/09/12/apple_to_release_ios_5_gm_to_assemblers_during_week_of_sept_23.html">AppleInsider</a> and <a href="http://www.macrumors.com/2011/09/12/apple-sending-ios-5-to-iphone-assemblers-at-end-of-september-no-sign-of-redesigned-iphone-5/">MacRumors</a>\r\n today that Apple should be delivering the golden master version of iOS 5\r\n between September 23 and 30. That software will then be imaged onto new\r\n devices that ship out to stores.\r\n</p>\r\n<p>The timing is of special note given expectations of a new\r\n<a href="http://www.cnet.com/apple-iphone.html">iPhone </a>and\r\n<a href="http://www.cnet.com/ipod/">iPod Touch</a> \r\nin the coming weeks. Kuo suggests it will take 10 to 12 days for \r\nshipping of new iPhones and iPod Touch units with the upgraded software,\r\n placing a higher possibility that those units won''t be available until \r\nthe second week of October. </p>\r\n<p>Apple released the latest beta version of its iOS 5 system software \r\nto developers at the tail end of August, the seventh iteration since \r\ntaking the wraps off the software at its Worldwide Developers Conference\r\n in June. So far, Apple has gone through a lengthier test process than \r\nusual, releasing a new beta of the software every few weeks ahead of the\r\n golden master, which represents the version the public gets: </p><div><br />Read more: <a href="http://news.cnet.com/8301-27076_3-20104888-248/ios-5-gold-master-expected-next-week-report-says/#ixzz1Xw6AsG9Q">http://news.cnet.com/8301-27076_3-20104888-248/ios-5-gold-master-expected-next-week-report-says/#ixzz1Xw6AsG9Q</a><br /></div>    ', '9bfe8a178df245ee90a2b5d62bfe682b.jpg', 'active', '2011-09-14', '0000-00-00 00:00:00'),
(6, 'en', 1, 'Google Street View''s naked lady', '<p>It is well accepted that, if there were commercial gain involved, \r\nGoogle might not be averse to peering inside the most intimate parts of \r\nyour life.</p>\r\n<p>However, sometimes the company manages to cast its gaze without even realizing just how close to you it is.</p>\r\n<p>I am sure some will be grateful to <a href="http://www.thesmokinggun.com/buster/google/google-street-view-naked-woman-094672">the always generous Smoking Gun</a>\r\n for leading them (in a SFW way) to a street in Miami, where a woman is \r\nstanding outside her front door naked. (The story of these interesting \r\npixels was originally broken by the <a href="http://randompixels.blogspot.com/2011/09/stay-classy-miami.html">Random Pixels blog</a>) </p>\r\n<p>Oh, of course it''s on Google Street View. Where else would you find truly unguarded moments, like <a href="http://news.cnet.com/8301-17852_3-20013500-71.html">a 10-year-old playing dead</a> or, indeed, <a href="http://news.cnet.com/8301-17852_3-20023487-71.html">a naked man in an open car trunk</a>?</p><p>In the Miami case, it appears the lady may have spotted Google''s \r\nmarauding recording vehicle, for in a subsequent shot on the site she \r\nattempts to cover up.</p>\r\n<p>The nude pose was still up in all its glory last night. However, this\r\n morning it''s blurred. What remains is merely a shot of her house and \r\nthe blurry image of a naked ghost.</p>\r\n<p>There will be those who will wonder what the naked lady might have \r\nbeen doing outside her house in a clothing-optional state. The obvious \r\nanswer would be that Miami is very hot. In this case, the naked lady \r\nappeared to be washing. Though this might have merely been a scene from \r\nyet another M. Night Shyamalan movie.</p>\r\n<p>Still, one can only wonder what other gems might still exist on a \r\nservice that, with its real-time captures of a microcosm of the world, \r\ntells us how people really spend their days. </p>  ', '22285438321c76a76dc925206f5dd5bf.png', 'active', '2011-09-14', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `title` varchar(200) NOT NULL COMMENT 'Заголовок',
  `url` varchar(250) DEFAULT NULL COMMENT 'Адрес',
  `text` text NOT NULL COMMENT 'Текст',
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Опубликована',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создана',
  PRIMARY KEY (`id`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `lang`, `title`, `url`, `text`, `is_published`, `date_create`) VALUES
(1, 'ru', 'Главная страница', '/', '<p>Yii &mdash; это высокоэффективный основанный на компонентной структуре PHP-фреймворк для     разработки масштабных веб-приложений. Он позволяет максимально применить концепцию повторного     использования кода и может существенно ускорить процесс веб-разработки. Название Yii     (произносится как Yee или [ji:]) означает простой (easy), эффективный (efficient) и расширяемый     (extensible).</p>', 1, '2011-06-25 16:23:15'),
(2, 'ru', 'О нас', '', '<p>История Yii началась 1 января 2008 года, как проект по исправлению некоторых изъянов в фреймворке PRADO (победителя &laquo;<a title="Zend Technologies" href="http://ru.wikipedia.org/wiki/Zend_Technologies">Zend</a> PHP 5 coding contest&raquo;<sup><a href="http://ru.wikipedia.org/wiki/Yii#cite_note-1">[2]</a></sup>). Например, PRADO медленно обрабатывал сложные страницы, имел крутую кривую обучения и был довольно труден в настройке.<sup><a href="http://ru.wikipedia.org/wiki/Yii#cite_note-2">[3]</a></sup> В октябре 2008 года, после более 10 месяцев закрытой разработки, вышла первая <a title="Альфа-версия" href="http://ru.wikipedia.org/wiki/%D0%90%D0%BB%D1%8C%D1%84%D0%B0-%D0%B2%D0%B5%D1%80%D1%81%D0%B8%D1%8F">альфа-версия</a>. 3 декабря 2008 был выпущен Yii 1.0<sup><a href="http://ru.wikipedia.org/wiki/Yii#cite_note-about-yii-0">[1]</a></sup></p>', 1, '2011-09-10 17:11:25'),
(3, 'en', 'Main page', '/', '<p><strong>Yii</strong> is pronounced as Yee or [ji:], and is an acroynym for "<strong>Yes It Is!</strong>". This is often the accurate, and most concise response to inquires from those new to Yii: <br />Is it fast? ... Is it secure? ... Is it professional? ... Is it right for my next project? ... <strong>Yes, it is!</strong></p>\r\n  <p>Yii is a free, open-source Web application development framework written in PHP5 that promotes clean, <a href="http://en.wikipedia.org/wiki/Don%27t_repeat_yourself" rel="nofollow">DRY</a>\r\n design and encourages rapid development. It works to streamline your \r\napplication development and helps to ensure an extremely efficient, \r\nextensible, and maintainable end product.</p>\r\n  <p>Being extremely performance optimized, Yii is a perfect choice for \r\nany sized project. However, it has been built with sophisticated, \r\nenterprise applications in mind. You have full control over the \r\nconfiguration from head-to-toe (presentation-to-persistence) to conform \r\nto your enterprise development guidelines. It comes packaged with tools \r\nto help test and debug your application, and has clear and comprehensive\r\n documentation.</p>\r\n  <p>To learn more about what Yii brings to the table, check out the <a href="http://www.yiiframework.com/features/">features section</a>.</p>  ', 1, '2011-09-11 00:00:53'),
(4, 'en', 'About us', '', '<p>Yii is the brainchild of its founder, Qiang Xue, who started the Yii project on January 1, 2008. Qiang previously developed and\r\n  maintained the <a href="http://www.pradosoft.com/" rel="nofollow">Prado</a>\r\n framework. The years of experience gained and developer feedback \r\ngathered from that project solidified the need for an extremely fast, \r\nsecure and professional framework that is tailor-made to meet the \r\nexpectations of Web 2.0 application development. On December 3, 2008, \r\nafter nearly one year''s\r\n  development, Yii 1.0 was formally released to the public.</p>\r\n  <p>Its extremely impressive performance metrics when compared to other \r\nPHP-based frameworks immediately drew very positive attention and its \r\npopularity and adoption continues to grow at an ever increasing rate.</p>    ', 1, '2011-09-11 00:33:10'),
(17, 'ru', 'ццц', '', '', 0, '2011-10-19 16:39:21');

-- --------------------------------------------------------

--
-- Table structure for table `pages_blocks`
--

CREATE TABLE IF NOT EXISTS `pages_blocks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `title` varchar(250) NOT NULL COMMENT 'Заголовок',
  `name` varchar(50) NOT NULL COMMENT 'Название (англ.)',
  `text` longtext NOT NULL COMMENT 'Текст',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлено',
  PRIMARY KEY (`id`),
  UNIQUE KEY `lang_2` (`lang`,`title`),
  UNIQUE KEY `lang_3` (`lang`,`name`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pages_blocks`
--

INSERT INTO `pages_blocks` (`id`, `lang`, `title`, `name`, `text`, `date_create`) VALUES
(1, 'en', 'Копирайт', 'copyright', '<p class="lf">© Copyright <a href="#">MyWebSite</a>.</p>\r\n            <p class="rf">Layout by Rocket <a href="http://www.rocketwebsitetemplates.com/">Website Templates</a></p>  ', '2011-09-11 00:39:54'),
(3, 'ru', 'Копирайт', 'copyright', '<p class="lf">© Copyright <a href="#">MyWebSite</a>.</p>\r\n            <p class="rf">Layout by Rocket <a href="http://www.rocketwebsitetemplates.com/">Website Templates</a></p>  ', '2011-09-13 02:41:42'),
(4, 'ru', 'Контакты', 'contacts', '<h2>Контакты</h2>\r\n                <p><a href="#">support@yoursite.com</a></p>\r\n                <p>+1 (123) 444-5677<br />\r\n                    +1 (123) 444-5678</p>\r\n                <p>Адрес: 123 TemplateAccess Rd1</p>  ', '2011-09-13 02:45:15'),
(5, 'en', 'Контакты', 'contacts', '<h2>Contact</h2>\r\n                <p><a href="#">support@yoursite.com</a></p>\r\n                <p>+1 (123) 444-5677<br />\r\n                    +1 (123) 444-5678</p>\r\n                <p>Address: 123 TemplateAccess Rd1</p>  ', '2011-09-13 02:45:40');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` varchar(50) NOT NULL COMMENT 'Модуль',
  `code` varchar(50) NOT NULL COMMENT 'Код',
  `name` varchar(100) NOT NULL COMMENT 'Заголовок',
  `value` text NOT NULL COMMENT 'Значение',
  `element` enum('text','textarea','editor') NOT NULL COMMENT 'Элемент',
  `hidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Скрыта',
  PRIMARY KEY (`id`),
  UNIQUE KEY `const` (`code`),
  UNIQUE KEY `title` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `module_id`, `code`, `name`, `value`, `element`, `hidden`) VALUES
(1, 'users', 'registration_mail_body', 'Шаблон письма регистрации', '<p>Здравствуйте {LAST_NAME} {FIRST_NAME} {PATRONYMIC}!</p>\r\n<p>Вы зарегистрировались на сайте {SITE_NAME}.</p>\r\n<p>Для завершения регистрации пройдите <a href="%7BACTIVATE_ACCOUNT_URL%7D">по этой ссылке.</a></p>\r\n<p>Адрес ссылки: {ACTIVATE_ACCOUNT_URL}</p>  ', 'editor', 0),
(7, 'users', 'registration_mail_subject', 'Тема письма регистрации', 'Регистрация на сайте {SITE_NAME}', 'text', 0),
(9, 'users', 'registration_done_message', 'Сообщение о завершении регистрации', '<p>Вы успешно зарегистрированы в системе, на ваш Email отправлено письмо с инструкциями завершения регистрации.</p>', 'editor', 0),
(10, 'users', 'activate_request_done_message', 'Сообщение после повторного запроса активации аккаунта', 'Мы выслали на ваш Email письмо, в котором нужно будет пройти по ссылке для активации аккаунта!', 'textarea', 0),
(11, 'users', 'change_password_request_mail_body', 'Шаблон письма запроса на смену пароля', '<p>Здравствуйте {LAST_NAME} {FIRST_NAME} {PATRONYMIC}!</p>\r\n<p>Вы сделали запрос на восстановление пароля на сайте {SITE_NAME}.</p>\r\n<p>Для того чтобы изменить пароль пройдите <a href="%7BLINK%7D">по этой ссылке.</a></p>\r\n<p>Адрес ссылки: {LINK}</p>  ', 'editor', 0),
(12, 'users', 'change_password_request_mail_subject', 'Тема письма запроса на смену пароля', 'Запрос на смену пароля {SITE_NAME}  ', 'editor', 0),
(13, 'mailer', 'timeout', 'Таймаут отправки (сек.)', '30', 'text', 0),
(14, 'mailer', 'signature', 'Подпись в письме', 'Данное сообщение отправлено роботом, просим Вас на него не отвечать.', 'text', 0),
(15, 'mailer', 'encoding', 'Кодировка писем', 'KOI8-U', 'text', 0),
(16, 'mailer', 'reply_address', 'Адрес для ответа', 'reply@electro-polis.ru', 'text', 0),
(17, 'mailer', 'letters_part_count', 'Отправлять писем за раз', '10\r\n', 'text', 0),
(18, 'mailer', 'dispatch_time', 'Последнее время отправки', '2011-09-30 19:15:02', 'text', 0),
(19, 'mailer', 'from_name', 'Имя от кого', 'Yii CMS сайт', 'text', 0),
(20, 'mailer', 'host', 'Хост', 'mail.el.korolevsait.ru', 'text', 0),
(21, 'mailer', 'port', 'Порт', '25', 'text', 0),
(22, 'mailer', 'login', 'Логин', 'elpolis', 'text', 0),
(23, 'mailer', 'password', 'Пароль', 'EPdEUoTn', 'text', 0),
(24, 'mailer', 'from_email', 'От кого(Email)', 'test@ya.ru', 'text', 0);

-- --------------------------------------------------------

--
-- Table structure for table `site_actions`
--

CREATE TABLE IF NOT EXISTS `site_actions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'Пользователь',
  `object_id`  int(11) unsigned NULL COMMENT 'ID объекта',
  `title` varchar(200) NOT NULL COMMENT 'Заголовок',
  `module` varchar(50) NOT NULL COMMENT 'Модуль',
  `controller` varchar(50) NOT NULL COMMENT 'Контроллер',
  `action` varchar(50) NOT NULL COMMENT 'Действие',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `site_actions`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(40) NOT NULL COMMENT 'Имя',
  `last_name` varchar(40) DEFAULT NULL COMMENT 'Фамилия',
  `patronymic` varchar(40) DEFAULT NULL COMMENT 'Отчество',
  `email` varchar(200) NOT NULL COMMENT 'Email',
  `phone` varchar(50) DEFAULT NULL COMMENT 'Мобильный телефон',
  `password` varchar(32) NOT NULL COMMENT 'Пароль',
  `birthdate` date DEFAULT NULL COMMENT 'Дата рождения',
  `gender` enum('man','woman') DEFAULT NULL COMMENT 'Пол',
  `status` enum('active','new','blocked') DEFAULT 'new' COMMENT 'Статус',
  `activate_code` varchar(32) DEFAULT NULL COMMENT 'Код активации',
  `activate_date` datetime DEFAULT NULL COMMENT 'Дата активации',
  `password_recover_code` varchar(32) DEFAULT NULL,
  `password_recover_date` datetime DEFAULT NULL,
  `avatar` varchar(50) DEFAULT NULL COMMENT 'Аватар пользователя',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Зарегистрирован',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `patronymic`, `email`, `phone`, `password`, `birthdate`, `gender`, `status`, `activate_code`, `activate_date`, `password_recover_code`, `password_recover_date`, `avatar`, `date_create`) VALUES
(1, 'Иван', 'Иванов', 'Васильевич', 'admin@ya.ru', '+7-965-1935233', 'e10adc3949ba59abbe56e057f20f883e', '2003-05-20', 'man', 'active', '070a63ae33af0eb7986992e774dc53e8',         '2011-05-21 13:18:39', NULL, NULL,              NULL, '2011-05-19 03:25:50'),
(17, 'Артем', 'Остапец', 'Игоревич', 'artem-moscow@yandex.ru', '+7-903-5492969', '813107300f254c3a072c17066c15a22a', '2011-09-25', 'man', 'new', '7533c7b47ed8206d6913e6d271b23ec3', '0000-00-00 00:00:00', NULL,NULL,                NULL,           '2011-09-22 20:19:48'),
(19, 'Алексей', 'Шаров', NULL, 'www.pismeco@gmail.com', '', '827ccb0eea8a706c4c34a16891f84e7b', '0000-00-00', '', 'active', '827ccb0eea8a706c4c34a16891f84e7b',                       '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', NULL,'2011-11-11 16:17:20');

-- --------------------------------------------------------

--
-- Table structure for table `ymarket_brands`
--

CREATE TABLE IF NOT EXISTS `ymarket_brands` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT 'Название',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=138 ;

--
-- Dumping data for table `ymarket_brands`
--

INSERT INTO `ymarket_brands` (`id`, `name`) VALUES
(31, '3Q'),
(2, 'Acer'),
(83, 'AIGO'),
(32, 'AirOn'),
(33, 'Alcatel'),
(85, 'Ambiance Technology'),
(34, 'AnyDATA'),
(3, 'Apple'),
(4, 'Aquarius'),
(86, 'Archos'),
(1, 'ASUS'),
(84, 'ATOMY'),
(35, 'BB-mobile'),
(5, 'BenQ'),
(36, 'BenQ-Siemens'),
(37, 'BlackBerry'),
(87, 'Bliss'),
(88, 'Bmorn'),
(89, 'COBY'),
(6, 'Compaq'),
(91, 'Creative'),
(90, 'CTL'),
(38, 'Daewoo'),
(7, 'DELL'),
(8, 'DEPO'),
(92, 'DigiLife'),
(93, 'Digma'),
(9, 'DNS'),
(94, 'E-Horse'),
(100, 'effire'),
(95, 'EKEN'),
(11, 'eMachines'),
(96, 'Enot'),
(39, 'Eten'),
(10, 'Eurocom'),
(97, 'Evromedia'),
(98, 'Excimer'),
(99, 'ExoPC'),
(40, 'Explay'),
(41, 'Fly'),
(12, 'Fujitsu'),
(13, 'Fujitsu-Siemens'),
(42, 'Garmin-Asus'),
(15, 'Getac'),
(14, 'GIGABYTE'),
(102, 'Globex'),
(101, 'GOCLEVER'),
(43, 'Google'),
(103, 'Gpad'),
(44, 'Gresso'),
(104, 'HaiPad'),
(46, 'Handheld'),
(47, 'Handyuhr'),
(48, 'Highscreen'),
(49, 'Hisense'),
(16, 'HP'),
(45, 'HTC'),
(50, 'Huawei'),
(106, 'IconBit'),
(110, 'iiView'),
(107, 'Impression'),
(108, 'iRobot'),
(109, 'iRos'),
(17, 'iRu'),
(51, 'iTravel'),
(105, 'IVIO'),
(52, 'JOA Telecom'),
(111, 'joinTech'),
(53, 'Just5'),
(54, 'Kyocera'),
(19, 'Lenovo'),
(18, 'LG'),
(55, 'Magic'),
(113, 'Maylong'),
(114, 'Mebol'),
(115, 'Miotex'),
(112, 'MIReader'),
(56, 'Mitac'),
(57, 'Mobiado'),
(116, 'Moonse'),
(58, 'Motorola'),
(117, 'MoveO!'),
(20, 'MSI'),
(118, 'Netbook Navigator'),
(21, 'Nokia'),
(119, 'Notion Ink'),
(122, 'Odeon'),
(120, 'OLT'),
(59, 'ONEXT'),
(121, 'OODO'),
(123, 'Open Star'),
(124, 'Oysters'),
(22, 'Packard Bell'),
(60, 'Palm'),
(23, 'Panasonic'),
(61, 'Pantech-Curitel'),
(126, 'Pegatron'),
(127, 'Perfeo'),
(62, 'Philips'),
(24, 'Point of View'),
(63, 'Porsche'),
(125, 'POSH-PAD'),
(128, 'Prestige'),
(129, 'Prestigio'),
(131, 'qBox'),
(64, 'Qtek'),
(130, 'Qumo'),
(65, 'Rover PC'),
(25, 'Roverbook'),
(132, 'RoverPad'),
(26, 'Samsung'),
(66, 'Seals'),
(67, 'Siemens'),
(68, 'Sitronics'),
(133, 'Smart Devices'),
(69, 'Sonim'),
(27, 'Sony'),
(70, 'Sony Ericsson'),
(134, 'Starway'),
(71, 'Tag Heuer'),
(72, 'TeXet'),
(28, 'Toshiba'),
(73, 'Ubiquam'),
(74, 'VEON'),
(75, 'Versace'),
(76, 'Vertu'),
(29, 'Viewsonic'),
(30, 'viliv'),
(77, 'Voxtel'),
(78, 'Watchtech'),
(135, 'YIFANG Digital'),
(79, 'Zakang'),
(137, 'Zenithink'),
(136, 'ZTE'),
(80, 'Билайн'),
(82, 'МегаФон'),
(81, 'МТС');

-- --------------------------------------------------------

--
-- Table structure for table `ymarket_crons`
--

CREATE TABLE IF NOT EXISTS `ymarket_crons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL COMMENT 'Название',
  `method` varchar(100) NOT NULL COMMENT 'Метод',
  `is_active` tinyint(1) NOT NULL COMMENT 'Активен',
  `priority` tinyint(1) NOT NULL COMMENT 'Приоритет',
  `interval` int(11) NOT NULL COMMENT 'Интервал (в сек.)',
  `date_of` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата работы',
  PRIMARY KEY (`id`),
  UNIQUE KEY `method` (`method`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ymarket_crons`
--

INSERT INTO `ymarket_crons` (`id`, `name`, `method`, `is_active`, `priority`, `interval`, `date_of`) VALUES
(3, 'Парсинг страниц с продуктами', 'ParsePages', 1, 3, 10, '2011-09-21 17:37:34'),
(4, 'Парсинг продуктов', 'ParseProducts', 1, 4, 1, '2011-09-21 15:59:56');

-- --------------------------------------------------------

--
-- Table structure for table `ymarket_ips`
--

CREATE TABLE IF NOT EXISTS `ymarket_ips` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(40) NOT NULL COMMENT 'IP адрес',
  `last_date_use` datetime NOT NULL COMMENT 'Дата последнего использования',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлен',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ip` (`ip`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `ymarket_ips`
--

INSERT INTO `ymarket_ips` (`id`, `ip`, `last_date_use`, `date_create`) VALUES
(1, '193.169.87.35', '2011-09-21 14:37:24', '2011-09-13 17:38:07'),
(2, '193.169.86.18', '2011-09-21 14:34:33', '2011-09-13 17:38:07'),
(3, '193.169.86.40', '2011-09-21 14:34:34', '2011-09-13 17:38:07'),
(4, '193.169.87.18', '2011-09-21 14:37:23', '2011-09-13 17:38:07'),
(5, '193.169.87.40', '2011-09-21 14:36:25', '2011-09-13 17:38:07'),
(6, '91.213.8.246', '2011-09-21 14:36:23', '2011-09-13 17:38:07'),
(7, '91.213.8.245', '2011-09-21 14:35:24', '2011-09-13 17:38:07'),
(8, '91.207.60.160', '2011-09-21 14:31:24', '2011-09-13 17:38:07'),
(9, '91.207.60.161', '2011-09-21 14:35:23', '2011-09-13 17:38:07'),
(10, '91.207.60.162', '2011-09-21 14:34:23', '2011-09-13 17:38:07'),
(11, '91.207.60.163', '2011-09-21 14:33:24', '2011-09-13 17:38:07'),
(12, '91.207.60.164', '2011-09-21 14:33:23', '2011-09-13 17:38:07'),
(13, '91.207.60.165', '2011-09-21 14:32:25', '2011-09-13 17:38:07'),
(14, '91.207.60.166', '2011-09-21 14:32:23', '2011-09-13 17:38:07'),
(15, '91.207.60.167', '2011-09-21 14:31:23', '2011-09-13 17:38:07'),
(16, '91.207.60.168', '2011-09-21 14:38:33', '2011-09-13 17:38:07'),
(17, '91.207.60.169', '2011-09-21 14:30:25', '2011-09-13 17:38:07'),
(18, '91.207.60.170', '2011-09-21 14:30:22', '2011-09-13 17:38:07'),
(19, '91.207.60.171', '2011-09-21 14:29:24', '2011-09-13 17:38:07'),
(20, '91.207.61.160', '2011-09-21 14:29:23', '2011-09-13 17:38:07'),
(21, '91.207.61.161', '2011-09-21 14:28:27', '2011-09-13 17:38:07'),
(22, '91.207.61.162', '2011-09-21 14:28:24', '2011-09-13 17:38:07'),
(23, '91.207.61.163', '2011-09-21 14:27:25', '2011-09-13 17:38:07'),
(24, '91.207.61.164', '2011-09-21 14:27:23', '2011-09-13 17:38:07'),
(25, '91.207.61.165', '2011-09-21 14:40:24', '2011-09-13 17:38:07'),
(26, '91.207.61.166', '2011-09-21 14:40:23', '2011-09-13 17:38:07'),
(27, '91.207.61.167', '2011-09-21 14:39:24', '2011-09-13 17:38:07'),
(28, '91.207.61.168', '2011-09-21 14:39:23', '2011-09-13 17:38:07'),
(29, '91.207.61.169', '2011-09-21 14:38:35', '2011-09-13 17:38:07'),
(30, '91.207.61.170', '2011-09-21 14:30:26', '2011-09-13 17:38:07'),
(31, '91.207.61.171', '2011-09-21 14:38:23', '2011-09-13 17:38:07');

-- --------------------------------------------------------

--
-- Table structure for table `ymarket_pages`
--

CREATE TABLE IF NOT EXISTS `ymarket_pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `section_id` int(11) unsigned NOT NULL COMMENT 'Раздел',
  `url` varchar(500) NOT NULL COMMENT 'URL',
  `num` int(11) NOT NULL COMMENT 'Номер',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_parse` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `ymarket_pages`
--

INSERT INTO `ymarket_pages` (`id`, `section_id`, `url`, `num`, `date_create`, `date_parse`) VALUES
(1, 2, '/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=10-EXC=1-PG=10&amp;greed_mode=false', 2, '2011-09-21 15:58:26', '2011-09-21 15:58:26'),
(2, 2, '/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=20-EXC=1-PG=10&amp;greed_mode=false', 3, '2011-09-21 15:58:26', '2011-09-21 15:59:18'),
(3, 2, '/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=30-EXC=1-PG=10&amp;greed_mode=false', 4, '2011-09-21 15:58:26', '2011-09-21 15:59:46'),
(4, 2, '/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=40-EXC=1-PG=10&amp;greed_mode=false', 5, '2011-09-21 15:58:26', NULL),
(5, 2, '/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=50-EXC=1-PG=10&amp;greed_mode=false', 6, '2011-09-21 15:58:26', NULL),
(6, 2, '/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=60-EXC=1-PG=10&amp;greed_mode=false', 7, '2011-09-21 15:58:26', NULL),
(7, 2, '/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=70-EXC=1-PG=10&amp;greed_mode=false', 8, '2011-09-21 15:58:26', NULL),
(8, 1, '/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=10-EXC=1-PG=10&amp;greed_mode=false', 2, '2011-09-21 15:59:18', NULL),
(9, 1, '/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=20-EXC=1-PG=10&amp;greed_mode=false', 3, '2011-09-21 15:59:18', NULL),
(10, 1, '/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=30-EXC=1-PG=10&amp;greed_mode=false', 4, '2011-09-21 15:59:18', NULL),
(11, 1, '/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=40-EXC=1-PG=10&amp;greed_mode=false', 5, '2011-09-21 15:59:18', NULL),
(12, 1, '/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=50-EXC=1-PG=10&amp;greed_mode=false', 6, '2011-09-21 15:59:18', NULL),
(13, 1, '/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=60-EXC=1-PG=10&amp;greed_mode=false', 7, '2011-09-21 15:59:18', NULL),
(14, 1, '/guru.xml?hid=91013&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=432460-BPOS=70-EXC=1-PG=10&amp;greed_mode=false', 8, '2011-09-21 15:59:18', NULL),
(15, 3, '/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=10-EXC=1-PG=10&amp;greed_mode=false', 2, '2011-09-21 15:59:46', NULL),
(16, 3, '/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=20-EXC=1-PG=10&amp;greed_mode=false', 3, '2011-09-21 15:59:46', NULL),
(17, 3, '/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=30-EXC=1-PG=10&amp;greed_mode=false', 4, '2011-09-21 15:59:46', NULL),
(18, 3, '/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=40-EXC=1-PG=10&amp;greed_mode=false', 5, '2011-09-21 15:59:46', NULL),
(19, 3, '/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=50-EXC=1-PG=10&amp;greed_mode=false', 6, '2011-09-21 15:59:46', NULL),
(20, 3, '/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=60-EXC=1-PG=10&amp;greed_mode=false', 7, '2011-09-21 15:59:46', NULL),
(21, 3, '/guru.xml?hid=6427100&amp;CMD=-RR=0,0,0,0-VIS=201E2-CAT_ID=6427101-BPOS=70-EXC=1-PG=10&amp;greed_mode=false', 8, '2011-09-21 15:59:46', NULL),
(22, 2, '/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-EXC=1-PG=10&amp;greed_mode=false', 1, '2011-09-21 17:37:34', NULL),
(23, 2, '/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=80-EXC=1-PG=10&amp;greed_mode=false', 9, '2011-09-21 17:37:34', NULL),
(24, 2, '/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=90-EXC=1-PG=10&amp;greed_mode=false', 10, '2011-09-21 17:37:34', NULL),
(25, 2, '/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=100-EXC=1-PG=10&amp;greed_mode=false', 11, '2011-09-21 17:37:34', NULL),
(26, 2, '/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=110-EXC=1-PG=10&amp;greed_mode=false', 12, '2011-09-21 17:37:34', NULL),
(27, 2, '/guru.xml?hid=91491&amp;CMD=-RR=9,0,0,0-VIS=201E2-CAT_ID=160043-BPOS=120-EXC=1-PG=10&amp;greed_mode=false', 13, '2011-09-21 17:37:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ymarket_products`
--

CREATE TABLE IF NOT EXISTS `ymarket_products` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) unsigned DEFAULT '0' COMMENT 'Брэнд',
  `name` varchar(150) NOT NULL COMMENT 'Название',
  `image` varchar(38) DEFAULT NULL COMMENT 'Картинка',
  `desc_html` text COMMENT 'Описание (HTML)',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлен',
  `date_update` datetime DEFAULT NULL COMMENT 'Дата обновления ',
  PRIMARY KEY (`id`),
  UNIQUE KEY `brand_id_name` (`brand_id`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1811 ;

--
-- Dumping data for table `ymarket_products`
--

INSERT INTO `ymarket_products` (`id`, `brand_id`, `name`, `image`, `desc_html`, `date_create`, `date_update`) VALUES
(1781, 26, ' S5830 Galaxy Ace', '1781.jpg', '<h3 class="b-offers__title"><a id="item-href-6976935" class="b-offers__name" href="/model.xml?modelid=6976935&amp;hid=91491">Samsung S5830 Galaxy Ace</a><sup class="b-offers__new">новинка</sup><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">8 900</span> до <span class="b-prices__num">11 990</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:58:27', NULL),
(1782, 21, ' E72', '1782.jpg', '<h3 class="b-offers__title"><a id="item-href-4742402" class="b-offers__name" href="/model.xml?modelid=4742402&amp;hid=91491">Nokia E72</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">8 400</span> до <span class="b-prices__num">14 080</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:58:28', NULL),
(1783, 21, ' N8', '1783.jpg', '<h3 class="b-offers__title"><a id="item-href-6168859" class="b-offers__name" href="/model.xml?modelid=6168859&amp;hid=91491">Nokia N8</a><sup class="b-offers__new">новинка</sup><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">13 380</span> до <span class="b-prices__num">19 580</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:58:30', NULL),
(1784, 26, ' B7722', '1784.jpg', '<h3 class="b-offers__title"><a id="item-href-6209440" class="b-offers__name" href="/model.xml?modelid=6209440&amp;hid=91491">Samsung B7722</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">6 750</span> до <span class="b-prices__num">11 990</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:58:30', NULL),
(1785, 3, ' iPhone 3GS 8Gb', '1785.jpg', '<h3 class="b-offers__title"><a id="item-href-6408887" class="b-offers__name" href="/model.xml?modelid=6408887&amp;hid=91491">Apple iPhone 3GS 8Gb</a><sup class="b-offers__new">новинка</sup><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">14 679</span> до <span class="b-prices__num">23 000</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:58:31', NULL),
(1786, 27, ' Ericsson Xperia Neo', '1786.jpg', '<h3 class="b-offers__title"><a id="item-href-7012978" class="b-offers__name" href="/model.xml?modelid=7012978&amp;hid=91491">Sony Ericsson Xperia Neo</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">11 880</span> до <span class="b-prices__num">18 000</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:58:32', NULL),
(1787, 21, ' C7-00', '1787.jpg', '<h3 class="b-offers__title"><a id="item-href-6413578" class="b-offers__name" href="/model.xml?modelid=6413578&amp;hid=91491">Nokia C7-00</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">9 990</span> до <span class="b-prices__num">15 635</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:58:33', NULL),
(1788, 27, ' Ericsson Vivaz', '1788.jpg', '<h3 class="b-offers__title"><a id="item-href-6029832" class="b-offers__name" href="/model.xml?modelid=6029832&amp;hid=91491">Sony Ericsson Vivaz</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">6 980</span> до <span class="b-prices__num">12 190</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:58:34', NULL),
(1789, 21, ' C5-03', '1789.jpg', '<h3 class="b-offers__title"><a id="item-href-6472840" class="b-offers__name" href="/model.xml?modelid=6472840&amp;hid=91491">Nokia C5-03</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other-half"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">6 290</span> до <span class="b-prices__num">13 000</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:58:35', NULL),
(1790, 26, ' Galaxy S Plus I9001', '1790.jpg', '<h3 class="b-offers__title"><a id="item-href-7187687" class="b-offers__name" href="/model.xml?modelid=7187687&amp;hid=91491">Samsung Galaxy S Plus I9001</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">13 150</span> до <span class="b-prices__num">19 990</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:58:36', NULL),
(1791, 21, ' 5230', '1791.jpg', '<h3 class="b-offers__title"><a id="item-href-4929241" class="b-offers__name" href="/model.xml?modelid=4929241&amp;hid=91491">Nokia 5230</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">5 264</span> до <span class="b-prices__num">6 948</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:20', NULL),
(1792, 26, ' GT-I9000 Galaxy S', '1792.jpg', '<h3 class="b-offers__title"><a id="item-href-6131829" class="b-offers__name" href="/model.xml?modelid=6131829&amp;hid=91491">Samsung GT-I9000 Galaxy S</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">12 250</span> до <span class="b-prices__num">24 990</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:21', NULL),
(1793, 21, ' C3', '1793.jpg', '<h3 class="b-offers__title"><a id="item-href-6152258" class="b-offers__name" href="/model.xml?modelid=6152258&amp;hid=91491">Nokia C3</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">3 798</span> до <span class="b-prices__num">5 000</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:22', NULL),
(1794, 26, ' Wave 525', '1794.jpg', '<h3 class="b-offers__title"><a id="item-href-6229012" class="b-offers__name" href="/model.xml?modelid=6229012&amp;hid=91491">Samsung Wave 525</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other-half"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">4 198</span> до <span class="b-prices__num">7 990</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:23', NULL),
(1795, 27, ' Ericsson Xperia X8', '1795.jpg', '<h3 class="b-offers__title"><a id="item-href-6229003" class="b-offers__name" href="/model.xml?modelid=6229003&amp;hid=91491">Sony Ericsson Xperia X8</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">5 570</span> до <span class="b-prices__num">8 762</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:23', NULL),
(1796, 21, ' X3-02', '1796.jpg', '<h3 class="b-offers__title"><a id="item-href-6374952" class="b-offers__name" href="/model.xml?modelid=6374952&amp;hid=91491">Nokia X3-02</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">5 099</span> до <span class="b-prices__num">6 600</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:24', NULL),
(1797, 26, ' GT-S5230 Star', '1797.jpg', '<h3 class="b-offers__title"><a id="item-href-4578928" class="b-offers__name" href="/model.xml?modelid=4578928&amp;hid=91491">Samsung GT-S5230 Star</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">3 150</span> до <span class="b-prices__num">5 090</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:25', NULL),
(1798, 21, ' E5', '1798.jpg', '<h3 class="b-offers__title"><a id="item-href-6152260" class="b-offers__name" href="/model.xml?modelid=6152260&amp;hid=91491">Nokia E5</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">6 400</span> до <span class="b-prices__num">9 200</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:26', NULL),
(1799, 21, ' C3 Touch and Type', '1799.jpg', '<h3 class="b-offers__title"><a id="item-href-6416469" class="b-offers__name" href="/model.xml?modelid=6416469&amp;hid=91491">Nokia C3 Touch and Type</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">5 587</span> до <span class="b-prices__num">9 990</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:26', NULL),
(1800, 21, ' E52', '1800.jpg', '<h3 class="b-offers__title"><a id="item-href-4676988" class="b-offers__name" href="/model.xml?modelid=4676988&amp;hid=91491">Nokia E52</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">7 550</span> до <span class="b-prices__num">10 109</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:27', NULL),
(1801, 26, ' S5570 Galaxy Mini', '1801.jpg', '<h3 class="b-offers__title"><a id="item-href-6944193" class="b-offers__name" href="/model.xml?modelid=6944193&amp;hid=91491">Samsung S5570 Galaxy Mini</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">5 598</span> до <span class="b-prices__num">7 800</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:48', NULL),
(1802, 21, ' 7230', '1802.jpg', '<h3 class="b-offers__title"><a id="item-href-5139257" class="b-offers__name" href="/model.xml?modelid=5139257&amp;hid=91491">Nokia 7230</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">3 900</span> до <span class="b-prices__num">5 135</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:49', NULL),
(1803, 21, ' E6', '1803.jpg', '<h3 class="b-offers__title"><a id="item-href-7163936" class="b-offers__name" href="/model.xml?modelid=7163936&amp;hid=91491">Nokia E6</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">11 850</span> до <span class="b-prices__num">16 490</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:50', NULL),
(1804, 21, ' X2-00', '1804.jpg', '<h3 class="b-offers__title"><a id="item-href-6175532" class="b-offers__name" href="/model.xml?modelid=6175532&amp;hid=91491">Nokia X2-00</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other-half"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">3 597</span> до <span class="b-prices__num">5 950</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:50', NULL),
(1805, 26, ' C6712 Star II DUOS', '1805.jpg', '<h3 class="b-offers__title"><a id="item-href-7163941" class="b-offers__name" href="/model.xml?modelid=7163941&amp;hid=91491">Samsung C6712 Star II DUOS</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">4 800</span> до <span class="b-prices__num">6 990</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:51', NULL),
(1806, 21, ' 5228', '1806.jpg', '<h3 class="b-offers__title"><a id="item-href-6223484" class="b-offers__name" href="/model.xml?modelid=6223484&amp;hid=91491">Nokia 5228</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">4 248</span> до <span class="b-prices__num">6 442</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:52', NULL),
(1807, 21, ' E7', '1807.jpg', '<h3 class="b-offers__title"><a id="item-href-6413579" class="b-offers__name" href="/model.xml?modelid=6413579&amp;hid=91491">Nokia E7</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">14 800</span> до <span class="b-prices__num">30 890</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:53', NULL),
(1808, 21, ' C5-00', '1808.jpg', '<h3 class="b-offers__title"><a id="item-href-6097484" class="b-offers__name" href="/model.xml?modelid=6097484&amp;hid=91491">Nokia C5-00</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">5 290</span> до <span class="b-prices__num">7 000</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:53', NULL),
(1809, 21, ' C6-01', '1809.jpg', '<h3 class="b-offers__title"><a id="item-href-6477764" class="b-offers__name" href="/model.xml?modelid=6477764&amp;hid=91491">Nokia C6-01</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">8 350</span> до <span class="b-prices__num">14 175</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:54', NULL),
(1810, 26, ' GT-S3600', '1810.jpg', '<h3 class="b-offers__title"><a id="item-href-2701792" class="b-offers__name" href="/model.xml?modelid=2701792&amp;hid=91491">Samsung GT-S3600</a><span class="b-rating b-rating_type_10 b-rating_type_model" title="рейтинг товара"><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star b-rating__star-other"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span><span title="" class="b-rating__star"><img class="b-rating__icon" src="/_c/Z3jABDSRezQ_Z675TetexLKEBD4.png" alt="*"></span></span></h3><div class="b-offers__price"><span class="b-prices b-prices__range">от <span class="b-prices__num">2 540</span> до <span class="b-prices__num">7 500</span><span class="b-prices__currency"> руб.</span></span>', '2011-09-21 15:59:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ymarket_sections`
--

CREATE TABLE IF NOT EXISTS `ymarket_sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT 'Название',
  `yandex_name` varchar(100) DEFAULT NULL COMMENT 'Название(Яндекс)',
  `url` varchar(250) NOT NULL COMMENT 'URL',
  `all_models_url` varchar(250) DEFAULT NULL COMMENT 'URL на все модели',
  `brands_url` varchar(250) DEFAULT NULL COMMENT 'URL на производителей',
  `breadcrumbs` text COMMENT 'Путь',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлено',
  `date_update` datetime DEFAULT NULL COMMENT 'Дата обновления',
  `date_brand_update` datetime DEFAULT NULL COMMENT 'Дата обновления брендов',
  `date_pages_parse` datetime DEFAULT NULL COMMENT 'Дата парсинга страниц',
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`),
  UNIQUE KEY `yandex_name` (`yandex_name`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `ymarket_sections`
--

INSERT INTO `ymarket_sections` (`id`, `name`, `yandex_name`, `url`, `all_models_url`, `brands_url`, `breadcrumbs`, `date_create`, `date_update`, `date_brand_update`, `date_pages_parse`) VALUES
(1, 'Ноутбуки', 'Ноутбуки', 'http://market.yandex.ru/catalogmodels.xml?CAT_ID=432460&hid=91013', '/guru.xml?CMD=-RR=9,0,0,0-VIS=160-CAT_ID=432460-EXC=1-PG=10&hid=91013', '/vendors.xml?CAT_ID=432460&hid=91013', '<a class="b-breadcrumbs__link" href="/catalog.xml?hid=91009">Компьютеры</a>', '2011-09-13 20:10:16', '2011-09-21 15:56:08', '2011-09-21 15:57:01', '2011-09-21 15:59:15'),
(2, NULL, 'Сотовые телефоны', 'http://market.yandex.ru/catalogmodels.xml?CAT_ID=160043&hid=91491', '/guru.xml?CMD=-RR=9,0,0,0-VIS=160-CAT_ID=160043-EXC=1-PG=10&hid=91491', '/vendors.xml?CAT_ID=160043&hid=91491', '<a class="b-breadcrumbs__link" href="/catalog.xml?hid=91461">Телефоны</a>', '2011-09-13 20:11:04', '2011-09-21 15:56:10', '2011-09-21 15:57:09', '2011-09-21 17:37:32'),
(3, NULL, 'Планшеты', 'http://market.yandex.ru/catalogmodels.xml?CAT_ID=6427101&hid=6427100', '/guru.xml?CMD=-RR=0,0,0,0-VIS=160-CAT_ID=6427101-EXC=1-PG=10&hid=6427100', '/vendors.xml?CAT_ID=6427101&hid=6427100', '<a class="b-breadcrumbs__link" href="/catalog.xml?hid=91009">Компьютеры</a>', '2011-09-20 20:18:16', '2011-09-21 15:56:11', '2011-09-21 15:57:18', '2011-09-21 15:59:45');

-- --------------------------------------------------------

--
-- Table structure for table `ymarket_sections_rels`
--

CREATE TABLE IF NOT EXISTS `ymarket_sections_rels` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `section_id` int(11) unsigned NOT NULL,
  `object_id` int(11) unsigned NOT NULL,
  `object_type` enum('brand','product') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `section_id_object_id_object_type` (`section_id`,`object_id`,`object_type`),
  KEY `section_id` (`section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=176 ;

--
-- Dumping data for table `ymarket_sections_rels`
--

INSERT INTO `ymarket_sections_rels` (`id`, `section_id`, `object_id`, `object_type`) VALUES
(1, 1, 1, 'brand'),
(2, 1, 2, 'brand'),
(3, 1, 3, 'brand'),
(4, 1, 4, 'brand'),
(5, 1, 5, 'brand'),
(6, 1, 6, 'brand'),
(7, 1, 7, 'brand'),
(8, 1, 8, 'brand'),
(9, 1, 9, 'brand'),
(10, 1, 10, 'brand'),
(11, 1, 11, 'brand'),
(12, 1, 12, 'brand'),
(13, 1, 13, 'brand'),
(14, 1, 14, 'brand'),
(15, 1, 15, 'brand'),
(16, 1, 16, 'brand'),
(17, 1, 17, 'brand'),
(18, 1, 18, 'brand'),
(19, 1, 19, 'brand'),
(20, 1, 20, 'brand'),
(21, 1, 21, 'brand'),
(22, 1, 22, 'brand'),
(23, 1, 23, 'brand'),
(24, 1, 24, 'brand'),
(25, 1, 25, 'brand'),
(26, 1, 26, 'brand'),
(27, 1, 27, 'brand'),
(28, 1, 28, 'brand'),
(29, 1, 29, 'brand'),
(30, 1, 30, 'brand'),
(31, 1, 31, 'brand'),
(32, 2, 1, 'brand'),
(33, 2, 2, 'brand'),
(37, 2, 3, 'brand'),
(41, 2, 7, 'brand'),
(46, 2, 14, 'brand'),
(48, 2, 15, 'brand'),
(51, 2, 16, 'brand'),
(62, 2, 18, 'brand'),
(67, 2, 21, 'brand'),
(75, 2, 26, 'brand'),
(83, 2, 28, 'brand'),
(34, 2, 32, 'brand'),
(35, 2, 33, 'brand'),
(36, 2, 34, 'brand'),
(38, 2, 35, 'brand'),
(39, 2, 36, 'brand'),
(40, 2, 37, 'brand'),
(42, 2, 38, 'brand'),
(43, 2, 39, 'brand'),
(44, 2, 40, 'brand'),
(45, 2, 41, 'brand'),
(47, 2, 42, 'brand'),
(49, 2, 43, 'brand'),
(50, 2, 44, 'brand'),
(52, 2, 45, 'brand'),
(53, 2, 46, 'brand'),
(54, 2, 47, 'brand'),
(55, 2, 48, 'brand'),
(56, 2, 49, 'brand'),
(57, 2, 50, 'brand'),
(58, 2, 51, 'brand'),
(59, 2, 52, 'brand'),
(60, 2, 53, 'brand'),
(61, 2, 54, 'brand'),
(63, 2, 55, 'brand'),
(64, 2, 56, 'brand'),
(65, 2, 57, 'brand'),
(66, 2, 58, 'brand'),
(68, 2, 59, 'brand'),
(69, 2, 60, 'brand'),
(70, 2, 61, 'brand'),
(71, 2, 62, 'brand'),
(72, 2, 63, 'brand'),
(73, 2, 64, 'brand'),
(74, 2, 65, 'brand'),
(76, 2, 66, 'brand'),
(77, 2, 67, 'brand'),
(78, 2, 68, 'brand'),
(79, 2, 69, 'brand'),
(80, 2, 70, 'brand'),
(81, 2, 71, 'brand'),
(82, 2, 72, 'brand'),
(84, 2, 73, 'brand'),
(85, 2, 74, 'brand'),
(86, 2, 75, 'brand'),
(87, 2, 76, 'brand'),
(88, 2, 77, 'brand'),
(89, 2, 78, 'brand'),
(90, 2, 79, 'brand'),
(91, 2, 80, 'brand'),
(92, 2, 81, 'brand'),
(93, 2, 82, 'brand'),
(95, 3, 1, 'brand'),
(97, 3, 2, 'brand'),
(99, 3, 3, 'brand'),
(107, 3, 7, 'brand'),
(119, 3, 12, 'brand'),
(120, 3, 14, 'brand'),
(122, 3, 15, 'brand'),
(125, 3, 16, 'brand'),
(134, 3, 17, 'brand'),
(137, 3, 18, 'brand'),
(138, 3, 19, 'brand'),
(140, 3, 20, 'brand'),
(157, 3, 24, 'brand'),
(163, 3, 26, 'brand'),
(167, 3, 28, 'brand'),
(168, 3, 29, 'brand'),
(169, 3, 30, 'brand'),
(173, 3, 31, 'brand'),
(101, 3, 37, 'brand'),
(116, 3, 40, 'brand'),
(118, 3, 41, 'brand'),
(126, 3, 45, 'brand'),
(128, 3, 50, 'brand'),
(145, 3, 58, 'brand'),
(166, 3, 72, 'brand'),
(174, 3, 80, 'brand'),
(175, 3, 81, 'brand'),
(94, 3, 83, 'brand'),
(96, 3, 84, 'brand'),
(98, 3, 85, 'brand'),
(100, 3, 86, 'brand'),
(102, 3, 87, 'brand'),
(103, 3, 88, 'brand'),
(104, 3, 89, 'brand'),
(105, 3, 90, 'brand'),
(106, 3, 91, 'brand'),
(108, 3, 92, 'brand'),
(109, 3, 93, 'brand'),
(110, 3, 94, 'brand'),
(111, 3, 95, 'brand'),
(112, 3, 96, 'brand'),
(113, 3, 97, 'brand'),
(114, 3, 98, 'brand'),
(115, 3, 99, 'brand'),
(117, 3, 100, 'brand'),
(121, 3, 101, 'brand'),
(123, 3, 102, 'brand'),
(124, 3, 103, 'brand'),
(127, 3, 104, 'brand'),
(129, 3, 105, 'brand'),
(130, 3, 106, 'brand'),
(131, 3, 107, 'brand'),
(132, 3, 108, 'brand'),
(133, 3, 109, 'brand'),
(135, 3, 110, 'brand'),
(136, 3, 111, 'brand'),
(139, 3, 112, 'brand'),
(141, 3, 113, 'brand'),
(142, 3, 114, 'brand'),
(143, 3, 115, 'brand'),
(144, 3, 116, 'brand'),
(146, 3, 117, 'brand'),
(147, 3, 118, 'brand'),
(148, 3, 119, 'brand'),
(149, 3, 120, 'brand'),
(150, 3, 121, 'brand'),
(151, 3, 122, 'brand'),
(152, 3, 123, 'brand'),
(153, 3, 124, 'brand'),
(154, 3, 125, 'brand'),
(155, 3, 126, 'brand'),
(156, 3, 127, 'brand'),
(158, 3, 128, 'brand'),
(159, 3, 129, 'brand'),
(160, 3, 130, 'brand'),
(161, 3, 131, 'brand'),
(162, 3, 132, 'brand'),
(164, 3, 133, 'brand'),
(165, 3, 134, 'brand'),
(170, 3, 135, 'brand'),
(171, 3, 136, 'brand'),
(172, 3, 137, 'brand');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `actions_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `actions_files`
--
ALTER TABLE `actions_files`
  ADD CONSTRAINT `actions_files_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `articles_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `articles_sections`
--
ALTER TABLE `articles_sections`
  ADD CONSTRAINT `articles_sections_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `articles_sections` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_sections_ibfk_2` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_assignments`
--
ALTER TABLE `auth_assignments`
  ADD CONSTRAINT `auth_assignments_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_assignments_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_items_childs`
--
ALTER TABLE `auth_items_childs`
  ADD CONSTRAINT `auth_items_childs_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_items_childs_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_objects`
--
ALTER TABLE `auth_objects`
  ADD CONSTRAINT `auth_objects_ibfk_1` FOREIGN KEY (`role`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `banners`
--
ALTER TABLE `banners`
  ADD CONSTRAINT `banners_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `banners_roles`
--
ALTER TABLE `banners_roles`
  ADD CONSTRAINT `banners_roles_ibfk_2` FOREIGN KEY (`role`) REFERENCES `auth_items` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `banners_roles_ibfk_1` FOREIGN KEY (`banner_id`) REFERENCES `banners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `documents_files`
--
ALTER TABLE `documents_files`
  ADD CONSTRAINT `documents_files_ibfk_1` FOREIGN KEY (`document_id`) REFERENCES `documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faq`
--
ALTER TABLE `faq`
  ADD CONSTRAINT `faq_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `faq_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `faq_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `faq_sections`
--
ALTER TABLE `faq_sections`
  ADD CONSTRAINT `faq_sections_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `mailer_letters`
--
ALTER TABLE `mailer_letters`
  ADD CONSTRAINT `mailer_letters_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `mailer_templates` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `mailer_recipients`
--
ALTER TABLE `mailer_recipients`
  ADD CONSTRAINT `mailer_recipients_ibfk_1` FOREIGN KEY (`letter_id`) REFERENCES `mailer_letters` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mailer_recipients_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mailer_templates_recipients`
--
ALTER TABLE `mailer_templates_recipients`
  ADD CONSTRAINT `mailer_templates_recipients_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `mailer_templates` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mailer_templates_recipients_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu_links`
--
ALTER TABLE `menu_links`
  ADD CONSTRAINT `menu_links_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `menu_links` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_2` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_3` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_4` FOREIGN KEY (`user_role`) REFERENCES `auth_items` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_5` FOREIGN KEY (`not_user_role`) REFERENCES `auth_items` (`name`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_links_ibfk_6` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `news_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pages`
--
ALTER TABLE `pages`
  ADD CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pages_blocks`
--
ALTER TABLE `pages_blocks`
  ADD CONSTRAINT `pages_blocks_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `site_actions`
--
ALTER TABLE `site_actions`
  ADD CONSTRAINT `site_actions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ymarket_pages`
--
ALTER TABLE `ymarket_pages`
  ADD CONSTRAINT `ymarket_pages_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `ymarket_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ymarket_products`
--
ALTER TABLE `ymarket_products`
  ADD CONSTRAINT `barnd_fk` FOREIGN KEY (`brand_id`) REFERENCES `ymarket_brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ymarket_sections_rels`
--
ALTER TABLE `ymarket_sections_rels`
  ADD CONSTRAINT `section_fk` FOREIGN KEY (`section_id`) REFERENCES `ymarket_sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

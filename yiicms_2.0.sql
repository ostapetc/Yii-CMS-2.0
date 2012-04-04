-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 03, 2012 at 11:35 PM
-- Server version: 5.1.58
-- PHP Version: 5.3.6-13ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yiicms_2.0`
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
('Admin_Pages', 1, 'Редактирование страниц', NULL, 's:0:"";', 0),
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
('Help_Captcha', 0, NULL, NULL, NULL, 1),
('Help_Sitemap', 0, NULL, NULL, NULL, 1),
('Help_Sitemapxml', 0, NULL, NULL, NULL, 1),
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
('User_Registration', 0, 'Регистрация', NULL, 'N;', 1),
('View_Pages', 1, 'Просмотр страниц', NULL, 's:0:"";', 0),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) unsigned NOT NULL COMMENT 'Тема',
  `name` varchar(200) NOT NULL COMMENT 'Имя',
  `email` varchar(200) NOT NULL COMMENT 'Email',
  `text` text NOT NULL COMMENT 'Текст',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `file_manager`
--

CREATE TABLE IF NOT EXISTS `file_manager` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` varchar(100) DEFAULT NULL COMMENT 'ID объекта',
  `model_id` varchar(100) DEFAULT NULL COMMENT 'Модель',
  `name` varchar(100) NOT NULL COMMENT 'Файл',
  `tag` varchar(100) DEFAULT NULL COMMENT 'Тег',
  `title` text COMMENT 'Название',
  `descr` text COMMENT 'Описание',
  `order` int(11) unsigned NOT NULL COMMENT 'Порядок',
  `path` varchar(250) NOT NULL COMMENT 'Путь к файлу',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `file_manager`
--

INSERT INTO `file_manager` (`id`, `object_id`, `model_id`, `name`, `tag`, `title`, `descr`, `order`, `path`) VALUES
(1, '13', 'News', 'e607ea11303b1ae216ce8410fb3d680f.jpg', 'files', 'DSCN2060(www.CoolWallpapers.org)-1280x10242.JPG', NULL, 1, ''),
(2, '13', 'News', '88364aee8a6ef951dcfadcdbe576e550.png', 'files', 'GNOME-210SimpleAndElegant_1280x1024.png', NULL, 2, ''),
(3, '13', 'News', 'a627f1aa47a9cd775c348578fc23da58.png', 'files', 'wallpaper-linux-cli-commands-1280-1024.png', NULL, 3, ''),
(4, '13', 'News', 'b874601073fbc29c0ca0459d2ee7f7c8.jpg', 'files', 'OTHER-SmolovSummer2004_1024x768.jpg', NULL, 4, ''),
(5, '13', 'News', '3c664f65c64426ff95f413f48e12088d.jpg', 'files', 'ubuntualien.jpg', NULL, 5, ''),
(6, '13', 'News', 'b1d756441e6eae30632e1dc172041a8b.jpg', 'files', 'NATURE-AtTheEdgeOfAtmosphere_1024x768.jpg', NULL, 6, ''),
(7, '13', 'News', '8b45f94c61220ccf25b4c666b11a1b6b.jpg', 'files', 'DSCN2060(www.CoolWallpapers.org)-1280x10242.JPG', NULL, 7, ''),
(8, '13', 'News', '015e557b48ef1f20368f67dfd8fe3706.png', 'files', 'GNOME-210SimpleAndElegant_1280x1024.png', NULL, 8, ''),
(9, '13', 'News', 'a91446c6617815267c8975043708464b.jpg', 'files', 'ski-resort-bad-hofgastein-1280x1024.jpg', NULL, 9, ''),
(10, '13', 'News', '1995e2446badb63bba8e92978d400d37.jpg', 'files', 'DSCN2060(www.CoolWallpapers.org)-1280x1024.JPG', NULL, 10, ''),
(11, '13', 'News', '61edbd42e55b69480b783b7054d370f5.jpg', 'files', 'awp05_alltolls_blogspot098-1280x1024.jpg', NULL, 11, ''),
(12, '2', 'Article', '[rutracker.org].t2959705.torrent', 'file', '[rutracker.org].t2959705.torrent', NULL, 1, 'upload/fileManager/95'),
(13, '2', 'Article', '[rutracker.org].t2959705.torrent', 'file', '[rutracker.org].t2959705.torrent', NULL, 2, 'upload/fileManager/06'),
(14, '2', 'Article', '[rutracker.org].t2203893.torrent', 'file', '[rutracker.org].t2203893.torrent', NULL, 3, 'upload/fileManager/d5'),
(15, '2', 'Article', '[rutracker.org].t3790516.torrent', 'file', '[rutracker.org].t3790516.torrent', NULL, 4, 'upload/fileManager/ef'),
(22, '2', 'News', '[rutracker.org].t3790516.torrent', 'file', '[rutracker.org].t3790516.torrent', NULL, 1, 'upload/fileManager/e1'),
(23, '1', 'News', '5.JPG', 'file', '5.JPG', NULL, 0, 'upload/fileManager/b8'),
(24, '1', 'News', 'IMG_1166.JPG', 'file', 'IMG_1166.JPG', NULL, 1, 'upload/fileManager/2c'),
(25, '1', 'News', 'IMG_1166.JPG', 'file', 'IMG_1166.JPG', NULL, 2, 'upload/fileManager/a8'),
(26, '1', 'News', '5.JPG', 'file', '5.JPG', NULL, 3, 'upload/fileManager/f8'),
(27, '1', 'News', 'vetton_ru_2212.jpg', 'file', 'vetton_ru_2212.jpg', NULL, 4, 'upload/fileManager/c2'),
(28, '1', 'News', 'vetton_ru_2205.jpg', 'file', 'vetton_ru_2205.jpg', NULL, 5, 'upload/fileManager/1a'),
(29, '1', 'News', 'vetton_ru_2225.jpg', 'file', 'vetton_ru_2225.jpg', NULL, 6, 'upload/fileManager/8e'),
(30, '1', 'News', 'vetton_ru_2213.jpg', 'file', 'vetton_ru_2213.jpg', NULL, 7, 'upload/fileManager/40'),
(31, '1', 'News', 'vetton_ru_2225.jpg', 'file', 'vetton_ru_2225.jpg', NULL, 8, 'upload/fileManager/c3'),
(32, '1', 'News', 'vetton_ru_2213.jpg', 'file', 'vetton_ru_2213.jpg', NULL, 9, 'upload/fileManager/a8'),
(33, '1', 'News', 'vetton_ru_2212.jpg', 'file', 'vetton_ru_2212.jpg', NULL, 10, 'upload/fileManager/41'),
(34, '1', 'News', 'vetton_ru_2205.jpg', 'file', 'vetton_ru_2205.jpg', NULL, 11, 'upload/fileManager/83'),
(35, '1', 'News', 'vetton_ru_2225.jpg', 'file', 'vetton_ru_2225.jpg', NULL, 12, 'upload/fileManager/55'),
(36, '1', 'News', 'vetton_ru_2213.jpg', 'file', 'vetton_ru_2213.jpg', NULL, 14, 'upload/fileManager/03'),
(37, '1', 'News', 'vetton_ru_2212.jpg', 'file', 'vetton_ru_2212.jpg', NULL, 13, 'upload/fileManager/62'),
(38, '1', 'News', 'vetton_ru_2205.jpg', 'file', 'vetton_ru_2205.jpg', NULL, 15, 'upload/fileManager/ae');

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
-- Table structure for table `languages_messages`
--

CREATE TABLE IF NOT EXISTS `languages_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(32) NOT NULL COMMENT 'Категория',
  `message` text NOT NULL COMMENT 'Сообщение',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=211 ;

--
-- Dumping data for table `languages_messages`
--

INSERT INTO `languages_messages` (`id`, `category`, `message`) VALUES
(1, 'main', 'Скрыть'),
(156, 'main', 'Управление страницами'),
(157, 'main', 'Добавление страницы'),
(158, 'main', 'Просмотр страницы'),
(159, 'main', 'Редактирование страницы'),
(160, 'main', 'Удаление страницы'),
(161, 'main', 'Получение данных страницы (JSON)'),
(162, 'main', 'Система'),
(163, 'main', 'Страницы сайта'),
(164, 'main', 'Язык'),
(165, 'main', 'Заголовок'),
(166, 'main', 'Адрес'),
(167, 'main', 'Текст'),
(168, 'main', 'Опубликована'),
(169, 'main', 'Создана'),
(170, 'main', 'Да'),
(171, 'main', 'Админ панель'),
(172, 'main', 'На сайт'),
(173, 'main', 'Выйти'),
(174, 'main', 'Быстрый поиск'),
(175, 'main', 'Контент'),
(176, 'main', 'Список страниц'),
(177, 'main', 'Добавить страницу'),
(178, 'main', 'Блоки страниц'),
(179, 'main', 'Добавить блок'),
(180, 'main', 'Управление меню'),
(181, 'main', 'Добавить меню'),
(182, 'main', 'Мета-теги'),
(183, 'main', 'Добавить мета-тег'),
(184, 'main', 'Логирование'),
(185, 'main', 'Действия сайта'),
(186, 'main', 'Обратная связь'),
(187, 'main', 'Языки'),
(188, 'main', 'Добавить язык'),
(189, 'main', 'Настройки'),
(190, 'main', 'Пользователи'),
(191, 'main', 'Все пользователи '),
(192, 'main', 'Добавить пользователя'),
(193, 'main', 'показать'),
(194, 'main', 'Главное'),
(195, 'main', 'Главная'),
(196, 'main', 'Новости'),
(197, 'main', 'Разработчики'),
(198, 'main', 'Инструменты'),
(199, 'main', 'Обзор'),
(200, 'main', 'Документация'),
(201, 'main', 'Языковые сообщения'),
(202, 'main', 'Языковые переводы'),
(203, 'main', 'Добавить Языковые сообщения'),
(204, 'main', 'Языки (сообщения)'),
(205, 'main', 'Языки (сообщения) добавить'),
(206, 'main', 'Языки (переводы)'),
(207, 'main', 'Языки (добавить перевод)'),
(208, 'main', 'Главная страница'),
(209, 'main', 'Редактировать'),
(210, 'main', 'View details');

-- --------------------------------------------------------

--
-- Table structure for table `languages_translations`
--

CREATE TABLE IF NOT EXISTS `languages_translations` (
  `id` int(11) NOT NULL,
  `language` char(2) NOT NULL DEFAULT '' COMMENT 'Язык',
  `translation` text COMMENT 'Перевод',
  PRIMARY KEY (`id`,`language`),
  KEY `language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `languages_translations`
--

INSERT INTO `languages_translations` (`id`, `language`, `translation`) VALUES
(162, 'en', 'System'),
(162, 'ru', 'Система'),
(175, 'en', 'Content'),
(176, 'en', 'Pages list'),
(177, 'en', 'Create page'),
(178, 'en', 'Page blocks'),
(179, 'en', 'Create page block'),
(180, 'en', 'Manage menu'),
(181, 'en', 'Ceate menu'),
(182, 'en', 'Meta tags'),
(183, 'en', 'Add meta tag'),
(184, 'en', 'Logging'),
(185, 'en', 'Site actions'),
(186, 'en', 'Feedback'),
(187, 'en', 'Languages'),
(188, 'en', 'Add language'),
(189, 'en', 'Settings'),
(196, 'en', 'News');

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

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT 'Название',
  `is_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Отображать',
  `lang` varchar(2) DEFAULT NULL COMMENT 'Язык',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `is_published`, `lang`) VALUES
(1, 'Верхнее меню', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu_sections`
--

CREATE TABLE IF NOT EXISTS `menu_sections` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `page_id` int(11) unsigned DEFAULT NULL COMMENT 'Привязка к странице',
  `menu_id` int(11) unsigned NOT NULL COMMENT 'Меню',
  `root` int(11) unsigned DEFAULT NULL,
  `left` int(11) unsigned NOT NULL,
  `right` int(11) unsigned NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `title` varchar(200) NOT NULL COMMENT 'Заголовок',
  `url` varchar(200) NOT NULL COMMENT 'Адрес',
  `module_url` varchar(300) DEFAULT NULL COMMENT 'Раздел модуля',
  `module_id` varchar(64) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Отображать',
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `menu_id` (`menu_id`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `menu_sections`
--

INSERT INTO `menu_sections` (`id`, `lang`, `page_id`, `menu_id`, `root`, `left`, `right`, `level`, `title`, `url`, `module_url`, `module_id`, `is_published`) VALUES
(1, 'ru', NULL, 1, 1, 1, 8, 1, 'Верхнее меню::корень', '', NULL, NULL, 0),
(2, 'ru', NULL, 1, 1, 2, 5, 2, 'Новости', '/', '/news/news/index', 'news', 1),
(34, 'ru', 2, 1, 1, 3, 4, 3, 'dsdf', '', NULL, NULL, 1),
(35, 'ru', NULL, 1, 1, 6, 7, 2, 'addd', '', NULL, NULL, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `meta_tags`
--

INSERT INTO `meta_tags` (`id`, `object_id`, `model_id`, `title`, `keywords`, `description`, `date_create`, `date_update`) VALUES
(7, 1, 'Page', 'www', 'rtyrtyry', 'trfyhr', '2011-10-19 14:25:29', '2012-02-19 22:17:38'),
(8, 3, 'News', 'zzzz', 'keyww', 'oppp', '2011-10-20 10:10:13', '2011-10-20 13:12:40'),
(13, 3, 'Page', NULL, NULL, NULL, '2012-03-25 18:28:06', NULL);

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
  `is_published` tinyint(1) NOT NULL COMMENT 'Опубликована',
  `date` date NOT NULL COMMENT 'Дата',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Создана',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `lang` (`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `lang`, `user_id`, `title`, `text`, `photo`, `is_published`, `date`, `date_create`) VALUES
(1, 'ru', 1, 'IdeaPad Y570: мощный ноутбук по разумной цене', '<p>В блоге компании Lenovo на Хабре мы уделяем наибольшее внимание серии ThinkPad, что вполне логично &ndash; судя по отзывам, большинству из вас по нраву как раз эти модели, созданные для работы и творчества, крепкие и строгие внешне. Но сегодня у нас обзор модели IdeaPad Y570, яркого представителя &laquo;пользовательской&raquo; серии ноутбуков Lenovo, весьма отличающейся от унаследованных у IBM бизнес-моделей. Обойти вниманием такой ноутбук сложно: при стоимости от 30 тысяч рублей он предоставляет в ваше распоряжение одну из самых мощных видеокарт, современный процессор Intel Core, а также невероятно быструю дисковую систему. Гибрид из емкого жесткого диска и быстрого SSD именно в &laquo;пятьсот семидесятом&raquo; стал штатным: им оснащается большинство модификаций ноутбука. В этом обзоре я расскажу о том, чем хороша загрузка за 15 секунд, какие изменения произошли в новой модели Y-серии, а также о том, почему стоит выбрать именно эту модель в качестве домашнего развлекательного центра.</p>', '80f3dfc8fb0c6fe5c33950e89eed32cf.jpeg', 1, '2006-04-24', '0000-00-00 00:00:00'),
(2, 'ru', 1, 'Твиттер запустит инструмент для веб-аналитики', '<p>Сколько трафика ваш сайт получает из Твиттера? Дать ответ на этот вопрос позволит анонсированный Твиттером инструмент для веб-аналитики под названием Twitter Web Analytics.<br /><br />Новый инструмент призван дать владельцам сайтов больше данных об эффективности их интеграции с Твиттером. Он основан на технологиях компании BackType, которая занимается социальной аналитикой и которую Твиттер купил в июне.<br /><a></a><br />Как <a href="https://dev.twitter.com/blog/introducing-twitter-web-analytics">пояснил</a> основатель BackType и новый сотрудник Твиттера Кристофер Голда, Twitter Web Analytics поможет владельцам сайтов понимать три ключевых момента: сколько их контента распространяется в Твиттере, сколько трафика их сайт получает из Твиттера, и насколько эффективны кнопки Твиттера.<br /><br />Как видно на скриншоте, панель аналитики состоит из четырёх вкладок. Первая, &laquo;трафик&raquo;, отображает число твитов со ссылками на сайт и количество кликов по этим ссылкам. Графики доступны для текущего дня, прошлой недели и прошлого месяца. Вкладка &laquo;твиты&raquo; показывает все твиты, содержащие ссылки на сайт, а также все твиты, отправленные из встроенных кнопок Твиттера на сайте. Администратор может ретвитить и отвечать на твиты из этой панели. Вкладка &laquo;кнопка Твиттера&raquo; показывает, насколько активно используются кнопки Твиттера на сайте, а вкладка &laquo;контент&raquo; показывает наиболее эффективные страницы сайта.<br /><br />По словам директора Твиттера по развитию веб-бизнеса Эйприл Андервуд, данные будут очищены от ботов и спама. Твиттер также выпустит API инструмента для разработчиков.<br /><br />Twitter Web Analytics бесплатен и пока что в бета-версии. Небольшая группа партнёров получит к нему доступ на этой неделе, а для всех он будет запущен в течение нескольких недель.</p>', 'be8a93e588f5469ee426a77a66e2444a.png', 1, '2011-09-05', '0000-00-00 00:00:00'),
(3, 'ru', 1, 'Microsoft выпустил Windows 8 Developer Preview', '<p>Разумеется, это не готовый продукт, поэтому будьте готовы к ошибкам, постоянным обновлениям и несовместимости программ. В общем, действуйте на свой риск.<br /><br />Если хотите получить некоторое представление о Windows 8 перед установкой, посмотрите скриншоты под катом.<br /><a></a>Разумеется, это не готовый продукт, поэтому будьте готовы к ошибкам, постоянным обновлениям и несовместимости программ. В общем, действуйте на свой риск.<br /><br />Если хотите получить некоторое представление о Windows 8 перед установкой, посмотрите скриншоты под катом.<br /><a></a><br />На конференции Microsoft продемонстрировал много устройств на Windo<strong>ws 8, в том числе планшетов:zz</strong></p>\r\n<p>&nbsp;</p>\r\n<p><strong>Разумеется, это не готовый продукт, поэтому будьте готовы к ошибкам, постоянным обновлениям и несовместимости программ. В общем, действуйте на свой риск.<br /><br />Если хотите получить некоторое представление о Windows 8 перед установкой, посмотрите скриншоты под катом.<br /><a></a><br />На конференции Microsoft продемонстрировал много устройств на Windo<strong>ws 8, в том числе планшетов:zz</strong></strong></p>\r\n<p>&nbsp;</p>\r\n<p><strong><strong>Разумеется, это не готовый продукт, поэтому будьте готовы к ошибкам, постоянным обновлениям и несовместимости программ. В общем, действуйте на свой риск.<br /><br />Если хотите получить некоторое представление о Windows 8 перед установкой, посмотрите скриншоты под катом.<br /><a></a><br />На конференции Microsoft продемонстрировал много устройств на Windo<strong>ws 8, в том числе планшетов:zz</strong><br /></strong></strong></p>\r\n<p>На конференции Microsoft продемонстрировал много устройств на Windo<strong>ws 8, в том числе планшетов:zz</strong></p>', '328a76e70961ee6f64165f802d281e09.jpg', 1, '2011-09-14', '0000-00-00 00:00:00'),
(4, 'en', 1, 'Intel brandishes first Google Android tablet', '<p>SAN FRANCISCO--Intel hauled out its first\r\n<a href="http://www.cnet.com/android-atlas/">Android</a>\r\n<a href="http://reviews.cnet.com/tablets/">tablet</a>\r\n running on "Medfield," an upcoming Atom chip for smartphones and \r\ntablets, while two executives also chatted with CNET about their \r\nrelationship with Google, all at Intel''s developer conference today. </p>\r\n<p>The Medfield Atom chip is one of Intel''s most power-efficient chip \r\ndesigns--a strict requirement for tablets and smartphones. It contains a\r\n single processing core--as opposed to more power-hungry dual-core Atom \r\nchips used in Netbooks--and will be available in devices in the first \r\nhalf of 2012. </p>\r\n<p>The tablet that Intel showed today (see photo below) is a so-called \r\nreference design that the company will supply to tablet makers that \r\nwould use it as a template for their own product. </p>\r\n<p>Importantly, Intel-based tablets and smartphones will be targeted at \r\nGoogle''s Android software, not Intel''s internal MeeGo operating system. \r\nThe latter has been relegated to automotive and industrial applications \r\nmostly and is no longer seen as a promising operating system for \r\nconsumer devices. To drive this point home, Intel reaffirmed its \r\nrelationship with Google today. </p>\r\n<p>CNET sat down briefly with two Intel phone executives to talk about \r\nthe relationship. The reaffirmation of the relationship is about \r\n"optimizing Intel for the Android platform for phone and for tablets," \r\nsaid Mike Bell, co-general manager of the phone division. "So, as a \r\n[device maker] you''ll be able to go out and build a device with the full\r\n blessing and backing of Intel and Google," he said. </p>\r\n<p>Intel has done an about-face of sorts. Its phone efforts had focused \r\nheavily on Nokia until that company made a dramatic switch to \r\nMicrosoft''s Windows phone platform. "We were very focused on Nokia. Mike\r\n and I took over in April and got the company very focused on the \r\nAndroid ecosystem," said Dave Whalen, the other co-manager of the phone \r\ndivision. </p><div><br />Read more: <a href="http://news.cnet.com/8301-13924_3-20105608-64/intel-brandishes-first-google-android-tablet/#ixzz1Xw5pQIsr">http://news.cnet.com/8301-13924_3-20105608-64/intel-brandishes-first-google-android-tablet/#ixzz1Xw5pQIsr</a><br /></div>  ', 'c142759dc89ae8e20abc642e1dd0e99c.jpg', 1, '2011-09-14', '0000-00-00 00:00:00'),
(5, 'en', 1, 'Windows 8 debuts at Microsoft Build (live blog)  Read more: http://news.cnet.com/8301-10805_3-20105152-75/windows-8-debuts-at-microsoft-build-live-blog/#ixzz1Xw61Mgip', '<p>A new analyst report making the rounds this morning asserts that \r\nApple''s putting the finishing touches on iOS 5, and plans to send it to \r\nits device assemblers as soon as next week. </p>\r\n<p>Analyst Ming-Chi Kuo of Concord Securities told <a href="http://www.appleinsider.com/articles/11/09/12/apple_to_release_ios_5_gm_to_assemblers_during_week_of_sept_23.html">AppleInsider</a> and <a href="http://www.macrumors.com/2011/09/12/apple-sending-ios-5-to-iphone-assemblers-at-end-of-september-no-sign-of-redesigned-iphone-5/">MacRumors</a>\r\n today that Apple should be delivering the golden master version of iOS 5\r\n between September 23 and 30. That software will then be imaged onto new\r\n devices that ship out to stores.\r\n</p>\r\n<p>The timing is of special note given expectations of a new\r\n<a href="http://www.cnet.com/apple-iphone.html">iPhone </a>and\r\n<a href="http://www.cnet.com/ipod/">iPod Touch</a> \r\nin the coming weeks. Kuo suggests it will take 10 to 12 days for \r\nshipping of new iPhones and iPod Touch units with the upgraded software,\r\n placing a higher possibility that those units won''t be available until \r\nthe second week of October. </p>\r\n<p>Apple released the latest beta version of its iOS 5 system software \r\nto developers at the tail end of August, the seventh iteration since \r\ntaking the wraps off the software at its Worldwide Developers Conference\r\n in June. So far, Apple has gone through a lengthier test process than \r\nusual, releasing a new beta of the software every few weeks ahead of the\r\n golden master, which represents the version the public gets: </p><div><br />Read more: <a href="http://news.cnet.com/8301-27076_3-20104888-248/ios-5-gold-master-expected-next-week-report-says/#ixzz1Xw6AsG9Q">http://news.cnet.com/8301-27076_3-20104888-248/ios-5-gold-master-expected-next-week-report-says/#ixzz1Xw6AsG9Q</a><br /></div>    ', '9bfe8a178df245ee90a2b5d62bfe682b.jpg', 1, '2011-09-14', '0000-00-00 00:00:00'),
(6, 'en', 1, 'Google Street View''s naked lady', '<p>It is well accepted that, if there were commercial gain involved, \r\nGoogle might not be averse to peering inside the most intimate parts of \r\nyour life.</p>\r\n<p>However, sometimes the company manages to cast its gaze without even realizing just how close to you it is.</p>\r\n<p>I am sure some will be grateful to <a href="http://www.thesmokinggun.com/buster/google/google-street-view-naked-woman-094672">the always generous Smoking Gun</a>\r\n for leading them (in a SFW way) to a street in Miami, where a woman is \r\nstanding outside her front door naked. (The story of these interesting \r\npixels was originally broken by the <a href="http://randompixels.blogspot.com/2011/09/stay-classy-miami.html">Random Pixels blog</a>) </p>\r\n<p>Oh, of course it''s on Google Street View. Where else would you find truly unguarded moments, like <a href="http://news.cnet.com/8301-17852_3-20013500-71.html">a 10-year-old playing dead</a> or, indeed, <a href="http://news.cnet.com/8301-17852_3-20023487-71.html">a naked man in an open car trunk</a>?</p><p>In the Miami case, it appears the lady may have spotted Google''s \r\nmarauding recording vehicle, for in a subsequent shot on the site she \r\nattempts to cover up.</p>\r\n<p>The nude pose was still up in all its glory last night. However, this\r\n morning it''s blurred. What remains is merely a shot of her house and \r\nthe blurry image of a naked ghost.</p>\r\n<p>There will be those who will wonder what the naked lady might have \r\nbeen doing outside her house in a clothing-optional state. The obvious \r\nanswer would be that Miami is very hot. In this case, the naked lady \r\nappeared to be washing. Though this might have merely been a scene from \r\nyet another M. Night Shyamalan movie.</p>\r\n<p>Still, one can only wonder what other gems might still exist on a \r\nservice that, with its real-time captures of a microcosm of the world, \r\ntells us how people really spend their days. </p>  ', '22285438321c76a76dc925206f5dd5bf.png', 1, '2011-09-14', '0000-00-00 00:00:00'),
(8, 'ru', 1, '1', '', NULL, 0, '0000-00-00', '2012-02-17 22:46:14'),
(9, 'ru', 1, '2', '', NULL, 0, '0000-00-00', '2012-02-17 22:46:14'),
(10, 'ru', 1, '3', '', NULL, 0, '0000-00-00', '2012-02-17 22:46:15'),
(11, 'ru', 1, '4', '', NULL, 0, '0000-00-00', '2012-02-17 22:46:19'),
(12, 'ru', 1, '5', '', NULL, 0, '0000-00-00', '2012-02-17 22:46:20'),
(13, 'ru', 1, '6', '', NULL, 0, '0000-00-00', '2012-02-17 22:46:20'),
(14, 'ru', 1, '7', '', NULL, 0, '0000-00-00', '2012-02-17 22:46:20'),
(15, 'ru', 1, '8', '', NULL, 0, '0000-00-00', '2012-02-17 22:46:21'),
(16, 'ru', 1, '1', '', NULL, 0, '0000-00-00', '2012-02-17 22:47:36'),
(17, 'ru', 1, '2', '', NULL, 0, '0000-00-00', '2012-02-17 22:47:36'),
(18, 'ru', 1, '3', '', NULL, 0, '0000-00-00', '2012-02-17 22:47:37'),
(19, 'ru', 1, '4', '', NULL, 0, '0000-00-00', '2012-02-17 22:47:37'),
(20, 'ru', 1, '5', '', NULL, 0, '0000-00-00', '2012-02-17 22:47:38'),
(23, 'ru', 1, '6', '', NULL, 0, '0000-00-00', '2012-02-17 22:47:38'),
(24, 'ru', 1, '7', '', NULL, 0, '0000-00-00', '2012-02-17 22:47:38'),
(25, 'ru', 1, '8', '', NULL, 0, '0000-00-00', '2012-02-17 22:47:39');

-- --------------------------------------------------------

--
-- Table structure for table `outbox_emails`
--

CREATE TABLE IF NOT EXISTS `outbox_emails` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(750) DEFAULT NULL,
  `user_name` varchar(750) DEFAULT NULL,
  `solution` varchar(300) DEFAULT NULL,
  `subject` varchar(750) DEFAULT NULL,
  `text` blob,
  `log` blob,
  `status` char(21) DEFAULT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_send` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `language` char(2) DEFAULT 'ru' COMMENT 'Язык',
  `title` varchar(200) NOT NULL COMMENT 'Заголовок',
  `url` varchar(250) DEFAULT NULL COMMENT 'Адрес',
  `text` text NOT NULL COMMENT 'Текст',
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Опубликована',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Создана',
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pages_language_fk` (`language`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `language`, `title`, `url`, `text`, `is_published`, `date_create`, `order`) VALUES
(1, 'ru', 'Главная страница', '/', '<p>Yii &mdash; это высокоэффективный основанный на компонентной структуре PHP-фреймворк для     разработки масштабных веб-приложений. Он позволяет максимально применить концепцию повторного     использования кода и может существенно ускорить процесс веб-разработки. Название Yii     (произносится как Yee или [ji:]) означает простой (easy), эффективный (efficient) и расширяемый     (extensible).</p>', 1, '2011-06-25 13:23:15', 19),
(3, 'en', 'Main page', '/', '<p><strong>Yii</strong> is pronounced as Yee or [ji:], and is an acroynym for "<strong>Yes It Is!</strong>". This is often the accurate, and most concise response to inquires from those new to Yii: <br />Is it fast? ... Is it secure? ... Is it professional? ... Is it right for my next project? ... <strong>Yes, it is!</strong></p>\r\n<p>Yii is a free, open-source Web application development framework written in PHP5 that promotes clean, <a rel="nofollow" href="http://en.wikipedia.org/wiki/Don%27t_repeat_yourself">DRY</a> design and encourages rapid development. It works to streamline your  application development and helps to ensure an extremely efficient,  extensible, and maintainable end product.</p>\r\n<p>Being extremely performance optimized, Yii is a perfect choice for  any sized project. However, it has been built with sophisticated,  enterprise applications in mind. You have full control over the  configuration from head-to-toe (presentation-to-persistence) to conform  to your enterprise development guidelines. It comes packaged with tools  to help test and debug your application, and has clear and comprehensive  documentation.</p>\r\n<p>To learn more about what Yii brings to the table, check out the <a href="http://www.yiiframework.com/features/">features section</a>.</p>', 1, '2011-09-10 21:00:53', 20);

-- --------------------------------------------------------

--
-- Table structure for table `params`
--

CREATE TABLE IF NOT EXISTS `params` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` varchar(50) NOT NULL COMMENT 'Модуль',
  `code` varchar(50) NOT NULL COMMENT 'Код',
  `name` varchar(100) NOT NULL COMMENT 'Заголовок',
  `value` text NOT NULL COMMENT 'Значение',
  `element` enum('text','textarea','editor','checkbox','file') NOT NULL COMMENT 'Элемент',
  PRIMARY KEY (`id`),
  UNIQUE KEY `const` (`code`),
  UNIQUE KEY `title` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `params`
--

INSERT INTO `params` (`id`, `module_id`, `code`, `name`, `value`, `element`) VALUES
(1, 'users', 'registration_mail_body', 'Шаблон письма регистрации', '<p>Здравствуйте {LAST_NAME} {FIRST_NAME} {PATRONYMIC}!</p>\r\n<p>Вы зарегистрировались на сайте {SITE_NAME}.</p>\r\n<p>Для завершения регистрации пройдите <a href="%7BACTIVATE_ACCOUNT_URL%7D">по этой ссылке.</a></p>\r\n<p>Адрес ссылки: {ACTIVATE_ACCOUNT_URL}</p>  ', 'editor'),
(7, 'users', 'registration_mail_subject', 'Тема письма регистрации', 'Регистрация на сайте {SITE_NAME}', 'text'),
(9, 'users', 'registration_done_message', 'Сообщение о завершении регистрации', '<p>Вы успешно зарегистрированы в системе, на ваш Email отправлено письмо с инструкциями завершения регистрации.</p>', 'editor'),
(10, 'users', 'activate_request_done_message', 'Сообщение после повторного запроса активации аккаунта', 'Мы выслали на ваш Email письмо, в котором нужно будет пройти по ссылке для активации аккаунта!', 'textarea'),
(11, 'users', 'change_password_request_mail_body', 'Шаблон письма запроса на смену пароля', '<p>Здравствуйте {LAST_NAME} {FIRST_NAME} {PATRONYMIC}!</p>\r\n<p>Вы сделали запрос на восстановление пароля на сайте {SITE_NAME}.</p>\r\n<p>Для того чтобы изменить пароль пройдите <a href="%7BLINK%7D">по этой ссылке.</a></p>\r\n<p>Адрес ссылки: {LINK}</p>  ', 'editor'),
(12, 'users', 'change_password_request_mail_subject', 'Тема письма запроса на смену пароля', 'Запрос на смену пароля {SITE_NAME}  ', 'editor'),
(13, 'mailer', 'timeout', 'Таймаут отправки (сек.)', '30', 'text'),
(14, 'mailer', 'signature', 'Подпись в письме', 'Данное сообщение отправлено роботом, просим Вас на него не отвечать.', 'text'),
(15, 'mailer', 'encoding', 'Кодировка писем', 'KOI8-U', 'text'),
(16, 'mailer', 'reply_address', 'Адрес для ответа', 'reply@electro-polis.ru', 'text'),
(17, 'mailer', 'letters_part_count', 'Отправлять писем за раз', '10\r\n', 'text'),
(18, 'mailer', 'dispatch_time', 'Последнее время отправки', '2011-09-30 19:15:02', 'text'),
(19, 'mailer', 'from_name', 'Имя от кого', 'Yii CMS сайт', 'text'),
(20, 'mailer', 'host', 'Хост', 'mail.el.korolevsait.ru', 'text'),
(21, 'mailer', 'port', 'Порт', '25', 'text'),
(22, 'mailer', 'login', 'Логин', 'elpolis', 'text'),
(23, 'mailer', 'password', 'Пароль', 'EPdEUoTn', 'text'),
(24, 'mailer', 'from_email', 'От кого(Email)', 'test@ya.ru', 'text'),
(25, 'main', 'SITE_ENABLED', 'Сайт доступен', '1', 'checkbox'),
(26, '', 'sefse', 'fsef', '', 'file'),
(27, '', 'LOGO', 'Логотип', 'Colony_0046_by_Artush.png', 'file'),
(28, 'main', 'project_name', 'Название проекта', 'Название проекта', 'text');

-- --------------------------------------------------------

--
-- Table structure for table `site_actions`
--

CREATE TABLE IF NOT EXISTS `site_actions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'Пользователь',
  `title` varchar(200) NOT NULL COMMENT 'Заголовок',
  `module` varchar(50) NOT NULL COMMENT 'Модуль',
  `controller` varchar(50) NOT NULL COMMENT 'Контроллер',
  `action` varchar(50) NOT NULL COMMENT 'Действие',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;

--
-- Dumping data for table `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1328899451),
('m120208_234523_docs', 1328899453),
('m120210_213443_banners', 1328900855),
('m120210_223441_banners', 1328902503),
('m120211_105306_captcha', 1328946802),
('m120211_110937_menu_links', 1328947816),
('m120211_143806_AR', 1328960362),
('m120211_165455_sitempa', 1328968696),
('m120211_170148_news', 1328968915),
('m120225_213735_is_published2', 1330195146),
('m120226_005110_is_published3', 1330206716),
('m120222_000430_add_user_tracking_to_pages_and_revisions', 1330273189),
('m120222_004351_add_timestamps', 1330273189);

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
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Зарегистрирован',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `patronymic`, `email`, `phone`, `password`, `birthdate`, `gender`, `status`, `activate_code`, `activate_date`, `password_recover_code`, `password_recover_date`, `date_create`) VALUES
(1, 'Иван', 'Иванов', 'Васильевич', 'admin@ya.ru', '+7-965-1935233', 'e10adc3949ba59abbe56e057f20f883e', '2003-05-20', 'man', 'active', '070a63ae33af0eb7986992e774dc53e8', '2011-05-21 13:18:39', NULL, NULL, '2011-05-19 00:25:50'),
(17, 'Артем', 'Остапец', 'Игоревич', 'artem-moscow@yandex.ru', '+7-903-5492969', '813107300f254c3a072c17066c15a22a', '2011-09-25', 'man', 'new', '7533c7b47ed8206d6913e6d271b23ec3', NULL, NULL, NULL, '2011-09-22 17:19:48'),
(18, 'os', 'art', 'igr', 'artemostapetc@gmail.com', NULL, '813107300f254c3a072c17066c15a22a', NULL, 'man', 'new', NULL, NULL, NULL, NULL, '2011-09-30 12:23:57'),
(19, 'Алексей', 'Шаров', NULL, 'www.pismeco@gmail.com', '', '827ccb0eea8a706c4c34a16891f84e7b', '0000-00-00', '', 'active', '827ccb0eea8a706c4c34a16891f84e7b', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '2011-11-11 14:17:20');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actions`
--
ALTER TABLE `actions`
  ADD CONSTRAINT `actions_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

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
-- Constraints for table `languages_translations`
--
ALTER TABLE `languages_translations`
  ADD CONSTRAINT `languages_translations_ibfk_1` FOREIGN KEY (`language`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id`) REFERENCES `languages_messages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu_sections`
--
ALTER TABLE `menu_sections`
  ADD CONSTRAINT `menu_sections_ibfk_1` FOREIGN KEY (`lang`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_sections_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `pages_language_fk` FOREIGN KEY (`language`) REFERENCES `languages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `site_actions`
--
ALTER TABLE `site_actions`
  ADD CONSTRAINT `site_actions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

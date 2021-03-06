set foreign_key_checks = 0;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `unitkit`
--

-- --------------------------------------------------------

--
-- Structure de la table `u_auto_login`
--

CREATE TABLE IF NOT EXISTS `u_auto_login` (
  `uuid` varchar(64) COLLATE utf8_bin NOT NULL,
  `u_person_id` int(10) unsigned NOT NULL,
  `key1` varchar(64) COLLATE utf8_bin NOT NULL,
  `key2` varchar(64) COLLATE utf8_bin NOT NULL,
  `duration` int(10) unsigned NOT NULL,
  `expired_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_album`
--

CREATE TABLE IF NOT EXISTS `u_cms_album` (
`id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Contenu de la table `u_cms_album`
--

INSERT INTO `u_cms_album` (`id`, `created_at`, `updated_at`) VALUES
(48, '2014-08-03 07:13:23', '2014-08-03 07:13:23'),
(49, '2014-11-29 13:00:45', '2014-12-04 11:12:51');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_album_i18n`
--

CREATE TABLE IF NOT EXISTS `u_cms_album_i18n` (
  `u_cms_album_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_cms_album_i18n`
--

INSERT INTO `u_cms_album_i18n` (`u_cms_album_id`, `i18n_id`, `title`) VALUES
(48, 'en', 'Carousel'),
(48, 'fr', 'Carousel'),
(49, 'en', 'Demo'),
(49, 'fr', 'Demo');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_album_photo`
--

CREATE TABLE IF NOT EXISTS `u_cms_album_photo` (
`id` int(10) unsigned NOT NULL,
  `u_cms_album_id` int(10) unsigned NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=55 ;

--
-- Contenu de la table `u_cms_album_photo`
--

INSERT INTO `u_cms_album_photo` (`id`, `u_cms_album_id`, `file_path`, `created_at`, `updated_at`) VALUES
(50, 48, 's1_53dfaeb90a174.jpg', '2014-08-04 16:03:05', '2014-08-04 16:03:05'),
(51, 48, 's2_53dfaec50f42f.jpg', '2014-08-04 16:03:17', '2014-08-04 16:03:17'),
(52, 48, 's3_5409838f0f182.jpg', '2014-08-04 16:03:25', '2014-12-04 11:12:58'),
(53, 49, 'picture-1_5479c66c32f72.jpg', '2014-11-29 13:00:53', '2014-11-29 13:13:16'),
(54, 49, 'picture-2_5479c65f9065d.jpg', '2014-11-29 13:01:02', '2014-11-29 13:13:03');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_album_photo_i18n`
--

CREATE TABLE IF NOT EXISTS `u_cms_album_photo_i18n` (
  `u_cms_album_photo_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_cms_album_photo_i18n`
--

INSERT INTO `u_cms_album_photo_i18n` (`u_cms_album_photo_id`, `i18n_id`, `title`) VALUES
(50, 'en', 'Slide 1'),
(50, 'fr', 'Slide 1'),
(51, 'en', 'Slide 2'),
(51, 'fr', 'Slide 2'),
(52, 'en', 'Slide 3'),
(52, 'fr', 'Slide 3'),
(53, 'en', 'Picture 1'),
(53, 'fr', 'Photo 1'),
(54, 'en', 'Picture 2'),
(54, 'fr', 'Photo 2');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_image`
--

CREATE TABLE IF NOT EXISTS `u_cms_image` (
`id` int(10) unsigned NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `u_cms_image`
--

INSERT INTO `u_cms_image` (`id`, `file_path`, `created_at`, `updated_at`) VALUES
(8, 'image_53dfa4ecb66da.jpg', '2014-08-03 07:31:17', '2014-08-04 15:21:16'),
(11, 'image2_53dfbb686a4c2.jpg', '2014-08-04 16:57:12', '2014-08-12 00:14:05');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_image_i18n`
--

CREATE TABLE IF NOT EXISTS `u_cms_image_i18n` (
  `u_cms_image_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_cms_image_i18n`
--

INSERT INTO `u_cms_image_i18n` (`u_cms_image_id`, `i18n_id`, `title`) VALUES
(8, 'en', 'Image 1'),
(8, 'fr', 'Image 1'),
(11, 'en', 'Image 2'),
(11, 'fr', 'Image 2');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_layout`
--

CREATE TABLE IF NOT EXISTS `u_cms_layout` (
`id` int(10) unsigned NOT NULL,
  `max_container` smallint(5) unsigned NOT NULL DEFAULT '1',
  `path` varchar(255) NOT NULL,
  `view` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `u_cms_layout`
--

INSERT INTO `u_cms_layout` (`id`, `max_container`, `path`, `view`, `created_at`, `updated_at`) VALUES
(1, 2, '//../modules/frontend/views/layouts/base', 'index', '2014-07-12 06:11:54', '2014-08-04 19:02:36'),
(2, 2, '//../modules/frontend/views/layouts/base', 'contact', '2014-08-03 18:57:42', '2014-10-12 11:44:19'),
(3, 2, '//../modules/frontend/views/layouts/base', 'carousel', '2014-11-22 11:45:08', '2014-11-22 11:45:18'),
(4, 1, '//../modules/frontend/views/layouts/base', 'news', '2014-11-29 11:21:19', '2014-11-29 12:18:41'),
(5, 1, '//../modules/frontend/views/layouts/base', 'album', '2014-11-29 12:58:08', '2014-11-29 12:58:08');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_layout_i18n`
--

CREATE TABLE IF NOT EXISTS `u_cms_layout_i18n` (
  `u_cms_layout_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_cms_layout_i18n`
--

INSERT INTO `u_cms_layout_i18n` (`u_cms_layout_id`, `i18n_id`, `name`) VALUES
(1, 'en', 'Main'),
(1, 'fr', 'Défaut'),
(2, 'en', 'Contact'),
(2, 'fr', 'Contact'),
(3, 'en', 'Carousel'),
(3, 'fr', 'Carousel'),
(4, 'en', 'News'),
(4, 'fr', 'News'),
(5, 'en', 'Album'),
(5, 'fr', 'Album');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_menu`
--

CREATE TABLE IF NOT EXISTS `u_cms_menu` (
`id` int(10) unsigned NOT NULL,
  `u_cms_menu_group_id` int(10) unsigned NOT NULL,
  `rank` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `u_cms_menu`
--

INSERT INTO `u_cms_menu` (`id`, `u_cms_menu_group_id`, `rank`, `created_at`, `updated_at`) VALUES
(1, 1, 10, '2014-07-29 15:55:15', '2014-11-22 14:12:11'),
(2, 1, 20, '2014-08-02 09:57:25', '2014-11-22 11:32:17'),
(3, 1, 30, '2014-08-04 16:29:24', '2014-11-22 11:32:20'),
(4, 1, 40, '2014-08-04 16:26:23', '2014-11-22 11:32:23');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_menu_group`
--

CREATE TABLE IF NOT EXISTS `u_cms_menu_group` (
`id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `u_cms_menu_group`
--

INSERT INTO `u_cms_menu_group` (`id`, `created_at`, `updated_at`) VALUES
(1, '2014-07-28 16:19:53', '2014-08-05 08:29:39');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_menu_group_i18n`
--

CREATE TABLE IF NOT EXISTS `u_cms_menu_group_i18n` (
  `u_cms_menu_group_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_cms_menu_group_i18n`
--

INSERT INTO `u_cms_menu_group_i18n` (`u_cms_menu_group_id`, `i18n_id`, `name`) VALUES
(1, 'en', 'Main'),
(1, 'fr', 'Principal');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_menu_i18n`
--

CREATE TABLE IF NOT EXISTS `u_cms_menu_i18n` (
  `u_cms_menu_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_cms_menu_i18n`
--

INSERT INTO `u_cms_menu_i18n` (`u_cms_menu_id`, `i18n_id`, `name`, `url`) VALUES
(1, 'en', 'Home', '/en'),
(1, 'fr', 'Accueil', '/fr'),
(2, 'en', 'About', '/en/about'),
(2, 'fr', 'A propos', '/fr/a-propos'),
(3, 'en', 'News', '/en/news'),
(3, 'fr', 'Actualités', '/fr/actualites'),
(4, 'en', 'Contact', '/en/contact'),
(4, 'fr', 'Contact', '/fr/contact');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_news`
--

CREATE TABLE IF NOT EXISTS `u_cms_news` (
`id` int(10) unsigned NOT NULL,
  `u_cms_news_group_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activated` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `published_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `u_cms_news`
--

INSERT INTO `u_cms_news` (`id`, `u_cms_news_group_id`, `created_at`, `updated_at`, `activated`, `published_at`) VALUES
(3, 15, '2014-08-03 07:32:43', '2014-11-27 19:55:13', 1, '2014-08-31 00:00:00'),
(4, 15, '2014-10-31 15:23:36', '2014-11-27 19:55:48', 1, '2014-07-16 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_news_group`
--

CREATE TABLE IF NOT EXISTS `u_cms_news_group` (
`id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Contenu de la table `u_cms_news_group`
--

INSERT INTO `u_cms_news_group` (`id`, `created_at`, `updated_at`) VALUES
(15, '2014-07-28 16:23:03', '2014-07-28 16:23:03');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_news_group_i18n`
--

CREATE TABLE IF NOT EXISTS `u_cms_news_group_i18n` (
  `u_cms_news_group_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_cms_news_group_i18n`
--

INSERT INTO `u_cms_news_group_i18n` (`u_cms_news_group_id`, `i18n_id`, `name`) VALUES
(15, 'en', 'Main'),
(15, 'fr', 'Principal');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_news_i18n`
--

CREATE TABLE IF NOT EXISTS `u_cms_news_i18n` (
  `u_cms_news_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_cms_news_i18n`
--

INSERT INTO `u_cms_news_i18n` (`u_cms_news_id`, `i18n_id`, `title`, `content`) VALUES
(3, 'en', 'News title 1', '<p><img alt="" src="//static.unitkit.local/cms/images/lg/image_53dfa4ecb66da.jpg" style="width: 800px; height: 382px;" /></p>\r\n\r\n<p>News content</p>\r\n\r\n<p>&nbsp;</p>\r\n'),
(3, 'fr', 'Actualité titre 1', '<p><img alt="" src="//static.unitkit.local/cms/images/lg/image_53dfa4ecb66da.jpg" style="width: 800px; height: 382px;" /></p>\r\n\r\n<p>Actualité 1</p>\r\n\r\n<p>&nbsp;</p>'),
(4, 'en', 'News title 2', '<p>News content 2</p>\r\n'),
(4, 'fr', 'Actualité titre 2', '<p>Actualité 2</p>\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_page`
--

CREATE TABLE IF NOT EXISTS `u_cms_page` (
`id` int(10) unsigned NOT NULL,
  `activated` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `cache_duration` int(10) unsigned NOT NULL,
  `u_cms_layout_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Contenu de la table `u_cms_page`
--

INSERT INTO `u_cms_page` (`id`, `activated`, `cache_duration`, `u_cms_layout_id`, `created_at`, `updated_at`) VALUES
(8, 1, 3600, 3, '2014-08-02 09:38:43', '2014-11-22 12:30:59'),
(37, 1, 3600, 1, '2014-08-04 15:21:22', '2014-12-04 12:26:44'),
(39, 1, 3600, 2, '2014-08-04 16:26:09', '2014-12-04 12:26:26'),
(41, 1, 100, 4, '2014-08-04 16:32:00', '2014-12-04 11:12:44'),
(42, 1, 3600, 5, '2014-11-29 12:59:22', '2014-12-04 11:42:35');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_page_content`
--

CREATE TABLE IF NOT EXISTS `u_cms_page_content` (
`id` int(10) unsigned NOT NULL,
  `u_cms_page_id` int(10) unsigned NOT NULL,
  `index` smallint(5) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- Contenu de la table `u_cms_page_content`
--

INSERT INTO `u_cms_page_content` (`id`, `u_cms_page_id`, `index`) VALUES
(75, 8, 1),
(76, 8, 2),
(62, 37, 1),
(63, 37, 2),
(64, 39, 1),
(68, 39, 2),
(66, 41, 1),
(77, 42, 1);

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_page_content_i18n`
--

CREATE TABLE IF NOT EXISTS `u_cms_page_content_i18n` (
  `u_cms_page_content_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_cms_page_content_i18n`
--

INSERT INTO `u_cms_page_content_i18n` (`u_cms_page_content_id`, `i18n_id`, `content`) VALUES
(62, 'en', '<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12">\r\n<hr />\r\n<h2 class="intro-text text-center">About-us</h2>\r\n\r\n<hr /></div>\r\n\r\n<div class="col-md-6"><img alt="" class="img-responsive img-border-left" src="//static.unitkit.local/cms/images/lg/image_53dfa4ecb66da.jpg" style="width: 800px;" /></div>\r\n\r\n<div class="col-md-6">\r\n<p>This is a great place to introduce your company or project and describe what you do.</p>\r\n\r\n<p>Lid est laborum dolo rumes fugats untras. Etharums ser quidem rerum facilis dolores nemis omnis fugats vitaes nemo minima rerums unsers sadips amets.</p>\r\n\r\n<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>\r\n</div>\r\n\r\n<div class="clearfix">&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12">\r\n<hr />\r\n<h2 class="intro-text text-center">Our <strong>Team</strong></h2>\r\n\r\n<hr /></div>\r\n\r\n<div class="col-sm-4 text-center"><img alt="" class="img-responsive" src="http://placehold.it/750x450" />\r\n<h3>John Smith <small>Job Title</small></h3>\r\n</div>\r\n\r\n<div class="col-sm-4 text-center"><img alt="" class="img-responsive" src="http://placehold.it/750x450" />\r\n<h3>John Smith <small>Job Title</small></h3>\r\n</div>\r\n\r\n<div class="col-sm-4 text-center"><img alt="" class="img-responsive" src="http://placehold.it/750x450" />\r\n<h3>John Smith <small>Job Title</small></h3>\r\n</div>\r\n\r\n<div class="clearfix">&nbsp;</div>\r\n</div>\r\n</div>\r\n'),
(62, 'fr', '<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12">\r\n<hr />\r\n<h2 class="intro-text text-center">A propos de nous</h2>\r\n\r\n<hr /></div>\r\n\r\n<div class="col-md-6"><img alt="" class="img-responsive img-border-left" src="//static.unitkit.local/cms/images/lg/image_53dfa4ecb66da.jpg" style="width: 800px;" /></div>\r\n\r\n<div class="col-md-6">&nbsp;</div>\r\n\r\n<div class="clearfix">&nbsp;</div>\r\n</div>\r\n</div>\r\n\r\n<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12">\r\n<hr />\r\n<h2 class="intro-text text-center">Notre <strong>Equipe</strong></h2>\r\n\r\n<hr /></div>\r\n\r\n<div class="col-sm-4 text-center"><img alt="" class="img-responsive" src="http://placehold.it/750x450" />\r\n<h3>John Smith <small>Titre du job</small></h3>\r\n</div>\r\n\r\n<div class="col-sm-4 text-center"><img alt="" class="img-responsive" src="http://placehold.it/750x450" />\r\n<h3>John Smith <small>Titre du job</small></h3>\r\n</div>\r\n\r\n<div class="col-sm-4 text-center"><img alt="" class="img-responsive" src="http://placehold.it/750x450" />\r\n<h3>John Smith <small>Titre du job</small></h3>\r\n</div>\r\n\r\n<div class="clearfix">&nbsp;</div>\r\n</div>\r\n</div>\r\n'),
(63, 'en', ''),
(63, 'fr', ''),
(64, 'en', '<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12">\r\n<hr />\r\n<h2 class="intro-text text-center">Contact-us</h2>\r\n\r\n<hr /></div>\r\n\r\n<div class="col-md-8"><!-- Embedded Google Map using an iframe - to select your location find it on Google maps and paste the link as the iframe src. If you want to use the Google Maps API instead then have at it! --><iframe frameborder="0" height="400" marginheight="0" marginwidth="0" scrolling="no" src="http://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=37.0625,-95.677068&amp;spn=56.506174,79.013672&amp;t=m&amp;z=4&amp;output=embed" width="100%"></iframe></div>\r\n\r\n<div class="col-md-4">\r\n<p>Phone: <strong>123.456.7890</strong></p>\r\n\r\n<p>Email: <strong><a href="mailto:name@example.com">name@example.com</a></strong></p>\r\n\r\n<p>Address: <strong>3481 Melrose Place<br />\r\nBeverly Hills, CA 90210</strong></p>\r\n</div>\r\n\r\n<div class="clearfix">&nbsp;</div>\r\n</div>\r\n</div>\r\n'),
(64, 'fr', '<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12">\r\n<hr />\r\n<h2 class="intro-text text-center"><strong>Contactez-nous</strong></h2>\r\n\r\n<hr /></div>\r\n\r\n<div class="col-md-8"><!-- Embedded Google Map using an iframe - to select your location find it on Google maps and paste the link as the iframe src. If you want to use the Google Maps API instead then have at it! --><iframe frameborder="0" height="400" marginheight="0" marginwidth="0" scrolling="no" src="http://maps.google.com/maps?hl=en&amp;ie=UTF8&amp;ll=37.0625,-95.677068&amp;spn=56.506174,79.013672&amp;t=m&amp;z=4&amp;output=embed" width="100%"></iframe></div>\r\n\r\n<div class="col-md-4">\r\n<p>Téléphone : <strong>123.456.7890</strong></p>\r\n\r\n<p>Email: <strong><a href="mailto:name@example.com">name@example.com</a></strong></p>\r\n\r\n<p>Addresse: <strong>3481 Melrose Place<br />\r\nBeverly Hills, CA 90210</strong></p>\r\n</div>\r\n\r\n<div class="clearfix">&nbsp;</div>\r\n</div>\r\n</div>\r\n'),
(66, 'en', ''),
(66, 'fr', ''),
(68, 'en', ''),
(68, 'fr', ''),
(75, 'en', '<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12 text-center"><cms_widget id="5">CAROUSEL</cms_widget>\r\n<h2 class="brand-before"><small>Welcome to</small></h2>\r\n\r\n<h1 class="brand-name">Business Casual</h1>\r\n\r\n<hr class="tagline-divider" />\r\n<h2><small>By <strong>Start Bootstrap</strong> </small></h2>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12">\r\n<hr />\r\n<h2 class="intro-text text-center">Build a website <strong>worth visiting</strong></h2>\r\n\r\n<hr /><img alt="" class="img-responsive img-border img-left" src="//static.unitkit.local/cms/images/lg/image2_53dfbb686a4c2.jpg" />\r\n<hr class="visible-xs" />\r\n<p>The boxes used in this template are nested inbetween a normal Bootstrap row and the start of your column layout. The boxes will be full-width boxes, so if you want to make them smaller then you will need to customize.</p>\r\n\r\n<p>A huge thanks to <a href="http://join.deathtothestockphoto.com/" target="_blank">Death to the Stock Photo</a> for allowing us to use the beautiful photos that make this template really come to life. When using this template, make sure your photos are decent. Also make sure that the file size on your photos is kept to a minumum to keep load times to a minimum.</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc placerat diam quis nisl vestibulum dignissim. In hac habitasse platea dictumst. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12">\r\n<hr />\r\n<h2 class="intro-text text-center">Beautiful boxes <strong>to showcase your content</strong></h2>\r\n\r\n<hr />\r\n<p>Use as many boxes as you like, and put anything you want in them! They are great for just about anything, the sky''s the limit!</p>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc placerat diam quis nisl vestibulum dignissim. In hac habitasse platea dictumst. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>\r\n</div>\r\n</div>\r\n</div>\r\n'),
(75, 'fr', '<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12 text-center"><cms_widget id="5">CAROUSEL</cms_widget>\r\n<h2 class="brand-before"><small>Bienvenue</small></h2>\r\n\r\n<h1 class="brand-name">Business Casual</h1>\r\n\r\n<hr class="tagline-divider" />\r\n<h2><small>By <strong>Start Bootstrap</strong> </small></h2>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12">\r\n<hr />\r\n<h2 class="intro-text text-center">Titre <strong>numéro 1</strong></h2>\r\n\r\n<hr /><img alt="" class="img-responsive img-border img-left" src="//static.unitkit.local/cms/images/lg/image2_53dfbb686a4c2.jpg" />\r\n<hr class="visible-xs" />Zone de contenue 1</div>\r\n</div>\r\n</div>\r\n\r\n<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12">\r\n<hr />\r\n<h2 class="intro-text text-center">Titre <strong>numero 2</strong></h2>\r\n\r\n<hr />\r\n<p>Zone de contenue 2</p>\r\n</div>\r\n</div>\r\n</div>\r\n'),
(76, 'en', ''),
(76, 'fr', ''),
(77, 'en', '<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12 text-center">\r\n<hr />\r\n<h2 class="intro-text text-center">Album <strong>DEMO</strong></h2>\r\n\r\n<hr /><cms_widget id="6">WIDGET ALBUM HIVER</cms_widget></div>\r\n</div>\r\n</div>\r\n'),
(77, 'fr', '<div class="row">\r\n<div class="box">\r\n<div class="col-lg-12 text-center">\r\n<hr />\r\n<h2 class="intro-text text-center">Album <strong>DEMO</strong></h2>\r\n\r\n<hr /><cms_widget id="6">WIDGET ALBUM HIVER</cms_widget></div>\r\n</div>\r\n</div>\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_page_i18n`
--

CREATE TABLE IF NOT EXISTS `u_cms_page_i18n` (
  `u_cms_page_id` int(11) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `html_title` varchar(255) NOT NULL,
  `html_description` text NOT NULL,
  `html_keywords` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_cms_page_i18n`
--

INSERT INTO `u_cms_page_i18n` (`u_cms_page_id`, `i18n_id`, `title`, `slug`, `html_title`, `html_description`, `html_keywords`) VALUES
(8, 'en', 'Home', 'home', 'Home', '', ''),
(8, 'fr', 'Accueil', 'home', 'Accueil', '', ''),
(37, 'en', 'About', 'about', 'About', '', ''),
(37, 'fr', 'A propos', 'a-propos', 'A propos', '', ''),
(39, 'en', 'Contact', 'contact', 'Contact', '', ''),
(39, 'fr', 'Contact', 'contact', 'Contact', '', ''),
(41, 'en', 'News', 'news', 'News', '', ''),
(41, 'fr', 'Actualité', 'actualites', 'Actualité', '', ''),
(42, 'en', 'Album', 'album', 'Album', '', ''),
(42, 'fr', 'Album', 'album', 'Album', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_social`
--

CREATE TABLE IF NOT EXISTS `u_cms_social` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `u_cms_social`
--

INSERT INTO `u_cms_social` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Facebook', '2014-07-18 22:00:00', '2014-07-19 17:43:52'),
(2, 'Twitter', '2014-07-18 22:00:00', '2014-08-01 09:12:09');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_social_i18n`
--

CREATE TABLE IF NOT EXISTS `u_cms_social_i18n` (
  `u_cms_social_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_cms_social_i18n`
--

INSERT INTO `u_cms_social_i18n` (`u_cms_social_id`, `i18n_id`, `url`) VALUES
(1, 'en', ''),
(2, 'en', '');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_widget`
--

CREATE TABLE IF NOT EXISTS `u_cms_widget` (
`id` int(10) unsigned NOT NULL,
  `path` varchar(255) NOT NULL,
  `arg` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `u_cms_widget`
--

INSERT INTO `u_cms_widget` (`id`, `path`, `arg`, `created_at`, `updated_at`) VALUES
(2, 'application.modules.frontend.widgets.news.UWidgetCmsNews', '{id:15, size:5}', '2014-07-25 10:26:10', '2014-12-04 12:18:47'),
(3, 'application.modules.frontend.widgets.social.UWidgetCmsSocial', '', '2014-07-29 14:52:12', '2014-12-04 12:18:44'),
(4, 'application.modules.frontend.widgets.menu.UWidgetCmsMenu', '{id:20,brand:"My website"}', '2014-07-29 15:55:57', '2014-12-04 12:18:40'),
(5, 'application.modules.frontend.widgets.album.UWidgetCmsCarousel', '{album_id:48,container_id:"carousel"}', '2014-08-03 07:15:10', '2014-12-04 12:18:37'),
(6, 'application.modules.frontend.widgets.album.UWidgetCmsAlbum', '{id:49, cols:4}', '2014-11-29 13:01:50', '2014-12-04 12:18:33');

-- --------------------------------------------------------

--
-- Structure de la table `u_cms_widget_i18n`
--

CREATE TABLE IF NOT EXISTS `u_cms_widget_i18n` (
  `u_cms_widget_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_cms_widget_i18n`
--

INSERT INTO `u_cms_widget_i18n` (`u_cms_widget_id`, `i18n_id`, `name`) VALUES
(2, 'en', 'News'),
(2, 'fr', 'Actualités'),
(3, 'en', 'Social networks'),
(3, 'fr', 'Réseaux sociaux'),
(4, 'en', 'Menu'),
(4, 'fr', 'Menu'),
(5, 'en', 'Carousel'),
(5, 'fr', 'Carousel'),
(6, 'en', 'Album Demo'),
(6, 'fr', 'Album Demo');

-- --------------------------------------------------------

--
-- Structure de la table `u_group`
--

CREATE TABLE IF NOT EXISTS `u_group` (
`id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Contenu de la table `u_group`
--

INSERT INTO `u_group` (`id`, `created_at`, `updated_at`) VALUES
(2, '2012-12-05 16:34:39', '2014-01-27 09:17:28'),
(3, '2014-03-29 12:11:59', '2014-10-31 16:15:50');

-- --------------------------------------------------------

--
-- Structure de la table `u_group_i18n`
--

CREATE TABLE IF NOT EXISTS `u_group_i18n` (
`u_group_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Contenu de la table `u_group_i18n`
--

INSERT INTO `u_group_i18n` (`u_group_id`, `i18n_id`, `name`) VALUES
(2, 'en', 'Super administrator'),
(2, 'fr', 'Super administrateur'),
(3, 'en', 'Backend users'),
(3, 'fr', 'Utilisateur du backend');

-- --------------------------------------------------------

--
-- Structure de la table `u_group_role`
--

CREATE TABLE IF NOT EXISTS `u_group_role` (
  `u_group_id` int(10) unsigned NOT NULL,
  `u_role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `u_group_role`
--

INSERT INTO `u_group_role` (`u_group_id`, `u_role_id`) VALUES
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 6),
(3, 6),
(2, 7),
(3, 8);

-- --------------------------------------------------------

--
-- Structure de la table `u_i18n`
--

CREATE TABLE IF NOT EXISTS `u_i18n` (
  `id` varchar(16) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `u_i18n`
--

INSERT INTO `u_i18n` (`id`) VALUES
('en'),
('es'),
('fr');

-- --------------------------------------------------------

--
-- Structure de la table `u_i18n_i18n`
--

CREATE TABLE IF NOT EXISTS `u_i18n_i18n` (
  `u_i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `u_i18n_i18n`
--

INSERT INTO `u_i18n_i18n` (`u_i18n_id`, `i18n_id`, `name`) VALUES
('en', 'en', 'English'),
('en', 'fr', 'Anglais'),
('es', 'en', 'Spanish'),
('es', 'fr', 'Espagnol'),
('fr', 'en', 'French'),
('fr', 'fr', 'Français');

-- --------------------------------------------------------

--
-- Structure de la table `u_interface_setting`
--

CREATE TABLE IF NOT EXISTS `u_interface_setting` (
  `interface_id` varchar(64) COLLATE utf8_bin NOT NULL,
  `u_person_id` int(10) unsigned NOT NULL,
  `page_size` int(10) unsigned NOT NULL DEFAULT '10'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Structure de la table `u_mail_sending_role`
--

CREATE TABLE IF NOT EXISTS `u_mail_sending_role` (
  `u_person_id` int(10) unsigned NOT NULL,
  `u_mail_template_id` int(10) unsigned NOT NULL,
  `u_mail_send_role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_mail_sending_role`
--

INSERT INTO `u_mail_sending_role` (`u_person_id`, `u_mail_template_id`, `u_mail_send_role_id`) VALUES
(2, 2, 1),
(1, 3, 2),
(2, 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `u_mail_send_role`
--

CREATE TABLE IF NOT EXISTS `u_mail_send_role` (
`id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `u_mail_send_role`
--

INSERT INTO `u_mail_send_role` (`id`, `created_at`, `updated_at`) VALUES
(1, '2013-01-25 16:30:04', '2013-01-25 16:30:16'),
(2, '2013-01-25 16:30:08', '2013-01-25 16:30:20'),
(3, '2013-01-25 16:30:27', '2013-01-25 16:30:27'),
(4, '2013-01-25 16:30:30', '2013-01-25 16:30:30');

-- --------------------------------------------------------

--
-- Structure de la table `u_mail_send_role_i18n`
--

CREATE TABLE IF NOT EXISTS `u_mail_send_role_i18n` (
  `u_mail_send_role_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_mail_send_role_i18n`
--

INSERT INTO `u_mail_send_role_i18n` (`u_mail_send_role_id`, `i18n_id`, `name`) VALUES
(1, 'en', 'From'),
(1, 'fr', 'From'),
(2, 'en', 'To'),
(2, 'fr', 'To'),
(3, 'en', 'Cc'),
(3, 'fr', 'Cc'),
(4, 'en', 'Bcc'),
(4, 'fr', 'Bcc');

-- --------------------------------------------------------

--
-- Structure de la table `u_mail_template`
--

CREATE TABLE IF NOT EXISTS `u_mail_template` (
`id` int(10) unsigned NOT NULL,
  `u_mail_template_group_id` int(10) unsigned NOT NULL,
  `html_mode` tinyint(1) unsigned NOT NULL,
  `sql_request` text NOT NULL,
  `sql_param` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `u_mail_template`
--

INSERT INTO `u_mail_template` (`id`, `u_mail_template_group_id`, `html_mode`, `sql_request`, `sql_param`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 'SELECT id, first_name, last_name, email as b_mt_email_to FROM u_person WHERE email = :email', '', '2014-06-22 15:42:45', '2014-10-28 19:12:33'),
(3, 3, 1, '', '', '2014-11-24 19:39:02', '2014-11-25 16:32:53');

-- --------------------------------------------------------

--
-- Structure de la table `u_mail_template_group`
--

CREATE TABLE IF NOT EXISTS `u_mail_template_group` (
`id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Contenu de la table `u_mail_template_group`
--

INSERT INTO `u_mail_template_group` (`id`, `created_at`, `updated_at`) VALUES
(2, '2013-01-25 13:47:50', '2013-06-13 12:22:55'),
(3, '2014-11-24 19:37:54', '2014-12-04 11:12:28');

-- --------------------------------------------------------

--
-- Structure de la table `u_mail_template_group_i18n`
--

CREATE TABLE IF NOT EXISTS `u_mail_template_group_i18n` (
  `u_mail_template_group_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `u_mail_template_group_i18n`
--

INSERT INTO `u_mail_template_group_i18n` (`u_mail_template_group_id`, `i18n_id`, `name`) VALUES
(2, 'en', 'Backend'),
(2, 'fr', 'Backend'),
(3, 'en', 'Frontend'),
(3, 'fr', 'Frontend');

-- --------------------------------------------------------

--
-- Structure de la table `u_mail_template_i18n`
--

CREATE TABLE IF NOT EXISTS `u_mail_template_i18n` (
  `u_mail_template_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `object` varchar(255) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_mail_template_i18n`
--

INSERT INTO `u_mail_template_i18n` (`u_mail_template_id`, `i18n_id`, `object`, `message`) VALUES
(2, 'en', 'Password reset', '<p>Hello {first_name}&nbsp; {last_name},</p>\r\n\r\n<p>To reset your password, please go to the following page :</p>\r\n\r\n<p>{createPasswordResetLink({id})}</p>\r\n\r\n<p>If you do not wish to reset your password, ignore this message. It will expire in {nb} hours.</p>\r\n\r\n<p>Regards</p>\r\n\r\n<p>&nbsp;</p>\r\n'),
(2, 'fr', 'Réinitialisation du mot de passe', '<p>Bonjour {first_name} {last_name},</p>\r\n\r\n<p>Afin de r&eacute;initialiser votre mot de passe, merci de vous rendre &agrave; l&#39;adresse suivante :</p>\r\n\r\n<p>{createPasswordResetLink({id})}</p>\r\n\r\n<p>Si vous ne souhaitez pas r&eacute;initialiser votre mot de passe, ignorer ce message. Il expirera dans {nb} heures.</p>\r\n\r\n<p>Cordialement</p>\r\n\r\n<p>&nbsp;</p>\r\n'),
(3, 'en', 'Contact', '<p>Hello,</p>\r\n\r\n<p>You have received a message from {firstName} {lastName}.</p>\r\n\r\n<p>Contact informations :</p>\r\n\r\n<ul>\r\n	<li>First name : {firstName}</li>\r\n	<li>Last name : {lastName}</li>\r\n	<li>Email : {email}</li>\r\n	<li>Phone : {phone}</li>\r\n</ul>\r\n\r\n<p>Message :</p>\r\n\r\n<p>{message}</p>\r\n\r\n<hr />\r\n<p>This message is automatically sent from contact page</p>\r\n'),
(3, 'fr', 'Demande de contact', '<p>Bonjour,</p>\r\n\r\n<p>Vous avez reçu un message de {firstName} {lastName}.</p>\r\n\r\n<p>Informations du contact</p>\r\n\r\n<ul>\r\n	<li>Prénom: {firstName}</li>\r\n	<li>Nom : {lastName}</li>\r\n	<li>Email : {email}</li>\r\n	<li>Téléphone : {phone}</li>\r\n</ul>\r\n\r\n<p>Message :</p>\r\n\r\n<p>{message}</p>\r\n\r\n<hr />\r\n<p>Ce message est automatiquement envoyé depuis la page de contact</p>\r\n');

-- --------------------------------------------------------

--
-- Structure de la table `u_message`
--

CREATE TABLE IF NOT EXISTS `u_message` (
`id` int(10) unsigned NOT NULL,
  `u_message_group_id` int(10) unsigned DEFAULT NULL,
  `source` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=532 ;

--
-- Contenu de la table `u_message`
--

INSERT INTO `u_message` (`id`, `u_message_group_id`, `source`, `created_at`, `updated_at`) VALUES
(11, 1, 'u_i18n_fr', '2013-01-23 07:30:52', '2014-11-26 15:16:26'),
(12, 1, 'u_i18n_en', '2013-01-23 07:31:31', '2014-11-26 15:16:26'),
(13, 1, 'u_i18n_de', '2013-01-23 07:47:12', '2014-11-26 15:16:26'),
(14, 2, 'navbar_parameter', '2013-01-23 08:07:53', '2014-04-12 10:20:22'),
(15, 2, 'navbar_variable', '2013-01-23 08:10:33', '2014-04-12 10:20:22'),
(17, 1, 'btn_save', '2013-01-23 08:11:33', '2014-04-12 10:20:22'),
(18, 1, 'btn_add', '2013-01-23 08:12:34', '2014-06-28 11:29:10'),
(19, 1, 'btn_add_again', '2013-01-23 08:12:55', '2014-06-28 11:29:10'),
(20, 1, 'btn_close', '2013-01-23 08:13:08', '2014-06-28 11:29:10'),
(22, 1, 'btn_advanced_search', '2013-01-23 08:15:43', '2014-06-28 11:29:10'),
(23, 1, 'is_saved', '2013-01-23 08:16:32', '2014-06-28 11:29:10'),
(24, 1, 'advanced_search_title', '2013-01-23 08:41:06', '2014-06-28 11:29:10'),
(25, 1, 'btn_search', '2013-01-23 08:41:36', '2014-06-28 11:29:10'),
(26, 1, 'u_message:source', '2013-01-23 08:51:03', '2014-06-28 11:29:10'),
(27, 1, 'u_message_category_i18n:name', '2013-01-23 08:51:21', '2014-07-05 11:21:02'),
(29, 1, 'input_search', '2013-01-23 10:28:40', '2014-11-01 10:07:39'),
(30, 1, 'navbar_current_language', '2013-01-24 10:23:34', '2014-04-12 10:20:22'),
(34, 1, 'login_btn_connect', '2013-01-24 15:43:12', '2014-04-12 10:20:22'),
(36, 1, 'btn_check_all', '2013-01-24 16:25:07', '2014-04-12 10:20:22'),
(38, 1, 'btn_uncheck_all', '2013-01-24 16:26:39', '2014-04-12 10:20:22'),
(42, 1, 'btn_delete_selected', '2013-01-24 16:29:10', '2014-04-12 10:20:22'),
(43, 1, 'list_title', '2013-01-24 16:40:48', '2014-07-07 09:49:11'),
(44, 1, 'btn_settings', '2013-01-24 16:41:10', '2014-04-12 10:20:22'),
(45, 2, 'translate_title', '2013-01-25 16:31:29', '2014-07-06 08:23:30'),
(46, 1, 'input_select', '2013-01-26 15:45:43', '2014-07-19 10:06:05'),
(47, 1, 'input_drop_down_list_all', '2013-01-28 13:51:30', '2014-06-28 11:13:22'),
(48, 1, 'input_drop_down_list_checked', '2013-01-28 13:53:49', '2014-06-28 11:13:22'),
(49, 1, 'input_drop_down_list_unchecked', '2013-01-28 13:54:25', '2014-06-28 11:13:22'),
(51, 2, 'mail_template_btn_list_role', '2013-01-29 15:41:47', '2014-04-12 10:20:22'),
(54, 1, 'u_person:first_name', '2013-01-30 17:02:04', '2014-06-28 11:13:22'),
(55, 1, 'u_person:last_name', '2013-01-30 17:02:17', '2014-07-10 18:43:31'),
(56, 1, 'u_person:email', '2013-01-30 17:02:40', '2014-06-28 11:13:22'),
(57, 1, 'u_person:password', '2013-01-30 17:02:51', '2014-06-28 11:13:22'),
(61, 2, 'profile_password_is_required', '2013-01-30 19:29:35', '2014-06-27 10:14:18'),
(65, 1, 'person_email_exist', '2013-01-30 19:33:01', '2014-06-28 11:13:22'),
(66, 2, 'person_profile:password', '2013-01-30 19:33:35', '2014-06-27 10:05:17'),
(71, 1, 'go_to_login', '2013-01-31 20:43:00', '2014-06-28 11:13:22'),
(73, 2, 'login_form:username', '2013-01-31 21:06:48', '2014-11-22 10:51:15'),
(74, 2, 'login_form:remember_me', '2013-01-31 21:07:11', '2014-11-22 10:51:15'),
(76, 2, 'account_not_validated', '2013-01-31 21:28:41', '2014-11-22 10:51:15'),
(81, 1, 'captcha_help', '2013-01-31 22:28:48', '2014-11-22 10:51:15'),
(96, 1, 'update', '2013-02-05 08:13:03', '2014-11-22 10:51:15'),
(99, 2, 'list_right_title', '2013-02-05 12:02:03', '2014-11-22 10:51:15'),
(102, 2, 'select_interface_title', '2013-02-05 15:01:48', '2014-11-22 10:51:15'),
(145, 1, 'edit_create_title', '2013-02-20 08:06:04', '2014-11-22 10:51:15'),
(146, 1, 'edit_update_title', '2013-02-20 08:06:21', '2014-11-22 10:51:15'),
(160, 2, 'navbar_media', '2013-02-20 14:00:45', '2014-11-22 10:51:15'),
(162, 2, 'navbar_message', '2013-02-20 14:01:18', '2014-07-05 09:38:04'),
(163, 2, 'navbar_right', '2013-02-20 14:01:38', '2014-06-27 09:22:10'),
(164, 2, 'navbar_language', '2013-02-20 14:01:52', '2014-06-27 09:22:10'),
(165, 2, 'navbar_mail', '2013-02-20 14:02:09', '2014-06-27 09:22:10'),
(178, 1, 'warning', '2013-02-21 09:19:43', '2014-04-12 10:36:07'),
(186, 1, 'btn_send', '2013-02-21 11:27:49', '2014-04-12 10:36:07'),
(189, 1, 'btn_cancel', '2013-02-21 11:28:58', '2014-04-12 10:36:07'),
(190, 1, 'btn_export_csv', '2013-04-17 11:44:53', '2014-04-12 10:36:07'),
(191, 1, 'no_results', '2013-04-25 09:56:57', '2014-04-12 10:36:07'),
(192, 1, 'list_advanced_search_title', '2013-04-25 09:57:36', '2014-04-12 10:36:07'),
(193, 1, 'u_message:u_message_group_id', '2013-04-25 09:58:49', '2014-07-10 18:43:31'),
(194, 2, 'navbar_member', '2013-04-25 10:01:24', '2014-06-27 09:22:10'),
(195, 1, 'settings_title', '2013-04-25 10:02:21', '2014-06-28 11:12:06'),
(196, 1, 'u_interface_setting:page_size', '2013-04-25 10:02:54', '2014-06-28 11:12:06'),
(197, 2, 'navbar_mail_template', '2013-04-25 10:03:52', '2014-07-08 15:31:01'),
(198, 2, 'navbar_mail_template_group', '2013-04-25 10:05:49', '2014-07-08 15:34:39'),
(199, 2, 'navbar_mail_send_role', '2013-04-25 10:06:34', '2014-07-08 15:25:51'),
(209, 2, 'navbar_variable_group', '2013-04-25 10:25:45', '2014-07-07 09:53:19'),
(211, 2, 'navbar_message_group', '2013-04-25 10:29:05', '2014-07-08 15:18:01'),
(213, 2, 'navbar_person_group', '2013-04-25 10:30:06', '2014-07-07 09:53:19'),
(214, 2, 'navbar_group_role', '2013-04-25 10:30:40', '2014-07-07 09:53:19'),
(215, 2, 'navbar_auto_login', '2013-04-25 10:31:10', '2014-04-12 10:36:07'),
(217, 2, 'navbar_role', '2013-04-25 10:31:37', '2014-04-12 10:36:07'),
(219, 2, 'navbar_site_i18n', '2013-04-25 10:32:04', '2014-04-12 10:36:07'),
(220, 2, 'navbar_i18n', '2013-04-25 10:32:31', '2014-04-12 10:36:07'),
(227, 1, 'u_person:default_language', '2013-04-25 10:43:24', '2014-07-08 15:03:55'),
(228, 1, 'u_message_group_i18n:name', '2013-04-25 10:44:12', '2014-07-08 15:18:01'),
(229, 1, 'u_message_i18n:translation', '2013-04-25 10:44:48', '2014-06-28 11:12:06'),
(230, 1, 'navbar_logout', '2013-04-25 10:45:22', '2014-06-28 11:12:06'),
(231, 1, 'u_person:u_groups', '2013-04-25 10:46:37', '2014-06-28 11:12:06'),
(232, 1, 'u_mail_template_i18n:object', '2013-04-25 10:47:24', '2014-06-28 11:12:06'),
(233, 1, 'u_mail_template_i18n:message', '2013-04-25 10:47:39', '2014-04-12 10:36:07'),
(234, 1, 'u_mail_template_group_i18n:name', '2013-04-25 10:47:58', '2014-07-05 11:21:02'),
(235, 1, 'u_mail_template:html_mode', '2013-04-25 10:48:12', '2014-04-12 10:36:07'),
(236, 2, 'login_title', '2013-04-25 10:51:08', '2014-07-14 09:41:13'),
(237, 1, 'btn_update', '2013-04-25 10:52:25', '2014-04-13 15:48:13'),
(238, 1, 'btn_edit_inline', '2013-04-25 10:53:24', '2014-04-12 10:36:07'),
(239, 1, 'btn_delete', '2013-04-25 10:54:03', '2014-04-12 10:36:07'),
(240, 1, 'btn_translate', '2013-04-25 11:00:37', '2014-07-06 08:23:30'),
(243, 1, 'btn_confirm', '2013-04-25 11:59:17', '2014-04-12 10:36:07'),
(244, 1, 'modal_remove_selected', '2013-04-25 12:00:05', '2014-07-19 10:06:05'),
(245, 1, 'modal_remove_one', '2013-04-25 12:12:21', '2014-06-19 09:59:18'),
(246, 2, 'u_person_email_exist', '2013-05-29 14:52:02', '2014-06-27 09:38:37'),
(247, 2, 'navbar_adv_setting', '2013-06-14 10:35:42', '2014-06-19 09:59:18'),
(248, 2, 'navbar_db_schema_flush', '2013-06-14 10:37:05', '2014-06-19 09:59:18'),
(249, 2, 'db_shema_refresh_title', '2013-06-14 10:38:59', '2014-06-19 09:59:18'),
(250, 2, 'db_schema_is_refreshed', '2013-06-14 10:39:57', '2014-04-12 10:36:07'),
(251, 2, 'navbar_profile', '2013-06-14 10:41:16', '2014-11-01 09:37:06'),
(252, 2, 'profile_edit_title', '2013-06-14 10:41:58', '2014-11-01 09:37:06'),
(253, 1, 'model:created_at', '2013-06-14 11:15:09', '2014-04-13 15:48:07'),
(254, 1, 'model:updated_at', '2013-06-14 11:15:36', '2014-04-13 15:48:13'),
(261, 2, 'right_right_interface_list_title', '2013-06-20 05:24:28', '2014-04-12 10:36:07'),
(263, 1, 'model:id', '2013-06-20 06:02:44', '2014-06-19 16:35:49'),
(264, 1, 'u_mail_template:sql_request', '2013-06-20 06:03:40', '2014-04-12 10:36:07'),
(265, 1, 'u_mail_template:sql_param', '2013-06-20 06:04:14', '2014-04-12 10:36:07'),
(266, 1, 'u_mail_template:u_mail_template_group_id', '2013-06-20 06:07:40', '2014-07-08 15:31:01'),
(267, 1, 'u_mail_send_role_i18n:name', '2013-06-20 06:08:55', '2014-07-05 11:21:02'),
(268, 1, 'u_person:fullName', '2013-06-20 06:14:52', '2014-04-12 10:36:07'),
(269, 1, 'u_mail_sending_role:u_mail_send_role_id', '2013-06-20 06:20:48', '2014-07-08 15:25:51'),
(270, 1, 'u_variable:param', '2013-06-20 06:22:17', '2014-07-10 18:43:31'),
(271, 1, 'u_variable_group_i18n:name', '2013-06-20 06:22:34', '2014-07-05 16:02:47'),
(272, 1, 'u_variable:val', '2013-06-20 06:22:48', '2014-04-12 10:36:07'),
(273, 1, 'u_variable_i18n:description', '2013-06-20 06:23:01', '2014-04-12 10:36:07'),
(274, 1, 'u_variable:u_variable_group_id', '2013-06-20 06:26:51', '2014-07-10 18:43:31'),
(277, 2, 'right_group_role_edit_title', '2013-06-20 07:12:55', '2014-04-12 10:36:07'),
(278, 2, 'right_auto_login_list_title', '2013-06-20 07:13:40', '2014-04-12 10:36:07'),
(279, 1, 'u_auto_login:duration', '2013-06-20 07:14:32', '2014-04-12 10:36:07'),
(280, 1, 'u_auto_login:expired_at', '2013-06-20 07:14:45', '2014-04-12 10:36:07'),
(281, 1, 'u_auto_login:key1', '2013-06-20 07:15:05', '2014-04-12 10:36:07'),
(282, 1, 'u_auto_login:key2', '2013-06-20 07:15:18', '2014-04-12 10:36:07'),
(283, 2, 'right_interface_list_title', '2013-06-20 07:17:15', '2014-05-04 09:33:12'),
(285, 2, 'right_role_list_title', '2013-06-20 07:18:41', '2014-07-08 14:49:23'),
(287, 2, 'right_action_list_title', '2013-06-20 07:20:22', '2014-05-04 09:33:11'),
(290, 1, 'u_i18n_i18n:name', '2013-06-20 07:22:03', '2014-11-26 15:16:26'),
(291, 1, 'model:name', '2013-06-20 07:22:15', '2014-07-05 11:21:02'),
(293, 2, 'person_profile:old_password', '2013-06-20 07:27:53', '2014-06-27 10:05:17'),
(294, 2, 'person_profile:repeat_password', '2013-06-20 07:29:51', '2014-06-27 10:05:17'),
(295, 2, 'welcome_backend', '2013-10-01 06:54:46', '2014-04-29 09:12:17'),
(298, 1, 'date_range_between', '2014-01-22 13:58:34', '2014-04-29 09:12:17'),
(299, 1, 'date_range_separator', '2014-01-22 13:59:00', '2014-04-29 09:12:17'),
(300, 1, 'select_input_add', '2014-01-22 14:19:09', '2014-04-29 09:12:17'),
(301, 1, 'u_variable_group:code', '2014-01-22 14:20:47', '2014-07-05 16:02:47'),
(302, 2, 'navbar_cache', '2014-01-22 14:22:13', '2014-05-04 15:46:07'),
(303, 2, 'navbar_person', '2014-01-22 14:22:53', '2014-05-04 15:46:07'),
(304, 2, 'btn_translate_all_message', '2014-01-22 14:39:04', '2014-07-06 08:23:30'),
(307, 1, 'create_title', '2014-04-29 09:24:41', '2014-07-19 19:24:35'),
(311, 1, 'update_title', '2014-05-04 15:36:58', '2014-07-19 19:24:17'),
(316, 2, 'person_group', '2014-05-04 16:25:07', '2014-06-27 11:02:07'),
(318, 2, 'bad_login_password', '2014-06-19 16:30:27', '2014-06-28 11:32:23'),
(320, 2, 'login_form:password', '2014-06-26 18:31:01', '2014-07-30 19:26:56'),
(321, 2, 'account_not_activated', '2014-06-27 09:17:57', '2014-11-26 13:56:48'),
(322, 2, 'u_person_email_not_exist', '2014-06-27 09:56:42', '2014-07-03 12:32:55'),
(323, 2, 'password_reset_email_sent', '2014-06-27 10:01:11', '2014-07-04 18:36:53'),
(324, 2, 'profile_old_password_not_valid', '2014-06-27 10:15:14', '2014-07-04 18:36:53'),
(326, 2, 'reset_password_invalid_token', '2014-06-27 14:25:41', '2014-07-04 18:36:53'),
(327, 2, 'password_reset_title', '2014-06-27 14:48:30', '2014-07-04 18:36:53'),
(328, 2, 'password_reset_renew', '2014-06-27 16:53:52', '2014-07-04 18:36:53'),
(329, 2, 'password_reset_cant_be_reset', '2014-06-28 07:38:28', '2014-07-04 18:36:53'),
(331, 1, 'u_person:active_reset', '2014-06-28 16:11:10', '2014-07-05 09:43:59'),
(334, 2, 'cms_page_container_index', '2014-07-03 15:59:36', '2014-07-05 09:43:59'),
(335, 2, 'cache_refresh_success', '2014-07-04 18:35:38', '2014-07-05 09:43:59'),
(336, 2, 'cache_refresh_error', '2014-07-04 18:35:54', '2014-07-21 07:39:57'),
(337, 2, 'navbar_cms', '2014-07-05 09:37:13', '2014-07-05 09:43:59'),
(338, 2, 'navbar_cms_page', '2014-07-05 09:37:48', '2014-07-05 09:43:59'),
(339, 2, 'navbar_cms_edito', '2014-07-05 09:39:00', '2014-07-08 15:59:15'),
(340, 2, 'navbar_cms_layout', '2014-07-05 09:41:49', '2014-07-08 15:57:19'),
(341, 2, 'navbar_cms_edito_group', '2014-07-05 09:43:00', '2014-07-12 05:48:52'),
(342, 2, 'navbar_cms_widget', '2014-07-05 09:43:20', '2014-07-08 15:59:33'),
(343, 2, 'navbar_cms_image', '2014-07-05 09:44:20', '2014-07-05 09:57:11'),
(345, 1, 'model:activated', '2014-07-05 09:49:38', '2014-11-26 13:56:48'),
(346, 1, 'model:validated', '2014-07-05 09:52:36', '2014-07-05 09:57:11'),
(347, 1, 'u_cms_page:cache_duration', '2014-07-05 09:53:43', '2014-07-21 07:39:57'),
(348, 1, 'u_cms_page_i18n:title', '2014-07-05 09:54:40', '2014-07-08 13:00:39'),
(349, 1, 'u_cms_page_i18n:html_title', '2014-07-05 09:56:32', '2014-07-08 13:00:39'),
(350, 1, 'u_cms_page_i18n:html_description', '2014-07-05 09:56:56', '2014-07-08 14:04:23'),
(351, 1, 'u_cms_page_i18n:html_keywords', '2014-07-05 09:57:42', '2014-07-08 14:04:23'),
(352, 2, 'u_cms_page:pageContainers', '2014-07-05 09:59:38', '2014-07-05 10:16:01'),
(353, 1, 'u_cms_page:u_cms_layout_id', '2014-07-05 10:02:13', '2014-07-08 15:57:19'),
(354, 1, 'u_cms_layout:max_container', '2014-07-05 10:12:04', '2014-07-13 09:33:13'),
(355, 1, 'u_cms_layout:path', '2014-07-05 10:12:24', '2014-07-13 09:33:13'),
(356, 2, 'btn_refresh_all_cms_page', '2014-07-05 10:13:23', '2014-07-21 07:39:57'),
(357, 2, 'btn_refresh_cms_page', '2014-07-05 10:16:54', '2014-07-21 07:39:57'),
(359, 2, 'u_cms_page:cacheManagment', '2014-07-05 10:27:13', '2014-07-21 07:39:57'),
(360, 1, 'u_cms_widget:path', '2014-07-05 10:27:48', '2014-07-08 15:59:33'),
(361, 1, 'model:title', '2014-07-05 10:32:07', '2014-07-05 11:19:53'),
(367, 1, 'model:description', '2014-07-05 10:44:55', '2014-07-05 15:45:47'),
(368, 1, 'u_cms_layout_i18n:name', '2014-07-05 11:16:06', '2014-07-21 07:40:25'),
(371, 1, 'u_cms_widget_i18n:name', '2014-07-05 15:23:49', '2014-07-08 15:59:33'),
(372, 1, 'u_cms_image:file_path', '2014-07-05 15:25:18', '2014-07-08 16:10:29'),
(373, 1, 'u_cms_image:code', '2014-07-05 15:25:39', '2014-07-05 15:58:02'),
(374, 1, 'u_cms_image_i18n:title', '2014-07-05 15:26:01', '2014-07-05 15:58:02'),
(377, 1, 'u_role:operation', '2014-07-05 15:50:10', '2014-07-05 15:58:02'),
(378, 1, 'u_role:business_rule', '2014-07-05 15:50:40', '2014-07-05 15:58:02'),
(392, 1, 'u_message_source_exist', '2014-07-05 16:52:10', '2014-07-06 08:32:25'),
(398, 2, 'person_create_title', '2014-07-06 13:54:45', '2014-07-19 19:24:35'),
(399, 2, 'person_update_title', '2014-07-06 13:55:10', '2014-07-06 13:55:10'),
(401, 1, 'translate_title', '2014-07-07 09:50:45', '2014-07-07 09:50:45'),
(402, 1, 'u_cms_page_i18n:slug', '2014-07-08 13:00:23', '2014-07-08 14:04:23'),
(403, 1, 'u_cms_page_i18n_slug_exist', '2014-07-08 14:02:22', '2014-07-08 14:04:23'),
(405, 2, 'variable_variable_create_title', '2014-07-08 14:37:12', '2014-07-19 19:24:35'),
(406, 2, 'variable_variable_update_title', '2014-07-08 14:37:29', '2014-07-08 14:37:29'),
(407, 2, 'variable_variable_group_list_title', '2014-07-08 14:38:10', '2014-07-08 14:38:10'),
(408, 2, 'variable_variable_group_create_title', '2014-07-08 14:39:58', '2014-07-19 19:24:35'),
(409, 2, 'variable_variable_group_update_title', '2014-07-08 14:40:35', '2014-07-08 14:40:35'),
(410, 2, 'right_person_list_title', '2014-07-08 14:41:01', '2014-07-08 14:41:01'),
(411, 2, 'right_person_create_title', '2014-07-08 14:42:02', '2014-07-19 19:24:35'),
(412, 2, 'right_person_update_title', '2014-07-08 14:42:59', '2014-07-08 14:42:59'),
(413, 2, 'right_person_group_list_title', '2014-07-08 14:44:10', '2014-07-08 14:44:10'),
(414, 2, 'right_person_group_create_title', '2014-07-08 14:44:59', '2014-07-08 14:44:59'),
(415, 2, 'right_person_group_update_title', '2014-07-08 14:46:28', '2014-07-08 14:46:28'),
(416, 2, 'right_role_create_title', '2014-07-08 14:50:18', '2014-07-08 14:50:18'),
(417, 2, 'right_role_update_title', '2014-07-08 14:50:39', '2014-07-08 14:50:39'),
(418, 2, 'auto_login_auto_login_list_title', '2014-07-08 14:52:21', '2014-07-08 14:52:21'),
(419, 2, 'variable_variable_list_title', '2014-07-08 14:57:19', '2014-07-08 15:03:03'),
(420, 2, 'i18n_site_i18n_list_title', '2014-07-08 14:59:09', '2014-07-08 15:06:06'),
(422, 2, 'i18n_site_i18n_create_title', '2014-07-08 15:01:56', '2014-07-08 15:06:06'),
(423, 2, 'i18n_site_i18n_update_title', '2014-07-08 15:02:25', '2014-07-08 15:06:06'),
(424, 1, 'u_site_i18n:i18n_id', '2014-07-08 15:02:52', '2014-07-08 15:06:06'),
(425, 2, 'i18n_i18n_list_title', '2014-07-08 15:05:10', '2014-07-08 15:06:06'),
(426, 2, 'i18n_i18n_create_title', '2014-07-08 15:06:38', '2014-07-08 15:06:38'),
(427, 2, 'i18n_i18n_update_title', '2014-07-08 15:07:04', '2014-07-08 15:07:04'),
(428, 2, 'message_message_list_title', '2014-07-08 15:08:22', '2014-07-08 15:08:22'),
(429, 2, 'message_message_create_title', '2014-07-08 15:10:41', '2014-07-08 15:19:44'),
(430, 2, 'message_message_update_title', '2014-07-08 15:11:00', '2014-07-08 15:19:44'),
(431, 2, 'message_message_group_list_title', '2014-07-08 15:17:32', '2014-07-08 15:19:44'),
(432, 2, 'message_message_group_create_title', '2014-07-08 15:18:57', '2014-07-08 15:19:44'),
(433, 2, 'message_message_group_update_title', '2014-07-08 15:19:38', '2014-07-08 15:19:44'),
(434, 2, 'mail_mail_template_list_title', '2014-07-08 15:20:35', '2014-07-08 15:30:35'),
(435, 2, 'mail_mail_template_create_title', '2014-07-08 15:22:32', '2014-07-08 15:30:35'),
(436, 2, 'mail_mail_template_update_title', '2014-07-08 15:23:04', '2014-07-08 15:30:35'),
(437, 2, 'mail_mail_sending_role_list_title', '2014-07-08 15:24:17', '2014-07-08 17:00:24'),
(438, 2, 'mail_mail_sending_role_create_title', '2014-07-08 15:24:59', '2014-07-08 17:00:24'),
(439, 2, 'mail_mail_template_group_list_title', '2014-07-08 15:27:34', '2014-07-08 15:33:29'),
(440, 2, 'mail_mail_template_group_create_title', '2014-07-08 15:29:30', '2014-07-08 15:33:29'),
(441, 2, 'mail_mail_template_group_update_title', '2014-07-08 15:33:19', '2014-07-08 15:33:29'),
(442, 2, 'cms_page_container_list_title', '2014-07-08 15:52:01', '2014-07-08 15:52:01'),
(443, 2, 'cms_page_container_create_title', '2014-07-08 15:55:42', '2014-07-08 15:55:42'),
(444, 2, 'cms_page_container_update_title', '2014-07-08 15:56:05', '2014-07-08 15:56:05'),
(445, 2, 'cms_layout_list_title', '2014-07-08 15:56:46', '2014-07-08 15:57:19'),
(446, 2, 'cms_layout_create_title', '2014-07-08 15:58:09', '2014-07-08 15:58:09'),
(447, 2, 'cms_layout_update_title', '2014-07-08 15:58:38', '2014-07-08 15:58:38'),
(448, 2, 'cms_edito_list_title', '2014-07-08 16:00:00', '2014-07-12 05:48:52'),
(449, 2, 'cms_edito_create_title', '2014-07-08 16:00:28', '2014-07-08 16:00:28'),
(450, 2, 'cms_edito_update_title', '2014-07-08 16:00:54', '2014-07-11 12:44:52'),
(452, 2, 'cms_edito_group_create_title', '2014-07-08 16:02:41', '2014-07-11 12:44:52'),
(453, 2, 'cms_edito_group_update_title', '2014-07-08 16:03:24', '2014-08-05 09:00:11'),
(454, 2, 'cms_widget_list_title', '2014-07-08 16:05:15', '2014-08-05 09:00:11'),
(455, 2, 'cms_widget_create_title', '2014-07-08 16:05:41', '2014-08-05 09:00:11'),
(456, 2, 'cms_widget_update_title', '2014-07-08 16:06:05', '2014-08-05 09:00:11'),
(457, 2, 'cms_image_list_title', '2014-07-08 16:06:34', '2014-08-05 09:00:11'),
(458, 2, 'cms_image_create_title', '2014-07-08 16:07:29', '2014-08-05 09:00:11'),
(459, 2, 'cms_image_update_title', '2014-07-08 16:08:28', '2014-08-05 09:00:11'),
(460, 1, 'btn_upload', '2014-07-08 16:09:19', '2014-08-05 09:00:11'),
(461, 2, 'mail_mail_sending_role_update_title', '2014-07-08 17:00:05', '2014-08-05 09:00:11'),
(462, 1, 'uploader_max_size', '2014-07-09 07:03:13', '2014-08-05 09:00:11'),
(463, 1, 'select_input_update', '2014-07-10 09:55:35', '2014-07-18 09:20:57'),
(464, 2, 'btn_cms_image_select', '2014-07-10 14:25:09', '2014-07-19 10:06:05'),
(465, 1, 'u_cms_layout:view', '2014-07-13 09:32:30', '2014-07-18 09:20:57'),
(466, 2, 'cms_social_list_title', '2014-07-19 09:51:47', '2014-07-19 10:03:25'),
(467, 2, 'cms_social_update_title', '2014-07-19 09:52:23', '2014-07-19 10:03:25'),
(468, 1, 'u_cms_social:name', '2014-07-19 09:52:59', '2014-07-19 10:03:25'),
(469, 1, 'u_cms_social_i18n:url', '2014-07-19 09:54:02', '2014-07-20 11:05:55'),
(470, 2, 'navbar_cms_social', '2014-07-19 09:55:41', '2014-07-20 11:05:55'),
(471, 1, 'u_cms_album_i18n:title', '2014-07-20 11:01:05', '2014-07-20 11:05:55'),
(472, 1, 'u_cms_album_photo:file_path', '2014-07-20 11:01:51', '2014-07-20 11:05:55'),
(473, 1, 'u_cms_album_photo:u_cms_album_id', '2014-07-20 11:02:17', '2014-07-20 11:05:55'),
(474, 1, 'u_cms_album_photo_i18n:title', '2014-07-20 13:17:37', '2014-07-20 13:17:37'),
(475, 2, 'btn_back_album', '2014-07-21 09:07:39', '2014-07-21 09:07:39'),
(476, 2, 'navbar_cms_album', '2014-07-21 09:08:05', '2014-07-21 09:08:05'),
(477, 2, 'cms_album_list_title', '2014-07-21 09:13:16', '2014-07-21 09:13:16'),
(478, 2, 'cms_album_create_title', '2014-07-21 09:14:45', '2014-07-21 09:35:35'),
(479, 2, 'cms_album_update_title', '2014-07-21 09:15:03', '2014-07-21 09:35:35'),
(480, 2, 'cms_album_photo_list_title', '2014-07-21 09:32:44', '2014-07-21 09:35:35'),
(481, 2, 'cms_album_photo_create_title', '2014-07-21 09:34:36', '2014-07-21 09:35:35'),
(482, 2, 'cms_album_photo_update_title', '2014-07-21 09:35:23', '2014-07-21 09:35:35'),
(483, 2, 'btn_add_cms_album_photo', '2014-07-21 11:27:04', '2014-07-25 11:42:23'),
(484, 1, 'u_cms_widget:arg', '2014-07-21 14:04:40', '2014-07-25 11:42:23'),
(485, 2, 'btn_view_photos', '2014-07-21 14:46:01', '2014-07-25 11:42:23'),
(486, 2, 'btn_cms_image_select_sm', '2014-07-23 14:44:43', '2014-07-28 16:10:01'),
(487, 2, 'btn_cms_image_select_lg', '2014-07-23 14:45:02', '2014-07-28 16:10:54'),
(488, 1, 'u_cms_news_group_i18n:name', '2014-07-28 16:08:45', '2014-11-22 10:57:36'),
(489, 1, 'u_cms_news_i18n:title', '2014-07-28 16:09:09', '2014-07-28 16:24:18'),
(490, 1, 'u_cms_news_i18n:content', '2014-07-28 16:09:37', '2014-07-28 16:24:18'),
(491, 1, 'u_cms_news:u_cms_news_group_id', '2014-07-28 16:10:18', '2014-07-28 16:24:18'),
(493, 2, 'cms_news_list_title', '2014-07-28 16:20:38', '2014-11-22 10:57:36'),
(494, 2, 'cms_news_create_title', '2014-07-28 16:21:46', '2014-07-28 16:21:46'),
(495, 2, 'cms_news_update_title', '2014-07-28 16:22:07', '2014-07-28 16:22:07'),
(496, 2, 'cms_news_group_create_title', '2014-07-28 16:22:36', '2014-11-22 10:57:36'),
(497, 2, 'cms_news_group_update_title', '2014-07-28 16:22:58', '2014-11-22 10:57:36'),
(498, 2, 'cms_news_group_list_title', '2014-07-28 16:23:22', '2014-11-22 10:57:36'),
(499, 2, 'cms_edito_group_list_title', '2014-07-28 16:27:47', '2014-07-28 16:30:13'),
(500, 2, 'navbar_cms_news', '2014-07-28 16:29:51', '2014-11-22 10:57:36'),
(503, 2, 'navbar_cms_news_group', '2014-07-28 16:40:33', '2014-11-22 10:57:36'),
(504, 2, 'navbar_cms_menu', '2014-07-28 16:40:59', '2014-07-28 16:40:59'),
(505, 2, 'navbar_cms_menu_group', '2014-07-28 16:41:18', '2014-07-28 16:41:18'),
(506, 2, 'cms_menu_list_title', '2014-07-28 16:41:39', '2014-11-01 09:32:47'),
(507, 2, 'cms_menu_create_title', '2014-07-28 16:42:05', '2014-11-01 09:32:47'),
(508, 2, 'cms_menu_update_title', '2014-07-28 16:42:37', '2014-11-24 18:30:39'),
(509, 2, 'cms_menu_group_list_title', '2014-07-28 16:43:23', '2014-11-24 18:32:02'),
(510, 1, 'u_cms_menu_group_i18n:name', '2014-07-28 16:43:39', '2014-11-24 18:32:02'),
(511, 2, 'cms_menu_group_create_title', '2014-07-28 16:44:34', '2014-11-24 18:32:02'),
(512, 2, 'cms_menu_group_update_title', '2014-07-28 16:45:14', '2014-11-24 18:32:02'),
(513, 1, 'u_cms_menu_i18n:name', '2014-07-28 16:45:47', '2014-11-24 18:32:02'),
(514, 1, 'u_cms_menu_i18n:url', '2014-07-28 16:46:45', '2014-11-24 18:32:02'),
(515, 1, 'u_cms_menu:u_cms_menu_group_id', '2014-07-29 13:13:19', '2014-11-24 18:32:02'),
(516, 2, 'url_manager_refresh_title', '2014-11-24 18:29:12', '2014-11-24 18:32:02'),
(517, 2, 'url_manager_schema_flush', '2014-11-24 18:30:01', '2014-11-26 15:17:03'),
(518, 2, 'url_is_refreshed', '2014-11-24 18:31:50', '2014-12-04 10:57:07'),
(519, 3, 'contact_form:first_name', '2014-11-25 15:30:08', '2014-12-04 10:57:07'),
(520, 3, 'contact_form:last_name', '2014-11-25 15:30:27', '2014-12-05 08:41:31'),
(521, 3, 'contact_form:email', '2014-11-25 15:30:40', '2014-12-05 08:41:31'),
(522, 3, 'contact_form:phone', '2014-11-25 15:31:03', '2014-12-05 08:41:31'),
(523, 3, 'contact_form:message', '2014-11-25 15:32:47', '2014-12-05 08:41:31'),
(524, 3, 'email_is_sent', '2014-11-25 16:03:35', '2014-12-05 08:41:31'),
(525, 1, 'u_site_i18n:activated', '2014-11-26 13:56:28', '2014-12-05 08:41:31'),
(526, 1, 'u_i18n_es', '2014-11-26 15:16:01', '2014-12-05 08:41:31'),
(528, 1, 'u_cms_news:published_at', '2014-11-27 19:51:38', '2014-12-05 08:41:31'),
(529, 1, 'mail_template_not_exist', '2014-12-05 08:39:44', '2014-12-05 08:41:31'),
(530, 1, 'mail_template_not_translated', '2014-12-05 08:41:20', '2014-12-05 08:41:31');

-- --------------------------------------------------------

--
-- Structure de la table `u_message_group`
--

CREATE TABLE IF NOT EXISTS `u_message_group` (
`id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `u_message_group`
--

INSERT INTO `u_message_group` (`id`, `created_at`, `updated_at`) VALUES
(1, '2014-06-28 10:37:52', '2014-07-30 19:19:58'),
(2, '2013-01-11 11:03:27', '2014-06-28 14:03:47'),
(3, '2014-08-02 09:29:12', '2014-08-02 09:29:12');

-- --------------------------------------------------------

--
-- Structure de la table `u_message_group_i18n`
--

CREATE TABLE IF NOT EXISTS `u_message_group_i18n` (
  `u_message_group_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `u_message_group_i18n`
--

INSERT INTO `u_message_group_i18n` (`u_message_group_id`, `i18n_id`, `name`) VALUES
(1, 'en', 'Unitkit'),
(1, 'fr', 'UNITKIT'),
(2, 'en', 'Backend'),
(2, 'fr', 'Backend'),
(3, 'en', 'Frontend'),
(3, 'fr', 'Frontend');

-- --------------------------------------------------------

--
-- Structure de la table `u_message_i18n`
--

CREATE TABLE IF NOT EXISTS `u_message_i18n` (
  `u_message_id` int(11) unsigned NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '',
  `translation` text CHARACTER SET utf8
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `u_message_i18n`
--

INSERT INTO `u_message_i18n` (`u_message_id`, `i18n_id`, `translation`) VALUES
(11, 'en', 'French'),
(11, 'fr', 'Français'),
(12, 'en', 'English'),
(12, 'fr', 'Anglais'),
(13, 'en', 'German'),
(13, 'fr', 'Allemand'),
(14, 'en', 'Settings'),
(14, 'fr', 'Paramètres'),
(15, 'en', 'Variables'),
(15, 'fr', 'Variables'),
(17, 'en', 'Save'),
(17, 'fr', 'Enregistrer'),
(18, 'en', 'Add'),
(18, 'fr', 'Ajouter'),
(19, 'en', 'Add again'),
(19, 'fr', 'Ajouter à nouveau'),
(20, 'en', 'Close'),
(20, 'fr', 'Fermer'),
(22, 'en', 'Advanced search'),
(22, 'fr', 'Recherche anvançée'),
(23, 'en', 'Informations has been saved'),
(23, 'fr', 'Les informations ont bien été enregistrées'),
(24, 'en', 'Advanced search'),
(24, 'fr', 'Recherche avançée'),
(25, 'en', 'Find'),
(25, 'fr', 'Rechercher'),
(26, 'en', 'Code'),
(26, 'fr', 'Code'),
(27, 'en', 'Category'),
(27, 'fr', 'Catégorie'),
(29, 'en', 'Search'),
(29, 'fr', 'Rechercher'),
(30, 'en', 'Language'),
(30, 'fr', 'Langue'),
(34, 'en', 'Log In'),
(34, 'fr', 'Connexion'),
(36, 'en', 'Check all'),
(36, 'fr', 'Tout cocher'),
(38, 'en', 'Uncheck all'),
(38, 'fr', 'Tout décocher'),
(42, 'en', 'Remove'),
(42, 'fr', 'Supprimer'),
(43, 'en', 'List'),
(43, 'fr', 'Liste'),
(44, 'en', 'Settings'),
(44, 'fr', 'Préférences'),
(45, 'en', 'Translate'),
(45, 'fr', 'Traduction'),
(46, 'en', 'Select'),
(46, 'fr', 'Sélectionner'),
(47, 'en', 'Unfiltered'),
(47, 'fr', 'Non filtré'),
(48, 'en', 'Checked'),
(48, 'fr', 'Coché'),
(49, 'en', 'Unchecked'),
(49, 'fr', 'Décoché'),
(51, 'en', 'Roles'),
(51, 'fr', 'Rôles'),
(54, 'en', 'Firstname'),
(54, 'fr', 'Prénom'),
(55, 'en', '{@=model:name}'),
(55, 'fr', '{@=model:name}'),
(56, 'en', 'Email'),
(56, 'fr', 'Email'),
(57, 'en', 'Password'),
(57, 'fr', 'Mot de passe'),
(61, 'en', 'You must enter a new password'),
(61, 'fr', 'Vous devez saisir un nouveau mot de passe'),
(65, 'en', 'Email already exist'),
(65, 'fr', 'L''adresse email est déjà utilisé'),
(66, 'en', 'New password'),
(66, 'fr', 'Nouveau mot de passe'),
(71, 'en', 'I''m log in'),
(71, 'fr', 'Je me connecte'),
(73, 'en', 'Username'),
(73, 'fr', 'Identifiant'),
(74, 'en', 'Keep me logged in'),
(74, 'fr', 'Garder ma session active'),
(76, 'en', 'You has not confirmed your registration'),
(76, 'fr', 'Votre inscription n''a pas été confirmé'),
(81, 'en', 'Please enter the letters as they are shown in the image above.<br/>Letters are not case-sensitive.'),
(81, 'fr', 'Merci de saisir les lettres affichées dans l''image ci-dessus. Les lettres sont insensible à la casse'),
(96, 'en', 'Update'),
(96, 'fr', 'Modifier'),
(99, 'en', 'Rights'),
(99, 'fr', 'Liste des droits'),
(102, 'en', 'Select an interface'),
(102, 'fr', 'Sélectionner une interface'),
(145, 'en', 'Create'),
(145, 'fr', 'Création'),
(146, 'en', 'Update'),
(146, 'fr', 'Mise à jour'),
(160, 'en', 'Media'),
(160, 'fr', 'Médias'),
(162, 'en', 'Messages'),
(162, 'fr', 'Messages'),
(163, 'en', 'Rights'),
(163, 'fr', 'Droits'),
(164, 'en', 'Languages'),
(164, 'fr', 'Langues'),
(165, 'en', 'Emails'),
(165, 'fr', 'Mails'),
(178, 'en', 'Warning !'),
(178, 'fr', 'Attention !'),
(186, 'en', 'Send'),
(186, 'fr', 'Envoyer'),
(189, 'en', 'Cancel'),
(189, 'fr', 'Annuler'),
(190, 'en', 'Export'),
(190, 'fr', 'Exporter'),
(191, 'en', 'No results'),
(191, 'fr', 'Aucun résultat'),
(192, 'en', 'Advanced search'),
(192, 'fr', 'Recherche avançée'),
(193, 'en', '{@=u_message_group_i18n:name }'),
(193, 'fr', '{@=u_message_group_i18n:name }'),
(194, 'en', 'Users'),
(194, 'fr', 'Utilisateurs'),
(195, 'en', 'Settings'),
(195, 'fr', 'Paramètres'),
(196, 'en', 'Paging'),
(196, 'fr', 'Pagination'),
(197, 'en', 'Mail templates'),
(197, 'fr', 'Modèles de mail'),
(198, 'en', 'Groups of mail templates'),
(198, 'fr', 'Groupes de modèles de mail'),
(199, 'en', 'Sending roles'),
(199, 'fr', 'Rôles d''envoie des mails'),
(209, 'en', 'Groups of variables'),
(209, 'fr', 'Groupes de variables'),
(211, 'en', 'Groups of messages'),
(211, 'fr', 'Groupes de messages'),
(213, 'en', 'Users groups'),
(213, 'fr', 'Groupes d''utilisateurs'),
(214, 'en', 'Assigning roles to groups'),
(214, 'fr', 'Affectation des rôles aux groupes'),
(215, 'en', 'Auto login'),
(215, 'fr', 'Connexions automatiques'),
(217, 'en', 'Roles'),
(217, 'fr', 'Rôles'),
(219, 'en', 'Website language'),
(219, 'fr', 'Langues du site'),
(220, 'en', 'Languages'),
(220, 'fr', 'Langues'),
(227, 'en', 'Default language'),
(227, 'fr', 'Langue par défaut'),
(228, 'en', 'Group of message'),
(228, 'fr', 'Groupe de message'),
(229, 'en', 'Translate'),
(229, 'fr', 'Traduction'),
(230, 'en', 'Log out'),
(230, 'fr', 'Déconnexion'),
(231, 'en', 'Groups'),
(231, 'fr', 'Groupes'),
(232, 'en', 'Subject'),
(232, 'fr', 'Objet'),
(233, 'en', 'Message'),
(233, 'fr', 'Message'),
(234, 'en', 'Group'),
(234, 'fr', 'Groupe'),
(235, 'en', 'Html mode'),
(235, 'fr', 'Mode html'),
(236, 'en', 'Sign in'),
(236, 'fr', 'Identification'),
(237, 'en', 'Update'),
(237, 'fr', 'Modifier'),
(238, 'en', 'Edit'),
(238, 'fr', 'Editer'),
(239, 'en', 'Remove'),
(239, 'fr', 'Supprimer'),
(240, 'en', 'Translate'),
(240, 'fr', 'Traduire'),
(243, 'en', 'Confirm'),
(243, 'fr', 'Confirmer'),
(244, 'en', 'Do you want to remove the selected rows ?'),
(244, 'fr', 'Voulez-vous supprimmer les lignes sélectionnées ?'),
(245, 'en', 'Do you want to remove this item ?'),
(245, 'fr', 'Voulez-vous supprimer cet élément ?'),
(246, 'en', 'Email already exists'),
(246, 'fr', 'Cet email n''est pas disponible'),
(247, 'en', 'Advanced settings'),
(247, 'fr', 'Paramètres avançés'),
(248, 'en', 'Refresh database schema'),
(248, 'fr', 'Actualiser le schéma de la base de données'),
(249, 'en', 'Refresh database schema'),
(249, 'fr', 'Actualisation du schéma de la base de données'),
(250, 'en', 'The database schema has been refreshed'),
(250, 'fr', 'Le schéma de la base de données a bien été actualisé.'),
(251, 'en', 'Profile'),
(251, 'fr', 'Profil'),
(252, 'en', 'My profile'),
(252, 'fr', 'Mon Profil'),
(253, 'en', 'Create at'),
(253, 'fr', 'Date de création'),
(254, 'en', 'Update at'),
(254, 'fr', 'Date de mise à jour'),
(261, 'en', 'Rights interfaces'),
(261, 'fr', 'Droits par interfaces'),
(263, 'en', 'Id'),
(263, 'fr', 'Identifiant'),
(264, 'en', 'SQL request'),
(264, 'fr', 'Requête SQL'),
(265, 'en', 'Request parameters'),
(265, 'fr', 'Paramètres de la requête'),
(266, 'en', 'Group of mail templates'),
(266, 'fr', 'Groupe du modèle de mail'),
(267, 'en', 'Role'),
(267, 'fr', 'Rôle'),
(268, 'en', 'User'),
(268, 'fr', 'Utilisateur'),
(269, 'en', 'Sending roles'),
(269, 'fr', 'Rôles d''envoie des mails'),
(270, 'en', '{@=model:name}'),
(270, 'fr', '{@=model:name}'),
(271, 'en', 'Group'),
(271, 'fr', 'Groupe'),
(272, 'en', 'Value'),
(272, 'fr', 'Valeur'),
(273, 'en', 'Descrition'),
(273, 'fr', 'Description'),
(274, 'en', '{@=u_variable_group_i18n:name}'),
(274, 'fr', '{@=u_variable_group_i18n:name}'),
(277, 'en', 'Assigning roles to groups'),
(277, 'fr', 'Affectation des rôles aux groupes'),
(278, 'en', 'Auto login'),
(278, 'fr', 'Connexions automatiques'),
(279, 'en', 'Session duration'),
(279, 'fr', 'Durée de la session'),
(280, 'en', 'Expired at'),
(280, 'fr', 'Date d''expiration'),
(281, 'en', 'Key 1'),
(281, 'fr', 'Clef 1'),
(282, 'en', 'Key 2'),
(282, 'fr', 'Clef 2'),
(283, 'en', 'Interfaces'),
(283, 'fr', 'Interfaces'),
(285, 'en', 'Roles'),
(285, 'fr', 'Rôles'),
(287, 'en', 'Actions'),
(287, 'fr', 'Actions'),
(288, 'en', '{@alias=model:name}'),
(288, 'fr', '{@alias=model:name}'),
(290, 'en', 'Language'),
(290, 'fr', 'Langue'),
(291, 'en', 'Name'),
(291, 'fr', 'Nom'),
(293, 'en', 'Old password'),
(293, 'fr', 'Ancien mot de passe'),
(294, 'en', 'Password (confirmation)'),
(294, 'fr', 'Mot de passe (confirmation)'),
(295, 'en', 'Welcome to your administration area'),
(295, 'fr', 'Bienvenue sur votre espace d''administration'),
(298, 'en', 'Between'),
(298, 'fr', 'Entre'),
(299, 'en', 'and'),
(299, 'fr', 'et'),
(300, 'en', 'Add'),
(300, 'fr', 'Ajouter'),
(301, 'en', 'Code'),
(301, 'fr', 'Code'),
(302, 'en', 'Cache management'),
(302, 'fr', 'Gestion du cache'),
(303, 'en', 'Users'),
(303, 'fr', 'Utilisateurs'),
(304, 'en', 'Translate messages'),
(304, 'fr', 'Traduire tous les messages'),
(307, 'en', 'Create'),
(307, 'fr', 'Ajouter'),
(311, 'en', 'Update'),
(311, 'fr', 'Modifier'),
(316, 'en', 'group of persons'),
(316, 'fr', 'groupe de personnes'),
(318, 'en', 'Bad login or password'),
(318, 'fr', 'Mauvais identifiant ou mot de passe'),
(320, 'en', '{@=unitkit, u_person:password}'),
(320, 'fr', '{@=unitkit, u_person:password}'),
(321, 'en', 'Your account is not activated'),
(321, 'fr', 'Votre compte utilisateur a été désactivé'),
(322, 'en', 'Email doesn''t exist'),
(322, 'fr', 'L''adresse email n''existe pas'),
(323, 'en', 'An email has been sent to you in order to reset your password'),
(323, 'fr', 'Un email vous a été envoyé afin de réinitialiser votre mot de passe'),
(324, 'en', 'The old password is not valid'),
(324, 'fr', 'L''ancien mot de passe n''est pas valide'),
(326, 'en', 'The password can''t be reset. To renew your request please to follow the link bellow <br /> <br /> {link}'),
(326, 'fr', 'Le mot de passe ne peut pas être réinitialisé. Pour effectuer une nouvelle demande, merci de cliquer sur le lien ci-dessous <br /> {link}'),
(327, 'en', 'Reset password'),
(327, 'fr', 'Réinitialisation du mot de passe'),
(328, 'en', 'Reset your password'),
(328, 'fr', 'Réinitialiser votre mot de passe'),
(329, 'en', 'The password of this account can''t be reset'),
(329, 'fr', 'Le mot de passe de ce compte utilisateur ne peut être réinitialisé'),
(331, 'en', 'Active password reset'),
(331, 'fr', 'Active la réinitialisation du mot de passe'),
(334, 'en', 'Container number'),
(334, 'fr', 'Bloc numéro'),
(335, 'en', 'Cache is updated'),
(335, 'fr', 'Le cache a été mis à jour'),
(336, 'en', 'An error occured. Cache isn''t updated'),
(336, 'fr', 'Le cache n''a pas pu être mis à jour.'),
(337, 'en', 'CMS'),
(337, 'fr', 'CMS'),
(338, 'en', 'Pages'),
(338, 'fr', 'Pages'),
(339, 'en', 'Editorials'),
(339, 'fr', 'Editoriaux'),
(340, 'en', 'Layouts'),
(340, 'fr', 'Modèles de page'),
(341, 'en', 'Groups of editorials'),
(341, 'fr', 'Groupes d''éditoriaux'),
(342, 'en', 'Widgets'),
(342, 'fr', 'Widgets'),
(343, 'en', 'Images'),
(343, 'fr', 'Images'),
(345, 'en', 'Activated'),
(345, 'fr', 'Activé'),
(346, 'en', 'Validated'),
(346, 'fr', 'Validé'),
(347, 'en', 'Cache'),
(347, 'fr', 'Cache'),
(348, 'en', 'Page title'),
(348, 'fr', 'Titre de page'),
(349, 'en', 'HTML title'),
(349, 'fr', 'Titre HTML'),
(350, 'en', 'HTML description'),
(350, 'fr', 'Description HTML'),
(351, 'en', 'HTML keywords'),
(351, 'fr', 'Mots clefs HTML'),
(352, 'en', 'Page containers'),
(352, 'fr', 'Blocs de pages'),
(353, 'en', 'Layout'),
(353, 'fr', 'Modèle de page'),
(354, 'en', 'Max number of containers'),
(354, 'fr', 'Nombre de blocs maximum'),
(355, 'en', 'Layout path'),
(355, 'fr', 'Chemin du modèle'),
(356, 'en', 'Refresh the cache of all pages'),
(356, 'fr', 'Rafrachir le cache des pages'),
(357, 'en', 'Refresh page cache'),
(357, 'fr', 'Rafraichir le cache de la page'),
(359, 'en', 'Cache managment'),
(359, 'fr', 'Gestion du cache'),
(360, 'en', 'Widget path'),
(360, 'fr', 'Chemin du widget'),
(361, 'en', 'Title'),
(361, 'fr', 'Titre'),
(367, 'en', 'Description'),
(367, 'fr', 'Description'),
(368, 'en', 'Layout'),
(368, 'fr', 'Modèle de page'),
(371, 'en', 'Widget name'),
(371, 'fr', 'Nom du widget'),
(372, 'en', 'Image file'),
(372, 'fr', 'Fichier image'),
(373, 'en', 'Image code'),
(373, 'fr', 'Code de l''image'),
(374, 'en', 'Image title'),
(374, 'fr', 'Titre de l''image'),
(377, 'en', 'Operation'),
(377, 'fr', 'Opération'),
(378, 'en', 'Buisness rule'),
(378, 'fr', 'Règle métier'),
(392, 'en', 'Code already exist'),
(392, 'fr', 'Le code de traduction est déjà utilisé'),
(398, 'en', 'Create an user account'),
(398, 'fr', 'Créer un compte utilisateur'),
(399, 'en', 'Update the user account'),
(399, 'fr', 'Modifier le compte utilisateur'),
(401, 'en', 'Translate'),
(401, 'fr', 'Traduire'),
(402, 'en', 'Slug'),
(402, 'fr', 'Slug'),
(403, 'en', 'This slug already exist'),
(403, 'fr', 'Ce slug est déjà utilisé'),
(405, 'en', 'Create a variable'),
(405, 'fr', 'Ajouter une variable'),
(406, 'en', 'Update the variable'),
(406, 'fr', 'Modifier la variable'),
(407, 'en', 'Groups of variables'),
(407, 'fr', 'Groupes de variables'),
(408, 'en', 'Create a group of variable'),
(408, 'fr', 'Ajouter un groupe de variables'),
(409, 'en', 'Update the group of variables'),
(409, 'fr', 'Modifier le groupe de variables'),
(410, 'en', 'Users'),
(410, 'fr', 'Utilisateurs'),
(411, 'en', 'Create an user'),
(411, 'fr', 'Ajouter un utilisateur'),
(412, 'en', 'Update the user informations'),
(412, 'fr', 'Modifier les informations de l''utilisateur'),
(413, 'en', 'Groups of users'),
(413, 'fr', 'Groupes d''utilisateurs'),
(414, 'en', 'Create a group of users'),
(414, 'fr', 'Ajouter un groupe d''utilisateurs'),
(415, 'en', 'Update the group of users'),
(415, 'fr', 'Modifier le groupe d''utilisateurs'),
(416, 'en', 'Create a role'),
(416, 'fr', 'Ajouter un rôle'),
(417, 'en', 'Update the role'),
(417, 'fr', 'Modifier le rôle'),
(418, 'en', 'Auto login'),
(418, 'fr', 'Connexions automatiques'),
(419, 'en', 'Variables'),
(419, 'fr', 'Variables'),
(420, 'en', 'Website languages'),
(420, 'fr', 'Langues du site'),
(422, 'en', 'Add a website language'),
(422, 'fr', 'Ajouter une langue de site web'),
(423, 'en', 'Update the website language'),
(423, 'fr', 'Modifier la langue du site'),
(424, 'en', '{@=u_i18n_i18n:name}'),
(424, 'fr', '{@=u_i18n_i18n:name}'),
(425, 'en', 'Languages'),
(425, 'fr', 'Langues'),
(426, 'en', 'Add a language'),
(426, 'fr', 'Ajouter une langue'),
(427, 'en', 'Update the language'),
(427, 'fr', 'Modifier la langue'),
(428, 'en', 'Messages'),
(428, 'fr', 'Message'),
(429, 'en', 'Create a message'),
(429, 'fr', 'Ajouter un message'),
(430, 'en', 'Update the message'),
(430, 'fr', 'Modifier le message'),
(431, 'en', 'Groups of messages'),
(431, 'fr', 'Groupes de messages'),
(432, 'en', 'Create a group of messages'),
(432, 'fr', 'Ajouter un groupe de messages'),
(433, 'en', 'Update the group of messages'),
(433, 'fr', 'Modifier le groupe de messages'),
(434, 'en', 'Mail templates'),
(434, 'fr', 'Modèles de mail'),
(435, 'en', 'Create a mail template'),
(435, 'fr', 'Ajouter un modèle de mail'),
(436, 'en', 'Update the mail template'),
(436, 'fr', 'Modifier le modèle de mail'),
(437, 'en', 'Sending roles'),
(437, 'fr', 'Rôles d''envoi du mail'),
(438, 'en', 'Create a sending role'),
(438, 'fr', 'Ajouter un rôle d''envoi du mail'),
(439, 'en', 'Group of mail templates'),
(439, 'fr', 'Groupe de modèles de mail'),
(440, 'en', 'Create a group of email templates'),
(440, 'fr', 'Ajouter un groupe de modèles de mail'),
(441, 'en', 'Update the group of mail templates'),
(441, 'fr', 'Modifier le groupe de modèles de mail'),
(442, 'en', 'Pages'),
(442, 'fr', 'Pages'),
(443, 'en', 'Create a page'),
(443, 'fr', 'Ajouter une page'),
(444, 'en', 'Update the page'),
(444, 'fr', 'Modifier la page'),
(445, 'en', 'Layouts'),
(445, 'fr', 'Modèles de page'),
(446, 'en', 'Create a layout'),
(446, 'fr', 'Ajouter un modèle de page'),
(447, 'en', 'Update the layout'),
(447, 'fr', 'Modifier le modèle de page'),
(448, 'en', 'Editorials'),
(448, 'fr', 'Editoriaux'),
(449, 'en', 'Create an editorial'),
(449, 'fr', 'Ajouter un éditorial'),
(450, 'en', 'Update the editorial'),
(450, 'fr', 'Modifier l''éditorial'),
(452, 'en', 'Create a group of editorials'),
(452, 'fr', 'Ajouter un groupe d''éditoriaux'),
(453, 'en', 'Update the group of editorials'),
(453, 'fr', 'Modifier le groupe d''éditoriaux'),
(454, 'en', 'Widgets'),
(454, 'fr', 'Widgets'),
(455, 'en', 'Add a widget'),
(455, 'fr', 'Ajouter un widget'),
(456, 'en', 'Update the widget'),
(456, 'fr', 'Modifier le widget'),
(457, 'en', 'Images'),
(457, 'fr', 'Images'),
(458, 'en', 'Add an image'),
(458, 'fr', 'Ajouter une image'),
(459, 'en', 'Update the image'),
(459, 'fr', 'Modifier l''image'),
(460, 'en', 'Upload'),
(460, 'fr', 'Télécharger'),
(461, 'en', 'Update the sending role'),
(461, 'fr', 'Modifier le rôle d''envoi du mail'),
(462, 'en', 'Maximum size'),
(462, 'fr', 'Taille maximum'),
(463, 'en', 'Update'),
(463, 'fr', 'Modifier'),
(464, 'en', 'Insert image'),
(464, 'fr', 'Insérer l''image'),
(465, 'en', 'Layout view'),
(465, 'fr', 'Vue du modèle'),
(466, 'en', 'Social networks'),
(466, 'fr', 'Réseaux sociaux'),
(467, 'en', 'Update the social network'),
(467, 'fr', 'Modifier le réseau social'),
(468, 'en', 'Name of social network'),
(468, 'fr', 'Nom du réseau social'),
(469, 'en', 'Url of social network'),
(469, 'fr', 'Url du réseau social'),
(470, 'en', 'Social networks'),
(470, 'fr', 'Réseaux sociaux'),
(471, 'en', 'Album'),
(471, 'fr', 'Album'),
(472, 'en', 'Photo path'),
(472, 'fr', 'Adresse de la photo'),
(473, 'en', '{@=u_cms_album_i18n:title}'),
(473, 'fr', '{@=u_cms_album_i18n:title}'),
(474, 'en', 'Photo title'),
(474, 'fr', 'Titre de la photo'),
(475, 'en', 'Back to albums'),
(475, 'fr', 'Retour aux albums'),
(476, 'en', 'Albums'),
(476, 'fr', 'Albums'),
(477, 'en', 'Albums'),
(477, 'fr', 'Albums'),
(478, 'en', 'Add an album'),
(478, 'fr', 'Ajouter un album'),
(479, 'en', 'Update the album'),
(479, 'fr', 'Modifier l''album'),
(480, 'en', 'Photos of album "{name}"'),
(480, 'fr', 'Photos de l''album "{name}"'),
(481, 'en', 'Add a photo in album  "{name}"'),
(481, 'fr', 'Ajouter une photo dans l''album "{name}"'),
(482, 'en', 'Update the photo of album  "{name}"'),
(482, 'fr', 'Modifier la photo de l''album "{name}"'),
(483, 'en', 'Add photos'),
(483, 'fr', 'Ajouter des photos'),
(484, 'en', 'Widget parameters'),
(484, 'fr', 'Paramètres du widget'),
(485, 'en', 'View album photos'),
(485, 'fr', 'Afficher les photos de l''album'),
(486, 'en', 'Insert image (small)'),
(486, 'fr', 'Insérer l''image (petite)'),
(487, 'en', 'Insert image (large)'),
(487, 'fr', 'Insérer l''image (grande)'),
(488, 'en', 'Newsgroup'),
(488, 'fr', 'Groupe d''actualités'),
(489, 'en', 'News title'),
(489, 'fr', 'Titre de la nouvelle'),
(490, 'en', 'News content'),
(490, 'fr', 'Contenu de la nouvelle'),
(491, 'en', '{@=u_cms_news_group_i18n:name}'),
(491, 'fr', '{@=u_cms_news_group_i18n:name}'),
(493, 'en', 'News'),
(493, 'fr', 'Actualités'),
(494, 'en', 'Add news'),
(494, 'fr', 'Ajouter une nouvelle'),
(495, 'en', 'Update the news'),
(495, 'fr', 'Modifier la nouvelle'),
(496, 'en', 'Add newsgroup'),
(496, 'fr', 'Ajouter un groupe d''actualités'),
(497, 'en', 'Update the newsgroup'),
(497, 'fr', 'Modifier le groupe d''actualités'),
(498, 'en', 'Newsgroups'),
(498, 'fr', 'Groupes  d''actualités'),
(499, 'en', 'Groups of editorials'),
(499, 'fr', 'Groupes d''éditoriaux'),
(500, 'en', 'News'),
(500, 'fr', 'Actualités'),
(503, 'en', 'Newsgroups'),
(503, 'fr', 'Groupes d''actualités'),
(504, 'en', 'Menus'),
(504, 'fr', 'Menus'),
(505, 'en', 'Groups of menus'),
(505, 'fr', 'Groupes de menus'),
(506, 'en', 'Menus'),
(506, 'fr', 'Menus'),
(507, 'en', 'Add a menu'),
(507, 'fr', 'Ajouter un menu'),
(508, 'en', 'Update the menu'),
(508, 'fr', 'Modifier le menu'),
(509, 'en', 'Groups of menus'),
(509, 'fr', 'Groupes de menus'),
(510, 'en', 'Group of menus'),
(510, 'fr', 'Groupe de menus'),
(511, 'en', 'Add a group of menus'),
(511, 'fr', 'Ajouter un groupe de menus'),
(512, 'en', 'Update the group of menus'),
(512, 'fr', 'Modifier le groupe de menus'),
(513, 'en', 'Menu name'),
(513, 'fr', 'Nom du menu'),
(514, 'en', 'Menu URL'),
(514, 'fr', 'URL du menu'),
(515, 'en', 'Group of menu'),
(515, 'fr', 'Groupe du menu'),
(516, 'en', 'Refresh urls cache'),
(516, 'fr', 'Rafraichir le cache des urls'),
(517, 'en', '{@=url_manager_refresh_title}'),
(517, 'fr', '{@=url_manager_refresh_title}'),
(518, 'en', 'Urls cache is refreshed'),
(518, 'fr', 'Le cache des urls a été mise à jour'),
(519, 'en', 'First name'),
(519, 'fr', 'Prénom'),
(520, 'en', 'Last name'),
(520, 'fr', 'Nom'),
(521, 'en', 'Email'),
(521, 'fr', 'Email'),
(522, 'en', 'Phone'),
(522, 'fr', 'Téléphone'),
(523, 'en', 'Message'),
(523, 'fr', 'Message'),
(524, 'en', 'Your email has been sent'),
(524, 'fr', 'Votre email a bien été envoyé'),
(525, 'en', '{@=model:activated}'),
(525, 'fr', '{@=model:activated}'),
(526, 'en', 'Spanish'),
(526, 'fr', 'Espagnol'),
(528, 'en', 'Published at'),
(528, 'fr', 'Publié le'),
(529, 'en', 'The mail template doesn''t exists'),
(529, 'fr', 'Le modèle de mail n''existe pas'),
(530, 'en', 'The mail template translation doesn''t exists'),
(530, 'fr', 'La traduction du modèle de mail n''a pas été trouvé');

-- --------------------------------------------------------

--
-- Structure de la table `u_person`
--

CREATE TABLE IF NOT EXISTS `u_person` (
`id` int(10) unsigned NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `first_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `activated` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `validated` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `active_reset` tinyint(1) unsigned NOT NULL,
  `default_language` varchar(16) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Contenu de la table `u_person`
--

INSERT INTO `u_person` (`id`, `email`, `password`, `first_name`, `last_name`, `activated`, `validated`, `active_reset`, `default_language`, `created_at`, `updated_at`) VALUES
(1, 'admin@unitkit.com', '$2a$13$wX7Nnt9jkr2MB9ZaLKtOgu9ZoppWTFl7hwIKV2LayqLwoghhlYiKm', 'Super', 'Admin', 1, 1, 0, 'en', '2012-12-20 12:40:50', '2014-12-04 13:48:32'),
(2, 'noreply@unitkit.com', '', 'Sender', '', 0, 0, 0, 'en', '2013-04-25 10:07:58', '2014-12-04 12:42:46');

-- --------------------------------------------------------

--
-- Structure de la table `u_person_group`
--

CREATE TABLE IF NOT EXISTS `u_person_group` (
  `u_person_id` int(10) unsigned NOT NULL,
  `u_group_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `u_person_group`
--

INSERT INTO `u_person_group` (`u_person_id`, `u_group_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `u_person_token`
--

CREATE TABLE IF NOT EXISTS `u_person_token` (
  `uuid` varchar(64) NOT NULL,
  `u_person_id` int(10) unsigned NOT NULL,
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `action` varchar(64) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `expired_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `u_role`
--

CREATE TABLE IF NOT EXISTS `u_role` (
`id` int(10) unsigned NOT NULL,
  `operation` varchar(64) COLLATE utf8_bin NOT NULL,
  `business_rule` text COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=107 ;

--
-- Contenu de la table `u_role`
--

INSERT INTO `u_role` (`id`, `operation`, `business_rule`, `created_at`, `updated_at`) VALUES
(1, 'consult:*', '', '2014-03-23 14:35:53', '2014-04-09 09:18:52'),
(2, 'create:*', '', '2014-03-23 13:44:27', '2014-11-22 10:44:55'),
(3, 'update:*', '', '2014-03-23 14:38:13', '2014-04-09 09:19:14'),
(4, 'delete:*', '', '2014-03-23 14:38:28', '2014-04-15 04:36:48'),
(6, 'consult:backend', '', '2013-01-09 20:08:33', '2014-04-13 15:56:01'),
(7, 'administrate:backend/right', '', '2012-12-05 16:36:34', '2014-07-08 14:51:12'),
(8, 'update:backend/profile/profile', '', '2014-06-26 18:01:57', '2014-11-22 10:44:35'),
(9, 'create:backend/variable/variable', '', '2014-10-31 16:12:06', '2014-11-22 10:44:19'),
(10, 'update:backend/variable/variable', '', '2014-10-31 16:12:06', '2014-11-22 10:44:15'),
(11, 'consult:backend/variable/variable', '', '2014-10-31 16:12:06', '2014-11-22 10:44:11'),
(12, 'delete:backend/variable/variable', '', '2014-10-31 16:12:06', '2014-11-22 10:44:06'),
(13, 'create:backend/variable/variableGroup', '', '2014-10-31 16:14:51', '2014-11-22 10:43:59'),
(14, 'update:backend/variable/variableGroup', '', '2014-10-31 16:14:51', '2014-11-22 10:43:52'),
(15, 'consult:backend/variable/variableGroup', '', '2014-10-31 16:14:51', '2014-11-22 10:43:47'),
(16, 'delete:backend/variable/variableGroup', '', '2014-10-31 16:14:51', '2014-11-22 10:43:48'),
(17, 'create:backend/right/group', '', '2014-10-31 16:17:48', '2014-11-22 10:43:33'),
(18, 'update:backend/right/group', '', '2014-10-31 16:17:48', '2014-11-22 10:43:29'),
(19, 'consult:backend/right/group', '', '2014-10-31 16:17:48', '2014-11-22 10:43:20'),
(20, 'delete:backend/right/group', '', '2014-10-31 16:17:48', '2014-11-22 10:43:10'),
(21, 'create:backend/right/person', '', '2014-10-31 16:19:41', '2014-11-22 10:43:02'),
(22, 'update:backend/right/person', '', '2014-10-31 16:19:41', '2014-11-22 10:42:58'),
(23, 'consult:backend/right/person', '', '2014-10-31 16:19:41', '2014-11-22 10:42:52'),
(24, 'delete:backend/right/person', '', '2014-10-31 16:19:41', '2014-11-22 10:42:41'),
(25, 'create:backend/right/role', '', '2014-10-31 16:19:52', '2014-11-22 10:42:34'),
(26, 'update:backend/right/role', '', '2014-10-31 16:19:52', '2014-11-22 10:42:28'),
(27, 'consult:backend/right/role', '', '2014-10-31 16:19:52', '2014-11-22 10:42:24'),
(28, 'delete:backend/right/role', '', '2014-10-31 16:19:52', '2014-11-22 10:42:16'),
(29, 'create:backend/message/message', '', '2014-10-31 16:25:47', '2014-11-22 10:41:48'),
(30, 'update:backend/message/message', '', '2014-10-31 16:25:47', '2014-11-22 10:41:45'),
(31, 'consult:backend/message/message', '', '2014-10-31 16:25:47', '2014-11-22 10:41:41'),
(32, 'delete:backend/message/message', '', '2014-10-31 16:25:47', '2014-11-22 10:41:36'),
(33, 'create:backend/message/messageGroup', '', '2014-10-31 16:26:14', '2014-11-22 10:41:30'),
(34, 'update:backend/message/messageGroup', '', '2014-10-31 16:26:14', '2014-11-22 10:41:25'),
(35, 'consult:backend/message/messageGroup', '', '2014-10-31 16:26:14', '2014-11-22 10:41:21'),
(36, 'delete:backend/message/messageGroup', '', '2014-10-31 16:26:14', '2014-11-22 10:41:18'),
(37, 'create:backend/mail/mailSendingRole', '', '2014-10-31 16:35:00', '2014-11-22 10:41:06'),
(38, 'update:backend/mail/mailSendingRole', '', '2014-10-31 16:35:00', '2014-11-22 10:41:01'),
(39, 'consult:backend/mail/mailSendingRole', '', '2014-10-31 16:35:00', '2014-11-22 10:40:57'),
(40, 'delete:backend/mail/mailSendingRole', '', '2014-10-31 16:35:00', '2014-11-22 10:40:52'),
(41, 'create:backend/mail/mailTemplate', '', '2014-10-31 16:49:29', '2014-11-22 10:40:11'),
(42, 'update:backend/mail/mailTemplate', '', '2014-10-31 16:49:29', '2014-11-22 10:40:08'),
(43, 'consult:backend/mail/mailTemplate', '', '2014-10-31 16:49:29', '2014-11-22 10:40:05'),
(44, 'delete:backend/mail/mailTemplate', '', '2014-10-31 16:49:29', '2014-11-22 10:39:58'),
(45, 'create:backend/mail/mailTemplateGroup', '', '2014-10-31 16:57:02', '2014-11-22 10:39:48'),
(46, 'update:backend/mail/mailTemplateGroup', '', '2014-10-31 16:57:02', '2014-11-22 10:39:44'),
(47, 'consult:backend/mail/mailTemplateGroup', '', '2014-10-31 16:57:02', '2014-11-22 10:39:38'),
(48, 'delete:backend/mail/mailTemplateGroup', '', '2014-10-31 16:57:02', '2014-11-22 10:39:40'),
(49, 'create:backend/i18n/i18n', '', '2014-10-31 17:01:51', '2014-11-22 10:39:00'),
(50, 'update:backend/i18n/i18n', '', '2014-10-31 17:01:51', '2014-11-22 10:38:55'),
(51, 'consult:backend/i18n/i18n', '', '2014-10-31 17:01:51', '2014-11-22 10:38:48'),
(52, 'delete:backend/i18n/i18n', '', '2014-10-31 17:01:51', '2014-11-22 10:38:44'),
(53, 'create:backend/i18n/siteI18n', '', '2014-10-31 17:05:40', '2014-11-22 10:38:28'),
(54, 'update:backend/i18n/siteI18n', '', '2014-10-31 17:05:40', '2014-11-22 10:38:20'),
(55, 'consult:backend/i18n/siteI18n', '', '2014-10-31 17:05:40', '2014-11-22 10:38:01'),
(56, 'delete:backend/i18n/siteI18n', '', '2014-10-31 17:05:40', '2014-11-22 10:37:53'),
(59, 'consult:backend/autoLogin/autoLogin', '', '2014-10-31 17:08:52', '2014-11-22 10:37:34'),
(60, 'delete:backend/autoLogin/autoLogin', '', '2014-10-31 17:08:52', '2014-11-22 10:37:26'),
(61, 'update:backend/cache/dbSchema', '', '2014-10-31 17:23:29', '2014-11-22 10:36:44'),
(62, 'create:backend/cms/albumPhoto', '', '2014-10-31 17:29:03', '2014-11-22 10:36:13'),
(63, 'update:backend/cms/albumPhoto', '', '2014-10-31 17:29:03', '2014-11-22 10:36:10'),
(64, 'consult:backend/cms/albumPhoto', '', '2014-10-31 17:29:03', '2014-11-22 10:36:07'),
(65, 'delete:backend/cms/albumPhoto', '', '2014-10-31 17:29:03', '2014-11-22 10:35:58'),
(66, 'create:backend/cms/album', '', '2014-10-31 17:29:03', '2014-11-22 10:35:26'),
(67, 'update:backend/cms/album', '', '2014-10-31 17:29:03', '2014-11-22 10:35:22'),
(68, 'consult:backend/cms/album', '', '2014-10-31 17:29:03', '2014-11-22 10:35:18'),
(69, 'delete:backend/cms/album', '', '2014-10-31 17:29:03', '2014-11-22 10:35:13'),
(70, 'create:backend/cms/image', '', '2014-10-31 17:29:03', '2014-11-22 10:34:09'),
(71, 'update:backend/cms/image', '', '2014-10-31 17:29:03', '2014-11-22 10:33:53'),
(72, 'consult:backend/cms/image', '', '2014-10-31 17:29:03', '2014-11-22 10:33:49'),
(73, 'delete:backend/cms/image', '', '2014-10-31 17:29:03', '2014-11-22 10:33:42'),
(74, 'create:backend/cms/layout', '', '2014-10-31 17:29:03', '2014-11-22 10:35:03'),
(75, 'update:backend/cms/layout', '', '2014-10-31 17:29:03', '2014-11-22 10:33:20'),
(76, 'consult:backend/cms/layout', '', '2014-10-31 17:29:03', '2014-11-22 10:33:25'),
(77, 'delete:backend/cms/layout', '', '2014-10-31 17:29:03', '2014-11-22 10:33:27'),
(78, 'create:backend/cms/menuGroup', '', '2014-10-31 17:29:03', '2014-11-22 10:34:57'),
(79, 'update:backend/cms/menuGroup', '', '2014-10-31 17:29:03', '2014-11-22 10:32:18'),
(80, 'consult:backend/cms/menuGroup', '', '2014-10-31 17:29:03', '2014-11-22 10:32:12'),
(81, 'delete:backend/cms/menuGroup', '', '2014-10-31 17:29:03', '2014-11-22 10:32:14'),
(82, 'create:backend/cms/menu', '', '2014-10-31 17:29:03', '2014-11-22 10:34:51'),
(83, 'update:backend/cms/menu', '', '2014-10-31 17:29:03', '2014-11-22 10:31:50'),
(84, 'consult:backend/cms/menu', '', '2014-10-31 17:29:03', '2014-11-22 10:31:40'),
(85, 'delete:backend/cms/menu', '', '2014-10-31 17:29:03', '2014-11-22 10:31:38'),
(86, 'create:backend/cms/newsGroup', '', '2014-10-31 17:29:38', '2014-11-22 10:34:46'),
(87, 'update:backend/cms/newsGroup', '', '2014-10-31 17:29:38', '2014-11-22 10:31:15'),
(88, 'consult:backend/cms/newsGroup', '', '2014-10-31 17:29:38', '2014-11-22 10:31:11'),
(89, 'delete:backend/cms/newsGroup', '', '2014-10-31 17:29:38', '2014-11-22 10:31:05'),
(90, 'create:backend/cms/news', '', '2014-10-31 17:29:38', '2014-11-22 10:34:41'),
(91, 'update:backend/cms/news', '', '2014-10-31 17:29:38', '2014-11-22 10:30:46'),
(92, 'consult:backend/cms/news', '', '2014-10-31 17:29:38', '2014-11-22 10:30:42'),
(93, 'delete:backend/cms/news', '', '2014-10-31 17:29:38', '2014-11-22 10:30:37'),
(94, 'create:backend/cms/pageContainer', '', '2014-10-31 17:29:38', '2014-11-22 10:34:36'),
(95, 'update:backend/cms/pageContainer', '', '2014-10-31 17:29:38', '2014-11-22 10:30:27'),
(96, 'consult:backend/cms/pageContainer', '', '2014-10-31 17:29:38', '2014-11-22 10:30:12'),
(97, 'delete:backend/cms/pageContainer', '', '2014-10-31 17:29:38', '2014-11-22 10:29:33'),
(98, 'create:backend/cms/social', '', '2014-10-31 17:29:38', '2014-11-22 10:34:29'),
(99, 'update:backend/cms/social', '', '2014-10-31 17:29:38', '2014-11-22 10:29:06'),
(100, 'consult:backend/cms/social', '', '2014-10-31 17:29:38', '2014-11-22 10:29:04'),
(101, 'delete:backend/cms/social', '', '2014-10-31 17:29:38', '2014-11-22 10:29:03'),
(102, 'create:backend/cms/widget', '', '2014-10-31 17:29:38', '2014-11-22 10:34:23'),
(103, 'update:backend/cms/widget', '', '2014-10-31 17:29:38', '2014-11-22 10:27:57'),
(104, 'consult:backend/cms/widget', '', '2014-10-31 17:29:38', '2014-11-22 10:27:49'),
(105, 'delete:backend/cms/widget', '', '2014-10-31 17:29:38', '2014-10-31 17:29:38'),
(106, 'update:backend/cache/urlManager/flush', '', '2014-11-30 13:45:04', '2014-11-30 13:45:04');

-- --------------------------------------------------------

--
-- Structure de la table `u_role_i18n`
--

CREATE TABLE IF NOT EXISTS `u_role_i18n` (
  `u_role_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `u_role_i18n`
--

INSERT INTO `u_role_i18n` (`u_role_id`, `i18n_id`, `name`) VALUES
(1, 'en', 'Consult'),
(1, 'fr', 'Consulter'),
(2, 'en', 'Create'),
(2, 'fr', 'Ajouter'),
(3, 'en', 'Update'),
(3, 'fr', 'Modifier'),
(4, 'en', 'Delete'),
(4, 'fr', 'Supprimer'),
(6, 'en', 'Navigate in back-end'),
(6, 'fr', 'Naviguer en back-office'),
(7, 'en', 'Administrate rights'),
(7, 'fr', 'Administrer les droits'),
(8, 'en', 'Update profil informations'),
(8, 'fr', 'Modifier profil'),
(9, 'en', 'Create variables'),
(9, 'fr', 'Ajouter variables'),
(10, 'en', 'Update variables'),
(10, 'fr', 'Modifier variables'),
(11, 'en', 'Consult variables'),
(11, 'fr', 'Afficher variables'),
(12, 'en', 'Delete variables'),
(12, 'fr', 'Supprimer variables'),
(13, 'en', 'Create variable groups'),
(13, 'fr', 'Ajouter groupes de variables'),
(14, 'en', 'Update variable groups'),
(14, 'fr', 'Modifier groupes de variables'),
(15, 'en', 'Consult variable groups'),
(15, 'fr', 'Afficher groupes de variables'),
(16, 'en', 'Delete variable groups'),
(16, 'fr', 'Supprimer groupes de variables'),
(17, 'en', 'Create groups'),
(17, 'fr', 'Ajouter groupes d''utilisateurs'),
(18, 'en', 'Update groups'),
(18, 'fr', 'Modifier groupes d''utilisateurs'),
(19, 'en', 'Consult groups'),
(19, 'fr', 'Afficher groupes d''utilisateurs'),
(20, 'en', 'Delete groups'),
(20, 'fr', 'Supprimer groupes d''utilisateurs'),
(21, 'en', 'Create persons'),
(21, 'fr', 'Ajouter utilisateurs'),
(22, 'en', 'Update persons'),
(22, 'fr', 'Modifier utilisateurs'),
(23, 'en', 'Consult persons'),
(23, 'fr', 'Afficher utilisateurs'),
(24, 'en', 'Delete persons'),
(24, 'fr', 'Supprimer utilisateurs'),
(25, 'en', 'Create roles'),
(25, 'fr', 'Ajoutet rôles'),
(26, 'en', 'Update roles'),
(26, 'fr', 'Modifier rôles'),
(27, 'en', 'Consult roles'),
(27, 'fr', 'Afficher rôles'),
(28, 'en', 'Delete roles'),
(28, 'fr', 'Supprimer rôles'),
(29, 'en', 'Create messages'),
(29, 'fr', 'Ajouter messages'),
(30, 'en', 'Update messages'),
(30, 'fr', 'Modifier messages'),
(31, 'en', 'Consult messages'),
(31, 'fr', 'Afficher messages'),
(32, 'en', 'Delete messages'),
(32, 'fr', 'Supprimer messages'),
(33, 'en', 'Create message groups'),
(33, 'fr', 'Ajouter groupes de messages'),
(34, 'en', 'Update message groups'),
(34, 'fr', 'Modifier groupes de messages'),
(35, 'en', 'Consult message groups'),
(35, 'fr', 'Afficher groupes de messages'),
(36, 'en', 'Delete message groups'),
(36, 'fr', 'Supprimer groupes de messages'),
(37, 'en', 'Create mail sending roles'),
(37, 'fr', 'Ajouter rôles d''envoie de mails'),
(38, 'en', 'Update mail sending roles'),
(38, 'fr', 'Modifier rôles d''envoie de mails'),
(39, 'en', 'Consult mail sending roles'),
(39, 'fr', 'Afficher rôles d''envoie de mails'),
(40, 'en', 'Delete mail sending roles'),
(40, 'fr', 'Supprimer rôles d''envoie de mails'),
(41, 'en', 'Create mail templates'),
(41, 'fr', 'Ajouter modèles de mails'),
(42, 'en', 'Update mail templates'),
(42, 'fr', 'Modifier modèles de mails'),
(43, 'en', 'Consult mail templates'),
(43, 'fr', 'Afficher modèles de mails'),
(44, 'en', 'Delete mail templates'),
(44, 'fr', 'Supprimer modèles de mails'),
(45, 'en', 'Create mail template groups'),
(45, 'fr', 'Ajouter groupes de modèles de mails'),
(46, 'en', 'Update mail template groups'),
(46, 'fr', 'Modifier groupes de modèles de mails'),
(47, 'en', 'Consult mail template groups'),
(47, 'fr', 'Afficher groupes de modèles de mails'),
(48, 'en', 'Delete mail template groups'),
(48, 'fr', 'Supprimer groupes de modèles de mails'),
(49, 'en', 'Create i18ns'),
(49, 'fr', 'Ajouter langues'),
(50, 'en', 'Update i18ns'),
(50, 'fr', 'Modifier langues'),
(51, 'en', 'Consult i18ns'),
(51, 'fr', 'Afficher langues'),
(52, 'en', 'Delete i18ns'),
(52, 'fr', 'Supprimer langues'),
(53, 'en', 'Create site i18ns'),
(53, 'fr', 'Ajouter langues du site'),
(54, 'en', 'Update site i18ns'),
(54, 'fr', 'Modifier langues du site'),
(55, 'en', 'Consult site i18ns'),
(55, 'fr', 'Afficher langues du site'),
(56, 'en', 'Delete site i18ns'),
(56, 'fr', 'Supprimer langues du site'),
(59, 'en', 'Consult auto logins'),
(59, 'fr', 'Afficher connexions automatiques'),
(60, 'en', 'Delete auto logins'),
(60, 'fr', 'Supprimer connexions automatiques'),
(61, 'en', 'Update cache database'),
(61, 'fr', 'Mettre à jour le cache de la base de données'),
(62, 'en', 'Create album photos'),
(62, 'fr', 'Ajouter photos des albums'),
(63, 'en', 'Update album photos'),
(63, 'fr', 'Modifier photos des albums'),
(64, 'en', 'Consult album photos'),
(64, 'fr', 'Afficher photos des albums'),
(65, 'en', 'Delete album photos'),
(65, 'fr', 'Supprimer photos des albums'),
(66, 'en', 'Create albums'),
(66, 'fr', 'Ajouter album'),
(67, 'en', 'Update albums'),
(67, 'fr', 'Modifier albums'),
(68, 'en', 'Consult albums'),
(68, 'fr', 'Afficher albums'),
(69, 'en', 'Delete albums'),
(69, 'fr', 'Supprimer albums'),
(70, 'en', 'Create images'),
(70, 'fr', 'Ajouter images'),
(71, 'en', 'Update images'),
(71, 'fr', 'Modifier images'),
(72, 'en', 'Consult images'),
(72, 'fr', 'Afficher images'),
(73, 'en', 'Delete images'),
(73, 'fr', 'Supprimer images'),
(74, 'en', 'Create layouts'),
(74, 'fr', 'Ajouter mises en pages'),
(75, 'en', 'Update layouts'),
(75, 'fr', 'Modifier mises en pages'),
(76, 'en', 'Consult layouts'),
(76, 'fr', 'Afficher mises en pages'),
(77, 'en', 'Delete layouts'),
(77, 'fr', 'Supprimer mises en pages'),
(78, 'en', 'Create menu groups'),
(78, 'fr', 'Ajouter groupes de menus'),
(79, 'en', 'Update menu groups'),
(79, 'fr', 'Modifier groupes de menus'),
(80, 'en', 'Consult menu groups'),
(80, 'fr', 'Afficher groupes de menus'),
(81, 'en', 'Delete menu groups'),
(81, 'fr', 'Supprimer groupes de menus'),
(82, 'en', 'Create menus'),
(82, 'fr', 'Ajouter menus'),
(83, 'en', 'Update menus'),
(83, 'fr', 'Modifier menus'),
(84, 'en', 'Consult menus'),
(84, 'fr', 'Afficher menus'),
(85, 'en', 'Delete menus'),
(85, 'fr', 'Supprimer menus'),
(86, 'en', 'Create news groups'),
(86, 'fr', 'Ajouter groupes de news'),
(87, 'en', 'Update news groups'),
(87, 'fr', 'Modifier groupes de news'),
(88, 'en', 'Consult news groups'),
(88, 'fr', 'Afficher groupes de news'),
(89, 'en', 'Delete news groups'),
(89, 'fr', 'Supprimer groupes de news'),
(90, 'en', 'Create newss'),
(90, 'fr', 'Ajouter news'),
(91, 'en', 'Update newss'),
(91, 'fr', 'Modifier news'),
(92, 'en', 'Consult newss'),
(92, 'fr', 'Afficher news'),
(93, 'en', 'Delete newss'),
(93, 'fr', 'Supprimer news'),
(94, 'en', 'Create containers'),
(94, 'fr', 'Ajouter pages'),
(95, 'en', 'Update pages'),
(95, 'fr', 'Modifier pages'),
(96, 'en', 'Consult pages'),
(96, 'fr', 'Afficher pages'),
(97, 'en', 'Delete pages'),
(97, 'fr', 'Supprimer pages'),
(98, 'en', 'Create socials'),
(98, 'fr', 'Ajouter réseaux sociaux'),
(99, 'en', 'Update socials'),
(99, 'fr', 'Modifier réseaux sociaux'),
(100, 'en', 'Consult socials'),
(100, 'fr', 'Afficher réseaux sociaux'),
(101, 'en', 'Delete socials'),
(101, 'fr', 'Supprimer réseaux sociaux'),
(102, 'en', 'Create widgets'),
(102, 'fr', 'Ajouter widgets'),
(103, 'en', 'Update widgets'),
(103, 'fr', 'Modifier widgets'),
(104, 'en', 'Consult widgets'),
(104, 'fr', 'Afficher widgets'),
(105, 'en', 'Delete widgets'),
(105, 'fr', 'Supprimer widgets'),
(106, 'en', 'Update cache url'),
(106, 'fr', 'Mettre à jour le cache des urls');

-- --------------------------------------------------------

--
-- Structure de la table `u_site_i18n`
--

CREATE TABLE IF NOT EXISTS `u_site_i18n` (
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) unsigned NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `u_site_i18n`
--

INSERT INTO `u_site_i18n` (`i18n_id`, `activated`) VALUES
('en', 1),
('fr', 0);

-- --------------------------------------------------------

--
-- Structure de la table `u_variable`
--

CREATE TABLE IF NOT EXISTS `u_variable` (
`id` int(10) unsigned NOT NULL,
  `u_variable_group_id` int(10) unsigned NOT NULL,
  `param` varchar(50) COLLATE utf8_bin NOT NULL,
  `val` text COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=28 ;

--
-- Contenu de la table `u_variable`
--

INSERT INTO `u_variable` (`id`, `u_variable_group_id`, `param`, `val`, `created_at`, `updated_at`) VALUES
(1, 2, 'u_role_id:navigate', 'consult:backend', '2012-12-20 17:38:56', '2014-06-23 13:16:53'),
(2, 2, 'u_auto_login_duration', '7', '2012-12-21 09:34:02', '2014-06-23 13:56:20'),
(3, 1, 'u_send_role_id:from', '1', '2013-01-29 17:35:43', '2014-06-23 13:16:27'),
(4, 1, 'u_send_role_id:to', '2', '2013-01-29 17:36:12', '2014-06-23 13:16:23'),
(5, 1, 'u_send_role_id:cc', '3', '2013-01-29 17:36:33', '2014-06-23 13:16:19'),
(6, 1, 'u_send_role_id:bcc', '4', '2013-01-29 17:36:51', '2014-06-23 13:16:14'),
(11, 1, 'u_message_group_id:unitkit', '1', '2014-06-22 16:01:48', '2014-07-30 19:23:11'),
(12, 1, 'u_message_group_id:backend', '2', '2014-06-22 16:02:12', '2014-08-02 09:30:49'),
(13, 2, 'mail_template_id:resetPassword', '2', '2014-06-23 12:30:47', '2014-06-23 13:32:38'),
(14, 2, 'u_person_token_action:resetPassword', 'backend:resetPassword', '2014-06-23 13:27:09', '2014-06-23 13:32:33'),
(15, 2, 'u_person_token_expired_at:resetPassword', '12', '2014-06-23 13:34:14', '2014-07-02 14:02:34'),
(18, 1, 'u_message_group_id:frontend', '3', '2014-08-02 09:29:56', '2014-08-02 09:30:37'),
(19, 3, 'website_name', 'Website', '2014-08-05 07:37:18', '2014-11-22 11:36:44'),
(20, 3, 'u_cms_menu_group_id:main', '1', '2014-08-05 09:23:31', '2014-11-24 18:34:21'),
(21, 3, 'u_cms_page_id:contact', '39', '2014-11-24 17:32:18', '2014-11-24 17:33:21'),
(22, 3, 'mail_template_id:contact', ' 3', '2014-11-25 15:46:17', '2014-11-29 11:19:49'),
(23, 3, 'u_cms_page_id:news', '41', '2014-11-29 11:19:14', '2014-11-29 11:19:57'),
(24, 3, 'u_cms_news_group_id:main', '15', '2014-11-29 12:47:04', '2014-11-29 12:47:04'),
(25, 1, 'mail_template_sql_alias_mailto', 'b_mt_email_to', '2014-12-05 12:48:51', '2014-12-05 12:50:59'),
(26, 1, 'mail_template_sql_alias_mailfrom', 'b_mt_email_from', '2014-12-05 12:49:22', '2014-12-05 12:50:58'),
(27, 1, 'mail_template_sql_alias_sender', 'b_mt_email_sender', '2014-12-05 12:49:59', '2014-12-05 12:51:31');

-- --------------------------------------------------------

--
-- Structure de la table `u_variable_group`
--

CREATE TABLE IF NOT EXISTS `u_variable_group` (
`id` int(10) unsigned NOT NULL,
  `code` varchar(50) COLLATE utf8_bin NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Contenu de la table `u_variable_group`
--

INSERT INTO `u_variable_group` (`id`, `code`, `created_at`, `updated_at`) VALUES
(1, 'unitkit', '2012-12-28 15:46:26', '2014-07-30 19:24:31'),
(2, 'backend', '2012-12-20 17:28:37', '2014-11-01 10:03:50'),
(3, 'frontend', '2014-08-05 07:36:32', '2014-08-05 07:36:32');

-- --------------------------------------------------------

--
-- Structure de la table `u_variable_group_i18n`
--

CREATE TABLE IF NOT EXISTS `u_variable_group_i18n` (
  `u_variable_group_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `u_variable_group_i18n`
--

INSERT INTO `u_variable_group_i18n` (`u_variable_group_id`, `i18n_id`, `name`) VALUES
(1, 'en', 'Unitkit'),
(1, 'fr', 'Unitkit'),
(2, 'en', 'Backend'),
(2, 'fr', 'Backend'),
(3, 'en', 'Frontend'),
(3, 'fr', 'Frontend');

-- --------------------------------------------------------

--
-- Structure de la table `u_variable_i18n`
--

CREATE TABLE IF NOT EXISTS `u_variable_i18n` (
  `u_variable_id` int(10) unsigned NOT NULL,
  `i18n_id` varchar(16) COLLATE utf8_bin NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `u_variable_i18n`
--

INSERT INTO `u_variable_i18n` (`u_variable_id`, `i18n_id`, `description`) VALUES
(1, 'en', 'Role ID used to navigate in the Backend'),
(1, 'fr', 'Identifiant du rôle permettant de naviguer dans le Backend'),
(2, 'en', 'Time during which an autologin session keep alive (in days)'),
(2, 'fr', 'Nombre de jours pendant lesquels une session auto-login reste active'),
(3, 'en', 'ID of FROM sending role'),
(3, 'fr', 'Identifiant du role d''envoie d''email "FROM"'),
(4, 'en', 'ID of TO sending role'),
(4, 'fr', 'Identifiant du role d''envoie d''email "TO"'),
(5, 'en', 'ID of CC sending role'),
(5, 'fr', 'Identifiant du role d''envoie d''email "CC"'),
(6, 'en', 'ID of BCC sending role'),
(6, 'fr', 'Identifiant du role d''envoie d''email "BCC"'),
(11, 'en', 'ID of messages group used in an UNITKIT application'),
(11, 'fr', 'Identifiant du groupe de message utilisé dans une application UNITKIT'),
(12, 'en', 'ID of messages group used from backend application'),
(12, 'fr', 'Identifiant du groupe de message utilisé dans le backend'),
(13, 'en', 'ID of mail template used in the password reset module'),
(13, 'fr', 'Identifiant du modèle de mail utilisé dans le module de réinitialisation du mot de passe'),
(14, 'en', 'Token action used in the password reset module'),
(14, 'fr', 'Action du jeton utilisé dans le module de réinitialisation du mot de passe'),
(15, 'en', 'Time during which the reset password action keep alive (in hours)'),
(15, 'fr', 'Temps pendant lequel l''action de réinitialisation du mot de passe reste active (en heure)'),
(18, 'en', 'ID of messages group used from frontend application'),
(18, 'fr', 'Identifiant du groupe de message utilisé dans sur le frontend'),
(19, 'en', 'Name of website'),
(19, 'fr', 'Nom du site web'),
(20, 'en', 'Group ID of main menu'),
(20, 'fr', 'Identifiant du groupe du menu principal'),
(21, 'en', 'ID of cms page contact'),
(21, 'fr', 'Identifiant de la page cms de contact'),
(22, 'en', 'ID of contact mail template'),
(22, 'fr', 'Identifiant du modèle de mail utilisé dans le module de contact'),
(23, 'en', 'ID of cms page news'),
(23, 'fr', 'Identifiant de la page news'),
(24, 'en', 'ID of main news group'),
(24, 'fr', 'Identifiant du groupe de news principale'),
(25, 'en', 'Sql alias in mail template for mail recipient'),
(25, 'fr', 'Alias SQL utilisé dans les mail template pour désigner le receveur'),
(26, 'en', 'Sql alias in mail template for mail sender'),
(26, 'fr', 'Alias SQL utilisé dans les mail template pour désigner l''envoyeur'),
(27, 'en', 'Sql alias in mail template for sender name'),
(27, 'fr', 'Alias SQL utilisé dans les mail template pour désigner le nom de l''envoyeur');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `u_auto_login`
--
ALTER TABLE `u_auto_login`
 ADD PRIMARY KEY (`uuid`), ADD KEY `u_person_id` (`u_person_id`);

--
-- Index pour la table `u_cms_album`
--
ALTER TABLE `u_cms_album`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `u_cms_album_i18n`
--
ALTER TABLE `u_cms_album_i18n`
 ADD PRIMARY KEY (`u_cms_album_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_cms_album_photo`
--
ALTER TABLE `u_cms_album_photo`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `file_path` (`file_path`), ADD KEY `u_cms_album_id` (`u_cms_album_id`);

--
-- Index pour la table `u_cms_album_photo_i18n`
--
ALTER TABLE `u_cms_album_photo_i18n`
 ADD PRIMARY KEY (`u_cms_album_photo_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_cms_image`
--
ALTER TABLE `u_cms_image`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `file_path` (`file_path`);

--
-- Index pour la table `u_cms_image_i18n`
--
ALTER TABLE `u_cms_image_i18n`
 ADD PRIMARY KEY (`u_cms_image_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_cms_layout`
--
ALTER TABLE `u_cms_layout`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `u_cms_layout_i18n`
--
ALTER TABLE `u_cms_layout_i18n`
 ADD PRIMARY KEY (`u_cms_layout_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_cms_menu`
--
ALTER TABLE `u_cms_menu`
 ADD PRIMARY KEY (`id`), ADD KEY `u_cms_edito_group_id` (`u_cms_menu_group_id`), ADD KEY `rank` (`rank`);

--
-- Index pour la table `u_cms_menu_group`
--
ALTER TABLE `u_cms_menu_group`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `u_cms_menu_group_i18n`
--
ALTER TABLE `u_cms_menu_group_i18n`
 ADD PRIMARY KEY (`u_cms_menu_group_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_cms_menu_i18n`
--
ALTER TABLE `u_cms_menu_i18n`
 ADD PRIMARY KEY (`u_cms_menu_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_cms_news`
--
ALTER TABLE `u_cms_news`
 ADD PRIMARY KEY (`id`), ADD KEY `u_cms_news_group_id` (`u_cms_news_group_id`);

--
-- Index pour la table `u_cms_news_group`
--
ALTER TABLE `u_cms_news_group`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `u_cms_news_group_i18n`
--
ALTER TABLE `u_cms_news_group_i18n`
 ADD PRIMARY KEY (`u_cms_news_group_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_cms_news_i18n`
--
ALTER TABLE `u_cms_news_i18n`
 ADD PRIMARY KEY (`u_cms_news_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_cms_page`
--
ALTER TABLE `u_cms_page`
 ADD PRIMARY KEY (`id`), ADD KEY `u_cms_layout_id` (`u_cms_layout_id`);

--
-- Index pour la table `u_cms_page_content`
--
ALTER TABLE `u_cms_page_content`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `u_cms_page_id_2` (`u_cms_page_id`,`index`), ADD KEY `u_cms_page_id` (`u_cms_page_id`);

--
-- Index pour la table `u_cms_page_content_i18n`
--
ALTER TABLE `u_cms_page_content_i18n`
 ADD PRIMARY KEY (`u_cms_page_content_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_cms_page_i18n`
--
ALTER TABLE `u_cms_page_i18n`
 ADD PRIMARY KEY (`u_cms_page_id`,`i18n_id`), ADD UNIQUE KEY `i18n_id_2` (`i18n_id`,`slug`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_cms_social`
--
ALTER TABLE `u_cms_social`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `u_cms_social_i18n`
--
ALTER TABLE `u_cms_social_i18n`
 ADD PRIMARY KEY (`u_cms_social_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_cms_widget`
--
ALTER TABLE `u_cms_widget`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `u_cms_widget_i18n`
--
ALTER TABLE `u_cms_widget_i18n`
 ADD PRIMARY KEY (`u_cms_widget_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_group`
--
ALTER TABLE `u_group`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `u_group_i18n`
--
ALTER TABLE `u_group_i18n`
 ADD PRIMARY KEY (`u_group_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_group_role`
--
ALTER TABLE `u_group_role`
 ADD PRIMARY KEY (`u_group_id`,`u_role_id`), ADD KEY `u_role_id` (`u_role_id`);

--
-- Index pour la table `u_i18n`
--
ALTER TABLE `u_i18n`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `u_i18n_i18n`
--
ALTER TABLE `u_i18n_i18n`
 ADD PRIMARY KEY (`u_i18n_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_interface_setting`
--
ALTER TABLE `u_interface_setting`
 ADD PRIMARY KEY (`interface_id`,`u_person_id`), ADD KEY `u_person_id` (`u_person_id`);

--
-- Index pour la table `u_mail_sending_role`
--
ALTER TABLE `u_mail_sending_role`
 ADD PRIMARY KEY (`u_person_id`,`u_mail_template_id`,`u_mail_send_role_id`), ADD KEY `u_mail_template_id` (`u_mail_template_id`), ADD KEY `u_mail_send_role_id` (`u_mail_send_role_id`);

--
-- Index pour la table `u_mail_send_role`
--
ALTER TABLE `u_mail_send_role`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `u_mail_send_role_i18n`
--
ALTER TABLE `u_mail_send_role_i18n`
 ADD PRIMARY KEY (`u_mail_send_role_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_mail_template`
--
ALTER TABLE `u_mail_template`
 ADD PRIMARY KEY (`id`), ADD KEY `u_mail_template_type_id` (`u_mail_template_group_id`);

--
-- Index pour la table `u_mail_template_group`
--
ALTER TABLE `u_mail_template_group`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `u_mail_template_group_i18n`
--
ALTER TABLE `u_mail_template_group_i18n`
 ADD PRIMARY KEY (`u_mail_template_group_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_mail_template_i18n`
--
ALTER TABLE `u_mail_template_i18n`
 ADD PRIMARY KEY (`u_mail_template_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_message`
--
ALTER TABLE `u_message`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `u_message_category_id` (`u_message_group_id`,`source`), ADD KEY `u_category_id` (`u_message_group_id`);

--
-- Index pour la table `u_message_group`
--
ALTER TABLE `u_message_group`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `u_message_group_i18n`
--
ALTER TABLE `u_message_group_i18n`
 ADD PRIMARY KEY (`u_message_group_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_message_i18n`
--
ALTER TABLE `u_message_i18n`
 ADD PRIMARY KEY (`u_message_id`,`i18n_id`), ADD KEY `language` (`i18n_id`);

--
-- Index pour la table `u_person`
--
ALTER TABLE `u_person`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`), ADD KEY `default_language` (`default_language`);

--
-- Index pour la table `u_person_group`
--
ALTER TABLE `u_person_group`
 ADD PRIMARY KEY (`u_person_id`,`u_group_id`), ADD KEY `u_group_id` (`u_group_id`);

--
-- Index pour la table `u_person_token`
--
ALTER TABLE `u_person_token`
 ADD PRIMARY KEY (`uuid`), ADD UNIQUE KEY `uuid` (`password`,`action`), ADD KEY `u_person_id` (`u_person_id`), ADD KEY `u_person_id_2` (`u_person_id`,`action`);

--
-- Index pour la table `u_role`
--
ALTER TABLE `u_role`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `operation_2` (`operation`), ADD KEY `operation` (`operation`);

--
-- Index pour la table `u_role_i18n`
--
ALTER TABLE `u_role_i18n`
 ADD PRIMARY KEY (`u_role_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_site_i18n`
--
ALTER TABLE `u_site_i18n`
 ADD PRIMARY KEY (`i18n_id`);

--
-- Index pour la table `u_variable`
--
ALTER TABLE `u_variable`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `u_unique_param` (`u_variable_group_id`,`param`);

--
-- Index pour la table `u_variable_group`
--
ALTER TABLE `u_variable_group`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `code` (`code`);

--
-- Index pour la table `u_variable_group_i18n`
--
ALTER TABLE `u_variable_group_i18n`
 ADD PRIMARY KEY (`u_variable_group_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- Index pour la table `u_variable_i18n`
--
ALTER TABLE `u_variable_i18n`
 ADD PRIMARY KEY (`u_variable_id`,`i18n_id`), ADD KEY `i18n_id` (`i18n_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `u_cms_album`
--
ALTER TABLE `u_cms_album`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT pour la table `u_cms_album_photo`
--
ALTER TABLE `u_cms_album_photo`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=55;
--
-- AUTO_INCREMENT pour la table `u_cms_image`
--
ALTER TABLE `u_cms_image`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `u_cms_layout`
--
ALTER TABLE `u_cms_layout`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `u_cms_menu`
--
ALTER TABLE `u_cms_menu`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `u_cms_menu_group`
--
ALTER TABLE `u_cms_menu_group`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `u_cms_news`
--
ALTER TABLE `u_cms_news`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `u_cms_news_group`
--
ALTER TABLE `u_cms_news_group`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `u_cms_page`
--
ALTER TABLE `u_cms_page`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT pour la table `u_cms_page_content`
--
ALTER TABLE `u_cms_page_content`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT pour la table `u_cms_social`
--
ALTER TABLE `u_cms_social`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `u_cms_widget`
--
ALTER TABLE `u_cms_widget`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `u_group`
--
ALTER TABLE `u_group`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `u_group_i18n`
--
ALTER TABLE `u_group_i18n`
MODIFY `u_group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `u_mail_send_role`
--
ALTER TABLE `u_mail_send_role`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `u_mail_template`
--
ALTER TABLE `u_mail_template`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `u_mail_template_group`
--
ALTER TABLE `u_mail_template_group`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `u_message`
--
ALTER TABLE `u_message`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=532;
--
-- AUTO_INCREMENT pour la table `u_message_group`
--
ALTER TABLE `u_message_group`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `u_person`
--
ALTER TABLE `u_person`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `u_role`
--
ALTER TABLE `u_role`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=107;
--
-- AUTO_INCREMENT pour la table `u_variable`
--
ALTER TABLE `u_variable`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT pour la table `u_variable_group`
--
ALTER TABLE `u_variable_group`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `u_auto_login`
--
ALTER TABLE `u_auto_login`
ADD CONSTRAINT `u_auto_login_ibfk_2` FOREIGN KEY (`u_person_id`) REFERENCES `u_person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_album_i18n`
--
ALTER TABLE `u_cms_album_i18n`
ADD CONSTRAINT `u_cms_album_i18n_ibfk_1` FOREIGN KEY (`u_cms_album_id`) REFERENCES `u_cms_album` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_cms_album_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_album_photo`
--
ALTER TABLE `u_cms_album_photo`
ADD CONSTRAINT `u_cms_album_photo_ibfk_1` FOREIGN KEY (`u_cms_album_id`) REFERENCES `u_cms_album` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_album_photo_i18n`
--
ALTER TABLE `u_cms_album_photo_i18n`
ADD CONSTRAINT `u_cms_album_photo_i18n_ibfk_1` FOREIGN KEY (`u_cms_album_photo_id`) REFERENCES `u_cms_album_photo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_cms_album_photo_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_image_i18n`
--
ALTER TABLE `u_cms_image_i18n`
ADD CONSTRAINT `u_cms_image_i18n_ibfk_1` FOREIGN KEY (`u_cms_image_id`) REFERENCES `u_cms_image` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_cms_image_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_layout_i18n`
--
ALTER TABLE `u_cms_layout_i18n`
ADD CONSTRAINT `u_cms_layout_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_cms_layout_i18n_ibfk_3` FOREIGN KEY (`u_cms_layout_id`) REFERENCES `u_cms_layout` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_menu`
--
ALTER TABLE `u_cms_menu`
ADD CONSTRAINT `u_cms_menu_ibfk_1` FOREIGN KEY (`u_cms_menu_group_id`) REFERENCES `u_cms_menu_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_menu_group_i18n`
--
ALTER TABLE `u_cms_menu_group_i18n`
ADD CONSTRAINT `u_cms_menu_group_i18n_ibfk_1` FOREIGN KEY (`u_cms_menu_group_id`) REFERENCES `u_cms_menu_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_cms_menu_group_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_menu_i18n`
--
ALTER TABLE `u_cms_menu_i18n`
ADD CONSTRAINT `u_cms_menu_i18n_ibfk_1` FOREIGN KEY (`u_cms_menu_id`) REFERENCES `u_cms_menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_cms_menu_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_news`
--
ALTER TABLE `u_cms_news`
ADD CONSTRAINT `u_cms_news_ibfk_1` FOREIGN KEY (`u_cms_news_group_id`) REFERENCES `u_cms_news_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_news_group_i18n`
--
ALTER TABLE `u_cms_news_group_i18n`
ADD CONSTRAINT `u_cms_news_group_i18n_ibfk_1` FOREIGN KEY (`u_cms_news_group_id`) REFERENCES `u_cms_news_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_cms_news_group_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_news_i18n`
--
ALTER TABLE `u_cms_news_i18n`
ADD CONSTRAINT `u_cms_news_i18n_ibfk_1` FOREIGN KEY (`u_cms_news_id`) REFERENCES `u_cms_news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_cms_news_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_page`
--
ALTER TABLE `u_cms_page`
ADD CONSTRAINT `u_cms_page_ibfk_1` FOREIGN KEY (`u_cms_layout_id`) REFERENCES `u_cms_layout` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_page_content`
--
ALTER TABLE `u_cms_page_content`
ADD CONSTRAINT `u_cms_page_content_ibfk_2` FOREIGN KEY (`u_cms_page_id`) REFERENCES `u_cms_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_page_content_i18n`
--
ALTER TABLE `u_cms_page_content_i18n`
ADD CONSTRAINT `u_cms_page_content_i18n_ibfk_1` FOREIGN KEY (`u_cms_page_content_id`) REFERENCES `u_cms_page_content` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_cms_page_content_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_page_i18n`
--
ALTER TABLE `u_cms_page_i18n`
ADD CONSTRAINT `u_cms_page_i18n_ibfk_1` FOREIGN KEY (`u_cms_page_id`) REFERENCES `u_cms_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_cms_page_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_social_i18n`
--
ALTER TABLE `u_cms_social_i18n`
ADD CONSTRAINT `u_cms_social_i18n_ibfk_1` FOREIGN KEY (`u_cms_social_id`) REFERENCES `u_cms_social` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_cms_social_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_cms_widget_i18n`
--
ALTER TABLE `u_cms_widget_i18n`
ADD CONSTRAINT `u_cms_widget_i18n_ibfk_1` FOREIGN KEY (`u_cms_widget_id`) REFERENCES `u_cms_widget` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_cms_widget_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_group_i18n`
--
ALTER TABLE `u_group_i18n`
ADD CONSTRAINT `u_group_i18n_ibfk_3` FOREIGN KEY (`u_group_id`) REFERENCES `u_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_group_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_group_role`
--
ALTER TABLE `u_group_role`
ADD CONSTRAINT `u_group_role_ibfk_3` FOREIGN KEY (`u_group_id`) REFERENCES `u_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_group_role_ibfk_4` FOREIGN KEY (`u_role_id`) REFERENCES `u_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_i18n_i18n`
--
ALTER TABLE `u_i18n_i18n`
ADD CONSTRAINT `u_i18n_i18n_ibfk_3` FOREIGN KEY (`u_i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_i18n_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_interface_setting`
--
ALTER TABLE `u_interface_setting`
ADD CONSTRAINT `u_interface_setting_ibfk_4` FOREIGN KEY (`u_person_id`) REFERENCES `u_person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_mail_sending_role`
--
ALTER TABLE `u_mail_sending_role`
ADD CONSTRAINT `u_mail_sending_role_ibfk_4` FOREIGN KEY (`u_person_id`) REFERENCES `u_person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_mail_sending_role_ibfk_5` FOREIGN KEY (`u_mail_template_id`) REFERENCES `u_mail_template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_mail_sending_role_ibfk_6` FOREIGN KEY (`u_mail_send_role_id`) REFERENCES `u_mail_send_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_mail_send_role_i18n`
--
ALTER TABLE `u_mail_send_role_i18n`
ADD CONSTRAINT `u_mail_send_role_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_mail_send_role_i18n_ibfk_5` FOREIGN KEY (`u_mail_send_role_id`) REFERENCES `u_mail_send_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_mail_template`
--
ALTER TABLE `u_mail_template`
ADD CONSTRAINT `u_mail_template_ibfk_2` FOREIGN KEY (`u_mail_template_group_id`) REFERENCES `u_mail_template_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_mail_template_group_i18n`
--
ALTER TABLE `u_mail_template_group_i18n`
ADD CONSTRAINT `u_mail_template_group_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_mail_template_group_i18n_ibfk_5` FOREIGN KEY (`u_mail_template_group_id`) REFERENCES `u_mail_template_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_mail_template_i18n`
--
ALTER TABLE `u_mail_template_i18n`
ADD CONSTRAINT `u_mail_template_i18n_ibfk_3` FOREIGN KEY (`u_mail_template_id`) REFERENCES `u_mail_template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_mail_template_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_message`
--
ALTER TABLE `u_message`
ADD CONSTRAINT `u_message_ibfk_2` FOREIGN KEY (`u_message_group_id`) REFERENCES `u_message_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_message_group_i18n`
--
ALTER TABLE `u_message_group_i18n`
ADD CONSTRAINT `u_message_group_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_message_group_i18n_ibfk_5` FOREIGN KEY (`u_message_group_id`) REFERENCES `u_message_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_message_i18n`
--
ALTER TABLE `u_message_i18n`
ADD CONSTRAINT `u_message_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_message_i18n_ibfk_5` FOREIGN KEY (`u_message_id`) REFERENCES `u_message` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_person`
--
ALTER TABLE `u_person`
ADD CONSTRAINT `u_person_ibfk_2` FOREIGN KEY (`default_language`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_person_group`
--
ALTER TABLE `u_person_group`
ADD CONSTRAINT `u_person_group_ibfk_3` FOREIGN KEY (`u_person_id`) REFERENCES `u_person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_person_group_ibfk_4` FOREIGN KEY (`u_group_id`) REFERENCES `u_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_person_token`
--
ALTER TABLE `u_person_token`
ADD CONSTRAINT `u_person_token_ibfk_1` FOREIGN KEY (`u_person_id`) REFERENCES `u_person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_role_i18n`
--
ALTER TABLE `u_role_i18n`
ADD CONSTRAINT `u_role_i18n_ibfk_3` FOREIGN KEY (`u_role_id`) REFERENCES `u_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_role_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_site_i18n`
--
ALTER TABLE `u_site_i18n`
ADD CONSTRAINT `u_site_i18n_ibfk_2` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_variable`
--
ALTER TABLE `u_variable`
ADD CONSTRAINT `u_variable_ibfk_2` FOREIGN KEY (`u_variable_group_id`) REFERENCES `u_variable_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_variable_group_i18n`
--
ALTER TABLE `u_variable_group_i18n`
ADD CONSTRAINT `u_variable_group_i18n_ibfk_4` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_variable_group_i18n_ibfk_5` FOREIGN KEY (`u_variable_group_id`) REFERENCES `u_variable_group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `u_variable_i18n`
--
ALTER TABLE `u_variable_i18n`
ADD CONSTRAINT `u_variable_i18n_ibfk_4` FOREIGN KEY (`u_variable_id`) REFERENCES `u_variable` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `u_variable_i18n_ibfk_5` FOREIGN KEY (`i18n_id`) REFERENCES `u_i18n` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

set foreign_key_checks = 1;


ALTER TABLE `comment` ADD `name` VARCHAR( 50 ) NOT NULL ,
ADD `email` VARCHAR( 50 ) NOT NULL


2013-07-26 :
CREATE TABLE `contact` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 50 ) NOT NULL ,
`email` VARCHAR( 50 ) NOT NULL ,
`website` VARCHAR( 150 ) NOT NULL ,
`message` LONGTEXT NOT NULL ,
`message_time` DATETIME NOT NULL
) ENGINE = MYISAM ;



CREATE TABLE IF NOT EXISTS `page_static` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `desc` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `page_static`
--

INSERT INTO `page_static` (`id`, `name`, `alias`, `desc`) VALUES
(2, 'About us', 'about-us', 'Ini isinya about us 213123 222<br>'),
(3, 'Advertising', 'advertising', 'advertising'),
(4, 'Full Page', 'full-page', '<p>Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto. Beatae vitae dicta sunt.<br />\r\nexplicabo ipsam voluptatem. Quia <a href="#">voluptas sit aspernatur</a> aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</p>\r\n<p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitatione, by injected humour, or randomised words which don&#8217;t look even slightly believable. If you <a href="#">are going to use</a> a passage of Lorem Ipsum, you need.</p>\r\n<p><em>“ Be sure there isn&#8217;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet ora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitatione”.</em></p>\r\n<h4>Perspiciatis unde omnis iste natus.</h4>\r\n<p>Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto. Beatae vitae dicta sunt.explicabo ipsam voluptatem. Quia voluptas sit aspernatur aut odit aut fugit.</p>\r\n<p>Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat.</p>\r\n<blockquote class="sc_quote sc_quote_style_1"><span class="quotes">&#8220;</span>Omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas.</blockquote>\r\n<p>Perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto. Beatae vitae dicta sunt.explicabo ipsam voluptatem.</p>'),
(5, 'Privacy Policy', 'privacy-policy', 'Privacy Policy');
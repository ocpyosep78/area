-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 16. Juli 2013 jam 09:40
-- Versi Server: 5.1.41
-- Versi PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `suekarea_bd`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`id`, `alias`, `name`) VALUES
(1, 'film', 'Film'),
(2, 'tv-serial', 'TV Serial'),
(3, 'anime', 'Anime'),
(4, 'cartoon', 'Cartoon');

-- --------------------------------------------------------

--
-- Struktur dari tabel `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `comment` longtext NOT NULL,
  `comment_time` datetime NOT NULL,
  `is_publish` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `link`, `comment`, `comment_time`, `is_publish`) VALUES
(3, 0, '', 'asd', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `post_type_id` int(11) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desc` longtext NOT NULL,
  `link_source` longtext NOT NULL,
  `thumbnail` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL,
  `publish_date` datetime NOT NULL,
  `view_count` int(11) NOT NULL,
  `is_hot` tinyint(4) NOT NULL,
  `is_popular` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data untuk tabel `post`
--

INSERT INTO `post` (`id`, `user_id`, `category_id`, `post_type_id`, `alias`, `name`, `desc`, `link_source`, `thumbnail`, `create_date`, `publish_date`, `view_count`, `is_hot`, `is_popular`) VALUES
(4, 1, 2, 3, 'g-i-joe-retaliation-2013', 'G.I.Joe Retaliation (2013)', '<div> <span>The G.I. Joes are not only fighting their mortal enemy Cobra; they are forced to contend with threats from within the government that jeopardize their very existence.</span> </div><div> <span><br></span> </div><div> <span>Director: Jon M. Chu</span> </div><div> <span>Writers: Rhett Reese, Paul Wernick</span> </div><div> <span>Stars: Dwayne Johnson, Byung-hun Lee, Adrianne Palicki | See full cast and crew</span> </div>', 'http://www.mirrorcreator.com/files/FLO5NGCA/giret.avi.001_links giret.avi.001\nhttp://www.mirrorcreator.com/files/0LJYB2FV/giret.avi.002_links giret.avi.002\nhttp://www.mirrorcreator.com/files/Z6JXVQFH/giret.avi.003_links giret.avi.003\nhttp://www.mirrorcreator.com/files/PHMKC890/giret.avi.004_links giret.avi.004\nhttp://www.mirrorcreator.com/files/01FCIZ4K/giret.avi.005_links giret.avi.005', '2013/07/16/20130716_093202_7114.jpg', '2013-07-11 06:34:00', '2013-07-11 05:31:00', 0, 1, 1),
(5, 1, 2, 3, 'at-any-price', 'At Any Price', '&nbsp;A farming family''s business is threatened by an unexpected crisis, further testing the relationship between a father and his rebellious son.<br><br>Director : Ramin Bahrani<br>Writers : Ramin Bahrani (screenplay), Hallie Elizabeth Newton<br>Stars : Dennis Quaid, Kim Dickens, Zac Efron | See full cast and crew <br>', 'http://www.mirrorcreator.com/files/1RHDE1QM/aap2012.avi_0.001_links aap2012.avi.001\nhttp://www.mirrorcreator.com/files/CBLPVDAO/aap2012.avi_0.002_links aap2012.avi.002\nhttp://www.mirrorcreator.com/files/FQIRTM71/aap2012.avi.003_links aap2012.avi.003\nhttp://www.mirrorcreator.com/files/03FNVDPC/aap2012.avi.004_links aap2012.avi.004', '2013/07/16/20130716_092956_7665.jpg', '2013-07-13 19:21:48', '2013-07-13 18:19:00', 0, 1, 1),
(6, 1, 2, 3, 'a-good-day-to-die-hard', 'A Good Day to Die Hard', 'John McClane travels to Russia to help out his seemingly wayward son, Jack, only to discover that Jack is a CIA operative working to prevent a nuclear-weapons heist, causing the father and son to team up against underworld forces.<br><br>Director : John Moore<br>Writers : Skip Woods, Roderick Thorp (certain original characters by)<br>Stars : Bruce Willis, Jai Courtney, Sebastian Koch | See full cast and crew <br>', 'http://www.mirrorcreator.com/files/UV94VDY3/agdtdh.avi.001_links agdtdh.avi.001\nhttp://www.mirrorcreator.com/files/0OWSCROP/agdtdh.avi.002_links agdtdh.avi.002\nhttp://www.mirrorcreator.com/files/0FDEOTJ0/agdtdh.avi.003_links agdtdh.avi.003\nhttp://www.mirrorcreator.com/files/13UXTSM8/agdtdh.avi.004_links agdtdh.avi.004', '2013/07/16/20130716_092704_3147.jpg', '2013-07-13 19:23:25', '2013-07-13 18:22:00', 0, 1, 1),
(7, 1, 3, 3, 'horriblesubs-dog-scissors-01', '[HorribleSubs] Dog & Scissors - 01', 'Plot Summary: The absurd mystery comedy centers around Kazuhito Harumi, a high school boy who is obsessed with reading books. One day, he is killed in the middle of a robbery and resurrected as a dachshund dog. Unable to read in his new form, the hapless Kazuhito now belongs to Kirihime Natsuno, a sadistic novelist who uses scissors on Kazuhito to abuse him.', 'http://www.mirrorcreator.com/files/NVLJPN8I/dns01.mkv.001_links dns01.mkv.001\nhttp://www.mirrorcreator.com/files/WEUCXSKH/dns01.mkv.002_links dns01.mkv.002', '2013/07/16/20130716_092501_2415.jpg', '2013-07-13 19:25:16', '2013-07-13 18:23:00', 0, 1, 1),
(8, 1, 4, 3, 'apocalypse-z-2013', 'Apocalypse Z 2013', 'A bacteriological weapon developed by the Us Government to create a super soldier - spreads an epidemic in a quiet little town in the middle of Eastern Europe. All citizens have been turned into infected zombies. The plan is to bring an atomic bomb into the city''s nuclear plant to pretend a terrible accident occurred. No one has to know the truth. A team of mercenaries is hired to complete the mission. The battle is on. Hordes of monsters against the team. Who will survive?', 'http://www.mirrorcreator.com/files/0RHJ6TPJ/aplz.avi.001_links aplz.avi.001\nhttp://www.mirrorcreator.com/files/JMGNLFQC/aplz.avi.002_links aplz.avi.002\nhttp://www.mirrorcreator.com/files/0PTGHBKR/aplz.avi.003_links aplz.avi.003\nhttp://www.mirrorcreator.com/files/2FTGGI9Y/aplz.avi.004_links aplz.avi.004', '2013/07/16/20130716_092039_8866.jpg', '2013-07-13 19:27:33', '2013-07-13 18:25:00', 0, 1, 1),
(9, 1, 4, 3, 'olympus-has-fallen-2013', 'Olympus Has Fallen (2013)', 'Disgraced former Presidential guard Mike Banning finds himself trapped inside the White House in the wake of a terrorist attack; using his inside knowledge, Banning works with national security to rescue the President from his kidnappers.<br><br>Director: Antoine Fuqua<br>Writers: Creighton Rothenberger, Katrin Benedikt<br>Stars: Gerard Butler, Aaron Eckhart, Morgan Freeman | See full cast and crew<br><br>', 'http://www.mirrorcreator.com/files/1TZXYPUL/ohf2013.avi.001_links ohf2013.avi.001\nhttp://www.mirrorcreator.com/files/1EZWCUKY/ohf2013.avi.002_links ohf2013.avi.002\nhttp://www.mirrorcreator.com/files/WXOG8PBK/ohf2013.avi.003_links ohf2013.avi.003\nhttp://www.mirrorcreator.com/files/S5NOGNHK/ohf2013.avi.004_links ohf2013.avi.004', '2013/07/16/20130716_091753_3244.jpg', '2013-07-13 19:29:01', '2013-07-13 18:28:00', 0, 1, 1),
(10, 1, 3, 3, 'utw-photokano-13', '[UTW] Photokano - 13', '<div>Photo Kano is a Japanese dating sim game developed by Dingo and Enterbrain, and was released for the PlayStation Portable on February 2, 2012.</div><br><br><div>Due to the Enterbrain''s involvement, Photo Kano is considered the spiritual successor to KimiKiss and Amagami despite having no recurring staff except for Ichiro Sugiyama who was the producer for KimiKiss.</div><br><br><div>An enhanced version titled Photo Kano Kiss was released on April 25, 2013 for the PlayStation Vita. There have been five manga adaptations, and an anime television series produced by Madhouse began airing on April 5, 2013 on TBS.</div>', 'http://www.mirrorcreator.com/files/0DDGKLUH/pk13.mkv.001_links pk13.mkv.001\nhttp://www.mirrorcreator.com/files/Q2F7O5IL/pk13.mkv.002_links pk13.mkv.002', '2013/07/16/20130716_091506_5466.jpg', '2013-07-13 19:33:44', '2013-07-13 18:31:00', 0, 0, 0),
(11, 1, 4, 3, 'paranorman', 'Paranorman', '<span style="color: rgb(0, 0, 0); "></span> <span>A misunderstood boy takes on ghosts, zombies and grown-ups to save his town from a centuries-old curse.</span> <div> <span><br></span> </div><div> <span>Directors: Chris Butler, Sam Fell</span> </div><div> <span>Writer: Chris Butler</span> </div><div> <span>Stars: Kodi Smit-McPhee, Tucker Albrizzi, Anna Kendrick | See full cast and crew</span> </div>', 'http://www.mirrorcreator.com/files/D93A2KNA/para.mp4.001_links para.mp4.001\nhttp://www.mirrorcreator.com/files/1OICUGAV/para.mp4.002_links para.mp4.002\nhttp://www.mirrorcreator.com/files/1HEOMCSS/para.mp4.003_links para.mp4.003\nhttp://www.mirrorcreator.com/files/01WGF3VL/para.mp4.004_links para.mp4.004', '2013/07/16/20130716_091135_2255.jpeg', '2013-07-13 19:34:51', '2013-07-13 18:33:00', 0, 1, 1),
(12, 1, 3, 3, 'anime-koi-karneval', '[Anime-Koi] Karneval', 'Nai searches for someone important to him, with only an abandoned bracelet as a clue. Gareki steals and pick-pockets to get by from day to day. The two meet in a strange mansion where they are set-up, and soon become wanted criminals by military security operatives. When Nai and Gareki find themselves desperate in a hopeless predicament, they encounter none other than the country''s most powerful defense organization, "Circus".<br><br>&nbsp;The Circus is a Defense organization that works for the government. They perform raids to capture criminals and solve crimes that the Security force otherwise cannot handle. After their raids, they put on shows as an apology for scaring the citizens.<br><br>Their group consists of the strongest, most capable fighters that use a special type of bracelet, known as Circus I.D., to fight.', 'http://www.mirrorcreator.com/files/QPYJCGHY/karneval.mkv.001_links karneval.mkv.001\nhttp://www.mirrorcreator.com/files/KJHSMX9Y/karneval.mkv.002_links karneval.mkv.002\nhttp://www.mirrorcreator.com/files/1ZBR6S3Q/karneval.mkv.003_links karneval.mkv.003', '2013/07/16/20130716_090926_2253.jpg', '2013-07-13 19:36:43', '2013-07-13 18:35:00', 0, 0, 0),
(13, 1, 1, 3, 'fast-furious-6-2013-hdrip', 'Fast & Furious 6 2013 HDRip', '<span style="color: rgb(0, 0, 0); "></span> <span>Hobbs has Dom and Brian reassemble their crew in order to take down a mastermind who commands an organization of mercenary drivers across 12 countries. Payment? Full pardons for them all.</span> <div> <span><br></span> </div><div> <span>Director: Justin Lin</span> </div><div> <span>Writers: Chris Morgan, Gary Scott Thompson (characters)</span> </div><div> <span>Stars: Vin Diesel, Paul Walker, Dwayne Johnson | See full cast and crew</span> </div>', 'http://www.mirrorcreator.com/files/LR4JVALB/ff6.mkv.001_links ff6.mkv.001\nhttp://www.mirrorcreator.com/files/NXNX4IEG/ff6.mkv.002_links ff6.mkv.002\nhttp://www.mirrorcreator.com/files/0NEE7CWS/ff6.mkv.003_links ff6.mkv.003\nhttp://www.mirrorcreator.com/files/1PKUNFYE/ff6.mkv_0.004_links ff6.mkv.004\nhttp://www.mirrorcreator.com/files/KPNHH9UK/ff6.mkv.005_links ff6.mkv.005\nhttp://www.mirrorcreator.com/files/1Z3PQ4MY/ff6.mkv.006_links ff6.mkv.006\nhttp://www.mirrorcreator.com/files/JMTMPVZ1/ff6.mkv.007_links ff6.mkv.007\nhttp://www.mirrorcreator.com/files/0BGVDIPZ/ff6.mkv.008_links ff6.mkv.008', '2013/07/16/20130716_072600_7693.jpg', '2013-07-13 19:38:04', '2013-07-13 18:37:00', 0, 1, 1),
(14, 1, 1, 3, 'redemption-2013-hdrip-xvid-aqos', 'Redemption 2013 HDRip XviD AQOS', 'Redemption is a documentary about New York City''s canners - the men and women who survive by redeeming bottles and cans they collect from curbs, garbage cans and apartment complexes.', 'http://www.mirrorcreator.com/files/06EFC7U4/redempt.avi.001_links redempt.avi.001\nhttp://www.mirrorcreator.com/files/ZOE1BHGY/redempt.avi.002_links redempt.avi.002\nhttp://www.mirrorcreator.com/files/1Q2DAKWL/redempt.avi.003_links redempt.avi.003\nhttp://www.mirrorcreator.com/files/DFEPBYMH/redempt.avi.004_links redempt.avi.004\nhttp://www.mirrorcreator.com/files/XZMU9HRH/redempt.avi.005_links redempt.avi.005', '2013/07/16/20130716_085950_8921.jpg', '2013-07-13 19:39:30', '2013-07-13 18:38:00', 0, 0, 1),
(15, 1, 1, 3, 'hansel-gretel-witch-hunters-2013', 'Hansel & Gretel: Witch Hunters (2013)', '<span style="color: rgb(0, 0, 0); "></span><div> <span>Hansel &amp; Gretel are bounty hunters who track and kill witches all over the world. As the fabled Blood Moon approaches, the siblings encounter a new form of evil that might hold a secret to their past.</span> </div><div> <span><br></span> </div><div> <span>Director: Tommy Wirkola</span> </div><div> <span>Writer: Tommy Wirkola</span> </div><div> <span>Stars: Jeremy Renner, Gemma Arterton, Famke Janssen | See full cast and crew</span> </div>', 'http://www.mirrorcreator.com/files/1TZGRE6H/hngwh.avi.001_links hngwh.avi.001\nhttp://www.mirrorcreator.com/files/18SP7EWY/hngwh.avi.002_links hngwh.avi.002\nhttp://www.mirrorcreator.com/files/YPYHEAOE/hngwh.avi.003_links hngwh.avi.003\nhttp://www.mirrorcreator.com/files/0KKKLUWZ/hngwh.avi.004_links hngwh.avi.004', '2013/07/16/20130716_085708_8902.jpg', '2013-07-13 19:40:30', '2013-07-13 18:39:00', 0, 1, 1),
(16, 1, 1, 3, 'sawney-flesh-of-man', 'Sawney: Flesh of Man', '<span style="color: rgb(0, 0, 0); "></span><div> <span>Scottish cannibal Sawney Bean and his murderous, inbred family are responsible for over a thousand murders over the centuries.</span> </div><div> <span><br></span> </div><div> <span>Director: Ricky Wood</span> </div><div> <span>Writer: Rick Wood</span> </div><div> <span>Stars: Elizabeth Brown, Lisa Cameron, Lindsay Cromar | See full cast and crew</span> </div>', 'http://www.mirrorcreator.com/files/9ZHP4XJR/lod2013.avi.001_links lod2013.avi.001\nhttp://www.mirrorcreator.com/files/1A5IUVFF/lod2013.avi.002_links lod2013.avi.002\nhttp://www.mirrorcreator.com/files/0XNGB966/lod2013.avi.003_links lod2013.avi.003\nhttp://www.mirrorcreator.com/files/1PWE9EF0/lod2013.avi.004_links lod2013.avi.004\nhttp://www.mirrorcreator.com/files/0FB3RMKU/lod2013.avi.005_links lod2013.avi.005', '2013/07/16/20130716_085515_8891.jpg', '2013-07-13 19:42:43', '2013-07-13 18:42:00', 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `post_type`
--

CREATE TABLE IF NOT EXISTS `post_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data untuk tabel `post_type`
--

INSERT INTO `post_type` (`id`, `name`) VALUES
(1, 'Draft'),
(2, 'Single Link'),
(3, 'Multi Link');

-- --------------------------------------------------------

--
-- Struktur dari tabel `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `description` longtext NOT NULL,
  `request_time` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `request`
--

INSERT INTO `request` (`id`, `user_id`, `description`, `request_time`, `status`) VALUES
(1, 1, '111 2222', '2013-07-12 09:42:59', 'Approve');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_type_id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `register_date` datetime NOT NULL,
  `is_active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `user_type_id`, `email`, `fullname`, `passwd`, `address`, `register_date`, `is_active`) VALUES
(1, 1, 'her0satr@yahoo.com', 'Suekarea', 'fe30fa79056939db8cbe99c8d601de74', '1235', '2013-07-04 00:00:00', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `user_type`
--

INSERT INTO `user_type` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Member');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

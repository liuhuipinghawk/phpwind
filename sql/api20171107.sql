-- MySQL dump 10.13  Distrib 5.5.40, for linux2.6 (x86_64)
--
-- Host: localhost    Database: api
-- ------------------------------------------------------
-- Server version	5.5.40-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ad`
--

DROP TABLE IF EXISTS `ad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ad` (
  `adId` tinyint(11) NOT NULL AUTO_INCREMENT,
  `adName` varchar(30) DEFAULT NULL COMMENT '广告名称',
  `pid` tinyint(11) DEFAULT '0' COMMENT '父级ID',
  `thumb` varchar(260) DEFAULT NULL COMMENT '图片路径',
  `url` varchar(200) DEFAULT NULL COMMENT '路径',
  `createTime` varchar(100) DEFAULT NULL COMMENT '添加时间',
  `updateTime` varchar(100) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`adId`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ad`
--

LOCK TABLES `ad` WRITE;
/*!40000 ALTER TABLE `ad` DISABLE KEYS */;
INSERT INTO `ad` VALUES (1,'Demo',1,'http://img3.redocn.com/tupian/20150910/lvsebeijingshoujiAPPjiemian_4223262.jpg',NULL,'2017-07-25',NULL),(2,'Demo',1,'http://pic31.photophoto.cn/20140630/0020032932880435_b.jpg',NULL,'2017-07-25',NULL),(3,'Demo',1,'http://img.zcool.cn/community/0154c055c2fabf32f87528a18af321.jpg',NULL,'2017-07-25',NULL);
/*!40000 ALTER TABLE `ad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adcate`
--

DROP TABLE IF EXISTS `adcate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adcate` (
  `adCateId` tinyint(11) NOT NULL AUTO_INCREMENT COMMENT '广告分类Id',
  `adCateName` varchar(30) DEFAULT NULL COMMENT '广告名称',
  `parentId` tinyint(11) DEFAULT '0' COMMENT '父级分类',
  `createTime` varchar(100) DEFAULT NULL COMMENT '添加时间',
  `updateTime` varchar(100) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`adCateId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adcate`
--

LOCK TABLES `adcate` WRITE;
/*!40000 ALTER TABLE `adcate` DISABLE KEYS */;
INSERT INTO `adcate` VALUES (1,'大图轮播',0,'1501920404','1501920404'),(2,'APP首次加载图',0,'1501920419','1501920419'),(4,'service',0,'1504259552','1504259552');
/*!40000 ALTER TABLE `adcate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `adminid` int(11) NOT NULL AUTO_INCREMENT,
  `adminuser` varchar(32) DEFAULT NULL,
  `adminpass` varchar(90) DEFAULT NULL,
  `adminemail` varchar(50) DEFAULT NULL,
  `logintime` varchar(50) DEFAULT NULL,
  `loginip` varchar(50) DEFAULT NULL,
  `createtime` varchar(98) DEFAULT NULL,
  `headerImg` varchar(110) DEFAULT NULL,
  PRIMARY KEY (`adminid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (4,'admin','c3284d0f94606de1fd2af172aba15bf3','admin@163.com','1504238763','-1062706066','2017-09-02 07:12:14','uploads/admin/index.jpg'),(3,'syx_1990','0d96c6ef5946ca7b0a572f72840748db','838690365@qq.com','1510025877','1933344872','1501732126','uploads/admin/index.jpg'),(8,'mengjiao','e10adc3949ba59abbe56e057f20f883e','838690360@qq.com','1509499445','2099790230','2017-10-16 15:59:48','uploads/admin/ddd.jpg'),(9,'kexia','e10adc3949ba59abbe56e057f20f883e','838690360@qq.com','1508372802','3684535836','2017-10-16 16:00:24','uploads/admin/ddd.jpg');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app`
--

DROP TABLE IF EXISTS `app`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL,
  `is_encryption` tinyint(1) NOT NULL,
  `key` varchar(200) NOT NULL DEFAULT '0',
  `image_size` text,
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app`
--

LOCK TABLES `app` WRITE;
/*!40000 ALTER TABLE `app` DISABLE KEYS */;
INSERT INTO `app` VALUES (2,'安卓手机',1,'c39f07bf54425745d642498395ce144c',NULL,0,0,1),(3,'安卓pad',1,'c39f07bf54425745d642498395ce144c',NULL,0,0,1),(4,'iphone',1,'c39f07bf54425745d642498395ce144c',NULL,0,0,1);
/*!40000 ALTER TABLE `app` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `articleId` tinyint(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `cateId` tinyint(11) DEFAULT NULL COMMENT '分类ID',
  `houseId` tinyint(11) DEFAULT NULL COMMENT '楼盘ID',
  `adminName` varchar(30) DEFAULT NULL,
  `headImg` varchar(1000) DEFAULT NULL COMMENT '图像',
  `thumb` varchar(255) DEFAULT NULL COMMENT '图片路径',
  `content` longtext,
  `title` varchar(60) DEFAULT NULL COMMENT '标题',
  `status` tinyint(11) DEFAULT '0' COMMENT '1下架2',
  `stars` tinyint(11) DEFAULT '0' COMMENT '点赞数',
  `createTime` varchar(100) DEFAULT NULL,
  `updateTime` varchar(100) DEFAULT NULL,
  `introduction` varchar(255) DEFAULT NULL COMMENT '动态链接',
  `url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`articleId`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article`
--

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;
INSERT INTO `article` VALUES (19,1,2,'syx_1990','uploads/admin/ddd.jpg','uploads/article/微信截图_20171017170005.jpg','<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">胡润榜的热度今天依然没散，不谈辟谣的阿里高管，不聊上榜的二代90后，帮主今天来说说传统的房地产行业老板。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">这一年各地频繁出台严厉的调控政策，北上广深等一线城市房价止涨，不少业内人士预测房地产商的“寒冬来领”；但富豪榜中上榜最多的仍然房地产老板，而房地产老板的财富也在不断增长，只不过首富从万达的王健林变成了恒 大的许家印。可谓“流水的富豪榜，铁打的房地产商”。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">在北京上海，明显感到房价已经止涨了，销售已经冷淡了，但富豪榜仍有房地产商的半壁江山，这是为什么呢？</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\"><strong>许家印财富一天涨10亿，房地产业财富总额上涨</strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">根据胡润榜，恒 大董事局主席许家印以2900亿元身价首次成为中国首富，取代万达集团董事长王健林；腾讯公司董事会主席兼首席执行官马化腾以2500亿元财富超越阿里巴巴董事局主席马云，位列第二。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">最近两年榜单中稳坐前两位的王健林、马云，分别在2017年榜单中位列第5位和第3位。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">最近三年，首富分别是王健林和许家印，均出自房地产行业，女首富为碧桂园的杨惠妍，仍然是房地产行业。从整个榜单来看，这些年房地产行业上榜人数在连续下降，2017年在胡润百富榜的比例为14.6%。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">虽然连续下降，房地产行业的富豪人数仍然名列前茅，房地产行业的财富总额不断上涨，房地产行业前50名富豪的门槛为120亿，平均财富313亿。行业中富豪最多的为制造业，但由于制造业行业分散，事实上，房地产业富豪人数仍是最多。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">富豪榜一年一更新，榜单上的富豪排名也不断更迭变化中。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">据2016年的胡润房地产富豪榜，王健林及其家族以1150亿元第六次成为“地产首富”，许家印以505亿元上升两位到第二，75岁的北京“地产女王”陈丽华以490亿位居第三，而姚振华是2016年的“大黑马”，总财富翻了9倍到1150亿元，地产财富上升到400亿首次进入地产榜即进入前十名，列第六。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">从今年的胡润百富榜来看，房地产富豪的座次排名在更迭。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">许家印今年以2900亿元首次成为中国首富，他是胡润百富榜19年来第12位中国首富。“许家印的财富增长主要是这半年，涨了2000亿，平均一天涨10亿，这是99年以来财富增长速度最快的一次。”胡润说。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">胡润榜单表示，恒 大今年上半年成功引入两轮合共700亿战略投资，并迅速还清1129亿永续债，实现资产负债率下降至75.5%，同期股价增长近5倍。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">前首富王健林及其家族财富缩水600亿元，位列富豪榜第五位，这是王健林五年来第一次跌出前三甲。万达过去一年商业版图的变动使得王健林身价缩水，但也间接造富了其他富豪。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">今年，万达商业将13个文旅项目91%股权以438亿元的价格转让给融创，而这也使得融创孙宏斌今年财富增长625亿，位列榜单第十九位；万达将77个酒店以199亿元的价格转让给富力地产，也使得富力张力今年财富增长三成。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">此外，胡润榜单估值，目前29岁的王思聪个人财富50亿，除了在万达集团中的财富，其自行运营的普思资本也因互联网直播经济的热潮而收益颇丰。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">富豪榜前十名中另一位房地产富豪是碧桂园的杨惠妍，她今年挤掉“地产女王”陈丽华，重新摘回中国女首富的桂冠。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">在一年间，杨惠妍财富增长了1000多亿，合计身价达到1600亿元。在富豪榜中的位置，也从去年的第22名，迅速上升至第四位，也成为今年前十名中唯一的女性。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">除了以上前十名榜单中的富豪，帮主统计了一下部分房地产富豪或者涉及房地产业务的富豪的财富情况：</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">宝能姚振华：950亿元，第14位；泛海卢志强：860亿元，第16位；融创孙宏斌：720亿元，第19位；复星郭广昌：625亿元，第25位；龙湖吴亚军家族：570亿元，第30位； 龙光地产纪海鹏295亿元，第81位；SOHO中国潘石屹张欣夫妇：250亿元， 第111位。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\"><strong>房价止涨，富豪为何还是房地产行业最多？</strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">与富豪最多相对的是，今年楼市经历了十分严厉的调控，一二线城市尤其是热点城市房价止涨。从去年9月30日至今，多城经历了四轮以及以上的政策加码，房价止涨。在持续的严格调控之下，热点城市的房价则出现了增速放缓或下降的态势。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">从国家统计局的数据来看，8月70城房价中，15个一线和热点二线城市新建商品住宅价格环比下降或持平，包括北京上海广州深圳等。从同比看，15个热点和一线城市新建商品住宅价格涨幅均继续比上月回落，回落幅度在1.3至6.6个百分点之间。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">8月北京二手房价格跌幅连续四个月领跌全国。北京楼市房价和销量下滑，有的小区房价甚至下降2万元，也有的降价10%。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">截至9月底，共有超过40个城市在过去一年多出台了楼市调控政策。此外，也有不少城市的银行通过提高房贷利率，为楼市“降温”。不少分析人士认为，房地产商的好日子到头了，将迎来寒冬。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">既然如此，为什么房地产老板的财富依然上涨，富豪依然最多？</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">“因为过去两年多的楼市火爆，2017年房企迎来了历史上销售业绩与利润上涨最迅速的一年。”张大伟向帮主表示，楼市调控的市场影响在三季度末才会出现，叠加2016年末的结转，大部分企业将收获了历史上最丰盛的2017年房地产盛宴。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">从市场方面看，虽然调控抑制了部分城市的房地产市场。但从全国看，整体市场依然在同比上涨，全国房地产市场在2017年有望继续刷新2016年创造的记录。“其中，龙头房企转型加速，布局合理，明显上涨幅度超过市场平均涨幅。”张大伟分析。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\"><strong>房地产富豪财富背后是飙涨的业绩和股价</strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">房企的数据也与张大伟的说法一致。比如在杨惠妍身价大涨的背后，碧桂园今年的业绩和股价表现都十分强劲。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">资料显示，前三季度，碧桂园的销售规模突破了4000亿元。在8月中期业绩发布以后，碧桂园的股价便一路上扬。同花顺数据显示，截至8月15日的一年间，碧桂园的股价由3.016港元升至9.072港元，翻了两倍。在今年6月份，碧桂园的市值突破2000亿港元。此外，今年5月，碧桂园教育板块在纽交所上市，杨惠妍持股20%。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">恒 大半年报显示，今年上半年恒 大销售额2441亿，同比增72%。恒 大官网表示，2017年恒 大地产将实现销售4500亿元。而在2016年，恒 大地产实现销售额3734亿，销售面积4469万平方米，核心业务利润208亿元。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">万科也在9月份提前完成去年的销售额。据万科近日发布的公告显示，9月份公司实现销售面积272.9万平方米，销售金额463.2亿元。2017年1-9月，公司累计实现销售面积2664.5万平方米，销售金额3961亿元。而在2016年，万科地产销售额为3647.7亿元。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">“近日有31家企业发布9月销售业绩，9月单月这31家房企合计销售额达到了2524.3亿。环比上涨了20.3%。房企销售依然处于高峰中。”中原地产首席分析师张大伟告说，虽然部分龙头房企未公布销售业绩，但从目前数据看，公布销售业绩的企业2017年刷新纪录已成为定局。“房企年度目标完成平均已经超过80%，预计大部分企业将在10到11月完成年度销售目标。”</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">以下是张大伟向帮主提供的部分地产公司近三个月的销售数据，数据可以看出的，这十家地产公司中大部分房企销售面积、销售额在这三个月持续攀升：</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal; text-align: center;\"><img src=\"http://s3.ifengimg.com/2017/10/14/cf3f27e09af07f55410495dce2861261.png\" style=\"border-style: none; display: block; margin: 0px auto; max-width: 800px;\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">不过，需要值得注意的是，随着本轮调控逐渐影响开始影响市场，部分立足北上等一线城市的房企的销售将出现压力。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">“随着一二线城市的调控收紧，市场走势逐渐涨幅放缓。房地产销售增速持续收窄，企业之间分化非常明显，多家立足核心城市的上市房企营业收入及利润率出现了双下调，”张大伟分析，北京、上海等城市从严房地产市场调控政策，对于立足这些地区的企业来说，预计2017年全年市场很难乐观。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">也许到明年胡润百富榜发布时，房地产富豪榜的格局会再次更迭。</p><p><br/></p>','房价不涨了 为何还是房地产老板的财富增长最多？',0,1,'2017-10-17 17:00:50','2017-10-28 08:57:28','胡润榜的热度今天依然没散，不谈辟谣的阿里高管，不聊上榜的二代90后，帮主今天来说说传统的房地产行业老板。','/index.php?r=mobile/default/index&id=19&cateid=1'),(18,1,2,'syx_1990','uploads/admin/ddd.jpg','uploads/article/微信截图_20171017164942.jpg','<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">两个着传统武打装扮的年轻人，斜步蹲身，一起擎出一个硕大的牌匾来，中间三个遒劲有力的字正是“达摩院”。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">&nbsp;&nbsp;马云说，要搞电商，于是有了阿里巴巴；马云说，要有网上支付，于是有了支付宝，有了蚂蚁金服；马云说，要有云计算，于是到处是云计算。现在马云说，要有达摩院，于是，达摩院的牌子挂起来了。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">&nbsp;&nbsp;10月11日开幕的2017云栖大会吸引了4万人之众，人们把这场大会当做一场嘉年华，会场外，男人女人们，像游客一样撑起自拍杆，阿里帝国已经大到了令人咋舌的地步，批量创造着千万富翁。马云称阿里已经是世界上第21大经济体，未来要做第5大经济体。大会上人们记得最真切的是有“外星人”之称的马云说要投资1000亿元建立达摩院。达摩院就是实验室。马云为达摩院命名，当年马云同样为天猫命名。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">&nbsp;&nbsp;“达摩院”这个名字很有阿里特色，达摩是一个佛教人物，民间常称其为达摩祖师，南印度人，自称佛传禅宗第二十八祖，为中国禅宗始祖。南北朝时，达摩从南朝梁国北来，面壁于嵩山少林寺，历时九年。武侠小说中不可缺少的重要宗派“少林寺”，就由他光大，少林功夫“易筋经”据传就由他传授。少林寺的藏经阁是武林宝典，有各种关于技击的终极解读，面壁故事代表一种对智慧有平常心但又坚定不移的渴求。不少武侠小说提到武侠人士突然参悟出某种武功，打通关节。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">&nbsp;&nbsp;负责达摩院的是阿里CTO张建锋，诨名行癫。马云号风清扬，阿里有头脸的人物都有一个江湖诨名，就跟梁山泊一百零八将一样，连诨名都没有，估计这人在阿里也就没什么地位。如果将一些典故或者武侠背景联系起来，就会明白，达摩院其实是藏经阁，这里将会发明各种必杀之技，未来也不知道会怎么样，但大家都明白，谁掌握了技术，就会像大航海时代的殖民者一样，以少胜多。但是必杀技哪里会那么简单？到了一定程度就会有瓶颈，一定不是现有水平的修修补补，而是牵涉到基础科学、基础技术，越是处于领先地位的企业，越是走得靠前的企业，他们离天花板就越近，看得越清晰。这就是为什么国际顶尖企业会做顶尖研究，他们有财力有眼力，还有能力。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">&nbsp;&nbsp;“达摩院”首批公布的研究领域包括：量子计算、机器学习、基础算法、网络安全、视觉计算、自然语言处理、下一代人机交互、芯片技术、传感器技术、嵌入式系统等，涵盖机器智能、智联网、金融科技等多个产业领域。名目繁多，似乎无所不包，这里面可以看到马云的野心，这也显示了马云和阿里一个非常重要变化——由“术”向“道”。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">&nbsp;&nbsp;马云说，阿里成立七八年的时候，他坚决反对公司有任何研究室、实验室的，因为当时阿里是一个初创公司，公司在还没有立足之前就考虑研发是大灾难。阿里的做法一直是问题导向，遇到什么问题，需要什么，就组织工作人员去攻关。马云多次说过，如果他是技术人员，一开始就知道会有这么多难题，估计就会退缩，就不会有现在的阿里巴巴、蚂蚁金服。阿里现在不仅是遇到问题就组织科研人员去攻关，而是四处开拓疆土，看看有什么领域比较有机会。前者目的性很强，是问题导向，后者则是四处撒网，花钱多但不一定有结果。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">&nbsp;&nbsp;像这些比较基础的科研，一般是高校和科研院所承担，这些机构背后买单者是政府，这是政府要承担的职能之一，因为这些研发大多是没有收益的，但对社会会比较有帮助，让单个企业承担的成本太高。这表明阿里已经不再担忧生存问题，愿意承担一部分政府承担的责任。有不少人认为，阿里这次投入，只是一场作秀，科技不可能拔苗助长，不可能投进去很多钱，就能大跃进。不过公众应该去想一想，像阿里这样精明的企业，怎么会愿意做折本买卖？</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">&nbsp;&nbsp;阿里现在的规模已足够大，护城墙也足够高，危险来自未来，如果不下足功夫研究，一旦被竞争对手掌握，就有可能被秒杀。即使像腾讯这样规模的还面临从QQ到微信的惊险一跃，就跟苏宁和京东的竞争一样，一旦落后下去，就很难追赶了。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">&nbsp;&nbsp;马云说贝尔、IBM的实验室曾经创造辉煌，可这种工业时代的实验室模式已经没落了。他认为达摩院科研的目标不仅仅是FUN，也不仅是PROFIT，而是问题导向，以解决问题为目标。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">&nbsp;&nbsp;达摩院似乎是一个独立经营个体，就像很多研发机构也能最终上市一样，马云要求达摩院能够独立经营维持下去。至于方法，外人还很难猜测，科研机构一般要靠政府拨款，或者慈善捐助，当然也可以是订单式研发，转让专利技术。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">&nbsp;&nbsp;有很多技术是得益于那些大企业的研发，比如数码相机，即使研发者被革了命，也是为人类做了贡献。应该记住的是，即使那些传统企业没落了，他们留下的科研仍在；即使那些富豪不在了，他们留下的研究机构还在；比如卡耐基捐助的卡内基·梅隆大学，洛克菲勒捐助的洛克菲勒大学，还有洛克菲勒基金会对科学所做的贡献。</p><p><br/></p>','马云的达摩院想干嘛？',0,1,'2017-10-17 16:50:13','2017-10-28 09:00:21','两个着传统武打装扮的年轻人，斜步蹲身，一起擎出一个硕大的牌匾来，中间三个遒劲有力的字正是“达摩院”。','/index.php?r=mobile/default/index&id=18&cateid=1'),(17,1,2,'syx_1990','uploads/admin/ddd.jpg','uploads/article/支付宝.jpg','<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">最近，支付宝上线租房功能，来抢“包租婆”饭碗的消息引起了热议，很多网友认为“芝麻分超过650分可免押金、房租月付”一定可以冲击传统的房屋租赁模式，但事实是什么情况呢，“免押金”和“付一”的真相是什么，小编去实地测验了。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">10月10日，支付宝正式上线信用租房平台，上海、北京、深圳、杭州、南京、成都、西安、郑州八个城市在国内率先开通了支付宝租房业务。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal; text-align: center;\"><img src=\"http://s1.ifengimg.com/2017/10/15/1902c9161ab7d8664472f6e4e40f58da.jpg\" style=\"border-style: none; display: block; margin: 0px auto; max-width: 800px;\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">　听说芝麻信用分超过650还可以免押金、房租月付?这对租房族来说可谓福音，尤其是北京这样的地方,终于摆脱了“押一付三”、“押一付六”,动辄一次性缴纳大几千甚至上万元现金的尴尬。</p><p><br/></p>','实测：支付宝租房“免押金”和“付一”的真相是……',0,1,'2017-10-17 16:02:47','2017-10-28 09:01:10','最近，支付宝上线租房功能，来抢“包租婆”饭碗的消息引起了热议','/index.php?r=mobile/default/index&id=17&cateid=1'),(20,1,2,'syx_1990','uploads/admin/ddd.jpg','uploads/article/微信截图_20171017170711.jpg','<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">继支付宝介入住房租赁市场后，10月11日，中国银联宣布与沈阳市房产局签署住房租赁服务平台合作协议，共同推动住房租赁市场建设，提升老百姓租房、用房综合服务体验。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">今年7月，住建部等9部委联合印发了《关于在人口净流入的大中城市加快发展住房租赁市场的通知》，在全国范围内加快推进租赁住房建设，其中广州、深圳、南京、杭州、厦门、武汉、成都、沈阳、合肥、郑州、佛山、肇庆等12个城市成为首批开展住房租赁试点城市，大力建设政府住房租赁交易服务平台。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">此前一天，支付宝宣布正式上线租房平台，超过100万间公寓正式入驻，率先在上海、北京、深圳、杭州等8个城市试水信用租房，且芝麻信用分超过650分的租客可凭借信用免押金、按月交租。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">而中国银联也在不断完善各领域金融民生服务。自2016年《国务院办公厅关于加快培育和发展住房租赁市场的若干意见》发布以来，积极探索完善住房租赁市场的金融支付服务，结合自身在金融服务领域的技术研发、网络建设、客户服务等方面的经验，打造了中国银联住房租赁金融服务体系，实现包括金融产品的发布与撮合、信息认证，综合支付等功能，支持各地地方政府共同建设配套的金融服务平台。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">据介绍，中国银联住房租赁金融服务体系，以金融服务、信用体系、内容权益、综合支付为亮点，服务于各地政府住房租赁平台，满足租赁各参与方的实际需求。该项服务一端通过连接政府住房租赁平台对接租赁参与各方，包括房产开发企业、机构运营企业、出租人及承租人等；另一端通过银联标准接口对接各银行及其他各类金融机构的金融产品，让政府住房租赁平台通过一点接入，实现全部银行及各类金融机构的金融服务，达到“一点接入、全面覆盖”效果。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">中国银联表示，此次与沈阳市房产局签约的同时，正在积极加快与其他试点城市的合作进展，今年年内有望在12个试点城市全部实现服务开通。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\"><strong>租房市场迎来巨变支付宝将上线百万套房源</strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">住房租赁市场正迎来巨变。继牵手杭州市政府推出全国首个智慧住房租赁平台后，蚂蚁金服又祭出大招。10月10日，记者从中国放心公寓联盟发布会上获悉，蚂蚁金服旗下支付宝已正式上线租房平台，超过100万间公寓将入驻支付宝，在上海、北京、深圳、杭州、南京、成都、西安、郑州这8个城市率先推广信用租房。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">与此同时，地方政府亦加速扩容住房租赁市场。昨日，上海又推出5幅租赁住宅用地，涉及浦东世博、长宁古北和大虹桥区域，出让面积达16.3万平方米，地块位置均极其优越。自9部委将京沪等12个城市列入租赁市场试点城市以来，上海已陆续拿出24幅优质地块作为租赁用地。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">业内专家表示，国家政策的鼓励和培育，加上互联网技术和信用体系的支持，或将直击行业痛点，重构租房体验。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\"><strong>首批房源覆盖8大城市</strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">目前进驻支付宝的房源主要来自首批合作接入的长租公寓品牌——蘑菇租房，接下来将有魔方、寓见、V领地、蛋壳等近十家长租公寓品牌将陆续接入支付宝，房源总量将超过百万套。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">9月底，支付宝租房平台正式上线。记者实际体验发现，在支付宝首页搜索框搜索“租房”，即可进入信用租房平台，覆盖城市包括上海、北京、深圳、杭州、南京、成都、西安、郑州等8个城市。选定城市之后，可按照搜索条件，查寻经过信用评估后的房源。据记者了解，目前进驻支付宝的房源主要来自首批合作接入的长租公寓品牌——蘑菇租房，接下来将有魔方、寓见、V领地、蛋壳等近十家长租公寓品牌将陆续接入支付宝，房源总量将超过百万套。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">借助阿里成熟的产品技术能力，注入互联网创新基因，住房租赁市场多年来房源失真、中介人员失信等行业顽疾，有望得到解决。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">与传统线下租房不同的是，通过支付宝租房平台租房，租借双方会签订一份电子合同，一方面避免虚假合同，另一方面签订电子合同后，房源也会同步自动下线，以防止房源“永远在线”的情况，误导后续用户。预计今年年底支付宝租房平台上，还会形成租客、房东和从业人员的芝麻信用租房档案，把租房的所有参与方全部纳入信用体系。爱护房源、按时交租、诚实守信等行为都有助于信用积累，而挂出假房源、恶意欠租、提前清退、任意涨价等失信行为则会影响其信用评估。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">多位市场人士认为，参与各方信用体系的建立对住房租赁意义重大。不论是租客、房东、经纪公司、招租平台，守信可以帮助行业良性发展、避免纠纷。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\"><strong>着力推广信用租房</strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">信用租房“付一押零”，意味着一个用户的租房启动资金或将节省上万元。这对于很多刚毕业的年轻人来说，可大幅缓解资金压力。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">变革还体现在支付模式上。付三押一，是目前线下租房时最常见的付款方式。“我们希望推广的方式是付一押零，也就是说，用户可以凭借自己的信用，减免押金，按月交租。”蚂蚁金服创新及智能服务事业部总经理王博表示，这一模式此前在上海进行了半年左右的试运行。“我们发现，提供信用免押金的房源虽然仅占房源数量的15%，但却占据了80%的成交量，这证明信用租房模式非常受到用户的青睐。”</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">事实上，“付一押零”意味着一个用户的租房启动资金或将节省上万元。例如一套月租3500元的公寓，如果付三押一，用户第一次付房租要支付14000元；但如果付一押零，则只需要支付3500元，便可以节省10050元。这对于很多刚毕业的年轻人来说，可大幅缓解资金压力。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">“免押金租房对用户的价值点和吸引力显而易见，对租房成交的带动作用很大。但此前大家不知道能给哪些用户免押金，也不知道风险多大，引入支付宝芝麻信用后，这个问题便迎刃而解了。这种免押金租房，可能会和免押金租共享单车一样，逐渐成为趋势。”一位业内人士表示。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\"><strong>重塑租房行业格局</strong></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">蚂蚁金服计划将技术服务能力向更多合作伙伴和地方政府输出。蚂蚁金服房产租赁行业相关负责人向记者透露，继杭州之后，还有两三个试点城市将与蚂蚁金服在租房市场达成深度合作。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">信用租房看似并不复杂，但实际上需要涉及多维的互联网能力，而蚂蚁金服在这方面显然占据优势。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">王博向记者介绍说，电子合同需要依赖支付宝的实名认证和支付能力，免押金和信用档案需要依靠芝麻信用的信用体系，而按月交租的背后其实是房租分期，需要依赖蚂蚁金服的金融解决方案。“支付+信用+消费金融”，这一整套多维能力，蚂蚁金服将会全面向租房行业进行开放，输出给合作伙伴们，也包括中介公司。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">首批上线8个城市之后，支付宝平台还将陆续开通更多城市的租赁房源，主要包括一、二线城市以及部分经济较发达、人口流入量大的三线城市。一方面牵手长租公寓品牌的合作伙伴，另一方面蚂蚁金服还与地方政府深度合作，输出服务能力。蚂蚁金服房产租赁行业相关负责人向记者透露，继杭州之后，还有两三个试点城市将与蚂蚁金服在租房市场达成类似深度合作。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">在中央的大力推进之下，各地发展住房租赁市场的政策轮廓初现。大部分城市着力发展国有住房租赁平台，降低租赁住房税负，扩大租赁房源和建立市场监管体系。在此背景下，蚂蚁金服此次以变革者姿态涉足租房市场，将技术服务能力向更多合作伙伴和地方政府输出，有望重塑行业格局。</p><p><br/></p>','继支付宝之后中国银联也挺进住房租赁市场',0,1,'2017-10-17 17:07:45','2017-10-28 09:01:57','继支付宝之后中国银联也挺进住房租赁市场','/index.php?r=mobile/default/index&id=20&cateid=1'),(21,1,2,'syx_1990','uploads/admin/ddd.jpg','uploads/article/微信截图_20171017171028.jpg','<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">近期，郑州市轨道交通5号线工程轨道开铺动员会暨安全宣誓仪式在众意路站铺轨基地举行。这标志着5号线施工开始进入一个新阶段——铺设轨道。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\"><img src=\"http://s2.ifengimg.com/2017/07/03/f64d9719dcce52db82562292affb6bfb.jpeg\" style=\"border-style: none; display: block; margin: 0px auto; max-width: 800px;\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">铺轨是指在地铁车站和隧道内部铺设未来地铁列车行驶的轨道。5号线铺轨共分3个标段，昨天开始铺轨的是第一标段，由中铁一局具体负责施工。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">上午11时30分许，全体参建人员紧握右手庄严宣誓。铿锵有力的誓言表达了每一位参建员工对严守安全、严控质量的郑重承诺以及建好轨道交通5号线的决心。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">市轨道交通有限公司常务副经理袁聚亮下达开铺施工令。他说，轨道开铺标志着5号线工程施工从此进入了铺轨、土建、安装多专业并行施工新阶段，这将为2019年实现通车试运营奠定坚实基础。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &#39;Hiragino Sans GB&#39;, &#39;Microsoft Yahei UI&#39;, &#39;Microsoft Yahei&#39;, 微软雅黑, &#39;Segoe UI&#39;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; line-height: 28px; white-space: normal;\">据悉，目前5号线已实现全部车站和区间开工。所有车站区间土建施工中，除月季公园明挖段因上方建筑物未拆除进展缓慢外，其他区间隧道施工都在积极进行中。5号线计划2018年6月实现轨通。</p><p><br/></p>','郑州唯一环线地铁 5号线开始铺轨',0,0,'2017-10-17 17:11:02','2017-10-28 09:03:26','','/index.php?r=mobile/default/index&id=21&cateid=1'),(22,1,2,'syx_1990','uploads/admin/ddd.jpg','uploads/article/191da.jpg','<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; color: rgb(62, 62, 62); font-family: &quot;Helvetica Neue&quot;, Helvetica, &quot;Hiragino Sans GB&quot;, &quot;Microsoft YaHei&quot;, Arial, sans-serif; text-align: center; white-space: pre-wrap; word-wrap: break-word !important;\"><img src=\"http://www.zhengez.com/userfiles/image/20171018/1816274516a4613d6d8505.png\" title=\"1816274516a4613d6d8505.png\" alt=\"微信截图_20171018162653.png\" style=\"border-style: none; display: block; margin: 0px auto; max-width: 800px;\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; white-space: normal;\"></p><p></p><section><section><section></section><section><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; font-weight: bold; color: rgb(197, 22, 29); word-wrap: break-word !important;\"><span style=\"font-size:32px\"><br/></span></p><p style=\"text-align: center; margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; font-weight: bold; color: rgb(197, 22, 29); word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; word-wrap: break-word !important;font-size:32px\">热烈庆祝党的十九隆重开幕</span></p><section><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; text-align: justify; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; word-wrap: break-word !important;font-size:32px\"><br/></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; text-align: justify; word-wrap: break-word !important;\"><span style=\"font-size:32px\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; word-wrap: break-word !important;\">习近平指出，中国共产党第十九次全国代表大会，是在全面建成小康社会决胜阶段、中国特色社会主义进入新时代的关键时期召开的一次十分重要的大会。大会的主题是：</span><strong style=\"margin: 0px; padding: 0px; max-width: 100%; word-wrap: break-word !important;\">不忘初心，牢记使命，高举中国特色社会主义伟大旗帜，决胜全面建成小康社会，夺取新时代中国特色社会主义伟大胜利，为实现中华民族伟大复兴的中国梦不懈奋斗</strong><span style=\"margin: 0px; padding: 0px; max-width: 100%; word-wrap: break-word !important;\">。</span>”</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; word-wrap: break-word !important;\"><img src=\"http://www.zhengez.com/userfiles/image/20171018/181627540b80d320484061.jpg\" title=\"181627540b80d320484061.jpg\" alt=\"1.jpg\" style=\"border-style: none; display: block; margin: 0px auto; max-width: 800px;\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; text-align: justify; word-wrap: break-word !important;\"><span style=\"font-size:32px\">习近平在报告中指出，<strong style=\"margin: 0px; padding: 0px; max-width: 100%; word-wrap: break-word !important;\">经过长期努力，中国特色社会主义进入了新时代，这是我国发展新的历史方位</strong>。</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; word-wrap: break-word !important;\"><img src=\"http://www.zhengez.com/userfiles/image/20171018/1816280671a429b5559322.jpg\" title=\"1816280671a429b5559322.jpg\" alt=\"2.jpg\" style=\"border-style: none; display: block; margin: 0px auto; max-width: 800px;\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; text-align: justify; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; white-space: pre-wrap; word-wrap: break-word !important;font-size:32px\">中国特色社会主义进入新时代，意味着近代以来久经磨难的中华民族迎来了从站起来、富起来到强起来的伟大飞跃，迎来了实现中华民族伟大复兴的光明前景；意味着科学社会主义在二十一世纪的中国焕发出强大生机活力，在世界上高高举起了中国特色社会主义伟大旗帜；意味着中国特色社会主义道路、理论、制度、文化不断发展，拓展了发展中国家走向现代化的途径，给世界上那些既希望加快发展又希望保持自身独立性的国家和民族提供了全新选择，为解决人类问题贡献了中国智慧和中国方案。</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; white-space: pre-wrap; word-wrap: break-word !important;font-size:32px\"><img src=\"http://www.zhengez.com/userfiles/image/20171018/18162834779f944e782227.jpg\" title=\"18162834779f944e782227.jpg\" alt=\"3.jpg\" style=\"border-style: none; display: block; margin: 0px auto; max-width: 800px;\"/></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; text-align: justify; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; white-space: pre-wrap; word-wrap: break-word !important;font-size:32px\"><br/></span></p><p style=\"margin-top: 0px; margin-bottom: 20px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; text-align: justify; word-wrap: break-word !important;\"><span style=\"font-size:32px\">这个新时代，是承前启后、继往开来、在新的历史条件下继续夺取中国特色社会主义伟大胜利的时代，是决胜全面建成小康社会、进而全面建设社会主义现代化强国的时代，是全国各族人民团结奋斗、不断创造美好生活、逐步实现全体人民共同富裕的时代，是全体中华儿女勠力同心、奋力实现中华民族伟大复兴中国梦的时代，是我国日益走近世界舞台中央、不断为人类作出更大贡献的时代。</span></p><p style=\"margin-top: 0px; margin-bottom: 20px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; text-align: justify; word-wrap: break-word !important;\"><span style=\"font-size:32px\">习近平说，中国特色社会主义进入新时代，在中华人民共和国发展史上、中华民族发展史上具有重大意义，在世界社会主义发展史上、人类社会发展史上也具有重大意义。全党要坚定信心、奋发有为，让中国特色社会主义展现出更加强大的生命力。</span></p></section></section></section></section><p></p><p></p><section><section><section><section><section><section><section><section><section><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; text-align: justify; word-wrap: break-word !important;\"><span style=\"font-size:32px\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; word-wrap: break-word !important;\"></span></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; word-wrap: break-word !important;\"><img src=\"http://www.zhengez.com/userfiles/image/20171018/1816311290658258b31417.png\" title=\"1816311290658258b31417.png\" alt=\"微信截图_20171018162927.png\" style=\"border-style: none; display: block; margin: 0px auto; max-width: 800px;\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; text-align: justify; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; word-wrap: break-word !important;font-size:32px\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; background-color: rgba(255, 255, 255, 0.6); word-wrap: break-word !important;\">这</span>是一次肩负重大使命的历史性盛会。在全面建成小康社会决胜阶段、中国特色社会主义发展关键时期召开的党的十九大，将向世界明确宣示——在中国共产党的领导下，１３亿多中国人民将继续高举中国特色社会主义伟大旗帜，坚定不移沿着中国特色社会主义道路，向着实现民族复兴的伟大梦想奋勇前进。</span></p></section></section></section></section></section></section></section></section></section><section><section><section></section><section><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; font-weight: bold; color: rgb(197, 22, 29); word-wrap: break-word !important;\"><span style=\"font-size:32px\"><br/></span></p><p style=\"text-align: center; margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; white-space: pre-wrap; font-weight: bold; color: rgb(197, 22, 29); word-wrap: break-word !important;\"><span style=\"font-size:32px\">不忘初心，牢记使命</span></p><section><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; text-align: justify; word-wrap: break-word !important;\"><span style=\"font-size:32px\">学习号召党的艰苦奋斗不忘初心，为了理想奋斗的精神。在党的光辉照耀下正e租一直前行，发展成一家专业提供<a href=\"http://undefined\" class=\"p_wordlink\" target=\"_blank\" style=\"color: rgb(44, 44, 44); outline: none;\"><span style=\"font-size:32px\">写字楼</span></a>、<a href=\"http://undefined\" class=\"p_wordlink\" target=\"_blank\" style=\"color: rgb(44, 44, 44); outline: none;\"><span style=\"font-size:32px\">商铺</span></a>、公寓租赁服务的互联网平台，专注为用户提供基于写字楼、商铺、公寓入住到办公生活服务整套解决方案。党委提供了很多开放性的政策，让正e租网得以顺利发展，为人民服务的宗旨牢记在心，坚持以客户为中心，以服务为根本；以市场需求持续创新，极大的提升用户选租效率和节约租赁成本；为写字楼、商铺、公寓供需双方及第三方经纪人创造更多惊喜、机会、和服务。</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; word-wrap: break-word !important;\"><img src=\"http://www.zhengez.com/userfiles/image/20171018/18163137367629b8d68610.png\" title=\"18163137367629b8d68610.png\" alt=\"微信截图_20171018162943.png\" style=\"border-style: none; display: block; margin: 0px auto; max-width: 800px;\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; text-align: justify; word-wrap: break-word !important;\"><span style=\"font-size:32px\">“求木之长者，必固其根本；欲流之远者，必浚其泉源。”建党时的奋斗精神，是共产党人“初心”的内涵构成，是我们党攻坚克难的制胜法宝，也是今后不忘初心、继续前进的动力之源。正e租团队全体员工要深刻学习党留给我们弥足珍贵的精神财富，永葆奋斗精神，是我们不忘初心、继续前进的时代课题。</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; word-wrap: break-word !important;\"><span style=\"font-size:32px\"><br/></span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; text-align: justify; word-wrap: break-word !important;\"><span style=\"font-size:32px\">未来，正e租不忘初心，牢记使命，陆续覆盖更多河南省地市，将在资源整合方面持续发力，增强写字楼、商铺、公寓租赁服务与入住后增值服务的深度挖掘，加强服务意识，为客户提供更多场景化体验的企业级服务，实现用户办公发展所需的全领域专业服务而不断努力！</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px; outline: none; text-indent: 30px; max-width: 100%; clear: both; min-height: 1em; word-wrap: break-word !important;\"><img src=\"http://www.zhengez.com/userfiles/image/20171018/18163150b5f9b8ee936443.png\" title=\"18163150b5f9b8ee936443.png\" alt=\"微信截图_20171018162950.png\" style=\"border-style: none; display: block; margin: 0px auto; max-width: 800px;\"/></p></section></section></section></section><p></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; white-space: normal;\"><br/></p>','热烈庆祝党的十九大隆重开幕！不忘初心，牢记使命，为实现伟大理想而奋斗！',0,0,'2017-10-19 11:07:51','2017-10-28 09:04:12','热烈庆祝党的十九大隆重开幕！不忘初心，牢记使命，为实现伟大理想而奋斗！','/index.php?r=mobile/default/index&id=22&cateid=1'),(23,0,2,'mengjiao','uploads/admin/ddd.jpg','uploads/article/11.1.jpg','<p>正商四大铭筑环湖国际，550㎡高品质办公写字楼，环湖办公，环境静谧。超高性价比1.5元/㎡/天。</p><p><img src=\"http://106.15.127.161/css/umeditor/php/upload/20171101/15095132081457.jpg\"/></p>',' 房源推荐-正商四大铭筑环湖国际',0,2,'2017-11-01 13:13:59','2017-11-01 13:27:33','正商四大铭筑环湖国际','/index.php?r=mobile/default/index&id=23&cateid=0'),(24,0,2,'mengjiao','uploads/admin/ddd.jpg','uploads/article/u=2557470808,1468695862&fm=27&gp=0.jpg','<p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; white-space: normal;\">有过出租或租房经历的人都知道，租房市场有各种乱象。租客有可能遇上假房东、二房东，付了租金却被真房东赶出去。而房东可能也会遇到奇葩租客，被租客拖欠租金。</p><p style=\"text-align: center; margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; white-space: normal;\"><img src=\"http://106.15.127.161/css/umeditor/php/upload/20171101/15095153792478.jpg\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; white-space: normal;\">不过，今后杭州人租房，应该不用担心遇上这种乱糟糟的问题啦！8月9日，杭州住保房管局与阿里巴巴集团、蚂蚁金服集团就合作搭建智慧住房租赁监管服务平台举行了签约仪式。这个平台将实现住房租赁市场中企业、人员、房源、评价、信用等信息的全共享。解决租赁市场中房源信息不实、租赁关系不稳定、租赁行为不规范等诸多痛点。这是全国首个充分利用阿里巴巴的大数据、线上交易、评价系统及蚂蚁金服的网上支付、芝麻信用体系等技术的平台。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; white-space: normal;\">在具体功能上，租赁平台既注重监管、又突出服务，我们来重点解析一下平台诸多功能中的七大亮点——</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; white-space: normal;\">实人认证，人脸识别揪出弄虚作假的租客。租赁平台将通过实名身份验证以及人脸识别等技术，确保中介、房东、租客的身份真实性和操作真实性，从而提高房屋租赁业务的可靠性、安全性。有了这个功能，房东就不担心遇上用假身份证的租客了。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; white-space: normal;\">全方位核验房源真实性，确保真房东。租赁平台通过住保房管局房屋权属核验与阿里巴巴验真服务相结合的方式，对挂牌房源均实行核验，从而实现房源“七真”，即真实产权、真实存在、真实委托、真实价格、真实图片、真实信用、真实评价。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; white-space: normal;\">统筹公安、公积金、教育等各部门信息，共享一站式服务。在签约仪式现场，来了公安局（流动人口办）、教育局、建委、国土资源局、规划局等相关部门，租赁平台将与公安、工商、公积金、教育等相关部门互联共享，实现人口流动备案、居住证办理、住房公积金提取等在线办理服务，为租赁各方提供一站式便民服务。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; white-space: normal;\">评价系统将租房双方各种情况变得透明。租赁平台将结合“杭州市二手房交易监管服务平台”管理体系和阿里提供的线上评价体系，租赁主体将在租前、租中、租后，进行多维度、多阶段互评，包括买卖双方对经纪人的服务评价、租客对房屋核验情况的评价、租客对房东的服务评价、房东对租客的收房评价以及对租客的缴费行为评价等。通过评价，一方面鼓励租赁主体自觉履约，规范租赁行为；另一方面将评价纳入租赁主体的整体信用状况，供平台用户参考评估。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; white-space: normal;\">信用体系成为租房双方的辨别利器。租赁平台将结合“杭州市二手房交易监管服务平台”管理体系和芝麻信用，全新打造租客、房东及租赁机构的信用体系。未来，杭州市的可租房源、租客、房东以及中介服务人员都将对应一套完善的信用体系。信用好的房东，会获得更多租客的青睐，信用好的租客，不仅可能免交押金，还有可能按月缴纳房租。同时，爱护房源、履约交租都有助租客信用积累。而如果在租房过程中有恶意失信行为，也会影响其信用评估。通过营造大家一起遵守契约的氛围，化解各种租房纠纷。一个有过拖欠租金记录的租客，或者一个二房东，都有可能因为信用不良，上了平台的黑名单。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; white-space: normal;\">租金、押金、佣金网上支付，保障双方利益。租赁平台将利用蚂蚁金服网上支付技术，实现租金、押金、佣金等完全线上支付，同时严格保障资金支付安全。以前，房东担心租客拖欠房租，租客担心房东扣押金，有了这个平台监督，对双方都是约束，保障双方利益。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; white-space: normal;\">多通道在线签约，轻松实现智能网签。租赁平台打造了“一个平台两个服务通道”。房东、租客可以使用电脑或移动设备，通过住保房管局或阿里巴巴其中任一通道实现智能网签。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 5px 0px; outline: none; text-indent: 30px; color: rgb(51, 51, 51); font-family: &quot;Hiragino Sans GB&quot;, &quot;Microsoft Yahei UI&quot;, &quot;Microsoft Yahei&quot;, 微软雅黑, &quot;Segoe UI&quot;, Tahoma, 宋体, SimSun, sans-serif; font-size: medium; white-space: normal;\">在租赁平台合作成功的基础上，杭州市住保房管局还将与阿里巴巴共同探索优化延伸二手房交易的更多便民服务。这次合作是阿里巴巴在二手房领域租售能力对政府的首次输出。“信用租房不仅实实在在地减轻了资金负担，还避免了黑中介、假房源、恶意违约等行业问题。人们在杭州的落脚门槛降低，就能吸引和留住更多的人才，从而提升杭州核心竞争力。”芝麻信用总经理胡滔表示。</p><p><br/></p>','全国首个智慧住房租赁平台启用',0,2,'2017-11-01 13:49:46','2017-11-01 13:50:22','全国首个智慧住房租赁平台启用','/index.php?r=mobile/default/index&id=24&cateid=0');
/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atlas`
--

DROP TABLE IF EXISTS `atlas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atlas` (
  `Id` int(11) NOT NULL,
  `Thumb` varchar(550) DEFAULT NULL,
  `CreateTime` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atlas`
--

LOCK TABLES `atlas` WRITE;
/*!40000 ALTER TABLE `atlas` DISABLE KEYS */;
/*!40000 ALTER TABLE `atlas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('ad/create','3',1501924238),('ad/create','8',1508142749),('ad/create','9',1508143214),('ad/delete','3',1501924274),('ad/delete','8',1508142773),('ad/delete','9',1508143228),('ad/index','3',1501924220),('ad/index','8',1508142793),('ad/index','9',1508143240),('ad/update','3',1501924263),('ad/update','8',1508142818),('ad/update','9',1508143255),('ad/view','3',1501924251),('ad/view','8',1508142833),('ad/view','9',1508143268),('adcate/create','3',1501924493),('adcate/create','8',1508142849),('adcate/create','9',1508143322),('adcate/delete','3',1501924503),('adcate/delete','8',1508142861),('adcate/delete','9',1508143340),('adcate/index','3',1501924469),('adcate/index','8',1508142876),('adcate/index','9',1508143353),('adcate/update','3',1501924498),('adcate/update','8',1508142890),('adcate/update','9',1508143372),('adcate/view','3',1501924482),('adcate/view','8',1508142904),('adcate/view','9',1508143393),('admin/create','3',1501743655),('admin/create','9',1508143405),('admin/delete','3',1501743647),('admin/index','3',1501743616),('admin/post','3',1501743660),('admin/update','3',1501743665),('admin/view','3',1501743670),('article/create','3',1501841601),('article/create','8',1508142936),('article/create','9',1508143426),('article/delete','3',1501841638),('article/delete','8',1508142951),('article/delete','9',1508143438),('article/index','3',1501841565),('article/index','8',1508142974),('article/index','9',1508143452),('article/update','3',1501841617),('article/update','8',1508142991),('article/update','9',1508143466),('article/view','3',1501841585),('article/view','8',1508143009),('article/view','9',1508143479),('category/create','3',1501833910),('category/create','8',1508143023),('category/create','9',1508143496),('category/delete','3',1501833944),('category/delete','8',1508143038),('category/delete','9',1508143513),('category/index','3',1501833857),('category/index','8',1508143054),('category/index','9',1508143525),('category/update','3',1501833929),('category/update','8',1508143070),('category/update','9',1508143537),('category/view','3',1501833891),('category/view','8',1508143085),('category/view','9',1508143562),('default/index','3',1501834290),('default/index','8',1508143101),('default/index','9',1508143576),('proerynotice/create','3',1501923803),('proerynotice/create','8',1508143119),('proerynotice/create','9',1508143588),('proerynotice/delete','3',1501923838),('proerynotice/delete','8',1508143133),('proerynotice/delete','9',1508143598),('proerynotice/index','3',1501923743),('proerynotice/index','8',1508143149),('proerynotice/index','9',1508143611),('proerynotice/update','3',1501923820),('proerynotice/update','8',1508143161),('proerynotice/update','9',1508143627),('proerynotice/view','3',1501923787),('proerynotice/view','8',1508143176),('proerynotice/view','9',1508143635),('系统管理员','3',1501743708),('资产运营编辑','8',1508142683),('资产运营编辑','9',1508142686);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('ad/create',2,'创建了ad/create许可',NULL,NULL,1501924023,1501924023),('ad/delete',2,'创建了ad/delete许可',NULL,NULL,1501924053,1501924053),('ad/index',2,'创建了ad/index许可',NULL,NULL,1501923980,1501923980),('ad/update',2,'创建了ad/update许可',NULL,NULL,1501924037,1501924037),('ad/view',2,'创建了ad/view许可',NULL,NULL,1501924006,1501924006),('adcate/create',2,'创建了adcate/create许可',NULL,NULL,1501924348,1501924348),('adcate/delete',2,'创建了adcate/delete许可',NULL,NULL,1501924356,1501924356),('adcate/index',2,'创建了adcate/index许可',NULL,NULL,1501924314,1501924314),('adcate/update',2,'创建了adcate/update许可',NULL,NULL,1501924352,1501924352),('adcate/view',2,'创建了adcate/view许可',NULL,NULL,1501924343,1501924343),('admin/create',2,'创建了admin/create许可',NULL,NULL,1501743319,1501743319),('admin/delete',2,'创建了admin/delete许可',NULL,NULL,1501743356,1501743356),('admin/index',2,'创建了admin/index许可',NULL,NULL,1501743296,1501743296),('admin/post',2,'创建了admin/post许可',NULL,NULL,1501743262,1501743262),('admin/update',2,'创建了admin/update许可',NULL,NULL,1501743338,1501743338),('admin/view',2,'创建了admin/view许可',NULL,NULL,1501743311,1501743311),('article/create',2,'创建了article/create许可',NULL,NULL,1501841301,1501841301),('article/delete',2,'创建了article/delete许可',NULL,NULL,1501841335,1501841335),('article/index',2,'创建了article/index许可',NULL,NULL,1501841265,1501841265),('article/update',2,'创建了article/update许可',NULL,NULL,1501841316,1501841316),('article/view',2,'创建了article/view许可',NULL,NULL,1501841284,1501841284),('category/create',2,'创建了category/create许可',NULL,NULL,1501833474,1501833474),('category/delete',2,'创建了category/delete许可',NULL,NULL,1501833550,1501833550),('category/index',2,'创建了category/index许可',NULL,NULL,1501833430,1501833430),('category/update',2,'创建了category/update许可',NULL,NULL,1501833520,1501833520),('category/view',2,'创建了category/view许可',NULL,NULL,1501833455,1501833455),('certification/index',2,'创建了certification/index许可',NULL,NULL,1508141384,1508141384),('certification/view',2,'创建了certification/view许可',NULL,NULL,1508141472,1508141472),('default/index',2,'创建了default/index许可',NULL,NULL,1501834169,1501834169),('proerynotice/create',2,'创建了proerynotice/create许可',NULL,NULL,1501923482,1501923482),('proerynotice/delete',2,'创建了proerynotice/delete许可',NULL,NULL,1501923519,1501923519),('proerynotice/index',2,'创建了proerynotice/index许可',NULL,NULL,1501923436,1501923436),('proerynotice/update',2,'创建了proerynotice/update许可',NULL,NULL,1501923502,1501923502),('proerynotice/view',2,'创建了proerynotice/view许可',NULL,NULL,1501923459,1501923459),('客服主管',1,'创建了客服主管角色',NULL,NULL,1501743155,1501743155),('系统管理员',1,'创建了系统管理员角色',NULL,NULL,1501742970,1501742970),('维修主管',1,'创建了维修主管角色',NULL,NULL,1501743198,1501743198),('资产运营编辑',2,'创建了资产运营编辑许可',NULL,NULL,1508141511,1508141511),('项目负责人',1,'创建了项目负责人角色',NULL,NULL,1501743141,1501743141);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('系统管理员','ad/create'),('资产运营编辑','ad/create'),('系统管理员','ad/delete'),('资产运营编辑','ad/delete'),('系统管理员','ad/index'),('资产运营编辑','ad/index'),('系统管理员','ad/update'),('资产运营编辑','ad/update'),('系统管理员','ad/view'),('资产运营编辑','ad/view'),('系统管理员','adcate/create'),('资产运营编辑','adcate/create'),('系统管理员','adcate/delete'),('资产运营编辑','adcate/delete'),('系统管理员','adcate/index'),('资产运营编辑','adcate/index'),('系统管理员','adcate/update'),('资产运营编辑','adcate/update'),('系统管理员','adcate/view'),('系统管理员','admin/create'),('系统管理员','admin/delete'),('系统管理员','admin/index'),('系统管理员','admin/post'),('系统管理员','admin/update'),('系统管理员','admin/view'),('系统管理员','article/create'),('资产运营编辑','article/create'),('系统管理员','article/delete'),('资产运营编辑','article/delete'),('系统管理员','article/index'),('资产运营编辑','article/index'),('系统管理员','article/update'),('资产运营编辑','article/update'),('系统管理员','article/view'),('资产运营编辑','article/view'),('系统管理员','category/create'),('资产运营编辑','category/create'),('系统管理员','category/delete'),('资产运营编辑','category/delete'),('系统管理员','category/index'),('资产运营编辑','category/index'),('系统管理员','category/update'),('资产运营编辑','category/update'),('系统管理员','category/view'),('资产运营编辑','category/view'),('系统管理员','default/index'),('资产运营编辑','default/index'),('系统管理员','proerynotice/create'),('资产运营编辑','proerynotice/create'),('系统管理员','proerynotice/delete'),('资产运营编辑','proerynotice/delete'),('系统管理员','proerynotice/index'),('资产运营编辑','proerynotice/index'),('系统管理员','proerynotice/update'),('资产运营编辑','proerynotice/update'),('系统管理员','proerynotice/view'),('资产运营编辑','proerynotice/view');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `categoryId` tinyint(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(20) DEFAULT NULL,
  `parentId` tinyint(11) DEFAULT '0' COMMENT '父级节点',
  `createTime` varchar(50) DEFAULT NULL,
  `updateTime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'企业资讯',0,'1501915813','1501915813'),(5,'测试类',1,'1501833095','1501833095');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certification`
--

DROP TABLE IF EXISTS `certification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `certification` (
  `CertificationId` tinyint(11) NOT NULL AUTO_INCREMENT COMMENT '实名认证Id',
  `UserId` tinyint(11) DEFAULT NULL COMMENT '用户ID',
  `HouseId` int(11) DEFAULT NULL COMMENT '楼盘ID',
  `SeatId` int(11) DEFAULT NULL COMMENT '座号ID',
  `roomId` int(11) DEFAULT NULL COMMENT '房间号',
  `Address` varchar(255) DEFAULT NULL COMMENT '详细地址',
  `Company` varchar(255) DEFAULT NULL COMMENT '公司名称',
  `Department` varchar(255) DEFAULT NULL COMMENT '部门',
  `Position` varchar(255) DEFAULT NULL,
  `Maintenancetype` tinyint(11) DEFAULT NULL,
  `CreateTime` varchar(255) DEFAULT NULL COMMENT '添加时间',
  `UpdateTime` varchar(255) DEFAULT NULL COMMENT '更新时间',
  `Status` tinyint(255) DEFAULT '1' COMMENT '1.代表开始实名认证，2.审核信息 3.实名认证结束 4.实名认证失败',
  `CateId` int(11) DEFAULT NULL,
  PRIMARY KEY (`CertificationId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certification`
--

LOCK TABLES `certification` WRITE;
/*!40000 ALTER TABLE `certification` DISABLE KEYS */;
INSERT INTO `certification` VALUES (1,34,1,9,11,'航海路未来路交叉口正商国际广场B座四楼408室','叁叁零六科技有限公司',NULL,NULL,1,'2017-09-19 17:21:05','2017-09-19 17:21:05',1,1),(2,34,2,10,12,'商都路十里铺','叁叁零六科技有限公司',NULL,NULL,1,'2017-09-19 17:21:05','2017-09-19 17:21:05',1,1),(3,44,1,9,11,'航海路未来路交叉口正商国际广场B座四楼408室','叁叁零六科技有限公司','维修部','钳工',1,'2017-09-19 17:21:05','2017-09-19 17:21:05',1,3),(4,44,2,10,12,'测试','测试','维修部','维修部',1,NULL,NULL,1,3);
/*!40000 ALTER TABLE `certification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `city`
--

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;
INSERT INTO `city` VALUES (1,'郑州'),(7,'武汉'),(8,'长沙');
/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commont`
--

DROP TABLE IF EXISTS `commont`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commont` (
  `commontId` tinyint(11) NOT NULL AUTO_INCREMENT,
  `articleId` tinyint(11) DEFAULT NULL,
  `userId` tinyint(11) DEFAULT NULL,
  `content` varchar(50) DEFAULT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `headImg` varchar(500) DEFAULT NULL,
  `stars` tinyint(11) DEFAULT '0',
  `status` tinyint(11) DEFAULT '0',
  `createTime` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`commontId`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commont`
--

LOCK TABLES `commont` WRITE;
/*!40000 ALTER TABLE `commont` DISABLE KEYS */;
INSERT INTO `commont` VALUES (1,1,1,'好小子','爱哭的小男孩','http://img1.178.com/d3bj/201502/216777646601/216778925186.jpg',NULL,0,'2017-07-20 02:47:27'),(2,1,1,'好小子','爱哭的小男孩','http://img1.178.com/d3bj/201502/216777646601/216778925186.jpg',NULL,0,'2017-07-21 00:07:27'),(3,1,1,'好小子','爱哭的小男孩','http://img1.178.com/d3bj/201502/216777646601/216778925186.jpg',NULL,0,'2017-07-21 00:16:43'),(4,1,1,'ABC','爱哭的小男孩','http://img1.178.com/d3bj/201502/216777646601/216778925186.jpg',NULL,0,'2017-07-21 00:22:36'),(8,1,NULL,'啦啦啦',NULL,NULL,NULL,0,'2017-09-04 09:42:26'),(9,1,NULL,'啦啦啦',NULL,NULL,NULL,0,'2017-09-04 09:42:28'),(10,1,NULL,'哈哈',NULL,NULL,NULL,0,'2017-09-04 09:59:50'),(11,8,NULL,'yyyyy',NULL,NULL,NULL,0,'2017-09-05 01:38:01'),(12,8,NULL,'uuuu',NULL,NULL,NULL,0,'2017-09-05 01:38:25'),(13,1,NULL,'y',NULL,NULL,NULL,0,'2017-09-05 03:06:56'),(15,1,NULL,'ggg',NULL,NULL,NULL,0,'2017-09-05 03:19:41'),(16,8,NULL,'tt',NULL,NULL,NULL,0,'2017-09-05 03:37:37'),(17,1,NULL,'uu',NULL,NULL,NULL,0,'2017-09-05 03:39:46'),(18,1,NULL,'yyy',NULL,NULL,NULL,0,'2017-09-05 06:48:19'),(19,10,NULL,'不错不错',NULL,NULL,0,0,'2017-09-18 10:48:51'),(20,1,NULL,'不错不错',NULL,NULL,0,0,'2017-09-18 15:08:34'),(21,24,NULL,'很好',NULL,NULL,0,0,'2017-11-02 20:20:43'),(22,24,NULL,'很好',NULL,NULL,0,0,'2017-11-02 20:21:09'),(23,22,NULL,'19大',NULL,NULL,0,0,'2017-11-02 22:21:42'),(24,23,NULL,'这个房子不错',NULL,NULL,0,0,'2017-11-02 22:46:20'),(25,24,NULL,'是的 ',NULL,NULL,0,0,'2017-11-03 13:59:39'),(26,24,NULL,'很棒',NULL,NULL,0,0,'2017-11-03 14:01:12'),(27,24,NULL,'真的是这样',NULL,NULL,0,0,'2017-11-03 14:12:23'),(28,24,NULL,'楼上说的对',NULL,NULL,0,0,'2017-11-03 14:15:29'),(29,24,NULL,'有道理',NULL,NULL,0,0,'2017-11-03 16:23:09'),(30,24,NULL,'有道理',NULL,NULL,0,0,'2017-11-03 16:23:10'),(31,24,NULL,'有道理',NULL,NULL,0,0,'2017-11-03 16:23:10'),(32,24,NULL,'有道理',NULL,NULL,0,0,'2017-11-03 16:23:17'),(33,24,NULL,'有道理',NULL,NULL,0,0,'2017-11-03 16:23:19'),(34,23,NULL,'确实不错',NULL,NULL,0,0,'2017-11-03 16:39:47');
/*!40000 ALTER TABLE `commont` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comter`
--

DROP TABLE IF EXISTS `comter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comter` (
  `comterId` tinyint(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`comterId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comter`
--

LOCK TABLES `comter` WRITE;
/*!40000 ALTER TABLE `comter` DISABLE KEYS */;
/*!40000 ALTER TABLE `comter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dispatch`
--

DROP TABLE IF EXISTS `dispatch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dispatch` (
  `dispatchId` tinyint(11) NOT NULL AUTO_INCREMENT,
  `userId` tinyint(11) DEFAULT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `orderInfo` varchar(150) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `dispatchTime` varchar(200) DEFAULT NULL,
  `comterId` tinyint(11) DEFAULT NULL,
  PRIMARY KEY (`dispatchId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dispatch`
--

LOCK TABLES `dispatch` WRITE;
/*!40000 ALTER TABLE `dispatch` DISABLE KEYS */;
/*!40000 ALTER TABLE `dispatch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `house`
--

DROP TABLE IF EXISTS `house`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentId` int(11) DEFAULT '0',
  `housename` varchar(20) DEFAULT NULL,
  `cityid` int(11) DEFAULT NULL,
  `createtime` varchar(200) DEFAULT NULL,
  `updatetime` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `house`
--

LOCK TABLES `house` WRITE;
/*!40000 ALTER TABLE `house` DISABLE KEYS */;
INSERT INTO `house` VALUES (1,0,'正商国际广场',1,NULL,NULL),(2,0,'正商建正东方中心',1,NULL,NULL),(3,0,'正商向阳广场',1,NULL,NULL),(4,0,'正商学府广场',1,NULL,NULL),(6,0,'正商蓝海广场',1,NULL,NULL),(7,0,'正商航海广场',1,NULL,NULL),(8,0,'正商和谐广场',1,NULL,NULL),(9,1,'A座',1,NULL,NULL),(10,2,'B座',1,NULL,NULL),(11,9,'407',1,NULL,NULL),(12,10,'508',1,NULL,NULL);
/*!40000 ALTER TABLE `house` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `idcard`
--

DROP TABLE IF EXISTS `idcard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `idcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thumb` varchar(255) DEFAULT NULL,
  `createTime` varchar(110) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `idcard`
--

LOCK TABLES `idcard` WRITE;
/*!40000 ALTER TABLE `idcard` DISABLE KEYS */;
INSERT INTO `idcard` VALUES (1,'./uploads/Card/IMG_20170915_165743.jpg','2017-09-15 16:57:51'),(2,'./uploads/Card/IMG_20170915_165743.jpg','2017-09-15 17:01:07'),(3,'./uploads/Card/IMG_20170915_165743.jpg','2017-09-15 17:04:22'),(4,'./uploads/Card/IMG_20170915_165743.jpg','2017-09-15 17:08:13'),(5,'./uploads/Card/IMG_20170915_165743.jpg','2017-09-15 17:08:20'),(6,'./uploads/Card/IMG_20170915_165743.jpg','2017-09-15 17:08:46'),(7,'./uploads/Card/IMG_20170915_165743.jpg','2017-09-15 17:09:02'),(8,'./uploads/Card/IMG_20170915_173829.jpg','2017-09-15 17:38:37'),(9,'./uploads/Card/IMG_20170915_173829.jpg','2017-09-15 17:40:18'),(10,'./uploads/Card/IMG_20170915_173829.jpg','2017-09-15 17:52:16'),(11,'./uploads/Card/IMG_20170915_175851.jpg','2017-09-15 17:58:59'),(12,'./uploads/Card/IMG_20170925_090401.jpg','2017-09-25 09:04:09'),(13,'./uploads/Card/IMG_20170925_090401.jpg','2017-09-25 09:04:47'),(14,'./uploads/Card/IMG_20170925_092833.jpg','2017-09-25 09:28:38'),(15,'./uploads/Card/IMG_20170925_092833.jpg','2017-09-25 09:29:18'),(16,'./uploads/Card/IMG_20170926_105944.jpg','2017-09-26 10:59:54'),(17,'./uploads/Card/IMG_20170926_105944.jpg','2017-09-26 10:59:57'),(18,'./uploads/Card/IMG_20170926_105944.jpg','2017-09-26 10:59:59'),(19,'./uploads/Card/IMG_20170926_105944.jpg','2017-09-26 11:00:00'),(20,'./uploads/Card/IMG_20170926_105944.jpg','2017-09-26 11:00:01'),(21,'./uploads/Card/IMG_20170926_105944.jpg','2017-09-26 11:00:02'),(22,'./uploads/Card/IMG_20170926_105944.jpg','2017-09-26 11:00:04'),(23,' /uploads/Card/IMG_20171107_104916 jpg','2017-11-07 10:49:24');
/*!40000 ALTER TABLE `idcard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `idcardover`
--

DROP TABLE IF EXISTS `idcardover`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `idcardover` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thumb` varchar(255) DEFAULT NULL,
  `createTime` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `idcardover`
--

LOCK TABLES `idcardover` WRITE;
/*!40000 ALTER TABLE `idcardover` DISABLE KEYS */;
INSERT INTO `idcardover` VALUES (1,'./uploads/Card/IMG_20170915_165736.jpg','2017-09-15 16:57:51'),(2,'./uploads/Card/IMG_20170915_165736.jpg','2017-09-15 17:01:07'),(3,'./uploads/Card/IMG_20170915_165736.jpg','2017-09-15 17:04:22'),(4,'./uploads/Card/IMG_20170915_165736.jpg','2017-09-15 17:08:13'),(5,'./uploads/Card/IMG_20170915_165736.jpg','2017-09-15 17:08:20'),(6,'./uploads/Card/IMG_20170915_165736.jpg','2017-09-15 17:08:46'),(7,'./uploads/Card/IMG_20170915_165736.jpg','2017-09-15 17:09:02'),(8,'./uploads/Card/IMG_20170915_173833.jpg','2017-09-15 17:38:37'),(9,'./uploads/Card/IMG_20170915_173833.jpg','2017-09-15 17:40:18'),(10,'./uploads/Card/IMG_20170915_173833.jpg','2017-09-15 17:52:16'),(11,'./uploads/Card/IMG_20170915_175855.jpg','2017-09-15 17:59:00'),(12,'./uploads/Card/IMG_20170925_090405.jpg','2017-09-25 09:04:09'),(13,'./uploads/Card/IMG_20170925_090405.jpg','2017-09-25 09:04:47'),(14,'./uploads/Card/IMG_20170925_092836.jpg','2017-09-25 09:28:38'),(15,'./uploads/Card/IMG_20170925_092836.jpg','2017-09-25 09:29:18'),(16,'./uploads/Card/IMG_20170926_105953.jpg','2017-09-26 10:59:54'),(17,'./uploads/Card/IMG_20170926_105953.jpg','2017-09-26 10:59:57'),(18,'./uploads/Card/IMG_20170926_105953.jpg','2017-09-26 10:59:59'),(19,'./uploads/Card/IMG_20170926_105953.jpg','2017-09-26 11:00:00'),(20,'./uploads/Card/IMG_20170926_105953.jpg','2017-09-26 11:00:01'),(21,'./uploads/Card/IMG_20170926_105953.jpg','2017-09-26 11:00:02'),(22,'./uploads/Card/IMG_20170926_105953.jpg','2017-09-26 11:00:04'),(23,' /uploads/Card/IMG_20171107_104922 jpg','2017-11-07 10:49:24');
/*!40000 ALTER TABLE `idcardover` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `like`
--

DROP TABLE IF EXISTS `like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `like` (
  `likeId` tinyint(11) NOT NULL AUTO_INCREMENT COMMENT '点赞的自增数',
  `status` tinyint(11) DEFAULT '1' COMMENT '1（点赞）2.（取消点赞）',
  `voteTime` varchar(100) DEFAULT NULL COMMENT '点赞时间',
  `articleId` tinyint(11) DEFAULT NULL COMMENT '文章对应的ID',
  `userId` tinyint(11) DEFAULT NULL COMMENT '用户ID',
  PRIMARY KEY (`likeId`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `like`
--

LOCK TABLES `like` WRITE;
/*!40000 ALTER TABLE `like` DISABLE KEYS */;
INSERT INTO `like` VALUES (1,2,'2017-09-04 07:36:18',1,7),(2,1,'2017-09-04 07:40:57',1,7),(3,2,'2017-09-05 06:35:19',1,NULL),(4,2,'2017-09-05 06:47:59',1,NULL),(5,2,'2017-09-05 06:48:08',1,NULL),(6,2,'2017-09-06 17:19:57',10,NULL),(7,2,'2017-09-06 17:25:50',10,NULL),(8,2,'2017-09-06 17:25:51',10,NULL),(9,2,'2017-09-06 17:25:53',10,NULL),(10,2,'2017-09-06 17:45:56',11,NULL),(11,2,'2017-09-06 17:45:57',11,NULL),(12,2,'2017-09-06 17:45:58',11,NULL),(13,2,'2017-09-06 17:46:00',11,NULL),(14,2,'2017-09-06 17:46:00',11,NULL),(15,2,'2017-09-06 17:46:01',11,NULL),(16,2,'2017-09-06 17:46:01',11,NULL),(17,2,'2017-09-06 17:46:01',11,NULL),(18,2,'2017-09-06 17:46:02',11,NULL),(19,2,'2017-09-06 17:46:02',11,NULL),(20,2,'2017-09-06 17:46:03',11,NULL),(21,2,'2017-09-06 17:46:04',11,NULL),(22,2,'2017-09-06 17:46:04',11,NULL),(23,2,'2017-09-06 17:46:05',11,NULL),(24,2,'2017-09-06 17:46:05',11,NULL),(25,2,'2017-09-06 17:46:05',11,NULL),(26,2,'2017-09-06 17:46:06',11,NULL),(27,2,'2017-09-06 17:46:07',11,NULL),(28,2,'2017-09-06 17:46:08',11,NULL),(29,2,'2017-09-06 17:48:25',11,NULL),(30,2,'2017-09-06 17:48:25',11,NULL),(31,2,'2017-09-06 17:48:27',11,NULL),(32,2,'2017-09-06 17:48:28',11,NULL),(33,2,'2017-09-07 20:23:36',11,NULL),(34,2,'2017-09-07 20:23:37',11,NULL),(35,2,'2017-09-08 10:16:21',1,NULL),(36,2,'2017-09-08 14:59:43',1,NULL),(37,2,'2017-09-18 10:48:21',10,NULL),(38,2,'2017-09-18 10:48:24',10,NULL),(39,2,'2017-09-18 10:48:26',10,NULL),(40,2,'2017-09-26 11:06:41',1,38),(41,2,'2017-09-26 11:06:42',1,38),(42,1,'2017-10-01 18:50:45',11,37),(43,1,'2017-10-17 17:24:03',20,39),(44,1,'2017-10-19 10:30:14',19,36),(45,1,'2017-10-19 10:30:22',18,36),(46,2,'2017-10-25 17:31:09',17,42),(47,2,'2017-10-25 17:31:11',17,42),(48,2,'2017-10-25 17:31:12',17,42),(49,2,'2017-10-25 17:31:13',17,42),(50,2,'2017-10-25 17:31:15',17,42),(51,2,'2017-10-25 17:31:16',17,42),(52,2,'2017-10-25 17:31:17',17,42),(53,1,'2017-10-25 17:31:18',17,42),(54,1,'2017-11-01 13:28:12',23,39),(55,1,'2017-11-02 14:01:05',23,42),(56,2,'2017-11-02 14:35:57',18,42),(57,2,'2017-11-02 14:36:08',18,42),(58,2,'2017-11-02 14:36:10',18,42),(59,2,'2017-11-02 14:36:10',18,42),(60,2,'2017-11-02 14:36:10',18,42),(61,2,'2017-11-02 14:36:11',18,42),(62,2,'2017-11-02 14:37:13',18,42),(63,2,'2017-11-02 14:37:13',18,42),(64,2,'2017-11-02 14:37:14',18,42),(65,2,'2017-11-02 14:37:15',18,42),(66,2,'2017-11-02 14:37:15',18,42),(67,2,'2017-11-02 15:32:16',21,42),(68,2,'2017-11-02 15:32:18',21,42),(69,2,'2017-11-02 15:32:28',21,42),(70,2,'2017-11-03 14:27:59',24,NULL),(71,2,'2017-11-03 14:28:32',24,NULL),(72,2,'2017-11-03 14:28:35',24,NULL),(73,1,'2017-11-03 14:41:58',24,NULL);
/*!40000 ALTER TABLE `like` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `maintenancetype`
--

DROP TABLE IF EXISTS `maintenancetype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maintenancetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `housename` varchar(500) DEFAULT NULL,
  `parentId` int(11) DEFAULT NULL,
  `createtime` varchar(200) DEFAULT NULL,
  `updatetime` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maintenancetype`
--

LOCK TABLES `maintenancetype` WRITE;
/*!40000 ALTER TABLE `maintenancetype` DISABLE KEYS */;
INSERT INTO `maintenancetype` VALUES (1,'维修灯具',0,'2017-11-02 18:24',NULL);
/*!40000 ALTER TABLE `maintenancetype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1501661877),('m140506_102106_rbac_init',1501661880);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `o2o_type`
--

DROP TABLE IF EXISTS `o2o_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `o2o_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(20) NOT NULL DEFAULT '',
  `type_img` varchar(200) NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT '0',
  `level` tinyint(4) NOT NULL DEFAULT '1',
  `state` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `o2o_type`
--

LOCK TABLES `o2o_type` WRITE;
/*!40000 ALTER TABLE `o2o_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `o2o_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `Id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单自增ID',
  `OrderId` varchar(255) DEFAULT NULL COMMENT '订单号ID',
  `UserId` int(11) DEFAULT NULL COMMENT '用户ID',
  `HouseId` int(11) DEFAULT NULL COMMENT '楼盘ID',
  `SeatId` int(11) DEFAULT NULL COMMENT '座号ID',
  `RoomId` int(11) DEFAULT NULL COMMENT '房间号ID',
  `Address` varchar(255) DEFAULT NULL COMMENT '地址',
  `Company` varchar(255) DEFAULT NULL COMMENT '公司名称',
  `Title` varchar(50) DEFAULT NULL COMMENT '报检保修标题',
  `Content` varchar(255) DEFAULT NULL COMMENT '问题描述',
  `OrderTime` varchar(255) DEFAULT NULL COMMENT '生成订单时间',
  `PublishTime` varchar(255) DEFAULT NULL COMMENT '开始时间',
  `EndTime` varchar(255) DEFAULT NULL COMMENT '结束时间',
  `Persion` varchar(255) DEFAULT NULL COMMENT '联系人',
  `Number` varchar(255) DEFAULT NULL COMMENT '联系人电话',
  `Tumb` varchar(255) DEFAULT NULL COMMENT '图片多路径',
  `Status` tinyint(4) DEFAULT NULL COMMENT '状态（0.展示全部  1.申请中 2.处理 3.订单结束）',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,'2017110281394',34,1,9,11,'未来路航海路交叉口正商国际广场','个人或者不填','漏水了','地库漏水了，可以养鱼了！','2017-11-04 17:18:16','2017-11-02 17:17:20',NULL,'小可爱','15527559952','dddd',1);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_item`
--

DROP TABLE IF EXISTS `order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `orderno` varchar(255) DEFAULT NULL,
  `createtime` varchar(255) DEFAULT NULL,
  `endtime` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_item`
--

LOCK TABLES `order_item` WRITE;
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `other`
--

DROP TABLE IF EXISTS `other`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `other` (
  `otherId` tinyint(11) NOT NULL AUTO_INCREMENT,
  `commontId` tinyint(11) DEFAULT NULL,
  `status` tinyint(11) DEFAULT NULL,
  `voteTime` varchar(225) DEFAULT NULL,
  PRIMARY KEY (`otherId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `other`
--

LOCK TABLES `other` WRITE;
/*!40000 ALTER TABLE `other` DISABLE KEYS */;
/*!40000 ALTER TABLE `other` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `propertynotice`
--

DROP TABLE IF EXISTS `propertynotice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `propertynotice` (
  `pNoticeId` tinyint(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  `author` varchar(60) DEFAULT NULL,
  `content` longtext,
  `createTime` varchar(100) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `cateId` int(11) DEFAULT NULL,
  PRIMARY KEY (`pNoticeId`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propertynotice`
--

LOCK TABLES `propertynotice` WRITE;
/*!40000 ALTER TABLE `propertynotice` DISABLE KEYS */;
INSERT INTO `propertynotice` VALUES (1,'关于建正东方中心停电的通知','建正东方中心——物业服务中心','今天停水','2017-07-22','http://www.xingyewuye.com/Public/Home/xingye/images/logo.png',1),(2,'关于正商国际广场空调使用的温馨提示','正商国际广场——物业服务中心','空调使用','2017-07-22','http://www.xingyewuye.com/Public/Home/xingye/images/logo.png',1),(3,'关于航海广场停水的通知','正商航海广场——物业服务中心','今天航海广场停水的通知','2017-07-22','http://www.xingyewuye.com/Public/Home/xingye/images/logo.png',1),(4,'关于规范蓝海广场货梯使用的通知','正商蓝海广场——物业服务中心','关于规范蓝海广场货梯使用的通知','2017-07-22','http://www.xingyewuye.com/Public/Home/xingye/images/logo.png',1),(5,'关于暴雨防范的温馨提示','正商蓝海广场——物业服务中心','关于暴雨防范的温馨提示','2017-07-22','http://www.xingyewuye.com/Public/Home/xingye/images/logo.png',1);
/*!40000 ALTER TABLE `propertynotice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seat`
--

DROP TABLE IF EXISTS `seat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seat`
--

LOCK TABLES `seat` WRITE;
/*!40000 ALTER TABLE `seat` DISABLE KEYS */;
INSERT INTO `seat` VALUES (1,'A座'),(2,'B座'),(3,'C座'),(4,'D座'),(5,'E座'),(6,'F座');
/*!40000 ALTER TABLE `seat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suggestion`
--

DROP TABLE IF EXISTS `suggestion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suggestion` (
  `suggestionId` tinyint(11) NOT NULL AUTO_INCREMENT,
  `userId` tinyint(11) DEFAULT NULL,
  `suggestionContent` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`suggestionId`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suggestion`
--

LOCK TABLES `suggestion` WRITE;
/*!40000 ALTER TABLE `suggestion` DISABLE KEYS */;
INSERT INTO `suggestion` VALUES (1,1,'测试下！'),(2,18,'测试数据！'),(3,NULL,'wqwqwqwq'),(4,NULL,'yhhbn'),(5,NULL,'123'),(6,NULL,'bbbbbbh'),(7,NULL,'我建议周一可以邀约用户一起升国旗。'),(8,NULL,'hjj'),(9,NULL,'把'),(10,NULL,'德'),(11,NULL,'考虑考虑'),(12,NULL,'测试////'),(13,42,'测试一下'),(14,NULL,'Assets ');
/*!40000 ALTER TABLE `suggestion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `Tell` varchar(15) DEFAULT NULL COMMENT '手机号',
  `PassWord` varchar(100) DEFAULT NULL COMMENT '密码',
  `CreateTime` varchar(50) DEFAULT NULL COMMENT '添加时间',
  `UpdateTime` varchar(50) DEFAULT NULL COMMENT '更新时间',
  `LoginTime` varchar(50) DEFAULT NULL,
  `HeaderImg` varchar(225) DEFAULT NULL COMMENT '头像',
  `NickName` varchar(30) DEFAULT NULL,
  `Email` varchar(60) DEFAULT NULL,
  `TrueName` varchar(30) DEFAULT NULL,
  `HouseId` int(11) DEFAULT NULL COMMENT '楼盘',
  `Seat` tinyint(11) DEFAULT NULL COMMENT 'A座B座',
  `Address` varchar(30) DEFAULT NULL,
  `IdCard` varchar(255) DEFAULT NULL,
  `IdCardOver` varchar(255) DEFAULT NULL,
  `WorkCard` varchar(255) DEFAULT NULL,
  `Company` varchar(255) DEFAULT NULL,
  `Status` tinyint(11) DEFAULT '1' COMMENT '1代表实名认证，2.代表实名认证成功',
  `Cases` tinyint(11) DEFAULT NULL COMMENT '所属项目',
  `Department` varchar(255) DEFAULT NULL COMMENT '部门',
  `Position` varchar(255) DEFAULT NULL COMMENT '职位',
  `Maintenancetype` tinyint(4) DEFAULT NULL COMMENT '维修类型',
  `CateId` tinyint(4) DEFAULT '1' COMMENT '1.业主 2.员工 3.工程师傅',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (29,'13937643257','d9b1d7db4cd6e70935368a1efb10e377','2017-09-19 17:21:05',NULL,'2017-09-25 08:31:30','/uploads/head/IMG_20170921_172641.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(34,'17073577408','14e1b600b1fd579f47433b88e8d85291','2017-09-22 14:11:59',NULL,'2017-10-05 15:13:48',NULL,'像雾像风又像雨',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(36,'18810971428','d9b1d7db4cd6e70935368a1efb10e377','2017-09-25 08:05:37',NULL,'2017-11-07 14:30:48',NULL,'哈哈',NULL,'石高洁',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(35,'18538187569','14e1b600b1fd579f47433b88e8d85291','2017-09-22 14:37:48',NULL,'2017-09-22 14:37:48',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(37,'13837156894','21d5c37426ecddb8d13eafb62bf28847','2017-09-25 09:00:30','2017-09-25 09:29:18','2017-11-06 14:09:43','/uploads/head/IMG_20170925_093005.jpg','jingyn',NULL,'荆文君',1,2,'408','./uploads/Card/IMG_20170925_092833.jpg','./uploads/Card/IMG_20170925_092836.jpg','./uploads/WorkCard/IMG_20170925_092829.jpg','河南一二三科技有限公司',2,NULL,NULL,NULL,NULL,NULL),(38,'18638018998','14e1b600b1fd579f47433b88e8d85291','2017-09-26 09:23:51',NULL,'2017-09-26 09:23:51',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(39,'13140012057','151946fe014e7bd6a787d4f5c2d8cedf','2017-09-26 16:36:35',NULL,'2017-11-01 10:03:01','/uploads/head/IMG_20171101_100428.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(40,'15736739394','70873e8580c9900986939611618d7b1e','2017-10-19 11:00:33',NULL,'2017-10-19 11:57:21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(41,'13834068748','14e1b600b1fd579f47433b88e8d85291','2017-10-19 11:13:22',NULL,'2017-10-19 11:21:14',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL),(42,'17788116676','14e1b600b1fd579f47433b88e8d85291','2017-10-30 15:37:58',NULL,'2017-11-06 08:03:41','/uploads/head/IMG_20171101_100832.jpg','try',NULL,'ABC',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,1),(43,'15137132835','3e4739824d2f0f893921758ad6591801','2017-10-30 15:40:00',NULL,'2017-10-30 15:40:00',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,1),(44,'15527559952','3e4739824d2f0f893921758ad6591801','2017-10-30 15:40:00',NULL,NULL,'/uploads/head/IMG_20171101_100832.jpg','try',NULL,'ABC',NULL,NULL,NULL,'./uploads/Card/IMG_20170925_092833.jpg','./uploads/Card/IMG_20170925_092833.jpg','./uploads/Card/IMG_20170925_092833.jpg',NULL,1,NULL,NULL,NULL,NULL,1),(45,'18300612124','14e1b600b1fd579f47433b88e8d85291','2017-11-04 15:11:03',NULL,'2017-11-04 20:10:08',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usercate`
--

DROP TABLE IF EXISTS `usercate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usercate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `parentid` int(11) DEFAULT '0',
  `cratetime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usercate`
--

LOCK TABLES `usercate` WRITE;
/*!40000 ALTER TABLE `usercate` DISABLE KEYS */;
INSERT INTO `usercate` VALUES (1,'业主',0,'2017-10-12 09:01:18',NULL),(2,'员工',0,'2017-10-12 09:02:25',NULL),(3,'维修师傅',0,'2017-10-12 09:03:55',NULL);
/*!40000 ALTER TABLE `usercate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `version_upgrade`
--

DROP TABLE IF EXISTS `version_upgrade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `version_upgrade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` varchar(11) DEFAULT NULL COMMENT '客户端id',
  `version_code` varchar(11) DEFAULT NULL COMMENT '版本号',
  `type` tinyint(1) DEFAULT NULL COMMENT '1升级，0不升级，2强制升级',
  `apk_url` varchar(255) DEFAULT NULL,
  `upgrade_point` varchar(255) DEFAULT NULL COMMENT '升级提示',
  `status` tinyint(2) DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `version_upgrade`
--

LOCK TABLES `version_upgrade` WRITE;
/*!40000 ALTER TABLE `version_upgrade` DISABLE KEYS */;
INSERT INTO `version_upgrade` VALUES (2,'2','1.6',1,'http://106.15.127.161/uploads/app_v1.0_360.apk.1','有新功能了，快来更新',1,NULL,NULL),(5,'2','2.5',1,'http://106.15.127.161/uploads/app_v1.0_360.apk.1','我不想下载',1,NULL,NULL),(9,'2','2.5',0,'http://106.15.127.161/uploads/app_v1.0_360.apk.1','哥我不想下载了',1,NULL,NULL),(10,'2','2.5',2,'http://106.15.127.161/uploads/app_v1.0_360.apk.1','强制升级',1,NULL,NULL);
/*!40000 ALTER TABLE `version_upgrade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workcard`
--

DROP TABLE IF EXISTS `workcard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thumb` varchar(225) DEFAULT NULL,
  `createTime` varchar(110) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workcard`
--

LOCK TABLES `workcard` WRITE;
/*!40000 ALTER TABLE `workcard` DISABLE KEYS */;
INSERT INTO `workcard` VALUES (1,'./uploads/WorkCard/IMG_20170915_175848.jpg','2017-09-15 17:58:59'),(2,'./uploads/WorkCard/IMG_20170925_090347.jpg','2017-09-25 09:04:09'),(3,'./uploads/WorkCard/IMG_20170925_090347.jpg','2017-09-25 09:04:47'),(4,'./uploads/WorkCard/IMG_20170925_092829.jpg','2017-09-25 09:28:38'),(5,'./uploads/WorkCard/IMG_20170925_092829.jpg','2017-09-25 09:29:18');
/*!40000 ALTER TABLE `workcard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wy_order`
--

DROP TABLE IF EXISTS `wy_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wy_order` (
  `wyorderId` tinyint(11) NOT NULL AUTO_INCREMENT,
  `houseId` tinyint(11) DEFAULT '0' COMMENT '楼盘ID',
  `userId` tinyint(11) DEFAULT NULL COMMENT '用户ID',
  `userName` varchar(50) DEFAULT NULL COMMENT '用户名称',
  `Address` varchar(255) DEFAULT NULL COMMENT '地址',
  `content` varchar(130) DEFAULT NULL COMMENT '内容',
  `thumb` varchar(255) DEFAULT NULL COMMENT '图片路径',
  `orderTime` varchar(150) DEFAULT NULL COMMENT '添加时间',
  `ContactPersion` varchar(60) DEFAULT NULL,
  `ContactNumber` varchar(50) DEFAULT NULL,
  `status` tinyint(11) DEFAULT '1' COMMENT '1 申请中 2 处理 3 订单结束',
  PRIMARY KEY (`wyorderId`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wy_order`
--

LOCK TABLES `wy_order` WRITE;
/*!40000 ALTER TABLE `wy_order` DISABLE KEYS */;
INSERT INTO `wy_order` VALUES (5,1,2,NULL,'2222222222','22222222',NULL,'2017-09-12 10:49:41','3333333333','22222222',1),(6,0,22,'你好','y','j',NULL,'2017-09-12 11:08:02','to','13696356369',1),(10,2,36,NULL,'啊啊啊','啊啊啊',NULL,'2017-09-25 10:26:41','石','18810971428',1),(9,3,36,NULL,'阿','阿',NULL,'2017-09-25 10:25:37','呵呵','18810971428',1),(11,1,38,NULL,'407','啦咯啦咯啦咯',NULL,'2017-09-26 10:42:17','李然','15137132835',1),(12,2,39,NULL,'吧','了解了解',NULL,'2017-11-01 10:04:16','是','18810971428',1);
/*!40000 ALTER TABLE `wy_order` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-07 14:31:08

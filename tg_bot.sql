-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2021-06-21 23:33:40
-- 服务器版本： 5.5.62-log
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pay_azhe_live`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `token` varchar(255) DEFAULT NULL COMMENT 'telegram 令牌',
  `id` int(10) NOT NULL COMMENT '主键ID',
  `password` varchar(126) NOT NULL COMMENT '密码',
  `name` varchar(64) NOT NULL,
  `tg_name` varchar(255) NOT NULL COMMENT 'telegram用户名'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`token`, `id`, `password`, `name`, `tg_name`) VALUES
('', 1, 'e10adc3949ba59abbe56e057f20f883e', 'admin', '');

-- --------------------------------------------------------

--
-- 表的结构 `api`
--

CREATE TABLE IF NOT EXISTS `api` (
  `id` int(10) NOT NULL COMMENT '主键ID',
  `gid` int(10) DEFAULT NULL COMMENT '所属参数id',
  `text` varchar(255) DEFAULT NULL COMMENT '回复内容',
  `add_time` varchar(126) NOT NULL COMMENT '保存时间',
  `keywords` varchar(168) NOT NULL COMMENT '关键词'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `api`
--

INSERT INTO `api` (`id`, `gid`, `text`, `add_time`, `keywords`) VALUES
(1, 1, '您好，我是红牛开发的一款Telegram智能机器人！', '1609590900', '你好');

-- --------------------------------------------------------

--
-- 表的结构 `api_gid`
--

CREATE TABLE IF NOT EXISTS `api_gid` (
  `gid` int(10) NOT NULL COMMENT '主键id',
  `api` varchar(126) DEFAULT NULL COMMENT 'api指令',
  `zh_name` varchar(255) DEFAULT NULL COMMENT '指令中文注释'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `api_gid`
--

INSERT INTO `api_gid` (`gid`, `api`, `zh_name`) VALUES
(1, 'sendmessage?text=', '发送消息'),
(2, 'sendPhoto?photo=', '发送图片');

-- --------------------------------------------------------

--
-- 表的结构 `index`
--

CREATE TABLE IF NOT EXISTS `index` (
  `label` varchar(126) NOT NULL COMMENT '自定义标签',
  `cfg` varchar(126) NOT NULL COMMENT '回复参数',
  `content` varchar(255) NOT NULL COMMENT '回复内容',
  `id` int(10) NOT NULL COMMENT '主键ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `shangpin`
--

CREATE TABLE IF NOT EXISTS `shangpin` (
  `id` int(10) NOT NULL COMMENT '自增ID',
  `gid` int(10) NOT NULL COMMENT '分组ID',
  `content` longtext NOT NULL COMMENT '介绍',
  `add_time` varchar(64) NOT NULL COMMENT '发布时间',
  `fengmian_img` varchar(164) NOT NULL COMMENT '封面图',
  `title` varchar(164) NOT NULL COMMENT '标题'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `shangpin_gid`
--

CREATE TABLE IF NOT EXISTS `shangpin_gid` (
  `gid` int(10) NOT NULL COMMENT '主键ID',
  `name` varchar(64) NOT NULL COMMENT '标签名',
  `add_time` varchar(164) NOT NULL COMMENT '创建时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tg_message`
--

CREATE TABLE IF NOT EXISTS `tg_message` (
  `id` int(10) NOT NULL COMMENT '主键ID',
  `text` varchar(255) DEFAULT NULL COMMENT '消息',
  `name` varchar(126) DEFAULT NULL COMMENT '用户名',
  `chat_id` varchar(64) DEFAULT NULL COMMENT '用户ID',
  `time` varchar(64) NOT NULL COMMENT '发送时间'
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tg_message`
--

INSERT INTO `tg_message` (`id`, `text`, `name`, `chat_id`, `time`) VALUES
(1, NULL, NULL, NULL, '1620383566'),
(2, NULL, NULL, NULL, '1620383576'),
(3, NULL, NULL, NULL, '1620383601'),
(4, NULL, NULL, NULL, '1620383613'),
(5, NULL, NULL, NULL, '1620383615'),
(6, NULL, NULL, NULL, '1620383622'),
(7, NULL, NULL, NULL, '1620383625'),
(8, NULL, NULL, NULL, '1620383629'),
(9, NULL, NULL, NULL, '1620383641'),
(10, NULL, NULL, NULL, '1620383645'),
(11, NULL, NULL, NULL, '1620383650'),
(12, NULL, NULL, NULL, '1620383651'),
(13, NULL, NULL, NULL, '1620383653'),
(14, NULL, NULL, NULL, '1620383653'),
(15, NULL, NULL, NULL, '1620383655'),
(16, NULL, NULL, NULL, '1620383656'),
(17, NULL, NULL, NULL, '1620383656'),
(18, NULL, NULL, NULL, '1620383661'),
(19, NULL, NULL, NULL, '1620383662'),
(20, NULL, NULL, NULL, '1620383662'),
(21, NULL, NULL, NULL, '1620383665'),
(22, NULL, NULL, NULL, '1622152516'),
(23, NULL, NULL, NULL, '1622179969'),
(24, NULL, NULL, NULL, '1622202941'),
(25, NULL, NULL, NULL, '1622257589'),
(26, NULL, NULL, NULL, '1622324136'),
(27, NULL, NULL, NULL, '1622379723'),
(28, NULL, NULL, NULL, '1622460889'),
(29, NULL, NULL, NULL, '1622517830'),
(30, NULL, NULL, NULL, '1622572641'),
(31, NULL, NULL, NULL, '1622645231'),
(32, NULL, NULL, NULL, '1622711824'),
(33, NULL, NULL, NULL, '1622776184'),
(34, NULL, NULL, NULL, '1622844223'),
(35, NULL, NULL, NULL, '1622889383'),
(36, NULL, NULL, NULL, '1622889710'),
(37, NULL, NULL, NULL, '1622906199'),
(38, NULL, NULL, NULL, '1622968170'),
(39, NULL, NULL, NULL, '1623031836'),
(40, NULL, NULL, NULL, '1623083038'),
(41, NULL, NULL, NULL, '1623158514'),
(42, NULL, NULL, NULL, '1623214179'),
(43, NULL, NULL, NULL, '1623261555'),
(44, NULL, NULL, NULL, '1623330530'),
(45, NULL, NULL, NULL, '1623390380'),
(46, NULL, NULL, NULL, '1623464016'),
(47, NULL, NULL, NULL, '1623520310'),
(48, NULL, NULL, NULL, '1623580631'),
(49, NULL, NULL, NULL, '1623653586'),
(50, NULL, NULL, NULL, '1623713294'),
(51, NULL, NULL, NULL, '1623769582'),
(52, NULL, NULL, NULL, '1623834114'),
(53, NULL, NULL, NULL, '1623906172'),
(54, NULL, NULL, NULL, '1623972075'),
(55, NULL, NULL, NULL, '1624032326'),
(56, NULL, NULL, NULL, '1624089220'),
(57, NULL, NULL, NULL, '1624162921'),
(58, NULL, NULL, NULL, '1624218591');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_gid`
--
ALTER TABLE `api_gid`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `index`
--
ALTER TABLE `index`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `label` (`label`),
  ADD KEY `label_2` (`cfg`) USING BTREE;

--
-- Indexes for table `shangpin`
--
ALTER TABLE `shangpin`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `shangpin_gid`
--
ALTER TABLE `shangpin_gid`
  ADD UNIQUE KEY `gid` (`gid`);

--
-- Indexes for table `tg_message`
--
ALTER TABLE `tg_message`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键ID',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `api`
--
ALTER TABLE `api`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键ID',AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `index`
--
ALTER TABLE `index`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键ID';
--
-- AUTO_INCREMENT for table `shangpin`
--
ALTER TABLE `shangpin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '自增ID';
--
-- AUTO_INCREMENT for table `shangpin_gid`
--
ALTER TABLE `shangpin_gid`
  MODIFY `gid` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键ID';
--
-- AUTO_INCREMENT for table `tg_message`
--
ALTER TABLE `tg_message`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键ID',AUTO_INCREMENT=59;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

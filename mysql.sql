/*

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2014-10-01 23:28:04
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `answers`
-- ----------------------------
DROP TABLE IF EXISTS `answers`;
CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `answer_text` varchar(500) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `insert_dt` datetime DEFAULT NULL,
  `active_flg` int(11) NOT NULL DEFAULT '1',
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`answer_id`),
  KEY `q_a` (`question_id`),
  CONSTRAINT `q_a` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of answers
-- ----------------------------
INSERT INTO `answers` VALUES ('1', '1', '0-18', 'red', '2014-09-29 02:14:05', '1', '2');
INSERT INTO `answers` VALUES ('2', '1', '19-49', 'lightblue', '2014-09-29 02:14:18', '1', '1');
INSERT INTO `answers` VALUES ('3', '1', '50+', 'greenyellow', '2014-09-29 02:14:25', '1', '1');
INSERT INTO `answers` VALUES ('4', '2', 'At home', 'red', '2014-09-29 02:14:52', '1', '2');
INSERT INTO `answers` VALUES ('5', '2', 'In airplane', 'lightblue', '2014-09-29 02:15:03', '1', '2');
INSERT INTO `answers` VALUES ('6', '2', 'In hospital', 'greenyellow', '2014-09-29 02:15:14', '1', '0');
INSERT INTO `answers` VALUES ('9', '3', 'Red', 'red', '2014-09-29 02:15:46', '1', '3');
INSERT INTO `answers` VALUES ('10', '3', 'Blue', 'lightblue', '2014-09-29 02:15:48', '1', '0');
INSERT INTO `answers` VALUES ('11', '3', 'Green', 'greenyellow', '2014-09-29 02:15:50', '1', '1');

-- ----------------------------
-- Table structure for `questions`
-- ----------------------------
DROP TABLE IF EXISTS `questions`;
CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question_text` varchar(500) DEFAULT NULL,
  `insert_dt` datetime DEFAULT NULL,
  `active_flg` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of questions
-- ----------------------------
INSERT INTO `questions` VALUES ('1', 'How old are you?', '2014-09-29 02:11:34', '1');
INSERT INTO `questions` VALUES ('2', 'Where were you born?', '2014-09-29 02:12:40', '1');
INSERT INTO `questions` VALUES ('3', 'What is your favorite color?', '2014-09-29 02:13:53', '1');

-- ----------------------------
-- Table structure for `votes`
-- ----------------------------
DROP TABLE IF EXISTS `votes`;
CREATE TABLE `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `insert_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of votes
-- ----------------------------

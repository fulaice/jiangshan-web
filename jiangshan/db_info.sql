DROP TABLE IF EXISTS `contents`;
DROP TABLE IF EXISTS `provinces`;
DROP TABLE IF EXISTS `cities`;
DROP TABLE IF EXISTS `countries`;


-- create table
CREATE TABLE `provinces` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `provinceid` int(11) NOT NULL,
   `province` varchar(100) NOT NULL DEFAULT '',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;

-- create table
CREATE TABLE `cities` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `cityid` char(6) NOT NULL COMMENT '城市编码',
   `city` varchar(40) NOT NULL COMMENT '城市名称',
   `provinceid` char(6) NOT NULL COMMENT '所属省份编码',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=350 DEFAULT CHARSET=utf8mb4 COMMENT='城市信息表';

-- create table
CREATE TABLE `countries` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `countryid` char(6) NOT NULL COMMENT '区县编码',
   `country` varchar(40) NOT NULL COMMENT '区县名称',
   `cityid` char(6) NOT NULL COMMENT '所属城市编码',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3200 DEFAULT CHARSET=utf8mb4 COMMENT='区县信息表';

-- crate table
CREATE TABLE `contents` (
   `id` int(11) AUTO_INCREMENT PRIMARY KEY,    -- 每条内容自增ID
   `title` VARCHAR(50) NOT NULL,
   `author` VARCHAR(50) NOT NULL,
   `body` TEXT NOT NULL,
   `province_id` INT NOT NULL,
   `city_id` INT,
   `country_id` INT,
   `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,    -- 发布时间
   `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,    -- 修改时间
   FOREIGN KEY (`province_id`) REFERENCES `provinces`(`id`),
   FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`),
   FOREIGN KEY (`country_id`) REFERENCES `countries`(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='内容存储表';
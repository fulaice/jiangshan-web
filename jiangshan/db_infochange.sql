USE CITYINFO;

-- 修改 `cities` 表的 `provinceid` 列的数据类型
ALTER TABLE `provinces` MODIFY `provinceid` char(6) NOT NULL;
-- ALTER TABLE `cities` MODIFY `provinceid` int(11) NOT NULL;
-- ALTER TABLE `countries` MODIFY `cityid` int(11) NOT NULL;

-- 修改 `countries` 表的 `cityid` 列的数据类型
-- ALTER TABLE `countries` MODIFY `cityid` int(11) NOT NULL;

-- 在 `provinces` 表中为 `provinceid` 列添加一个唯一键约束
ALTER TABLE `provinces` ADD UNIQUE (`provinceid`);


-- 无法建立外键，因为city表的provinceid列存在province表中不存在的值

-- 删除 `cities` 表的旧外键并添加新外键
-- ALTER TABLE `cities` DROP FOREIGN KEY `cities_ibfk_1`;
ALTER TABLE `cities` ADD FOREIGN KEY (`provinceid`) REFERENCES `provinces`(`provinceid`);

-- 删除 `countries` 表的旧外键并添加新外键
-- ALTER TABLE `countries` DROP FOREIGN KEY `countries_ibfk_1`;
ALTER TABLE `countries` ADD FOREIGN KEY (`cityid`) REFERENCES `cities`(`cityid`);

-- 改成建立索引
CREATE INDEX idx_provinceid ON `cities`(`provinceid`);
CREATE INDEX idx_cityid ON `countries`(`cityid`);

-- 删除试试
DROP INDEX idx_provinceid ON `cities`;
DROP INDEX idx_cityid ON `countries`;

-- 测试语句
SELECT p.province FROM `provinces` p 
INNER JOIN `cities` c ON p.provinceid = c.provinceid 
INNER JOIN `countries` co ON c.cityid = co.cityid 
WHERE co.country = '庐溪县';

-- 测试语句
SELECT p.province FROM `provinces` p 
INNER JOIN `cities` c ON p.provinceid = c.provinceid 
INNER JOIN `countries` co ON c.cityid = co.cityid 
WHERE co.country = '五家渠市';



--mysqldump -u username -p database_name > backup.sql
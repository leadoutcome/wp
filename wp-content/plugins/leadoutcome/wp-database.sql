DROP TABLE `rmm18_lo_members`;
CREATE TABLE `rmm18_lo_members` (
	`id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`wp_uid` INTEGER(11) NOT NULL,
	`drpl_uid` INTEGER(11) NOT NULL,
	`ir_id` INTEGER(11) NOT NULL,
	`lo_name` VARCHAR(255) NOT NULL,
	`status` TINYINT,
	PRIMARY KEY  (id)
) ENGINE=InnoDB;

DROP TABLE `jaylo_members`;
CREATE TABLE `jaylo_members` (
	`id` INTEGER(11) NOT NULL AUTO_INCREMENT,
	`wp_uid` INTEGER(11) NOT NULL,
	`drpl_uid` INTEGER(11) NOT NULL,
	`ir_id` INTEGER(11) NOT NULL,
	`lo_name` VARCHAR(255) NOT NULL,
	`status` TINYINT,
	PRIMARY KEY  (id)
) ENGINE=InnoDB;


insert into jaylo_members (wp_uid,drpl_uid,ir_id,lo_name,status) values (11,25805,27270,'jnoland-27270',1);
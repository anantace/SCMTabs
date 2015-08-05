<?php
class AddSCMTabsTables extends DBMigration {

    public function description () {
        return 'create tables for the SCMPlugin';
    }

    public function up () {
        $db = DBManager::get();
        $db->exec("CREATE  TABLE `scm_tabs` (
            `scm_id` INT NOT NULL AUTO_INCREMENT,
			`range_id` VARCHAR(32) NOT NULL,
			`user_id` VARCHAR(32) NOT NULL,
			`tab_name` VARCHAR(32) NOT NULL DEFAULT 'Info',
            `content` TEXT DEFAULT NULL,
            `chdate` INT(20) NOT NULL DEFAULT 0,
            `mkdate` INT(20) NOT NULL DEFAULT 0,
			`position` INT(11) NOT NULL DEFAULT 0,
            PRIMARY KEY (`scm_id`)
        )");
		
        SimpleORMap::expireTableScheme();
    }

    public function down () {
        DBManager::get()->exec("DROP TABLE scm_tabs");
        SimpleORMap::expireTableScheme();
    }
}

<?php
class ChangePrimaryKey extends DBMigration {

    public function description () {
        return 'change primary key of scm_tabs to composite key';
    }

    public function up () {
        $db = DBManager::get();
        $db->exec("ALTER  TABLE `scm_tabs` DROP PRIMARY KEY, ADD PRIMARY KEY(scm_id, range_id);");
		
        SimpleORMap::expireTableScheme();
    }

    public function down () {
    }
}

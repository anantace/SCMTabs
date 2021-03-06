<?php
/**
 * ScmTabEntry.class.php
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of
 * the License, or (at your option) any later version.
 *
 * @author André Noack <noack@data-quest>, Suchi & Berg GmbH <info@data-quest.de>
 * @author Jan-Hendrik Willms <tleilax+studip@gmail.com>
 * @author Annelene Sudau <asudau@uos.de> 
 * @access public
 *
 * @property string scm_id database column
 * @property string id alias column for scm_id
 * @property string range_id database column
 * @property string user_id database column
 * @property string tab_name database column
 * @property string content database column
 * @property string mkdate database column
 * @property string chdate database column
 * @property string position database column
 * @property User user belongs_to User
 * @property Course course belongs_to Course
 */

class ScmTabEntry extends SimpleORMap
{
    protected static function configure($config = array())
    {
        $config['db_table'] = 'scm_tabs';
        $config['belongs_to']['user'] = array(
            'class_name'  => 'User',
            'foreign_key' => 'user_id',
        );
        $config['belongs_to']['course'] = array(
            'class_name'  => 'Course',
            'foreign_key' => 'range_id',
        );

        parent::configure($config);
    }
}
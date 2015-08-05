<?php
require_once dirname(__FILE__) .'/models/ScmTabEntry.class.php';
/*
 *  Copyright (c) 2015  Annelene Sudau <asudau@uos.de>
 * 
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License as
 *  published by the Free Software Foundation; either version 2 of
 *  the License, or (at your option) any later version.
 */

//require_once 'lib/modules/StudipModule.class.php';

class SCMPlugin extends StudIPPlugin implements StandardPlugin {
    
    public function __construct() {
        parent::__construct();

	 $this->course = Course::findCurrent();
	 $this->course_id = $this->course->id;

	 
	
    }
	
    public function initialize ()
    {
        //PageLayout::addStylesheet($this->getPluginUrl() . '/css/style.css');
        //PageLayout::addStylesheet($this->getPluginURL().'/assets/style.css');
        //PageLayout::addScript($this->getPluginURL().'/js/script.js');
		$this->setupAutoload();
    }
	
    public function perform($unconsumed_path) {

        $dispatcher = new Trails_Dispatcher(
            $this->getPluginPath(),
            rtrim(PluginEngine::getLink($this, array(), null), '/'),
            'show'
        );
        $dispatcher->plugin = $this;
        $dispatcher->dispatch($unconsumed_path);
 
    }

    private function setupAutoload() {
        if (class_exists("StudipAutoloader")) {
            StudipAutoloader::addAutoloadPath(__DIR__ . '/models');
        } else {
            spl_autoload_register(function ($class) {
                include_once __DIR__ . $class . '.php';
            });
        }
    }
	

	function getIconNavigation($course_id, $last_visit, $user_id) {
        
            return null;
    }
    
    function getTabNavigation($course_id) {
        if (TRUE){ 
            $temp = ScmTabEntry::findByRange_id($course_id, 'ORDER BY position ASC');
	     if($temp){	
            $scms = SimpleORMapCollection::createFromArray($temp);

            $navigation = new Navigation($scms->first()->tab_name ?: _('Informationen'));
            $navigation->setImage('icons/16/white/infopage.png');
            $navigation->setActiveImage('icons/16/black/infopage.png');

            foreach ($scms as $scm) {
                $scm_link = PluginEngine::getLink($this, array(), 'show/'.$scm->id);
                $nav = new Navigation($scm['tab_name'], $scm_link);
		  $nav->setImage('icons/16/white/infopage.png');
                $nav->setActiveImage('icons/16/black/infopage.png');
		  Navigation::addItem('course/scmTabs' . $scm->id, $nav);

            }

            return array('scm' => $navigation);
	     } else {

		$scm = new ScmTabEntry($id);
		$scm->tab_name = 'Infoseite';
              $scm->user_id  = $GLOBALS['user']->id;
              $scm->range_id = $GLOBALS['SessSemName'][1];
		$scm->store();

		$scm_link = PluginEngine::getLink($this, array(), 'show/'.$scm->id);
                $nav = new Navigation($scm->tab_name, $scm_link);
		  $nav->setImage('icons/16/white/infopage.png');
                $nav->setActiveImage('icons/16/black/infopage.png');
     		  Navigation::addItem('course/scmTabs' . $scm->id, $nav);
		  return null;
	     }
        } else {
            return null;
        }
    }
 
    function getNotificationObjects($course_id, $since, $user_id)
    {
        
        return null;
    }
	
	
	public function getInfoTemplate($course_id){
	return null;
    }

    /** 
     * @see StudipModule::getMetadata()
     */ 
    function getMetadata()
    {
        return array(
            'summary' => _('Die Lehrenden bestimmen, wie Titel und Inhalt dieser Seiten aussehen.'),
            'description' => _('Die ist eine Abwandlung der freien Informationsseite. Anders '.
				'als dort werden hier weitere Einträge in separaten Kartenreitern dargestellt. '.'Lehrende können beliebig viele Seiten nach ihren speziellen '.
                'Anforderungen einrichten. So kann z.B. der Titel im Kartenreiter '.
                'selbst definiert werden. Für jeden neuen Eintrag '.
                'öffnet sich eine Seite mit einem Text-Editor, in den '.
                'beliebiger Text eingegeben und formatiert werden kann. Oft '.
                'werden solche Seiten für die Angabe von Literatur genutzt als '.
                'Alternative zum Plugin Literatur. Sie können aber auch für '.
                'andere beliebige Zusatzinformationen (Links, Protokolle '.
                'etc.) verwendet werden.')
        );
    }

    
}

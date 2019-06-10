<?php
/* Copyright (c) 2019 Amstutz Timon <timon.amstutz@ilub.unibe.ch> Extended GPL, see docs/LICENSE */

require_once __DIR__ . "/../vendor/autoload.php";

/**
 * This class allows you to customize administration settings for the given plugin.
 *
 * The access the configuration class open the ILIAS Administration > Plugins > Actions (of your Plugin) > Configure
 *
 * IMPORTANT: Note, that for the configure action to be displayed in your plugins actions dropdown, you need to reload
 * the plugins control structure. You can force your plugin to do so, by updating the plugins version in plugin.php
 * and select Update in the plugins actions in the table in the plugin administration.
 *
 * Class ilUIHookDemoConfigGUI
 */
class ilUIHookDemoConfigGUI extends ilPluginConfigGUI {

	/**
	 * @param string $cmd
	 */
	public function performCommand($cmd){
		global $DIC;

		//Perform configuration in the GUI (Administration/Plugins/UIHookDemo) for your plugin here.
		$DIC->ui()->mainTemplate()->setContent("Some configurations might be placed here");
	}
}
<?php
/* Copyright (c) 2019 Amstutz Timon <timon.amstutz@ilub.unibe.ch>, Alex Killing Extended GPL, see docs/LICENSE */

require_once __DIR__ . "/../vendor/autoload.php";

/**
 * This is where the actual magic of the GUI modifications take place.
 *
 * Class ilUIHookDemoUIHookGUI
 */
class ilUIHookDemoUIHookGUI extends ilUIHookPluginGUI
{

	/**
	 * @deprecated Note this method is deprecated. There are several issues with hacking into already rendered html
	 * as provided here:
	 * - The generation of html might be performed twice (especially if REPLACE is used).
	 * - There is limited access to data used to generate the original html. If needed this data needs to be gathered again.
	 * - User Interface components are migrated towards the UIComponents and Global Screen which do not make use of the
	 *   mechanism provided here.
	 *
	 *
	 * Modify HTML output of GUI elements. Modifications modes are:
	 * - ilUIHookPluginGUI::KEEP (No modification)
	 * - ilUIHookPluginGUI::REPLACE (Replace default HTML with your HTML)
	 * - ilUIHookPluginGUI::APPEND (Append your HTML to the default HTML)
	 * - ilUIHookPluginGUI::PREPEND (Prepend your HTML to the default HTML)
	 *
	 * @param string $a_comp component
	 * @param string $a_part string that identifies the part of the UI that is handled
	 * @param array $a_par array of parameters (depend on $a_comp and $a_part), e.g. name of the used tpl.
	 *
	 * @return array array with entries "mode" => modification mode, "html" => your html
	 */
	function getHTML($a_comp, $a_part, $a_par = array())
	{
		//Shows the easiest but also most brutal way to change the html output of some component in some context
		if ($a_part == "template_get" && $a_par['tpl_id']=="src/UI/templates/default/MainControls/tpl.metabar.html" && $_GET["UIDemo"] == "newMetabarByGetHtml"){
			return array("mode" => ilUIHookPluginGUI::REPLACE, "html" => "Cool New Metabar");
		}
		return array("mode" => ilUIHookPluginGUI::KEEP, "html" => "");
	}


	/**
	 * @deprecated Note this method is deprecated. User Interface components are migrated towards the UIComponents and
	 * Global Screen which do not make use of the mechanism provided here. Make use of the extension possibilities provided
	 * by Global Screen and UI Components instead.
	 *
	 * In ILIAS 6.0 still working for working for:
	 * - $a_comp="Services/Ini" ; $a_part="init_style"
	 * - $a_comp="" ; $a_part="tabs"
	 * - $a_comp="" ; $a_part="sub_tabs"
	 *
	 * Allows to modify user interface objects before they generate their output.
	 *
	 * @param string $a_comp component
	 * @param string $a_part string that identifies the part of the UI that is handled
	 * @param array $a_par array of parameters (depend on $a_comp and $a_part)
	 */
	function modifyGUI($a_comp, $a_part, $a_par = array())
	{
		/**
		 * Tabs are not migrated to the UI Components/Global Screen, so they still might be manipulated here.
		 *
		 * Note that you currently do not get information in $a_comp
		 * here. So you need to use general GET/POST information
		 * like $_GET["baseClass"], $ilCtrl->getCmdClass/getCmd
		 * to determine the context.
		 */
		if ($a_part == "tabs" && $_GET["UIDemo"] == "addTab")
		{
			/**
			 * @var $tabs ilTabsGUI
			 */
			$tabs = $a_par["tabs"];
			$tabs->addTab("NewTabId","New Tab","#");
		}
	}

}
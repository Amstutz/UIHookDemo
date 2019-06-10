<?php
/* Copyright (c) 2019 Amstutz Timon <timon.amstutz@ilub.unibe.ch> Extended GPL, see docs/LICENSE */

require_once __DIR__ . "/../vendor/autoload.php";

use ILIAS\Plugins\UIHookDemo\MainMenu\ilMMRoleBasedProvider;
use ILIAS\GlobalScreen\Scope\MainMenu\Provider\AbstractStaticPluginMainMenuProvider;
use ILIAS\Plugins\UIHookDemo\DIC\JsonRenderer\JsonRenderer;
use ILIAS\Plugins\UIHookDemo\DIC\CustomMetaBar\Factory as CustomMetaBarFactory;
use ILIAS\UI\Implementation\Component\MainControls\Factory as DefaultMainControlsFactory;
use ILIAS\UI\Renderer;

/**
 * Previously there was not that much to do here except defining the Plugins name.
 *
 * Since the introduction of the Global Screen, this can be also used however, to manipulate the Main Menu of ILIAS.
 * Note that this does not only work for ilUserInterfaceHookPlugin plugins, but for all plugins descending ilPlugin.
 *
 * Class ilUIHookDemoPlugin
 */
class ilUIHookDemoPlugin extends ilUserInterfaceHookPlugin {
	/**
	 * @inheritdoc
	 */
	function getPluginName() {
		return 'UIHookDemo';
	}

	/**
	 * This method is used to promote a plugins own GlobalScreen provider. With such a provider, one can easily
	 * extend parts of the Global Screen such as the Main Menu. Note that this method is available for all types
	 * of plugins.
	 *
	 * @return AbstractStaticPluginMainMenuProvider
	 */
	public function promoteGlobalScreenProvider(): AbstractStaticPluginMainMenuProvider {
		global $DIC;

		return new ilMMRoleBasedProvider($DIC,$this);
	}

	/**
	 * This methods allows to extend the dependency injection container of ILIAS after initialization. One could
	 * replace the container completely, extend it, or replace several parts of it. Note that this method is available
	 * for all types of plugins.
	 *
	 * Important: Note that plugins might conflict by extending the $DIC if they try to extend the same component in
	 * the same context. Therefore it might by wise to be as specific as possible in context and in the component
	 * one is overwriting.
	 *
	 * @param \ILIAS\DI\Container $DIC
	 * @return \ILIAS\DI\Container
	 */
	public function afterClientInitialization(\ILIAS\DI\Container $DIC): \ILIAS\DI\Container {
		//Be as specific as possible with giving a context, to prevent plugins from creating conflicts in the DIC
		switch($_GET["UIDemo"]){
			//Replace the DefaultRenderer with a JsonRenderer, that echos parts of the page as json. Note that
			//that now items are rendered in vain this way.
			case "JsonRenderer":
				$DIC->extend("ui.renderer", function(Renderer $renderer,\ILIAS\DI\Container  $c){
					return new JsonRenderer();
				});
				break;
			//Replace the MetaBar with a Custom one and provide an own renderer for this Custom Metabar
			case "CustomMetaBar":
				$DIC->extend("ui.factory.maincontrols", function(DefaultMainControlsFactory $factory, \ILIAS\DI\Container  $c){
					return new CustomMetaBarFactory(
						$c['ui.signal_generator'],
						$c['ui.factory.maincontrols.slate']
					);
				});
		}

		return $DIC;
	}
}
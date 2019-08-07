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
	 * This methods allows to replace the UI Renderer (see src/UI) of ILIAS after initialization
	 * by returning a closure returning a custom renderer. E.g:
	 *
	 * return function(\ILIAS\DI\Container $c){
	 *   return new CustomRenderer();
	 * };
	 *
	 * Note: Note that plugins might conflict by replacing the renderer, so only use if you
	 * are sure, that no other plugin will do this for a given context.
	 *
	 * @param \ILIAS\DI\Container $dic
	 * @return Closure
	 */
	public function exchangeUIRendererAfterInitialization(\ILIAS\DI\Container $dic):Closure{
		//Be as specific as possible with giving a context, to prevent plugins from creating conflicts in the DIC
		if($_GET["UIDemo"] == "JsonRenderer"){
			return function(\ILIAS\DI\Container $c){
				return new JsonRenderer();
			};
		}
		return parent::exchangeUIRendererAfterInitialization( $dic);
	}

	/**
	 * This methods allows to replace some factory for UI Components (see src/UI) of ILIAS
	 * after initialization by returning a closure returning a custom factory. E.g:
	 *
	 * if($key == "ui.factory.nameOfFactory"){
	 *    return function(\ILIAS\DI\Container  $c){
	 *       return new CustomFactory($c['ui.signal_generator'],$c['ui.factory.maincontrols.slate']);
	 *    };
	 * }
	 *
	 * Note: Note that plugins might conflict by replacing the same factory, so only use if you
	 * are sure, that no other plugin will do this for a given context.
	 *
	 * @param string $dic_key
	 * @param \ILIAS\DI\Container $dic
	 * @return Closure
	 */
	public function exchangeUIFactoryAfterInitialization(string $key, \ILIAS\DI\Container $dic):Closure{
		//Be as specific as possible with giving a context, to prevent plugins from creating conflicts in the DIC
		if($key == "ui.factory.maincontrols" && $_GET["UIDemo"] == "CustomMetaBar"){
			return function(\ILIAS\DI\Container  $c){
				return new CustomMetaBarFactory(
					$c['ui.signal_generator'],
					$c['ui.factory.maincontrols.slate']
				);
			};
		}
		return parent::exchangeUIFactoryAfterInitialization($key,$dic);
	}
}
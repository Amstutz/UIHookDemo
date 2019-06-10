<?php
/* Copyright (c) 2019 Timon Amstutz Extended GPL, see docs/LICENSE */
namespace ILIAS\Plugins\UIHookDemo\DIC\CustomMetaBar;

use ILIAS\UI\Renderer as RendererInterface;
use ILIAS\UI\Component\MainControls\MetaBar;
use ILIAS\UI\Implementation\Component\MainControls\Renderer as DefaultRenderer;


class Renderer extends DefaultRenderer {

	/**
	 * @inheritdoc
	 */
	protected function renderMetabar(MetaBar $component, RendererInterface $default_renderer) {
		return "<div class='custom_meta'>".parent::renderMetabar($component,$default_renderer)."</div>";
	}

	/**
	 * Get the path to the template of this component.
	 *
	 * @param	string	$name
	 * @return	string
	 */
	protected function getTemplatePath($name) {
		if($name == "tpl.metabar.html"){
			return "src/UI/templates/default/MainControls/$name";
		}else{
			return parent::getTemplatePath($name);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function registerResources(\ILIAS\UI\Implementation\Render\ResourceRegistry $registry) {
		parent::registerResources($registry);
		$registry->register('Customizing/global/plugins/Services/UIComponent/UserInterfaceHook/UIHookDemo/js/custom_meta.js');
		$registry->register('Customizing/global/plugins/Services/UIComponent/UserInterfaceHook/UIHookDemo/js/custom_meta.css');
	}
}

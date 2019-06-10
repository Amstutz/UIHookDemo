<?php
/* Copyright (c) 2016 Timon Amstutz Extended GPL, see docs/LICENSE */
namespace ILIAS\Plugins\UIHookDemo\DIC\JsonRenderer;

use ILIAS\UI\Component\Component;
use ILIAS\UI\Renderer;
use ILIAS\UI\Component\Layout\Page\Standard;

class JsonRenderer implements Renderer {

	/**
	 * Render given component. If an array of components is passed, this method returns a concatenated output of
	 * each rendered component, in the same order as given in the array
	 *
	 * @param Component|Component[] $component
	 *
	 * @return string
	 */
	public function render($component){
		if (!is_array($component)) {
			$component = [$component];

		}
		foreach ($component as $c)
		if($c instanceof Standard){
			$page_info = new \stdClass();

			$page_info->logo = $c->getLogo()->getSource();
			array_walk($c->getMainbar()->getEntries(),function($entry,$index) use ($page_info){
				$page_info->main_bar_entries[$index] = $entry->getName();
			});
			array_walk($c->getMetabar()->getEntries(),function($entry,$index) use ($page_info){
				$page_info->metabar[$index] = new \stdClass();
				$page_info->metabar[$index]->label = $entry->getName();
			});
			array_walk($c->getBreadcrumbs()->getItems(),function($entry,$index) use ($page_info){
				$page_info->breadcrumbs[$index] = new \stdClass();
				$page_info->breadcrumbs[$index]->label = $entry->getLabel();
				$page_info->breadcrumbs[$index]->target = $entry->getAction();
			});

			echo "<pre>".json_encode($page_info, JSON_PRETTY_PRINT)."</pre>";
		}
		return "";
	}

	/**
	 * @inheritdoc
	 */
	public function renderAsync($component){
		$this->render($component);
	}

	/**
	 * @inheritdoc
	 */
	public function withAdditionalContext(Component $context){
		return $this;
	}
}

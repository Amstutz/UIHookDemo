<?php
/* Copyright (c) 2019 Timon Amstutz Extended GPL, see docs/LICENSE */
namespace ILIAS\Plugins\UIHookDemo\DIC\CustomMetaBar;

use ILIAS\UI\Implementation\Component\SignalGeneratorInterface;
use ILIAS\UI\Implementation\Component\MainControls\Metabar;

/**
 * CustomMetaBar
 */
class CustomMetaBar extends Metabar
{
	public function __construct(SignalGeneratorInterface $signal_generator) {
		parent::__construct($signal_generator);

		global $DIC;

		$this->entries["CustomEntry"] = $DIC->ui()->factory()->mainControls()->slate()->legacy(
			"Custom",
			$DIC->ui()->factory()->symbol()->icon()->standard("-","custom"),
			$DIC->ui()->factory()->legacy("<div>Some Cool new Feature</div>"));
	}
}

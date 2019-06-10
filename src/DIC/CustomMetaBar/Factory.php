<?php
/* Copyright (c) 2019 Timon Amstutz Extended GPL, see docs/LICENSE */
namespace ILIAS\Plugins\UIHookDemo\DIC\CustomMetaBar;

use ILIAS\UI\Component\MainControls as IMainControls;
use ILIAS\UI\Implementation\Component\MainControls\Factory as DefaultFactory;

class Factory extends DefaultFactory
{
	/**
	 * @inheritdoc
	 */
	public function metaBar(): IMainControls\MetaBar
	{
		return new CustomMetaBar($this->signal_generator);
	}

}

<?php
namespace ILIAS\Plugins\UIHookDemo\MainMenu;

use ILIAS\GlobalScreen\Scope\MainMenu\Provider\AbstractStaticPluginMainMenuProvider;
use ILIAS\GlobalScreen\Scope\MainMenu\Factory\TopItem\TopParentItem;
use ILIAS\GlobalScreen\Scope\MainMenu\Collector\Information\TypeInformation;
use ILIAS\GlobalScreen\Scope\MainMenu\Collector\Information\TypeInformationCollection;
use ilPlugin;

/**
 * Class ilMMRoleBasedProvider
 *
 * @author Timon Amstutz
 */
class ilMMRoleBasedProvider extends AbstractStaticPluginMainMenuProvider {

	/**
	 * @var \ILIAS\DI\Container
	 */
	protected $dic;

	/**
	 * @var ilPlugin $plugin
	 */
	protected $plugin;

	/**
	 * @return TopParentItem[]
	 *
	 * This Method returns all TopItems for the MainMenu.
	 * Make sure you use the same Identifier for all subitems as well,
	 * @see getParentIdentifier().
	 * Using $this->if-> (if stands for IdentificationFactory) you will already
	 * get a PluginIdentification for your Plugin-Instance.
	 */
	public function getStaticTopItems(): array {
		$item = $this->mainmenu->topLinkItem($this->if->identifier("demo_item"))->withTitle("UI Hook Demo")->withPosition(999)->withVisibilityCallable(
			function ()  {
				return ($_GET["UIDemo"]=="CustomMainMenuEntry");
			}
		);
		return [$item];
	}

	/**
	 * Accordingly this method provides the Subitems.
	 * By using $this->mainmenu->custom(...) you can even use your own Types.
	 * Make sure you provide special information and rendering for won types if
	 * needed, @see provideTypeInformation()
	 *
	 * @inheritdoc
	 */
	public function getStaticSubItems(): array {
		return [];
	}

	/**
	 * This method can be used to add new types of Main Menu entries.
	 * E.g.:
	 * $c = new TypeInformationCollection();
	 * $c->add(new TypeInformation(ilExampleType::class, "Example Description",new ilExampleRenderer(),
	 * 		new ilExampleTypeHandler($this->if->identifier("parent_role_entry")))
	 * );
	 * Adds an new Example Type the list of available Main menu entries in the admistration.
	 *
	 * @return TypeInformationCollection
	 */
	public function provideTypeInformation(): TypeInformationCollection {
		/**
		 * This is a more advanced example, adding a TopParentItem which can be shown for specific global roles.
		 */
		$c = new TypeInformationCollection();
		$c->add(new TypeInformation(ilMMRoleEntryType::class, "Role Based Access",new ilMMRoleEntryRenderer(),
				new ilMMRoleEntryType($this->if->identifier("parent_role_entry")))
		);
		return $c;
	}
}

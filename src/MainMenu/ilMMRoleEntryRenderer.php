<?php
namespace ILIAS\Plugins\UIHookDemo\MainMenu;

use ILIAS\GlobalScreen\Scope\MainMenu\Factory\isItem;
use ILIAS\GlobalScreen\Scope\MainMenu\Collector\Renderer\TopParentItemRenderer;
use ILIAS\UI\Component\Component;
/**
 * Class ilMMRoleEntryRenderer
 *
 * @author Timon Amstutz
 */
class ilMMRoleEntryRenderer extends TopParentItemRenderer {
	/**
	 * Enables to Exchange the given UI Component $item with a custom one
	 *
	 * @param isItem $item
	 * @return Component
	 */
	public function getComponentForItem(isItem $item): Component {
		/**
		 * Checks if one of the global roles assigned to this entry is attached to the current user, if so, the entry is shown.
		 */
		global $DIC;

		$identifier = $item->getProviderIdentification();
		$storage = new ilMMRoleStorage($identifier->getInternalIdentifier());
		$data = unserialize($storage->getMMItemData());

		$global_roles_with_access = $data['roles'];
		$global_roles_of_user = $DIC->rbac()->review()->assignedGlobalRoles($DIC->user()->getId());

		if(is_array($global_roles_with_access) && count(array_intersect($global_roles_of_user,$global_roles_with_access))){
			return parent::getComponentForItem($item);
		}
		//To not show the entry.
		return $this->ui_factory->legacy("");
	}
}
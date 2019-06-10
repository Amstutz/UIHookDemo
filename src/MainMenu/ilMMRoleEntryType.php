<?php
namespace ILIAS\Plugins\UIHookDemo\MainMenu;

use ILIAS\GlobalScreen\Scope\MainMenu\Factory\TopItem\TopParentItem;
use ILIAS\GlobalScreen\Scope\MainMenu\Collector\Handler\TypeHandler;
use ILIAS\GlobalScreen\Scope\MainMenu\Factory\isItem;
use ILIAS\GlobalScreen\Identification\IdentificationInterface;
use ilObjRole;

/**
 * Defines the type of the entry as TopParentItem. A little lazy, we also implement the TypeHandler here. In more elaborate
 * examples, an own class might be preferable
 *
 * Class ilMMRoleEntryType
 *
 * @author Timon Amstutz
 */
class ilMMRoleEntryType extends TopParentItem implements TypeHandler{
	/**
	 * @inheritDoc
	 */
	public function matchesForType(): string {
		return "";
	}


	/**
	 * @inheritDoc
	 */
	public function enrichItem(isItem $item): isItem {
		return $item;
	}


	/**
	 * The form in the administration is extended to show MultiSelect with the Global Roles
	 *
	 * @param IdentificationInterface $identification
	 * @return array
	 */
	public function getAdditionalFieldsForSubForm(IdentificationInterface $identification): array {
		global $DIC;



		if(ilMMRoleStorage::find($identification->getInternalIdentifier())){
			$storage = new ilMMRoleStorage($identification->getInternalIdentifier());
			$data = unserialize($storage->getMMItemData());
		}else{
			$data["roles"] = [];

		}

		$global_roles = $DIC->rbac()->review()->getGlobalRoles();
		$options = [];
		foreach ($global_roles as $role){
			$role = new ilObjRole($role);
			$options[$role->getId()] = $role->getTitle();
		}

		return [
			"roles" => $DIC->ui()->factory()->input()->field()->multiSelect("Global Roles",$options)
				->withValue($data["roles"])->withByline("Users of selected roles see the given entry.")
		];
	}


	/**
	 * Extended to save the values of the MultiSelect persistently by the Storage class
	 *
	 * @param IdentificationInterface $identification
	 * @param array $data
	 * @return bool
	 */
	public function saveFormFields(IdentificationInterface $identification, array $data): bool {
		$data = serialize($data);
		$storage = new ilMMRoleStorage();
		$storage->setMMItemIdentifier($identification->getInternalIdentifier());
		$storage->setMMItemData($data);
		$storage->save();
		return true;
	}
}
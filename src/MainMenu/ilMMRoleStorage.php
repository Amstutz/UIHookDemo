<?php
namespace ILIAS\Plugins\UIHookDemo\MainMenu;

/**
 * Used to save the global role data attached to the type persistently
 * Class ilMMRoleStorage
 *
 * @author       Timon Amstutz <timon.amstutz@ilub.unibe.ch>
 * @version 1.1.04
 */
class ilMMRoleStorage extends \ActiveRecord {
	/**
	 * @var $crs_ext_id
	 *
	 * @db_has_field        true
	 * @db_is_notnull       true
	 * @db_fieldtype        text
	 * @db_length           256
	 * @db_is_primary       true
	 */
	protected $mm_item_identifier = '';

	/**
	 * @var $cast_ref_id
	 *
	 * @db_has_field        true
	 * @db_is_notnull       true
	 * @db_fieldtype        text
	 * @db_length           4000
	 */
	protected $mm_item_data = '';

	public static function returnDBTableName(){
		return "ui_uihk_mm_item_data";
	}

	public function createTableIfNotExists(){
		if(!$this->tableExists()){
			$this->installDatabase();
		}
	}

	/**
	 * @return mixed
	 */
	public function getMMItemIdentifier()
	{
		return $this->mm_item_identifier;
	}

	/**
	 * @param mixed $mm_item_identifier
	 */
	public function setMMItemIdentifier($mm_item_identifier)
	{
		$this->mm_item_identifier = $mm_item_identifier;
	}

	/**
	 * @return mixed
	 */
	public function getMMItemData()
	{
		return $this->mm_item_data;
	}

	/**
	 * @param mixed $mm_item_data
	 */
	public function setMMItemData($mm_item_data)
	{
		$this->mm_item_data = $mm_item_data;
	}


}
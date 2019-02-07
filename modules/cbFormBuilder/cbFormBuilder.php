<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require_once 'data/CRMEntity.php';
require_once 'data/Tracker.php';
require_once 'include/utils/utils.php';
include_once 'vtlib/Vtiger/Module.php';

class cbFormBuilder extends CRMEntity {

	public $db;
	public $log;
	public $table_name = 'vtiger_cbformbuilder';
	public $table_index= 'cbformbuilderid';
	public $column_fields = array();
	public $IsCustomModule = true;
	public $HasDirectImageField = false;
	public $customFieldTable = array('vtiger_cbformbuildercf', 'cbformbuilderid');
	public $tab_name = array('vtiger_crmentity', 'vtiger_cbformbuilder', 'vtiger_cbformbuildercf');
	public $tab_name_index = array(
		'vtiger_crmentity' => 'crmid',
		'vtiger_cbformbuilder'   => 'cbformbuilderid',
		'vtiger_cbformbuildercf' => 'cbformbuilderid',
	);

	public $list_fields = array(
		'Form No'=> array('cbformbuilder' => 'cbformbuilderno'),
		'formname' => array('cbformbuilder' => 'formname'),
		'formmode' => array('cbformbuilder' => 'formmode'),
		'stepmode' => array('cbformbuilder' => 'stepmode'),
		'mainmodule' => array('cbformbuilder' => 'mainmodule'),
		'Assigned To' => array('crmentity' => 'smownerid')
	);
	public $list_fields_name = array(
		'Form No' => 'cbformbuilderno',
		'formname' => 'formname',
		'formmode' => 'formmode',
		'stepmode' => 'stepmode',
		'mainmodule' => 'mainmodule',
		'Assigned To' => 'assigned_user_id'
	);

	public $list_link_field = 'cbformbuilderno';

	public $search_fields = array(
		'Form No'=> array('cbformbuilder' => 'cbformbuilderno'),
		'formname'=> array('cbformbuilder' => 'formname'),
		'formmode'=> array('cbformbuilder' => 'formmode'),
		'stepmode'=> array('cbformbuilder' => 'stepmode'),
		'mainmodule'=> array('cbformbuilder' => 'mainmodule'),
		'Assigned To'=> array('crmentity' => 'smownerid'),
	);
	public $search_fields_name = array(
		'Form No'=> 'cbformbuilderno',
		'formname'=> 'formname',
		'formmode'=> 'formmode',
		'stepmode'=> 'stepmode',
		'mainmodule'=> 'mainmodule',
		'Assigned To'=> 'smownerid'
	);

	public $popup_fields = array('cbformbuilderno', 'formname', 'formmode', 'stepmode', 'mainmodule', 'assigned_user_id');
	public $sortby_fields = array(
		'formmode' => 'formmode',
		'stepmode' => 'stepmode'
	);
	public $def_basicsearch_col;

	public $def_detailview_recname;
	public $required_fields = array();
	public $special_functions = array('set_import_assigned_user');

	public $default_order_by = 'cbformbuilderno';
	public $default_sort_order='ASC';
	public $mandatory_fields = array('createdtime', 'modifiedtime', 'cbformbuilderno');

	public function save_module($module) {
		global $adb, $current_user;
		if ($this->HasDirectImageField) {
			$this->insertIntoAttachment($this->id, $module);
		}
		$menuurl = 'module=cbFormBuilder&action=index&op=exec&fid='.$this->id;
		$adb->pquery("UPDATE vtiger_cbformbuilder SET menuurl = ? WHERE cbformbuilderid=?", array($menuurl, $this->id));
	}
	/**
	 * Invoked when special actions are performed on the module.
	 * @param String Module name
	 * @param String Event Type (module.postinstall, module.disabled, module.enabled, module.preuninstall)
	 */
	public function vtlib_handler($modulename, $event_type) {
		if ($event_type == 'module.postinstall') {
			// TODO Handle post installation actions
			require_once 'include/utils/utils.php';
				global $adb;
				$this->setModuleSeqNumber('configure', $modulename, 'FB-', '00001');
				include_once 'vtlib/Vtiger/Module.php';
				// Mark the module as Standard module
				$adb->pquery('UPDATE vtiger_tab SET customized=0 WHERE name=?', array($modulename));
				//adds sharing accsess
		} elseif ($event_type == 'module.disabled') {
			// TODO Handle actions when this module is disabled.
		} elseif ($event_type == 'module.enabled') {
			// TODO Handle actions when this module is enabled.
		} elseif ($event_type == 'module.preuninstall') {
			// TODO Handle actions when this module is about to be deleted.
		} elseif ($event_type == 'module.preupdate') {
			// TODO Handle actions before this module is updated.
		} elseif ($event_type == 'module.postupdate') {
			// TODO Handle actions after this module is updated.
		}
	}
}
?>
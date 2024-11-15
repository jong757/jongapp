<?php
/**
 *  index.php 核心控制器
 *
 * @copyright			(C) 2024-2025 Jong 
 * @license				qq:3865176
 * @lastmodify			2024-11-14 
 */
// defined('IN_PHPCMS') or exit('No permission resources.');


class index {
	public function __construct() {
		// parent::__construct();
		// $this->db = pc_base::load_model('admin_model');
		// $this->menu_db = pc_base::load_model('menu_model');
		// $this->panel_db = pc_base::load_model('admin_panel_model');
	}
	
	public function init () {
		
		// $userid = $_SESSION['userid'];
		// $admin_username = param::get_cookie('admin_username');
		// $roles = getcache('role','commons');
		// $rolename = $roles[$_SESSION['roleid']];
		// $site = pc_base::load_app_class('sites');
		// $sitelist = $site->get_list($_SESSION['roleid']);
		// $currentsite = $this->get_siteinfo(param::get_cookie('siteid'));
		// /*管理员收藏栏*/
		// $adminpanel = $this->panel_db->select(array('userid'=>$userid), "*",20 , 'datetime');
		// $site_model = param::get_cookie('site_model');
		// include $this->admin_tpl('index');
	}
	
}
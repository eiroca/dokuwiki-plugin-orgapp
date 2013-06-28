<?php
/**
 * Plugin orgapp: OrgApp applet integration - GPL>=3 - See licence COPYING file
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2009-2011 eIrOcA - Enrico Croce & Simona Burzio
 * @license GPL >=3 (http://www.gnu.org/licenses/)
 * @version 1.0.3
 * @link http://www.eiroca.net
 */
/* Must be run within Dokuwiki */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
if (!defined('DOKU_PLUGIN_ORGAPP')) define('DOKU_PLUGIN_ORGAPP',DOKU_PLUGIN.'orgapp/');
require_once(DOKU_PLUGIN . 'action.php');
class action_plugin_orgapp extends DokuWiki_Action_Plugin {
	function register(&$controller) {
		$controller->register_hook('TOOLBAR_DEFINE', 'AFTER', $this, 'toolbar_add_button_orgapp', array ());
	}
	function toolbar_add_button_orgapp(&$event, $param) {
		$event->data[] = array (
			'type' => 'format',
			'title' => $this->getLang('orgapp_editor'),
			'icon' => '../../plugins/orgapp/editor/orgapp.png',
			'open' => '<orgapp',
			'sample' => @file_get_contents(DOKU_PLUGIN_ORGAPP.'editor/sample.txt'),
			'close' => '</orgapp>',
		);
	}
}
?>
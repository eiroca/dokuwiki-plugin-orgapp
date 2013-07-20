<?php
/**
 * Plugin orgapp: OrgApp applet integration - GPL>=3 - See licence COPYING file
 * @author Enrico Croce & Simona Burzio (staff@eiroca.net)
 * @copyright Copyright (C) 2009-2013 eIrOcA - Enrico Croce & Simona Burzio
 * @license GPL >=3 (http://www.gnu.org/licenses/)
 * @version 1.0.3
 * @link http://www.eiroca.net/doku_orgapp
 */
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
if (!defined('DOKU_PLUGIN_ORGAPP')) define('DOKU_PLUGIN_ORGAPP',DOKU_PLUGIN.'orgapp/');
require_once (DOKU_PLUGIN.'syntax.php');
class syntax_plugin_orgapp extends DokuWiki_Syntax_Plugin {
	function getType() {
		return 'disabled';
	}
	function getSort() {
		return 150;
	}
	function connectTo($mode) {
		$this->Lexer->addEntryPattern('<orgapp.*?>(?=.*?</orgapp>)',$mode,'plugin_orgapp');
	}
	function postConnect() {
		$this->Lexer->addExitPattern('</orgapp>', 'plugin_orgapp');
	}
	function handle($match, $state, $pos, &$handler){
		switch ($state) {
			case DOKU_LEXER_ENTER :
				$out['width']= $this->getConf('width');
				$out['height']= $this->getConf('height');
				$out['name']= $this->getConf('name');
				$out['code']= $this->getConf('code');
				$out['archive']= $this->getConf('archive');
				$out['target']= $this->getConf('target');
				$out['type']= $this->getConf('type');
				$found = preg_match_all('#([^\s=]+)\s*=\s*(\'[^<\']*\'|"[^<"]*"|[\d\w]+)#', $match, $matches, PREG_SET_ORDER);
				if ($found != 0) {
					foreach ($matches as $attribute) {
						if ($attribute[2][0]=='"') {
							$out[$attribute[1]] = substr($attribute[2],1,-1);
						}
						else { $out[$attribute[1]] = $attribute[2];
						}
					}
				}
				return array($state, $out);
			case DOKU_LEXER_UNMATCHED :
				return array ($state, $match);
			case DOKU_LEXER_EXIT :
				return array ($state, '');
		}
	}
	var $data;
	function render($mode, &$renderer, $data) {
		$renderer->info['cache'] = false;
		if($mode == 'xhtml'){
			list($state, $match) = $data;
			switch ($state) {
				case DOKU_LEXER_ENTER :
					$code=$match['code'];
					$renderer->doc .= '<applet name="'.$match['name'].'" code="'.$code.'" archive="'.$match['archive'].'" width="'.$match['width'].'" height="'.$match['height'].'">';
					if ($match['target']!='') {
						$renderer->doc .= '<param name="Target" value="'.$match['target'].'" />';
					}
					$renderer->doc .= '<param name="DataType" value="'.$match['type'].'" />';
					if ($match['url']!='') {
						$renderer->doc .= '<param name="DataSource" value="'.$match['url'].'" />';
					}
					$this->data='';
					break;
				case DOKU_LEXER_UNMATCHED :
					$this->data .= $match;
					break;
				case DOKU_LEXER_EXIT :
					if($this->data!=''){
						$renderer->doc .= '<param name="Data" value="'.$renderer->_xmlEntities($this->data).'" />';
					}
					$renderer->doc .= '</applet>';
					break;
			}
			return true;
		}
		return false;
	}
}
?>
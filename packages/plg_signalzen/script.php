<?php
/**
 * @package Signalzen
 * @author SignalZen
 * @copyright (C) 2021 - SignalZen
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/


defined('_JEXEC') or die;

/**
 * Signalzen script file.
 *
 * @package     A package name
 * @since       1.0
 */
class plgSystemSignalzenInstallerScript
{
	public function __construct($adapter) {}
	public function preflight($route, $adapter) {}
	public function postflight($route, $adapter) {}
	public function install($adapter) {
		$query = "update #__extensions set enabled=1 where type = 'plugin' and element = 'signalzen'";

		$db = JFactory::getDBO();
		$db->setQuery($query);
		$db->execute();
	}
	public function update($adapter) {}
	public function uninstall($adapter) {}
}

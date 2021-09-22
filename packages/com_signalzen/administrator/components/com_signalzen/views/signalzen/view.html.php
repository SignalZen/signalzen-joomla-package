<?php
/**
 * @package Signalzen
 * @author SignalZen
 * @copyright (C) 2021 - SignalZen
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

defined('_JEXEC') or die;

/**
 * Signalzen view.
 *
 * @package  [PACKAGE_NAME]
 * @since    1.0
 */
class SignalzenViewSignalzen extends JViewLegacy
{
	/**
	 * Displays a toolbar for a specific page.
	 *
	 * @return  void.
	 *
	 * @since   1.0
	 */
	private function toolbar()
	{
		JToolBarHelper::title("SignalZen", '');
	}
}

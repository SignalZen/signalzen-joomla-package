<?php
/**
 * @package Signalzen
 * @author SignalZen
 * @copyright (C) 2021 - SignalZen
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

defined('_JEXEC') or die;

// Execute the task
$controller = JControllerLegacy::getInstance('signalzen');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

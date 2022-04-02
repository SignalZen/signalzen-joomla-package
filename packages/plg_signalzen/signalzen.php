<?php
/**
 * @package Signalzen
 * @author SignalZen
 * @copyright (C) 2021 - SignalZen
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/

defined('_JEXEC') or die;

/**
 * Signalzen plugin.
 *
 * @package  [PACKAGE_NAME]
 * @since    1.0
 */
class plgSystemSignalzen extends JPlugin
{
  /**
   * Application object
   *
   * @var    JApplicationCms
   * @since  1.0
   */
  protected $app;

  /**
   * Database object
   *
   * @var    JDatabaseDriver
   * @since  1.0
   */
  protected $db;

  /**
   * Affects constructor behavior. If true, language files will be loaded automatically.
   *
   * @var    boolean
   * @since  1.0
   */
  protected $autoloadLanguage = true;

  public function onAfterInitialise()
  {
    $app = JFactory::getApplication();
    $doc = JFactory::getDocument();
    $user = JFactory::getUser();

    if ($app->isClient('administrator') || ($doc->getMimeEncoding() != 'text/html'))
      return;

    $params = JComponentHelper::getParams('com_signalzen');

    if (empty($params->get('signalzen_token'))) {
      return;
    }

    $token = $params->get('signalzen_token');

    $script = 'window.paceOptions = {
    ajax: {
      trackWebSockets: false,
      ignoreURLs: [/signalzen/]
    }
  };
  var _sz=_sz||{};_sz.appId="'.$token.'",function(){var e=document.createElement("script");e.src="https://cdn.signalzen.com/signalzen.js",e.setAttribute("async","true"),document.documentElement.firstChild.appendChild(e);var t=setInterval(function(){"undefined"!=typeof SignalZen&&(clearInterval(t),new SignalZen(_sz).load())},10)}();';
    $doc->addScriptDeclaration($script, $type = 'text/javascript');
  }

  /**
   * onAfterRoute.
   *
   * @return  void.
   *
   * @since   1.0
   */
  public function onAfterRoute()
  {

  }

  /**
   * onAfterDispatch.
   *
   * @return  void.
   *
   * @since   1.0
   */
  public function onAfterDispatch()
  {

  }

  /**
   * onAfterRender.
   *
   * @return  void.
   *
   * @since   1.0
   */
  public function onAfterRender()
  {

  }

  /**
   * onAfterCompileHead.
   *
   * @return  void.
   *
   * @since   1.0
   */
  public function onAfterCompileHead()
  {

  }

  /**
   * OnAfterCompress.
   *
   * @return  void.
   *
   * @since   1.0
   */
  public function onAfterCompress()
  {

  }

  /**
   * onAfterRespond.
   *
   * @return  void.
   *
   * @since   1.0
   */
  public function onAfterRespond()
  {

  }
}

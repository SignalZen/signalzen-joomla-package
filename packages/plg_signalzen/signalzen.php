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
  const COLORS = array(
  'primary' => '#046ee5',
  'secondary' => '#f5f7f8',
  'footer' => '#ffffff',
  'error' => '#cccccc',
  'popup' => '#ffffff',
  'popupClose' => '#ffffff',
  'popupCloseSymbol' => '#9c9c9c',
  'popupFormInputBorder' => '#9c9c9c',
  'badge' => '#c30606',
  'footerEmojisPopup' => '#ffffff',
  'footerOptions' => '#b2b3b4',
  'operatorMessages' => '#ebeff0',
  'formInput' => '#ffffff',
  'formInputBorder' => '#ffffff',
  'formButton' => '#0fc306',
  'formPlaceholder' => '#949595',
  'textPrimary' => '#ffffff',
  'textError' => '#ffffff',
  'textTime' => '#b5b7b8',
  'textTimeSeparator' => '#8e9192',
  'textUserMessage' => '#ffffff',
  'textFormInput' => '#000000',
  'textFormTitle' => '#8e9192',
  'textFormButton' => '#ffffff'
);

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

  /**
   * onAfterInitialise.
   *
   * @return  void.
   *
   * @since   1.0
   */
  public function colorValue($field) {
    $params = JComponentHelper::getParams('com_signalzen');

    $name = 'color_'. $field;
    $option = $params->get( $name );
    if (!is_string($option) && $option != '') {
      $option = plgSystemSignalzen::COLORS[$field];
    }
    return $option;
  }

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
    $layout = '';

    if (!empty($params->get('horizontal_offset')) || !empty($params->get('vertical_offset')) || !empty($params->get('vertical_position')) || !empty($params->get('horizontal_position'))) {
      $layout = 'layout: {';
      if (!empty($params->get('horizontal_offset'))) {
        $layout .= 'horizontalOffset: '. $params->get('horizontal_offset') .',';
      }
      if (!empty($params->get('vertical_offset'))) {
        $layout .= 'verticalOffset: '. $params->get('vertical_offset') .',';
      }
      if (!empty($params->get('horizontal_position'))) {
        $layout .= 'horizontalPosition: "'. $params->get('horizontal_position') .'",';
      }
      if (!empty($params->get('vertical_position'))) {
        $layout .= 'verticalPosition: "'. $params->get('vertical_position') .'",';
      }
      $layout .= '},';
    }

    $chat_icon = '';
    if ($params->get( 'chat_icon_enabled' ) == '1') {
      $chat_icon = 'chatIcon: {
        width: '.$params->get( 'chat_icon_width' ).',
        height: '.$params->get( 'chat_icon_height' ).',
        open: "/'.$params->get( 'chat_icon_open' ).'",
        closed: "/'.$params->get( 'chat_icon_closed' ).'",
        loading: "/'.$params->get( 'chat_icon_loading' ).'",
      },';
    }

    $script = 'window.paceOptions = {
    ajax: {
      trackWebSockets: false,
      ignoreURLs: [/signalzen/]
    }
  };

  var _sz = {
    '. $layout. '
    '. $chat_icon .'
    colors: {
      primary: "'. $this->colorValue('primary') .'",
      secondary: "'. $this->colorValue('secondary') .'",
      footer: "'. $this->colorValue('footer') .'",
      error: "'. $this->colorValue('error') .'",
      popup: "'. $this->colorValue('popup') .'",
      popupClose: "'. $this->colorValue('popupClose') .'",
      popupCloseSymbol: "'. $this->colorValue('popupCloseSymbol') .'",
      popupFormInputBorder: "'. $this->colorValue('popupFormInputBorder') .'",
      badge: "'. $this->colorValue('badge') .'",
      footerEmojisPopup: "'. $this->colorValue('footerEmojisPopup') .'",
      footerOptions: "'. $this->colorValue('footerOptions') .'",
      operatorMessages: "'. $this->colorValue('operatorMessages') .'",
      formInput: "'. $this->colorValue('formInput') .'",
      formInputBorder: "'. $this->colorValue('formInputBorder') .'",
      formButton: "'. $this->colorValue('formButton') .'",
      formPlaceholder: "'. $this->colorValue('formPlaceholder') .'",
      textPrimary: "'. $this->colorValue('textPrimary') .'",
      textError: "'. $this->colorValue('textError') .'",
      textTime: "'. $this->colorValue('textTime') .'",
      textTimeSeparator: "'. $this->colorValue('textTimeSeparator') .'",
      textUserMessage: "'. $this->colorValue('textUserMessage') .'",
      textFormInput: "'. $this->colorValue('textFormInput') .'",
      textFormTitle: "'. $this->colorValue('textFormTitle') .'",
      textFormButton: "'. $this->colorValue('textFormButton') .'",
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
